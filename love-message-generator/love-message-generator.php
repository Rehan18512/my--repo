<?php
/**
 * Plugin Name: Love Message Generator
 * Plugin URI: https://lovecalculator.in
 * Description: Premium Love Message Generator with occasion picker, tone selector, name personalization, an elegant message card and one-tap copy &amp; share. Use shortcode [love_message_generator].
 * Version: 1.0.0
 * Author: lovecalculator.in
 * Author URI: https://lovecalculator.in
 * License: GPL-2.0+
 * Text Domain: love-message-generator
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! function_exists( 'lm_pro_render_generator' ) ) {

    function lm_pro_render_generator( $atts = array() ) {
        ob_start();
        ?>
<div class="lm-wrap" id="lm-wrap">
    <style>
        .lm-wrap, .lm-wrap *, .lm-wrap *::before, .lm-wrap *::after { box-sizing: border-box; }
        .lm-wrap { font-family: 'DM Sans', 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; color: #1f1933; max-width: 880px; margin: 0 auto; padding: 12px; line-height: 1.55; }
        .lm-wrap h1, .lm-wrap h2, .lm-wrap h3, .lm-wrap h4 { font-family: 'Poppins', 'Syne', system-ui, sans-serif; font-weight: 800; letter-spacing: -0.01em; margin: 0; }

        /* Header */
        .lm-header { background: linear-gradient(135deg, #1a0533 0%, #3d0b55 50%, #690d3a 100%); border-radius: 22px; padding: 28px 20px; color: #fff; text-align: center; box-shadow: 0 20px 60px rgba(105, 13, 58, 0.25); position: relative; overflow: hidden; }
        .lm-header::before { content: ""; position: absolute; inset: -50%; background: radial-gradient(circle at 30% 20%, rgba(230,57,70,0.18), transparent 60%), radial-gradient(circle at 70% 80%, rgba(123,45,139,0.25), transparent 60%); pointer-events: none; }
        .lm-header-icon { font-size: 50px; line-height: 1; display: inline-block; animation: lm-bob 2.4s ease-in-out infinite; }
        .lm-header h1 { font-size: 36px; margin: 8px 0 6px; color: #fff; }
        .lm-header-sub { opacity: 0.86; font-size: 15px; margin: 0; }
        .lm-stats { display: flex; align-items: center; justify-content: center; gap: 0; margin-top: 18px; flex-wrap: wrap; }
        .lm-stat { padding: 4px 14px; min-width: 96px; }
        .lm-stat-num { font-weight: 800; font-family: 'Poppins', sans-serif; font-size: 18px; color: #fff; }
        .lm-stat-lbl { font-size: 11px; opacity: 0.78; text-transform: uppercase; letter-spacing: 0.06em; }
        .lm-stat + .lm-stat { border-left: 1px solid rgba(255,255,255,0.22); }

        /* Card shell */
        .lm-card { background: #fff; border-radius: 22px; padding: 24px 20px; margin-top: 18px; box-shadow: 0 20px 60px rgba(0,0,0,0.08); border: 1px solid #f1ecf6; }
        .lm-label { font-size: 13px; font-weight: 700; font-family: 'Poppins', sans-serif; color: #5b1d72; text-transform: uppercase; letter-spacing: 0.05em; margin: 0 0 10px; display: block; }
        .lm-label + .lm-label, .lm-block + .lm-block { margin-top: 20px; }

        .lm-name-field { position: relative; }
        .lm-input { width: 100%; min-height: 52px; padding: 12px 16px; font-size: 16px; border: 2px solid #ece6f3; border-radius: 14px; outline: none; background: #faf8fd; transition: border-color .2s, background .2s, box-shadow .2s; font-family: inherit; }
        .lm-input:focus { border-color: #E63946; background: #fff; box-shadow: 0 0 0 4px rgba(230,57,70,0.12); }

        /* Occasion chips */
        .lm-chips { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; }
        .lm-chip { background: #faf8fd; border: 2px solid #ece6f3; border-radius: 14px; padding: 12px 6px; text-align: center; cursor: pointer; transition: transform .15s ease, border-color .2s, box-shadow .2s, background .2s; min-height: 70px; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 4px; }
        .lm-chip:hover { transform: translateY(-2px); border-color: #b558d6; box-shadow: 0 10px 22px rgba(123,45,139,0.14); }
        .lm-chip.lm-active { border-color: #E63946; background: linear-gradient(135deg, #fff, #fff4f6); box-shadow: 0 10px 26px rgba(230,57,70,0.16); }
        .lm-chip-icon { font-size: 22px; line-height: 1; }
        .lm-chip-name { font-size: 12px; font-weight: 700; font-family: 'Poppins', sans-serif; color: #2d2447; }

        /* Tone pills */
        .lm-tones { display: flex; flex-wrap: wrap; gap: 8px; }
        .lm-tone { background: #f6f0fb; border: 1.5px solid #e6d8f3; color: #5b5070; border-radius: 999px; padding: 9px 16px; font-size: 13.5px; font-weight: 700; font-family: 'Poppins', sans-serif; cursor: pointer; transition: background .2s, color .2s, border-color .2s, transform .12s; min-height: 40px; }
        .lm-tone:hover { transform: translateY(-1px); }
        .lm-tone.lm-active { background: linear-gradient(135deg, #7B2D8B, #b558d6); color: #fff; border-color: transparent; }

        .lm-error { display: none; background: #fff1f2; color: #b3162a; border: 1px solid #ffd6db; padding: 10px 14px; border-radius: 12px; margin-top: 16px; font-size: 14px; text-align: center; }
        .lm-error.lm-show { display: block; animation: lm-shake .4s; }
        .lm-btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; min-height: 56px; padding: 18px 22px; font-size: 17px; font-weight: 700; font-family: 'Poppins', sans-serif; border: none; border-radius: 14px; cursor: pointer; width: 100%; transition: transform .15s ease, box-shadow .2s ease, opacity .2s; }
        .lm-btn-primary { background: linear-gradient(135deg, #E63946, #c81e2c); color: #fff; box-shadow: 0 14px 32px rgba(230,57,70,0.35); margin-top: 20px; }
        .lm-btn-primary:hover { transform: translateY(-2px); box-shadow: 0 18px 40px rgba(230,57,70,0.45); }
        .lm-btn-primary:active { transform: translateY(0); }
        .lm-trust { display: flex; gap: 10px; justify-content: center; flex-wrap: wrap; margin-top: 14px; }
        .lm-trust span { font-size: 12.5px; color: #5b5070; background: #f6f0fb; padding: 6px 12px; border-radius: 999px; min-height: 30px; display: inline-flex; align-items: center; }

        /* Loading */
        .lm-loading { display: none; text-align: center; padding: 14px 8px 6px; }
        .lm-loading.lm-show { display: block; }
        .lm-rings { position: relative; width: 150px; height: 150px; margin: 6px auto 18px; }
        .lm-ring { position: absolute; inset: 0; border-radius: 50%; border: 3px solid rgba(230,57,70,0.35); animation: lm-ring 2s ease-out infinite; }
        .lm-ring:nth-child(2) { animation-delay: .5s; border-color: rgba(123,45,139,0.4); }
        .lm-ring:nth-child(3) { animation-delay: 1s; border-color: rgba(255,107,157,0.45); }
        .lm-ring-heart { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; font-size: 54px; animation: lm-pulse 1.2s ease-in-out infinite; }
        .lm-load-step { font-size: 15px; color: #6b5e85; min-height: 24px; transition: opacity .25s; margin-top: 4px; }
        .lm-progress { height: 8px; background: #f1ebf7; border-radius: 999px; overflow: hidden; margin: 14px auto 4px; max-width: 360px; }
        .lm-progress-bar { height: 100%; width: 0%; background: linear-gradient(90deg, #E63946, #7B2D8B); border-radius: 999px; transition: width .3s ease; }

        /* Result */
        .lm-result { display: none; }
        .lm-result.lm-show { display: block; animation: lm-fadeUp .55s ease both; }
        .lm-msg-card { background: linear-gradient(135deg, #1a0533, #3d0b55, #690d3a); color: #fff; border-radius: 22px; padding: 30px 26px; box-shadow: 0 20px 60px rgba(0,0,0,0.25); position: relative; overflow: hidden; }
        .lm-msg-card::after { content: ""; position: absolute; inset: 0; background: radial-gradient(circle at 20% 10%, rgba(230,57,70,0.25), transparent 50%), radial-gradient(circle at 80% 90%, rgba(255,107,157,0.18), transparent 55%); pointer-events: none; }
        .lm-badges { display: flex; gap: 8px; flex-wrap: wrap; justify-content: center; position: relative; z-index: 1; }
        .lm-badge { background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.22); padding: 5px 12px; border-radius: 999px; font-size: 12px; font-weight: 700; font-family: 'Poppins', sans-serif; }
        .lm-quote { font-size: 28px; opacity: 0.5; line-height: 0.5; display: block; margin: 16px 0 4px; position: relative; z-index: 1; }
        .lm-msg-text { font-size: 19px; line-height: 1.62; text-align: center; position: relative; z-index: 1; min-height: 60px; }
        .lm-msg-text strong { color: #ffd1dc; }
        .lm-watermark { margin-top: 18px; font-size: 12.5px; opacity: 0.7; position: relative; z-index: 1; text-align: center; }

        /* Share */
        .lm-share { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin-top: 18px; }
        .lm-share-btn { display: inline-flex; align-items: center; justify-content: center; gap: 6px; min-height: 48px; padding: 12px 8px; font-size: 14px; font-weight: 700; font-family: 'Poppins', sans-serif; border-radius: 12px; border: none; cursor: pointer; color: #fff; text-decoration: none; transition: transform .15s ease, box-shadow .15s ease; }
        .lm-share-btn:hover { transform: translateY(-2px); box-shadow: 0 12px 26px rgba(0,0,0,0.15); }
        .lm-sb-wa { background: #25d366; }
        .lm-sb-tw { background: #111; }
        .lm-sb-copy { background: linear-gradient(135deg, #E63946, #7B2D8B); }
        .lm-sb-save { background: #5b5b6e; }

        .lm-actions { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-top: 14px; }
        .lm-regen { background: linear-gradient(135deg, #7B2D8B, #b558d6); color: #fff; box-shadow: 0 12px 28px rgba(123,45,139,0.32); }
        .lm-regen:hover { transform: translateY(-2px); }
        .lm-try { background: #fff; color: #3d0b55; border: 2px solid #ece6f3; }
        .lm-try:hover { border-color: #7B2D8B; color: #7B2D8B; }

        /* Confetti */
        .lm-confetti { position: fixed; inset: 0; pointer-events: none; z-index: 9999; overflow: hidden; }
        .lm-confetti i { position: absolute; top: -20px; width: 10px; height: 14px; opacity: 0.95; animation: lm-fall linear forwards; border-radius: 2px; }

        /* Related tools */
        .lm-related { margin-top: 22px; }
        .lm-related h2 { font-size: 22px; color: #3d0b55; margin-bottom: 12px; }
        .lm-related-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; }
        .lm-rt { display: block; text-decoration: none; background: #fff; border-radius: 16px; padding: 16px 12px; text-align: center; box-shadow: 0 10px 24px rgba(0,0,0,0.06); border-top: 4px solid #E63946; color: inherit; transition: transform .15s ease, box-shadow .2s ease; }
        .lm-rt:hover { transform: translateY(-3px); box-shadow: 0 16px 32px rgba(0,0,0,0.1); }
        .lm-rt:nth-child(1) { border-color: #ff6b35; }
        .lm-rt:nth-child(2) { border-color: #14b8a6; }
        .lm-rt:nth-child(3) { border-color: #E63946; }
        .lm-rt:nth-child(4) { border-color: #7B2D8B; }
        .lm-rt-icon { font-size: 28px; }
        .lm-rt h4 { font-size: 14.5px; color: #1f1933; margin: 6px 0 4px; }
        .lm-rt p { font-size: 12.5px; color: #5b5070; margin: 0; }

        /* Animations */
        @keyframes lm-pulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.08); } }
        @keyframes lm-bob { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-6px); } }
        @keyframes lm-ring { 0% { transform: scale(0.6); opacity: 0.9; } 100% { transform: scale(1.4); opacity: 0; } }
        @keyframes lm-fadeUp { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes lm-shake { 0%, 100% { transform: translateX(0); } 25% { transform: translateX(-4px); } 75% { transform: translateX(4px); } }
        @keyframes lm-fall { 0% { transform: translateY(-20px) rotate(0); opacity: 1; } 100% { transform: translateY(110vh) rotate(720deg); opacity: 0.3; } }

        /* Mobile */
        @media (max-width: 640px) {
            .lm-wrap { padding: 8px; }
            .lm-header { padding: 22px 16px; border-radius: 18px; }
            .lm-header h1 { font-size: 28px; }
            .lm-header-icon { font-size: 44px; }
            .lm-stat-num { font-size: 16px; }
            .lm-card { padding: 20px 16px; border-radius: 18px; }
            .lm-chips { grid-template-columns: repeat(3, 1fr); }
            .lm-msg-text { font-size: 17px; }
            .lm-share { grid-template-columns: repeat(2, 1fr); }
            .lm-related-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 380px) {
            .lm-header h1 { font-size: 24px; }
            .lm-chips { grid-template-columns: repeat(2, 1fr); }
        }
    </style>

    <!-- Header -->
    <header class="lm-header">
        <div class="lm-header-icon">&#128140;</div>
        <h1>Love Message Generator</h1>
        <p class="lm-header-sub">Heartfelt messages for every moment &mdash; ready in one tap</p>
        <div class="lm-stats">
            <div class="lm-stat">
                <div class="lm-stat-num" id="lm-counter">7,46,201</div>
                <div class="lm-stat-lbl">Messages Sent</div>
            </div>
            <div class="lm-stat">
                <div class="lm-stat-num">4.9&#9733;</div>
                <div class="lm-stat-lbl">Rating</div>
            </div>
            <div class="lm-stat">
                <div class="lm-stat-num">200+</div>
                <div class="lm-stat-lbl">Messages</div>
            </div>
        </div>
    </header>

    <!-- Card -->
    <section class="lm-card" id="lm-card">
        <div class="lm-input-phase" id="lm-input-phase">
            <div class="lm-block">
                <label class="lm-label" for="lm-name">Their Name <span style="opacity:.6;text-transform:none;font-weight:600;">(optional)</span></label>
                <div class="lm-name-field">
                    <input type="text" class="lm-input" id="lm-name" placeholder="e.g. Sara, Aryan, my love..." maxlength="24" autocomplete="off" />
                </div>
            </div>

            <div class="lm-block">
                <label class="lm-label">Choose an Occasion</label>
                <div class="lm-chips" id="lm-chips"></div>
            </div>

            <div class="lm-block">
                <label class="lm-label">Pick a Tone</label>
                <div class="lm-tones" id="lm-tones"></div>
            </div>

            <div class="lm-error" id="lm-error">Please choose an occasion first.</div>
            <button type="button" class="lm-btn lm-btn-primary" id="lm-gen-btn">Generate Love Message &#128140;</button>
            <div class="lm-trust">
                <span>&#128274; Private</span>
                <span>&#9889; Instant</span>
                <span>&#127378; Free</span>
            </div>
        </div>

        <!-- Loading -->
        <div class="lm-loading" id="lm-loading">
            <div class="lm-rings">
                <div class="lm-ring"></div>
                <div class="lm-ring"></div>
                <div class="lm-ring"></div>
                <div class="lm-ring-heart">&#128140;</div>
            </div>
            <div class="lm-load-step" id="lm-load-step">&#9999;&#65039; Writing from the heart...</div>
            <div class="lm-progress"><div class="lm-progress-bar" id="lm-progress-bar"></div></div>
        </div>

        <!-- Result -->
        <div class="lm-result" id="lm-result">
            <div class="lm-msg-card">
                <div class="lm-badges">
                    <span class="lm-badge" id="lm-badge-occ">&#128156; Romantic</span>
                    <span class="lm-badge" id="lm-badge-tone">Sweet</span>
                </div>
                <span class="lm-quote">&ldquo;</span>
                <div class="lm-msg-text" id="lm-msg-text">Your message will appear here...</div>
                <div class="lm-watermark">lovecalculator.in &#10084;</div>
            </div>

            <!-- Share -->
            <div class="lm-share">
                <button type="button" class="lm-share-btn lm-sb-copy" id="lm-sb-copy">&#128203; Copy</button>
                <a href="#" class="lm-share-btn lm-sb-wa" id="lm-sb-wa" target="_blank" rel="noopener">&#128241; WhatsApp</a>
                <a href="#" class="lm-share-btn lm-sb-tw" id="lm-sb-tw" target="_blank" rel="noopener">&#119991; Twitter</a>
                <button type="button" class="lm-share-btn lm-sb-save" id="lm-sb-save">&#128247; Save</button>
            </div>

            <div class="lm-actions">
                <button type="button" class="lm-btn lm-regen" id="lm-regen-btn">&#127922; Another Message</button>
                <button type="button" class="lm-btn lm-try" id="lm-try-btn">&#128260; Start Over</button>
            </div>
        </div>
    </section>

    <!-- Related tools -->
    <section class="lm-related">
        <h2>Try More Love Tools</h2>
        <div class="lm-related-grid">
            <a class="lm-rt" href="/love-calculator/"><div class="lm-rt-icon">&#128149;</div><h4>Love Calculator</h4><p>Test your name compatibility instantly</p></a>
            <a class="lm-rt" href="/love-horoscope/"><div class="lm-rt-icon">&#128156;</div><h4>Love Horoscope</h4><p>Your daily love forecast by the stars</p></a>
            <a class="lm-rt" href="/couple-nickname-generator/"><div class="lm-rt-icon">&#128139;</div><h4>Couple Nicknames</h4><p>Cute pet names for you two</p></a>
            <a class="lm-rt" href="/compatibility-test/"><div class="lm-rt-icon">&#128302;</div><h4>Compatibility</h4><p>Deep zodiac &amp; personality match</p></a>
        </div>
    </section>

    <!-- Schema -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "SoftwareApplication",
      "name": "Love Message Generator",
      "applicationCategory": "LifestyleApplication",
      "operatingSystem": "Web",
      "url": "https://lovecalculator.in/love-message-generator/",
      "offers": { "@type": "Offer", "price": "0", "priceCurrency": "USD" },
      "aggregateRating": { "@type": "AggregateRating", "ratingValue": "4.9", "ratingCount": "14275" }
    }
    </script>
</div>

<script>
(function(){
    'use strict';
    var $ = function(id){ return document.getElementById(id); };

    var OCCASIONS = [
        { key: 'romantic',  icon: '💗', name: 'Romantic' },
        { key: 'morning',   icon: '🌅', name: 'Good Morning' },
        { key: 'night',     icon: '🌙', name: 'Good Night' },
        { key: 'missyou',   icon: '🥺', name: 'Miss You' },
        { key: 'anniversary', icon: '💍', name: 'Anniversary' },
        { key: 'distance',  icon: '✈️', name: 'Long Distance' },
        { key: 'apology',   icon: '🌹', name: 'Apology' },
        { key: 'flirty',    icon: '😘', name: 'Flirty' }
    ];

    var TONES = [
        { key: 'sweet',  name: 'Sweet' },
        { key: 'poetic', name: 'Poetic' },
        { key: 'flirty', name: 'Playful' },
        { key: 'deep',   name: 'Deep' }
    ];

    // {name} is replaced with recipient name (or a fallback term of endearment)
    var MESSAGES = {
        romantic: {
            sweet: [
                'Every time I see you, {name}, my heart still skips a beat like it did on day one. You are my favorite hello and my hardest goodbye.',
                'You are the best part of my every day, {name}. Loving you is the easiest thing I have ever done.',
                'With you, {name}, even ordinary moments turn into memories I never want to forget. You are my whole world.'
            ],
            poetic: [
                'If love were a language, {name}, your name would be its sweetest word. You are the poem my heart never knew it was writing.',
                'You are the quiet melody my soul hums all day, {name} &mdash; soft, steady, and impossibly beautiful.',
                'In a sky full of stars, {name}, you are the one I would still reach for. My heart found its home in you.'
            ],
            flirty: [
                'Just so you know, {name}, you are dangerously cute and I am completely under your spell. Guilty as charged.',
                'Warning: spending time with you, {name}, causes uncontrollable smiling and a racing heart. Worth every second.',
                'I keep falling for you, {name}, and honestly? I have stopped looking for a way back up.'
            ],
            deep: [
                'Loving you, {name}, taught me what home truly means &mdash; it was never a place, it was always you. I choose you, today and every day after.',
                'You did not just walk into my life, {name}; you rebuilt it with warmth I never knew I needed. My love for you only grows deeper.',
                'Of all the souls in this vast world, {name}, mine recognized yours instantly. Some bonds are written long before we meet.'
            ]
        },
        morning: {
            sweet: [
                'Good morning, {name}! Waking up knowing you exist makes every sunrise sweeter. Have the most beautiful day.',
                'Rise and shine, {name}. You are my first thought every morning and my favorite reason to smile.',
                'Sending you a warm good morning, {name}, wrapped in all my love. Go conquer today, my star.'
            ],
            poetic: [
                'The sun rose this morning, {name}, but it has nothing on the light you bring to my life. Good morning, my dawn.',
                'Morning whispers your name to me, {name}, in the soft gold of first light. Wake gently, my love.',
                'Each new day feels like a fresh page, {name}, and you are the sweetest word written across mine. Good morning.'
            ],
            flirty: [
                'Good morning, {name}! Just imagining your sleepy smile has already made my whole day. Hurry and text me back.',
                'Morning, cutie {name}. Fair warning: I plan to think about you all day long. No apologies.',
                'Wakey wakey, {name}! My day does not officially start until I hear from you, sleepyhead.'
            ],
            deep: [
                'Good morning, {name}. However today unfolds, know that you are deeply loved, completely safe, and never alone. I am always in your corner.',
                'As you open your eyes, {name}, remember how much light you bring to this world &mdash; and to me. Today is lucky to have you.',
                'Morning, my love {name}. Whatever yesterday held, today is a clean slate, and I am grateful to share it with you.'
            ]
        },
        night: {
            sweet: [
                'Good night, {name}. May your dreams be as sweet as the smile you gave me today. Sleep tight, my love.',
                'Sending you the coziest good night, {name}. Close your eyes and know you are so deeply loved.',
                'Sweet dreams, {name}. You are my last thought tonight and my favorite one too.'
            ],
            poetic: [
                'The moon keeps watch tonight, {name}, but my heart keeps watch over you. Drift gently into dreams, my love.',
                'Stars are stitching the night sky, {name}, and each one carries a wish I made for you. Good night, dearest.',
                'Let the quiet of the night hold you softly, {name}. Sleep, and let your dreams be gentle.'
            ],
            flirty: [
                'Good night, {name}! Try not to dream about me too much... okay, dream about me a lot. I will allow it.',
                'Off to bed, {name}? Save me a spot in your dreams &mdash; I promise to behave. Mostly.',
                'Night night, {name}. Just know the only thing better than dreaming of you is waking up to your texts.'
            ],
            deep: [
                'Good night, {name}. As the world goes quiet, I hope you feel how safe and treasured you are. Rest easy &mdash; tomorrow we begin again, together.',
                'Whatever weight today carried, {name}, set it down now. You are enough, you are loved, and you can rest. Good night, my heart.',
                'Sleep peacefully, {name}. No matter the distance or the hour, my love for you never sleeps.'
            ]
        },
        missyou: {
            sweet: [
                'I miss you so much, {name}. The day just feels softer and slower without you next to me.',
                'Missing you today, {name} &mdash; and honestly, every day. Come back to me soon, okay?',
                'Just a little note to say I miss you, {name}, more than my words could ever hold.'
            ],
            poetic: [
                'Missing you, {name}, is a quiet ache that fills the spaces where your laughter used to be. Come home to my heart.',
                'The distance between us, {name}, only proves how vast my love has grown. I miss you in every silent moment.',
                'I count the hours like falling petals, {name}, each one whispering your name. How I miss you.'
            ],
            flirty: [
                'I miss you, {name}! This is your official reminder that I am sitting here being adorable and lonely. Fix it.',
                'Missing you so much, {name}, that I keep rereading our old chats. Yes, I am that person now. Your fault.',
                'Hey {name}, my arms are weirdly empty and it is 100% because you are not in them. Hurry up.'
            ],
            deep: [
                'I miss you, {name}, but missing you reminds me how rare and real what we have truly is. Distance changes nothing about my heart.',
                'Even apart, {name}, you live in every quiet thought I have. Missing you is just love that refuses to stay still.',
                'I carry you with me everywhere, {name}. No distance has ever made me feel closer to anyone than I feel to you.'
            ]
        },
        anniversary: {
            sweet: [
                'Happy anniversary, {name}! Every year with you is my favorite story, and I cannot wait to write the next chapter.',
                'Here is to us, {name}. Thank you for a love that keeps getting sweeter with every single day.',
                'Happy anniversary to my favorite person, {name}. Loving you is the best decision I make again and again.'
            ],
            poetic: [
                'Another year woven into our story, {name}, and still you are the most beautiful verse in it. Happy anniversary, my love.',
                'Time keeps turning, {name}, yet my heart keeps choosing you in every season. Happy anniversary, eternally yours.',
                'We have gathered a year of sunrises and storms, {name}, and through all of it, our love only deepened. Happy anniversary.'
            ],
            flirty: [
                'Happy anniversary, {name}! Still the cutest, still the best kisser, still completely stuck with me. Lucky you.',
                'Another year of putting up with my terrible jokes, {name} &mdash; happy anniversary, you absolute keeper.',
                'Happy anniversary, {name}! Warning: I plan to flirt with you for at least a few more decades.'
            ],
            deep: [
                'Happy anniversary, {name}. Through everything life has tested us with, we chose each other &mdash; and I would choose you a thousand times more.',
                'Years ago we began as two; today we are one story, {name}. Thank you for growing with me. Here is to forever.',
                'Our love is not measured in years, {name}, but in the quiet ways we keep choosing to stay. Happy anniversary, my forever.'
            ]
        },
        distance: {
            sweet: [
                'The miles between us are real, {name}, but so is my love &mdash; and mine is stronger. Counting down to you.',
                'Distance is just a test, {name}, and we are going to pass with flying colors. I am yours, near or far.',
                'No matter how far apart we are, {name}, my heart always knows the way back to you.'
            ],
            poetic: [
                'Oceans may stretch between us, {name}, but every star you see tonight, I see too. We share the same sky, always.',
                'Distance is only space, {name}; it has no power over a heart that has already chosen. I love you across every mile.',
                'I send my love on the evening wind, {name}, hoping it reaches you wherever you are. Soon, the distance will be only a memory.'
            ],
            flirty: [
                'Long distance is hard, {name}, but you are absolutely worth every blurry video call and goodnight at weird hours. Get over here.',
                'Hey {name}, just so you know, the first thing I am doing when I see you is the longest hug ever. Consider yourself warned.',
                'Missing you across all these miles, {name}. Hurry up and close the gap so I can annoy you in person again.'
            ],
            deep: [
                'Loving you from afar, {name}, has shown me that real love does not need proximity to be powerful. You are worth every mile and every wait.',
                'Distance taught me something, {name}: my heart does not care about geography. Wherever you are is where I belong.',
                'The hardest part is not the distance, {name} &mdash; it is the waiting. But for a love like ours, I would wait through anything.'
            ]
        },
        apology: {
            sweet: [
                'I am truly sorry, {name}. You mean everything to me, and I never want to be the reason you feel unhappy. Forgive me?',
                'I messed up, {name}, and I know it. I am sorry &mdash; you deserve the best of me, always.',
                'Sorry, {name}. My heart aches knowing I hurt you. Let me make it right, because you are worth it.'
            ],
            poetic: [
                'If words could mend what I broke, {name}, I would whisper a thousand sorries until your smile returned. Forgive me, my love.',
                'I am sorry, {name}. Even the moon dims when we are at odds. Let me earn back the light in your eyes.',
                'My heart wrote this apology in the ink of regret, {name}. I am deeply sorry, and deeply yours.'
            ],
            flirty: [
                'Okay, I was wrong, {name}, and you were right &mdash; there, I said it. Now can my favorite person please smile again?',
                'I am sorry, {name}. I come bearing apologies, snacks, and an embarrassing amount of love. Truce?',
                'I messed up, {name}, but I am cute and I love you, so... please forgive me? Pretty please?'
            ],
            deep: [
                'I am sorry, {name}. Not just for what I did, but for the hurt it caused you. You deserve honesty, effort, and a better me &mdash; and I am committed to becoming him.',
                'True love is also accountability, {name}. I own my mistake, I feel its weight, and I am sorry. Thank you for being patient with my growth.',
                'I would rather lose any argument than lose your peace, {name}. I am genuinely sorry. Let us heal this, together.'
            ]
        },
        flirty: {
            sweet: [
                'Hey {name}, has anyone told you today how impossibly cute you are? Because you are, and I noticed. Again.',
                'Just thinking about you, {name}, and smiling like an idiot. You do that to me, you know.',
                'You, {name}, are the best notification my phone could ever buzz with. Hi, cutie.'
            ],
            poetic: [
                'There is a sparkle in you, {name}, that makes the whole room forget to breathe. I am no exception.',
                'You walked by, {name}, and suddenly every love song finally made sense. Dangerous, really.',
                'If charm were a crime, {name}, you would be serving a life sentence. Guilty on all counts.'
            ],
            flirty: [
                'Are you a magnet, {name}? Because I am completely, helplessly drawn to you. Science, probably.',
                'Quick question, {name}: do you have a map? I keep getting lost in those eyes of yours.',
                'Careful, {name} &mdash; keep being this adorable and I might have to keep you forever. Just saying.'
            ],
            deep: [
                'It is not just your looks, {name} &mdash; it is the way your mind works, the way you laugh, the way you make everything feel alive. You are my favorite everything.',
                'I flirt with you, {name}, but underneath the teasing is something real: I genuinely think you are extraordinary.',
                'Behind every wink and joke, {name}, is a heart that means it when it says you are something truly special.'
            ]
        }
    };

    var state = { occ: null, tone: 'sweet', lastIdx: -1, lastList: null };

    // Build occasion chips
    var chipHost = $('lm-chips');
    OCCASIONS.forEach(function(o, i){
        var el = document.createElement('div');
        el.className = 'lm-chip' + (i === 0 ? ' lm-active' : '');
        el.setAttribute('data-key', o.key);
        el.innerHTML = '<span class="lm-chip-icon">' + o.icon + '</span><span class="lm-chip-name">' + o.name + '</span>';
        el.addEventListener('click', function(){
            document.querySelectorAll('.lm-chip').forEach(function(x){ x.classList.remove('lm-active'); });
            el.classList.add('lm-active');
            state.occ = o; $('lm-error').classList.remove('lm-show');
        });
        chipHost.appendChild(el);
    });
    state.occ = OCCASIONS[0];

    // Build tone pills
    var toneHost = $('lm-tones');
    TONES.forEach(function(t, i){
        var el = document.createElement('button');
        el.type = 'button';
        el.className = 'lm-tone' + (i === 0 ? ' lm-active' : '');
        el.setAttribute('data-key', t.key);
        el.textContent = t.name;
        el.addEventListener('click', function(){
            document.querySelectorAll('.lm-tone').forEach(function(x){ x.classList.remove('lm-active'); });
            el.classList.add('lm-active');
            state.tone = t.key;
        });
        toneHost.appendChild(el);
    });

    function escapeHtml(s){ return String(s).replace(/[&<>"']/g, function(c){ return ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'})[c]; }); }

    function fillName(tpl, name){
        var n = (name || '').trim();
        if (n){
            n = n.charAt(0).toUpperCase() + n.slice(1);
            return tpl.replace(/\{name\}/g, n);
        }
        // graceful fallback when no name given: "my love", with a clean sentence-start capital
        var out = tpl.replace(/\{name\}/g, 'my love');
        return out.charAt(0).toUpperCase() + out.slice(1);
    }

    var phases = { input: $('lm-input-phase'), loading: $('lm-loading'), result: $('lm-result') };

    var loadSteps = ['✍️ Writing from the heart...', '💭 Finding the right words...', '💖 Adding a little magic...', '💌 Almost ready...'];
    function runLoading(cb){
        var stepEl = $('lm-load-step'), barEl = $('lm-progress-bar'), i = 0;
        stepEl.textContent = loadSteps[0]; barEl.style.width = '8%';
        var iv = setInterval(function(){
            i++;
            if (i < loadSteps.length){ stepEl.style.opacity='0'; setTimeout(function(){ stepEl.textContent=loadSteps[i]; stepEl.style.opacity='1'; },200); barEl.style.width=((i+1)*25)+'%'; }
            else { clearInterval(iv); barEl.style.width='100%'; setTimeout(cb,300); }
        }, 550);
    }

    function confetti(){
        var colors = ['#E63946', '#ff6b9d', '#fbbf24', '#7B2D8B', '#fff'];
        var box = document.createElement('div'); box.className = 'lm-confetti';
        for (var i=0;i<50;i++){ var p=document.createElement('i'); p.style.left=(Math.random()*100)+'%'; p.style.background=colors[Math.floor(Math.random()*colors.length)]; p.style.animationDuration=(1.5+Math.random()*2)+'s'; p.style.animationDelay=(Math.random()*0.5)+'s'; p.style.transform='rotate('+(Math.random()*360)+'deg)'; box.appendChild(p); }
        document.body.appendChild(box); setTimeout(function(){ box.remove(); }, 4000);
    }

    function currentMessageText(){ return $('lm-msg-text').textContent; }

    function pickMessage(){
        var occKey = state.occ.key;
        var list = (MESSAGES[occKey] && MESSAGES[occKey][state.tone]) || (MESSAGES[occKey] && MESSAGES[occKey].sweet) || ['You mean the world to me, {name}.'];
        state.lastList = list;
        var idx = Math.floor(Math.random() * list.length);
        if (list.length > 1 && idx === state.lastIdx){ idx = (idx + 1) % list.length; }
        state.lastIdx = idx;
        return list[idx];
    }

    function renderMessage(){
        var tpl = pickMessage();
        var name = $('lm-name').value;
        var msg = fillName(tpl, name);
        var toneName = (TONES.filter(function(t){ return t.key === state.tone; })[0] || TONES[0]).name;
        $('lm-badge-occ').innerHTML = state.occ.icon + ' ' + state.occ.name;
        $('lm-badge-tone').textContent = toneName;
        $('lm-msg-text').innerHTML = msg.replace(/&mdash;/g, '—');
        setupShare(msg);
    }

    function setupShare(msg){
        var url = window.location.href;
        var waText = msg + '\n\n💌 via ' + url;
        $('lm-sb-wa').href = 'https://wa.me/?text=' + encodeURIComponent(waText);
        $('lm-sb-tw').href = 'https://twitter.com/intent/tweet?text=' + encodeURIComponent(msg) + '&url=' + encodeURIComponent(url);

        $('lm-sb-copy').onclick = function(){
            var btn=this, orig=btn.innerHTML, text=currentMessageText();
            try { if (navigator.clipboard){ navigator.clipboard.writeText(text).then(function(){ btn.innerHTML='✅ Copied!'; setTimeout(function(){ btn.innerHTML=orig; },1800); }); } else { var ta=document.createElement('textarea'); ta.value=text; document.body.appendChild(ta); ta.select(); document.execCommand('copy'); ta.remove(); btn.innerHTML='✅ Copied!'; setTimeout(function(){ btn.innerHTML=orig; },1800);} }
            catch(e){ btn.innerHTML='⚠ Try Manually'; setTimeout(function(){ btn.innerHTML=orig; },1800); }
        };
        $('lm-sb-save').onclick = function(){
            var btn=this, orig=btn.innerHTML, text=currentMessageText(); btn.innerHTML='📸 Saving...';
            setTimeout(function(){ if (navigator.share){ navigator.share({ title:'A Love Message', text:text, url:url }).then(function(){ btn.innerHTML=orig; }).catch(function(){ alert('Screenshot this message to save it!'); btn.innerHTML=orig; }); } else { alert('Screenshot this message to save it!'); btn.innerHTML=orig; } }, 400);
        };
    }

    function showResult(){
        renderMessage();
        phases.loading.classList.remove('lm-show'); phases.loading.style.display='none';
        phases.result.classList.add('lm-show');
        setTimeout(confetti, 450);
        setTimeout(function(){ phases.result.scrollIntoView({ behavior:'smooth', block:'start' }); }, 100);
    }

    function generate(){
        if (!state.occ){ $('lm-error').classList.add('lm-show'); return; }
        $('lm-error').classList.remove('lm-show');
        state.lastIdx = -1;
        phases.input.style.display='none';
        phases.loading.style.display='block'; phases.loading.classList.add('lm-show');
        $('lm-progress-bar').style.width='0%';
        runLoading(showResult);
    }

    $('lm-gen-btn').addEventListener('click', generate);
    $('lm-name').addEventListener('keydown', function(e){ if (e.key==='Enter'){ e.preventDefault(); generate(); } });

    $('lm-regen-btn').addEventListener('click', function(){
        var card = document.querySelector('.lm-msg-card');
        card.style.opacity = '0.35';
        setTimeout(function(){ renderMessage(); card.style.transition='opacity .35s'; card.style.opacity='1'; }, 180);
    });

    $('lm-try-btn').addEventListener('click', function(){
        phases.result.classList.remove('lm-show');
        phases.loading.classList.remove('lm-show'); phases.loading.style.display='none';
        phases.input.style.display='block';
        $('lm-card').scrollIntoView({ behavior:'smooth', block:'start' });
    });

    // Live counter
    var counterEl = $('lm-counter'); var count = 746201;
    setInterval(function(){ count += 1 + Math.floor(Math.random()*4); counterEl.textContent = count.toLocaleString('en-IN'); }, 8000);
})();
</script>
        <?php
        return ob_get_clean();
    }

    add_shortcode( 'love_message_generator', 'lm_pro_render_generator' );
}
