<?php
/**
 * 리앤양 수선 신청 전용 랜딩 페이지 v2
 * Apple HIG 스타일 · 사진 업로드 지원
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
        // 그누보드 원글은 wr_parent = wr_id 여야 삭제/수정이 정상 동작함
        sql_query("UPDATE g5_write_free SET wr_parent = {$wr_id} WHERE wr_id = {$wr_id}");
        $file_cnt = 0;

        // 사진 업로드 처리 (최대 3장)
        $upload_dir = G5_DATA_PATH . '/file/free/';
        if (!is_dir($upload_dir)) @mkdir($upload_dir, 0775, true);

        for ($fi = 0; $fi < 3; $fi++) {
            $fkey = "photo_{$fi}";
            if (empty($_FILES[$fkey]['name'])) continue;
            $f = $_FILES[$fkey];
            if ($f['error'] !== UPLOAD_ERR_OK) continue;

            $ext = strtolower(pathinfo($f['name'], PATHINFO_EXTENSION));
            if (!in_array($ext, ['jpg','jpeg','png','gif','webp'])) continue;
            if ($f['size'] > 10 * 1024 * 1024) continue; // 10MB 제한

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
                // 실제 이미지 크기 읽기 — bf_width > 0 조건으로 AI/슬랙 이미지 인식에 필요
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

        // 슬랙 알림 발송
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
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
:root {
    --bg:        #F5F5F7;
    --surface:   #FFFFFF;
    --surface2:  #F5F5F7;
    --label:     #1D1D1F;
    --label2:    #3A3A3C;
    --label3:    #6E6E73;
    --label4:    #AEAEB2;
    --separator: #D1D1D6;
    --blue:      #0071E3;
    --blue-dark: #0077ED;
    --green:     #34C759;
    --red:       #FF3B30;
    --radius-sm: 10px;
    --radius:    14px;
    --radius-lg: 20px;
    --shadow:    0 2px 20px rgba(0,0,0,0.06), 0 1px 4px rgba(0,0,0,0.04);
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

body {
    font-family: -apple-system, BlinkMacSystemFont, 'Noto Sans KR', 'Apple SD Gothic Neo', sans-serif;
    background: var(--bg);
    color: var(--label);
    min-height: 100vh;
    -webkit-font-smoothing: antialiased;
}

/* ─── 헤더 ─── */
.header {
    background: rgba(255,255,255,0.85);
    backdrop-filter: saturate(180%) blur(20px);
    -webkit-backdrop-filter: saturate(180%) blur(20px);
    border-bottom: 0.5px solid var(--separator);
    position: sticky; top: 0; z-index: 100;
    padding: 0 20px;
    height: 52px;
    display: flex; align-items: center; justify-content: space-between;
}
.header-logo {
    font-size: 17px; font-weight: 700;
    letter-spacing: 1.5px; color: var(--label);
    text-decoration: none;
}
.header-sub {
    font-size: 12px; color: var(--label3); font-weight: 400;
}

