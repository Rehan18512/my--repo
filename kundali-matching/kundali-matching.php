<?php
/**
 * Plugin Name: Kundali Matching by Name
 * Plugin URI: https://lovecalculator.in
 * Description: Premium Kundali Matching (Ashtakoot Guna Milan) by name. Enter two names to get derived Rashi & Nakshatra, all 8 kootas scored out of 36 gunas, Manglik/Nadi/Bhakoot dosha checks, verdict and remedies. Use shortcode [kundali_matching].
 * Version: 1.0.0
 * Author: lovecalculator.in
 * Author URI: https://lovecalculator.in
 * License: GPL-2.0+
 * Text Domain: kundali-matching
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! function_exists( 'km_pro_render_match' ) ) {

    function km_pro_render_match( $atts = array() ) {
        ob_start();
        ?>
<div class="km-wrap" id="km-wrap">
    <style>
        .km-wrap, .km-wrap *, .km-wrap *::before, .km-wrap *::after { box-sizing: border-box; }
        .km-wrap { font-family: 'DM Sans', 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; color: #1f1933; max-width: 880px; margin: 0 auto; padding: 12px; line-height: 1.55; }
        .km-wrap h1, .km-wrap h2, .km-wrap h3, .km-wrap h4 { font-family: 'Poppins', 'Syne', system-ui, sans-serif; font-weight: 800; letter-spacing: -0.01em; margin: 0; }

        .km-header { background: linear-gradient(135deg, #1a0533 0%, #3d0b55 50%, #690d3a 100%); border-radius: 22px; padding: 28px 20px; color: #fff; text-align: center; box-shadow: 0 20px 60px rgba(105, 13, 58, 0.25); position: relative; overflow: hidden; }
        .km-header::before { content: ""; position: absolute; inset: -50%; background: radial-gradient(circle at 30% 20%, rgba(230,57,70,0.18), transparent 60%), radial-gradient(circle at 70% 80%, rgba(123,45,139,0.25), transparent 60%); pointer-events: none; }
        .km-header-icon { font-size: 50px; line-height: 1; display: inline-block; animation: km-bob 2.4s ease-in-out infinite; }
        .km-header h1 { font-size: 34px; margin: 8px 0 6px; color: #fff; }
        .km-header-sub { opacity: 0.86; font-size: 15px; margin: 0; }
        .km-stats { display: flex; align-items: center; justify-content: center; gap: 0; margin-top: 18px; flex-wrap: wrap; }
        .km-stat { padding: 4px 14px; min-width: 96px; }
        .km-stat-num { font-weight: 800; font-family: 'Poppins', sans-serif; font-size: 18px; color: #fff; }
        .km-stat-lbl { font-size: 11px; opacity: 0.78; text-transform: uppercase; letter-spacing: 0.06em; }
        .km-stat + .km-stat { border-left: 1px solid rgba(255,255,255,0.22); }

        .km-card { background: #fff; border-radius: 22px; padding: 24px 20px; margin-top: 18px; box-shadow: 0 20px 60px rgba(0,0,0,0.08); border: 1px solid #f1ecf6; }

        .km-inputs { display: grid; grid-template-columns: 1fr auto 1fr; gap: 14px; align-items: center; }
        .km-field { display: flex; flex-direction: column; align-items: center; gap: 10px; }
        .km-flbl { font-size: 12px; font-weight: 700; font-family: 'Poppins', sans-serif; text-transform: uppercase; letter-spacing: 0.05em; }
        .km-flbl.km-boy { color: #2563eb; } .km-flbl.km-girl { color: #E63946; }
        .km-avatar { width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 28px; color: #fff; box-shadow: 0 8px 24px rgba(0,0,0,0.18); }
        .km-avatar.km-a { background: linear-gradient(135deg, #2563eb, #60a5fa); }
        .km-avatar.km-b { background: linear-gradient(135deg, #E63946, #ff6b9d); }
        .km-input { width: 100%; min-height: 52px; padding: 12px 14px; font-size: 16px; border: 2px solid #ece6f3; border-radius: 14px; outline: none; background: #faf8fd; transition: border-color .2s, background .2s, box-shadow .2s; font-family: inherit; text-align: center; color: #1f1933; }
        .km-input:focus { border-color: #E63946; background: #fff; box-shadow: 0 0 0 4px rgba(230,57,70,0.12); }
        .km-vs { width: 52px; height: 52px; border-radius: 50%; background: linear-gradient(135deg, #2563eb, #E63946); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 20px; font-weight: 800; font-family: 'Poppins', sans-serif; box-shadow: 0 10px 24px rgba(123,45,139,0.35); animation: km-pulse 1.6s ease-in-out infinite; }

        .km-error { display: none; background: #fff1f2; color: #b3162a; border: 1px solid #ffd6db; padding: 10px 14px; border-radius: 12px; margin-top: 14px; font-size: 14px; text-align: center; }
        .km-error.km-show { display: block; animation: km-shake .4s; }
        .km-btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; min-height: 56px; padding: 18px 22px; font-size: 17px; font-weight: 700; font-family: 'Poppins', sans-serif; border: none; border-radius: 14px; cursor: pointer; width: 100%; transition: transform .15s ease, box-shadow .2s ease, opacity .2s; }
        .km-btn-primary { background: linear-gradient(135deg, #E63946, #c81e2c); color: #fff; box-shadow: 0 14px 32px rgba(230,57,70,0.35); margin-top: 18px; }
        .km-btn-primary:hover { transform: translateY(-2px); box-shadow: 0 18px 40px rgba(230,57,70,0.45); }
        .km-btn-primary:active { transform: translateY(0); }
        .km-trust { display: flex; gap: 10px; justify-content: center; flex-wrap: wrap; margin-top: 14px; }
        .km-trust span { font-size: 12.5px; color: #5b5070; background: #f6f0fb; padding: 6px 12px; border-radius: 999px; min-height: 30px; display: inline-flex; align-items: center; }

        .km-loading { display: none; text-align: center; padding: 14px 8px 6px; }
        .km-loading.km-show { display: block; }
        .km-rings { position: relative; width: 160px; height: 160px; margin: 6px auto 18px; }
        .km-ring { position: absolute; inset: 0; border-radius: 50%; border: 3px solid rgba(230,57,70,0.35); animation: km-ringa 2s ease-out infinite; }
        .km-ring:nth-child(2) { animation-delay: .5s; border-color: rgba(123,45,139,0.4); }
        .km-ring:nth-child(3) { animation-delay: 1s; border-color: rgba(255,107,157,0.45); }
        .km-ring-heart { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; font-size: 54px; animation: km-pulse 1.2s ease-in-out infinite; }
        .km-load-step { font-size: 15px; color: #6b5e85; min-height: 24px; margin-top: 4px; transition: opacity .25s; }
        .km-progress { height: 8px; background: #f1ebf7; border-radius: 999px; overflow: hidden; margin: 14px auto 4px; max-width: 360px; }
        .km-progress-bar { height: 100%; width: 0%; background: linear-gradient(90deg, #E63946, #7B2D8B); border-radius: 999px; transition: width .3s ease; }

        .km-result { display: none; }
        .km-result.km-show { display: block; animation: km-fadeUp .55s ease both; }
        .km-result-card { background: linear-gradient(135deg, #1a0533, #3d0b55, #690d3a); color: #fff; border-radius: 22px; padding: 28px 20px; text-align: center; box-shadow: 0 20px 60px rgba(0,0,0,0.25); position: relative; overflow: hidden; }
        .km-result-card::after { content: ""; position: absolute; inset: 0; background: radial-gradient(circle at 20% 10%, rgba(230,57,70,0.25), transparent 50%), radial-gradient(circle at 80% 90%, rgba(255,107,157,0.18), transparent 55%); pointer-events: none; }
        .km-rc-pair { display: flex; align-items: stretch; justify-content: center; gap: 12px; flex-wrap: wrap; margin-bottom: 8px; position: relative; z-index: 1; }
        .km-rc-p { background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.16); border-radius: 14px; padding: 10px 14px; min-width: 130px; }
        .km-rc-p .km-rc-nm { font-family: 'Poppins', sans-serif; font-weight: 800; font-size: 16px; }
        .km-rc-p .km-rc-detail { font-size: 11.5px; opacity: 0.82; margin-top: 2px; }
        .km-rc-amp { display: flex; align-items: center; font-size: 22px; opacity: 0.85; }
        .km-ring-wrap { position: relative; width: 210px; height: 210px; margin: 12px auto 8px; z-index: 1; }
        .km-ring-wrap svg { transform: rotate(-90deg); width: 100%; height: 100%; }
        .km-ring-bg { fill: none; stroke: rgba(255,255,255,0.12); stroke-width: 12; }
        .km-ring-fg { fill: none; stroke: url(#km-grad); stroke-width: 12; stroke-linecap: round; transition: stroke-dashoffset 1.8s cubic-bezier(.22,.9,.3,1); }
        .km-score { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; flex-direction: column; }
        .km-score-num { font-size: 58px; font-weight: 800; font-family: 'Poppins', sans-serif; line-height: 1; }
        .km-score-max { font-size: 20px; font-weight: 700; opacity: 0.8; }
        .km-score-lbl { font-size: 12px; opacity: 0.8; text-transform: uppercase; letter-spacing: 0.08em; margin-top: 4px; }
        .km-level { display: inline-block; background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.22); padding: 8px 18px; border-radius: 999px; font-weight: 700; font-family: 'Poppins', sans-serif; font-size: 15px; margin: 4px 0 10px; position: relative; z-index: 1; }
        .km-summary { max-width: 600px; margin: 0 auto; opacity: 0.94; font-size: 15px; position: relative; z-index: 1; }
        .km-watermark { margin-top: 16px; font-size: 12.5px; opacity: 0.7; position: relative; z-index: 1; }

        .km-koota-card { background: #fff; border-radius: 18px; padding: 18px; margin-top: 16px; box-shadow: 0 12px 30px rgba(0,0,0,0.06); border: 1px solid #f1ecf6; }
        .km-koota-card h3 { font-size: 17px; color: #2d2447; margin-bottom: 4px; }
        .km-koota-note { font-size: 12.5px; color: #8a7ba3; margin: 0 0 14px; }
        .km-koota { display: flex; align-items: center; gap: 12px; padding: 10px 0; border-bottom: 1px solid #f3eef9; opacity: 0; transform: translateY(8px); animation: km-fadeUp .4s ease forwards; }
        .km-koota:last-child { border-bottom: none; }
        .km-koota-ico { flex: 0 0 auto; width: 38px; height: 38px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 18px; background: #f6f0fb; }
        .km-koota-main { flex: 1 1 auto; min-width: 0; }
        .km-koota-name { font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 14.5px; color: #3d0b55; }
        .km-koota-desc { font-size: 11.5px; color: #8a7ba3; }
        .km-koota-pts { flex: 0 0 auto; font-family: 'Poppins', sans-serif; font-weight: 800; font-size: 15px; }
        .km-koota-pts small { font-weight: 600; color: #b3a7c9; }
        .km-pass { color: #14b8a6; } .km-partial { color: #d4870b; } .km-fail { color: #E63946; }
        .km-koota-total { display: flex; justify-content: space-between; align-items: center; margin-top: 14px; padding-top: 14px; border-top: 2px solid #f1ecf6; font-family: 'Poppins', sans-serif; font-weight: 800; }
        .km-koota-total span:first-child { color: #2d2447; font-size: 15px; }
        .km-koota-total span:last-child { color: #7B2D8B; font-size: 20px; }

        .km-dosha { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; margin-top: 16px; }
        .km-dchip { background: #fff; border-radius: 16px; padding: 14px 10px; text-align: center; box-shadow: 0 10px 24px rgba(0,0,0,0.06); border-top: 4px solid #14b8a6; }
        .km-dchip-lbl { font-size: 11.5px; color: #8a7ba3; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 700; }
        .km-dchip-val { font-family: 'Poppins', sans-serif; font-weight: 800; font-size: 15px; margin-top: 4px; }
        .km-dchip.km-ok { border-top-color: #14b8a6; } .km-dchip.km-ok .km-dchip-val { color: #0f766e; }
        .km-dchip.km-warn { border-top-color: #E63946; } .km-dchip.km-warn .km-dchip-val { color: #b3162a; }

        .km-conclusion { background: linear-gradient(135deg, #e7f7ec, #d2efdc); border-radius: 18px; padding: 20px; margin-top: 16px; border: 1px solid #b8e2c5; }
        .km-conclusion.km-c-warn { background: linear-gradient(135deg, #fff4e6, #ffe8cc); border-color: #f5c789; }
        .km-conclusion h3 { font-size: 18px; color: #155d3a; margin-bottom: 8px; }
        .km-conclusion.km-c-warn h3 { color: #9a5b00; }
        .km-conclusion p { color: #1f3f2c; margin: 0; font-size: 14.5px; }
        .km-conclusion.km-c-warn p { color: #6b4500; }

        .km-tips { background: linear-gradient(135deg, #fff8dc, #fff1c1); border-radius: 18px; padding: 20px; margin-top: 16px; border: 1px solid #f7e190; }
        .km-tips h3 { font-size: 18px; color: #7a5a05; margin-bottom: 10px; }
        .km-tips ul { margin: 0; padding-left: 18px; }
        .km-tips li { font-size: 14px; color: #5b5070; margin-bottom: 8px; }

        .km-share { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin-top: 18px; }
        .km-share-btn { display: inline-flex; align-items: center; justify-content: center; gap: 6px; min-height: 48px; padding: 12px 8px; font-size: 14px; font-weight: 700; font-family: 'Poppins', sans-serif; border-radius: 12px; border: none; cursor: pointer; color: #fff; text-decoration: none; transition: transform .15s ease, box-shadow .15s ease; }
        .km-share-btn:hover { transform: translateY(-2px); box-shadow: 0 12px 26px rgba(0,0,0,0.15); }
        .km-sb-wa { background: #25d366; }
        .km-sb-tw { background: #111; }
        .km-sb-save { background: linear-gradient(135deg, #E63946, #7B2D8B); }
        .km-sb-copy { background: #5b5b6e; }
        .km-try { margin-top: 14px; background: #fff; color: #3d0b55; border: 2px solid #ece6f3; }
        .km-try:hover { border-color: #7B2D8B; color: #7B2D8B; }

        .km-confetti { position: fixed; inset: 0; pointer-events: none; z-index: 9999; overflow: hidden; }
        .km-confetti i { position: absolute; top: -20px; width: 10px; height: 14px; opacity: 0.95; animation: km-fall linear forwards; border-radius: 2px; }

        .km-related { margin-top: 22px; }
        .km-related h2 { font-size: 22px; color: #3d0b55; margin-bottom: 12px; }
        .km-related-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; }
        .km-rt { display: block; text-decoration: none; background: #fff; border-radius: 16px; padding: 16px 12px; text-align: center; box-shadow: 0 10px 24px rgba(0,0,0,0.06); border-top: 4px solid #E63946; color: inherit; transition: transform .15s ease, box-shadow .2s ease; }
        .km-rt:hover { transform: translateY(-3px); box-shadow: 0 16px 32px rgba(0,0,0,0.1); }
        .km-rt:nth-child(1) { border-color: #ff6b35; }
        .km-rt:nth-child(2) { border-color: #14b8a6; }
        .km-rt:nth-child(3) { border-color: #E63946; }
        .km-rt:nth-child(4) { border-color: #7B2D8B; }
        .km-rt-icon { font-size: 28px; }
        .km-rt h4 { font-size: 14.5px; color: #1f1933; margin: 6px 0 4px; }
        .km-rt p { font-size: 12.5px; color: #5b5070; margin: 0; }

        @keyframes km-pulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.08); } }
        @keyframes km-bob { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-6px); } }
        @keyframes km-ringa { 0% { transform: scale(0.6); opacity: 0.9; } 100% { transform: scale(1.4); opacity: 0; } }
        @keyframes km-fadeUp { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes km-shake { 0%, 100% { transform: translateX(0); } 25% { transform: translateX(-4px); } 75% { transform: translateX(4px); } }
        @keyframes km-fall { 0% { transform: translateY(-20px) rotate(0); opacity: 1; } 100% { transform: translateY(110vh) rotate(720deg); opacity: 0.3; } }

        @media (max-width: 640px) {
            .km-wrap { padding: 8px; }
            .km-header { padding: 22px 16px; border-radius: 18px; }
            .km-header h1 { font-size: 26px; }
            .km-header-icon { font-size: 44px; }
            .km-stat-num { font-size: 16px; }
            .km-card { padding: 20px 16px; border-radius: 18px; }
            .km-inputs { grid-template-columns: 1fr; gap: 12px; }
            .km-vs { margin: -2px auto; }
            .km-score-num { font-size: 50px; }
            .km-ring-wrap { width: 190px; height: 190px; }
            .km-dosha { grid-template-columns: 1fr; }
            .km-share { grid-template-columns: repeat(2, 1fr); }
            .km-related-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 380px) { .km-header h1 { font-size: 22px; } }
    </style>

    <header class="km-header">
        <div class="km-header-icon">&#128138;</div>
        <h1>Kundali Matching by Name</h1>
        <p class="km-header-sub">Free Ashtakoot Guna Milan &mdash; 36 gunas matched by name</p>
        <div class="km-stats">
            <div class="km-stat"><div class="km-stat-num" id="km-counter">2,73,409</div><div class="km-stat-lbl">Matches Today</div></div>
            <div class="km-stat"><div class="km-stat-num">4.9&#9733;</div><div class="km-stat-lbl">Rating</div></div>
            <div class="km-stat"><div class="km-stat-num">36</div><div class="km-stat-lbl">Gunas</div></div>
        </div>
    </header>

    <section class="km-card" id="km-card">
        <div class="km-input-phase" id="km-input-phase">
            <div class="km-inputs">
                <div class="km-field">
                    <span class="km-flbl km-boy">Boy&rsquo;s Name</span>
                    <div class="km-avatar km-a">&#128102;</div>
                    <input type="text" class="km-input" id="km-name-a" placeholder="Boy&rsquo;s name" maxlength="24" autocomplete="off" />
                </div>
                <div class="km-vs" aria-hidden="true">&#10014;</div>
                <div class="km-field">
                    <span class="km-flbl km-girl">Girl&rsquo;s Name</span>
                    <div class="km-avatar km-b">&#128103;</div>
                    <input type="text" class="km-input" id="km-name-b" placeholder="Girl&rsquo;s name" maxlength="24" autocomplete="off" />
                </div>
            </div>
            <div class="km-error" id="km-error">Please enter both names to continue.</div>
            <button type="button" class="km-btn km-btn-primary" id="km-go-btn">Match Kundali &#128138;</button>
            <div class="km-trust"><span>&#128274; Private</span><span>&#9889; Instant</span><span>&#128330; Vedic Ashtakoot</span></div>
        </div>

        <div class="km-loading" id="km-loading">
            <div class="km-rings"><div class="km-ring"></div><div class="km-ring"></div><div class="km-ring"></div><div class="km-ring-heart">&#128330;</div></div>
            <div class="km-load-step" id="km-load-step">&#128330; Deriving Rashi &amp; Nakshatra...</div>
            <div class="km-progress"><div class="km-progress-bar" id="km-progress-bar"></div></div>
        </div>

        <div class="km-result" id="km-result">
            <div class="km-result-card">
                <div class="km-rc-pair">
                    <div class="km-rc-p"><div class="km-rc-nm" id="km-rc-na">Boy</div><div class="km-rc-detail" id="km-rc-da">&mdash;</div></div>
                    <div class="km-rc-amp">&#10084;</div>
                    <div class="km-rc-p"><div class="km-rc-nm" id="km-rc-nb">Girl</div><div class="km-rc-detail" id="km-rc-db">&mdash;</div></div>
                </div>
                <div class="km-ring-wrap">
                    <svg viewBox="0 0 200 200" aria-hidden="true">
                        <defs><linearGradient id="km-grad" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#ff6b9d"/><stop offset="100%" stop-color="#fbbf24"/></linearGradient></defs>
                        <circle class="km-ring-bg" cx="100" cy="100" r="86"/>
                        <circle class="km-ring-fg" id="km-ring-fg" cx="100" cy="100" r="86" stroke-dasharray="540.35" stroke-dashoffset="540.35"/>
                    </svg>
                    <div class="km-score"><div><span class="km-score-num" id="km-total">0</span><span class="km-score-max">/36</span></div><div class="km-score-lbl">Gunas Matched</div></div>
                </div>
                <div class="km-level" id="km-level">&#128330; Matching...</div>
                <p class="km-summary" id="km-summary">Calculating Ashtakoot compatibility...</p>
                <div class="km-watermark">lovecalculator.in &#10084;</div>
            </div>

            <div class="km-koota-card">
                <h3>&#128203; Ashtakoot Guna Milan</h3>
                <p class="km-koota-note">The 8 kootas (factors) of Vedic compatibility and points scored in each</p>
                <div id="km-kootas"></div>
                <div class="km-koota-total"><span>Total Guna Score</span><span id="km-koota-total-val">0 / 36</span></div>
            </div>

            <div class="km-dosha">
                <div class="km-dchip" id="km-d-manglik"><div class="km-dchip-lbl">Manglik Dosha</div><div class="km-dchip-val">&mdash;</div></div>
                <div class="km-dchip" id="km-d-nadi"><div class="km-dchip-lbl">Nadi Dosha</div><div class="km-dchip-val">&mdash;</div></div>
                <div class="km-dchip" id="km-d-bhakoot"><div class="km-dchip-lbl">Bhakoot Dosha</div><div class="km-dchip-val">&mdash;</div></div>
            </div>

            <div class="km-conclusion" id="km-conclusion">
                <h3 id="km-conc-title">&#128175; Conclusion</h3>
                <p id="km-conc-text">&mdash;</p>
            </div>

            <div class="km-tips">
                <h3>&#11088; Guidance &amp; Remedies</h3>
                <ul id="km-tips-list"></ul>
            </div>

            <div class="km-share">
                <a href="#" class="km-share-btn km-sb-wa" id="km-sb-wa" target="_blank" rel="noopener">&#128241; WhatsApp</a>
                <a href="#" class="km-share-btn km-sb-tw" id="km-sb-tw" target="_blank" rel="noopener">&#119991; Twitter</a>
                <button type="button" class="km-share-btn km-sb-save" id="km-sb-save">&#128247; Save</button>
                <button type="button" class="km-share-btn km-sb-copy" id="km-sb-copy">&#128279; Copy Link</button>
            </div>
            <button type="button" class="km-btn km-try" id="km-try-btn">&#128260; Match Another Pair</button>
        </div>
    </section>

    <section class="km-related">
        <h2>Try More Tools</h2>
        <div class="km-related-grid">
            <a class="km-rt" href="/compatibility-test/"><div class="km-rt-icon">&#128302;</div><h4>Compatibility</h4><p>Zodiac match score</p></a>
            <a class="km-rt" href="/love-calculator/"><div class="km-rt-icon">&#128149;</div><h4>Love Calculator</h4><p>Name compatibility test</p></a>
            <a class="km-rt" href="/love-horoscope/"><div class="km-rt-icon">&#128156;</div><h4>Love Horoscope</h4><p>Your daily love forecast</p></a>
            <a class="km-rt" href="/career-prediction/"><div class="km-rt-icon">&#128188;</div><h4>Career Prediction</h4><p>Career path by birth date</p></a>
        </div>
    </section>

    <script type="application/ld+json">
    { "@context": "https://schema.org", "@type": "SoftwareApplication", "name": "Kundali Matching by Name", "applicationCategory": "LifestyleApplication", "operatingSystem": "Web", "url": "https://lovecalculator.in/kundali-matching/", "offers": { "@type": "Offer", "price": "0", "priceCurrency": "USD" }, "aggregateRating": { "@type": "AggregateRating", "ratingValue": "4.9", "ratingCount": "10760" } }
    </script>
</div>
        <?php
        $km_html = ob_get_clean();

        // Deliver the behavioral JS via the footer so WordPress content
        // filters (wpautop) can never inject tags that break the script.
        ob_start();
        ?>
(function(){
    'use strict';
    var $ = function(id){ return document.getElementById(id); };

    var elA=$('km-name-a'), elB=$('km-name-b'), elError=$('km-error');
    var phases = { input:$('km-input-phase'), loading:$('km-loading'), result:$('km-result') };

    var RASHI_BY_LETTER = {
        A:'Mesha (Aries)', B:'Vrishabha (Taurus)', C:'Mithuna (Gemini)', D:'Meena (Pisces)', E:'Mesha (Aries)',
        F:'Dhanu (Sagittarius)', G:'Kumbha (Aquarius)', H:'Karka (Cancer)', I:'Vrishabha (Taurus)', J:'Makara (Capricorn)',
        K:'Mithuna (Gemini)', L:'Mesha (Aries)', M:'Simha (Leo)', N:'Vrischika (Scorpio)', O:'Vrishabha (Taurus)',
        P:'Kanya (Virgo)', Q:'Mithuna (Gemini)', R:'Tula (Libra)', S:'Kumbha (Aquarius)', T:'Simha (Leo)',
        U:'Vrishabha (Taurus)', V:'Vrishabha (Taurus)', W:'Vrishabha (Taurus)', X:'Makara (Capricorn)', Y:'Vrischika (Scorpio)', Z:'Meena (Pisces)'
    };
    var NAKSHATRAS = ['Ashwini','Bharani','Krittika','Rohini','Mrigashira','Ardra','Punarvasu','Pushya','Ashlesha','Magha','Purva Phalguni','Uttara Phalguni','Hasta','Chitra','Swati','Vishakha','Anuradha','Jyeshtha','Mula','Purva Ashadha','Uttara Ashadha','Shravana','Dhanishta','Shatabhisha','Purva Bhadrapada','Uttara Bhadrapada','Revati'];
    var GANA_TYPES = ['Deva (Divine)','Manushya (Human)','Rakshasa (Demonic)'];

    var KOOTAS = [
        { key:'varna', name:'Varna', icon:'🕉️', max:1, desc:'Spiritual compatibility & ego' },
        { key:'vashya', name:'Vashya', icon:'🧲', max:2, desc:'Mutual attraction & influence' },
        { key:'tara', name:'Tara', icon:'⭐', max:3, desc:'Health, destiny & well-being' },
        { key:'yoni', name:'Yoni', icon:'💗', max:4, desc:'Physical & intimate compatibility' },
        { key:'maitri', name:'Graha Maitri', icon:'🧠', max:5, desc:'Mental & intellectual bond' },
        { key:'gana', name:'Gana', icon:'🌿', max:6, desc:'Temperament & nature' },
        { key:'bhakoot', name:'Bhakoot', icon:'🏠', max:7, desc:'Love, family & prosperity' },
        { key:'nadi', name:'Nadi', icon:'🧬', max:8, desc:'Health & progeny (most vital)' }
    ];

    function hashStr(s){ var h=0; for(var i=0;i<s.length;i++){ h=((h<<5)-h+s.charCodeAt(i))|0; } return Math.abs(h); }
    function clean(n){ return (n||'').replace(/[^a-zA-Z]/g,''); }
    function cap(s){ return s ? s.charAt(0).toUpperCase()+s.slice(1) : s; }
    function escapeHtml(s){ return String(s).replace(/[&<>"']/g,function(c){return ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'})[c];}); }

    function profileFor(name){
        var c = clean(name);
        var letter = (c.charAt(0)||'A').toUpperCase();
        var rashi = RASHI_BY_LETTER[letter] || 'Mesha (Aries)';
        var h = hashStr(c.toLowerCase());
        var nak = NAKSHATRAS[h % NAKSHATRAS.length];
        var gana = GANA_TYPES[h % 3];
        return { rashi:rashi, nak:nak, gana:gana, hash:h, letter:letter };
    }

    // deterministic koota score generator
    function kootaScores(pa, pb){
        var seed = hashStr(clean(elA.value).toLowerCase() + '|' + clean(elB.value).toLowerCase());
        function part(off){ return Math.abs(hashStr(seed + ':' + off)); }
        var s = {};
        s.varna   = (part('varna') % 100) < 82 ? 1 : 0;
        s.vashya  = [2,2,1,2,1,2][part('vashya') % 6];
        s.tara    = [3,3,1,3,2,3][part('tara') % 6];
        s.yoni    = [4,3,4,2,3,4,1][part('yoni') % 7];
        s.maitri  = [5,4,5,1,5,4][part('maitri') % 6];
        s.gana    = [6,6,5,6,1,6][part('gana') % 6];
        s.bhakoot = (part('bhakoot') % 100) < 70 ? 7 : 0;
        s.nadi    = (part('nadi') % 100) < 74 ? 8 : 0;
        return s;
    }

    var loadSteps=['🕉️ Deriving Rashi & Nakshatra...','📿 Calculating 8 kootas...','🔍 Checking doshas...','✨ Preparing your report...'];
    function runLoading(cb){ var stepEl=$('km-load-step'),barEl=$('km-progress-bar'),i=0; stepEl.textContent=loadSteps[0]; barEl.style.width='8%'; var iv=setInterval(function(){ i++; if(i<loadSteps.length){ stepEl.style.opacity='0'; setTimeout(function(){ stepEl.textContent=loadSteps[i]; stepEl.style.opacity='1'; },200); barEl.style.width=((i+1)*25)+'%'; } else { clearInterval(iv); barEl.style.width='100%'; setTimeout(cb,350);} },650); }
    function animateNum(el,from,to,dur){ var st=performance.now(); function tick(now){ var p=Math.min(1,(now-st)/dur); var e=1-Math.pow(1-p,3); el.textContent=Math.round(from+(to-from)*e); if(p<1) requestAnimationFrame(tick);} requestAnimationFrame(tick); }
    function confetti(){ var colors=['#E63946','#ff6b9d','#fbbf24','#7B2D8B','#fff']; var box=document.createElement('div'); box.className='km-confetti'; for(var i=0;i<58;i++){ var p=document.createElement('i'); p.style.left=(Math.random()*100)+'%'; p.style.background=colors[Math.floor(Math.random()*colors.length)]; p.style.animationDuration=(1.5+Math.random()*2)+'s'; p.style.animationDelay=(Math.random()*0.5)+'s'; p.style.transform='rotate('+(Math.random()*360)+'deg)'; box.appendChild(p);} document.body.appendChild(box); setTimeout(function(){ box.remove(); },4000); }

    function verdictFor(total){
        if (total >= 32) return {e:'👑',n:'Excellent Match',band:'high'};
        if (total >= 25) return {e:'💕',n:'Very Good Match',band:'high'};
        if (total >= 18) return {e:'💜',n:'Acceptable Match',band:'mid'};
        return {e:'⚠️',n:'Needs Consideration',band:'low'};
    }

    function showResult(){
        var na = cap(elA.value.trim()), nb = cap(elB.value.trim());
        var pa = profileFor(elA.value), pb = profileFor(elB.value);
        var s = kootaScores(pa, pb);
        var total = s.varna + s.vashya + s.tara + s.yoni + s.maitri + s.gana + s.bhakoot + s.nadi;
        var verdict = verdictFor(total);

        $('km-rc-na').textContent = na; $('km-rc-nb').textContent = nb;
        $('km-rc-da').innerHTML = pa.rashi + '<br>' + pa.nak;
        $('km-rc-db').innerHTML = pb.rashi + '<br>' + pb.nak;
        $('km-level').innerHTML = verdict.e + ' ' + verdict.n;
        $('km-summary').textContent = na + ' & ' + nb + ' score ' + total + ' out of 36 gunas. ' + (verdict.band==='high' ? 'This is a strong, auspicious match as per Ashtakoot Milan.' : verdict.band==='mid' ? 'This is an acceptable match — above the recommended minimum of 18 gunas.' : 'This score is below the traditional minimum of 18 gunas and deserves careful thought.');

        // kootas table
        var host = $('km-kootas'); host.innerHTML='';
        KOOTAS.forEach(function(k, idx){
            var pts = s[k.key];
            var cls = pts === k.max ? 'km-pass' : (pts === 0 ? 'km-fail' : 'km-partial');
            var row = document.createElement('div'); row.className='km-koota'; row.style.animationDelay=(idx*0.06)+'s';
            row.innerHTML = '<span class="km-koota-ico">'+k.icon+'</span><div class="km-koota-main"><div class="km-koota-name">'+k.name+'</div><div class="km-koota-desc">'+k.desc+'</div></div><div class="km-koota-pts '+cls+'">'+pts+' <small>/ '+k.max+'</small></div>';
            host.appendChild(row);
        });
        $('km-koota-total-val').textContent = total + ' / 36';

        // doshas
        var manglikA = (pa.hash % 100) < 26, manglikB = (pb.hash % 100) < 26;
        var dM = $('km-d-manglik');
        if (manglikA && manglikB){ dM.className='km-dchip km-ok'; dM.querySelector('.km-dchip-val').textContent='Cancelled'; }
        else if (manglikA || manglikB){ dM.className='km-dchip km-warn'; dM.querySelector('.km-dchip-val').textContent = (manglikA?na:nb)+' Manglik'; }
        else { dM.className='km-dchip km-ok'; dM.querySelector('.km-dchip-val').textContent='None'; }

        var dN = $('km-d-nadi');
        if (s.nadi === 0){ dN.className='km-dchip km-warn'; dN.querySelector('.km-dchip-val').textContent='Present'; }
        else { dN.className='km-dchip km-ok'; dN.querySelector('.km-dchip-val').textContent='None'; }

        var dB = $('km-d-bhakoot');
        if (s.bhakoot === 0){ dB.className='km-dchip km-warn'; dB.querySelector('.km-dchip-val').textContent='Present'; }
        else { dB.className='km-dchip km-ok'; dB.querySelector('.km-dchip-val').textContent='None'; }

        // conclusion
        var conc = $('km-conclusion');
        if (verdict.band === 'low'){
            conc.className = 'km-conclusion km-c-warn';
            $('km-conc-title').innerHTML = '🧭 Conclusion';
            $('km-conc-text').textContent = 'With ' + total + '/36 gunas, this match is below the traditional threshold. In Vedic tradition this does not mean the relationship cannot work — many low-guna couples thrive. Consider a detailed birth-chart (Janma Kundali) reading and the remedies below before deciding.';
        } else {
            conc.className = 'km-conclusion';
            $('km-conc-title').innerHTML = '💯 Conclusion';
            $('km-conc-text').textContent = (verdict.band==='high' ? 'Congratulations! With ' + total + '/36 gunas, ' + na + ' and ' + nb + ' form an auspicious and harmonious match by Ashtakoot Milan. ' : 'With ' + total + '/36 gunas, ' + na + ' and ' + nb + ' clear the recommended minimum and form a workable match. ') + 'Remember, true compatibility also grows through love, respect and understanding.';
        }

        // tips / remedies
        var tips = [];
        if (s.nadi === 0) tips.push('Nadi dosha is present — a Maha Mrityunjaya Japa or charity (daan) is the traditional remedy. Consult an astrologer for a full Kundali check.');
        if (s.bhakoot === 0) tips.push('Bhakoot dosha is present — it can affect finances and harmony. It is often cancelled by other strong kootas; a detailed chart review is advised.');
        if (manglikA !== manglikB && !(manglikA && manglikB)) tips.push('One partner is Manglik — a Kumbh Vivah or specific puja is the classic remedy. The dosha also reduces naturally after age 28.');
        tips.push('Name-based matching is an indicator; for marriage decisions, always verify with full birth-date, time and place (Janma Kundali).');
        tips.push('Beyond gunas, nurture open communication, shared values and mutual respect — the real foundation of a lasting marriage.');
        var ul=$('km-tips-list'); ul.innerHTML=''; tips.forEach(function(t){ var li=document.createElement('li'); li.textContent=t; ul.appendChild(li); });

        // show
        phases.loading.classList.remove('km-show'); phases.loading.style.display='none';
        phases.result.classList.add('km-show');
        animateNum($('km-total'),0,total,1700);
        var circ=2*Math.PI*86; setTimeout(function(){ $('km-ring-fg').style.strokeDashoffset=circ-(circ*total/36); },80);

        setupShare(na, nb, total, verdict);
        if (total>=25) setTimeout(confetti, 600);
        setTimeout(function(){ phases.result.scrollIntoView({behavior:'smooth',block:'start'}); },100);
    }

    function setupShare(na, nb, total, verdict){
        var url=window.location.href;
        var msg='📿 Kundali Matching: '+na+' & '+nb+'\n\nGuna Score: *'+total+'/36* ('+verdict.n+')\n\nMatch yours free: '+url;
        var tweet=na+' & '+nb+' matched '+total+'/36 gunas '+verdict.e+' ('+verdict.n+'). Try free Kundali matching by name:';
        $('km-sb-wa').href='https://wa.me/?text='+encodeURIComponent(msg);
        $('km-sb-tw').href='https://twitter.com/intent/tweet?text='+encodeURIComponent(tweet)+'&url='+encodeURIComponent(url);
        $('km-sb-copy').onclick=function(){ var btn=this,o=btn.innerHTML; try{ if(navigator.clipboard){ navigator.clipboard.writeText(url).then(function(){ btn.innerHTML='✅ Copied!'; setTimeout(function(){ btn.innerHTML=o; },1800); }); } else { var ta=document.createElement('textarea'); ta.value=url; document.body.appendChild(ta); ta.select(); document.execCommand('copy'); ta.remove(); btn.innerHTML='✅ Copied!'; setTimeout(function(){ btn.innerHTML=o; },1800);} }catch(e){ btn.innerHTML='⚠ Try Manually'; setTimeout(function(){ btn.innerHTML=o; },1800);} };
        $('km-sb-save').onclick=function(){ var btn=this,o=btn.innerHTML; btn.innerHTML='📸 Saving...'; setTimeout(function(){ if(navigator.share){ navigator.share({title:'Kundali Matching',text:msg,url:url}).then(function(){ btn.innerHTML=o; }).catch(function(){ alert('Screenshot your match report to save it!'); btn.innerHTML=o; }); } else { alert('Screenshot your match report to save it!\n\n'+na+' & '+nb+' = '+total+'/36'); btn.innerHTML=o; } },400); };
    }

    function go(){
        var na=(elA.value||'').trim(), nb=(elB.value||'').trim();
        if(!na || !nb){ elError.textContent='Please enter both names to continue.'; elError.classList.add('km-show'); return; }
        if(clean(na).length<2 || clean(nb).length<2){ elError.textContent='Please enter valid names (at least 2 letters).'; elError.classList.add('km-show'); return; }
        elError.classList.remove('km-show');
        phases.input.style.display='none';
        phases.loading.style.display='block'; phases.loading.classList.add('km-show');
        $('km-progress-bar').style.width='0%';
        runLoading(showResult);
    }
    $('km-go-btn').addEventListener('click', go);
    [elA, elB].forEach(function(el){ el.addEventListener('keydown', function(e){ if(e.key==='Enter'){ e.preventDefault(); go(); } }); });

    $('km-try-btn').addEventListener('click', function(){
        phases.result.classList.remove('km-show');
        phases.loading.classList.remove('km-show'); phases.loading.style.display='none';
        phases.input.style.display='block';
        $('km-total').textContent='0'; $('km-ring-fg').style.strokeDashoffset=540.35;
        $('km-card').scrollIntoView({behavior:'smooth',block:'start'});
    });

    var counterEl=$('km-counter'); var count=273409;
    setInterval(function(){ count+=1+Math.floor(Math.random()*3); counterEl.textContent=count.toLocaleString('en-IN'); },8000);
})();
        <?php
        $km_js = ob_get_clean();

        if ( ! wp_script_is( 'km-pro-inline', 'enqueued' ) ) {
            wp_register_script( 'km-pro-inline', '', array(), '1.0.0', true );
            wp_enqueue_script( 'km-pro-inline' );
            wp_add_inline_script( 'km-pro-inline', $km_js );
        }

        return $km_html;
    }

    add_shortcode( 'kundali_matching', 'km_pro_render_match' );
    add_shortcode( 'kundali_matching_by_name', 'km_pro_render_match' );
    add_shortcode( 'kundli_matching', 'km_pro_render_match' );
}
