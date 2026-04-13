<?php
/**
 * 맞춤 축구화 제작 전용 랜딩 페이지 — 베나프로(Venafro)
 * Apple design-md 기반 (VoltAgent/awesome-design-md)
 */
define('_GNUBOARD_', true);
require_once dirname(__FILE__) . '/common.php';
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>맞춤 축구화 제작 전문 | 캥거루 가죽 수제축구화 · 발볼 넓은 축구화 | 리앤양</title>
<meta name="description" content="나만의 발형으로 만드는 캥거루 가죽 수제 맞춤 축구화 베나프로. 발볼 넓은 분·무지외반증·특수 발형 모두 제작 가능. 35만원~, 전국 택배 접수. 카카오톡 21apro 24시간 상담.">
<meta name="keywords" content="맞춤축구화,수제축구화,캥거루가죽축구화,발볼넓은축구화,개인맞춤축구화,리앤양,베나프로">
<meta property="og:type" content="website">
<meta property="og:site_name" content="리앤양">
<meta property="og:title" content="캥거루 가죽 수제 맞춤 축구화 베나프로 | 리앤양">
<meta property="og:description" content="나만의 발형으로 제작하는 캥거루 가죽 수제 맞춤 축구화. 발볼·발등·발길이 실측, 35만원~, 2~4주 완성.">
<meta property="og:url" content="https://leeandyang.co.kr/custom.php">
<meta property="og:image" content="https://leeandyang.co.kr/thema/Miso-Basic4/main/image/og-image.jpg">
<link rel="canonical" href="https://leeandyang.co.kr/custom.php">
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Product",
  "name": "베나프로 맞춤 축구화",
  "description": "캥거루 천연가죽 어퍼, 발형 실측 수제 제작 맞춤 축구화. 발볼 넓은 분·무지외반증·특수 발형 모두 제작 가능.",
  "brand": { "@type": "Brand", "name": "리앤양" },
  "offers": {
    "@type": "AggregateOffer",
    "lowPrice": "350000", "highPrice": "450000", "priceCurrency": "KRW",
    "availability": "https://schema.org/InStock",
    "url": "https://leeandyang.co.kr/custom.php"
  },
  "provider": {
    "@type": "LocalBusiness", "name": "리앤양", "telephone": "010-3547-7744",
    "address": {
      "@type": "PostalAddress",
      "addressLocality": "경기도 고양시 덕양구",
      "streetAddress": "서오릉로 433 한우만 3층", "addressCountry": "KR"
    }
  }
}
</script>
<!-- Google Ads 전환 추적 -->
<script async src="https://www.googletagmanager.com/gtag/js?id=AW-998917058"></script>
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());
gtag('config', 'AW-998917058');
</script>
<style>
/*
 * Apple Design System — VoltAgent/awesome-design-md
 * #000000 hero / #f5f5f7 gray sections / #ffffff white sections
 * SF Pro Display(20px+) · SF Pro Text(19px 이하)
 * Apple Blue #0071e3 — 인터랙티브 전용, 다른 색상 accent 없음
 * 카드 보더 없음 · 섀도우 rgba(0,0,0,0.22) 3px 5px 30px
 * Headline: line-height 1.07 · letter-spacing -0.28px
 * Body: line-height 1.47 · letter-spacing -0.374px
 * Primary CTA: 8px radius · Pill link: 980px
 */
:root {
    --black:     #000000;
    --gray:      #f5f5f7;
    --white:     #ffffff;
    --label:     #1d1d1f;
    --label-s:   rgba(0,0,0,0.80);
    --label-t:   rgba(0,0,0,0.48);
    --sep:       rgba(0,0,0,0.10);
    --blue:      #0071e3;
    --blue-dark: #2997ff;
    --card-dark: #272729;
    --card-d2:   #2a2a2d;
    --shadow:    rgba(0,0,0,0.22) 3px 5px 30px 0px;
    --green:     #32d74b;
}
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html { scroll-behavior: smooth; }
body {
    font-family: 'SF Pro Text', 'SF Pro Display', -apple-system,
                 BlinkMacSystemFont, 'Helvetica Neue', Arial, sans-serif;
    background: var(--white); color: var(--label);
    -webkit-font-smoothing: antialiased; overflow-x: hidden;
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
    font-family: 'SF Pro Display', -apple-system, sans-serif;
    font-size: 15px; font-weight: 600; letter-spacing: 1.5px;
    color: #fff; text-decoration: none; opacity: 0.9;
}
.nav-back {
    font-size: 14px; font-weight: 400; letter-spacing: -0.224px;
    color: var(--blue-dark); text-decoration: none;
    display: flex; align-items: center; gap: 4px;
}
.nav-back:hover { text-decoration: underline; }
.nav-cta {
    font-size: 14px; font-weight: 400; letter-spacing: -0.224px;
    background: var(--blue); color: #fff;
    padding: 6px 16px; border-radius: 8px;
    text-decoration: none; transition: opacity 0.2s;
}
.nav-cta:hover { opacity: 0.85; }

