<?php
/**
 * 축구화·풋살화 창갈이(뽕갈이) 서비스 전용 랜딩 페이지
 * SEO: 축구화 창갈이, 풋살화 창갈이, 밑창 교체, 스터드 교체
 */
define('_GNUBOARD_', true);
require_once dirname(__FILE__) . '/common.php';

// ── AJAX 더 보기 핸들러 ──────────────────────────
if (isset($_GET['ajax']) && $_GET['ajax'] === 'gallery') {
    $allowed = ['nike','adidas','mizuno','puma','asics','newbalance','etc'];
    $brand  = preg_replace('/[^a-z]/', '', strtolower($_GET['brand'] ?? ''));
    $offset = max(0, (int)($_GET['offset'] ?? 4));
    $limit  = 8;

    if (!in_array($brand, $allowed, true)) {
        header('Content-Type: application/json');
        echo json_encode(['items' => [], 'has_more' => false]);
        exit;
    }

    $res = sql_query("
        SELECT f.bf_file, f.bf_width, f.bf_height, w.wr_id
        FROM g5_board_file f
        JOIN g5_write_{$brand} w ON w.wr_id = f.wr_id
        WHERE f.bo_table = '{$brand}' AND f.bf_width > 0 AND w.wr_is_comment = 0
        ORDER BY w.wr_id DESC
        LIMIT " . ($offset + $limit + 1) . "
    ");
    $all = [];
    while ($row = sql_fetch_array($res)) $all[] = $row;
    $slice    = array_slice($all, $offset, $limit);
    $has_more = count($all) > $offset + $limit;

    $items = array_map(function($r) use ($brand) {
        return [
            'src' => '/data/file/' . $brand . '/' . $r['bf_file'],
            'alt' => $brand . ' 축구화 창갈이 수선 전후',
        ];
    }, $slice);

    header('Content-Type: application/json');
    echo json_encode(['items' => $items, 'has_more' => $has_more]);
    exit;
}

// 브랜드별 최신 이미지 조회 (각 브랜드 최대 4장)
$brands = [
    'nike'       => '나이키',
    'adidas'     => '아디다스',
    'mizuno'     => '미즈노',
    'puma'       => '퓨마',
    'asics'      => '아식스',
    'newbalance' => '뉴발란스',
    'etc'        => '기타브랜드',
];
$gallery = [];
foreach ($brands as $table => $label) {
    $res = sql_query("
        SELECT f.bf_file, f.bf_width, f.bf_height, w.wr_id, w.wr_subject
        FROM g5_board_file f
        JOIN g5_write_{$table} w ON w.wr_id = f.wr_id
        WHERE f.bo_table = '{$table}' AND f.bf_width > 0 AND w.wr_is_comment = 0
        ORDER BY w.wr_id DESC
        LIMIT 4
    ");
    $imgs = [];
    while ($row = sql_fetch_array($res)) {
        $imgs[] = $row;
    }
    if ($imgs) {
        $gallery[$table] = ['label' => $label, 'imgs' => $imgs];
    }
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>신발 창갈이 · 축구화 창갈이(뽕갈이) 전문 | 풋살화 밑창 교체 · 스터드 교체 | 리앤양</title>
<meta name="description" content="신발 창갈이·축구화 창갈이(뽕갈이) 전문 리앤양. 나이키·아디다스·미즈노·퓨마 등 모든 브랜드 밑창 교체, 스터드 교체. 전국 택배 접수, 카카오톡 21apro 24시간 상담.">
<meta name="keywords" content="축구화창갈이, 풋살화창갈이, 뽕갈이, 밑창교체, 스터드교체, 스터드커팅, 축구화수선, 나이키창갈이, 아디다스창갈이, 미즈노창갈이, 퓨마창갈이, 리앤양">
<meta property="og:type" content="website">
<meta property="og:site_name" content="리앤양">
<meta property="og:title" content="축구화 창갈이 전문 | 풋살화 밑창 교체 · 스터드 교체 | 리앤양">
<meta property="og:description" content="나이키·아디다스·미즈노 등 모든 브랜드 축구화·풋살화 창갈이(뽕갈이), 밑창 교체, 스터드 교체 전문. 경기도 고양시 리앤양.">
<meta property="og:url" content="https://leeandyang.co.kr/changalyi.php">
<meta property="og:image" content="https://leeandyang.co.kr/thema/Miso-Basic4/main/image/og-image.jpg">
<meta property="og:locale" content="ko_KR">
<link rel="canonical" href="https://leeandyang.co.kr/changalyi.php">
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Service",
  "name": "축구화·풋살화 창갈이(뽕갈이) 서비스",
  "provider": {
    "@type": "LocalBusiness",
    "name": "리앤양",
    "telephone": "010-3547-7744",
    "address": {
      "@type": "PostalAddress",
      "addressLocality": "경기도 고양시 덕양구",
      "streetAddress": "서오릉로 433 한우만 3층",
      "addressCountry": "KR"
    }
  },
  "areaServed": "대한민국",
  "serviceType": ["신발 창갈이", "축구화 창갈이", "풋살화 창갈이", "밑창 교체", "스터드 교체"]
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
/* ── 디자인 토큰 (custom.php 동일) ──────────── */
:root {
    --black:   #000000;
    --gray:    #f5f5f7;
    --white:   #ffffff;
    --label:   #1d1d1f;
    --label2:  #6e6e73;
    --blue:    #0071e3;
    --blue-dk: #2997ff;
    --sep:     rgba(255,255,255,0.12);
    --sep-lt:  rgba(0,0,0,0.08);
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html { scroll-behavior: smooth; }
body {
    font-family: 'SF Pro Text', 'SF Pro Display',
        -apple-system, BlinkMacSystemFont,
        'Pretendard', 'Apple SD Gothic Neo', 'Noto Sans KR', sans-serif;
    background: var(--black);
    color: #fff;
    -webkit-font-smoothing: antialiased;
    overflow-x: hidden;
}

/* ── 네비게이션 — 다크 글래스 ───────────────── */
.nav {
    position: fixed; top: 0; left: 0; right: 0; z-index: 200;
    height: 52px;
    background: rgba(0,0,0,0.80);
    backdrop-filter: saturate(180%) blur(20px);
    -webkit-backdrop-filter: saturate(180%) blur(20px);
    border-bottom: 0.5px solid var(--sep);
    display: flex; align-items: center; justify-content: space-between;
    padding: 0 24px;
}
.nav-logo {
    font-size: 16px; font-weight: 700; letter-spacing: 1.5px;
    color: #fff; text-decoration: none;
}
.nav-back {
    font-size: 13px; color: rgba(255,255,255,0.60);
    text-decoration: none; letter-spacing: -0.2px;
    transition: color 0.2s;
}
.nav-back:hover { color: #fff; }
.nav-cta {
    font-size: 13px; font-weight: 500;
    background: var(--blue); color: #fff;
    padding: 6px 16px; border-radius: 980px;
    text-decoration: none; transition: opacity 0.2s;
}
.nav-cta:hover { opacity: 0.86; }

/* ── 공통 섹션 ───────────────────────────── */
.sec {
    padding: 96px 24px;
}
.sec-black { background: var(--black); }
.sec-gray  { background: var(--gray);  color: var(--label); }
.sec-white { background: var(--white); color: var(--label); }

.inner {
    max-width: 980px;
    margin: 0 auto;
}
.inner-wide {
    max-width: 1200px;
    margin: 0 auto;
}

.eyebrow {
    font-size: 12px; font-weight: 600; letter-spacing: 0.06em;
    color: var(--blue); text-transform: uppercase;
    margin-bottom: 10px;
}
.sec-black .eyebrow { color: rgba(255,255,255,0.40); }

.sec-title {
    font-family: 'SF Pro Display', -apple-system, sans-serif;
    font-size: clamp(28px, 4vw, 52px); font-weight: 600;
    line-height: 1.07; letter-spacing: -0.28px;
    margin-bottom: 16px;
}
.sec-gray .sec-title,
.sec-white .sec-title { color: var(--label); }

.sec-desc {
    font-size: clamp(15px, 1.6vw, 19px); font-weight: 400;
    line-height: 1.5; letter-spacing: -0.374px;
    color: rgba(255,255,255,0.56);
    max-width: 560px; margin-bottom: 52px;
}
.sec-gray .sec-desc,
.sec-white .sec-desc { color: var(--label2); }

/* ── 히어로 ──────────────────────────────── */
.hero {
    background: var(--black);
    min-height: 100vh;
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    text-align: center;
    padding: 120px 24px 80px;
}
.hero-eyebrow {
    font-size: 12px; font-weight: 600; letter-spacing: 0.06em;
    color: rgba(255,255,255,0.40); text-transform: uppercase;
    margin-bottom: 16px;
}
.hero-h1 {
    font-family: 'SF Pro Display', -apple-system, sans-serif;
    font-size: clamp(38px, 6vw, 80px); font-weight: 600;
    line-height: 1.05; letter-spacing: -0.28px;
    color: #fff; margin-bottom: 20px;
    max-width: 780px;
}
.hero-h1 span { color: rgba(255,255,255,0.38); }
.hero-sub {
    font-size: clamp(15px, 1.8vw, 21px); font-weight: 400;
    line-height: 1.5; letter-spacing: -0.374px;
    color: rgba(255,255,255,0.56);
    max-width: 500px; margin-bottom: 40px;
}
.hero-btns {
    display: flex; gap: 12px; flex-wrap: wrap;
    justify-content: center;
}
.btn-blue {
    background: var(--blue); color: #fff;
    font-size: 17px; font-weight: 400; letter-spacing: -0.374px;
    padding: 12px 26px; border-radius: 8px;
    text-decoration: none; transition: opacity 0.2s;
    border: none; cursor: pointer;
}
.btn-blue:hover { opacity: 0.86; }
.btn-pill {
    color: var(--blue-dk); font-size: 17px; font-weight: 400; letter-spacing: -0.374px;
    padding: 11px 22px;
    border: 1px solid rgba(41,151,255,0.45); border-radius: 980px;
    text-decoration: none; background: none; cursor: pointer;
    transition: background 0.2s;
}
.btn-pill:hover { background: rgba(41,151,255,0.10); }

/* ── 서비스 카드 그리드 ────────────────────── */
.svc-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 2px;
    background: var(--sep);
    border-radius: 18px;
    overflow: hidden;
}
.svc-card {
    background: #111111;
    padding: 40px 28px;
    transition: background 0.2s;
}
.svc-card:hover { background: #181818; }
.svc-num {
    font-family: 'SF Pro Display', -apple-system, sans-serif;
    font-size: 13px; font-weight: 600; letter-spacing: 0.06em;
    color: rgba(255,255,255,0.30); margin-bottom: 20px;
}
.svc-name {
    font-size: 17px; font-weight: 600; letter-spacing: -0.3px;
    color: #fff; margin-bottom: 10px; line-height: 1.3;
}
.svc-desc {
    font-size: 14px; color: rgba(255,255,255,0.48);
    line-height: 1.65; letter-spacing: -0.2px;
}

/* ── 가격표 ──────────────────────────────── */
.price-table {
    border-radius: 14px;
    overflow: hidden;
    border: 1px solid var(--sep-lt);
}
.price-row {
    display: flex; align-items: center; justify-content: space-between;
    padding: 20px 28px;
    border-bottom: 0.5px solid var(--sep-lt);
    transition: background 0.15s;
}
.price-row:last-child { border-bottom: none; }
.price-row:hover { background: rgba(0,0,0,0.03); }
.price-row.head {
    background: var(--label); color: #fff;
    font-size: 13px; font-weight: 600;
    letter-spacing: 0.04em; text-transform: uppercase;
}
.price-row.head:hover { background: var(--label); }
.price-name {
    font-size: 15px; font-weight: 500; color: var(--label);
    letter-spacing: -0.2px;
}
.price-detail {
    font-size: 13px; color: var(--label2);
    margin-top: 3px; line-height: 1.5;
}
.price-val {
    font-family: 'SF Pro Display', -apple-system, sans-serif;
    font-size: 17px; font-weight: 600;
    color: var(--label); white-space: nowrap;
    letter-spacing: -0.3px;
}
.price-free { color: var(--blue); }
.price-note {
    font-size: 13px; color: var(--label2);
    margin-top: 16px; line-height: 1.7;
    padding: 0 4px;
}

/* ── 브랜드 목록 ─────────────────────────── */
.brand-grid {
    display: flex; flex-wrap: wrap; gap: 10px;
}
.brand-pill {
    background: rgba(255,255,255,0.07);
    border: 0.5px solid rgba(255,255,255,0.15);
    color: rgba(255,255,255,0.80);
    padding: 8px 18px; border-radius: 980px;
    font-size: 14px; letter-spacing: -0.2px;
}

/* ── 진행 과정 ───────────────────────────── */
.process-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 2px;
    background: var(--sep-lt);
    border-radius: 18px;
    overflow: hidden;
}
.process-item {
    background: #fff;
    padding: 36px 24px;
    text-align: left;
}
.process-num {
    font-family: 'SF Pro Display', -apple-system, sans-serif;
    font-size: 13px; font-weight: 600; letter-spacing: 0.06em;
    color: var(--blue); margin-bottom: 16px;
}
.process-title {
    font-size: 17px; font-weight: 600;
    color: var(--label); margin-bottom: 8px;
    letter-spacing: -0.3px;
}
.process-desc {
    font-size: 14px; color: var(--label2);
    line-height: 1.65; letter-spacing: -0.2px;
}

/* ── 갤러리 ──────────────────────────────── */
.brand-tabs {
    display: flex; flex-wrap: wrap; gap: 8px;
    margin-bottom: 28px;
}
.brand-tab {
    padding: 7px 18px; border-radius: 980px;
    font-size: 13px; font-weight: 500; letter-spacing: -0.2px;
    border: 0.5px solid rgba(255,255,255,0.20);
    background: none; color: rgba(255,255,255,0.55);
    cursor: pointer; transition: all 0.18s;
}
.brand-tab.active,
.brand-tab:hover {
    background: #fff; color: var(--label);
    border-color: #fff;
}
.brand-panel { display: none; }
.brand-panel.active { display: block; }
.gallery-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 3px;
}
.gallery-item {
    aspect-ratio: 1; overflow: hidden;
    border-radius: 4px;
    background: #1c1c1e;
    cursor: pointer;
}
.gallery-item img {
    width: 100%; height: 100%;
    object-fit: cover; display: block;
    transition: transform 0.3s ease;
}
.gallery-item:hover img { transform: scale(1.06); }
.gallery-empty {
    color: rgba(255,255,255,0.30); font-size: 14px;
    padding: 40px 0; text-align: center;
}

.load-more-wrap { text-align: center; margin-top: 24px; }
.btn-load-more {
    display: inline-flex; align-items: center; gap: 8px;
    background: rgba(255,255,255,0.07);
    border: 0.5px solid rgba(255,255,255,0.20);
    color: rgba(255,255,255,0.70); font-size: 14px; font-weight: 500;
    padding: 11px 28px; border-radius: 980px;
    cursor: pointer; transition: all 0.2s;
}
.btn-load-more:hover { background: rgba(255,255,255,0.12); color: #fff; }
.btn-load-more:disabled { opacity: 0.35; cursor: default; }
.spinner {
    display: none; width: 14px; height: 14px;
    border: 2px solid rgba(255,255,255,0.25);
    border-top-color: #fff; border-radius: 50%;
    animation: spin 0.7s linear infinite;
}
.btn-load-more.loading .spinner { display: block; }
.btn-load-more.loading .btn-load-text { display: none; }
@keyframes spin { to { transform: rotate(360deg); } }

/* ── 라이트박스 ───────────────────────────── */
.lb-overlay {
    display: none; position: fixed;
    inset: 0; z-index: 999;
    background: rgba(0,0,0,0.92);
    align-items: center; justify-content: center;
}
.lb-overlay.open { display: flex; }
.lb-img {
    max-width: 92vw; max-height: 88vh;
    border-radius: 12px; object-fit: contain;
}
.lb-close {
    position: fixed; top: 18px; right: 22px;
    color: rgba(255,255,255,0.70); font-size: 28px; cursor: pointer;
    background: none; border: none; line-height: 1;
}
.lb-close:hover { color: #fff; }

/* ── FAQ ─────────────────────────────────── */
.faq-list { display: flex; flex-direction: column; gap: 1px; }
.faq-item {
    background: #fff;
    overflow: hidden;
}
.faq-item:first-child { border-radius: 14px 14px 0 0; }
.faq-item:last-child  { border-radius: 0 0 14px 14px; }
.faq-q {
    width: 100%; text-align: left;
    padding: 20px 24px;
    font-size: 15px; font-weight: 500; letter-spacing: -0.2px;
    color: var(--label); background: none; border: none; cursor: pointer;
    display: flex; justify-content: space-between; align-items: center; gap: 16px;
}
.faq-chevron {
    flex-shrink: 0; width: 22px; height: 22px;
    border-radius: 50%;
    background: var(--gray);
    display: flex; align-items: center; justify-content: center;
    transition: transform 0.22s, background 0.2s;
}
.faq-chevron svg { display: block; transition: transform 0.22s; }
.faq-item.open .faq-chevron { background: var(--label); }
.faq-item.open .faq-chevron svg { transform: rotate(180deg); }
.faq-item.open .faq-chevron path { stroke: #fff; }
.faq-a {
    display: none;
    padding: 0 24px 20px;
    font-size: 14px; color: var(--label2);
    line-height: 1.75; letter-spacing: -0.2px;
    border-top: 0.5px solid rgba(0,0,0,0.06);
    padding-top: 16px;
}
.faq-item.open .faq-a { display: block; }

/* ── 하단 CTA ─────────────────────────────── */
.cta-sec {
    background: var(--black);
    padding: 100px 24px;
    text-align: center;
}
.cta-title {
    font-family: 'SF Pro Display', -apple-system, sans-serif;
    font-size: clamp(28px, 4vw, 52px); font-weight: 600;
    line-height: 1.07; letter-spacing: -0.28px;
    color: #fff; margin-bottom: 14px;
}
.cta-sub {
    font-size: clamp(15px, 1.6vw, 19px); color: rgba(255,255,255,0.50);
    letter-spacing: -0.374px; line-height: 1.5;
    margin-bottom: 36px;
}
.btn-kakao {
    display: inline-flex; align-items: center; gap: 8px;
    background: #FEE500; color: #3C1E1E;
    font-size: 15px; font-weight: 700;
    padding: 12px 26px; border-radius: 980px;
    border: none; cursor: pointer; transition: opacity 0.2s;
    text-decoration: none;
}
.btn-kakao:hover { opacity: 0.88; }
.cta-btns { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }
.copy-feedback {
    display: none; margin-top: 14px;
    font-size: 13px; color: rgba(255,255,255,0.50);
}

/* ── 푸터 ────────────────────────────────── */
.footer {
    padding: 36px 24px; text-align: center;
    font-size: 13px; color: rgba(255,255,255,0.28);
    border-top: 0.5px solid var(--sep); line-height: 1.9;
}
.footer a { color: rgba(255,255,255,0.40); text-decoration: none; }
.footer a:hover { color: rgba(255,255,255,0.80); }

/* ── 스크롤 애니메이션 ────────────────────── */
.rv {
    opacity: 0; transform: translateY(24px);
    transition: opacity 0.55s ease, transform 0.55s ease;
}
.rv.visible { opacity: 1; transform: translateY(0); }
.d1 { transition-delay: 0.06s; }
.d2 { transition-delay: 0.13s; }
.d3 { transition-delay: 0.20s; }
.d4 { transition-delay: 0.27s; }

/* ── 반응형 ──────────────────────────────── */
@media (max-width: 860px) {
    .svc-grid     { grid-template-columns: repeat(2, 1fr); }
    .process-grid { grid-template-columns: repeat(2, 1fr); }
    .gallery-grid { grid-template-columns: repeat(3, 1fr); }
}
@media (max-width: 640px) {
    .sec          { padding: 64px 20px; }
    .hero         { padding: 100px 20px 64px; }
    .svc-grid     { grid-template-columns: 1fr; }
    .process-grid { grid-template-columns: 1fr; }
    .gallery-grid { grid-template-columns: repeat(2, 1fr); }
    .price-row    { padding: 16px 20px; }
    .cta-sec      { padding: 72px 20px; }
    .hero-btns    { flex-direction: column; align-items: center; }
}
</style>
</head>
<body>

<!-- 네비게이션 -->
<nav class="nav">
    <a href="/" class="nav-logo">LEE&amp;YANG</a>
    <a href="/custom.php" class="nav-back">맞춤 축구화 &rsaquo;</a>
    <a href="/apply.php" class="nav-cta">신청하기</a>
</nav>

<!-- ① HERO -->
<section class="hero">
    <p class="hero-eyebrow rv">리앤양 창갈이·수선</p>
    <h1 class="hero-h1 rv d1">헌 신발을 새것처럼.<br><span>창갈이 전문 리앤양.</span></h1>
    <p class="hero-sub rv d2">밑창 교체·스터드 교체·안감 수선<br>나이키·아디다스·미즈노 등 모든 브랜드 · 전국 택배 접수</p>
    <div class="hero-btns rv d3">
        <a href="/apply.php" class="btn-blue">지금 신청하기</a>
        <a href="#price" class="btn-pill">가격 확인하기</a>
    </div>
</section>

<!-- ② 서비스 4종 -->
<section class="sec sec-black">
    <div class="inner">
        <p class="eyebrow rv">서비스</p>
        <h2 class="sec-title rv d1">어떤 수선이든<br>전문으로 처리합니다</h2>
        <p class="sec-desc rv d2">신발 창갈이(밑창 교체)부터 스터드 교체, 안감 수선까지.<br>신발 상태에 맞는 최적의 서비스를 안내해드립니다.</p>
        <div class="svc-grid rv d2">
            <div class="svc-card">
                <div class="svc-num">01</div>
                <div class="svc-name">신발·축구화<br>창갈이(뽕갈이)</div>
                <div class="svc-desc">마모·파손된 밑창을 새 것으로 교체. 천연잔디·인조잔디·풋살 용도별 최적 밑창 추천.</div>
            </div>
            <div class="svc-card">
                <div class="svc-num">02</div>
                <div class="svc-name">풋살화<br>창갈이</div>
                <div class="svc-desc">실내 전용 고무 밑창으로 교체. 그립력과 쿠셔닝 동시 개선. 앞코 미싱 처리 무료.</div>
            </div>
            <div class="svc-card">
                <div class="svc-num">03</div>
                <div class="svc-name">스터드 교체<br>&amp; 커팅</div>
                <div class="svc-desc">파손된 스터드 개별 교체. FG·SG·AG 모든 타입. 높이 초과 스터드는 규정에 맞게 커팅.</div>
            </div>
            <div class="svc-card">
                <div class="svc-num">04</div>
                <div class="svc-name">안감·덧댐<br>수선</div>
                <div class="svc-desc">닳은 안감 교체, 앞코 덧댐 보강. 오래된 신발도 착화감을 새것처럼 되살립니다.</div>
            </div>
        </div>
    </div>
</section>

<!-- ③ 가격표 -->
<section class="sec sec-gray" id="price">
    <div class="inner">
        <p class="eyebrow rv">가격</p>
        <h2 class="sec-title rv d1">명확한 가격,<br>숨겨진 비용 없음</h2>
        <p class="sec-desc rv d2">아래는 기준 가격이며, 신발 상태에 따라 정확한 견적을 별도로 안내드립니다.</p>
        <div class="price-table rv d2">
            <div class="price-row head">
                <span>서비스</span>
                <span>기준가</span>
            </div>
            <div class="price-row">
                <div>
                    <div class="price-name">밑창 교체 (창갈이)</div>
                    <div class="price-detail">마모·파손 밑창 → 새 밑창으로 교체</div>
                </div>
                <div class="price-val">50,000원~</div>
            </div>
            <div class="price-row">
                <div>
                    <div class="price-name">중창 교체</div>
                    <div class="price-detail">밑창 교체 시 함께 진행 권장 (접착력 향상)</div>
                </div>
                <div class="price-val">+20,000원</div>
            </div>
            <div class="price-row">
                <div>
                    <div class="price-name">덧댐 (앞코 보호)</div>
                    <div class="price-detail">짧게 / 길게</div>
                </div>
                <div class="price-val">20,000 / 30,000원</div>
            </div>
            <div class="price-row">
                <div>
                    <div class="price-name">스터드 커팅</div>
                    <div class="price-detail">잔디 규정 초과 스터드 가공</div>
                </div>
                <div class="price-val">30,000원~</div>
            </div>
            <div class="price-row">
                <div>
                    <div class="price-name">안감 수선</div>
                    <div class="price-detail">닳은 내부 안감 교체</div>
                </div>
                <div class="price-val">50,000원~</div>
            </div>
            <div class="price-row">
                <div>
                    <div class="price-name">쿠션 추가</div>
                    <div class="price-detail">창갈이 진행 시 추가 가능</div>
                </div>
                <div class="price-val">+50,000원</div>
            </div>
            <div class="price-row">
                <div>
                    <div class="price-name">풋살화 앞코 미싱 처리</div>
                    <div class="price-detail">창갈이 진행 시</div>
                </div>
                <div class="price-val price-free">무료</div>
            </div>
        </div>
        <p class="price-note rv d3">* 연식이 오래된 신발은 어퍼 코팅 상태에 따라 추가 비용(+50,000원)이 발생할 수 있습니다.<br>* 사진과 함께 신청하시면 2~4시간 내 정확한 견적을 안내드립니다.</p>
    </div>
</section>

<!-- ④ 가능 브랜드 -->
<section class="sec sec-black">
    <div class="inner">
        <p class="eyebrow rv">브랜드</p>
        <h2 class="sec-title rv d1">모든 브랜드,<br>모두 가능합니다</h2>
        <p class="sec-desc rv d2">국내외 모든 축구화·풋살화 브랜드 수선이 가능합니다.</p>
        <div class="brand-grid rv d2">
            <span class="brand-pill">나이키 (Nike)</span>
            <span class="brand-pill">아디다스 (Adidas)</span>
            <span class="brand-pill">미즈노 (Mizuno)</span>
            <span class="brand-pill">퓨마 (Puma)</span>
            <span class="brand-pill">아식스 (Asics)</span>
            <span class="brand-pill">뉴발란스 (New Balance)</span>
            <span class="brand-pill">험멜 (Hummel)</span>
            <span class="brand-pill">언더아머 (Under Armour)</span>
            <span class="brand-pill">그 외 모든 브랜드</span>
        </div>
    </div>
</section>

<!-- ⑤ 진행 과정 -->
<section class="sec sec-white">
    <div class="inner">
        <p class="eyebrow rv">진행 과정</p>
        <h2 class="sec-title rv d1">4단계로 완료되는<br>간단한 프로세스</h2>
        <div class="process-grid rv d2">
            <div class="process-item">
                <div class="process-num">STEP 01</div>
                <div class="process-title">온라인 신청</div>
                <div class="process-desc">신청서에 신발 사진을 첨부해 접수. 카카오톡 21apro로 사진만 보내도 됩니다.</div>
            </div>
            <div class="process-item">
                <div class="process-num">STEP 02</div>
                <div class="process-title">견적 안내</div>
                <div class="process-desc">2~4시간 내 카카오톡으로 정확한 견적과 작업 기간을 안내드립니다.</div>
            </div>
            <div class="process-item">
                <div class="process-num">STEP 03</div>
                <div class="process-title">신발 발송</div>
                <div class="process-desc">전국 택배로 발송하거나 고양시 매장에 직접 방문(예약 필수)하실 수 있습니다.</div>
            </div>
            <div class="process-item">
                <div class="process-num">STEP 04</div>
                <div class="process-title">수선 완료 · 반송</div>
                <div class="process-desc">수선 완료 후 사진으로 결과를 공유하고, 전국 택배로 반송해드립니다.</div>
            </div>
        </div>
    </div>
</section>

<!-- ⑥ 브랜드별 수선 사진 -->
<?php if ($gallery): ?>
<section class="sec sec-black">
    <div class="inner-wide">
        <p class="eyebrow rv">수선 전후 사진</p>
        <h2 class="sec-title rv d1">직접 수선한<br>실제 결과물입니다</h2>
        <p class="sec-desc rv d2">브랜드를 선택하면 해당 창갈이·수선 전후 사진을 볼 수 있습니다.</p>

        <div class="brand-tabs rv d2">
            <?php $first = true; foreach ($gallery as $table => $data): ?>
            <button class="brand-tab <?= $first ? 'active' : '' ?>"
                    onclick="switchBrand(this, '<?= $table ?>')">
                <?= htmlspecialchars($data['label']) ?>
            </button>
            <?php $first = false; endforeach; ?>
        </div>

        <?php $first = true; foreach ($gallery as $table => $data): ?>
        <div class="brand-panel <?= $first ? 'active' : '' ?>" id="panel-<?= $table ?>"
             data-brand="<?= $table ?>" data-offset="4">
            <?php if ($data['imgs']): ?>
            <div class="gallery-grid" id="grid-<?= $table ?>">
                <?php foreach ($data['imgs'] as $img): ?>
                <div class="gallery-item" onclick="openLb('/data/file/<?= $table ?>/<?= htmlspecialchars($img['bf_file']) ?>')">
                    <img src="/data/file/<?= $table ?>/<?= htmlspecialchars($img['bf_file']) ?>"
                         alt="<?= htmlspecialchars($data['label']) ?> 축구화 창갈이 수선 전후"
                         loading="lazy">
                </div>
                <?php endforeach; ?>
            </div>
            <div class="load-more-wrap" id="more-<?= $table ?>">
                <button class="btn-load-more" onclick="loadMore('<?= $table ?>')">
                    <span class="spinner"></span>
                    <span class="btn-load-text">더 보기</span>
                </button>
            </div>
            <?php else: ?>
            <div class="gallery-empty">사진을 준비 중입니다.</div>
            <?php endif; ?>
        </div>
        <?php $first = false; endforeach; ?>
    </div>
</section>

<div class="lb-overlay" id="lb" onclick="closeLb()">
    <button class="lb-close" onclick="closeLb()">&times;</button>
    <img class="lb-img" id="lb-img" src="" alt="">
</div>
<?php endif; ?>

<!-- ⑦ FAQ -->
<section class="sec sec-gray">
    <div class="inner">
        <p class="eyebrow rv">FAQ</p>
        <h2 class="sec-title rv d1">자주 묻는 질문</h2>
        <div class="faq-list rv d2">
            <div class="faq-item">
                <button class="faq-q" onclick="toggleFaq(this)">
                    창갈이(밑창 교체) 비용이 얼마인가요?
                    <span class="faq-chevron"><svg width="11" height="7" viewBox="0 0 11 7" fill="none"><path d="M1 1l4.5 4.5L10 1" stroke="#1d1d1f" stroke-width="1.5" stroke-linecap="round"/></svg></span>
                </button>
                <div class="faq-a">
                    기본 비용은 아래와 같습니다.<br><br>
                    &middot; <strong>밑창 교체</strong> 50,000원~<br>
                    &middot; <strong>중창 교체</strong> +20,000원 (대부분 함께 진행)<br><br>
                    기존 중창은 얇은 원단 소재라 새 밑창과 접착력이 부족합니다. 대부분의 경우 중창도 함께 교체해야 제 성능이 나오며, 중창 교체 시 간단한 사이즈 조정은 <strong>무료</strong>로 함께 진행됩니다.<br><br>
                    연식이 오래된 신발은 어퍼 코팅 상태에 따라 추가 비용(+50,000원)이 발생할 수 있습니다. 사진과 함께 신청해 주시면 정확한 견적을 안내드립니다.
                </div>
            </div>
            <div class="faq-item">
                <button class="faq-q" onclick="toggleFaq(this)">
                    덧댐·스터드 커팅·안감 수선 비용은 얼마인가요?
                    <span class="faq-chevron"><svg width="11" height="7" viewBox="0 0 11 7" fill="none"><path d="M1 1l4.5 4.5L10 1" stroke="#1d1d1f" stroke-width="1.5" stroke-linecap="round"/></svg></span>
                </button>
                <div class="faq-a">
                    &middot; <strong>덧댐(앞코 보호)</strong> — 짧게 20,000원 / 길게 30,000원<br>
                    &middot; <strong>스터드 커팅</strong> — 1켤레 30,000원~<br>
                    &middot; <strong>안감 수선</strong> — 50,000원~ (상태에 따라 상이)<br>
                    &middot; <strong>풋살화 앞코 미싱 처리</strong> — 창갈이 시 무료<br>
                    &middot; <strong>오솔라이트 깔창(인솔)</strong> — 창갈이·수선 시 20,000원에 구매 가능<br>
                    &middot; <strong>쿠션 추가</strong> — 창갈이 시 +50,000원<br><br>
                    위 금액은 예상 기준가이며, 실제 신발 상태 확인 후 정확한 견적을 드립니다.
                </div>
            </div>
            <div class="faq-item">
                <button class="faq-q" onclick="toggleFaq(this)">
                    작업 기간이 얼마나 걸리나요?
                    <span class="faq-chevron"><svg width="11" height="7" viewBox="0 0 11 7" fill="none"><path d="M1 1l4.5 4.5L10 1" stroke="#1d1d1f" stroke-width="1.5" stroke-linecap="round"/></svg></span>
                </button>
                <div class="faq-a">현재 작업 소요 기간은 약 <strong>2주~1달</strong> 정도입니다. 접수 물량에 따라 달라질 수 있으며, 정확한 기간은 견적 안내 시 함께 알려드립니다.</div>
            </div>
            <div class="faq-item">
                <button class="faq-q" onclick="toggleFaq(this)">
                    택배로 신청하는 방법은 어떻게 되나요?
                    <span class="faq-chevron"><svg width="11" height="7" viewBox="0 0 11 7" fill="none"><path d="M1 1l4.5 4.5L10 1" stroke="#1d1d1f" stroke-width="1.5" stroke-linecap="round"/></svg></span>
                </button>
                <div class="faq-a">
                    1. 온라인 신청 또는 카카오톡으로 먼저 견적 확인<br>
                    2. 택배 상자에 <strong>성함·연락처·주소·수선 요청사항</strong>을 메모해 동봉<br>
                    3. 아래 주소로 발송<br><br>
                    <strong>경기도 고양시 덕양구 서오릉로 433 한우만 3층 (리앤양)</strong><br><br>
                    택배 도착 후 입금 안내를 드리며, 입금 확인 후 작업이 시작됩니다. 완료 후 반송해 드립니다.
                </div>
            </div>
            <div class="faq-item">
                <button class="faq-q" onclick="toggleFaq(this)">
                    방문도 가능한가요?
                    <span class="faq-chevron"><svg width="11" height="7" viewBox="0 0 11 7" fill="none"><path d="M1 1l4.5 4.5L10 1" stroke="#1d1d1f" stroke-width="1.5" stroke-linecap="round"/></svg></span>
                </button>
                <div class="faq-a"><strong>방문 전 반드시 예약</strong>이 필요합니다. 카카오톡 <strong>21apro</strong> 또는 문자(010-3547-7744)로 먼저 예약 후 방문해 주세요.<br><br>주소: 경기도 고양시 덕양구 서오릉로 433 한우만 3층</div>
            </div>
            <div class="faq-item">
                <button class="faq-q" onclick="toggleFaq(this)">
                    카카오톡 상담은 언제 가능한가요?
                    <span class="faq-chevron"><svg width="11" height="7" viewBox="0 0 11 7" fill="none"><path d="M1 1l4.5 4.5L10 1" stroke="#1d1d1f" stroke-width="1.5" stroke-linecap="round"/></svg></span>
                </button>
                <div class="faq-a">카카오톡 아이디 <strong>21apro</strong>로 24시간 상담 가능합니다. 전화 상담은 AM 10:00 ~ PM 7:00입니다.</div>
            </div>
        </div>
    </div>
</section>

<!-- ⑧ 하단 CTA -->
<section class="cta-sec">
    <div class="inner">
        <p class="eyebrow" style="justify-content:center;display:block;text-align:center;color:rgba(255,255,255,0.38);margin-bottom:12px;">지금 시작하세요</p>
        <h2 class="cta-title rv">사진 한 장이면<br>견적까지 2~4시간</h2>
        <p class="cta-sub rv d1">카카오톡 21apro · 전화 010-3547-7744</p>
        <div class="cta-btns rv d2">
            <a href="/apply.php" class="btn-blue">신청서 작성하기</a>
            <button class="btn-kakao" onclick="copyKakaoId()">
                <svg width="18" height="18" viewBox="0 0 18 18" fill="none"><path d="M9 1.5C4.86 1.5 1.5 4.14 1.5 7.38c0 2.04 1.2 3.84 3.03 4.92l-.75 2.79 3.21-2.1c.66.12 1.32.18 2.01.18 4.14 0 7.5-2.64 7.5-5.88S13.14 1.5 9 1.5z" fill="#3C1E1E"/></svg>
                카카오톡 ID 복사: 21apro
            </button>
        </div>
        <div class="copy-feedback" id="copy-feedback">복사됐습니다. 카카오톡에서 21apro 를 검색해주세요.</div>
    </div>
</section>

<!-- 푸터 -->
<footer class="footer">
    <p>리앤양 — 맞춤 축구화 제작 · 창갈이(뽕갈이) · 밑창 교체 · 수선 전문</p>
    <p>경기도 고양시 덕양구 서오릉로 433 한우만 3층 · 010-3547-7744</p>
    <p style="margin-top:10px">
        <a href="/">홈</a> &nbsp;&middot;&nbsp;
        <a href="/custom.php">맞춤 축구화</a> &nbsp;&middot;&nbsp;
        <a href="/apply.php">수선 신청</a>
    </p>
</footer>

<script>
/* FAQ 토글 */
function toggleFaq(btn) {
    var item = btn.closest('.faq-item');
    var isOpen = item.classList.contains('open');
    document.querySelectorAll('.faq-item.open').forEach(function(el) {
        el.classList.remove('open');
    });
    if (!isOpen) item.classList.add('open');
}

/* 브랜드 탭 전환 */
function switchBrand(tabEl, table) {
    document.querySelectorAll('.brand-tab').forEach(function(t) { t.classList.remove('active'); });
    document.querySelectorAll('.brand-panel').forEach(function(p) { p.classList.remove('active'); });
    tabEl.classList.add('active');
    var panel = document.getElementById('panel-' + table);
    if (panel) panel.classList.add('active');
}

/* 더 보기 */
function loadMore(brand) {
    var panel    = document.getElementById('panel-' + brand);
    var grid     = document.getElementById('grid-' + brand);
    var moreWrap = document.getElementById('more-' + brand);
    var btn      = moreWrap ? moreWrap.querySelector('.btn-load-more') : null;
    if (!btn || btn.disabled) return;

    var offset = parseInt(panel.dataset.offset, 10) || 4;
    btn.classList.add('loading');
    btn.disabled = true;

    fetch('/changalyi.php?ajax=gallery&brand=' + brand + '&offset=' + offset)
        .then(function(r) { return r.json(); })
        .then(function(data) {
            data.items.forEach(function(item) {
                var div = document.createElement('div');
                div.className = 'gallery-item';
                div.onclick = function() { openLb(item.src); };
                var img = document.createElement('img');
                img.src = item.src; img.alt = item.alt; img.loading = 'lazy';
                div.appendChild(img);
                grid.appendChild(div);
            });
            panel.dataset.offset = offset + data.items.length;
            btn.classList.remove('loading');
            if (!data.has_more) {
                moreWrap.style.display = 'none';
            } else {
                btn.disabled = false;
            }
        })
        .catch(function() {
            btn.classList.remove('loading');
            btn.disabled = false;
        });
}

/* 라이트박스 */
function openLb(src) {
    document.getElementById('lb-img').src = src;
    document.getElementById('lb').classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeLb() {
    document.getElementById('lb').classList.remove('open');
    document.getElementById('lb-img').src = '';
    document.body.style.overflow = '';
}
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeLb();
});

/* 카카오톡 ID 복사 */
function copyKakaoId() {
    var id = '21apro';
    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(id).then(showCopyFeedback);
    } else {
        var el = document.createElement('textarea');
        el.value = id; el.style.position = 'fixed'; el.style.opacity = '0';
        document.body.appendChild(el);
        el.focus(); el.select();
        document.execCommand('copy');
        document.body.removeChild(el);
        showCopyFeedback();
    }
}
function showCopyFeedback() {
    var fb = document.getElementById('copy-feedback');
    fb.style.display = 'block';
    setTimeout(function() { fb.style.display = 'none'; }, 3000);
}

/* 스크롤 페이드인 */
var obs = new IntersectionObserver(function(entries) {
    entries.forEach(function(e) {
        if (e.isIntersecting) {
            e.target.classList.add('visible');
            obs.unobserve(e.target);
        }
    });
}, { threshold: 0.10 });

document.querySelectorAll('.rv').forEach(function(el) { obs.observe(el); });
</script>

</body>
</html>
