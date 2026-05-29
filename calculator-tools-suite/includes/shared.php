<?php
/**
 * Shared assets for the Calculator Tools Suite.
 * Outputs the unified theme CSS + JS helper library a single time per page,
 * no matter how many of the three shortcodes appear.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! function_exists( 'cts_shared_assets' ) ) {

    function cts_shared_assets() {
        static $printed = false;
        if ( $printed ) {
            return '';
        }
        $printed = true;

        ob_start();
        ?>
<style id="cts-theme">
    .cts-wrap, .cts-wrap *, .cts-wrap *::before, .cts-wrap *::after { box-sizing: border-box; }
    .cts-wrap {
        /* One unified palette shared by all three calculators */
        --c-deep1: #1a0b3d; --c-deep2: #3b1566; --c-deep3: #6b2b8f;
        --c-gold:  #f4c430; --c-gold2: #e0a91b; --c-gold-soft: #fff7da;
        --c-ink:   #251a3d; --c-muted: #6a5e85; --c-soft: #faf7ff; --c-line: #ece6f6;
        font-family: 'DM Sans','Inter',-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;
        color: var(--c-ink); max-width: 900px; margin: 0 auto; padding: 12px; line-height: 1.55;
    }
    .cts-wrap h1,.cts-wrap h2,.cts-wrap h3,.cts-wrap h4 { font-family:'Poppins','Syne',system-ui,sans-serif; font-weight:800; letter-spacing:-0.01em; margin:0; }

    /* Toolbar: language + advanced toggles */
    .cts-toolbar { display:flex; justify-content:flex-end; gap:8px; flex-wrap:wrap; margin-bottom:10px; }
    .cts-toggle { display:inline-flex; align-items:center; gap:6px; background:#fff; border:2px solid var(--c-line); border-radius:999px; padding:6px 6px; min-height:40px; }
    .cts-seg { border:none; background:transparent; font-family:'Poppins',sans-serif; font-weight:700; font-size:13px; color:var(--c-muted); padding:6px 12px; border-radius:999px; cursor:pointer; transition:all .2s; }
    .cts-seg.cts-on { background:linear-gradient(135deg,var(--c-gold),var(--c-gold2)); color:#3a2600; box-shadow:0 6px 16px rgba(224,169,27,.35); }
    .cts-adv-btn { display:inline-flex; align-items:center; gap:6px; background:#fff; border:2px solid var(--c-line); border-radius:999px; padding:8px 14px; min-height:40px; font-family:'Poppins',sans-serif; font-weight:700; font-size:13px; color:var(--c-muted); cursor:pointer; transition:all .2s; }
    .cts-adv-btn.cts-on { border-color:var(--c-gold2); color:#7a5a05; background:var(--c-gold-soft); }

    /* Header */
    .cts-header { background:linear-gradient(135deg,var(--c-deep1) 0%,var(--c-deep2) 55%,var(--c-deep3) 100%); border-radius:22px; padding:28px 20px; color:#fff; text-align:center; box-shadow:0 20px 60px rgba(60,15,90,.28); position:relative; overflow:hidden; }
    .cts-header::before { content:""; position:absolute; inset:-50%; background:radial-gradient(circle at 28% 18%,rgba(244,196,48,.20),transparent 60%),radial-gradient(circle at 75% 82%,rgba(123,45,139,.30),transparent 60%); pointer-events:none; }
    .cts-h-icon { font-size:50px; line-height:1; display:inline-block; animation:cts-bob 2.4s ease-in-out infinite; }
    .cts-header h1 { font-size:36px; margin:8px 0 6px; color:#fff; position:relative; z-index:1; }
    .cts-h-sub { opacity:.88; font-size:15px; margin:0; position:relative; z-index:1; }
    .cts-stats { display:flex; align-items:center; justify-content:center; margin-top:18px; flex-wrap:wrap; position:relative; z-index:1; }
    .cts-stat { padding:4px 14px; min-width:96px; }
    .cts-stat-num { font-weight:800; font-family:'Poppins',sans-serif; font-size:18px; color:var(--c-gold); }
    .cts-stat-lbl { font-size:11px; opacity:.8; text-transform:uppercase; letter-spacing:.06em; }
    .cts-stat + .cts-stat { border-left:1px solid rgba(255,255,255,.22); }

    /* Card */
    .cts-card { background:#fff; border-radius:22px; padding:24px 20px; margin-top:18px; box-shadow:0 20px 60px rgba(0,0,0,.08); border:1px solid var(--c-line); }

    /* Inputs */
    .cts-inputs { display:grid; grid-template-columns:1fr auto 1fr; gap:14px; align-items:center; }
    .cts-field { display:flex; flex-direction:column; align-items:center; gap:10px; }
    .cts-avatar { width:64px; height:64px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-family:'Poppins',sans-serif; font-weight:800; font-size:26px; color:#fff; box-shadow:0 8px 24px rgba(0,0,0,.18); transition:transform .25s; }
    .cts-avatar.cts-a { background:linear-gradient(135deg,#7B2D8B,#b558d6); }
    .cts-avatar.cts-b { background:linear-gradient(135deg,var(--c-gold2),var(--c-gold)); color:#3a2600; }
    .cts-avatar:hover { transform:scale(1.05); }
    .cts-input,.cts-select { width:100%; min-height:52px; padding:12px 14px; font-size:16px; border:2px solid var(--c-line); border-radius:14px; outline:none; background:var(--c-soft); transition:border-color .2s,background .2s,box-shadow .2s; font-family:inherit; color:var(--c-ink); }
    .cts-input:focus,.cts-select:focus { border-color:var(--c-gold2); background:#fff; box-shadow:0 0 0 4px rgba(244,196,48,.18); }
    .cts-label { font-size:12.5px; font-weight:700; color:var(--c-muted); align-self:flex-start; }
    .cts-vs { width:56px; height:56px; border-radius:50%; background:linear-gradient(135deg,var(--c-deep3),var(--c-gold2)); color:#fff; display:flex; align-items:center; justify-content:center; font-size:22px; font-weight:800; font-family:'Poppins',sans-serif; box-shadow:0 10px 24px rgba(107,43,143,.35); animation:cts-pulse 1.6s ease-in-out infinite; }
    .cts-single { max-width:420px; margin:0 auto; display:flex; flex-direction:column; gap:8px; }
    .cts-row { display:grid; grid-template-columns:1fr 1fr; gap:12px; }

    .cts-btn { display:inline-flex; align-items:center; justify-content:center; gap:8px; min-height:56px; padding:18px 22px; font-size:17px; font-weight:700; font-family:'Poppins',sans-serif; border:none; border-radius:14px; cursor:pointer; width:100%; transition:transform .15s,box-shadow .2s,opacity .2s; }
    .cts-btn-primary { background:linear-gradient(135deg,var(--c-gold),var(--c-gold2)); color:#3a2600; box-shadow:0 14px 32px rgba(224,169,27,.40); margin-top:18px; }
    .cts-btn-primary:hover { transform:translateY(-2px); box-shadow:0 18px 40px rgba(224,169,27,.52); }
    .cts-btn-primary:active { transform:translateY(0); }
    .cts-trust { display:flex; gap:10px; justify-content:center; flex-wrap:wrap; margin-top:14px; }
    .cts-trust span { font-size:12.5px; color:var(--c-muted); background:var(--c-soft); padding:6px 12px; border-radius:999px; min-height:30px; display:inline-flex; align-items:center; border:1px solid var(--c-line); }
    .cts-error { display:none; background:#fff1f2; color:#b3162a; border:1px solid #ffd6db; padding:10px 14px; border-radius:12px; margin-top:12px; font-size:14px; text-align:center; }
    .cts-error.cts-show { display:block; animation:cts-shake .4s; }

    /* Loading */
    .cts-loading { display:none; text-align:center; padding:14px 8px 6px; }
    .cts-loading.cts-show { display:block; }
    .cts-rings { position:relative; width:160px; height:160px; margin:6px auto 18px; }
    .cts-ring { position:absolute; inset:0; border-radius:50%; border:3px solid rgba(244,196,48,.40); animation:cts-ring 2s ease-out infinite; }
    .cts-ring:nth-child(2){ animation-delay:.5s; border-color:rgba(123,45,139,.42); }
    .cts-ring:nth-child(3){ animation-delay:1s; border-color:rgba(224,169,27,.5); }
    .cts-ring-emoji { position:absolute; inset:0; display:flex; align-items:center; justify-content:center; font-size:58px; animation:cts-pulse 1.2s ease-in-out infinite; }
    .cts-load-title { font-size:18px; font-weight:700; font-family:'Poppins',sans-serif; color:var(--c-deep2); margin-bottom:12px; }
    .cts-load-step { font-size:15px; color:var(--c-muted); min-height:24px; transition:opacity .25s; }
    .cts-progress { height:8px; background:var(--c-line); border-radius:999px; overflow:hidden; margin:14px auto 4px; max-width:360px; }
    .cts-progress-bar { height:100%; width:0%; background:linear-gradient(90deg,var(--c-gold2),var(--c-deep3)); border-radius:999px; transition:width .3s ease; }

    /* Result */
    .cts-result { display:none; }
    .cts-result.cts-show { display:block; animation:cts-fadeUp .55s ease both; }
    .cts-rcard { background:linear-gradient(135deg,var(--c-deep1),var(--c-deep2),var(--c-deep3)); color:#fff; border-radius:22px; padding:28px 20px; text-align:center; box-shadow:0 20px 60px rgba(0,0,0,.25); position:relative; overflow:hidden; }
    .cts-rcard::after { content:""; position:absolute; inset:0; background:radial-gradient(circle at 20% 10%,rgba(244,196,48,.25),transparent 50%),radial-gradient(circle at 80% 90%,rgba(181,88,214,.18),transparent 55%); pointer-events:none; }
    .cts-rc-top { display:flex; align-items:center; justify-content:center; gap:14px; flex-wrap:wrap; margin-bottom:6px; position:relative; z-index:1; }
    .cts-rc-name { display:flex; align-items:center; gap:10px; font-weight:700; font-family:'Poppins',sans-serif; font-size:17px; }
    .cts-rc-name .cts-avatar { width:44px; height:44px; font-size:18px; }
    .cts-rc-mid { font-size:22px; opacity:.9; }
    .cts-ring-wrap { position:relative; width:220px; height:220px; margin:14px auto 10px; z-index:1; }
    .cts-ring-wrap svg { transform:rotate(-90deg); width:100%; height:100%; }
    .cts-ring-bg { fill:none; stroke:rgba(255,255,255,.12); stroke-width:12; }
    .cts-ring-fg { fill:none; stroke-width:12; stroke-linecap:round; transition:stroke-dashoffset 1.8s cubic-bezier(.22,.9,.3,1); }
    .cts-percent { position:absolute; inset:0; display:flex; align-items:center; justify-content:center; flex-direction:column; }
    .cts-percent-num { font-size:62px; font-weight:800; font-family:'Poppins',sans-serif; line-height:1; }
    .cts-percent-sym { font-size:22px; font-weight:700; opacity:.85; }
    .cts-percent-sub { font-size:12px; opacity:.75; margin-top:2px; letter-spacing:.04em; }
    .cts-level { display:inline-block; background:rgba(255,255,255,.12); border:1px solid rgba(255,255,255,.22); padding:8px 18px; border-radius:999px; font-weight:700; font-family:'Poppins',sans-serif; font-size:15px; margin:6px 0 10px; position:relative; z-index:1; }
    .cts-rc-desc { max-width:600px; margin:0 auto; opacity:.92; font-size:15px; position:relative; z-index:1; }
    .cts-watermark { margin-top:14px; font-size:12.5px; opacity:.72; position:relative; z-index:1; }

    /* Bars */
    .cts-bars { margin-top:8px; }
    .cts-bar-row { margin:14px 0; }
    .cts-bar-top { display:flex; justify-content:space-between; font-size:14px; font-weight:600; color:var(--c-ink); margin-bottom:6px; }
    .cts-bar-top span:last-child { color:var(--c-deep3); font-family:'Poppins',sans-serif; font-weight:800; }
    .cts-bar { height:10px; background:var(--c-line); border-radius:999px; overflow:hidden; }
    .cts-bar-fill { height:100%; width:0%; border-radius:999px; background:linear-gradient(90deg,var(--c-gold2),var(--c-deep3)); transition:width 1.5s cubic-bezier(.22,.9,.3,1); }

    /* Golden hints */
    .cts-hints { background:linear-gradient(135deg,#fff8dc,#fff1c1); border-radius:18px; padding:20px; margin-top:18px; border:1px solid #f7e190; }
    .cts-hints h3 { font-size:19px; color:#7a5a05; margin-bottom:12px; }
    .cts-hints-grid { display:grid; grid-template-columns:repeat(2,1fr); gap:12px; }
    .cts-hint { background:#fff; border-radius:14px; padding:14px; border-left:4px solid var(--c-gold2); box-shadow:0 8px 20px rgba(0,0,0,.05); opacity:0; transform:translateY(8px); animation:cts-fadeUp .5s ease forwards; }
    .cts-hint-icon { font-size:22px; margin-bottom:4px; }
    .cts-hint h4 { font-size:14.5px; color:var(--c-deep2); margin-bottom:4px; }
    .cts-hint p { font-size:13px; color:var(--c-muted); margin:0; }

    /* Extras (emoji / song / pet / career / horoscope / soulmate cards) */
    .cts-extras { display:grid; grid-template-columns:repeat(2,1fr); gap:12px; margin-top:16px; }
    .cts-x { background:#fff; border-radius:16px; padding:16px; box-shadow:0 10px 24px rgba(0,0,0,.06); border-top:4px solid var(--c-gold2); opacity:0; transform:translateY(8px); animation:cts-fadeUp .5s ease forwards; }
    .cts-x-head { display:flex; align-items:center; gap:8px; margin-bottom:6px; }
    .cts-x-emoji { font-size:24px; }
    .cts-x-title { font-size:13px; font-weight:800; font-family:'Poppins',sans-serif; color:var(--c-deep3); text-transform:uppercase; letter-spacing:.04em; }
    .cts-x-val { font-size:16px; font-weight:700; color:var(--c-ink); margin:0 0 2px; }
    .cts-x-note { font-size:13px; color:var(--c-muted); margin:0; }

    /* Advice */
    .cts-advice { background:linear-gradient(135deg,#f3e9ff,#e7d6ff); border-radius:18px; padding:20px; margin-top:16px; border:1px solid #d8c1f0; }
    .cts-advice h3 { font-size:18px; color:#5a1f8a; margin-bottom:8px; }
    .cts-advice p { font-style:italic; color:#3a2057; margin:0 0 12px; }
    .cts-tags { display:flex; flex-wrap:wrap; gap:8px; }
    .cts-tag { background:#fff; padding:6px 12px; border-radius:999px; font-size:12.5px; font-weight:600; color:#5a1f8a; border:1px solid #d8c1f0; }

    /* Advanced details */
    .cts-adv-panel { display:none; background:#fff; border-radius:18px; padding:20px; margin-top:16px; box-shadow:0 10px 24px rgba(0,0,0,.06); border:1px dashed var(--c-gold2); }
    .cts-adv-panel.cts-show { display:block; animation:cts-fadeUp .45s ease both; }
    .cts-adv-panel h3 { font-size:18px; color:var(--c-deep2); margin-bottom:12px; display:flex; align-items:center; gap:8px; }
    .cts-adv-grid { display:grid; grid-template-columns:repeat(2,1fr); gap:10px; }
    .cts-adv-item { background:var(--c-soft); border-radius:12px; padding:12px 14px; border:1px solid var(--c-line); }
    .cts-adv-item .k { font-size:11.5px; text-transform:uppercase; letter-spacing:.05em; color:var(--c-muted); font-weight:700; }
    .cts-adv-item .v { font-size:15px; font-weight:700; color:var(--c-ink); margin-top:2px; }

    /* Share + download */
    .cts-share { display:grid; grid-template-columns:repeat(4,1fr); gap:10px; margin-top:18px; }
    .cts-share-btn { display:inline-flex; align-items:center; justify-content:center; gap:6px; min-height:48px; padding:12px 8px; font-size:14px; font-weight:700; font-family:'Poppins',sans-serif; border-radius:12px; border:none; cursor:pointer; color:#fff; text-decoration:none; transition:transform .15s,box-shadow .15s; }
    .cts-share-btn:hover { transform:translateY(-2px); box-shadow:0 12px 26px rgba(0,0,0,.15); }
    .cts-sb-wa { background:#25d366; }
    .cts-sb-tw { background:#111; }
    .cts-sb-dl { background:linear-gradient(135deg,var(--c-gold2),var(--c-deep3)); }
    .cts-sb-copy { background:#5b5b6e; }
    .cts-try { margin-top:14px; background:#fff; color:var(--c-deep2); border:2px solid var(--c-line); }
    .cts-try:hover { border-color:var(--c-deep3); color:var(--c-deep3); }

    /* Confetti */
    .cts-confetti { position:fixed; inset:0; pointer-events:none; z-index:9999; overflow:hidden; }
    .cts-confetti i { position:absolute; top:-20px; width:10px; height:14px; opacity:.95; animation:cts-fall linear forwards; border-radius:2px; }

    /* Levels reference */
    .cts-levels { display:grid; grid-template-columns:repeat(5,1fr); gap:10px; margin-top:22px; }
    .cts-lvl { background:#fff; border-radius:16px; padding:14px 10px; text-align:center; box-shadow:0 10px 24px rgba(0,0,0,.06); border-top:4px solid var(--c-gold2); }
    .cts-lvl-icon { font-size:26px; }
    .cts-lvl h4 { font-size:14px; color:var(--c-ink); margin:4px 0; }
    .cts-lvl-range { font-size:12px; color:var(--c-deep3); font-weight:700; }
    .cts-lvl-desc { font-size:12px; color:var(--c-muted); margin:4px 0 0; }

    /* Related tools */
    .cts-related { margin-top:22px; }
    .cts-related h2 { font-size:22px; color:var(--c-deep2); margin-bottom:12px; }
    .cts-related-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:12px; }
    .cts-rt { display:block; text-decoration:none; background:#fff; border-radius:16px; padding:16px 12px; text-align:center; box-shadow:0 10px 24px rgba(0,0,0,.06); border-top:4px solid var(--c-gold2); color:inherit; transition:transform .15s,box-shadow .2s; }
    .cts-rt:hover { transform:translateY(-3px); box-shadow:0 16px 32px rgba(0,0,0,.1); }
    .cts-rt-icon { font-size:28px; }
    .cts-rt h4 { font-size:14.5px; color:var(--c-ink); margin:6px 0 4px; }
    .cts-rt p { font-size:12.5px; color:var(--c-muted); margin:0; }

    .cts-foot { text-align:center; font-size:12.5px; color:var(--c-muted); margin-top:18px; }

    /* Animations */
    @keyframes cts-pulse { 0%,100%{ transform:scale(1);} 50%{ transform:scale(1.08);} }
    @keyframes cts-bob { 0%,100%{ transform:translateY(0);} 50%{ transform:translateY(-6px);} }
    @keyframes cts-ring { 0%{ transform:scale(.6); opacity:.9;} 100%{ transform:scale(1.4); opacity:0;} }
    @keyframes cts-fadeUp { from{ opacity:0; transform:translateY(12px);} to{ opacity:1; transform:translateY(0);} }
    @keyframes cts-shake { 0%,100%{ transform:translateX(0);} 25%{ transform:translateX(-4px);} 75%{ transform:translateX(4px);} }
    @keyframes cts-fall { 0%{ transform:translateY(-20px) rotate(0); opacity:1;} 100%{ transform:translateY(110vh) rotate(720deg); opacity:.3;} }
    @media (prefers-reduced-motion: reduce) { .cts-wrap *{ animation-duration:.001s !important; transition-duration:.05s !important; } }

    /* Mobile */
    @media (max-width:640px){
        .cts-wrap{ padding:8px; }
        .cts-header{ padding:22px 16px; border-radius:18px; }
        .cts-header h1{ font-size:28px; }
        .cts-h-icon{ font-size:44px; }
        .cts-card{ padding:20px 16px; border-radius:18px; }
        .cts-inputs{ grid-template-columns:1fr; gap:12px; }
        .cts-vs{ margin:-4px auto; }
        .cts-percent-num{ font-size:54px; }
        .cts-ring-wrap{ width:200px; height:200px; }
        .cts-share{ grid-template-columns:repeat(2,1fr); }
        .cts-levels{ grid-template-columns:repeat(2,1fr); }
        .cts-related-grid{ grid-template-columns:1fr; }
        .cts-hints-grid,.cts-extras,.cts-adv-grid{ grid-template-columns:1fr; }
        .cts-row{ grid-template-columns:1fr; }
    }
</style>

<script id="cts-helpers">
(function(){
    'use strict';
    if (window.CTS) { return; }

    var CTS = window.CTS = {};

    CTS.$ = function(root, id){ return root.querySelector('#' + id); };
    CTS.qa = function(root, sel){ return Array.prototype.slice.call(root.querySelectorAll(sel)); };

    CTS.escapeHtml = function(s){
        return String(s).replace(/[&<>"']/g, function(c){
            return ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'})[c];
        });
    };

    /* Deterministic 32-bit seed from a string */
    CTS.seed = function(str){
        var s = 0; str = String(str);
        for (var i=0;i<str.length;i++){ s = ((s<<5)-s + str.charCodeAt(i))|0; }
        return s;
    };

    /* Seeded 0..1 generator */
    CTS.rng = function(seed){
        return function(off){ return Math.abs(Math.sin(seed + (off||0)*97.13)) % 1; };
    };

    /* Pick deterministically from an array */
    CTS.pick = function(arr, seed, off){
        if (!arr || !arr.length) { return null; }
        var r = Math.abs(Math.sin(seed + (off||0)*53.7)) % 1;
        return arr[Math.floor(r * arr.length) % arr.length];
    };

    /* Reduce a number to a single digit (numerology), keeping 1..9 */
    CTS.reduceDigit = function(n){
        n = Math.abs(parseInt(n,10) || 0);
        while (n > 9){
            var t = 0; while (n > 0){ t += n % 10; n = Math.floor(n/10); } n = t;
        }
        return n === 0 ? 9 : n;
    };

    /* Count-up animation */
    CTS.animateNum = function(el, from, to, duration){
        var start = performance.now();
        function tick(now){
            var p = Math.min(1, (now - start)/duration);
            var eased = 1 - Math.pow(1 - p, 3);
            el.textContent = Math.round(from + (to - from)*eased);
            if (p < 1) requestAnimationFrame(tick);
        }
        requestAnimationFrame(tick);
    };

    /* Confetti burst */
    CTS.confetti = function(){
        var colors = ['#f4c430','#e0a91b','#b558d6','#7B2D8B','#fff'];
        var box = document.createElement('div'); box.className = 'cts-confetti';
        for (var i=0;i<64;i++){
            var p = document.createElement('i');
            p.style.left = (Math.random()*100)+'%';
            p.style.background = colors[Math.floor(Math.random()*colors.length)];
            p.style.animationDuration = (1.5 + Math.random()*2)+'s';
            p.style.animationDelay = (Math.random()*.5)+'s';
            p.style.transform = 'rotate('+(Math.random()*360)+'deg)';
            box.appendChild(p);
        }
        document.body.appendChild(box);
        setTimeout(function(){ box.remove(); }, 4000);
    };

    /* Multi-step loading then callback */
    CTS.runLoading = function(stepEl, barEl, steps, callback){
        var i = 0; stepEl.textContent = steps[0]; barEl.style.width = '8%';
        var iv = setInterval(function(){
            i++;
            if (i < steps.length){
                stepEl.style.opacity = '0';
                setTimeout(function(){ stepEl.textContent = steps[i]; stepEl.style.opacity = '1'; }, 200);
                barEl.style.width = Math.round(((i+1)/steps.length)*100)+'%';
            } else {
                clearInterval(iv); barEl.style.width = '100%';
                setTimeout(callback, 350);
            }
        }, 650);
    };

    /* Copy current URL */
    CTS.copyLink = function(btn, okLabel){
        var orig = btn.innerHTML, url = window.location.href;
        function done(){ btn.innerHTML = okLabel; setTimeout(function(){ btn.innerHTML = orig; }, 1800); }
        try {
            if (navigator.clipboard){ navigator.clipboard.writeText(url).then(done, done); }
            else {
                var ta = document.createElement('textarea'); ta.value = url; document.body.appendChild(ta);
                ta.select(); document.execCommand('copy'); ta.remove(); done();
            }
        } catch(e){ done(); }
    };

    CTS.shareWhatsApp = function(text){ return 'https://wa.me/?text=' + encodeURIComponent(text); };
    CTS.shareTwitter = function(text, url){ return 'https://twitter.com/intent/tweet?text=' + encodeURIComponent(text) + '&url=' + encodeURIComponent(url); };

    /* Draw a branded result card to canvas and download as PNG (no libraries) */
    CTS.downloadCard = function(opts){
        var W = 1080, H = 1350, c = document.createElement('canvas');
        c.width = W; c.height = H; var x = c.getContext('2d');
        var g = x.createLinearGradient(0,0,W,H);
        g.addColorStop(0,'#1a0b3d'); g.addColorStop(.55,'#3b1566'); g.addColorStop(1,'#6b2b8f');
        x.fillStyle = g; x.fillRect(0,0,W,H);
        // soft gold glow
        var rg = x.createRadialGradient(W*0.25,H*0.18,40, W*0.25,H*0.18,520);
        rg.addColorStop(0,'rgba(244,196,48,.28)'); rg.addColorStop(1,'rgba(244,196,48,0)');
        x.fillStyle = rg; x.fillRect(0,0,W,H);
        x.textAlign = 'center';
        x.fillStyle = '#f4c430'; x.font = '700 44px Poppins, Arial, sans-serif';
        x.fillText(opts.brand || '', W/2, 120);
        x.fillStyle = '#ffffff'; x.font = '800 64px Poppins, Arial, sans-serif';
        CTS._wrapText(x, opts.title || '', W/2, 230, W-160, 70);
        // big metric ring
        var cx = W/2, cy = 620, r = 230;
        x.lineWidth = 34; x.strokeStyle = 'rgba(255,255,255,.14)';
        x.beginPath(); x.arc(cx,cy,r,0,Math.PI*2); x.stroke();
        var pct = Math.max(0, Math.min(100, opts.percent||0));
        var grad = x.createLinearGradient(cx-r,cy-r,cx+r,cy+r);
        grad.addColorStop(0,'#f4c430'); grad.addColorStop(1,'#b558d6');
        x.strokeStyle = grad; x.lineCap = 'round';
        x.beginPath(); x.arc(cx,cy,r,-Math.PI/2, -Math.PI/2 + Math.PI*2*pct/100); x.stroke();
        x.fillStyle = '#fff'; x.font = '800 150px Poppins, Arial, sans-serif';
        x.fillText((opts.centerText!=null?opts.centerText:pct), cx, cy+40);
        if (opts.centerSub){ x.fillStyle='rgba(255,255,255,.8)'; x.font='600 34px Poppins, Arial, sans-serif'; x.fillText(opts.centerSub, cx, cy+100); }
        // level pill
        x.fillStyle = '#f4c430'; x.font = '700 46px Poppins, Arial, sans-serif';
        x.fillText(opts.level || '', W/2, 970);
        // description
        x.fillStyle = 'rgba(255,255,255,.92)'; x.font = '400 36px Arial, sans-serif';
        CTS._wrapText(x, opts.desc || '', W/2, 1060, W-180, 50);
        // footer
        x.fillStyle = 'rgba(255,255,255,.7)'; x.font = '600 30px Arial, sans-serif';
        x.fillText(opts.footer || '', W/2, H-70);
        try {
            var url = c.toDataURL('image/png');
            var a = document.createElement('a'); a.href = url;
            a.download = (opts.file || 'result') + '.png';
            document.body.appendChild(a); a.click(); a.remove();
            return true;
        } catch(e){ return false; }
    };

    CTS._wrapText = function(ctx, text, x, y, maxW, lh){
        var words = String(text).split(' '), line = '', lines = [];
        for (var i=0;i<words.length;i++){
            var test = line + words[i] + ' ';
            if (ctx.measureText(test).width > maxW && line){ lines.push(line); line = words[i] + ' '; }
            else { line = test; }
        }
        lines.push(line);
        for (var j=0;j<lines.length && j<6;j++){ ctx.fillText(lines[j].trim(), x, y + j*lh); }
    };

    /* Apply language to a root: updates [data-en]/[data-hi] text + placeholders */
    CTS.applyLang = function(root, lang){
        CTS.qa(root, '[data-en]').forEach(function(el){
            var t = el.getAttribute('data-'+lang);
            if (t != null){ el.textContent = t; }
        });
        CTS.qa(root, '[data-ph-en]').forEach(function(el){
            var t = el.getAttribute('data-ph-'+lang);
            if (t != null){ el.setAttribute('placeholder', t); }
        });
    };

    /* Live counter with Indian formatting */
    CTS.liveCounter = function(el, start){
        var count = start;
        setInterval(function(){
            count += 1 + Math.floor(Math.random()*3);
            el.textContent = count.toLocaleString('en-IN');
        }, 8000);
    };
})();
</script>
        <?php
        return ob_get_clean();
    }
}
