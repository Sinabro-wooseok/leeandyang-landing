<?php
/**
 * 맞춤 축구화 전용 신청 폼
 * 제출 시 DB(g5_custom_apply) 저장 + 관리자 이메일 발송
 */
define('_GNUBOARD_', true);
require_once dirname(__FILE__) . '/common.php';

$error  = '';
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    /* ── 입력 검증 ─────────────────────── */
    $name    = trim($_POST['name']    ?? '');
    $phone   = trim($_POST['phone']   ?? '');
    $brand   = trim($_POST['brand']   ?? '');
    $size    = trim($_POST['size']    ?? '');
    $width   = trim($_POST['width']   ?? '');
    $good    = trim($_POST['good']    ?? '');
    $bad     = trim($_POST['bad']     ?? '');
    $leather = trim($_POST['leather'] ?? '');
    $color   = trim($_POST['color']   ?? '');
    $memo    = trim($_POST['memo']    ?? '');

    if (!$name)  $error = '이름을 입력해 주세요.';
    elseif (!preg_match('/^[0-9\-+() ]{8,20}$/', $phone))
        $error = '연락처를 올바르게 입력해 주세요.';
    elseif (!$leather) $error = '원하시는 가죽 소재를 선택해 주세요.';

    if (!$error) {
        /* ── DB 저장 ───────────────────── */
        $ip = $_SERVER['REMOTE_ADDR'] ?? '';
        $sql = "INSERT INTO g5_custom_apply
                    (ca_name, ca_phone, ca_brand, ca_size, ca_width,
                     ca_good, ca_bad, ca_leather, ca_color, ca_memo, ca_ip)
                VALUES (
                    '".sql_escape_string($name)."',
                    '".sql_escape_string($phone)."',
                    '".sql_escape_string($brand)."',
                    '".sql_escape_string($size)."',
                    '".sql_escape_string($width)."',
                    '".sql_escape_string($good)."',
                    '".sql_escape_string($bad)."',
                    '".sql_escape_string($leather)."',
                    '".sql_escape_string($color)."',
                    '".sql_escape_string($memo)."',
                    '".sql_escape_string($ip)."'
                )";
        sql_query($sql);

        /* ── 관리자 이메일 알림 ────────── */
        $admin_email = $g5['admin_email'] ?? 'woosuk547@naver.com';
        $subject = "[리앤양] 맞춤 축구화 신청 — {$name}";
        $body = "맞춤 축구화 제작 신청이 접수되었습니다.\n\n"
              . "이름: {$name}\n"
              . "연락처: {$phone}\n"
              . "평소 브랜드: {$brand}\n"
              . "평소 사이즈: {$size}mm\n"
              . "발 특이사항: {$width}\n"
              . "좋았던 점: {$good}\n"
              . "불편했던 점: {$bad}\n"
              . "원하는 가죽: {$leather}\n"
              . "원하는 색상: {$color}\n"
              . "기타 문의: {$memo}\n\n"
              . "접수 시각: ".date('Y-m-d H:i:s')."\n"
              . "IP: {$ip}";

        $headers = "From: noreply@leeandyang.co.kr\r\nContent-Type: text/plain; charset=UTF-8";
        @mail($admin_email, $subject, $body, $headers);

        $success = true;
    }
}

/* gnuboard sql_escape_string 없으면 fallback */
if (!function_exists('sql_escape_string')) {
    function sql_escape_string($s) { return addslashes($s); }
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>맞춤 축구화 제작 신청 | 리앤양</title>
<meta name="robots" content="noindex">
<script async src="https://www.googletagmanager.com/gtag/js?id=AW-998917058"></script>
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());
gtag('config', 'AW-998917058');
</script>
<style>
:root {
    --black:   #000000;
    --gray:    #f5f5f7;
    --white:   #ffffff;
    --label:   #1d1d1f;
    --label-s: rgba(0,0,0,0.80);
    --label-t: rgba(0,0,0,0.48);
    --sep:     rgba(0,0,0,0.10);
    --blue:    #0071e3;
    --blue-dk: #2997ff;
    --dk-card: #272729;
    --shadow:  rgba(0,0,0,0.22) 3px 5px 30px 0px;
    --red:     #ff3b30;
    --green:   #32d74b;
}
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html { scroll-behavior: smooth; }
body {
    font-family: 'SF Pro Text', 'SF Pro Display',
                 -apple-system, BlinkMacSystemFont,
                 'Helvetica Neue', Arial, sans-serif;
    background: var(--gray);
    color: var(--label);
    -webkit-font-smoothing: antialiased;
}

