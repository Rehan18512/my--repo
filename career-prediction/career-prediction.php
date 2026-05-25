<?php
/**
 * Plugin Name: Career Prediction by Date of Birth
 * Plugin URI: https://lovecalculator.in
 * Description: Premium Career Prediction tool. Enter a date of birth to reveal sun-sign + numerology life-path career analysis: career power score, best career fields, strength meters, ideal industries, lucky career stats and golden tips. Use shortcode [career_prediction].
 * Version: 1.0.0
 * Author: lovecalculator.in
 * Author URI: https://lovecalculator.in
 * License: GPL-2.0+
 * Text Domain: career-prediction
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! function_exists( 'cp_pro_render_career' ) ) {

    function cp_pro_render_career( $atts = array() ) {
        ob_start();
        ?>
<div class="cp-wrap" id="cp-wrap">
    <style>
        .cp-wrap, .cp-wrap *, .cp-wrap *::before, .cp-wrap *::after { box-sizing: border-box; }
        .cp-wrap { font-family: 'DM Sans', 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; color: #1f1933; max-width: 880px; margin: 0 auto; padding: 12px; line-height: 1.55; }
        .cp-wrap h1, .cp-wrap h2, .cp-wrap h3, .cp-wrap h4 { font-family: 'Poppins', 'Syne', system-ui, sans-serif; font-weight: 800; letter-spacing: -0.01em; margin: 0; }

        .cp-header { background: linear-gradient(135deg, #1a0533 0%, #3d0b55 50%, #690d3a 100%); border-radius: 22px; padding: 28px 20px; color: #fff; text-align: center; box-shadow: 0 20px 60px rgba(105, 13, 58, 0.25); position: relative; overflow: hidden; }
        .cp-header::before { content: ""; position: absolute; inset: -50%; background: radial-gradient(circle at 30% 20%, rgba(230,57,70,0.18), transparent 60%), radial-gradient(circle at 70% 80%, rgba(123,45,139,0.25), transparent 60%); pointer-events: none; }
        .cp-header-icon { font-size: 50px; line-height: 1; display: inline-block; animation: cp-bob 2.4s ease-in-out infinite; }
        .cp-header h1 { font-size: 34px; margin: 8px 0 6px; color: #fff; }
        .cp-header-sub { opacity: 0.86; font-size: 15px; margin: 0; }
        .cp-stats { display: flex; align-items: center; justify-content: center; gap: 0; margin-top: 18px; flex-wrap: wrap; }
        .cp-stat { padding: 4px 14px; min-width: 96px; }
        .cp-stat-num { font-weight: 800; font-family: 'Poppins', sans-serif; font-size: 18px; color: #fff; }
        .cp-stat-lbl { font-size: 11px; opacity: 0.78; text-transform: uppercase; letter-spacing: 0.06em; }
        .cp-stat + .cp-stat { border-left: 1px solid rgba(255,255,255,0.22); }

        .cp-card { background: #fff; border-radius: 22px; padding: 24px 20px; margin-top: 18px; box-shadow: 0 20px 60px rgba(0,0,0,0.08); border: 1px solid #f1ecf6; }
        .cp-card-title { font-size: 20px; color: #3d0b55; text-align: center; margin-bottom: 4px; }
        .cp-card-note { text-align: center; font-size: 13.5px; color: #6b5e85; margin: 0 0 18px; }

        .cp-field { margin-bottom: 16px; }
        .cp-label { font-size: 13px; font-weight: 700; font-family: 'Poppins', sans-serif; color: #5b1d72; text-transform: uppercase; letter-spacing: 0.05em; margin: 0 0 8px; display: block; }
        .cp-input { width: 100%; min-height: 52px; padding: 12px 16px; font-size: 16px; border: 2px solid #ece6f3; border-radius: 14px; outline: none; background: #faf8fd; transition: border-color .2s, background .2s, box-shadow .2s; font-family: inherit; color: #1f1933; }
        .cp-input:focus { border-color: #E63946; background: #fff; box-shadow: 0 0 0 4px rgba(230,57,70,0.12); }

        .cp-error { display: none; background: #fff1f2; color: #b3162a; border: 1px solid #ffd6db; padding: 10px 14px; border-radius: 12px; margin-top: 4px; font-size: 14px; text-align: center; }
        .cp-error.cp-show { display: block; animation: cp-shake .4s; }
        .cp-btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; min-height: 56px; padding: 18px 22px; font-size: 17px; font-weight: 700; font-family: 'Poppins', sans-serif; border: none; border-radius: 14px; cursor: pointer; width: 100%; transition: transform .15s ease, box-shadow .2s ease, opacity .2s; }
        .cp-btn-primary { background: linear-gradient(135deg, #E63946, #c81e2c); color: #fff; box-shadow: 0 14px 32px rgba(230,57,70,0.35); margin-top: 12px; }
        .cp-btn-primary:hover { transform: translateY(-2px); box-shadow: 0 18px 40px rgba(230,57,70,0.45); }
        .cp-btn-primary:active { transform: translateY(0); }
        .cp-trust { display: flex; gap: 10px; justify-content: center; flex-wrap: wrap; margin-top: 14px; }
        .cp-trust span { font-size: 12.5px; color: #5b5070; background: #f6f0fb; padding: 6px 12px; border-radius: 999px; min-height: 30px; display: inline-flex; align-items: center; }

        .cp-loading { display: none; text-align: center; padding: 14px 8px 6px; }
        .cp-loading.cp-show { display: block; }
        .cp-rings { position: relative; width: 160px; height: 160px; margin: 6px auto 18px; }
        .cp-ring { position: absolute; inset: 0; border-radius: 50%; border: 3px solid rgba(230,57,70,0.35); animation: cp-ring 2s ease-out infinite; }
        .cp-ring:nth-child(2) { animation-delay: .5s; border-color: rgba(123,45,139,0.4); }
        .cp-ring:nth-child(3) { animation-delay: 1s; border-color: rgba(255,107,157,0.45); }
        .cp-ring-heart { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; font-size: 56px; animation: cp-pulse 1.2s ease-in-out infinite; }
        .cp-load-step { font-size: 15px; color: #6b5e85; min-height: 24px; transition: opacity .25s; margin-top: 4px; }
        .cp-progress { height: 8px; background: #f1ebf7; border-radius: 999px; overflow: hidden; margin: 14px auto 4px; max-width: 360px; }
        .cp-progress-bar { height: 100%; width: 0%; background: linear-gradient(90deg, #E63946, #7B2D8B); border-radius: 999px; transition: width .3s ease; }

        .cp-result { display: none; }
        .cp-result.cp-show { display: block; animation: cp-fadeUp .55s ease both; }
        .cp-result-card { background: linear-gradient(135deg, #1a0533, #3d0b55, #690d3a); color: #fff; border-radius: 22px; padding: 28px 20px; text-align: center; box-shadow: 0 20px 60px rgba(0,0,0,0.25); position: relative; overflow: hidden; }
        .cp-result-card::after { content: ""; position: absolute; inset: 0; background: radial-gradient(circle at 20% 10%, rgba(230,57,70,0.25), transparent 50%), radial-gradient(circle at 80% 90%, rgba(255,107,157,0.18), transparent 55%); pointer-events: none; }
        .cp-rc-top { display: flex; align-items: center; justify-content: center; gap: 12px; flex-wrap: wrap; margin-bottom: 4px; position: relative; z-index: 1; }
        .cp-rc-icon { font-size: 36px; }
        .cp-rc-name { font-family: 'Poppins', sans-serif; font-weight: 800; font-size: 22px; }
        .cp-rc-meta { font-size: 13px; opacity: 0.82; position: relative; z-index: 1; margin-bottom: 6px; }
        .cp-ring-wrap { position: relative; width: 210px; height: 210px; margin: 12px auto 8px; z-index: 1; }
        .cp-ring-wrap svg { transform: rotate(-90deg); width: 100%; height: 100%; }
        .cp-ring-bg { fill: none; stroke: rgba(255,255,255,0.12); stroke-width: 12; }
        .cp-ring-fg { fill: none; stroke: url(#cp-grad); stroke-width: 12; stroke-linecap: round; transition: stroke-dashoffset 1.8s cubic-bezier(.22,.9,.3,1); }
        .cp-percent { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; flex-direction: column; }
        .cp-percent-num { font-size: 60px; font-weight: 800; font-family: 'Poppins', sans-serif; line-height: 1; }
        .cp-percent-sym { font-size: 22px; font-weight: 700; opacity: 0.85; }
        .cp-percent-lbl { font-size: 12px; opacity: 0.8; text-transform: uppercase; letter-spacing: 0.08em; margin-top: 2px; }
        .cp-level { display: inline-block; background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.22); padding: 8px 18px; border-radius: 999px; font-weight: 700; font-family: 'Poppins', sans-serif; font-size: 15px; margin: 4px 0 10px; position: relative; z-index: 1; }
        .cp-summary { max-width: 600px; margin: 0 auto; opacity: 0.94; font-size: 15.5px; position: relative; z-index: 1; }
        .cp-watermark { margin-top: 16px; font-size: 12.5px; opacity: 0.7; position: relative; z-index: 1; }

        .cp-lucky { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin-top: 18px; }
        .cp-luck { background: #fff; border-radius: 16px; padding: 16px 10px; text-align: center; box-shadow: 0 10px 24px rgba(0,0,0,0.06); border-top: 4px solid #E63946; }
        .cp-luck:nth-child(1) { border-color: #E63946; }
        .cp-luck:nth-child(2) { border-color: #7B2D8B; }
        .cp-luck:nth-child(3) { border-color: #2563eb; }
        .cp-luck:nth-child(4) { border-color: #14b8a6; }
        .cp-luck-lbl { font-size: 11.5px; color: #8a7ba3; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 700; }
        .cp-luck-val { font-family: 'Poppins', sans-serif; font-weight: 800; font-size: 16px; color: #2d2447; margin-top: 4px; display: flex; align-items: center; justify-content: center; gap: 6px; }
        .cp-swatch { width: 16px; height: 16px; border-radius: 50%; border: 1px solid rgba(0,0,0,0.15); display: inline-block; }

        .cp-section { background: #fff; border-radius: 18px; padding: 18px; margin-top: 16px; box-shadow: 0 12px 30px rgba(0,0,0,0.06); border: 1px solid #f1ecf6; border-top: 4px solid #7B2D8B; }
        .cp-section h3 { font-size: 17px; color: #2d2447; margin-bottom: 4px; display: flex; align-items: center; gap: 8px; }
        .cp-section .cp-sec-note { font-size: 12.5px; color: #8a7ba3; margin: 0 0 12px; }
        .cp-fields { display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; }
        .cp-fchip { display: flex; align-items: center; gap: 10px; background: #faf8fd; border: 1px solid #ece6f3; border-radius: 12px; padding: 12px 14px; opacity: 0; transform: translateY(8px); animation: cp-fadeUp .45s ease forwards; }
        .cp-fchip-icon { font-size: 22px; }
        .cp-fchip-txt { font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 14.5px; color: #3d0b55; }
        .cp-fchip-sub { font-size: 11.5px; color: #8a7ba3; }

        .cp-lifepath { background: linear-gradient(135deg, #fff8dc, #fff1c1); border: 1px solid #f7e190; border-top: 4px solid #d4af37; }
        .cp-lifepath h3 { color: #7a5a05; }
        .cp-lp-num { display: inline-flex; align-items: center; justify-content: center; width: 54px; height: 54px; border-radius: 50%; background: linear-gradient(135deg, #d4af37, #b8860b); color: #fff; font-family: 'Poppins', sans-serif; font-weight: 800; font-size: 24px; margin-right: 10px; }
        .cp-lp-row { display: flex; align-items: center; margin-bottom: 8px; }
        .cp-lp-title { font-family: 'Poppins', sans-serif; font-weight: 800; color: #7a5a05; font-size: 16px; }
        .cp-lp-text { color: #5b5070; font-size: 14px; margin: 0; }

        .cp-tags { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 4px; }
        .cp-tag { background: #f6f0fb; padding: 6px 12px; border-radius: 999px; font-size: 12.5px; font-weight: 600; color: #6c2dba; border: 1px solid #d8c1f0; }

        .cp-bars { margin-top: 16px; }
        .cp-bar-row { margin: 14px 0; }
        .cp-bar-top { display: flex; justify-content: space-between; font-size: 14px; font-weight: 600; color: #2d2447; margin-bottom: 6px; }
        .cp-bar-top span:last-child { color: #7B2D8B; font-family: 'Poppins', sans-serif; font-weight: 800; }
        .cp-bar { height: 10px; background: #f1ebf7; border-radius: 999px; overflow: hidden; }
        .cp-bar-fill { height: 100%; width: 0%; border-radius: 999px; background: linear-gradient(90deg, #E63946, #7B2D8B); transition: width 1.5s cubic-bezier(.22,.9,.3,1); }

        .cp-tips { background: linear-gradient(135deg, #e7f7ec, #d2efdc); border-radius: 18px; padding: 20px; margin-top: 16px; border: 1px solid #b8e2c5; }
        .cp-tips h3 { font-size: 19px; color: #155d3a; margin-bottom: 12px; }
        .cp-tips-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; }
        .cp-tip { background: #fff; border-radius: 14px; padding: 14px; border-left: 4px solid #14b8a6; box-shadow: 0 8px 20px rgba(0,0,0,0.05); opacity: 0; transform: translateY(8px); animation: cp-fadeUp .5s ease forwards; }
        .cp-tip-icon { font-size: 22px; margin-bottom: 4px; }
        .cp-tip h4 { font-size: 14.5px; color: #155d3a; margin-bottom: 4px; }
        .cp-tip p { font-size: 13px; color: #5b5070; margin: 0; }

        .cp-share { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin-top: 18px; }
        .cp-share-btn { display: inline-flex; align-items: center; justify-content: center; gap: 6px; min-height: 48px; padding: 12px 8px; font-size: 14px; font-weight: 700; font-family: 'Poppins', sans-serif; border-radius: 12px; border: none; cursor: pointer; color: #fff; text-decoration: none; transition: transform .15s ease, box-shadow .15s ease; }
        .cp-share-btn:hover { transform: translateY(-2px); box-shadow: 0 12px 26px rgba(0,0,0,0.15); }
        .cp-sb-wa { background: #25d366; }
        .cp-sb-tw { background: #111; }
        .cp-sb-save { background: linear-gradient(135deg, #E63946, #7B2D8B); }
        .cp-sb-copy { background: #5b5b6e; }

        .cp-try { margin-top: 14px; background: #fff; color: #3d0b55; border: 2px solid #ece6f3; }
        .cp-try:hover { border-color: #7B2D8B; color: #7B2D8B; }

        .cp-confetti { position: fixed; inset: 0; pointer-events: none; z-index: 9999; overflow: hidden; }
        .cp-confetti i { position: absolute; top: -20px; width: 10px; height: 14px; opacity: 0.95; animation: cp-fall linear forwards; border-radius: 2px; }

        .cp-related { margin-top: 22px; }
        .cp-related h2 { font-size: 22px; color: #3d0b55; margin-bottom: 12px; }
        .cp-related-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; }
        .cp-rt { display: block; text-decoration: none; background: #fff; border-radius: 16px; padding: 16px 12px; text-align: center; box-shadow: 0 10px 24px rgba(0,0,0,0.06); border-top: 4px solid #E63946; color: inherit; transition: transform .15s ease, box-shadow .2s ease; }
        .cp-rt:hover { transform: translateY(-3px); box-shadow: 0 16px 32px rgba(0,0,0,0.1); }
        .cp-rt:nth-child(1) { border-color: #ff6b35; }
        .cp-rt:nth-child(2) { border-color: #14b8a6; }
        .cp-rt:nth-child(3) { border-color: #E63946; }
        .cp-rt:nth-child(4) { border-color: #7B2D8B; }
        .cp-rt-icon { font-size: 28px; }
        .cp-rt h4 { font-size: 14.5px; color: #1f1933; margin: 6px 0 4px; }
        .cp-rt p { font-size: 12.5px; color: #5b5070; margin: 0; }

        @keyframes cp-pulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.08); } }
        @keyframes cp-bob { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-6px); } }
        @keyframes cp-ring { 0% { transform: scale(0.6); opacity: 0.9; } 100% { transform: scale(1.4); opacity: 0; } }
        @keyframes cp-fadeUp { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes cp-shake { 0%, 100% { transform: translateX(0); } 25% { transform: translateX(-4px); } 75% { transform: translateX(4px); } }
        @keyframes cp-fall { 0% { transform: translateY(-20px) rotate(0); opacity: 1; } 100% { transform: translateY(110vh) rotate(720deg); opacity: 0.3; } }

        @media (max-width: 640px) {
            .cp-wrap { padding: 8px; }
            .cp-header { padding: 22px 16px; border-radius: 18px; }
            .cp-header h1 { font-size: 27px; }
            .cp-header-icon { font-size: 44px; }
            .cp-stat-num { font-size: 16px; }
            .cp-card { padding: 20px 16px; border-radius: 18px; }
            .cp-percent-num { font-size: 52px; }
            .cp-ring-wrap { width: 190px; height: 190px; }
            .cp-lucky { grid-template-columns: repeat(2, 1fr); }
            .cp-fields { grid-template-columns: 1fr; }
            .cp-tips-grid { grid-template-columns: 1fr; }
            .cp-share { grid-template-columns: repeat(2, 1fr); }
            .cp-related-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 380px) {
            .cp-header h1 { font-size: 23px; }
        }
    </style>

    <header class="cp-header">
        <div class="cp-header-icon">&#128188;</div>
        <h1>Career Prediction by Date of Birth</h1>
        <p class="cp-header-sub">Discover your ideal career path through astrology &amp; numerology</p>
        <div class="cp-stats">
            <div class="cp-stat"><div class="cp-stat-num" id="cp-counter">1,94,508</div><div class="cp-stat-lbl">Reports Today</div></div>
            <div class="cp-stat"><div class="cp-stat-num">4.9&#9733;</div><div class="cp-stat-lbl">Rating</div></div>
            <div class="cp-stat"><div class="cp-stat-num">100%</div><div class="cp-stat-lbl">Free</div></div>
        </div>
    </header>

    <section class="cp-card" id="cp-card">
        <div class="cp-input-phase" id="cp-input-phase">
            <h2 class="cp-card-title">Enter Your Birth Details</h2>
            <p class="cp-card-note">We use your sun sign and numerology life path to map your career strengths</p>
            <div class="cp-field">
                <label class="cp-label" for="cp-name">Your Name <span style="opacity:.6;text-transform:none;font-weight:600;">(optional)</span></label>
                <input type="text" class="cp-input" id="cp-name" placeholder="e.g. Aryan" maxlength="24" autocomplete="off" />
            </div>
            <div class="cp-field">
                <label class="cp-label" for="cp-dob">Date of Birth</label>
                <input type="date" class="cp-input" id="cp-dob" />
            </div>
            <div class="cp-error" id="cp-error">Please enter your date of birth.</div>
            <button type="button" class="cp-btn cp-btn-primary" id="cp-go-btn">Reveal My Career Path &#128640;</button>
            <div class="cp-trust">
                <span>&#128274; Private</span>
                <span>&#9889; Instant</span>
                <span>&#128302; Astro + Numerology</span>
            </div>
        </div>

        <div class="cp-loading" id="cp-loading">
            <div class="cp-rings"><div class="cp-ring"></div><div class="cp-ring"></div><div class="cp-ring"></div><div class="cp-ring-heart">&#128640;</div></div>
            <div class="cp-load-step" id="cp-load-step">&#128302; Reading your birth chart...</div>
            <div class="cp-progress"><div class="cp-progress-bar" id="cp-progress-bar"></div></div>
        </div>

        <div class="cp-result" id="cp-result">
            <div class="cp-result-card">
                <div class="cp-rc-top"><span class="cp-rc-icon" id="cp-rc-icon">&#9800;</span><span class="cp-rc-name" id="cp-rc-name">Aries</span></div>
                <div class="cp-rc-meta" id="cp-rc-meta">Fire &middot; Ruled by Mars &middot; Life Path 1</div>
                <div class="cp-ring-wrap">
                    <svg viewBox="0 0 200 200" aria-hidden="true">
                        <defs><linearGradient id="cp-grad" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#ff6b9d"/><stop offset="100%" stop-color="#fbbf24"/></linearGradient></defs>
                        <circle class="cp-ring-bg" cx="100" cy="100" r="86"/>
                        <circle class="cp-ring-fg" id="cp-ring-fg" cx="100" cy="100" r="86" stroke-dasharray="540.35" stroke-dashoffset="540.35"/>
                    </svg>
                    <div class="cp-percent"><div><span class="cp-percent-num" id="cp-pct">0</span><span class="cp-percent-sym">%</span></div><div class="cp-percent-lbl">Career Power</div></div>
                </div>
                <div class="cp-level" id="cp-level">&#128188; Analyzing...</div>
                <p class="cp-summary" id="cp-summary">Your career blueprint is loading...</p>
                <div class="cp-watermark">lovecalculator.in &#10084;</div>
            </div>

            <div class="cp-lucky">
                <div class="cp-luck"><div class="cp-luck-lbl">Power Color</div><div class="cp-luck-val"><span class="cp-swatch" id="cp-luck-swatch"></span><span id="cp-luck-color">&mdash;</span></div></div>
                <div class="cp-luck"><div class="cp-luck-lbl">Lucky Number</div><div class="cp-luck-val" id="cp-luck-num">&mdash;</div></div>
                <div class="cp-luck"><div class="cp-luck-lbl">Power Day</div><div class="cp-luck-val" id="cp-luck-day">&mdash;</div></div>
                <div class="cp-luck"><div class="cp-luck-lbl">Lucky Direction</div><div class="cp-luck-val" id="cp-luck-dir">&mdash;</div></div>
            </div>

            <div class="cp-section">
                <h3>&#127919; Best Career Fields For You</h3>
                <p class="cp-sec-note">Industries where your natural strengths shine brightest</p>
                <div class="cp-fields" id="cp-fields"></div>
            </div>

            <div class="cp-section cp-lifepath">
                <h3>&#128290; Your Numerology Life Path</h3>
                <div class="cp-lp-row"><span class="cp-lp-num" id="cp-lp-num">1</span><span class="cp-lp-title" id="cp-lp-title">The Leader</span></div>
                <p class="cp-lp-text" id="cp-lp-text">&mdash;</p>
            </div>

            <div class="cp-section">
                <h3>&#128170; Your Career Strengths</h3>
                <div class="cp-bars">
                    <div class="cp-bar-row"><div class="cp-bar-top"><span>&#128081; Leadership</span><span id="cp-b1-v">0%</span></div><div class="cp-bar"><div class="cp-bar-fill" id="cp-b1"></div></div></div>
                    <div class="cp-bar-row"><div class="cp-bar-top"><span>&#127912; Creativity</span><span id="cp-b2-v">0%</span></div><div class="cp-bar"><div class="cp-bar-fill" id="cp-b2"></div></div></div>
                    <div class="cp-bar-row"><div class="cp-bar-top"><span>&#129504; Analytical Mind</span><span id="cp-b3-v">0%</span></div><div class="cp-bar"><div class="cp-bar-fill" id="cp-b3"></div></div></div>
                    <div class="cp-bar-row"><div class="cp-bar-top"><span>&#128172; Communication</span><span id="cp-b4-v">0%</span></div><div class="cp-bar"><div class="cp-bar-fill" id="cp-b4"></div></div></div>
                </div>
            </div>

            <div class="cp-section">
                <h3>&#127970; Ideal Work Environment</h3>
                <p class="cp-sec-note" id="cp-env-text" style="color:#5b5070;font-size:14px;">&mdash;</p>
                <div class="cp-tags" id="cp-env-tags"></div>
            </div>

            <div class="cp-tips">
                <h3 id="cp-tips-title">&#11088; Golden Career Tips</h3>
                <div class="cp-tips-grid" id="cp-tips-grid"></div>
            </div>

            <div class="cp-share">
                <a href="#" class="cp-share-btn cp-sb-wa" id="cp-sb-wa" target="_blank" rel="noopener">&#128241; WhatsApp</a>
                <a href="#" class="cp-share-btn cp-sb-tw" id="cp-sb-tw" target="_blank" rel="noopener">&#119991; Twitter</a>
                <button type="button" class="cp-share-btn cp-sb-save" id="cp-sb-save">&#128247; Save</button>
                <button type="button" class="cp-share-btn cp-sb-copy" id="cp-sb-copy">&#128279; Copy Link</button>
            </div>

            <button type="button" class="cp-btn cp-try" id="cp-try-btn">&#128260; Try Another Date</button>
        </div>
    </section>

    <section class="cp-related">
        <h2>Try More Tools</h2>
        <div class="cp-related-grid">
            <a class="cp-rt" href="/love-horoscope/"><div class="cp-rt-icon">&#128156;</div><h4>Love Horoscope</h4><p>Your daily love forecast</p></a>
            <a class="cp-rt" href="/compatibility-test/"><div class="cp-rt-icon">&#128302;</div><h4>Compatibility</h4><p>Zodiac match score</p></a>
            <a class="cp-rt" href="/kundali-matching/"><div class="cp-rt-icon">&#128138;</div><h4>Kundali Matching</h4><p>Guna Milan by name</p></a>
            <a class="cp-rt" href="/love-calculator/"><div class="cp-rt-icon">&#128149;</div><h4>Love Calculator</h4><p>Name compatibility</p></a>
        </div>
    </section>

    <script type="application/ld+json">
    { "@context": "https://schema.org", "@type": "SoftwareApplication", "name": "Career Prediction by Date of Birth", "applicationCategory": "LifestyleApplication", "operatingSystem": "Web", "url": "https://lovecalculator.in/career-prediction/", "offers": { "@type": "Offer", "price": "0", "priceCurrency": "USD" }, "aggregateRating": { "@type": "AggregateRating", "ratingValue": "4.9", "ratingCount": "8421" } }
    </script>
</div>
        <?php
        $cp_html = ob_get_clean();

        // Deliver the behavioral JS via the footer so WordPress content
        // filters (wpautop) can never inject tags that break the script.
        ob_start();
        ?>
(function(){
    'use strict';
    var $ = function(id){ return document.getElementById(id); };

    var SIGNS = [
        { key:'capricorn', name:'Capricorn', icon:'♑', element:'Earth', planet:'Saturn', from:[12,22], to:[1,19] },
        { key:'aquarius',  name:'Aquarius',  icon:'♒', element:'Air',   planet:'Uranus', from:[1,20],  to:[2,18] },
        { key:'pisces',    name:'Pisces',    icon:'♓', element:'Water', planet:'Neptune',from:[2,19],  to:[3,20] },
        { key:'aries',     name:'Aries',     icon:'♈', element:'Fire',  planet:'Mars',   from:[3,21],  to:[4,19] },
        { key:'taurus',    name:'Taurus',    icon:'♉', element:'Earth', planet:'Venus',  from:[4,20],  to:[5,20] },
        { key:'gemini',    name:'Gemini',    icon:'♊', element:'Air',   planet:'Mercury',from:[5,21],  to:[6,20] },
        { key:'cancer',    name:'Cancer',    icon:'♋', element:'Water', planet:'Moon',   from:[6,21],  to:[7,22] },
        { key:'leo',       name:'Leo',       icon:'♌', element:'Fire',  planet:'Sun',    from:[7,23],  to:[8,22] },
        { key:'virgo',     name:'Virgo',     icon:'♍', element:'Earth', planet:'Mercury',from:[8,23],  to:[9,22] },
        { key:'libra',     name:'Libra',     icon:'♎', element:'Air',   planet:'Venus',  from:[9,23],  to:[10,22] },
        { key:'scorpio',   name:'Scorpio',   icon:'♏', element:'Water', planet:'Pluto',  from:[10,23], to:[11,21] },
        { key:'sagittarius',name:'Sagittarius',icon:'♐',element:'Fire', planet:'Jupiter',from:[11,22], to:[12,21] }
    ];

    var FIELDS_BY_ELEMENT = {
        Fire:  [ {i:'🚀',t:'Entrepreneurship',s:'Start-ups & ventures'}, {i:'🎤',t:'Leadership Roles',s:'Management & command'}, {i:'🏅',t:'Sports & Fitness',s:'Coaching & athletics'}, {i:'🎬',t:'Media & Performance',s:'Acting, hosting, stage'}, {i:'⚖️',t:'Law & Defense',s:'Advocacy, armed forces'}, {i:'📣',t:'Marketing & Sales',s:'Brand & growth roles'} ],
        Earth: [ {i:'💰',t:'Finance & Banking',s:'Accounts, investment'}, {i:'🏗️',t:'Architecture & Real Estate',s:'Build & property'}, {i:'⚙️',t:'Engineering',s:'Mechanical, civil, tech'}, {i:'🌱',t:'Agriculture & Food',s:'Agri-business, F&B'}, {i:'📊',t:'Operations & Admin',s:'Process & systems'}, {i:'⚕️',t:'Healthcare',s:'Medicine, wellness'} ],
        Air:   [ {i:'💻',t:'Technology & IT',s:'Software, data, AI'}, {i:'✍️',t:'Writing & Journalism',s:'Content & media'}, {i:'🎓',t:'Teaching & Research',s:'Academia, training'}, {i:'🗣️',t:'Communication & PR',s:'Public relations'}, {i:'✈️',t:'Travel & Aviation',s:'Tourism, airlines'}, {i:'🤝',t:'Consulting',s:'Advisory & strategy'} ],
        Water: [ {i:'🎨',t:'Arts & Design',s:'Creative & visual'}, {i:'🎵',t:'Music & Film',s:'Composing, production'}, {i:'🧠',t:'Psychology & Counseling',s:'Therapy & care'}, {i:'⚕️',t:'Healthcare & Nursing',s:'Healing professions'}, {i:'📷',t:'Photography & Media',s:'Visual storytelling'}, {i:'🌊',t:'Hospitality',s:'Hotels, service, care'} ]
    };

    var ENV_BY_ELEMENT = {
        Fire:  { text:'You thrive in fast-paced, high-energy settings where you can lead, take initiative and see quick results. Avoid roles that feel slow or overly restrictive.', tags:['Leadership','Fast-paced','Independent','Goal-driven'] },
        Earth: { text:'You do best in stable, structured environments that reward patience, reliability and steady growth. You build lasting value where others quit.', tags:['Structured','Stable','Hands-on','Long-term'] },
        Air:   { text:'You shine in dynamic, idea-rich spaces with variety, conversation and constant learning. Repetitive, isolated work drains you.', tags:['Collaborative','Innovative','Flexible','Social'] },
        Water: { text:'You flourish in creative, people-centred environments where empathy and intuition matter. You need meaning and emotional connection in your work.', tags:['Creative','Empathetic','Purpose-led','Supportive'] }
    };

    var LIFEPATH = {
        1: { t:'The Leader', d:'Born to pioneer. You are ambitious, original and driven to be first. Careers in leadership, entrepreneurship and innovation suit you. Independence is your fuel.' },
        2: { t:'The Diplomat', d:'A natural peacemaker and team player. You excel in partnership, counseling, HR, design and any role needing tact and cooperation.' },
        3: { t:'The Communicator', d:'Creative and expressive, you were made to inspire. Writing, media, arts, teaching and marketing let your imagination earn.' },
        4: { t:'The Builder', d:'Disciplined and reliable, you turn ideas into systems. Engineering, finance, operations and architecture reward your steady hand.' },
        5: { t:'The Adventurer', d:'Freedom-loving and adaptable, you thrive on variety. Travel, sales, media, tech and anything dynamic keeps you thriving.' },
        6: { t:'The Nurturer', d:'Caring and responsible, you are drawn to service. Healthcare, teaching, hospitality and community roles fulfil you deeply.' },
        7: { t:'The Analyst', d:'Deep-thinking and intuitive, you seek truth. Research, science, technology, psychology and specialist expertise are your strengths.' },
        8: { t:'The Achiever', d:'Powerful and business-minded, you are built for influence and wealth. Management, finance, law and large enterprises are your arena.' },
        9: { t:'The Humanitarian', d:'Compassionate and visionary, you work for a bigger cause. Social work, arts, healing and global roles give your work meaning.' },
        11:{ t:'The Visionary (Master 11)', d:'An inspired, intuitive guide. You can lead and uplift others through spirituality, innovation, teaching and the creative arts.' },
        22:{ t:'The Master Builder (Master 22)', d:'You turn grand visions into reality on a large scale. Architecture, large enterprises, public projects and global impact roles fit you.' },
        33:{ t:'The Master Teacher (Master 33)', d:'A rare healer and mentor. You elevate others through teaching, healing, counseling and selfless service.' }
    };

    var COLORS = [ {n:'Royal Purple',c:'#7B2D8B'}, {n:'Golden Amber',c:'#fbbf24'}, {n:'Deep Red',c:'#E63946'}, {n:'Ocean Blue',c:'#2563eb'}, {n:'Emerald',c:'#10b981'}, {n:'Teal',c:'#14b8a6'}, {n:'Coral',c:'#ff6b35'}, {n:'Indigo',c:'#4f46e5'} ];
    var DAYS = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
    var DIRS = ['North','North-East','East','South-East','South','South-West','West','North-West'];

    var TIPS_POOL = [
        {i:'🎯',t:'Play To Strengths',d:'Build your career around what you are naturally great at, not what looks impressive.'},
        {i:'📚',t:'Never Stop Learning',d:'Add one new skill every quarter. Compounding knowledge is your unfair advantage.'},
        {i:'🤝',t:'Build Your Network',d:'Opportunities travel through people. Nurture genuine professional relationships.'},
        {i:'🧭',t:'Follow Your Element',d:'Align your work with your elemental nature for energy that never runs out.'},
        {i:'⏳',t:'Be Patient With Growth',d:'Great careers compound slowly. Stay consistent and let results stack up.'},
        {i:'💡',t:'Solve Real Problems',d:'The more valuable the problem you solve, the more your career rewards you.'},
        {i:'🔥',t:'Take Bold Steps',d:'Calculated risks early in your path often unlock the biggest leaps.'},
        {i:'🌟',t:'Own Your Brand',d:'Be known for one thing you do exceptionally well. Reputation opens doors.'}
    ];

    function hashStr(s){ var h=0; for(var i=0;i<s.length;i++){ h=((h<<5)-h+s.charCodeAt(i))|0; } return Math.abs(h); }
    function escapeHtml(s){ return String(s).replace(/[&<>"']/g,function(c){return ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'})[c];}); }

    function signFor(month, day){
        for (var i=0;i<SIGNS.length;i++){
            var s = SIGNS[i];
            if ((month === s.from[0] && day >= s.from[1]) || (month === s.to[0] && day <= s.to[1])) return s;
        }
        return SIGNS[3];
    }
    function reduceNum(n){
        while (n > 9 && n !== 11 && n !== 22 && n !== 33){
            var t = 0; String(n).split('').forEach(function(d){ t += parseInt(d,10); }); n = t;
        }
        return n;
    }
    function lifePath(y, m, d){
        var total = 0;
        (String(y)+String(m)+String(d)).split('').forEach(function(c){ total += parseInt(c,10); });
        return reduceNum(total);
    }

    var phases = { input:$('cp-input-phase'), loading:$('cp-loading'), result:$('cp-result') };
    var loadSteps = ['🔮 Reading your birth chart...','🔢 Calculating life path...','💼 Matching career fields...','✨ Finalising your report...'];
    function runLoading(cb){
        var stepEl=$('cp-load-step'), barEl=$('cp-progress-bar'), i=0;
        stepEl.textContent=loadSteps[0]; barEl.style.width='8%';
        var iv=setInterval(function(){ i++; if(i<loadSteps.length){ stepEl.style.opacity='0'; setTimeout(function(){ stepEl.textContent=loadSteps[i]; stepEl.style.opacity='1'; },200); barEl.style.width=((i+1)*25)+'%'; } else { clearInterval(iv); barEl.style.width='100%'; setTimeout(cb,350); } },650);
    }
    function animateNum(el,from,to,dur){ var st=performance.now(); function tick(now){ var p=Math.min(1,(now-st)/dur); var e=1-Math.pow(1-p,3); el.textContent=Math.round(from+(to-from)*e); if(p<1) requestAnimationFrame(tick); } requestAnimationFrame(tick); }
    function confetti(){ var colors=['#E63946','#ff6b9d','#fbbf24','#7B2D8B','#fff']; var box=document.createElement('div'); box.className='cp-confetti'; for(var i=0;i<55;i++){ var p=document.createElement('i'); p.style.left=(Math.random()*100)+'%'; p.style.background=colors[Math.floor(Math.random()*colors.length)]; p.style.animationDuration=(1.5+Math.random()*2)+'s'; p.style.animationDelay=(Math.random()*0.5)+'s'; p.style.transform='rotate('+(Math.random()*360)+'deg)'; box.appendChild(p);} document.body.appendChild(box); setTimeout(function(){ box.remove(); },4000); }

    function levelFor(score){
        if (score>=90) return {e:'👑',n:'Exceptional Potential',c:'#d4af37'};
        if (score>=80) return {e:'🚀',n:'High Achiever',c:'#E63946'};
        if (score>=70) return {e:'💼',n:'Strong & Promising',c:'#7B2D8B'};
        return {e:'🌱',n:'Growing Potential',c:'#2563eb'};
    }

    var state = {};

    function showResult(){
        var name = ($('cp-name').value||'').trim();
        var dob = $('cp-dob').value; // YYYY-MM-DD
        var parts = dob.split('-');
        var y=parseInt(parts[0],10), m=parseInt(parts[1],10), d=parseInt(parts[2],10);
        var sign = signFor(m, d);
        var lp = lifePath(y, m, d);
        var seed = hashStr(dob + sign.key);
        var score = 70 + (seed % 29); // 70-98
        var level = levelFor(score);

        $('cp-rc-icon').textContent = sign.icon;
        $('cp-rc-name').textContent = name ? (name.charAt(0).toUpperCase()+name.slice(1)) : sign.name;
        $('cp-rc-meta').innerHTML = sign.name + ' · ' + sign.element + ' · Ruled by ' + sign.planet + ' · Life Path ' + lp;
        $('cp-level').innerHTML = level.e + ' ' + level.n;
        var who = name ? (name.charAt(0).toUpperCase()+name.slice(1)) : ('As a ' + sign.name);
        $('cp-summary').textContent = who + ', your ' + sign.element.toLowerCase() + ' energy and Life Path ' + lp + ' point to a career where ' + (FIELDS_BY_ELEMENT[sign.element][0].t.toLowerCase()) + ' and ' + (FIELDS_BY_ELEMENT[sign.element][1].t.toLowerCase()) + ' let you thrive. Lead with your strengths and success follows.';

        // lucky
        var color = COLORS[seed % COLORS.length];
        $('cp-luck-swatch').style.background = color.c; $('cp-luck-color').textContent = color.n;
        $('cp-luck-num').textContent = (lp === 11 || lp === 22 || lp === 33) ? lp : (reduceNum(seed % 90 + 1));
        $('cp-luck-day').textContent = DAYS[seed % 7];
        $('cp-luck-dir').textContent = DIRS[(Math.floor(seed/7)) % 8];

        // fields (pick 4 of 6 for the element, rotate by seed)
        var pool = FIELDS_BY_ELEMENT[sign.element];
        var start = seed % pool.length;
        var picks = []; for (var fi=0; fi<4; fi++){ picks.push(pool[(start+fi)%pool.length]); }
        var fg = $('cp-fields'); fg.innerHTML='';
        picks.forEach(function(f, idx){ var el=document.createElement('div'); el.className='cp-fchip'; el.style.animationDelay=(idx*0.08)+'s'; el.innerHTML='<span class="cp-fchip-icon">'+f.i+'</span><span><span class="cp-fchip-txt">'+f.t+'</span><br><span class="cp-fchip-sub">'+f.s+'</span></span>'; fg.appendChild(el); });

        // life path card
        var lpData = LIFEPATH[lp] || LIFEPATH[1];
        $('cp-lp-num').textContent = lp; $('cp-lp-title').textContent = lpData.t; $('cp-lp-text').textContent = lpData.d;

        // strength bars (derived from element + seed)
        function bar(base, off){ var v = base + (hashStr(dob+off) % 22) - 8; return Math.max(45, Math.min(99, v)); }
        var leadBase = sign.element==='Fire'?88:(sign.element==='Earth'?78:(sign.element==='Air'?72:68));
        var creBase  = sign.element==='Water'?90:(sign.element==='Fire'?80:(sign.element==='Air'?82:70));
        var anaBase  = sign.element==='Air'?88:(sign.element==='Earth'?86:(sign.element==='Water'?74:72));
        var comBase  = sign.element==='Air'?90:(sign.element==='Fire'?82:(sign.element==='Water'?80:74));
        var bars = { lead:bar(leadBase,'L'), cre:bar(creBase,'C'), ana:bar(anaBase,'A'), com:bar(comBase,'M') };

        // env
        var env = ENV_BY_ELEMENT[sign.element];
        $('cp-env-text').textContent = env.text;
        var et = $('cp-env-tags'); et.innerHTML=''; env.tags.forEach(function(t){ var s=document.createElement('span'); s.className='cp-tag'; s.textContent=t; et.appendChild(s); });

        // tips (4 distinct)
        var tips=[], used={}, ti=seed; while(tips.length<4){ var t=TIPS_POOL[ti%TIPS_POOL.length]; if(!used[t.t]){used[t.t]=1; tips.push(t);} ti+=3; }
        $('cp-tips-title').innerHTML = '⭐ Golden Career Tips' + (name ? (' for ' + escapeHtml(name.charAt(0).toUpperCase()+name.slice(1))) : '');
        var tg=$('cp-tips-grid'); tg.innerHTML=''; tips.forEach(function(t,idx){ var el=document.createElement('div'); el.className='cp-tip'; el.style.animationDelay=(idx*0.1)+'s'; el.innerHTML='<div class="cp-tip-icon">'+t.i+'</div><h4>'+t.t+'</h4><p>'+t.d+'</p>'; tg.appendChild(el); });

        // show
        phases.loading.classList.remove('cp-show'); phases.loading.style.display='none';
        phases.result.classList.add('cp-show');
        animateNum($('cp-pct'),0,score,1800);
        var circ=2*Math.PI*86; setTimeout(function(){ $('cp-ring-fg').style.strokeDashoffset = circ-(circ*score/100); },80);
        setTimeout(function(){
            $('cp-b1').style.width=bars.lead+'%'; $('cp-b1-v').textContent=bars.lead+'%';
            $('cp-b2').style.width=bars.cre+'%';  $('cp-b2-v').textContent=bars.cre+'%';
            $('cp-b3').style.width=bars.ana+'%';  $('cp-b3-v').textContent=bars.ana+'%';
            $('cp-b4').style.width=bars.com+'%';  $('cp-b4-v').textContent=bars.com+'%';
        },200);

        setupShare(sign, lp, score, level, name);
        if (score>=82) setTimeout(confetti, 600);
        setTimeout(function(){ phases.result.scrollIntoView({behavior:'smooth',block:'start'}); },100);
    }

    function setupShare(sign, lp, score, level, name){
        var url=window.location.href;
        var who = name ? (name.charAt(0).toUpperCase()+name.slice(1)) : sign.name;
        var msg = '💼 Career Prediction for ' + who + '\n\nCareer Power: ' + score + '% (' + level.n + ')\nSun Sign: ' + sign.name + ' · Life Path ' + lp + '\n\nGet yours: ' + url;
        var tweet = 'My career power is ' + score + '% (' + level.n + ') 🚀 ' + sign.name + ' · Life Path ' + lp + '. Check yours:';
        $('cp-sb-wa').href='https://wa.me/?text='+encodeURIComponent(msg);
        $('cp-sb-tw').href='https://twitter.com/intent/tweet?text='+encodeURIComponent(tweet)+'&url='+encodeURIComponent(url);
        $('cp-sb-copy').onclick=function(){ var b=this,o=b.innerHTML; try{ if(navigator.clipboard){ navigator.clipboard.writeText(url).then(function(){ b.innerHTML='✅ Copied!'; setTimeout(function(){ b.innerHTML=o; },1800); }); } else { var ta=document.createElement('textarea'); ta.value=url; document.body.appendChild(ta); ta.select(); document.execCommand('copy'); ta.remove(); b.innerHTML='✅ Copied!'; setTimeout(function(){ b.innerHTML=o; },1800);} }catch(e){ b.innerHTML='⚠ Try Manually'; setTimeout(function(){ b.innerHTML=o; },1800);} };
        $('cp-sb-save').onclick=function(){ var b=this,o=b.innerHTML; b.innerHTML='📸 Saving...'; setTimeout(function(){ if(navigator.share){ navigator.share({title:'Career Prediction',text:msg,url:url}).then(function(){ b.innerHTML=o; }).catch(function(){ alert('Screenshot your report to save it!'); b.innerHTML=o; }); } else { alert('Screenshot your report to save it!\n\n'+who+' — '+score+'% Career Power'); b.innerHTML=o; } },400); };
    }

    function go(){
        var dob=$('cp-dob').value;
        if(!dob){ $('cp-error').textContent='Please enter your date of birth.'; $('cp-error').classList.add('cp-show'); return; }
        var y=parseInt(dob.split('-')[0],10);
        if(isNaN(y) || y<1900 || y>new Date().getFullYear()){ $('cp-error').textContent='Please enter a valid date of birth.'; $('cp-error').classList.add('cp-show'); return; }
        $('cp-error').classList.remove('cp-show');
        phases.input.style.display='none';
        phases.loading.style.display='block'; phases.loading.classList.add('cp-show');
        $('cp-progress-bar').style.width='0%';
        runLoading(showResult);
    }
    $('cp-go-btn').addEventListener('click', go);
    $('cp-dob').addEventListener('keydown', function(e){ if(e.key==='Enter'){ e.preventDefault(); go(); } });

    $('cp-try-btn').addEventListener('click', function(){
        phases.result.classList.remove('cp-show');
        phases.loading.classList.remove('cp-show'); phases.loading.style.display='none';
        phases.input.style.display='block';
        $('cp-pct').textContent='0'; $('cp-ring-fg').style.strokeDashoffset=540.35;
        ['cp-b1','cp-b2','cp-b3','cp-b4'].forEach(function(id){ $(id).style.width='0%'; });
        $('cp-card').scrollIntoView({behavior:'smooth',block:'start'});
    });

    var counterEl=$('cp-counter'); var count=194508;
    setInterval(function(){ count+=1+Math.floor(Math.random()*3); counterEl.textContent=count.toLocaleString('en-IN'); },8000);
})();
        <?php
        $cp_js = ob_get_clean();

        if ( ! wp_script_is( 'cp-pro-inline', 'enqueued' ) ) {
            wp_register_script( 'cp-pro-inline', '', array(), '1.0.0', true );
            wp_enqueue_script( 'cp-pro-inline' );
            wp_add_inline_script( 'cp-pro-inline', $cp_js );
        }

        return $cp_html;
    }

    add_shortcode( 'career_prediction', 'cp_pro_render_career' );
    add_shortcode( 'career_prediction_by_dob', 'cp_pro_render_career' );
    add_shortcode( 'career_astrology', 'cp_pro_render_career' );
}
