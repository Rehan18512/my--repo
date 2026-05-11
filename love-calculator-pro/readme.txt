=== Love Calculator Pro ===
Contributors: lovecalculatorpro
Tags: love calculator, love meter, compatibility, relationship, numerology, zodiac, valentine
Requires at least: 5.0
Tested up to: 6.6
Requires PHP: 7.0
Stable tag: 2.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Premium Love Calculator with unique 2026 light-romantic UI, heart-shaped percentage meter, 5-dimensional compatibility radar, per-tier golden hints / pro tips / life lessons, advanced numerology + zodiac mode, EN + HI.

== Description ==

A modern, animated, self-contained Love Calculator for WordPress — not a copy of any competitor. Built on the same battle-tested architecture as the FLAMES Calculator Pro plugin: CSS prints in `wp_head`, JS prints in `wp_footer` (both wpautop-safe), all panels controlled by inline `display:none` + defensive CSS so themes cannot break it.

**Highlights**

* Unique 2026 light-romantic UI with floating heart particles, cupid-arrow animation, heart-shaped SVG percentage meter that fills like water.
* Classic L-O-V-E-S algorithm + name-overlap blend (basic mode).
* Advanced mode adds Numerology life path + Zodiac element match + 5-dimensional Compatibility Radar (Emotional / Communication / Trust / Romance / Future).
* 5 result tiers — Cool Waters / Light Spark / Warm Match / Strong Love / Soul Connection — each with its own quote, advice and theme.
* 5 advice cards per tier: Golden Hint, Pro Tip, Life Lesson, Score Boost, What Next — in English and Hindi.
* Bonus cards: Love Song dedication, Date Idea, Lucky Day.
* Optional Gender chips + Relationship Status chips (Crush / Dating / Committed / Married).
* Sound + haptics toggle, history (localStorage), share, downloadable 1080x1080 result card (canvas-based).
* Three configurable AdSense slots and optional Premium upsell card.
* Three theme skins: Rose Blush, Sunset Peach, Royal Wine (dark).
* No external CDN — pure HTML / CSS / vanilla JS.
* Translation-ready, WP 5.0+ / PHP 7.0+ compatible.

**Usage**

Insert anywhere with shortcode:

`[love_calculator_pro]`

or override defaults:

`[love_calculator_pro mode="advanced" lang="hi" skin="royal"]`

Alias also works: `[love_calculator]`.

== Installation ==

1. Upload the `love-calculator-pro` folder to `/wp-content/plugins/`.
2. Activate the plugin from the WordPress Plugins screen.
3. Go to **Settings -> Love Calculator** to configure default mode, language, theme skin, ads and premium upsell.
4. Add the shortcode `[love_calculator_pro]` to any page or post.

== Frequently Asked Questions ==

= Does this work in the block editor? =
Yes — paste the shortcode inside a Shortcode block, or use the classic editor.

= Does it require any external library? =
No. Everything (CSS, animations, audio, canvas, share image) is built-in vanilla code. Nothing loads from third-party CDNs.

= Will it conflict with my theme? =
All styles and IDs are scoped under `.lcp-` and a unique container ID, so it should not conflict with theme styles.

= Why did I get a low score? =
The classic L-O-V-E-S algorithm counts how many times the letters L, O, V, E and S appear in both names. Names with few of those letters get lower scores. Each tier has its own thoughtful advice — low scores are never treated as failure.

== Changelog ==

= 2.0.0 =
* Complete rewrite. Brand-new unique 2026 light-romantic UI, not a copy of any competitor.
* Heart-shaped SVG percentage meter that fills like liquid with rising bubbles.
* Cupid arrow animation between name fields.
* Floating heart particles background.
* 5-tier result system with custom quotes and 5 advice cards per tier (EN + HI).
* Advanced mode: Numerology + Zodiac + 5-dimensional Compatibility Radar.
* Gender chips and Relationship Status chips for personalised vibe.
* Bonus extras: Love Song / Date Idea / Lucky Day after every result.
* Three theme skins (Rose / Sunset / Royal).
* AdSense + Premium ready.
* wpautop-safe asset printing via wp_head + wp_footer hooks.
* Defensive display:none style + [hidden] CSS so themes cannot block panels.
* JSDOM-verified form submit, result reveal and EN/HI live language switch.

= 1.0.0 =
* Original release.
