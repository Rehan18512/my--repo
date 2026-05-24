<?php
/**
 * Plugin Name: Love Horoscope Today
 * Plugin URI: https://lovecalculator.in
 * Description: Premium daily Love Horoscope with zodiac picker, animated love score, lucky color/number/time, best-match sign, mood meters, singles & couples advice, golden tips and share cards. Use shortcode [love_horoscope].
 * Version: 1.0.0
 * Author: lovecalculator.in
 * Author URI: https://lovecalculator.in
 * License: GPL-2.0+
 * Text Domain: love-horoscope-today
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! function_exists( 'lh_pro_render_horoscope' ) ) {

    function lh_pro_render_horoscope( $atts = array() ) {
        ob_start();
        ?>
<div class="lh-wrap" id="lh-wrap">
    <style>
        .lh-wrap, .lh-wrap *, .lh-wrap *::before, .lh-wrap *::after { box-sizing: border-box; }
        .lh-wrap { font-family: 'DM Sans', 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; color: #1f1933; max-width: 880px; margin: 0 auto; padding: 12px; line-height: 1.55; }
        .lh-wrap h1, .lh-wrap h2, .lh-wrap h3, .lh-wrap h4 { font-family: 'Poppins', 'Syne', system-ui, sans-serif; font-weight: 800; letter-spacing: -0.01em; margin: 0; }

        /* Header */
        .lh-header { background: linear-gradient(135deg, #1a0533 0%, #3d0b55 50%, #690d3a 100%); border-radius: 22px; padding: 28px 20px; color: #fff; text-align: center; box-shadow: 0 20px 60px rgba(105, 13, 58, 0.25); position: relative; overflow: hidden; }
        .lh-header::before { content: ""; position: absolute; inset: -50%; background: radial-gradient(circle at 30% 20%, rgba(230,57,70,0.18), transparent 60%), radial-gradient(circle at 70% 80%, rgba(123,45,139,0.25), transparent 60%); pointer-events: none; }
        .lh-header-icon { font-size: 50px; line-height: 1; display: inline-block; animation: lh-bob 2.4s ease-in-out infinite; }
        .lh-header h1 { font-size: 38px; margin: 8px 0 6px; color: #fff; }
        .lh-header-sub { opacity: 0.86; font-size: 15px; margin: 0; }
        .lh-date { display: inline-block; margin-top: 14px; background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.22); padding: 7px 16px; border-radius: 999px; font-size: 13.5px; font-weight: 600; }
        .lh-stats { display: flex; align-items: center; justify-content: center; gap: 0; margin-top: 14px; flex-wrap: wrap; }
        .lh-stat { padding: 4px 14px; min-width: 96px; }
        .lh-stat-num { font-weight: 800; font-family: 'Poppins', sans-serif; font-size: 18px; color: #fff; }
        .lh-stat-lbl { font-size: 11px; opacity: 0.78; text-transform: uppercase; letter-spacing: 0.06em; }
        .lh-stat + .lh-stat { border-left: 1px solid rgba(255,255,255,0.22); }

        /* Card shell */
        .lh-card { background: #fff; border-radius: 22px; padding: 24px 20px; margin-top: 18px; box-shadow: 0 20px 60px rgba(0,0,0,0.08); border: 1px solid #f1ecf6; }
        .lh-card-title { font-size: 20px; color: #3d0b55; text-align: center; margin-bottom: 4px; }
        .lh-card-note { text-align: center; font-size: 13.5px; color: #6b5e85; margin: 0 0 18px; }

        /* Sign grid */
        .lh-signs { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; }
        .lh-sign { position: relative; background: #faf8fd; border: 2px solid #ece6f3; border-radius: 16px; padding: 14px 8px; text-align: center; cursor: pointer; transition: transform .15s ease, border-color .2s, box-shadow .2s, background .2s; }
        .lh-sign:hover { transform: translateY(-3px); border-color: #b558d6; box-shadow: 0 12px 26px rgba(123,45,139,0.16); }
        .lh-sign.lh-active { border-color: #E63946; background: linear-gradient(135deg, #fff, #fff4f6); box-shadow: 0 12px 30px rgba(230,57,70,0.18); }
        .lh-sign.lh-active::after { content: "\2714"; position: absolute; top: 8px; right: 8px; width: 20px; height: 20px; background: #E63946; color: #fff; border-radius: 50%; font-size: 11px; display: flex; align-items: center; justify-content: center; }
        .lh-sign-icon { font-size: 30px; line-height: 1; }
        .lh-sign-name { font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 14px; color: #2d2447; margin-top: 6px; }
        .lh-sign-date { font-size: 11px; color: #8a7ba3; margin-top: 2px; }

        .lh-error { display: none; background: #fff1f2; color: #b3162a; border: 1px solid #ffd6db; padding: 10px 14px; border-radius: 12px; margin-top: 14px; font-size: 14px; text-align: center; }
        .lh-error.lh-show { display: block; animation: lh-shake .4s; }
        .lh-btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; min-height: 56px; padding: 18px 22px; font-size: 17px; font-weight: 700; font-family: 'Poppins', sans-serif; border: none; border-radius: 14px; cursor: pointer; width: 100%; transition: transform .15s ease, box-shadow .2s ease, opacity .2s; }
        .lh-btn-primary { background: linear-gradient(135deg, #E63946, #c81e2c); color: #fff; box-shadow: 0 14px 32px rgba(230,57,70,0.35); margin-top: 18px; }
        .lh-btn-primary:hover { transform: translateY(-2px); box-shadow: 0 18px 40px rgba(230,57,70,0.45); }
        .lh-btn-primary:active { transform: translateY(0); }
        .lh-trust { display: flex; gap: 10px; justify-content: center; flex-wrap: wrap; margin-top: 14px; }
        .lh-trust span { font-size: 12.5px; color: #5b5070; background: #f6f0fb; padding: 6px 12px; border-radius: 999px; min-height: 30px; display: inline-flex; align-items: center; }

        /* Loading */
        .lh-loading { display: none; text-align: center; padding: 14px 8px 6px; }
        .lh-loading.lh-show { display: block; }
        .lh-rings { position: relative; width: 160px; height: 160px; margin: 6px auto 18px; }
        .lh-ring { position: absolute; inset: 0; border-radius: 50%; border: 3px solid rgba(230,57,70,0.35); animation: lh-ring 2s ease-out infinite; }
        .lh-ring:nth-child(2) { animation-delay: .5s; border-color: rgba(123,45,139,0.4); }
        .lh-ring:nth-child(3) { animation-delay: 1s; border-color: rgba(255,107,157,0.45); }
        .lh-ring-heart { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; font-size: 58px; animation: lh-pulse 1.2s ease-in-out infinite; }
        .lh-load-sign { font-size: 18px; font-weight: 700; font-family: 'Poppins', sans-serif; color: #3d0b55; margin-bottom: 12px; }
        .lh-load-step { font-size: 15px; color: #6b5e85; min-height: 24px; transition: opacity .25s; }
        .lh-progress { height: 8px; background: #f1ebf7; border-radius: 999px; overflow: hidden; margin: 14px auto 4px; max-width: 360px; }
        .lh-progress-bar { height: 100%; width: 0%; background: linear-gradient(90deg, #E63946, #7B2D8B); border-radius: 999px; transition: width .3s ease; }

        /* Result */
        .lh-result { display: none; }
        .lh-result.lh-show { display: block; animation: lh-fadeUp .55s ease both; }
        .lh-result-card { background: linear-gradient(135deg, #1a0533, #3d0b55, #690d3a); color: #fff; border-radius: 22px; padding: 28px 20px; text-align: center; box-shadow: 0 20px 60px rgba(0,0,0,0.25); position: relative; overflow: hidden; }
        .lh-result-card::after { content: ""; position: absolute; inset: 0; background: radial-gradient(circle at 20% 10%, rgba(230,57,70,0.25), transparent 50%), radial-gradient(circle at 80% 90%, rgba(255,107,157,0.18), transparent 55%); pointer-events: none; }
        .lh-rc-sign { display: flex; align-items: center; justify-content: center; gap: 12px; flex-wrap: wrap; margin-bottom: 4px; position: relative; z-index: 1; }
        .lh-rc-sign-icon { font-size: 38px; }
        .lh-rc-sign-name { font-family: 'Poppins', sans-serif; font-weight: 800; font-size: 24px; }
        .lh-rc-meta { font-size: 13px; opacity: 0.82; position: relative; z-index: 1; margin-bottom: 6px; }
        .lh-ring-wrap { position: relative; width: 210px; height: 210px; margin: 12px auto 8px; z-index: 1; }
        .lh-ring-wrap svg { transform: rotate(-90deg); width: 100%; height: 100%; }
        .lh-ring-bg { fill: none; stroke: rgba(255,255,255,0.12); stroke-width: 12; }
        .lh-ring-fg { fill: none; stroke: url(#lh-grad); stroke-width: 12; stroke-linecap: round; transition: stroke-dashoffset 1.8s cubic-bezier(.22,.9,.3,1); }
        .lh-percent { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; flex-direction: column; }
        .lh-percent-num { font-size: 60px; font-weight: 800; font-family: 'Poppins', sans-serif; line-height: 1; }
        .lh-percent-sym { font-size: 22px; font-weight: 700; opacity: 0.85; }
        .lh-percent-lbl { font-size: 12px; opacity: 0.8; text-transform: uppercase; letter-spacing: 0.08em; margin-top: 2px; }
        .lh-level { display: inline-block; background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.22); padding: 8px 18px; border-radius: 999px; font-weight: 700; font-family: 'Poppins', sans-serif; font-size: 15px; margin: 4px 0 10px; position: relative; z-index: 1; }
        .lh-forecast { max-width: 600px; margin: 0 auto; opacity: 0.94; font-size: 15.5px; position: relative; z-index: 1; }
        .lh-watermark { margin-top: 16px; font-size: 12.5px; opacity: 0.7; position: relative; z-index: 1; }

        /* Lucky chips */
        .lh-lucky { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin-top: 18px; }
        .lh-luck { background: #fff; border-radius: 16px; padding: 16px 10px; text-align: center; box-shadow: 0 10px 24px rgba(0,0,0,0.06); border-top: 4px solid #E63946; }
        .lh-luck:nth-child(1) { border-color: #E63946; }
        .lh-luck:nth-child(2) { border-color: #7B2D8B; }
        .lh-luck:nth-child(3) { border-color: #2563eb; }
        .lh-luck:nth-child(4) { border-color: #14b8a6; }
        .lh-luck-lbl { font-size: 11.5px; color: #8a7ba3; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 700; }
        .lh-luck-val { font-family: 'Poppins', sans-serif; font-weight: 800; font-size: 17px; color: #2d2447; margin-top: 4px; display: flex; align-items: center; justify-content: center; gap: 6px; }
        .lh-swatch { width: 16px; height: 16px; border-radius: 50%; border: 1px solid rgba(0,0,0,0.15); display: inline-block; }

        /* Mode toggle */
        .lh-toggle { display: flex; background: #f1ebf7; border-radius: 14px; padding: 5px; margin-top: 18px; gap: 5px; }
        .lh-toggle button { flex: 1; min-height: 44px; border: none; background: transparent; font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 14px; color: #6b5e85; border-radius: 10px; cursor: pointer; transition: background .2s, color .2s, box-shadow .2s; }
        .lh-toggle button.lh-on { background: #fff; color: #7B2D8B; box-shadow: 0 6px 16px rgba(0,0,0,0.08); }
        .lh-mode { background: linear-gradient(135deg, #f6f0fb, #efe6f8); border-radius: 18px; padding: 18px 18px; margin-top: 12px; border: 1px solid #e6d8f3; }
        .lh-mode h3 { font-size: 16px; color: #5b1d72; margin-bottom: 6px; }
        .lh-mode p { font-size: 14.5px; color: #4a3f63; margin: 0; }

        /* Mood bars */
        .lh-bars { margin-top: 18px; }
        .lh-bar-row { margin: 14px 0; }
        .lh-bar-top { display: flex; justify-content: space-between; font-size: 14px; font-weight: 600; color: #2d2447; margin-bottom: 6px; }
        .lh-bar-top span:last-child { color: #7B2D8B; font-family: 'Poppins', sans-serif; font-weight: 800; }
        .lh-bar { height: 10px; background: #f1ebf7; border-radius: 999px; overflow: hidden; }
        .lh-bar-fill { height: 100%; width: 0%; border-radius: 999px; background: linear-gradient(90deg, #E63946, #7B2D8B); transition: width 1.5s cubic-bezier(.22,.9,.3,1); }

        /* Golden tips */
        .lh-tips { background: linear-gradient(135deg, #fff8dc, #fff1c1); border-radius: 18px; padding: 20px; margin-top: 18px; border: 1px solid #f7e190; }
        .lh-tips h3 { font-size: 19px; color: #7a5a05; margin-bottom: 12px; }
        .lh-tips-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; }
        .lh-tip { background: #fff; border-radius: 14px; padding: 14px; border-left: 4px solid #E63946; box-shadow: 0 8px 20px rgba(0,0,0,0.05); opacity: 0; transform: translateY(8px); animation: lh-fadeUp .5s ease forwards; }
        .lh-tip-icon { font-size: 22px; margin-bottom: 4px; }
        .lh-tip h4 { font-size: 14.5px; color: #3d0b55; margin-bottom: 4px; }
        .lh-tip p { font-size: 13px; color: #5b5070; margin: 0; }

        /* Share */
        .lh-share { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin-top: 18px; }
        .lh-share-btn { display: inline-flex; align-items: center; justify-content: center; gap: 6px; min-height: 48px; padding: 12px 8px; font-size: 14px; font-weight: 700; font-family: 'Poppins', sans-serif; border-radius: 12px; border: none; cursor: pointer; color: #fff; text-decoration: none; transition: transform .15s ease, box-shadow .15s ease; }
        .lh-share-btn:hover { transform: translateY(-2px); box-shadow: 0 12px 26px rgba(0,0,0,0.15); }
        .lh-sb-wa { background: #25d366; }
        .lh-sb-tw { background: #111; }
        .lh-sb-save { background: linear-gradient(135deg, #E63946, #7B2D8B); }
        .lh-sb-copy { background: #5b5b6e; }

        .lh-try { margin-top: 14px; background: #fff; color: #3d0b55; border: 2px solid #ece6f3; }
        .lh-try:hover { border-color: #7B2D8B; color: #7B2D8B; }

        /* Confetti */
        .lh-confetti { position: fixed; inset: 0; pointer-events: none; z-index: 9999; overflow: hidden; }
        .lh-confetti i { position: absolute; top: -20px; width: 10px; height: 14px; opacity: 0.95; animation: lh-fall linear forwards; border-radius: 2px; }

        /* All-signs reference */
        .lh-all { margin-top: 22px; }
        .lh-all h2 { font-size: 22px; color: #3d0b55; margin-bottom: 12px; text-align: center; }
        .lh-all-grid { display: grid; grid-template-columns: repeat(6, 1fr); gap: 10px; }
        .lh-all-item { background: #fff; border-radius: 14px; padding: 12px 6px; text-align: center; box-shadow: 0 8px 20px rgba(0,0,0,0.05); border: 1px solid #f1ecf6; cursor: pointer; transition: transform .15s ease, box-shadow .2s; }
        .lh-all-item:hover { transform: translateY(-3px); box-shadow: 0 14px 30px rgba(0,0,0,0.1); }
        .lh-all-icon { font-size: 24px; }
        .lh-all-name { font-size: 11.5px; font-weight: 700; font-family: 'Poppins', sans-serif; color: #2d2447; margin-top: 4px; }

        /* Related tools */
        .lh-related { margin-top: 22px; }
        .lh-related h2 { font-size: 22px; color: #3d0b55; margin-bottom: 12px; }
        .lh-related-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; }
        .lh-rt { display: block; text-decoration: none; background: #fff; border-radius: 16px; padding: 16px 12px; text-align: center; box-shadow: 0 10px 24px rgba(0,0,0,0.06); border-top: 4px solid #E63946; color: inherit; transition: transform .15s ease, box-shadow .2s ease; }
        .lh-rt:hover { transform: translateY(-3px); box-shadow: 0 16px 32px rgba(0,0,0,0.1); }
        .lh-rt:nth-child(1) { border-color: #ff6b35; }
        .lh-rt:nth-child(2) { border-color: #14b8a6; }
        .lh-rt:nth-child(3) { border-color: #E63946; }
        .lh-rt:nth-child(4) { border-color: #7B2D8B; }
        .lh-rt-icon { font-size: 28px; }
        .lh-rt h4 { font-size: 14.5px; color: #1f1933; margin: 6px 0 4px; }
        .lh-rt p { font-size: 12.5px; color: #5b5070; margin: 0; }

        /* Animations */
        @keyframes lh-pulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.08); } }
        @keyframes lh-bob { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-6px); } }
        @keyframes lh-ring { 0% { transform: scale(0.6); opacity: 0.9; } 100% { transform: scale(1.4); opacity: 0; } }
        @keyframes lh-fadeUp { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes lh-shake { 0%, 100% { transform: translateX(0); } 25% { transform: translateX(-4px); } 75% { transform: translateX(4px); } }
        @keyframes lh-fall { 0% { transform: translateY(-20px) rotate(0); opacity: 1; } 100% { transform: translateY(110vh) rotate(720deg); opacity: 0.3; } }

        /* Mobile */
        @media (max-width: 640px) {
            .lh-wrap { padding: 8px; }
            .lh-header { padding: 22px 16px; border-radius: 18px; }
            .lh-header h1 { font-size: 30px; }
            .lh-header-icon { font-size: 44px; }
            .lh-stat-num { font-size: 16px; }
            .lh-card { padding: 20px 16px; border-radius: 18px; }
            .lh-signs { grid-template-columns: repeat(3, 1fr); }
            .lh-percent-num { font-size: 52px; }
            .lh-ring-wrap { width: 190px; height: 190px; }
            .lh-lucky { grid-template-columns: repeat(2, 1fr); }
            .lh-share { grid-template-columns: repeat(2, 1fr); }
            .lh-tips-grid { grid-template-columns: 1fr; }
            .lh-all-grid { grid-template-columns: repeat(4, 1fr); }
            .lh-related-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 380px) {
            .lh-header h1 { font-size: 26px; }
            .lh-signs { grid-template-columns: repeat(2, 1fr); }
            .lh-all-grid { grid-template-columns: repeat(3, 1fr); }
        }
    </style>

    <!-- Header -->
    <header class="lh-header">
        <div class="lh-header-icon">&#128156;</div>
        <h1>Love Horoscope Today</h1>
        <p class="lh-header-sub">Your daily love &amp; relationship forecast by the stars</p>
        <div class="lh-date" id="lh-date">Loading today&rsquo;s date&hellip;</div>
        <div class="lh-stats">
            <div class="lh-stat">
                <div class="lh-stat-num" id="lh-counter">2,18,640</div>
                <div class="lh-stat-lbl">Readings Today</div>
            </div>
            <div class="lh-stat">
                <div class="lh-stat-num">4.9&#9733;</div>
                <div class="lh-stat-lbl">Rating</div>
            </div>
            <div class="lh-stat">
                <div class="lh-stat-num">12</div>
                <div class="lh-stat-lbl">Zodiac Signs</div>
            </div>
        </div>
    </header>

    <!-- Picker card -->
    <section class="lh-card" id="lh-pick-card">
        <div class="lh-input-phase" id="lh-input-phase">
            <h2 class="lh-card-title">Choose Your Zodiac Sign</h2>
            <p class="lh-card-note">Tap your sun sign to reveal today&rsquo;s love forecast</p>
            <div class="lh-signs" id="lh-signs"></div>
            <div class="lh-error" id="lh-error">Please select your zodiac sign first.</div>
            <button type="button" class="lh-btn lh-btn-primary" id="lh-go-btn">Reveal My Love Forecast &#128156;</button>
            <div class="lh-trust">
                <span>&#128274; Private</span>
                <span>&#9889; Instant</span>
                <span>&#127378; Free Daily</span>
            </div>
        </div>

        <!-- Loading -->
        <div class="lh-loading" id="lh-loading">
            <div class="lh-rings">
                <div class="lh-ring"></div>
                <div class="lh-ring"></div>
                <div class="lh-ring"></div>
                <div class="lh-ring-heart">&#10024;</div>
            </div>
            <div class="lh-load-sign" id="lh-load-sign">&#10024;</div>
            <div class="lh-load-step" id="lh-load-step">&#128300; Aligning the stars&hellip;</div>
            <div class="lh-progress"><div class="lh-progress-bar" id="lh-progress-bar"></div></div>
        </div>

        <!-- Result -->
        <div class="lh-result" id="lh-result">
            <div class="lh-result-card">
                <div class="lh-rc-sign">
                    <span class="lh-rc-sign-icon" id="lh-rc-icon">&#9800;</span>
                    <span class="lh-rc-sign-name" id="lh-rc-name">Aries</span>
                </div>
                <div class="lh-rc-meta" id="lh-rc-meta">Fire &middot; Ruled by Mars</div>
                <div class="lh-ring-wrap">
                    <svg viewBox="0 0 200 200" aria-hidden="true">
                        <defs>
                            <linearGradient id="lh-grad" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#ff6b9d"/>
                                <stop offset="100%" stop-color="#fbbf24"/>
                            </linearGradient>
                        </defs>
                        <circle class="lh-ring-bg" cx="100" cy="100" r="86"/>
                        <circle class="lh-ring-fg" id="lh-ring-fg" cx="100" cy="100" r="86" stroke-dasharray="540.35" stroke-dashoffset="540.35"/>
                    </svg>
                    <div class="lh-percent">
                        <div><span class="lh-percent-num" id="lh-pct">0</span><span class="lh-percent-sym">%</span></div>
                        <div class="lh-percent-lbl">Love Energy</div>
                    </div>
                </div>
                <div class="lh-level" id="lh-level">&#128156; Reading&hellip;</div>
                <p class="lh-forecast" id="lh-forecast">Your stars are aligning&hellip;</p>
                <div class="lh-watermark">lovecalculator.in &#10084;</div>
            </div>

            <!-- Lucky chips -->
            <div class="lh-lucky">
                <div class="lh-luck">
                    <div class="lh-luck-lbl">Lucky Color</div>
                    <div class="lh-luck-val" id="lh-luck-color"><span class="lh-swatch" id="lh-luck-swatch"></span><span id="lh-luck-color-name">&mdash;</span></div>
                </div>
                <div class="lh-luck">
                    <div class="lh-luck-lbl">Lucky Number</div>
                    <div class="lh-luck-val" id="lh-luck-num">&mdash;</div>
                </div>
                <div class="lh-luck">
                    <div class="lh-luck-lbl">Lucky Time</div>
                    <div class="lh-luck-val" id="lh-luck-time">&mdash;</div>
                </div>
                <div class="lh-luck">
                    <div class="lh-luck-lbl">Best Match</div>
                    <div class="lh-luck-val" id="lh-luck-match">&mdash;</div>
                </div>
            </div>

            <!-- Singles / Couples toggle -->
            <div class="lh-toggle">
                <button type="button" class="lh-on" id="lh-tab-single">&#128150; For Singles</button>
                <button type="button" id="lh-tab-couple">&#128141; For Couples</button>
            </div>
            <div class="lh-mode">
                <h3 id="lh-mode-title">&#128150; If You&rsquo;re Single</h3>
                <p id="lh-mode-text">&mdash;</p>
            </div>

            <!-- Mood bars -->
            <div class="lh-bars">
                <div class="lh-bar-row">
                    <div class="lh-bar-top"><span>&#128150; Romance</span><span id="lh-b1-v">0%</span></div>
                    <div class="lh-bar"><div class="lh-bar-fill" id="lh-b1"></div></div>
                </div>
                <div class="lh-bar-row">
                    <div class="lh-bar-top"><span>&#128293; Passion</span><span id="lh-b2-v">0%</span></div>
                    <div class="lh-bar"><div class="lh-bar-fill" id="lh-b2"></div></div>
                </div>
                <div class="lh-bar-row">
                    <div class="lh-bar-top"><span>&#9774; Harmony</span><span id="lh-b3-v">0%</span></div>
                    <div class="lh-bar"><div class="lh-bar-fill" id="lh-b3"></div></div>
                </div>
                <div class="lh-bar-row">
                    <div class="lh-bar-top"><span>&#128172; Communication</span><span id="lh-b4-v">0%</span></div>
                    <div class="lh-bar"><div class="lh-bar-fill" id="lh-b4"></div></div>
                </div>
            </div>

            <!-- Golden tips -->
            <div class="lh-tips">
                <h3 id="lh-tips-title">&#11088; Today&rsquo;s Golden Love Tips</h3>
                <div class="lh-tips-grid" id="lh-tips-grid"></div>
            </div>

            <!-- Share -->
            <div class="lh-share">
                <a href="#" class="lh-share-btn lh-sb-wa" id="lh-sb-wa" target="_blank" rel="noopener">&#128241; WhatsApp</a>
                <a href="#" class="lh-share-btn lh-sb-tw" id="lh-sb-tw" target="_blank" rel="noopener">&#119991; Twitter</a>
                <button type="button" class="lh-share-btn lh-sb-save" id="lh-sb-save">&#128247; Save Card</button>
                <button type="button" class="lh-share-btn lh-sb-copy" id="lh-sb-copy">&#128279; Copy Link</button>
            </div>

            <button type="button" class="lh-btn lh-try" id="lh-try-btn">&#128260; Check Another Sign</button>
        </div>
    </section>

    <!-- All signs reference -->
    <section class="lh-all">
        <h2>All 12 Zodiac Signs</h2>
        <div class="lh-all-grid" id="lh-all-grid"></div>
    </section>

    <!-- Related tools -->
    <section class="lh-related">
        <h2>Try More Love Tools</h2>
        <div class="lh-related-grid">
            <a class="lh-rt" href="/love-calculator/"><div class="lh-rt-icon">&#128149;</div><h4>Love Calculator</h4><p>Test your name compatibility instantly</p></a>
            <a class="lh-rt" href="/couple-nickname-generator/"><div class="lh-rt-icon">&#128139;</div><h4>Couple Nicknames</h4><p>Cute pet names for you two</p></a>
            <a class="lh-rt" href="/love-message-generator/"><div class="lh-rt-icon">&#128140;</div><h4>Love Messages</h4><p>Sweet messages for any moment</p></a>
            <a class="lh-rt" href="/compatibility-test/"><div class="lh-rt-icon">&#128302;</div><h4>Compatibility</h4><p>Deep zodiac &amp; personality match</p></a>
        </div>
    </section>

    <!-- Schema -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "SoftwareApplication",
      "name": "Love Horoscope Today",
      "applicationCategory": "LifestyleApplication",
      "operatingSystem": "Web",
      "url": "https://lovecalculator.in/love-horoscope/",
      "offers": { "@type": "Offer", "price": "0", "priceCurrency": "USD" },
      "aggregateRating": { "@type": "AggregateRating", "ratingValue": "4.9", "ratingCount": "9648" }
    }
    </script>
</div>

<script>
(function(){
    'use strict';
    var $ = function(id){ return document.getElementById(id); };

    var SIGNS = [
        { key: 'aries',       name: 'Aries',       icon: '♈', dates: 'Mar 21 - Apr 19', element: 'Fire',  planet: 'Mars',    match: 'Leo' },
        { key: 'taurus',      name: 'Taurus',      icon: '♉', dates: 'Apr 20 - May 20', element: 'Earth', planet: 'Venus',   match: 'Cancer' },
        { key: 'gemini',      name: 'Gemini',      icon: '♊', dates: 'May 21 - Jun 20', element: 'Air',   planet: 'Mercury', match: 'Libra' },
        { key: 'cancer',      name: 'Cancer',      icon: '♋', dates: 'Jun 21 - Jul 22', element: 'Water', planet: 'Moon',    match: 'Scorpio' },
        { key: 'leo',         name: 'Leo',         icon: '♌', dates: 'Jul 23 - Aug 22', element: 'Fire',  planet: 'Sun',     match: 'Sagittarius' },
        { key: 'virgo',       name: 'Virgo',       icon: '♍', dates: 'Aug 23 - Sep 22', element: 'Earth', planet: 'Mercury', match: 'Taurus' },
        { key: 'libra',       name: 'Libra',       icon: '♎', dates: 'Sep 23 - Oct 22', element: 'Air',   planet: 'Venus',   match: 'Gemini' },
        { key: 'scorpio',     name: 'Scorpio',     icon: '♏', dates: 'Oct 23 - Nov 21', element: 'Water', planet: 'Pluto',   match: 'Cancer' },
        { key: 'sagittarius', name: 'Sagittarius', icon: '♐', dates: 'Nov 22 - Dec 21', element: 'Fire',  planet: 'Jupiter', match: 'Aries' },
        { key: 'capricorn',   name: 'Capricorn',   icon: '♑', dates: 'Dec 22 - Jan 19', element: 'Earth', planet: 'Saturn',  match: 'Virgo' },
        { key: 'aquarius',    name: 'Aquarius',    icon: '♒', dates: 'Jan 20 - Feb 18', element: 'Air',   planet: 'Uranus',  match: 'Gemini' },
        { key: 'pisces',      name: 'Pisces',      icon: '♓', dates: 'Feb 19 - Mar 20', element: 'Water', planet: 'Neptune', match: 'Scorpio' }
    ];

    var COLORS = [
        { n: 'Rose Red', c: '#E63946' }, { n: 'Royal Purple', c: '#7B2D8B' }, { n: 'Soft Pink', c: '#ff6b9d' },
        { n: 'Golden Amber', c: '#fbbf24' }, { n: 'Ocean Blue', c: '#2563eb' }, { n: 'Emerald', c: '#10b981' },
        { n: 'Coral', c: '#ff6b35' }, { n: 'Teal', c: '#14b8a6' }, { n: 'Lavender', c: '#a78bfa' },
        { n: 'Ruby', c: '#be123c' }, { n: 'Sky Blue', c: '#38bdf8' }, { n: 'Magenta', c: '#c026d3' }
    ];
    var TIMES = ['6:00 AM', '8:30 AM', '11:00 AM', '1:15 PM', '3:00 PM', '5:30 PM', '7:00 PM', '9:00 PM', '10:30 PM'];

    var FORECASTS = [
        'The cosmos is turning up the warmth in your love life today. A heartfelt conversation could deepen a bond you already treasure. Let your guard down a little &mdash; vulnerability is your superpower right now.',
        'Venus is smiling on your romantic side. Small gestures carry big meaning today, so a kind word or a gentle touch can rewrite the whole mood. Trust the soft pull of your heart.',
        'Today rewards honesty in matters of the heart. Say the thing you have been holding back &mdash; the stars are clearing the path for a beautiful response. Courage and tenderness make a winning pair.',
        'A spark of fresh energy lights up your connections. Whether new or familiar, love feels playful and alive today. Follow the laughter; it leads exactly where you need to go.',
        'The planets nudge you toward emotional balance. If something has felt off, today is perfect for a gentle reset. Listen more than you speak and watch the harmony return.',
        'Romance hums quietly beneath the surface today. Patience is your ally &mdash; let things unfold naturally instead of forcing them. The right moment is closer than you think.',
        'Your magnetic charm is dialed up under today&rsquo;s sky. People are drawn to your warmth, so share it generously. A meaningful glance or message could change everything.',
        'The Moon stirs deep feelings, inviting you to reconnect with what truly matters in love. Choose closeness over being right. Tenderness opens doors that pride keeps shut.',
        'Today favors bold, loving moves. If your heart has been whispering, let it speak out loud. The universe loves a brave romantic and is ready to meet you halfway.',
        'A wave of calm settles over your relationships. Old tension softens and understanding grows. Use this gentle energy to express gratitude to someone who matters.'
    ];

    var SINGLES = [
        'Singles, the universe is setting the stage for a delightful encounter. Step out, smile more, and stay open &mdash; the person who notices your light could surprise you. Confidence is your best accessory today.',
        'A fresh connection is brewing for you. Don&rsquo;t overthink first impressions &mdash; your natural warmth is exactly what draws the right person closer. Say yes to the unexpected invitation.',
        'Today is about self-love first. The more you celebrate your own worth, the more magnetic you become. Someone admires you from a distance &mdash; give them a reason to come closer.',
        'The stars hint at flirtatious energy in the air. A casual chat could carry more chemistry than you expect. Keep it light, keep it genuine, and let the sparks decide the rest.',
        'Romance may arrive through familiar circles today. Reconnect, reply to that message, and revisit a place you love. The right timing is finally on your side.'
    ];
    var COUPLES = [
        'Couples, today is made for rekindling the spark. Surprise your partner with undivided attention and watch the warmth multiply. Small rituals of love mean more than grand gestures now.',
        'A gentle honesty deepens your bond today. Share a feeling you usually keep private &mdash; your partner is more ready to listen than you realize. Closeness grows in these quiet truths.',
        'Plan a little something together today, even if it&rsquo;s simple. Shared moments are the glue of lasting love, and the stars reward couples who make time for each other.',
        'If there has been friction, today offers a soft landing. Lead with appreciation instead of criticism and the tension melts. Choose teamwork &mdash; you are on the same side.',
        'Your relationship radiates steady, comforting energy today. Express gratitude out loud and let your partner feel truly seen. This is how ordinary days become cherished memories.'
    ];

    var TIPS_POOL = [
        { i: '💌', t: 'Speak From the Heart', d: 'One honest sentence today is worth a hundred polite ones. Say what you feel.' },
        { i: '⏰', t: 'Make Real Time', d: 'Carve out 20 phone-free minutes for the person who matters most.' },
        { i: '🌟', t: 'Lead With Warmth', d: 'A genuine compliment can transform someone&rsquo;s entire day &mdash; including yours.' },
        { i: '🌊', t: 'Go With the Flow', d: 'Resist forcing outcomes today. Let love find its own gentle rhythm.' },
        { i: '🔑', t: 'Listen Fully', d: 'Hear to understand, not to reply. Today, presence is the greatest gift.' },
        { i: '🎉', t: 'Celebrate Small Wins', d: 'Notice the little things your loved one does. Gratitude deepens every bond.' },
        { i: '💝', t: 'Be Brave', d: 'Send the message you keep rewriting. The stars favor the bold today.' },
        { i: '✨', t: 'Stay Authentic', d: 'The right energy is attracted to the real you, not a polished version.' }
    ];

    function escapeHtml(s){ return String(s).replace(/[&<>"']/g, function(c){ return ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'})[c]; }); }

    // Deterministic seed per sign per day
    function dateSeed(){
        var d = new Date();
        return d.getFullYear() * 10000 + (d.getMonth()+1) * 100 + d.getDate();
    }
    function hashStr(str){
        var h = 0;
        for (var i=0;i<str.length;i++){ h = ((h << 5) - h + str.charCodeAt(i)) | 0; }
        return Math.abs(h);
    }
    function pick(arr, seed){ return arr[seed % arr.length]; }

    var state = { sign: null };

    // Build picker grid
    var grid = $('lh-signs');
    SIGNS.forEach(function(s){
        var el = document.createElement('div');
        el.className = 'lh-sign';
        el.setAttribute('data-key', s.key);
        el.innerHTML = '<div class="lh-sign-icon">' + s.icon + '</div><div class="lh-sign-name">' + s.name + '</div><div class="lh-sign-date">' + s.dates + '</div>';
        el.addEventListener('click', function(){
            document.querySelectorAll('.lh-sign').forEach(function(x){ x.classList.remove('lh-active'); });
            el.classList.add('lh-active');
            state.sign = s;
            $('lh-error').classList.remove('lh-show');
        });
        grid.appendChild(el);
    });

    // All-signs reference (quick jump)
    var allGrid = $('lh-all-grid');
    SIGNS.forEach(function(s){
        var el = document.createElement('div');
        el.className = 'lh-all-item';
        el.innerHTML = '<div class="lh-all-icon">' + s.icon + '</div><div class="lh-all-name">' + s.name + '</div>';
        el.addEventListener('click', function(){
            state.sign = s;
            document.querySelectorAll('.lh-sign').forEach(function(x){ x.classList.toggle('lh-active', x.getAttribute('data-key') === s.key); });
            startReading();
        });
        allGrid.appendChild(el);
    });

    // Date display
    (function(){
        var d = new Date();
        var opts = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        try { $('lh-date').textContent = '📅 ' + d.toLocaleDateString(undefined, opts); }
        catch(e){ $('lh-date').textContent = '📅 ' + d.toDateString(); }
    })();

    var phases = { input: $('lh-input-phase'), loading: $('lh-loading'), result: $('lh-result') };

    var loadSteps = ['🔭 Aligning the stars...', '🌙 Reading the Moon...', '💕 Decoding Venus...', '✨ Writing your forecast...'];
    function runLoading(cb){
        var stepEl = $('lh-load-step'), barEl = $('lh-progress-bar'), i = 0;
        stepEl.textContent = loadSteps[0]; barEl.style.width = '8%';
        var iv = setInterval(function(){
            i++;
            if (i < loadSteps.length){
                stepEl.style.opacity = '0';
                setTimeout(function(){ stepEl.textContent = loadSteps[i]; stepEl.style.opacity = '1'; }, 200);
                barEl.style.width = ((i+1)*25) + '%';
            } else { clearInterval(iv); barEl.style.width = '100%'; setTimeout(cb, 350); }
        }, 650);
    }

    function animateNum(el, from, to, duration){
        var start = performance.now();
        function tick(now){
            var p = Math.min(1, (now - start) / duration);
            var eased = 1 - Math.pow(1 - p, 3);
            el.textContent = Math.round(from + (to - from) * eased);
            if (p < 1) requestAnimationFrame(tick);
        }
        requestAnimationFrame(tick);
    }

    function confetti(){
        var colors = ['#E63946', '#ff6b9d', '#fbbf24', '#7B2D8B', '#fff'];
        var box = document.createElement('div'); box.className = 'lh-confetti';
        for (var i=0;i<60;i++){
            var p = document.createElement('i');
            p.style.left = (Math.random()*100) + '%';
            p.style.background = colors[Math.floor(Math.random()*colors.length)];
            p.style.animationDuration = (1.5 + Math.random()*2) + 's';
            p.style.animationDelay = (Math.random()*0.5) + 's';
            p.style.transform = 'rotate(' + (Math.random()*360) + 'deg)';
            box.appendChild(p);
        }
        document.body.appendChild(box);
        setTimeout(function(){ box.remove(); }, 4000);
    }

    function getLevel(score){
        if (score >= 90) return { emoji: '👑', name: 'Radiant Love Day', color: '#d4af37' };
        if (score >= 75) return { emoji: '💕', name: 'Strong Romance', color: '#E63946' };
        if (score >= 60) return { emoji: '💜', name: 'Warm & Promising', color: '#7B2D8B' };
        return { emoji: '💙', name: 'Gentle & Reflective', color: '#2563eb' };
    }

    var lastData = null;

    function buildData(sign){
        var seed = hashStr(sign.key + ':' + dateSeed());
        var score = 60 + (seed % 39); // 60-98, love horoscopes skew positive
        var color = pick(COLORS, Math.floor(seed/7));
        var num = (seed % 9) + 1 + ((Math.floor(seed/13)) % 9) * 10; // 1-90ish nice number
        if (num > 99) num = num % 99;
        if (num < 1) num = 7;
        var time = pick(TIMES, Math.floor(seed/11));
        var forecast = pick(FORECASTS, Math.floor(seed/3));
        var single = pick(SINGLES, Math.floor(seed/5));
        var couple = pick(COUPLES, Math.floor(seed/9));
        // mood bars derived from score with variation
        function bar(off){ var v = score - 12 + (hashStr(sign.key + off + dateSeed()) % 24); return Math.max(35, Math.min(99, v)); }
        var bars = { romance: bar('r'), passion: bar('p'), harmony: bar('h'), comm: bar('c') };
        // tips: pick 4 distinct
        var tips = [], used = {}, ti = seed;
        while (tips.length < 4){
            var t = TIPS_POOL[ti % TIPS_POOL.length];
            if (!used[t.t]){ used[t.t] = 1; tips.push(t); }
            ti += 3;
        }
        return { sign: sign, score: score, color: color, num: num, time: time, forecast: forecast, single: single, couple: couple, bars: bars, tips: tips, level: getLevel(score) };
    }

    function showResult(){
        var data = buildData(state.sign);
        lastData = data;
        var s = state.sign;

        $('lh-rc-icon').textContent = s.icon;
        $('lh-rc-name').textContent = s.name;
        $('lh-rc-meta').innerHTML = s.element + ' · Ruled by ' + s.planet;
        $('lh-level').innerHTML = data.level.emoji + ' ' + data.level.name;
        $('lh-forecast').innerHTML = '<strong>' + escapeHtml(s.name) + ':</strong> ' + data.forecast;

        // lucky chips
        $('lh-luck-swatch').style.background = data.color.c;
        $('lh-luck-color-name').textContent = data.color.n;
        $('lh-luck-num').textContent = data.num;
        $('lh-luck-time').textContent = data.time;
        $('lh-luck-match').textContent = s.match;

        // mode default singles
        setMode('single');

        // show
        phases.loading.classList.remove('lh-show'); phases.loading.style.display = 'none';
        phases.result.classList.add('lh-show');

        // ring + number
        animateNum($('lh-pct'), 0, data.score, 1800);
        var circ = 2 * Math.PI * 86;
        setTimeout(function(){ $('lh-ring-fg').style.strokeDashoffset = circ - (circ * data.score / 100); }, 80);

        // bars
        setTimeout(function(){
            $('lh-b1').style.width = data.bars.romance + '%'; $('lh-b1-v').textContent = data.bars.romance + '%';
            $('lh-b2').style.width = data.bars.passion + '%'; $('lh-b2-v').textContent = data.bars.passion + '%';
            $('lh-b3').style.width = data.bars.harmony + '%'; $('lh-b3-v').textContent = data.bars.harmony + '%';
            $('lh-b4').style.width = data.bars.comm + '%'; $('lh-b4-v').textContent = data.bars.comm + '%';
        }, 200);

        // tips
        $('lh-tips-title').innerHTML = '⭐ Today’s Golden Tips for ' + escapeHtml(s.name);
        var tg = $('lh-tips-grid'); tg.innerHTML = '';
        data.tips.forEach(function(t, idx){
            var card = document.createElement('div');
            card.className = 'lh-tip';
            card.style.borderLeftColor = data.level.color;
            card.style.animationDelay = (idx * 0.1) + 's';
            card.innerHTML = '<div class="lh-tip-icon">' + t.i + '</div><h4>' + t.t + '</h4><p>' + t.d + '</p>';
            tg.appendChild(card);
        });

        setupShare(data);
        if (data.score >= 80) setTimeout(confetti, 600);
        setTimeout(function(){ phases.result.scrollIntoView({ behavior: 'smooth', block: 'start' }); }, 100);
    }

    function setMode(mode){
        if (!lastData) return;
        var single = mode === 'single';
        $('lh-tab-single').classList.toggle('lh-on', single);
        $('lh-tab-couple').classList.toggle('lh-on', !single);
        $('lh-mode-title').innerHTML = single ? '💖 If You’re Single' : '💍 If You’re in a Relationship';
        $('lh-mode-text').textContent = single ? lastData.single : lastData.couple;
    }
    $('lh-tab-single').addEventListener('click', function(){ setMode('single'); });
    $('lh-tab-couple').addEventListener('click', function(){ setMode('couple'); });

    function setupShare(data){
        var url = window.location.href;
        var s = data.sign;
        var msg = '✨ ' + s.name + ' Love Horoscope Today ✨\n\n' + 'Love Energy: ' + data.score + '% (' + data.level.name + ')\nLucky Color: ' + data.color.n + '\nLucky Number: ' + data.num + '\nBest Match: ' + s.match + '\n\nRead yours: ' + url;
        var tweet = s.name + ' love horoscope today: ' + data.score + '% love energy (' + data.level.name + ') ' + s.icon + ' Read yours:';
        $('lh-sb-wa').href = 'https://wa.me/?text=' + encodeURIComponent(msg);
        $('lh-sb-tw').href = 'https://twitter.com/intent/tweet?text=' + encodeURIComponent(tweet) + '&url=' + encodeURIComponent(url);

        $('lh-sb-copy').onclick = function(){
            var btn = this, orig = btn.innerHTML;
            try {
                if (navigator.clipboard){
                    navigator.clipboard.writeText(url).then(function(){ btn.innerHTML = '✅ Copied!'; setTimeout(function(){ btn.innerHTML = orig; }, 1800); });
                } else {
                    var ta = document.createElement('textarea'); ta.value = url; document.body.appendChild(ta); ta.select(); document.execCommand('copy'); ta.remove();
                    btn.innerHTML = '✅ Copied!'; setTimeout(function(){ btn.innerHTML = orig; }, 1800);
                }
            } catch(e){ btn.innerHTML = '⚠ Try Manually'; setTimeout(function(){ btn.innerHTML = orig; }, 1800); }
        };
        $('lh-sb-save').onclick = function(){
            var btn = this, orig = btn.innerHTML; btn.innerHTML = '📸 Saving...';
            setTimeout(function(){
                if (navigator.share){
                    navigator.share({ title: s.name + ' Love Horoscope', text: msg, url: url }).then(function(){ btn.innerHTML = orig; }).catch(function(){ alert('Take a screenshot of your forecast to save it!'); btn.innerHTML = orig; });
                } else { alert('Take a screenshot of your forecast to save it!\n\n' + s.name + ' — ' + data.score + '% Love Energy'); btn.innerHTML = orig; }
            }, 400);
        };
    }

    function startReading(){
        if (!state.sign){ $('lh-error').classList.add('lh-show'); return; }
        $('lh-error').classList.remove('lh-show');
        phases.input.style.display = 'none';
        phases.loading.style.display = 'block';
        phases.loading.classList.add('lh-show');
        $('lh-load-sign').textContent = state.sign.icon + ' ' + state.sign.name;
        $('lh-progress-bar').style.width = '0%';
        runLoading(showResult);
    }

    $('lh-go-btn').addEventListener('click', startReading);

    $('lh-try-btn').addEventListener('click', function(){
        phases.result.classList.remove('lh-show');
        phases.loading.classList.remove('lh-show');
        phases.loading.style.display = 'none';
        phases.input.style.display = 'block';
        $('lh-pct').textContent = '0';
        $('lh-ring-fg').style.strokeDashoffset = 540.35;
        ['lh-b1','lh-b2','lh-b3','lh-b4'].forEach(function(id){ $(id).style.width = '0%'; });
        $('lh-pick-card').scrollIntoView({ behavior: 'smooth', block: 'start' });
    });

    // Live counter
    var counterEl = $('lh-counter'); var count = 218640;
    setInterval(function(){ count += 1 + Math.floor(Math.random()*4); counterEl.textContent = count.toLocaleString('en-IN'); }, 8000);
})();
</script>
        <?php
        return ob_get_clean();
    }

    add_shortcode( 'love_horoscope', 'lh_pro_render_horoscope' );
}
