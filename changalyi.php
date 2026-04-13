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
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="축구화 창갈이 전문 | 풋살화 밑창 교체 | 리앤양">
<meta name="twitter:description" content="나이키·아디다스·미즈노 모든 브랜드 축구화·풋살화 창갈이(뽕갈이), 밑창 교체, 스터드 교체 전문.">
<link rel="canonical" href="https://leeandyang.co.kr/changalyi.php">
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Service",
  "name": "축구화·풋살화 창갈이(뽕갈이) 서비스",
  "provider": {
    "@type": "LocalBusiness",
    "name": "리앤양",
    "description": "맞춤 축구화 제작, 축구화·풋살화 창갈이(뽕갈이), 밑창 교체, 스터드 교체 전문",
    "telephone": "010-3547-7744",
    "address": {
      "@type": "PostalAddress",
      "addressLocality": "경기도 고양시 덕양구",
      "streetAddress": "서오릉로 433 한우만 3층",
      "addressCountry": "KR"
    },
    "url": "https://leeandyang.co.kr"
  },
  "description": "나이키·아디다스·미즈노·퓨마 등 모든 브랜드 축구화·풋살화 창갈이(뽕갈이), 밑창 교체, 스터드 교체 전문 서비스",
  "areaServed": "대한민국",
  "serviceType": ["신발 창갈이", "축구화 창갈이", "풋살화 창갈이", "밑창 교체", "스터드 교체", "스터드 커팅", "운동화 창갈이"]
}
</script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
/* ───────────────────────────────────────────
   Apple HIG 디자인 토큰 (apply.php 동일)
─────────────────────────────────────────── */
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
    --radius-sm: 10px;
    --radius:    14px;
    --radius-lg: 20px;
    --shadow:    0 2px 20px rgba(0,0,0,0.06), 0 1px 4px rgba(0,0,0,0.04);
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

html { scroll-behavior: smooth; }

body {
    font-family: -apple-system, BlinkMacSystemFont, 'Noto Sans KR', 'Apple SD Gothic Neo', sans-serif;
    background: var(--bg);
    color: var(--label);
    -webkit-font-smoothing: antialiased;
    overflow-x: hidden;
}