/* ── HERO ────────────────────────────────────── */
.hero {
    background: var(--black);
    padding: 110px 22px 90px;
    text-align: center;
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    min-height: 520px;
}
.hero-eyebrow {
    font-size: 12px; font-weight: 600; letter-spacing: -0.12px;
    color: rgba(255,255,255,0.48); text-transform: uppercase;
    margin-bottom: 14px;
}
.hero-h1 {
    font-family: 'SF Pro Display', -apple-system, sans-serif;
    font-size: clamp(36px, 6vw, 64px); font-weight: 600;
    line-height: 1.07; letter-spacing: -0.28px;
    color: #fff; max-width: 700px; margin-bottom: 20px;
}
.hero-h1 span { color: rgba(255,255,255,0.40); }
.hero-sub {
    font-size: clamp(16px, 2vw, 21px); font-weight: 400;
    line-height: 1.47; letter-spacing: -0.374px;
    color: rgba(255,255,255,0.56); max-width: 560px; margin-bottom: 40px;
}
.hero-btns { display: flex; gap: 12px; flex-wrap: wrap; justify-content: center; }
/* Primary CTA — 8px radius */
.btn-blue {
    background: var(--blue); color: #fff;
    font-size: 17px; font-weight: 400; letter-spacing: -0.374px;
    padding: 9px 22px; border-radius: 8px;
    text-decoration: none; transition: opacity 0.2s;
}
.btn-blue:hover { opacity: 0.86; }
/* Pill link — 980px */
.btn-outline {
    color: var(--blue-dark); font-size: 17px; font-weight: 400; letter-spacing: -0.374px;
    padding: 8px 20px;
    border: 1px solid rgba(41,151,255,0.50); border-radius: 980px;
    text-decoration: none; transition: background 0.2s;
}
.btn-outline:hover { background: rgba(41,151,255,0.10); }

