=== FLAMES Calculator Pro ===
Contributors: flamescalculatorpro
Tags: flames, flames calculator, love calculator, compatibility, relationship, numerology, zodiac
Requires at least: 5.0
Tested up to: 6.6
Requires PHP: 7.0
Stable tag: 1.0.1
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Premium FLAMES Calculator with unique 2026 animated UI, advanced zodiac & numerology mode, golden hints, pro tips and life advice for every result. Bilingual EN/HI. AdSense & Premium ready.

== Description ==

A modern, animated, fully self-contained FLAMES Calculator for WordPress.

**Highlights**

* Unique 2026 glass-morphism UI with animated mesh background, ember particles, confetti reveal.
* Live letter-elimination animation + animated F-L-A-M-E-S wheel.
* Basic mode (FLAMES only) and Advanced mode (FLAMES + Numerology + Zodiac + Compatibility %).
* Golden Hints, Pro Tips, Life Lessons, Score Boost and What-Next advice for every result letter.
* Bilingual: English & Hindi (toggle inside the tool).
* Sound + haptics toggle, dark glass theme, mobile-first responsive.
* Save history (localStorage), share result, download a 1080×1080 result card.
* Three AdSense slots (Top, After-Result, Bottom) configurable from admin.
* Optional Premium upsell card (configurable URL + label).
* No external CDN dependencies — pure HTML / CSS / vanilla JS.
* Translation-ready, WP 5.0+ / PHP 7.0+ compatible.

**Usage**

Insert anywhere with shortcode:

`[flames_calculator_pro]`

or override defaults:

`[flames_calculator_pro mode="advanced" lang="hi"]`

Alias also works: `[flames_calculator]`.

== Installation ==

1. Upload the `flames-calculator-pro` folder to `/wp-content/plugins/`.
2. Activate the plugin from the WordPress Plugins screen.
3. Go to **Settings → FLAMES Calculator** to configure default mode, language, ads and premium upsell.
4. Add the shortcode `[flames_calculator_pro]` to any page or post.

== Frequently Asked Questions ==

= Does this work in the block editor? =
Yes — paste the shortcode inside a Shortcode block, or use the classic editor.

= Does it require any external library? =
No. Everything (CSS, animations, audio, canvas, share image) is built-in vanilla code. Nothing loads from third-party CDNs.

= Will it conflict with my theme? =
All styles and IDs are scoped under `.fcp-` and a unique container ID, so it should not conflict with theme styles.

== Changelog ==

= 1.0.1 =
* Fix: results not showing on submit caused by WordPress wpautop injecting
  `<p>` tags inside the inline `<script>` block. CSS now prints via `wp_head`
  and JS via `wp_footer`, both bypassing wpautop entirely.
* Defensive CSS for `[hidden]` and inline `display:none` so theme overrides
  cannot prevent the loading/result panels from showing.
* JS auto-initializes every `.fcp-wrap` instance on the page.
* Submit handler bound to both form `submit` and button `click` for
  maximum reliability.

= 1.0.0 =
* Initial release.