/* ───────────────────────────────────────────
   네비게이션 바 (apply.php 동일 스타일)
─────────────────────────────────────────── */
.nav {
    position: fixed; top: 0; left: 0; right: 0; z-index: 200;
    height: 52px;
    background: rgba(255,255,255,0.72);
    backdrop-filter: saturate(180%) blur(20px);
    -webkit-backdrop-filter: saturate(180%) blur(20px);
    border-bottom: 0.5px solid var(--separator);
    display: flex; align-items: center; justify-content: space-between;
    padding: 0 24px;
    transition: background 0.3s;
}
.nav-logo {
    font-size: 17px; font-weight: 700;
    letter-spacing: 1.5px; color: var(--label);
    text-decoration: none;
}
.nav-cta {
    font-size: 13px; font-weight: 600;
    color: var(--blue); text-decoration: none;
    padding: 6px 16px;
    border: 1.5px solid var(--blue);
    border-radius: 980px;
    transition: all 0.2s;
}
.nav-cta:hover { background: var(--blue); color: #fff; }

/* ───────────────────────────────────────────
   히어로 — 다크 (apply.php 히어로 동일)
─────────────────────────────────────────── */
.hero {
    background: var(--label);
    color: #fff;
    padding: 120px 24px 80px;
    text-align: center;
    min-height: 480px;
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
}
.hero-eyebrow {
    font-size: 12px; font-weight: 600;
    letter-spacing: 2px; color: #86868B;
    text-transform: uppercase; margin-bottom: 14px;
}
.hero h1 {
    font-size: clamp(32px, 5.5vw, 64px);
    font-weight: 700;
    line-height: 1.12;
    letter-spacing: -0.03em;
    margin-bottom: 18px;
    max-width: 680px;
}
.hero h1 em { color: #86868B; font-style: normal; }
.hero-sub {
    font-size: clamp(15px, 2vw, 19px);
    color: #86868B;
    line-height: 1.6;
    max-width: 480px;
    margin-bottom: 36px;
}
.btn-primary {
    display: inline-block;
    background: var(--blue); color: #fff;
    font-size: 16px; font-weight: 600;
    padding: 14px 32px; border-radius: 980px;
    text-decoration: none;
    transition: background 0.2s, transform 0.15s;
}
.btn-primary:hover { background: var(--blue-dark); transform: scale(1.03); }

/* ───────────────────────────────────────────
   섹션 공통
─────────────────────────────────────────── */
.section {
    padding: 80px 24px;
}
.section.dark {
    background: var(--label);
    color: #fff;
}
.section.white { background: var(--surface); }
.section.gray  { background: var(--bg); }

.section-inner {
    max-width: 900px;
    margin: 0 auto;
}
.section-eyebrow {
    font-size: 12px; font-weight: 600;
    letter-spacing: 2px; text-transform: uppercase;
    color: var(--blue); margin-bottom: 12px;
}
.section.dark .section-eyebrow { color: #86868B; }
.section-title {
    font-size: clamp(26px, 4vw, 44px);
    font-weight: 700;
    line-height: 1.15;
    letter-spacing: -0.025em;
    margin-bottom: 16px;
}
.section-desc {
    font-size: 17px; color: var(--label3);
    line-height: 1.7; max-width: 560px;
    margin-bottom: 48px;
}
.section.dark .section-desc { color: #86868B; }

/* ───────────────────────────────────────────
   서비스 카드 그리드
─────────────────────────────────────────── */
.service-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 16px;
}
.service-card {
    background: var(--surface);
    border-radius: var(--radius-lg);
    padding: 32px 28px;
    box-shadow: var(--shadow);
    transition: transform 0.25s, box-shadow 0.25s;
}
.service-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 40px rgba(0,0,0,0.10);
}
.section.dark .service-card {
    background: #2C2C2E;
    box-shadow: none;
}
.service-icon {
    font-size: 36px; margin-bottom: 16px;
    display: block;
}
.service-name {
    font-size: 17px; font-weight: 700;
    margin-bottom: 8px; color: var(--label);
}
.section.dark .service-name { color: #fff; }
.service-desc {
    font-size: 14px; color: var(--label3);
    line-height: 1.65;
}
.section.dark .service-desc { color: #86868B; }

/* ───────────────────────────────────────────
   브랜드 태그
─────────────────────────────────────────── */
.brand-wrap {
    background: var(--surface);
    border-radius: var(--radius-lg);
    padding: 36px 32px;
    box-shadow: var(--shadow);
}
.brand-intro {
    font-size: 15px; color: var(--label3);
    margin-bottom: 20px;
}
.brand-list {
    display: flex; flex-wrap: wrap; gap: 10px;
}
.brand-tag {
    background: var(--bg);
    border: 1px solid var(--separator);
    color: var(--label2);
    padding: 7px 16px; border-radius: 980px;
    font-size: 14px; font-weight: 500;
}

/* ───────────────────────────────────────────
   진행 과정 (apply.php steps-bar 확장)
─────────────────────────────────────────── */
.process-row {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 0;
    background: var(--surface);
    border-radius: var(--radius-lg);
    overflow: hidden;
    box-shadow: var(--shadow);
}
.process-item {
    padding: 32px 20px;
    text-align: center;
    border-right: 0.5px solid var(--separator);
    position: relative;
}
.process-item:last-child { border-right: none; }
.process-num {
    width: 38px; height: 38px;
    background: var(--label); color: #fff;
    border-radius: 50%; font-weight: 700; font-size: 15px;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 14px;
}
.process-label { font-size: 15px; font-weight: 700; margin-bottom: 6px; }
.process-desc  { font-size: 13px; color: var(--label3); line-height: 1.55; }

/* ───────────────────────────────────────────
   FAQ
─────────────────────────────────────────── */
.faq-list { display: flex; flex-direction: column; gap: 10px; }
.faq-item {
    background: var(--surface);
    border-radius: var(--radius);
    overflow: hidden;
    box-shadow: var(--shadow);
}
.faq-q {
    width: 100%; text-align: left;
    padding: 18px 22px;
    font-size: 15px; font-weight: 600;
    color: var(--label);
    background: none; border: none; cursor: pointer;
    display: flex; justify-content: space-between; align-items: center;
    gap: 12px;
}
.faq-arrow {
    flex-shrink: 0; width: 20px; height: 20px;
    display: flex; align-items: center; justify-content: center;
    border-radius: 50%; background: var(--bg);
    color: var(--label3); font-size: 12px;
    transition: transform 0.2s;
}
.faq-item.open .faq-arrow { transform: rotate(180deg); }
.faq-a {
    display: none;
    padding: 0 22px 18px;
    font-size: 14px; color: var(--label3);
    line-height: 1.7; border-top: 0.5px solid var(--separator);
    padding-top: 14px;
}
.faq-item.open .faq-a { display: block; }

/* ───────────────────────────────────────────
   하단 CTA
─────────────────────────────────────────── */
.cta-block {
    background: var(--label);
    border-radius: var(--radius-lg);
    padding: 52px 36px;
    text-align: center;
    margin: 0 auto;
    max-width: 680px;
}
.cta-title {
    font-size: clamp(22px, 3.5vw, 34px);
    font-weight: 700; color: #fff;
    margin-bottom: 12px; letter-spacing: -0.02em;
}
.cta-desc { font-size: 15px; color: #86868B; margin-bottom: 28px; line-height: 1.6; }
.cta-btn-row { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }
.btn-kakao {
    display: inline-block;
    background: #FEE500; color: #3C1E1E;
    font-size: 15px; font-weight: 700;
    padding: 13px 28px; border-radius: 980px;
    text-decoration: none;
    transition: opacity 0.2s;
}
.btn-kakao:hover { opacity: 0.88; }

/* ───────────────────────────────────────────
   푸터
─────────────────────────────────────────── */
.footer {
    padding: 36px 24px;
    text-align: center;
    font-size: 13px; color: var(--label4);
    border-top: 0.5px solid var(--separator);
    line-height: 1.8;
}
.footer a { color: var(--label3); text-decoration: none; }
.footer a:hover { color: var(--label); }

/* ───────────────────────────────────────────
   스크롤 페이드인 애니메이션
─────────────────────────────────────────── */
.reveal {
    opacity: 0;
    transform: translateY(28px);
    transition: opacity 0.55s ease, transform 0.55s ease;
}
.reveal.visible {
    opacity: 1;
    transform: translateY(0);
}
.reveal-d1 { transition-delay: 0.05s; }
.reveal-d2 { transition-delay: 0.12s; }
.reveal-d3 { transition-delay: 0.19s; }
.reveal-d4 { transition-delay: 0.26s; }

/* ───────────────────────────────────────────
   반응형
─────────────────────────────────────────── */
@media (max-width: 640px) {
    .hero { padding: 100px 20px 60px; min-height: 400px; }
    .section { padding: 56px 20px; }
    .service-grid { grid-template-columns: 1fr; gap: 12px; }
    .process-row  { grid-template-columns: 1fr 1fr; }
    .cta-block { padding: 40px 24px; }
    .brand-wrap { padding: 28px 20px; }
}
@media (max-width: 400px) {
    .process-row { grid-template-columns: 1fr; }
}

/* ───────────────────────────────────────────
   브랜드별 수선 갤러리
─────────────────────────────────────────── */
.brand-tabs {
    display: flex; flex-wrap: wrap; gap: 8px;
    margin-bottom: 24px;
}
.brand-tab {
    padding: 7px 18px;
    border-radius: 980px;
    font-size: 13px; font-weight: 600;
    border: 1.5px solid var(--separator);
    background: none; color: var(--label3);
    cursor: pointer; transition: all 0.18s;
}
.brand-tab.active,
.brand-tab:hover {
    background: var(--label); color: #fff;
    border-color: var(--label);
}
.brand-panel { display: none; }
.brand-panel.active { display: block; }
.gallery-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 10px;
}
.gallery-item {
    aspect-ratio: 1;
    overflow: hidden;
    border-radius: var(--radius);
    background: var(--bg);
    cursor: pointer;
}
.gallery-item img {
    width: 100%; height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.3s ease;
}
.gallery-item:hover img { transform: scale(1.06); }
.gallery-empty {
    color: var(--label4); font-size: 14px;
    padding: 32px 0; text-align: center;
}

/* 라이트박스 */
.lb-overlay {
    display: none; position: fixed;
    inset: 0; z-index: 999;
    background: rgba(0,0,0,0.88);
    align-items: center; justify-content: center;
}
.lb-overlay.open { display: flex; }
.lb-img {
    max-width: 92vw; max-height: 88vh;
    border-radius: var(--radius);
    object-fit: contain;
}
.lb-close {
    position: fixed; top: 18px; right: 22px;
    color: #fff; font-size: 28px; cursor: pointer;
    background: none; border: none; line-height: 1;
    opacity: 0.8;
}
.lb-close:hover { opacity: 1; }

/* 카카오 복사 */
.btn-kakao-copy {
    display: inline-flex; align-items: center; gap: 8px;
    background: #FEE500; color: #3C1E1E;
    font-size: 15px; font-weight: 700;
    padding: 13px 28px; border-radius: 980px;
    border: none; cursor: pointer;
    transition: opacity 0.2s;
}
.btn-kakao-copy:hover { opacity: 0.88; }
.copy-feedback {
    display: none; margin-top: 12px;
    font-size: 13px; color: var(--green);
    font-weight: 600;
}

.load-more-wrap { text-align: center; margin-top: 20px; }
.btn-load-more {
    display: inline-flex; align-items: center; gap: 8px;
    background: rgba(255,255,255,0.08);
    border: 1.5px solid rgba(255,255,255,0.2);
    color: #fff; font-size: 14px; font-weight: 600;
    padding: 11px 28px; border-radius: 980px;
    cursor: pointer; transition: all 0.2s;
}
.btn-load-more:hover { background: rgba(255,255,255,0.15); }
.btn-load-more:disabled { opacity: 0.4; cursor: default; }
.btn-load-more .spinner {
    display: none; width: 14px; height: 14px;
    border: 2px solid rgba(255,255,255,0.3);
    border-top-color: #fff;
    border-radius: 50%;
    animation: spin 0.7s linear infinite;
}
.btn-load-more.loading .spinner { display: block; }
.btn-load-more.loading .btn-load-text { display: none; }
@keyframes spin { to { transform: rotate(360deg); } }

@media (max-width: 640px) {
    .gallery-grid { grid-template-columns: repeat(2, 1fr); gap: 8px; }
    .brand-tab { font-size: 12px; padding: 6px 14px; }
}
</style>
</head>
<body>

<!-- 네비게이션 -->
<nav class="nav">
    <a href="/" class="nav-logo">LEE&amp;YANG</a>
    <a href="/apply.php" class="nav-cta">신청하기</a>
</nav>

<!-- ── 히어로 ── -->
<section class="hero">
    <p class="hero-eyebrow">리앤양 창갈이·수선</p>
    <h1>신발·축구화·풋살화 창갈이,<br><em>전문가에게 맡기세요</em></h1>
    <p class="hero-sub">신발 창갈이(뽕갈이) · 밑창 교체 · 스터드 교체<br>나이키·아디다스·미즈노 등 모든 브랜드 대응 · 전국 택배 접수</p>
    <a href="/apply.php" class="btn-primary">지금 신청하기</a>
</section>

<!-- ── 서비스 종류 (화이트) ── -->
<section class="section white">
    <div class="section-inner">
        <p class="section-eyebrow reveal">서비스</p>
        <h2 class="section-title reveal reveal-d1">어떤 수선이든<br>전문으로 처리합니다</h2>
        <p class="section-desc reveal reveal-d2">신발 창갈이(밑창 교체)부터 스터드 교체, 맞춤 제작까지. 신발 상태에 맞는 최적의 서비스를 안내해드립니다.</p>
        <div class="service-grid">
            <div class="service-card reveal reveal-d1">
                <span class="service-icon">👟</span>
                <div class="service-name">신발·축구화 창갈이(뽕갈이)</div>
                <div class="service-desc">마모·파손된 밑창을 새 것으로 교체. 천연잔디·인조잔디·풋살 용도별 추천.</div>
            </div>
            <div class="service-card reveal reveal-d2">
                <span class="service-icon">🏃</span>
                <div class="service-name">풋살화 창갈이</div>
                <div class="service-desc">실내 전용 고무 밑창으로 교체. 그립력과 쿠셔닝 동시 개선.</div>
            </div>
            <div class="service-card reveal reveal-d3">
                <span class="service-icon">🔩</span>
                <div class="service-name">스터드 교체</div>
                <div class="service-desc">파손된 스터드 개별 교체. FG·SG·AG 모든 타입 대응.</div>
            </div>
            <div class="service-card reveal reveal-d4">
                <span class="service-icon">✂️</span>
                <div class="service-name">스터드 커팅</div>
                <div class="service-desc">높이 기준 초과 스터드를 잔디 규정에 맞게 커팅 가공.</div>
            </div>
        </div>
    </div>
</section>

<!-- ── 가능 브랜드 (회색) ── -->
<section class="section gray">
    <div class="section-inner">
        <p class="section-eyebrow reveal">브랜드</p>
        <h2 class="section-title reveal reveal-d1">모든 브랜드,<br>모두 가능합니다</h2>
        <div class="brand-wrap reveal reveal-d2">
            <p class="brand-intro">국내외 모든 축구화·풋살화 브랜드 수선이 가능합니다.</p>
            <div class="brand-list">
                <span class="brand-tag">나이키 (Nike)</span>
                <span class="brand-tag">아디다스 (Adidas)</span>
                <span class="brand-tag">미즈노 (Mizuno)</span>
                <span class="brand-tag">퓨마 (Puma)</span>
                <span class="brand-tag">아식스 (Asics)</span>
                <span class="brand-tag">뉴발란스 (New Balance)</span>
                <span class="brand-tag">험멜 (Hummel)</span>
                <span class="brand-tag">언더아머 (Under Armour)</span>
                <span class="brand-tag">기타 모든 브랜드</span>
            </div>
        </div>
    </div>
</section>

<!-- ── 진행 과정 (화이트) ── -->
<section class="section white">
    <div class="section-inner">
        <p class="section-eyebrow reveal">진행 과정</p>
        <h2 class="section-title reveal reveal-d1">4단계로 완료되는<br>간단한 프로세스</h2>
        <div class="process-row reveal reveal-d2">
            <div class="process-item">
                <div class="process-num">1</div>
                <div class="process-label">온라인 신청</div>
                <div class="process-desc">사진과 함께<br>신청서 작성</div>
            </div>
            <div class="process-item">
                <div class="process-num">2</div>
                <div class="process-label">견적 안내</div>
                <div class="process-desc">2~4시간 내<br>카카오톡 견적</div>
            </div>
            <div class="process-item">
                <div class="process-num">3</div>
                <div class="process-label">신발 발송</div>
                <div class="process-desc">전국 택배 또는<br>직접 방문</div>
            </div>
            <div class="process-item">
                <div class="process-num">4</div>
                <div class="process-label">수선 완료</div>
                <div class="process-desc">완료 후<br>반송·수령</div>
            </div>
        </div>
    </div>
</section>

<!-- ── FAQ (회색) ── -->
<section class="section gray">
    <div class="section-inner">
        <p class="section-eyebrow reveal">FAQ</p>
        <h2 class="section-title reveal reveal-d1">자주 묻는 질문</h2>
        <div class="faq-list reveal reveal-d2">
            <div class="faq-item">
                <button class="faq-q" onclick="toggleFaq(this)">
                    창갈이(밑창 교체) 비용이 얼마인가요?
                    <span class="faq-arrow">▼</span>
                </button>
                <div class="faq-a">
                    기본 비용은 아래와 같습니다.<br><br>
                    · <strong>밑창 교체</strong> 50,000원~<br>
                    · <strong>중창 교체</strong> +20,000원 (대부분 함께 진행)<br><br>
                    기존 중창은 얇은 원단 소재라 새 밑창과 접착력이 부족합니다. 대부분의 경우 중창도 함께 교체해야 제 성능이 나오며, 중창 교체 시 간단한 사이즈 조정은 <strong>무료</strong>로 함께 진행됩니다.<br><br>
                    연식이 오래된 신발은 어퍼 코팅 상태에 따라 추가 비용(+50,000원)이 발생할 수 있습니다. 사진과 함께 신청해 주시면 정확한 견적을 안내드립니다.
                </div>
            </div>
            <div class="faq-item">
                <button class="faq-q" onclick="toggleFaq(this)">
                    덧댐·스터드 커팅·안감 수선 비용은 얼마인가요?
                    <span class="faq-arrow">▼</span>
                </button>
                <div class="faq-a">
                    · <strong>덧댐(앞코 보호)</strong> — 짧게 20,000원 / 길게 30,000원<br>
                    · <strong>스터드 커팅</strong> — 1켤레 30,000원~<br>
                    · <strong>안감 수선</strong> — 50,000원~ (상태에 따라 상이)<br>
                    · <strong>풋살화 앞코 미싱 처리</strong> — 창갈이 시 무료<br>
                    · <strong>오솔라이트 깔창(인솔)</strong> — 창갈이·수선 시 20,000원에 구매 가능<br>
                    · <strong>쿠션 추가</strong> — 창갈이 시 +50,000원<br><br>
                    위 금액은 예상 기준가이며, 실제 신발 상태 확인 후 정확한 견적을 드립니다.
                </div>
            </div>
            <div class="faq-item">
                <button class="faq-q" onclick="toggleFaq(this)">
                    작업 기간이 얼마나 걸리나요?
                    <span class="faq-arrow">▼</span>
                </button>
                <div class="faq-a">현재 작업 소요 기간은 약 <strong>2주~1달</strong> 정도입니다. 접수 물량에 따라 달라질 수 있으며, 정확한 기간은 견적 안내 시 함께 알려드립니다.</div>
            </div>
            <div class="faq-item">
                <button class="faq-q" onclick="toggleFaq(this)">
                    택배로 신청하는 방법은 어떻게 되나요?
                    <span class="faq-arrow">▼</span>
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
                    <span class="faq-arrow">▼</span>
                </button>
                <div class="faq-a"><strong>방문 전 반드시 예약</strong>이 필요합니다. 카카오톡 <strong>21apro</strong> 또는 문자(010-3547-7744)로 먼저 예약 후 방문해 주세요.<br><br>주소: 경기도 고양시 덕양구 서오릉로 433 한우만 3층</div>
            </div>
            <div class="faq-item">
                <button class="faq-q" onclick="toggleFaq(this)">
                    카카오톡 상담은 언제 가능한가요?
                    <span class="faq-arrow">▼</span>
                </button>
                <div class="faq-a">카카오톡 아이디 <strong>21apro</strong>로 24시간 상담 가능합니다. 전화 상담은 AM 10:00 ~ PM 7:00입니다.</div>
            </div>
        </div>
    </div>
</section>

<!-- ── 브랜드별 수선 사진 (다크) ── -->
<?php if ($gallery): ?>
<section class="section dark">
    <div class="section-inner">
        <p class="section-eyebrow reveal">수선 전후 사진</p>
        <h2 class="section-title reveal reveal-d1">직접 수선한<br>실제 결과물입니다</h2>
        <p class="section-desc reveal reveal-d2">브랜드를 선택하면 해당 창갈이·수선 전후 사진을 볼 수 있습니다.</p>

        <!-- 브랜드 탭 -->
        <div class="brand-tabs reveal reveal-d2">
            <?php $first = true; foreach ($gallery as $table => $data): ?>
            <button class="brand-tab <?= $first ? 'active' : '' ?>"
                    onclick="switchBrand(this, '<?= $table ?>')">
                <?= htmlspecialchars($data['label']) ?>
            </button>
            <?php $first = false; endforeach; ?>
        </div>

        <!-- 브랜드 패널 -->
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

<!-- 라이트박스 -->
<div class="lb-overlay" id="lb" onclick="closeLb()">
    <button class="lb-close" onclick="closeLb()">&times;</button>
    <img class="lb-img" id="lb-img" src="" alt="">
</div>
<?php endif; ?>

<!-- ── 하단 CTA (화이트) ── -->
<section class="section white">
    <div class="section-inner">
        <div class="cta-block reveal">
            <div class="cta-title">지금 바로 신청하세요</div>
            <p class="cta-desc">사진 한 장이면 견적까지 2~4시간<br>카카오톡 21apro · 전화 010-3547-7744</p>
            <div class="cta-btn-row">
                <a href="/apply.php" class="btn-primary">신청서 작성하기</a>
                <button class="btn-kakao-copy" onclick="copyKakaoId()">💬 카카오톡 ID 복사: 21apro</button>
            </div>
            <div class="copy-feedback" id="copy-feedback">✓ 복사됐습니다. 카카오톡에서 21apro 검색해주세요!</div>
        </div>
    </div>
</section>

<!-- 푸터 -->
<footer class="footer">
    <p>리앤양 — 맞춤 축구화 제작 · 창갈이(뽕갈이) · 밑창 교체 · 수선 전문</p>
    <p>경기도 고양시 덕양구 서오릉로 433 한우만 3층 · 010-3547-7744</p>
    <p style="margin-top:10px">
        <a href="/">메인</a> &nbsp;·&nbsp;
        <a href="/apply.php">수선 신청</a> &nbsp;·&nbsp;
        <a href="/page/repair.php">수선 안내</a>
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
    var panel  = document.getElementById('panel-' + brand);
    var grid   = document.getElementById('grid-' + brand);
    var moreWrap = document.getElementById('more-' + brand);
    var btn    = moreWrap ? moreWrap.querySelector('.btn-load-more') : null;
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
                img.src = item.src;
                img.alt = item.alt;
                img.loading = 'lazy';
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
        el.value = id;
        el.style.position = 'fixed'; el.style.opacity = '0';
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
var observer = new IntersectionObserver(function(entries) {
    entries.forEach(function(entry) {
        if (entry.isIntersecting) {
            entry.target.classList.add('visible');
            observer.unobserve(entry.target);
        }
    });
}, { threshold: 0.12 });

document.querySelectorAll('.reveal').forEach(function(el) {
    observer.observe(el);
});
</script>

</body>
</html>