/* ── NAV ─────────────────────────────────────── */
.nav {
    position: fixed; inset: 0 0 auto 0; z-index: 300;
    height: 48px;
    background: rgba(0,0,0,0.82);
    backdrop-filter: saturate(180%) blur(20px);
    -webkit-backdrop-filter: saturate(180%) blur(20px);
    display: flex; align-items: center; justify-content: space-between;
    padding: 0 22px;
}
.nav-logo {
    font-size: 15px; font-weight: 600; letter-spacing: 1.5px;
    color: #fff; text-decoration: none; opacity: 0.9;
}
.nav-back {
    font-size: 14px; font-weight: 400; letter-spacing: -0.224px;
    color: var(--blue-dk); text-decoration: none;
}
.nav-back:hover { text-decoration: underline; }

/* ── 페이지 레이아웃 ─────────────────────────── */
.page {
    max-width: 680px; margin: 0 auto;
    padding: 88px 22px 80px;
}
.page-eyebrow {
    font-size: 12px; font-weight: 600; letter-spacing: -0.12px;
    color: var(--blue); text-transform: uppercase; margin-bottom: 8px;
}
.page-title {
    font-family: 'SF Pro Display', -apple-system, sans-serif;
    font-size: clamp(28px, 5vw, 48px); font-weight: 600;
    line-height: 1.07; letter-spacing: -0.28px;
    color: var(--label); margin-bottom: 14px;
}
.page-desc {
    font-size: 17px; font-weight: 400; line-height: 1.47; letter-spacing: -0.374px;
    color: var(--label-s); margin-bottom: 40px;
}

/* ── 폼 ──────────────────────────────────────── */
.form-card {
    background: var(--white); border-radius: 16px;
    padding: 40px 36px;
    box-shadow: var(--shadow);
}
.form-section {
    margin-bottom: 36px;
    padding-bottom: 36px;
    border-bottom: 0.5px solid var(--sep);
}
.form-section:last-of-type { border-bottom: none; margin-bottom: 0; }
.form-section-title {
    font-family: 'SF Pro Display', -apple-system, sans-serif;
    font-size: 21px; font-weight: 700; letter-spacing: 0.231px; line-height: 1.19;
    color: var(--label); margin-bottom: 6px;
}
.form-section-desc {
    font-size: 14px; font-weight: 400; letter-spacing: -0.224px;
    color: var(--label-t); line-height: 1.43; margin-bottom: 20px;
}
.field { margin-bottom: 16px; }
.field:last-child { margin-bottom: 0; }
label {
    display: block;
    font-size: 14px; font-weight: 600; letter-spacing: -0.224px;
    color: var(--label); margin-bottom: 6px;
}
label .req { color: var(--blue); margin-left: 2px; }
label .opt {
    font-size: 12px; font-weight: 400; color: var(--label-t);
    margin-left: 6px;
}
input[type="text"],
input[type="tel"],
select,
textarea {
    width: 100%; background: var(--gray);
    border: 1px solid transparent;
    border-radius: 10px;
    padding: 12px 14px;
    font-family: inherit;
    font-size: 17px; font-weight: 400; letter-spacing: -0.374px;
    color: var(--label);
    outline: none;
    transition: border-color 0.18s, box-shadow 0.18s;
    -webkit-appearance: none;
}
input[type="text"]:focus,
input[type="tel"]:focus,
select:focus,
textarea:focus {
    border-color: var(--blue);
    box-shadow: 0 0 0 3px rgba(0,113,227,0.15);
    background: var(--white);
}
input::placeholder, textarea::placeholder { color: var(--label-t); }
textarea { resize: vertical; min-height: 96px; line-height: 1.47; }
select { cursor: pointer; }