/* ─── 히어로 ─── */
.hero {
    background: var(--label);
    color: #fff;
    padding: 40px 24px 36px;
    text-align: center;
}
.hero-eyebrow {
    font-size: 12px; font-weight: 600;
    letter-spacing: 1px; color: #86868B;
    text-transform: uppercase; margin-bottom: 10px;
}
.hero-title {
    font-size: 28px; font-weight: 700;
    line-height: 1.25; letter-spacing: -0.5px;
    margin-bottom: 10px;
}
.hero-title span { color: #86868B; }
.hero-desc {
    font-size: 14px; color: #86868B;
    line-height: 1.6;
}

/* ─── 진행 단계 ─── */
.steps-bar {
    background: #fff;
    border-bottom: 0.5px solid var(--separator);
    display: flex; justify-content: center;
    padding: 14px 20px; gap: 0;
}
.step {
    display: flex; align-items: center;
    font-size: 12px; font-weight: 500; color: var(--label4);
}
.step.active { color: var(--blue); }
.step.done   { color: var(--green); }
.step-dot {
    width: 20px; height: 20px; border-radius: 50%;
    background: var(--separator); color: var(--label4);
    font-size: 11px; font-weight: 700;
    display: flex; align-items: center; justify-content: center;
    margin-right: 5px; flex-shrink: 0;
}
.step.active .step-dot { background: var(--blue); color: #fff; }
.step.done   .step-dot { background: var(--green); color: #fff; }
.step-sep { color: var(--separator); margin: 0 8px; font-size: 10px; }

/* ─── 메인 래퍼 ─── */
.wrap {
    max-width: 520px; margin: 0 auto;
    padding: 28px 16px 60px;
}

/* ─── 섹션 카드 ─── */
.section {
    background: var(--surface);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow);
    padding: 24px;
    margin-bottom: 16px;
}
.section-label {
    font-size: 11px; font-weight: 600;
    letter-spacing: 0.5px; color: var(--label3);
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
    display: block; border: 1.5px solid var(--separator);
    border-radius: var(--radius); padding: 16px 12px 14px;
    text-align: center; cursor: pointer;
    transition: all 0.2s cubic-bezier(0.34,1.56,0.64,1);
    background: var(--surface);
    user-select: none;
}
.type-card:active { transform: scale(0.96); }
.type-item input:checked + .type-card {
    border-color: var(--blue);
    background: rgba(0,113,227,0.05);
    box-shadow: 0 0 0 3px rgba(0,113,227,0.12);
}
.type-icon {
    font-size: 28px; display: block; margin-bottom: 7px;
    transition: transform 0.2s;
}
.type-item input:checked + .type-card .type-icon {
    transform: scale(1.1);
}
.type-name {
    font-size: 14px; font-weight: 600; color: var(--label);
    display: block; margin-bottom: 3px;
}
.type-item input:checked + .type-card .type-name { color: var(--blue); }
.type-hint { font-size: 11px; color: var(--label3); display: block; }

/* ─── 폼 필드 ─── */
.field { margin-bottom: 14px; }
.field:last-child { margin-bottom: 0; }
.field-label {
    font-size: 12px; font-weight: 600;
    color: var(--label2); margin-bottom: 7px;
    display: flex; align-items: center; gap: 4px;
}
.req { color: var(--red); font-size: 14px; line-height: 1; }
.opt { color: var(--label4); font-weight: 400; font-size: 11px; }

.field input, .field select, .field textarea {
    width: 100%; padding: 13px 15px;
    background: var(--surface2);
    border: 1.5px solid transparent;
    border-radius: var(--radius-sm);
    font-size: 16px; font-family: inherit;
    color: var(--label);
    outline: none;
    transition: border-color 0.15s, background 0.15s;
    -webkit-appearance: none;
    appearance: none;
}
.field input::placeholder, .field textarea::placeholder {
    color: var(--label4);
}
.field input:focus, .field select:focus, .field textarea:focus {
    background: var(--surface);
    border-color: var(--blue);
    box-shadow: 0 0 0 3px rgba(0,113,227,0.12);
}
.field select {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M5 6L0 0h10z' fill='%23AEAEB2'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 15px center;
    padding-right: 38px;
}
.field textarea { height: 96px; resize: none; line-height: 1.55; }

/* ─── 사진 업로드 ─── */
.photo-grid {
    display: grid; grid-template-columns: repeat(3, 1fr);
    gap: 10px; margin-top: 12px;
}
.photo-slot {
    aspect-ratio: 1;
    border: 1.5px dashed var(--separator);
    border-radius: var(--radius);
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    cursor: pointer; position: relative;
    overflow: hidden;
    transition: border-color 0.15s, background 0.15s;
    background: var(--surface2);
}
.photo-slot:hover { border-color: var(--blue); background: rgba(0,113,227,0.03); }
.photo-slot input[type="file"] {
    position: absolute; inset: 0; opacity: 0; cursor: pointer; z-index: 2;
}
.photo-slot-icon { font-size: 22px; color: var(--label4); margin-bottom: 4px; }
.photo-slot-text { font-size: 11px; color: var(--label4); font-weight: 500; }
.photo-slot.has-file { border-style: solid; border-color: var(--blue); }
.photo-slot.has-file .photo-slot-icon,
.photo-slot.has-file .photo-slot-text { color: var(--blue); }
.photo-slot img.preview {
    position: absolute; inset: 0; width: 100%; height: 100%;
    object-fit: cover; z-index: 1;
}

/* ─── 제출 버튼 ─── */
.submit-wrap { padding-top: 4px; }
.btn-submit {
    width: 100%; height: 54px;
    background: var(--blue); color: #fff;
    border: none; border-radius: var(--radius);
    font-size: 17px; font-weight: 600;
    font-family: inherit; cursor: pointer;
    letter-spacing: -0.3px;
    transition: background 0.15s, transform 0.1s;
}
.btn-submit:hover { background: var(--blue-dark); }
.btn-submit:active { transform: scale(0.98); }

/* ─── 안내 텍스트 ─── */
.info-list {
    display: flex; flex-direction: column; gap: 12px;
}
.info-row {
    display: flex; align-items: flex-start; gap: 10px;
    font-size: 13px; color: var(--label2); line-height: 1.5;
}
.info-row-icon { font-size: 16px; flex-shrink: 0; margin-top: 1px; }

/* ─── 입력 에러 강조 ─── */
.field input.field-error,
.field select.field-error,
.field textarea.field-error {
    border-color: var(--red);
    background: rgba(255,59,48,0.04);
    box-shadow: 0 0 0 3px rgba(255,59,48,0.12);
}
.section.type-error {
    box-shadow: var(--shadow), 0 0 0 2px var(--red);
}

/* ─── 에러 ─── */
.alert-error {
    background: rgba(255,59,48,0.08);
    border: 1px solid rgba(255,59,48,0.2);
    border-radius: var(--radius-sm);
    padding: 13px 16px;
    font-size: 14px; color: var(--red);
    margin-bottom: 16px;
    display: flex; align-items: center; gap: 8px;
}

/* ─── 완료 화면 ─── */
.done-section {
    background: var(--surface);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow);
    padding: 40px 24px;
    text-align: center;
}
.done-checkmark {
    width: 72px; height: 72px; border-radius: 50%;
    background: rgba(52,199,89,0.12);
    display: flex; align-items: center; justify-content: center;
    font-size: 34px; margin: 0 auto 20px;
}
.done-title {
    font-size: 22px; font-weight: 700;
    letter-spacing: -0.3px; margin-bottom: 10px;
}
.done-desc {
    font-size: 14px; color: var(--label3);
    line-height: 1.7; margin-bottom: 28px;
}
.btn-kakao {
    display: flex; align-items: center; justify-content: center;
    gap: 8px; width: 100%; height: 52px;
    background: #FEE500; color: #3A1D1D;
    border: none; border-radius: var(--radius);
    font-size: 16px; font-weight: 700; font-family: inherit;
    cursor: pointer; text-decoration: none;
    margin-bottom: 12px;
    transition: background 0.15s;
}
.btn-kakao:hover { background: #F5DC00; }
.btn-home {
    display: block; color: var(--label3); font-size: 13px;
    text-decoration: none; padding: 10px;
}
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
    .type-icon  { font-size: 32px; }
}
</style>
</head>
<body>

<header class="header">
    <a href="/" class="header-logo">LEE&amp;YANG</a>
    <span class="header-sub">맞춤축구화 · 신발수선</span>
</header>

<div class="hero">
    <p class="hero-eyebrow">리앤양 수선 신청</p>
    <h1 class="hero-title">축구화·풋살화 창갈이,<br><span>지금 바로 신청하세요</span></h1>
    <p class="hero-desc">밑창 교체 · 스터드 교체 · 수선 · 맞춤제작 — 접수 후 2~4시간 내 견적 안내</p>
</div>

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
<!-- 완료 -->
<div class="done-section">
    <div class="done-checkmark">✓</div>
    <div class="done-title">신청 완료!</div>
    <div class="done-desc">
        빠른 시간 내에 확인 후<br>
        카카오톡 또는 문자로 연락드립니다.<br><br>
        <strong>평균 응답 2~4시간</strong> (AM 10 ~ PM 7)
    </div>
    <button type="button" class="btn-kakao" id="btn-copy-kakao" onclick="copyKakaoId()">
        💬 카카오톡 ID 복사: 21apro
    </button>
    <div id="copy-feedback">✓ 복사됐습니다. 카카오톡에서 21apro 검색해주세요!</div>
    <a href="/" class="btn-home">홈으로 돌아가기</a>
</div>

<?php else: ?>
<!-- 신청 폼 -->
<form method="POST" action="/apply.php" enctype="multipart/form-data">

    <?php if ($error): ?>
    <div class="alert-error">⚠ <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <!-- 신청 유형 -->
    <div class="section">
        <div class="section-label">신청 유형</div>
        <div class="type-grid">
            <?php
            $types = [
                ['val'=>'창갈이',   'icon'=>'👟', 'hint'=>'밑창 교체'],
                ['val'=>'맞춤제작', 'icon'=>'✂️', 'hint'=>'나만의 축구화'],
                ['val'=>'수선',     'icon'=>'🔧', 'hint'=>'찢김·접착'],
                ['val'=>'문의',     'icon'=>'💬', 'hint'=>'기타 상담'],
            ];
            foreach ($types as $t):
                $checked = ($_POST['wr_1']??'')===$t['val'] ? 'checked' : '';
            ?>
            <div class="type-item">
                <input type="radio" name="wr_1" id="type_<?=$t['val']?>" value="<?=$t['val']?>" <?=$checked?>>
                <label for="type_<?=$t['val']?>" class="type-card">
                    <span class="type-icon"><?=$t['icon']?></span>
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
                <span class="photo-slot-icon">+</span>
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
        <div class="info-row"><span class="info-row-icon">📋</span><span>신청 접수 후 카카오톡 또는 문자로 견적 안내드립니다.</span></div>
        <div class="info-row"><span class="info-row-icon">📦</span><span>전국 택배 수선 가능 · 수선 완료 후 문 앞 배송</span></div>
        <div class="info-row"><span class="info-row-icon">💬</span><span>카카오톡 <strong>21apro</strong> 24시간 상담 가능</span></div>
        <div class="info-row"><span class="info-row-icon">⏰</span><span>운영시간 AM 10:00 ~ PM 7:00</span></div>
    </div>
</div>

<?php endif; ?>
</div>

<script>
// 압축 후 DataURL을 File 객체로 변환
function dataURLtoFile(dataurl, filename) {
    var arr = dataurl.split(','), mime = arr[0].match(/:(.*?);/)[1];
    var bstr = atob(arr[1]), n = bstr.length, u8arr = new Uint8Array(n);
    while (n--) u8arr[n] = bstr.charCodeAt(n);
    return new File([u8arr], filename, {type: mime});
}

// 사진 선택 → Canvas로 리사이즈(최대 1600px) 후 미리보기 + 압축본 교체
function previewPhoto(input, idx) {
    const slot = document.getElementById('slot_' + idx);
    const existing = slot.querySelector('img.preview');
    if (existing) existing.remove();

    if (!input.files || !input.files[0]) {
        slot.classList.remove('has-file');
        return;
    }

    const file = input.files[0];
    const reader = new FileReader();
    reader.onload = function(e) {
        const original = new Image();
        original.onload = function() {
            // 최대 1600px로 축소
            const MAX = 1600;
            let w = original.width, h = original.height;
            if (w > MAX || h > MAX) {
                if (w > h) { h = Math.round(h * MAX / w); w = MAX; }
                else       { w = Math.round(w * MAX / h); h = MAX; }
            }
            const canvas = document.createElement('canvas');
            canvas.width = w; canvas.height = h;
            canvas.getContext('2d').drawImage(original, 0, 0, w, h);
            const compressed = canvas.toDataURL('image/jpeg', 0.85);

            // 압축본으로 input 교체 (DataTransfer 지원 브라우저)
            try {
                const dt = new DataTransfer();
                dt.items.add(dataURLtoFile(compressed, file.name.replace(/\.[^.]+$/, '.jpg')));
                input.files = dt.files;
            } catch(err) { /* 구형 브라우저: 원본 그대로 */ }

            // 미리보기
            const img = document.createElement('img');
            img.className = 'preview';
            img.src = compressed;
            slot.appendChild(img);
            slot.classList.add('has-file');
        };
        original.src = e.target.result;
    };
    reader.readAsDataURL(file);
}

// 에러 발생 시 해당 필드 강조 + 스크롤
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

// 카카오톡 ID 복사
function copyKakaoId() {
    var id = '21apro';
    var btn = document.getElementById('btn-copy-kakao');
    var fb  = document.getElementById('copy-feedback');

    function onSuccess() {
        btn.innerHTML = '✓ 복사 완료!';
        fb.style.display = 'block';
        setTimeout(function() {
            btn.innerHTML = '💬 카카오톡 ID 복사: 21apro';
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

// 폼 제출 시 버튼 로딩 상태
document.querySelector('form').addEventListener('submit', function() {
    var btn = document.getElementById('btn-submit');
    if (btn) {
        btn.textContent = '전송 중...';
        btn.disabled = true;
        btn.style.opacity = '0.7';
    }
});

// 유형 선택 시 시각 피드백
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
