<?php
/**
 * Friendship Calculator — Shortcode [friendship_calculator]
 *
 * Premium friendship compatibility calculator by name.
 * Includes: animated ring, 4 metric bars, best emoji, career match,
 * best pet, friendship song, friendship color, lucky day & number,
 * golden hints, personalized advice, share buttons, Hindi+English bilingual mode, JSON-LD schema.
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! function_exists( 'ccp_render_friendship_calculator' ) ) {

function ccp_render_friendship_calculator( $atts = array() ) {
    ob_start();
    ?>
<div class="fc-wrap" id="fc-wrap">
    <style>
        .fc-wrap, .fc-wrap *, .fc-wrap *::before, .fc-wrap *::after { box-sizing: border-box; }
        .fc-wrap { font-family: 'DM Sans', 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; color: #1F1933; max-width: 920px; margin: 0 auto; padding: 12px; line-height: 1.6; }
        .fc-wrap h1, .fc-wrap h2, .fc-wrap h3, .fc-wrap h4 { font-family: 'Poppins', 'Syne', system-ui, sans-serif; font-weight: 800; letter-spacing: -0.01em; margin: 0; }

        /* === Shared Cosmic Theme === */
        .fc-header { background: linear-gradient(135deg, #0F0729 0%, #2E1065 45%, #4C1D95 75%, #BE185D 100%); border-radius: 24px; padding: 32px 22px; color: #fff; text-align: center; box-shadow: 0 22px 60px rgba(76, 29, 149, 0.32); position: relative; overflow: hidden; }
        .fc-header::before { content: ""; position: absolute; inset: -50%; background: radial-gradient(circle at 25% 20%, rgba(245,158,11,0.18), transparent 55%), radial-gradient(circle at 78% 82%, rgba(190,24,93,0.32), transparent 55%); pointer-events: none; animation: fc-shimmer 9s linear infinite; }
        .fc-header-icon { font-size: 54px; line-height: 1; display: inline-block; animation: fc-bob 2.4s ease-in-out infinite; filter: drop-shadow(0 4px 14px rgba(245,158,11,0.4)); }
        .fc-header h1 { font-size: 40px; margin: 8px 0 6px; color: #fff; }
        .fc-header-sub { opacity: 0.88; font-size: 15.5px; margin: 0; max-width: 560px; margin-inline: auto; }
        .fc-stats { display: flex; align-items: center; justify-content: center; gap: 0; margin-top: 20px; flex-wrap: wrap; position: relative; z-index: 1; }
        .fc-stat { padding: 4px 16px; min-width: 100px; }
        .fc-stat-num { font-weight: 800; font-family: 'Poppins', sans-serif; font-size: 19px; color: #FBBF24; }
        .fc-stat-lbl { font-size: 11px; opacity: 0.82; text-transform: uppercase; letter-spacing: 0.07em; }
        .fc-stat + .fc-stat { border-left: 1px solid rgba(255,255,255,0.22); }

        /* Card shell */
        .fc-card { background: #fff; border-radius: 22px; padding: 26px 22px; margin-top: 18px; box-shadow: 0 22px 60px rgba(15, 7, 41, 0.10); border: 1px solid #EEE8FB; }

        /* Input phase */
        .fc-inputs { display: grid; grid-template-columns: 1fr auto 1fr; gap: 14px; align-items: center; }
        .fc-field { display: flex; flex-direction: column; align-items: center; gap: 10px; }
        .fc-avatar { width: 68px; height: 68px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-family: 'Poppins', sans-serif; font-weight: 800; font-size: 28px; color: #fff; box-shadow: 0 10px 26px rgba(0,0,0,0.18); transition: transform .25s ease; }
        .fc-avatar.fc-a { background: linear-gradient(135deg, #4C1D95, #7C3AED); }
        .fc-avatar.fc-b { background: linear-gradient(135deg, #BE185D, #F472B6); }
        .fc-avatar:hover { transform: scale(1.06) rotate(-3deg); }
        .fc-input { width: 100%; min-height: 52px; padding: 12px 16px; font-size: 16px; border: 2px solid #EDE7FB; border-radius: 14px; outline: none; background: #FAF8FF; transition: border-color .2s, background .2s, box-shadow .2s; font-family: inherit; }
        .fc-input:focus { border-color: #7C3AED; background: #fff; box-shadow: 0 0 0 4px rgba(124,58,237,0.14); }
        .fc-vs { width: 58px; height: 58px; border-radius: 50%; background: linear-gradient(135deg, #F59E0B, #BE185D); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 22px; font-weight: 800; font-family: 'Poppins', sans-serif; box-shadow: 0 12px 26px rgba(190,24,93,0.36); animation: fc-pulse 1.6s ease-in-out infinite; }
        .fc-btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; min-height: 56px; padding: 18px 22px; font-size: 17px; font-weight: 700; font-family: 'Poppins', sans-serif; border: none; border-radius: 14px; cursor: pointer; width: 100%; transition: transform .15s ease, box-shadow .2s ease, opacity .2s; }
        .fc-btn-primary { background: linear-gradient(135deg, #4C1D95, #BE185D); color: #fff; box-shadow: 0 14px 32px rgba(76,29,149,0.36); margin-top: 20px; }
        .fc-btn-primary:hover { transform: translateY(-2px); box-shadow: 0 18px 42px rgba(190,24,93,0.45); }
        .fc-btn-primary:active { transform: translateY(0); }
        .fc-trust { display: flex; gap: 10px; justify-content: center; flex-wrap: wrap; margin-top: 14px; }
        .fc-trust span { font-size: 12.5px; color: #5B5070; background: #F4EEFB; padding: 6px 12px; border-radius: 999px; min-height: 30px; display: inline-flex; align-items: center; }
        .fc-error { display: none; background: #FFF1F2; color: #B3162A; border: 1px solid #FFD6DB; padding: 10px 14px; border-radius: 12px; margin-top: 12px; font-size: 14px; text-align: center; }
        .fc-error.fc-show { display: block; animation: fc-shake .4s; }

        /* Loading phase */
        .fc-loading { display: none; text-align: center; padding: 14px 8px 6px; }
        .fc-loading.fc-show { display: block; }
        .fc-rings { position: relative; width: 170px; height: 170px; margin: 6px auto 18px; }
        .fc-ring { position: absolute; inset: 0; border-radius: 50%; border: 3px solid rgba(124,58,237,0.35); animation: fc-ringp 2s ease-out infinite; }
        .fc-ring:nth-child(2) { animation-delay: .5s; border-color: rgba(245,158,11,0.42); }
        .fc-ring:nth-child(3) { animation-delay: 1s; border-color: rgba(190,24,93,0.45); }
        .fc-ring-icon { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; font-size: 62px; animation: fc-pulse 1.2s ease-in-out infinite; }
        .fc-load-names { font-size: 18px; font-weight: 700; font-family: 'Poppins', sans-serif; color: #2E1065; margin-bottom: 12px; }
        .fc-load-step { font-size: 15px; color: #6B5E85; min-height: 24px; transition: opacity .25s; }
        .fc-progress { height: 8px; background: #F1EBF7; border-radius: 999px; overflow: hidden; margin: 14px auto 4px; max-width: 380px; }
        .fc-progress-bar { height: 100%; width: 0%; background: linear-gradient(90deg, #4C1D95, #BE185D, #F59E0B); border-radius: 999px; transition: width .35s ease; }

        /* Result phase */
        .fc-result { display: none; }
        .fc-result.fc-show { display: block; animation: fc-fadeUp .55s ease both; }
        .fc-result-card { background: linear-gradient(135deg, #0F0729, #2E1065, #4C1D95, #BE185D); color: #fff; border-radius: 22px; padding: 30px 22px; text-align: center; box-shadow: 0 22px 60px rgba(15,7,41,0.32); position: relative; overflow: hidden; }
        .fc-result-card::after { content: ""; position: absolute; inset: 0; background: radial-gradient(circle at 18% 12%, rgba(245,158,11,0.25), transparent 55%), radial-gradient(circle at 82% 88%, rgba(244,114,182,0.22), transparent 55%); pointer-events: none; }
        .fc-rc-names { display: flex; align-items: center; justify-content: center; gap: 14px; flex-wrap: wrap; margin-bottom: 6px; position: relative; z-index: 1; }
        .fc-rc-name { display: flex; align-items: center; gap: 10px; font-weight: 700; font-family: 'Poppins', sans-serif; font-size: 17px; }
        .fc-rc-name .fc-avatar { width: 46px; height: 46px; font-size: 19px; }
        .fc-rc-heart { font-size: 24px; opacity: 0.9; }
        .fc-ring-wrap { position: relative; width: 230px; height: 230px; margin: 14px auto 10px; z-index: 1; }
        .fc-ring-wrap svg { transform: rotate(-90deg); width: 100%; height: 100%; }
        .fc-ring-bg { fill: none; stroke: rgba(255,255,255,0.14); stroke-width: 12; }
        .fc-ring-fg { fill: none; stroke: url(#fc-grad); stroke-width: 12; stroke-linecap: round; transition: stroke-dashoffset 1.8s cubic-bezier(.22,.9,.3,1); }
        .fc-percent { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; flex-direction: column; }
        .fc-percent-num { font-size: 66px; font-weight: 800; font-family: 'Poppins', sans-serif; line-height: 1; }
        .fc-percent-sym { font-size: 24px; font-weight: 700; opacity: 0.85; }
        .fc-level { display: inline-block; background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.24); padding: 8px 18px; border-radius: 999px; font-weight: 700; font-family: 'Poppins', sans-serif; font-size: 15px; margin: 6px 0 10px; position: relative; z-index: 1; }
        .fc-rc-desc { max-width: 600px; margin: 0 auto; opacity: 0.94; font-size: 15px; position: relative; z-index: 1; }
        .fc-watermark { margin-top: 14px; font-size: 12.5px; opacity: 0.72; position: relative; z-index: 1; }

        /* Bars */
        .fc-bars { margin-top: 10px; }
        .fc-bar-row { margin: 14px 0; }
        .fc-bar-top { display: flex; justify-content: space-between; font-size: 14px; font-weight: 600; color: #2D2447; margin-bottom: 6px; }
        .fc-bar-top span:last-child { color: #7C3AED; font-family: 'Poppins', sans-serif; font-weight: 800; }
        .fc-bar { height: 10px; background: #F1EBF7; border-radius: 999px; overflow: hidden; }
        .fc-bar-fill { height: 100%; width: 0%; border-radius: 999px; background: linear-gradient(90deg, #4C1D95, #BE185D, #F59E0B); transition: width 1.5s cubic-bezier(.22,.9,.3,1); }

        /* Predictions grid (Emoji / Career / Pet / Song / Color / Day / Number) */
        .fc-preds { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin-top: 18px; }
        .fc-pred { background: linear-gradient(135deg, #FFFFFF, #FAF6FF); border-radius: 16px; padding: 16px 12px; text-align: center; box-shadow: 0 10px 24px rgba(15,7,41,0.06); border: 1px solid #EEE8FB; opacity: 0; transform: translateY(10px); animation: fc-fadeUp .5s ease forwards; }
        .fc-pred-ic { font-size: 30px; }
        .fc-pred h4 { font-size: 13px; color: #6B5E85; margin: 6px 0 2px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.06em; }
        .fc-pred-val { font-family: 'Poppins', sans-serif; font-weight: 800; color: #2E1065; font-size: 15.5px; line-height: 1.3; }
        .fc-pred-swatch { display: inline-block; width: 36px; height: 14px; border-radius: 6px; margin-top: 4px; box-shadow: inset 0 0 0 1px rgba(0,0,0,0.08); }

        /* Golden hints */
        .fc-hints { background: linear-gradient(135deg, #FFFBEB, #FEF3C7); border-radius: 18px; padding: 22px; margin-top: 18px; border: 1px solid #FCD34D; position: relative; }
        .fc-hints::before { content: "\2605"; position: absolute; top: -10px; left: 20px; background: #F59E0B; color: #fff; width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 16px; box-shadow: 0 6px 14px rgba(245,158,11,0.4); }
        .fc-hints h3 { font-size: 19px; color: #78350F; margin-bottom: 12px; padding-left: 8px; }
        .fc-hints-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; }
        .fc-hint { background: #fff; border-radius: 14px; padding: 14px; border-left: 4px solid #F59E0B; box-shadow: 0 8px 20px rgba(0,0,0,0.05); opacity: 0; transform: translateY(8px); animation: fc-fadeUp .5s ease forwards; }
        .fc-hint-icon { font-size: 22px; margin-bottom: 4px; }
        .fc-hint h4 { font-size: 14.5px; color: #2E1065; margin-bottom: 4px; }
        .fc-hint p { font-size: 13px; color: #5B5070; margin: 0; }

        /* Advice */
        .fc-advice { background: linear-gradient(135deg, #ECFDF5, #D1FAE5); border-radius: 18px; padding: 22px; margin-top: 16px; border: 1px solid #6EE7B7; }
        .fc-advice h3 { font-size: 18px; color: #065F46; margin-bottom: 8px; }
        .fc-advice p { font-style: italic; color: #064E3B; margin: 0 0 12px; font-size: 14.5px; line-height: 1.65; }
        .fc-tags { display: flex; flex-wrap: wrap; gap: 8px; }
        .fc-tag { background: #fff; padding: 6px 12px; border-radius: 999px; font-size: 12.5px; font-weight: 600; color: #065F46; border: 1px solid #A7F3D0; }
        .fc-tag.fc-t2 { color: #6D28D9; border-color: #DDD6FE; }
        .fc-tag.fc-t3 { color: #BE185D; border-color: #FBCFE8; }
        .fc-tag.fc-t4 { color: #B45309; border-color: #FDE68A; }

        /* Share */
        .fc-share { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin-top: 18px; }
        .fc-share-btn { display: inline-flex; align-items: center; justify-content: center; gap: 6px; min-height: 48px; padding: 12px 8px; font-size: 14px; font-weight: 700; font-family: 'Poppins', sans-serif; border-radius: 12px; border: none; cursor: pointer; color: #fff; text-decoration: none; transition: transform .15s ease, box-shadow .15s ease; }
        .fc-share-btn:hover { transform: translateY(-2px); box-shadow: 0 12px 26px rgba(0,0,0,0.15); }
        .fc-sb-wa { background: #25D366; }
        .fc-sb-tw { background: #111; }
        .fc-sb-save { background: linear-gradient(135deg, #4C1D95, #BE185D); }
        .fc-sb-copy { background: #5B5B6E; }
        .fc-try { margin-top: 14px; background: #fff; color: #2E1065; border: 2px solid #EDE7FB; }
        .fc-try:hover { border-color: #7C3AED; color: #7C3AED; }

        /* Confetti */
        .fc-confetti { position: fixed; inset: 0; pointer-events: none; z-index: 9999; overflow: hidden; }
        .fc-confetti i { position: absolute; top: -20px; width: 10px; height: 14px; opacity: 0.95; animation: fc-fall linear forwards; border-radius: 2px; }

        /* Levels */
        .fc-levels { display: grid; grid-template-columns: repeat(5, 1fr); gap: 10px; margin-top: 22px; }
        .fc-lvl { background: #fff; border-radius: 16px; padding: 14px 10px; text-align: center; box-shadow: 0 10px 24px rgba(0,0,0,0.06); border-top: 4px solid #4C1D95; }
        .fc-lvl:nth-child(1) { border-color: #F59E0B; }
        .fc-lvl:nth-child(2) { border-color: #BE185D; }
        .fc-lvl:nth-child(3) { border-color: #4C1D95; }
        .fc-lvl:nth-child(4) { border-color: #2563EB; }
        .fc-lvl:nth-child(5) { border-color: #14B8A6; }
        .fc-lvl-icon { font-size: 26px; }
        .fc-lvl h4 { font-size: 14px; color: #1F1933; margin: 4px 0; }
        .fc-lvl-range { font-size: 12px; color: #7C3AED; font-weight: 700; }
        .fc-lvl-desc { font-size: 12px; color: #5B5070; margin: 4px 0 0; }

        /* Language toggle */
        .fc-lang { display: inline-flex; gap: 4px; background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.22); border-radius: 999px; padding: 4px; margin-top: 14px; position: relative; z-index: 1; }
        .fc-lang-btn { background: transparent; color: #fff; border: none; padding: 7px 16px; font-size: 13px; font-weight: 700; font-family: 'Poppins', sans-serif; border-radius: 999px; cursor: pointer; transition: background .2s, color .2s; min-height: 34px; }
        .fc-lang-btn.fc-lang-active { background: #FBBF24; color: #1F1933; box-shadow: 0 6px 14px rgba(245,158,11,0.35); }

        /* Related */
        .fc-related { margin-top: 24px; }
        .fc-related h2 { font-size: 22px; color: #2E1065; margin-bottom: 12px; }
        .fc-related-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; }
        .fc-rt { display: block; text-decoration: none; background: #fff; border-radius: 16px; padding: 16px 12px; text-align: center; box-shadow: 0 10px 24px rgba(0,0,0,0.06); border-top: 4px solid #4C1D95; color: inherit; transition: transform .15s ease, box-shadow .2s ease; }
        .fc-rt:hover { transform: translateY(-3px); box-shadow: 0 16px 32px rgba(0,0,0,0.1); }
        .fc-rt:nth-child(1) { border-color: #F59E0B; }
        .fc-rt:nth-child(2) { border-color: #BE185D; }
        .fc-rt:nth-child(3) { border-color: #14B8A6; }
        .fc-rt-icon { font-size: 28px; }
        .fc-rt h4 { font-size: 15px; color: #1F1933; margin: 6px 0 4px; }
        .fc-rt p { font-size: 12.5px; color: #5B5070; margin: 0; }

        /* Animations */
        @keyframes fc-pulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.08); } }
        @keyframes fc-bob { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-6px); } }
        @keyframes fc-ringp { 0% { transform: scale(0.6); opacity: 0.9; } 100% { transform: scale(1.4); opacity: 0; } }
        @keyframes fc-fadeUp { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fc-shake { 0%, 100% { transform: translateX(0); } 25% { transform: translateX(-4px); } 75% { transform: translateX(4px); } }
        @keyframes fc-fall { 0% { transform: translateY(-20px) rotate(0); opacity: 1; } 100% { transform: translateY(110vh) rotate(720deg); opacity: 0.3; } }
        @keyframes fc-shimmer { 0%, 100% { transform: rotate(0deg); } 50% { transform: rotate(180deg); } }

        @media (max-width: 720px) {
            .fc-preds { grid-template-columns: repeat(2, 1fr); }
            .fc-related-grid { grid-template-columns: 1fr 1fr; }
        }
        @media (max-width: 640px) {
            .fc-wrap { padding: 8px; }
            .fc-header { padding: 24px 16px; border-radius: 18px; }
            .fc-header h1 { font-size: 30px; }
            .fc-header-icon { font-size: 46px; }
            .fc-stat-num { font-size: 16px; }
            .fc-card { padding: 20px 16px; border-radius: 18px; }
            .fc-inputs { grid-template-columns: 1fr; gap: 12px; }
            .fc-vs { margin: -4px auto; }
            .fc-percent-num { font-size: 56px; }
            .fc-ring-wrap { width: 200px; height: 200px; }
            .fc-share { grid-template-columns: repeat(2, 1fr); }
            .fc-levels { grid-template-columns: repeat(2, 1fr); }
            .fc-related-grid { grid-template-columns: 1fr; }
            .fc-hints-grid { grid-template-columns: 1fr; }
        }
        @media (max-width: 380px) {
            .fc-header h1 { font-size: 26px; }
            .fc-stat { padding: 4px 8px; min-width: 84px; }
            .fc-preds { grid-template-columns: 1fr 1fr; }
        }
    </style>

    <header class="fc-header">
        <div class="fc-header-icon">&#129309;</div>
        <h1 data-i18n="title">Friendship Calculator</h1>
        <p class="fc-header-sub" data-i18n="sub">Discover the strength of your bond by name &mdash; with best emoji, career match, pet, song &amp; golden hints.</p>
        <div class="fc-stats">
            <div class="fc-stat">
                <div class="fc-stat-num" id="fc-counter">2,76,481</div>
                <div class="fc-stat-lbl" data-i18n="tests">Tests Today</div>
            </div>
            <div class="fc-stat">
                <div class="fc-stat-num">4.9&#9733;</div>
                <div class="fc-stat-lbl" data-i18n="rating">Rating</div>
            </div>
            <div class="fc-stat">
                <div class="fc-stat-num">100%</div>
                <div class="fc-stat-lbl" data-i18n="free">Free</div>
            </div>
        </div>
        <div class="fc-lang" role="group" aria-label="Language">
            <button type="button" class="fc-lang-btn fc-lang-active" data-lang="en">English</button>
            <button type="button" class="fc-lang-btn" data-lang="hi">हिंदी</button>
        </div>
    </header>

    <section class="fc-card">
        <div class="fc-input-phase" id="fc-input-phase">
            <div class="fc-inputs">
                <div class="fc-field">
                    <div class="fc-avatar fc-a" id="fc-av-a">?</div>
                    <input type="text" class="fc-input" id="fc-name-a" placeholder="Your name" maxlength="30" autocomplete="off" aria-label="Your name" />
                </div>
                <div class="fc-vs" aria-hidden="true">&#129309;</div>
                <div class="fc-field">
                    <div class="fc-avatar fc-b" id="fc-av-b">?</div>
                    <input type="text" class="fc-input" id="fc-name-b" placeholder="Friend's name" maxlength="30" autocomplete="off" aria-label="Friend's name" />
                </div>
            </div>
            <div class="fc-error" id="fc-error" data-i18n="err_empty">Please enter both names to continue.</div>
            <button type="button" class="fc-btn fc-btn-primary" id="fc-calc-btn" data-i18n="calc_btn">Calculate Friendship &#129309;</button>
            <div class="fc-trust">
                <span data-i18n="t_private">&#128274; Private &amp; Safe</span>
                <span data-i18n="t_instant">&#9889; Instant Result</span>
                <span data-i18n="t_free">&#127942; 100% Free</span>
                <span data-i18n="t_mobile">&#128241; Mobile Friendly</span>
            </div>
        </div>

        <div class="fc-loading" id="fc-loading">
            <div class="fc-rings">
                <div class="fc-ring"></div>
                <div class="fc-ring"></div>
                <div class="fc-ring"></div>
                <div class="fc-ring-icon">&#128591;</div>
            </div>
            <div class="fc-load-names" id="fc-load-names">&#129309;</div>
            <div class="fc-load-step" id="fc-load-step">&#128483; Reading your names...</div>
            <div class="fc-progress"><div class="fc-progress-bar" id="fc-progress-bar"></div></div>
        </div>

        <div class="fc-result" id="fc-result">
            <div class="fc-result-card">
                <div class="fc-rc-names">
                    <div class="fc-rc-name"><div class="fc-avatar fc-a" id="fc-rc-av-a">?</div><span id="fc-rc-n-a">Name 1</span></div>
                    <div class="fc-rc-heart">&#129309;</div>
                    <div class="fc-rc-name"><div class="fc-avatar fc-b" id="fc-rc-av-b">?</div><span id="fc-rc-n-b">Name 2</span></div>
                </div>
                <div class="fc-ring-wrap">
                    <svg viewBox="0 0 200 200" aria-hidden="true">
                        <defs>
                            <linearGradient id="fc-grad" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#F59E0B"/>
                                <stop offset="50%" stop-color="#F472B6"/>
                                <stop offset="100%" stop-color="#7C3AED"/>
                            </linearGradient>
                        </defs>
                        <circle class="fc-ring-bg" cx="100" cy="100" r="86"/>
                        <circle class="fc-ring-fg" id="fc-ring-fg" cx="100" cy="100" r="86" stroke-dasharray="540.35" stroke-dashoffset="540.35"/>
                    </svg>
                    <div class="fc-percent">
                        <div><span class="fc-percent-num" id="fc-pct">0</span><span class="fc-percent-sym">%</span></div>
                    </div>
                </div>
                <div class="fc-level" id="fc-level">&#11088; Calculating...</div>
                <p class="fc-rc-desc" id="fc-desc">Your friendship story is being decoded...</p>
                <div class="fc-watermark">cosmiccalculators.in &middot; Friendship</div>
            </div>

            <div class="fc-bars">
                <div class="fc-bar-row">
                    <div class="fc-bar-top"><span data-i18n="m_loyalty">&#128081; Loyalty</span><span id="fc-b1-v">0%</span></div>
                    <div class="fc-bar"><div class="fc-bar-fill" id="fc-b1"></div></div>
                </div>
                <div class="fc-bar-row">
                    <div class="fc-bar-top"><span data-i18n="m_fun">&#127881; Fun &amp; Laughter</span><span id="fc-b2-v">0%</span></div>
                    <div class="fc-bar"><div class="fc-bar-fill" id="fc-b2"></div></div>
                </div>
                <div class="fc-bar-row">
                    <div class="fc-bar-top"><span data-i18n="m_trust">&#129303; Trust</span><span id="fc-b3-v">0%</span></div>
                    <div class="fc-bar"><div class="fc-bar-fill" id="fc-b3"></div></div>
                </div>
                <div class="fc-bar-row">
                    <div class="fc-bar-top"><span data-i18n="m_support">&#129704; Emotional Support</span><span id="fc-b4-v">0%</span></div>
                    <div class="fc-bar"><div class="fc-bar-fill" id="fc-b4"></div></div>
                </div>
            </div>

            <!-- Predictions -->
            <div class="fc-preds">
                <div class="fc-pred"><div class="fc-pred-ic" id="fc-pe">&#128153;</div><h4 data-i18n="p_emoji">Best Emoji</h4><div class="fc-pred-val" id="fc-pev">--</div></div>
                <div class="fc-pred"><div class="fc-pred-ic">&#128188;</div><h4 data-i18n="p_career">Career Match</h4><div class="fc-pred-val" id="fc-pcv">--</div></div>
                <div class="fc-pred"><div class="fc-pred-ic">&#128062;</div><h4 data-i18n="p_pet">Best Pet</h4><div class="fc-pred-val" id="fc-ppv">--</div></div>
                <div class="fc-pred"><div class="fc-pred-ic">&#127925;</div><h4 data-i18n="p_song">Friendship Song</h4><div class="fc-pred-val" id="fc-psv">--</div></div>
                <div class="fc-pred"><div class="fc-pred-ic">&#127912;</div><h4 data-i18n="p_color">Bond Color</h4><div class="fc-pred-val" id="fc-pcolv">--</div><span class="fc-pred-swatch" id="fc-pcolsw"></span></div>
                <div class="fc-pred"><div class="fc-pred-ic">&#128197;</div><h4 data-i18n="p_day">Lucky Day</h4><div class="fc-pred-val" id="fc-pdv">--</div></div>
                <div class="fc-pred"><div class="fc-pred-ic">&#127815;</div><h4 data-i18n="p_num">Lucky Number</h4><div class="fc-pred-val" id="fc-pnv">--</div></div>
                <div class="fc-pred"><div class="fc-pred-ic">&#127757;</div><h4 data-i18n="p_mantra">Power Mantra</h4><div class="fc-pred-val" id="fc-pmv">--</div></div>
            </div>

            <div class="fc-hints">
                <h3 id="fc-hints-title">Golden Hints</h3>
                <div class="fc-hints-grid" id="fc-hints-grid"></div>
            </div>

            <div class="fc-advice">
                <h3 data-i18n="advice_h">&#129302; Personalized Friendship Advice</h3>
                <p id="fc-advice-text"></p>
                <div class="fc-tags" id="fc-tags"></div>
            </div>

            <div class="fc-share">
                <a href="#" class="fc-share-btn fc-sb-wa" id="fc-sb-wa" target="_blank" rel="noopener" data-i18n="sh_wa">&#128241; WhatsApp</a>
                <a href="#" class="fc-share-btn fc-sb-tw" id="fc-sb-tw" target="_blank" rel="noopener" data-i18n="sh_tw">&#119991; Twitter</a>
                <button type="button" class="fc-share-btn fc-sb-save" id="fc-sb-save" data-i18n="sh_save">&#128247; Save Card</button>
                <button type="button" class="fc-share-btn fc-sb-copy" id="fc-sb-copy" data-i18n="sh_copy">&#128279; Copy Link</button>
            </div>

            <button type="button" class="fc-btn fc-try" id="fc-try-btn" data-i18n="try_again">&#128260; Try Another Name</button>
        </div>
    </section>

    <section class="fc-levels">
        <div class="fc-lvl"><div class="fc-lvl-icon">&#128081;</div><h4 data-i18n="lvl1">Soul Friends</h4><div class="fc-lvl-range">90-100%</div><p class="fc-lvl-desc" data-i18n="lvl1d">Once-in-a-lifetime bond</p></div>
        <div class="fc-lvl"><div class="fc-lvl-icon">&#129505;</div><h4 data-i18n="lvl2">BFFs Forever</h4><div class="fc-lvl-range">70-89%</div><p class="fc-lvl-desc" data-i18n="lvl2d">Inseparable squad</p></div>
        <div class="fc-lvl"><div class="fc-lvl-icon">&#127881;</div><h4 data-i18n="lvl3">Squad Goals</h4><div class="fc-lvl-range">50-69%</div><p class="fc-lvl-desc" data-i18n="lvl3d">Great vibes, fun crew</p></div>
        <div class="fc-lvl"><div class="fc-lvl-icon">&#129309;</div><h4 data-i18n="lvl4">Good Pals</h4><div class="fc-lvl-range">30-49%</div><p class="fc-lvl-desc" data-i18n="lvl4d">Friendship in progress</p></div>
        <div class="fc-lvl"><div class="fc-lvl-icon">&#128075;</div><h4 data-i18n="lvl5">Casual</h4><div class="fc-lvl-range">0-29%</div><p class="fc-lvl-desc" data-i18n="lvl5d">Acquaintance vibes</p></div>
    </section>

    <section class="fc-related">
        <h2 data-i18n="related_h">Try More Cosmic Calculators</h2>
        <div class="fc-related-grid">
            <a class="fc-rt" href="#mulank"><div class="fc-rt-icon">&#128302;</div><h4 data-i18n="rt1">Mulank Calculator</h4><p data-i18n="rt1d">Find your numerology root number &amp; ruling planet</p></a>
            <a class="fc-rt" href="#crush"><div class="fc-rt-icon">&#128150;</div><h4 data-i18n="rt2">Crush Calculator</h4><p data-i18n="rt2d">Does your crush like you back? Find out now</p></a>
            <a class="fc-rt" href="#love"><div class="fc-rt-icon">&#10084;</div><h4 data-i18n="rt3">Love Calculator</h4><p data-i18n="rt3d">Test true love compatibility by name</p></a>
        </div>
    </section>

    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "SoftwareApplication",
      "name": "Friendship Calculator by Name",
      "applicationCategory": "LifestyleApplication",
      "operatingSystem": "Web",
      "inLanguage": ["en", "hi"],
      "url": "https://cosmiccalculators.in/friendship-calculator/",
      "offers": { "@type": "Offer", "price": "0", "priceCurrency": "USD" },
      "aggregateRating": { "@type": "AggregateRating", "ratingValue": "4.9", "ratingCount": "9384" }
    }
    </script>
</div>

<script>
(function(){
    'use strict';
    var FC = {
        $: function(id){ return document.getElementById(id); },
        nameA: '', nameB: '', score: 0, level: '', lang: 'en'
    };

    // === Bilingual dictionary (English + Hindi) ===
    var T = {
        en: {
            title: 'Friendship Calculator',
            sub: 'Discover the strength of your bond by name — with best emoji, career match, pet, song & golden hints.',
            tests: 'Tests Today', rating: 'Rating', free: 'Free',
            pl_a: 'Your name', pl_b: "Friend's name",
            err_empty: 'Please enter both names to continue.',
            err_short: 'Names should be at least 2 characters.',
            calc_btn: 'Calculate Friendship 🤝',
            t_private: '🔒 Private & Safe', t_instant: '⚡ Instant Result', t_free: '🏆 100% Free', t_mobile: '📱 Mobile Friendly',
            m_loyalty: '👑 Loyalty', m_fun: '🎉 Fun & Laughter', m_trust: '🤝 Trust', m_support: '🫶 Emotional Support',
            p_emoji: 'Best Emoji', p_career: 'Career Match', p_pet: 'Best Pet', p_song: 'Friendship Song',
            p_color: 'Bond Color', p_day: 'Lucky Day', p_num: 'Lucky Number', p_mantra: 'Power Mantra',
            advice_h: '🤖 Personalized Friendship Advice',
            hints_h: 'Golden Hints for',
            sh_wa: '📱 WhatsApp', sh_tw: '𝕏 Twitter', sh_save: '📷 Save Card', sh_copy: '🔗 Copy Link',
            try_again: '🔄 Try Another Name',
            lvl1: 'Soul Friends', lvl1d: 'Once-in-a-lifetime bond',
            lvl2: 'BFFs Forever', lvl2d: 'Inseparable squad',
            lvl3: 'Squad Goals',  lvl3d: 'Great vibes, fun crew',
            lvl4: 'Good Pals',    lvl4d: 'Friendship in progress',
            lvl5: 'Casual',       lvl5d: 'Acquaintance vibes',
            related_h: 'Try More Cosmic Calculators',
            rt1: 'Mulank Calculator', rt1d: 'Find your numerology root number & ruling planet',
            rt2: 'Crush Calculator',  rt2d: 'Does your crush like you back? Find out now',
            rt3: 'Love Calculator',   rt3d: 'Test true love compatibility by name',
            load: ['📝 Reading your names...', '🔬 Checking shared letters...', '✨ Calculating bond energy...', '🔮 Drawing your friendship chart...']
        },
        hi: {
            title: 'दोस्ती कैलकुलेटर',
            sub: 'नाम से अपनी दोस्ती की ताकत जानें — सबसे अच्छा इमोजी, करियर मैच, पेट, गाना और गोल्डन हिंट्स के साथ।',
            tests: 'आज के टेस्ट', rating: 'रेटिंग', free: 'मुफ़्त',
            pl_a: 'आपका नाम', pl_b: 'दोस्त का नाम',
            err_empty: 'कृपया दोनों नाम भरें।',
            err_short: 'नाम कम से कम 2 अक्षर का होना चाहिए।',
            calc_btn: 'दोस्ती निकालें 🤝',
            t_private: '🔒 निजी और सुरक्षित', t_instant: '⚡ तुरंत नतीजा', t_free: '🏆 100% मुफ़्त', t_mobile: '📱 मोबाइल फ्रेंडली',
            m_loyalty: '👑 वफ़ादारी', m_fun: '🎉 मज़ा और हँसी', m_trust: '🤝 भरोसा', m_support: '🫶 भावनात्मक सहारा',
            p_emoji: 'बेस्ट इमोजी', p_career: 'करियर मैच', p_pet: 'बेस्ट पेट', p_song: 'दोस्ती का गाना',
            p_color: 'रंग', p_day: 'लकी दिन', p_num: 'लकी नंबर', p_mantra: 'पावर मंत्र',
            advice_h: '🤖 आपकी दोस्ती के लिए सलाह',
            hints_h: 'गोल्डन हिंट्स',
            sh_wa: '📱 व्हाट्सऐप', sh_tw: '𝕏 ट्विटर', sh_save: '📷 कार्ड सेव', sh_copy: '🔗 लिंक कॉपी',
            try_again: '🔄 दूसरा नाम आज़माएँ',
            lvl1: 'आत्मा दोस्त', lvl1d: 'जीवन में एक बार मिलने वाला बंधन',
            lvl2: 'हमेशा के दोस्त', lvl2d: 'अटूट टोली',
            lvl3: 'मज़ेदार टोली', lvl3d: 'शानदार वाइब्स',
            lvl4: 'अच्छे साथी',   lvl4d: 'दोस्ती बन रही है',
            lvl5: 'जान-पहचान',    lvl5d: 'हल्की-फुल्की दोस्ती',
            related_h: 'और कॉस्मिक कैलकुलेटर आज़माएँ',
            rt1: 'मूलांक कैलकुलेटर', rt1d: 'अपना मूलांक और स्वामी ग्रह जानें',
            rt2: 'क्रश कैलकुलेटर',   rt2d: 'क्या आपका क्रश भी आपको पसंद करता है?',
            rt3: 'लव कैलकुलेटर',     rt3d: 'नाम से सच्ची मोहब्बत जाँचें',
            load: ['📝 आपके नाम पढ़े जा रहे हैं...', '🔬 साझा अक्षर जाँचे जा रहे हैं...', '✨ बंधन की ऊर्जा निकाली जा रही है...', '🔮 दोस्ती का चार्ट बन रहा है...']
        }
    };

    function applyLang(lang) {
        if (!T[lang]) return;
        FC.lang = lang;
        document.querySelectorAll('#fc-wrap [data-i18n]').forEach(function(el){
            var k = el.getAttribute('data-i18n');
            if (T[lang][k] != null) {
                if (el.tagName === 'INPUT') el.setAttribute('placeholder', T[lang][k]);
                else el.textContent = T[lang][k];
            }
        });
        // Update placeholders
        var na = FC.$('fc-name-a'), nb = FC.$('fc-name-b');
        if (na) na.placeholder = T[lang].pl_a;
        if (nb) nb.placeholder = T[lang].pl_b;
        // Toggle button active state
        document.querySelectorAll('#fc-wrap .fc-lang-btn').forEach(function(b){
            b.classList.toggle('fc-lang-active', b.getAttribute('data-lang') === lang);
        });
        // Re-render result if already showing
        if (FC.score > 0 && FC.$('fc-result').classList.contains('fc-show')) {
            renderResultContent();
        }
    }
    document.querySelectorAll('#fc-wrap .fc-lang-btn').forEach(function(btn){
        btn.addEventListener('click', function(){ applyLang(btn.getAttribute('data-lang')); });
    });

    var elInputPhase = FC.$('fc-input-phase');
    var elLoading    = FC.$('fc-loading');
    var elResult     = FC.$('fc-result');
    var elNameA      = FC.$('fc-name-a');
    var elNameB      = FC.$('fc-name-b');
    var elAvA        = FC.$('fc-av-a');
    var elAvB        = FC.$('fc-av-b');
    var elError      = FC.$('fc-error');
    var elCalcBtn    = FC.$('fc-calc-btn');

    function escapeHtml(s) {
        return String(s).replace(/[&<>"']/g, function(c){
            return ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'})[c];
        });
    }

    function updateAvatar(input, av) {
        var v = (input.value || '').trim();
        av.textContent = v ? v.charAt(0).toUpperCase() : '?';
    }
    elNameA.addEventListener('input', function(){ updateAvatar(elNameA, elAvA); elError.classList.remove('fc-show'); });
    elNameB.addEventListener('input', function(){ updateAvatar(elNameB, elAvB); elError.classList.remove('fc-show'); });

    function seedFor(s) {
        var x = 0;
        for (var i=0; i<s.length; i++) { x = ((x << 5) - x + s.charCodeAt(i)) | 0; }
        return Math.abs(x);
    }

    // Deterministic friendship score
    function calcFriendship(n1, n2) {
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

        var seed = seedFor(a + '|' + b);
        var rand = Math.abs(Math.sin(seed)) * 30;

        var raw = (overlapScore * 0.42) + (numScore * 0.22) + (lenScore * 0.18) + (rand * 0.6);
        var score = Math.round(raw);
        if (score < 14) score = 14 + (seed % 16);
        if (score > 99) score = 99;
        return score;
    }

    function calcMetrics(n1, n2, score) {
        var a = (n1 || '').toLowerCase().replace(/[^a-z]/g,'');
        var b = (n2 || '').toLowerCase().replace(/[^a-z]/g,'');
        var seed = seedFor(a + b);
        function vary(off) {
            var r = Math.abs(Math.sin(seed + off * 7.31)) * 22 - 11;
            var v = Math.round(score + r);
            return Math.max(18, Math.min(99, v));
        }
        return { loyalty: vary(1), fun: vary(2), trust: vary(3), support: vary(4) };
    }

    var LEVEL_NAMES = {
        en: ['Soul Friends','BFFs Forever','Squad Goals','Good Pals','Casual Friends'],
        hi: ['आत्मा दोस्त','हमेशा के दोस्त','मज़ेदार टोली','अच्छे साथी','जान-पहचान']
    };
    function getLevel(score, lang) {
        lang = lang || FC.lang;
        var L = LEVEL_NAMES[lang] || LEVEL_NAMES.en;
        if (score >= 90) return { emoji: '👑', name: L[0], color: '#F59E0B' };
        if (score >= 70) return { emoji: '🦅', name: L[1], color: '#BE185D' };
        if (score >= 50) return { emoji: '🎉', name: L[2], color: '#7C3AED' };
        if (score >= 30) return { emoji: '🤝', name: L[3], color: '#2563EB' };
        return { emoji: '👋', name: L[4], color: '#14B8A6' };
    }

    function getDescription(score, n1, n2, lang) {
        lang = lang || FC.lang;
        if (lang === 'hi') {
            if (score >= 90) return n1 + ' और ' + n2 + ', यह दोस्ती सितारों ने सुनहरी स्याही से लिखी है। ऐसा बंधन बहुत कम मिलता है — दूरी, समय और बदलाव सब झेल लेता है। इसे सहेज कर रखें।';
            if (score >= 70) return n1 + ' और ' + n2 + ', आप दोनों सच्ची दोस्ती का जीता-जागता उदाहरण हैं। वफ़ादारी गहरी है, मज़ाक कभी पुराने नहीं होते, और भरोसा अटूट है। एक-दूसरे के लिए हमेशा खड़े रहें।';
            if (score >= 50) return n1 + ' और ' + n2 + ', आपकी टोली में अच्छी ऊर्जा है। सच्चा जुड़ाव, खूब हँसी और अच्छे पल — साथ थोड़ा और समय और ईमानदारी से यह दोस्ती बहुत बड़ी बन सकती है।';
            if (score >= 30) return n1 + ' और ' + n2 + ', बुनियाद तैयार है — अब इस पर बनाना है। असली दोस्ती के लिए लगातार कोशिश, गहरी बातचीत और छोटी अच्छाइयाँ चाहिए।';
            return n1 + ' और ' + n2 + ', हर बड़ी दोस्ती कहीं न कहीं से शुरू होती है। अभी हल्की-फुल्की दोस्ती है, और यह बिल्कुल सही है। थोड़ा वक्त दें, कुछ यादें बनाएँ, और देखें यह कहाँ ले जाती है।';
        }
        if (score >= 90) return n1 + ' & ' + n2 + ', this is a friendship the stars wrote with gold ink. A bond like yours is rare — it survives distance, time, and growing up. Protect it, celebrate it, and never take a single shared laugh for granted.';
        if (score >= 70) return n1 + ' & ' + n2 + ', you two are the textbook definition of best friends. Loyalty runs deep, jokes never get old, and the trust is unshakeable. Keep showing up for each other — the world is better with friendships like yours.';
        if (score >= 50) return n1 + ' & ' + n2 + ', your squad energy is real. There is genuine connection, lots of laughs, and shared good times. With a bit more honesty and time together, this friendship can level up to legendary status.';
        if (score >= 30) return n1 + ' & ' + n2 + ', the foundation is there — now build on it. Real friendships need consistent effort, deeper conversations, and small acts of kindness. Show up when it counts, and watch the bond grow stronger fast.';
        return n1 + ' & ' + n2 + ', every great friendship starts somewhere. The vibe is light right now, and that is perfectly okay. Be curious about each other, make a few shared memories, and let the connection take its natural shape.';
    }

    var EMOJI_POOL = ['🤝','💛','🌟','🔥','🦅','👑','🎉','🌈','💫','✨','🎯','🍀','🌸','💜','💚','🧡'];

    var POOLS = {
        en: {
            CAREERS: ['Co-founders of a creative startup','Travel vloggers and content duo','Stand-up comedy partners','Music producers and songwriters','Restaurant owners and chefs','Fashion designers and stylists','Tech engineers and product builders','Doctors running a wellness clinic','Teachers running a learning academy','Photographers and filmmakers','Authors writing a bestselling series','Sports coaches and athletes','Wedding planners and event stylists','YouTubers running a hit channel','Architects building dream homes','Game developers shipping indie hits'],
            PETS: ['Golden Retriever 🐕','Indie cat 🐈','Talkative parrot 🦜','Mini rabbit 🐇','Hamster duo 🐹','Beta fish 🐠','Tiny turtle 🐢','Husky pup 🐶','Persian cat 🐱','Lovebird 🐦','Pug squad 🐕','Hedgehog 🦔'],
            SONGS: ['"Count On Me" — Bruno Mars','"You’ve Got A Friend In Me" — Randy Newman','"Lean On Me" — Bill Withers','"That’s What Friends Are For" — Dionne Warwick','"Yaaron" — KK','"Yeh Dosti" — Sholay','"Tere Jaisa Yaar Kahan" — Kishore Kumar','"Best Day Of My Life" — American Authors','"Friends" — Marshmello & Anne-Marie','"We’re Going To Be Friends" — White Stripes','"Good Times" — Sam Cooke','"Bro Code Anthem" — Indie Mix'],
            COLORS: [{name:'Royal Purple',hex:'#7C3AED'},{name:'Cosmic Gold',hex:'#F59E0B'},{name:'Sunset Coral',hex:'#FB7185'},{name:'Emerald',hex:'#10B981'},{name:'Sky Blue',hex:'#3B82F6'},{name:'Magenta Pink',hex:'#BE185D'},{name:'Teal',hex:'#14B8A6'},{name:'Lavender',hex:'#A78BFA'}],
            DAYS: ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'],
            MANTRAS: ['"Real friends grow apart and back together — always."','"Loyalty over likes, always."','"One real friend is louder than a hundred fake ones."','"Distance is just a test of true friendship."','"The best therapy is a long talk with a real friend."','"Friendship is when silence feels like home."','"A friend who laughs with you also fights for you."','"Shared memories are the richest currency."']
        },
        hi: {
            CAREERS: ['क्रिएटिव स्टार्टअप के सह-संस्थापक','ट्रैवल व्लॉगर्स और कंटेंट जोड़ी','स्टैंड-अप कॉमेडी पार्टनर','म्यूज़िक प्रोड्यूसर और गीतकार','रेस्तरां मालिक और शेफ','फ़ैशन डिज़ाइनर और स्टाइलिस्ट','टेक इंजीनियर और प्रोडक्ट बिल्डर','वेलनेस क्लिनिक चलाने वाले डॉक्टर','लर्निंग अकैडमी चलाने वाले शिक्षक','फ़ोटोग्राफ़र और फ़िल्म-निर्माता','बेस्टसेलर सीरीज़ लिखने वाले लेखक','स्पोर्ट्स कोच और एथलीट','वेडिंग प्लानर और इवेंट स्टाइलिस्ट','हिट चैनल चलाने वाले YouTuber','सपनों के घर बनाने वाले आर्किटेक्ट','इंडी गेम डेवलपर'],
            PETS: ['गोल्डन रिट्रीवर 🐕','इंडी बिल्ली 🐈','बातूनी तोता 🦜','छोटा खरगोश 🐇','हम्सटर जोड़ी 🐹','बेटा मछली 🐠','छोटा कछुआ 🐢','हस्की पिल्ला 🐶','फ़ारसी बिल्ली 🐱','लवबर्ड 🐦','पग स्क्वॉड 🐕','हेजहोग 🦔'],
            SONGS: ['"यारों" — KK','"ये दोस्ती" — शोले','"तेरे जैसा यार कहाँ" — किशोर कुमार','"दिल चाहता है" — टाइटल सॉन्ग','"चड्डी बुड्ढी" — जाने तू या जाने ना','"Count On Me" — Bruno Mars','"Lean On Me" — Bill Withers','"Friends" — Marshmello & Anne-Marie','"Perfect" — Ed Sheeran','"वो लड़की है कहाँ" — दिल चाहता है','"मैं हूँ ना" — टाइटल','"पल" — Jubin Nautiyal'],
            COLORS: [{name:'राजसी बैंगनी',hex:'#7C3AED'},{name:'कॉस्मिक सुनहरा',hex:'#F59E0B'},{name:'सूर्यास्त गुलाबी',hex:'#FB7185'},{name:'पन्ना हरा',hex:'#10B981'},{name:'आसमानी',hex:'#3B82F6'},{name:'मैजेंटा',hex:'#BE185D'},{name:'टील',hex:'#14B8A6'},{name:'लैवेंडर',hex:'#A78BFA'}],
            DAYS: ['रविवार','सोमवार','मंगलवार','बुधवार','गुरुवार','शुक्रवार','शनिवार'],
            MANTRAS: ['"सच्चे दोस्त दूर जाकर भी हमेशा वापस आते हैं।"','"लाइक्स से नहीं, वफ़ादारी से दोस्ती चलती है।"','"एक सच्चा दोस्त सौ झूठों से बेहतर है।"','"दूरी सच्ची दोस्ती का इम्तिहान है।"','"सबसे अच्छी थैरेपी है सच्चे दोस्त से लंबी बात।"','"दोस्ती तब है जब चुप्पी भी घर लगे।"','"जो हँसी में साथ है, वही लड़ाई में भी।"','"साझा यादें सबसे क़ीमती धन हैं।"']
        }
    };

    var HINTS_DATA = {
        en: {
            high: [
                { i: '📞', t: 'Stay In Touch', d: 'Drop a voice note this week — small check-ins keep big friendships alive.' },
                { i: '🍴', t: 'Plan A Hangout', d: 'Schedule a meet-up this month. Nothing beats real laughs over real food.' },
                { i: '🏆', t: 'Celebrate Wins', d: 'Hype each other’s achievements — even tiny ones. Hype is loyalty.' },
                { i: '🗝', t: 'Keep Secrets Safe', d: 'Whatever is told in trust stays in trust. Always.' }
            ],
            mid: [
                { i: '💬', t: 'Real Conversations', d: 'Skip the small talk this week. Ask one deep question and listen.' },
                { i: '🤝', t: 'Show Up', d: 'Be the one who replies, remembers, and shows up. That builds friendships fast.' },
                { i: '🎮', t: 'Shared Hobby', d: 'Pick one thing you can both do together — game, gym, walks, reading.' },
                { i: '🔓', t: 'Be Honest', d: 'Speak your truth kindly. Friendships built on lies always break.' }
            ],
            low: [
                { i: '🌱', t: 'Give It Time', d: 'Some friendships need a few seasons to bloom. Be patient and curious.' },
                { i: '👋', t: 'Make The First Move', d: 'Send a meme. Drop a hi. Friendship often starts with one small message.' },
                { i: '📍', t: 'Find Common Ground', d: 'Find one thing you both genuinely enjoy and start there.' },
                { i: '✨', t: 'Be Yourself', d: 'The right friends will love your real version, not your filtered one.' }
            ]
        },
        hi: {
            high: [
                { i: '📞', t: 'संपर्क में रहें', d: 'इस हफ़्ते एक वॉइस नोट भेजें — छोटे हाल-चाल बड़ी दोस्ती बचाते हैं।' },
                { i: '🍴', t: 'मिलने की योजना', d: 'इस महीने एक मुलाक़ात तय करें। असली खाने के साथ असली हँसी बेमिसाल है।' },
                { i: '🏆', t: 'जीत मनाएँ', d: 'एक-दूसरे की छोटी-बड़ी जीत में साथ खुश हों। यही असली वफ़ादारी है।' },
                { i: '🗝', t: 'राज़ सुरक्षित रखें', d: 'जो भरोसे में कहा गया, वह भरोसे में ही रहे — हमेशा।' }
            ],
            mid: [
                { i: '💬', t: 'गहरी बात करें', d: 'इस हफ़्ते छोटी-मोटी बातें छोड़ें। एक गहरा सवाल पूछें और सुनें।' },
                { i: '🤝', t: 'सामने आएँ', d: 'वो दोस्त बनें जो जवाब देता है, याद रखता है, और मौक़े पर खड़ा है।' },
                { i: '🎮', t: 'साझा शौक़', d: 'एक चीज़ चुनें जो दोनों मिलकर करें — खेल, जिम, सैर, किताबें।' },
                { i: '🔓', t: 'ईमानदार बनें', d: 'अपनी सच्चाई नर्मी से कहें। झूठ पर खड़ी दोस्ती टूट जाती है।' }
            ],
            low: [
                { i: '🌱', t: 'समय दें', d: 'कुछ दोस्तियाँ खिलने में मौसम लेती हैं। धीरज और जिज्ञासा रखें।' },
                { i: '👋', t: 'पहला क़दम', d: 'एक मीम भेजें। एक "हाय" लिखें। दोस्ती अक्सर एक छोटे संदेश से शुरू होती है।' },
                { i: '📍', t: 'साझा शुरुआत', d: 'एक चीज़ ढूँढें जो दोनों को पसंद हो और वहीं से शुरू करें।' },
                { i: '✨', t: 'अपने जैसे बनें', d: 'सही दोस्त आपका असली रूप पसंद करते हैं, फ़िल्टर वाला नहीं।' }
            ]
        }
    };
    function getHints(score, n1, n2, lang) {
        lang = lang || FC.lang;
        var H = HINTS_DATA[lang] || HINTS_DATA.en;
        if (score >= 70) return H.high;
        if (score >= 40) return H.mid;
        return H.low;
    }

    function getAdvice(score, n1, n2, lang) {
        lang = lang || FC.lang;
        if (lang === 'hi') {
            if (score >= 70) return {
                text: n1 + ' और ' + n2 + ', आपकी दोस्ती वो सुरक्षित जगह है जिसकी दुनिया को ज़रूरत है। मुश्किल दिनों में भी एक-दूसरे को चुनते रहें। यही दोस्ती को महान बनाता है।',
                tags: ['वफ़ादार टोली','हमेशा का बंधन','गहरा भरोसा','जान-छिड़कने वाले']
            };
            if (score >= 40) return {
                text: n1 + ' और ' + n2 + ', चिंगारी असली है — अब इसे पालें। इस महीने एक फ़ोन-फ्री मुलाक़ात रखें, बेहतर सवाल पूछें, और वही दोस्त बनें जिसकी आपको ज़रूरत है।',
                tags: ['बढ़ता बंधन','बनाने लायक़','ईमानदार वाइब्स','भविष्य की टोली']
            };
            return {
                text: n1 + ' और ' + n2 + ', हर रिश्ता हमेशा की दोस्ती नहीं बनता — और यह ठीक है। खुले मन से रहें, दयालु बनें, और दोस्ती को अपना आकार लेने दें।',
                tags: ['नई शुरुआत','धीरे चलें','नई ऊर्जा','खुला दिल']
            };
        }
        if (score >= 70) return {
            text: n1 + ' & ' + n2 + ', your friendship is the kind of safe space the world needs more of. Keep choosing each other, especially on tough days. Send the random check-in. Remember the little dates. And when life gets noisy — show up. That is what makes a friendship legendary.',
            tags: ['Loyal Squad','Forever Bond','Deep Trust','Ride-Or-Die']
        };
        if (score >= 40) return {
            text: n1 + ' & ' + n2 + ', the spark is real — now feed it. Plan one phone-free hangout this month, ask better questions, and be the friend you wish you had. Friendships are not found, they are built one honest moment at a time.',
            tags: ['Growing Bond','Worth Building','Honest Vibes','Future Crew']
        };
        return {
            text: n1 + ' & ' + n2 + ', not every connection becomes a forever friendship — and that is okay. Some people are seasons, some are chapters, and a few are forever. Be open, be kind, and let the friendship reveal what it wants to be.',
            tags: ['Fresh Start','Take It Slow','New Energy','Open Heart']
        };
    }

    function pickFromList(seed, list) { return list[seed % list.length]; }

    function buildPredictions(n1, n2, score, lang) {
        lang = lang || FC.lang;
        var P = POOLS[lang] || POOLS.en;
        var seed = seedFor(n1 + '#' + n2);
        return {
            emoji:  pickFromList(seed, EMOJI_POOL),
            career: pickFromList(seed >> 1, P.CAREERS),
            pet:    pickFromList(seed >> 2, P.PETS),
            song:   pickFromList(seed >> 3, P.SONGS),
            color:  pickFromList(seed >> 4, P.COLORS),
            day:    pickFromList(seed >> 5, P.DAYS),
            lucky:  ((seed >> 6) % 9) + 1,
            mantra: pickFromList(seed >> 7, P.MANTRAS)
        };
    }

    function getLoadSteps(lang) { return (T[lang] && T[lang].load) || T.en.load; }

    function runLoading(callback) {
        var stepEl = FC.$('fc-load-step');
        var barEl  = FC.$('fc-progress-bar');
        var steps = getLoadSteps(FC.lang);
        var i = 0;
        stepEl.textContent = steps[0];
        barEl.style.width = '8%';

        var interval = setInterval(function(){
            i++;
            steps = getLoadSteps(FC.lang); // pick up lang changes mid-flight
            if (i < steps.length) {
                stepEl.style.opacity = '0';
                setTimeout(function(){
                    stepEl.textContent = steps[i];
                    stepEl.style.opacity = '1';
                }, 200);
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
        var colors = ['#4C1D95','#BE185D','#F59E0B','#F472B6','#fff'];
        var box = document.createElement('div');
        box.className = 'fc-confetti';
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

    function renderResultContent() {
        var n1 = FC.nameA, n2 = FC.nameB;
        var score = FC.score;
        if (!score || !n1 || !n2) return;
        var lang = FC.lang;
        var level = getLevel(score, lang);
        var desc = getDescription(score, n1, n2, lang);
        var hints = getHints(score, n1, n2, lang);
        var advice = getAdvice(score, n1, n2, lang);
        var preds = buildPredictions(n1, n2, score, lang);

        FC.level = level.name;
        FC.$('fc-rc-n-a').textContent = n1;
        FC.$('fc-rc-n-b').textContent = n2;
        FC.$('fc-rc-av-a').textContent = n1.charAt(0).toUpperCase();
        FC.$('fc-rc-av-b').textContent = n2.charAt(0).toUpperCase();
        FC.$('fc-level').textContent = level.emoji + ' ' + level.name;
        FC.$('fc-desc').textContent  = desc;

        FC.$('fc-pe').textContent  = preds.emoji;
        FC.$('fc-pev').textContent = preds.emoji + '  ' + level.name;
        FC.$('fc-pcv').textContent = preds.career;
        FC.$('fc-ppv').textContent = preds.pet;
        FC.$('fc-psv').textContent = preds.song;
        FC.$('fc-pcolv').textContent = preds.color.name;
        FC.$('fc-pcolsw').style.background = preds.color.hex;
        FC.$('fc-pdv').textContent = preds.day;
        FC.$('fc-pnv').textContent = preds.lucky;
        FC.$('fc-pmv').textContent = preds.mantra;

        var hintsLabel = (T[lang] && T[lang].hints_h) || 'Golden Hints for';
        FC.$('fc-hints-title').innerHTML = '⭐ ' + escapeHtml(hintsLabel) + ' ' + escapeHtml(n1) + ' &amp; ' + escapeHtml(n2);
        var grid = FC.$('fc-hints-grid');
        grid.innerHTML = '';
        for (var hi=0; hi<hints.length; hi++) {
            var h = hints[hi];
            var card = document.createElement('div');
            card.className = 'fc-hint';
            card.style.borderLeftColor = level.color;
            card.style.animationDelay = (hi * 0.1) + 's';
            card.innerHTML = '<div class="fc-hint-icon">' + h.i + '</div><h4>' + escapeHtml(h.t) + '</h4><p>' + escapeHtml(h.d) + '</p>';
            grid.appendChild(card);
        }

        FC.$('fc-advice-text').textContent = advice.text;
        var tagsBox = FC.$('fc-tags');
        tagsBox.innerHTML = '';
        for (var ti=0; ti<advice.tags.length; ti++) {
            var tag = document.createElement('span');
            tag.className = 'fc-tag fc-t' + ((ti % 4) + 1);
            tag.textContent = advice.tags[ti];
            tagsBox.appendChild(tag);
        }

        setupShare(n1, n2, score, level.name);
    }

    function showResult() {
        var n1 = FC.nameA, n2 = FC.nameB;
        var score = calcFriendship(n1, n2);
        var metrics = calcMetrics(n1, n2, score);
        FC.score = score;

        elLoading.classList.remove('fc-show');
        elLoading.style.display = 'none';
        elResult.classList.add('fc-show');

        renderResultContent();

        animateNum(FC.$('fc-pct'), 0, score, 1800);

        var circ = 2 * Math.PI * 86;
        var ring = FC.$('fc-ring-fg');
        setTimeout(function(){ ring.style.strokeDashoffset = circ - (circ * score / 100); }, 80);

        setTimeout(function(){
            FC.$('fc-b1').style.width = metrics.loyalty + '%';
            FC.$('fc-b2').style.width = metrics.fun + '%';
            FC.$('fc-b3').style.width = metrics.trust + '%';
            FC.$('fc-b4').style.width = metrics.support + '%';
            FC.$('fc-b1-v').textContent = metrics.loyalty + '%';
            FC.$('fc-b2-v').textContent = metrics.fun + '%';
            FC.$('fc-b3-v').textContent = metrics.trust + '%';
            FC.$('fc-b4-v').textContent = metrics.support + '%';
        }, 220);

        var predEls = document.querySelectorAll('#fc-wrap .fc-pred');
        for (var pi=0; pi<predEls.length; pi++) predEls[pi].style.animationDelay = (pi * 0.07) + 's';

        if (score >= 70) setTimeout(confetti, 600);

        setTimeout(function(){ elResult.scrollIntoView({ behavior: 'smooth', block: 'start' }); }, 100);
    }

    function setupShare(n1, n2, score, level) {
        var url = window.location.href;
        var msg = '🤝 Friendship Calculator Result!\n\n' + n1 + ' + ' + n2 + ' = *' + score + '% Friendship*\nBond: *' + level + '*\n\nTest yours: ' + url;
        var tweet = n1 + ' + ' + n2 + ' = ' + score + '% Friendship 🤝 (' + level + ')! Test yours:';

        FC.$('fc-sb-wa').href = 'https://wa.me/?text=' + encodeURIComponent(msg);
        FC.$('fc-sb-tw').href = 'https://twitter.com/intent/tweet?text=' + encodeURIComponent(tweet) + '&url=' + encodeURIComponent(url);

        FC.$('fc-sb-copy').onclick = function(){
            var btn = this; var orig = btn.innerHTML;
            try {
                if (navigator.clipboard) {
                    navigator.clipboard.writeText(url).then(function(){
                        btn.innerHTML = '✅ Copied!';
                        setTimeout(function(){ btn.innerHTML = orig; }, 1800);
                    });
                } else {
                    var ta = document.createElement('textarea');
                    ta.value = url; document.body.appendChild(ta); ta.select();
                    document.execCommand('copy'); ta.remove();
                    btn.innerHTML = '✅ Copied!';
                    setTimeout(function(){ btn.innerHTML = orig; }, 1800);
                }
            } catch(e) {
                btn.innerHTML = '⚠ Try Manually';
                setTimeout(function(){ btn.innerHTML = orig; }, 1800);
            }
        };

        FC.$('fc-sb-save').onclick = function(){
            var btn = this; var orig = btn.innerHTML;
            btn.innerHTML = '📸 Saving...';
            setTimeout(function(){
                if (navigator.share) {
                    navigator.share({ title: 'Friendship Calculator Result', text: msg, url: url }).then(function(){ btn.innerHTML = orig; }).catch(function(){
                        alert('Take a screenshot to save it!\n\n' + n1 + ' + ' + n2 + ' = ' + score + '% Friendship');
                        btn.innerHTML = orig;
                    });
                } else {
                    alert('Take a screenshot to save it!\n\n' + n1 + ' + ' + n2 + ' = ' + score + '% Friendship\n' + level);
                    btn.innerHTML = orig;
                }
            }, 400);
        };
    }

    elCalcBtn.addEventListener('click', function(){
        var n1 = (elNameA.value || '').trim();
        var n2 = (elNameB.value || '').trim();
        var tt = T[FC.lang] || T.en;
        if (!n1 || !n2) { elError.textContent = tt.err_empty; elError.classList.add('fc-show'); return; }
        if (n1.length < 2 || n2.length < 2) {
            elError.textContent = tt.err_short;
            elError.classList.add('fc-show'); return;
        }
        elError.classList.remove('fc-show');
        elError.textContent = tt.err_empty;
        FC.nameA = n1; FC.nameB = n2;
        elInputPhase.style.display = 'none';
        elLoading.style.display = 'block';
        elLoading.classList.add('fc-show');
        FC.$('fc-load-names').textContent = n1 + ' 🤝 ' + n2;
        FC.$('fc-progress-bar').style.width = '0%';
        runLoading(showResult);
    });

    [elNameA, elNameB].forEach(function(el){
        el.addEventListener('keydown', function(e){ if (e.key === 'Enter') { e.preventDefault(); elCalcBtn.click(); } });
    });

    FC.$('fc-try-btn').addEventListener('click', function(){
        elResult.classList.remove('fc-show');
        elLoading.classList.remove('fc-show'); elLoading.style.display = 'none';
        elInputPhase.style.display = 'block';
        elNameA.value = ''; elNameB.value = '';
        elAvA.textContent = '?'; elAvB.textContent = '?';
        FC.$('fc-pct').textContent = '0';
        FC.$('fc-ring-fg').style.strokeDashoffset = 540.35;
        ['fc-b1','fc-b2','fc-b3','fc-b4'].forEach(function(id){ FC.$(id).style.width = '0%'; });
        elInputPhase.scrollIntoView({ behavior: 'smooth', block: 'start' });
        setTimeout(function(){ elNameA.focus(); }, 400);
    });

    var counterEl = FC.$('fc-counter');
    var count = 276481;
    setInterval(function(){
        count += 1 + Math.floor(Math.random()*3);
        counterEl.textContent = count.toLocaleString('en-IN');
    }, 8000);

    // Auto-detect browser language on first load
    try {
        var lg = (navigator.language || navigator.userLanguage || 'en').toLowerCase();
        if (lg.indexOf('hi') === 0) applyLang('hi'); else applyLang('en');
    } catch (e) { applyLang('en'); }
})();
</script>
    <?php
    return ob_get_clean();
}

}
