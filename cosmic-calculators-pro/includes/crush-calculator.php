<?php
/**
 * Crush Calculator — Shortcode [crush_calculator]
 *
 * Inputs: your name, crush name, your zodiac (optional), crush zodiac (optional).
 * Outputs: crush %, "likes you back?" verdict, soulmate status, future-together,
 *   horoscope compatibility, mood emoji, best date idea, confession day,
 *   crush song, golden hints, personalized advice, share, FAQ + JSON-LD.
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! function_exists( 'ccp_render_crush_calculator' ) ) {

function ccp_render_crush_calculator( $atts = array() ) {
    ob_start();
    ?>
<div class="cc-wrap" id="cc-wrap">
    <style>
        .cc-wrap, .cc-wrap *, .cc-wrap *::before, .cc-wrap *::after { box-sizing: border-box; }
        .cc-wrap { font-family: 'DM Sans', 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; color: #1F1933; max-width: 920px; margin: 0 auto; padding: 12px; line-height: 1.6; }
        .cc-wrap h1, .cc-wrap h2, .cc-wrap h3, .cc-wrap h4 { font-family: 'Poppins', 'Syne', system-ui, sans-serif; font-weight: 800; letter-spacing: -0.01em; margin: 0; }

        .cc-header { background: linear-gradient(135deg, #0F0729 0%, #2E1065 45%, #4C1D95 75%, #BE185D 100%); border-radius: 24px; padding: 32px 22px; color: #fff; text-align: center; box-shadow: 0 22px 60px rgba(76, 29, 149, 0.32); position: relative; overflow: hidden; }
        .cc-header::before { content: ""; position: absolute; inset: -50%; background: radial-gradient(circle at 25% 20%, rgba(245,158,11,0.18), transparent 55%), radial-gradient(circle at 78% 82%, rgba(190,24,93,0.32), transparent 55%); pointer-events: none; animation: cc-shimmer 9s linear infinite; }
        .cc-header-icon { font-size: 54px; line-height: 1; display: inline-block; animation: cc-bob 2.4s ease-in-out infinite; filter: drop-shadow(0 4px 14px rgba(244,114,182,0.5)); }
        .cc-header h1 { font-size: 40px; margin: 8px 0 6px; color: #fff; }
        .cc-header-sub { opacity: 0.88; font-size: 15.5px; margin: 0 auto; max-width: 580px; }
        .cc-stats { display: flex; align-items: center; justify-content: center; gap: 0; margin-top: 20px; flex-wrap: wrap; position: relative; z-index: 1; }
        .cc-stat { padding: 4px 16px; min-width: 100px; }
        .cc-stat-num { font-weight: 800; font-family: 'Poppins', sans-serif; font-size: 19px; color: #FBBF24; }
        .cc-stat-lbl { font-size: 11px; opacity: 0.82; text-transform: uppercase; letter-spacing: 0.07em; }
        .cc-stat + .cc-stat { border-left: 1px solid rgba(255,255,255,0.22); }

        .cc-card { background: #fff; border-radius: 22px; padding: 26px 22px; margin-top: 18px; box-shadow: 0 22px 60px rgba(15, 7, 41, 0.10); border: 1px solid #EEE8FB; }

        .cc-inputs { display: grid; grid-template-columns: 1fr auto 1fr; gap: 14px; align-items: center; }
        .cc-field { display: flex; flex-direction: column; align-items: center; gap: 10px; }
        .cc-avatar { width: 68px; height: 68px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-family: 'Poppins', sans-serif; font-weight: 800; font-size: 28px; color: #fff; box-shadow: 0 10px 26px rgba(0,0,0,0.18); transition: transform .25s ease; }
        .cc-avatar.cc-a { background: linear-gradient(135deg, #BE185D, #F472B6); }
        .cc-avatar.cc-b { background: linear-gradient(135deg, #4C1D95, #7C3AED); }
        .cc-avatar:hover { transform: scale(1.06) rotate(3deg); }
        .cc-input { width: 100%; min-height: 52px; padding: 12px 16px; font-size: 16px; border: 2px solid #EDE7FB; border-radius: 14px; outline: none; background: #FAF8FF; transition: border-color .2s, background .2s, box-shadow .2s; font-family: inherit; }
        .cc-input:focus { border-color: #BE185D; background: #fff; box-shadow: 0 0 0 4px rgba(190,24,93,0.14); }
        .cc-vs { width: 58px; height: 58px; border-radius: 50%; background: linear-gradient(135deg, #F472B6, #BE185D); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 22px; font-weight: 800; font-family: 'Poppins', sans-serif; box-shadow: 0 12px 26px rgba(190,24,93,0.4); animation: cc-pulse 1.6s ease-in-out infinite; }
        .cc-zodiacs { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-top: 14px; }
        .cc-zlabel { display: block; font-size: 12.5px; color: #5B5070; margin-bottom: 4px; font-weight: 600; }
        .cc-select { width: 100%; min-height: 52px; padding: 12px 16px; font-size: 15.5px; border: 2px solid #EDE7FB; border-radius: 14px; outline: none; background: #FAF8FF; font-family: inherit; color: #1F1933; }
        .cc-select:focus { border-color: #BE185D; box-shadow: 0 0 0 4px rgba(190,24,93,0.12); }
        .cc-btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; min-height: 56px; padding: 18px 22px; font-size: 17px; font-weight: 700; font-family: 'Poppins', sans-serif; border: none; border-radius: 14px; cursor: pointer; width: 100%; transition: transform .15s ease, box-shadow .2s ease, opacity .2s; }
        .cc-btn-primary { background: linear-gradient(135deg, #BE185D, #4C1D95); color: #fff; box-shadow: 0 14px 32px rgba(190,24,93,0.4); margin-top: 20px; }
        .cc-btn-primary:hover { transform: translateY(-2px); box-shadow: 0 18px 42px rgba(76,29,149,0.45); }
        .cc-btn-primary:active { transform: translateY(0); }
        .cc-trust { display: flex; gap: 10px; justify-content: center; flex-wrap: wrap; margin-top: 14px; }
        .cc-trust span { font-size: 12.5px; color: #5B5070; background: #F4EEFB; padding: 6px 12px; border-radius: 999px; min-height: 30px; display: inline-flex; align-items: center; }
        .cc-error { display: none; background: #FFF1F2; color: #B3162A; border: 1px solid #FFD6DB; padding: 10px 14px; border-radius: 12px; margin-top: 12px; font-size: 14px; text-align: center; }
        .cc-error.cc-show { display: block; animation: cc-shake .4s; }

        /* Loading */
        .cc-loading { display: none; text-align: center; padding: 14px 8px 6px; }
        .cc-loading.cc-show { display: block; }
        .cc-rings { position: relative; width: 170px; height: 170px; margin: 6px auto 18px; }
        .cc-ring { position: absolute; inset: 0; border-radius: 50%; border: 3px solid rgba(190,24,93,0.35); animation: cc-ringp 2s ease-out infinite; }
        .cc-ring:nth-child(2) { animation-delay: .5s; border-color: rgba(245,158,11,0.42); }
        .cc-ring:nth-child(3) { animation-delay: 1s; border-color: rgba(124,58,237,0.45); }
        .cc-ring-icon { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; font-size: 62px; animation: cc-pulse 1.2s ease-in-out infinite; }
        .cc-load-names { font-size: 18px; font-weight: 700; font-family: 'Poppins', sans-serif; color: #2E1065; margin-bottom: 12px; }
        .cc-load-step { font-size: 15px; color: #6B5E85; min-height: 24px; transition: opacity .25s; }
        .cc-progress { height: 8px; background: #F1EBF7; border-radius: 999px; overflow: hidden; margin: 14px auto 4px; max-width: 380px; }
        .cc-progress-bar { height: 100%; width: 0%; background: linear-gradient(90deg, #BE185D, #F59E0B, #4C1D95); border-radius: 999px; transition: width .35s ease; }

        /* Result card */
        .cc-result { display: none; }
        .cc-result.cc-show { display: block; animation: cc-fadeUp .55s ease both; }
        .cc-result-card { background: linear-gradient(135deg, #0F0729, #2E1065, #4C1D95, #BE185D); color: #fff; border-radius: 22px; padding: 30px 22px; text-align: center; box-shadow: 0 22px 60px rgba(15,7,41,0.32); position: relative; overflow: hidden; }
        .cc-result-card::after { content: ""; position: absolute; inset: 0; background: radial-gradient(circle at 18% 12%, rgba(244,114,182,0.25), transparent 55%), radial-gradient(circle at 82% 88%, rgba(245,158,11,0.22), transparent 55%); pointer-events: none; }
        .cc-rc-names { display: flex; align-items: center; justify-content: center; gap: 14px; flex-wrap: wrap; margin-bottom: 6px; position: relative; z-index: 1; }
        .cc-rc-name { display: flex; align-items: center; gap: 10px; font-weight: 700; font-family: 'Poppins', sans-serif; font-size: 17px; }
        .cc-rc-name .cc-avatar { width: 46px; height: 46px; font-size: 19px; }
        .cc-rc-heart { font-size: 24px; opacity: 0.92; }
        .cc-ring-wrap { position: relative; width: 230px; height: 230px; margin: 14px auto 10px; z-index: 1; }
        .cc-ring-wrap svg { transform: rotate(-90deg); width: 100%; height: 100%; }
        .cc-ring-bg { fill: none; stroke: rgba(255,255,255,0.14); stroke-width: 12; }
        .cc-ring-fg { fill: none; stroke: url(#cc-grad); stroke-width: 12; stroke-linecap: round; transition: stroke-dashoffset 1.8s cubic-bezier(.22,.9,.3,1); }
        .cc-percent { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; flex-direction: column; }
        .cc-percent-num { font-size: 66px; font-weight: 800; font-family: 'Poppins', sans-serif; line-height: 1; }
        .cc-percent-sym { font-size: 24px; font-weight: 700; opacity: 0.85; }
        .cc-level { display: inline-block; background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.24); padding: 8px 18px; border-radius: 999px; font-weight: 700; font-family: 'Poppins', sans-serif; font-size: 15px; margin: 6px 0 10px; position: relative; z-index: 1; }
        .cc-rc-desc { max-width: 600px; margin: 0 auto; opacity: 0.94; font-size: 15px; position: relative; z-index: 1; }
        .cc-verdict { display: inline-block; margin-top: 14px; padding: 8px 22px; background: rgba(255,255,255,0.14); border: 1px solid rgba(255,255,255,0.24); border-radius: 999px; font-weight: 800; font-family: 'Poppins', sans-serif; font-size: 17px; color: #FBBF24; position: relative; z-index: 1; }
        .cc-watermark { margin-top: 14px; font-size: 12.5px; opacity: 0.72; position: relative; z-index: 1; }

        /* Bars */
        .cc-bars { margin-top: 10px; }
        .cc-bar-row { margin: 14px 0; }
        .cc-bar-top { display: flex; justify-content: space-between; font-size: 14px; font-weight: 600; color: #2D2447; margin-bottom: 6px; }
        .cc-bar-top span:last-child { color: #BE185D; font-family: 'Poppins', sans-serif; font-weight: 800; }
        .cc-bar { height: 10px; background: #F1EBF7; border-radius: 999px; overflow: hidden; }
        .cc-bar-fill { height: 100%; width: 0%; border-radius: 999px; background: linear-gradient(90deg, #BE185D, #F472B6, #F59E0B); transition: width 1.5s cubic-bezier(.22,.9,.3,1); }

        /* Insights grid */
        .cc-preds { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin-top: 18px; }
        .cc-pred { background: linear-gradient(135deg, #FFFFFF, #FFF1F8); border-radius: 16px; padding: 16px 12px; text-align: center; box-shadow: 0 10px 24px rgba(15,7,41,0.06); border: 1px solid #FBCFE8; opacity: 0; transform: translateY(10px); animation: cc-fadeUp .5s ease forwards; }
        .cc-pred-ic { font-size: 30px; }
        .cc-pred h4 { font-size: 13px; color: #6B5E85; margin: 6px 0 2px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.06em; }
        .cc-pred-val { font-family: 'Poppins', sans-serif; font-weight: 800; color: #831843; font-size: 15.5px; line-height: 1.3; }

        /* Horoscope */
        .cc-horo { background: linear-gradient(135deg, #FAF5FF, #F3E8FF); border-radius: 18px; padding: 22px; margin-top: 16px; border: 1px solid #D8B4FE; }
        .cc-horo h3 { font-size: 19px; color: #6B21A8; margin-bottom: 8px; }
        .cc-horo-row { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }
        .cc-zo { background: #fff; padding: 8px 14px; border-radius: 999px; font-weight: 700; color: #6B21A8; border: 1px solid #D8B4FE; font-size: 14px; }
        .cc-horo-bar { flex: 1; height: 10px; background: #F1EBF7; border-radius: 999px; overflow: hidden; min-width: 140px; }
        .cc-horo-fill { height: 100%; width: 0%; background: linear-gradient(90deg, #6B21A8, #BE185D, #F59E0B); transition: width 1.5s ease; border-radius: 999px; }
        .cc-horo-val { font-family: 'Poppins', sans-serif; font-weight: 800; color: #6B21A8; min-width: 50px; text-align: right; }
        .cc-horo p { color: #4C1D95; font-size: 14.5px; margin: 10px 0 0; line-height: 1.6; }

        /* Soulmate */
        .cc-soul { background: linear-gradient(135deg, #FFF7ED, #FED7AA); border-radius: 18px; padding: 22px; margin-top: 16px; border: 1px solid #FDBA74; position: relative; }
        .cc-soul h3 { color: #9A3412; font-size: 19px; margin-bottom: 8px; }
        .cc-soul-status { font-family: 'Poppins', sans-serif; font-size: 24px; font-weight: 800; color: #9A3412; margin: 4px 0; }
        .cc-soul-future { color: #7C2D12; font-size: 14.5px; line-height: 1.65; margin: 8px 0 0; }

        /* Golden hints */
        .cc-hints { background: linear-gradient(135deg, #FFFBEB, #FEF3C7); border-radius: 18px; padding: 22px; margin-top: 16px; border: 1px solid #FCD34D; position: relative; }
        .cc-hints::before { content: "\2605"; position: absolute; top: -10px; left: 20px; background: #F59E0B; color: #fff; width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 16px; box-shadow: 0 6px 14px rgba(245,158,11,0.4); }
        .cc-hints h3 { font-size: 19px; color: #78350F; margin-bottom: 12px; padding-left: 8px; }
        .cc-hints-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; }
        .cc-hint { background: #fff; border-radius: 14px; padding: 14px; border-left: 4px solid #F59E0B; box-shadow: 0 8px 20px rgba(0,0,0,0.05); opacity: 0; transform: translateY(8px); animation: cc-fadeUp .5s ease forwards; }
        .cc-hint-icon { font-size: 22px; margin-bottom: 4px; }
        .cc-hint h4 { font-size: 14.5px; color: #831843; margin-bottom: 4px; }
        .cc-hint p { font-size: 13px; color: #5B5070; margin: 0; }

        /* Advice */
        .cc-advice { background: linear-gradient(135deg, #FDF2F8, #FCE7F3); border-radius: 18px; padding: 22px; margin-top: 16px; border: 1px solid #F9A8D4; }
        .cc-advice h3 { font-size: 18px; color: #831843; margin-bottom: 8px; }
        .cc-advice p { font-style: italic; color: #9D174D; margin: 0 0 12px; font-size: 14.5px; line-height: 1.65; }
        .cc-tags { display: flex; flex-wrap: wrap; gap: 8px; }
        .cc-tag { background: #fff; padding: 6px 12px; border-radius: 999px; font-size: 12.5px; font-weight: 600; color: #831843; border: 1px solid #FBCFE8; }
        .cc-tag.cc-t2 { color: #6D28D9; border-color: #DDD6FE; }
        .cc-tag.cc-t3 { color: #065F46; border-color: #A7F3D0; }
        .cc-tag.cc-t4 { color: #B45309; border-color: #FDE68A; }

        /* Share */
        .cc-share { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin-top: 18px; }
        .cc-share-btn { display: inline-flex; align-items: center; justify-content: center; gap: 6px; min-height: 48px; padding: 12px 8px; font-size: 14px; font-weight: 700; font-family: 'Poppins', sans-serif; border-radius: 12px; border: none; cursor: pointer; color: #fff; text-decoration: none; transition: transform .15s ease, box-shadow .15s ease; }
        .cc-share-btn:hover { transform: translateY(-2px); box-shadow: 0 12px 26px rgba(0,0,0,0.15); }
        .cc-sb-wa { background: #25D366; }
        .cc-sb-tw { background: #111; }
        .cc-sb-save { background: linear-gradient(135deg, #BE185D, #4C1D95); }
        .cc-sb-copy { background: #5B5B6E; }
        .cc-try { margin-top: 14px; background: #fff; color: #831843; border: 2px solid #FBCFE8; }
        .cc-try:hover { border-color: #BE185D; color: #BE185D; }

        /* Confetti */
        .cc-confetti { position: fixed; inset: 0; pointer-events: none; z-index: 9999; overflow: hidden; }
        .cc-confetti i { position: absolute; top: -20px; width: 10px; height: 14px; opacity: 0.95; animation: cc-fall linear forwards; border-radius: 2px; }

        /* Levels */
        .cc-levels { display: grid; grid-template-columns: repeat(5, 1fr); gap: 10px; margin-top: 22px; }
        .cc-lvl { background: #fff; border-radius: 16px; padding: 14px 10px; text-align: center; box-shadow: 0 10px 24px rgba(0,0,0,0.06); border-top: 4px solid #BE185D; }
        .cc-lvl:nth-child(1) { border-color: #F59E0B; }
        .cc-lvl:nth-child(2) { border-color: #BE185D; }
        .cc-lvl:nth-child(3) { border-color: #7C3AED; }
        .cc-lvl:nth-child(4) { border-color: #2563EB; }
        .cc-lvl:nth-child(5) { border-color: #94A3B8; }
        .cc-lvl-icon { font-size: 26px; }
        .cc-lvl h4 { font-size: 14px; color: #1F1933; margin: 4px 0; }
        .cc-lvl-range { font-size: 12px; color: #BE185D; font-weight: 700; }
        .cc-lvl-desc { font-size: 12px; color: #5B5070; margin: 4px 0 0; }

        /* FAQ */
        .cc-faq { margin-top: 24px; }
        .cc-faq h2 { font-size: 24px; color: #2E1065; margin-bottom: 12px; }
        .cc-faq-item { background: #fff; border-radius: 14px; margin-bottom: 10px; box-shadow: 0 8px 20px rgba(0,0,0,0.05); border: 1px solid #EEE8FB; overflow: hidden; }
        .cc-faq-q { width: 100%; min-height: 56px; padding: 16px 18px; background: #fff; border: none; text-align: left; font-size: 15.5px; font-weight: 700; font-family: 'Poppins', sans-serif; color: #1F1933; cursor: pointer; display: flex; justify-content: space-between; align-items: center; gap: 10px; }
        .cc-faq-q::after { content: "+"; font-size: 24px; font-weight: 400; color: #BE185D; transition: transform .25s; }
        .cc-faq-item.cc-open .cc-faq-q::after { transform: rotate(45deg); }
        .cc-faq-a { padding: 0 18px; max-height: 0; overflow: hidden; transition: max-height .35s ease, padding .35s ease; color: #5B5070; font-size: 14.5px; }
        .cc-faq-item.cc-open .cc-faq-a { padding: 0 18px 18px; max-height: 600px; }

        @keyframes cc-pulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.08); } }
        @keyframes cc-bob { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-6px); } }
        @keyframes cc-ringp { 0% { transform: scale(0.6); opacity: 0.9; } 100% { transform: scale(1.4); opacity: 0; } }
        @keyframes cc-fadeUp { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes cc-shake { 0%, 100% { transform: translateX(0); } 25% { transform: translateX(-4px); } 75% { transform: translateX(4px); } }
        @keyframes cc-fall { 0% { transform: translateY(-20px) rotate(0); opacity: 1; } 100% { transform: translateY(110vh) rotate(720deg); opacity: 0.3; } }
        @keyframes cc-shimmer { 0%, 100% { transform: rotate(0deg); } 50% { transform: rotate(180deg); } }

        @media (max-width: 720px) {
            .cc-preds { grid-template-columns: repeat(2, 1fr); }
            .cc-zodiacs { grid-template-columns: 1fr; }
        }
        @media (max-width: 640px) {
            .cc-wrap { padding: 8px; }
            .cc-header { padding: 24px 16px; border-radius: 18px; }
            .cc-header h1 { font-size: 30px; }
            .cc-header-icon { font-size: 46px; }
            .cc-card { padding: 20px 16px; border-radius: 18px; }
            .cc-inputs { grid-template-columns: 1fr; gap: 12px; }
            .cc-vs { margin: -4px auto; }
            .cc-percent-num { font-size: 56px; }
            .cc-ring-wrap { width: 200px; height: 200px; }
            .cc-share { grid-template-columns: repeat(2, 1fr); }
            .cc-levels { grid-template-columns: repeat(2, 1fr); }
            .cc-hints-grid { grid-template-columns: 1fr; }
        }
    </style>

    <header class="cc-header">
        <div class="cc-header-icon">&#128150;</div>
        <h1>Crush Calculator</h1>
        <p class="cc-header-sub">Does your crush like you back? Get instant crush %, horoscope match, soulmate verdict, confession day, mood emoji &amp; song.</p>
        <div class="cc-stats">
            <div class="cc-stat"><div class="cc-stat-num" id="cc-counter">3,12,940</div><div class="cc-stat-lbl">Tests Today</div></div>
            <div class="cc-stat"><div class="cc-stat-num">4.9&#9733;</div><div class="cc-stat-lbl">Rating</div></div>
            <div class="cc-stat"><div class="cc-stat-num">100%</div><div class="cc-stat-lbl">Anonymous</div></div>
        </div>
    </header>

    <section class="cc-card">
        <div class="cc-input-phase" id="cc-input-phase">
            <div class="cc-inputs">
                <div class="cc-field">
                    <div class="cc-avatar cc-a" id="cc-av-a">?</div>
                    <input type="text" class="cc-input" id="cc-name-a" placeholder="Your name" maxlength="30" autocomplete="off" aria-label="Your name" />
                </div>
                <div class="cc-vs" aria-hidden="true">&#128150;</div>
                <div class="cc-field">
                    <div class="cc-avatar cc-b" id="cc-av-b">?</div>
                    <input type="text" class="cc-input" id="cc-name-b" placeholder="Crush name" maxlength="30" autocomplete="off" aria-label="Crush name" />
                </div>
            </div>
            <div class="cc-zodiacs">
                <div>
                    <label class="cc-zlabel" for="cc-zo-a">Your zodiac (optional)</label>
                    <select class="cc-select" id="cc-zo-a"></select>
                </div>
                <div>
                    <label class="cc-zlabel" for="cc-zo-b">Crush zodiac (optional)</label>
                    <select class="cc-select" id="cc-zo-b"></select>
                </div>
            </div>
            <div class="cc-error" id="cc-error">Please enter both names to continue.</div>
            <button type="button" class="cc-btn cc-btn-primary" id="cc-calc-btn">Reveal The Truth &#128150;</button>
            <div class="cc-trust">
                <span>&#128274; 100% Anonymous</span>
                <span>&#9889; Instant Result</span>
                <span>&#127942; Free Forever</span>
                <span>&#128302; Vedic + Western</span>
            </div>
        </div>

        <div class="cc-loading" id="cc-loading">
            <div class="cc-rings">
                <div class="cc-ring"></div>
                <div class="cc-ring"></div>
                <div class="cc-ring"></div>
                <div class="cc-ring-icon">&#128150;</div>
            </div>
            <div class="cc-load-names" id="cc-load-names">&#128150;</div>
            <div class="cc-load-step" id="cc-load-step">&#128270; Reading the energy between you...</div>
            <div class="cc-progress"><div class="cc-progress-bar" id="cc-progress-bar"></div></div>
        </div>

        <div class="cc-result" id="cc-result">
            <div class="cc-result-card">
                <div class="cc-rc-names">
                    <div class="cc-rc-name"><div class="cc-avatar cc-a" id="cc-rc-av-a">?</div><span id="cc-rc-n-a">You</span></div>
                    <div class="cc-rc-heart">&#128150;</div>
                    <div class="cc-rc-name"><div class="cc-avatar cc-b" id="cc-rc-av-b">?</div><span id="cc-rc-n-b">Crush</span></div>
                </div>
                <div class="cc-ring-wrap">
                    <svg viewBox="0 0 200 200" aria-hidden="true">
                        <defs>
                            <linearGradient id="cc-grad" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#F472B6"/>
                                <stop offset="50%" stop-color="#F59E0B"/>
                                <stop offset="100%" stop-color="#7C3AED"/>
                            </linearGradient>
                        </defs>
                        <circle class="cc-ring-bg" cx="100" cy="100" r="86"/>
                        <circle class="cc-ring-fg" id="cc-ring-fg" cx="100" cy="100" r="86" stroke-dasharray="540.35" stroke-dashoffset="540.35"/>
                    </svg>
                    <div class="cc-percent">
                        <div><span class="cc-percent-num" id="cc-pct">0</span><span class="cc-percent-sym">%</span></div>
                    </div>
                </div>
                <div class="cc-level" id="cc-level">&#128150; Reading...</div>
                <p class="cc-rc-desc" id="cc-desc">Decoding the secret signals...</p>
                <div class="cc-verdict" id="cc-verdict">&#128528; Wait...</div>
                <div class="cc-watermark">cosmiccalculators.in &middot; Crush Reading</div>
            </div>

            <div class="cc-bars">
                <div class="cc-bar-row"><div class="cc-bar-top"><span>&#10024; Attraction</span><span id="cc-b1-v">0%</span></div><div class="cc-bar"><div class="cc-bar-fill" id="cc-b1"></div></div></div>
                <div class="cc-bar-row"><div class="cc-bar-top"><span>&#128172; Vibe Match</span><span id="cc-b2-v">0%</span></div><div class="cc-bar"><div class="cc-bar-fill" id="cc-b2"></div></div></div>
                <div class="cc-bar-row"><div class="cc-bar-top"><span>&#128293; Chemistry</span><span id="cc-b3-v">0%</span></div><div class="cc-bar"><div class="cc-bar-fill" id="cc-b3"></div></div></div>
                <div class="cc-bar-row"><div class="cc-bar-top"><span>&#127881; Long-term Potential</span><span id="cc-b4-v">0%</span></div><div class="cc-bar"><div class="cc-bar-fill" id="cc-b4"></div></div></div>
            </div>

            <!-- Predictions -->
            <div class="cc-preds">
                <div class="cc-pred"><div class="cc-pred-ic" id="cc-pe">&#128525;</div><h4>Mood Emoji</h4><div class="cc-pred-val" id="cc-pev">--</div></div>
                <div class="cc-pred"><div class="cc-pred-ic">&#127801;</div><h4>Best Date Idea</h4><div class="cc-pred-val" id="cc-pdv">--</div></div>
                <div class="cc-pred"><div class="cc-pred-ic">&#127925;</div><h4>Your Song</h4><div class="cc-pred-val" id="cc-psv">--</div></div>
                <div class="cc-pred"><div class="cc-pred-ic">&#128197;</div><h4>Confess On</h4><div class="cc-pred-val" id="cc-pcv">--</div></div>
                <div class="cc-pred"><div class="cc-pred-ic">&#127872;</div><h4>Gift Idea</h4><div class="cc-pred-val" id="cc-pgv">--</div></div>
                <div class="cc-pred"><div class="cc-pred-ic">&#127807;</div><h4>Lucky Charm</h4><div class="cc-pred-val" id="cc-plv">--</div></div>
                <div class="cc-pred"><div class="cc-pred-ic">&#128276;</div><h4>Power Word</h4><div class="cc-pred-val" id="cc-pwv">--</div></div>
                <div class="cc-pred"><div class="cc-pred-ic">&#127770;</div><h4>Confession Time</h4><div class="cc-pred-val" id="cc-ptv">--</div></div>
            </div>

            <!-- Horoscope -->
            <div class="cc-horo">
                <h3>&#9802; Horoscope Compatibility</h3>
                <div class="cc-horo-row">
                    <span class="cc-zo" id="cc-zo-a-disp">--</span>
                    <span class="cc-zo" id="cc-zo-b-disp">--</span>
                    <div class="cc-horo-bar"><div class="cc-horo-fill" id="cc-horo-fill"></div></div>
                    <span class="cc-horo-val" id="cc-horo-val">0%</span>
                </div>
                <p id="cc-horo-text"></p>
            </div>

            <!-- Soulmate / Future -->
            <div class="cc-soul">
                <h3>&#128081; Soulmate Verdict</h3>
                <div class="cc-soul-status" id="cc-soul-status">--</div>
                <p class="cc-soul-future" id="cc-soul-future"></p>
            </div>

            <!-- Hints -->
            <div class="cc-hints">
                <h3 id="cc-hints-title">Golden Hints</h3>
                <div class="cc-hints-grid" id="cc-hints-grid"></div>
            </div>

            <!-- Advice -->
            <div class="cc-advice">
                <h3>&#129302; Your Crush Advice</h3>
                <p id="cc-advice-text"></p>
                <div class="cc-tags" id="cc-tags"></div>
            </div>

            <!-- Share -->
            <div class="cc-share">
                <a href="#" class="cc-share-btn cc-sb-wa" id="cc-sb-wa" target="_blank" rel="noopener">&#128241; WhatsApp</a>
                <a href="#" class="cc-share-btn cc-sb-tw" id="cc-sb-tw" target="_blank" rel="noopener">&#119991; Twitter</a>
                <button type="button" class="cc-share-btn cc-sb-save" id="cc-sb-save">&#128247; Save Card</button>
                <button type="button" class="cc-share-btn cc-sb-copy" id="cc-sb-copy">&#128279; Copy Link</button>
            </div>

            <button type="button" class="cc-btn cc-try" id="cc-try-btn">&#128260; Try Another Crush</button>
        </div>
    </section>

    <section class="cc-levels">
        <div class="cc-lvl"><div class="cc-lvl-icon">&#128081;</div><h4>Soulmate</h4><div class="cc-lvl-range">90-100%</div><p class="cc-lvl-desc">Confess. Cosmically yours.</p></div>
        <div class="cc-lvl"><div class="cc-lvl-icon">&#128293;</div><h4>Strong Chance</h4><div class="cc-lvl-range">70-89%</div><p class="cc-lvl-desc">They feel it too.</p></div>
        <div class="cc-lvl"><div class="cc-lvl-icon">&#128150;</div><h4>Mutual Vibes</h4><div class="cc-lvl-range">50-69%</div><p class="cc-lvl-desc">Worth exploring slowly.</p></div>
        <div class="cc-lvl"><div class="cc-lvl-icon">&#128524;</div><h4>One-Sided?</h4><div class="cc-lvl-range">30-49%</div><p class="cc-lvl-desc">Be patient and observant.</p></div>
        <div class="cc-lvl"><div class="cc-lvl-icon">&#129402;</div><h4>Just Vibes</h4><div class="cc-lvl-range">0-29%</div><p class="cc-lvl-desc">Friendship may suit better.</p></div>
    </section>

    <section class="cc-faq">
        <h2>Crush Calculator &mdash; FAQs</h2>
        <div class="cc-faq-item"><button class="cc-faq-q" type="button">How does the crush calculator work?</button><div class="cc-faq-a"><p>It blends three signals from both names plus optional zodiac compatibility: (1) letter overlap, (2) name numerology, and (3) seeded harmony. If zodiacs are entered, an additional Western horoscope-compatibility weight is added. The blend produces your crush %, verdict, mood emoji, song, gift idea, and confession timing.</p></div></div>
        <div class="cc-faq-item"><button class="cc-faq-q" type="button">Will the calculator tell me if my crush likes me back?</button><div class="cc-faq-a"><p>The tool gives a clear verdict — Yes / Maybe / Slow Down — based on the score and horoscope alignment. Treat it as a confidence boost or a reflection nudge, not a final answer. Real signals come from how your crush behaves around you.</p></div></div>
        <div class="cc-faq-item"><button class="cc-faq-q" type="button">Are the results based on astrology?</button><div class="cc-faq-a"><p>Yes &mdash; the optional zodiac inputs use Western horoscope compatibility logic combined with name-numerology. You can also use the calculator without entering zodiacs; in that case only the name-based signals are used.</p></div></div>
        <div class="cc-faq-item"><button class="cc-faq-q" type="button">Is my crush&rsquo;s name private?</button><div class="cc-faq-a"><p>Yes. Everything runs inside your browser. Names and zodiacs are never sent to a server, saved, or shared. The tool is fully anonymous and works offline once loaded.</p></div></div>
        <div class="cc-faq-item"><button class="cc-faq-q" type="button">Why does the same crush pair always give the same result?</button><div class="cc-faq-a"><p>The algorithm is deterministic &mdash; it uses a seeded calculation instead of randomness so your result is consistent and shareable. The score won&rsquo;t change unless the inputs do.</p></div></div>
        <div class="cc-faq-item"><button class="cc-faq-q" type="button">Should I really confess based on this result?</button><div class="cc-faq-a"><p>If the result is high, take it as a gentle push to make a thoughtful move. Always be respectful, low-pressure, and ready to handle any answer with maturity. Real-life chemistry > any calculator.</p></div></div>
    </section>

    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@graph": [
        {
          "@type": "SoftwareApplication",
          "name": "Crush Calculator",
          "applicationCategory": "LifestyleApplication",
          "operatingSystem": "Web",
          "url": "https://cosmiccalculators.in/crush-calculator/",
          "offers": { "@type": "Offer", "price": "0", "priceCurrency": "USD" },
          "aggregateRating": { "@type": "AggregateRating", "ratingValue": "4.9", "ratingCount": "13680" }
        },
        {
          "@type": "FAQPage",
          "mainEntity": [
            { "@type": "Question", "name": "How does the crush calculator work?", "acceptedAnswer": { "@type": "Answer", "text": "It blends letter overlap, name numerology, seeded harmony, and optional zodiac horoscope-compatibility to produce a crush %, verdict, song, mood emoji, and confession timing." } },
            { "@type": "Question", "name": "Will it tell me if my crush likes me back?", "acceptedAnswer": { "@type": "Answer", "text": "It gives a Yes / Maybe / Slow Down verdict based on score and horoscope alignment. Use it as guidance, not a final answer." } },
            { "@type": "Question", "name": "Is my crush's name private?", "acceptedAnswer": { "@type": "Answer", "text": "Yes. All calculations happen in your browser. Nothing is sent to any server, logged, or saved." } },
            { "@type": "Question", "name": "Why is the result the same every time?", "acceptedAnswer": { "@type": "Answer", "text": "The algorithm is deterministic and seeded, so the same inputs always return the same output. This makes results shareable and reproducible." } }
          ]
        }
      ]
    }
    </script>
</div>

<script>
(function(){
    'use strict';
    var CC = { $: function(id){ return document.getElementById(id); }, nameA: '', nameB: '', zoA: '', zoB: '' };

    function escapeHtml(s) {
        return String(s).replace(/[&<>"']/g, function(c){
            return ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'})[c];
        });
    }

    var ZODIACS = [
        ['', '— select —'],
        ['aries','♈ Aries'],['taurus','♉ Taurus'],['gemini','♊ Gemini'],
        ['cancer','♋ Cancer'],['leo','♌ Leo'],['virgo','♍ Virgo'],
        ['libra','♎ Libra'],['scorpio','♏ Scorpio'],['sagittarius','♐ Sagittarius'],
        ['capricorn','♑ Capricorn'],['aquarius','♒ Aquarius'],['pisces','♓ Pisces']
    ];

    // Element grouping: fire / earth / air / water
    var Z_ELEMENT = {
        aries: 'fire', leo: 'fire', sagittarius: 'fire',
        taurus: 'earth', virgo: 'earth', capricorn: 'earth',
        gemini: 'air', libra: 'air', aquarius: 'air',
        cancer: 'water', scorpio: 'water', pisces: 'water'
    };

    // Compat matrix (very simplified Western astrology guideline)
    function zodiacCompat(a, b) {
        if (!a || !b) return null;
        if (a === b) return 78; // same sign — mirror match
        var ea = Z_ELEMENT[a], eb = Z_ELEMENT[b];
        if (ea === eb) return 88; // same element
        // opposite-element matches
        var opposites = { fire: 'air', air: 'fire', water: 'earth', earth: 'water' };
        if (opposites[ea] === eb) return 80;
        // remaining squares = trickier
        return 62;
    }

    (function populateZ(){
        var a = CC.$('cc-zo-a'), b = CC.$('cc-zo-b');
        for (var i=0; i<ZODIACS.length; i++) {
            var o1 = document.createElement('option'); o1.value = ZODIACS[i][0]; o1.textContent = ZODIACS[i][1]; a.appendChild(o1);
            var o2 = document.createElement('option'); o2.value = ZODIACS[i][0]; o2.textContent = ZODIACS[i][1]; b.appendChild(o2);
        }
    })();

    var elInputPhase = CC.$('cc-input-phase');
    var elLoading    = CC.$('cc-loading');
    var elResult     = CC.$('cc-result');
    var elNameA      = CC.$('cc-name-a');
    var elNameB      = CC.$('cc-name-b');
    var elAvA        = CC.$('cc-av-a');
    var elAvB        = CC.$('cc-av-b');
    var elError      = CC.$('cc-error');
    var elCalcBtn    = CC.$('cc-calc-btn');

    function updateAvatar(input, av) {
        var v = (input.value || '').trim();
        av.textContent = v ? v.charAt(0).toUpperCase() : '?';
    }
    elNameA.addEventListener('input', function(){ updateAvatar(elNameA, elAvA); elError.classList.remove('cc-show'); });
    elNameB.addEventListener('input', function(){ updateAvatar(elNameB, elAvB); elError.classList.remove('cc-show'); });

    function seedFor(s) {
        var x = 0;
        for (var i=0; i<s.length; i++) { x = ((x << 5) - x + s.charCodeAt(i)) | 0; }
        return Math.abs(x);
    }

    function calcCrush(n1, n2, zo) {
        var a = (n1 || '').toLowerCase().replace(/[^a-z]/g,'');
        var b = (n2 || '').toLowerCase().replace(/[^a-z]/g,'');
        if (!a || !b) return 50;

        var freqA = {}, freqB = {};
        for (var i=0;i<a.length;i++){ freqA[a[i]] = (freqA[a[i]]||0) + 1; }
        for (var j=0;j<b.length;j++){ freqB[b[j]] = (freqB[b[j]]||0) + 1; }
        var overlap = 0, total = 0, keys = {};
        for (var k in freqA) keys[k]=1;
        for (var k2 in freqB) keys[k2]=1;
        for (var k3 in keys) {
            overlap += Math.min(freqA[k3]||0, freqB[k3]||0);
            total   += Math.max(freqA[k3]||0, freqB[k3]||0);
        }
        var overlapScore = total ? (overlap / total) * 100 : 50;

        var sumA = 0, sumB = 0;
        for (var i2=0;i2<a.length;i2++) sumA += a.charCodeAt(i2) - 96;
        for (var j2=0;j2<b.length;j2++) sumB += b.charCodeAt(j2) - 96;
        var num = ((sumA + sumB) % 9) + 1;
        var numScore = num * 10;

        var diff = Math.abs(a.length - b.length);
        var lenScore = Math.max(0, 100 - diff * 12);

        var seed = seedFor(a + '+' + b);
        var rand = Math.abs(Math.sin(seed)) * 30;

        var raw = (overlapScore * 0.38) + (numScore * 0.20) + (lenScore * 0.16) + (rand * 0.6);
        // Add zodiac weight if available
        if (zo !== null) raw = raw * 0.78 + zo * 0.22;

        var score = Math.round(raw);
        if (score < 14) score = 14 + (seed % 18);
        if (score > 99) score = 99;
        return score;
    }

    function calcMetrics(n1, n2, score) {
        var a = (n1 || '').toLowerCase().replace(/[^a-z]/g,'');
        var b = (n2 || '').toLowerCase().replace(/[^a-z]/g,'');
        var seed = seedFor(a + b + 'x');
        function vary(off) {
            var r = Math.abs(Math.sin(seed + off * 5.13)) * 22 - 11;
            var v = Math.round(score + r);
            return Math.max(18, Math.min(99, v));
        }
        return { attr: vary(1), vibe: vary(2), chem: vary(3), lt: vary(4) };
    }

    function getLevel(score) {
        if (score >= 90) return { emoji: '👑', name: 'Soulmate',       color: '#F59E0B' };
        if (score >= 70) return { emoji: '🔥', name: 'Strong Chance',  color: '#BE185D' };
        if (score >= 50) return { emoji: '💖', name: 'Mutual Vibes',   color: '#7C3AED' };
        if (score >= 30) return { emoji: '😌', name: 'One-Sided?',     color: '#2563EB' };
        return { emoji: '🥺', name: 'Just Friendly Vibes', color: '#94A3B8' };
    }

    function getVerdict(score) {
        if (score >= 75) return '💚 YES — They likely like you back';
        if (score >= 55) return '💛 MAYBE — Signals are mixed';
        if (score >= 35) return '🧡 SLOW — Build comfort first';
        return '❤️ HOLD — Focus on you for now';
    }

    function getDescription(score, n1, n2) {
        if (score >= 90) return n1 + ' & ' + n2 + ', the energy between you is rare and electric — the kind people write love songs about. If the timing feels right, take the leap. The stars are clearly in your favor.';
        if (score >= 70) return n1 + ' & ' + n2 + ', there is a real spark here. Your crush probably feels it too — maybe more than they show. Keep being your honest self and let the magic build naturally.';
        if (score >= 50) return n1 + ' & ' + n2 + ', the chemistry is real but unfinished. There is enough to explore but not enough to rush. Talk more, hang out longer, and watch the bond reveal itself.';
        if (score >= 30) return n1 + ' & ' + n2 + ', the connection might be more from your side right now. That is not a no — it is a "not yet". Be patient, stay genuine, and don’t force what should flow.';
        return n1 + ' & ' + n2 + ', the romantic spark seems quiet right now, but friendship often grows into something deeper. Focus on real conversations and shared moments before anything else.';
    }

    var EMOJI_POOL = ['💗','💘','💝','💖','😍','🥰','💞','💓','🌹','🦋','✨','💫','🔥','🌷','🍓'];

    var DATE_IDEAS = [
        'Sunset rooftop with chai',
        'Aquarium walk',
        'Bookstore + coffee',
        'Bowling night',
        'Street food crawl',
        'Sunset beach drive',
        'Picnic in a garden park',
        'Movie + ice cream',
        'Stargazing on a terrace',
        'Long late-night phone call',
        'Trip to a local cafe',
        'Cooking together at home'
    ];

    var SONGS = [
        '"Tum Hi Ho" — Arijit Singh',
        '"Sweater Weather" — The Neighbourhood',
        '"Tera Hone Laga Hoon" — Atif Aslam',
        '"Perfect" — Ed Sheeran',
        '"Pasoori" — Ali Sethi & Shae Gill',
        '"Crush" — David Archuleta',
        '"Tujh Mein Rab Dikhta Hai" — Rab Ne Bana Di Jodi',
        '"Stay" — The Kid LAROI & Justin Bieber',
        '"Kesariya" — Arijit Singh',
        '"Hawayein" — Arijit Singh',
        '"Apna Bana Le" — Arijit Singh',
        '"Ek Ladki Ko Dekha Toh" — Kumar Sanu'
    ];

    var GIFTS = [
        'Handwritten letter',
        'Their favorite chocolate',
        'A book they’ll love',
        'A playlist made for them',
        'Polaroid photo memory',
        'Their favorite snack box',
        'Mini bouquet (any flower)',
        'Custom keychain',
        'Sticky note with one honest line',
        'A meme that screams “them”',
        'Voice note saying hi',
        'Their favorite coffee'
    ];

    var CHARMS = [
        'Lucky pink stone',
        'Gold thread bracelet',
        'Pink rose petal in wallet',
        'Spritz of vanilla perfume',
        'Smile + eye contact',
        'Wear something maroon',
        'Talk to them on a Friday',
        'Carry their favorite scent',
        'Send a midnight “hi”',
        'Use their name in a compliment',
        'Listen — really listen',
        'Wear a confident outfit'
    ];

    var WORDS = ['Patience','Confidence','Soft Eyes','Calm','Curiosity','Honesty','Mystery','Lightness','Warmth','Charm','Listen','Smile'];

    var DAYS_LIST = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
    var TIMES = ['Morning ☀️','Afternoon 🌤','Sunset 🌇','Evening 🌙','Midnight 🌌'];

    function getHints(score, n1, n2) {
        if (score >= 70) return [
            { i: '👁', t: 'Eye Contact Magic', d: 'Hold a 3-second glance once. That single look says everything words can’t.' },
            { i: '🗒', t: 'Drop A Subtle Hint', d: 'Compliment one specific thing about them — not generic. Specific = real.' },
            { i: '🌃', t: 'Plan Quality Time', d: 'Invite them to one chill hangout. Real love grows in low-pressure moments.' },
            { i: '🔓', t: 'Show A Real Side', d: 'Share one thing nobody else knows. Vulnerability fast-forwards trust.' }
        ];
        if (score >= 40) return [
            { i: '🤝', t: 'Be A Good Friend First', d: 'Friendship is the safest bridge to romance. Skip the rush.' },
            { i: '🎯', t: 'Find Common Ground', d: 'Discover one thing you both love and turn it into a shared ritual.' },
            { i: '📞', t: 'Stay Lightly In Touch', d: 'Two thoughtful messages a week beats 20 random ones.' },
            { i: '🌱', t: 'Let It Breathe', d: 'Pressure kills crush energy. Be calm, kind, and curious.' }
        ];
        return [
            { i: '🪞', t: 'Self First', d: 'A confident, happy you is the biggest attraction multiplier.' },
            { i: '🚪', t: 'Don’t Force It', d: 'Some doors aren’t closed forever — they’re closed for now.' },
            { i: '🛤', t: 'Stay Open', d: 'The right person often arrives when you stop chasing the wrong one.' },
            { i: '✨', t: 'Be Mysterious', d: 'Reveal slowly. People crave what they cannot fully read.' }
        ];
    }

    function getAdvice(score, n1, n2) {
        if (score >= 70) return {
            text: n1 + ' & ' + n2 + ', the universe is dropping hints — pay attention. Stay genuine, low-pressure, and confident. If you sense a green signal, lean in gently. The right move at the right moment can change everything.',
            tags: ['Strong Spark','Make A Move','Confident Energy','Cosmic Yes']
        };
        if (score >= 40) return {
            text: n1 + ' & ' + n2 + ', the energy is warm but still forming. Build comfort first, romance second. Be the friend who listens. Crushes turn into love stories most often through small, consistent moments — not grand gestures.',
            tags: ['Slow Build','Friendship First','Be Patient','Watch The Signs']
        };
        return {
            text: n1 + ' & ' + n2 + ', not every crush is meant to become a love story — and that is perfectly okay. Sometimes the right move is to feel it, learn from it, and grow forward. The right person will match your energy effortlessly.',
            tags: ['Heal & Grow','Self Love','Open Heart','Better Match Coming']
        };
    }

    function getSoulmate(score) {
        if (score >= 88) return { status: '👑 Cosmic Soulmate Pair', future: 'If both choose to walk together, this connection has the potential to last decades. Marriage, deep friendship, and lifelong support — all on the table.' };
        if (score >= 70) return { status: '🔥 Strong Future Match',  future: 'The relationship could go the distance with effort and honest communication. Long-term love is very possible.' };
        if (score >= 50) return { status: '💞 Possible Future Bond',  future: 'There is real potential — but the next 6 to 12 months will decide. Build trust, share more, and let time test the bond.' };
        if (score >= 30) return { status: '🌱 Slow Burn Connection',  future: 'Not a forever match yet — but a meaningful chapter. Some of these slow connections surprise everyone later.' };
        return { status: '🤝 Better As Friends',                       future: 'A romantic future seems unlikely right now, but a great friendship is possible. Sometimes that is the real gift.' };
    }

    function getHoroscopeText(score, a, b) {
        if (score === null) return 'Add both zodiac signs to see your full horoscope compatibility reading.';
        var sa = labelOf(a), sb = labelOf(b);
        if (score >= 85) return sa + ' and ' + sb + ' share an electric, deeply harmonious cosmic energy. Communication flows, emotions align, and conflicts resolve quickly. A blessed pairing.';
        if (score >= 70) return sa + ' and ' + sb + ' have natural chemistry and shared values. With effort, this can grow into something solid and meaningful.';
        if (score >= 60) return sa + ' and ' + sb + ' are different on the surface but can complement each other beautifully if both stay patient and curious.';
        return sa + ' and ' + sb + ' have a more challenging match astrologically. Real effort, honesty, and mutual respect will be needed for it to thrive.';
    }

    function labelOf(key) {
        for (var i=0; i<ZODIACS.length; i++) if (ZODIACS[i][0] === key) return ZODIACS[i][1];
        return '—';
    }

    function pickFromList(seed, list) { return list[seed % list.length]; }

    function buildPredictions(n1, n2, score) {
        var seed = seedFor(n1 + '|' + n2);
        return {
            emoji: pickFromList(seed, EMOJI_POOL),
            date:  pickFromList(seed >> 1, DATE_IDEAS),
            song:  pickFromList(seed >> 2, SONGS),
            day:   pickFromList(seed >> 3, DAYS_LIST),
            gift:  pickFromList(seed >> 4, GIFTS),
            charm: pickFromList(seed >> 5, CHARMS),
            word:  pickFromList(seed >> 6, WORDS),
            time:  pickFromList(seed >> 7, TIMES)
        };
    }

    var loadSteps = [
        '🔍 Reading the energy between you...',
        '🌌 Checking horoscope alignment...',
        '✨ Decoding crush signals...',
        '💖 Drafting your reading...'
    ];

    function runLoading(callback) {
        var stepEl = CC.$('cc-load-step');
        var barEl  = CC.$('cc-progress-bar');
        var i = 0;
        stepEl.textContent = loadSteps[0];
        barEl.style.width = '8%';
        var interval = setInterval(function(){
            i++;
            if (i < loadSteps.length) {
                stepEl.style.opacity = '0';
                setTimeout(function(){ stepEl.textContent = loadSteps[i]; stepEl.style.opacity = '1'; }, 200);
                barEl.style.width = ((i+1) * 25) + '%';
            } else {
                clearInterval(interval);
                barEl.style.width = '100%';
                setTimeout(callback, 350);
            }
        }, 650);
    }

    function animateNum(el, from, to, duration) {
        var start = performance.now();
        function tick(now) {
            var p = Math.min(1, (now - start) / duration);
            var eased = 1 - Math.pow(1 - p, 3);
            el.textContent = Math.round(from + (to - from) * eased);
            if (p < 1) requestAnimationFrame(tick);
        }
        requestAnimationFrame(tick);
    }

    function confetti() {
        var colors = ['#BE185D','#F472B6','#F59E0B','#7C3AED','#fff'];
        var box = document.createElement('div');
        box.className = 'cc-confetti';
        for (var i=0;i<70;i++){
            var p = document.createElement('i');
            p.style.left = (Math.random()*100) + '%';
            p.style.background = colors[Math.floor(Math.random()*colors.length)];
            p.style.animationDuration = (1.5 + Math.random()*2) + 's';
            p.style.animationDelay = (Math.random()*0.5) + 's';
            p.style.transform = 'rotate(' + (Math.random()*360) + 'deg)';
            box.appendChild(p);
        }
        document.body.appendChild(box);
        setTimeout(function(){ box.remove(); }, 4200);
    }

    function showResult() {
        var n1 = CC.nameA, n2 = CC.nameB;
        var zo = zodiacCompat(CC.zoA, CC.zoB);
        var score = calcCrush(n1, n2, zo);
        var metrics = calcMetrics(n1, n2, score);
        var level = getLevel(score);
        var desc = getDescription(score, n1, n2);
        var hints = getHints(score, n1, n2);
        var advice = getAdvice(score, n1, n2);
        var preds = buildPredictions(n1, n2, score);
        var soul = getSoulmate(score);
        var horoText = getHoroscopeText(zo, CC.zoA, CC.zoB);
        var verdict = getVerdict(score);

        CC.$('cc-rc-n-a').textContent = n1;
        CC.$('cc-rc-n-b').textContent = n2;
        CC.$('cc-rc-av-a').textContent = n1.charAt(0).toUpperCase();
        CC.$('cc-rc-av-b').textContent = n2.charAt(0).toUpperCase();

        CC.$('cc-level').textContent = level.emoji + ' ' + level.name;
        CC.$('cc-desc').textContent  = desc;
        CC.$('cc-verdict').textContent = verdict;

        elLoading.classList.remove('cc-show');
        elLoading.style.display = 'none';
        elResult.classList.add('cc-show');

        animateNum(CC.$('cc-pct'), 0, score, 1800);

        var circ = 2 * Math.PI * 86;
        setTimeout(function(){
            CC.$('cc-ring-fg').style.strokeDashoffset = circ - (circ * score / 100);
        }, 80);

        setTimeout(function(){
            CC.$('cc-b1').style.width = metrics.attr + '%';
            CC.$('cc-b2').style.width = metrics.vibe + '%';
            CC.$('cc-b3').style.width = metrics.chem + '%';
            CC.$('cc-b4').style.width = metrics.lt + '%';
            CC.$('cc-b1-v').textContent = metrics.attr + '%';
            CC.$('cc-b2-v').textContent = metrics.vibe + '%';
            CC.$('cc-b3-v').textContent = metrics.chem + '%';
            CC.$('cc-b4-v').textContent = metrics.lt + '%';
        }, 220);

        CC.$('cc-pe').textContent  = preds.emoji;
        CC.$('cc-pev').textContent = preds.emoji + '  ' + level.name;
        CC.$('cc-pdv').textContent = preds.date;
        CC.$('cc-psv').textContent = preds.song;
        CC.$('cc-pcv').textContent = preds.day;
        CC.$('cc-pgv').textContent = preds.gift;
        CC.$('cc-plv').textContent = preds.charm;
        CC.$('cc-pwv').textContent = preds.word;
        CC.$('cc-ptv').textContent = preds.time;

        // Horoscope
        CC.$('cc-zo-a-disp').textContent = CC.zoA ? labelOf(CC.zoA) : 'You';
        CC.$('cc-zo-b-disp').textContent = CC.zoB ? labelOf(CC.zoB) : 'Crush';
        var horoScore = zo === null ? 0 : zo;
        setTimeout(function(){ CC.$('cc-horo-fill').style.width = horoScore + '%'; }, 250);
        CC.$('cc-horo-val').textContent = horoScore + '%';
        CC.$('cc-horo-text').textContent = horoText;

        // Soulmate
        CC.$('cc-soul-status').textContent = soul.status;
        CC.$('cc-soul-future').textContent = soul.future;

        // Hints
        CC.$('cc-hints-title').innerHTML = '⭐ Golden Hints for ' + escapeHtml(n1) + ' &amp; ' + escapeHtml(n2);
        var grid = CC.$('cc-hints-grid');
        grid.innerHTML = '';
        for (var hi=0; hi<hints.length; hi++) {
            var h = hints[hi];
            var card = document.createElement('div');
            card.className = 'cc-hint';
            card.style.borderLeftColor = level.color;
            card.style.animationDelay = (hi * 0.1) + 's';
            card.innerHTML = '<div class="cc-hint-icon">' + h.i + '</div><h4>' + escapeHtml(h.t) + '</h4><p>' + escapeHtml(h.d) + '</p>';
            grid.appendChild(card);
        }

        var predEls = document.querySelectorAll('#cc-wrap .cc-pred');
        for (var pi=0; pi<predEls.length; pi++) predEls[pi].style.animationDelay = (pi * 0.07) + 's';

        // Advice
        CC.$('cc-advice-text').textContent = advice.text;
        var tagsBox = CC.$('cc-tags');
        tagsBox.innerHTML = '';
        for (var ti=0; ti<advice.tags.length; ti++) {
            var tag = document.createElement('span');
            tag.className = 'cc-tag cc-t' + ((ti % 4) + 1);
            tag.textContent = advice.tags[ti];
            tagsBox.appendChild(tag);
        }

        setupShare(n1, n2, score, level.name);

        if (score >= 70) setTimeout(confetti, 600);

        setTimeout(function(){ elResult.scrollIntoView({ behavior: 'smooth', block: 'start' }); }, 100);
    }

    function setupShare(n1, n2, score, level) {
        var url = window.location.href;
        var msg = '💖 Crush Calculator Result!\n\n' + n1 + ' + ' + n2 + ' = *' + score + '% Crush*\nLevel: *' + level + '*\n\nTest yours: ' + url;
        var tweet = n1 + ' + ' + n2 + ' = ' + score + '% Crush 💖 (' + level + ')! Find out yours:';

        CC.$('cc-sb-wa').href = 'https://wa.me/?text=' + encodeURIComponent(msg);
        CC.$('cc-sb-tw').href = 'https://twitter.com/intent/tweet?text=' + encodeURIComponent(tweet) + '&url=' + encodeURIComponent(url);

        CC.$('cc-sb-copy').onclick = function(){
            var btn = this; var orig = btn.innerHTML;
            try {
                if (navigator.clipboard) {
                    navigator.clipboard.writeText(url).then(function(){ btn.innerHTML = '✅ Copied!'; setTimeout(function(){ btn.innerHTML = orig; }, 1800); });
                } else {
                    var ta = document.createElement('textarea'); ta.value = url; document.body.appendChild(ta); ta.select();
                    document.execCommand('copy'); ta.remove();
                    btn.innerHTML = '✅ Copied!'; setTimeout(function(){ btn.innerHTML = orig; }, 1800);
                }
            } catch(e) { btn.innerHTML = '⚠ Try Manually'; setTimeout(function(){ btn.innerHTML = orig; }, 1800); }
        };
        CC.$('cc-sb-save').onclick = function(){
            var btn = this; var orig = btn.innerHTML;
            btn.innerHTML = '📸 Saving...';
            setTimeout(function(){
                if (navigator.share) {
                    navigator.share({ title: 'Crush Calculator Result', text: msg, url: url }).then(function(){ btn.innerHTML = orig; }).catch(function(){
                        alert('Take a screenshot to save your result!\n\n' + n1 + ' + ' + n2 + ' = ' + score + '% Crush');
                        btn.innerHTML = orig;
                    });
                } else {
                    alert('Take a screenshot to save your result!\n\n' + n1 + ' + ' + n2 + ' = ' + score + '% Crush\n' + level);
                    btn.innerHTML = orig;
                }
            }, 400);
        };
    }

    elCalcBtn.addEventListener('click', function(){
        var n1 = (elNameA.value || '').trim();
        var n2 = (elNameB.value || '').trim();
        if (!n1 || !n2) { elError.textContent = 'Please enter both names to continue.'; elError.classList.add('cc-show'); return; }
        if (n1.length < 2 || n2.length < 2) { elError.textContent = 'Names should be at least 2 characters.'; elError.classList.add('cc-show'); return; }
        elError.classList.remove('cc-show');
        CC.nameA = n1; CC.nameB = n2;
        CC.zoA = CC.$('cc-zo-a').value;
        CC.zoB = CC.$('cc-zo-b').value;
        elInputPhase.style.display = 'none';
        elLoading.style.display = 'block';
        elLoading.classList.add('cc-show');
        CC.$('cc-load-names').textContent = n1 + ' 💖 ' + n2;
        CC.$('cc-progress-bar').style.width = '0%';
        runLoading(showResult);
    });

    [elNameA, elNameB].forEach(function(el){
        el.addEventListener('keydown', function(e){ if (e.key === 'Enter') { e.preventDefault(); elCalcBtn.click(); } });
    });

    CC.$('cc-try-btn').addEventListener('click', function(){
        elResult.classList.remove('cc-show');
        elLoading.classList.remove('cc-show'); elLoading.style.display = 'none';
        elInputPhase.style.display = 'block';
        elNameA.value = ''; elNameB.value = '';
        elAvA.textContent = '?'; elAvB.textContent = '?';
        CC.$('cc-pct').textContent = '0';
        CC.$('cc-ring-fg').style.strokeDashoffset = 540.35;
        ['cc-b1','cc-b2','cc-b3','cc-b4'].forEach(function(id){ CC.$(id).style.width = '0%'; });
        CC.$('cc-horo-fill').style.width = '0%';
        elInputPhase.scrollIntoView({ behavior: 'smooth', block: 'start' });
        setTimeout(function(){ elNameA.focus(); }, 400);
    });

    var faqs = document.querySelectorAll('#cc-wrap .cc-faq-item');
    faqs.forEach(function(item){
        var q = item.querySelector('.cc-faq-q');
        q.addEventListener('click', function(){ item.classList.toggle('cc-open'); });
    });

    var counterEl = CC.$('cc-counter');
    var count = 312940;
    setInterval(function(){
        count += 1 + Math.floor(Math.random()*3);
        counterEl.textContent = count.toLocaleString('en-IN');
    }, 8000);
})();
</script>
    <?php
    return ob_get_clean();
}

}
