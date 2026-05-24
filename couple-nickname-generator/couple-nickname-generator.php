<?php
/**
 * Plugin Name: Couple Nickname Generator
 * Plugin URI: https://lovecalculator.in
 * Description: Premium Couple Nickname Generator that blends two names into ship names, cute pet names, stylish combos and romantic nicknames &mdash; each with a vibe label and one-tap copy. Use shortcode [couple_nickname_generator].
 * Version: 1.0.0
 * Author: lovecalculator.in
 * Author URI: https://lovecalculator.in
 * License: GPL-2.0+
 * Text Domain: couple-nickname-generator
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! function_exists( 'cn_pro_render_generator' ) ) {

    function cn_pro_render_generator( $atts = array() ) {
        ob_start();
        ?>
<div class="cn-wrap" id="cn-wrap">
    <style>
        .cn-wrap, .cn-wrap *, .cn-wrap *::before, .cn-wrap *::after { box-sizing: border-box; }
        .cn-wrap { font-family: 'DM Sans', 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; color: #1f1933; max-width: 880px; margin: 0 auto; padding: 12px; line-height: 1.55; }
        .cn-wrap h1, .cn-wrap h2, .cn-wrap h3, .cn-wrap h4 { font-family: 'Poppins', 'Syne', system-ui, sans-serif; font-weight: 800; letter-spacing: -0.01em; margin: 0; }

        /* Header */
        .cn-header { background: linear-gradient(135deg, #1a0533 0%, #3d0b55 50%, #690d3a 100%); border-radius: 22px; padding: 28px 20px; color: #fff; text-align: center; box-shadow: 0 20px 60px rgba(105, 13, 58, 0.25); position: relative; overflow: hidden; }
        .cn-header::before { content: ""; position: absolute; inset: -50%; background: radial-gradient(circle at 30% 20%, rgba(230,57,70,0.18), transparent 60%), radial-gradient(circle at 70% 80%, rgba(123,45,139,0.25), transparent 60%); pointer-events: none; }
        .cn-header-icon { font-size: 50px; line-height: 1; display: inline-block; animation: cn-bob 2.4s ease-in-out infinite; }
        .cn-header h1 { font-size: 36px; margin: 8px 0 6px; color: #fff; }
        .cn-header-sub { opacity: 0.86; font-size: 15px; margin: 0; }
        .cn-stats { display: flex; align-items: center; justify-content: center; gap: 0; margin-top: 18px; flex-wrap: wrap; }
        .cn-stat { padding: 4px 14px; min-width: 96px; }
        .cn-stat-num { font-weight: 800; font-family: 'Poppins', sans-serif; font-size: 18px; color: #fff; }
        .cn-stat-lbl { font-size: 11px; opacity: 0.78; text-transform: uppercase; letter-spacing: 0.06em; }
        .cn-stat + .cn-stat { border-left: 1px solid rgba(255,255,255,0.22); }

        /* Card shell */
        .cn-card { background: #fff; border-radius: 22px; padding: 24px 20px; margin-top: 18px; box-shadow: 0 20px 60px rgba(0,0,0,0.08); border: 1px solid #f1ecf6; }

        /* Inputs */
        .cn-inputs { display: grid; grid-template-columns: 1fr auto 1fr; gap: 14px; align-items: center; }
        .cn-field { display: flex; flex-direction: column; align-items: center; gap: 10px; }
        .cn-avatar { width: 64px; height: 64px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-family: 'Poppins', sans-serif; font-weight: 800; font-size: 26px; color: #fff; box-shadow: 0 8px 24px rgba(0,0,0,0.18); transition: transform .25s ease; }
        .cn-avatar.cn-a { background: linear-gradient(135deg, #E63946, #ff6b9d); }
        .cn-avatar.cn-b { background: linear-gradient(135deg, #7B2D8B, #b558d6); }
        .cn-avatar:hover { transform: scale(1.04); }
        .cn-input { width: 100%; min-height: 52px; padding: 12px 14px; font-size: 16px; border: 2px solid #ece6f3; border-radius: 14px; outline: none; background: #faf8fd; transition: border-color .2s, background .2s, box-shadow .2s; font-family: inherit; text-align: center; }
        .cn-input:focus { border-color: #E63946; background: #fff; box-shadow: 0 0 0 4px rgba(230,57,70,0.12); }
        .cn-vs { width: 56px; height: 56px; border-radius: 50%; background: linear-gradient(135deg, #E63946, #7B2D8B); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 22px; font-weight: 800; font-family: 'Poppins', sans-serif; box-shadow: 0 10px 24px rgba(230,57,70,0.35); animation: cn-pulse 1.6s ease-in-out infinite; }
        .cn-btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; min-height: 56px; padding: 18px 22px; font-size: 17px; font-weight: 700; font-family: 'Poppins', sans-serif; border: none; border-radius: 14px; cursor: pointer; width: 100%; transition: transform .15s ease, box-shadow .2s ease, opacity .2s; }
        .cn-btn-primary { background: linear-gradient(135deg, #E63946, #c81e2c); color: #fff; box-shadow: 0 14px 32px rgba(230,57,70,0.35); margin-top: 18px; }
        .cn-btn-primary:hover { transform: translateY(-2px); box-shadow: 0 18px 40px rgba(230,57,70,0.45); }
        .cn-btn-primary:active { transform: translateY(0); }
        .cn-trust { display: flex; gap: 10px; justify-content: center; flex-wrap: wrap; margin-top: 14px; }
        .cn-trust span { font-size: 12.5px; color: #5b5070; background: #f6f0fb; padding: 6px 12px; border-radius: 999px; min-height: 30px; display: inline-flex; align-items: center; }
        .cn-error { display: none; background: #fff1f2; color: #b3162a; border: 1px solid #ffd6db; padding: 10px 14px; border-radius: 12px; margin-top: 12px; font-size: 14px; text-align: center; }
        .cn-error.cn-show { display: block; animation: cn-shake .4s; }

        /* Loading */
        .cn-loading { display: none; text-align: center; padding: 14px 8px 6px; }
        .cn-loading.cn-show { display: block; }
        .cn-rings { position: relative; width: 150px; height: 150px; margin: 6px auto 18px; }
        .cn-ring { position: absolute; inset: 0; border-radius: 50%; border: 3px solid rgba(230,57,70,0.35); animation: cn-ring 2s ease-out infinite; }
        .cn-ring:nth-child(2) { animation-delay: .5s; border-color: rgba(123,45,139,0.4); }
        .cn-ring:nth-child(3) { animation-delay: 1s; border-color: rgba(255,107,157,0.45); }
        .cn-ring-heart { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; font-size: 54px; animation: cn-pulse 1.2s ease-in-out infinite; }
        .cn-load-names { font-size: 18px; font-weight: 700; font-family: 'Poppins', sans-serif; color: #3d0b55; margin-bottom: 12px; }
        .cn-load-step { font-size: 15px; color: #6b5e85; min-height: 24px; transition: opacity .25s; }
        .cn-progress { height: 8px; background: #f1ebf7; border-radius: 999px; overflow: hidden; margin: 14px auto 4px; max-width: 360px; }
        .cn-progress-bar { height: 100%; width: 0%; background: linear-gradient(90deg, #E63946, #7B2D8B); border-radius: 999px; transition: width .3s ease; }

        /* Result */
        .cn-result { display: none; }
        .cn-result.cn-show { display: block; animation: cn-fadeUp .55s ease both; }
        .cn-result-head { background: linear-gradient(135deg, #1a0533, #3d0b55, #690d3a); color: #fff; border-radius: 22px; padding: 24px 20px; text-align: center; box-shadow: 0 20px 60px rgba(0,0,0,0.25); position: relative; overflow: hidden; }
        .cn-result-head::after { content: ""; position: absolute; inset: 0; background: radial-gradient(circle at 20% 10%, rgba(230,57,70,0.25), transparent 50%), radial-gradient(circle at 80% 90%, rgba(255,107,157,0.18), transparent 55%); pointer-events: none; }
        .cn-rh-names { display: flex; align-items: center; justify-content: center; gap: 12px; flex-wrap: wrap; position: relative; z-index: 1; }
        .cn-rh-name { display: flex; align-items: center; gap: 10px; font-weight: 700; font-family: 'Poppins', sans-serif; font-size: 17px; }
        .cn-rh-name .cn-avatar { width: 42px; height: 42px; font-size: 17px; }
        .cn-rh-heart { font-size: 22px; opacity: 0.85; }
        .cn-rh-title { font-size: 22px; margin-top: 12px; position: relative; z-index: 1; }
        .cn-rh-sub { opacity: 0.85; font-size: 14px; margin-top: 4px; position: relative; z-index: 1; }
        .cn-top-pick { display: inline-flex; align-items: center; gap: 10px; background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.22); border-radius: 16px; padding: 12px 20px; margin-top: 14px; position: relative; z-index: 1; }
        .cn-top-pick .cn-tp-name { font-family: 'Poppins', sans-serif; font-weight: 800; font-size: 26px; background: linear-gradient(90deg, #ffd1dc, #fbbf24); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent; }

        /* Category sections */
        .cn-cat { background: #fff; border-radius: 18px; padding: 18px; margin-top: 16px; box-shadow: 0 12px 30px rgba(0,0,0,0.06); border: 1px solid #f1ecf6; border-top: 4px solid #E63946; }
        .cn-cat:nth-of-type(1) { border-top-color: #E63946; }
        .cn-cat-head { display: flex; align-items: center; gap: 10px; margin-bottom: 12px; }
        .cn-cat-icon { font-size: 24px; }
        .cn-cat-title { font-size: 17px; color: #2d2447; }
        .cn-cat-desc { font-size: 12.5px; color: #8a7ba3; margin: 0; }
        .cn-chips { display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; }
        .cn-chip { display: flex; align-items: center; justify-content: space-between; gap: 8px; background: #faf8fd; border: 1px solid #ece6f3; border-radius: 12px; padding: 12px 14px; cursor: pointer; transition: transform .12s ease, border-color .2s, box-shadow .2s, background .2s; min-height: 52px; opacity: 0; transform: translateY(8px); animation: cn-fadeUp .45s ease forwards; }
        .cn-chip:hover { transform: translateY(-2px); border-color: #b558d6; box-shadow: 0 10px 22px rgba(123,45,139,0.14); }
        .cn-chip-main { display: flex; flex-direction: column; min-width: 0; }
        .cn-chip-name { font-family: 'Poppins', sans-serif; font-weight: 800; font-size: 16px; color: #3d0b55; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .cn-chip-vibe { font-size: 11.5px; color: #8a7ba3; }
        .cn-chip-copy { flex: 0 0 auto; width: 34px; height: 34px; border-radius: 9px; background: #fff; border: 1px solid #ece6f3; display: flex; align-items: center; justify-content: center; font-size: 15px; color: #7B2D8B; transition: background .2s, color .2s; }
        .cn-chip:hover .cn-chip-copy { background: #7B2D8B; color: #fff; }
        .cn-chip.cn-copied { background: linear-gradient(135deg, #e7f7ec, #d2efdc); border-color: #b8e2c5; }
        .cn-chip.cn-copied .cn-chip-copy { background: #14b8a6; color: #fff; }

        /* Share */
        .cn-share { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin-top: 18px; }
        .cn-share-btn { display: inline-flex; align-items: center; justify-content: center; gap: 6px; min-height: 48px; padding: 12px 8px; font-size: 14px; font-weight: 700; font-family: 'Poppins', sans-serif; border-radius: 12px; border: none; cursor: pointer; color: #fff; text-decoration: none; transition: transform .15s ease, box-shadow .15s ease; }
        .cn-share-btn:hover { transform: translateY(-2px); box-shadow: 0 12px 26px rgba(0,0,0,0.15); }
        .cn-sb-wa { background: #25d366; }
        .cn-sb-tw { background: #111; }
        .cn-sb-save { background: linear-gradient(135deg, #E63946, #7B2D8B); }
        .cn-sb-copy { background: #5b5b6e; }

        .cn-actions { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-top: 14px; }
        .cn-regen { background: linear-gradient(135deg, #7B2D8B, #b558d6); color: #fff; box-shadow: 0 12px 28px rgba(123,45,139,0.32); }
        .cn-regen:hover { transform: translateY(-2px); }
        .cn-try { background: #fff; color: #3d0b55; border: 2px solid #ece6f3; }
        .cn-try:hover { border-color: #7B2D8B; color: #7B2D8B; }

        /* Confetti */
        .cn-confetti { position: fixed; inset: 0; pointer-events: none; z-index: 9999; overflow: hidden; }
        .cn-confetti i { position: absolute; top: -20px; width: 10px; height: 14px; opacity: 0.95; animation: cn-fall linear forwards; border-radius: 2px; }

        /* Related tools */
        .cn-related { margin-top: 22px; }
        .cn-related h2 { font-size: 22px; color: #3d0b55; margin-bottom: 12px; }
        .cn-related-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; }
        .cn-rt { display: block; text-decoration: none; background: #fff; border-radius: 16px; padding: 16px 12px; text-align: center; box-shadow: 0 10px 24px rgba(0,0,0,0.06); border-top: 4px solid #E63946; color: inherit; transition: transform .15s ease, box-shadow .2s ease; }
        .cn-rt:hover { transform: translateY(-3px); box-shadow: 0 16px 32px rgba(0,0,0,0.1); }
        .cn-rt:nth-child(1) { border-color: #ff6b35; }
        .cn-rt:nth-child(2) { border-color: #14b8a6; }
        .cn-rt:nth-child(3) { border-color: #E63946; }
        .cn-rt:nth-child(4) { border-color: #7B2D8B; }
        .cn-rt-icon { font-size: 28px; }
        .cn-rt h4 { font-size: 14.5px; color: #1f1933; margin: 6px 0 4px; }
        .cn-rt p { font-size: 12.5px; color: #5b5070; margin: 0; }

        /* Animations */
        @keyframes cn-pulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.08); } }
        @keyframes cn-bob { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-6px); } }
        @keyframes cn-ring { 0% { transform: scale(0.6); opacity: 0.9; } 100% { transform: scale(1.4); opacity: 0; } }
        @keyframes cn-fadeUp { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes cn-shake { 0%, 100% { transform: translateX(0); } 25% { transform: translateX(-4px); } 75% { transform: translateX(4px); } }
        @keyframes cn-fall { 0% { transform: translateY(-20px) rotate(0); opacity: 1; } 100% { transform: translateY(110vh) rotate(720deg); opacity: 0.3; } }

        /* Mobile */
        @media (max-width: 640px) {
            .cn-wrap { padding: 8px; }
            .cn-header { padding: 22px 16px; border-radius: 18px; }
            .cn-header h1 { font-size: 28px; }
            .cn-header-icon { font-size: 44px; }
            .cn-stat-num { font-size: 16px; }
            .cn-card { padding: 20px 16px; border-radius: 18px; }
            .cn-inputs { grid-template-columns: 1fr; gap: 12px; }
            .cn-vs { margin: -4px auto; }
            .cn-chips { grid-template-columns: 1fr; }
            .cn-share { grid-template-columns: repeat(2, 1fr); }
            .cn-related-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 380px) {
            .cn-header h1 { font-size: 24px; }
            .cn-stat { padding: 4px 8px; min-width: 86px; }
        }
    </style>

    <!-- Header -->
    <header class="cn-header">
        <div class="cn-header-icon">&#128139;</div>
        <h1>Couple Nickname Generator</h1>
        <p class="cn-header-sub">Blend your names into cute, stylish &amp; romantic nicknames</p>
        <div class="cn-stats">
            <div class="cn-stat">
                <div class="cn-stat-num" id="cn-counter">5,12,883</div>
                <div class="cn-stat-lbl">Names Made</div>
            </div>
            <div class="cn-stat">
                <div class="cn-stat-num">4.9&#9733;</div>
                <div class="cn-stat-lbl">Rating</div>
            </div>
            <div class="cn-stat">
                <div class="cn-stat-num">40+</div>
                <div class="cn-stat-lbl">Ideas Each</div>
            </div>
        </div>
    </header>

    <!-- Card -->
    <section class="cn-card" id="cn-card">
        <div class="cn-input-phase" id="cn-input-phase">
            <div class="cn-inputs">
                <div class="cn-field">
                    <div class="cn-avatar cn-a" id="cn-av-a">?</div>
                    <input type="text" class="cn-input" id="cn-name-a" placeholder="Your name" maxlength="20" autocomplete="off" />
                </div>
                <div class="cn-vs" aria-hidden="true">&#10084;</div>
                <div class="cn-field">
                    <div class="cn-avatar cn-b" id="cn-av-b">?</div>
                    <input type="text" class="cn-input" id="cn-name-b" placeholder="Partner&rsquo;s name" maxlength="20" autocomplete="off" />
                </div>
            </div>
            <div class="cn-error" id="cn-error">Please enter both names to continue.</div>
            <button type="button" class="cn-btn cn-btn-primary" id="cn-gen-btn">Generate Nicknames &#128139;</button>
            <div class="cn-trust">
                <span>&#128274; Private</span>
                <span>&#9889; Instant</span>
                <span>&#127378; Free</span>
            </div>
        </div>

        <!-- Loading -->
        <div class="cn-loading" id="cn-loading">
            <div class="cn-rings">
                <div class="cn-ring"></div>
                <div class="cn-ring"></div>
                <div class="cn-ring"></div>
                <div class="cn-ring-heart">&#128139;</div>
            </div>
            <div class="cn-load-names" id="cn-load-names">&#10084;</div>
            <div class="cn-load-step" id="cn-load-step">&#128269; Mixing your names...</div>
            <div class="cn-progress"><div class="cn-progress-bar" id="cn-progress-bar"></div></div>
        </div>

        <!-- Result -->
        <div class="cn-result" id="cn-result">
            <div class="cn-result-head">
                <div class="cn-rh-names">
                    <div class="cn-rh-name"><div class="cn-avatar cn-a" id="cn-rh-av-a">?</div><span id="cn-rh-n-a">Name 1</span></div>
                    <div class="cn-rh-heart">&#10084;</div>
                    <div class="cn-rh-name"><div class="cn-avatar cn-b" id="cn-rh-av-b">?</div><span id="cn-rh-n-b">Name 2</span></div>
                </div>
                <h2 class="cn-rh-title">Your Couple Nicknames</h2>
                <p class="cn-rh-sub">Tap any name to copy it instantly</p>
                <div class="cn-top-pick">
                    <span style="font-size:22px;">&#11088;</span>
                    <div style="text-align:left;">
                        <div style="font-size:11px;opacity:.8;text-transform:uppercase;letter-spacing:.06em;">Top Pick</div>
                        <div class="cn-tp-name" id="cn-top-pick">&mdash;</div>
                    </div>
                </div>
            </div>

            <div id="cn-cats"></div>

            <!-- Share -->
            <div class="cn-share">
                <a href="#" class="cn-share-btn cn-sb-wa" id="cn-sb-wa" target="_blank" rel="noopener">&#128241; WhatsApp</a>
                <a href="#" class="cn-share-btn cn-sb-tw" id="cn-sb-tw" target="_blank" rel="noopener">&#119991; Twitter</a>
                <button type="button" class="cn-share-btn cn-sb-save" id="cn-sb-save">&#128247; Save</button>
                <button type="button" class="cn-share-btn cn-sb-copy" id="cn-sb-copy">&#128279; Copy Link</button>
            </div>

            <div class="cn-actions">
                <button type="button" class="cn-btn cn-regen" id="cn-regen-btn">&#127922; More Ideas</button>
                <button type="button" class="cn-btn cn-try" id="cn-try-btn">&#128260; New Names</button>
            </div>
        </div>
    </section>

    <!-- Related tools -->
    <section class="cn-related">
        <h2>Try More Love Tools</h2>
        <div class="cn-related-grid">
            <a class="cn-rt" href="/love-calculator/"><div class="cn-rt-icon">&#128149;</div><h4>Love Calculator</h4><p>Test your name compatibility instantly</p></a>
            <a class="cn-rt" href="/love-horoscope/"><div class="cn-rt-icon">&#128156;</div><h4>Love Horoscope</h4><p>Your daily love forecast by the stars</p></a>
            <a class="cn-rt" href="/love-message-generator/"><div class="cn-rt-icon">&#128140;</div><h4>Love Messages</h4><p>Sweet messages for any moment</p></a>
            <a class="cn-rt" href="/flames-calculator/"><div class="cn-rt-icon">&#128293;</div><h4>FLAMES</h4><p>Friends, Love, Affection &amp; more</p></a>
        </div>
    </section>

    <!-- Schema -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "SoftwareApplication",
      "name": "Couple Nickname Generator",
      "applicationCategory": "LifestyleApplication",
      "operatingSystem": "Web",
      "url": "https://lovecalculator.in/couple-nickname-generator/",
      "offers": { "@type": "Offer", "price": "0", "priceCurrency": "USD" },
      "aggregateRating": { "@type": "AggregateRating", "ratingValue": "4.9", "ratingCount": "11320" }
    }
    </script>
</div>
        <?php
        $cn_html = ob_get_clean();

        // Deliver the behavioral JS via the footer so WordPress content
        // filters (wpautop) can never inject tags that break the script.
        ob_start();
        ?>
(function(){
    'use strict';
    var $ = function(id){ return document.getElementById(id); };

    var elA = $('cn-name-a'), elB = $('cn-name-b'), elAvA = $('cn-av-a'), elAvB = $('cn-av-b'), elError = $('cn-error');
    var phases = { input: $('cn-input-phase'), loading: $('cn-loading'), result: $('cn-result') };
    var state = { a: '', b: '', variant: 0 };

    function updateAvatar(input, av){ var v = (input.value || '').trim(); av.textContent = v ? v.charAt(0).toUpperCase() : '?'; }
    elA.addEventListener('input', function(){ updateAvatar(elA, elAvA); elError.classList.remove('cn-show'); });
    elB.addEventListener('input', function(){ updateAvatar(elB, elAvB); elError.classList.remove('cn-show'); });

    function clean(n){ return (n||'').toLowerCase().replace(/[^a-z]/g,''); }
    function cap(s){ return s ? s.charAt(0).toUpperCase() + s.slice(1) : s; }
    function hashStr(str){ var h=0; for (var i=0;i<str.length;i++){ h=((h<<5)-h+str.charCodeAt(i))|0; } return Math.abs(h); }

    var VOWELS = 'aeiou';
    function firstHalf(s){ return s.slice(0, Math.max(1, Math.ceil(s.length/2))); }
    function secondHalf(s){ return s.slice(Math.floor(s.length/2)); }
    function uniq(arr){ var seen={}, out=[]; arr.forEach(function(x){ var k=x.toLowerCase(); if(x && !seen[k]){ seen[k]=1; out.push(x); } }); return out; }

    // Ship / blended names
    function shipNames(a, b){
        var out = [];
        out.push(cap(firstHalf(a) + secondHalf(b)));
        out.push(cap(firstHalf(b) + secondHalf(a)));
        out.push(cap(a.slice(0, Math.ceil(a.length*0.6)) + b.slice(Math.floor(b.length*0.5))));
        out.push(cap(b.slice(0, Math.ceil(b.length*0.6)) + a.slice(Math.floor(a.length*0.5))));
        out.push(cap(a.slice(0,2) + b));
        out.push(cap(a + b.slice(Math.max(1, b.length-2))));
        out.push(cap(firstHalf(a) + firstHalf(b)));
        out.push(cap(a.charAt(0) + b.slice(1)));
        return uniq(out).slice(0, 6);
    }

    var CUTE_SUFFIX = ['-ie', '-boo', '-bug', '-bear', '-pie', '-kins'];
    function cuteNames(a, b){
        var base = cap(firstHalf(a) + secondHalf(b));
        var out = [];
        out.push(cap(a) + 'kins');
        out.push(cap(firstHalf(a)) + 'boo');
        out.push(cap(firstHalf(b)) + 'bear');
        out.push(cap(a.charAt(0) + b.charAt(0)) + (VOWELS.indexOf(a.charAt(0))>=0?'mmy':'zzy'));
        out.push(cap(firstHalf(a)) + 'pie');
        out.push(cap(base.slice(0, Math.min(4, base.length))) + 'ie');
        out.push('Lil ' + cap(firstHalf(b)));
        out.push(cap(a) + ' Bug');
        return uniq(out).slice(0, 6);
    }

    var STYLISH_DECOR = [
        function(s){ return '·' + s + '·'; },
        function(s){ return '✧ ' + s + ' ✧'; },
        function(s){ return s + '™'; },
        function(s){ return '♥' + s + '♥'; }
    ];
    function stylishNames(a, b){
        var blend = cap(firstHalf(a) + secondHalf(b));
        var blend2 = cap(firstHalf(b) + secondHalf(a));
        var out = [];
        out.push(blend + ' × ' + blend2);
        out.push('✧ ' + blend + ' ✧');
        out.push(cap(a) + ' & ' + cap(b));
        out.push('♥ ' + blend + ' ♥');
        out.push('Team ' + cap(firstHalf(a) + firstHalf(b)));
        out.push(blend + ' Forever');
        out.push('The ' + cap(firstHalf(a) + secondHalf(b)) + 's');
        out.push(cap(a.charAt(0)) + ' ＆ ' + cap(b.charAt(0)));
        return uniq(out).slice(0, 6);
    }

    var PET_NAMES = [
        'Sweetheart', 'Honey', 'Babe', 'Cutie', 'Sunshine', 'Angel', 'Darling', 'Cupcake',
        'My Love', 'Sugar', 'Pumpkin', 'Munchkin', 'Snuggles', 'Lovebug', 'Prince', 'Princess',
        'Soulmate', 'Jaan', 'Heartbeat', 'Cuddle Bug'
    ];
    function petNames(a, b, seed){
        var out = [];
        var pool = PET_NAMES.slice();
        for (var i=0;i<8;i++){
            var idx = (seed + i*7) % pool.length;
            out.push(pool[idx]);
        }
        // personalize a couple
        out[2] = cap(firstHalf(a)) + ' Sweetheart';
        out[5] = 'My ' + cap(firstHalf(b));
        return uniq(out).slice(0, 6);
    }

    var VIBES = ['Romantic', 'Playful', 'Trendy', 'Sweet', 'Classic', 'Aesthetic', 'Cozy', 'Iconic', 'Dreamy', 'Adorable'];
    function vibeFor(name, seed){ return VIBES[(hashStr(name) + seed) % VIBES.length]; }

    function buildCategories(a, b, variant){
        var seed = hashStr(a + b) + variant * 17;
        function rot(arr){ if (!variant) return arr; var n = variant % Math.max(1, arr.length); return arr.slice(n).concat(arr.slice(0, n)); }
        return [
            { icon: '💕', title: 'Ship Names', desc: 'Your two names blended into one', color: '#E63946', items: rot(shipNames(a, b)) },
            { icon: '🧸', title: 'Cute Nicknames', desc: 'Adorable, lovable pet-style names', color: '#ff6b9d', items: rot(cuteNames(a, b)) },
            { icon: '✨', title: 'Stylish Combos', desc: 'Aesthetic combos for bios &amp; profiles', color: '#7B2D8B', items: rot(stylishNames(a, b)) },
            { icon: '💋', title: 'Romantic Pet Names', desc: 'Timeless names to call each other', color: '#fbbf24', items: rot(petNames(a, b, seed)) }
        ];
    }

    function copyText(text, chipEl){
        function done(){ if (chipEl){ chipEl.classList.add('cn-copied'); setTimeout(function(){ chipEl.classList.remove('cn-copied'); }, 1400); } }
        try {
            if (navigator.clipboard){ navigator.clipboard.writeText(text).then(done, function(){ fallback(); }); }
            else fallback();
        } catch(e){ fallback(); }
        function fallback(){ var ta=document.createElement('textarea'); ta.value=text; document.body.appendChild(ta); ta.select(); try{document.execCommand('copy');}catch(e){} ta.remove(); done(); }
    }

    function renderCats(a, b, variant){
        var cats = buildCategories(a, b, variant);
        var host = $('cn-cats');
        host.innerHTML = '';
        var animIdx = 0;
        cats.forEach(function(cat){
            var sec = document.createElement('div');
            sec.className = 'cn-cat';
            sec.style.borderTopColor = cat.color;
            var head = '<div class="cn-cat-head"><span class="cn-cat-icon">' + cat.icon + '</span><div><div class="cn-cat-title">' + cat.title + '</div><p class="cn-cat-desc">' + cat.desc + '</p></div></div>';
            var chips = '<div class="cn-chips">';
            cat.items.forEach(function(name){
                var vibe = vibeFor(name, variant);
                chips += '<div class="cn-chip" data-name="' + name.replace(/"/g,'&quot;') + '" style="animation-delay:' + (animIdx*0.04) + 's"><div class="cn-chip-main"><span class="cn-chip-name">' + name + '</span><span class="cn-chip-vibe">' + vibe + '</span></div><span class="cn-chip-copy">⎘</span></div>';
                animIdx++;
            });
            chips += '</div>';
            sec.innerHTML = head + chips;
            host.appendChild(sec);
        });
        // wire copy
        host.querySelectorAll('.cn-chip').forEach(function(chip){
            chip.addEventListener('click', function(){ copyText(chip.getAttribute('data-name'), chip); });
        });
        // top pick = first ship name
        var top = cats[0].items[0] || (cap(a) + cap(b));
        $('cn-top-pick').textContent = top;
        return top;
    }

    var loadSteps = ['🔍 Mixing your names...', '💞 Blending sounds...', '✨ Adding some style...', '💖 Polishing your nicknames...'];
    function runLoading(cb){
        var stepEl = $('cn-load-step'), barEl = $('cn-progress-bar'), i=0;
        stepEl.textContent = loadSteps[0]; barEl.style.width = '8%';
        var iv = setInterval(function(){
            i++;
            if (i < loadSteps.length){ stepEl.style.opacity='0'; setTimeout(function(){ stepEl.textContent=loadSteps[i]; stepEl.style.opacity='1'; },200); barEl.style.width=((i+1)*25)+'%'; }
            else { clearInterval(iv); barEl.style.width='100%'; setTimeout(cb,300); }
        }, 600);
    }

    function confetti(){
        var colors = ['#E63946', '#ff6b9d', '#fbbf24', '#7B2D8B', '#fff'];
        var box = document.createElement('div'); box.className = 'cn-confetti';
        for (var i=0;i<55;i++){ var p=document.createElement('i'); p.style.left=(Math.random()*100)+'%'; p.style.background=colors[Math.floor(Math.random()*colors.length)]; p.style.animationDuration=(1.5+Math.random()*2)+'s'; p.style.animationDelay=(Math.random()*0.5)+'s'; p.style.transform='rotate('+(Math.random()*360)+'deg)'; box.appendChild(p); }
        document.body.appendChild(box); setTimeout(function(){ box.remove(); }, 4000);
    }

    function setupShare(a, b, top){
        var url = window.location.href;
        var msg = '💕 Our Couple Nickname is *' + top + '*!\n\n' + cap(a) + ' + ' + cap(b) + ' 💑\nMake yours: ' + url;
        var tweet = cap(a) + ' + ' + cap(b) + ' = ' + top + ' 💕 Generate your couple nickname:';
        $('cn-sb-wa').href = 'https://wa.me/?text=' + encodeURIComponent(msg);
        $('cn-sb-tw').href = 'https://twitter.com/intent/tweet?text=' + encodeURIComponent(tweet) + '&url=' + encodeURIComponent(url);
        $('cn-sb-copy').onclick = function(){
            var btn=this, orig=btn.innerHTML;
            try { if (navigator.clipboard){ navigator.clipboard.writeText(url).then(function(){ btn.innerHTML='✅ Copied!'; setTimeout(function(){ btn.innerHTML=orig; },1800); }); } else { var ta=document.createElement('textarea'); ta.value=url; document.body.appendChild(ta); ta.select(); document.execCommand('copy'); ta.remove(); btn.innerHTML='✅ Copied!'; setTimeout(function(){ btn.innerHTML=orig; },1800);} }
            catch(e){ btn.innerHTML='⚠ Try Manually'; setTimeout(function(){ btn.innerHTML=orig; },1800); }
        };
        $('cn-sb-save').onclick = function(){
            var btn=this, orig=btn.innerHTML; btn.innerHTML='📸 Saving...';
            setTimeout(function(){ if (navigator.share){ navigator.share({ title:'Our Couple Nickname', text:msg, url:url }).then(function(){ btn.innerHTML=orig; }).catch(function(){ alert('Screenshot your nicknames to save them!'); btn.innerHTML=orig; }); } else { alert('Screenshot your nicknames to save them!\n\n' + cap(a) + ' + ' + cap(b) + ' = ' + top); btn.innerHTML=orig; } }, 400);
        };
    }

    function showResult(){
        var a = state.a, b = state.b;
        $('cn-rh-n-a').textContent = cap(elA.value.trim());
        $('cn-rh-n-b').textContent = cap(elB.value.trim());
        $('cn-rh-av-a').textContent = elA.value.trim().charAt(0).toUpperCase();
        $('cn-rh-av-b').textContent = elB.value.trim().charAt(0).toUpperCase();
        var top = renderCats(a, b, state.variant);
        setupShare(a, b, top);
        phases.loading.classList.remove('cn-show'); phases.loading.style.display='none';
        phases.result.classList.add('cn-show');
        setTimeout(confetti, 500);
        setTimeout(function(){ phases.result.scrollIntoView({ behavior:'smooth', block:'start' }); }, 100);
    }

    function generate(){
        var na = (elA.value||'').trim(), nb = (elB.value||'').trim();
        if (!na || !nb){ elError.textContent='Please enter both names to continue.'; elError.classList.add('cn-show'); return; }
        if (clean(na).length < 2 || clean(nb).length < 2){ elError.textContent='Please enter real names (at least 2 letters).'; elError.classList.add('cn-show'); return; }
        elError.classList.remove('cn-show');
        state.a = clean(na); state.b = clean(nb); state.variant = 0;
        phases.input.style.display='none';
        phases.loading.style.display='block'; phases.loading.classList.add('cn-show');
        $('cn-load-names').textContent = cap(na) + ' ❤️ ' + cap(nb);
        $('cn-progress-bar').style.width='0%';
        runLoading(showResult);
    }

    $('cn-gen-btn').addEventListener('click', generate);
    [elA, elB].forEach(function(el){ el.addEventListener('keydown', function(e){ if (e.key==='Enter'){ e.preventDefault(); generate(); } }); });

    $('cn-regen-btn').addEventListener('click', function(){
        state.variant++;
        var top = renderCats(state.a, state.b, state.variant);
        setupShare(state.a, state.b, top);
        $('cn-cats').scrollIntoView({ behavior:'smooth', block:'start' });
    });

    $('cn-try-btn').addEventListener('click', function(){
        phases.result.classList.remove('cn-show');
        phases.loading.classList.remove('cn-show'); phases.loading.style.display='none';
        phases.input.style.display='block';
        elA.value=''; elB.value=''; elAvA.textContent='?'; elAvB.textContent='?';
        $('cn-card').scrollIntoView({ behavior:'smooth', block:'start' });
        setTimeout(function(){ elA.focus(); }, 400);
    });

    // Live counter
    var counterEl = $('cn-counter'); var count = 512883;
    setInterval(function(){ count += 1 + Math.floor(Math.random()*3); counterEl.textContent = count.toLocaleString('en-IN'); }, 8000);
})();
        <?php
        $cn_js = ob_get_clean();

        if ( ! wp_script_is( 'cn-pro-inline', 'enqueued' ) ) {
            wp_register_script( 'cn-pro-inline', '', array(), '1.0.0', true );
            wp_enqueue_script( 'cn-pro-inline' );
            wp_add_inline_script( 'cn-pro-inline', $cn_js );
        }

        return $cn_html;
    }

    add_shortcode( 'couple_nickname_generator', 'cn_pro_render_generator' );

    // Aliases so the tool still works if a different shortcode name is used.
    add_shortcode( 'couple_nickname', 'cn_pro_render_generator' );
    add_shortcode( 'couple_name_generator', 'cn_pro_render_generator' );
}
