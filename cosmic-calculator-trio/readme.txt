=== Cosmic Calculator Trio ===
Contributors: cosmiccalctrio
Tags: friendship calculator, mulank calculator, crush calculator, numerology, bhagyank, compatibility
Requires at least: 5.0
Tested up to: 6.6
Requires PHP: 7.0
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Three premium 2026 calculators in one plugin — Friendship Calculator, Mulank (Numerology) Calculator and Crush Calculator. Aurora Mystic theme, animated, EN+HI, golden hints + pro tips + life lessons per result.

== Description ==

Three calculators share one shared **Aurora Mystic** theme (indigo violet + magenta + mint on cream) and one unified architecture. Built using the same battle-tested wp_head CSS + wp_footer JS architecture as the FLAMES and Love Calculator Pro plugins, so WordPress wpautop can never break the scripts.

**Three shortcodes**

* `[friendship_calculator]` — Friendship by Name
* `[mulank_calculator]`     — Mulank + Bhagyank (Numerology)
* `[crush_calculator]`      — Crush Compatibility

Alias: `[numerology_calculator]` works for Mulank too.

**Friendship Calculator — features**

* FRIENDS-letter algorithm + name overlap blend.
* 5 tiers: Soul Buddies / Close / Good / Casual / Distant.
* Per-tier Golden Hint, Pro Tip, Life Lesson, Boost and What-Next (EN + HI).
* Bonus extras: friendship emoji, friendship song, ideal shared pet, career-together prediction, lucky day to meet, date idea.

**Mulank Calculator — features**

* Calculates Mulank (root number from day of birth) and Bhagyank (destiny number from full DOB).
* Full 1-9 profiles with ruling planet, lucky colours, lucky day, lucky numbers, compatible numbers, career suggestions, personality analysis.
* Per-number Golden Hint, Pro Tip, Life Lesson, Boost and What-Next (EN + HI).

**Crush Calculator — features**

* CRUSH-letter algorithm + name overlap blend, optional DOB for advanced mode.
* 5 tiers: Destined / Strong / Real / Mild / Just Curiosity.
* Per-tier advice (Golden / Pro / Life / Boost / Next) in EN + HI.
* Bonus extras: crush emoji, future prediction, soulmate signal, horoscope note, crush song, lucky day to confess.

**Shared features**

* Unique 2026 Aurora Mystic UI — drifting indigo / magenta / mint orbs and twinkling stars background, animated icon, gradient confetti reveal, SVG score ring.
* No external CDN. Pure HTML / CSS / vanilla JS.
* Bilingual EN + HI with live language toggle.
* Sound + haptics toggle.
* History (localStorage, last 8 — per tool).
* Share (Web Share API + clipboard fallback) and 1080x1080 canvas-based downloadable result card.
* Three AdSense slots (Top / After-Result / Bottom) and optional Premium upsell card.
* Translation-ready and theme-conflict-safe via fully scoped `.cct-` class names.

== Installation ==

1. Upload the `cosmic-calculator-trio` folder to `/wp-content/plugins/`.
2. Activate the plugin from the WordPress Plugins screen.
3. Go to **Settings -> Cosmic Trio** to configure language, sound, history, ads and premium upsell.
4. Place any of the three shortcodes on the relevant page.

== Frequently Asked Questions ==

= Do all three tools share the same theme? =
Yes. They share one Aurora Mystic palette and identical card/button/animation system so your site feels cohesive.

= Can I use only one of the three tools? =
Yes — each shortcode is independent. Use only what you need.

= Will scripts break under wpautop? =
No. CSS prints via wp_head and JS via wp_footer, both wpautop-safe by design.

== Changelog ==

= 1.0.0 =
* Initial release — Friendship + Mulank + Crush calculators in a single plugin with shared Aurora Mystic theme.
* All three tools verified end-to-end with simulated wpautop pass + JSDOM browser test (form submit, result reveal, advice, extras, language switch — zero JS errors).
