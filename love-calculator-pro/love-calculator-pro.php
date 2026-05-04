<?php
/**
 * Plugin Name: Love Calculator Pro
 * Plugin URI: https://lovecalculator.in
 * Description: Premium Love Calculator with animations, golden hints, personalized advice, share cards, FAQ schema, and related tools. Use shortcode [love_calculator].
 * Version: 1.0.0
 * Author: lovecalculator.in
 * Author URI: https://lovecalculator.in
 * License: GPL-2.0+
 * Text Domain: love-calculator-pro
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! function_exists( 'lc_pro_render_calculator' ) ) {

    function lc_pro_render_calculator( $atts = array() ) {
        ob_start();
        ?>
<div class="lc-wrap" id="lc-wrap">
    <style>
        .lc-wrap, .lc-wrap *, .lc-wrap *::before, .lc-wrap *::after { box-sizing: border-box; }
        .lc-wrap { font-family: 'DM Sans', 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; color: #1f1933; max-width: 880px; margin: 0 auto; padding: 12px; line-height: 1.55; }
        .lc-wrap h1, .lc-wrap h2, .lc-wrap h3, .lc-wrap h4 { font-family: 'Poppins', 'Syne', system-ui, sans-serif; font-weight: 800; letter-spacing: -0.01em; margin: 0; }

        /* Header */
        .lc-header { background: linear-gradient(135deg, #1a0533 0%, #3d0b55 50%, #690d3a 100%); border-radius: 22px; padding: 28px 20px; color: #fff; text-align: center; box-shadow: 0 20px 60px rgba(105, 13, 58, 0.25); position: relative; overflow: hidden; }
        .lc-header::before { content: ""; position: absolute; inset: -50%; background: radial-gradient(circle at 30% 20%, rgba(230,57,70,0.18), transparent 60%), radial-gradient(circle at 70% 80%, rgba(123,45,139,0.25), transparent 60%); pointer-events: none; }
        .lc-header-icon { font-size: 50px; line-height: 1; display: inline-block; animation: lc-bob 2.4s ease-in-out infinite; }
        .lc-header h1 { font-size: 38px; margin: 8px 0 6px; color: #fff; }
        .lc-header-sub { opacity: 0.86; font-size: 15px; margin: 0; }
        .lc-stats { display: flex; align-items: center; justify-content: center; gap: 0; margin-top: 18px; flex-wrap: wrap; }
        .lc-stat { padding: 4px 14px; min-width: 96px; }
        .lc-stat-num { font-weight: 800; font-family: 'Poppins', sans-serif; font-size: 18px; color: #fff; }
        .lc-stat-lbl { font-size: 11px; opacity: 0.78; text-transform: uppercase; letter-spacing: 0.06em; }
        .lc-stat + .lc-stat { border-left: 1px solid rgba(255,255,255,0.22); }

        /* Card shell */
        .lc-card { background: #fff; border-radius: 22px; padding: 24px 20px; margin-top: 18px; box-shadow: 0 20px 60px rgba(0,0,0,0.08); border: 1px solid #f1ecf6; }

        /* Input phase */
        .lc-inputs { display: grid; grid-template-columns: 1fr auto 1fr; gap: 14px; align-items: center; }
        .lc-field { display: flex; flex-direction: column; align-items: center; gap: 10px; }
        .lc-avatar { width: 64px; height: 64px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-family: 'Poppins', sans-serif; font-weight: 800; font-size: 26px; color: #fff; box-shadow: 0 8px 24px rgba(0,0,0,0.18); transition: transform .25s ease; }
        .lc-avatar.lc-a { background: linear-gradient(135deg, #E63946, #ff6b9d); }
        .lc-avatar.lc-b { background: linear-gradient(135deg, #7B2D8B, #b558d6); }
        .lc-avatar:hover { transform: scale(1.04); }
        .lc-input { width: 100%; min-height: 52px; padding: 12px 14px; font-size: 16px; border: 2px solid #ece6f3; border-radius: 14px; outline: none; background: #faf8fd; transition: border-color .2s, background .2s, box-shadow .2s; font-family: inherit; }
        .lc-input:focus { border-color: #E63946; background: #fff; box-shadow: 0 0 0 4px rgba(230,57,70,0.12); }
        .lc-vs { width: 56px; height: 56px; border-radius: 50%; background: linear-gradient(135deg, #E63946, #7B2D8B); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 22px; font-weight: 800; font-family: 'Poppins', sans-serif; box-shadow: 0 10px 24px rgba(230,57,70,0.35); animation: lc-pulse 1.6s ease-in-out infinite; }
        .lc-btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; min-height: 56px; padding: 18px 22px; font-size: 17px; font-weight: 700; font-family: 'Poppins', sans-serif; border: none; border-radius: 14px; cursor: pointer; width: 100%; transition: transform .15s ease, box-shadow .2s ease, opacity .2s; }
        .lc-btn-primary { background: linear-gradient(135deg, #E63946, #c81e2c); color: #fff; box-shadow: 0 14px 32px rgba(230,57,70,0.35); margin-top: 18px; }
        .lc-btn-primary:hover { transform: translateY(-2px); box-shadow: 0 18px 40px rgba(230,57,70,0.45); }
        .lc-btn-primary:active { transform: translateY(0); }
        .lc-trust { display: flex; gap: 10px; justify-content: center; flex-wrap: wrap; margin-top: 14px; }
        .lc-trust span { font-size: 12.5px; color: #5b5070; background: #f6f0fb; padding: 6px 12px; border-radius: 999px; min-height: 30px; display: inline-flex; align-items: center; }
        .lc-error { display: none; background: #fff1f2; color: #b3162a; border: 1px solid #ffd6db; padding: 10px 14px; border-radius: 12px; margin-top: 12px; font-size: 14px; text-align: center; }
        .lc-error.lc-show { display: block; animation: lc-shake .4s; }

        /* Loading phase */
        .lc-loading { display: none; text-align: center; padding: 14px 8px 6px; }
        .lc-loading.lc-show { display: block; }
        .lc-rings { position: relative; width: 160px; height: 160px; margin: 6px auto 18px; }
        .lc-ring { position: absolute; inset: 0; border-radius: 50%; border: 3px solid rgba(230,57,70,0.35); animation: lc-ring 2s ease-out infinite; }
        .lc-ring:nth-child(2) { animation-delay: .5s; border-color: rgba(123,45,139,0.4); }
        .lc-ring:nth-child(3) { animation-delay: 1s; border-color: rgba(255,107,157,0.45); }
        .lc-ring-heart { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; font-size: 60px; animation: lc-pulse 1.2s ease-in-out infinite; }
        .lc-load-names { font-size: 18px; font-weight: 700; font-family: 'Poppins', sans-serif; color: #3d0b55; margin-bottom: 12px; }
        .lc-load-step { font-size: 15px; color: #6b5e85; min-height: 24px; transition: opacity .25s; }
        .lc-progress { height: 8px; background: #f1ebf7; border-radius: 999px; overflow: hidden; margin: 14px auto 4px; max-width: 360px; }
        .lc-progress-bar { height: 100%; width: 0%; background: linear-gradient(90deg, #E63946, #7B2D8B); border-radius: 999px; transition: width .3s ease; }

        /* Result phase */
        .lc-result { display: none; }
        .lc-result.lc-show { display: block; animation: lc-fadeUp .55s ease both; }
        .lc-result-card { background: linear-gradient(135deg, #1a0533, #3d0b55, #690d3a); color: #fff; border-radius: 22px; padding: 28px 20px; text-align: center; box-shadow: 0 20px 60px rgba(0,0,0,0.25); position: relative; overflow: hidden; }
        .lc-result-card::after { content: ""; position: absolute; inset: 0; background: radial-gradient(circle at 20% 10%, rgba(230,57,70,0.25), transparent 50%), radial-gradient(circle at 80% 90%, rgba(255,107,157,0.18), transparent 55%); pointer-events: none; }
        .lc-rc-names { display: flex; align-items: center; justify-content: center; gap: 14px; flex-wrap: wrap; margin-bottom: 6px; position: relative; z-index: 1; }
        .lc-rc-name { display: flex; align-items: center; gap: 10px; font-weight: 700; font-family: 'Poppins', sans-serif; font-size: 17px; }
        .lc-rc-name .lc-avatar { width: 44px; height: 44px; font-size: 18px; }
        .lc-rc-heart { font-size: 22px; opacity: 0.85; }
        .lc-ring-wrap { position: relative; width: 220px; height: 220px; margin: 14px auto 10px; z-index: 1; }
        .lc-ring-wrap svg { transform: rotate(-90deg); width: 100%; height: 100%; }
        .lc-ring-bg { fill: none; stroke: rgba(255,255,255,0.12); stroke-width: 12; }
        .lc-ring-fg { fill: none; stroke: url(#lc-grad); stroke-width: 12; stroke-linecap: round; transition: stroke-dashoffset 1.8s cubic-bezier(.22,.9,.3,1); }
        .lc-percent { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; flex-direction: column; }
        .lc-percent-num { font-size: 64px; font-weight: 800; font-family: 'Poppins', sans-serif; line-height: 1; }
        .lc-percent-sym { font-size: 24px; font-weight: 700; opacity: 0.85; }
        .lc-level { display: inline-block; background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.22); padding: 8px 18px; border-radius: 999px; font-weight: 700; font-family: 'Poppins', sans-serif; font-size: 15px; margin: 6px 0 10px; position: relative; z-index: 1; }
        .lc-rc-desc { max-width: 580px; margin: 0 auto; opacity: 0.92; font-size: 15px; position: relative; z-index: 1; }
        .lc-watermark { margin-top: 14px; font-size: 12.5px; opacity: 0.7; position: relative; z-index: 1; }

        /* Bars */
        .lc-bars { margin-top: 6px; }
        .lc-bar-row { margin: 14px 0; }
        .lc-bar-top { display: flex; justify-content: space-between; font-size: 14px; font-weight: 600; color: #2d2447; margin-bottom: 6px; }
        .lc-bar-top span:last-child { color: #7B2D8B; font-family: 'Poppins', sans-serif; font-weight: 800; }
        .lc-bar { height: 10px; background: #f1ebf7; border-radius: 999px; overflow: hidden; }
        .lc-bar-fill { height: 100%; width: 0%; border-radius: 999px; background: linear-gradient(90deg, #E63946, #7B2D8B); transition: width 1.5s cubic-bezier(.22,.9,.3,1); }

        /* Golden hints */
        .lc-hints { background: linear-gradient(135deg, #fff8dc, #fff1c1); border-radius: 18px; padding: 20px; margin-top: 18px; border: 1px solid #f7e190; }
        .lc-hints h3 { font-size: 19px; color: #7a5a05; margin-bottom: 12px; }
        .lc-hints-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; }
        .lc-hint { background: #fff; border-radius: 14px; padding: 14px; border-left: 4px solid #E63946; box-shadow: 0 8px 20px rgba(0,0,0,0.05); opacity: 0; transform: translateY(8px); animation: lc-fadeUp .5s ease forwards; }
        .lc-hint-icon { font-size: 22px; margin-bottom: 4px; }
        .lc-hint h4 { font-size: 14.5px; color: #3d0b55; margin-bottom: 4px; }
        .lc-hint p { font-size: 13px; color: #5b5070; margin: 0; }

        /* Advice */
        .lc-advice { background: linear-gradient(135deg, #e7f7ec, #d2efdc); border-radius: 18px; padding: 20px; margin-top: 16px; border: 1px solid #b8e2c5; }
        .lc-advice h3 { font-size: 18px; color: #155d3a; margin-bottom: 8px; }
        .lc-advice p { font-style: italic; color: #1f3f2c; margin: 0 0 12px; }
        .lc-tags { display: flex; flex-wrap: wrap; gap: 8px; }
        .lc-tag { background: #fff; padding: 6px 12px; border-radius: 999px; font-size: 12.5px; font-weight: 600; color: #155d3a; border: 1px solid #b8e2c5; }
        .lc-tag.lc-t2 { color: #6c2dba; border-color: #d8c1f0; }
        .lc-tag.lc-t3 { color: #b3162a; border-color: #ffc8ce; }
        .lc-tag.lc-t4 { color: #b6770b; border-color: #f4dca0; }

        /* Share buttons */
        .lc-share { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin-top: 18px; }
        .lc-share-btn { display: inline-flex; align-items: center; justify-content: center; gap: 6px; min-height: 48px; padding: 12px 8px; font-size: 14px; font-weight: 700; font-family: 'Poppins', sans-serif; border-radius: 12px; border: none; cursor: pointer; color: #fff; text-decoration: none; transition: transform .15s ease, box-shadow .15s ease; }
        .lc-share-btn:hover { transform: translateY(-2px); box-shadow: 0 12px 26px rgba(0,0,0,0.15); }
        .lc-sb-wa { background: #25d366; }
        .lc-sb-tw { background: #111; }
        .lc-sb-save { background: linear-gradient(135deg, #E63946, #7B2D8B); }
        .lc-sb-copy { background: #5b5b6e; }

        .lc-try { margin-top: 14px; background: #fff; color: #3d0b55; border: 2px solid #ece6f3; }
        .lc-try:hover { border-color: #7B2D8B; color: #7B2D8B; }

        /* Confetti */
        .lc-confetti { position: fixed; inset: 0; pointer-events: none; z-index: 9999; overflow: hidden; }
        .lc-confetti i { position: absolute; top: -20px; width: 10px; height: 14px; opacity: 0.95; animation: lc-fall linear forwards; border-radius: 2px; }

        /* Score levels */
        .lc-levels { display: grid; grid-template-columns: repeat(5, 1fr); gap: 10px; margin-top: 22px; }
        .lc-lvl { background: #fff; border-radius: 16px; padding: 14px 10px; text-align: center; box-shadow: 0 10px 24px rgba(0,0,0,0.06); border-top: 4px solid #E63946; }
        .lc-lvl:nth-child(1) { border-color: #d4af37; }
        .lc-lvl:nth-child(2) { border-color: #E63946; }
        .lc-lvl:nth-child(3) { border-color: #7B2D8B; }
        .lc-lvl:nth-child(4) { border-color: #2563eb; }
        .lc-lvl:nth-child(5) { border-color: #14b8a6; }
        .lc-lvl-icon { font-size: 26px; }
        .lc-lvl h4 { font-size: 14px; color: #1f1933; margin: 4px 0; }
        .lc-lvl-range { font-size: 12px; color: #7B2D8B; font-weight: 700; }
        .lc-lvl-desc { font-size: 12px; color: #5b5070; margin: 4px 0 0; }

        /* FAQ */
        .lc-faq { margin-top: 22px; }
        .lc-faq h2 { font-size: 24px; color: #3d0b55; margin-bottom: 12px; }
        .lc-faq-item { background: #fff; border-radius: 14px; margin-bottom: 10px; box-shadow: 0 8px 20px rgba(0,0,0,0.05); border: 1px solid #f1ecf6; overflow: hidden; }
        .lc-faq-q { width: 100%; min-height: 56px; padding: 16px 18px; background: #fff; border: none; text-align: left; font-size: 15.5px; font-weight: 700; font-family: 'Poppins', sans-serif; color: #1f1933; cursor: pointer; display: flex; justify-content: space-between; align-items: center; gap: 10px; }
        .lc-faq-q::after { content: "+"; font-size: 24px; font-weight: 400; color: #7B2D8B; transition: transform .25s; }
        .lc-faq-item.lc-open .lc-faq-q::after { transform: rotate(45deg); }
        .lc-faq-a { padding: 0 18px; max-height: 0; overflow: hidden; transition: max-height .35s ease, padding .35s ease; color: #5b5070; font-size: 14.5px; }
        .lc-faq-item.lc-open .lc-faq-a { padding: 0 18px 18px; max-height: 600px; }

        /* Related tools */
        .lc-related { margin-top: 22px; }
        .lc-related h2 { font-size: 22px; color: #3d0b55; margin-bottom: 12px; }
        .lc-related-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; }
        .lc-rt { display: block; text-decoration: none; background: #fff; border-radius: 16px; padding: 16px 12px; text-align: center; box-shadow: 0 10px 24px rgba(0,0,0,0.06); border-top: 4px solid #E63946; color: inherit; transition: transform .15s ease, box-shadow .2s ease; }
        .lc-rt:hover { transform: translateY(-3px); box-shadow: 0 16px 32px rgba(0,0,0,0.1); }
        .lc-rt:nth-child(1) { border-color: #ff6b35; }
        .lc-rt:nth-child(2) { border-color: #14b8a6; }
        .lc-rt:nth-child(3) { border-color: #E63946; }
        .lc-rt:nth-child(4) { border-color: #7B2D8B; }
        .lc-rt-icon { font-size: 28px; }
        .lc-rt h4 { font-size: 14.5px; color: #1f1933; margin: 6px 0 4px; }
        .lc-rt p { font-size: 12.5px; color: #5b5070; margin: 0; }

        /* Animations */
        @keyframes lc-pulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.08); } }
        @keyframes lc-bob { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-6px); } }
        @keyframes lc-ring { 0% { transform: scale(0.6); opacity: 0.9; } 100% { transform: scale(1.4); opacity: 0; } }
        @keyframes lc-fadeUp { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes lc-shake { 0%, 100% { transform: translateX(0); } 25% { transform: translateX(-4px); } 75% { transform: translateX(4px); } }
        @keyframes lc-fall { 0% { transform: translateY(-20px) rotate(0); opacity: 1; } 100% { transform: translateY(110vh) rotate(720deg); opacity: 0.3; } }

        /* Mobile */
        @media (max-width: 640px) {
            .lc-wrap { padding: 8px; }
            .lc-header { padding: 22px 16px; border-radius: 18px; }
            .lc-header h1 { font-size: 30px; }
            .lc-header-icon { font-size: 44px; }
            .lc-stat-num { font-size: 16px; }
            .lc-card { padding: 20px 16px; border-radius: 18px; }
            .lc-inputs { grid-template-columns: 1fr; gap: 12px; }
            .lc-vs { margin: -4px auto; }
            .lc-percent-num { font-size: 56px; }
            .lc-ring-wrap { width: 200px; height: 200px; }
            .lc-share { grid-template-columns: repeat(2, 1fr); }
            .lc-levels { grid-template-columns: repeat(2, 1fr); }
            .lc-related-grid { grid-template-columns: repeat(2, 1fr); }
            .lc-hints-grid { grid-template-columns: 1fr; }
        }

        @media (max-width: 380px) {
            .lc-header h1 { font-size: 26px; }
            .lc-stat { padding: 4px 8px; min-width: 86px; }
        }
    </style>

    <!-- Header -->
    <header class="lc-header">
        <div class="lc-header-icon">&#128157;</div>
        <h1>Love Calculator</h1>
        <p class="lc-header-sub">Find your true love compatibility in seconds</p>
        <div class="lc-stats">
            <div class="lc-stat">
                <div class="lc-stat-num" id="lc-counter">3,84,219</div>
                <div class="lc-stat-lbl">Tests Today</div>
            </div>
            <div class="lc-stat">
                <div class="lc-stat-num">4.9&#9733;</div>
                <div class="lc-stat-lbl">Rating</div>
            </div>
            <div class="lc-stat">
                <div class="lc-stat-num">100%</div>
                <div class="lc-stat-lbl">Free</div>
            </div>
        </div>
    </header>

    <!-- Calculator card -->
    <section class="lc-card">
        <!-- Input phase -->
        <div class="lc-input-phase" id="lc-input-phase">
            <div class="lc-inputs">
                <div class="lc-field">
                    <div class="lc-avatar lc-a" id="lc-av-a">?</div>
                    <input type="text" class="lc-input" id="lc-name-a" placeholder="Your name" maxlength="30" autocomplete="off" />
                </div>
                <div class="lc-vs" aria-hidden="true">&#10084;</div>
                <div class="lc-field">
                    <div class="lc-avatar lc-b" id="lc-av-b">?</div>
                    <input type="text" class="lc-input" id="lc-name-b" placeholder="Their name" maxlength="30" autocomplete="off" />
                </div>
            </div>
            <div class="lc-error" id="lc-error">Please enter both names to continue.</div>
            <button type="button" class="lc-btn lc-btn-primary" id="lc-calc-btn">Calculate Love &#10084;</button>
            <div class="lc-trust">
                <span>&#128274; Private</span>
                <span>&#9889; Instant</span>
                <span>&#127378; Free</span>
            </div>
        </div>

        <!-- Loading phase -->
        <div class="lc-loading" id="lc-loading">
            <div class="lc-rings">
                <div class="lc-ring"></div>
                <div class="lc-ring"></div>
                <div class="lc-ring"></div>
                <div class="lc-ring-heart">&#128156;</div>
            </div>
            <div class="lc-load-names" id="lc-load-names">&#10084;</div>
            <div class="lc-load-step" id="lc-load-step">&#128140; Scanning your names...</div>
            <div class="lc-progress"><div class="lc-progress-bar" id="lc-progress-bar"></div></div>
        </div>

        <!-- Result phase -->
        <div class="lc-result" id="lc-result">
            <div class="lc-result-card">
                <div class="lc-rc-names">
                    <div class="lc-rc-name"><div class="lc-avatar lc-a" id="lc-rc-av-a">?</div><span id="lc-rc-n-a">Name 1</span></div>
                    <div class="lc-rc-heart">&#10084;</div>
                    <div class="lc-rc-name"><div class="lc-avatar lc-b" id="lc-rc-av-b">?</div><span id="lc-rc-n-b">Name 2</span></div>
                </div>
                <div class="lc-ring-wrap">
                    <svg viewBox="0 0 200 200" aria-hidden="true">
                        <defs>
                            <linearGradient id="lc-grad" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#ff6b9d"/>
                                <stop offset="100%" stop-color="#fbbf24"/>
                            </linearGradient>
                        </defs>
                        <circle class="lc-ring-bg" cx="100" cy="100" r="86"/>
                        <circle class="lc-ring-fg" id="lc-ring-fg" cx="100" cy="100" r="86" stroke-dasharray="540.35" stroke-dashoffset="540.35"/>
                    </svg>
                    <div class="lc-percent">
                        <div><span class="lc-percent-num" id="lc-pct">0</span><span class="lc-percent-sym">%</span></div>
                    </div>
                </div>
                <div class="lc-level" id="lc-level">&#128156; Calculating...</div>
                <p class="lc-rc-desc" id="lc-desc">Your love story is being written...</p>
                <div class="lc-watermark">lovecalculator.in &#10084;</div>
            </div>

            <!-- Bars -->
            <div class="lc-bars">
                <div class="lc-bar-row">
                    <div class="lc-bar-top"><span>&#128274; Trust</span><span id="lc-b1-v">0%</span></div>
                    <div class="lc-bar"><div class="lc-bar-fill" id="lc-b1"></div></div>
                </div>
                <div class="lc-bar-row">
                    <div class="lc-bar-top"><span>&#10024; Chemistry</span><span id="lc-b2-v">0%</span></div>
                    <div class="lc-bar"><div class="lc-bar-fill" id="lc-b2"></div></div>
                </div>
                <div class="lc-bar-row">
                    <div class="lc-bar-top"><span>&#128172; Communication</span><span id="lc-b3-v">0%</span></div>
                    <div class="lc-bar"><div class="lc-bar-fill" id="lc-b3"></div></div>
                </div>
                <div class="lc-bar-row">
                    <div class="lc-bar-top"><span>&#127881; Long-term Potential</span><span id="lc-b4-v">0%</span></div>
                    <div class="lc-bar"><div class="lc-bar-fill" id="lc-b4"></div></div>
                </div>
            </div>

            <!-- Golden hints -->
            <div class="lc-hints">
                <h3 id="lc-hints-title">&#11088; Golden Hints</h3>
                <div class="lc-hints-grid" id="lc-hints-grid"></div>
            </div>

            <!-- Advice -->
            <div class="lc-advice">
                <h3>&#129302; Personalized Love Advice</h3>
                <p id="lc-advice-text"></p>
                <div class="lc-tags" id="lc-tags"></div>
            </div>

            <!-- Share -->
            <div class="lc-share">
                <a href="#" class="lc-share-btn lc-sb-wa" id="lc-sb-wa" target="_blank" rel="noopener">&#128241; WhatsApp</a>
                <a href="#" class="lc-share-btn lc-sb-tw" id="lc-sb-tw" target="_blank" rel="noopener">&#119991; Twitter</a>
                <button type="button" class="lc-share-btn lc-sb-save" id="lc-sb-save">&#128247; Save Card</button>
                <button type="button" class="lc-share-btn lc-sb-copy" id="lc-sb-copy">&#128279; Copy Link</button>
            </div>

            <button type="button" class="lc-btn lc-try" id="lc-try-btn">&#128260; Try Again</button>
        </div>
    </section>

    <!-- Score levels -->
    <section class="lc-levels">
        <div class="lc-lvl"><div class="lc-lvl-icon">&#128081;</div><h4>Soulmates</h4><div class="lc-lvl-range">90-100%</div><p class="lc-lvl-desc">Made for each other</p></div>
        <div class="lc-lvl"><div class="lc-lvl-icon">&#128149;</div><h4>Perfect Match</h4><div class="lc-lvl-range">70-89%</div><p class="lc-lvl-desc">Strong love bond</p></div>
        <div class="lc-lvl"><div class="lc-lvl-icon">&#128156;</div><h4>Good Potential</h4><div class="lc-lvl-range">50-69%</div><p class="lc-lvl-desc">Worth nurturing</p></div>
        <div class="lc-lvl"><div class="lc-lvl-icon">&#128153;</div><h4>Needs Effort</h4><div class="lc-lvl-range">30-49%</div><p class="lc-lvl-desc">Grow together</p></div>
        <div class="lc-lvl"><div class="lc-lvl-icon">&#129309;</div><h4>Just Friends</h4><div class="lc-lvl-range">0-29%</div><p class="lc-lvl-desc">Friendship is gold</p></div>
    </section>

    <!-- FAQ -->
    <section class="lc-faq">
        <h2>Frequently Asked Questions</h2>
        <div class="lc-faq-item">
            <button class="lc-faq-q" type="button">How does love calculator work by name?</button>
            <div class="lc-faq-a"><p>Our love calculator analyzes both names using letter frequency overlap, name numerology, and length harmony. Each name is converted to numerical values, compared, and run through a multi-factor scoring algorithm to give a consistent compatibility percentage.</p></div>
        </div>
        <div class="lc-faq-item">
            <button class="lc-faq-q" type="button">Is the love calculator percentage accurate?</button>
            <div class="lc-faq-a"><p>The calculator is designed for fun and self-reflection. While the algorithm is consistent (same names always give the same result), real relationships depend on communication, trust, and effort &mdash; not numbers. Take it as a fun starting point.</p></div>
        </div>
        <div class="lc-faq-item">
            <button class="lc-faq-q" type="button">What is a good love percentage?</button>
            <div class="lc-faq-a"><p>Anything above 70% is considered a strong match. 50-69% means good potential with effort. Below 50% doesn&rsquo;t mean failure &mdash; many great relationships started low and grew strong through care and shared experiences.</p></div>
        </div>
        <div class="lc-faq-item">
            <button class="lc-faq-q" type="button">Is my data private and safe?</button>
            <div class="lc-faq-a"><p>Yes. Names are processed entirely in your browser. Nothing is sent to any server, stored, or shared. The calculation is 100% client-side and completely private.</p></div>
        </div>
        <div class="lc-faq-item">
            <button class="lc-faq-q" type="button">Can I use Hindi or Indian names?</button>
            <div class="lc-faq-a"><p>Absolutely. The calculator works with any names &mdash; English, Hindi, Tamil, Bengali, or any other. Just type the name as you spell it in English letters and the algorithm handles the rest.</p></div>
        </div>
        <div class="lc-faq-item">
            <button class="lc-faq-q" type="button">Is the love calculator free to use?</button>
            <div class="lc-faq-a"><p>100% free, with no signup, no ads in the result, and no hidden charges. Use it as many times as you want and share results with friends and partner.</p></div>
        </div>
    </section>

    <!-- Related tools -->
    <section class="lc-related">
        <h2>Try More Love Tools</h2>
        <div class="lc-related-grid">
            <a class="lc-rt" href="/flames-calculator/"><div class="lc-rt-icon">&#128293;</div><h4>FLAMES</h4><p>Friends, Love, Affection, Marriage, Enemies, Siblings</p></a>
            <a class="lc-rt" href="/friendship-calculator/"><div class="lc-rt-icon">&#129309;</div><h4>Friendship</h4><p>How strong is your friendship bond?</p></a>
            <a class="lc-rt" href="/crush-calculator/"><div class="lc-rt-icon">&#128150;</div><h4>Crush Calc</h4><p>Find out if your crush likes you back</p></a>
            <a class="lc-rt" href="/compatibility-test/"><div class="lc-rt-icon">&#128302;</div><h4>Compatibility</h4><p>Deep zodiac &amp; personality compatibility</p></a>
        </div>
    </section>

    <!-- JSON-LD Schema -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@graph": [
        {
          "@type": "SoftwareApplication",
          "name": "Love Calculator",
          "applicationCategory": "LifestyleApplication",
          "operatingSystem": "Web",
          "url": "https://lovecalculator.in/",
          "offers": { "@type": "Offer", "price": "0", "priceCurrency": "USD" },
          "aggregateRating": { "@type": "AggregateRating", "ratingValue": "4.9", "ratingCount": "12847" }
        },
        {
          "@type": "FAQPage",
          "mainEntity": [
            { "@type": "Question", "name": "How does love calculator work by name?", "acceptedAnswer": { "@type": "Answer", "text": "Our love calculator analyzes both names using letter frequency overlap, name numerology, and length harmony. Each name is converted to numerical values, compared, and run through a multi-factor scoring algorithm to give a consistent compatibility percentage." } },
            { "@type": "Question", "name": "Is the love calculator percentage accurate?", "acceptedAnswer": { "@type": "Answer", "text": "The calculator is designed for fun and self-reflection. While the algorithm is consistent (same names always give the same result), real relationships depend on communication, trust, and effort — not numbers." } },
            { "@type": "Question", "name": "What is a good love percentage?", "acceptedAnswer": { "@type": "Answer", "text": "Anything above 70% is considered a strong match. 50-69% means good potential with effort. Below 50% doesn’t mean failure — many great relationships started low and grew strong through care and shared experiences." } },
            { "@type": "Question", "name": "Is my data private and safe?", "acceptedAnswer": { "@type": "Answer", "text": "Yes. Names are processed entirely in your browser. Nothing is sent to any server, stored, or shared. The calculation is 100% client-side and completely private." } },
            { "@type": "Question", "name": "Can I use Hindi or Indian names?", "acceptedAnswer": { "@type": "Answer", "text": "Absolutely. The calculator works with any names — English, Hindi, Tamil, Bengali, or any other. Just type the name as you spell it in English letters and the algorithm handles the rest." } },
            { "@type": "Question", "name": "Is the love calculator free to use?", "acceptedAnswer": { "@type": "Answer", "text": "100% free, with no signup, no ads in the result, and no hidden charges. Use it as many times as you want and share results with friends and partner." } }
          ]
        }
      ]
    }
    </script>
</div>

<script>
(function(){
    'use strict';
    var LC = {
        $: function(id){ return document.getElementById(id); },
        nameA: '', nameB: '', score: 0, level: '', metrics: { trust: 0, chem: 0, comm: 0, lt: 0 }
    };

    var elInputPhase = LC.$('lc-input-phase');
    var elLoading = LC.$('lc-loading');
    var elResult = LC.$('lc-result');
    var elNameA = LC.$('lc-name-a');
    var elNameB = LC.$('lc-name-b');
    var elAvA = LC.$('lc-av-a');
    var elAvB = LC.$('lc-av-b');
    var elError = LC.$('lc-error');
    var elCalcBtn = LC.$('lc-calc-btn');

    // Live avatar updates
    function updateAvatar(input, av) {
        var v = (input.value || '').trim();
        av.textContent = v ? v.charAt(0).toUpperCase() : '?';
    }
    elNameA.addEventListener('input', function(){ updateAvatar(elNameA, elAvA); elError.classList.remove('lc-show'); });
    elNameB.addEventListener('input', function(){ updateAvatar(elNameB, elAvB); elError.classList.remove('lc-show'); });

    // Algorithm
    function calcLove(n1, n2) {
        var a = (n1 || '').toLowerCase().replace(/[^a-z]/g,'');
        var b = (n2 || '').toLowerCase().replace(/[^a-z]/g,'');
        if (!a || !b) return 50;

        // 1. Letter frequency overlap
        var freqA = {}, freqB = {};
        for (var i=0;i<a.length;i++){ freqA[a[i]] = (freqA[a[i]]||0) + 1; }
        for (var j=0;j<b.length;j++){ freqB[b[j]] = (freqB[b[j]]||0) + 1; }
        var overlap = 0, total = 0;
        var keys = {};
        for (var k in freqA){ keys[k]=1; }
        for (var k2 in freqB){ keys[k2]=1; }
        for (var k3 in keys) {
            overlap += Math.min(freqA[k3]||0, freqB[k3]||0);
            total += Math.max(freqA[k3]||0, freqB[k3]||0);
        }
        var overlapScore = total ? (overlap / total) * 100 : 50;

        // 2. Numerology
        var sumA = 0, sumB = 0;
        for (var i2=0;i2<a.length;i2++){ sumA += a.charCodeAt(i2) - 96; }
        for (var j2=0;j2<b.length;j2++){ sumB += b.charCodeAt(j2) - 96; }
        var num = ((sumA + sumB) % 9) + 1;
        var numScore = num * 10;

        // 3. Length harmony
        var diff = Math.abs(a.length - b.length);
        var lenScore = Math.max(0, 100 - diff * 12);

        // 4. Seeded random based on combined names
        var seed = 0;
        var combined = a + b;
        for (var s=0; s<combined.length; s++){
            seed = ((seed << 5) - seed + combined.charCodeAt(s)) | 0;
        }
        var rand = Math.abs(Math.sin(seed)) * 30; // 0-30 modifier

        var raw = (overlapScore * 0.4) + (numScore * 0.25) + (lenScore * 0.2) + (rand * 0.5);
        var score = Math.round(raw);

        // Clamp 12-99
        if (score < 12) score = 12 + (Math.abs(seed) % 18);
        if (score > 99) score = 99;
        return score;
    }

    function calcMetrics(n1, n2, score) {
        var a = (n1 || '').toLowerCase().replace(/[^a-z]/g,'');
        var b = (n2 || '').toLowerCase().replace(/[^a-z]/g,'');
        var seed = 0;
        for (var s=0; s<a.length+b.length; s++){
            seed = ((seed << 5) - seed + (a+b).charCodeAt(s)) | 0;
        }
        function vary(base, off) {
            var r = Math.abs(Math.sin(seed + off)) * 20 - 10;
            var v = Math.round(base + r);
            return Math.max(15, Math.min(99, v));
        }
        return {
            trust: vary(score, 1),
            chem: vary(score, 2),
            comm: vary(score, 3),
            lt: vary(score, 4)
        };
    }

    function getLevel(score) {
        if (score >= 90) return { emoji: '👑', name: 'Soulmates', color: '#d4af37' };
        if (score >= 70) return { emoji: '💕', name: 'Perfect Match', color: '#E63946' };
        if (score >= 50) return { emoji: '💜', name: 'Good Potential', color: '#7B2D8B' };
        if (score >= 30) return { emoji: '💙', name: 'Needs Effort', color: '#2563eb' };
        return { emoji: '🤝', name: 'Just Friends', color: '#14b8a6' };
    }

    function getDescription(score, n1, n2) {
        if (score >= 90) return n1 + ' and ' + n2 + ', the universe is whispering your names together. Your bond runs deep — a rare connection few ever experience. This is the kind of love that grows stronger through every season. Cherish it.';
        if (score >= 70) return n1 + ' and ' + n2 + ', you two have a love story worth telling. Your hearts are tuned to a similar rhythm, and the chemistry between you sparks easily. Keep nurturing this beautiful bond — it has incredible potential to last a lifetime.';
        if (score >= 50) return n1 + ' and ' + n2 + ', there is real potential here waiting to bloom. With patience, honest conversations, and shared experiences, your connection can grow into something truly meaningful. Love isn’t just found — it’s built, day by day.';
        if (score >= 30) return n1 + ' and ' + n2 + ', every great love story takes work. Your differences could become your greatest strengths if you both lean in with openness and care. Listen, laugh, and grow together — the best chapters are still ahead.';
        return n1 + ' and ' + n2 + ', friendship is one of life’s most precious gifts. Sometimes the best relationships are the ones built on trust, laughter, and shared memories — not romance. Treasure what you have, in whatever form it takes.';
    }

    function getHints(score, n1, n2) {
        if (score >= 70) return [
            { i: '💌', t: 'Daily Affection', d: 'Send a sweet message every morning to keep the spark alive.' },
            { i: '🎉', t: 'Celebrate Small Wins', d: 'Acknowledge each other’s little victories — they matter.' },
            { i: '🗝', t: 'Plan Memories', d: 'Take a trip together this year, even a small one. Memories > things.' },
            { i: '🔒', t: 'Protect Privacy', d: 'Some things are meant just for you two. Keep the magic sacred.' }
        ];
        if (score >= 40) return [
            { i: '🗣', t: 'Open Up More', d: 'Share one new thought a day. Vulnerability builds connection.' },
            { i: '⏰', t: 'Quality Time', d: 'Schedule phone-free time together — even 30 minutes counts.' },
            { i: '🎯', t: 'Set Shared Goals', d: 'A goal you both chase together pulls you closer.' },
            { i: '🌱', t: 'Grow Together', d: 'Try a new hobby as a team. Shared learning = deeper love.' }
        ];
        return [
            { i: '🤝', t: 'Value Friendship', d: 'A loyal friend is rarer than a romantic partner. Hold tight.' },
            { i: '💬', t: 'Honest Talks', d: 'Have one real conversation this week — no small talk.' },
            { i: '🌟', t: 'Be Yourself', d: 'The right person celebrates who you already are.' },
            { i: '✨', t: 'Patience Wins', d: 'Some bonds need time to reveal their true form. Don’t rush.' }
        ];
    }

    function getAdvice(score, n1, n2) {
        if (score >= 70) {
            return {
                text: n1 + ' & ' + n2 + ', the love between you is genuine and full of promise. Hold onto the small moments — a shared laugh, a quiet glance, a hand held in silence. Love thrives in attention, not perfection. Keep choosing each other, every single day.',
                tags: ['Strong Chemistry', 'Forever Potential', 'Soulful Bond', 'Deep Trust']
            };
        }
        if (score >= 40) {
            return {
                text: n1 + ' & ' + n2 + ', you have something worth nurturing. The seeds are planted — now water them with kindness, patience, and presence. Communication is your superpower; use it openly. Don’t be afraid of the awkward conversations; they’re where real love grows.',
                tags: ['Growing Bond', 'Communication First', 'Worth The Effort', 'Future Bright']
            };
        }
        return {
            text: n1 + ' & ' + n2 + ', not every connection becomes romance — and that’s a beautiful thing. Some people enter our lives as lifelong friends, mentors, or kindred spirits. Whatever form your bond takes, lean into it with honesty. The right love, in any form, will always feel right.',
            tags: ['True Friendship', 'Honest Bond', 'Different Path', 'Self Love First']
        };
    }

    // Loading sequence
    var loadSteps = [
        '💌 Scanning your names...',
        '🔬 Analyzing compatibility...',
        '✨ Calculating love score...',
        '💝 Preparing your result...'
    ];

    function runLoading(callback) {
        var stepEl = LC.$('lc-load-step');
        var barEl = LC.$('lc-progress-bar');
        var i = 0;
        stepEl.textContent = loadSteps[0];
        barEl.style.width = '8%';

        var interval = setInterval(function(){
            i++;
            if (i < loadSteps.length) {
                stepEl.style.opacity = '0';
                setTimeout(function(){
                    stepEl.textContent = loadSteps[i];
                    stepEl.style.opacity = '1';
                }, 200);
                barEl.style.width = ((i+1) * 25) + '%';
            } else {
                clearInterval(interval);
                barEl.style.width = '100%';
                setTimeout(callback, 350);
            }
        }, 700);
    }

    // Animate count-up
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

    // Confetti
    function confetti() {
        var colors = ['#E63946', '#ff6b9d', '#fbbf24', '#7B2D8B', '#fff'];
        var box = document.createElement('div');
        box.className = 'lc-confetti';
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

    function showResult() {
        var n1 = LC.nameA, n2 = LC.nameB;
        var score = calcLove(n1, n2);
        var metrics = calcMetrics(n1, n2, score);
        var level = getLevel(score);
        var desc = getDescription(score, n1, n2);
        var hints = getHints(score, n1, n2);
        var advice = getAdvice(score, n1, n2);

        LC.score = score; LC.level = level.name;

        // Names + avatars
        LC.$('lc-rc-n-a').textContent = n1;
        LC.$('lc-rc-n-b').textContent = n2;
        LC.$('lc-rc-av-a').textContent = n1.charAt(0).toUpperCase();
        LC.$('lc-rc-av-b').textContent = n2.charAt(0).toUpperCase();

        // Level + desc
        LC.$('lc-level').innerHTML = level.emoji + ' ' + level.name;
        LC.$('lc-desc').textContent = desc;

        // Show result
        elLoading.classList.remove('lc-show');
        elLoading.style.display = 'none';
        elResult.classList.add('lc-show');

        // Animate percentage
        animateNum(LC.$('lc-pct'), 0, score, 1800);

        // Animate ring
        var circ = 2 * Math.PI * 86;
        var ring = LC.$('lc-ring-fg');
        setTimeout(function(){
            ring.style.strokeDashoffset = circ - (circ * score / 100);
        }, 80);

        // Bars
        setTimeout(function(){
            LC.$('lc-b1').style.width = metrics.trust + '%';
            LC.$('lc-b2').style.width = metrics.chem + '%';
            LC.$('lc-b3').style.width = metrics.comm + '%';
            LC.$('lc-b4').style.width = metrics.lt + '%';
            LC.$('lc-b1-v').textContent = metrics.trust + '%';
            LC.$('lc-b2-v').textContent = metrics.chem + '%';
            LC.$('lc-b3-v').textContent = metrics.comm + '%';
            LC.$('lc-b4-v').textContent = metrics.lt + '%';
        }, 200);

        // Hints
        var hintsTitle = LC.$('lc-hints-title');
        hintsTitle.innerHTML = '⭐ Golden Hints for ' + escapeHtml(n1) + ' &amp; ' + escapeHtml(n2);
        var hintsGrid = LC.$('lc-hints-grid');
        hintsGrid.innerHTML = '';
        for (var hi=0; hi<hints.length; hi++) {
            var h = hints[hi];
            var card = document.createElement('div');
            card.className = 'lc-hint';
            card.style.borderLeftColor = level.color;
            card.style.animationDelay = (hi * 0.1) + 's';
            card.innerHTML = '<div class="lc-hint-icon">' + h.i + '</div><h4>' + escapeHtml(h.t) + '</h4><p>' + escapeHtml(h.d) + '</p>';
            hintsGrid.appendChild(card);
        }

        // Advice
        LC.$('lc-advice-text').textContent = advice.text;
        var tagsBox = LC.$('lc-tags');
        tagsBox.innerHTML = '';
        for (var ti=0; ti<advice.tags.length; ti++) {
            var tag = document.createElement('span');
            tag.className = 'lc-tag lc-t' + ((ti % 4) + 1);
            tag.textContent = advice.tags[ti];
            tagsBox.appendChild(tag);
        }

        // Share links
        setupShare(n1, n2, score, level.name);

        // Confetti
        if (score >= 70) {
            setTimeout(confetti, 600);
        }

        // Scroll to result
        setTimeout(function(){
            elResult.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }, 100);
    }

    function escapeHtml(s) {
        return String(s).replace(/[&<>"']/g, function(c){
            return ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'})[c];
        });
    }

    function setupShare(n1, n2, score, level) {
        var url = window.location.href;
        var msg = '❤️ Love Calculator Result!\n\n' + n1 + ' + ' + n2 + ' = *' + score + '% Love*\nStatus: *' + level + '*\n\nTest yours: ' + url;
        var tweet = n1 + ' + ' + n2 + ' = ' + score + '% Love ❤️ (' + level + ')! Test your love compatibility:';

        LC.$('lc-sb-wa').href = 'https://wa.me/?text=' + encodeURIComponent(msg);
        LC.$('lc-sb-tw').href = 'https://twitter.com/intent/tweet?text=' + encodeURIComponent(tweet) + '&url=' + encodeURIComponent(url);

        LC.$('lc-sb-copy').onclick = function(){
            var btn = this;
            var orig = btn.innerHTML;
            try {
                if (navigator.clipboard) {
                    navigator.clipboard.writeText(url).then(function(){
                        btn.innerHTML = '✅ Copied!';
                        setTimeout(function(){ btn.innerHTML = orig; }, 1800);
                    });
                } else {
                    var ta = document.createElement('textarea');
                    ta.value = url;
                    document.body.appendChild(ta);
                    ta.select();
                    document.execCommand('copy');
                    ta.remove();
                    btn.innerHTML = '✅ Copied!';
                    setTimeout(function(){ btn.innerHTML = orig; }, 1800);
                }
            } catch(e) {
                btn.innerHTML = '⚠ Try Manually';
                setTimeout(function(){ btn.innerHTML = orig; }, 1800);
            }
        };

        LC.$('lc-sb-save').onclick = function(){
            var btn = this;
            var orig = btn.innerHTML;
            btn.innerHTML = '📸 Saving...';
            setTimeout(function(){
                if (navigator.share) {
                    navigator.share({ title: 'Love Calculator Result', text: msg, url: url }).then(function(){
                        btn.innerHTML = orig;
                    }).catch(function(){
                        alert('Take a screenshot of your result to save it!\n\n' + n1 + ' + ' + n2 + ' = ' + score + '% Love');
                        btn.innerHTML = orig;
                    });
                } else {
                    alert('Take a screenshot of your result to save it!\n\n' + n1 + ' + ' + n2 + ' = ' + score + '% Love\n' + level);
                    btn.innerHTML = orig;
                }
            }, 400);
        };
    }

    // Calculate button
    elCalcBtn.addEventListener('click', function(){
        var n1 = (elNameA.value || '').trim();
        var n2 = (elNameB.value || '').trim();
        if (!n1 || !n2) {
            elError.classList.add('lc-show');
            return;
        }
        if (n1.length < 2 || n2.length < 2) {
            elError.textContent = 'Names should be at least 2 characters.';
            elError.classList.add('lc-show');
            return;
        }
        elError.classList.remove('lc-show');
        elError.textContent = 'Please enter both names to continue.';
        LC.nameA = n1;
        LC.nameB = n2;

        elInputPhase.style.display = 'none';
        elLoading.style.display = 'block';
        elLoading.classList.add('lc-show');
        LC.$('lc-load-names').textContent = n1 + ' ❤️ ' + n2;
        LC.$('lc-progress-bar').style.width = '0%';

        runLoading(showResult);
    });

    // Enter key submits
    [elNameA, elNameB].forEach(function(el){
        el.addEventListener('keydown', function(e){
            if (e.key === 'Enter') { e.preventDefault(); elCalcBtn.click(); }
        });
    });

    // Try again
    LC.$('lc-try-btn').addEventListener('click', function(){
        elResult.classList.remove('lc-show');
        elLoading.classList.remove('lc-show');
        elLoading.style.display = 'none';
        elInputPhase.style.display = 'block';
        elNameA.value = '';
        elNameB.value = '';
        elAvA.textContent = '?';
        elAvB.textContent = '?';
        LC.$('lc-pct').textContent = '0';
        LC.$('lc-ring-fg').style.strokeDashoffset = 540.35;
        ['lc-b1','lc-b2','lc-b3','lc-b4'].forEach(function(id){ LC.$(id).style.width = '0%'; });
        elInputPhase.scrollIntoView({ behavior: 'smooth', block: 'start' });
        setTimeout(function(){ elNameA.focus(); }, 400);
    });

    // FAQ accordion
    var faqs = document.querySelectorAll('.lc-faq-item');
    faqs.forEach(function(item){
        var q = item.querySelector('.lc-faq-q');
        q.addEventListener('click', function(){
            item.classList.toggle('lc-open');
        });
    });

    // Live counter
    var counterEl = LC.$('lc-counter');
    var count = 384219;
    setInterval(function(){
        count += 1 + Math.floor(Math.random()*3);
        counterEl.textContent = count.toLocaleString('en-IN');
    }, 8000);
})();
</script>
        <?php
        return ob_get_clean();
    }

    add_shortcode( 'love_calculator', 'lc_pro_render_calculator' );
}