/* 라디오 그룹 */
.radio-group { display: flex; flex-direction: column; gap: 8px; }
.radio-label {
    display: flex; align-items: center; gap: 10px;
    background: var(--gray); border: 1px solid transparent;
    border-radius: 10px; padding: 14px 16px; cursor: pointer;
    font-size: 17px; font-weight: 400; letter-spacing: -0.374px;
    color: var(--label); transition: border-color 0.18s, background 0.18s;
}
.radio-label:hover { border-color: var(--blue); background: var(--white); }
.radio-label input[type="radio"] { display: none; }
.radio-label .radio-dot {
    width: 20px; height: 20px; border-radius: 50%;
    border: 2px solid var(--sep); flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    transition: border-color 0.18s;
}
.radio-label input:checked ~ .radio-dot {
    border-color: var(--blue);
    background: var(--blue);
    box-shadow: inset 0 0 0 4px var(--white);
}
.radio-label:has(input:checked) {
    border-color: var(--blue); background: rgba(0,113,227,0.05);
}
.radio-name { flex: 1; }
.radio-sub {
    font-size: 13px; color: var(--label-t); letter-spacing: -0.1px;
}

/* 제출 버튼 */
.submit-btn {
    width: 100%; background: var(--blue); color: #fff;
    font-family: inherit;
    font-size: 17px; font-weight: 400; letter-spacing: -0.374px;
    padding: 14px; border-radius: 12px; border: none; cursor: pointer;
    margin-top: 32px; transition: opacity 0.2s;
}
.submit-btn:hover { opacity: 0.86; }
.submit-btn:disabled { opacity: 0.5; cursor: default; }

/* 에러 */
.error-msg {
    background: rgba(255,59,48,0.08); border: 1px solid rgba(255,59,48,0.25);
    border-radius: 10px; padding: 12px 16px; margin-bottom: 20px;
    font-size: 14px; font-weight: 400; letter-spacing: -0.224px;
    color: var(--red); line-height: 1.43;
}

/* ── 완료 화면 ───────────────────────────────── */
.success-wrap { text-align: center; padding: 80px 22px; }
.success-icon {
    width: 64px; height: 64px; border-radius: 50%;
    background: rgba(50,215,75,0.12);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 24px;
}
.success-icon svg { width: 32px; height: 32px; }
.success-title {
    font-family: 'SF Pro Display', -apple-system, sans-serif;
    font-size: 34px; font-weight: 600; line-height: 1.10; letter-spacing: -0.28px;
    color: var(--label); margin-bottom: 12px;
}
.success-desc {
    font-size: 17px; font-weight: 400; line-height: 1.47; letter-spacing: -0.374px;
    color: var(--label-s); max-width: 420px; margin: 0 auto 36px;
}
.success-back {
    display: inline-block;
    font-size: 17px; font-weight: 400; letter-spacing: -0.374px;
    color: var(--blue); text-decoration: none;
}
.success-back:hover { text-decoration: underline; }

/* ── 반응형 ────────────────────────────────────── */
@media (max-width: 600px) {
    .page { padding: 72px 16px 60px; }
    .form-card { padding: 28px 20px; }
}
</style>
</head>
<body>

<nav class="nav">
    <a href="/" class="nav-logo">LEE&amp;YANG</a>
    <a href="/custom.php" class="nav-back">&#8249; 맞춤 축구화</a>
</nav>

<?php if ($success): ?>
<!-- 완료 화면 -->
<div class="success-wrap">
    <div class="success-icon">
        <svg viewBox="0 0 32 32" fill="none">
            <path d="M6 16l7 7L26 9" stroke="#32d74b" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </div>
    <div class="success-title">신청이 접수됐습니다.</div>
    <div class="success-desc">입력하신 연락처로 1~2 영업일 내 전화 상담 연락드리겠습니다.<br>급하신 분은 카카오톡 <strong>21apro</strong>로 먼저 연락해 주세요.</div>
    <a href="/custom.php" class="success-back">맞춤 축구화 페이지로 돌아가기 ›</a>
</div>

