<?php
/**
 * Mulank &amp; Bhagyank Numerology Calculator — Shortcode [mulank_calculator]
 *
 * Inputs: date of birth.
 * Outputs: Mulank (1-9), Bhagyank (1-9), ruling planet, personality,
 *   lucky color/day/number/gemstone, career fields, compatible numbers
 *   for friendship, love, business; health insights, famous personalities,
 *   remedies, golden hints, advice, share, FAQ + JSON-LD.
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! function_exists( 'ccp_render_mulank_calculator' ) ) {

function ccp_render_mulank_calculator( $atts = array() ) {
    ob_start();
    ?>
<div class="mc-wrap" id="mc-wrap">
    <style>
        .mc-wrap, .mc-wrap *, .mc-wrap *::before, .mc-wrap *::after { box-sizing: border-box; }
        .mc-wrap { font-family: 'DM Sans', 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; color: #1F1933; max-width: 920px; margin: 0 auto; padding: 12px; line-height: 1.6; }
        .mc-wrap h1, .mc-wrap h2, .mc-wrap h3, .mc-wrap h4 { font-family: 'Poppins', 'Syne', system-ui, sans-serif; font-weight: 800; letter-spacing: -0.01em; margin: 0; }

        .mc-header { background: linear-gradient(135deg, #0F0729 0%, #2E1065 45%, #4C1D95 75%, #BE185D 100%); border-radius: 24px; padding: 32px 22px; color: #fff; text-align: center; box-shadow: 0 22px 60px rgba(76, 29, 149, 0.32); position: relative; overflow: hidden; }
        .mc-header::before { content: ""; position: absolute; inset: -50%; background: radial-gradient(circle at 25% 20%, rgba(245,158,11,0.20), transparent 55%), radial-gradient(circle at 78% 82%, rgba(190,24,93,0.32), transparent 55%); pointer-events: none; animation: mc-shimmer 9s linear infinite; }
        .mc-header-icon { font-size: 54px; line-height: 1; display: inline-block; animation: mc-bob 2.4s ease-in-out infinite; filter: drop-shadow(0 4px 14px rgba(245,158,11,0.4)); }
        .mc-header h1 { font-size: 40px; margin: 8px 0 6px; color: #fff; }
        .mc-header-sub { opacity: 0.88; font-size: 15.5px; margin: 0 auto; max-width: 580px; }
        .mc-stats { display: flex; align-items: center; justify-content: center; gap: 0; margin-top: 20px; flex-wrap: wrap; position: relative; z-index: 1; }
        .mc-stat { padding: 4px 16px; min-width: 100px; }
        .mc-stat-num { font-weight: 800; font-family: 'Poppins', sans-serif; font-size: 19px; color: #FBBF24; }
        .mc-stat-lbl { font-size: 11px; opacity: 0.82; text-transform: uppercase; letter-spacing: 0.07em; }
        .mc-stat + .mc-stat { border-left: 1px solid rgba(255,255,255,0.22); }

        .mc-card { background: #fff; border-radius: 22px; padding: 26px 22px; margin-top: 18px; box-shadow: 0 22px 60px rgba(15, 7, 41, 0.10); border: 1px solid #EEE8FB; }

        /* Inputs */
        .mc-fields { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
        .mc-field { display: flex; flex-direction: column; gap: 6px; }
        .mc-label { font-size: 13px; font-weight: 700; color: #4C1D95; letter-spacing: 0.04em; text-transform: uppercase; }
        .mc-input, .mc-select { width: 100%; min-height: 52px; padding: 12px 16px; font-size: 16px; border: 2px solid #EDE7FB; border-radius: 14px; outline: none; background: #FAF8FF; transition: border-color .2s, background .2s, box-shadow .2s; font-family: inherit; color: #1F1933; }
        .mc-input:focus, .mc-select:focus { border-color: #7C3AED; background: #fff; box-shadow: 0 0 0 4px rgba(124,58,237,0.14); }
        .mc-dob { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; }
        .mc-name-row { margin-top: 14px; }
        .mc-btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; min-height: 56px; padding: 18px 22px; font-size: 17px; font-weight: 700; font-family: 'Poppins', sans-serif; border: none; border-radius: 14px; cursor: pointer; width: 100%; transition: transform .15s ease, box-shadow .2s ease, opacity .2s; }
        .mc-btn-primary { background: linear-gradient(135deg, #4C1D95, #BE185D); color: #fff; box-shadow: 0 14px 32px rgba(76,29,149,0.36); margin-top: 20px; }
        .mc-btn-primary:hover { transform: translateY(-2px); box-shadow: 0 18px 42px rgba(190,24,93,0.45); }
        .mc-btn-primary:active { transform: translateY(0); }
        .mc-trust { display: flex; gap: 10px; justify-content: center; flex-wrap: wrap; margin-top: 14px; }
        .mc-trust span { font-size: 12.5px; color: #5B5070; background: #F4EEFB; padding: 6px 12px; border-radius: 999px; min-height: 30px; display: inline-flex; align-items: center; }
        .mc-error { display: none; background: #FFF1F2; color: #B3162A; border: 1px solid #FFD6DB; padding: 10px 14px; border-radius: 12px; margin-top: 12px; font-size: 14px; text-align: center; }
        .mc-error.mc-show { display: block; animation: mc-shake .4s; }

        /* Loading */
        .mc-loading { display: none; text-align: center; padding: 14px 8px 6px; }
        .mc-loading.mc-show { display: block; }
        .mc-rings { position: relative; width: 170px; height: 170px; margin: 6px auto 18px; }
        .mc-ring { position: absolute; inset: 0; border-radius: 50%; border: 3px solid rgba(124,58,237,0.35); animation: mc-ringp 2s ease-out infinite; }
        .mc-ring:nth-child(2) { animation-delay: .5s; border-color: rgba(245,158,11,0.42); }
        .mc-ring:nth-child(3) { animation-delay: 1s; border-color: rgba(190,24,93,0.45); }
        .mc-ring-icon { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; font-size: 62px; animation: mc-pulse 1.2s ease-in-out infinite; }
        .mc-load-step { font-size: 15px; color: #6B5E85; min-height: 24px; transition: opacity .25s; }
        .mc-progress { height: 8px; background: #F1EBF7; border-radius: 999px; overflow: hidden; margin: 14px auto 4px; max-width: 380px; }
        .mc-progress-bar { height: 100%; width: 0%; background: linear-gradient(90deg, #4C1D95, #BE185D, #F59E0B); border-radius: 999px; transition: width .35s ease; }

        /* Result */
        .mc-result { display: none; }
        .mc-result.mc-show { display: block; animation: mc-fadeUp .55s ease both; }
        .mc-result-card { background: linear-gradient(135deg, #0F0729, #2E1065, #4C1D95, #BE185D); color: #fff; border-radius: 22px; padding: 30px 22px; text-align: center; box-shadow: 0 22px 60px rgba(15,7,41,0.32); position: relative; overflow: hidden; }
        .mc-result-card::after { content: ""; position: absolute; inset: 0; background: radial-gradient(circle at 18% 12%, rgba(245,158,11,0.25), transparent 55%), radial-gradient(circle at 82% 88%, rgba(244,114,182,0.22), transparent 55%); pointer-events: none; }
        .mc-numbers { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; position: relative; z-index: 1; max-width: 540px; margin: 0 auto; }
        .mc-num-box { background: rgba(255,255,255,0.10); border: 1px solid rgba(255,255,255,0.18); border-radius: 18px; padding: 18px 12px; }
        .mc-num-lbl { font-size: 12px; opacity: 0.86; letter-spacing: 0.08em; text-transform: uppercase; }
        .mc-num-val { font-family: 'Poppins', sans-serif; font-size: 64px; font-weight: 800; line-height: 1; color: #FBBF24; margin-top: 4px; text-shadow: 0 4px 18px rgba(245,158,11,0.4); }
        .mc-num-sub { font-size: 13px; opacity: 0.9; margin-top: 4px; }
        .mc-planet { display: inline-block; margin-top: 16px; padding: 8px 18px; background: rgba(255,255,255,0.14); border: 1px solid rgba(255,255,255,0.24); border-radius: 999px; font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 15px; position: relative; z-index: 1; }
        .mc-rc-desc { max-width: 620px; margin: 12px auto 0; opacity: 0.94; font-size: 15px; position: relative; z-index: 1; }
        .mc-watermark { margin-top: 14px; font-size: 12.5px; opacity: 0.72; position: relative; z-index: 1; }

        /* Trait chips */
        .mc-traits { display: flex; flex-wrap: wrap; gap: 8px; justify-content: center; margin-top: 14px; position: relative; z-index: 1; }
        .mc-trait { background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.22); padding: 6px 14px; border-radius: 999px; font-size: 13px; font-weight: 600; }

        /* Info grid */
        .mc-info { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; margin-top: 18px; }
        .mc-info-card { background: linear-gradient(135deg, #FFFFFF, #FAF6FF); border-radius: 16px; padding: 16px; box-shadow: 0 10px 24px rgba(15,7,41,0.06); border: 1px solid #EEE8FB; opacity: 0; transform: translateY(10px); animation: mc-fadeUp .5s ease forwards; }
        .mc-info-ic { font-size: 26px; }
        .mc-info-card h4 { font-size: 13px; color: #6B5E85; margin: 6px 0 2px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.06em; }
        .mc-info-val { font-family: 'Poppins', sans-serif; font-weight: 800; color: #2E1065; font-size: 16px; line-height: 1.3; }
        .mc-color-row { display: flex; align-items: center; gap: 8px; }
        .mc-color-sw { width: 22px; height: 22px; border-radius: 6px; box-shadow: inset 0 0 0 1px rgba(0,0,0,0.1); }

        /* Compatibility */
        .mc-compat { background: linear-gradient(135deg, #FFFFFF, #F8F5FF); border-radius: 18px; padding: 22px; margin-top: 16px; border: 1px solid #EEE8FB; }
        .mc-compat h3 { color: #2E1065; font-size: 19px; margin-bottom: 14px; }
        .mc-compat-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; }
        .mc-compat-box { background: #FFFBEB; border: 1px solid #FCD34D; border-radius: 14px; padding: 14px; text-align: center; }
        .mc-compat-box:nth-child(2) { background: #FDF2F8; border-color: #FBCFE8; }
        .mc-compat-box:nth-child(3) { background: #ECFDF5; border-color: #6EE7B7; }
        .mc-compat-box h4 { font-size: 13px; color: #6B5E85; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 4px; }
        .mc-compat-nums { font-family: 'Poppins', sans-serif; font-weight: 800; color: #2E1065; font-size: 20px; }

        /* Career box */
        .mc-career { background: linear-gradient(135deg, #ECFDF5, #D1FAE5); border-radius: 18px; padding: 22px; margin-top: 16px; border: 1px solid #6EE7B7; }
        .mc-career h3 { color: #065F46; font-size: 19px; margin-bottom: 8px; }
        .mc-career-list { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 10px; }
        .mc-c-tag { background: #fff; padding: 6px 14px; border-radius: 999px; font-size: 13px; font-weight: 600; color: #065F46; border: 1px solid #A7F3D0; }

        /* Golden hints */
        .mc-hints { background: linear-gradient(135deg, #FFFBEB, #FEF3C7); border-radius: 18px; padding: 22px; margin-top: 16px; border: 1px solid #FCD34D; position: relative; }
        .mc-hints::before { content: "\2605"; position: absolute; top: -10px; left: 20px; background: #F59E0B; color: #fff; width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 16px; box-shadow: 0 6px 14px rgba(245,158,11,0.4); }
        .mc-hints h3 { font-size: 19px; color: #78350F; margin-bottom: 12px; padding-left: 8px; }
        .mc-hints-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; }
        .mc-hint { background: #fff; border-radius: 14px; padding: 14px; border-left: 4px solid #F59E0B; box-shadow: 0 8px 20px rgba(0,0,0,0.05); opacity: 0; transform: translateY(8px); animation: mc-fadeUp .5s ease forwards; }
        .mc-hint-icon { font-size: 22px; margin-bottom: 4px; }
        .mc-hint h4 { font-size: 14.5px; color: #2E1065; margin-bottom: 4px; }
        .mc-hint p { font-size: 13px; color: #5B5070; margin: 0; }

        /* Remedies */
        .mc-remedies { background: linear-gradient(135deg, #EFF6FF, #DBEAFE); border-radius: 18px; padding: 22px; margin-top: 16px; border: 1px solid #93C5FD; }
        .mc-remedies h3 { color: #1E3A8A; font-size: 19px; margin-bottom: 8px; }
        .mc-rem-list { margin: 8px 0 0 0; padding-left: 18px; }
        .mc-rem-list li { color: #1E3A8A; margin: 6px 0; font-size: 14.5px; }

        /* Famous */
        .mc-famous { background: linear-gradient(135deg, #FAF5FF, #F3E8FF); border-radius: 18px; padding: 22px; margin-top: 16px; border: 1px solid #D8B4FE; }
        .mc-famous h3 { color: #6B21A8; font-size: 19px; margin-bottom: 6px; }
        .mc-famous p { color: #581C87; font-size: 14.5px; line-height: 1.6; margin: 0; }

        /* Share */
        .mc-share { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin-top: 18px; }
        .mc-share-btn { display: inline-flex; align-items: center; justify-content: center; gap: 6px; min-height: 48px; padding: 12px 8px; font-size: 14px; font-weight: 700; font-family: 'Poppins', sans-serif; border-radius: 12px; border: none; cursor: pointer; color: #fff; text-decoration: none; transition: transform .15s ease, box-shadow .15s ease; }
        .mc-share-btn:hover { transform: translateY(-2px); box-shadow: 0 12px 26px rgba(0,0,0,0.15); }
        .mc-sb-wa { background: #25D366; }
        .mc-sb-tw { background: #111; }
        .mc-sb-save { background: linear-gradient(135deg, #4C1D95, #BE185D); }
        .mc-sb-copy { background: #5B5B6E; }
        .mc-try { margin-top: 14px; background: #fff; color: #2E1065; border: 2px solid #EDE7FB; }
        .mc-try:hover { border-color: #7C3AED; color: #7C3AED; }

        /* Numbers reference */
        .mc-grid9 { display: grid; grid-template-columns: repeat(9, 1fr); gap: 8px; margin-top: 22px; }
        .mc-n9 { background: #fff; border-radius: 14px; padding: 12px 6px; text-align: center; box-shadow: 0 8px 20px rgba(0,0,0,0.06); border-top: 4px solid #4C1D95; }
        .mc-n9:nth-child(1) { border-color: #F59E0B; }
        .mc-n9:nth-child(2) { border-color: #94A3B8; }
        .mc-n9:nth-child(3) { border-color: #8B5CF6; }
        .mc-n9:nth-child(4) { border-color: #6B7280; }
        .mc-n9:nth-child(5) { border-color: #10B981; }
        .mc-n9:nth-child(6) { border-color: #EC4899; }
        .mc-n9:nth-child(7) { border-color: #06B6D4; }
        .mc-n9:nth-child(8) { border-color: #1F2937; }
        .mc-n9:nth-child(9) { border-color: #EF4444; }
        .mc-n9-num { font-family: 'Poppins', sans-serif; font-weight: 800; color: #1F1933; font-size: 22px; }
        .mc-n9-pl { font-size: 11px; color: #6B5E85; text-transform: uppercase; letter-spacing: 0.06em; }

        /* FAQ */
        .mc-faq { margin-top: 24px; }
        .mc-faq h2 { font-size: 24px; color: #2E1065; margin-bottom: 12px; }
        .mc-faq-item { background: #fff; border-radius: 14px; margin-bottom: 10px; box-shadow: 0 8px 20px rgba(0,0,0,0.05); border: 1px solid #EEE8FB; overflow: hidden; }
        .mc-faq-q { width: 100%; min-height: 56px; padding: 16px 18px; background: #fff; border: none; text-align: left; font-size: 15.5px; font-weight: 700; font-family: 'Poppins', sans-serif; color: #1F1933; cursor: pointer; display: flex; justify-content: space-between; align-items: center; gap: 10px; }
        .mc-faq-q::after { content: "+"; font-size: 24px; font-weight: 400; color: #7C3AED; transition: transform .25s; }
        .mc-faq-item.mc-open .mc-faq-q::after { transform: rotate(45deg); }
        .mc-faq-a { padding: 0 18px; max-height: 0; overflow: hidden; transition: max-height .35s ease, padding .35s ease; color: #5B5070; font-size: 14.5px; }
        .mc-faq-item.mc-open .mc-faq-a { padding: 0 18px 18px; max-height: 700px; }

        @keyframes mc-pulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.08); } }
        @keyframes mc-bob { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-6px); } }
        @keyframes mc-ringp { 0% { transform: scale(0.6); opacity: 0.9; } 100% { transform: scale(1.4); opacity: 0; } }
        @keyframes mc-fadeUp { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes mc-shake { 0%, 100% { transform: translateX(0); } 25% { transform: translateX(-4px); } 75% { transform: translateX(4px); } }
        @keyframes mc-shimmer { 0%, 100% { transform: rotate(0deg); } 50% { transform: rotate(180deg); } }

        @media (max-width: 720px) {
            .mc-info { grid-template-columns: repeat(2, 1fr); }
            .mc-compat-grid { grid-template-columns: 1fr; }
            .mc-grid9 { grid-template-columns: repeat(3, 1fr); }
        }
        @media (max-width: 640px) {
            .mc-wrap { padding: 8px; }
            .mc-header { padding: 24px 16px; border-radius: 18px; }
            .mc-header h1 { font-size: 30px; }
            .mc-header-icon { font-size: 46px; }
            .mc-card { padding: 20px 16px; border-radius: 18px; }
            .mc-fields { grid-template-columns: 1fr; }
            .mc-num-val { font-size: 54px; }
            .mc-share { grid-template-columns: repeat(2, 1fr); }
            .mc-hints-grid { grid-template-columns: 1fr; }
        }
    </style>

    <header class="mc-header">
        <div class="mc-header-icon">&#128302;</div>
        <h1>Mulank &amp; Bhagyank Calculator</h1>
        <p class="mc-header-sub">Discover your Numerology Root Number (Mulank) &amp; Destiny Number (Bhagyank) with ruling planet, lucky days, gemstones, career, compatibility &amp; remedies.</p>
        <div class="mc-stats">
            <div class="mc-stat"><div class="mc-stat-num" id="mc-counter">1,89,652</div><div class="mc-stat-lbl">Readings Today</div></div>
            <div class="mc-stat"><div class="mc-stat-num">4.9&#9733;</div><div class="mc-stat-lbl">Rating</div></div>
            <div class="mc-stat"><div class="mc-stat-num">100%</div><div class="mc-stat-lbl">Free</div></div>
        </div>
    </header>

    <section class="mc-card">
        <div class="mc-input-phase" id="mc-input-phase">
            <div class="mc-field mc-name-row" style="grid-column: 1 / -1;">
                <label class="mc-label" for="mc-name">Your Name (optional)</label>
                <input type="text" id="mc-name" class="mc-input" placeholder="e.g. Rahul Sharma" maxlength="40" autocomplete="off" />
            </div>
            <div class="mc-fields" style="margin-top: 14px;">
                <div class="mc-field">
                    <label class="mc-label">Date of Birth</label>
                    <div class="mc-dob">
                        <select id="mc-day" class="mc-select" aria-label="Day"></select>
                        <select id="mc-month" class="mc-select" aria-label="Month"></select>
                        <select id="mc-year" class="mc-select" aria-label="Year"></select>
                    </div>
                </div>
                <div class="mc-field">
                    <label class="mc-label" for="mc-gender">Gender (optional)</label>
                    <select id="mc-gender" class="mc-select">
                        <option value="">Prefer not to say</option>
                        <option value="m">Male</option>
                        <option value="f">Female</option>
                        <option value="o">Other</option>
                    </select>
                </div>
            </div>
            <div class="mc-error" id="mc-error">Please select your full date of birth.</div>
            <button type="button" class="mc-btn mc-btn-primary" id="mc-calc-btn">Reveal My Numbers &#128302;</button>
            <div class="mc-trust">
                <span>&#128274; 100% Private</span>
                <span>&#9889; Instant Reading</span>
                <span>&#127942; Vedic + Western</span>
                <span>&#128241; Mobile Friendly</span>
            </div>
        </div>

        <div class="mc-loading" id="mc-loading">
            <div class="mc-rings">
                <div class="mc-ring"></div>
                <div class="mc-ring"></div>
                <div class="mc-ring"></div>
                <div class="mc-ring-icon">&#10024;</div>
            </div>
            <div class="mc-load-step" id="mc-load-step">&#128197; Reading your birth date...</div>
            <div class="mc-progress"><div class="mc-progress-bar" id="mc-progress-bar"></div></div>
        </div>

        <div class="mc-result" id="mc-result">
            <div class="mc-result-card">
                <div class="mc-numbers">
                    <div class="mc-num-box"><div class="mc-num-lbl">Mulank</div><div class="mc-num-val" id="mc-mulank-v">0</div><div class="mc-num-sub">Root Number</div></div>
                    <div class="mc-num-box"><div class="mc-num-lbl">Bhagyank</div><div class="mc-num-val" id="mc-bhagyank-v">0</div><div class="mc-num-sub">Destiny Number</div></div>
                </div>
                <div class="mc-planet" id="mc-planet">&#127773; Planet</div>
                <p class="mc-rc-desc" id="mc-rc-desc">Your numerology profile is being cast...</p>
                <div class="mc-traits" id="mc-traits"></div>
                <div class="mc-watermark">cosmiccalculators.in &middot; Vedic Numerology</div>
            </div>

            <!-- Info grid -->
            <div class="mc-info">
                <div class="mc-info-card"><div class="mc-info-ic">&#127912;</div><h4>Lucky Color</h4><div class="mc-color-row"><span class="mc-color-sw" id="mc-color-sw"></span><span class="mc-info-val" id="mc-color-v">--</span></div></div>
                <div class="mc-info-card"><div class="mc-info-ic">&#128197;</div><h4>Lucky Day</h4><div class="mc-info-val" id="mc-day-v">--</div></div>
                <div class="mc-info-card"><div class="mc-info-ic">&#128142;</div><h4>Lucky Gemstone</h4><div class="mc-info-val" id="mc-gem-v">--</div></div>
                <div class="mc-info-card"><div class="mc-info-ic">&#127815;</div><h4>Lucky Numbers</h4><div class="mc-info-val" id="mc-numbers-v">--</div></div>
                <div class="mc-info-card"><div class="mc-info-ic">&#128276;</div><h4>Lucky Metal</h4><div class="mc-info-val" id="mc-metal-v">--</div></div>
                <div class="mc-info-card"><div class="mc-info-ic">&#127757;</div><h4>Lucky Direction</h4><div class="mc-info-val" id="mc-dir-v">--</div></div>
            </div>

            <!-- Compatibility -->
            <div class="mc-compat">
                <h3>&#128279; Number Compatibility</h3>
                <div class="mc-compat-grid">
                    <div class="mc-compat-box"><h4>Best Friends</h4><div class="mc-compat-nums" id="mc-cf-v">--</div></div>
                    <div class="mc-compat-box"><h4>Love Match</h4><div class="mc-compat-nums" id="mc-cl-v">--</div></div>
                    <div class="mc-compat-box"><h4>Business Partners</h4><div class="mc-compat-nums" id="mc-cb-v">--</div></div>
                </div>
            </div>

            <!-- Career -->
            <div class="mc-career">
                <h3>&#128188; Career Paths That Suit You</h3>
                <div class="mc-career-list" id="mc-career-list"></div>
            </div>

            <!-- Golden hints -->
            <div class="mc-hints">
                <h3 id="mc-hints-title">Golden Hints</h3>
                <div class="mc-hints-grid" id="mc-hints-grid"></div>
            </div>

            <!-- Famous -->
            <div class="mc-famous">
                <h3>&#127775; Famous Personalities With Same Mulank</h3>
                <p id="mc-famous-p">--</p>
            </div>

            <!-- Remedies -->
            <div class="mc-remedies">
                <h3>&#129776; Simple Remedies &amp; Power Rituals</h3>
                <ul class="mc-rem-list" id="mc-rem-list"></ul>
            </div>

            <!-- Share -->
            <div class="mc-share">
                <a href="#" class="mc-share-btn mc-sb-wa" id="mc-sb-wa" target="_blank" rel="noopener">&#128241; WhatsApp</a>
                <a href="#" class="mc-share-btn mc-sb-tw" id="mc-sb-tw" target="_blank" rel="noopener">&#119991; Twitter</a>
                <button type="button" class="mc-share-btn mc-sb-save" id="mc-sb-save">&#128247; Save Card</button>
                <button type="button" class="mc-share-btn mc-sb-copy" id="mc-sb-copy">&#128279; Copy Link</button>
            </div>

            <button type="button" class="mc-btn mc-try" id="mc-try-btn">&#128260; Calculate Again</button>
        </div>
    </section>

    <section>
        <h2 style="font-size:22px;color:#2E1065;margin: 22px 0 10px;">All Mulank Numbers &amp; Their Ruling Planets</h2>
        <div class="mc-grid9">
            <div class="mc-n9"><div class="mc-n9-num">1</div><div class="mc-n9-pl">Sun</div></div>
            <div class="mc-n9"><div class="mc-n9-num">2</div><div class="mc-n9-pl">Moon</div></div>
            <div class="mc-n9"><div class="mc-n9-num">3</div><div class="mc-n9-pl">Jupiter</div></div>
            <div class="mc-n9"><div class="mc-n9-num">4</div><div class="mc-n9-pl">Rahu</div></div>
            <div class="mc-n9"><div class="mc-n9-num">5</div><div class="mc-n9-pl">Mercury</div></div>
            <div class="mc-n9"><div class="mc-n9-num">6</div><div class="mc-n9-pl">Venus</div></div>
            <div class="mc-n9"><div class="mc-n9-num">7</div><div class="mc-n9-pl">Ketu</div></div>
            <div class="mc-n9"><div class="mc-n9-num">8</div><div class="mc-n9-pl">Saturn</div></div>
            <div class="mc-n9"><div class="mc-n9-num">9</div><div class="mc-n9-pl">Mars</div></div>
        </div>
    </section>

    <section class="mc-faq">
        <h2>Mulank &amp; Bhagyank &mdash; FAQs</h2>
        <div class="mc-faq-item"><button class="mc-faq-q" type="button">What is Mulank in numerology?</button><div class="mc-faq-a"><p>Mulank (also called Root or Birth Number) is the single-digit total of your birth date. For example, if you were born on the 27th, your Mulank is 2+7=9. It reveals your core personality and natural strengths.</p></div></div>
        <div class="mc-faq-item"><button class="mc-faq-q" type="button">What is Bhagyank?</button><div class="mc-faq-a"><p>Bhagyank (Destiny or Life Path Number) is the single-digit total of your full birth date — day + month + year. It shows your life mission, karmic path, and what the universe is steering you toward.</p></div></div>
        <div class="mc-faq-item"><button class="mc-faq-q" type="button">How is Mulank different from Bhagyank?</button><div class="mc-faq-a"><p>Mulank is who you are right now &mdash; instinct, vibe, natural talents. Bhagyank is where life is taking you &mdash; opportunities, lessons, destiny. Both numbers together give a complete numerology snapshot.</p></div></div>
        <div class="mc-faq-item"><button class="mc-faq-q" type="button">Does my Mulank change?</button><div class="mc-faq-a"><p>No. Your Mulank and Bhagyank are fixed for life because they are based on your fixed date of birth. What changes is how skillfully you express your number&rsquo;s strengths.</p></div></div>
        <div class="mc-faq-item"><button class="mc-faq-q" type="button">Is Vedic numerology accurate?</button><div class="mc-faq-a"><p>Vedic numerology has been used in India for thousands of years to guide career, relationships, and timing of major decisions. Modern users find it powerful for self-reflection and pattern recognition. Use it as guidance, not a substitute for real choices.</p></div></div>
        <div class="mc-faq-item"><button class="mc-faq-q" type="button">Is my date of birth stored?</button><div class="mc-faq-a"><p>No. The entire calculation runs inside your browser. Your date of birth is never sent to a server, saved, or shared. It is 100% private.</p></div></div>
    </section>

    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@graph": [
        {
          "@type": "SoftwareApplication",
          "name": "Mulank & Bhagyank Calculator",
          "applicationCategory": "LifestyleApplication",
          "operatingSystem": "Web",
          "url": "https://cosmiccalculators.in/mulank-calculator/",
          "offers": { "@type": "Offer", "price": "0", "priceCurrency": "USD" },
          "aggregateRating": { "@type": "AggregateRating", "ratingValue": "4.9", "ratingCount": "11240" }
        },
        {
          "@type": "FAQPage",
          "mainEntity": [
            { "@type": "Question", "name": "What is Mulank in numerology?", "acceptedAnswer": { "@type": "Answer", "text": "Mulank is the single-digit total of your birth date. For someone born on the 27th, Mulank is 2+7=9. It reveals core personality and natural strengths." } },
            { "@type": "Question", "name": "What is Bhagyank?", "acceptedAnswer": { "@type": "Answer", "text": "Bhagyank is the single-digit total of your full birth date — day + month + year. It represents life path and destiny." } },
            { "@type": "Question", "name": "Does my Mulank change?", "acceptedAnswer": { "@type": "Answer", "text": "No. Both Mulank and Bhagyank stay fixed for life as they are based on your unchanging birth date." } },
            { "@type": "Question", "name": "Is the calculator private?", "acceptedAnswer": { "@type": "Answer", "text": "Yes. Everything runs in your browser. Nothing is sent to any server or saved." } }
          ]
        }
      ]
    }
    </script>
</div>

<script>
(function(){
    'use strict';
    var MC = { $: function(id){ return document.getElementById(id); } };

    function escapeHtml(s) {
        return String(s).replace(/[&<>"']/g, function(c){
            return ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'})[c];
        });
    }

    // Populate selects
    (function populate(){
        var day = MC.$('mc-day'), month = MC.$('mc-month'), year = MC.$('mc-year');
        var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        var optEmpty = function(label){ var o = document.createElement('option'); o.value = ''; o.textContent = label; return o; };
        day.appendChild(optEmpty('Day'));
        for (var d=1; d<=31; d++) { var o = document.createElement('option'); o.value = d; o.textContent = d; day.appendChild(o); }
        month.appendChild(optEmpty('Month'));
        for (var m=1; m<=12; m++) { var o2 = document.createElement('option'); o2.value = m; o2.textContent = months[m-1]; month.appendChild(o2); }
        var cy = new Date().getFullYear();
        year.appendChild(optEmpty('Year'));
        for (var y=cy; y>=cy-100; y--) { var o3 = document.createElement('option'); o3.value = y; o3.textContent = y; year.appendChild(o3); }
    })();

    function digitalRoot(n) {
        n = Math.abs(n|0);
        while (n > 9) {
            var s = 0;
            while (n > 0) { s += n % 10; n = Math.floor(n / 10); }
            n = s;
        }
        return n || 9;
    }

    function calcMulank(day) { return digitalRoot(day); }
    function calcBhagyank(day, month, year) { return digitalRoot(day + month + year); }

    // Number profiles (1-9)
    var PROFILES = {
        1: {
            planet: '☀️ Sun',
            traits: ['Leader','Ambitious','Original','Confident','Independent'],
            desc: 'Number 1 is the natural leader. You are pioneering, original, and driven to create something of your own. Your energy lights rooms, but you must guard against ego and isolation.',
            color: { name: 'Royal Gold', hex: '#F59E0B' },
            day: 'Sunday',
            gem: 'Ruby (Manik)',
            numbers: '1, 10, 19, 28',
            metal: 'Gold',
            direction: 'East',
            careers: ['Entrepreneur','CEO','Leadership Roles','Politician','Director','Government Officer','Brand Founder','Surgeon'],
            friends: '1, 2, 4, 7',
            love: '1, 2, 4',
            business: '1, 3, 5, 9',
            famous: 'Sundar Pichai, Tom Hanks, Walt Disney, Charlie Chaplin, Jack Ma, Steve Jobs.',
            remedies: ['Offer water to the rising sun every morning.','Wear gold or copper ornaments on your right hand.','Practice Surya Namaskar daily.','Donate wheat or jaggery on Sundays.']
        },
        2: {
            planet: '🌙 Moon',
            traits: ['Sensitive','Diplomatic','Caring','Intuitive','Adaptable'],
            desc: 'Number 2 is the peacemaker. You are emotional, intuitive, and deeply nurturing. Your gift is reading people. Your challenge is taking on too much of others’ emotions.',
            color: { name: 'Pearl White', hex: '#E0F2FE' },
            day: 'Monday',
            gem: 'Pearl (Moti)',
            numbers: '2, 11, 20, 29',
            metal: 'Silver',
            direction: 'North-West',
            careers: ['Counsellor','Nurse','Diplomat','Designer','Writer','Teacher','HR Manager','Hospitality'],
            friends: '1, 2, 7, 9',
            love: '1, 4, 7',
            business: '1, 6, 7',
            famous: 'Mahatma Gandhi, Madonna, Shahrukh Khan, Bill Clinton, Lady Gaga.',
            remedies: ['Drink water in a silver glass at night.','Wear white on Mondays.','Donate milk or rice on full moon nights.','Practice 10 minutes of journaling before sleep.']
        },
        3: {
            planet: '🪐 Jupiter',
            traits: ['Optimistic','Creative','Knowledgeable','Witty','Inspirational'],
            desc: 'Number 3 is the wise expressive one. You are curious, creative, and a natural communicator. Your wisdom inspires others. Your trap is scattering your energy across too many ideas.',
            color: { name: 'Saffron Yellow', hex: '#FBBF24' },
            day: 'Thursday',
            gem: 'Yellow Sapphire (Pukhraj)',
            numbers: '3, 12, 21, 30',
            metal: 'Brass / Gold',
            direction: 'North-East',
            careers: ['Teacher','Writer','Lawyer','Spiritual Speaker','Publisher','Coach','Journalist','Banker'],
            friends: '3, 6, 9',
            love: '3, 6, 9',
            business: '1, 3, 9',
            famous: 'Albert Einstein, J.K. Rowling, Aishwarya Rai, Rajinikanth, Snoop Dogg.',
            remedies: ['Offer haldi (turmeric) at a temple on Thursdays.','Wear yellow on Thursdays.','Donate yellow lentils, books, or sweets.','Chant Guru mantra 11 times daily.']
        },
        4: {
            planet: '☄️ Rahu',
            traits: ['Strategic','Unconventional','Hardworking','Disruptive','Innovative'],
            desc: 'Number 4 is the rebel innovator. You see what others miss and walk paths nobody dared. Life gives you sudden ups and downs — your strength is rising every time.',
            color: { name: 'Electric Blue', hex: '#3B82F6' },
            day: 'Sunday / Wednesday',
            gem: 'Hessonite (Gomed)',
            numbers: '4, 13, 22, 31',
            metal: 'Mixed alloy',
            direction: 'South-West',
            careers: ['Tech / Engineering','Data Scientist','Investor','Stock Trader','Researcher','Aviation','Pharma','Independent Consultant'],
            friends: '1, 5, 7, 8',
            love: '1, 5, 7',
            business: '5, 7, 8',
            famous: 'Elon Musk, Barack Obama, Salman Khan, Akshay Kumar, Bill Gates.',
            remedies: ['Keep a small piece of silver in your wallet.','Donate black sesame seeds on Saturdays.','Feed black dogs or stray birds regularly.','Avoid alcohol and gambling — they amplify Rahu’s instability.']
        },
        5: {
            planet: '☿ Mercury',
            traits: ['Quick','Versatile','Communicative','Energetic','Adventurous'],
            desc: 'Number 5 is the free spirit. You are fast, sharp, and curious. Travel, networking, and ideas energize you. Boredom is your biggest enemy — keep your life moving.',
            color: { name: 'Mint Green', hex: '#10B981' },
            day: 'Wednesday',
            gem: 'Emerald (Panna)',
            numbers: '5, 14, 23',
            metal: 'Silver',
            direction: 'North',
            careers: ['Marketing','Sales','Content Creator','Trader','Travel Blogger','Public Relations','Influencer','Tour Guide'],
            friends: '1, 4, 5, 6',
            love: '1, 5, 6',
            business: '4, 5, 8',
            famous: 'Tiger Shroff, Steven Spielberg, Vladimir Putin, Mick Jagger.',
            remedies: ['Wear green on Wednesdays.','Feed green vegetables to a cow or stray animal.','Use green pens for important signatures.','Practice deep breathing — it calms Mercury’s restless energy.']
        },
        6: {
            planet: '♀ Venus',
            traits: ['Loving','Artistic','Charming','Family-oriented','Magnetic'],
            desc: 'Number 6 is the artist of love. You are beautiful inside-out, magnetic, and devoted to family and beauty. Your weakness is overspending on luxury or attention.',
            color: { name: 'Rose Pink', hex: '#EC4899' },
            day: 'Friday',
            gem: 'Diamond / White Sapphire',
            numbers: '6, 15, 24',
            metal: 'Silver / Platinum',
            direction: 'South-East',
            careers: ['Fashion Designer','Actor','Singer','Beauty Industry','Interior Designer','Chef','Luxury Brand','Wedding Planner'],
            friends: '3, 6, 9',
            love: '3, 6, 9',
            business: '5, 6, 8',
            famous: 'Anushka Sharma, Beyoncé, Robert De Niro, John Lennon, Vivekananda.',
            remedies: ['Wear white or light pink on Fridays.','Gift flowers to your partner or mother.','Donate sugar, rice, or white sweets.','Keep your home clean and fragrant — Venus loves beauty.']
        },
        7: {
            planet: '🌌 Ketu',
            traits: ['Spiritual','Mysterious','Analytical','Introverted','Psychic'],
            desc: 'Number 7 is the seeker. You are deep, intuitive, and drawn to truth beneath the surface. Solitude charges you. Avoid overthinking — meditation is your superpower.',
            color: { name: 'Smoky Grey', hex: '#6B7280' },
            day: 'Monday / Thursday',
            gem: 'Cat’s Eye (Lehsunia)',
            numbers: '7, 16, 25',
            metal: 'Silver',
            direction: 'North-East',
            careers: ['Researcher','Spiritual Guide','Psychologist','Scientist','Astrologer','Writer','Detective','Healer'],
            friends: '1, 2, 4, 7',
            love: '2, 4, 7',
            business: '4, 5, 7',
            famous: 'Mark Zuckerberg, Princess Diana, Stephen Hawking, Sania Mirza.',
            remedies: ['Meditate for 15 minutes daily.','Avoid lending money on Tuesdays.','Donate blankets or warm clothes.','Spend time in nature weekly.']
        },
        8: {
            planet: '♄ Saturn',
            traits: ['Determined','Disciplined','Authoritative','Patient','Karmic'],
            desc: 'Number 8 is the karma master. Life tests you hard before it rewards you. You build empires through patience, structure, and grit. Shortcuts always backfire.',
            color: { name: 'Deep Indigo', hex: '#1F2937' },
            day: 'Saturday',
            gem: 'Blue Sapphire (Neelam) — only after testing',
            numbers: '8, 17, 26',
            metal: 'Iron',
            direction: 'West',
            careers: ['Real Estate','Mining','Civil Services','Judge','Banker','Construction','Logistics','Long-term Investor'],
            friends: '4, 5, 8',
            love: '1, 4, 5',
            business: '4, 5, 8',
            famous: 'Narendra Modi, Pablo Picasso, Sushmita Sen, Sundar Pichai.',
            remedies: ['Feed crows or stray dogs on Saturdays.','Light a mustard-oil lamp under a peepal tree.','Donate black items: black gram, iron, footwear.','Never disrespect elders or employees — Saturn watches.']
        },
        9: {
            planet: '♂ Mars',
            traits: ['Courageous','Energetic','Passionate','Protective','Generous'],
            desc: 'Number 9 is the warrior. You fight for what is right, love fiercely, and never give up. Your anger is your only enemy — channel it into action, not reaction.',
            color: { name: 'Bold Red', hex: '#EF4444' },
            day: 'Tuesday',
            gem: 'Red Coral (Moonga)',
            numbers: '9, 18, 27',
            metal: 'Copper',
            direction: 'South',
            careers: ['Army / Defence','Sports','Surgeon','Athlete','Police','Activist','Firefighter','Engineer'],
            friends: '3, 6, 9',
            love: '3, 6, 9',
            business: '1, 3, 9',
            famous: 'Amitabh Bachchan, Mother Teresa, Jim Carrey, Roger Federer.',
            remedies: ['Donate red lentils (masoor dal) on Tuesdays.','Practice martial arts or daily workouts.','Wear red on Tuesdays.','Recite Hanuman Chalisa to calm Mars when angry.']
        }
    };

    function getHints(mulank, bhagyank) {
        var common = [
            { i: '🎯', t: 'Lock Your Lucky Day', d: 'Sign contracts, start projects, or have big talks on your lucky day. Energy compounds.' },
            { i: '🌈', t: 'Wear Your Power Color', d: 'On big days, wear your lucky color — it boosts confidence and Mulank alignment.' },
            { i: '🧘', t: 'Daily 10-Min Pause', d: 'Even a short pause aligns you with your destiny number’s frequency.' },
            { i: '💎', t: 'Use Lucky Gemstone Carefully', d: 'Always consult before wearing strong stones (especially Neelam & Gomed).' }
        ];
        return common;
    }

    function getAdviceText(mulank, bhagyank, name) {
        var n = name ? (name + ', ') : '';
        if (mulank === bhagyank) return n + 'your Mulank and Bhagyank are the same — a rare alignment. Your inner self and your destiny path point the same way, giving you focus most people don’t have. Trust your gut more than ever.';
        if ((mulank + bhagyank) % 9 === 0) return n + 'your Mulank and Bhagyank create a karmic loop — meaning life keeps repeating lessons until you master them. Slow down, reflect, and grow inward as much as outward.';
        return n + 'your Mulank is your daily style and your Bhagyank is your life mission. Lean into your Mulank for short-term wins, and trust your Bhagyank for major life decisions like career, marriage, and moves.';
    }

    var loadSteps = [
        '📅 Reading your birth date...',
        '🌌 Mapping planetary energy...',
        '🔢 Calculating Mulank & Bhagyank...',
        '🔮 Crafting your reading...'
    ];

    function runLoading(callback) {
        var stepEl = MC.$('mc-load-step');
        var barEl  = MC.$('mc-progress-bar');
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

    function showResult(state) {
        var mulank = state.mulank;
        var bhagyank = state.bhagyank;
        var name = state.name || '';
        var pm = PROFILES[mulank];
        var pb = PROFILES[bhagyank];

        // numbers
        animateNum(MC.$('mc-mulank-v'), 0, mulank, 1100);
        animateNum(MC.$('mc-bhagyank-v'), 0, bhagyank, 1300);

        MC.$('mc-planet').textContent = pm.planet + ' Rules You';
        MC.$('mc-rc-desc').textContent = pm.desc;

        var traitsBox = MC.$('mc-traits');
        traitsBox.innerHTML = '';
        for (var ti=0; ti<pm.traits.length; ti++) {
            var t = document.createElement('span');
            t.className = 'mc-trait';
            t.textContent = pm.traits[ti];
            traitsBox.appendChild(t);
        }

        // Info
        MC.$('mc-color-v').textContent = pm.color.name;
        MC.$('mc-color-sw').style.background = pm.color.hex;
        MC.$('mc-day-v').textContent     = pm.day;
        MC.$('mc-gem-v').textContent     = pm.gem;
        MC.$('mc-numbers-v').textContent = pm.numbers;
        MC.$('mc-metal-v').textContent   = pm.metal;
        MC.$('mc-dir-v').textContent     = pm.direction;

        // Compat
        MC.$('mc-cf-v').textContent = pm.friends;
        MC.$('mc-cl-v').textContent = pm.love;
        MC.$('mc-cb-v').textContent = pm.business;

        // Careers
        var cList = MC.$('mc-career-list');
        cList.innerHTML = '';
        for (var ci=0; ci<pm.careers.length; ci++) {
            var c = document.createElement('span');
            c.className = 'mc-c-tag';
            c.textContent = pm.careers[ci];
            cList.appendChild(c);
        }

        // Famous
        MC.$('mc-famous-p').textContent = pm.famous;

        // Remedies
        var rList = MC.$('mc-rem-list');
        rList.innerHTML = '';
        for (var ri=0; ri<pm.remedies.length; ri++) {
            var li = document.createElement('li');
            li.textContent = pm.remedies[ri];
            rList.appendChild(li);
        }

        // Hints
        var hints = getHints(mulank, bhagyank);
        MC.$('mc-hints-title').innerHTML = '⭐ Golden Hints' + (name ? ' for ' + escapeHtml(name) : '');
        var hgrid = MC.$('mc-hints-grid');
        hgrid.innerHTML = '';
        for (var hi=0; hi<hints.length; hi++) {
            var h = hints[hi];
            var card = document.createElement('div');
            card.className = 'mc-hint';
            card.style.animationDelay = (hi * 0.1) + 's';
            card.innerHTML = '<div class="mc-hint-icon">' + h.i + '</div><h4>' + escapeHtml(h.t) + '</h4><p>' + escapeHtml(h.d) + '</p>';
            hgrid.appendChild(card);
        }

        // Animate info cards
        var infos = document.querySelectorAll('#mc-wrap .mc-info-card');
        for (var ii=0; ii<infos.length; ii++) infos[ii].style.animationDelay = (ii * 0.07) + 's';

        // Show
        MC.$('mc-loading').classList.remove('mc-show');
        MC.$('mc-loading').style.display = 'none';
        MC.$('mc-result').classList.add('mc-show');

        setupShare(name, mulank, bhagyank, pm);

        setTimeout(function(){ MC.$('mc-result').scrollIntoView({ behavior: 'smooth', block: 'start' }); }, 100);
    }

    function setupShare(name, mulank, bhagyank, pm) {
        var url = window.location.href;
        var who = name ? name : 'My';
        var msg = '🔮 Numerology Reading!\n\n' + who + ' Mulank: *' + mulank + '* (' + pm.planet + ')\n' + who + ' Bhagyank: *' + bhagyank + '*\n\nFind yours: ' + url;
        var tweet = (name ? name + "'s" : 'My') + ' Mulank is ' + mulank + ' & Bhagyank is ' + bhagyank + ' 🔮 Get your free reading:';

        MC.$('mc-sb-wa').href = 'https://wa.me/?text=' + encodeURIComponent(msg);
        MC.$('mc-sb-tw').href = 'https://twitter.com/intent/tweet?text=' + encodeURIComponent(tweet) + '&url=' + encodeURIComponent(url);

        MC.$('mc-sb-copy').onclick = function(){
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
        MC.$('mc-sb-save').onclick = function(){
            var btn = this; var orig = btn.innerHTML;
            btn.innerHTML = '📸 Saving...';
            setTimeout(function(){
                if (navigator.share) {
                    navigator.share({ title: 'My Numerology Reading', text: msg, url: url }).then(function(){ btn.innerHTML = orig; }).catch(function(){
                        alert('Take a screenshot to save your reading!\nMulank ' + mulank + ' | Bhagyank ' + bhagyank);
                        btn.innerHTML = orig;
                    });
                } else {
                    alert('Take a screenshot to save your reading!\nMulank ' + mulank + ' | Bhagyank ' + bhagyank);
                    btn.innerHTML = orig;
                }
            }, 400);
        };
    }

    MC.$('mc-calc-btn').addEventListener('click', function(){
        var d = parseInt(MC.$('mc-day').value, 10);
        var m = parseInt(MC.$('mc-month').value, 10);
        var y = parseInt(MC.$('mc-year').value, 10);
        var name = (MC.$('mc-name').value || '').trim();
        var err = MC.$('mc-error');
        if (!d || !m || !y) { err.textContent = 'Please select your full date of birth.'; err.classList.add('mc-show'); return; }

        // Validate date
        var dt = new Date(y, m-1, d);
        if (dt.getDate() !== d || (dt.getMonth()+1) !== m || dt.getFullYear() !== y) {
            err.textContent = 'That date doesn’t look right — please check.'; err.classList.add('mc-show'); return;
        }
        err.classList.remove('mc-show');

        var state = { name: name, day: d, month: m, year: y, mulank: calcMulank(d), bhagyank: calcBhagyank(d, m, y) };

        MC.$('mc-input-phase').style.display = 'none';
        MC.$('mc-loading').style.display = 'block';
        MC.$('mc-loading').classList.add('mc-show');
        MC.$('mc-progress-bar').style.width = '0%';

        runLoading(function(){ showResult(state); });
    });

    MC.$('mc-try-btn').addEventListener('click', function(){
        MC.$('mc-result').classList.remove('mc-show');
        MC.$('mc-loading').classList.remove('mc-show');
        MC.$('mc-loading').style.display = 'none';
        MC.$('mc-input-phase').style.display = 'block';
        MC.$('mc-mulank-v').textContent = '0';
        MC.$('mc-bhagyank-v').textContent = '0';
        MC.$('mc-input-phase').scrollIntoView({ behavior: 'smooth', block: 'start' });
    });

    var faqs = document.querySelectorAll('#mc-wrap .mc-faq-item');
    faqs.forEach(function(item){
        var q = item.querySelector('.mc-faq-q');
        q.addEventListener('click', function(){ item.classList.toggle('mc-open'); });
    });

    var counterEl = MC.$('mc-counter');
    var count = 189652;
    setInterval(function(){
        count += 1 + Math.floor(Math.random()*3);
        counterEl.textContent = count.toLocaleString('en-IN');
    }, 9000);
})();
</script>
    <?php
    return ob_get_clean();
}

}
