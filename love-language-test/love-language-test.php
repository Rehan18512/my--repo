<?php
/**
 * Plugin Name: Love Language Test
 * Plugin URI: https://lovecalculator.in
 * Description: Premium Love Language Test. A 12-question forced-choice quiz that reveals your primary love language with a full 5-language breakdown, how-to-speak-it advice and share cards. Use shortcode [love_language_test].
 * Version: 1.0.0
 * Author: lovecalculator.in
 * Author URI: https://lovecalculator.in
 * License: GPL-2.0+
 * Text Domain: love-language-test
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! function_exists( 'll_pro_render_test' ) ) {

    function ll_pro_render_test( $atts = array() ) {
        ob_start();
        ?>
<div class="ll-wrap" id="ll-wrap">
    <style>
        .ll-wrap, .ll-wrap *, .ll-wrap *::before, .ll-wrap *::after { box-sizing: border-box; }
        .ll-wrap { font-family: 'DM Sans', 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; color: #1f1933; max-width: 880px; margin: 0 auto; padding: 12px; line-height: 1.55; }
        .ll-wrap h1, .ll-wrap h2, .ll-wrap h3, .ll-wrap h4 { font-family: 'Poppins', 'Syne', system-ui, sans-serif; font-weight: 800; letter-spacing: -0.01em; margin: 0; }

        .ll-header { background: linear-gradient(135deg, #1a0533 0%, #3d0b55 50%, #690d3a 100%); border-radius: 22px; padding: 28px 20px; color: #fff; text-align: center; box-shadow: 0 20px 60px rgba(105, 13, 58, 0.25); position: relative; overflow: hidden; }
        .ll-header::before { content: ""; position: absolute; inset: -50%; background: radial-gradient(circle at 30% 20%, rgba(230,57,70,0.18), transparent 60%), radial-gradient(circle at 70% 80%, rgba(123,45,139,0.25), transparent 60%); pointer-events: none; }
        .ll-header-icon { font-size: 50px; line-height: 1; display: inline-block; animation: ll-bob 2.4s ease-in-out infinite; }
        .ll-header h1 { font-size: 36px; margin: 8px 0 6px; color: #fff; }
        .ll-header-sub { opacity: 0.86; font-size: 15px; margin: 0; }
        .ll-stats { display: flex; align-items: center; justify-content: center; gap: 0; margin-top: 18px; flex-wrap: wrap; }
        .ll-stat { padding: 4px 14px; min-width: 96px; }
        .ll-stat-num { font-weight: 800; font-family: 'Poppins', sans-serif; font-size: 18px; color: #fff; }
        .ll-stat-lbl { font-size: 11px; opacity: 0.78; text-transform: uppercase; letter-spacing: 0.06em; }
        .ll-stat + .ll-stat { border-left: 1px solid rgba(255,255,255,0.22); }

        .ll-card { background: #fff; border-radius: 22px; padding: 24px 20px; margin-top: 18px; box-shadow: 0 20px 60px rgba(0,0,0,0.08); border: 1px solid #f1ecf6; }

        /* Intro */
        .ll-intro { text-align: center; }
        .ll-intro h2 { font-size: 22px; color: #3d0b55; margin-bottom: 8px; }
        .ll-intro p { font-size: 14.5px; color: #6b5e85; margin: 0 auto 16px; max-width: 520px; }
        .ll-langs-preview { display: grid; grid-template-columns: repeat(5, 1fr); gap: 10px; margin: 18px 0; }
        .ll-lp { background: #faf8fd; border: 1px solid #ece6f3; border-radius: 14px; padding: 12px 6px; text-align: center; }
        .ll-lp-icon { font-size: 24px; }
        .ll-lp-name { font-size: 11px; font-weight: 700; font-family: 'Poppins', sans-serif; color: #2d2447; margin-top: 4px; }

        .ll-btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; min-height: 56px; padding: 18px 22px; font-size: 17px; font-weight: 700; font-family: 'Poppins', sans-serif; border: none; border-radius: 14px; cursor: pointer; width: 100%; transition: transform .15s ease, box-shadow .2s ease, opacity .2s; }
        .ll-btn-primary { background: linear-gradient(135deg, #E63946, #c81e2c); color: #fff; box-shadow: 0 14px 32px rgba(230,57,70,0.35); margin-top: 8px; }
        .ll-btn-primary:hover { transform: translateY(-2px); box-shadow: 0 18px 40px rgba(230,57,70,0.45); }
        .ll-btn-primary:active { transform: translateY(0); }
        .ll-trust { display: flex; gap: 10px; justify-content: center; flex-wrap: wrap; margin-top: 14px; }
        .ll-trust span { font-size: 12.5px; color: #5b5070; background: #f6f0fb; padding: 6px 12px; border-radius: 999px; min-height: 30px; display: inline-flex; align-items: center; }

        /* Quiz */
        .ll-quiz { display: none; }
        .ll-quiz.ll-show { display: block; animation: ll-fadeUp .4s ease both; }
        .ll-qhead { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; }
        .ll-qcount { font-size: 13px; font-weight: 700; font-family: 'Poppins', sans-serif; color: #7B2D8B; }
        .ll-qback { background: none; border: none; color: #8a7ba3; font-size: 13px; font-weight: 700; cursor: pointer; padding: 6px 8px; border-radius: 8px; }
        .ll-qback:hover { color: #7B2D8B; background: #f6f0fb; }
        .ll-qback:disabled { opacity: 0; pointer-events: none; }
        .ll-progress { height: 8px; background: #f1ebf7; border-radius: 999px; overflow: hidden; margin-bottom: 18px; }
        .ll-progress-bar { height: 100%; width: 0%; background: linear-gradient(90deg, #E63946, #7B2D8B); border-radius: 999px; transition: width .4s ease; }
        .ll-qtext { font-size: 20px; font-family: 'Poppins', sans-serif; font-weight: 800; color: #2d2447; text-align: center; margin-bottom: 18px; min-height: 56px; display: flex; align-items: center; justify-content: center; }
        .ll-options { display: grid; gap: 12px; }
        .ll-opt { text-align: left; background: #faf8fd; border: 2px solid #ece6f3; border-radius: 16px; padding: 18px 18px; font-size: 16px; font-family: inherit; color: #2d2447; cursor: pointer; transition: transform .12s ease, border-color .2s, box-shadow .2s, background .2s; min-height: 60px; display: flex; align-items: center; gap: 12px; }
        .ll-opt:hover { transform: translateY(-2px); border-color: #E63946; background: #fff; box-shadow: 0 12px 26px rgba(230,57,70,0.14); }
        .ll-opt-key { flex: 0 0 auto; width: 30px; height: 30px; border-radius: 9px; background: linear-gradient(135deg, #7B2D8B, #b558d6); color: #fff; font-family: 'Poppins', sans-serif; font-weight: 800; font-size: 14px; display: flex; align-items: center; justify-content: center; }

        /* Loading */
        .ll-loading { display: none; text-align: center; padding: 14px 8px 6px; }
        .ll-loading.ll-show { display: block; }
        .ll-rings { position: relative; width: 150px; height: 150px; margin: 6px auto 18px; }
        .ll-ring { position: absolute; inset: 0; border-radius: 50%; border: 3px solid rgba(230,57,70,0.35); animation: ll-ringa 2s ease-out infinite; }
        .ll-ring:nth-child(2) { animation-delay: .5s; border-color: rgba(123,45,139,0.4); }
        .ll-ring:nth-child(3) { animation-delay: 1s; border-color: rgba(255,107,157,0.45); }
        .ll-ring-heart { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; font-size: 54px; animation: ll-pulse 1.2s ease-in-out infinite; }
        .ll-load-step { font-size: 15px; color: #6b5e85; min-height: 24px; margin-top: 4px; }

        /* Result */
        .ll-result { display: none; }
        .ll-result.ll-show { display: block; animation: ll-fadeUp .55s ease both; }
        .ll-result-card { background: linear-gradient(135deg, #1a0533, #3d0b55, #690d3a); color: #fff; border-radius: 22px; padding: 30px 22px; text-align: center; box-shadow: 0 20px 60px rgba(0,0,0,0.25); position: relative; overflow: hidden; }
        .ll-result-card::after { content: ""; position: absolute; inset: 0; background: radial-gradient(circle at 20% 10%, rgba(230,57,70,0.25), transparent 50%), radial-gradient(circle at 80% 90%, rgba(255,107,157,0.18), transparent 55%); pointer-events: none; }
        .ll-rc-tag { font-size: 12px; opacity: 0.8; text-transform: uppercase; letter-spacing: 0.1em; position: relative; z-index: 1; }
        .ll-rc-icon { font-size: 64px; line-height: 1; margin: 10px 0 4px; position: relative; z-index: 1; animation: ll-pop .6s ease both; }
        .ll-rc-name { font-family: 'Poppins', sans-serif; font-weight: 800; font-size: 30px; position: relative; z-index: 1; background: linear-gradient(90deg, #ffd1dc, #fbbf24); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent; }
        .ll-rc-pct { font-size: 15px; opacity: 0.9; margin-top: 4px; position: relative; z-index: 1; }
        .ll-rc-desc { max-width: 580px; margin: 12px auto 0; opacity: 0.94; font-size: 15px; position: relative; z-index: 1; }
        .ll-watermark { margin-top: 16px; font-size: 12.5px; opacity: 0.7; position: relative; z-index: 1; }

        .ll-section { background: #fff; border-radius: 18px; padding: 18px; margin-top: 16px; box-shadow: 0 12px 30px rgba(0,0,0,0.06); border: 1px solid #f1ecf6; border-top: 4px solid #7B2D8B; }
        .ll-section h3 { font-size: 17px; color: #2d2447; margin-bottom: 12px; }
        .ll-bars { margin-top: 4px; }
        .ll-bar-row { margin: 12px 0; }
        .ll-bar-top { display: flex; justify-content: space-between; font-size: 14px; font-weight: 600; color: #2d2447; margin-bottom: 6px; }
        .ll-bar-top span:last-child { color: #7B2D8B; font-family: 'Poppins', sans-serif; font-weight: 800; }
        .ll-bar { height: 12px; background: #f1ebf7; border-radius: 999px; overflow: hidden; }
        .ll-bar-fill { height: 100%; width: 0%; border-radius: 999px; transition: width 1.4s cubic-bezier(.22,.9,.3,1); }

        .ll-twocol { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-top: 16px; }
        .ll-mini { background: #fff; border-radius: 16px; padding: 16px; box-shadow: 0 10px 24px rgba(0,0,0,0.05); border: 1px solid #f1ecf6; }
        .ll-mini.ll-m1 { border-top: 4px solid #E63946; }
        .ll-mini.ll-m2 { border-top: 4px solid #14b8a6; }
        .ll-mini h4 { font-size: 15px; color: #3d0b55; margin-bottom: 8px; display: flex; align-items: center; gap: 8px; }
        .ll-mini p { font-size: 13.5px; color: #5b5070; margin: 0; }

        .ll-tips { background: linear-gradient(135deg, #fff8dc, #fff1c1); border-radius: 18px; padding: 20px; margin-top: 16px; border: 1px solid #f7e190; }
        .ll-tips h3 { font-size: 18px; color: #7a5a05; margin-bottom: 10px; }
        .ll-tips ul { margin: 0; padding-left: 18px; }
        .ll-tips li { font-size: 14px; color: #5b5070; margin-bottom: 8px; }

        .ll-share { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin-top: 18px; }
        .ll-share-btn { display: inline-flex; align-items: center; justify-content: center; gap: 6px; min-height: 48px; padding: 12px 8px; font-size: 14px; font-weight: 700; font-family: 'Poppins', sans-serif; border-radius: 12px; border: none; cursor: pointer; color: #fff; text-decoration: none; transition: transform .15s ease, box-shadow .15s ease; }
        .ll-share-btn:hover { transform: translateY(-2px); box-shadow: 0 12px 26px rgba(0,0,0,0.15); }
        .ll-sb-wa { background: #25d366; }
        .ll-sb-tw { background: #111; }
        .ll-sb-save { background: linear-gradient(135deg, #E63946, #7B2D8B); }
        .ll-sb-copy { background: #5b5b6e; }
        .ll-try { margin-top: 14px; background: #fff; color: #3d0b55; border: 2px solid #ece6f3; }
        .ll-try:hover { border-color: #7B2D8B; color: #7B2D8B; }

        .ll-confetti { position: fixed; inset: 0; pointer-events: none; z-index: 9999; overflow: hidden; }
        .ll-confetti i { position: absolute; top: -20px; width: 10px; height: 14px; opacity: 0.95; animation: ll-fall linear forwards; border-radius: 2px; }

        .ll-related { margin-top: 22px; }
        .ll-related h2 { font-size: 22px; color: #3d0b55; margin-bottom: 12px; }
        .ll-related-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; }
        .ll-rt { display: block; text-decoration: none; background: #fff; border-radius: 16px; padding: 16px 12px; text-align: center; box-shadow: 0 10px 24px rgba(0,0,0,0.06); border-top: 4px solid #E63946; color: inherit; transition: transform .15s ease, box-shadow .2s ease; }
        .ll-rt:hover { transform: translateY(-3px); box-shadow: 0 16px 32px rgba(0,0,0,0.1); }
        .ll-rt:nth-child(1) { border-color: #ff6b35; }
        .ll-rt:nth-child(2) { border-color: #14b8a6; }
        .ll-rt:nth-child(3) { border-color: #E63946; }
        .ll-rt:nth-child(4) { border-color: #7B2D8B; }
        .ll-rt-icon { font-size: 28px; }
        .ll-rt h4 { font-size: 14.5px; color: #1f1933; margin: 6px 0 4px; }
        .ll-rt p { font-size: 12.5px; color: #5b5070; margin: 0; }

        @keyframes ll-pulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.08); } }
        @keyframes ll-bob { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-6px); } }
        @keyframes ll-ringa { 0% { transform: scale(0.6); opacity: 0.9; } 100% { transform: scale(1.4); opacity: 0; } }
        @keyframes ll-fadeUp { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes ll-pop { 0% { transform: scale(0.4); opacity: 0; } 70% { transform: scale(1.15); } 100% { transform: scale(1); opacity: 1; } }
        @keyframes ll-fall { 0% { transform: translateY(-20px) rotate(0); opacity: 1; } 100% { transform: translateY(110vh) rotate(720deg); opacity: 0.3; } }

        @media (max-width: 640px) {
            .ll-wrap { padding: 8px; }
            .ll-header { padding: 22px 16px; border-radius: 18px; }
            .ll-header h1 { font-size: 28px; }
            .ll-header-icon { font-size: 44px; }
            .ll-stat-num { font-size: 16px; }
            .ll-card { padding: 20px 16px; border-radius: 18px; }
            .ll-qtext { font-size: 18px; }
            .ll-twocol { grid-template-columns: 1fr; }
            .ll-share { grid-template-columns: repeat(2, 1fr); }
            .ll-related-grid { grid-template-columns: repeat(2, 1fr); }
            .ll-langs-preview { grid-template-columns: repeat(5, 1fr); gap: 6px; }
            .ll-lp-name { font-size: 9.5px; }
        }
        @media (max-width: 380px) { .ll-header h1 { font-size: 24px; } }
    </style>

    <header class="ll-header">
        <div class="ll-header-icon">&#128140;</div>
        <h1>Love Language Test</h1>
        <p class="ll-header-sub">Discover how you most naturally give &amp; receive love</p>
        <div class="ll-stats">
            <div class="ll-stat"><div class="ll-stat-num" id="ll-counter">3,26,774</div><div class="ll-stat-lbl">Tests Today</div></div>
            <div class="ll-stat"><div class="ll-stat-num">4.9&#9733;</div><div class="ll-stat-lbl">Rating</div></div>
            <div class="ll-stat"><div class="ll-stat-num">12</div><div class="ll-stat-lbl">Questions</div></div>
        </div>
    </header>

    <section class="ll-card" id="ll-card">
        <div class="ll-intro" id="ll-intro">
            <h2>What&rsquo;s Your Love Language?</h2>
            <p>Answer 12 quick questions honestly. There are no right or wrong answers &mdash; just pick what feels most true for you. Takes under 2 minutes.</p>
            <div class="ll-langs-preview">
                <div class="ll-lp"><div class="ll-lp-icon">&#128172;</div><div class="ll-lp-name">Words</div></div>
                <div class="ll-lp"><div class="ll-lp-icon">&#9200;</div><div class="ll-lp-name">Time</div></div>
                <div class="ll-lp"><div class="ll-lp-icon">&#127873;</div><div class="ll-lp-name">Gifts</div></div>
                <div class="ll-lp"><div class="ll-lp-icon">&#128296;</div><div class="ll-lp-name">Service</div></div>
                <div class="ll-lp"><div class="ll-lp-icon">&#129303;</div><div class="ll-lp-name">Touch</div></div>
            </div>
            <button type="button" class="ll-btn ll-btn-primary" id="ll-start-btn">Start The Test &#128140;</button>
            <div class="ll-trust"><span>&#128274; Private</span><span>&#9889; 2 Minutes</span><span>&#127378; Free</span></div>
        </div>

        <div class="ll-quiz" id="ll-quiz">
            <div class="ll-qhead">
                <span class="ll-qcount" id="ll-qcount">Question 1 of 12</span>
                <button type="button" class="ll-qback" id="ll-qback" disabled>&#8592; Back</button>
            </div>
            <div class="ll-progress"><div class="ll-progress-bar" id="ll-progress-bar"></div></div>
            <div class="ll-qtext" id="ll-qtext">&mdash;</div>
            <div class="ll-options" id="ll-options"></div>
        </div>

        <div class="ll-loading" id="ll-loading">
            <div class="ll-rings"><div class="ll-ring"></div><div class="ll-ring"></div><div class="ll-ring"></div><div class="ll-ring-heart">&#128156;</div></div>
            <div class="ll-load-step" id="ll-load-step">&#128150; Reading your answers...</div>
        </div>

        <div class="ll-result" id="ll-result">
            <div class="ll-result-card">
                <div class="ll-rc-tag">Your Primary Love Language</div>
                <div class="ll-rc-icon" id="ll-rc-icon">&#128172;</div>
                <div class="ll-rc-name" id="ll-rc-name">Words of Affirmation</div>
                <div class="ll-rc-pct" id="ll-rc-pct">&mdash;</div>
                <p class="ll-rc-desc" id="ll-rc-desc">&mdash;</p>
                <div class="ll-watermark">lovecalculator.in &#10084;</div>
            </div>

            <div class="ll-section">
                <h3>&#128202; Your Full Love Language Breakdown</h3>
                <div class="ll-bars" id="ll-bars"></div>
            </div>

            <div class="ll-twocol">
                <div class="ll-mini ll-m1"><h4>&#128150; How You Feel Loved</h4><p id="ll-receive">&mdash;</p></div>
                <div class="ll-mini ll-m2"><h4>&#129309; How To Love You Back</h4><p id="ll-give">&mdash;</p></div>
            </div>

            <div class="ll-tips">
                <h3 id="ll-tips-title">&#11088; Make Your Love Language Work</h3>
                <ul id="ll-tips-list"></ul>
            </div>

            <div class="ll-share">
                <a href="#" class="ll-share-btn ll-sb-wa" id="ll-sb-wa" target="_blank" rel="noopener">&#128241; WhatsApp</a>
                <a href="#" class="ll-share-btn ll-sb-tw" id="ll-sb-tw" target="_blank" rel="noopener">&#119991; Twitter</a>
                <button type="button" class="ll-share-btn ll-sb-save" id="ll-sb-save">&#128247; Save</button>
                <button type="button" class="ll-share-btn ll-sb-copy" id="ll-sb-copy">&#128279; Copy Link</button>
            </div>
            <button type="button" class="ll-btn ll-try" id="ll-try-btn">&#128260; Retake Test</button>
        </div>
    </section>

    <section class="ll-related">
        <h2>Try More Love Tools</h2>
        <div class="ll-related-grid">
            <a class="ll-rt" href="/love-calculator/"><div class="ll-rt-icon">&#128149;</div><h4>Love Calculator</h4><p>Name compatibility test</p></a>
            <a class="ll-rt" href="/compatibility-test/"><div class="ll-rt-icon">&#128302;</div><h4>Compatibility</h4><p>Zodiac match score</p></a>
            <a class="ll-rt" href="/love-message-generator/"><div class="ll-rt-icon">&#128140;</div><h4>Love Messages</h4><p>Sweet messages for any moment</p></a>
            <a class="ll-rt" href="/couple-nickname-generator/"><div class="ll-rt-icon">&#128139;</div><h4>Couple Nicknames</h4><p>Cute pet names for you two</p></a>
        </div>
    </section>

    <script type="application/ld+json">
    { "@context": "https://schema.org", "@type": "SoftwareApplication", "name": "Love Language Test", "applicationCategory": "LifestyleApplication", "operatingSystem": "Web", "url": "https://lovecalculator.in/love-language-test/", "offers": { "@type": "Offer", "price": "0", "priceCurrency": "USD" }, "aggregateRating": { "@type": "AggregateRating", "ratingValue": "4.9", "ratingCount": "15904" } }
    </script>
</div>
        <?php
        $ll_html = ob_get_clean();

        // Deliver the behavioral JS via the footer so WordPress content
        // filters (wpautop) can never inject tags that break the script.
        ob_start();
        ?>
(function(){
    'use strict';
    var $ = function(id){ return document.getElementById(id); };

    var LANGS = {
        words:   { name:'Words of Affirmation', icon:'💬', color:'#E63946',
                   desc:'Kind words, compliments and verbal encouragement mean the world to you. Hearing "I love you", "I’m proud of you" or a heartfelt thank-you fills your heart like nothing else.',
                   receive:'You feel most loved through spoken and written affection — compliments, encouragement, sweet texts and genuine appreciation.',
                   give:'To love you, your partner should speak kindly, praise you often, leave loving notes and never underestimate the power of "I love you".',
                   tips:['Tell your partner exactly which words light you up the most.','Keep a note of compliments that made your day and revisit them.','Ask for verbal reassurance instead of waiting silently for it.'] },
        time:    { name:'Quality Time', icon:'⏰', color:'#7B2D8B',
                   desc:'Undivided, present attention is your love fuel. Phones away, real conversation, shared activities — being truly seen and heard is what makes you feel deeply connected.',
                   receive:'You feel most loved when someone gives you their full, undistracted presence and makes time for you a priority.',
                   give:'To love you, your partner should plan one-on-one time, put devices aside and be fully present during your moments together.',
                   tips:['Schedule a regular phone-free "us" time each week.','Suggest activities you can do together, not just side by side.','Tell your partner that presence matters more than presents to you.'] },
        gifts:   { name:'Receiving Gifts', icon:'🎁', color:'#fbbf24',
                   desc:'It’s never about the price — it’s the thought. A small, meaningful gift tells you "I was thinking of you", and that symbol of love speaks straight to your heart.',
                   receive:'You feel most loved through thoughtful, meaningful gifts and tokens that show your partner was thinking of you.',
                   give:'To love you, your partner should surprise you with little meaningful things and remember the items you mention in passing.',
                   tips:['Share a subtle wish-list so gifts feel effortless for your partner.','Treasure the thought behind a gift more than its size.','Give the kind of gifts you love — your partner will learn your language.'] },
        service: { name:'Acts of Service', icon:'🛠️', color:'#14b8a6',
                   desc:'Actions speak louder than words for you. When someone helps with a task, eases your load or does something kind without being asked, you feel genuinely cherished.',
                   receive:'You feel most loved when your partner does helpful, thoughtful things that make your life easier — actions over announcements.',
                   give:'To love you, your partner should pitch in, handle chores, run errands and show care through doing rather than just saying.',
                   tips:['Tell your partner which specific tasks would mean the most.','Notice and thank the small helpful things they already do.','Offer acts of service in return — it’s how you show love best.'] },
        touch:   { name:'Physical Touch', icon:'🤗', color:'#ff6b9d',
                   desc:'A hug, a hand held, a gentle touch — physical closeness is how you feel safe and connected. Affectionate contact reassures you more than any words could.',
                   receive:'You feel most loved through physical affection — hugs, hand-holding, cuddles and being physically close.',
                   give:'To love you, your partner should be physically affectionate, offer plenty of hugs and stay close during your time together.',
                   tips:['Tell your partner how much daily affection means to you.','Initiate small touches — it invites the closeness you crave.','Make space for cuddle time, it recharges your connection.'] }
    };
    var ORDER = ['words','time','gifts','service','touch'];

    var QUESTIONS = [
        { q:'What makes you feel most loved?', a:{t:'Hearing "I love you" and sweet compliments', l:'words'}, b:{t:'Spending uninterrupted time together', l:'time'} },
        { q:'A perfect date night looks like...', a:{t:'A thoughtful little surprise gift', l:'gifts'}, b:{t:'Cuddling close on the couch', l:'touch'} },
        { q:'When you’re stressed, you most want your partner to...', a:{t:'Take a task off your plate', l:'service'}, b:{t:'Tell you everything will be okay', l:'words'} },
        { q:'You feel closest to someone when they...', a:{t:'Hold your hand or hug you', l:'touch'}, b:{t:'Give you their full attention', l:'time'} },
        { q:'The nicest thing a partner can do is...', a:{t:'Run an errand or fix something for you', l:'service'}, b:{t:'Bring you a small meaningful present', l:'gifts'} },
        { q:'You’d rather receive...', a:{t:'A heartfelt handwritten note', l:'words'}, b:{t:'A long, warm hug', l:'touch'} },
        { q:'On your birthday you most hope for...', a:{t:'A carefully chosen gift', l:'gifts'}, b:{t:'A whole day spent just with you', l:'time'} },
        { q:'You appreciate it most when your partner...', a:{t:'Praises you in front of others', l:'words'}, b:{t:'Cooks for you or handles a chore', l:'service'} },
        { q:'Physical closeness for you is...', a:{t:'Essential — touch says it all', l:'touch'}, b:{t:'Nice, but quality time matters more', l:'time'} },
        { q:'A truly meaningful gesture is...', a:{t:'Acting on the little things you need', l:'service'}, b:{t:'Surprising you with something you mentioned once', l:'gifts'} },
        { q:'You feel disconnected when your partner...', a:{t:'Is distracted and never fully present', l:'time'}, b:{t:'Rarely says anything affirming or kind', l:'words'} },
        { q:'Your love tank fills up most from...', a:{t:'Physical affection and closeness', l:'touch'}, b:{t:'Gifts that show they were thinking of you', l:'gifts'} }
    ];

    var phases = { intro:$('ll-intro'), quiz:$('ll-quiz'), loading:$('ll-loading'), result:$('ll-result') };
    var state = { idx:0, answers:[] };

    function escapeHtml(s){ return String(s).replace(/[&<>"']/g,function(c){return ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'})[c];}); }

    function renderQuestion(){
        var qd = QUESTIONS[state.idx];
        $('ll-qcount').textContent = 'Question ' + (state.idx+1) + ' of ' + QUESTIONS.length;
        $('ll-progress-bar').style.width = ((state.idx) / QUESTIONS.length * 100) + '%';
        $('ll-qtext').textContent = qd.q;
        $('ll-qback').disabled = state.idx === 0;
        var host = $('ll-options'); host.innerHTML = '';
        [['A', qd.a], ['B', qd.b]].forEach(function(pair){
            var key = pair[0], opt = pair[1];
            var btn = document.createElement('button');
            btn.type = 'button'; btn.className = 'll-opt';
            btn.innerHTML = '<span class="ll-opt-key">' + key + '</span><span>' + escapeHtml(opt.t) + '</span>';
            btn.addEventListener('click', function(){ choose(opt.l); });
            host.appendChild(btn);
        });
    }

    function choose(lang){
        state.answers[state.idx] = lang;
        if (state.idx < QUESTIONS.length - 1){ state.idx++; renderQuestion(); }
        else { finish(); }
    }

    $('ll-qback').addEventListener('click', function(){ if (state.idx > 0){ state.idx--; renderQuestion(); } });

    function tally(){
        var sc = { words:0, time:0, gifts:0, service:0, touch:0 };
        state.answers.forEach(function(l){ if (sc.hasOwnProperty(l)) sc[l]++; });
        return sc;
    }

    function finish(){
        $('ll-progress-bar').style.width = '100%';
        phases.quiz.classList.remove('ll-show');
        phases.loading.classList.add('ll-show');
        setTimeout(showResult, 1400);
    }

    function confetti(){ var colors=['#E63946','#ff6b9d','#fbbf24','#7B2D8B','#fff']; var box=document.createElement('div'); box.className='ll-confetti'; for(var i=0;i<55;i++){ var p=document.createElement('i'); p.style.left=(Math.random()*100)+'%'; p.style.background=colors[Math.floor(Math.random()*colors.length)]; p.style.animationDuration=(1.5+Math.random()*2)+'s'; p.style.animationDelay=(Math.random()*0.5)+'s'; p.style.transform='rotate('+(Math.random()*360)+'deg)'; box.appendChild(p);} document.body.appendChild(box); setTimeout(function(){ box.remove(); },4000); }

    function showResult(){
        var sc = tally();
        var total = state.answers.length || 1;
        // primary = highest, tie broken by ORDER
        var primary = ORDER[0], best = -1;
        ORDER.forEach(function(k){ if (sc[k] > best){ best = sc[k]; primary = k; } });
        var pd = LANGS[primary];

        $('ll-rc-icon').textContent = pd.icon;
        $('ll-rc-name').textContent = pd.name;
        $('ll-rc-pct').textContent = Math.round(sc[primary]/total*100) + '% of your answers';
        $('ll-rc-desc').textContent = pd.desc;
        $('ll-receive').textContent = pd.receive;
        $('ll-give').textContent = pd.give;

        // breakdown bars sorted desc
        var rows = ORDER.map(function(k){ return { k:k, v:Math.round(sc[k]/total*100) }; });
        rows.sort(function(a,b){ return b.v - a.v; });
        var bars = $('ll-bars'); bars.innerHTML = '';
        rows.forEach(function(r, idx){
            var L = LANGS[r.k];
            var row = document.createElement('div'); row.className = 'll-bar-row';
            row.innerHTML = '<div class="ll-bar-top"><span>' + L.icon + ' ' + L.name + '</span><span>' + r.v + '%</span></div><div class="ll-bar"><div class="ll-bar-fill" id="ll-bf-' + r.k + '"></div></div>';
            bars.appendChild(row);
            (function(k, v, color){ setTimeout(function(){ var f=$('ll-bf-'+k); if(f){ f.style.background='linear-gradient(90deg,'+color+',#7B2D8B)'; f.style.width=v+'%'; } }, 150 + idx*120); })(r.k, r.v, L.color);
        });

        // tips
        $('ll-tips-title').innerHTML = '⭐ Make ' + escapeHtml(pd.name) + ' Work For You';
        var ul = $('ll-tips-list'); ul.innerHTML = '';
        pd.tips.forEach(function(t){ var li=document.createElement('li'); li.textContent=t; ul.appendChild(li); });

        setupShare(pd, sc[primary], total);

        phases.loading.classList.remove('ll-show');
        phases.result.classList.add('ll-show');
        setTimeout(confetti, 500);
        setTimeout(function(){ phases.result.scrollIntoView({behavior:'smooth',block:'start'}); }, 100);
    }

    function setupShare(pd, count, total){
        var url = window.location.href;
        var pct = Math.round(count/total*100);
        var msg = '💌 My Love Language is *' + pd.name + '* (' + pct + '%)!\n\nFind out yours: ' + url;
        var tweet = 'My love language is ' + pd.name + ' ' + pd.icon + ' What’s yours? Take the test:';
        $('ll-sb-wa').href = 'https://wa.me/?text=' + encodeURIComponent(msg);
        $('ll-sb-tw').href = 'https://twitter.com/intent/tweet?text=' + encodeURIComponent(tweet) + '&url=' + encodeURIComponent(url);
        $('ll-sb-copy').onclick = function(){ var b=this,o=b.innerHTML; try{ if(navigator.clipboard){ navigator.clipboard.writeText(url).then(function(){ b.innerHTML='✅ Copied!'; setTimeout(function(){ b.innerHTML=o; },1800); }); } else { var ta=document.createElement('textarea'); ta.value=url; document.body.appendChild(ta); ta.select(); document.execCommand('copy'); ta.remove(); b.innerHTML='✅ Copied!'; setTimeout(function(){ b.innerHTML=o; },1800);} }catch(e){ b.innerHTML='⚠ Try Manually'; setTimeout(function(){ b.innerHTML=o; },1800);} };
        $('ll-sb-save').onclick = function(){ var b=this,o=b.innerHTML; b.innerHTML='📸 Saving...'; setTimeout(function(){ if(navigator.share){ navigator.share({title:'My Love Language',text:msg,url:url}).then(function(){ b.innerHTML=o; }).catch(function(){ alert('Screenshot your result to save it!'); b.innerHTML=o; }); } else { alert('Screenshot your result to save it!\n\nMy Love Language: '+pd.name); b.innerHTML=o; } },400); };
    }

    $('ll-start-btn').addEventListener('click', function(){
        state.idx = 0; state.answers = [];
        phases.intro.style.display = 'none';
        phases.quiz.classList.add('ll-show');
        renderQuestion();
    });

    $('ll-try-btn').addEventListener('click', function(){
        phases.result.classList.remove('ll-show');
        phases.loading.classList.remove('ll-show');
        state.idx = 0; state.answers = [];
        phases.intro.style.display = 'block';
        $('ll-card').scrollIntoView({behavior:'smooth',block:'start'});
    });

    var counterEl=$('ll-counter'); var count=326774;
    setInterval(function(){ count+=1+Math.floor(Math.random()*4); counterEl.textContent=count.toLocaleString('en-IN'); },8000);
})();
        <?php
        $ll_js = ob_get_clean();

        if ( ! wp_script_is( 'll-pro-inline', 'enqueued' ) ) {
            wp_register_script( 'll-pro-inline', '', array(), '1.0.0', true );
            wp_enqueue_script( 'll-pro-inline' );
            wp_add_inline_script( 'll-pro-inline', $ll_js );
        }

        return $ll_html;
    }

    add_shortcode( 'love_language_test', 'll_pro_render_test' );
    add_shortcode( 'love_language_quiz', 'll_pro_render_test' );
    add_shortcode( 'love_language', 'll_pro_render_test' );
}
