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
<meta property="og:image" content="https://leeandyang.co.kr/data/item/1719737285/01.jpg">
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
 * Dark glass nav / #000 hero / #f5f5f7 gray / #fff white 교차
 * SF Pro Display · line-height 1.07 · letter-spacing -0.28px (headline)
 * SF Pro Text  · line-height 1.47 · letter-spacing -0.374px (body)
 * #0071e3 — 인터랙티브 전용 단일 accent
 * 카드 보더 없음 · shadow rgba(0,0,0,0.22) 3px 5px 30px
 * Primary CTA 8px · Pill link 980px
 */
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
    --green:   #32d74b;
}
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html { scroll-behavior: smooth; }
body {
    font-family: 'SF Pro Text', 'SF Pro Display',
                 -apple-system, BlinkMacSystemFont,
                 'Helvetica Neue', Arial, sans-serif;
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
    font-size: 15px; font-weight: 600; letter-spacing: 1.5px;
    color: #fff; text-decoration: none; opacity: 0.9;
}
.nav-back {
    font-size: 14px; font-weight: 400; letter-spacing: -0.224px;
    color: var(--blue-dk); text-decoration: none;
}
.nav-back:hover { text-decoration: underline; }
.nav-cta {
    font-size: 14px; font-weight: 400; letter-spacing: -0.224px;
    background: var(--blue); color: #fff;
    padding: 6px 16px; border-radius: 8px;
    text-decoration: none; transition: opacity 0.2s;
}
.nav-cta:hover { opacity: 0.85; }

/* ── HERO ─ 좌(텍스트) / 우(이미지) 분할 ──── */
.hero {
    background: var(--black);
    padding: 48px 0 0;
    overflow: hidden;
    min-height: 100vh;
    display: flex; align-items: stretch;
}
.hero-inner {
    display: grid;
    grid-template-columns: 1fr 1fr;
    max-width: 1200px; margin: 0 auto;
    width: 100%; align-items: center;
}
.hero-text {
    padding: 80px 52px 80px 44px;
}
.hero-eyebrow {
    font-size: 12px; font-weight: 600; letter-spacing: -0.12px;
    color: rgba(255,255,255,0.48); text-transform: uppercase;
    margin-bottom: 12px;
}
.hero-h1 {
    font-family: 'SF Pro Display', -apple-system, sans-serif;
    font-size: clamp(34px, 4.5vw, 64px); font-weight: 600;
    line-height: 1.07; letter-spacing: -0.28px;
    color: #fff; margin-bottom: 18px;
}
.hero-h1 span { color: rgba(255,255,255,0.38); }
.hero-sub {
    font-size: clamp(15px, 1.5vw, 19px); font-weight: 400;
    line-height: 1.47; letter-spacing: -0.374px;
    color: rgba(255,255,255,0.56); margin-bottom: 36px;
}
.hero-btns {
    display: flex; gap: 12px; flex-wrap: wrap;
}
.btn-blue {
    background: var(--blue); color: #fff;
    font-size: 17px; font-weight: 400; letter-spacing: -0.374px;
    padding: 9px 22px; border-radius: 8px;
    text-decoration: none; transition: opacity 0.2s;
}
.btn-blue:hover { opacity: 0.86; }
.btn-pill {
    color: var(--blue-dk); font-size: 17px; font-weight: 400; letter-spacing: -0.374px;
    padding: 8px 20px;
    border: 1px solid rgba(41,151,255,0.45); border-radius: 980px;
    text-decoration: none; transition: background 0.2s;
}
.btn-pill:hover { background: rgba(41,151,255,0.10); }
/* 히어로 우측 이미지 */
.hero-img {
    height: 100%; min-height: 560px;
    overflow: hidden; position: relative;
}
.hero-img img {
    width: 100%; height: 100%;
    object-fit: cover; object-position: center;
    display: block;
}

/* ── 갤러리 — 컬러웨이 ───────────────────────── */
.gallery {
    background: var(--black);
    padding: 4px 8px 80px;
}
.gallery-row {
    display: grid; grid-template-columns: repeat(3, 1fr); gap: 4px;
    max-width: 1200px; margin: 0 auto;
}
.gallery-item img {
    width: 100%; height: auto; display: block;
    border-radius: 4px;
}
.gallery-caption {
    text-align: center; margin-top: 20px;
    font-size: 12px; font-weight: 400; letter-spacing: -0.12px;
    color: rgba(255,255,255,0.40);
}

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
    color: var(--label-s); max-width: 620px; margin-bottom: 52px;
}
.sec-black .sec-body { color: rgba(255,255,255,0.56); }

