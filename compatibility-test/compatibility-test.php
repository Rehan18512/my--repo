<?php
/**
 * Plugin Name: Compatibility Test
 * Plugin URI: https://lovecalculator.in
 * Description: Premium zodiac Compatibility Test. Pick two signs (and optional names) to get an element-based compatibility score, love/trust/communication/passion meters, strengths, challenges and relationship advice. Use shortcode [compatibility_test].
 * Version: 1.0.0
 * Author: lovecalculator.in
 * Author URI: https://lovecalculator.in
 * License: GPL-2.0+
 * Text Domain: compatibility-test
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! function_exists( 'ct_pro_render_compat' ) ) {

    function ct_pro_render_compat( $atts = array() ) {
        ob_start();
        ?>
<div class="ct-wrap" id="ct-wrap">
    <style>
        .ct-wrap, .ct-wrap *, .ct-wrap *::before, .ct-wrap *::after { box-sizing: border-box; }
        .ct-wrap { font-family: 'DM Sans', 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; color: #1f1933; max-width: 880px; margin: 0 auto; padding: 12px; line-height: 1.55; }
        .ct-wrap h1, .ct-wrap h2, .ct-wrap h3, .ct-wrap h4 { font-family: 'Poppins', 'Syne', system-ui, sans-serif; font-weight: 800; letter-spacing: -0.01em; margin: 0; }

        .ct-header { background: linear-gradient(135deg, #1a0533 0%, #3d0b55 50%, #690d3a 100%); border-radius: 22px; padding: 28px 20px; color: #fff; text-align: center; box-shadow: 0 20px 60px rgba(105, 13, 58, 0.25); position: relative; overflow: hidden; }
        .ct-header::before { content: ""; position: absolute; inset: -50%; background: radial-gradient(circle at 30% 20%, rgba(230,57,70,0.18), transparent 60%), radial-gradient(circle at 70% 80%, rgba(123,45,139,0.25), transparent 60%); pointer-events: none; }
        .ct-header-icon { font-size: 50px; line-height: 1; display: inline-block; animation: ct-bob 2.4s ease-in-out infinite; }
        .ct-header h1 { font-size: 36px; margin: 8px 0 6px; color: #fff; }
        .ct-header-sub { opacity: 0.86; font-size: 15px; margin: 0; }
        .ct-stats { display: flex; align-items: center; justify-content: center; gap: 0; margin-top: 18px; flex-wrap: wrap; }
        .ct-stat { padding: 4px 14px; min-width: 96px; }
        .ct-stat-num { font-weight: 800; font-family: 'Poppins', sans-serif; font-size: 18px; color: #fff; }
        .ct-stat-lbl { font-size: 11px; opacity: 0.78; text-transform: uppercase; letter-spacing: 0.06em; }
        .ct-stat + .ct-stat { border-left: 1px solid rgba(255,255,255,0.22); }

        .ct-card { background: #fff; border-radius: 22px; padding: 24px 20px; margin-top: 18px; box-shadow: 0 20px 60px rgba(0,0,0,0.08); border: 1px solid #f1ecf6; }

        .ct-inputs { display: grid; grid-template-columns: 1fr auto 1fr; gap: 14px; align-items: start; }
        .ct-person { display: flex; flex-direction: column; gap: 10px; }
        .ct-avatar { width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 28px; color: #fff; box-shadow: 0 8px 24px rgba(0,0,0,0.18); margin: 0 auto; }
        .ct-avatar.ct-a { background: linear-gradient(135deg, #E63946, #ff6b9d); }
        .ct-avatar.ct-b { background: linear-gradient(135deg, #7B2D8B, #b558d6); }
        .ct-input, .ct-select { width: 100%; min-height: 50px; padding: 12px 14px; font-size: 15.5px; border: 2px solid #ece6f3; border-radius: 14px; outline: none; background: #faf8fd; transition: border-color .2s, background .2s, box-shadow .2s; font-family: inherit; color: #1f1933; }
        .ct-input { text-align: center; }
        .ct-input:focus, .ct-select:focus { border-color: #E63946; background: #fff; box-shadow: 0 0 0 4px rgba(230,57,70,0.12); }
        .ct-select { appearance: none; -webkit-appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath fill='%237B2D8B' d='M6 8L0 0h12z'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 16px center; padding-right: 38px; cursor: pointer; }
        .ct-vs { width: 50px; height: 50px; border-radius: 50%; background: linear-gradient(135deg, #E63946, #7B2D8B); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 20px; font-weight: 800; font-family: 'Poppins', sans-serif; box-shadow: 0 10px 24px rgba(230,57,70,0.35); animation: ct-pulse 1.6s ease-in-out infinite; margin-top: 6px; }

        .ct-error { display: none; background: #fff1f2; color: #b3162a; border: 1px solid #ffd6db; padding: 10px 14px; border-radius: 12px; margin-top: 12px; font-size: 14px; text-align: center; }
        .ct-error.ct-show { display: block; animation: ct-shake .4s; }
        .ct-btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; min-height: 56px; padding: 18px 22px; font-size: 17px; font-weight: 700; font-family: 'Poppins', sans-serif; border: none; border-radius: 14px; cursor: pointer; width: 100%; transition: transform .15s ease, box-shadow .2s ease, opacity .2s; }
        .ct-btn-primary { background: linear-gradient(135deg, #E63946, #c81e2c); color: #fff; box-shadow: 0 14px 32px rgba(230,57,70,0.35); margin-top: 18px; }
        .ct-btn-primary:hover { transform: translateY(-2px); box-shadow: 0 18px 40px rgba(230,57,70,0.45); }
        .ct-btn-primary:active { transform: translateY(0); }
        .ct-trust { display: flex; gap: 10px; justify-content: center; flex-wrap: wrap; margin-top: 14px; }
        .ct-trust span { font-size: 12.5px; color: #5b5070; background: #f6f0fb; padding: 6px 12px; border-radius: 999px; min-height: 30px; display: inline-flex; align-items: center; }

        .ct-loading { display: none; text-align: center; padding: 14px 8px 6px; }
        .ct-loading.ct-show { display: block; }
        .ct-rings { position: relative; width: 160px; height: 160px; margin: 6px auto 18px; }
        .ct-ring { position: absolute; inset: 0; border-radius: 50%; border: 3px solid rgba(230,57,70,0.35); animation: ct-ringa 2s ease-out infinite; }
        .ct-ring:nth-child(2) { animation-delay: .5s; border-color: rgba(123,45,139,0.4); }
        .ct-ring:nth-child(3) { animation-delay: 1s; border-color: rgba(255,107,157,0.45); }
        .ct-ring-heart { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; font-size: 56px; animation: ct-pulse 1.2s ease-in-out infinite; }
        .ct-load-step { font-size: 15px; color: #6b5e85; min-height: 24px; margin-top: 4px; transition: opacity .25s; }
        .ct-progress { height: 8px; background: #f1ebf7; border-radius: 999px; overflow: hidden; margin: 14px auto 4px; max-width: 360px; }
        .ct-progress-bar { height: 100%; width: 0%; background: linear-gradient(90deg, #E63946, #7B2D8B); border-radius: 999px; transition: width .3s ease; }

        .ct-result { display: none; }
        .ct-result.ct-show { display: block; animation: ct-fadeUp .55s ease both; }
        .ct-result-card { background: linear-gradient(135deg, #1a0533, #3d0b55, #690d3a); color: #fff; border-radius: 22px; padding: 28px 20px; text-align: center; box-shadow: 0 20px 60px rgba(0,0,0,0.25); position: relative; overflow: hidden; }
        .ct-result-card::after { content: ""; position: absolute; inset: 0; background: radial-gradient(circle at 20% 10%, rgba(230,57,70,0.25), transparent 50%), radial-gradient(circle at 80% 90%, rgba(255,107,157,0.18), transparent 55%); pointer-events: none; }
        .ct-rc-pair { display: flex; align-items: center; justify-content: center; gap: 14px; flex-wrap: wrap; margin-bottom: 6px; position: relative; z-index: 1; }
        .ct-rc-p { display: flex; flex-direction: column; align-items: center; gap: 4px; font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 14px; }
        .ct-rc-p .ct-rc-ico { font-size: 32px; }
        .ct-rc-heart { font-size: 22px; opacity: 0.85; }
        .ct-ring-wrap { position: relative; width: 210px; height: 210px; margin: 12px auto 8px; z-index: 1; }
        .ct-ring-wrap svg { transform: rotate(-90deg); width: 100%; height: 100%; }
        .ct-ring-bg { fill: none; stroke: rgba(255,255,255,0.12); stroke-width: 12; }
        .ct-ring-fg { fill: none; stroke: url(#ct-grad); stroke-width: 12; stroke-linecap: round; transition: stroke-dashoffset 1.8s cubic-bezier(.22,.9,.3,1); }
        .ct-percent { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; flex-direction: column; }
        .ct-percent-num { font-size: 60px; font-weight: 800; font-family: 'Poppins', sans-serif; line-height: 1; }
        .ct-percent-sym { font-size: 22px; font-weight: 700; opacity: 0.85; }
        .ct-percent-lbl { font-size: 12px; opacity: 0.8; text-transform: uppercase; letter-spacing: 0.08em; margin-top: 2px; }
        .ct-level { display: inline-block; background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.22); padding: 8px 18px; border-radius: 999px; font-weight: 700; font-family: 'Poppins', sans-serif; font-size: 15px; margin: 4px 0 10px; position: relative; z-index: 1; }
        .ct-summary { max-width: 600px; margin: 0 auto; opacity: 0.94; font-size: 15.5px; position: relative; z-index: 1; }
        .ct-watermark { margin-top: 16px; font-size: 12.5px; opacity: 0.7; position: relative; z-index: 1; }

        .ct-elem { background: #fff; border-radius: 16px; padding: 16px; margin-top: 16px; box-shadow: 0 10px 24px rgba(0,0,0,0.06); border: 1px solid #f1ecf6; border-left: 4px solid #7B2D8B; }
        .ct-elem h3 { font-size: 16px; color: #3d0b55; margin-bottom: 6px; display: flex; align-items: center; gap: 8px; }
        .ct-elem p { font-size: 14px; color: #5b5070; margin: 0; }

        .ct-bars { background: #fff; border-radius: 18px; padding: 18px; margin-top: 16px; box-shadow: 0 12px 30px rgba(0,0,0,0.06); border: 1px solid #f1ecf6; }
        .ct-bars h3 { font-size: 17px; color: #2d2447; margin-bottom: 12px; }
        .ct-bar-row { margin: 14px 0; }
        .ct-bar-top { display: flex; justify-content: space-between; font-size: 14px; font-weight: 600; color: #2d2447; margin-bottom: 6px; }
        .ct-bar-top span:last-child { color: #7B2D8B; font-family: 'Poppins', sans-serif; font-weight: 800; }
        .ct-bar { height: 10px; background: #f1ebf7; border-radius: 999px; overflow: hidden; }
        .ct-bar-fill { height: 100%; width: 0%; border-radius: 999px; background: linear-gradient(90deg, #E63946, #7B2D8B); transition: width 1.5s cubic-bezier(.22,.9,.3,1); }

        .ct-twocol { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-top: 16px; }
        .ct-sc { background: #fff; border-radius: 16px; padding: 16px; box-shadow: 0 10px 24px rgba(0,0,0,0.05); border: 1px solid #f1ecf6; }
        .ct-sc.ct-strength { border-top: 4px solid #14b8a6; }
        .ct-sc.ct-challenge { border-top: 4px solid #ff6b35; }
        .ct-sc h4 { font-size: 15px; margin-bottom: 8px; display: flex; align-items: center; gap: 8px; }
        .ct-strength h4 { color: #0f766e; } .ct-challenge h4 { color: #c2410c; }
        .ct-sc ul { margin: 0; padding-left: 18px; }
        .ct-sc li { font-size: 13.5px; color: #5b5070; margin-bottom: 6px; }

        .ct-advice { background: linear-gradient(135deg, #e7f7ec, #d2efdc); border-radius: 18px; padding: 20px; margin-top: 16px; border: 1px solid #b8e2c5; }
        .ct-advice h3 { font-size: 18px; color: #155d3a; margin-bottom: 8px; }
        .ct-advice p { font-style: italic; color: #1f3f2c; margin: 0; }

        .ct-share { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin-top: 18px; }
        .ct-share-btn { display: inline-flex; align-items: center; justify-content: center; gap: 6px; min-height: 48px; padding: 12px 8px; font-size: 14px; font-weight: 700; font-family: 'Poppins', sans-serif; border-radius: 12px; border: none; cursor: pointer; color: #fff; text-decoration: none; transition: transform .15s ease, box-shadow .15s ease; }
        .ct-share-btn:hover { transform: translateY(-2px); box-shadow: 0 12px 26px rgba(0,0,0,0.15); }
        .ct-sb-wa { background: #25d366; }
        .ct-sb-tw { background: #111; }
        .ct-sb-save { background: linear-gradient(135deg, #E63946, #7B2D8B); }
        .ct-sb-copy { background: #5b5b6e; }
        .ct-try { margin-top: 14px; background: #fff; color: #3d0b55; border: 2px solid #ece6f3; }
        .ct-try:hover { border-color: #7B2D8B; color: #7B2D8B; }

        .ct-confetti { position: fixed; inset: 0; pointer-events: none; z-index: 9999; overflow: hidden; }
        .ct-confetti i { position: absolute; top: -20px; width: 10px; height: 14px; opacity: 0.95; animation: ct-fall linear forwards; border-radius: 2px; }

        .ct-related { margin-top: 22px; }
        .ct-related h2 { font-size: 22px; color: #3d0b55; margin-bottom: 12px; }
        .ct-related-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; }
        .ct-rt { display: block; text-decoration: none; background: #fff; border-radius: 16px; padding: 16px 12px; text-align: center; box-shadow: 0 10px 24px rgba(0,0,0,0.06); border-top: 4px solid #E63946; color: inherit; transition: transform .15s ease, box-shadow .2s ease; }
        .ct-rt:hover { transform: translateY(-3px); box-shadow: 0 16px 32px rgba(0,0,0,0.1); }
        .ct-rt:nth-child(1) { border-color: #ff6b35; }
        .ct-rt:nth-child(2) { border-color: #14b8a6; }
        .ct-rt:nth-child(3) { border-color: #E63946; }
        .ct-rt:nth-child(4) { border-color: #7B2D8B; }
        .ct-rt-icon { font-size: 28px; }
        .ct-rt h4 { font-size: 14.5px; color: #1f1933; margin: 6px 0 4px; }
        .ct-rt p { font-size: 12.5px; color: #5b5070; margin: 0; }

        @keyframes ct-pulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.08); } }
        @keyframes ct-bob { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-6px); } }
        @keyframes ct-ringa { 0% { transform: scale(0.6); opacity: 0.9; } 100% { transform: scale(1.4); opacity: 0; } }
        @keyframes ct-fadeUp { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes ct-shake { 0%, 100% { transform: translateX(0); } 25% { transform: translateX(-4px); } 75% { transform: translateX(4px); } }
        @keyframes ct-fall { 0% { transform: translateY(-20px) rotate(0); opacity: 1; } 100% { transform: translateY(110vh) rotate(720deg); opacity: 0.3; } }

        @media (max-width: 640px) {
            .ct-wrap { padding: 8px; }
            .ct-header { padding: 22px 16px; border-radius: 18px; }
            .ct-header h1 { font-size: 28px; }
            .ct-header-icon { font-size: 44px; }
            .ct-stat-num { font-size: 16px; }
            .ct-card { padding: 20px 16px; border-radius: 18px; }
            .ct-inputs { grid-template-columns: 1fr; gap: 12px; }
            .ct-vs { margin: -2px auto; }
            .ct-percent-num { font-size: 52px; }
            .ct-ring-wrap { width: 190px; height: 190px; }
            .ct-twocol { grid-template-columns: 1fr; }
            .ct-share { grid-template-columns: repeat(2, 1fr); }
            .ct-related-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 380px) { .ct-header h1 { font-size: 24px; } }
    </style>

    <header class="ct-header">
        <div class="ct-header-icon">&#128302;</div>
        <h1>Compatibility Test</h1>
        <p class="ct-header-sub">Discover how compatible your zodiac signs really are</p>
        <div class="ct-stats">
            <div class="ct-stat"><div class="ct-stat-num" id="ct-counter">4,07,612</div><div class="ct-stat-lbl">Tests Today</div></div>
            <div class="ct-stat"><div class="ct-stat-num">4.9&#9733;</div><div class="ct-stat-lbl">Rating</div></div>
            <div class="ct-stat"><div class="ct-stat-num">144</div><div class="ct-stat-lbl">Sign Pairs</div></div>
        </div>
    </header>

    <section class="ct-card" id="ct-card">
        <div class="ct-input-phase" id="ct-input-phase">
            <div class="ct-inputs">
                <div class="ct-person">
                    <div class="ct-avatar ct-a">&#128104;</div>
                    <input type="text" class="ct-input" id="ct-name-a" placeholder="Your name (optional)" maxlength="20" autocomplete="off" />
                    <select class="ct-select" id="ct-sign-a" aria-label="Your zodiac sign"></select>
                </div>
                <div class="ct-vs" aria-hidden="true">&#10084;</div>
                <div class="ct-person">
                    <div class="ct-avatar ct-b">&#128105;</div>
                    <input type="text" class="ct-input" id="ct-name-b" placeholder="Partner name (optional)" maxlength="20" autocomplete="off" />
                    <select class="ct-select" id="ct-sign-b" aria-label="Partner zodiac sign"></select>
                </div>
            </div>
            <div class="ct-error" id="ct-error">Please choose both zodiac signs.</div>
            <button type="button" class="ct-btn ct-btn-primary" id="ct-go-btn">Check Compatibility &#128302;</button>
            <div class="ct-trust"><span>&#128274; Private</span><span>&#9889; Instant</span><span>&#127378; Free</span></div>
        </div>

        <div class="ct-loading" id="ct-loading">
            <div class="ct-rings"><div class="ct-ring"></div><div class="ct-ring"></div><div class="ct-ring"></div><div class="ct-ring-heart">&#128149;</div></div>
            <div class="ct-load-step" id="ct-load-step">&#128302; Reading the stars...</div>
            <div class="ct-progress"><div class="ct-progress-bar" id="ct-progress-bar"></div></div>
        </div>

        <div class="ct-result" id="ct-result">
            <div class="ct-result-card">
                <div class="ct-rc-pair">
                    <div class="ct-rc-p"><span class="ct-rc-ico" id="ct-rc-ico-a">&#9800;</span><span id="ct-rc-na">Aries</span></div>
                    <div class="ct-rc-heart">&#10084;</div>
                    <div class="ct-rc-p"><span class="ct-rc-ico" id="ct-rc-ico-b">&#9802;</span><span id="ct-rc-nb">Gemini</span></div>
                </div>
                <div class="ct-ring-wrap">
                    <svg viewBox="0 0 200 200" aria-hidden="true">
                        <defs><linearGradient id="ct-grad" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#ff6b9d"/><stop offset="100%" stop-color="#fbbf24"/></linearGradient></defs>
                        <circle class="ct-ring-bg" cx="100" cy="100" r="86"/>
                        <circle class="ct-ring-fg" id="ct-ring-fg" cx="100" cy="100" r="86" stroke-dasharray="540.35" stroke-dashoffset="540.35"/>
                    </svg>
                    <div class="ct-percent"><div><span class="ct-percent-num" id="ct-pct">0</span><span class="ct-percent-sym">%</span></div><div class="ct-percent-lbl">Compatible</div></div>
                </div>
                <div class="ct-level" id="ct-level">&#128149; Analyzing...</div>
                <p class="ct-summary" id="ct-summary">Reading your cosmic connection...</p>
                <div class="ct-watermark">lovecalculator.in &#10084;</div>
            </div>

            <div class="ct-elem">
                <h3>&#127777; Element Connection</h3>
                <p id="ct-elem-text">&mdash;</p>
            </div>

            <div class="ct-bars">
                <h3>&#128202; Relationship Breakdown</h3>
                <div class="ct-bar-row"><div class="ct-bar-top"><span>&#128150; Love &amp; Romance</span><span id="ct-b1-v">0%</span></div><div class="ct-bar"><div class="ct-bar-fill" id="ct-b1"></div></div></div>
                <div class="ct-bar-row"><div class="ct-bar-top"><span>&#128172; Communication</span><span id="ct-b2-v">0%</span></div><div class="ct-bar"><div class="ct-bar-fill" id="ct-b2"></div></div></div>
                <div class="ct-bar-row"><div class="ct-bar-top"><span>&#128274; Trust</span><span id="ct-b3-v">0%</span></div><div class="ct-bar"><div class="ct-bar-fill" id="ct-b3"></div></div></div>
                <div class="ct-bar-row"><div class="ct-bar-top"><span>&#128293; Passion</span><span id="ct-b4-v">0%</span></div><div class="ct-bar"><div class="ct-bar-fill" id="ct-b4"></div></div></div>
                <div class="ct-bar-row"><div class="ct-bar-top"><span>&#127881; Long-term Potential</span><span id="ct-b5-v">0%</span></div><div class="ct-bar"><div class="ct-bar-fill" id="ct-b5"></div></div></div>
            </div>

            <div class="ct-twocol">
                <div class="ct-sc ct-strength"><h4>&#9989; Strengths</h4><ul id="ct-strengths"></ul></div>
                <div class="ct-sc ct-challenge"><h4>&#9888;&#65039; Watch Out For</h4><ul id="ct-challenges"></ul></div>
            </div>

            <div class="ct-advice">
                <h3>&#128161; Relationship Advice</h3>
                <p id="ct-advice-text">&mdash;</p>
            </div>

            <div class="ct-share">
                <a href="#" class="ct-share-btn ct-sb-wa" id="ct-sb-wa" target="_blank" rel="noopener">&#128241; WhatsApp</a>
                <a href="#" class="ct-share-btn ct-sb-tw" id="ct-sb-tw" target="_blank" rel="noopener">&#119991; Twitter</a>
                <button type="button" class="ct-share-btn ct-sb-save" id="ct-sb-save">&#128247; Save</button>
                <button type="button" class="ct-share-btn ct-sb-copy" id="ct-sb-copy">&#128279; Copy Link</button>
            </div>
            <button type="button" class="ct-btn ct-try" id="ct-try-btn">&#128260; Test Another Pair</button>
        </div>
    </section>

    <section class="ct-related">
        <h2>Try More Love Tools</h2>
        <div class="ct-related-grid">
            <a class="ct-rt" href="/love-calculator/"><div class="ct-rt-icon">&#128149;</div><h4>Love Calculator</h4><p>Name compatibility test</p></a>
            <a class="ct-rt" href="/kundali-matching/"><div class="ct-rt-icon">&#128138;</div><h4>Kundali Matching</h4><p>Guna Milan by name</p></a>
            <a class="ct-rt" href="/love-horoscope/"><div class="ct-rt-icon">&#128156;</div><h4>Love Horoscope</h4><p>Your daily love forecast</p></a>
            <a class="ct-rt" href="/love-language-test/"><div class="ct-rt-icon">&#128140;</div><h4>Love Language</h4><p>How you give &amp; receive love</p></a>
        </div>
    </section>

    <script type="application/ld+json">
    { "@context": "https://schema.org", "@type": "SoftwareApplication", "name": "Compatibility Test", "applicationCategory": "LifestyleApplication", "operatingSystem": "Web", "url": "https://lovecalculator.in/compatibility-test/", "offers": { "@type": "Offer", "price": "0", "priceCurrency": "USD" }, "aggregateRating": { "@type": "AggregateRating", "ratingValue": "4.9", "ratingCount": "13288" } }
    </script>
</div>
        <?php
        $ct_html = ob_get_clean();

        // Deliver the behavioral JS via the footer so WordPress content
        // filters (wpautop) can never inject tags that break the script.
        ob_start();
        ?>
(function(){
    'use strict';
    var $ = function(id){ return document.getElementById(id); };

    var SIGNS = [
        { key:'aries', name:'Aries', icon:'♈', element:'Fire' },
        { key:'taurus', name:'Taurus', icon:'♉', element:'Earth' },
        { key:'gemini', name:'Gemini', icon:'♊', element:'Air' },
        { key:'cancer', name:'Cancer', icon:'♋', element:'Water' },
        { key:'leo', name:'Leo', icon:'♌', element:'Fire' },
        { key:'virgo', name:'Virgo', icon:'♍', element:'Earth' },
        { key:'libra', name:'Libra', icon:'♎', element:'Air' },
        { key:'scorpio', name:'Scorpio', icon:'♏', element:'Water' },
        { key:'sagittarius', name:'Sagittarius', icon:'♐', element:'Fire' },
        { key:'capricorn', name:'Capricorn', icon:'♑', element:'Earth' },
        { key:'aquarius', name:'Aquarius', icon:'♒', element:'Air' },
        { key:'pisces', name:'Pisces', icon:'♓', element:'Water' }
    ];
    var SMAP = {}; SIGNS.forEach(function(s){ SMAP[s.key]=s; });

    function elemPairKey(a,b){ return [a,b].sort().join('-'); }
    var ELEM_BASE = {
        'Fire-Fire':86,'Earth-Earth':84,'Air-Air':85,'Water-Water':86,
        'Air-Fire':90,'Earth-Fire':62,'Fire-Water':56,'Earth-Water':88,'Air-Water':64,'Air-Earth':66
    };
    var ELEM_TEXT = {
        'Fire-Fire':'Two fire signs together create a passionate, high-energy bond full of excitement. Channel that intensity as a team and you are unstoppable.',
        'Earth-Earth':'Two earth signs build a grounded, dependable partnership rooted in loyalty, security and shared goals. Steady love that lasts.',
        'Air-Air':'Two air signs share a lively meeting of minds — endless conversation, ideas and social spark. Keep it grounded with follow-through.',
        'Water-Water':'Two water signs flow into a deeply emotional, intuitive connection. You understand each other’s feelings without a word.',
        'Air-Fire':'Air feeds Fire — this is a naturally electric, inspiring match. Air brings ideas, Fire brings action. Together you light up the room.',
        'Earth-Fire':'Earth and Fire move at different speeds — Fire is fast and bold, Earth is steady and patient. With respect, you balance each other beautifully.',
        'Fire-Water':'Fire and Water are an intense, opposites-attract pairing. Fire’s heat meets Water’s depth — magical when balanced, stormy when not.',
        'Earth-Water':'Earth and Water nourish each other — a wonderfully harmonious, nurturing match. Water adds emotion, Earth adds stability. Soulmate energy.',
        'Air-Water':'Air and Water mix logic with emotion. Air thinks, Water feels — bridge the gap with patience and you complete each other.',
        'Air-Earth':'Air and Earth blend ideas with practicality. Air dreams it up, Earth makes it real. Different rhythms that can work brilliantly together.'
    };

    var STRENGTHS = {
        high:['Natural understanding and easy chemistry','Shared values keep you aligned','You bring out the best in each other','Strong foundation for a lasting bond'],
        mid:['Great potential with mutual effort','You balance each other’s differences','Exciting growth as a couple','Complementary strengths'],
        low:['Opposites can spark deep attraction','Plenty to learn from each other','Growth through healthy challenge','Never a dull moment together']
    };
    var CHALLENGES = {
        high:['Avoid taking the harmony for granted','Keep the spark alive with novelty','Don’t skip honest check-ins'],
        mid:['Communicate openly about needs','Be patient with different paces','Make time to truly understand each other'],
        low:['Misunderstandings need extra patience','Different needs require compromise','Listen before reacting to differences']
    };
    var ADVICE = {
        high:'You two have a beautiful, natural connection. Protect it by never taking each other for granted — keep dating, keep talking, and keep choosing one another every day.',
        mid:'There is real potential here. With open communication and a little patience for your differences, this relationship can grow into something genuinely lasting.',
        low:'This match takes work, but opposites can build the deepest love. Lead with curiosity instead of judgement, and let your differences become your greatest strength.'
    };

    function hashStr(s){ var h=0; for(var i=0;i<s.length;i++){ h=((h<<5)-h+s.charCodeAt(i))|0; } return Math.abs(h); }

    // populate selects
    function fillSelect(sel){ SIGNS.forEach(function(s){ var o=document.createElement('option'); o.value=s.key; o.textContent=s.icon+'  '+s.name; sel.appendChild(o); }); }
    fillSelect($('ct-sign-a')); fillSelect($('ct-sign-b'));
    $('ct-sign-a').value='aries'; $('ct-sign-b').value='leo';

    var phases = { input:$('ct-input-phase'), loading:$('ct-loading'), result:$('ct-result') };
    var loadSteps=['🔭 Reading the stars...','🧬 Comparing elements...','💞 Scoring your bond...','✨ Writing your result...'];
    function runLoading(cb){ var stepEl=$('ct-load-step'),barEl=$('ct-progress-bar'),i=0; stepEl.textContent=loadSteps[0]; barEl.style.width='8%'; var iv=setInterval(function(){ i++; if(i<loadSteps.length){ stepEl.style.opacity='0'; setTimeout(function(){ stepEl.textContent=loadSteps[i]; stepEl.style.opacity='1'; },200); barEl.style.width=((i+1)*25)+'%'; } else { clearInterval(iv); barEl.style.width='100%'; setTimeout(cb,350);} },650); }
    function animateNum(el,from,to,dur){ var st=performance.now(); function tick(now){ var p=Math.min(1,(now-st)/dur); var e=1-Math.pow(1-p,3); el.textContent=Math.round(from+(to-from)*e); if(p<1) requestAnimationFrame(tick);} requestAnimationFrame(tick); }
    function confetti(){ var colors=['#E63946','#ff6b9d','#fbbf24','#7B2D8B','#fff']; var box=document.createElement('div'); box.className='ct-confetti'; for(var i=0;i<60;i++){ var p=document.createElement('i'); p.style.left=(Math.random()*100)+'%'; p.style.background=colors[Math.floor(Math.random()*colors.length)]; p.style.animationDuration=(1.5+Math.random()*2)+'s'; p.style.animationDelay=(Math.random()*0.5)+'s'; p.style.transform='rotate('+(Math.random()*360)+'deg)'; box.appendChild(p);} document.body.appendChild(box); setTimeout(function(){ box.remove(); },4000); }

    function levelFor(score){ if(score>=88) return {e:'👑',n:'Soulmate Match',c:'#d4af37',band:'high'}; if(score>=72) return {e:'💕',n:'Highly Compatible',c:'#E63946',band:'high'}; if(score>=58) return {e:'💜',n:'Good Potential',c:'#7B2D8B',band:'mid'}; return {e:'💙',n:'Takes Work',c:'#2563eb',band:'low'}; }

    function computeScore(a, b){
        var base = ELEM_BASE[elemPairKey(a.element, b.element)] || 70;
        var seed = hashStr(a.key + '+' + b.key);
        var mod = (seed % 17) - 8; // -8..+8
        if (a.key === b.key) base += 3;
        var score = base + mod;
        return Math.max(45, Math.min(99, Math.round(score)));
    }

    function showResult(){
        var a = SMAP[$('ct-sign-a').value], b = SMAP[$('ct-sign-b').value];
        var na = ($('ct-name-a').value||'').trim(), nb = ($('ct-name-b').value||'').trim();
        var score = computeScore(a, b);
        var level = levelFor(score);
        var seed = hashStr(a.key + b.key);
        var ek = elemPairKey(a.element, b.element);

        $('ct-rc-ico-a').textContent = a.icon; $('ct-rc-ico-b').textContent = b.icon;
        $('ct-rc-na').textContent = na ? (na.charAt(0).toUpperCase()+na.slice(1)) : a.name;
        $('ct-rc-nb').textContent = nb ? (nb.charAt(0).toUpperCase()+nb.slice(1)) : b.name;
        $('ct-level').innerHTML = level.e + ' ' + level.n;
        var who = (na ? (na.charAt(0).toUpperCase()+na.slice(1)) : a.name) + ' & ' + (nb ? (nb.charAt(0).toUpperCase()+nb.slice(1)) : b.name);
        $('ct-summary').textContent = who + ' share a ' + score + '% cosmic compatibility. ' + (level.band==='high' ? 'The stars are clearly on your side.' : level.band==='mid' ? 'A promising match with real room to grow.' : 'A challenging but potentially transformative bond.');

        $('ct-elem-text').textContent = (a.element === b.element ? (a.element + ' meets ' + b.element + ' — ') : (a.element + ' meets ' + b.element + ' — ')) + (ELEM_TEXT[ek] || '');

        function bar(off, lo, hi){ var v = score + ((hashStr(a.key+b.key+off) % (hi-lo+1)) + lo); return Math.max(42, Math.min(99, v)); }
        var bars = { love:bar('L',-6,8), comm:bar('C',-10,6), trust:bar('T',-8,7), pass:bar('P',-4,10), lt:bar('G',-9,6) };

        // strengths/challenges
        var sList = STRENGTHS[level.band], cList = CHALLENGES[level.band];
        var su=$('ct-strengths'); su.innerHTML=''; sList.forEach(function(t){ var li=document.createElement('li'); li.textContent=t; su.appendChild(li); });
        var cu=$('ct-challenges'); cu.innerHTML=''; cList.forEach(function(t){ var li=document.createElement('li'); li.textContent=t; cu.appendChild(li); });
        $('ct-advice-text').textContent = ADVICE[level.band];

        phases.loading.classList.remove('ct-show'); phases.loading.style.display='none';
        phases.result.classList.add('ct-show');
        animateNum($('ct-pct'),0,score,1800);
        var circ=2*Math.PI*86; setTimeout(function(){ $('ct-ring-fg').style.strokeDashoffset=circ-(circ*score/100); },80);
        setTimeout(function(){
            $('ct-b1').style.width=bars.love+'%'; $('ct-b1-v').textContent=bars.love+'%';
            $('ct-b2').style.width=bars.comm+'%'; $('ct-b2-v').textContent=bars.comm+'%';
            $('ct-b3').style.width=bars.trust+'%'; $('ct-b3-v').textContent=bars.trust+'%';
            $('ct-b4').style.width=bars.pass+'%'; $('ct-b4-v').textContent=bars.pass+'%';
            $('ct-b5').style.width=bars.lt+'%'; $('ct-b5-v').textContent=bars.lt+'%';
        },200);

        setupShare(a, b, na, nb, score, level);
        if (score>=80) setTimeout(confetti, 600);
        setTimeout(function(){ phases.result.scrollIntoView({behavior:'smooth',block:'start'}); },100);
    }

    function setupShare(a,b,na,nb,score,level){
        var url=window.location.href;
        var who=(na?(na.charAt(0).toUpperCase()+na.slice(1)):a.name)+' & '+(nb?(nb.charAt(0).toUpperCase()+nb.slice(1)):b.name);
        var msg='💞 '+who+' = *'+score+'% Compatible* ('+level.n+')!\n'+a.name+' '+a.icon+' + '+b.name+' '+b.icon+'\n\nTest yours: '+url;
        var tweet=a.name+' + '+b.name+' = '+score+'% compatible '+level.e+' Test your zodiac compatibility:';
        $('ct-sb-wa').href='https://wa.me/?text='+encodeURIComponent(msg);
        $('ct-sb-tw').href='https://twitter.com/intent/tweet?text='+encodeURIComponent(tweet)+'&url='+encodeURIComponent(url);
        $('ct-sb-copy').onclick=function(){ var btn=this,o=btn.innerHTML; try{ if(navigator.clipboard){ navigator.clipboard.writeText(url).then(function(){ btn.innerHTML='✅ Copied!'; setTimeout(function(){ btn.innerHTML=o; },1800); }); } else { var ta=document.createElement('textarea'); ta.value=url; document.body.appendChild(ta); ta.select(); document.execCommand('copy'); ta.remove(); btn.innerHTML='✅ Copied!'; setTimeout(function(){ btn.innerHTML=o; },1800);} }catch(e){ btn.innerHTML='⚠ Try Manually'; setTimeout(function(){ btn.innerHTML=o; },1800);} };
        $('ct-sb-save').onclick=function(){ var btn=this,o=btn.innerHTML; btn.innerHTML='📸 Saving...'; setTimeout(function(){ if(navigator.share){ navigator.share({title:'Compatibility Result',text:msg,url:url}).then(function(){ btn.innerHTML=o; }).catch(function(){ alert('Screenshot your result to save it!'); btn.innerHTML=o; }); } else { alert('Screenshot your result to save it!\n\n'+who+' = '+score+'% compatible'); btn.innerHTML=o; } },400); };
    }

    function go(){
        if(!$('ct-sign-a').value || !$('ct-sign-b').value){ $('ct-error').classList.add('ct-show'); return; }
        $('ct-error').classList.remove('ct-show');
        phases.input.style.display='none';
        phases.loading.style.display='block'; phases.loading.classList.add('ct-show');
        $('ct-progress-bar').style.width='0%';
        runLoading(showResult);
    }
    $('ct-go-btn').addEventListener('click', go);

    $('ct-try-btn').addEventListener('click', function(){
        phases.result.classList.remove('ct-show');
        phases.loading.classList.remove('ct-show'); phases.loading.style.display='none';
        phases.input.style.display='block';
        $('ct-pct').textContent='0'; $('ct-ring-fg').style.strokeDashoffset=540.35;
        ['ct-b1','ct-b2','ct-b3','ct-b4','ct-b5'].forEach(function(id){ $(id).style.width='0%'; });
        $('ct-card').scrollIntoView({behavior:'smooth',block:'start'});
    });

    var counterEl=$('ct-counter'); var count=407612;
    setInterval(function(){ count+=1+Math.floor(Math.random()*3); counterEl.textContent=count.toLocaleString('en-IN'); },8000);
})();
        <?php
        $ct_js = ob_get_clean();

        if ( ! wp_script_is( 'ct-pro-inline', 'enqueued' ) ) {
            wp_register_script( 'ct-pro-inline', '', array(), '1.0.0', true );
            wp_enqueue_script( 'ct-pro-inline' );
            wp_add_inline_script( 'ct-pro-inline', $ct_js );
        }

        return $ct_html;
    }

    add_shortcode( 'compatibility_test', 'ct_pro_render_compat' );
    add_shortcode( 'zodiac_compatibility', 'ct_pro_render_compat' );
    add_shortcode( 'love_compatibility', 'ct_pro_render_compat' );
}