/* ── 섹션 공통 ────────────────────────────────── */
.sec { padding: 88px 22px; }
.sec-black { background: var(--black); }
.sec-gray  { background: var(--gray); }
.sec-white { background: var(--white); }
.inner { max-width: 980px; margin: 0 auto; }
.eyebrow {
    font-size: 12px; font-weight: 600; letter-spacing: -0.12px;
    color: var(--blue); text-transform: uppercase; margin-bottom: 8px;
}
.sec-black .eyebrow { color: rgba(255,255,255,0.48); }
.sec-title {
    font-family: 'SF Pro Display', -apple-system, sans-serif;
    font-size: clamp(28px, 4vw, 48px); font-weight: 600;
    line-height: 1.07; letter-spacing: -0.28px; margin-bottom: 14px;
}
.sec-black .sec-title { color: #fff; }
.sec-body {
    font-size: 17px; font-weight: 400; line-height: 1.47; letter-spacing: -0.374px;
    color: var(--label-s); max-width: 640px; margin-bottom: 52px;
}
.sec-black .sec-body { color: rgba(255,255,255,0.56); }

/* ── 캥거루 가죽 — 4개 피처 카드 ─────────────── */
.kang-intro {
    display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-bottom: 8px;
}
.kang-card {
    background: var(--card-dark); border-radius: 12px;
    padding: 36px 32px;
}
.kang-card.wide { grid-column: 1 / -1; }
.kang-num {
    font-size: 56px; font-weight: 600; line-height: 1; letter-spacing: -0.28px;
    color: #fff; margin-bottom: 6px;
}
.kang-num-unit {
    font-size: 20px; font-weight: 400; letter-spacing: -0.374px;
    color: rgba(255,255,255,0.56);
}
.kang-label {
    font-size: 28px; font-weight: 600; line-height: 1.14; letter-spacing: 0.196px;
    color: #fff; margin-bottom: 10px;
}
.kang-desc {
    font-size: 17px; font-weight: 400; line-height: 1.47; letter-spacing: -0.374px;
    color: rgba(255,255,255,0.56);
}
.kang-tag {
    display: inline-block;
    font-size: 12px; font-weight: 600; letter-spacing: -0.12px;
    color: var(--blue-dark);
    background: rgba(41,151,255,0.12); border-radius: 4px;
    padding: 2px 10px; margin-bottom: 14px;
}

/* ── 가죽 가격 비교 ────────────────────────────── */
.price-grid {
    display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px;
    max-width: 860px; margin: 0 auto;
}
.price-card {
    background: var(--white); border-radius: 12px;
    padding: 36px 28px; text-align: center; position: relative;
    box-shadow: var(--shadow);
}
.price-card.rec {
    background: var(--black);
    box-shadow: rgba(0,0,0,0.44) 3px 8px 40px 0px;
    transform: scale(1.04); z-index: 2;
}
.rec-badge {
    position: absolute; top: -14px; left: 50%; transform: translateX(-50%);
    background: var(--blue); color: #fff;
    font-size: 11px; font-weight: 600; letter-spacing: -0.12px;
    padding: 4px 16px; border-radius: 980px; white-space: nowrap;
}
.p-tier {
    font-size: 12px; font-weight: 600; letter-spacing: -0.12px;
    color: var(--label-t); text-transform: uppercase; margin-bottom: 8px;
}
.price-card.rec .p-tier { color: rgba(255,255,255,0.40); }
.p-name {
    font-family: 'SF Pro Display', -apple-system, sans-serif;
    font-size: 28px; font-weight: 600; line-height: 1.14; letter-spacing: 0.196px;
    color: var(--label); margin-bottom: 4px;
}
.price-card.rec .p-name { color: #fff; }
.p-sub { font-size: 14px; color: var(--label-t); margin-bottom: 24px; letter-spacing: -0.224px; }
.price-card.rec .p-sub { color: rgba(255,255,255,0.40); }
.p-amount {
    font-family: 'SF Pro Display', -apple-system, sans-serif;
    font-size: 52px; font-weight: 600; line-height: 1; letter-spacing: -0.28px;
    color: var(--label); margin-bottom: 4px;
}
.price-card.rec .p-amount { color: #fff; }
.p-amount small { font-size: 0.38em; font-weight: 400; letter-spacing: 0; vertical-align: 0.5em; }
.p-unit { font-size: 12px; color: var(--label-t); margin-bottom: 28px; letter-spacing: -0.12px; }
.price-card.rec .p-unit { color: rgba(255,255,255,0.40); }
.p-divider { height: 0.5px; background: var(--sep); margin-bottom: 20px; }
.price-card.rec .p-divider { background: rgba(255,255,255,0.10); }
.p-list { list-style: none; text-align: left; }
.p-list li {
    font-size: 14px; font-weight: 400; letter-spacing: -0.224px;
    color: var(--label-s); line-height: 1.43;
    padding: 6px 0; border-bottom: 0.5px solid var(--sep);
    display: flex; align-items: baseline; gap: 8px;
}
.p-list li:last-child { border-bottom: none; }
.price-card.rec .p-list li { color: rgba(255,255,255,0.80); border-bottom-color: rgba(255,255,255,0.08); }
.p-list li::before { content: "—"; color: var(--blue); font-size: 13px; flex-shrink: 0; }
.price-card.rec .p-list li::before { color: var(--blue-dark); }
.price-note {
    text-align: center; margin-top: 28px;
    font-size: 14px; font-weight: 400; letter-spacing: -0.224px;
    color: var(--label-t);
}

/* ── 베나프로 특징 3열 ─────────────────────────── */
.feat-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px; }
.feat-card {
    background: var(--card-dark); border-radius: 12px;
    padding: 36px 28px;
}
.feat-icon { font-size: 36px; margin-bottom: 18px; display: block; }
.feat-name {
    font-family: 'SF Pro Display', -apple-system, sans-serif;
    font-size: 21px; font-weight: 700; line-height: 1.19; letter-spacing: 0.231px;
    color: #fff; margin-bottom: 10px;
}
.feat-desc {
    font-size: 17px; font-weight: 400; line-height: 1.47; letter-spacing: -0.374px;
    color: rgba(255,255,255,0.56);
}

/* ── 추천 대상 ────────────────────────────────── */
.target-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
.target-item {
    background: var(--white); border-radius: 12px;
    padding: 20px 24px; display: flex; align-items: flex-start; gap: 14px;
    box-shadow: var(--shadow);
}
.target-dot {
    width: 6px; height: 6px; border-radius: 50%;
    background: var(--blue); flex-shrink: 0; margin-top: 8px;
}
.target-text {
    font-size: 17px; font-weight: 400; line-height: 1.47; letter-spacing: -0.374px;
    color: var(--label);
}

/* ── 제작 과정 ─────────────────────────────────── */
.process-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 8px; }
.proc-card {
    background: var(--card-d2); border-radius: 12px;
    padding: 28px 22px; text-align: center;
}
.proc-num {
    font-family: 'SF Pro Display', -apple-system, sans-serif;
    font-size: 40px; font-weight: 600; line-height: 1; letter-spacing: -0.28px;
    color: rgba(255,255,255,0.20); margin-bottom: 14px;
}
.proc-name {
    font-size: 17px; font-weight: 600; letter-spacing: -0.374px;
    color: #fff; margin-bottom: 8px;
}
.proc-desc {
    font-size: 14px; font-weight: 400; letter-spacing: -0.224px;
    color: rgba(255,255,255,0.48); line-height: 1.43;
}

/* ── FAQ ──────────────────────────────────────── */
.faq-wrap { max-width: 720px; margin: 0 auto; }
.faq-item { background: var(--white); border-radius: 12px; overflow: hidden; margin-bottom: 4px; }
.faq-q {
    width: 100%; text-align: left; background: none; border: none; cursor: pointer;
    padding: 20px 24px; gap: 16px;
    font-size: 17px; font-weight: 400; letter-spacing: -0.374px; color: var(--label);
    display: flex; align-items: center; justify-content: space-between;
    box-shadow: var(--shadow);
}
.faq-arr { flex-shrink: 0; font-size: 11px; color: var(--label-t); transition: transform 0.22s; }
.faq-item.open .faq-arr { transform: rotate(180deg); }
.faq-a {
    display: none;
    padding: 0 24px 20px;
    font-size: 17px; font-weight: 400; letter-spacing: -0.374px;
    color: var(--label-s); line-height: 1.47;
    border-top: 0.5px solid var(--sep);
    padding-top: 16px;
}
.faq-item.open .faq-a { display: block; }

/* ── CTA 최하단 ────────────────────────────────── */
.cta-wrap {
    max-width: 680px; margin: 0 auto; text-align: center;
}
.cta-title {
    font-family: 'SF Pro Display', -apple-system, sans-serif;
    font-size: clamp(28px, 4vw, 48px); font-weight: 600;
    line-height: 1.07; letter-spacing: -0.28px;
    color: #fff; margin-bottom: 16px;
}
.cta-sub {
    font-size: 17px; font-weight: 400; line-height: 1.47; letter-spacing: -0.374px;
    color: rgba(255,255,255,0.56); margin-bottom: 36px;
}
.cta-btns { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }
.btn-kakao {
    display: inline-flex; align-items: center; gap: 8px;
    background: #FEE500; color: #3C1E1E;
    font-size: 17px; font-weight: 400; letter-spacing: -0.374px;
    padding: 9px 22px; border-radius: 8px;
    border: none; cursor: pointer; transition: opacity 0.2s; text-decoration: none;
}
.btn-kakao:hover { opacity: 0.88; }
.copy-msg { display: none; margin-top: 14px; font-size: 14px; color: var(--green); font-weight: 600; letter-spacing: -0.224px; }

/* ── 푸터 ─────────────────────────────────────── */
.footer {
    padding: 40px 22px; text-align: center;
    background: var(--gray);
    font-size: 12px; font-weight: 400; letter-spacing: -0.12px;
    color: var(--label-t); line-height: 1.33;
    border-top: 0.5px solid var(--sep);
}
.footer a { color: var(--label-s); text-decoration: none; }
.footer a:hover { text-decoration: underline; }

/* ── 스크롤 reveal ─────────────────────────────── */
.rv { opacity: 0; transform: translateY(28px); transition: opacity 0.58s ease, transform 0.58s ease; }
.rv.on { opacity: 1; transform: translateY(0); }
.d1 { transition-delay: 0.06s; }
.d2 { transition-delay: 0.13s; }
.d3 { transition-delay: 0.20s; }
.d4 { transition-delay: 0.27s; }

/* ── 반응형 ────────────────────────────────────── */
@media (max-width: 680px) {
    .hero { padding: 96px 20px 68px; min-height: 420px; }
    .sec { padding: 60px 20px; }
    .kang-intro { grid-template-columns: 1fr; }
    .kang-card.wide { grid-column: auto; }
    .price-grid { grid-template-columns: 1fr; }
    .price-card.rec { transform: none; }
    .feat-grid { grid-template-columns: 1fr; }
    .target-grid { grid-template-columns: 1fr; }
    .process-row { grid-template-columns: 1fr 1fr; }
    .hero-btns { flex-direction: column; align-items: center; }
    .cta-btns  { flex-direction: column; align-items: center; }
}
</style>
</head>
<body>

<!-- NAV -->
<nav class="nav">
    <a href="/" class="nav-logo">LEE&amp;YANG</a>
    <a href="/changalyi.php" class="nav-back">&#8249; 창갈이 수선</a>
    <a href="/apply.php" class="nav-cta">신청하기</a>
</nav>

<!-- ① HERO -->
<section class="hero">
    <p class="hero-eyebrow">리앤양 베나프로 맞춤 축구화</p>
    <h1 class="hero-h1">내 발을 위해<br>처음부터 만드는<br><span>유일한 축구화.</span></h1>
    <p class="hero-sub">발볼·발등·발길이를 실측해 손으로 한 켤레씩 제작합니다.<br>세상에 단 하나, 오직 내 발만을 위한 맞춤 수제 축구화.</p>
    <div class="hero-btns">
        <a href="/apply.php" class="btn-blue">지금 제작 신청하기</a>
        <a href="#kanguro" class="btn-outline">캥거루 가죽이란? ›</a>
    </div>
</section>

<!-- ② 캥거루 가죽 -->
<section class="sec sec-black" id="kanguro">
    <div class="inner">
        <p class="eyebrow rv">소재</p>
        <h2 class="sec-title rv d1">세계 최상급 축구화 가죽,<br>캥거루 가죽을 권장하는 이유.</h2>
        <p class="sec-body rv d2">나이키 Tiempo Legend Elite, 아디다스 Copa Mundial. 세계 정상급 축구화가 선택한 소재가 캥거루 가죽입니다. 리앤양 베나프로에서도 가장 많이 선택되는 어퍼 소재입니다.</p>
        <div class="kang-intro rv d2">
            <div class="kang-card">
                <div class="kang-tag">강도</div>
                <div class="kang-num">3<span class="kang-num-unit">배</span></div>
                <div class="kang-label">같은 두께, 3배 강하다</div>
                <div class="kang-desc">캥거루 가죽은 단위 두께당 인장 강도가 소가죽의 약 3배입니다. 얇게 가공해도 찢어지지 않아, 더 가볍고 얇은 어퍼를 만들 수 있습니다. 볼 터치의 민감도가 높아지고 착화감이 극적으로 좋아집니다.</div>
            </div>
            <div class="kang-card">
                <div class="kang-tag">착화감</div>
                <div class="kang-num">2~3<span class="kang-num-unit">시간</span></div>
                <div class="kang-label">빠르게 발에 길든다</div>
                <div class="kang-desc">섬유 구조가 유연하고 촘촘해 2~3시간 착용만으로 발형에 맞게 변형됩니다. 맞춤 제작된 라스트(틀) 위에서 제작되기 때문에, 캥거루 가죽을 사용할 때 이 효과가 극대화됩니다.</div>
            </div>
            <div class="kang-card wide">
                <div class="kang-tag">소재 비교</div>
                <div class="kang-label">인조가죽 · 소가죽 · 캥거루 가죽</div>
                <div class="kang-desc" style="margin-top:12px;">인조가죽은 내구성이 낮고 발에 잘 길들지 않습니다. 소가죽은 천연가죽의 착화감을 주지만 두꺼워 볼 터치가 무뎌집니다. 캥거루 가죽은 얇고 강하면서 유연해, 맞춤 제작 축구화의 성능을 가장 잘 살려주는 소재입니다. 대부분의 고객이 경험 후 캥거루 가죽을 다시 선택합니다.</div>
            </div>
        </div>
    </div>
</section>

<!-- ③ 가격 비교 -->
<section class="sec sec-gray" id="price">
    <div class="inner">
        <p class="eyebrow rv" style="text-align:center;">가격</p>
        <h2 class="sec-title rv d1" style="text-align:center;">어퍼 소재를 선택하세요</h2>
        <p class="sec-body rv d2" style="text-align:center;margin-left:auto;margin-right:auto;">발형 실측, 색상·스터드 커스터마이징, 수제 제작, 전국 배송 모두 포함된 가격입니다.</p>
        <div class="price-grid rv d2">

            <!-- 인조가죽 -->
            <div class="price-card">
                <div class="p-tier">Basic</div>
                <div class="p-name">인조가죽</div>
                <div class="p-sub">합성 어퍼</div>
                <div class="p-amount"><small>₩</small>35<small style="font-size:0.38em;vertical-align:baseline">만원</small></div>
                <div class="p-unit">VAT 포함 · 전국 배송 포함</div>
                <div class="p-divider"></div>
                <ul class="p-list">
                    <li>합성 소재 어퍼</li>
                    <li>FG/AG 겸용 아웃솔</li>
                    <li>발형 실측 맞춤 제작</li>
                    <li>색상·스터드 선택</li>
                </ul>
            </div>

            <!-- 캥거루 가죽 (추천) -->
            <div class="price-card rec">
                <div class="rec-badge">추천 · 가장 많이 선택</div>
                <div class="p-tier">Premium</div>
                <div class="p-name">캥거루 가죽</div>
                <div class="p-sub">세계 최상급 천연가죽</div>
                <div class="p-amount"><small>₩</small>45<small style="font-size:0.38em;vertical-align:baseline">만원</small></div>
                <div class="p-unit">VAT 포함 · 전국 배송 포함</div>
                <div class="p-divider"></div>
                <ul class="p-list">
                    <li>캥거루 천연가죽 어퍼</li>
                    <li>소가죽 대비 얇고 3배 강함</li>
                    <li>2~3시간 내 발에 길듦</li>
                    <li>FG/AG/SG 아웃솔 선택</li>
                    <li>발형 실측 맞춤 제작</li>
                    <li>색상·스터드 선택</li>
                </ul>
            </div>

            <!-- 소가죽 -->
            <div class="price-card">
                <div class="p-tier">Standard</div>
                <div class="p-name">소가죽</div>
                <div class="p-sub">천연 카프스킨</div>
                <div class="p-amount"><small>₩</small>40<small style="font-size:0.38em;vertical-align:baseline">만원</small></div>
                <div class="p-unit">VAT 포함 · 전국 배송 포함</div>
                <div class="p-divider"></div>
                <ul class="p-list">
                    <li>천연 소가죽 어퍼</li>
                    <li>FG/AG/SG 아웃솔 선택</li>
                    <li>발형 실측 맞춤 제작</li>
                    <li>색상·스터드 선택</li>
                </ul>
            </div>

        </div>
        <p class="price-note rv">색상·스터드 조합은 상담 후 결정합니다. 궁금한 점은 카카오톡 <strong>21apro</strong>로 문의해 주세요.</p>
    </div>
</section>

<!-- ④ 베나프로 특징 -->
<section class="sec sec-black">
    <div class="inner">
        <p class="eyebrow rv">베나프로 특징</p>
        <h2 class="sec-title rv d1">기성화가 맞지 않는 이유가 있습니다.</h2>
        <p class="sec-body rv d2">대량 생산 축구화는 평균 발형 기준으로 만들어집니다. 베나프로는 당신의 발형 데이터만을 기준으로 처음부터 다시 만듭니다.</p>
        <div class="feat-grid rv d2">
            <div class="feat-card">
                <span class="feat-icon">📐</span>
                <div class="feat-name">발형 실측 제작</div>
                <div class="feat-desc">발 길이·너비·발등 높이·아치 곡률까지 정밀 측정합니다. 방문 측정 또는 족적지 우편 발송 모두 가능합니다.</div>
            </div>
            <div class="feat-card">
                <span class="feat-icon">🎨</span>
                <div class="feat-name">색상·스터드 선택</div>
                <div class="feat-desc">어퍼 색상, 스터드 패턴(15종), 아웃솔 타입(FG/AG/SG)을 직접 선택합니다. 세상에 하나뿐인 나만의 디자인.</div>
            </div>
            <div class="feat-card">
                <span class="feat-icon">🏭</span>
                <div class="feat-name">한 켤레씩 수작업</div>
                <div class="feat-desc">공장 대량 생산이 아닌 장인이 직접 제작합니다. 라스트(틀)를 발형에 맞게 커스텀해 착화감을 극대화합니다.</div>
            </div>
        </div>
    </div>
</section>

<!-- ⑤ 추천 대상 -->
<section class="sec sec-white">
    <div class="inner">
        <p class="eyebrow rv">추천 대상</p>
        <h2 class="sec-title rv d1">이런 분들을 위해 만들었습니다.</h2>
        <p class="sec-body rv d2">기성 축구화가 불편한 데는 이유가 있습니다. 발형 문제라면 맞춤 제작이 유일한 해답입니다.</p>
        <div class="target-grid rv d2">
            <div class="target-item">
                <div class="target-dot"></div>
                <span class="target-text">발볼이 넓어 기성 축구화가 꽉 끼거나 발가락이 눌리는 분</span>
            </div>
            <div class="target-item">
                <div class="target-dot"></div>
                <span class="target-text">무지외반증·소건막류 등 발 변형으로 신발 선택이 어려운 분</span>
            </div>
            <div class="target-item">
                <div class="target-dot"></div>
                <span class="target-text">발 좌우 사이즈가 달라 항상 한쪽이 맞지 않는 분</span>
            </div>
            <div class="target-item">
                <div class="target-dot"></div>
                <span class="target-text">220mm 이하 또는 295mm 이상의 특수 사이즈가 필요한 분</span>
            </div>
            <div class="target-item">
                <div class="target-dot"></div>
                <span class="target-text">발등이 높거나 낮아 기성화 착용 시 발이 빠지거나 조이는 분</span>
            </div>
            <div class="target-item">
                <div class="target-dot"></div>
                <span class="target-text">나만의 색상·디자인으로 특별한 축구화를 갖고 싶은 선수·동호인</span>
            </div>
        </div>
    </div>
</section>

<!-- ⑥ 제작 과정 -->
<section class="sec sec-black">
    <div class="inner">
        <p class="eyebrow rv">제작 과정</p>
        <h2 class="sec-title rv d1">4단계로 완성됩니다.</h2>
        <p class="sec-body rv d2">카카오톡 상담부터 배송까지. 복잡한 절차 없이 진행됩니다.</p>
        <div class="process-row rv d2">
            <div class="proc-card">
                <div class="proc-num">01</div>
                <div class="proc-name">상담·견적</div>
                <div class="proc-desc">카카오톡 21apro로 발 사진 전송, 원하는 소재·색상·스터드 상담. 24시간 가능.</div>
            </div>
            <div class="proc-card">
                <div class="proc-num">02</div>
                <div class="proc-name">발형 측정</div>
                <div class="proc-desc">경기도 고양시 직접 방문 또는 족적지 우편 발송. 발 전체 치수를 정밀 측정.</div>
            </div>
            <div class="proc-card">
                <div class="proc-num">03</div>
                <div class="proc-name">수제 제작</div>
                <div class="proc-desc">발형 데이터로 라스트 커스텀 후 장인이 직접 수작업 제작. 2~4주 소요.</div>
            </div>
            <div class="proc-card">
                <div class="proc-num">04</div>
                <div class="proc-name">배송·피팅</div>
                <div class="proc-desc">전국 택배 발송 완료 후 착용감 피팅 상담. 간단한 수선도 상담 가능.</div>
            </div>
        </div>
    </div>
</section>

<!-- ⑦ FAQ -->
<section class="sec sec-gray">
    <div class="inner">
        <p class="eyebrow rv" style="text-align:center;">FAQ</p>
        <h2 class="sec-title rv d1" style="text-align:center;margin-bottom:40px;">자주 묻는 질문</h2>
        <div class="faq-wrap rv d2">

            <div class="faq-item">
                <button class="faq-q" onclick="toggleFaq(this)">
                    가격이 어떻게 되나요?
                    <span class="faq-arr">▼</span>
                </button>
                <div class="faq-a">어퍼 소재에 따라 다릅니다. <strong>인조가죽 35만원 / 소가죽 40만원 / 캥거루 가죽 45만원</strong>이며, 모두 발형 실측·색상 커스터마이징·수제 제작·전국 배송이 포함된 가격입니다. 대부분의 고객은 착화감과 내구성이 월등한 캥거루 가죽을 선택합니다.</div>
            </div>

            <div class="faq-item">
                <button class="faq-q" onclick="toggleFaq(this)">
                    왜 캥거루 가죽이 더 좋은가요?
                    <span class="faq-arr">▼</span>
                </button>
                <div class="faq-a">캥거루 가죽은 단위 두께당 인장 강도가 소가죽의 약 3배입니다. 얇게 가공해도 내구성이 유지되어 볼 터치 민감도가 높아집니다. 또한 섬유 조직이 유연해 2~3시간 착용만으로 발형에 맞게 길들어, 맞춤 제작과 시너지가 매우 큽니다. 나이키 Tiempo Legend Elite, 아디다스 Copa Mundial 등 세계 최상위 모델이 이 소재를 사용하는 이유입니다.</div>
            </div>

            <div class="faq-item">
                <button class="faq-q" onclick="toggleFaq(this)">
                    발 사진만으로 제작 가능한가요?
                    <span class="faq-arr">▼</span>
                </button>
                <div class="faq-a">카카오톡으로 발 사진(위·옆·앞·뒤)을 보내주시면 기초 상담이 가능합니다. 더 정확한 제작을 위해 <strong>방문 측정</strong>을 권장하며, 방문이 어려운 분은 족적지를 우편으로 보내주시는 방법도 있습니다. 방문 주소: 경기도 고양시 덕양구 서오릉로 433 한우만 3층.</div>
            </div>

            <div class="faq-item">
                <button class="faq-q" onclick="toggleFaq(this)">
                    제작 기간이 얼마나 걸리나요?
                    <span class="faq-arr">▼</span>
                </button>
                <div class="faq-a">보통 <strong>2주에서 4주</strong> 소요됩니다. 주문 현황에 따라 달라질 수 있으며, 상담 시 예상 기간을 정확히 안내드립니다.</div>
            </div>

            <div class="faq-item">
                <button class="faq-q" onclick="toggleFaq(this)">
                    어떤 발형도 제작 가능한가요?
                    <span class="faq-arr">▼</span>
                </button>
                <div class="faq-a">발볼 넓음·무지외반증·짝발·특수 사이즈(220mm 이하, 295mm 이상) 등 <strong>대부분의 발형 제작이 가능</strong>합니다. 먼저 카카오톡으로 발 사진과 함께 상담해 주세요.</div>
            </div>

            <div class="faq-item">
                <button class="faq-q" onclick="toggleFaq(this)">
                    스터드(아웃솔)는 어떻게 선택하나요?
                    <span class="faq-arr">▼</span>
                </button>
                <div class="faq-a">Stud 03번~15번, 총 15가지 패턴 중 선택 가능합니다. 천연 잔디(FG), 인공 잔디(AG), 연식 잔디(SG) 등 주로 사용하는 경기장 환경에 맞춰 상담 후 결정합니다. 스터드 선택에 따른 추가 비용은 없습니다.</div>
            </div>

        </div>
    </div>
</section>

<!-- ⑧ CTA -->
<section class="sec sec-black">
    <div class="inner">
        <div class="cta-wrap rv">
            <p class="hero-eyebrow" style="margin-bottom:14px;">지금 시작하세요</p>
            <h2 class="cta-title">발 사진 한 장으로<br>무료 상담·견적.</h2>
            <p class="cta-sub">카카오톡 21apro로 발 사진을 보내주시면<br>소재·색상·스터드 상담과 견적을 바로 드립니다.</p>
            <div class="cta-btns">
                <a href="/apply.php" class="btn-blue">신청서 작성하기</a>
                <button class="btn-kakao" onclick="copyKakao()">
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none"><path d="M9 1.5C4.86 1.5 1.5 4.14 1.5 7.38c0 2.04 1.2 3.84 3.03 4.92l-.75 2.79 3.21-2.1c.66.12 1.32.18 2.01.18 4.14 0 7.5-2.64 7.5-5.88S13.14 1.5 9 1.5z" fill="#3C1E1E"/></svg>
                    카카오톡 21apro
                </button>
            </div>
            <div class="copy-msg" id="copyMsg">아이디가 복사됐습니다. 카카오톡에서 21apro를 검색해 주세요.</div>
        </div>
    </div>
</section>

<footer class="footer">
    <div>리앤양 Lee &amp; Yang &nbsp;|&nbsp; 경기도 고양시 덕양구 서오릉로 433 한우만 3층</div>
    <div style="margin-top:4px;">Tel: 010-3547-7744 &nbsp;|&nbsp; 카카오톡: 21apro &nbsp;|&nbsp; 우리은행 578-224027-02-003 (이주용)</div>
    <div style="margin-top:10px;">
        <a href="/">홈</a> &nbsp;·&nbsp;
        <a href="/changalyi.php">창갈이 수선</a> &nbsp;·&nbsp;
        <a href="/apply.php">신청하기</a>
    </div>
</footer>

<script>
function toggleFaq(btn) {
    btn.closest('.faq-item').classList.toggle('open');
}

function copyKakao() {
    var id = '21apro';
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(id).then(showMsg);
    } else {
        var t = document.createElement('textarea');
        t.value = id; t.style.cssText = 'position:fixed;opacity:0';
        document.body.appendChild(t); t.focus(); t.select();
        try { document.execCommand('copy'); } catch(e) {}
        document.body.removeChild(t); showMsg();
    }
}
function showMsg() {
    var el = document.getElementById('copyMsg');
    el.style.display = 'block';
    setTimeout(function(){ el.style.display = 'none'; }, 3500);
}

(function() {
    var els = document.querySelectorAll('.rv');
    if (!els.length) return;
    if ('IntersectionObserver' in window) {
        var io = new IntersectionObserver(function(entries) {
            entries.forEach(function(e) {
                if (e.isIntersecting) { e.target.classList.add('on'); io.unobserve(e.target); }
            });
        }, { threshold: 0.08 });
        els.forEach(function(el) { io.observe(el); });
    } else {
        els.forEach(function(el) { el.classList.add('on'); });
    }
})();
</script>
</body>
</html>