/* ── 캥거루 가죽 — 빌보드 스탯 ───────────────── */
.kang-grid {
    display: grid; grid-template-columns: 1fr 1fr; gap: 2px;
}
.kang-block {
    background: var(--dk-card); padding: 44px 36px;
}
.kang-block:first-child { border-radius: 12px 0 0 0; }
.kang-block:nth-child(2) { border-radius: 0 12px 0 0; }
.kang-block:nth-child(3) { border-radius: 0; }
.kang-block:last-child { border-radius: 0 0 12px 0; }
.kang-stat {
    font-family: 'SF Pro Display', -apple-system, sans-serif;
    font-size: 64px; font-weight: 600; line-height: 1; letter-spacing: -0.28px;
    color: #fff; margin-bottom: 6px;
}
.kang-stat span {
    font-size: 28px; font-weight: 400; letter-spacing: -0.28px;
    color: rgba(255,255,255,0.56);
}
.kang-label {
    font-family: 'SF Pro Display', -apple-system, sans-serif;
    font-size: 21px; font-weight: 600; line-height: 1.19; letter-spacing: 0.231px;
    color: #fff; margin-bottom: 10px;
}
.kang-desc {
    font-size: 15px; font-weight: 400; line-height: 1.47; letter-spacing: -0.374px;
    color: rgba(255,255,255,0.56);
}
.kang-wide {
    background: var(--dk-card); padding: 44px 36px; margin-top: 2px;
    border-radius: 0 0 12px 12px;
}
.kang-wide-title {
    font-family: 'SF Pro Display', -apple-system, sans-serif;
    font-size: 28px; font-weight: 600; line-height: 1.14; letter-spacing: 0.196px;
    color: #fff; margin-bottom: 12px;
}
.kang-wide-body {
    font-size: 17px; font-weight: 400; line-height: 1.47; letter-spacing: -0.374px;
    color: rgba(255,255,255,0.56); max-width: 720px;
}

/* ── 가격 — 테이블 행 스타일, 카드 없음 ─────── */
.price-table { max-width: 680px; margin: 0 auto; }
.price-row {
    display: grid; grid-template-columns: 1fr auto;
    align-items: baseline; gap: 16px;
    padding: 28px 0;
    border-bottom: 0.5px solid var(--sep);
}
.price-row:last-child { border-bottom: none; }
.price-row.rec .p-name { color: var(--label); }
.price-row.rec .p-amount-num { color: var(--blue); }
.p-name {
    font-family: 'SF Pro Display', -apple-system, sans-serif;
    font-size: 28px; font-weight: 600; line-height: 1.14; letter-spacing: 0.196px;
    color: var(--label-s);
}
.p-sub {
    font-size: 14px; font-weight: 400; letter-spacing: -0.224px;
    color: var(--label-t); margin-top: 4px;
}
.p-features {
    list-style: none; margin-top: 10px;
}
.p-features li {
    font-size: 14px; font-weight: 400; letter-spacing: -0.224px;
    color: var(--label-t); line-height: 1.6;
    padding-left: 14px; position: relative;
}
.p-features li::before {
    content: "—"; position: absolute; left: 0;
    color: var(--label-t); font-size: 12px;
}
.price-row.rec .p-features li,
.price-row.rec .p-features li::before { color: var(--label-s); }
.p-rec-badge {
    display: inline-block; margin-left: 10px;
    font-size: 11px; font-weight: 600; letter-spacing: -0.12px;
    color: var(--blue);
    border: 1px solid var(--blue); border-radius: 4px;
    padding: 1px 8px; vertical-align: middle;
}
.p-amount {
    text-align: right; white-space: nowrap;
}
.p-amount-num {
    font-family: 'SF Pro Display', -apple-system, sans-serif;
    font-size: 40px; font-weight: 600; line-height: 1; letter-spacing: -0.28px;
    color: var(--label-s);
}
.p-amount-unit {
    font-size: 16px; font-weight: 400; letter-spacing: -0.374px;
    color: var(--label-t); margin-left: 2px;
}
.price-note {
    margin-top: 28px; padding-top: 20px;
    border-top: 0.5px solid var(--sep);
    font-size: 14px; font-weight: 400; letter-spacing: -0.224px;
    color: var(--label-t); line-height: 1.6; text-align: center;
}