<?php else: ?>
<!-- 신청 폼 -->
<div class="page">
    <p class="page-eyebrow">베나프로 맞춤 축구화</p>
    <h1 class="page-title">제작 신청서</h1>
    <p class="page-desc">간단히 작성해 주시면 전화 상담 후 진행됩니다.<br>5분이면 충분합니다.</p>

    <div class="form-card">
        <?php if ($error): ?>
        <div class="error-msg"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="/apply-custom.php" onsubmit="return beforeSubmit()">

            <!-- 섹션 1: 기본 정보 -->
            <div class="form-section">
                <div class="form-section-title">연락 정보</div>
                <div class="form-section-desc">상담 전화 드릴 때 필요합니다.</div>
                <div class="field">
                    <label>이름 <span class="req">*</span></label>
                    <input type="text" name="name" placeholder="홍길동" maxlength="30"
                           value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required>
                </div>
                <div class="field">
                    <label>연락처 <span class="req">*</span></label>
                    <input type="tel" name="phone" placeholder="010-0000-0000" maxlength="20"
                           value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>" required>
                </div>
            </div>

            <!-- 섹션 2: 현재 신는 축구화 -->
            <div class="form-section">
                <div class="form-section-title">현재 신는 축구화</div>
                <div class="form-section-desc">현재 기성화 기준 정보를 알아야 맞춤 라스트를 정확히 설계할 수 있습니다.</div>
                <div class="field">
                    <label>주로 신는 브랜드 <span class="opt">선택</span></label>
                    <select name="brand">
                        <option value="" <?= (!($_POST['brand'] ?? '')) ? 'selected' : '' ?>>선택하지 않음</option>
                        <option value="나이키" <?= (($_POST['brand'] ?? '') === '나이키') ? 'selected' : '' ?>>나이키 (Nike)</option>
                        <option value="아디다스" <?= (($_POST['brand'] ?? '') === '아디다스') ? 'selected' : '' ?>>아디다스 (Adidas)</option>
                        <option value="미즈노" <?= (($_POST['brand'] ?? '') === '미즈노') ? 'selected' : '' ?>>미즈노 (Mizuno)</option>
                        <option value="퓨마" <?= (($_POST['brand'] ?? '') === '퓨마') ? 'selected' : '' ?>>퓨마 (Puma)</option>
                        <option value="뉴발란스" <?= (($_POST['brand'] ?? '') === '뉴발란스') ? 'selected' : '' ?>>뉴발란스 (New Balance)</option>
                        <option value="기타" <?= (($_POST['brand'] ?? '') === '기타') ? 'selected' : '' ?>>기타</option>
                    </select>
                </div>
                <div class="field">
                    <label>평소 신는 사이즈 <span class="opt">선택</span></label>
                    <select name="size">
                        <option value="" <?= (!($_POST['size'] ?? '')) ? 'selected' : '' ?>>모르겠음</option>
                        <?php
                        $sizes = range(220, 310, 5);
                        foreach ($sizes as $s) {
                            $sel = (($_POST['size'] ?? '') === (string)$s) ? 'selected' : '';
                            echo "<option value=\"{$s}\" {$sel}>{$s}mm</option>";
                        }
                        ?>
                        <option value="220mm 이하" <?= (($_POST['size'] ?? '') === '220mm 이하') ? 'selected' : '' ?>>220mm 이하</option>
                        <option value="310mm 이상" <?= (($_POST['size'] ?? '') === '310mm 이상') ? 'selected' : '' ?>>310mm 이상</option>
                    </select>
                </div>
                <div class="field">
                    <label>발 특이사항 <span class="opt">선택</span></label>
                    <input type="text" name="width"
                           placeholder="발볼 넓음, 무지외반증, 발등 높음, 짝발 등 자유 기재"
                           maxlength="100"
                           value="<?= htmlspecialchars($_POST['width'] ?? '') ?>">
                </div>
            </div>

            <!-- 섹션 3: 기성화 경험 -->
            <div class="form-section">
                <div class="form-section-title">기성화를 신었을 때 경험</div>
                <div class="form-section-desc">좋았던 점과 불편했던 점을 알면 맞춤화 설계에 반영할 수 있습니다.</div>
                <div class="field">
                    <label>좋았던 점 <span class="opt">선택</span></label>
                    <textarea name="good" placeholder="예) 앞코가 좁아서 볼 터치가 좋았다, 가벼워서 발이 편했다 등"
                              maxlength="500"><?= htmlspecialchars($_POST['good'] ?? '') ?></textarea>
                </div>
                <div class="field">
                    <label>불편했던 점 <span class="opt">선택</span></label>
                    <textarea name="bad" placeholder="예) 발볼이 너무 좁아 발가락이 눌렸다, 발등이 낮아 발이 빠졌다 등"
                              maxlength="500"><?= htmlspecialchars($_POST['bad'] ?? '') ?></textarea>
                </div>
            </div>

            <!-- 섹션 4: 원하는 소재 -->
            <div class="form-section">
                <div class="form-section-title">원하는 어퍼 소재 <span style="color:var(--blue)">*</span></div>
                <div class="form-section-desc">소재에 따라 가격이 다릅니다.</div>
                <div class="radio-group">
                    <label class="radio-label">
                        <input type="radio" name="leather" value="캥거루 가죽 (45만원)"
                               <?= (($_POST['leather'] ?? '') === '캥거루 가죽 (45만원)') ? 'checked' : '' ?> required>
                        <span class="radio-dot"></span>
                        <span class="radio-name">
                            캥거루 가죽 — 45만원
                            <span class="radio-sub">세계 최상급 / 가장 많이 선택 / 3배 강도 · 빠른 길듦</span>
                        </span>
                    </label>
                    <label class="radio-label">
                        <input type="radio" name="leather" value="소가죽 (40만원)"
                               <?= (($_POST['leather'] ?? '') === '소가죽 (40만원)') ? 'checked' : '' ?>>
                        <span class="radio-dot"></span>
                        <span class="radio-name">
                            소가죽 — 40만원
                            <span class="radio-sub">천연 카프스킨 어퍼</span>
                        </span>
                    </label>
                    <label class="radio-label">
                        <input type="radio" name="leather" value="인조가죽 (35만원)"
                               <?= (($_POST['leather'] ?? '') === '인조가죽 (35만원)') ? 'checked' : '' ?>>
                        <span class="radio-dot"></span>
                        <span class="radio-name">
                            인조가죽 — 35만원
                            <span class="radio-sub">합성 소재 어퍼</span>
                        </span>
                    </label>
                    <label class="radio-label">
                        <input type="radio" name="leather" value="상담 후 결정"
                               <?= (($_POST['leather'] ?? '') === '상담 후 결정') ? 'checked' : '' ?>>
                        <span class="radio-dot"></span>
                        <span class="radio-name">
                            상담 후 결정
                            <span class="radio-sub">전화 상담 시 설명 듣고 선택하겠습니다</span>
                        </span>
                    </label>
                </div>
            </div>

            <!-- 섹션 5: 기타 -->
            <div class="form-section">
                <div class="form-section-title">색상 · 기타 요청사항</div>
                <div class="form-section-desc">원하는 색상, 스터드, 참고 이미지 URL 등 자유롭게 적어 주세요.</div>
                <div class="field">
                    <label>원하는 색상 <span class="opt">선택</span></label>
                    <input type="text" name="color"
                           placeholder="예) 올블랙, 흰색 어퍼 + 파란 밑창, 레퍼런스 이미지 있음 등"
                           maxlength="200"
                           value="<?= htmlspecialchars($_POST['color'] ?? '') ?>">
                </div>
                <div class="field">
                    <label>추가 문의사항 <span class="opt">선택</span></label>
                    <textarea name="memo" placeholder="방문 가능 일정, 급하게 필요한 날짜, 참고할 사항 등"
                              maxlength="1000"><?= htmlspecialchars($_POST['memo'] ?? '') ?></textarea>
                </div>
            </div>

            <button type="submit" class="submit-btn" id="submitBtn">
                신청서 제출하기
            </button>
            <p style="margin-top:14px;font-size:12px;color:var(--label-t);letter-spacing:-0.12px;text-align:center;line-height:1.6;">
                제출 후 1~2 영업일 내 전화 상담 연락드립니다.<br>
                급하신 분은 카카오톡 <strong style="color:var(--label-s);">21apro</strong>로 먼저 연락해 주세요.
            </p>

        </form>
    </div>
</div>
<?php endif; ?>

<script>
function beforeSubmit() {
    var btn = document.getElementById('submitBtn');
    if (btn) { btn.disabled = true; btn.textContent = '제출 중...'; }
    return true;
}
</script>
</body>
</html>
