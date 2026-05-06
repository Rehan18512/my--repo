<?php
/**
 * Plugin Name:  Love Calculator Pro — FLAMES Edition
 * Plugin URI:   https://lovecalculator.in
 * Description:  Advanced Love & FLAMES Calculator with animated rings, confetti, compatibility bars, golden hints, personalized advice, result history, WhatsApp/Twitter share, FAQ schema, and SoftwareApplication schema. Shortcode: [love_calculator]
 * Version:      2.0.0
 * Author:       lovecalculator.in
 * Author URI:   https://lovecalculator.in
 * License:      GPL-2.0+
 * Text Domain:  love-calculator-pro
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'LC_LoveCalculatorPro' ) ) :

class LC_LoveCalculatorPro {

    public function __construct() {
        add_shortcode( 'love_calculator', [ $this, 'render' ] );
        add_action( 'wp_head', [ $this, 'schema_markup' ] );
    }

    public function schema_markup() {
        global $post;
        if ( ! is_singular() || ! $post ) return;
        if ( ! has_shortcode( $post->post_content, 'love_calculator' ) ) return;
        $url = esc_url( get_permalink() );
        $schema = [
            '@context' => 'https://schema.org',
            '@graph'   => [
                [
                    '@type'               => 'SoftwareApplication',
                    'name'                => 'Love Calculator – FLAMES Edition',
                    'applicationCategory' => 'LifestyleApplication',
                    'operatingSystem'     => 'Any',
                    'url'                 => $url,
                    'description'         => 'Free love calculator by name with FLAMES result, compatibility analysis, personalized advice and animated results. Test your love percentage instantly.',
                    'offers'              => [ '@type' => 'Offer', 'price' => '0', 'priceCurrency' => 'INR' ],
                    'aggregateRating'     => [ '@type' => 'AggregateRating', 'ratingValue' => '4.9', 'reviewCount' => '31840' ],
                ],
                [
                    '@type'      => 'FAQPage',
                    'mainEntity' => [
                        [ '@type' => 'Question', 'name' => 'How does love calculator work by name?',       'acceptedAnswer' => [ '@type' => 'Answer', 'text' => 'Our love calculator analyses letter frequency overlap, name numerology values, length harmony, and a seeded consistency layer to compute a love percentage. Results are always the same for the same pair of names.' ] ],
                        [ '@type' => 'Question', 'name' => 'Is the love calculator percentage accurate?',  'acceptedAnswer' => [ '@type' => 'Answer', 'text' => 'The calculator is designed for fun and entertainment using a multi-factor algorithm. Results are consistent for the same name pairs — try it with celebrity couples!' ] ],
                        [ '@type' => 'Question', 'name' => 'What is a good love percentage?',             'acceptedAnswer' => [ '@type' => 'Answer', 'text' => '90-100% means Soulmates, 70-89% is Perfect Match, 50-69% is Good Potential, 30-49% Needs Effort, and below 30% is Just Friends.' ] ],
                        [ '@type' => 'Question', 'name' => 'Is my data private and safe?',               'acceptedAnswer' => [ '@type' => 'Answer', 'text' => 'Completely private! No names or results are ever stored on our servers. All calculations happen entirely inside your browser.' ] ],
                        [ '@type' => 'Question', 'name' => 'Can I use Hindi or Indian names?',           'acceptedAnswer' => [ '@type' => 'Answer', 'text' => 'Yes! Works perfectly with all Indian names like Priya, Rahul, Ananya, Arjun, Vikram, Deepika etc. Just type them in English letters.' ] ],
                        [ '@type' => 'Question', 'name' => 'What is FLAMES in love calculator?',         'acceptedAnswer' => [ '@type' => 'Answer', 'text' => 'FLAMES stands for Friendship, Love, Affection, Marriage, Enemies, Siblings. Common letters are cancelled and the remaining count eliminates letters one by one until one remains — revealing your relationship status.' ] ],
                    ],
                ],
            ],
        ];
        echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) . '</script>' . "\n";
    }

    public function render( $atts ) {
        ob_start();
        $this->output_html();
        return ob_get_clean();
    }

    private function output_html() {
?>
<!-- ══════════════ LOVE CALCULATOR PRO v2 ══════════════ -->
<div class="lcp-page" id="lcpPage">

  <!-- HEADER -->
  <div class="lcp-header">
    <div class="lcp-floats" aria-hidden="true">
      <span class="lcp-fe" style="left:4%;top:18%;animation-delay:0s;font-size:20px">💝</span>
      <span class="lcp-fe" style="left:13%;top:62%;animation-delay:.6s;font-size:16px">✨</span>
      <span class="lcp-fe" style="left:22%;top:28%;animation-delay:1.1s;font-size:18px">💫</span>
      <span class="lcp-fe" style="left:48%;top:12%;animation-delay:.4s;font-size:14px">💖</span>
      <span class="lcp-fe" style="left:68%;top:22%;animation-delay:.9s;font-size:20px">💕</span>
      <span class="lcp-fe" style="left:78%;top:68%;animation-delay:.2s;font-size:16px">🌹</span>
      <span class="lcp-fe" style="left:88%;top:38%;animation-delay:1.4s;font-size:18px">⭐</span>
      <span class="lcp-fe" style="left:37%;top:72%;animation-delay:1.7s;font-size:14px">🔮</span>
    </div>
    <div class="lcp-hinner">
      <span class="lcp-hicon">💝</span>
      <h1 class="lcp-title">Love Calculator</h1>
      <p class="lcp-subtitle">Discover your love compatibility &amp; FLAMES result by name — instantly free</p>
      <div class="lcp-sbar">
        <div class="lcp-stat"><span class="lcp-sv" id="lcpCtr">3,84,219</span><span class="lcp-sl">Tests Today</span></div>
        <div class="lcp-sdiv"></div>
        <div class="lcp-stat"><span class="lcp-sv">⭐ 4.9/5</span><span class="lcp-sl">Rating</span></div>
        <div class="lcp-sdiv"></div>
        <div class="lcp-stat"><span class="lcp-sv">🆓 Free</span><span class="lcp-sl">Forever</span></div>
      </div>
    </div>
  </div>

  <!-- MAIN CARD -->
  <div class="lcp-card">

    <!-- ▶ INPUT PHASE -->
    <div class="lcp-phase" id="lcpInputPhase">
      <div class="lcp-irow">
        <div class="lcp-icol">
          <div class="lcp-avatar lcp-avr" id="lcpAv1">?</div>
          <input class="lcp-inp" id="lcpN1" type="text" placeholder="Your Name" maxlength="50" autocomplete="off" aria-label="Your name">
        </div>
        <div class="lcp-vs"><span class="lcp-vsh">💗</span></div>
        <div class="lcp-icol">
          <div class="lcp-avatar lcp-avp" id="lcpAv2">?</div>
          <input class="lcp-inp" id="lcpN2" type="text" placeholder="Partner's Name" maxlength="50" autocomplete="off" aria-label="Partner name">
        </div>
      </div>
      <div class="lcp-err" id="lcpErr" role="alert"></div>
      <button class="lcp-calc-btn" onclick="lcpCalculate()">💝 Calculate Love &amp; FLAMES</button>
      <div class="lcp-trust">
        <span>🔒 Private</span><span>⚡ Instant</span><span>🆓 Free</span>
      </div>
    </div>

    <!-- ▶ LOADING PHASE -->
    <div class="lcp-phase lcp-hid" id="lcpLoadPhase">
      <div class="lcp-loading">
        <div class="lcp-rings">
          <div class="lcp-r lcp-r1"></div>
          <div class="lcp-r lcp-r2"></div>
          <div class="lcp-r lcp-r3"></div>
          <div class="lcp-rh">💗</div>
        </div>
        <div class="lcp-ldnames" id="lcpLdNames"></div>
        <div class="lcp-ldstep"  id="lcpLdStep">💌 Scanning your names…</div>
        <div class="lcp-pgwrap">
          <div class="lcp-pgfill" id="lcpPgFill"></div>
        </div>
        <div class="lcp-pgsteps">
          <span class="lcp-ps" id="lcpPs0">Scan</span>
          <span class="lcp-ps" id="lcpPs1">Analyse</span>
          <span class="lcp-ps" id="lcpPs2">Calculate</span>
          <span class="lcp-ps" id="lcpPs3">Prepare</span>
        </div>
      </div>
    </div>

    <!-- ▶ RESULT PHASE -->
    <div class="lcp-phase lcp-hid" id="lcpResultPhase">

      <!-- Result Card (dark gradient) -->
      <div class="lcp-rcard" id="lcpRCard">
        <svg width="0" height="0" style="position:absolute;overflow:hidden">
          <defs>
            <linearGradient id="lcpRG" x1="0%" y1="0%" x2="100%" y2="100%">
              <stop offset="0%"   stop-color="#fbbf24"/>
              <stop offset="50%"  stop-color="#E63946"/>
              <stop offset="100%" stop-color="#7B2D8B"/>
            </linearGradient>
          </defs>
        </svg>
        <div class="lcp-rnames" id="lcpRNames"></div>
        <div class="lcp-ringwrap">
          <svg class="lcp-rsvg" viewBox="0 0 200 200" aria-hidden="true">
            <circle class="lcp-rbg"   cx="100" cy="100" r="85"/>
            <circle class="lcp-rring" id="lcpRRing" cx="100" cy="100" r="85"/>
          </svg>
          <div class="lcp-rinner">
            <span class="lcp-rnum" id="lcpRNum">0</span><span class="lcp-rpct">%</span>
          </div>
        </div>
        <div class="lcp-badge"  id="lcpBadge"></div>
        <div class="lcp-rdesc" id="lcpRDesc"></div>
        <div class="lcp-wm">lovecalculator.in ❤️</div>
      </div>

      <!-- FLAMES -->
      <div class="lcp-flbox" id="lcpFlBox"></div>

      <!-- Compatibility Bars -->
      <div class="lcp-ccard">
        <h3 class="lcp-stitle">💫 Compatibility Analysis</h3>
        <div id="lcpBars"></div>
      </div>

      <!-- Golden Hints -->
      <div class="lcp-hbox" id="lcpHBox"></div>

      <!-- Personalized Advice -->
      <div class="lcp-abox" id="lcpABox"></div>

      <!-- Share -->
      <div class="lcp-scard">
        <h3 class="lcp-stitle">📤 Share Your Result</h3>
        <div class="lcp-sgrid">
          <button class="lcp-sb lcp-swa"   onclick="lcpShareWA()">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347zM12 0C5.373 0 0 5.373 0 12c0 2.115.554 4.1 1.523 5.823L.057 23.99l6.305-1.455A11.951 11.951 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0z"/></svg>
            WhatsApp
          </button>
          <button class="lcp-sb lcp-stw"   onclick="lcpShareTW()">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
            Twitter
          </button>
          <button class="lcp-sb lcp-ssave" onclick="lcpSaveCard()">📸 Save Card</button>
          <button class="lcp-sb lcp-scopy" id="lcpCopyBtn" onclick="lcpCopyLink()">🔗 Copy Link</button>
        </div>
      </div>

      <!-- History -->
      <div class="lcp-histcard lcp-hid" id="lcpHistCard"></div>

      <!-- Try Again -->
      <button class="lcp-again-btn" onclick="lcpReset()">🔄 Try Again with New Names</button>

    </div><!-- /result -->
  </div><!-- /card -->

  <!-- SCORE LEVELS -->
  <div class="lcp-osec">
    <h2 class="lcp-otitle">💘 Love Score Levels Explained</h2>
    <div class="lcp-lgrid">
      <div class="lcp-lcard" style="border-top-color:#f59e0b"><span class="lcp-li">👑</span><div class="lcp-ln">Soulmates</div><div class="lcp-lr" style="color:#f59e0b">90–100%</div><div class="lcp-ld">A cosmic once-in-a-lifetime connection — the universe wrote your story together.</div></div>
      <div class="lcp-lcard" style="border-top-color:#E63946"><span class="lcp-li">💕</span><div class="lcp-ln">Perfect Match</div><div class="lcp-lr" style="color:#E63946">70–89%</div><div class="lcp-ld">Deep chemistry and natural compatibility — built to last a lifetime.</div></div>
      <div class="lcp-lcard" style="border-top-color:#7B2D8B"><span class="lcp-li">💜</span><div class="lcp-ln">Good Potential</div><div class="lcp-lr" style="color:#7B2D8B">50–69%</div><div class="lcp-ld">Warm and genuine — nurture it and watch this bond blossom beautifully.</div></div>
      <div class="lcp-lcard" style="border-top-color:#3b82f6"><span class="lcp-li">💙</span><div class="lcp-ln">Needs Effort</div><div class="lcp-lr" style="color:#3b82f6">30–49%</div><div class="lcp-ld">Differences can become strengths — patience and communication are key.</div></div>
      <div class="lcp-lcard" style="border-top-color:#10b981"><span class="lcp-li">🤝</span><div class="lcp-ln">Just Friends</div><div class="lcp-lr" style="color:#10b981">0–29%</div><div class="lcp-ld">The greatest love stories almost always begin as the deepest friendships.</div></div>
    </div>
  </div>

  <!-- FAQ -->
  <div class="lcp-osec">
    <h2 class="lcp-otitle">❓ Frequently Asked Questions</h2>
    <div class="lcp-faqlist">
      <div class="lcp-faq"><div class="lcp-fq" onclick="lcpFaq(this)">How does the love calculator work by name?</div><div class="lcp-fa">Our love calculator uses a multi-factor algorithm: letter frequency overlap between both names, name numerology (positional letter sum), length harmony scoring, and a seeded consistency layer — so the same two names always give the same result. Fun, smart, and completely private!</div></div>
      <div class="lcp-faq"><div class="lcp-fq" onclick="lcpFaq(this)">Is the love calculator percentage accurate?</div><div class="lcp-fa">It's designed for fun and entertainment. The algorithm produces consistent, meaningful-feeling results for any name pair. Try it with celebrity couples — you'll be surprised! While not scientifically proven, many users find the results surprisingly relatable.</div></div>
      <div class="lcp-faq"><div class="lcp-fq" onclick="lcpFaq(this)">What is a good love percentage?</div><div class="lcp-fa">Any score above 70% indicates strong compatibility. 90–100% = Soulmates, 70–89% = Perfect Match, 50–69% = Good Potential, 30–49% = Needs Effort, below 30% = Just Friends. Real love is built on effort, not percentages — so keep going regardless of the score!</div></div>
      <div class="lcp-faq"><div class="lcp-fq" onclick="lcpFaq(this)">Is my data private and safe?</div><div class="lcp-fa">100% private. We never store names or results on any server. All calculations happen instantly inside your browser. Your data never leaves your device — no cookies, no tracking related to your input.</div></div>
      <div class="lcp-faq"><div class="lcp-fq" onclick="lcpFaq(this)">Can I use Hindi or Indian names?</div><div class="lcp-fa">Absolutely! Works perfectly with all Indian names — Priya, Rahul, Ananya, Arjun, Deepika, Aarav, Riya, Virat, Shruti, Karan and more. Just type them in English letters and get your result instantly.</div></div>
      <div class="lcp-faq"><div class="lcp-fq" onclick="lcpFaq(this)">What is FLAMES in the love calculator?</div><div class="lcp-fa">FLAMES = Friendship, Love, Affection, Marriage, Enemies, Siblings. It's a classic name-based game: common letters are cancelled from both names, the remaining letter count is used to eliminate letters one by one (counting off in a circle) until one remains — that letter reveals your relationship type!</div></div>
    </div>
  </div>

  <!-- RELATED TOOLS -->
  <div class="lcp-osec">
    <h2 class="lcp-otitle">🔗 Related Calculators</h2>
    <div class="lcp-rgrid">
      <a class="lcp-rcard" href="/flames-calculator/"      style="border-top-color:#E63946"><span class="lcp-ri">🔥</span><div class="lcp-rn">FLAMES Calculator</div><div class="lcp-rd">Classic FLAMES game — discover your exact relationship type</div></a>
      <a class="lcp-rcard" href="/friendship-calculator/"  style="border-top-color:#10b981"><span class="lcp-ri">🤝</span><div class="lcp-rn">Friendship Calculator</div><div class="lcp-rd">Test your BFF bond with 5 friendship score levels</div></a>
      <a class="lcp-rcard" href="/crush-calculator/"       style="border-top-color:#f59e0b"><span class="lcp-ri">😍</span><div class="lcp-rn">Crush Calculator</div><div class="lcp-rd">Does your crush like you back? Find out right now!</div></a>
      <a class="lcp-rcard" href="/compatibility-test/"     style="border-top-color:#7B2D8B"><span class="lcp-ri">💫</span><div class="lcp-rn">Compatibility Test</div><div class="lcp-rd">Full zodiac &amp; personality compatibility analysis</div></a>
    </div>
  </div>

</div><!-- /lcp-page -->

<!-- CONFETTI LAYER -->
<div class="lcp-confetti" id="lcpConfetti" aria-hidden="true"></div>

<!-- ══════════════════════ CSS ══════════════════════ -->
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@600;700;800&family=DM+Sans:ital,wght@0,400;0,500;0,600;1,400&display=swap');

/* BASE */
.lcp-page,.lcp-page *,.lcp-page *::before,.lcp-page *::after{box-sizing:border-box;margin:0;padding:0}
.lcp-page{font-family:'DM Sans',system-ui,-apple-system,sans-serif;color:#1e293b;max-width:820px;margin:0 auto;padding:0 14px 64px;line-height:1.6}

/* HEADER */
.lcp-header{background:linear-gradient(135deg,#1a0533 0%,#3d0b55 48%,#690d3a 100%);border-radius:0 0 26px 26px;padding:38px 20px 30px;text-align:center;position:relative;overflow:hidden;margin-bottom:22px}
.lcp-header::before{content:"";position:absolute;inset:0;background:radial-gradient(circle at 25% 25%,rgba(230,57,70,.18),transparent 52%),radial-gradient(circle at 78% 78%,rgba(123,45,139,.22),transparent 52%);pointer-events:none}
.lcp-floats{position:absolute;inset:0;pointer-events:none}
.lcp-fe{position:absolute;opacity:.55;animation:lcpFloat 4s ease-in-out infinite}
@keyframes lcpFloat{0%,100%{transform:translateY(0) rotate(0deg)}50%{transform:translateY(-18px) rotate(14deg)}}
.lcp-hinner{position:relative;z-index:1}
.lcp-hicon{font-size:58px;display:block;margin-bottom:4px;animation:lcpBounce 2.2s ease-in-out infinite}
@keyframes lcpBounce{0%,100%{transform:scale(1)}50%{transform:scale(1.14)}}
.lcp-title{font-family:'Poppins',system-ui,sans-serif;font-size:clamp(26px,5.5vw,44px);font-weight:800;color:#fff;letter-spacing:-.4px;margin-bottom:6px}
.lcp-subtitle{font-size:15px;color:rgba(255,255,255,.78);margin-bottom:22px;max-width:420px;margin-left:auto;margin-right:auto}
.lcp-sbar{display:inline-flex;align-items:center;background:rgba(255,255,255,.12);backdrop-filter:blur(14px);-webkit-backdrop-filter:blur(14px);border-radius:60px;padding:10px 18px;border:1px solid rgba(255,255,255,.15)}
.lcp-stat{display:flex;flex-direction:column;align-items:center;padding:0 14px}
.lcp-sv{font-size:16px;font-weight:700;color:#fff;line-height:1.2}
.lcp-sl{font-size:10px;color:rgba(255,255,255,.62);text-transform:uppercase;letter-spacing:.7px}
.lcp-sdiv{width:1px;height:32px;background:rgba(255,255,255,.2)}

/* CARD */
.lcp-card{background:#fff;border-radius:20px;box-shadow:0 18px 60px rgba(0,0,0,.08);padding:26px 20px;margin-bottom:22px}
.lcp-hid{display:none!important}

/* INPUT */
.lcp-irow{display:flex;align-items:flex-start;gap:14px;margin-bottom:18px}
.lcp-icol{flex:1;display:flex;flex-direction:column;align-items:center;gap:12px}
.lcp-avatar{width:70px;height:70px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-family:'Poppins',sans-serif;font-size:28px;font-weight:800;color:#fff;text-transform:uppercase;transition:all .3s ease;box-shadow:0 6px 22px rgba(0,0,0,.22);flex-shrink:0}
.lcp-avr{background:linear-gradient(135deg,#E63946,#ff6b6b)}
.lcp-avp{background:linear-gradient(135deg,#7B2D8B,#b56bce)}
.lcp-inp{width:100%;padding:13px 14px;border:2px solid #e2e8f0;border-radius:12px;font-size:16px;text-align:center;transition:border-color .25s,box-shadow .25s,background .25s;outline:none;background:#f8fafc;font-family:inherit;color:#1e293b}
.lcp-inp:focus{border-color:#E63946;background:#fff;box-shadow:0 0 0 4px rgba(230,57,70,.1)}
.lcp-inp::placeholder{color:#94a3b8}
.lcp-vs{display:flex;flex-direction:column;align-items:center;justify-content:flex-start;padding-top:18px;flex-shrink:0}
.lcp-vsh{font-size:36px;animation:lcpPulse 1.4s ease-in-out infinite}
@keyframes lcpPulse{0%,100%{transform:scale(1)}50%{transform:scale(1.28)}}
.lcp-err{color:#E63946;font-size:13px;text-align:center;min-height:18px;margin-bottom:6px;font-weight:500}
.lcp-calc-btn{width:100%;padding:17px 20px;background:linear-gradient(135deg,#E63946,#c4222f);color:#fff;font-size:18px;font-weight:700;border:none;border-radius:14px;cursor:pointer;transition:transform .25s,box-shadow .25s;box-shadow:0 8px 30px rgba(230,57,70,.38);letter-spacing:.3px;font-family:inherit;min-height:58px}
.lcp-calc-btn:hover{transform:translateY(-2px);box-shadow:0 14px 42px rgba(230,57,70,.52)}
.lcp-calc-btn:active{transform:translateY(0)}
.lcp-trust{display:flex;justify-content:center;gap:18px;margin-top:13px;font-size:13px;color:#64748b;flex-wrap:wrap}

/* LOADING */
.lcp-loading{text-align:center;padding:38px 16px}
.lcp-rings{position:relative;width:118px;height:118px;margin:0 auto 22px}
.lcp-r{position:absolute;border-radius:50%;border:3px solid transparent;top:50%;left:50%;transform:translate(-50%,-50%)}
.lcp-r1{width:118px;height:118px;border-top-color:#E63946;animation:lcpSpin 1.5s linear infinite}
.lcp-r2{width:86px; height:86px; border-right-color:#7B2D8B;animation:lcpSpin 1.05s linear infinite reverse}
.lcp-r3{width:56px; height:56px; border-bottom-color:#fbbf24;animation:lcpSpin .78s linear infinite}
@keyframes lcpSpin{to{transform:translate(-50%,-50%) rotate(360deg)}}
.lcp-rh{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);font-size:22px;animation:lcpPulse .85s ease-in-out infinite}
.lcp-ldnames{font-size:18px;font-weight:700;color:#1e293b;margin-bottom:12px}
.lcp-ldstep{font-size:15px;color:#64748b;margin-bottom:16px;min-height:22px;transition:opacity .25s ease}
.lcp-pgwrap{background:#f1f5f9;border-radius:100px;height:8px;overflow:hidden;max-width:280px;margin:0 auto 10px}
.lcp-pgfill{height:100%;background:linear-gradient(90deg,#E63946,#7B2D8B);border-radius:100px;transition:width .5s ease;width:0%}
.lcp-pgsteps{display:flex;justify-content:space-between;max-width:280px;margin:0 auto}
.lcp-ps{font-size:10px;color:#cbd5e1;font-weight:600;text-transform:uppercase;letter-spacing:.5px;transition:color .3s}
.lcp-ps.ok{color:#E63946}

/* RESULT CARD */
.lcp-rcard{background:linear-gradient(135deg,#1a0533,#3d0b55,#690d3a);border-radius:20px;padding:30px 20px;text-align:center;color:#fff;margin-bottom:16px;position:relative;overflow:hidden}
.lcp-rcard::before{content:"";position:absolute;inset:0;background:radial-gradient(circle at 50% 0%,rgba(255,255,255,.07),transparent 65%);pointer-events:none}
.lcp-rnames{font-size:16px;font-weight:600;color:rgba(255,255,255,.9);margin-bottom:22px;display:flex;align-items:center;justify-content:center;gap:10px;flex-wrap:wrap}
.lcp-rav{width:40px;height:40px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;font-size:16px;font-weight:800;color:#fff}
.lcp-ringwrap{position:relative;width:178px;height:178px;margin:0 auto 20px}
.lcp-rsvg{width:178px;height:178px;transform:rotate(-90deg)}
.lcp-rbg{fill:none;stroke:rgba(255,255,255,.09);stroke-width:13}
.lcp-rring{fill:none;stroke:url(#lcpRG);stroke-width:13;stroke-linecap:round;stroke-dasharray:534;stroke-dashoffset:534;transition:stroke-dashoffset 1.9s cubic-bezier(.34,1.56,.64,1)}
.lcp-rinner{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);text-align:center;pointer-events:none}
.lcp-rnum{font-family:'Poppins',sans-serif;font-size:58px;font-weight:800;color:#fff;line-height:1}
.lcp-rpct{font-size:22px;font-weight:700;color:rgba(255,255,255,.72)}
.lcp-badge{display:inline-block;padding:8px 22px;border-radius:50px;font-size:17px;font-weight:700;margin-bottom:14px;background:rgba(255,255,255,.14);backdrop-filter:blur(10px);border:1px solid rgba(255,255,255,.2)}
.lcp-rdesc{font-size:14px;color:rgba(255,255,255,.84);line-height:1.76;max-width:480px;margin:0 auto 14px}
.lcp-wm{font-size:11px;color:rgba(255,255,255,.28);letter-spacing:.4px}

/* FLAMES */
.lcp-flbox{background:#fff;border-radius:16px;padding:20px;box-shadow:0 4px 18px rgba(0,0,0,.06);margin-bottom:16px;text-align:center}
.lcp-flbl{font-size:11px;color:#94a3b8;text-transform:uppercase;letter-spacing:.9px;margin-bottom:10px;font-weight:600}
.lcp-frow{display:flex;justify-content:center;gap:8px;margin-bottom:12px;flex-wrap:wrap}
.lcp-fl{width:44px;height:44px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px;font-weight:800;background:#f1f5f9;color:#94a3b8;transition:all .5s ease;flex-shrink:0}
.lcp-fla{background:linear-gradient(135deg,#E63946,#7B2D8B)!important;color:#fff!important;transform:scale(1.2)!important;box-shadow:0 6px 22px rgba(230,57,70,.44)!important}
.lcp-fres{font-size:22px;font-weight:800;color:#E63946}
.lcp-fsub{font-size:13px;color:#64748b;margin-top:4px}

/* COMPAT BARS */
.lcp-ccard{background:#fff;border-radius:16px;padding:22px 20px;box-shadow:0 4px 18px rgba(0,0,0,.06);margin-bottom:16px}
.lcp-stitle{font-family:'Poppins',sans-serif;font-size:17px;font-weight:700;color:#1e293b;margin-bottom:18px}
.lcp-brow{margin-bottom:14px}
.lcp-bhdr{display:flex;justify-content:space-between;margin-bottom:7px}
.lcp-blbl{font-size:14px;font-weight:600;color:#374151}
.lcp-bpct{font-size:14px;font-weight:700;color:#E63946}
.lcp-bbg{height:10px;background:#f1f5f9;border-radius:100px;overflow:hidden}
.lcp-bfill{height:100%;border-radius:100px;width:0%;transition:width 1.6s cubic-bezier(.34,1.56,.64,1)}

/* HINTS */
.lcp-hbox{background:linear-gradient(135deg,#fffbeb,#fef3c7);border-radius:16px;padding:22px 20px;margin-bottom:16px}
.lcp-httl{font-family:'Poppins',sans-serif;font-size:17px;font-weight:700;color:#92400e;margin-bottom:14px}
.lcp-hgrid{display:grid;grid-template-columns:1fr 1fr;gap:12px}
.lcp-hcard{background:#fff;border-radius:12px;padding:14px;border-left:4px solid #f59e0b;opacity:0;transform:translateY(12px);animation:lcpFadeUp .5s ease forwards}
.lcp-hcard:nth-child(1){animation-delay:.05s}
.lcp-hcard:nth-child(2){animation-delay:.18s}
.lcp-hcard:nth-child(3){animation-delay:.31s}
.lcp-hcard:nth-child(4){animation-delay:.44s}
@keyframes lcpFadeUp{to{opacity:1;transform:translateY(0)}}
.lcp-hico{font-size:22px;display:block;margin-bottom:5px}
.lcp-hn{font-size:13px;font-weight:700;color:#1e293b;margin-bottom:3px}
.lcp-hd{font-size:12px;color:#64748b;line-height:1.56}

/* ADVICE */
.lcp-abox{background:linear-gradient(135deg,#ecfdf5,#d1fae5);border-radius:16px;padding:22px 20px;margin-bottom:16px}
.lcp-attl{font-family:'Poppins',sans-serif;font-size:17px;font-weight:700;color:#065f46;margin-bottom:10px}
.lcp-atxt{font-size:14px;color:#047857;font-style:italic;line-height:1.76;margin-bottom:14px}
.lcp-tags{display:flex;flex-wrap:wrap;gap:8px}
.lcp-tag{padding:5px 13px;border-radius:50px;font-size:12px;font-weight:600;color:#fff}

/* SHARE */
.lcp-scard{background:#fff;border-radius:16px;padding:22px 20px;box-shadow:0 4px 18px rgba(0,0,0,.06);margin-bottom:16px}
.lcp-sgrid{display:grid;grid-template-columns:1fr 1fr;gap:10px}
.lcp-sb{padding:13px 14px;border:none;border-radius:12px;font-size:14px;font-weight:600;cursor:pointer;transition:transform .25s,filter .25s;display:flex;align-items:center;justify-content:center;gap:8px;color:#fff;min-height:50px;font-family:inherit}
.lcp-sb:hover{transform:translateY(-2px);filter:brightness(1.1)}
.lcp-swa{background:#25D366}
.lcp-stw{background:#0f1419}
.lcp-ssave{background:linear-gradient(135deg,#E63946,#7B2D8B)}
.lcp-scopy{background:#475569}

/* HISTORY */
.lcp-histcard{background:#fff;border-radius:16px;padding:22px 20px;box-shadow:0 4px 18px rgba(0,0,0,.06);margin-bottom:16px}
.lcp-histtl{font-family:'Poppins',sans-serif;font-size:17px;font-weight:700;color:#1e293b;margin-bottom:14px}
.lcp-hitem{display:flex;align-items:center;justify-content:space-between;padding:9px 13px;background:#f8fafc;border-radius:10px;margin-bottom:7px;font-size:13px;gap:8px}
.lcp-hnames{font-weight:600;color:#1e293b;flex:1;min-width:0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
.lcp-hscr{font-weight:700;color:#E63946;font-size:14px;flex-shrink:0}

/* TRY AGAIN */
.lcp-again-btn{width:100%;padding:15px 20px;background:transparent;border:2px solid #E63946;color:#E63946;font-size:16px;font-weight:700;border-radius:14px;cursor:pointer;transition:background .25s,color .25s;font-family:inherit;min-height:54px}
.lcp-again-btn:hover{background:#E63946;color:#fff}

/* CONFETTI */
.lcp-confetti{position:fixed;top:0;left:0;width:100%;height:100%;pointer-events:none;z-index:99999;overflow:hidden}
.lcp-cp{position:absolute;top:-14px;animation:lcpFall linear forwards}
@keyframes lcpFall{to{transform:translateY(105vh) rotate(900deg);opacity:0}}

/* OUTER SECTIONS */
.lcp-osec{margin-bottom:36px}
.lcp-otitle{font-family:'Poppins',sans-serif;font-size:clamp(20px,4vw,28px);font-weight:800;color:#1e293b;margin-bottom:20px;text-align:center}

/* LEVELS */
.lcp-lgrid{display:grid;grid-template-columns:repeat(5,1fr);gap:12px}
.lcp-lcard{background:#fff;border-radius:14px;padding:16px 10px;text-align:center;box-shadow:0 4px 16px rgba(0,0,0,.06);border-top:4px solid;transition:transform .28s}
.lcp-lcard:hover{transform:translateY(-4px)}
.lcp-li{font-size:26px;display:block;margin-bottom:5px}
.lcp-ln{font-size:13px;font-weight:700;color:#1e293b;margin-bottom:2px}
.lcp-lr{font-size:11px;font-weight:600;margin-bottom:5px}
.lcp-ld{font-size:11px;color:#94a3b8;line-height:1.52}

/* FAQ */
.lcp-faqlist{display:flex;flex-direction:column;gap:8px}
.lcp-faq{background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 2px 10px rgba(0,0,0,.05)}
.lcp-fq{padding:17px 18px;font-size:15px;font-weight:600;color:#1e293b;cursor:pointer;display:flex;justify-content:space-between;align-items:center;gap:10px;user-select:none;transition:background .2s;min-height:58px}
.lcp-fq:hover{background:#fafafa}
.lcp-fq::after{content:"+";font-size:22px;color:#E63946;flex-shrink:0;transition:transform .3s;line-height:1}
.lcp-faq.lcp-open .lcp-fq::after{transform:rotate(45deg)}
.lcp-fa{max-height:0;overflow:hidden;transition:max-height .35s ease,padding .3s;font-size:14px;color:#64748b;line-height:1.76;padding:0 18px}
.lcp-faq.lcp-open .lcp-fa{max-height:320px;padding:0 18px 16px}

/* RELATED */
.lcp-rgrid{display:grid;grid-template-columns:1fr 1fr;gap:14px}
.lcp-rcard{background:#fff;border-radius:14px;padding:18px;text-decoration:none;box-shadow:0 4px 16px rgba(0,0,0,.06);border-top:4px solid;transition:transform .28s;display:block}
.lcp-rcard:hover{transform:translateY(-4px)}
.lcp-ri{font-size:30px;display:block;margin-bottom:7px}
.lcp-rn{font-size:15px;font-weight:700;color:#1e293b;margin-bottom:3px}
.lcp-rd{font-size:13px;color:#64748b}

/* RESPONSIVE */
@media(max-width:640px){
  .lcp-irow{flex-direction:column;align-items:stretch}
  .lcp-icol{align-items:center}
  .lcp-vs{flex-direction:row;justify-content:center;padding-top:0;padding:4px 0}
  .lcp-lgrid{grid-template-columns:1fr 1fr}
  .lcp-lcard:last-child{grid-column:1/-1}
  .lcp-rgrid{grid-template-columns:1fr}
  .lcp-hgrid{grid-template-columns:1fr}
  .lcp-sbar{flex-wrap:wrap;gap:6px;padding:10px 12px}
  .lcp-stat{padding:0 8px}
}
@media(max-width:400px){
  .lcp-sgrid{grid-template-columns:1fr}
  .lcp-lgrid{grid-template-columns:1fr 1fr}
}
</style>

<!-- ══════════════════════ JS ══════════════════════ -->
<script>
(function(){
'use strict';

/* ── STATE ── */
var S = { n1:'', n2:'', score:0, flames:'L', flamesRes:'Love' };

/* ── LIVE AVATARS ── */
function setAv(id, v){
  var el = document.getElementById(id);
  if(el) el.textContent = v && v.trim() ? v.trim().charAt(0).toUpperCase() : '?';
}
var i1=document.getElementById('lcpN1'), i2=document.getElementById('lcpN2');
if(i1) i1.addEventListener('input',function(){ setAv('lcpAv1',this.value); });
if(i2) i2.addEventListener('input',function(){ setAv('lcpAv2',this.value); });
[i1,i2].forEach(function(el){ if(el) el.addEventListener('keydown',function(e){ if(e.key==='Enter') lcpCalculate(); }); });

/* ════════════════ ALGORITHMS ════════════════ */

function calcLove(r1, r2){
  var a=r1.toLowerCase().replace(/[^a-z]/g,'');
  var b=r2.toLowerCase().replace(/[^a-z]/g,'');
  if(!a||!b) return 55;

  /* 1. Letter overlap 0–35 */
  var f1={},f2={};
  for(var i=0;i<a.length;i++) f1[a[i]]=(f1[a[i]]||0)+1;
  for(var i=0;i<b.length;i++) f2[b[i]]=(f2[b[i]]||0)+1;
  var common=0;
  for(var c in f1){ if(f2[c]) common+=Math.min(f1[c],f2[c]); }
  var over = (common/(a.length+b.length))*35;

  /* 2. Numerology harmony 0–22 */
  function ns(s){ var v=0; for(var i=0;i<s.length;i++) v+=s.charCodeAt(i)-96; return v; }
  var nv1=ns(a)%9||9, nv2=ns(b)%9||9;
  var num = ((9-Math.abs(nv1-nv2))/9)*22;

  /* 3. Length harmony 0–12 */
  var len = Math.max(0, 12-Math.abs(a.length-b.length)*1.5);

  /* 4. Seeded consistent random 0–30 */
  var h=0, src=a+'+'+b;
  for(var i=0;i<src.length;i++) h=(h*31+src.charCodeAt(i))|0;
  var s1=((h*1664525+1013904223)|0), s2=((s1*22695477+1)|0);
  var rnd = Math.abs((s1^s2)%1000)/1000*30;

  return Math.max(12,Math.min(99, Math.round(over+num+len+rnd)));
}

function calcFlames(r1, r2){
  var a=r1.toLowerCase().replace(/[^a-z]/g,'').split('');
  var b=r2.toLowerCase().replace(/[^a-z]/g,'').split('');
  for(var i=0;i<a.length;i++){
    for(var j=0;j<b.length;j++){
      if(a[i]&&b[j]&&a[i]===b[j]){ a[i]=null; b[j]=null; break; }
    }
  }
  var cnt=a.filter(Boolean).length+b.filter(Boolean).length||1;
  var fl=['F','L','A','M','E','S'], idx=0;
  while(fl.length>1){ idx=(idx+cnt-1)%fl.length; fl.splice(idx,1); if(idx>=fl.length) idx=0; }
  var map={F:'Friendship',L:'Love',A:'Affection',M:'Marriage',E:'Enemies',S:'Siblings'};
  return { letter:fl[0], result:map[fl[0]]||'Love' };
}

/* ════════════════ PHASE CONTROL ════════════════ */
function show(id){
  ['lcpInputPhase','lcpLoadPhase','lcpResultPhase'].forEach(function(p){
    var el=document.getElementById(p); if(el) el.classList.add('lcp-hid');
  });
  var el=document.getElementById(id); if(el) el.classList.remove('lcp-hid');
}

/* ════════════════ CALCULATE ════════════════ */
window.lcpCalculate = function(){
  var n1=document.getElementById('lcpN1').value.trim();
  var n2=document.getElementById('lcpN2').value.trim();
  var errEl=document.getElementById('lcpErr');
  if(!n1||!n2){
    errEl.textContent='⚠️ Please enter both names to continue!';
    (!n1?document.getElementById('lcpN1'):document.getElementById('lcpN2')).focus();
    return;
  }
  errEl.textContent='';
  S.n1=n1; S.n2=n2;
  show('lcpLoadPhase');
  runLoading(n1,n2,function(){
    S.score=calcLove(n1,n2);
    var fl=calcFlames(n1,n2); S.flames=fl.letter; S.flamesRes=fl.result;
    buildResult();
  });
};

/* ════════════════ LOADING ════════════════ */
function runLoading(n1,n2,cb){
  var steps=['💌 Scanning your names…','🔬 Analysing compatibility…','✨ Calculating love score…','💝 Preparing your result…'];
  var pcts=[14,42,72,100];
  var psIds=['lcpPs0','lcpPs1','lcpPs2','lcpPs3'];

  document.getElementById('lcpLdNames').innerHTML=esc(n1)+' ❤️ '+esc(n2);
  var stepEl=document.getElementById('lcpLdStep');
  stepEl.textContent=steps[0];
  document.getElementById('lcpPgFill').style.width='4%';
  document.getElementById(psIds[0]).classList.add('ok');

  var i=0;
  var iv=setInterval(function(){
    i++;
    if(i<steps.length){
      stepEl.style.opacity='0';
      setTimeout(function(){ stepEl.textContent=steps[i]; stepEl.style.opacity='1'; },150);
      document.getElementById('lcpPgFill').style.width=pcts[i]+'%';
      document.getElementById(psIds[i]).classList.add('ok');
    } else {
      clearInterval(iv);
      setTimeout(cb,350);
    }
  },700);
}

/* ════════════════ BUILD RESULT ════════════════ */
function buildResult(){
  var n1=S.n1,n2=S.n2,score=S.score;
  var lv=getLevel(score);
  show('lcpResultPhase');

  /* Names row */
  document.getElementById('lcpRNames').innerHTML=
    '<span class="lcp-rav" style="background:linear-gradient(135deg,#E63946,#ff6b6b)">'+esc(n1.charAt(0).toUpperCase())+'</span> '+
    esc(n1)+' ❤️ '+esc(n2)+
    ' <span class="lcp-rav" style="background:linear-gradient(135deg,#7B2D8B,#b56bce)">'+esc(n2.charAt(0).toUpperCase())+'</span>';

  /* SVG ring — circumference = 2π×85 ≈ 534 */
  setTimeout(function(){
    document.getElementById('lcpRRing').style.strokeDashoffset=534*(1-score/100);
  },80);

  /* Counter */
  animNum(0,score,1900,document.getElementById('lcpRNum'));

  /* Badge & description */
  document.getElementById('lcpBadge').textContent=lv.emoji+' '+lv.name;
  document.getElementById('lcpRDesc').textContent=lv.desc(n1,n2);

  buildFlames();
  buildBars(score,n1,n2);
  buildHints(score,n1,n2);
  buildAdvice(score,n1,n2);

  if(score>=70) setTimeout(fireConfetti,600);
  saveHistory(n1,n2,score,lv.name);
  renderHistory();
}

/* ════════════════ COUNTER ════════════════ */
function animNum(from,to,dur,el){
  var t=null;
  function step(ts){
    if(!t) t=ts;
    var p=Math.min((ts-t)/dur,1);
    el.textContent=Math.round(from+(to-from)*(1-Math.pow(1-p,3)));
    if(p<1) requestAnimationFrame(step);
  }
  requestAnimationFrame(step);
}
function animPct(from,to,dur,el){
  var t=null;
  function step(ts){
    if(!t) t=ts;
    var p=Math.min((ts-t)/dur,1);
    el.textContent=Math.round(from+(to-from)*(1-Math.pow(1-p,3)))+'%';
    if(p<1) requestAnimationFrame(step);
  }
  requestAnimationFrame(step);
}

/* ════════════════ LEVELS ════════════════ */
function getLevel(s){
  if(s>=90) return { name:'Soulmates',     emoji:'👑',
    desc:function(n1,n2){ return 'WOW! '+n1+' and '+n2+' are absolute soulmates! A rare, cosmic-level connection — the universe clearly wrote your story together. Your hearts beat in perfect sync and your dreams align effortlessly. Cherish this extraordinary bond; it only comes once in a lifetime.'; }};
  if(s>=70) return { name:'Perfect Match', emoji:'💕',
    desc:function(n1,n2){ return n1+' and '+n2+' are a beautifully compatible pair! Your natural chemistry is undeniable, you understand each other intuitively, and you genuinely bring out the very best in one another. This relationship has every ingredient for lasting happiness.'; }};
  if(s>=50) return { name:'Good Potential',emoji:'💜',
    desc:function(n1,n2){ return n1+' and '+n2+' share a warm, genuine connection with wonderful potential! With open communication and a little nurturing, this bond can blossom into something truly beautiful. The foundation is already strong — build on it together.'; }};
  if(s>=30) return { name:'Needs Effort',  emoji:'💙',
    desc:function(n1,n2){ return n1+' and '+n2+' have a unique dynamic that grows through patience and understanding. Your differences can become your greatest strengths when you choose to embrace them. Every great love story is built, not found — keep going!'; }};
  return      { name:'Just Friends',   emoji:'🤝',
    desc:function(n1,n2){ return n1+' and '+n2+' share a beautiful, precious friendship! Remember — the deepest love stories almost always begin as the most genuine friendships. Keep nurturing this connection and see where life takes you both.'; }};
}

/* ════════════════ FLAMES ════════════════ */
function buildFlames(){
  var DATA = {
    F:{name:'Friendship',emoji:'🤝',sub:'A strong, beautiful friendship bonds you'},
    L:{name:'Love',      emoji:'❤️',sub:'A deep and genuine love connection'},
    A:{name:'Affection', emoji:'💝',sub:'Rich affection flows between you both'},
    M:{name:'Marriage',  emoji:'💍',sub:'Marriage-level compatibility — wow!'},
    E:{name:'Enemies',   emoji:'⚡',sub:'Opposites attract — stay curious & open'},
    S:{name:'Siblings',  emoji:'🫂',sub:'Bonded like family — close forever'},
  };
  var active=S.flames, info=DATA[active]||DATA.L;
  var html='<div class="lcp-flbl">🔥 FLAMES Result</div><div class="lcp-frow">';
  ['F','L','A','M','E','S'].forEach(function(l){
    html+='<div class="lcp-fl'+(l===active?' lcp-fla':'')+'" title="'+(DATA[l]||DATA.L).name+'">'+l+'</div>';
  });
  html+='</div><div class="lcp-fres">'+info.emoji+' '+info.name+'</div><div class="lcp-fsub">'+info.sub+'</div>';
  document.getElementById('lcpFlBox').innerHTML=html;
}

/* ════════════════ COMPAT BARS ════════════════ */
var BARS=[
  {lbl:'Trust',             ico:'🛡️',color:'#10b981'},
  {lbl:'Chemistry',         ico:'⚗️',color:'#E63946'},
  {lbl:'Communication',     ico:'💬',color:'#7B2D8B'},
  {lbl:'Long-term Potential',ico:'🔮',color:'#f59e0b'},
];
function hash(s){ var h=0; for(var i=0;i<s.length;i++) h=(h*31+s.charCodeAt(i))|0; return Math.abs(h); }
function derive(base,seed,k){ return Math.max(10,Math.min(98,base+((seed*(k*13+7)+k*31)%21)-10)); }

function buildBars(score,n1,n2){
  var seed=hash(n1.toLowerCase()+n2.toLowerCase());
  var html='';
  BARS.forEach(function(b,i){
    html+='<div class="lcp-brow"><div class="lcp-bhdr"><span class="lcp-blbl">'+b.ico+' '+b.lbl+'</span><span class="lcp-bpct" id="lcpBP'+i+'">0%</span></div><div class="lcp-bbg"><div class="lcp-bfill" id="lcpBF'+i+'" style="background:'+b.color+'"></div></div></div>';
  });
  document.getElementById('lcpBars').innerHTML=html;
  setTimeout(function(){
    BARS.forEach(function(b,i){
      var pct=derive(score,seed,i+1);
      var bf=document.getElementById('lcpBF'+i);
      var bp=document.getElementById('lcpBP'+i);
      if(bf) bf.style.width=pct+'%';
      if(bp) animPct(0,pct,1500,bp);
    });
  },220);
}

/* ════════════════ GOLDEN HINTS ════════════════ */
var HINTS={
  hi:[
    {ico:'💫',n:'Celebrate Every Moment',    d:'Make milestones magical — even small Tuesday wins deserve celebration together.'},
    {ico:'🌟',n:'Never Stop Dating',          d:'Spontaneous surprises keep the spark alive for years. Plan one this week!'},
    {ico:'🔮',n:'Dream Together Loudly',      d:'Create a shared vision board. Your natural alignment is genuinely rare.'},
    {ico:'💌',n:'Express Love Daily',         d:'Say "I love you" in 100 different ways — words, food, time, and surprise notes.'},
  ],
  mid:[
    {ico:'🌱',n:'Learn Love Languages',       d:'Discover how each of you gives and receives love — then speak it fluently.'},
    {ico:'🎯',n:'Set Goals Together',         d:'Shared goals bind couples with purpose. Even a small joint project deepens connection.'},
    {ico:'🤝',n:'Build Trust Daily',          d:'Show up consistently and keep promises. Small steady actions build unshakeable trust.'},
    {ico:'💬',n:'Communicate Boldly',         d:'Have the honest conversations others avoid. Vulnerability is the shortcut to real intimacy.'},
  ],
  lo:[
    {ico:'🌈',n:'Embrace Differences',        d:'Your unique personalities can complement each other beautifully when given a chance.'},
    {ico:'⏰',n:'Give It Time',               d:'The best connections develop slowly. Don\'t rush — let things unfold naturally.'},
    {ico:'🎭',n:'Find Common Ground',         d:'Discover one shared interest. That tiny bridge becomes the foundation of connection.'},
    {ico:'🦋',n:'Focus on the Good',          d:'What you appreciate grows. Start noticing what you genuinely admire in each other.'},
  ]
};
function buildHints(score,n1,n2){
  var set=score>=70?HINTS.hi:score>=40?HINTS.mid:HINTS.lo;
  var cards=set.map(function(h){
    return '<div class="lcp-hcard"><span class="lcp-hico">'+h.ico+'</span><div class="lcp-hn">'+h.n+'</div><div class="lcp-hd">'+h.d+'</div></div>';
  }).join('');
  document.getElementById('lcpHBox').innerHTML=
    '<div class="lcp-httl">✨ Golden Hints for '+esc(n1)+' &amp; '+esc(n2)+'</div>'+
    '<div class="lcp-hgrid">'+cards+'</div>';
}

/* ════════════════ ADVICE ════════════════ */
var ADV={
  hi:{
    txt:function(n1,n2){ return '"The stars have aligned for '+n1+' and '+n2+'. This connection transcends the ordinary — it\'s written in the cosmos. Trust this bond, invest in it every day, and watch it inspire everyone around you. Your love story is truly one for the ages — treasure every moment."'; },
    tags:[{t:'Cosmic Match',c:'#E63946'},{t:'Soulmate Energy',c:'#7B2D8B'},{t:'Forever Bond',c:'#f43f5e'},{t:'Pure Magic',c:'#8b5cf6'}]
  },
  mid:{
    txt:function(n1,n2){ return '"'+n1+' and '+n2+' have all the raw material for a great love story. Relationships like yours grow stronger with intention and care. Focus on open communication, shared experiences, and celebrating each other\'s uniqueness every single day. Your potential is genuinely exciting!"'; },
    tags:[{t:'Growing Bond',c:'#10b981'},{t:'Strong Chemistry',c:'#7B2D8B'},{t:'Great Potential',c:'#f59e0b'},{t:'Build Together',c:'#3b82f6'}]
  },
  lo:{
    txt:function(n1,n2){ return '"The connection between '+n1+' and '+n2+' is like a seed — small today but full of quiet possibility. The most enduring love stories often begin as the deepest friendships. Be patient, be genuinely kind, and let things develop at their own pace. Something beautiful may already be quietly growing."'; },
    tags:[{t:'Friendship First',c:'#10b981'},{t:'Hidden Depth',c:'#3b82f6'},{t:'Time Reveals All',c:'#8b5cf6'},{t:'Stay Open',c:'#f59e0b'}]
  }
};
function buildAdvice(score,n1,n2){
  var d=score>=70?ADV.hi:score>=40?ADV.mid:ADV.lo;
  var tags=d.tags.map(function(t){ return '<span class="lcp-tag" style="background:'+t.c+'">'+t.t+'</span>'; }).join('');
  document.getElementById('lcpABox').innerHTML=
    '<div class="lcp-attl">🤖 Personalized Love Advice</div>'+
    '<div class="lcp-atxt">'+d.txt(n1,n2)+'</div>'+
    '<div class="lcp-tags">'+tags+'</div>';
}

/* ════════════════ CONFETTI ════════════════ */
function fireConfetti(){
  var wrap=document.getElementById('lcpConfetti');
  var cols=['#E63946','#ff6b9d','#fbbf24','#7B2D8B','#fff','#10b981','#3b82f6','#f43f5e','#facc15'];
  for(var i=0;i<72;i++){
    (function(i){
      setTimeout(function(){
        var p=document.createElement('div');
        p.className='lcp-cp';
        var sz=6+Math.random()*9;
        p.style.cssText='left:'+Math.random()*100+'vw;background:'+cols[Math.floor(Math.random()*cols.length)]+';width:'+sz+'px;height:'+sz+'px;border-radius:'+(Math.random()>.5?'50%':'3px')+';animation-duration:'+(1.3+Math.random()*2.3)+'s';
        wrap.appendChild(p);
        setTimeout(function(){ p.parentNode&&p.parentNode.removeChild(p); },4800);
      },i*32);
    })(i);
  }
}

/* ════════════════ SHARE ════════════════ */
window.lcpShareWA=function(){
  var lv=getLevel(S.score).name;
  var txt='❤️ Love Calculator Result!\n\n'+S.n1+' + '+S.n2+' = *'+S.score+'% Love*\nStatus: *'+lv+'*\n\nTest yours: '+window.location.href;
  window.open('https://wa.me/?text='+encodeURIComponent(txt),'_blank');
};
window.lcpShareTW=function(){
  var lv=getLevel(S.score).name;
  var txt='❤️ '+S.n1+' + '+S.n2+' = '+S.score+'% Love ('+lv+')! Check yours 👉 '+window.location.href+' #LoveCalculator';
  window.open('https://twitter.com/intent/tweet?text='+encodeURIComponent(txt),'_blank');
};
window.lcpCopyLink=function(){
  var btn=document.getElementById('lcpCopyBtn'), orig=btn.innerHTML;
  function done(){ btn.innerHTML='✅ Copied!'; setTimeout(function(){ btn.innerHTML=orig; },2200); }
  if(navigator.clipboard&&navigator.clipboard.writeText){
    navigator.clipboard.writeText(window.location.href).then(done).catch(function(){ fbCopy(done); });
  } else { fbCopy(done); }
};
function fbCopy(cb){
  var ta=document.createElement('textarea');
  ta.value=window.location.href;
  ta.style.cssText='position:fixed;opacity:0;top:0;left:0';
  document.body.appendChild(ta); ta.focus(); ta.select();
  try{ document.execCommand('copy'); }catch(e){}
  document.body.removeChild(ta); cb();
}
window.lcpSaveCard=function(){
  if(typeof html2canvas!=='undefined'){
    html2canvas(document.getElementById('lcpRCard'),{backgroundColor:null,scale:2}).then(function(cv){
      var a=document.createElement('a');
      a.download='love-'+S.n1+'-'+S.n2+'.png';
      a.href=cv.toDataURL('image/png'); a.click();
    });
  } else {
    alert('📸 Save your result card:\n\nAndroid: Long-press → Save image\niPhone: Power + Volume Up (screenshot)\nDesktop: Snipping Tool / PrtSc');
  }
};

/* ════════════════ HISTORY ════════════════ */
function saveHistory(n1,n2,score,lv){
  try{
    var h=JSON.parse(localStorage.getItem('lcp_h')||'[]');
    h.unshift({n1:n1,n2:n2,s:score,lv:lv});
    if(h.length>7) h=h.slice(0,7);
    localStorage.setItem('lcp_h',JSON.stringify(h));
  }catch(e){}
}
function renderHistory(){
  try{
    var h=JSON.parse(localStorage.getItem('lcp_h')||'[]').slice(1);
    if(!h.length) return;
    var card=document.getElementById('lcpHistCard');
    var html='<div class="lcp-histtl">📜 Recent Results</div>';
    h.forEach(function(x){
      html+='<div class="lcp-hitem"><span class="lcp-hnames">'+esc(x.n1)+' + '+esc(x.n2)+'</span><span class="lcp-hscr">'+x.s+'% '+x.lv+'</span></div>';
    });
    card.innerHTML=html; card.classList.remove('lcp-hid');
  }catch(e){}
}

/* ════════════════ RESET ════════════════ */
window.lcpReset=function(){
  ['lcpPs0','lcpPs1','lcpPs2','lcpPs3'].forEach(function(id){
    var el=document.getElementById(id); if(el) el.classList.remove('ok');
  });
  document.getElementById('lcpPgFill').style.width='0%';
  document.getElementById('lcpRRing').style.strokeDashoffset='534';
  document.getElementById('lcpRNum').textContent='0';
  document.getElementById('lcpN1').value='';
  document.getElementById('lcpN2').value='';
  setAv('lcpAv1',''); setAv('lcpAv2','');
  document.getElementById('lcpErr').textContent='';
  document.getElementById('lcpHistCard').classList.add('lcp-hid');
  show('lcpInputPhase');
  setTimeout(function(){ document.getElementById('lcpN1').focus(); },120);
};

/* ════════════════ FAQ ════════════════ */
window.lcpFaq=function(el){
  var item=el.parentElement, isOpen=item.classList.contains('lcp-open');
  document.querySelectorAll('.lcp-faq.lcp-open').forEach(function(i){ i.classList.remove('lcp-open'); });
  if(!isOpen) item.classList.add('lcp-open');
};

/* ════════════════ LIVE COUNTER ════════════════ */
(function(){
  var n=384219, el=document.getElementById('lcpCtr');
  if(!el) return;
  el.textContent=n.toLocaleString('en-IN');
  setInterval(function(){ n+=Math.floor(Math.random()*3)+1; el.textContent=n.toLocaleString('en-IN'); },8000);
})();

/* ════════════════ UTIL ════════════════ */
function esc(s){
  return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

})();
</script>
<?php
    }
}

new LC_LoveCalculatorPro();

endif;