/* ── 특징 3열 ─────────────────────────────────── */
.feat-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 2px; }
.feat-block {
    background: var(--dk-card); padding: 40px 32px;
}
.feat-block:first-child { border-radius: 12px 0 0 12px; }
.feat-block:last-child  { border-radius: 0 12px 12px 0; }
.feat-num {
    font-family: 'SF Pro Display', -apple-system, sans-serif;
    font-size: 14px; font-weight: 600; letter-spacing: -0.12px;
    color: rgba(255,255,255,0.30); margin-bottom: 32px;
}
.feat-name {
    font-family: 'SF Pro Display', -apple-system, sans-serif;
    font-size: 21px; font-weight: 700; line-height: 1.19; letter-spacing: 0.231px;
    color: #fff; margin-bottom: 10px;
}
.feat-desc {
    font-size: 15px; font-weight: 400; line-height: 1.47; letter-spacing: -0.374px;
    color: rgba(255,255,255,0.56);
}

/* ── 추천 대상 ────────────────────────────────── */
.target-list { list-style: none; max-width: 680px; }
.target-item {
    display: flex; align-items: baseline; gap: 16px;
    padding: 20px 0;
    border-bottom: 0.5px solid var(--sep);
    font-size: 17px; font-weight: 400; line-height: 1.47; letter-spacing: -0.374px;
    color: var(--label);
}
.target-item:last-child { border-bottom: none; }
.t-idx {
    font-family: 'SF Pro Display', -apple-system, sans-serif;
    font-size: 14px; font-weight: 600; letter-spacing: -0.12px;
    color: var(--blue); flex-shrink: 0; min-width: 24px;
}

