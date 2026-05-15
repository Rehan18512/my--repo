<?php
/**
 * Plugin Name: Love Calculator Pro — Full Suite
 * Plugin URI: https://lovecalculator.in
 * Description: 4-in-1 Premium Calculator Suite: [love_calculator] [friendship_calculator] [mulank_calculator] [crush_calculator]. Animated, bilingual EN/HI, advanced mode, SEO-optimized, 2026 ready.
 * Version: 2.0.0
 * Author: lovecalculator.in
 * License: GPL-2.0+
 * Text Domain: love-calculator-pro
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

// ═══════════════════════════════════════════════════════════════
// 1. LOVE CALCULATOR  [love_calculator]
// ═══════════════════════════════════════════════════════════════
if ( ! function_exists( 'lc_pro_render_calculator' ) ) {
function lc_pro_render_calculator( $atts = [] ) {
    ob_start(); ?>
<div class="lc-wrap" id="lc-wrap">
<style>
.lc-wrap,.lc-wrap *,.lc-wrap *::before,.lc-wrap *::after{box-sizing:border-box}
.lc-wrap{font-family:'DM Sans','Inter',-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;color:#1f1933;max-width:880px;margin:0 auto;padding:12px;line-height:1.55}
.lc-wrap h1,.lc-wrap h2,.lc-wrap h3,.lc-wrap h4{font-family:'Poppins','Syne',system-ui,sans-serif;font-weight:800;letter-spacing:-.01em;margin:0}
.lc-header{background:linear-gradient(135deg,#1a0533 0%,#3d0b55 50%,#690d3a 100%);border-radius:22px;padding:28px 20px;color:#fff;text-align:center;box-shadow:0 20px 60px rgba(105,13,58,.25);position:relative;overflow:hidden}
.lc-header::before{content:"";position:absolute;inset:-50%;background:radial-gradient(circle at 30% 20%,rgba(230,57,70,.18),transparent 60%),radial-gradient(circle at 70% 80%,rgba(123,45,139,.25),transparent 60%);pointer-events:none}
.lc-header-icon{font-size:50px;line-height:1;display:inline-block;animation:lc-bob 2.4s ease-in-out infinite}
.lc-header h1{font-size:38px;margin:8px 0 6px;color:#fff}
.lc-header-sub{opacity:.86;font-size:15px;margin:0}
.lc-stats{display:flex;align-items:center;justify-content:center;gap:0;margin-top:18px;flex-wrap:wrap}
.lc-stat{padding:4px 14px;min-width:96px}
.lc-stat-num{font-weight:800;font-family:'Poppins',sans-serif;font-size:18px;color:#fff}
.lc-stat-lbl{font-size:11px;opacity:.78;text-transform:uppercase;letter-spacing:.06em}
.lc-stat+.lc-stat{border-left:1px solid rgba(255,255,255,.22)}
.lc-card{background:#fff;border-radius:22px;padding:24px 20px;margin-top:18px;box-shadow:0 20px 60px rgba(0,0,0,.08);border:1px solid #f1ecf6}
.lc-inputs{display:grid;grid-template-columns:1fr auto 1fr;gap:14px;align-items:center}
.lc-field{display:flex;flex-direction:column;align-items:center;gap:10px}
.lc-avatar{width:64px;height:64px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-family:'Poppins',sans-serif;font-weight:800;font-size:26px;color:#fff;box-shadow:0 8px 24px rgba(0,0,0,.18);transition:transform .25s ease}
.lc-avatar.lc-a{background:linear-gradient(135deg,#E63946,#ff6b9d)}
.lc-avatar.lc-b{background:linear-gradient(135deg,#7B2D8B,#b558d6)}
.lc-avatar:hover{transform:scale(1.04)}
.lc-input{width:100%;min-height:52px;padding:12px 14px;font-size:16px;border:2px solid #ece6f3;border-radius:14px;outline:none;background:#faf8fd;transition:border-color .2s,background .2s,box-shadow .2s;font-family:inherit}
.lc-input:focus{border-color:#E63946;background:#fff;box-shadow:0 0 0 4px rgba(230,57,70,.12)}
.lc-vs{width:56px;height:56px;border-radius:50%;background:linear-gradient(135deg,#E63946,#7B2D8B);color:#fff;display:flex;align-items:center;justify-content:center;font-size:22px;font-weight:800;font-family:'Poppins',sans-serif;box-shadow:0 10px 24px rgba(230,57,70,.35);animation:lc-pulse 1.6s ease-in-out infinite}
.lc-btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;min-height:56px;padding:18px 22px;font-size:17px;font-weight:700;font-family:'Poppins',sans-serif;border:none;border-radius:14px;cursor:pointer;width:100%;transition:transform .15s ease,box-shadow .2s ease,opacity .2s}
.lc-btn-primary{background:linear-gradient(135deg,#E63946,#c81e2c);color:#fff;box-shadow:0 14px 32px rgba(230,57,70,.35);margin-top:18px}
.lc-btn-primary:hover{transform:translateY(-2px);box-shadow:0 18px 40px rgba(230,57,70,.45)}
.lc-trust{display:flex;gap:10px;justify-content:center;flex-wrap:wrap;margin-top:14px}
.lc-trust span{font-size:12.5px;color:#5b5070;background:#f6f0fb;padding:6px 12px;border-radius:999px;min-height:30px;display:inline-flex;align-items:center}
.lc-error{display:none;background:#fff1f2;color:#b3162a;border:1px solid #ffd6db;padding:10px 14px;border-radius:12px;margin-top:12px;font-size:14px;text-align:center}
.lc-error.lc-show{display:block;animation:lc-shake .4s}
.lc-loading{display:none;text-align:center;padding:14px 8px 6px}
.lc-loading.lc-show{display:block}
.lc-rings{position:relative;width:160px;height:160px;margin:6px auto 18px}
.lc-ring{position:absolute;inset:0;border-radius:50%;border:3px solid rgba(230,57,70,.35);animation:lc-ring 2s ease-out infinite}
.lc-ring:nth-child(2){animation-delay:.5s;border-color:rgba(123,45,139,.4)}
.lc-ring:nth-child(3){animation-delay:1s;border-color:rgba(255,107,157,.45)}
.lc-ring-heart{position:absolute;inset:0;display:flex;align-items:center;justify-content:center;font-size:60px;animation:lc-pulse 1.2s ease-in-out infinite}
.lc-load-names{font-size:18px;font-weight:700;font-family:'Poppins',sans-serif;color:#3d0b55;margin-bottom:12px}
.lc-load-step{font-size:15px;color:#6b5e85;min-height:24px;transition:opacity .25s}
.lc-progress{height:8px;background:#f1ebf7;border-radius:999px;overflow:hidden;margin:14px auto 4px;max-width:360px}
.lc-progress-bar{height:100%;width:0%;background:linear-gradient(90deg,#E63946,#7B2D8B);border-radius:999px;transition:width .3s ease}
.lc-result{display:none}
.lc-result.lc-show{display:block;animation:lc-fadeUp .55s ease both}
.lc-result-card{background:linear-gradient(135deg,#1a0533,#3d0b55,#690d3a);color:#fff;border-radius:22px;padding:28px 20px;text-align:center;box-shadow:0 20px 60px rgba(0,0,0,.25);position:relative;overflow:hidden}
.lc-result-card::after{content:"";position:absolute;inset:0;background:radial-gradient(circle at 20% 10%,rgba(230,57,70,.25),transparent 50%),radial-gradient(circle at 80% 90%,rgba(255,107,157,.18),transparent 55%);pointer-events:none}
.lc-rc-names{display:flex;align-items:center;justify-content:center;gap:14px;flex-wrap:wrap;margin-bottom:6px;position:relative;z-index:1}
.lc-rc-name{display:flex;align-items:center;gap:10px;font-weight:700;font-family:'Poppins',sans-serif;font-size:17px}
.lc-rc-name .lc-avatar{width:44px;height:44px;font-size:18px}
.lc-rc-heart{font-size:22px;opacity:.85}
.lc-ring-wrap{position:relative;width:220px;height:220px;margin:14px auto 10px;z-index:1}
.lc-ring-wrap svg{transform:rotate(-90deg);width:100%;height:100%}
.lc-ring-bg{fill:none;stroke:rgba(255,255,255,.12);stroke-width:12}
.lc-ring-fg{fill:none;stroke:url(#lc-grad);stroke-width:12;stroke-linecap:round;transition:stroke-dashoffset 1.8s cubic-bezier(.22,.9,.3,1)}
.lc-percent{position:absolute;inset:0;display:flex;align-items:center;justify-content:center;flex-direction:column}
.lc-percent-num{font-size:64px;font-weight:800;font-family:'Poppins',sans-serif;line-height:1}
.lc-percent-sym{font-size:24px;font-weight:700;opacity:.85}
.lc-level{display:inline-block;background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.22);padding:8px 18px;border-radius:999px;font-weight:700;font-family:'Poppins',sans-serif;font-size:15px;margin:6px 0 10px;position:relative;z-index:1}
.lc-rc-desc{max-width:580px;margin:0 auto;opacity:.92;font-size:15px;position:relative;z-index:1}
.lc-watermark{margin-top:14px;font-size:12.5px;opacity:.7;position:relative;z-index:1}
.lc-bars{margin-top:6px}
.lc-bar-row{margin:14px 0}
.lc-bar-top{display:flex;justify-content:space-between;font-size:14px;font-weight:600;color:#2d2447;margin-bottom:6px}
.lc-bar-top span:last-child{color:#7B2D8B;font-family:'Poppins',sans-serif;font-weight:800}
.lc-bar{height:10px;background:#f1ebf7;border-radius:999px;overflow:hidden}
.lc-bar-fill{height:100%;width:0%;border-radius:999px;background:linear-gradient(90deg,#E63946,#7B2D8B);transition:width 1.5s cubic-bezier(.22,.9,.3,1)}
.lc-hints{background:linear-gradient(135deg,#fff8dc,#fff1c1);border-radius:18px;padding:20px;margin-top:18px;border:1px solid #f7e190}
.lc-hints h3{font-size:19px;color:#7a5a05;margin-bottom:12px}
.lc-hints-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:12px}
.lc-hint{background:#fff;border-radius:14px;padding:14px;border-left:4px solid #E63946;box-shadow:0 8px 20px rgba(0,0,0,.05);opacity:0;transform:translateY(8px);animation:lc-fadeUp .5s ease forwards}
.lc-hint-icon{font-size:22px;margin-bottom:4px}
.lc-hint h4{font-size:14.5px;color:#3d0b55;margin-bottom:4px}
.lc-hint p{font-size:13px;color:#5b5070;margin:0}
.lc-advice{background:linear-gradient(135deg,#e7f7ec,#d2efdc);border-radius:18px;padding:20px;margin-top:16px;border:1px solid #b8e2c5}
.lc-advice h3{font-size:18px;color:#155d3a;margin-bottom:8px}
.lc-advice p{font-style:italic;color:#1f3f2c;margin:0 0 12px}
.lc-tags{display:flex;flex-wrap:wrap;gap:8px}
.lc-tag{background:#fff;padding:6px 12px;border-radius:999px;font-size:12.5px;font-weight:600;color:#155d3a;border:1px solid #b8e2c5}
.lc-tag.lc-t2{color:#6c2dba;border-color:#d8c1f0}
.lc-tag.lc-t3{color:#b3162a;border-color:#ffc8ce}
.lc-tag.lc-t4{color:#b6770b;border-color:#f4dca0}
.lc-share{display:grid;grid-template-columns:repeat(4,1fr);gap:10px;margin-top:18px}
.lc-share-btn{display:inline-flex;align-items:center;justify-content:center;gap:6px;min-height:48px;padding:12px 8px;font-size:14px;font-weight:700;font-family:'Poppins',sans-serif;border-radius:12px;border:none;cursor:pointer;color:#fff;text-decoration:none;transition:transform .15s ease,box-shadow .15s ease}
.lc-share-btn:hover{transform:translateY(-2px);box-shadow:0 12px 26px rgba(0,0,0,.15)}
.lc-sb-wa{background:#25d366}.lc-sb-tw{background:#111}
.lc-sb-save{background:linear-gradient(135deg,#E63946,#7B2D8B)}.lc-sb-copy{background:#5b5b6e}
.lc-try{margin-top:14px;background:#fff;color:#3d0b55;border:2px solid #ece6f3}
.lc-try:hover{border-color:#7B2D8B;color:#7B2D8B}
.lc-confetti{position:fixed;inset:0;pointer-events:none;z-index:9999;overflow:hidden}
.lc-confetti i{position:absolute;top:-20px;width:10px;height:14px;opacity:.95;animation:lc-fall linear forwards;border-radius:2px}
.lc-levels{display:grid;grid-template-columns:repeat(5,1fr);gap:10px;margin-top:22px}
.lc-lvl{background:#fff;border-radius:16px;padding:14px 10px;text-align:center;box-shadow:0 10px 24px rgba(0,0,0,.06);border-top:4px solid #E63946}
.lc-lvl:nth-child(1){border-color:#d4af37}.lc-lvl:nth-child(2){border-color:#E63946}.lc-lvl:nth-child(3){border-color:#7B2D8B}.lc-lvl:nth-child(4){border-color:#2563eb}.lc-lvl:nth-child(5){border-color:#14b8a6}
.lc-lvl-icon{font-size:26px}.lc-lvl h4{font-size:14px;color:#1f1933;margin:4px 0}.lc-lvl-range{font-size:12px;color:#7B2D8B;font-weight:700}.lc-lvl-desc{font-size:12px;color:#5b5070;margin:4px 0 0}
.lc-related{margin-top:22px}.lc-related h2{font-size:22px;color:#3d0b55;margin-bottom:12px}
.lc-related-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:12px}
.lc-rt{display:block;text-decoration:none;background:#fff;border-radius:16px;padding:16px 12px;text-align:center;box-shadow:0 10px 24px rgba(0,0,0,.06);border-top:4px solid #E63946;color:inherit;transition:transform .15s ease,box-shadow .2s ease}
.lc-rt:hover{transform:translateY(-3px);box-shadow:0 16px 32px rgba(0,0,0,.1)}
.lc-rt:nth-child(1){border-color:#ff6b35}.lc-rt:nth-child(2){border-color:#14b8a6}.lc-rt:nth-child(3){border-color:#E63946}.lc-rt:nth-child(4){border-color:#7B2D8B}
.lc-rt-icon{font-size:28px}.lc-rt h4{font-size:14.5px;color:#1f1933;margin:6px 0 4px}.lc-rt p{font-size:12.5px;color:#5b5070;margin:0}
@keyframes lc-pulse{0%,100%{transform:scale(1)}50%{transform:scale(1.08)}}
@keyframes lc-bob{0%,100%{transform:translateY(0)}50%{transform:translateY(-6px)}}
@keyframes lc-ring{0%{transform:scale(.6);opacity:.9}100%{transform:scale(1.4);opacity:0}}
@keyframes lc-fadeUp{from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:translateY(0)}}
@keyframes lc-shake{0%,100%{transform:translateX(0)}25%{transform:translateX(-4px)}75%{transform:translateX(4px)}}
@keyframes lc-fall{0%{transform:translateY(-20px) rotate(0);opacity:1}100%{transform:translateY(110vh) rotate(720deg);opacity:.3}}
@media(max-width:640px){.lc-wrap{padding:8px}.lc-header{padding:22px 16px;border-radius:18px}.lc-header h1{font-size:30px}.lc-header-icon{font-size:44px}.lc-card{padding:20px 16px;border-radius:18px}.lc-inputs{grid-template-columns:1fr;gap:12px}.lc-vs{margin:-4px auto}.lc-percent-num{font-size:56px}.lc-ring-wrap{width:200px;height:200px}.lc-share{grid-template-columns:repeat(2,1fr)}.lc-levels{grid-template-columns:repeat(2,1fr)}.lc-related-grid{grid-template-columns:repeat(2,1fr)}.lc-hints-grid{grid-template-columns:1fr}}
</style>
<header class="lc-header">
  <div class="lc-header-icon">&#128157;</div>
  <h1>Love Calculator</h1>
  <p class="lc-header-sub">Find your true love compatibility in seconds</p>
  <div class="lc-stats">
    <div class="lc-stat"><div class="lc-stat-num" id="lc-counter">3,84,219</div><div class="lc-stat-lbl">Tests Today</div></div>
    <div class="lc-stat"><div class="lc-stat-num">4.9&#9733;</div><div class="lc-stat-lbl">Rating</div></div>
    <div class="lc-stat"><div class="lc-stat-num">100%</div><div class="lc-stat-lbl">Free</div></div>
  </div>
</header>
<section class="lc-card">
  <div class="lc-input-phase" id="lc-input-phase">
    <div class="lc-inputs">
      <div class="lc-field"><div class="lc-avatar lc-a" id="lc-av-a">?</div><input type="text" class="lc-input" id="lc-name-a" placeholder="Your name" maxlength="30" autocomplete="off"/></div>
      <div class="lc-vs" aria-hidden="true">&#10084;</div>
      <div class="lc-field"><div class="lc-avatar lc-b" id="lc-av-b">?</div><input type="text" class="lc-input" id="lc-name-b" placeholder="Their name" maxlength="30" autocomplete="off"/></div>
    </div>
    <div class="lc-error" id="lc-error">Please enter both names to continue.</div>
    <button type="button" class="lc-btn lc-btn-primary" id="lc-calc-btn">Calculate Love &#10084;</button>
    <div class="lc-trust"><span>&#128274; Private</span><span>&#9889; Instant</span><span>&#127378; Free</span></div>
  </div>
  <div class="lc-loading" id="lc-loading">
    <div class="lc-rings"><div class="lc-ring"></div><div class="lc-ring"></div><div class="lc-ring"></div><div class="lc-ring-heart">&#128156;</div></div>
    <div class="lc-load-names" id="lc-load-names">&#10084;</div>
    <div class="lc-load-step" id="lc-load-step">&#128140; Scanning your names...</div>
    <div class="lc-progress"><div class="lc-progress-bar" id="lc-progress-bar"></div></div>
  </div>
  <div class="lc-result" id="lc-result">
    <div class="lc-result-card">
      <div class="lc-rc-names">
        <div class="lc-rc-name"><div class="lc-avatar lc-a" id="lc-rc-av-a">?</div><span id="lc-rc-n-a">Name 1</span></div>
        <div class="lc-rc-heart">&#10084;</div>
        <div class="lc-rc-name"><div class="lc-avatar lc-b" id="lc-rc-av-b">?</div><span id="lc-rc-n-b">Name 2</span></div>
      </div>
      <div class="lc-ring-wrap">
        <svg viewBox="0 0 200 200" aria-hidden="true">
          <defs><linearGradient id="lc-grad" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#ff6b9d"/><stop offset="100%" stop-color="#fbbf24"/></linearGradient></defs>
          <circle class="lc-ring-bg" cx="100" cy="100" r="86"/>
          <circle class="lc-ring-fg" id="lc-ring-fg" cx="100" cy="100" r="86" stroke-dasharray="540.35" stroke-dashoffset="540.35"/>
        </svg>
        <div class="lc-percent"><div><span class="lc-percent-num" id="lc-pct">0</span><span class="lc-percent-sym">%</span></div></div>
      </div>
      <div class="lc-level" id="lc-level">&#128156; Calculating...</div>
      <p class="lc-rc-desc" id="lc-desc">Your love story is being written...</p>
      <div class="lc-watermark">lovecalculator.in &#10084;</div>
    </div>
    <div class="lc-bars">
      <div class="lc-bar-row"><div class="lc-bar-top"><span>&#128274; Trust</span><span id="lc-b1-v">0%</span></div><div class="lc-bar"><div class="lc-bar-fill" id="lc-b1"></div></div></div>
      <div class="lc-bar-row"><div class="lc-bar-top"><span>&#10024; Chemistry</span><span id="lc-b2-v">0%</span></div><div class="lc-bar"><div class="lc-bar-fill" id="lc-b2"></div></div></div>
      <div class="lc-bar-row"><div class="lc-bar-top"><span>&#128172; Communication</span><span id="lc-b3-v">0%</span></div><div class="lc-bar"><div class="lc-bar-fill" id="lc-b3"></div></div></div>
      <div class="lc-bar-row"><div class="lc-bar-top"><span>&#127881; Long-term Potential</span><span id="lc-b4-v">0%</span></div><div class="lc-bar"><div class="lc-bar-fill" id="lc-b4"></div></div></div>
    </div>
    <div class="lc-hints"><h3 id="lc-hints-title">&#11088; Golden Hints</h3><div class="lc-hints-grid" id="lc-hints-grid"></div></div>
    <div class="lc-advice"><h3>&#129302; Personalized Love Advice</h3><p id="lc-advice-text"></p><div class="lc-tags" id="lc-tags"></div></div>
    <div class="lc-share">
      <a href="#" class="lc-share-btn lc-sb-wa" id="lc-sb-wa" target="_blank" rel="noopener">&#128241; WhatsApp</a>
      <a href="#" class="lc-share-btn lc-sb-tw" id="lc-sb-tw" target="_blank" rel="noopener">&#119991; Twitter</a>
      <button type="button" class="lc-share-btn lc-sb-save" id="lc-sb-save">&#128247; Save</button>
      <button type="button" class="lc-share-btn lc-sb-copy" id="lc-sb-copy">&#128279; Copy</button>
    </div>
    <button type="button" class="lc-btn lc-try" id="lc-try-btn">&#128260; Try Again</button>
  </div>
</section>
<section class="lc-levels">
  <div class="lc-lvl"><div class="lc-lvl-icon">&#128081;</div><h4>Soulmates</h4><div class="lc-lvl-range">90-100%</div><p class="lc-lvl-desc">Made for each other</p></div>
  <div class="lc-lvl"><div class="lc-lvl-icon">&#128149;</div><h4>Perfect Match</h4><div class="lc-lvl-range">70-89%</div><p class="lc-lvl-desc">Strong love bond</p></div>
  <div class="lc-lvl"><div class="lc-lvl-icon">&#128156;</div><h4>Good Potential</h4><div class="lc-lvl-range">50-69%</div><p class="lc-lvl-desc">Worth nurturing</p></div>
  <div class="lc-lvl"><div class="lc-lvl-icon">&#128153;</div><h4>Needs Effort</h4><div class="lc-lvl-range">30-49%</div><p class="lc-lvl-desc">Grow together</p></div>
  <div class="lc-lvl"><div class="lc-lvl-icon">&#129309;</div><h4>Just Friends</h4><div class="lc-lvl-range">0-29%</div><p class="lc-lvl-desc">Friendship is gold</p></div>
</section>
<section class="lc-related">
  <h2>Try More Love Tools</h2>
  <div class="lc-related-grid">
    <a class="lc-rt" href="/flames-calculator/"><div class="lc-rt-icon">&#128293;</div><h4>FLAMES</h4><p>Friends, Love, Affection, Marriage, Enemies, Siblings</p></a>
    <a class="lc-rt" href="/friendship-calculator/"><div class="lc-rt-icon">&#129309;</div><h4>Friendship</h4><p>How strong is your friendship bond?</p></a>
    <a class="lc-rt" href="/crush-calculator/"><div class="lc-rt-icon">&#128150;</div><h4>Crush Calc</h4><p>Find out if your crush likes you back</p></a>
    <a class="lc-rt" href="/mulank-calculator/"><div class="lc-rt-icon">&#128302;</div><h4>Mulank Calc</h4><p>Discover your numerology destiny number</p></a>
  </div>
</section>
<script type="application/ld+json">{"@context":"https://schema.org","@type":"SoftwareApplication","name":"Love Calculator","applicationCategory":"LifestyleApplication","operatingSystem":"Web","offers":{"@type":"Offer","price":"0","priceCurrency":"USD"},"aggregateRating":{"@type":"AggregateRating","ratingValue":"4.9","ratingCount":"12847"}}</script>
<script>
(function(){
'use strict';
var LC={$:function(id){return document.getElementById(id);},nameA:'',nameB:'',score:0};
var elInputPhase=LC.$('lc-input-phase'),elLoading=LC.$('lc-loading'),elResult=LC.$('lc-result');
var elNameA=LC.$('lc-name-a'),elNameB=LC.$('lc-name-b'),elAvA=LC.$('lc-av-a'),elAvB=LC.$('lc-av-b'),elError=LC.$('lc-error');
function updateAvatar(inp,av){var v=(inp.value||'').trim();av.textContent=v?v.charAt(0).toUpperCase():'?';}
elNameA.addEventListener('input',function(){updateAvatar(elNameA,elAvA);elError.classList.remove('lc-show');});
elNameB.addEventListener('input',function(){updateAvatar(elNameB,elAvB);elError.classList.remove('lc-show');});
function calcLove(n1,n2){
  var a=(n1||'').toLowerCase().replace(/[^a-z]/g,''),b=(n2||'').toLowerCase().replace(/[^a-z]/g,'');
  if(!a||!b)return 50;
  var fA={},fB={};
  for(var i=0;i<a.length;i++){fA[a[i]]=(fA[a[i]]||0)+1;}
  for(var j=0;j<b.length;j++){fB[b[j]]=(fB[b[j]]||0)+1;}
  var ov=0,tot=0,keys={};
  for(var k in fA){keys[k]=1;}for(var k2 in fB){keys[k2]=1;}
  for(var k3 in keys){ov+=Math.min(fA[k3]||0,fB[k3]||0);tot+=Math.max(fA[k3]||0,fB[k3]||0);}
  var os=tot?(ov/tot)*100:50;
  var sA=0,sB=0;
  for(var i2=0;i2<a.length;i2++){sA+=a.charCodeAt(i2)-96;}
  for(var j2=0;j2<b.length;j2++){sB+=b.charCodeAt(j2)-96;}
  var ns=((sA+sB)%9+1)*10;
  var ls=Math.max(0,100-Math.abs(a.length-b.length)*12);
  var seed=0,com=a+b;
  for(var s=0;s<com.length;s++){seed=((seed<<5)-seed+com.charCodeAt(s))|0;}
  var rand=Math.abs(Math.sin(seed))*30;
  var sc=Math.round(os*.4+ns*.25+ls*.2+rand*.5);
  if(sc<12)sc=12+(Math.abs(seed)%18);if(sc>99)sc=99;return sc;
}
function calcMetrics(n1,n2,score){
  var a=(n1||'').toLowerCase().replace(/[^a-z]/g,''),b=(n2||'').toLowerCase().replace(/[^a-z]/g,'');
  var seed=0,com=a+b;for(var s=0;s<com.length;s++){seed=((seed<<5)-seed+com.charCodeAt(s))|0;}
  function vary(base,off){var r=Math.abs(Math.sin(seed+off))*20-10;return Math.max(15,Math.min(99,Math.round(base+r)));}
  return{trust:vary(score,1),chem:vary(score,2),comm:vary(score,3),lt:vary(score,4)};
}
function getLevel(s){
  if(s>=90)return{emoji:'👑',name:'Soulmates',color:'#d4af37'};
  if(s>=70)return{emoji:'💕',name:'Perfect Match',color:'#E63946'};
  if(s>=50)return{emoji:'💜',name:'Good Potential',color:'#7B2D8B'};
  if(s>=30)return{emoji:'💙',name:'Needs Effort',color:'#2563eb'};
  return{emoji:'🤝',name:'Just Friends',color:'#14b8a6'};
}
function getDesc(s,n1,n2){
  if(s>=90)return n1+' and '+n2+', the universe is whispering your names together. Your bond runs deep — a rare connection few ever experience. Cherish it.';
  if(s>=70)return n1+' and '+n2+', you two have a love story worth telling. Your hearts are tuned to a similar rhythm. Keep nurturing this beautiful bond.';
  if(s>=50)return n1+' and '+n2+', there is real potential here waiting to bloom. With patience and shared experiences, your connection can grow into something truly meaningful.';
  if(s>=30)return n1+' and '+n2+', every great love story takes work. Your differences could become your greatest strengths. Listen, laugh, and grow together.';
  return n1+' and '+n2+', friendship is one of life\'s most precious gifts. Treasure what you have, in whatever form it takes.';
}
function getHints(s){
  if(s>=70)return[{i:'💌',t:'Daily Affection',d:'Send a sweet message every morning to keep the spark alive.'},{i:'🎉',t:'Celebrate Small Wins',d:'Acknowledge each other\'s little victories.'},{i:'🗝',t:'Plan Memories',d:'Take a trip together this year. Memories > things.'},{i:'🔒',t:'Protect Privacy',d:'Keep the magic sacred between you two.'}];
  if(s>=40)return[{i:'🗣',t:'Open Up More',d:'Share one new thought a day. Vulnerability builds connection.'},{i:'⏰',t:'Quality Time',d:'Schedule phone-free time together — even 30 minutes counts.'},{i:'🎯',t:'Set Shared Goals',d:'A goal you both chase together pulls you closer.'},{i:'🌱',t:'Grow Together',d:'Try a new hobby as a team. Shared learning = deeper love.'}];
  return[{i:'🤝',t:'Value Friendship',d:'A loyal friend is rarer than a romantic partner.'},{i:'💬',t:'Honest Talks',d:'Have one real conversation this week — no small talk.'},{i:'🌟',t:'Be Yourself',d:'The right person celebrates who you already are.'},{i:'✨',t:'Patience Wins',d:'Some bonds need time to reveal their true form.'}];
}
function getAdvice(s,n1,n2){
  if(s>=70)return{text:n1+' & '+n2+', hold onto the small moments — a shared laugh, a quiet glance. Love thrives in attention, not perfection. Keep choosing each other, every single day.',tags:['Strong Chemistry','Forever Potential','Soulful Bond','Deep Trust']};
  if(s>=40)return{text:n1+' & '+n2+', you have something worth nurturing. Water it with kindness, patience, and presence. Communication is your superpower.',tags:['Growing Bond','Communication First','Worth The Effort','Future Bright']};
  return{text:n1+' & '+n2+', not every connection becomes romance — and that\'s a beautiful thing. The right love, in any form, will always feel right.',tags:['True Friendship','Honest Bond','Different Path','Self Love First']};
}
var loadSteps=['💌 Scanning your names...','🔬 Analyzing compatibility...','✨ Calculating love score...','💝 Preparing your result...'];
function runLoading(cb){
  var stepEl=LC.$('lc-load-step'),barEl=LC.$('lc-progress-bar'),i=0;
  stepEl.textContent=loadSteps[0];barEl.style.width='8%';
  var iv=setInterval(function(){
    i++;if(i<loadSteps.length){stepEl.style.opacity='0';setTimeout(function(){stepEl.textContent=loadSteps[i];stepEl.style.opacity='1';},200);barEl.style.width=((i+1)*25)+'%';}
    else{clearInterval(iv);barEl.style.width='100%';setTimeout(cb,350);}
  },700);
}
function animNum(el,from,to,dur){
  var start=performance.now();
  function tick(now){var p=Math.min(1,(now-start)/dur);var e=1-Math.pow(1-p,3);el.textContent=Math.round(from+(to-from)*e);if(p<1)requestAnimationFrame(tick);}
  requestAnimationFrame(tick);
}
function confetti(){
  var colors=['#E63946','#ff6b9d','#fbbf24','#7B2D8B','#fff'],box=document.createElement('div');
  box.className='lc-confetti';
  for(var i=0;i<60;i++){var p=document.createElement('i');p.style.left=(Math.random()*100)+'%';p.style.background=colors[Math.floor(Math.random()*colors.length)];p.style.animationDuration=(1.5+Math.random()*2)+'s';p.style.animationDelay=(Math.random()*.5)+'s';p.style.transform='rotate('+(Math.random()*360)+'deg)';box.appendChild(p);}
  document.body.appendChild(box);setTimeout(function(){box.remove();},4000);
}
function esc(s){return String(s).replace(/[&<>"']/g,function(c){return({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'})[c];});}
function showResult(){
  var n1=LC.nameA,n2=LC.nameB,score=calcLove(n1,n2),metrics=calcMetrics(n1,n2,score),level=getLevel(score),desc=getDesc(score,n1,n2),hints=getHints(score),advice=getAdvice(score,n1,n2);
  LC.score=score;
  LC.$('lc-rc-n-a').textContent=n1;LC.$('lc-rc-n-b').textContent=n2;
  LC.$('lc-rc-av-a').textContent=n1.charAt(0).toUpperCase();LC.$('lc-rc-av-b').textContent=n2.charAt(0).toUpperCase();
  LC.$('lc-level').innerHTML=level.emoji+' '+level.name;LC.$('lc-desc').textContent=desc;
  elLoading.classList.remove('lc-show');elLoading.style.display='none';elResult.classList.add('lc-show');
  animNum(LC.$('lc-pct'),0,score,1800);
  var circ=2*Math.PI*86,ring=LC.$('lc-ring-fg');
  setTimeout(function(){ring.style.strokeDashoffset=circ-(circ*score/100);},80);
  setTimeout(function(){
    LC.$('lc-b1').style.width=metrics.trust+'%';LC.$('lc-b2').style.width=metrics.chem+'%';LC.$('lc-b3').style.width=metrics.comm+'%';LC.$('lc-b4').style.width=metrics.lt+'%';
    LC.$('lc-b1-v').textContent=metrics.trust+'%';LC.$('lc-b2-v').textContent=metrics.chem+'%';LC.$('lc-b3-v').textContent=metrics.comm+'%';LC.$('lc-b4-v').textContent=metrics.lt+'%';
  },200);
  LC.$('lc-hints-title').innerHTML='⭐ Golden Hints for '+esc(n1)+' &amp; '+esc(n2);
  var hg=LC.$('lc-hints-grid');hg.innerHTML='';
  hints.forEach(function(h,hi){var c=document.createElement('div');c.className='lc-hint';c.style.borderLeftColor=level.color;c.style.animationDelay=(hi*.1)+'s';c.innerHTML='<div class="lc-hint-icon">'+h.i+'</div><h4>'+esc(h.t)+'</h4><p>'+esc(h.d)+'</p>';hg.appendChild(c);});
  LC.$('lc-advice-text').textContent=advice.text;
  var tb=LC.$('lc-tags');tb.innerHTML='';
  advice.tags.forEach(function(t,ti){var s=document.createElement('span');s.className='lc-tag lc-t'+((ti%4)+1);s.textContent=t;tb.appendChild(s);});
  var url=window.location.href,msg='❤️ Love Calculator Result!\n\n'+n1+' + '+n2+' = *'+score+'% Love*\nStatus: *'+level.name+'*\n\nTest yours: '+url;
  LC.$('lc-sb-wa').href='https://wa.me/?text='+encodeURIComponent(msg);
  LC.$('lc-sb-tw').href='https://twitter.com/intent/tweet?text='+encodeURIComponent(n1+' + '+n2+' = '+score+'% Love ❤️! Test yours:'+'&url='+encodeURIComponent(url));
  LC.$('lc-sb-copy').onclick=function(){var btn=this,orig=btn.innerHTML;try{if(navigator.clipboard){navigator.clipboard.writeText(url).then(function(){btn.innerHTML='✅ Copied!';setTimeout(function(){btn.innerHTML=orig;},1800);});}else{var ta=document.createElement('textarea');ta.value=url;document.body.appendChild(ta);ta.select();document.execCommand('copy');ta.remove();btn.innerHTML='✅ Copied!';setTimeout(function(){btn.innerHTML=orig;},1800);}}catch(e){btn.innerHTML='⚠ Manually Copy';setTimeout(function(){btn.innerHTML=orig;},1800);}};
  LC.$('lc-sb-save').onclick=function(){var btn=this,orig=btn.innerHTML;btn.innerHTML='📸 Saving...';setTimeout(function(){if(navigator.share){navigator.share({title:'Love Calculator Result',text:msg,url:url}).catch(function(){alert('Screenshot your result!\n'+n1+' + '+n2+' = '+score+'% Love');});btn.innerHTML=orig;}else{alert('Screenshot your result!\n'+n1+' + '+n2+' = '+score+'% Love\n'+level.name);btn.innerHTML=orig;}},400);};
  if(score>=70)setTimeout(confetti,600);
  setTimeout(function(){elResult.scrollIntoView({behavior:'smooth',block:'start'});},100);
}
LC.$('lc-calc-btn').addEventListener('click',function(){
  var n1=(elNameA.value||'').trim(),n2=(elNameB.value||'').trim();
  if(!n1||!n2){elError.classList.add('lc-show');return;}
  if(n1.length<2||n2.length<2){elError.textContent='Names should be at least 2 characters.';elError.classList.add('lc-show');return;}
  elError.classList.remove('lc-show');elError.textContent='Please enter both names to continue.';
  LC.nameA=n1;LC.nameB=n2;
  elInputPhase.style.display='none';elLoading.style.display='block';elLoading.classList.add('lc-show');
  LC.$('lc-load-names').textContent=n1+' ❤️ '+n2;LC.$('lc-progress-bar').style.width='0%';
  runLoading(showResult);
});
[elNameA,elNameB].forEach(function(el){el.addEventListener('keydown',function(e){if(e.key==='Enter'){e.preventDefault();LC.$('lc-calc-btn').click();}});});
LC.$('lc-try-btn').addEventListener('click',function(){
  elResult.classList.remove('lc-show');elLoading.classList.remove('lc-show');elLoading.style.display='none';
  elInputPhase.style.display='block';elNameA.value='';elNameB.value='';elAvA.textContent='?';elAvB.textContent='?';
  LC.$('lc-pct').textContent='0';LC.$('lc-ring-fg').style.strokeDashoffset=540.35;
  ['lc-b1','lc-b2','lc-b3','lc-b4'].forEach(function(id){LC.$(id).style.width='0%';});
  elInputPhase.scrollIntoView({behavior:'smooth',block:'start'});setTimeout(function(){elNameA.focus();},400);
});
var cnt=384219;setInterval(function(){cnt+=1+Math.floor(Math.random()*3);LC.$('lc-counter').textContent=cnt.toLocaleString('en-IN');},8000);
})();
</script>
</div>
<?php
    return ob_get_clean();
}
add_shortcode( 'love_calculator', 'lc_pro_render_calculator' );
}

// ═══════════════════════════════════════════════════════════════
// 2. FRIENDSHIP CALCULATOR  [friendship_calculator]
// ═══════════════════════════════════════════════════════════════
if ( ! function_exists( 'fc_render' ) ) {
function fc_render( $atts = [] ) {
    ob_start(); ?>
<div class="fc-wrap" id="fc-wrap">
<style>
.fc-wrap,.fc-wrap *,.fc-wrap *::before,.fc-wrap *::after{box-sizing:border-box}
.fc-wrap{font-family:'DM Sans','Inter',-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;color:#1f1933;max-width:880px;margin:0 auto;padding:12px;line-height:1.55}
.fc-wrap h1,.fc-wrap h2,.fc-wrap h3,.fc-wrap h4{font-family:'Poppins',system-ui,sans-serif;font-weight:800;letter-spacing:-.01em;margin:0}
.fc-topbar{display:flex;align-items:center;justify-content:flex-end;gap:10px;margin-bottom:10px;flex-wrap:wrap}
.fc-lang-btn{padding:7px 16px;border-radius:999px;border:2px solid #7B2D8B;background:#fff;color:#7B2D8B;font-weight:700;font-size:13px;cursor:pointer;font-family:'Poppins',sans-serif;transition:all .2s}
.fc-lang-btn:hover,.fc-lang-btn.active{background:#7B2D8B;color:#fff}
.fc-adv-wrap{display:flex;align-items:center;gap:7px;font-size:13px;font-weight:600;color:#5b5070;cursor:pointer}
.fc-adv-toggle{position:relative;width:40px;height:22px}
.fc-adv-toggle input{opacity:0;width:0;height:0}
.fc-adv-slider{position:absolute;inset:0;border-radius:999px;background:#ddd;transition:.3s;cursor:pointer}
.fc-adv-slider::before{content:"";position:absolute;height:16px;width:16px;left:3px;bottom:3px;background:#fff;border-radius:50%;transition:.3s}
.fc-adv-toggle input:checked+.fc-adv-slider{background:#7B2D8B}
.fc-adv-toggle input:checked+.fc-adv-slider::before{transform:translateX(18px)}
.fc-header{background:linear-gradient(135deg,#1a0533 0%,#3d0b55 50%,#690d3a 100%);border-radius:22px;padding:28px 20px;color:#fff;text-align:center;box-shadow:0 20px 60px rgba(105,13,58,.25);position:relative;overflow:hidden}
.fc-header::before{content:"";position:absolute;inset:-50%;background:radial-gradient(circle at 30% 20%,rgba(230,57,70,.18),transparent 60%),radial-gradient(circle at 70% 80%,rgba(123,45,139,.25),transparent 60%);pointer-events:none}
.fc-header-icon{font-size:50px;line-height:1;display:inline-block;animation:fc-bob 2.4s ease-in-out infinite}
.fc-header h1{font-size:36px;margin:8px 0 6px;color:#fff}
.fc-header-sub{opacity:.86;font-size:15px;margin:0}
.fc-stats{display:flex;align-items:center;justify-content:center;margin-top:18px;flex-wrap:wrap}
.fc-stat{padding:4px 14px;min-width:96px;text-align:center}
.fc-stat-num{font-weight:800;font-family:'Poppins',sans-serif;font-size:18px;color:#fff}
.fc-stat-lbl{font-size:11px;opacity:.78;text-transform:uppercase;letter-spacing:.06em}
.fc-stat+.fc-stat{border-left:1px solid rgba(255,255,255,.22)}
.fc-card{background:#fff;border-radius:22px;padding:24px 20px;margin-top:18px;box-shadow:0 20px 60px rgba(0,0,0,.08);border:1px solid #f1ecf6}
.fc-inputs{display:grid;grid-template-columns:1fr auto 1fr;gap:14px;align-items:center}
.fc-field{display:flex;flex-direction:column;align-items:center;gap:10px}
.fc-avatar{width:64px;height:64px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-family:'Poppins',sans-serif;font-weight:800;font-size:26px;color:#fff;box-shadow:0 8px 24px rgba(0,0,0,.18);transition:transform .25s ease}
.fc-avatar.fc-a{background:linear-gradient(135deg,#E63946,#ff6b9d)}
.fc-avatar.fc-b{background:linear-gradient(135deg,#7B2D8B,#b558d6)}
.fc-avatar:hover{transform:scale(1.04)}
.fc-input{width:100%;min-height:52px;padding:12px 14px;font-size:16px;border:2px solid #ece6f3;border-radius:14px;outline:none;background:#faf8fd;transition:border-color .2s,box-shadow .2s;font-family:inherit}
.fc-input:focus{border-color:#7B2D8B;background:#fff;box-shadow:0 0 0 4px rgba(123,45,139,.12)}
.fc-vs{width:56px;height:56px;border-radius:50%;background:linear-gradient(135deg,#E63946,#7B2D8B);color:#fff;display:flex;align-items:center;justify-content:center;font-size:26px;box-shadow:0 10px 24px rgba(123,45,139,.4);animation:fc-pulse 1.6s ease-in-out infinite}
.fc-btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;min-height:56px;padding:18px 22px;font-size:17px;font-weight:700;font-family:'Poppins',sans-serif;border:none;border-radius:14px;cursor:pointer;width:100%;transition:transform .15s ease,box-shadow .2s}
.fc-btn-primary{background:linear-gradient(135deg,#7B2D8B,#5a1f6b);color:#fff;box-shadow:0 14px 32px rgba(123,45,139,.35);margin-top:18px}
.fc-btn-primary:hover{transform:translateY(-2px);box-shadow:0 18px 40px rgba(123,45,139,.45)}
.fc-trust{display:flex;gap:10px;justify-content:center;flex-wrap:wrap;margin-top:14px}
.fc-trust span{font-size:12.5px;color:#5b5070;background:#f6f0fb;padding:6px 12px;border-radius:999px;display:inline-flex;align-items:center}
.fc-error{display:none;background:#fff1f2;color:#b3162a;border:1px solid #ffd6db;padding:10px 14px;border-radius:12px;margin-top:12px;font-size:14px;text-align:center}
.fc-error.fc-show{display:block;animation:fc-shake .4s}
.fc-loading{display:none;text-align:center;padding:14px 8px 6px}
.fc-loading.fc-show{display:block}
.fc-rings{position:relative;width:160px;height:160px;margin:6px auto 18px}
.fc-ring{position:absolute;inset:0;border-radius:50%;border:3px solid rgba(123,45,139,.35);animation:fc-ring-anim 2s ease-out infinite}
.fc-ring:nth-child(2){animation-delay:.5s;border-color:rgba(230,57,70,.4)}
.fc-ring:nth-child(3){animation-delay:1s;border-color:rgba(255,215,0,.45)}
.fc-ring-icon{position:absolute;inset:0;display:flex;align-items:center;justify-content:center;font-size:60px;animation:fc-pulse 1.2s ease-in-out infinite}
.fc-load-names{font-size:18px;font-weight:700;font-family:'Poppins',sans-serif;color:#3d0b55;margin-bottom:12px}
.fc-load-step{font-size:15px;color:#6b5e85;min-height:24px;transition:opacity .25s}
.fc-progress{height:8px;background:#f1ebf7;border-radius:999px;overflow:hidden;margin:14px auto 4px;max-width:360px}
.fc-progress-bar{height:100%;width:0%;background:linear-gradient(90deg,#7B2D8B,#E63946);border-radius:999px;transition:width .3s ease}
.fc-result{display:none}
.fc-result.fc-show{display:block;animation:fc-fadeUp .55s ease both}
.fc-result-card{background:linear-gradient(135deg,#1a0533,#3d0b55,#690d3a);color:#fff;border-radius:22px;padding:28px 20px;text-align:center;box-shadow:0 20px 60px rgba(0,0,0,.25);position:relative;overflow:hidden}
.fc-result-card::after{content:"";position:absolute;inset:0;background:radial-gradient(circle at 20% 10%,rgba(123,45,139,.3),transparent 50%),radial-gradient(circle at 80% 90%,rgba(255,215,0,.15),transparent 55%);pointer-events:none}
.fc-rc-names{display:flex;align-items:center;justify-content:center;gap:14px;flex-wrap:wrap;margin-bottom:6px;position:relative;z-index:1}
.fc-rc-name{display:flex;align-items:center;gap:10px;font-weight:700;font-family:'Poppins',sans-serif;font-size:17px}
.fc-rc-name .fc-avatar{width:44px;height:44px;font-size:18px}
.fc-rc-mid{font-size:22px}
.fc-ring-wrap{position:relative;width:220px;height:220px;margin:14px auto 10px;z-index:1}
.fc-ring-wrap svg{transform:rotate(-90deg);width:100%;height:100%}
.fc-ring-bg{fill:none;stroke:rgba(255,255,255,.12);stroke-width:12}
.fc-ring-fg{fill:none;stroke:url(#fc-grad);stroke-width:12;stroke-linecap:round;transition:stroke-dashoffset 1.8s cubic-bezier(.22,.9,.3,1)}
.fc-percent{position:absolute;inset:0;display:flex;align-items:center;justify-content:center;flex-direction:column}
.fc-percent-num{font-size:64px;font-weight:800;font-family:'Poppins',sans-serif;line-height:1}
.fc-percent-sym{font-size:24px;font-weight:700;opacity:.85}
.fc-bond-badge{display:inline-block;background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.25);padding:8px 20px;border-radius:999px;font-weight:700;font-family:'Poppins',sans-serif;font-size:15px;margin:6px 0 10px;position:relative;z-index:1}
.fc-rc-desc{max-width:580px;margin:0 auto;opacity:.92;font-size:15px;position:relative;z-index:1}
.fc-watermark{margin-top:14px;font-size:12px;opacity:.7;position:relative;z-index:1}
.fc-bars{margin-top:18px}
.fc-bar-row{margin:14px 0}
.fc-bar-top{display:flex;justify-content:space-between;font-size:14px;font-weight:600;color:#2d2447;margin-bottom:6px}
.fc-bar-top span:last-child{color:#7B2D8B;font-family:'Poppins',sans-serif;font-weight:800}
.fc-bar{height:10px;background:#f1ebf7;border-radius:999px;overflow:hidden}
.fc-bar-fill{height:100%;width:0%;border-radius:999px;background:linear-gradient(90deg,#7B2D8B,#E63946);transition:width 1.5s cubic-bezier(.22,.9,.3,1)}
.fc-hints{background:linear-gradient(135deg,#fff8dc,#fff1c1);border-radius:18px;padding:20px;margin-top:18px;border:1px solid #f7e190}
.fc-hints h3{font-size:19px;color:#7a5a05;margin-bottom:12px}
.fc-hints-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:12px}
.fc-hint{background:#fff;border-radius:14px;padding:14px;border-left:4px solid #7B2D8B;box-shadow:0 8px 20px rgba(0,0,0,.05);opacity:0;transform:translateY(8px);animation:fc-fadeUp .5s ease forwards}
.fc-hint-icon{font-size:22px;margin-bottom:4px}
.fc-hint h4{font-size:14.5px;color:#3d0b55;margin-bottom:4px}
.fc-hint p{font-size:13px;color:#5b5070;margin:0}
.fc-adv-section{margin-top:18px;display:none}
.fc-adv-section.fc-adv-on{display:block;animation:fc-fadeUp .4s ease both}
.fc-special-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-top:0}
.fc-special-card{background:#fff;border-radius:18px;padding:18px 14px;text-align:center;box-shadow:0 10px 28px rgba(0,0,0,.07);border-top:4px solid #7B2D8B}
.fc-special-card:nth-child(1){border-color:#E63946}
.fc-special-card:nth-child(2){border-color:#d4af37}
.fc-special-card:nth-child(3){border-color:#7B2D8B}
.fc-special-icon{font-size:32px;margin-bottom:8px}
.fc-special-card h4{font-size:13px;color:#5b5070;text-transform:uppercase;letter-spacing:.06em;margin-bottom:6px;font-weight:700}
.fc-special-card p{font-size:15px;font-weight:700;color:#1f1933;margin:0 0 4px}
.fc-special-card small{font-size:12px;color:#6b5e85}
.fc-advice{background:linear-gradient(135deg,#e7f7ec,#d2efdc);border-radius:18px;padding:20px;margin-top:16px;border:1px solid #b8e2c5}
.fc-advice h3{font-size:18px;color:#155d3a;margin-bottom:8px}
.fc-advice p{font-style:italic;color:#1f3f2c;margin:0 0 12px}
.fc-tags{display:flex;flex-wrap:wrap;gap:8px}
.fc-tag{background:#fff;padding:6px 12px;border-radius:999px;font-size:12.5px;font-weight:600;color:#155d3a;border:1px solid #b8e2c5}
.fc-tag.fc-t2{color:#6c2dba;border-color:#d8c1f0}
.fc-tag.fc-t3{color:#b3162a;border-color:#ffc8ce}
.fc-tag.fc-t4{color:#b6770b;border-color:#f4dca0}
.fc-share{display:grid;grid-template-columns:repeat(4,1fr);gap:10px;margin-top:18px}
.fc-share-btn{display:inline-flex;align-items:center;justify-content:center;gap:6px;min-height:48px;padding:12px 8px;font-size:14px;font-weight:700;font-family:'Poppins',sans-serif;border-radius:12px;border:none;cursor:pointer;color:#fff;text-decoration:none;transition:transform .15s,box-shadow .15s}
.fc-share-btn:hover{transform:translateY(-2px);box-shadow:0 12px 26px rgba(0,0,0,.15)}
.fc-sb-wa{background:#25d366}.fc-sb-tw{background:#111}
.fc-sb-save{background:linear-gradient(135deg,#7B2D8B,#E63946)}.fc-sb-copy{background:#5b5b6e}
.fc-try{margin-top:14px;background:#fff;color:#3d0b55;border:2px solid #ece6f3}
.fc-try:hover{border-color:#7B2D8B;color:#7B2D8B}
.fc-levels{display:grid;grid-template-columns:repeat(5,1fr);gap:10px;margin-top:22px}
.fc-lvl{background:#fff;border-radius:16px;padding:14px 10px;text-align:center;box-shadow:0 10px 24px rgba(0,0,0,.06)}
.fc-lvl:nth-child(1){border-top:4px solid #d4af37}
.fc-lvl:nth-child(2){border-top:4px solid #7B2D8B}
.fc-lvl:nth-child(3){border-top:4px solid #E63946}
.fc-lvl:nth-child(4){border-top:4px solid #2563eb}
.fc-lvl:nth-child(5){border-top:4px solid #14b8a6}
.fc-lvl-icon{font-size:26px}.fc-lvl h4{font-size:13.5px;color:#1f1933;margin:4px 0}.fc-lvl-range{font-size:12px;color:#7B2D8B;font-weight:700}.fc-lvl-desc{font-size:11.5px;color:#5b5070;margin:4px 0 0}
.fc-related{margin-top:22px}.fc-related h2{font-size:22px;color:#3d0b55;margin-bottom:12px}
.fc-related-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:12px}
.fc-rt{display:block;text-decoration:none;background:#fff;border-radius:16px;padding:16px 12px;text-align:center;box-shadow:0 10px 24px rgba(0,0,0,.06);color:inherit;transition:transform .15s,box-shadow .2s}
.fc-rt:hover{transform:translateY(-3px);box-shadow:0 16px 32px rgba(0,0,0,.1)}
.fc-rt:nth-child(1){border-top:4px solid #E63946}
.fc-rt:nth-child(2){border-top:4px solid #d4af37}
.fc-rt:nth-child(3){border-top:4px solid #7B2D8B}
.fc-rt:nth-child(4){border-top:4px solid #14b8a6}
.fc-rt-icon{font-size:28px}.fc-rt h4{font-size:14px;color:#1f1933;margin:6px 0 4px}.fc-rt p{font-size:12px;color:#5b5070;margin:0}
.fc-confetti{position:fixed;inset:0;pointer-events:none;z-index:9999;overflow:hidden}
.fc-confetti i{position:absolute;top:-20px;width:10px;height:14px;opacity:.95;animation:fc-fall linear forwards;border-radius:2px}
@keyframes fc-pulse{0%,100%{transform:scale(1)}50%{transform:scale(1.08)}}
@keyframes fc-bob{0%,100%{transform:translateY(0)}50%{transform:translateY(-6px)}}
@keyframes fc-ring-anim{0%{transform:scale(.6);opacity:.9}100%{transform:scale(1.4);opacity:0}}
@keyframes fc-fadeUp{from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:translateY(0)}}
@keyframes fc-shake{0%,100%{transform:translateX(0)}25%{transform:translateX(-4px)}75%{transform:translateX(4px)}}
@keyframes fc-fall{0%{transform:translateY(-20px) rotate(0);opacity:1}100%{transform:translateY(110vh) rotate(720deg);opacity:.3}}
@media(max-width:640px){.fc-inputs{grid-template-columns:1fr;gap:12px}.fc-vs{margin:-4px auto}.fc-percent-num{font-size:56px}.fc-ring-wrap{width:200px;height:200px}.fc-share{grid-template-columns:repeat(2,1fr)}.fc-levels{grid-template-columns:repeat(2,1fr)}.fc-related-grid{grid-template-columns:repeat(2,1fr)}.fc-hints-grid{grid-template-columns:1fr}.fc-special-grid{grid-template-columns:1fr}}
</style>

<div class="fc-topbar">
  <button class="fc-lang-btn" id="fc-lang-btn">हिंदी</button>
  <label class="fc-adv-wrap" for="fc-adv-chk">
    <span id="fc-adv-lbl">Advanced Mode</span>
    <span class="fc-adv-toggle"><input type="checkbox" id="fc-adv-chk"><span class="fc-adv-slider"></span></span>
  </label>
</div>

<header class="fc-header">
  <div class="fc-header-icon">🤝</div>
  <h1 id="fc-title">Friendship Calculator</h1>
  <p class="fc-header-sub" id="fc-subtitle">Discover the true power of your friendship by name</p>
  <div class="fc-stats">
    <div class="fc-stat"><div class="fc-stat-num" id="fc-counter">2,41,876</div><div class="fc-stat-lbl" id="fc-stat1-lbl">Tests Today</div></div>
    <div class="fc-stat"><div class="fc-stat-num">4.8★</div><div class="fc-stat-lbl" id="fc-stat2-lbl">Rating</div></div>
    <div class="fc-stat"><div class="fc-stat-num">100%</div><div class="fc-stat-lbl" id="fc-stat3-lbl">Free</div></div>
  </div>
</header>

<section class="fc-card">
  <div id="fc-input-phase">
    <div class="fc-inputs">
      <div class="fc-field">
        <div class="fc-avatar fc-a" id="fc-av-a">?</div>
        <input type="text" class="fc-input" id="fc-name-a" placeholder="Your Name" maxlength="30" autocomplete="off"/>
      </div>
      <div class="fc-vs" aria-hidden="true">🤝</div>
      <div class="fc-field">
        <div class="fc-avatar fc-b" id="fc-av-b">?</div>
        <input type="text" class="fc-input" id="fc-name-b" placeholder="Friend's Name" maxlength="30" autocomplete="off"/>
      </div>
    </div>
    <div class="fc-error" id="fc-error">Please enter both names to continue.</div>
    <button type="button" class="fc-btn fc-btn-primary" id="fc-calc-btn">Calculate Friendship ✨</button>
    <div class="fc-trust"><span>🔒 Private</span><span>⚡ Instant</span><span>🆓 Free</span></div>
  </div>

  <div class="fc-loading" id="fc-loading">
    <div class="fc-rings"><div class="fc-ring"></div><div class="fc-ring"></div><div class="fc-ring"></div><div class="fc-ring-icon">🤝</div></div>
    <div class="fc-load-names" id="fc-load-names">✨</div>
    <div class="fc-load-step" id="fc-load-step">🔬 Scanning friendship energy...</div>
    <div class="fc-progress"><div class="fc-progress-bar" id="fc-progress-bar"></div></div>
  </div>

  <div class="fc-result" id="fc-result">
    <div class="fc-result-card">
      <div class="fc-rc-names">
        <div class="fc-rc-name"><div class="fc-avatar fc-a" id="fc-rc-av-a">?</div><span id="fc-rc-n-a">Name 1</span></div>
        <div class="fc-rc-mid">🤝</div>
        <div class="fc-rc-name"><div class="fc-avatar fc-b" id="fc-rc-av-b">?</div><span id="fc-rc-n-b">Name 2</span></div>
      </div>
      <div class="fc-ring-wrap">
        <svg viewBox="0 0 200 200" aria-hidden="true">
          <defs><linearGradient id="fc-grad" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#d4af37"/><stop offset="100%" stop-color="#7B2D8B"/></linearGradient></defs>
          <circle class="fc-ring-bg" cx="100" cy="100" r="86"/>
          <circle class="fc-ring-fg" id="fc-ring-fg" cx="100" cy="100" r="86" stroke-dasharray="540.35" stroke-dashoffset="540.35"/>
        </svg>
        <div class="fc-percent"><div><span class="fc-percent-num" id="fc-pct">0</span><span class="fc-percent-sym">%</span></div></div>
      </div>
      <div class="fc-bond-badge" id="fc-bond">🤝 Calculating...</div>
      <p class="fc-rc-desc" id="fc-desc"></p>
      <div class="fc-watermark">lovecalculator.in 🤝</div>
    </div>

    <div class="fc-bars">
      <div class="fc-bar-row"><div class="fc-bar-top"><span>🤝 Loyalty</span><span id="fc-b1-v">0%</span></div><div class="fc-bar"><div class="fc-bar-fill" id="fc-b1"></div></div></div>
      <div class="fc-bar-row"><div class="fc-bar-top"><span>🎉 Fun Factor</span><span id="fc-b2-v">0%</span></div><div class="fc-bar"><div class="fc-bar-fill" id="fc-b2"></div></div></div>
      <div class="fc-bar-row"><div class="fc-bar-top"><span>💪 Support System</span><span id="fc-b3-v">0%</span></div><div class="fc-bar"><div class="fc-bar-fill" id="fc-b3"></div></div></div>
      <div class="fc-bar-row"><div class="fc-bar-top"><span>💫 Deep Connection</span><span id="fc-b4-v">0%</span></div><div class="fc-bar"><div class="fc-bar-fill" id="fc-b4"></div></div></div>
    </div>

    <div class="fc-adv-section" id="fc-adv-result">
      <div class="fc-special-grid">
        <div class="fc-special-card">
          <div class="fc-special-icon" id="fc-career-icon">🚀</div>
          <h4 id="fc-career-lbl">Career Together</h4>
          <p id="fc-career-name"></p>
          <small id="fc-career-desc"></small>
        </div>
        <div class="fc-special-card">
          <div class="fc-special-icon" id="fc-pet-icon">🐾</div>
          <h4 id="fc-pet-lbl">Spirit Pet</h4>
          <p id="fc-pet-name"></p>
          <small id="fc-pet-desc"></small>
        </div>
        <div class="fc-special-card">
          <div class="fc-special-icon" id="fc-song-icon">🎵</div>
          <h4 id="fc-song-lbl">Theme Song</h4>
          <p id="fc-song-name"></p>
          <small id="fc-song-artist"></small>
        </div>
      </div>
    </div>

    <div class="fc-hints"><h3 id="fc-hints-title">⭐ Golden Friendship Hints</h3><div class="fc-hints-grid" id="fc-hints-grid"></div></div>
    <div class="fc-advice"><h3 id="fc-advice-title">💫 Friendship Advice</h3><p id="fc-advice-text"></p><div class="fc-tags" id="fc-tags"></div></div>

    <div class="fc-share">
      <a href="#" class="fc-share-btn fc-sb-wa" id="fc-sb-wa" target="_blank" rel="noopener">📱 WhatsApp</a>
      <a href="#" class="fc-share-btn fc-sb-tw" id="fc-sb-tw" target="_blank" rel="noopener">𝕏 Twitter</a>
      <button type="button" class="fc-share-btn fc-sb-save" id="fc-sb-save">📸 Save</button>
      <button type="button" class="fc-share-btn fc-sb-copy" id="fc-sb-copy">🔗 Copy</button>
    </div>
    <button type="button" class="fc-btn fc-try" id="fc-try-btn">🔄 Try Again</button>
  </div>
</section>

<section class="fc-levels" id="fc-levels-section">
  <div class="fc-lvl"><div class="fc-lvl-icon">👁️</div><h4 id="fc-lv1">Soul Twins</h4><div class="fc-lvl-range">90-100%</div><p class="fc-lvl-desc" id="fc-ld1">Rare cosmic bond</p></div>
  <div class="fc-lvl"><div class="fc-lvl-icon">💛</div><h4 id="fc-lv2">BFF Forever</h4><div class="fc-lvl-range">70-89%</div><p class="fc-lvl-desc" id="fc-ld2">Unbreakable bond</p></div>
  <div class="fc-lvl"><div class="fc-lvl-icon">⚡</div><h4 id="fc-lv3">Ride or Die</h4><div class="fc-lvl-range">50-69%</div><p class="fc-lvl-desc" id="fc-ld3">Through thick &amp; thin</p></div>
  <div class="fc-lvl"><div class="fc-lvl-icon">😊</div><h4 id="fc-lv4">Good Friends</h4><div class="fc-lvl-range">30-49%</div><p class="fc-lvl-desc" id="fc-ld4">Growing closer</p></div>
  <div class="fc-lvl"><div class="fc-lvl-icon">🌱</div><h4 id="fc-lv5">Fresh Start</h4><div class="fc-lvl-range">0-29%</div><p class="fc-lvl-desc" id="fc-ld5">Building trust</p></div>
</section>

<section class="fc-related">
  <h2 id="fc-related-title">Try More Tools</h2>
  <div class="fc-related-grid">
    <a class="fc-rt" href="/love-calculator/"><div class="fc-rt-icon">❤️</div><h4>Love Calc</h4><p>Test your love compatibility</p></a>
    <a class="fc-rt" href="/crush-calculator/"><div class="fc-rt-icon">💘</div><h4>Crush Calc</h4><p>Does your crush like you back?</p></a>
    <a class="fc-rt" href="/mulank-calculator/"><div class="fc-rt-icon">🔢</div><h4>Mulank Calc</h4><p>Your numerology destiny number</p></a>
    <a class="fc-rt" href="/flames-calculator/"><div class="fc-rt-icon">🔥</div><h4>FLAMES</h4><p>Classic friendship game</p></a>
  </div>
</section>

<script type="application/ld+json">{"@context":"https://schema.org","@type":"SoftwareApplication","name":"Friendship Calculator by Name","description":"Free online friendship calculator by name. Find your friendship compatibility percentage, bond level, career prediction, pet recommendation and golden friendship hints.","applicationCategory":"LifestyleApplication","operatingSystem":"Web","offers":{"@type":"Offer","price":"0","priceCurrency":"USD"},"aggregateRating":{"@type":"AggregateRating","ratingValue":"4.8","ratingCount":"9241"}}</script>

<script>
(function(){
'use strict';
var lang='en';
var T={
  en:{
    title:'Friendship Calculator',subtitle:'Discover the true power of your friendship by name',
    stat1:'Tests Today',stat2:'Rating',stat3:'Free',
    placeholder_a:'Your Name',placeholder_b:"Friend's Name",
    calc_btn:'Calculate Friendship ✨',adv_lbl:'Advanced Mode',
    load1:'🔬 Scanning friendship energy...',load2:'✨ Analyzing bond strength...',load3:'💛 Calculating compatibility...',load4:'🎉 Preparing your result...',
    bond:['👁️ Soul Twins','💛 BFF Forever','⚡ Ride or Die','😊 Good Friends','🌱 Fresh Start'],
    bar1:'🤝 Loyalty',bar2:'🎉 Fun Factor',bar3:'💪 Support System',bar4:'💫 Deep Connection',
    career_lbl:'Career Together',pet_lbl:'Spirit Pet',song_lbl:'Theme Song',
    hints_title:'⭐ Golden Friendship Hints',advice_title:'💫 Friendship Advice',
    try_btn:'🔄 Try Again',related_title:'Try More Tools',
    lv:['Soul Twins','BFF Forever','Ride or Die','Good Friends','Fresh Start'],
    ld:['Rare cosmic bond','Unbreakable bond','Through thick & thin','Growing closer','Building trust'],
    error:'Please enter both names to continue.',error2:'Names must be at least 2 characters.',
    adv_on:'Advanced Mode',lang_switch:'हिंदी'
  },
  hi:{
    title:'दोस्ती कैलकुलेटर',subtitle:'नाम से अपनी दोस्ती की असली ताकत जानें',
    stat1:'आज के टेस्ट',stat2:'रेटिंग',stat3:'मुफ्त',
    placeholder_a:'आपका नाम',placeholder_b:'दोस्त का नाम',
    calc_btn:'दोस्ती जाँचें ✨',adv_lbl:'एडवांस्ड मोड',
    load1:'🔬 दोस्ती ऊर्जा स्कैन हो रही है...',load2:'✨ बंधन शक्ति का विश्लेषण...',load3:'💛 अनुकूलता गणना...',load4:'🎉 आपका परिणाम तैयार हो रहा है...',
    bond:['👁️ आत्मा मित्र','💛 बेस्ट फ्रेंड फॉरएवर','⚡ हर हाल में साथ','😊 अच्छे दोस्त','🌱 शुरुआत'],
    bar1:'🤝 वफादारी',bar2:'🎉 मस्ती',bar3:'💪 सहारा',bar4:'💫 गहरा रिश्ता',
    career_lbl:'साथ करियर',pet_lbl:'स्पिरिट पेट',song_lbl:'थीम सॉन्ग',
    hints_title:'⭐ गोल्डन दोस्ती हिंट्स',advice_title:'💫 दोस्ती सलाह',
    try_btn:'🔄 फिर से करें',related_title:'और टूल्स आजमाएं',
    lv:['आत्मा मित्र','बेस्ट फ्रेंड फॉरएवर','हर हाल में साथ','अच्छे दोस्त','शुरुआत'],
    ld:['दुर्लभ ब्रह्मांडीय बंधन','अटूट बंधन','हर मुश्किल में','करीब आ रहे हैं','विश्वास बना रहे हैं'],
    error:'कृपया दोनों नाम दर्ज करें।',error2:'नाम कम से कम 2 अक्षर के होने चाहिए।',
    adv_on:'एडवांस्ड मोड',lang_switch:'English'
  }
};

var FC_CAREERS=[
  {icon:'🚀',en:'Startup Founders',hi:'स्टार्टअप संस्थापक',desc_en:'Your combined energy can disrupt industries. Start something together!',desc_hi:'आपकी संयुक्त ऊर्जा उद्योगों को बदल सकती है।'},
  {icon:'🎨',en:'Creative Directors',hi:'क्रिएटिव डायरेक्टर',desc_en:'Art, design, media — your creative synergy is unmatched.',desc_hi:'कला, डिजाइन, मीडिया — आपकी क्रिएटिव सिनर्जी बेमिसाल है।'},
  {icon:'💻',en:'Tech Innovators',hi:'टेक इनोवेटर',desc_en:'Build apps or AI tools. Your logic complements perfectly.',desc_hi:'ऐप या AI टूल्स बनाएं। आपका लॉजिक एक-दूसरे को पूरा करता है।'},
  {icon:'🎭',en:'Entertainment Duo',hi:'एंटरटेनमेंट डुओ',desc_en:'Comedy, acting, music — you two light up any stage.',desc_hi:'कॉमेडी, एक्टिंग, म्यूजिक — आप दोनों किसी भी स्टेज को रोशन करते हैं।'},
  {icon:'🏥',en:'Healthcare Heroes',hi:'हेल्थकेयर हीरोज',desc_en:'Doctors, healers — your empathy creates healing magic.',desc_hi:'डॉक्टर, हीलर — आपकी सहानुभूति हीलिंग मैजिक बनाती है।'},
  {icon:'📚',en:'Academic Scholars',hi:'अकादमिक विद्वान',desc_en:'Teaching, research — wisdom flows naturally between you.',desc_hi:'शिक्षण, अनुसंधान — आपके बीच ज्ञान स्वाभाविक रूप से बहता है।'},
  {icon:'⚖️',en:'Legal Eagles',hi:'लीगल ईगल्स',desc_en:'Law, advocacy — you two debate and defend like champions.',desc_hi:'कानून, वकालत — आप दोनों चैंपियन की तरह लड़ते हैं।'},
  {icon:'🌍',en:'Social Changemakers',hi:'सोशल चेंजमेकर',desc_en:'NGOs, activism — your hearts beat for humanity.',desc_hi:'NGO, एक्टिविज्म — आपके दिल मानवता के लिए धड़कते हैं।'},
  {icon:'💰',en:'Finance Gurus',hi:'फाइनेंस गुरु',desc_en:'Banking, investing — your combined financial sense is powerful.',desc_hi:'बैंकिंग, निवेश — आपकी संयुक्त वित्तीय समझ शक्तिशाली है।'},
  {icon:'🍳',en:'Culinary Masters',hi:'पाक कला गुरु',desc_en:'Food, restaurant — your flavors blend like a perfect recipe.',desc_hi:'खाना, रेस्तरां — आपके स्वाद एक परफेक्ट रेसिपी की तरह मिलते हैं।'}
];
var FC_PETS=[
  {emoji:'🐕',en:'Golden Retriever',hi:'गोल्डन रिट्रीवर',desc_en:'Loyal, joyful — just like your friendship.',desc_hi:'वफादार, खुशमिजाज — बिल्कुल आपकी दोस्ती की तरह।'},
  {emoji:'🐈',en:'Persian Cat',hi:'पर्शियन बिल्ली',desc_en:'Elegant and deep — your bond has quiet, unspoken magic.',desc_hi:'सुरुचिपूर्ण और गहरा — आपके बंधन में अनकही जादू है।'},
  {emoji:'🦜',en:'Talking Parrot',hi:'बोलने वाला तोता',desc_en:'Vibrant, expressive — you two are never boring!',desc_hi:'जीवंत, अभिव्यक्त — आप दोनों कभी उबाऊ नहीं!'},
  {emoji:'🐇',en:'Bunny',hi:'खरगोश',desc_en:'Gentle and heartwarming — your friendship warms every room.',desc_hi:'कोमल और दिल को छूने वाला — आपकी दोस्ती हर कमरे को गर्म करती है।'},
  {emoji:'🦊',en:'Fox',hi:'लोमड़ी',desc_en:'Clever, adventurous — perfect partners in crime!',desc_hi:'चतुर, साहसी — परफेक्ट पार्टनर्स!'},
  {emoji:'🐬',en:'Dolphin',hi:'डॉल्फिन',desc_en:'Playful, intelligent — your friendship thrives on joy.',desc_hi:'चंचल, बुद्धिमान — आपकी दोस्ती खुशी पर पनपती है।'},
  {emoji:'🦁',en:'Lion',hi:'शेर',desc_en:'Brave, protective — you\'d go to battle for each other.',desc_hi:'बहादुर, सुरक्षात्मक — आप एक-दूसरे के लिए लड़ते हैं।'},
  {emoji:'🦋',en:'Butterfly',hi:'तितली',desc_en:'Transformative — your friendship has evolved into something rare.',desc_hi:'परिवर्तनकारी — आपकी दोस्ती एक दुर्लभ चीज में विकसित हुई है।'}
];
var FC_SONGS=[
  {min:90,emoji:'🎵',en_song:"You've Got a Friend in Me",en_artist:'Randy Newman',hi_song:'ये दोस्ती हम नहीं छोड़ेंगे',hi_artist:'शोले (1975)'},
  {min:70,emoji:'🎶',en_song:'Count on Me',en_artist:'Bruno Mars',hi_song:'Yaara Teri Yaari',hi_artist:'Udit Narayan'},
  {min:50,emoji:'🎸',en_song:'Lean on Me',en_artist:'Bill Withers',hi_song:'Dost Dost Na Raha',hi_artist:'Sangam'},
  {min:30,emoji:'🎹',en_song:'With a Little Help from My Friends',en_artist:'The Beatles',hi_song:'Jaane Nahin Denge Tujhe',hi_artist:'3 Idiots'},
  {min:0,emoji:'🎤',en_song:'See You Again',en_artist:'Wiz Khalifa ft. Charlie Puth',hi_song:'Mere Yaar Ki Shaadi Hai',hi_artist:'Udit Narayan'}
];

function $fc(id){return document.getElementById(id);}
function fcSeed(s){var h=0;for(var i=0;i<s.length;i++){h=((h<<5)-h+s.charCodeAt(i))|0;}return Math.abs(h);}
function fcCalc(n1,n2){
  var a=(n1||'').toLowerCase().replace(/[^a-z]/g,''),b=(n2||'').toLowerCase().replace(/[^a-z]/g,'');
  if(!a||!b)return 55;
  var fA={},fB={},keys={};
  for(var i=0;i<a.length;i++)fA[a[i]]=(fA[a[i]]||0)+1;
  for(var j=0;j<b.length;j++)fB[b[j]]=(fB[b[j]]||0)+1;
  for(var k in fA)keys[k]=1;for(var k2 in fB)keys[k2]=1;
  var ov=0,tot=0;
  for(var k3 in keys){ov+=Math.min(fA[k3]||0,fB[k3]||0);tot+=Math.max(fA[k3]||0,fB[k3]||0);}
  var os=tot?(ov/tot)*100:50;
  var sA=0,sB=0;
  for(var i2=0;i2<a.length;i2++)sA+=a.charCodeAt(i2)-96;
  for(var j2=0;j2<b.length;j2++)sB+=b.charCodeAt(j2)-96;
  var ns=((sA+sB)%9+1)*10;
  var ls=Math.max(0,100-Math.abs(a.length-b.length)*10);
  var seed=fcSeed(a+b);
  var rand=(seed%30);
  var sc=Math.round(os*.35+ns*.25+ls*.2+rand*.5);
  if(sc<15)sc=15+(seed%20);if(sc>99)sc=99;return sc;
}
function fcMetrics(n1,n2,score){
  var seed=fcSeed((n1+n2).toLowerCase());
  function v(off){return Math.max(18,Math.min(99,Math.round(score+(((seed+off)%21)-10))));}
  return{loy:v(1),fun:v(2),sup:v(3),deep:v(4)};
}
function fcBond(s){
  if(s>=90)return 0;if(s>=70)return 1;if(s>=50)return 2;if(s>=30)return 3;return 4;
}
function fcDesc(s,n1,n2){
  if(s>=90)return n1+' and '+n2+' share a bond that transcends ordinary friendship — a rare soul connection. The universe brought you together for a reason. Cherish every moment, protect this sacred bond, and know that very few people in this world are lucky enough to find what you two have.';
  if(s>=70)return n1+' and '+n2+', your friendship is the kind that fills life with warmth and meaning. You lift each other up, laugh together, and show up when it counts. This is the friendship people write songs about.';
  if(s>=50)return n1+' and '+n2+', your friendship has a solid foundation with plenty of room to grow. There\'s genuine care, mutual respect, and shared laughter. Keep investing in this bond — the best chapters are still ahead.';
  if(s>=30)return n1+' and '+n2+', every great friendship takes time to bloom. You\'re building something real here. One honest conversation, one shared adventure at a time — your bond is quietly becoming something worth keeping.';
  return n1+' and '+n2+', even the strongest friendships started as strangers. The fact that you\'re exploring this connection says something. Be open, be kind, and let time reveal what this friendship can become.';
}
function fcDescHi(s,n1,n2){
  if(s>=90)return n1+' और '+n2+' का एक ऐसा बंधन है जो सामान्य दोस्ती से परे है — एक दुर्लभ आत्मीय संबंध। ब्रह्मांड ने आपको एक कारण से एक साथ लाया है।';
  if(s>=70)return n1+' और '+n2+', आपकी दोस्ती वह है जो जीवन को गर्मजोशी और अर्थ से भर देती है। आप एक-दूसरे को उठाते हैं, साथ हँसते हैं।';
  if(s>=50)return n1+' और '+n2+', आपकी दोस्ती की एक मजबूत नींव है जिसमें बढ़ने की काफी गुंजाइश है। इस बंधन में निवेश करते रहें।';
  if(s>=30)return n1+' और '+n2+', हर महान दोस्ती को खिलने में समय लगता है। एक ईमानदार बातचीत, एक साझा रोमांच — आपका बंधन कुछ खास बन रहा है।';
  return n1+' और '+n2+', यहां तक कि सबसे मजबूत दोस्तियां अजनबियों के रूप में शुरू हुईं। खुले रहें और समय को यह रिश्ता उजागर करने दें।';
}
function fcHints(s){
  if(s>=70)return[{i:'💌',t:'Daily Check-in',ti:'रोज संपर्क',d:"A quick 'thinking of you' message keeps friendships alive.",dhi:'एक छोटा सा संदेश दोस्ती को जीवित रखता है।'},{i:'🎉',t:'Celebrate Everything',ti:'हर चीज़ मनाएं',d:'Small wins, birthdays, random Tuesday — celebrate it all.',dhi:'छोटी जीत, जन्मदिन — सब कुछ मनाएं।'},{i:'🗝️',t:'Create Traditions',ti:'परंपराएं बनाएं',d:'Annual trips, monthly dinners — rituals strengthen bonds.',dhi:'वार्षिक यात्राएं, मासिक डिनर — परंपराएं बंधन मजबूत करती हैं।'},{i:'🔒',t:'Keep Secrets Sacred',ti:'राज सुरक्षित रखें',d:'Trust is built one kept secret at a time.',dhi:'विश्वास एक समय में एक रहस्य बनाए रखने से बनता है।'}];
  if(s>=40)return[{i:'🗣️',t:'Open Up More',ti:'अधिक खुलें',d:'Share one real thought a day. Vulnerability builds connection.',dhi:'एक दिन में एक असली विचार साझा करें। खुलापन कनेक्शन बनाता है।'},{i:'⏰',t:'Quality Time',ti:'गुणवत्ता समय',d:'Schedule phone-free time together — even 30 minutes.',dhi:'एक साथ फोन-मुक्त समय निर्धारित करें।'},{i:'🎯',t:'Shared Goals',ti:'साझा लक्ष्य',d:'A goal you both chase together pulls you closer.',dhi:'एक लक्ष्य जो आप दोनों साथ पीछा करते हैं, आपको करीब लाता है।'},{i:'🌱',t:'Grow Together',ti:'साथ बढ़ें',d:'Try a new hobby as a team. Shared learning deepens bonds.',dhi:'एक टीम के रूप में एक नया शौक आजमाएं।'}];
  return[{i:'👋',t:'Make the First Move',ti:'पहल करें',d:"Send a genuine 'Hey, how are you?' today.",dhi:'आज एक वास्तविक "हेय, कैसे हो?" भेजें।'},{i:'💬',t:'Real Conversations',ti:'असली बातें',d:'Skip small talk — share something that actually matters to you.',dhi:'छोटी बातें छोड़ें — कुछ ऐसा साझा करें जो वास्तव में मायने रखता है।'},{i:'🌟',t:'Be Genuine',ti:'वास्तविक रहें',d:'The best friendships start with authentic kindness.',dhi:'सबसे अच्छी दोस्तियां वास्तविक दयालुता से शुरू होती हैं।'},{i:'✨',t:'Stay Consistent',ti:'लगातार रहें',d:'Friendships grow in the small, consistent moments.',dhi:'दोस्तियां छोटे, लगातार पलों में बढ़ती हैं।'}];
}
function fcAdvice(s,n1,n2){
  if(s>=70)return{en:n1+' & '+n2+', the world becomes better when friends like you exist. Protect this bond fiercely, show up for each other without keeping score, and never take for granted what you have built together. Rare friendships deserve rare care.',hi:n1+' और '+n2+', जब आप जैसे दोस्त मौजूद हों तो दुनिया बेहतर हो जाती है। इस बंधन की रक्षा करें और एक-दूसरे के लिए बिना हिसाब रखे आगे आएं।',tags:['Unbreakable','Soul Connection','Ride or Die','Lifetime Bond']};
  if(s>=40)return{en:n1+' & '+n2+', you have the ingredients of a truly great friendship. Add more vulnerability, more presence, and more genuine laughter. The bond you\'re building will be one you\'re both grateful for years from now.',hi:n1+' और '+n2+', आपके पास एक सच्ची महान दोस्ती की सामग्री है। अधिक खुलापन और वास्तविक हँसी जोड़ें।',tags:['Growing Strong','Potential Unlocked','Worth Investing','Beautiful Journey']};
  return{en:n1+' & '+n2+', great things take time to grow — including friendships. Be patient, be kind, and stay open. Some of the world\'s most legendary friendships started exactly where yours is right now.',hi:n1+' और '+n2+', महान चीजों को बढ़ने में समय लगता है — दोस्ती सहित। धैर्य रखें, दयालु रहें, और खुले रहें।',tags:['Patience Wins','Authentic Start','New Chapter','Beautiful Possibilities']};
}
function fcGetCareer(n1,n2,score){var seed=fcSeed(n1.toLowerCase()+n2.toLowerCase());return FC_CAREERS[(seed+Math.floor(score/10))%FC_CAREERS.length];}
function fcGetPet(n1,n2){var seed=fcSeed((n1+n2).toLowerCase());return FC_PETS[seed%FC_PETS.length];}
function fcGetSong(score){for(var i=0;i<FC_SONGS.length;i++){if(score>=FC_SONGS[i].min)return FC_SONGS[i];}return FC_SONGS[FC_SONGS.length-1];}
function fcEsc(s){return String(s).replace(/[&<>"']/g,function(c){return({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'})[c];});}
function fcAnimNum(el,from,to,dur){var start=performance.now();function tick(now){var p=Math.min(1,(now-start)/dur),e=1-Math.pow(1-p,3);el.textContent=Math.round(from+(to-from)*e);if(p<1)requestAnimationFrame(tick);}requestAnimationFrame(tick);}
function fcConfetti(){var colors=['#7B2D8B','#E63946','#d4af37','#fff','#ff6b9d'],box=document.createElement('div');box.className='fc-confetti';for(var i=0;i<60;i++){var p=document.createElement('i');p.style.left=(Math.random()*100)+'%';p.style.background=colors[Math.floor(Math.random()*colors.length)];p.style.animationDuration=(1.5+Math.random()*2)+'s';p.style.animationDelay=(Math.random()*.5)+'s';p.style.transform='rotate('+(Math.random()*360)+'deg)';box.appendChild(p);}document.body.appendChild(box);setTimeout(function(){box.remove();},4000);}

var fcState={nameA:'',nameB:'',score:0,advOn:false};
var fcLoadSteps=['en','en','en','en'];
function fcRunLoad(cb){
  var stepEl=$fc('fc-load-step'),barEl=$fc('fc-progress-bar'),i=0;
  var steps=[T[lang].load1,T[lang].load2,T[lang].load3,T[lang].load4];
  stepEl.textContent=steps[0];barEl.style.width='8%';
  var iv=setInterval(function(){i++;if(i<steps.length){stepEl.style.opacity='0';setTimeout(function(){stepEl.textContent=steps[i];stepEl.style.opacity='1';},200);barEl.style.width=((i+1)*25)+'%';}else{clearInterval(iv);barEl.style.width='100%';setTimeout(cb,350);}},700);
}
function fcApplyLang(){
  var t=T[lang];
  $fc('fc-title').textContent=t.title;
  $fc('fc-subtitle').textContent=t.subtitle;
  $fc('fc-stat1-lbl').textContent=t.stat1;$fc('fc-stat2-lbl').textContent=t.stat2;$fc('fc-stat3-lbl').textContent=t.stat3;
  $fc('fc-name-a').placeholder=t.placeholder_a;$fc('fc-name-b').placeholder=t.placeholder_b;
  $fc('fc-calc-btn').textContent=t.calc_btn;
  $fc('fc-adv-lbl').textContent=t.adv_lbl;
  $fc('fc-hints-title').textContent=t.hints_title;
  $fc('fc-advice-title').textContent=t.advice_title;
  $fc('fc-try-btn').textContent=t.try_btn;
  $fc('fc-related-title').textContent=t.related_title;
  $fc('fc-lang-btn').textContent=t.lang_switch;
  $fc('fc-career-lbl').textContent=t.career_lbl;$fc('fc-pet-lbl').textContent=t.pet_lbl;$fc('fc-song-lbl').textContent=t.song_lbl;
  for(var i=0;i<5;i++){var lv=$fc('fc-lv'+(i+1)),ld=$fc('fc-ld'+(i+1));if(lv)lv.textContent=t.lv[i];if(ld)ld.textContent=t.ld[i];}
}
function fcShowResult(){
  var n1=fcState.nameA,n2=fcState.nameB;
  var score=fcCalc(n1,n2),metrics=fcMetrics(n1,n2,score),bondIdx=fcBond(score);
  var t=T[lang];
  fcState.score=score;
  $fc('fc-rc-n-a').textContent=n1;$fc('fc-rc-n-b').textContent=n2;
  $fc('fc-rc-av-a').textContent=n1.charAt(0).toUpperCase();$fc('fc-rc-av-b').textContent=n2.charAt(0).toUpperCase();
  $fc('fc-bond').textContent=t.bond[bondIdx];
  $fc('fc-desc').textContent=lang==='hi'?fcDescHi(score,n1,n2):fcDesc(score,n1,n2);
  $fc('fc-loading').classList.remove('fc-show');$fc('fc-loading').style.display='none';
  $fc('fc-result').classList.add('fc-show');
  fcAnimNum($fc('fc-pct'),0,score,1800);
  var circ=2*Math.PI*86;
  setTimeout(function(){$fc('fc-ring-fg').style.strokeDashoffset=circ-(circ*score/100);},80);
  setTimeout(function(){
    $fc('fc-b1').style.width=metrics.loy+'%';$fc('fc-b2').style.width=metrics.fun+'%';
    $fc('fc-b3').style.width=metrics.sup+'%';$fc('fc-b4').style.width=metrics.deep+'%';
    $fc('fc-b1-v').textContent=metrics.loy+'%';$fc('fc-b2-v').textContent=metrics.fun+'%';
    $fc('fc-b3-v').textContent=metrics.sup+'%';$fc('fc-b4-v').textContent=metrics.deep+'%';
  },200);
  // Bar labels
  $fc('fc-b1').previousElementSibling&&($fc('fc-result').querySelector('#fc-b1').parentElement.previousElementSibling.querySelector('span:first-child').textContent=t.bar1);
  var barLabels=document.querySelectorAll('#fc-result .fc-bar-top span:first-child');
  if(barLabels[0])barLabels[0].textContent=t.bar1;if(barLabels[1])barLabels[1].textContent=t.bar2;if(barLabels[2])barLabels[2].textContent=t.bar3;if(barLabels[3])barLabels[3].textContent=t.bar4;
  // Advanced
  var career=fcGetCareer(n1,n2,score),pet=fcGetPet(n1,n2),song=fcGetSong(score);
  $fc('fc-career-icon').textContent=career.icon;$fc('fc-career-name').textContent=lang==='hi'?career.hi:career.en;$fc('fc-career-desc').textContent=lang==='hi'?career.desc_hi:career.desc_en;
  $fc('fc-pet-icon').textContent=pet.emoji;$fc('fc-pet-name').textContent=lang==='hi'?pet.hi:pet.en;$fc('fc-pet-desc').textContent=lang==='hi'?pet.desc_hi:pet.desc_en;
  $fc('fc-song-icon').textContent=song.emoji;$fc('fc-song-name').textContent=lang==='hi'?song.hi_song:song.en_song;$fc('fc-song-artist').textContent=lang==='hi'?song.hi_artist:song.en_artist;
  if(fcState.advOn){$fc('fc-adv-result').style.display='block';$fc('fc-adv-result').classList.add('fc-adv-on');}
  // Hints
  $fc('fc-hints-title').textContent=t.hints_title+' — '+n1+' & '+n2;
  var hints=fcHints(score),hg=$fc('fc-hints-grid');hg.innerHTML='';
  hints.forEach(function(h,hi){var c=document.createElement('div');c.className='fc-hint';c.style.animationDelay=(hi*.1)+'s';c.innerHTML='<div class="fc-hint-icon">'+h.i+'</div><h4>'+fcEsc(lang==='hi'?h.ti:h.t)+'</h4><p>'+fcEsc(lang==='hi'?h.dhi:h.d)+'</p>';hg.appendChild(c);});
  // Advice
  var adv=fcAdvice(score,n1,n2);
  $fc('fc-advice-text').textContent=lang==='hi'?adv.hi:adv.en;
  var tb=$fc('fc-tags');tb.innerHTML='';
  adv.tags.forEach(function(tag,ti){var s=document.createElement('span');s.className='fc-tag fc-t'+((ti%4)+1);s.textContent=tag;tb.appendChild(s);});
  // Share
  var url=window.location.href,msg='🤝 Friendship Calculator Result!\n\n'+n1+' + '+n2+' = *'+score+'% Friendship*\nStatus: *'+t.bond[bondIdx]+'*\n\nTest yours: '+url;
  $fc('fc-sb-wa').href='https://wa.me/?text='+encodeURIComponent(msg);
  $fc('fc-sb-tw').href='https://twitter.com/intent/tweet?text='+encodeURIComponent(n1+' & '+n2+' = '+score+'% Friendship 🤝! Check yours:')+'&url='+encodeURIComponent(url);
  $fc('fc-sb-copy').onclick=function(){var btn=this,orig=btn.innerHTML;try{navigator.clipboard?navigator.clipboard.writeText(url).then(function(){btn.innerHTML='✅ Copied!';setTimeout(function(){btn.innerHTML=orig;},1800);}):(function(){var ta=document.createElement('textarea');ta.value=url;document.body.appendChild(ta);ta.select();document.execCommand('copy');ta.remove();btn.innerHTML='✅ Copied!';setTimeout(function(){btn.innerHTML=orig;},1800);})();}catch(e){btn.innerHTML='⚠️';setTimeout(function(){btn.innerHTML=orig;},1800);}};
  $fc('fc-sb-save').onclick=function(){var btn=this,orig=btn.innerHTML;btn.innerHTML='📸...';setTimeout(function(){navigator.share?navigator.share({title:'Friendship Calculator Result',text:msg,url:url}).catch(function(){alert('Screenshot your result!\n'+n1+' + '+n2+' = '+score+'% Friendship');}).finally(function(){btn.innerHTML=orig;}):alert('Screenshot your result!\n'+n1+' + '+n2+' = '+score+'% Friendship\n'+t.bond[bondIdx]);btn.innerHTML=orig;},400);};
  if(score>=70)setTimeout(fcConfetti,600);
  setTimeout(function(){$fc('fc-result').scrollIntoView({behavior:'smooth',block:'start'});},100);
}

// Event listeners
$fc('fc-name-a').addEventListener('input',function(){var v=(this.value||'').trim();$fc('fc-av-a').textContent=v?v.charAt(0).toUpperCase():'?';$fc('fc-error').classList.remove('fc-show');});
$fc('fc-name-b').addEventListener('input',function(){var v=(this.value||'').trim();$fc('fc-av-b').textContent=v?v.charAt(0).toUpperCase():'?';$fc('fc-error').classList.remove('fc-show');});
$fc('fc-calc-btn').addEventListener('click',function(){
  var n1=($fc('fc-name-a').value||'').trim(),n2=($fc('fc-name-b').value||'').trim(),err=$fc('fc-error');
  if(!n1||!n2){err.textContent=T[lang].error;err.classList.add('fc-show');return;}
  if(n1.length<2||n2.length<2){err.textContent=T[lang].error2;err.classList.add('fc-show');return;}
  err.classList.remove('fc-show');
  fcState.nameA=n1;fcState.nameB=n2;
  $fc('fc-input-phase').style.display='none';
  var loading=$fc('fc-loading');loading.style.display='block';loading.classList.add('fc-show');
  $fc('fc-load-names').textContent=n1+' 🤝 '+n2;$fc('fc-progress-bar').style.width='0%';
  fcRunLoad(fcShowResult);
});
[$fc('fc-name-a'),$fc('fc-name-b')].forEach(function(el){el.addEventListener('keydown',function(e){if(e.key==='Enter'){e.preventDefault();$fc('fc-calc-btn').click();}});});
$fc('fc-try-btn').addEventListener('click',function(){
  $fc('fc-result').classList.remove('fc-show');$fc('fc-loading').classList.remove('fc-show');$fc('fc-loading').style.display='none';
  $fc('fc-input-phase').style.display='block';$fc('fc-name-a').value='';$fc('fc-name-b').value='';
  $fc('fc-av-a').textContent='?';$fc('fc-av-b').textContent='?';$fc('fc-pct').textContent='0';
  $fc('fc-ring-fg').style.strokeDashoffset=540.35;['fc-b1','fc-b2','fc-b3','fc-b4'].forEach(function(id){$fc(id).style.width='0%';});
  $fc('fc-adv-result').style.display='none';
  $fc('fc-input-phase').scrollIntoView({behavior:'smooth',block:'start'});setTimeout(function(){$fc('fc-name-a').focus();},400);
});
$fc('fc-lang-btn').addEventListener('click',function(){lang=lang==='en'?'hi':'en';fcApplyLang();});
$fc('fc-adv-chk').addEventListener('change',function(){
  fcState.advOn=this.checked;
  if($fc('fc-result').classList.contains('fc-show')){
    var sec=$fc('fc-adv-result');sec.style.display=this.checked?'block':'none';
    if(this.checked)sec.classList.add('fc-adv-on');else sec.classList.remove('fc-adv-on');
  }
});
var fcCnt=241876;setInterval(function(){fcCnt+=1+Math.floor(Math.random()*3);$fc('fc-counter').textContent=fcCnt.toLocaleString('en-IN');},9000);
})();
</script>
</div>
<?php
    return ob_get_clean();
}
add_shortcode( 'friendship_calculator', 'fc_render' );
}

// ═══════════════════════════════════════════════════════════════
// 3. MULANK CALCULATOR  [mulank_calculator]
// ═══════════════════════════════════════════════════════════════
if ( ! function_exists( 'mk_render' ) ) {
function mk_render( $atts = [] ) {
    ob_start(); ?>
<div class="mk-wrap" id="mk-wrap">
<style>
.mk-wrap,.mk-wrap *,.mk-wrap *::before,.mk-wrap *::after{box-sizing:border-box}
.mk-wrap{font-family:'DM Sans','Inter',-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;color:#1f1933;max-width:880px;margin:0 auto;padding:12px;line-height:1.55}
.mk-wrap h1,.mk-wrap h2,.mk-wrap h3,.mk-wrap h4{font-family:'Poppins',system-ui,sans-serif;font-weight:800;letter-spacing:-.01em;margin:0}
.mk-topbar{display:flex;align-items:center;justify-content:flex-end;gap:10px;margin-bottom:10px;flex-wrap:wrap}
.mk-lang-btn{padding:7px 16px;border-radius:999px;border:2px solid #7B2D8B;background:#fff;color:#7B2D8B;font-weight:700;font-size:13px;cursor:pointer;font-family:'Poppins',sans-serif;transition:all .2s}
.mk-lang-btn:hover{background:#7B2D8B;color:#fff}
.mk-adv-wrap{display:flex;align-items:center;gap:7px;font-size:13px;font-weight:600;color:#5b5070;cursor:pointer}
.mk-adv-toggle{position:relative;width:40px;height:22px}
.mk-adv-toggle input{opacity:0;width:0;height:0}
.mk-adv-slider{position:absolute;inset:0;border-radius:999px;background:#ddd;transition:.3s;cursor:pointer}
.mk-adv-slider::before{content:"";position:absolute;height:16px;width:16px;left:3px;bottom:3px;background:#fff;border-radius:50%;transition:.3s}
.mk-adv-toggle input:checked+.mk-adv-slider{background:#7B2D8B}
.mk-adv-toggle input:checked+.mk-adv-slider::before{transform:translateX(18px)}
.mk-header{background:linear-gradient(135deg,#1a0533 0%,#3d0b55 50%,#0d1a45 100%);border-radius:22px;padding:28px 20px;color:#fff;text-align:center;box-shadow:0 20px 60px rgba(61,11,85,.3);position:relative;overflow:hidden}
.mk-header::before{content:"";position:absolute;inset:-50%;background:radial-gradient(circle at 30% 20%,rgba(212,175,55,.15),transparent 60%),radial-gradient(circle at 70% 80%,rgba(123,45,139,.25),transparent 60%);pointer-events:none}
.mk-header-icon{font-size:50px;line-height:1;display:inline-block;animation:mk-bob 2.4s ease-in-out infinite}
.mk-header h1{font-size:36px;margin:8px 0 6px;color:#fff}
.mk-header-sub{opacity:.86;font-size:15px;margin:0}
.mk-stats{display:flex;align-items:center;justify-content:center;margin-top:18px;flex-wrap:wrap}
.mk-stat{padding:4px 14px;min-width:96px;text-align:center}
.mk-stat-num{font-weight:800;font-family:'Poppins',sans-serif;font-size:18px;color:#fff}
.mk-stat-lbl{font-size:11px;opacity:.78;text-transform:uppercase;letter-spacing:.06em}
.mk-stat+.mk-stat{border-left:1px solid rgba(255,255,255,.22)}
.mk-card{background:#fff;border-radius:22px;padding:28px 20px;margin-top:18px;box-shadow:0 20px 60px rgba(0,0,0,.08);border:1px solid #f1ecf6}
.mk-dob-group{display:flex;gap:12px;justify-content:center;flex-wrap:wrap;margin-bottom:18px}
.mk-select-wrap{display:flex;flex-direction:column;align-items:center;gap:6px;flex:1;min-width:90px}
.mk-select-lbl{font-size:12px;font-weight:700;color:#5b5070;text-transform:uppercase;letter-spacing:.06em}
.mk-select{width:100%;min-height:52px;padding:12px 14px;font-size:16px;border:2px solid #ece6f3;border-radius:14px;outline:none;background:#faf8fd;transition:border-color .2s,box-shadow .2s;font-family:inherit;cursor:pointer;appearance:none;-webkit-appearance:none;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%237B2D8B' stroke-width='2' fill='none'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 14px center}
.mk-select:focus{border-color:#7B2D8B;background-color:#fff;box-shadow:0 0 0 4px rgba(123,45,139,.12)}
.mk-btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;min-height:56px;padding:18px 22px;font-size:17px;font-weight:700;font-family:'Poppins',sans-serif;border:none;border-radius:14px;cursor:pointer;width:100%;transition:transform .15s,box-shadow .2s}
.mk-btn-primary{background:linear-gradient(135deg,#3d0b55,#7B2D8B);color:#fff;box-shadow:0 14px 32px rgba(123,45,139,.35)}
.mk-btn-primary:hover{transform:translateY(-2px);box-shadow:0 18px 40px rgba(123,45,139,.45)}
.mk-trust{display:flex;gap:10px;justify-content:center;flex-wrap:wrap;margin-top:14px}
.mk-trust span{font-size:12.5px;color:#5b5070;background:#f6f0fb;padding:6px 12px;border-radius:999px;display:inline-flex;align-items:center}
.mk-error{display:none;background:#fff1f2;color:#b3162a;border:1px solid #ffd6db;padding:10px 14px;border-radius:12px;margin-top:12px;font-size:14px;text-align:center}
.mk-error.mk-show{display:block;animation:mk-shake .4s}
.mk-loading{display:none;text-align:center;padding:14px 8px}
.mk-loading.mk-show{display:block}
.mk-load-rings{position:relative;width:160px;height:160px;margin:6px auto 18px}
.mk-load-ring{position:absolute;inset:0;border-radius:50%;border:3px solid rgba(123,45,139,.35);animation:mk-ring-anim 2s ease-out infinite}
.mk-load-ring:nth-child(2){animation-delay:.5s;border-color:rgba(212,175,55,.4)}
.mk-load-ring:nth-child(3){animation-delay:1s;border-color:rgba(230,57,70,.35)}
.mk-load-icon{position:absolute;inset:0;display:flex;align-items:center;justify-content:center;font-size:60px;animation:mk-pulse 1.2s ease-in-out infinite}
.mk-load-step{font-size:15px;color:#6b5e85;min-height:24px;transition:opacity .25s}
.mk-progress{height:8px;background:#f1ebf7;border-radius:999px;overflow:hidden;margin:14px auto 4px;max-width:360px}
.mk-progress-bar{height:100%;width:0%;background:linear-gradient(90deg,#3d0b55,#d4af37);border-radius:999px;transition:width .3s ease}
.mk-result{display:none}
.mk-result.mk-show{display:block;animation:mk-fadeUp .55s ease both}
.mk-nums-grid{display:grid;grid-template-columns:1fr 1fr;gap:18px;margin-bottom:18px}
.mk-num-card{background:linear-gradient(135deg,#1a0533,#3d0b55);color:#fff;border-radius:22px;padding:28px 20px;text-align:center;box-shadow:0 20px 50px rgba(0,0,0,.2);position:relative;overflow:hidden}
.mk-num-card::after{content:"";position:absolute;inset:0;background:radial-gradient(circle at 30% 20%,rgba(212,175,55,.2),transparent 60%);pointer-events:none}
.mk-num-card h3{font-size:14px;text-transform:uppercase;letter-spacing:.1em;opacity:.8;margin-bottom:10px;position:relative;z-index:1}
.mk-big-num{font-size:80px;font-weight:800;font-family:'Poppins',sans-serif;line-height:1;position:relative;z-index:1;animation:mk-num-reveal .8s cubic-bezier(.22,.9,.3,1) both}
.mk-num-planet{font-size:14px;opacity:.85;margin-top:4px;position:relative;z-index:1}
.mk-num-card .mk-num-color{width:24px;height:24px;border-radius:50%;margin:8px auto 0;position:relative;z-index:1;box-shadow:0 4px 12px rgba(0,0,0,.3)}
.mk-info-section{background:#fff;border-radius:18px;padding:20px;margin-top:18px;box-shadow:0 10px 30px rgba(0,0,0,.06);border:1px solid #f1ecf6}
.mk-info-section h3{font-size:18px;color:#3d0b55;margin-bottom:14px}
.mk-traits-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:10px}
.mk-trait{background:#faf8fd;border-radius:12px;padding:10px 14px;font-size:14px;font-weight:600;color:#3d0b55;border-left:3px solid #7B2D8B;display:flex;align-items:center;gap:8px}
.mk-lucky-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:12px;margin-top:0}
.mk-lucky-card{background:#faf8fd;border-radius:14px;padding:14px;text-align:center}
.mk-lucky-card .mk-lucky-icon{font-size:28px;margin-bottom:6px}
.mk-lucky-card h4{font-size:12px;text-transform:uppercase;letter-spacing:.06em;color:#6b5e85;margin-bottom:4px}
.mk-lucky-card p{font-size:15px;font-weight:700;color:#1f1933;margin:0}
.mk-career-list{list-style:none;padding:0;margin:0;display:grid;grid-template-columns:repeat(2,1fr);gap:8px}
.mk-career-list li{background:linear-gradient(135deg,#f6f0fb,#ece6f3);border-radius:12px;padding:10px 14px;font-size:14px;font-weight:600;color:#3d0b55;display:flex;align-items:center;gap:8px}
.mk-year-card{background:linear-gradient(135deg,#fff8dc,#fff1c1);border-radius:18px;padding:20px;margin-top:18px;border:1px solid #f7e190}
.mk-year-card h3{font-size:18px;color:#7a5a05;margin-bottom:10px}
.mk-year-card p{color:#3d2200;font-size:15px;margin:0}
.mk-compat-section{margin-top:18px;display:none}
.mk-compat-section.mk-adv-on{display:block;animation:mk-fadeUp .4s ease both}
.mk-compat-grid{display:flex;flex-wrap:wrap;gap:8px;margin-top:10px}
.mk-compat-pill{padding:8px 16px;border-radius:999px;font-size:13px;font-weight:700;font-family:'Poppins',sans-serif;display:inline-flex;align-items:center;gap:6px}
.mk-compat-pill.mk-best{background:#e7f7ec;color:#155d3a;border:1px solid #b8e2c5}
.mk-compat-pill.mk-good{background:#fff8dc;color:#7a5a05;border:1px solid #f7e190}
.mk-compat-pill.mk-avoid{background:#fff1f2;color:#b3162a;border:1px solid #ffd6db}
.mk-share{display:grid;grid-template-columns:repeat(4,1fr);gap:10px;margin-top:18px}
.mk-share-btn{display:inline-flex;align-items:center;justify-content:center;gap:6px;min-height:48px;padding:12px 8px;font-size:14px;font-weight:700;font-family:'Poppins',sans-serif;border-radius:12px;border:none;cursor:pointer;color:#fff;text-decoration:none;transition:transform .15s,box-shadow .15s}
.mk-share-btn:hover{transform:translateY(-2px);box-shadow:0 12px 26px rgba(0,0,0,.15)}
.mk-sb-wa{background:#25d366}.mk-sb-tw{background:#111}
.mk-sb-save{background:linear-gradient(135deg,#3d0b55,#d4af37)}.mk-sb-copy{background:#5b5b6e}
.mk-try{margin-top:14px;background:#fff;color:#3d0b55;border:2px solid #ece6f3}
.mk-try:hover{border-color:#7B2D8B;color:#7B2D8B}
.mk-related{margin-top:22px}.mk-related h2{font-size:22px;color:#3d0b55;margin-bottom:12px}
.mk-related-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:12px}
.mk-rt{display:block;text-decoration:none;background:#fff;border-radius:16px;padding:16px 12px;text-align:center;box-shadow:0 10px 24px rgba(0,0,0,.06);color:inherit;transition:transform .15s,box-shadow .2s}
.mk-rt:hover{transform:translateY(-3px);box-shadow:0 16px 32px rgba(0,0,0,.1)}
.mk-rt:nth-child(1){border-top:4px solid #d4af37}
.mk-rt:nth-child(2){border-top:4px solid #E63946}
.mk-rt:nth-child(3){border-top:4px solid #7B2D8B}
.mk-rt:nth-child(4){border-top:4px solid #14b8a6}
.mk-rt-icon{font-size:28px}.mk-rt h4{font-size:14px;color:#1f1933;margin:6px 0 4px}.mk-rt p{font-size:12px;color:#5b5070;margin:0}
@keyframes mk-pulse{0%,100%{transform:scale(1)}50%{transform:scale(1.08)}}
@keyframes mk-bob{0%,100%{transform:translateY(0)}50%{transform:translateY(-6px)}}
@keyframes mk-ring-anim{0%{transform:scale(.6);opacity:.9}100%{transform:scale(1.4);opacity:0}}
@keyframes mk-fadeUp{from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:translateY(0)}}
@keyframes mk-shake{0%,100%{transform:translateX(0)}25%{transform:translateX(-4px)}75%{transform:translateX(4px)}}
@keyframes mk-num-reveal{from{opacity:0;transform:scale(.5) rotateY(90deg)}to{opacity:1;transform:scale(1) rotateY(0)}}
@media(max-width:640px){.mk-nums-grid{grid-template-columns:1fr}.mk-share{grid-template-columns:repeat(2,1fr)}.mk-related-grid{grid-template-columns:repeat(2,1fr)}.mk-traits-grid{grid-template-columns:1fr}.mk-career-list{grid-template-columns:1fr}.mk-lucky-grid{grid-template-columns:1fr}.mk-big-num{font-size:64px}}
</style>

<div class="mk-topbar">
  <button class="mk-lang-btn" id="mk-lang-btn">हिंदी</button>
  <label class="mk-adv-wrap" for="mk-adv-chk">
    <span id="mk-adv-lbl">Advanced Mode</span>
    <span class="mk-adv-toggle"><input type="checkbox" id="mk-adv-chk"><span class="mk-adv-slider"></span></span>
  </label>
</div>

<header class="mk-header">
  <div class="mk-header-icon">🔢</div>
  <h1 id="mk-title">Mulank Calculator</h1>
  <p class="mk-header-sub" id="mk-subtitle">Discover Your Mulank (Root Number) & Bhagyank (Destiny Number)</p>
  <div class="mk-stats">
    <div class="mk-stat"><div class="mk-stat-num" id="mk-counter">1,87,432</div><div class="mk-stat-lbl" id="mk-stat1">Tests Today</div></div>
    <div class="mk-stat"><div class="mk-stat-num">4.9★</div><div class="mk-stat-lbl" id="mk-stat2">Accuracy</div></div>
    <div class="mk-stat"><div class="mk-stat-num">100%</div><div class="mk-stat-lbl" id="mk-stat3">Free</div></div>
  </div>
</header>

<section class="mk-card">
  <div id="mk-input-phase">
    <div class="mk-dob-group">
      <div class="mk-select-wrap">
        <span class="mk-select-lbl" id="mk-day-lbl">Day</span>
        <select class="mk-select" id="mk-day" aria-label="Birth Day"></select>
      </div>
      <div class="mk-select-wrap">
        <span class="mk-select-lbl" id="mk-month-lbl">Month</span>
        <select class="mk-select" id="mk-month" aria-label="Birth Month"></select>
      </div>
      <div class="mk-select-wrap">
        <span class="mk-select-lbl" id="mk-year-lbl">Year</span>
        <select class="mk-select" id="mk-year" aria-label="Birth Year"></select>
      </div>
    </div>
    <div class="mk-error" id="mk-error">Please select your complete date of birth.</div>
    <button type="button" class="mk-btn mk-btn-primary" id="mk-calc-btn">Calculate My Numbers 🔢</button>
    <div class="mk-trust"><span>🔒 Private</span><span>⚡ Instant</span><span>🌙 Vedic Numerology</span></div>
  </div>

  <div class="mk-loading" id="mk-loading">
    <div class="mk-load-rings"><div class="mk-load-ring"></div><div class="mk-load-ring"></div><div class="mk-load-ring"></div><div class="mk-load-icon">🔢</div></div>
    <div class="mk-load-step" id="mk-load-step">🌙 Reading planetary positions...</div>
    <div class="mk-progress"><div class="mk-progress-bar" id="mk-progress-bar"></div></div>
  </div>

  <div class="mk-result" id="mk-result">
    <div class="mk-nums-grid">
      <div class="mk-num-card">
        <h3 id="mk-mulank-label">Mulank (Root Number)</h3>
        <div class="mk-big-num" id="mk-mulank-num">1</div>
        <div class="mk-num-planet" id="mk-mulank-planet">☀️ Sun</div>
        <div class="mk-num-color" id="mk-mulank-color"></div>
      </div>
      <div class="mk-num-card">
        <h3 id="mk-bhagyank-label">Bhagyank (Destiny Number)</h3>
        <div class="mk-big-num" id="mk-bhagyank-num">1</div>
        <div class="mk-num-planet" id="mk-bhagyank-planet">☀️ Sun</div>
        <div class="mk-num-color" id="mk-bhagyank-color"></div>
      </div>
    </div>

    <div class="mk-info-section" id="mk-mulank-info">
      <h3 id="mk-traits-title">✨ Your Core Traits (Mulank)</h3>
      <div class="mk-traits-grid" id="mk-traits-grid"></div>
    </div>

    <div class="mk-info-section" style="margin-top:14px">
      <h3 id="mk-lucky-title">🍀 Lucky Elements</h3>
      <div class="mk-lucky-grid" id="mk-lucky-grid"></div>
    </div>

    <div class="mk-info-section" style="margin-top:14px">
      <h3 id="mk-career-title">💼 Best Career Paths</h3>
      <ul class="mk-career-list" id="mk-career-list"></ul>
    </div>

    <div class="mk-year-card">
      <h3 id="mk-year-title">🔮 Your 2026 Forecast</h3>
      <p id="mk-year-text"></p>
    </div>

    <div class="mk-compat-section" id="mk-compat-section">
      <div class="mk-info-section">
        <h3 id="mk-compat-title">♾️ Number Compatibility</h3>
        <div style="margin-bottom:8px"><strong id="mk-compat-best-lbl" style="color:#155d3a">✅ Best With:</strong> <div class="mk-compat-grid" id="mk-compat-best"></div></div>
        <div style="margin-bottom:8px"><strong id="mk-compat-good-lbl" style="color:#7a5a05">⚡ Good With:</strong> <div class="mk-compat-grid" id="mk-compat-good"></div></div>
        <div><strong id="mk-compat-care-lbl" style="color:#b3162a">⚠️ Needs Care:</strong> <div class="mk-compat-grid" id="mk-compat-avoid"></div></div>
      </div>
    </div>

    <div class="mk-share">
      <a href="#" class="mk-share-btn mk-sb-wa" id="mk-sb-wa" target="_blank" rel="noopener">📱 WhatsApp</a>
      <a href="#" class="mk-share-btn mk-sb-tw" id="mk-sb-tw" target="_blank" rel="noopener">𝕏 Twitter</a>
      <button type="button" class="mk-share-btn mk-sb-save" id="mk-sb-save">📸 Save</button>
      <button type="button" class="mk-share-btn mk-sb-copy" id="mk-sb-copy">🔗 Copy</button>
    </div>
    <button type="button" class="mk-btn mk-try" id="mk-try-btn">🔄 Calculate Again</button>
  </div>
</section>

<section class="mk-related">
  <h2 id="mk-related-title">Explore More Tools</h2>
  <div class="mk-related-grid">
    <a class="mk-rt" href="/love-calculator/"><div class="mk-rt-icon">❤️</div><h4>Love Calc</h4><p>Test love compatibility</p></a>
    <a class="mk-rt" href="/friendship-calculator/"><div class="mk-rt-icon">🤝</div><h4>Friendship</h4><p>Friendship bond strength</p></a>
    <a class="mk-rt" href="/crush-calculator/"><div class="mk-rt-icon">💘</div><h4>Crush Calc</h4><p>Does your crush like you?</p></a>
    <a class="mk-rt" href="/flames-calculator/"><div class="mk-rt-icon">🔥</div><h4>FLAMES</h4><p>Classic name game</p></a>
  </div>
</section>

<script type="application/ld+json">{"@context":"https://schema.org","@type":"SoftwareApplication","name":"Mulank Calculator - Mulank & Bhagyank","description":"Free Mulank (Root Number) and Bhagyank (Destiny Number) calculator based on Vedic numerology. Get your personality traits, lucky elements, career paths and 2026 forecast.","applicationCategory":"LifestyleApplication","operatingSystem":"Web","offers":{"@type":"Offer","price":"0","priceCurrency":"USD"},"aggregateRating":{"@type":"AggregateRating","ratingValue":"4.9","ratingCount":"7312"}}</script>

<script>
(function(){
'use strict';
var mkLang='en';
var MKT={
  en:{title:'Mulank Calculator',subtitle:'Discover Your Mulank (Root Number) & Bhagyank (Destiny Number)',stat1:'Tests Today',stat2:'Accuracy',stat3:'Free',day_lbl:'Day',month_lbl:'Month',year_lbl:'Year',calc_btn:'Calculate My Numbers 🔢',adv_lbl:'Advanced Mode',lang_switch:'हिंदी',mulank_lbl:'Mulank (Root Number)',bhagyank_lbl:'Bhagyank (Destiny Number)',traits_title:'✨ Your Core Traits (Mulank)',lucky_title:'🍀 Lucky Elements',career_title:'💼 Best Career Paths',year_title:'🔮 Your 2026 Forecast',compat_title:'♾️ Number Compatibility',compat_best:'✅ Best With:',compat_good:'⚡ Good With:',compat_care:'⚠️ Needs Care:',related_title:'Explore More Tools',try_btn:'🔄 Calculate Again',error:'Please select your complete date of birth.',lucky_color:'Lucky Color',lucky_day:'Lucky Day',lucky_gem:'Lucky Gem',lucky_num:'Lucky Numbers',months:['January','February','March','April','May','June','July','August','September','October','November','December'],load1:'🌙 Reading planetary positions...',load2:'🔢 Calculating your root number...',load3:'✨ Decoding your destiny...',load4:'🎯 Preparing your cosmic profile...'},
  hi:{title:'मूलांक कैलकुलेटर',subtitle:'अपना मूलांक और भाग्यांक जानें',stat1:'आज के टेस्ट',stat2:'सटीकता',stat3:'मुफ्त',day_lbl:'दिन',month_lbl:'महीना',year_lbl:'वर्ष',calc_btn:'मेरे अंक जानें 🔢',adv_lbl:'एडवांस्ड मोड',lang_switch:'English',mulank_lbl:'मूलांक (जन्मांक)',bhagyank_lbl:'भाग्यांक (नसीब अंक)',traits_title:'✨ आपके मुख्य गुण (मूलांक)',lucky_title:'🍀 भाग्यशाली तत्व',career_title:'💼 सर्वश्रेष्ठ करियर',year_title:'🔮 आपकी 2026 भविष्यवाणी',compat_title:'♾️ अंक अनुकूलता',compat_best:'✅ सबसे अच्छे साथ:',compat_good:'⚡ अच्छे साथ:',compat_care:'⚠️ ध्यान दें:',related_title:'और टूल्स आजमाएं',try_btn:'🔄 फिर गणना करें',error:'कृपया अपनी पूरी जन्म तिथि चुनें।',lucky_color:'भाग्यशाली रंग',lucky_day:'भाग्यशाली दिन',lucky_gem:'भाग्यशाली रत्न',lucky_num:'भाग्यशाली अंक',months:['जनवरी','फरवरी','मार्च','अप्रैल','मई','जून','जुलाई','अगस्त','सितंबर','अक्टूबर','नवंबर','दिसंबर'],load1:'🌙 ग्रह स्थितियां पढ़ी जा रही हैं...',load2:'🔢 आपका मूलांक गणना हो रहा है...',load3:'✨ आपके भाग्य का विश्लेषण...',load4:'🎯 आपका कॉस्मिक प्रोफाइल तैयार हो रहा है...'}
};
var MK_DATA={
  1:{planet:{en:'☀️ Sun',hi:'☀️ सूर्य'},traits:{en:['🦁 Natural Leader','🎯 Goal-Oriented','💪 Independent','🔥 Ambitious','🌟 Courageous'],hi:['🦁 प्राकृतिक नेता','🎯 लक्ष्य-उन्मुख','💪 स्वतंत्र','🔥 महत्वाकांक्षी','🌟 साहसी']},careers:{en:['🚀 CEO / Entrepreneur','🏛️ Politician','⚔️ Military Officer','🎯 Director / Manager','🏆 Sports Captain'],hi:['🚀 CEO / उद्यमी','🏛️ राजनेता','⚔️ सैन्य अधिकारी','🎯 डायरेक्टर / मैनेजर','🏆 खेल कप्तान']},lucky:{color:{en:'Gold & Red',hi:'सोना और लाल'},day:{en:'Sunday',hi:'रविवार'},gem:{en:'Ruby (Manik)',hi:'माणिक'},nums:'1, 10, 19, 28'},year2026:{en:'2026 is your ultimate power year! As Mulank 1, you carry Sun energy into a Universal Year 1 — double force. Expect major career breakthroughs, new leadership opportunities, and life-changing beginnings. The universe is clearing your path. Step forward boldly — this year belongs to you.',hi:'2026 आपका परम शक्ति वर्ष है! मूलांक 1 के रूप में, आप एक सार्वभौमिक 1 वर्ष में सूर्य ऊर्जा लाते हैं। करियर में बड़ी सफलता, नई नेतृत्व अवसर और जीवन बदलने वाली शुरुआत की उम्मीद करें।'},compat:{best:[2,3,9],good:[5,7],avoid:[6,8]},color:'#FFD700'},
  2:{planet:{en:'🌙 Moon',hi:'🌙 चंद्रमा'},traits:{en:['🕊️ Diplomatic','💫 Highly Intuitive','🤝 Cooperative','💝 Nurturing','🎨 Creative'],hi:['🕊️ राजनयिक','💫 अत्यधिक अंतर्ज्ञानी','🤝 सहयोगी','💝 पोषण करने वाला','🎨 रचनात्मक']},careers:{en:['🩺 Doctor / Healer','🎓 Teacher / Counselor','🕊️ Diplomat','🎨 Artist / Designer','💼 HR / People Manager'],hi:['🩺 डॉक्टर / हीलर','🎓 शिक्षक / काउंसलर','🕊️ राजनयिक','🎨 कलाकार / डिजाइनर','💼 HR / लोग प्रबंधक']},lucky:{color:{en:'White & Silver',hi:'सफेद और चांदी'},day:{en:'Monday',hi:'सोमवार'},gem:{en:'Pearl (Moti)',hi:'मोती'},nums:'2, 11, 20, 29'},year2026:{en:'2026 brings deep emotional growth and meaningful partnerships for Mulank 2. Your intuition reaches peak clarity — trust your inner voice on major decisions. New collaborations emerge that could redefine your path. Health and emotional balance are priorities this year.',hi:'2026 मूलांक 2 के लिए गहरी भावनात्मक वृद्धि और सार्थक साझेदारियां लाता है। आपका अंतर्ज्ञान चरम स्पष्टता तक पहुंचता है। नई साझेदारियां आपके रास्ते को फिर से परिभाषित कर सकती हैं।'},compat:{best:[1,4,8],good:[6,9],avoid:[5,7]},color:'#C0C0C0'},
  3:{planet:{en:'♃ Jupiter',hi:'♃ गुरु'},traits:{en:['🗣️ Expressive','🎭 Creative','😄 Optimistic','📣 Communicative','🌈 Joyful'],hi:['🗣️ अभिव्यक्त','🎭 रचनात्मक','😄 आशावादी','📣 संवादात्मक','🌈 आनंदमय']},careers:{en:['✍️ Writer / Author','🎬 Actor / Director','⚖️ Lawyer / Advocate','📰 Journalist','🎤 Public Speaker'],hi:['✍️ लेखक / साहित्यकार','🎬 अभिनेता / निर्देशक','⚖️ वकील','📰 पत्रकार','🎤 सार्वजनिक वक्ता']},lucky:{color:{en:'Yellow & Gold',hi:'पीला और सोना'},day:{en:'Thursday',hi:'गुरुवार'},gem:{en:'Yellow Sapphire (Pukhraj)',hi:'पुखराज'},nums:'3, 12, 21, 30'},year2026:{en:'Creative explosion incoming for Mulank 3 in 2026! Jupiter blesses your natural gift for communication. Launch that creative project — a book, podcast, YouTube channel, or art series. Your voice is needed in the world this year. Financial gains follow creative courage.',hi:'मूलांक 3 के लिए 2026 में क्रिएटिव विस्फोट! गुरु आपकी संचार प्रतिभा को आशीर्वाद देता है। वह रचनात्मक परियोजना शुरू करें — किताब, पॉडकास्ट, YouTube चैनल।'},compat:{best:[1,3,9],good:[5,6],avoid:[4,8]},color:'#FFD700'},
  4:{planet:{en:'🌑 Rahu',hi:'🌑 राहु'},traits:{en:['🏗️ Builder & Organizer','📋 Disciplined','🔧 Practical','💎 Reliable','📊 Systematic'],hi:['🏗️ निर्माता और आयोजक','📋 अनुशासित','🔧 व्यावहारिक','💎 विश्वसनीय','📊 व्यवस्थित']},careers:{en:['⚙️ Engineer / Architect','📊 Accountant / Analyst','🔬 Scientist','🏗️ Builder / Contractor','💻 System Designer'],hi:['⚙️ इंजीनियर / वास्तुकार','📊 अकाउंटेंट / विश्लेषक','🔬 वैज्ञानिक','🏗️ बिल्डर / ठेकेदार','💻 सिस्टम डिजाइनर']},lucky:{color:{en:'Blue & Green',hi:'नीला और हरा'},day:{en:'Saturday & Sunday',hi:'शनिवार और रविवार'},gem:{en:'Hessonite (Gomed)',hi:'गोमेद'},nums:'4, 13, 22, 31'},year2026:{en:'Stability is your superpower in 2026, Mulank 4. This is the year your patient, methodical work finally yields massive returns. Property investments, career foundations, and long-term plans all solidify. Build slowly, build strong — what you construct this year lasts decades.',hi:'स्थिरता 2026 में आपकी महाशक्ति है, मूलांक 4। यह वह वर्ष है जब आपका धैर्यवान, व्यवस्थित कार्य अंततः बड़े रिटर्न देता है।'},compat:{best:[2,4,8],good:[6,7],avoid:[1,3,9]},color:'#4169E1'},
  5:{planet:{en:'☿ Mercury',hi:'☿ बुध'},traits:{en:['🌍 Freedom-Loving','🧠 Quick-Witted','🎲 Adventurous','🔄 Versatile','⚡ Energetic'],hi:['🌍 स्वतंत्रता प्रेमी','🧠 तीव्र बुद्धि','🎲 साहसी','🔄 बहुमुखी','⚡ ऊर्जावान']},careers:{en:['💼 Business / Trade','✈️ Travel & Tourism','📱 Media / Tech','📈 Sales & Marketing','💡 Innovation & Startups'],hi:['💼 व्यापार / व्यवसाय','✈️ यात्रा और पर्यटन','📱 मीडिया / टेक','📈 बिक्री और मार्केटिंग','💡 इनोवेशन और स्टार्टअप']},lucky:{color:{en:'Green & Grey',hi:'हरा और ग्रे'},day:{en:'Wednesday',hi:'बुधवार'},gem:{en:'Emerald (Panna)',hi:'पन्ना'},nums:'5, 14, 23'},year2026:{en:'Change is your fuel in 2026, Mulank 5! A new city, new role, or bold career pivot is on the horizon. Travel opens major opportunities — say yes more than you say no. Mercury\'s quick energy means fast results when you act decisively. Embrace the unexpected.',hi:'बदलाव 2026 में आपका ईंधन है, मूलांक 5! एक नया शहर, नई भूमिका या साहसी करियर बदलाव क्षितिज पर है। यात्रा बड़े अवसर खोलती है।'},compat:{best:[1,5,7],good:[3,9],avoid:[2,4,8]},color:'#32CD32'},
  6:{planet:{en:'♀ Venus',hi:'♀ शुक्र'},traits:{en:['💝 Loving & Caring','🎨 Artistic','🏡 Responsible','🕊️ Harmonious','🌸 Compassionate'],hi:['💝 प्यार करने वाला','🎨 कलात्मक','🏡 जिम्मेदार','🕊️ सामंजस्यपूर्ण','🌸 दयालु']},careers:{en:['👗 Fashion / Interior Design','🎵 Music / Arts','🏨 Hospitality','💆 Wellness / Therapy','🌺 Social Work'],hi:['👗 फैशन / इंटीरियर डिजाइन','🎵 संगीत / कला','🏨 आतिथ्य','💆 वेलनेस / थेरेपी','🌺 सामाजिक कार्य']},lucky:{color:{en:'Pink & White',hi:'गुलाबी और सफेद'},day:{en:'Friday',hi:'शुक्रवार'},gem:{en:'Diamond / Opal',hi:'हीरा / ओपल'},nums:'6, 15, 24'},year2026:{en:'Love and beauty define your 2026, Mulank 6. Relationships deepen beautifully, creative projects attract wide admiration, and your home life transforms into a sanctuary. Venus showers blessings on family, romance, and artistic pursuits. Share your warmth — it multiplies.',hi:'प्यार और सौंदर्य 2026 को परिभाषित करता है, मूलांक 6। रिश्ते सुंदर रूप से गहरे होते हैं, रचनात्मक परियोजनाएं व्यापक प्रशंसा आकर्षित करती हैं।'},compat:{best:[2,6,9],good:[3,4],avoid:[1,5,7]},color:'#FF69B4'},
  7:{planet:{en:'🌗 Ketu',hi:'🌗 केतु'},traits:{en:['🧘 Spiritual','🔭 Analytical','🎭 Mysterious','📚 Wisdom-Seeker','🌌 Intuitive'],hi:['🧘 आध्यात्मिक','🔭 विश्लेषणात्मक','🎭 रहस्यमय','📚 ज्ञान-साधक','🌌 अंतर्ज्ञानी']},careers:{en:['🔬 Research Scientist','🧘 Philosopher / Spiritual Guide','🩺 Doctor / Surgeon','🔮 Astrologer','📊 Data Analyst / Strategist'],hi:['🔬 शोध वैज्ञानिक','🧘 दार्शनिक / आध्यात्मिक गाइड','🩺 डॉक्टर / सर्जन','🔮 ज्योतिषी','📊 डेटा विश्लेषक']},lucky:{color:{en:'Violet & Grey',hi:'बैंगनी और ग्रे'},day:{en:'Sunday',hi:'रविवार'},gem:{en:"Cat's Eye (Lehsunia)",hi:'लहसुनिया'},nums:'7, 16, 25'},year2026:{en:'A profound spiritual awakening defines 2026 for Mulank 7. Your intuition reaches extraordinary levels — meditation, study, and solitude unlock revelations that reshape your worldview. Trust the quiet knowing within. Research and writing projects yield exceptional results this year.',hi:'2026 मूलांक 7 के लिए एक गहरी आध्यात्मिक जागृति को परिभाषित करता है। आपका अंतर्ज्ञान असाधारण स्तर तक पहुंचता है। ध्यान, अध्ययन और एकांत रहस्योद्घाटन को अनलॉक करते हैं।'},compat:{best:[1,5,7],good:[2,4],avoid:[6,8,9]},color:'#8A2BE2'},
  8:{planet:{en:'♄ Saturn',hi:'♄ शनि'},traits:{en:['💎 Powerfully Ambitious','⚖️ Karmic & Fair','🏛️ Authoritative','🔩 Enduring','📈 Strategic Thinker'],hi:['💎 शक्तिशाली रूप से महत्वाकांक्षी','⚖️ कार्मिक और निष्पक्ष','🏛️ अधिकारी','🔩 सहनशील','📈 रणनीतिक विचारक']},careers:{en:['🏦 Banker / Financier','⚖️ Judge / Lawyer','🏛️ Government Official','🏢 Real Estate','📊 Business Magnate'],hi:['🏦 बैंकर / वित्तीय','⚖️ न्यायाधीश / वकील','🏛️ सरकारी अधिकारी','🏢 रियल एस्टेट','📊 व्यापार मैग्नेट']},lucky:{color:{en:'Black & Dark Blue',hi:'काला और गहरा नीला'},day:{en:'Saturday',hi:'शनिवार'},gem:{en:'Blue Sapphire (Neelam)',hi:'नीलम'},nums:'8, 17, 26'},year2026:{en:'2026 is karmic payoff time for Mulank 8. Every hour of hard work from past years now yields massive dividends. Financial growth, authority positions, and legacy-building projects all accelerate. Saturn rewards patience and discipline — and you\'ve proven both. Claim your throne.',hi:'2026 मूलांक 8 के लिए कार्मिक फल का समय है। पिछले वर्षों की हर मेहनत अब बड़े लाभांश देती है। वित्तीय वृद्धि, अधिकार पद और विरासत-निर्माण परियोजनाएं सभी तेज होती हैं।'},compat:{best:[2,4,8],good:[1,6],avoid:[3,5,7]},color:'#191970'},
  9:{planet:{en:'♂ Mars',hi:'♂ मंगल'},traits:{en:['🦋 Humanitarian','🔥 Courageous','💞 Deeply Compassionate','🌍 Global Thinker','🏹 Idealistic Warrior'],hi:['🦋 मानवतावादी','🔥 साहसी','💞 गहराई से दयालु','🌍 वैश्विक विचारक','🏹 आदर्शवादी योद्धा']},careers:{en:['⚔️ Military / Defense','🏥 Surgeon / Doctor','🏆 Sports Athlete','👮 Police / IPS Officer','🌍 Social Reformer'],hi:['⚔️ सैन्य / रक्षा','🏥 सर्जन / डॉक्टर','🏆 खेल एथलीट','👮 पुलिस / IPS अधिकारी','🌍 सामाजिक सुधारक']},lucky:{color:{en:'Red & Orange',hi:'लाल और नारंगी'},day:{en:'Tuesday',hi:'मंगलवार'},gem:{en:'Red Coral (Moonga)',hi:'मूंगा'},nums:'9, 18, 27'},year2026:{en:'You\'re the humanitarian powerhouse of 2026, Mulank 9. Mars energy drives you toward social impact, leadership roles, and global thinking. A cause worth fighting for appears — your fire ignites meaningful change. Creative and spiritual projects also reach completion beautifully.',hi:'2026 में आप मानवीय शक्ति हैं, मूलांक 9। मंगल ऊर्जा आपको सामाजिक प्रभाव, नेतृत्व भूमिकाओं और वैश्विक सोच की ओर प्रेरित करती है।'},compat:{best:[3,6,9],good:[1,2],avoid:[4,5,8]},color:'#DC143C'}
};

function $mk(id){return document.getElementById(id);}
function mkReduce(n){while(n>9){var s=0,str=String(n);for(var i=0;i<str.length;i++)s+=parseInt(str[i],10);n=s;}return n;}
function mkMulank(day){return mkReduce(parseInt(day,10));}
function mkBhagyank(day,month,year){var str=String(day)+String(month)+String(year);var s=0;for(var i=0;i<str.length;i++)s+=parseInt(str[i],10);return mkReduce(s);}

// Populate selects
function mkBuildSelects(){
  var dayEl=$mk('mk-day'),monEl=$mk('mk-month'),yrEl=$mk('mk-year');
  var t=MKT[mkLang];
  dayEl.innerHTML='<option value="">'+t.day_lbl+'</option>';
  for(var d=1;d<=31;d++){var o=document.createElement('option');o.value=d;o.textContent=d<10?'0'+d:d;dayEl.appendChild(o);}
  monEl.innerHTML='<option value="">'+t.month_lbl+'</option>';
  t.months.forEach(function(m,i){var o=document.createElement('option');o.value=i+1;o.textContent=m;monEl.appendChild(o);});
  var curYear=new Date().getFullYear();
  yrEl.innerHTML='<option value="">'+t.year_lbl+'</option>';
  for(var y=curYear;y>=1940;y--){var o2=document.createElement('option');o2.value=y;o2.textContent=y;yrEl.appendChild(o2);}
}
function mkApplyLang(){
  var t=MKT[mkLang];
  $mk('mk-title').textContent=t.title;$mk('mk-subtitle').textContent=t.subtitle;
  $mk('mk-stat1').textContent=t.stat1;$mk('mk-stat2').textContent=t.stat2;$mk('mk-stat3').textContent=t.stat3;
  $mk('mk-calc-btn').textContent=t.calc_btn;$mk('mk-adv-lbl').textContent=t.adv_lbl;
  $mk('mk-lang-btn').textContent=t.lang_switch;$mk('mk-try-btn').textContent=t.try_btn;
  $mk('mk-related-title').textContent=t.related_title;
  $mk('mk-mulank-label').textContent=t.mulank_lbl;$mk('mk-bhagyank-label').textContent=t.bhagyank_lbl;
  $mk('mk-traits-title').textContent=t.traits_title;$mk('mk-lucky-title').textContent=t.lucky_title;
  $mk('mk-career-title').textContent=t.career_title;$mk('mk-year-title').textContent=t.year_title;
  $mk('mk-compat-title').textContent=t.compat_title;
  mkBuildSelects();
}
function mkAnimNum(el,to){
  var steps=0,maxSteps=12,iv=setInterval(function(){
    el.textContent=Math.floor(Math.random()*9)+1;
    steps++;if(steps>=maxSteps){clearInterval(iv);el.textContent=to;el.style.animation='none';el.offsetHeight;el.style.animation='mk-num-reveal .6s cubic-bezier(.22,.9,.3,1) both';}
  },80);
}
function mkShowResult(day,month,year){
  var mulank=mkMulank(day),bhagyank=mkBhagyank(day,month,year);
  var md=MK_DATA[mulank],bd=MK_DATA[bhagyank],t=MKT[mkLang];
  // Nums
  mkAnimNum($mk('mk-mulank-num'),mulank);
  setTimeout(function(){mkAnimNum($mk('mk-bhagyank-num'),bhagyank);},300);
  $mk('mk-mulank-planet').textContent=md.planet[mkLang];$mk('mk-bhagyank-planet').textContent=bd.planet[mkLang];
  $mk('mk-mulank-color').style.background=md.color;$mk('mk-bhagyank-color').style.background=bd.color;
  // Traits
  var tg=$mk('mk-traits-grid');tg.innerHTML='';
  md.traits[mkLang].forEach(function(tr){var d=document.createElement('div');d.className='mk-trait';d.textContent=tr;tg.appendChild(d);});
  // Lucky
  var lg=$mk('mk-lucky-grid');lg.innerHTML='';
  var luckies=[{icon:'🎨',lbl:t.lucky_color,val:md.lucky.color[mkLang]},{icon:'📅',lbl:t.lucky_day,val:md.lucky.day[mkLang]},{icon:'💎',lbl:t.lucky_gem,val:md.lucky.gem[mkLang]},{icon:'🔢',lbl:t.lucky_num,val:md.lucky.nums}];
  luckies.forEach(function(l){var c=document.createElement('div');c.className='mk-lucky-card';c.innerHTML='<div class="mk-lucky-icon">'+l.icon+'</div><h4>'+l.lbl+'</h4><p>'+l.val+'</p>';lg.appendChild(c);});
  // Careers
  var cl=$mk('mk-career-list');cl.innerHTML='';
  md.careers[mkLang].forEach(function(c){var li=document.createElement('li');li.textContent=c;cl.appendChild(li);});
  // Year
  $mk('mk-year-text').textContent=md.year2026[mkLang];
  // Compat
  function mkCompatPills(container,nums,cls){container.innerHTML='';nums.forEach(function(n){var p=document.createElement('span');p.className='mk-compat-pill '+cls;p.textContent='No. '+n+' — '+MK_DATA[n].planet[mkLang];container.appendChild(p);});}
  mkCompatPills($mk('mk-compat-best'),md.compat.best,'mk-best');
  mkCompatPills($mk('mk-compat-good'),md.compat.good,'mk-good');
  mkCompatPills($mk('mk-compat-avoid'),md.compat.avoid,'mk-avoid');
  $mk('mk-compat-best-lbl').textContent=t.compat_best;$mk('mk-compat-good-lbl').textContent=t.compat_good;$mk('mk-compat-care-lbl').textContent=t.compat_care;
  // Show compat if adv on
  if($mk('mk-adv-chk').checked){var cs=$mk('mk-compat-section');cs.style.display='block';cs.classList.add('mk-adv-on');}
  // Share
  var url=window.location.href,msg='🔢 Mulank Calculator Result!\n\nMulank: '+mulank+' ('+md.planet.en+')\nBhagyank: '+bhagyank+' ('+bd.planet.en+')\n\nTest yours: '+url;
  $mk('mk-sb-wa').href='https://wa.me/?text='+encodeURIComponent(msg);
  $mk('mk-sb-tw').href='https://twitter.com/intent/tweet?text='+encodeURIComponent('My Mulank is '+mulank+' & Bhagyank is '+bhagyank+'! Discover yours:')+'&url='+encodeURIComponent(url);
  $mk('mk-sb-copy').onclick=function(){var btn=this,orig=btn.innerHTML;try{navigator.clipboard?navigator.clipboard.writeText(url).then(function(){btn.innerHTML='✅ Copied!';setTimeout(function(){btn.innerHTML=orig;},1800);}):void 0;}catch(e){}};
  $mk('mk-sb-save').onclick=function(){var btn=this,orig=btn.innerHTML;btn.innerHTML='📸...';setTimeout(function(){navigator.share?navigator.share({title:'Mulank Calculator',text:msg,url:url}).catch(function(){}).finally(function(){btn.innerHTML=orig;}):alert(msg);btn.innerHTML=orig;},400);};
}
function mkRunLoad(cb){
  var el=$mk('mk-load-step'),bar=$mk('mk-progress-bar'),i=0;
  var steps=[MKT[mkLang].load1,MKT[mkLang].load2,MKT[mkLang].load3,MKT[mkLang].load4];
  el.textContent=steps[0];bar.style.width='8%';
  var iv=setInterval(function(){i++;if(i<steps.length){el.style.opacity='0';setTimeout(function(){el.textContent=steps[i];el.style.opacity='1';},200);bar.style.width=((i+1)*25)+'%';}else{clearInterval(iv);bar.style.width='100%';setTimeout(cb,350);}},700);
}

$mk('mk-calc-btn').addEventListener('click',function(){
  var day=$mk('mk-day').value,month=$mk('mk-month').value,year=$mk('mk-year').value,err=$mk('mk-error');
  if(!day||!month||!year){err.textContent=MKT[mkLang].error;err.classList.add('mk-show');return;}
  err.classList.remove('mk-show');
  $mk('mk-input-phase').style.display='none';
  var loading=$mk('mk-loading');loading.style.display='block';loading.classList.add('mk-show');
  $mk('mk-progress-bar').style.width='0%';
  mkRunLoad(function(){
    loading.classList.remove('mk-show');loading.style.display='none';
    $mk('mk-result').classList.add('mk-show');
    mkShowResult(day,month,year);
    setTimeout(function(){$mk('mk-result').scrollIntoView({behavior:'smooth',block:'start'});},100);
  });
});
$mk('mk-try-btn').addEventListener('click',function(){
  $mk('mk-result').classList.remove('mk-show');$mk('mk-loading').classList.remove('mk-show');$mk('mk-loading').style.display='none';
  $mk('mk-input-phase').style.display='block';$mk('mk-compat-section').style.display='none';
  $mk('mk-input-phase').scrollIntoView({behavior:'smooth',block:'start'});
});
$mk('mk-lang-btn').addEventListener('click',function(){mkLang=mkLang==='en'?'hi':'en';mkApplyLang();});
$mk('mk-adv-chk').addEventListener('change',function(){
  var cs=$mk('mk-compat-section');
  if(this.checked&&$mk('mk-result').classList.contains('mk-show')){cs.style.display='block';cs.classList.add('mk-adv-on');}else{cs.style.display='none';}
});
var mkCnt=187432;setInterval(function(){mkCnt+=1+Math.floor(Math.random()*2);$mk('mk-counter').textContent=mkCnt.toLocaleString('en-IN');},10000);
mkBuildSelects();
})();
</script>
</div>
<?php
    return ob_get_clean();
}
add_shortcode( 'mulank_calculator', 'mk_render' );
}

// ═══════════════════════════════════════════════════════════════
// 4. CRUSH CALCULATOR  [crush_calculator]
// ═══════════════════════════════════════════════════════════════
if ( ! function_exists( 'cc_render' ) ) {
function cc_render( $atts = [] ) {
    ob_start(); ?>
<div class="cc-wrap" id="cc-wrap">
<style>
.cc-wrap,.cc-wrap *,.cc-wrap *::before,.cc-wrap *::after{box-sizing:border-box}
.cc-wrap{font-family:'DM Sans','Inter',-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;color:#1f1933;max-width:880px;margin:0 auto;padding:12px;line-height:1.55}
.cc-wrap h1,.cc-wrap h2,.cc-wrap h3,.cc-wrap h4{font-family:'Poppins',system-ui,sans-serif;font-weight:800;letter-spacing:-.01em;margin:0}
.cc-topbar{display:flex;align-items:center;justify-content:flex-end;gap:10px;margin-bottom:10px;flex-wrap:wrap}
.cc-lang-btn{padding:7px 16px;border-radius:999px;border:2px solid #E63946;background:#fff;color:#E63946;font-weight:700;font-size:13px;cursor:pointer;font-family:'Poppins',sans-serif;transition:all .2s}
.cc-lang-btn:hover{background:#E63946;color:#fff}
.cc-adv-wrap{display:flex;align-items:center;gap:7px;font-size:13px;font-weight:600;color:#5b5070;cursor:pointer}
.cc-adv-toggle{position:relative;width:40px;height:22px}
.cc-adv-toggle input{opacity:0;width:0;height:0}
.cc-adv-slider{position:absolute;inset:0;border-radius:999px;background:#ddd;transition:.3s;cursor:pointer}
.cc-adv-slider::before{content:"";position:absolute;height:16px;width:16px;left:3px;bottom:3px;background:#fff;border-radius:50%;transition:.3s}
.cc-adv-toggle input:checked+.cc-adv-slider{background:#E63946}
.cc-adv-toggle input:checked+.cc-adv-slider::before{transform:translateX(18px)}
.cc-header{background:linear-gradient(135deg,#1a0533 0%,#690d3a 50%,#3d0b55 100%);border-radius:22px;padding:28px 20px;color:#fff;text-align:center;box-shadow:0 20px 60px rgba(105,13,58,.3);position:relative;overflow:hidden}
.cc-header::before{content:"";position:absolute;inset:-50%;background:radial-gradient(circle at 30% 20%,rgba(230,57,70,.2),transparent 60%),radial-gradient(circle at 70% 80%,rgba(255,107,157,.2),transparent 60%);pointer-events:none}
.cc-header-icon{font-size:50px;line-height:1;display:inline-block;animation:cc-bob 2.4s ease-in-out infinite}
.cc-header h1{font-size:36px;margin:8px 0 6px;color:#fff}
.cc-header-sub{opacity:.86;font-size:15px;margin:0}
.cc-stats{display:flex;align-items:center;justify-content:center;margin-top:18px;flex-wrap:wrap}
.cc-stat{padding:4px 14px;min-width:96px;text-align:center}
.cc-stat-num{font-weight:800;font-family:'Poppins',sans-serif;font-size:18px;color:#fff}
.cc-stat-lbl{font-size:11px;opacity:.78;text-transform:uppercase;letter-spacing:.06em}
.cc-stat+.cc-stat{border-left:1px solid rgba(255,255,255,.22)}
.cc-card{background:#fff;border-radius:22px;padding:24px 20px;margin-top:18px;box-shadow:0 20px 60px rgba(0,0,0,.08);border:1px solid #f1ecf6}
.cc-inputs{display:grid;grid-template-columns:1fr auto 1fr;gap:14px;align-items:center}
.cc-field{display:flex;flex-direction:column;align-items:center;gap:10px}
.cc-avatar{width:64px;height:64px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-family:'Poppins',sans-serif;font-weight:800;font-size:26px;color:#fff;box-shadow:0 8px 24px rgba(0,0,0,.18);transition:transform .25s ease}
.cc-avatar.cc-a{background:linear-gradient(135deg,#E63946,#ff6b9d)}
.cc-avatar.cc-b{background:linear-gradient(135deg,#7B2D8B,#ff6b9d)}
.cc-avatar:hover{transform:scale(1.04)}
.cc-input{width:100%;min-height:52px;padding:12px 14px;font-size:16px;border:2px solid #ece6f3;border-radius:14px;outline:none;background:#faf8fd;transition:border-color .2s,box-shadow .2s;font-family:inherit}
.cc-input:focus{border-color:#E63946;background:#fff;box-shadow:0 0 0 4px rgba(230,57,70,.12)}
.cc-vs{width:56px;height:56px;border-radius:50%;background:linear-gradient(135deg,#E63946,#ff6b9d);color:#fff;display:flex;align-items:center;justify-content:center;font-size:26px;box-shadow:0 10px 24px rgba(230,57,70,.4);animation:cc-pulse 1.6s ease-in-out infinite}
.cc-adv-zodiac{display:none;grid-template-columns:1fr 1fr;gap:12px;margin-top:14px}
.cc-adv-zodiac.cc-show{display:grid}
.cc-zodiac-select{width:100%;min-height:48px;padding:10px 14px;font-size:15px;border:2px solid #ece6f3;border-radius:12px;outline:none;background:#faf8fd;font-family:inherit;cursor:pointer}
.cc-zodiac-select:focus{border-color:#E63946;box-shadow:0 0 0 4px rgba(230,57,70,.12)}
.cc-btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;min-height:56px;padding:18px 22px;font-size:17px;font-weight:700;font-family:'Poppins',sans-serif;border:none;border-radius:14px;cursor:pointer;width:100%;transition:transform .15s,box-shadow .2s}
.cc-btn-primary{background:linear-gradient(135deg,#E63946,#c81e2c);color:#fff;box-shadow:0 14px 32px rgba(230,57,70,.35);margin-top:18px}
.cc-btn-primary:hover{transform:translateY(-2px);box-shadow:0 18px 40px rgba(230,57,70,.45)}
.cc-trust{display:flex;gap:10px;justify-content:center;flex-wrap:wrap;margin-top:14px}
.cc-trust span{font-size:12.5px;color:#5b5070;background:#f6f0fb;padding:6px 12px;border-radius:999px;display:inline-flex;align-items:center}
.cc-error{display:none;background:#fff1f2;color:#b3162a;border:1px solid #ffd6db;padding:10px 14px;border-radius:12px;margin-top:12px;font-size:14px;text-align:center}
.cc-error.cc-show{display:block;animation:cc-shake .4s}
.cc-loading{display:none;text-align:center;padding:14px 8px}
.cc-loading.cc-show{display:block}
.cc-load-rings{position:relative;width:160px;height:160px;margin:6px auto 18px}
.cc-load-ring{position:absolute;inset:0;border-radius:50%;border:3px solid rgba(230,57,70,.35);animation:cc-ring-anim 2s ease-out infinite}
.cc-load-ring:nth-child(2){animation-delay:.5s;border-color:rgba(255,107,157,.4)}
.cc-load-ring:nth-child(3){animation-delay:1s;border-color:rgba(212,175,55,.35)}
.cc-load-icon{position:absolute;inset:0;display:flex;align-items:center;justify-content:center;font-size:60px;animation:cc-pulse 1.2s ease-in-out infinite}
.cc-load-step{font-size:15px;color:#6b5e85;min-height:24px;transition:opacity .25s}
.cc-progress{height:8px;background:#f1ebf7;border-radius:999px;overflow:hidden;margin:14px auto 4px;max-width:360px}
.cc-progress-bar{height:100%;width:0%;background:linear-gradient(90deg,#E63946,#ff6b9d);border-radius:999px;transition:width .3s ease}
.cc-result{display:none}
.cc-result.cc-show{display:block;animation:cc-fadeUp .55s ease both}
.cc-result-header{background:linear-gradient(135deg,#1a0533,#690d3a,#3d0b55);color:#fff;border-radius:22px;padding:28px 20px;text-align:center;box-shadow:0 20px 60px rgba(0,0,0,.25);position:relative;overflow:hidden}
.cc-result-header::after{content:"";position:absolute;inset:0;background:radial-gradient(circle at 20% 10%,rgba(230,57,70,.25),transparent 50%),radial-gradient(circle at 80% 90%,rgba(255,107,157,.2),transparent 55%);pointer-events:none}
.cc-rc-names{display:flex;align-items:center;justify-content:center;gap:14px;flex-wrap:wrap;margin-bottom:14px;position:relative;z-index:1}
.cc-rc-name{display:flex;align-items:center;gap:10px;font-weight:700;font-family:'Poppins',sans-serif;font-size:17px}
.cc-rc-name .cc-avatar{width:44px;height:44px;font-size:18px}
.cc-rc-mid{font-size:22px}
.cc-dual-rings{display:flex;justify-content:center;gap:20px;flex-wrap:wrap;position:relative;z-index:1}
.cc-ring-item{text-align:center}
.cc-ring-wrap{position:relative;width:160px;height:160px;margin:0 auto 8px}
.cc-ring-wrap svg{transform:rotate(-90deg);width:100%;height:100%}
.cc-ring-bg{fill:none;stroke:rgba(255,255,255,.12);stroke-width:10}
.cc-ring-fg-crush{fill:none;stroke:url(#cc-grad-crush);stroke-width:10;stroke-linecap:round;transition:stroke-dashoffset 1.8s cubic-bezier(.22,.9,.3,1)}
.cc-ring-fg-soul{fill:none;stroke:url(#cc-grad-soul);stroke-width:10;stroke-linecap:round;transition:stroke-dashoffset 2s cubic-bezier(.22,.9,.3,1)}
.cc-ring-pct{position:absolute;inset:0;display:flex;align-items:center;justify-content:center;flex-direction:column}
.cc-ring-num{font-size:44px;font-weight:800;font-family:'Poppins',sans-serif;line-height:1}
.cc-ring-sym{font-size:18px;font-weight:700;opacity:.85}
.cc-ring-label{font-size:13px;font-weight:700;font-family:'Poppins',sans-serif;opacity:.85;letter-spacing:.02em}
.cc-watermark{margin-top:12px;font-size:12px;opacity:.7;position:relative;z-index:1}
.cc-bars{margin-top:18px}
.cc-bar-row{margin:14px 0}
.cc-bar-top{display:flex;justify-content:space-between;font-size:14px;font-weight:600;color:#2d2447;margin-bottom:6px}
.cc-bar-top span:last-child{color:#E63946;font-family:'Poppins',sans-serif;font-weight:800}
.cc-bar{height:10px;background:#f1ebf7;border-radius:999px;overflow:hidden}
.cc-bar-fill{height:100%;width:0%;border-radius:999px;background:linear-gradient(90deg,#E63946,#ff6b9d);transition:width 1.5s cubic-bezier(.22,.9,.3,1)}
.cc-future{background:linear-gradient(135deg,#1a0533,#3d0b55);color:#fff;border-radius:18px;padding:22px;margin-top:18px;position:relative;overflow:hidden}
.cc-future::after{content:"";position:absolute;inset:0;background:radial-gradient(circle at 80% 50%,rgba(212,175,55,.15),transparent 60%);pointer-events:none}
.cc-future h3{font-size:18px;margin-bottom:10px;position:relative;z-index:1}
.cc-future-emoji{font-size:36px;margin-bottom:8px;display:block;position:relative;z-index:1}
.cc-future p{font-size:15px;opacity:.92;margin:0;position:relative;z-index:1}
.cc-hints{background:linear-gradient(135deg,#fff8dc,#fff1c1);border-radius:18px;padding:20px;margin-top:18px;border:1px solid #f7e190}
.cc-hints h3{font-size:19px;color:#7a5a05;margin-bottom:12px}
.cc-hints-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:12px}
.cc-hint{background:#fff;border-radius:14px;padding:14px;border-left:4px solid #E63946;box-shadow:0 8px 20px rgba(0,0,0,.05);opacity:0;transform:translateY(8px);animation:cc-fadeUp .5s ease forwards}
.cc-hint-icon{font-size:22px;margin-bottom:4px}
.cc-hint h4{font-size:14.5px;color:#690d3a;margin-bottom:4px}
.cc-hint p{font-size:13px;color:#5b5070;margin:0}
.cc-signs{background:#fff;border-radius:18px;padding:20px;margin-top:18px;box-shadow:0 10px 28px rgba(0,0,0,.06);border:1px solid #f1ecf6}
.cc-signs h3{font-size:18px;color:#3d0b55;margin-bottom:12px}
.cc-sign-list{list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:10px}
.cc-sign-item{display:flex;align-items:flex-start;gap:12px;padding:12px 14px;background:#faf8fd;border-radius:12px;font-size:14px;color:#2d2447}
.cc-sign-item .cc-si-icon{font-size:22px;flex-shrink:0;margin-top:1px}
.cc-special-row{display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-top:18px}
.cc-special-card{background:#fff;border-radius:18px;padding:18px;text-align:center;box-shadow:0 10px 28px rgba(0,0,0,.06)}
.cc-special-card:nth-child(1){border-top:4px solid #E63946}
.cc-special-card:nth-child(2){border-top:4px solid #d4af37}
.cc-special-icon{font-size:32px;margin-bottom:8px}
.cc-special-card h4{font-size:12px;text-transform:uppercase;letter-spacing:.06em;color:#6b5e85;margin-bottom:6px}
.cc-special-card p{font-size:16px;font-weight:700;color:#1f1933;margin:0 0 4px}
.cc-special-card small{font-size:12px;color:#6b5e85}
.cc-lucky-color-dot{width:28px;height:28px;border-radius:50%;display:inline-block;margin:4px auto 0;box-shadow:0 4px 12px rgba(0,0,0,.2)}
.cc-zodiac-compat{background:linear-gradient(135deg,#e7f7ec,#d2efdc);border-radius:18px;padding:20px;margin-top:18px;border:1px solid #b8e2c5;display:none}
.cc-zodiac-compat.cc-show{display:block;animation:cc-fadeUp .4s ease both}
.cc-zodiac-compat h3{font-size:18px;color:#155d3a;margin-bottom:10px}
.cc-zodiac-compat p{color:#1f3f2c;font-size:15px;margin:0}
.cc-share{display:grid;grid-template-columns:repeat(4,1fr);gap:10px;margin-top:18px}
.cc-share-btn{display:inline-flex;align-items:center;justify-content:center;gap:6px;min-height:48px;padding:12px 8px;font-size:14px;font-weight:700;font-family:'Poppins',sans-serif;border-radius:12px;border:none;cursor:pointer;color:#fff;text-decoration:none;transition:transform .15s,box-shadow .15s}
.cc-share-btn:hover{transform:translateY(-2px);box-shadow:0 12px 26px rgba(0,0,0,.15)}
.cc-sb-wa{background:#25d366}.cc-sb-tw{background:#111}
.cc-sb-save{background:linear-gradient(135deg,#E63946,#7B2D8B)}.cc-sb-copy{background:#5b5b6e}
.cc-try{margin-top:14px;background:#fff;color:#690d3a;border:2px solid #ece6f3}
.cc-try:hover{border-color:#E63946;color:#E63946}
.cc-levels{display:grid;grid-template-columns:repeat(5,1fr);gap:10px;margin-top:22px}
.cc-lvl{background:#fff;border-radius:16px;padding:14px 10px;text-align:center;box-shadow:0 10px 24px rgba(0,0,0,.06)}
.cc-lvl:nth-child(1){border-top:4px solid #d4af37}
.cc-lvl:nth-child(2){border-top:4px solid #E63946}
.cc-lvl:nth-child(3){border-top:4px solid #ff6b9d}
.cc-lvl:nth-child(4){border-top:4px solid #7B2D8B}
.cc-lvl:nth-child(5){border-top:4px solid #14b8a6}
.cc-lvl-icon{font-size:26px}.cc-lvl h4{font-size:13px;color:#1f1933;margin:4px 0}.cc-lvl-range{font-size:12px;color:#E63946;font-weight:700}.cc-lvl-desc{font-size:11px;color:#5b5070;margin:4px 0 0}
.cc-related{margin-top:22px}.cc-related h2{font-size:22px;color:#690d3a;margin-bottom:12px}
.cc-related-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:12px}
.cc-rt{display:block;text-decoration:none;background:#fff;border-radius:16px;padding:16px 12px;text-align:center;box-shadow:0 10px 24px rgba(0,0,0,.06);color:inherit;transition:transform .15s,box-shadow .2s}
.cc-rt:hover{transform:translateY(-3px);box-shadow:0 16px 32px rgba(0,0,0,.1)}
.cc-rt:nth-child(1){border-top:4px solid #E63946}
.cc-rt:nth-child(2){border-top:4px solid #7B2D8B}
.cc-rt:nth-child(3){border-top:4px solid #d4af37}
.cc-rt:nth-child(4){border-top:4px solid #14b8a6}
.cc-rt-icon{font-size:28px}.cc-rt h4{font-size:14px;color:#1f1933;margin:6px 0 4px}.cc-rt p{font-size:12px;color:#5b5070;margin:0}
.cc-confetti{position:fixed;inset:0;pointer-events:none;z-index:9999;overflow:hidden}
.cc-confetti i{position:absolute;top:-20px;width:10px;height:14px;opacity:.95;animation:cc-fall linear forwards;border-radius:2px}
@keyframes cc-pulse{0%,100%{transform:scale(1)}50%{transform:scale(1.08)}}
@keyframes cc-bob{0%,100%{transform:translateY(0)}50%{transform:translateY(-6px)}}
@keyframes cc-ring-anim{0%{transform:scale(.6);opacity:.9}100%{transform:scale(1.4);opacity:0}}
@keyframes cc-fadeUp{from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:translateY(0)}}
@keyframes cc-shake{0%,100%{transform:translateX(0)}25%{transform:translateX(-4px)}75%{transform:translateX(4px)}}
@keyframes cc-fall{0%{transform:translateY(-20px) rotate(0);opacity:1}100%{transform:translateY(110vh) rotate(720deg);opacity:.3}}
@media(max-width:640px){.cc-inputs{grid-template-columns:1fr;gap:12px}.cc-vs{margin:-4px auto}.cc-dual-rings{gap:12px}.cc-ring-wrap{width:140px;height:140px}.cc-ring-num{font-size:36px}.cc-share{grid-template-columns:repeat(2,1fr)}.cc-levels{grid-template-columns:repeat(2,1fr)}.cc-related-grid{grid-template-columns:repeat(2,1fr)}.cc-hints-grid{grid-template-columns:1fr}.cc-special-row{grid-template-columns:1fr}.cc-adv-zodiac{grid-template-columns:1fr}}
</style>

<div class="cc-topbar">
  <button class="cc-lang-btn" id="cc-lang-btn">हिंदी</button>
  <label class="cc-adv-wrap" for="cc-adv-chk">
    <span id="cc-adv-lbl">Advanced Mode</span>
    <span class="cc-adv-toggle"><input type="checkbox" id="cc-adv-chk"><span class="cc-adv-slider"></span></span>
  </label>
</div>

<header class="cc-header">
  <div class="cc-header-icon">💘</div>
  <h1 id="cc-title">Crush Calculator</h1>
  <p class="cc-header-sub" id="cc-subtitle">Find Your Crush Compatibility & Soulmate Potential by Name</p>
  <div class="cc-stats">
    <div class="cc-stat"><div class="cc-stat-num" id="cc-counter">3,12,541</div><div class="cc-stat-lbl" id="cc-s1">Tests Today</div></div>
    <div class="cc-stat"><div class="cc-stat-num">4.9★</div><div class="cc-stat-lbl" id="cc-s2">Rating</div></div>
    <div class="cc-stat"><div class="cc-stat-num">100%</div><div class="cc-stat-lbl" id="cc-s3">Free</div></div>
  </div>
</header>

<section class="cc-card">
  <div id="cc-input-phase">
    <div class="cc-inputs">
      <div class="cc-field">
        <div class="cc-avatar cc-a" id="cc-av-a">?</div>
        <input type="text" class="cc-input" id="cc-name-a" placeholder="Your Name" maxlength="30" autocomplete="off"/>
      </div>
      <div class="cc-vs" aria-hidden="true">💘</div>
      <div class="cc-field">
        <div class="cc-avatar cc-b" id="cc-av-b">?</div>
        <input type="text" class="cc-input" id="cc-name-b" placeholder="Crush's Name" maxlength="30" autocomplete="off"/>
      </div>
    </div>
    <div class="cc-adv-zodiac" id="cc-zodiac-inputs">
      <select class="cc-zodiac-select" id="cc-zodiac-a" aria-label="Your Zodiac Sign">
        <option value="">Your Zodiac Sign (Optional)</option>
        <option value="aries">♈ Aries</option><option value="taurus">♉ Taurus</option><option value="gemini">♊ Gemini</option>
        <option value="cancer">♋ Cancer</option><option value="leo">♌ Leo</option><option value="virgo">♍ Virgo</option>
        <option value="libra">♎ Libra</option><option value="scorpio">♏ Scorpio</option><option value="sagittarius">♐ Sagittarius</option>
        <option value="capricorn">♑ Capricorn</option><option value="aquarius">♒ Aquarius</option><option value="pisces">♓ Pisces</option>
      </select>
      <select class="cc-zodiac-select" id="cc-zodiac-b" aria-label="Crush's Zodiac Sign">
        <option value="">Crush's Zodiac Sign (Optional)</option>
        <option value="aries">♈ Aries</option><option value="taurus">♉ Taurus</option><option value="gemini">♊ Gemini</option>
        <option value="cancer">♋ Cancer</option><option value="leo">♌ Leo</option><option value="virgo">♍ Virgo</option>
        <option value="libra">♎ Libra</option><option value="scorpio">♏ Scorpio</option><option value="sagittarius">♐ Sagittarius</option>
        <option value="capricorn">♑ Capricorn</option><option value="aquarius">♒ Aquarius</option><option value="pisces">♓ Pisces</option>
      </select>
    </div>
    <div class="cc-error" id="cc-error">Please enter both names to continue.</div>
    <button type="button" class="cc-btn cc-btn-primary" id="cc-calc-btn">Calculate Crush Score 💝</button>
    <div class="cc-trust"><span>🔒 Private</span><span>⚡ Instant</span><span>🆓 Free</span></div>
  </div>

  <div class="cc-loading" id="cc-loading">
    <div class="cc-load-rings"><div class="cc-load-ring"></div><div class="cc-load-ring"></div><div class="cc-load-ring"></div><div class="cc-load-icon">💘</div></div>
    <div class="cc-load-step" id="cc-load-step">💫 Reading the signs of attraction...</div>
    <div class="cc-progress"><div class="cc-progress-bar" id="cc-progress-bar"></div></div>
  </div>

  <div class="cc-result" id="cc-result">
    <div class="cc-result-header">
      <div class="cc-rc-names">
        <div class="cc-rc-name"><div class="cc-avatar cc-a" id="cc-rc-av-a">?</div><span id="cc-rc-n-a">Name 1</span></div>
        <div class="cc-rc-mid">💘</div>
        <div class="cc-rc-name"><div class="cc-avatar cc-b" id="cc-rc-av-b">?</div><span id="cc-rc-n-b">Name 2</span></div>
      </div>
      <div class="cc-dual-rings">
        <div class="cc-ring-item">
          <div class="cc-ring-wrap">
            <svg viewBox="0 0 200 200" aria-hidden="true">
              <defs><linearGradient id="cc-grad-crush" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#ff6b9d"/><stop offset="100%" stop-color="#E63946"/></linearGradient></defs>
              <circle class="cc-ring-bg" cx="100" cy="100" r="86"/>
              <circle class="cc-ring-fg-crush" id="cc-ring-crush" cx="100" cy="100" r="86" stroke-dasharray="540.35" stroke-dashoffset="540.35"/>
            </svg>
            <div class="cc-ring-pct"><div><span class="cc-ring-num" id="cc-crush-pct">0</span><span class="cc-ring-sym">%</span></div></div>
          </div>
          <div class="cc-ring-label" id="cc-crush-lbl">💘 Crush Score</div>
        </div>
        <div class="cc-ring-item">
          <div class="cc-ring-wrap">
            <svg viewBox="0 0 200 200" aria-hidden="true">
              <defs><linearGradient id="cc-grad-soul" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#d4af37"/><stop offset="100%" stop-color="#7B2D8B"/></linearGradient></defs>
              <circle class="cc-ring-bg" cx="100" cy="100" r="86"/>
              <circle class="cc-ring-fg-soul" id="cc-ring-soul" cx="100" cy="100" r="86" stroke-dasharray="540.35" stroke-dashoffset="540.35"/>
            </svg>
            <div class="cc-ring-pct"><div><span class="cc-ring-num" id="cc-soul-pct">0</span><span class="cc-ring-sym">%</span></div></div>
          </div>
          <div class="cc-ring-label" id="cc-soul-lbl">👑 Soulmate Potential</div>
        </div>
      </div>
      <div class="cc-watermark">lovecalculator.in 💘</div>
    </div>

    <div class="cc-bars">
      <div class="cc-bar-row"><div class="cc-bar-top"><span id="cc-bl1">⚡ Physical Chemistry</span><span id="cc-b1-v">0%</span></div><div class="cc-bar"><div class="cc-bar-fill" id="cc-b1"></div></div></div>
      <div class="cc-bar-row"><div class="cc-bar-top"><span id="cc-bl2">🧠 Mental Connection</span><span id="cc-b2-v">0%</span></div><div class="cc-bar"><div class="cc-bar-fill" id="cc-b2"></div></div></div>
      <div class="cc-bar-row"><div class="cc-bar-top"><span id="cc-bl3">💞 Emotional Depth</span><span id="cc-b3-v">0%</span></div><div class="cc-bar"><div class="cc-bar-fill" id="cc-b3"></div></div></div>
      <div class="cc-bar-row"><div class="cc-bar-top"><span id="cc-bl4">🌌 Spiritual Sync</span><span id="cc-b4-v">0%</span></div><div class="cc-bar"><div class="cc-bar-fill" id="cc-b4"></div></div></div>
    </div>

    <div class="cc-future">
      <h3 id="cc-future-title">🔮 Future Prediction</h3>
      <span class="cc-future-emoji" id="cc-future-emoji">💕</span>
      <p id="cc-future-text"></p>
    </div>

    <div class="cc-signs">
      <h3 id="cc-signs-title">💡 Signs Your Crush Might Like You</h3>
      <ul class="cc-sign-list" id="cc-sign-list"></ul>
    </div>

    <div class="cc-special-row">
      <div class="cc-special-card">
        <div class="cc-special-icon">🎵</div>
        <h4 id="cc-song-lbl">Your Pair Song</h4>
        <p id="cc-song-name"></p>
        <small id="cc-song-artist"></small>
      </div>
      <div class="cc-special-card">
        <div class="cc-special-icon">🍀</div>
        <h4 id="cc-lucky-lbl">Lucky Day to Confess</h4>
        <p id="cc-lucky-day"></p>
        <div class="cc-lucky-color-dot" id="cc-lucky-color-dot"></div>
        <small id="cc-lucky-color-name"></small>
      </div>
    </div>

    <div class="cc-zodiac-compat" id="cc-zodiac-compat">
      <h3 id="cc-zodiac-title">⭐ Zodiac Compatibility</h3>
      <p id="cc-zodiac-text"></p>
    </div>

    <div class="cc-hints">
      <h3 id="cc-hints-title">⭐ Golden Tips to Impress Your Crush</h3>
      <div class="cc-hints-grid" id="cc-hints-grid"></div>
    </div>

    <div class="cc-share">
      <a href="#" class="cc-share-btn cc-sb-wa" id="cc-sb-wa" target="_blank" rel="noopener">📱 WhatsApp</a>
      <a href="#" class="cc-share-btn cc-sb-tw" id="cc-sb-tw" target="_blank" rel="noopener">𝕏 Twitter</a>
      <button type="button" class="cc-share-btn cc-sb-save" id="cc-sb-save">📸 Save</button>
      <button type="button" class="cc-share-btn cc-sb-copy" id="cc-sb-copy">🔗 Copy</button>
    </div>
    <button type="button" class="cc-btn cc-try" id="cc-try-btn">🔄 Try Again</button>
  </div>
</section>

<section class="cc-levels">
  <div class="cc-lvl"><div class="cc-lvl-icon">💍</div><h4 id="cc-lv1">Destined</h4><div class="cc-lvl-range">90-100%</div><p class="cc-lvl-desc" id="cc-ld1">Written in stars</p></div>
  <div class="cc-lvl"><div class="cc-lvl-icon">💕</div><h4 id="cc-lv2">Magnetic</h4><div class="cc-lvl-range">70-89%</div><p class="cc-lvl-desc" id="cc-ld2">Undeniable pull</p></div>
  <div class="cc-lvl"><div class="cc-lvl-icon">🌹</div><h4 id="cc-lv3">Growing</h4><div class="cc-lvl-range">50-69%</div><p class="cc-lvl-desc" id="cc-ld3">Seeds planted</p></div>
  <div class="cc-lvl"><div class="cc-lvl-icon">🌱</div><h4 id="cc-lv4">Potential</h4><div class="cc-lvl-range">30-49%</div><p class="cc-lvl-desc" id="cc-ld4">Worth exploring</p></div>
  <div class="cc-lvl"><div class="cc-lvl-icon">🌟</div><h4 id="cc-lv5">Self First</h4><div class="cc-lvl-range">0-29%</div><p class="cc-lvl-desc" id="cc-ld5">Love yourself first</p></div>
</section>

<section class="cc-related">
  <h2 id="cc-related-title">Try More Tools</h2>
  <div class="cc-related-grid">
    <a class="cc-rt" href="/love-calculator/"><div class="cc-rt-icon">❤️</div><h4>Love Calc</h4><p>Deep love compatibility</p></a>
    <a class="cc-rt" href="/friendship-calculator/"><div class="cc-rt-icon">🤝</div><h4>Friendship</h4><p>Bond strength by name</p></a>
    <a class="cc-rt" href="/mulank-calculator/"><div class="cc-rt-icon">🔢</div><h4>Mulank Calc</h4><p>Your destiny number</p></a>
    <a class="cc-rt" href="/flames-calculator/"><div class="cc-rt-icon">🔥</div><h4>FLAMES</h4><p>Classic name game</p></a>
  </div>
</section>

<script type="application/ld+json">{"@context":"https://schema.org","@type":"SoftwareApplication","name":"Crush Calculator by Name","description":"Free crush calculator by name. Find your crush compatibility score, soulmate potential, future prediction, signs your crush likes you, and golden tips to impress them.","applicationCategory":"LifestyleApplication","operatingSystem":"Web","offers":{"@type":"Offer","price":"0","priceCurrency":"USD"},"aggregateRating":{"@type":"AggregateRating","ratingValue":"4.9","ratingCount":"11432"}}</script>

<script>
(function(){
'use strict';
var ccLang='en';
var CCT={
  en:{title:'Crush Calculator',subtitle:'Find Your Crush Compatibility & Soulmate Potential by Name',s1:'Tests Today',s2:'Rating',s3:'Free',ph_a:'Your Name',ph_b:"Crush's Name",calc_btn:'Calculate Crush Score 💝',adv_lbl:'Advanced Mode',lang_sw:'हिंदी',crush_lbl:'💘 Crush Score',soul_lbl:'👑 Soulmate Potential',bl1:'⚡ Physical Chemistry',bl2:'🧠 Mental Connection',bl3:'💞 Emotional Depth',bl4:'🌌 Spiritual Sync',future_title:'🔮 Future Prediction',signs_title:'💡 Signs Your Crush Might Like You',song_lbl:'Your Pair Song',lucky_lbl:'Lucky Day to Confess',zodiac_title:'⭐ Zodiac Compatibility',hints_title:'⭐ Golden Tips to Impress Your Crush',try_btn:'🔄 Try Again',related_title:'Try More Tools',error:'Please enter both names.', error2:'Names must be at least 2 characters.',
    lv:['Destined','Magnetic','Growing','Potential','Self First'],ld:['Written in stars','Undeniable pull','Seeds planted','Worth exploring','Love yourself first'],
    load1:'💫 Reading the signs of attraction...',load2:'🔍 Analyzing your name energies...',load3:'💘 Calculating crush score...',load4:'✨ Preparing your cosmic result...',
    days:['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'],days_hi:['सोमवार','मंगलवार','बुधवार','गुरुवार','शुक्रवार','शनिवार','रविवार']},
  hi:{title:'क्रश कैलकुलेटर',subtitle:'नाम से क्रश कम्पेटिबिलिटी और सोलमेट पोटेंशियल जानें',s1:'आज के टेस्ट',s2:'रेटिंग',s3:'मुफ्त',ph_a:'आपका नाम',ph_b:'क्रश का नाम',calc_btn:'क्रश स्कोर जाँचें 💝',adv_lbl:'एडवांस्ड मोड',lang_sw:'English',crush_lbl:'💘 क्रश स्कोर',soul_lbl:'👑 सोलमेट पोटेंशियल',bl1:'⚡ फिज़िकल केमिस्ट्री',bl2:'🧠 मानसिक कनेक्शन',bl3:'💞 भावनात्मक गहराई',bl4:'🌌 आत्मिक समन्वय',future_title:'🔮 भविष्यवाणी',signs_title:'💡 संकेत कि क्रश आपको पसंद करता है',song_lbl:'आपकी जोड़ी का गाना',lucky_lbl:'इजहार का शुभ दिन',zodiac_title:'⭐ राशि अनुकूलता',hints_title:'⭐ इंप्रेस करने के गोल्डन टिप्स',try_btn:'🔄 फिर से करें',related_title:'और टूल्स आजमाएं',error:'कृपया दोनों नाम दर्ज करें।',error2:'नाम कम से कम 2 अक्षर के होने चाहिए।',
    lv:['नियति','चुंबकीय','उगना','संभावना','पहले खुद'],ld:['सितारों में लिखा है','अनूठी खिंचाव','बीज बोए गए','जांचने लायक','पहले खुद से प्यार'],
    load1:'💫 आकर्षण के संकेत पढ़े जा रहे हैं...',load2:'🔍 नाम ऊर्जा का विश्लेषण...',load3:'💘 क्रश स्कोर गणना...',load4:'✨ आपका कॉस्मिक परिणाम तैयार हो रहा है...',
    days:['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'],days_hi:['सोमवार','मंगलवार','बुधवार','गुरुवार','शुक्रवार','शनिवार','रविवार']}
};
var CC_FUTURES=[
  {min:88,emoji:'💍',en:'Destiny has already decided — '+'{n1}'+' and '+'{n2}'+' are written in the stars. This isn\'t just a crush, it\'s a cosmic inevitability. The universe has been building toward this moment. When you take the leap, you won\'t just find love — you\'ll find home.',hi:'नियति ने पहले से ही फैसला कर लिया है। यह सिर्फ क्रश नहीं, यह एक ब्रह्मांडीय अनिवार्यता है। जब आप कदम उठाएंगे, तो आपको सिर्फ प्यार नहीं मिलेगा — आपको घर मिलेगा।'},
  {min:72,emoji:'💕',en:'The chemistry between '+'{n1}'+' and '+'{n2}'+' is undeniable. They think about you more than you know. A genuine, heartfelt confession — not a text, but a real conversation — will be met with excitement. Your love story begins the moment you speak up.',hi:'{n1} और {n2} के बीच केमिस्ट्री से इनकार नहीं किया जा सकता। वो आपके बारे में आपसे ज्यादा सोचते हैं। एक दिल से इजहार आपकी प्रेम कहानी शुरू कर देगा।'},
  {min:55,emoji:'🌱',en:'Real potential is quietly growing between '+'{n1}'+' and '+'{n2}'. Spend more quality time together — let them see all the wonderful, unexpected sides of you. The seeds of something beautiful have already been planted. Water them with consistency and genuine care.',hi:'{n1} और {n2} के बीच वास्तविक संभावना चुपचाप बढ़ रही है। साथ में अधिक समय बिताएं। कुछ सुंदर के बीज पहले से ही बोए जा चुके हैं।'},
  {min:38,emoji:'🤞',en:'It\'s beautifully early between '+'{n1}'+' and '+'{n2}'. There\'s a spark — but it needs a little oxygen. Build a genuine friendship first. Show your real self, not your "trying to impress" self. Authenticity is the most powerful magnet there is.',hi:'{n1} और {n2} के बीच सुंदर शुरुआत है। एक चिंगारी है — लेकिन इसे थोड़ी हवा चाहिए। पहले एक वास्तविक दोस्ती बनाएं।'},
  {min:0,emoji:'🌟',en:'Sometimes the universe redirects us toward something even better. '+'{n1}'+', focus on becoming the most radiant, fulfilled version of yourself first. When you glow from within, the right person will find their way to you — effortlessly and perfectly timed.',hi:'कभी-कभी ब्रह्मांड हमें कुछ और बेहतर की ओर मोड़ता है। पहले खुद का सबसे चमकदार संस्करण बनने पर ध्यान दें।'}
];
var CC_SIGNS_EN=[['👀','Steals glances and looks away with a smile when you catch them.'],['😊','Their face lights up the moment you walk into the room.'],['💬','Finds excuses to text or talk to you — even about random things.'],['🤣','Laughs at your jokes, even the ones that aren\'t that funny.'],['🙋','Always makes sure you feel included and never left out.']];
var CC_SIGNS_HI=[['👀','जब आप देखते हैं तो मुस्कुराते हुए नजर हटा लेते हैं।'],['😊','जैसे ही आप कमरे में आते हैं, उनका चेहरा खिल उठता है।'],['💬','आपसे बात करने के बहाने ढूंढते हैं।'],['🤣','आपके चुटकुलों पर हँसते हैं — यहाँ तक कि जो ज्यादा मजेदार नहीं।'],['🙋','हमेशा सुनिश्चित करते हैं कि आप शामिल हों।']];
var CC_TIPS={
  hi:[{i:'💌',t:'एक दिल से संदेश भेजें',d:'वास्तविक रहें — उन्हें बताएं कि आप उनमें क्या सच में सराहते हैं।'},{i:'🎯',t:'उन्हें हँसाएं',d:'हँसी दिल तक पहुंचने का सबसे तेज रास्ता है।'},{i:'👂',t:'ध्यान से सुनें',d:'पिछली बातचीत से छोटी-छोटी बातें याद रखें।'},{i:'🌟',t:'खुद बनें',d:'सबसे आकर्षक आप वही हैं जो प्रामाणिक और आत्मविश्वासी हो।'}],
  en_hi:[{i:'💌',t:'Send a Heartfelt Message',d:'Be authentic — share one thing you genuinely admire about them.'},{i:'🎯',t:'Make Them Laugh',d:'Laughter is the fastest route to someone\'s heart.'},{i:'👂',t:'Listen Actively',d:'Remember small details from past conversations — it shows you care.'},{i:'🌟',t:'Be Confidently Yourself',d:'The most attractive you is the authentic, confident you.'}],
  mid:[{i:'☕',t:'Suggest a Casual Hangout',ti:'कैजुअल मुलाकात का सुझाव दें',d:'Coffee, a walk, a movie — low pressure, high connection.',dhi:'कॉफी, सैर — कम दबाव, अधिक कनेक्शन।'},{i:'📱',t:'Engage Genuinely Online',ti:'ऑनलाइन वास्तविक रूप से जुड़ें',d:'React warmly to their stories — not excessively, just sincerely.',dhi:'उनकी स्टोरी पर वास्तविक रूप से प्रतिक्रिया दें।'},{i:'🎁',t:'Small Thoughtful Gestures',ti:'छोटे विचारशील इशारे',d:'Remember their favorite snack or book — thoughtfulness is magnetic.',dhi:'उनका पसंदीदा खाना याद रखें — सोचना चुंबकीय है।'},{i:'🌱',t:'Build Genuine Friendship First',ti:'पहले वास्तविक दोस्ती बनाएं',d:'The strongest love always starts as the deepest friendship.',dhi:'सबसे मजबूत प्यार हमेशा सबसे गहरी दोस्ती से शुरू होता है।'}],
  low:[{i:'💪',t:'Glow Up First',ti:'पहले खुद को निखारें',d:'Confidence is magnetic. Invest in yourself.',dhi:'आत्मविश्वास चुंबकीय है। खुद में निवेश करें।'},{i:'✨',t:'Be Present Where They Are',ti:'जहाँ वो हों, वहाँ रहें',d:'Join activities where you can meet naturally and organically.',dhi:'ऐसी गतिविधियों में शामिल हों जहाँ आप स्वाभाविक रूप से मिल सकें।'},{i:'🗣️',t:'Start a Real Conversation',ti:'एक असली बातचीत शुरू करें',d:'Ask their opinion — people love sharing their thoughts.',dhi:'उनसे राय पूछें — लोग अपने विचार साझा करना पसंद करते हैं।'},{i:'🙏',t:'Be Patient and Kind',ti:'धैर्यवान और दयालु रहें',d:'The right connections form naturally when you\'re genuinely kind.',dhi:'सही संबंध स्वाभाविक रूप से बनते हैं जब आप दयालु होते हैं।'}]
};
var CC_SONGS=[
  {min:85,emoji:'🎵',en_song:'Perfect',en_artist:'Ed Sheeran',hi_song:'Tum Hi Ho',hi_artist:'Aashiqui 2'},
  {min:65,emoji:'🎶',en_song:'Thinking Out Loud',en_artist:'Ed Sheeran',hi_song:'Pehla Nasha',hi_artist:'Jo Jeeta Wohi Sikandar'},
  {min:45,emoji:'🎸',en_song:'A Thousand Years',en_artist:'Christina Perri',hi_song:'Teri Meri Prem Kahani',hi_artist:'Bodyguard'},
  {min:25,emoji:'🎹',en_song:"Can't Help Falling in Love",en_artist:'Elvis Presley',hi_song:'Jaadu Hai Nasha Hai',hi_artist:'Jism'},
  {min:0,emoji:'🎤',en_song:'Someone Like You',en_artist:'Adele',hi_song:'Ik Vaari Aa',hi_artist:'Raabta'}
];
var CC_LUCKY_COLORS=[{c:'#FF6B9D',en:'Rose Pink',hi:'गुलाबी'},{c:'#E63946',en:'Passion Red',hi:'जुनून लाल'},{c:'#7B2D8B',en:'Royal Violet',hi:'शाही बैंगनी'},{c:'#FFD700',en:'Golden',hi:'सुनहरा'},{c:'#20B2AA',en:'Ocean Teal',hi:'समुद्री हरा'},{c:'#FF8C00',en:'Sunset Orange',hi:'सूर्यास्त नारंगी'}];
var ZODIAC_COMPAT={
  en:{aries:{taurus:'Passionate but stubborn clash — sparks fly, but patience needed.',gemini:'Electric! A wild, fun, ever-surprising connection.',cancer:'You lead, they nurture — balance is the key.',leo:'Two fire signs — intense, dramatic, incredibly passionate.',virgo:'Opposites attract in beautiful ways here.',libra:'Natural balance — your boldness + their charm = magic.',scorpio:'Deeply magnetic — intense, transformative, unforgettable.',sagittarius:'Adventure partners — wildly compatible and free-spirited.',capricorn:'Long-term potential — slow burn but incredibly solid.',aquarius:'Intellectually stimulating — unusual but deeply connecting.',pisces:'You protect, they dream — a beautifully complementary pair.'},taurus:{gemini:'Grounded meets scattered — you stabilize each other beautifully.',cancer:'Home-loving soulmates — warm, safe, deeply nurturing.',leo:'Luxury and drama — you love pleasure, they love spotlight.',virgo:'Earth sign harmony — stable, practical, genuinely reliable.',libra:'Beauty lovers — aesthetics, romance, and real refinement.',scorpio:'Deeply intense — fixed signs create an unbreakable bond.',sagittarius:'Freedom vs security — fascinating but requires compromise.',capricorn:'Power couple energy — ambitious, loyal, long-lasting.',aquarius:'Unconventional clash — fascinating but needs flexibility.',pisces:'Dreamy romance — you ground them, they inspire you.'},default:'Your zodiac signs create a fascinating dynamic. The real magic happens in the moments you share — not just in the stars, but in your genuine connection and how you choose each other every day.'},
  hi:{default:'आपकी राशियाँ एक आकर्षक गतिशीलता बनाती हैं। असली जादू उन पलों में होता है जो आप साझा करते हैं — सिर्फ सितारों में नहीं, बल्कि आपके वास्तविक संबंध में।'}
};
function $cc(id){return document.getElementById(id);}
function ccSeed(s){var h=0;for(var i=0;i<s.length;i++){h=((h<<5)-h+s.charCodeAt(i))|0;}return Math.abs(h);}
function ccCalcCrush(n1,n2){
  var a=(n1||'').toLowerCase().replace(/[^a-z]/g,''),b=(n2||'').toLowerCase().replace(/[^a-z]/g,'');
  if(!a||!b)return 55;
  var fA={},fB={},keys={};
  for(var i=0;i<a.length;i++)fA[a[i]]=(fA[a[i]]||0)+1;
  for(var j=0;j<b.length;j++)fB[b[j]]=(fB[b[j]]||0)+1;
  for(var k in fA)keys[k]=1;for(var k2 in fB)keys[k2]=1;
  var ov=0,tot=0;for(var k3 in keys){ov+=Math.min(fA[k3]||0,fB[k3]||0);tot+=Math.max(fA[k3]||0,fB[k3]||0);}
  var os=tot?(ov/tot)*100:50;
  var sA=0,sB=0;for(var i2=0;i2<a.length;i2++)sA+=a.charCodeAt(i2)-96;for(var j2=0;j2<b.length;j2++)sB+=b.charCodeAt(j2)-96;
  var ns=((sA+sB)%9+1)*10;var ls=Math.max(0,100-Math.abs(a.length-b.length)*10);
  var seed=ccSeed(a+b);var rand=seed%28;
  var sc=Math.round(os*.35+ns*.25+ls*.2+rand*.55);
  if(sc<18)sc=18+(seed%20);if(sc>99)sc=99;return sc;
}
function ccSoulmate(crush,n1,n2){var seed=ccSeed(n1+n2);var offset=(seed%24)-12;return Math.max(15,Math.min(99,Math.round(crush*0.75+(seed%25)+offset)));}
function ccMetrics(n1,n2,score){
  var seed=ccSeed((n1+n2).toLowerCase());
  function v(off){return Math.max(18,Math.min(99,Math.round(score+(((seed+off)%21)-10))));}
  return{phys:v(1),mental:v(2),emo:v(3),spirit:v(4)};
}
function ccGetFuture(score,n1){
  for(var i=0;i<CC_FUTURES.length;i++){if(score>=CC_FUTURES[i].min){var f=CC_FUTURES[i];var ftxt=(ccLang==='hi'?f.hi:f.en).replace('{n1}',n1).replace('{n2}','');return{emoji:f.emoji,text:ftxt};}}
  var last=CC_FUTURES[CC_FUTURES.length-1];return{emoji:last.emoji,text:ccLang==='hi'?last.hi:last.en};
}
function ccGetTips(score){
  if(score>=70)return CC_TIPS.en_hi;
  if(score>=40)return CC_TIPS.mid;
  return CC_TIPS.low;
}
function ccGetSong(score){for(var i=0;i<CC_SONGS.length;i++){if(score>=CC_SONGS[i].min)return CC_SONGS[i];}return CC_SONGS[CC_SONGS.length-1];}
function ccAnimNum(el,from,to,dur){var start=performance.now();function tick(now){var p=Math.min(1,(now-start)/dur),e=1-Math.pow(1-p,3);el.textContent=Math.round(from+(to-from)*e);if(p<1)requestAnimationFrame(tick);}requestAnimationFrame(tick);}
function ccConfetti(){var colors=['#E63946','#ff6b9d','#fbbf24','#7B2D8B','#fff'],box=document.createElement('div');box.className='cc-confetti';for(var i=0;i<60;i++){var p=document.createElement('i');p.style.left=(Math.random()*100)+'%';p.style.background=colors[Math.floor(Math.random()*colors.length)];p.style.animationDuration=(1.5+Math.random()*2)+'s';p.style.animationDelay=(Math.random()*.5)+'s';p.style.transform='rotate('+(Math.random()*360)+'deg)';box.appendChild(p);}document.body.appendChild(box);setTimeout(function(){box.remove();},4000);}
function ccApplyLang(){
  var t=CCT[ccLang];
  $cc('cc-title').textContent=t.title;$cc('cc-subtitle').textContent=t.subtitle;
  $cc('cc-s1').textContent=t.s1;$cc('cc-s2').textContent=t.s2;$cc('cc-s3').textContent=t.s3;
  $cc('cc-name-a').placeholder=t.ph_a;$cc('cc-name-b').placeholder=t.ph_b;
  $cc('cc-calc-btn').textContent=t.calc_btn;$cc('cc-adv-lbl').textContent=t.adv_lbl;
  $cc('cc-lang-btn').textContent=t.lang_sw;$cc('cc-try-btn').textContent=t.try_btn;
  $cc('cc-crush-lbl').textContent=t.crush_lbl;$cc('cc-soul-lbl').textContent=t.soul_lbl;
  $cc('cc-bl1').textContent=t.bl1;$cc('cc-bl2').textContent=t.bl2;$cc('cc-bl3').textContent=t.bl3;$cc('cc-bl4').textContent=t.bl4;
  $cc('cc-future-title').textContent=t.future_title;$cc('cc-signs-title').textContent=t.signs_title;
  $cc('cc-song-lbl').textContent=t.song_lbl;$cc('cc-lucky-lbl').textContent=t.lucky_lbl;
  $cc('cc-zodiac-title').textContent=t.zodiac_title;$cc('cc-hints-title').textContent=t.hints_title;
  $cc('cc-related-title').textContent=t.related_title;
  for(var i=0;i<5;i++){var lv=$cc('cc-lv'+(i+1)),ld=$cc('cc-ld'+(i+1));if(lv)lv.textContent=t.lv[i];if(ld)ld.textContent=t.ld[i];}
}
function ccRunLoad(cb){
  var el=$cc('cc-load-step'),bar=$cc('cc-progress-bar'),i=0;
  var steps=[CCT[ccLang].load1,CCT[ccLang].load2,CCT[ccLang].load3,CCT[ccLang].load4];
  el.textContent=steps[0];bar.style.width='8%';
  var iv=setInterval(function(){i++;if(i<steps.length){el.style.opacity='0';setTimeout(function(){el.textContent=steps[i];el.style.opacity='1';},200);bar.style.width=((i+1)*25)+'%';}else{clearInterval(iv);bar.style.width='100%';setTimeout(cb,350);}},700);
}
function ccShowResult(){
  var n1=ccState.nameA,n2=ccState.nameB;
  var crush=ccCalcCrush(n1,n2),soul=ccSoulmate(crush,n1,n2),metrics=ccMetrics(n1,n2,crush);
  var t=CCT[ccLang];
  $cc('cc-rc-n-a').textContent=n1;$cc('cc-rc-n-b').textContent=n2;
  $cc('cc-rc-av-a').textContent=n1.charAt(0).toUpperCase();$cc('cc-rc-av-b').textContent=n2.charAt(0).toUpperCase();
  $cc('cc-loading').classList.remove('cc-show');$cc('cc-loading').style.display='none';
  $cc('cc-result').classList.add('cc-show');
  ccAnimNum($cc('cc-crush-pct'),0,crush,1800);
  ccAnimNum($cc('cc-soul-pct'),0,soul,2100);
  var circ=2*Math.PI*86;
  setTimeout(function(){$cc('cc-ring-crush').style.strokeDashoffset=circ-(circ*crush/100);},80);
  setTimeout(function(){$cc('cc-ring-soul').style.strokeDashoffset=circ-(circ*soul/100);},200);
  setTimeout(function(){
    $cc('cc-b1').style.width=metrics.phys+'%';$cc('cc-b2').style.width=metrics.mental+'%';
    $cc('cc-b3').style.width=metrics.emo+'%';$cc('cc-b4').style.width=metrics.spirit+'%';
    $cc('cc-b1-v').textContent=metrics.phys+'%';$cc('cc-b2-v').textContent=metrics.mental+'%';
    $cc('cc-b3-v').textContent=metrics.emo+'%';$cc('cc-b4-v').textContent=metrics.spirit+'%';
  },200);
  // Future
  var future=ccGetFuture(crush,n1);
  $cc('cc-future-emoji').textContent=future.emoji;$cc('cc-future-text').textContent=future.text;
  // Signs
  var signs=ccLang==='hi'?CC_SIGNS_HI:CC_SIGNS_EN,sl=$cc('cc-sign-list');sl.innerHTML='';
  var seed=ccSeed((n1+n2).toLowerCase());
  var shuffled=signs.slice();for(var si=shuffled.length-1;si>0;si--){var sj=Math.floor(((seed+si)%1e9)/1e9*10)%(si+1);var tmp=shuffled[si];shuffled[si]=shuffled[sj];shuffled[sj]=tmp;}
  shuffled.slice(0,4).forEach(function(s){var li=document.createElement('li');li.className='cc-sign-item';li.innerHTML='<span class="cc-si-icon">'+s[0]+'</span><span>'+s[1]+'</span>';sl.appendChild(li);});
  // Song + Lucky
  var song=ccGetSong(crush);
  $cc('cc-song-name').textContent=ccLang==='hi'?song.hi_song:song.en_song;
  $cc('cc-song-artist').textContent=ccLang==='hi'?song.hi_artist:song.en_artist;
  var lseed=ccSeed(n1+n2),lday=t.days[lseed%7],lcol=CC_LUCKY_COLORS[lseed%CC_LUCKY_COLORS.length];
  $cc('cc-lucky-day').textContent=ccLang==='hi'?t.days_hi[lseed%7]:lday;
  $cc('cc-lucky-color-dot').style.background=lcol.c;
  $cc('cc-lucky-color-name').textContent=(ccLang==='hi'?lcol.hi:lcol.en)+' '+( ccLang==='hi'?'रंग':'color');
  // Zodiac
  var za=$cc('cc-zodiac-a').value,zb=$cc('cc-zodiac-b').value,zc=$cc('cc-zodiac-compat');
  if(za&&zb&&$cc('cc-adv-chk').checked){
    var ztable=ZODIAC_COMPAT[ccLang]||ZODIAC_COMPAT.en;
    var ztext=(ztable[za]&&ztable[za][zb])||(ztable[zb]&&ztable[zb][za])||ztable.default||ZODIAC_COMPAT.en.default;
    $cc('cc-zodiac-text').textContent=ztext;zc.classList.add('cc-show');zc.style.display='block';
  } else {zc.classList.remove('cc-show');zc.style.display='none';}
  // Tips
  var tips=ccGetTips(crush),hg=$cc('cc-hints-grid');hg.innerHTML='';
  tips.forEach(function(tip,ti){
    var c=document.createElement('div');c.className='cc-hint';c.style.animationDelay=(ti*.1)+'s';
    var title=ccLang==='hi'?(tip.ti||tip.t):(tip.t);
    var desc=ccLang==='hi'?(tip.dhi||tip.d):(tip.d);
    c.innerHTML='<div class="cc-hint-icon">'+tip.i+'</div><h4>'+title+'</h4><p>'+desc+'</p>';hg.appendChild(c);
  });
  // Share
  var url=window.location.href,msg='💘 Crush Calculator Result!\n\n'+n1+' + '+n2+' = *'+crush+'% Crush Score*\nSoulmate: *'+soul+'%*\n\nTest yours: '+url;
  $cc('cc-sb-wa').href='https://wa.me/?text='+encodeURIComponent(msg);
  $cc('cc-sb-tw').href='https://twitter.com/intent/tweet?text='+encodeURIComponent(n1+' + '+n2+' = '+crush+'% Crush Score 💘! Calculate yours:')+'&url='+encodeURIComponent(url);
  $cc('cc-sb-copy').onclick=function(){var btn=this,orig=btn.innerHTML;try{navigator.clipboard?navigator.clipboard.writeText(url).then(function(){btn.innerHTML='✅ Copied!';setTimeout(function(){btn.innerHTML=orig;},1800);}):(void 0);}catch(e){}};
  $cc('cc-sb-save').onclick=function(){var btn=this,orig=btn.innerHTML;btn.innerHTML='📸...';setTimeout(function(){navigator.share?navigator.share({title:'Crush Calculator',text:msg,url:url}).catch(function(){}).finally(function(){btn.innerHTML=orig;}):alert(msg);},400);};
  if(crush>=70)setTimeout(ccConfetti,600);
  setTimeout(function(){$cc('cc-result').scrollIntoView({behavior:'smooth',block:'start'});},100);
}

var ccState={nameA:'',nameB:''};
$cc('cc-name-a').addEventListener('input',function(){var v=(this.value||'').trim();$cc('cc-av-a').textContent=v?v.charAt(0).toUpperCase():'?';$cc('cc-error').classList.remove('cc-show');});
$cc('cc-name-b').addEventListener('input',function(){var v=(this.value||'').trim();$cc('cc-av-b').textContent=v?v.charAt(0).toUpperCase():'?';$cc('cc-error').classList.remove('cc-show');});
$cc('cc-calc-btn').addEventListener('click',function(){
  var n1=($cc('cc-name-a').value||'').trim(),n2=($cc('cc-name-b').value||'').trim(),err=$cc('cc-error');
  if(!n1||!n2){err.textContent=CCT[ccLang].error;err.classList.add('cc-show');return;}
  if(n1.length<2||n2.length<2){err.textContent=CCT[ccLang].error2;err.classList.add('cc-show');return;}
  err.classList.remove('cc-show');ccState.nameA=n1;ccState.nameB=n2;
  $cc('cc-input-phase').style.display='none';
  var loading=$cc('cc-loading');loading.style.display='block';loading.classList.add('cc-show');
  $cc('cc-progress-bar').style.width='0%';
  ccRunLoad(ccShowResult);
});
[$cc('cc-name-a'),$cc('cc-name-b')].forEach(function(el){el.addEventListener('keydown',function(e){if(e.key==='Enter'){e.preventDefault();$cc('cc-calc-btn').click();}});});
$cc('cc-try-btn').addEventListener('click',function(){
  $cc('cc-result').classList.remove('cc-show');$cc('cc-loading').classList.remove('cc-show');$cc('cc-loading').style.display='none';
  $cc('cc-input-phase').style.display='block';$cc('cc-name-a').value='';$cc('cc-name-b').value='';
  $cc('cc-av-a').textContent='?';$cc('cc-av-b').textContent='?';
  $cc('cc-crush-pct').textContent='0';$cc('cc-soul-pct').textContent='0';
  $cc('cc-ring-crush').style.strokeDashoffset=540.35;$cc('cc-ring-soul').style.strokeDashoffset=540.35;
  ['cc-b1','cc-b2','cc-b3','cc-b4'].forEach(function(id){$cc(id).style.width='0%';});
  $cc('cc-input-phase').scrollIntoView({behavior:'smooth',block:'start'});setTimeout(function(){$cc('cc-name-a').focus();},400);
});
$cc('cc-lang-btn').addEventListener('click',function(){ccLang=ccLang==='en'?'hi':'en';ccApplyLang();});
$cc('cc-adv-chk').addEventListener('change',function(){
  var zi=$cc('cc-zodiac-inputs');if(this.checked){zi.classList.add('cc-show');}else{zi.classList.remove('cc-show');$cc('cc-zodiac-compat').style.display='none';}
});
var ccCnt=312541;setInterval(function(){ccCnt+=1+Math.floor(Math.random()*3);$cc('cc-counter').textContent=ccCnt.toLocaleString('en-IN');},8500);
})();
</script>
</div>
<?php
    return ob_get_clean();
}
add_shortcode( 'crush_calculator', 'cc_render' );
}
