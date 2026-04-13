<?php
/**
 * 리앤양 수선 신청 전용 랜딩 페이지 v3
 * Apple Dark Design — #000 배경, 다크 글래스 nav, 다크 폼 카드
 */

define('_GNUBOARD_', true);
require_once dirname(__FILE__) . '/common.php';
require_once dirname(__FILE__) . '/skin/board/slack_notify.inc.php';

$done        = false;
$error       = '';
$error_field = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = trim(strip_tags($_POST['wr_name']    ?? ''));
    $phone   = trim(strip_tags($_POST['wr_phone']   ?? ''));
    $type    = trim(strip_tags($_POST['wr_1']       ?? ''));
    $brand   = trim(strip_tags($_POST['wr_3']       ?? ''));
    $content = trim(strip_tags($_POST['wr_content'] ?? ''));

    if (!$name)  { $error = '이름을 입력해 주세요.';      $error_field = 'wr_name'; }
    elseif (!$phone) { $error = '연락처를 입력해 주세요.'; $error_field = 'wr_phone'; }
    elseif (!$type)  { $error = '신청 유형을 선택해 주세요.'; $error_field = 'type'; }

    if (!$error) {
        $subject = "[{$type}] {$name} 님의 신청";
        $body    = "신청 유형: {$type}
브랜드: {$brand}
내용: {$content}";
        $now     = date('Y-m-d H:i:s');
        $ip      = $_SERVER['REMOTE_ADDR'];

        $res    = sql_query("SELECT MIN(wr_num) as mn FROM g5_write_free");
        $row    = sql_fetch_array($res);
        $wr_num = (int)($row['mn'] ?? 0) - 1;

        $subject_e = sql_real_escape_string($subject);
        $body_e    = sql_real_escape_string($body);
        $name_e    = sql_real_escape_string($name);
        $ip_e      = sql_real_escape_string($ip);
        $type_e    = sql_real_escape_string($type);
        $brand_e   = sql_real_escape_string($brand);
        $phone_e   = sql_real_escape_string($phone);

        sql_query("INSERT INTO g5_write_free
            (wr_num, wr_reply, wr_parent, wr_is_comment, wr_subject, wr_content,
             wr_name, wr_password, wr_email, wr_homepage, wr_datetime, wr_last, wr_ip,
             wr_1, wr_3)
            VALUES (
                {$wr_num}, '', 0, 0,
                '{$subject_e}', '{$body_e}',
                '{$name_e}', MD5('apply'), '', '{$phone_e}',
                '{$now}', '{$now}', '{$ip_e}',
                '{$type_e}', '{$brand_e}'
            )");

        $wr_id    = sql_insert_id();
        /* 그누보드 원글은 wr_parent = wr_id 여야 삭제/수정이 정상 동작함 */
        sql_query("UPDATE g5_write_free SET wr_parent = {$wr_id} WHERE wr_id = {$wr_id}");
        $file_cnt = 0;

        /* 사진 업로드 처리 (최대 3장) */
        $upload_dir = G5_DATA_PATH . '/file/free/';
        if (!is_dir($upload_dir)) @mkdir($upload_dir, 0775, true);

        for ($fi = 0; $fi < 3; $fi++) {
            $fkey = "photo_{$fi}";
            if (empty($_FILES[$fkey]['name'])) continue;
            $f = $_FILES[$fkey];
            if ($f['error'] !== UPLOAD_ERR_OK) continue;

            $ext = strtolower(pathinfo($f['name'], PATHINFO_EXTENSION));
            if (!in_array($ext, ['jpg','jpeg','png','gif','webp'])) continue;
            if ($f['size'] > 10 * 1024 * 1024) continue; /* 10MB 제한 */

            $uid      = uniqid(mt_rand(), true);
            $newname  = preg_replace('/[^a-z0-9_\-]/i', '', pathinfo($f['name'], PATHINFO_FILENAME));
            $newname  = substr($newname, 0, 20);
            $savename = "{$wr_id}_{$uid}_{$newname}.{$ext}";
            $savepath = $upload_dir . $savename;

            if (move_uploaded_file($f['tmp_name'], $savepath)) {
                @chmod($savepath, 0664);
                $orig_e  = sql_real_escape_string($f['name']);
                $save_e  = sql_real_escape_string($savename);
                $size    = (int)$f['size'];
                /* 실제 이미지 크기 읽기 — bf_width > 0 조건으로 AI/슬랙 이미지 인식에 필요 */
                $imginfo = @getimagesize($savepath);
                $bf_w    = $imginfo ? (int)$imginfo[0] : 1;
                $bf_h    = $imginfo ? (int)$imginfo[1] : 1;
                sql_query("INSERT INTO g5_board_file
                    (bo_table, wr_id, bf_no, bf_source, bf_file, bf_download, bf_content, bf_filesize, bf_width, bf_height, bf_type, bf_datetime)
                    VALUES ('free', {$wr_id}, {$fi}, '{$orig_e}', '{$save_e}', 0, '', {$size}, {$bf_w}, {$bf_h}, 0, '{$now}')");
                $file_cnt++;
            }
        }

        if ($file_cnt > 0) {
            sql_query("UPDATE g5_write_free SET wr_file={$file_cnt} WHERE wr_id={$wr_id}");
        }

        sql_query("UPDATE g5_board SET bo_count_write = bo_count_write + 1 WHERE bo_table = 'free'");

        /* 슬랙 알림 발송 */
        $post_url  = 'https://leeandyang.co.kr/bbs/board.php?bo_table=free&wr_id=' . $wr_id;
        $reply_url = 'https://leeandyang.co.kr/bbs/write.php?bo_table=free&w=r&wr_id=' . $wr_id;
        $slack_msg = "유형: {$type} | 연락처: {$phone}"
                   . ($brand   ? " | 브랜드: {$brand}" : '')
                   . ($content ? "\n{$content}" : '');
        $payload = slack_post_payload(
            '신청접수',
            $name,
            $subject,
            $slack_msg,
            $post_url,
            $reply_url
        );
        send_slack_notify($payload);

        $done = true;
    }
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>축구화·풋살화 창갈이(뽕갈이) 신청 | 스터드 교체 | 리앤양</title>
<meta name="description" content="축구화·풋살화 창갈이(뽕갈이), 밑창 교체, 스터드 교체 신청. 나이키·아디다스·미즈노 모든 브랜드 가능. 사진 업로드 후 2~4시간 내 견적 안내. 경기도 고양시 리앤양.">
<meta name="keywords" content="축구화창갈이, 풋살화창갈이, 뽕갈이, 밑창교체, 스터드교체, 스터드커팅, 축구화수선, 풋살화수선, 리앤양">
<meta property="og:title" content="축구화·풋살화 창갈이 신청 | 스터드 교체 | 리앤양">
<meta property="og:description" content="축구화·풋살화 창갈이(뽕갈이), 밑창 교체, 스터드 교체 신청. 나이키·아디다스·미즈노 모든 브랜드 가능. 경기도 고양시 리앤양.">
<meta property="og:url" content="https://leeandyang.co.kr/apply.php">
<link rel="canonical" href="https://leeandyang.co.kr/apply.php">
<!-- Google Ads 전환 추적 -->
<script async src="https://www.googletagmanager.com/gtag/js?id=AW-998917058"></script>
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());
gtag('config', 'AW-998917058');
</script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Pretendard:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
:root {
    --black:   #000000;
    --gray:    #f5f5f7;
    --white:   #ffffff;
    --label:   #1d1d1f;
    --label2:  #6e6e73;
    --blue:    #0071e3;
    --blue-dk: #2997ff;
    --sep:     rgba(255,255,255,0.12);
    --red:     #ff453a;
    --green:   #30d158;
    --radius-sm: 10px;
    --radius:    14px;
    --radius-lg: 18px;
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

html { color-scheme: dark; }

body {
    font-family: 'SF Pro Text', 'SF Pro Display', -apple-system, BlinkMacSystemFont, 'Pretendard', 'Apple SD Gothic Neo', sans-serif;
    background: #000;
    color: #fff;
    min-height: 100vh;
    -webkit-font-smoothing: antialiased;
}

/* ─── 네비게이션 ─── */
.nav {
    background: rgba(0,0,0,0.80);
    backdrop-filter: saturate(180%) blur(20px);
    -webkit-backdrop-filter: saturate(180%) blur(20px);
    border-bottom: 0.5px solid var(--sep);
    position: sticky; top: 0; z-index: 100;
    padding: 0 20px;
    height: 52px;
    display: flex; align-items: center; justify-content: space-between;
}
.nav-logo {
    font-size: 17px; font-weight: 700;
    letter-spacing: 1.5px; color: #fff;
    text-decoration: none;
}
.nav-links {
    display: flex; align-items: center; gap: 18px;
}
.nav-link {
    font-size: 13px; color: rgba(255,255,255,0.70);
    text-decoration: none; font-weight: 400;
    transition: color 0.15s;
    white-space: nowrap;
}
.nav-link:hover { color: #fff; }

/* ─── 히어로 ─── */
.hero {
    background: #000;
    padding: 44px 24px 38px;
    text-align: center;
    border-bottom: 0.5px solid var(--sep);
}
.hero-eyebrow {
    font-size: 12px; font-weight: 600;
    letter-spacing: 1.2px; color: var(--blue-dk);
    text-transform: uppercase; margin-bottom: 10px;
}
.hero-title {
    font-size: 28px; font-weight: 700;
    line-height: 1.25; letter-spacing: -0.5px;
    color: #fff; margin-bottom: 10px;
}
.hero-title span { color: rgba(255,255,255,0.45); }
.hero-desc {
    font-size: 14px; color: rgba(255,255,255,0.50);
    line-height: 1.6;
}

/* ─── 진행 단계바 ─── */
.steps-bar {
    background: #111;
    border-bottom: 0.5px solid var(--sep);
    display: flex; justify-content: center;
    padding: 14px 20px; gap: 0;
}
.step {
    display: flex; align-items: center;
    font-size: 12px; font-weight: 500;
    color: rgba(255,255,255,0.30);
}
.step.active { color: var(--blue-dk); }
.step.done   { color: var(--green); }
.step-dot {
    width: 20px; height: 20px; border-radius: 50%;
    background: rgba(255,255,255,0.10);
    color: rgba(255,255,255,0.40);
    font-size: 11px; font-weight: 700;
    display: flex; align-items: center; justify-content: center;
    margin-right: 5px; flex-shrink: 0;
}
.step.active .step-dot { background: var(--blue-dk); color: #fff; }
.step.done   .step-dot { background: var(--green); color: #000; }
.step-sep { color: rgba(255,255,255,0.20); margin: 0 8px; font-size: 10px; }

/* ─── 메인 래퍼 ─── */
.wrap {
    max-width: 520px; margin: 0 auto;
    padding: 28px 16px 60px;
}

/* ─── 섹션 카드 ─── */
.section {
    background: #111;
    border: 0.5px solid rgba(255,255,255,0.10);
    border-radius: var(--radius-lg);
    padding: 24px;
    margin-bottom: 16px;
}
.section-label {
    font-size: 11px; font-weight: 600;
    letter-spacing: 0.5px;
    color: rgba(255,255,255,0.50);
    text-transform: uppercase; margin-bottom: 14px;
}

/* ─── 유형 선택 ─── */
.type-grid {
    display: grid; grid-template-columns: 1fr 1fr;
    gap: 10px;
}
.type-item { position: relative; }
.type-item input[type="radio"] {
    position: absolute; opacity: 0; width: 0; height: 0;
}
.type-card {
    display: block;
    border: 0.5px solid rgba(255,255,255,0.15);
    border-radius: var(--radius);
    padding: 18px 12px 16px;
    text-align: center; cursor: pointer;
    transition: all 0.2s cubic-bezier(0.34,1.56,0.64,1);
    background: #1c1c1e;
    user-select: none;
}
.type-card:active { transform: scale(0.96); }
.type-item input:checked + .type-card {
    border-color: var(--blue-dk);
    background: rgba(41,151,255,0.10);
    box-shadow: 0 0 0 2px rgba(41,151,255,0.25);
}
/* 번호 배지 (이모지 대신) */
.type-num {
    display: inline-flex;
    align-items: center; justify-content: center;
    width: 28px; height: 28px;
    border-radius: 8px;
    background: rgba(255,255,255,0.08);
    font-size: 11px; font-weight: 700;
    color: rgba(255,255,255,0.45);
    letter-spacing: 0;
    margin-bottom: 9px;
    transition: background 0.2s, color 0.2s;
}
.type-item input:checked + .type-card .type-num {
    background: var(--blue-dk);
    color: #fff;
}
.type-name {
    font-size: 14px; font-weight: 600;
    color: rgba(255,255,255,0.85);
    display: block; margin-bottom: 3px;
}
.type-item input:checked + .type-card .type-name { color: var(--blue-dk); }
.type-hint { font-size: 11px; color: rgba(255,255,255,0.35); display: block; }

/* ─── 폼 필드 ─── */
.field { margin-bottom: 14px; }
.field:last-child { margin-bottom: 0; }
.field-label {
    font-size: 12px; font-weight: 500;
    color: rgba(255,255,255,0.50);
    margin-bottom: 7px;
    display: flex; align-items: center; gap: 4px;
}
.req { color: var(--red); font-size: 14px; line-height: 1; }
.opt { color: rgba(255,255,255,0.30); font-weight: 400; font-size: 11px; }

.field input,
.field select,
.field textarea {
    width: 100%; padding: 13px 15px;
    background: #1c1c1e;
    border: 0.5px solid rgba(255,255,255,0.15);
    border-radius: var(--radius-sm);
    font-size: 16px; font-family: inherit;
    color: #fff;
    outline: none;
    transition: border-color 0.15s, box-shadow 0.15s;
    -webkit-appearance: none;
    appearance: none;
}
.field input::placeholder, .field textarea::placeholder {
    color: rgba(255,255,255,0.25);
}
.field input:focus,
.field select:focus,
.field textarea:focus {
    border-color: var(--blue);
    box-shadow: 0 0 0 3px rgba(0,113,227,0.20);
}
/* select 다크 화살표 */
.field select {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M5 6L0 0h10z' fill='%23ffffff'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 15px center;
    padding-right: 38px;
    color: #fff;
}
/* select option 다크 */
.field select option {
    background: #1c1c1e;
    color: #fff;
}
.field textarea { height: 96px; resize: none; line-height: 1.55; }

/* ─── 사진 업로드 ─── */
.photo-grid {
    display: grid; grid-template-columns: repeat(3, 1fr);
    gap: 10px; margin-top: 12px;
}
.photo-slot {
    aspect-ratio: 1;
    border: 1px dashed rgba(255,255,255,0.18);
    border-radius: var(--radius);
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    cursor: pointer; position: relative;
    overflow: hidden;
    transition: border-color 0.15s, background 0.15s;
    background: #1c1c1e;
}
.photo-slot:hover { border-color: var(--blue-dk); background: rgba(41,151,255,0.05); }
.photo-slot input[type="file"] {
    position: absolute; inset: 0; opacity: 0; cursor: pointer; z-index: 2;
}
/* SVG 플러스 아이콘 */
.photo-slot-svg {
    margin-bottom: 5px;
    opacity: 0.35;
    transition: opacity 0.15s;
}
.photo-slot:hover .photo-slot-svg { opacity: 0.60; }
.photo-slot-text { font-size: 11px; color: rgba(255,255,255,0.35); font-weight: 500; }
.photo-slot.has-file { border-style: solid; border-color: var(--blue-dk); }
.photo-slot.has-file .photo-slot-svg { opacity: 0.80; }
.photo-slot.has-file .photo-slot-text { color: var(--blue-dk); }
.photo-slot img.preview {
    position: absolute; inset: 0; width: 100%; height: 100%;
    object-fit: cover; z-index: 1;
}

/* ─── 제출 버튼 ─── */
.submit-wrap { padding-top: 4px; }
.btn-submit {
    width: 100%; height: 52px;
    background: var(--blue); color: #fff;
    border: none; border-radius: var(--radius-sm);
    font-size: 17px; font-weight: 600;
    font-family: inherit; cursor: pointer;
    letter-spacing: -0.3px;
    transition: background 0.15s, transform 0.1s;
}
.btn-submit:hover { background: #0077ed; }
.btn-submit:active { transform: scale(0.98); }

/* ─── 안내 텍스트 ─── */
.info-list {
    display: flex; flex-direction: column; gap: 12px;
}
.info-row {
    display: flex; align-items: flex-start; gap: 10px;
    font-size: 13px; color: rgba(255,255,255,0.55); line-height: 1.55;
}
.info-dash {
    flex-shrink: 0;
    color: rgba(255,255,255,0.25);
    font-size: 14px;
    margin-top: 0px;
}

/* ─── 입력 에러 강조 ─── */
.field input.field-error,
.field select.field-error,
.field textarea.field-error {
    border-color: var(--red);
    background: rgba(255,69,58,0.07);
    box-shadow: 0 0 0 3px rgba(255,69,58,0.15);
}
.section.type-error {
    box-shadow: 0 0 0 2px var(--red);
}

/* ─── 에러 알림 ─── */
.alert-error {
    background: rgba(255,69,58,0.10);
    border: 0.5px solid rgba(255,69,58,0.30);
    border-radius: var(--radius-sm);
    padding: 13px 16px;
    font-size: 14px; color: var(--red);
    margin-bottom: 16px;
    display: flex; align-items: center; gap: 8px;
}

/* ─── 완료 화면 ─── */
.done-section {
    background: #111;
    border: 0.5px solid rgba(255,255,255,0.10);
    border-radius: var(--radius-lg);
    padding: 44px 24px;
    text-align: center;
}
.done-checkmark {
    width: 72px; height: 72px; border-radius: 50%;
    background: rgba(48,209,88,0.12);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 22px;
}
.done-title {
    font-size: 22px; font-weight: 700;
    letter-spacing: -0.3px; margin-bottom: 10px; color: #fff;
}
.done-desc {
    font-size: 14px; color: rgba(255,255,255,0.50);
    line-height: 1.75; margin-bottom: 30px;
}
.done-desc strong { color: rgba(255,255,255,0.80); }
.btn-kakao {
    display: flex; align-items: center; justify-content: center;
    gap: 8px; width: 100%; height: 52px;
    background: #FEE500; color: #3A1D1D;
    border: none; border-radius: var(--radius-sm);
    font-size: 16px; font-weight: 700; font-family: inherit;
    cursor: pointer; text-decoration: none;
    margin-bottom: 12px;
    transition: background 0.15s;
}
.btn-kakao:hover { background: #F5DC00; }
.btn-home {
    display: block; color: rgba(255,255,255,0.35); font-size: 13px;
    text-decoration: none; padding: 10px;
}
.btn-home:hover { color: rgba(255,255,255,0.60); }
#copy-feedback {
    display: none;
    text-align: center;
    color: var(--green);
    font-size: 13px;
    font-weight: 600;
    margin-top: 10px;
    animation: fadeIn 0.2s ease;
}
@keyframes fadeIn { from { opacity: 0; transform: translateY(-4px); } to { opacity: 1; transform: translateY(0); } }

/* ─── 반응형 ─── */
@media (min-width: 480px) {
    .hero-title { font-size: 34px; }
}
</style>
</head>
<body>

<!-- 네비게이션 -->
<nav class="nav">
    <a href="/" class="nav-logo">LEE&amp;YANG</a>
    <div class="nav-links">
        <a href="/changalyi.php" class="nav-link">창갈이 수선 ›</a>
        <a href="/custom.php" class="nav-link">맞춤축구화 ›</a>
    </div>
</nav>

<!-- 히어로 -->
<div class="hero">
    <p class="hero-eyebrow">리앤양 수선 신청</p>
    <h1 class="hero-title">축구화·풋살화 창갈이,<br><span>지금 바로 신청하세요</span></h1>
    <p class="hero-desc">밑창 교체 · 스터드 교체 · 수선 · 맞춤제작 — 접수 후 2~4시간 내 견적 안내</p>
</div>

<!-- 진행 단계바 -->
<div class="steps-bar">
    <div class="step active"><span class="step-dot">1</span>신청</div>
    <span class="step-sep">›</span>
    <div class="step"><span class="step-dot">2</span>견적</div>
    <span class="step-sep">›</span>
    <div class="step"><span class="step-dot">3</span>수선</div>
    <span class="step-sep">›</span>
    <div class="step"><span class="step-dot">4</span>완료</div>
</div>

<div class="wrap">

<?php if ($done): ?>
<!-- Google Ads 신청 완료 전환 이벤트 -->
<script>
gtag('event', 'conversion', {'send_to': 'AW-998917058/Gm0RCLPghJMcEMKHqdwD'});
</script>

<!-- 완료 화면 -->
<div class="done-section">
    <!-- SVG 체크 아이콘 -->
    <div class="done-checkmark">
        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M7 16.5L13 22.5L25 10" stroke="#30d158" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </div>
    <div class="done-title">신청 완료</div>
    <div class="done-desc">
        빠른 시간 내에 확인 후<br>
        카카오톡 또는 문자로 연락드립니다.<br><br>
        <strong>평균 응답 2~4시간</strong> (AM 10 ~ PM 7)
    </div>
    <button type="button" class="btn-kakao" id="btn-copy-kakao" onclick="copyKakaoId()">
        카카오톡 ID 복사: 21apro
    </button>
    <div id="copy-feedback">복사됐습니다. 카카오톡에서 21apro 검색해주세요!</div>
    <a href="/" class="btn-home">홈으로 돌아가기</a>
</div>

<?php else: ?>
<!-- 신청 폼 -->
<form method="POST" action="/apply.php" enctype="multipart/form-data">

    <?php if ($error): ?>
    <div class="alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <!-- 신청 유형 -->
    <div class="section">
        <div class="section-label">신청 유형</div>
        <div class="type-grid">
            <?php
            $types = [
                ['val'=>'창갈이',   'num'=>'01', 'hint'=>'밑창 교체'],
                ['val'=>'맞춤제작', 'num'=>'02', 'hint'=>'나만의 축구화'],
                ['val'=>'수선',     'num'=>'03', 'hint'=>'찢김·접착'],
                ['val'=>'문의',     'num'=>'04', 'hint'=>'기타 상담'],
            ];
            foreach ($types as $t):
                $checked = ($_POST['wr_1']??'')===$t['val'] ? 'checked' : '';
            ?>
            <div class="type-item">
                <input type="radio" name="wr_1" id="type_<?=$t['val']?>" value="<?=$t['val']?>" <?=$checked?>>
                <label for="type_<?=$t['val']?>" class="type-card">
                    <span class="type-num"><?=$t['num']?></span>
                    <span class="type-name"><?=$t['val']?></span>
                    <span class="type-hint"><?=$t['hint']?></span>
                </label>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- 기본 정보 -->
    <div class="section">
        <div class="section-label">기본 정보</div>

        <div class="field">
            <div class="field-label">이름 <span class="req">*</span></div>
            <input type="text" name="wr_name"
                   value="<?=htmlspecialchars($_POST['wr_name']??'')?>"
                   placeholder="홍길동" maxlength="20" autocomplete="name">
        </div>

        <div class="field">
            <div class="field-label">연락처 <span class="req">*</span></div>
            <input type="tel" name="wr_phone"
                   value="<?=htmlspecialchars($_POST['wr_phone']??'')?>"
                   placeholder="010-0000-0000" maxlength="20" autocomplete="tel">
        </div>

        <div class="field">
            <div class="field-label">신발 브랜드 <span class="opt">(선택)</span></div>
            <select name="wr_3">
                <option value="">선택 안함</option>
                <?php
                $brands = ['나이키','아디다스','미즈노','푸마','아식스','뉴발란스','기타'];
                foreach ($brands as $b):
                    $sel = ($_POST['wr_3']??'')===$b ? 'selected' : '';
                ?>
                <option value="<?=$b?>" <?=$sel?>><?=$b?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="field">
            <div class="field-label">내용 <span class="opt">(선택)</span></div>
            <textarea name="wr_content"
                      placeholder="수선이 필요한 부위나 상태를 간단히 알려주세요."><?=htmlspecialchars($_POST['wr_content']??'')?></textarea>
        </div>
    </div>

    <!-- 사진 첨부 -->
    <div class="section">
        <div class="section-label">신발 사진 <span class="opt" style="text-transform:none">최대 3장 · 10MB 이하</span></div>
        <div class="photo-grid">
            <?php for ($fi = 0; $fi < 3; $fi++): ?>
            <div class="photo-slot" id="slot_<?=$fi?>">
                <input type="file" name="photo_<?=$fi?>" accept="image/*"
                       onchange="previewPhoto(this,<?=$fi?>)">
                <!-- SVG 플러스 아이콘 -->
                <svg class="photo-slot-svg" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 5V19M5 12H19" stroke="white" stroke-width="1.8" stroke-linecap="round"/>
                </svg>
                <span class="photo-slot-text">사진 추가</span>
            </div>
            <?php endfor; ?>
        </div>
    </div>

    <!-- 제출 -->
    <div class="section submit-wrap">
        <button type="submit" class="btn-submit" id="btn-submit">신청하기</button>
    </div>

</form>

<!-- 안내 -->
<div class="section">
    <div class="section-label">진행 안내</div>
    <div class="info-list">
        <div class="info-row"><span class="info-dash">—</span><span>신청 접수 후 카카오톡 또는 문자로 견적 안내드립니다.</span></div>
        <div class="info-row"><span class="info-dash">—</span><span>전국 택배 수선 가능 · 수선 완료 후 문 앞 배송</span></div>
        <div class="info-row"><span class="info-dash">—</span><span>카카오톡 <strong style="color:rgba(255,255,255,0.80)">21apro</strong> 24시간 상담 가능</span></div>
        <div class="info-row"><span class="info-dash">—</span><span>운영시간 AM 10:00 ~ PM 7:00</span></div>
    </div>
</div>

<?php endif; ?>
</div>

<script>
/* DataURL을 File 객체로 변환 */
function dataURLtoFile(dataurl, filename) {
    var arr = dataurl.split(','), mime = arr[0].match(/:(.*?);/)[1];
    var bstr = atob(arr[1]), n = bstr.length, u8arr = new Uint8Array(n);
    while (n--) u8arr[n] = bstr.charCodeAt(n);
    return new File([u8arr], filename, {type: mime});
}

/* 사진 선택 → Canvas로 리사이즈(최대 1600px) 후 미리보기 + 압축본 교체 */
function previewPhoto(input, idx) {
    var slot = document.getElementById('slot_' + idx);
    var existing = slot.querySelector('img.preview');
    if (existing) existing.remove();

    if (!input.files || !input.files[0]) {
        slot.classList.remove('has-file');
        return;
    }

    var file = input.files[0];
    var reader = new FileReader();
    reader.onload = function(e) {
        var original = new Image();
        original.onload = function() {
            /* 최대 1600px로 축소 */
            var MAX = 1600;
            var w = original.width, h = original.height;
            if (w > MAX || h > MAX) {
                if (w > h) { h = Math.round(h * MAX / w); w = MAX; }
                else       { w = Math.round(w * MAX / h); h = MAX; }
            }
            var canvas = document.createElement('canvas');
            canvas.width = w; canvas.height = h;
            canvas.getContext('2d').drawImage(original, 0, 0, w, h);
            var compressed = canvas.toDataURL('image/jpeg', 0.85);

            /* 압축본으로 input 교체 (DataTransfer 지원 브라우저) */
            try {
                var dt = new DataTransfer();
                dt.items.add(dataURLtoFile(compressed, file.name.replace(/\.[^.]+$/, '.jpg')));
                input.files = dt.files;
            } catch(err) { /* 구형 브라우저: 원본 그대로 */ }

            /* 미리보기 */
            var img = document.createElement('img');
            img.className = 'preview';
            img.src = compressed;
            slot.appendChild(img);
            slot.classList.add('has-file');
        };
        original.src = e.target.result;
    };
    reader.readAsDataURL(file);
}

/* 에러 발생 시 해당 필드 강조 + 스크롤 */
<?php if ($error && $error_field): ?>
document.addEventListener('DOMContentLoaded', function() {
    <?php if ($error_field === 'type'): ?>
    var section = document.querySelector('.type-grid').closest('.section');
    if (section) {
        section.classList.add('type-error');
        section.scrollIntoView({behavior: 'smooth', block: 'center'});
    }
    <?php else: ?>
    var el = document.querySelector('[name="<?= htmlspecialchars($error_field) ?>"]');
    if (el) {
        el.classList.add('field-error');
        el.focus();
        el.scrollIntoView({behavior: 'smooth', block: 'center'});
    }
    <?php endif; ?>
});
<?php endif; ?>

/* 카카오톡 ID 복사 */
function copyKakaoId() {
    var id = '21apro';
    var btn = document.getElementById('btn-copy-kakao');
    var fb  = document.getElementById('copy-feedback');

    function onSuccess() {
        btn.textContent = '복사 완료!';
        fb.style.display = 'block';
        setTimeout(function() {
            btn.textContent = '카카오톡 ID 복사: 21apro';
            fb.style.display = 'none';
        }, 2500);
    }

    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(id).then(onSuccess).catch(function() { fallbackCopy(id, onSuccess); });
    } else {
        fallbackCopy(id, onSuccess);
    }
}
function fallbackCopy(text, cb) {
    var el = document.createElement('textarea');
    el.value = text;
    el.style.cssText = 'position:fixed;top:-9999px;opacity:0';
    document.body.appendChild(el);
    el.focus(); el.select();
    try { document.execCommand('copy'); cb(); } catch(e) {}
    document.body.removeChild(el);
}

/* 폼 제출 시 버튼 로딩 상태 — $done=false일 때만 form 존재하므로 null 체크 */
var form = document.querySelector('form');
if (form) {
    form.addEventListener('submit', function() {
        var btn = document.getElementById('btn-submit');
        if (btn) {
            btn.textContent = '전송 중...';
            btn.disabled = true;
            btn.style.opacity = '0.7';
        }
    });
}

/* 유형 선택 시 시각 피드백 */
document.querySelectorAll('.type-item input').forEach(function(radio) {
    radio.addEventListener('change', function() {
        document.querySelectorAll('.type-card').forEach(function(c) {
            c.style.transform = '';
        });
        if (this.checked) {
            this.nextElementSibling.style.transform = 'scale(1.02)';
            setTimeout(function() {
                document.querySelectorAll('.type-card').forEach(function(c) {
                    c.style.transform = '';
                });
            }, 200);
        }
    });
});
</script>

</body>
</html>