/* ── 제작 과정 ─────────────────────────────────── */
.process-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 2px; }
.proc-block {
    background: var(--dk-card); padding: 36px 28px;
}
.proc-block:first-child { border-radius: 12px 0 0 12px; }
.proc-block:last-child  { border-radius: 0 12px 12px 0; }
.proc-num {
    font-family: 'SF Pro Display', -apple-system, sans-serif;
    font-size: 40px; font-weight: 600; line-height: 1; letter-spacing: -0.28px;
    color: rgba(255,255,255,0.20); margin-bottom: 20px;
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
.faq-item {
    background: var(--white);
    border-radius: 12px; margin-bottom: 4px;
    box-shadow: var(--shadow);
}
.faq-q {
    width: 100%; text-align: left; background: none; border: none; cursor: pointer;
    padding: 20px 24px;
    font-size: 17px; font-weight: 400; letter-spacing: -0.374px; color: var(--label);
    display: flex; align-items: center; justify-content: space-between; gap: 16px;
}
.faq-arr { flex-shrink: 0; font-size: 11px; color: var(--label-t); transition: transform 0.22s; }
.faq-item.open .faq-arr { transform: rotate(180deg); }
.faq-a {
    display: none;
    padding: 0 24px 20px;
    font-size: 17px; font-weight: 400; letter-spacing: -0.374px;
    color: var(--label-s); line-height: 1.47;
    border-top: 0.5px solid var(--sep); padding-top: 16px;
}
.faq-item.open .faq-a { display: block; }

/* ── CTA ──────────────────────────────────────── */
.cta-wrap { max-width: 600px; margin: 0 auto; text-align: center; }
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
.copy-msg {
    display: none; margin-top: 14px;
    font-size: 14px; color: var(--green); font-weight: 600; letter-spacing: -0.224px;
}

/* ── 푸터 ─────────────────────────────────────── */
.footer {
    padding: 40px 22px; text-align: center;
    background: var(--gray);
    font-size: 12px; font-weight: 400; letter-spacing: -0.12px;
    color: var(--label-t); line-height: 1.47;
    border-top: 0.5px solid var(--sep);
}
.footer a { color: var(--label-s); text-decoration: none; }
.footer a:hover { text-decoration: underline; }

/* ── 스크롤 reveal ─────────────────────────────── */
.rv { opacity: 0; transform: translateY(24px); transition: opacity 0.58s ease, transform 0.58s ease; }
.rv.on { opacity: 1; transform: translateY(0); }
.d1 { transition-delay: 0.06s; } .d2 { transition-delay: 0.13s; }
.d3 { transition-delay: 0.20s; } .d4 { transition-delay: 0.27s; }

/* ── 반응형 ────────────────────────────────────── */
@media (max-width: 680px) {
    .hero { padding: 0; min-height: auto; }
    .hero-inner { grid-template-columns: 1fr; }
    .hero-text { padding: 100px 20px 48px; order: 1; }
    .hero-img { min-height: 320px; order: 2; }
    .hero-btns { flex-direction: column; align-items: flex-start; }
    .sec  { padding: 60px 20px; }
    .kang-grid    { grid-template-columns: 1fr; }
    .kang-block:first-child { border-radius: 12px 12px 0 0; }
    .kang-block:nth-child(2){ border-radius: 0; }
    .kang-block:nth-child(3){ border-radius: 0; }
    .kang-block:last-child  { border-radius: 0 0 0 0; }
    .kang-wide    { border-radius: 0 0 12px 12px; }
    .feat-grid    { grid-template-columns: 1fr; gap: 2px; }
    .feat-block:first-child { border-radius: 12px 12px 0 0; }
    .feat-block:last-child  { border-radius: 0 0 12px 12px; }
    .process-row  { grid-template-columns: 1fr 1fr; }
    .proc-block:first-child { border-radius: 12px 0 0 0; }
    .proc-block:last-child  { border-radius: 0 0 12px 0; }
    .gallery-row  { grid-template-columns: 1fr; gap: 2px; }
    .hero-btns, .cta-btns { flex-direction: column; align-items: center; }
    .price-row    { grid-template-columns: 1fr; gap: 8px; }
    .p-amount     { text-align: left; }
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
    <div class="hero-inner">
        <div class="hero-text">
            <p class="hero-eyebrow rv">베나프로 맞춤 축구화</p>
            <h1 class="hero-h1 rv d1">내 발을 위해<br>처음부터 만드는<br><span>유일한 축구화.</span></h1>
            <p class="hero-sub rv d2">발볼·발등·발길이를 실측해 손으로 한 켤레씩 제작합니다.<br>오직 내 발만을 위한 맞춤 수제 축구화.</p>
            <div class="hero-btns rv d3">
                <a href="/apply-custom.php" class="btn-blue">맞춤 제작 신청하기</a>
                <a href="#price" class="btn-pill">가격 확인하기</a>
            </div>
        </div>
        <div class="hero-img rv d2">
            <img src="/data/item/1747209309/thumb-1_800x800.jpg" alt="베나프로 맞춤 축구화" loading="eager">
        </div>
    </div>
</section>

<!-- ② 컬러웨이 갤러리 -->
<section class="gallery">
    <div class="gallery-row">
        <div class="gallery-item">
            <img src="/data/item/1719735403/thumb-01_800x800.jpg" alt="베나프로 올블랙" loading="lazy">
        </div>
        <div class="gallery-item">
            <img src="/data/item/1747209309/thumb-3_800x800.jpg" alt="베나프로 올화이트" loading="lazy">
        </div>
        <div class="gallery-item">
            <img src="/data/item/1719736820/thumb-03_800x800.jpg" alt="베나프로 화이트" loading="lazy">
        </div>
    </div>
    <p class="gallery-caption rv">All Black · All White · White — 색상·스터드는 자유롭게 선택 가능합니다.</p>
</section>

<!-- ③ 캥거루 가죽 -->
<section class="sec sec-black" id="kanguro">
    <div class="inner">
        <p class="eyebrow rv">소재</p>
        <h2 class="sec-title rv d1">세계 최상급 소재,<br>캥거루 가죽을 권장하는 이유.</h2>
        <p class="sec-body rv d2">나이키 Tiempo Legend Elite, 아디다스 Copa Mundial. 세계 정상급 맞춤 축구화가 수십 년째 선택해 온 소재입니다. 리앤양 베나프로에서도 가장 많이 선택되는 어퍼 소재입니다.</p>
        <div class="kang-grid rv d2">
            <div class="kang-block">
                <div class="kang-stat">3<span>배</span></div>
                <div class="kang-label">같은 두께, 3배 강하다</div>
                <div class="kang-desc">단위 두께당 인장 강도가 소가죽의 약 3배입니다. 얇게 가공해도 찢어지지 않아 더 가볍고 얇은 어퍼를 만들 수 있습니다. 볼 터치 민감도가 높아지고 착화감이 극적으로 개선됩니다.</div>
            </div>
            <div class="kang-block">
                <div class="kang-stat">2~3<span>시간</span></div>
                <div class="kang-label">빠르게 발에 길든다</div>
                <div class="kang-desc">섬유 구조가 유연하고 촘촘해 2~3시간 착용만으로 발형에 맞게 변형됩니다. 발형을 실측한 라스트(틀) 위에서 제작되기 때문에 캥거루 가죽을 사용할 때 이 효과가 극대화됩니다.</div>
            </div>
        </div>
        <div class="kang-wide rv d3">
            <div class="kang-wide-title">인조가죽 · 소가죽 · 캥거루 가죽, 무엇이 다른가</div>
            <div class="kang-wide-body">인조가죽은 내구성이 낮고 발에 잘 길들지 않습니다. 소가죽은 천연가죽의 착화감을 주지만 두꺼워 볼 터치가 무뎌집니다. 캥거루 가죽은 얇고 강하면서 유연해, 맞춤 제작 축구화의 성능을 가장 잘 살려주는 소재입니다. 대부분의 고객이 착용 후 재구매 시 캥거루 가죽을 다시 선택합니다.</div>
        </div>
    </div>
</section>

<!-- ④ 가격 -->
<section class="sec sec-white" id="price">
    <div class="inner">
        <p class="eyebrow rv">가격</p>
        <h2 class="sec-title rv d1">어퍼 소재를 선택하세요.</h2>
        <p class="sec-body rv d2">발형 실측, 색상·스터드 커스터마이징, 수제 제작, 전국 배송이 모두 포함된 가격입니다.</p>
        <div class="price-table rv d2">

            <div class="price-row">
                <div>
                    <div class="p-name">인조가죽</div>
                    <div class="p-sub">합성 소재 어퍼</div>
                    <ul class="p-features">
                        <li>FG/AG 겸용 아웃솔</li>
                        <li>발형 실측 맞춤 제작</li>
                        <li>색상·스터드 선택</li>
                    </ul>
                </div>
                <div class="p-amount">
                    <span class="p-amount-num">35</span><span class="p-amount-unit">만원</span>
                </div>
            </div>

            <div class="price-row">
                <div>
                    <div class="p-name">소가죽</div>
                    <div class="p-sub">천연 카프스킨 어퍼</div>
                    <ul class="p-features">
                        <li>FG/AG/SG 아웃솔 선택</li>
                        <li>발형 실측 맞춤 제작</li>
                        <li>색상·스터드 선택</li>
                    </ul>
                </div>
                <div class="p-amount">
                    <span class="p-amount-num">40</span><span class="p-amount-unit">만원</span>
                </div>
            </div>

            <div class="price-row rec">
                <div>
                    <div class="p-name">캥거루 가죽 <span class="p-rec-badge">추천</span></div>
                    <div class="p-sub">세계 최상급 천연가죽 어퍼</div>
                    <ul class="p-features">
                        <li>소가죽 대비 얇고 3배 강한 내구성</li>
                        <li>2~3시간 내 발형에 맞게 길듦</li>
                        <li>FG/AG/SG 아웃솔 선택</li>
                        <li>발형 실측 맞춤 제작</li>
                        <li>색상·스터드 선택</li>
                    </ul>
                </div>
                <div class="p-amount">
                    <span class="p-amount-num">45</span><span class="p-amount-unit">만원</span>
                </div>
            </div>

        </div>
        <p class="price-note rv">색상·스터드 조합은 상담 후 결정합니다. 카카오톡 <strong>21apro</strong>로 언제든 문의해 주세요.</p>
    </div>
</section>

<!-- ⑤ 베나프로 특징 -->
<section class="sec sec-black">
    <div class="inner">
        <p class="eyebrow rv">베나프로 특징</p>
        <h2 class="sec-title rv d1">기성화가 맞지 않는 이유가 있습니다.</h2>
        <p class="sec-body rv d2">대량 생산 축구화는 평균 발형 기준으로 만들어집니다. 베나프로는 당신의 발형 데이터만을 기준으로 처음부터 다시 만듭니다.</p>
        <div class="feat-grid rv d2">
            <div class="feat-block">
                <div class="feat-num">01</div>
                <div class="feat-name">발형 실측 제작</div>
                <div class="feat-desc">발 길이·너비·발등 높이·아치 곡률까지 정밀 측정합니다. 방문 측정 또는 족적지 우편 발송 모두 가능합니다.</div>
            </div>
            <div class="feat-block">
                <div class="feat-num">02</div>
                <div class="feat-name">색상·스터드 선택</div>
                <div class="feat-desc">어퍼 색상, 스터드 패턴(15종), 아웃솔 타입(FG/AG/SG)을 직접 선택합니다. 세상에 하나뿐인 나만의 디자인입니다.</div>
            </div>
            <div class="feat-block">
                <div class="feat-num">03</div>
                <div class="feat-name">한 켤레씩 수작업</div>
                <div class="feat-desc">공장 대량 생산이 아닌 장인이 직접 제작합니다. 라스트(틀)를 발형에 맞게 커스텀해 착화감을 극대화합니다.</div>
            </div>
        </div>
    </div>
</section>

<!-- ⑥ 추천 대상 -->
<section class="sec sec-gray">
    <div class="inner">
        <p class="eyebrow rv">추천 대상</p>
        <h2 class="sec-title rv d1">이런 분들을 위해 만들었습니다.</h2>
        <p class="sec-body rv d2">기성 축구화가 불편한 데는 이유가 있습니다. 발형 문제라면 맞춤 제작이 유일한 해답입니다.</p>
        <ul class="target-list rv d2">
            <li class="target-item"><span class="t-idx">01</span>발볼이 넓어 기성 축구화가 꽉 끼거나 발가락이 눌리는 분</li>
            <li class="target-item"><span class="t-idx">02</span>무지외반증·소건막류 등 발 변형으로 신발 선택이 어려운 분</li>
            <li class="target-item"><span class="t-idx">03</span>발 좌우 사이즈가 달라 항상 한쪽이 맞지 않는 분</li>
            <li class="target-item"><span class="t-idx">04</span>220mm 이하 또는 295mm 이상의 특수 사이즈가 필요한 분</li>
            <li class="target-item"><span class="t-idx">05</span>발등이 높거나 낮아 기성화 착용 시 발이 빠지거나 조이는 분</li>
            <li class="target-item"><span class="t-idx">06</span>나만의 색상과 디자인으로 특별한 축구화를 원하는 선수·동호인</li>
        </ul>
    </div>
</section>

<!-- ⑦ 제작 과정 -->
<section class="sec sec-black">
    <div class="inner">
        <p class="eyebrow rv">제작 과정</p>
        <h2 class="sec-title rv d1">4단계로 완성됩니다.</h2>
        <p class="sec-body rv d2">카카오톡 상담부터 배송까지. 복잡한 절차 없이 진행됩니다.</p>
        <div class="process-row rv d2">
            <div class="proc-block">
                <div class="proc-num">01</div>
                <div class="proc-name">상담·견적</div>
                <div class="proc-desc">카카오톡 21apro로 발 사진 전송. 소재·색상·스터드 상담. 24시간 가능.</div>
            </div>
            <div class="proc-block">
                <div class="proc-num">02</div>
                <div class="proc-name">발형 측정</div>
                <div class="proc-desc">고양시 직접 방문 또는 족적지 우편 발송. 발 전체 치수를 정밀 측정.</div>
            </div>
            <div class="proc-block">
                <div class="proc-num">03</div>
                <div class="proc-name">수제 제작</div>
                <div class="proc-desc">발형 데이터로 라스트 커스텀 후 장인이 직접 수작업 제작. 2~4주 소요.</div>
            </div>
            <div class="proc-block">
                <div class="proc-num">04</div>
                <div class="proc-name">배송·피팅</div>
                <div class="proc-desc">전국 택배 발송. 착용 후 착화감 피팅 상담 및 간단한 수선도 가능.</div>
            </div>
        </div>
    </div>
</section>

<!-- ⑧ FAQ -->
<section class="sec sec-gray">
    <div class="inner">
        <p class="eyebrow rv" style="text-align:center;">FAQ</p>
        <h2 class="sec-title rv d1" style="text-align:center;margin-bottom:40px;">자주 묻는 질문</h2>
        <div class="faq-wrap rv d2">

            <div class="faq-item">
                <button class="faq-q" onclick="toggleFaq(this)">가격이 어떻게 되나요?<span class="faq-arr">&#9660;</span></button>
                <div class="faq-a">어퍼 소재에 따라 다릅니다. <strong>인조가죽 35만원 / 소가죽 40만원 / 캥거루 가죽 45만원</strong>이며, 모두 발형 실측·색상 커스터마이징·수제 제작·전국 배송이 포함된 가격입니다. 대부분의 고객은 착화감과 내구성이 월등한 캥거루 가죽을 선택합니다.</div>
            </div>

            <div class="faq-item">
                <button class="faq-q" onclick="toggleFaq(this)">왜 캥거루 가죽이 더 좋은가요?<span class="faq-arr">&#9660;</span></button>
                <div class="faq-a">캥거루 가죽은 단위 두께당 인장 강도가 소가죽의 약 3배입니다. 얇게 가공해도 내구성이 유지되어 볼 터치 민감도가 높아집니다. 섬유 조직이 유연해 2~3시간 착용만으로 발형에 맞게 길들어, 맞춤 제작과 시너지가 매우 큽니다. 나이키 Tiempo Legend Elite, 아디다스 Copa Mundial 등 세계 최상위 모델이 이 소재를 사용하는 이유입니다.</div>
            </div>

            <div class="faq-item">
                <button class="faq-q" onclick="toggleFaq(this)">발 사진만으로 제작 가능한가요?<span class="faq-arr">&#9660;</span></button>
                <div class="faq-a">카카오톡으로 발 사진(위·옆·앞·뒤)을 보내주시면 기초 상담이 가능합니다. 더 정확한 제작을 위해 <strong>방문 측정</strong>을 권장하며, 방문이 어려운 분은 족적지를 우편으로 보내주시는 방법도 있습니다. 방문 주소: 경기도 고양시 덕양구 서오릉로 433 한우만 3층.</div>
            </div>

            <div class="faq-item">
                <button class="faq-q" onclick="toggleFaq(this)">제작 기간이 얼마나 걸리나요?<span class="faq-arr">&#9660;</span></button>
                <div class="faq-a">보통 <strong>2주에서 4주</strong> 소요됩니다. 주문 현황에 따라 달라질 수 있으며, 상담 시 예상 기간을 정확히 안내드립니다.</div>
            </div>

            <div class="faq-item">
                <button class="faq-q" onclick="toggleFaq(this)">스터드(아웃솔)는 어떻게 선택하나요?<span class="faq-arr">&#9660;</span></button>
                <div class="faq-a">Stud 03번~15번, 총 15가지 패턴 중 선택 가능합니다. 천연 잔디(FG), 인공 잔디(AG), 연식 잔디(SG) 등 주로 사용하는 경기장 환경에 맞춰 상담 후 결정합니다. 스터드 선택에 따른 추가 비용은 없습니다.</div>
            </div>

        </div>
    </div>
</section>

<!-- ⑨ CTA -->
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
    <div style="margin-top:4px;">Tel: <a href="tel:01035477744">010-3547-7744</a> &nbsp;|&nbsp; 카카오톡: 21apro &nbsp;|&nbsp; 우리은행 578-224027-02-003 (이주용)</div>
    <div style="margin-top:12px;">
        <a href="/">홈</a> &nbsp;&middot;&nbsp;
        <a href="/changalyi.php">창갈이 수선</a> &nbsp;&middot;&nbsp;
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
    if (!('IntersectionObserver' in window)) {
        els.forEach(function(e){ e.classList.add('on'); }); return;
    }
    var io = new IntersectionObserver(function(entries) {
        entries.forEach(function(e) {
            if (e.isIntersecting) { e.target.classList.add('on'); io.unobserve(e.target); }
        });
    }, { threshold: 0.08 });
    els.forEach(function(el){ io.observe(el); });
})();
</script>
</body>
</html>
