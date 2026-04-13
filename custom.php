<?php
/**
 * 맞춤 축구화 제작 전용 랜딩 페이지
 * SEO: 맞춤축구화, 수제축구화, 발볼 넓은 축구화, 개인맞춤축구화
 */
define('_GNUBOARD_', true);
require_once dirname(__FILE__) . '/common.php';
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>맞춤 축구화 제작 전문 | 수제축구화 · 발볼 넓은 축구화 | 리앤양</title>
<meta name="description" content="나만의 맞춤 축구화 제작 전문 리앤양. 캥거루 가죽 최상급 어퍼, 발볼 넓은 분·무지외반증·특수 발형 모두 가능. 베나프로 350,000원~, 2주 완성. 카카오톡 21apro 24시간 상담.">
<meta name="keywords" content="맞춤축구화, 수제축구화, 개인맞춤축구화, 발볼넓은축구화, 와이드핏축구화, 맞춤축구화제작, 수제축구화제작, 리앤양">
<meta property="og:type" content="website">
<meta property="og:site_name" content="리앤양">
<meta property="og:title" content="맞춤 축구화 제작 전문 리앤양 | 수제 핸드메이드 · 발볼 넓은 축구화">
<meta property="og:description" content="나만의 발형으로 만드는 수제 맞춤 축구화. 발볼 넓은 분, 무지외반증, 특수 발형 모두 대응. 35만원, 2주 완성.">
<meta property="og:url" content="https://leeandyang.co.kr/custom.php">
<meta property="og:image" content="https://leeandyang.co.kr/thema/Miso-Basic4/main/image/og-image.jpg">
<link rel="canonical" href="https://leeandyang.co.kr/custom.php">
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Product",
  "name": "맞춤 축구화 베나프로",
  "description": "발형을 실측해 수제로 제작하는 핸드메이드 맞춤 축구화. 발볼 넓은 분, 무지외반증, 특수 발형 모두 제작 가능.",
  "brand": { "@type": "Brand", "name": "리앤양" },
  "offers": {
    "@type": "AggregateOffer",
    "lowPrice": "350000",
    "highPrice": "450000",
    "priceCurrency": "KRW",
    "availability": "https://schema.org/InStock",
    "url": "https://leeandyang.co.kr/custom.php"
  },
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
  }
}
</script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@400;500;600;700&display=swap" rel="stylesheet">
<!-- Google Ads 전환 추적 -->
<script async src="https://www.googletagmanager.com/gtag/js?id=AW-998917058"></script>
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());
gtag('config', 'AW-998917058');
</script>
<style>
:root {
    --bg:        #F5F5F7;
    --surface:   #FFFFFF;
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
    font-family: -apple-system, BlinkMacSystemFont, 'Noto Sans KR', sans-serif;
    background: var(--bg);
    color: var(--label);
    -webkit-font-smoothing: antialiased;
    overflow-x: hidden;
}
.nav {
    position: fixed; top: 0; left: 0; right: 0; z-index: 200;
    height: 52px;
    background: rgba(255,255,255,0.72);
    backdrop-filter: saturate(180%) blur(20px);
    -webkit-backdrop-filter: saturate(180%) blur(20px);
    border-bottom: 0.5px solid var(--separator);
    display: flex; align-items: center; justify-content: space-between;
    padding: 0 24px;
}
.nav-logo { font-size: 17px; font-weight: 700; letter-spacing: 1.5px; color: var(--label); text-decoration: none; }
.nav-cta {
    font-size: 13px; font-weight: 600; color: var(--blue); text-decoration: none;
    padding: 6px 16px; border: 1.5px solid var(--blue); border-radius: 980px; transition: all 0.2s;
}
.nav-cta:hover { background: var(--blue); color: #fff; }
.hero {
    background: var(--label); color: #fff;
    padding: 120px 24px 80px;
    text-align: center; min-height: 480px;
    display: flex; flex-direction: column; align-items: center; justify-content: center;
}
.hero-eyebrow { font-size: 12px; font-weight: 600; letter-spacing: 2px; color: #86868B; text-transform: uppercase; margin-bottom: 14px; }
.hero h1 {
    font-size: clamp(32px, 5.5vw, 64px); font-weight: 700;
    line-height: 1.12; letter-spacing: -0.03em; margin-bottom: 18px; max-width: 680px;
}
.hero h1 em { color: #86868B; font-style: normal; }
.hero-sub { font-size: clamp(15px, 2vw, 19px); color: #86868B; line-height: 1.6; max-width: 520px; margin-bottom: 36px; }
.price-badge {
    display: inline-block; background: var(--blue); color: #fff;
    font-size: 13px; font-weight: 700; padding: 6px 18px; border-radius: 980px; margin-bottom: 28px;
    letter-spacing: 0.02em;
}
.btn-primary {
    display: inline-block; background: var(--blue); color: #fff;
    font-size: 16px; font-weight: 600; padding: 14px 32px; border-radius: 980px;
    text-decoration: none; transition: background 0.2s, transform 0.15s;
}
.btn-primary:hover { background: var(--blue-dark); transform: scale(1.03); }
.section { padding: 80px 24px; }
.section.white { background: var(--surface); }
.section.gray  { background: var(--bg); }
.section.dark  { background: var(--label); color: #fff; }
.section-inner { max-width: 900px; margin: 0 auto; }
.section-eyebrow { font-size: 12px; font-weight: 600; letter-spacing: 2px; color: var(--blue); text-transform: uppercase; margin-bottom: 12px; }
.section-title { font-size: clamp(26px, 4vw, 42px); font-weight: 700; letter-spacing: -0.03em; line-height: 1.2; margin-bottom: 16px; }
.section.dark .section-eyebrow { color: #86868B; }
.section-desc { font-size: 16px; color: var(--label3); line-height: 1.7; margin-bottom: 48px; }
.section.dark .section-desc { color: #86868B; }

/* 특징 그리드 */
.feature-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
.feature-card {
    background: var(--bg); border-radius: var(--radius-lg);
    padding: 28px 24px; text-align: center;
}
.feature-icon { font-size: 32px; margin-bottom: 14px; display: block; }
.feature-name { font-size: 16px; font-weight: 700; margin-bottom: 8px; }
.feature-desc { font-size: 13px; color: var(--label3); line-height: 1.6; }

/* 대상자 섹션 */
.target-list { list-style: none; display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
.target-item {
    background: var(--surface); border-radius: var(--radius);
    padding: 18px 20px; display: flex; align-items: center; gap: 12px;
    box-shadow: var(--shadow);
}
.target-check { color: var(--blue); font-size: 18px; font-weight: 700; flex-shrink: 0; }
.target-text { font-size: 14px; font-weight: 600; }

/* 가격표 */
.leather-grid {
    display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px;
    max-width: 820px; margin: 0 auto;
}
.leather-card {
    background: var(--surface); border-radius: var(--radius-lg);
    padding: 32px 24px; text-align: center; position: relative;
    border: 1.5px solid var(--separator); transition: box-shadow 0.2s;
}
.leather-card:hover { box-shadow: 0 8px 32px rgba(0,0,0,0.10); }
.leather-card.featured {
    background: var(--label); border-color: var(--label);
    transform: scale(1.04);
}
.leather-badge {
    position: absolute; top: -13px; left: 50%; transform: translateX(-50%);
    background: var(--blue); color: #fff;
    font-size: 11px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase;
    padding: 4px 14px; border-radius: 980px; white-space: nowrap;
}
.leather-tag {
    font-size: 11px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase;
    color: var(--label4); margin-bottom: 10px;
}
.leather-card.featured .leather-tag { color: #86868B; }
.leather-name {
    font-size: 19px; font-weight: 700; letter-spacing: -0.02em;
    color: var(--label); margin-bottom: 4px;
}
.leather-card.featured .leather-name { color: #fff; }
.leather-sub {
    font-size: 12px; color: var(--label3); margin-bottom: 20px; line-height: 1.5;
}
.leather-card.featured .leather-sub { color: #86868B; }
.leather-price {
    font-size: clamp(30px, 4vw, 40px); font-weight: 700; letter-spacing: -0.04em;
    color: var(--label); line-height: 1; margin-bottom: 4px;
}
.leather-card.featured .leather-price { color: #fff; }
.leather-price-unit { font-size: 13px; color: var(--label4); margin-bottom: 20px; }
.leather-card.featured .leather-price-unit { color: #86868B; }
.leather-divider { height: 0.5px; background: var(--separator); margin-bottom: 16px; }
.leather-card.featured .leather-divider { background: #3A3A3C; }
.leather-features { list-style: none; text-align: left; }
.leather-features li {
    font-size: 13px; color: var(--label3); line-height: 1.6;
    padding: 4px 0; display: flex; align-items: flex-start; gap: 8px;
}
.leather-card.featured .leather-features li { color: #86868B; }
.leather-features li::before { content: "·"; color: var(--label4); flex-shrink: 0; margin-top: 1px; }
.leather-card.featured .leather-features li::before { color: #6E6E73; }
.leather-note {
    margin-top: 28px; text-align: center; font-size: 13px; color: var(--label3); line-height: 1.6;
    max-width: 820px; margin-left: auto; margin-right: auto;
}

/* 제작 과정 */
.process-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; }
.process-item { text-align: center; }
.process-num {
    width: 48px; height: 48px; border-radius: 50%;
    background: var(--blue); color: #fff;
    font-size: 20px; font-weight: 700;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 14px;
}
.process-label { font-size: 15px; font-weight: 700; margin-bottom: 6px; }
.process-desc { font-size: 13px; color: var(--label3); line-height: 1.6; }

/* FAQ */
.faq-list { display: flex; flex-direction: column; gap: 2px; }
.faq-item { background: var(--surface); border-radius: var(--radius); overflow: hidden; }
.faq-q {
    width: 100%; text-align: left; background: none; border: none; cursor: pointer;
    padding: 18px 22px; font-size: 15px; font-weight: 600; color: var(--label);
    display: flex; align-items: center; justify-content: space-between; gap: 12px;
}
.faq-arrow { transition: transform 0.2s; flex-shrink: 0; font-size: 12px; color: var(--label4); }
.faq-item.open .faq-arrow { transform: rotate(180deg); }
.faq-a {
    display: none; padding: 0 22px 18px; font-size: 14px; color: var(--label3);
    line-height: 1.7; border-top: 0.5px solid var(--separator); padding-top: 14px;
}
.faq-item.open .faq-a { display: block; }

/* CTA */
.cta-block {
    background: var(--label); border-radius: var(--radius-lg);
    padding: 52px 36px; text-align: center; margin: 0 auto; max-width: 680px;
}
.cta-title { font-size: clamp(22px, 3.5vw, 34px); font-weight: 700; color: #fff; margin-bottom: 12px; letter-spacing: -0.02em; }
.cta-desc { font-size: 15px; color: #86868B; margin-bottom: 28px; line-height: 1.6; }
.cta-btn-row { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }
.btn-kakao-copy {
    display: inline-flex; align-items: center; gap: 8px;
    background: #FEE500; color: #3C1E1E;
    font-size: 15px; font-weight: 700; padding: 13px 28px; border-radius: 980px;
    border: none; cursor: pointer; transition: opacity 0.2s;
}
.btn-kakao-copy:hover { opacity: 0.88; }
.copy-feedback { display: none; margin-top: 12px; font-size: 13px; color: var(--green); font-weight: 600; }

/* 푸터 */
.footer { padding: 36px 24px; text-align: center; font-size: 13px; color: var(--label4); border-top: 0.5px solid var(--separator); line-height: 1.8; }
.footer a { color: var(--label3); text-decoration: none; }

/* 애니메이션 */
.reveal { opacity: 0; transform: translateY(28px); transition: opacity 0.55s ease, transform 0.55s ease; }
.reveal.visible { opacity: 1; transform: translateY(0); }
.reveal-d1 { transition-delay: 0.05s; }
.reveal-d2 { transition-delay: 0.12s; }
.reveal-d3 { transition-delay: 0.19s; }

@media (max-width: 640px) {
    .hero { padding: 100px 20px 60px; min-height: 400px; }
    .section { padding: 56px 20px; }
    .feature-grid { grid-template-columns: 1fr; gap: 12px; }
    .target-list { grid-template-columns: 1fr; }
    .process-row { grid-template-columns: 1fr 1fr; }
    .leather-grid { grid-template-columns: 1fr; }
    .leather-card.featured { transform: none; }
    .cta-block { padding: 40px 24px; }
}
</style>
</head>
<body>

<nav class="nav">
    <a href="/" class="nav-logo">LEE&amp;YANG</a>
    <a href="/apply.php" class="nav-cta">제작 신청하기</a>
</nav>

<section class="hero">
    <p class="hero-eyebrow">리앤양 맞춤 축구화</p>
    <h1>세상에 하나뿐인<br><em>나만의 맞춤 축구화</em></h1>
    <p class="hero-sub">내 발형 그대로 수제 제작. 발볼 넓은 분, 무지외반증, 특수 발형 모두 가능.<br>색상·소재·디자인 직접 선택, 2주 완성.</p>
    <span class="price-badge">베나프로 맞춤 축구화 — 350,000원~</span>
    <a href="/apply.php" class="btn-primary">지금 제작 신청하기</a>
</section>

<!-- 특징 -->
<section class="section white">
    <div class="section-inner">
        <p class="section-eyebrow reveal">맞춤 제작 특징</p>
        <h2 class="section-title reveal reveal-d1">기성품이 맞지 않는 분들을 위한<br>완전한 맞춤 제작</h2>
        <p class="section-desc reveal reveal-d2">발형 실측부터 소재 선택, 핸드메이드 제작까지. 오직 하나뿐인 내 발을 위한 축구화를 만들어드립니다.</p>
        <div class="feature-grid">
            <div class="feature-card reveal reveal-d1">
                <span class="feature-icon">📐</span>
                <div class="feature-name">발형 실측 맞춤</div>
                <div class="feature-desc">발 길이, 발볼 너비, 발등 높이를 정밀 측정해 딱 맞게 제작합니다.</div>
            </div>
            <div class="feature-card reveal reveal-d2">
                <span class="feature-icon">🎨</span>
                <div class="feature-name">색상·소재 선택</div>
                <div class="feature-desc">어퍼 색상, 밑창 색상, 소재를 직접 선택해 나만의 디자인으로 완성합니다.</div>
            </div>
            <div class="feature-card reveal reveal-d3">
                <span class="feature-icon">🏭</span>
                <div class="feature-name">핸드메이드 수제 제작</div>
                <div class="feature-desc">공장 대량생산이 아닌 장인이 직접 손으로 한 켤레 한 켤레 제작합니다.</div>
            </div>
        </div>
    </div>
</section>

<!-- 이런 분께 추천 -->
<section class="section gray">
    <div class="section-inner">
        <p class="section-eyebrow reveal">추천 대상</p>
        <h2 class="section-title reveal reveal-d1">이런 분들께 꼭 맞습니다</h2>
        <ul class="target-list reveal reveal-d2">
            <li class="target-item">
                <span class="target-check">✓</span>
                <span class="target-text">발볼이 넓어 기성품 축구화가 불편한 분</span>
            </li>
            <li class="target-item">
                <span class="target-check">✓</span>
                <span class="target-text">무지외반증·소건막류 등 발 변형이 있는 분</span>
            </li>
            <li class="target-item">
                <span class="target-check">✓</span>
                <span class="target-text">발 좌우 사이즈가 달라 맞는 신발이 없는 분</span>
            </li>
            <li class="target-item">
                <span class="target-check">✓</span>
                <span class="target-text">나만의 색상·디자인으로 특별하게 갖고 싶은 분</span>
            </li>
            <li class="target-item">
                <span class="target-check">✓</span>
                <span class="target-text">발 사이즈가 시중 제품 범위(220~290mm)를 벗어난 분</span>
            </li>
            <li class="target-item">
                <span class="target-check">✓</span>
                <span class="target-text">경기력·편안함을 동시에 원하는 선수·동호인</span>
            </li>
        </ul>
    </div>
</section>

<!-- 가격 -->
<section class="section white">
    <div class="section-inner">
        <p class="section-eyebrow reveal" style="text-align:center;">가격</p>
        <h2 class="section-title reveal reveal-d1" style="text-align:center;">어퍼 소재에 따라<br>선택하세요</h2>
        <p class="section-desc reveal reveal-d2" style="text-align:center;">세 가지 가죽 중 하나를 선택. 발형 실측, 색상·스터드 커스터마이징, 수제 제작, 전국 배송 모두 포함.</p>
        <div class="leather-grid reveal reveal-d2">

            <!-- 인조가죽 -->
            <div class="leather-card">
                <div class="leather-tag">Basic</div>
                <div class="leather-name">인조가죽</div>
                <div class="leather-sub">합성 소재 어퍼</div>
                <div class="leather-price">350<span style="font-size:0.45em;letter-spacing:0">만원</span></div>
                <div class="leather-price-unit">VAT 포함 · 배송비 포함</div>
                <div class="leather-divider"></div>
                <ul class="leather-features">
                    <li>합성 소재 어퍼</li>
                    <li>FG/AG 겸용 아웃솔</li>
                    <li>발형 실측 맞춤 제작</li>
                    <li>색상·스터드 선택 가능</li>
                </ul>
            </div>

            <!-- 캥거루 가죽 (추천) -->
            <div class="leather-card featured">
                <div class="leather-badge">추천 · 가장 많이 선택</div>
                <div class="leather-tag">Premium</div>
                <div class="leather-name">캥거루 가죽</div>
                <div class="leather-sub">세계 최상급 천연가죽</div>
                <div class="leather-price">450<span style="font-size:0.45em;letter-spacing:0">만원</span></div>
                <div class="leather-price-unit">VAT 포함 · 배송비 포함</div>
                <div class="leather-divider"></div>
                <ul class="leather-features">
                    <li>캥거루 천연가죽 어퍼</li>
                    <li>소가죽 대비 얇고 강한 내구성</li>
                    <li>발에 빠르게 길드는 착화감</li>
                    <li>FG/AG/SG 아웃솔 선택 가능</li>
                    <li>발형 실측 맞춤 제작</li>
                    <li>색상·스터드 선택 가능</li>
                </ul>
            </div>

            <!-- 소가죽 -->
            <div class="leather-card">
                <div class="leather-tag">Standard</div>
                <div class="leather-name">소가죽</div>
                <div class="leather-sub">천연 카프스킨 어퍼</div>
                <div class="leather-price">400<span style="font-size:0.45em;letter-spacing:0">만원</span></div>
                <div class="leather-price-unit">VAT 포함 · 배송비 포함</div>
                <div class="leather-divider"></div>
                <ul class="leather-features">
                    <li>천연 소가죽(카프스킨) 어퍼</li>
                    <li>FG/AG/SG 아웃솔 선택 가능</li>
                    <li>발형 실측 맞춤 제작</li>
                    <li>색상·스터드 선택 가능</li>
                </ul>
            </div>

        </div>
        <p class="leather-note reveal">가죽 종류와 색상·스터드 조합은 상담 후 결정합니다. 궁금한 점은 카카오톡 <strong>21apro</strong>로 언제든지 문의해 주세요.</p>
    </div>
</section>

<!-- 제작 과정 -->
<section class="section gray">
    <div class="section-inner">
        <p class="section-eyebrow reveal">제작 과정</p>
        <h2 class="section-title reveal reveal-d1">4단계로 완성되는<br>나만의 축구화</h2>
        <div class="process-row reveal reveal-d2">
            <div class="process-item">
                <div class="process-num">1</div>
                <div class="process-label">상담·견적</div>
                <div class="process-desc">카카오톡으로 발 사진 전송,<br>발형·디자인 상담</div>
            </div>
            <div class="process-item">
                <div class="process-num">2</div>
                <div class="process-label">발형 측정</div>
                <div class="process-desc">방문 또는 발 족적지<br>우편 발송으로 정밀 측정</div>
            </div>
            <div class="process-item">
                <div class="process-num">3</div>
                <div class="process-label">수제 제작</div>
                <div class="process-desc">장인이 직접 한 켤레씩<br>핸드메이드 제작 (2주~)</div>
            </div>
            <div class="process-item">
                <div class="process-num">4</div>
                <div class="process-label">배송·완료</div>
                <div class="process-desc">전국 택배 발송,<br>착용 후 피팅 상담</div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ -->
<section class="section white">
    <div class="section-inner">
        <p class="section-eyebrow reveal">FAQ</p>
        <h2 class="section-title reveal reveal-d1">자주 묻는 질문</h2>
        <div class="faq-list reveal reveal-d2">
            <div class="faq-item">
                <button class="faq-q" onclick="toggleFaq(this)">
                    맞춤 축구화 가격이 얼마인가요?
                    <span class="faq-arrow">▼</span>
                </button>
                <div class="faq-a">
                    어퍼 소재에 따라 다릅니다. <strong>인조가죽 350,000원 / 소가죽 400,000원 / 캥거루 가죽 450,000원</strong>. 발형 실측, 색상·스터드 커스터마이징, 수제 제작, 전국 배송 모두 포함. 대부분의 고객은 착화감과 내구성이 탁월한 캥거루 가죽을 선택합니다.
                </div>
            </div>
            <div class="faq-item">
                <button class="faq-q" onclick="toggleFaq(this)">
                    발 사진만으로도 제작이 가능한가요?
                    <span class="faq-arrow">▼</span>
                </button>
                <div class="faq-a">
                    카카오톡으로 발 사진(위·옆·앞·뒤)을 보내주시면 기본 상담이 가능합니다. 더 정확한 제작을 위해서는 <strong>방문 측정</strong>을 권장하며, 방문이 어려운 분은 족적지를 우편으로 보내주시는 방법도 있습니다.
                </div>
            </div>
            <div class="faq-item">
                <button class="faq-q" onclick="toggleFaq(this)">
                    제작 기간이 얼마나 걸리나요?
                    <span class="faq-arrow">▼</span>
                </button>
                <div class="faq-a">보통 <strong>2주에서 1개월</strong> 정도 소요됩니다. 주문량에 따라 달라질 수 있으며, 상담 시 예상 기간을 정확히 안내해드립니다.</div>
            </div>
            <div class="faq-item">
                <button class="faq-q" onclick="toggleFaq(this)">
                    어떤 발형도 제작이 가능한가요?
                    <span class="faq-arrow">▼</span>
                </button>
                <div class="faq-a">
                    발볼이 넓거나 좁은 분, 무지외반증·소건막류 등 발 변형이 있는 분, 발 좌우 사이즈가 다른 분, 220mm 이하 또는 295mm 이상의 특수 사이즈 등 <strong>대부분의 발형 제작이 가능</strong>합니다. 먼저 카카오톡으로 상담해주세요.
                </div>
            </div>
            <div class="faq-item">
                <button class="faq-q" onclick="toggleFaq(this)">
                    직접 방문해야 하나요?
                    <span class="faq-arrow">▼</span>
                </button>
                <div class="faq-a">방문이 권장되지만 필수는 아닙니다. <strong>전국 어디서나</strong> 족적지 우편 발송 방식으로 제작이 가능합니다. 카카오톡 21apro로 먼저 상담해주세요.<br><br>방문 주소: 경기도 고양시 덕양구 서오릉로 433 한우만 3층 (리앤양)</div>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="section gray">
    <div class="section-inner">
        <div class="cta-block reveal">
            <div class="cta-title">지금 바로 시작하세요</div>
            <div class="cta-desc">카카오톡 상담 또는 온라인 신청서 작성으로 간편하게 시작.<br>발 사진 한 장으로 무료 상담·견적 가능합니다.</div>
            <div class="cta-btn-row">
                <a href="/apply.php" class="btn-primary">신청서 작성하기</a>
                <button class="btn-kakao-copy" onclick="copyKakaoId()">
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none"><path d="M9 1.5C4.86 1.5 1.5 4.14 1.5 7.38c0 2.04 1.2 3.84 3.03 4.92l-.75 2.79 3.21-2.1c.66.12 1.32.18 2.01.18 4.14 0 7.5-2.64 7.5-5.88S13.14 1.5 9 1.5z" fill="#3C1E1E"/></svg>
                    카카오톡 21apro
                </button>
            </div>
            <div class="copy-feedback" id="copyFeedback">아이디가 복사됐습니다. 카카오톡에서 21apro를 검색하세요.</div>
        </div>
    </div>
</section>

<footer class="footer">
    <div>리앤양 Lee &amp; Yang | 경기도 고양시 덕양구 서오릉로 433 한우만 3층</div>
    <div>Tel: 010-3547-7744 | 카카오톡: 21apro</div>
    <div style="margin-top:8px">
        <a href="/">홈</a> &nbsp;·&nbsp;
        <a href="/changalyi.php">창갈이 수선</a> &nbsp;·&nbsp;
        <a href="/apply.php">신청하기</a>
    </div>
</footer>

<script>
function toggleFaq(btn) {
    var item = btn.closest('.faq-item');
    item.classList.toggle('open');
}

function copyKakaoId() {
    var id = '21apro';
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(id).then(showFeedback);
    } else {
        var ta = document.createElement('textarea');
        ta.value = id; ta.style.position = 'fixed'; ta.style.opacity = '0';
        document.body.appendChild(ta); ta.focus(); ta.select();
        try { document.execCommand('copy'); } catch(e) {}
        document.body.removeChild(ta);
        showFeedback();
    }
}

function showFeedback() {
    var el = document.getElementById('copyFeedback');
    el.style.display = 'block';
    setTimeout(function() { el.style.display = 'none'; }, 3500);
}

(function() {
    var els = document.querySelectorAll('.reveal');
    if (!els.length) return;
    if ('IntersectionObserver' in window) {
        var obs = new IntersectionObserver(function(entries) {
            entries.forEach(function(e) {
                if (e.isIntersecting) { e.target.classList.add('visible'); obs.unobserve(e.target); }
            });
        }, { threshold: 0.1 });
        els.forEach(function(el) { obs.observe(el); });
    } else {
        els.forEach(function(el) { el.classList.add('visible'); });
    }
})();
</script>
</body>
</html>
