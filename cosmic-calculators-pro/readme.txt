=== Cosmic Calculators Pro — Friendship, Mulank &amp; Crush ===
Contributors: cosmiccalculators
Tags: friendship calculator, mulank, bhagyank, numerology, crush calculator, horoscope, soulmate, calculator, shortcode
Requires at least: 5.0
Tested up to: 6.5
Requires PHP: 7.2
Stable tag: 1.1.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Three premium bilingual (Hindi + English) calculators in one plugin — Friendship Calculator (by name), Mulank & Bhagyank Numerology Calculator (by birthdate), and Crush Calculator with horoscope, soulmate and future-prediction insights. Animated, SEO-optimized, fully self-contained.

== Description ==

Cosmic Calculators Pro bundles three professionally designed, animated, mobile-first calculators into a single WordPress plugin. All three share a unified cosmic color theme (deep purple → magenta → gold), golden-hint cards, personalized advice, share buttons, JSON-LD schema for rich-result SEO, and a built-in **English ↔ हिंदी language toggle** that translates every label, level name, description, hint, advice, and prediction in real-time.

= Tools included =

1. **Friendship Calculator** — Shortcode `[friendship_calculator]`
   * Animated friendship-percentage ring
   * 4 metric bars: Loyalty, Fun, Trust, Emotional Support
   * 8 personalized predictions: Best Emoji, Career Match, Best Pet, Friendship Song, Bond Color, Lucky Day, Lucky Number, Power Mantra
   * Golden Hints, personalized advice, share + FAQ + JSON-LD

2. **Mulank &amp; Bhagyank Numerology Calculator** — Shortcode `[mulank_calculator]`
   * Calculates Mulank (Root Number) and Bhagyank (Destiny Number) from date of birth
   * Ruling planet, personality traits, lucky color, day, gemstone, metal, direction, lucky numbers
   * Compatibility numbers for Friends / Love / Business
   * Career paths, famous personalities, simple remedies
   * Golden Hints, animated reveal, share + FAQ + JSON-LD

3. **Crush Calculator** — Shortcode `[crush_calculator]`
   * Crush % ring + 4 metric bars (Attraction, Vibe Match, Chemistry, Long-term)
   * Yes / Maybe / Slow verdict
   * Optional horoscope compatibility (Western zodiac, element-based)
   * Soulmate verdict + future-together reading
   * 8 predictions: Mood Emoji, Best Date Idea, Crush Song, Confession Day, Gift Idea, Lucky Charm, Power Word, Confession Time
   * Golden Hints, personalized advice, share + FAQ + JSON-LD

= Highlights =

* Unified cosmic theme across all 3 tools (Deep Purple, Magenta, Cosmic Gold)
* Fully animated: pulse rings, count-up percentages, confetti on high scores, smooth bar fills
* SEO-optimized: semantic headings, FAQ JSON-LD, SoftwareApplication schema with ratings
* 100% client-side — names and birth dates never leave the browser
* No jQuery, no external dependencies, no admin settings to fiddle with
* Mobile-first responsive layout, 48px+ touch targets, 375px tested
* Deterministic algorithms — same inputs always give the same output

== Installation ==

1. Upload the `cosmic-calculators-pro` folder to `/wp-content/plugins/` or upload the ZIP via Plugins → Add New.
2. Activate the plugin.
3. Add any of the shortcodes to any page, post, or widget:
   * `[friendship_calculator]`
   * `[mulank_calculator]`
   * `[crush_calculator]`

You can place all three on a single page if you want a complete calculator hub.

== Frequently Asked Questions ==

= Do the calculators share any data? =
No. Each calculator runs independently in the visitor’s browser. Nothing is sent to a server, logged, or saved.

= Can I style the calculators? =
The CSS is scoped under `.fc-wrap`, `.mc-wrap`, `.cc-wrap`. You can override anything from your theme stylesheet without conflicts.

= Will it slow down my site? =
No. There are no external scripts, no jQuery, and no admin AJAX. Each shortcode prints only its own scoped CSS/HTML/JS.

= Are the JSON-LD schemas valid? =
Yes — each tool ships with a `SoftwareApplication` + `FAQPage` schema block tested against Google’s Rich Results Test.

== Changelog ==

= 1.1.0 =
* Bilingual mode: English + हिंदी toggle on every tool (level names, descriptions, hints, advice, predictions, careers, songs, gifts, mantras, zodiacs, months — all translated).
* Auto-detect browser language (hi-* → Hindi by default).
* Removed in-tool FAQ section (use your page content for FAQs to avoid duplication).
* Cleaner JSON-LD: SoftwareApplication schema only, with inLanguage: [en, hi].

= 1.0.0 =
* Initial release with three calculators: Friendship, Mulank/Bhagyank, Crush.

== Upgrade Notice ==

= 1.1.0 =
Adds Hindi/English toggle to all 3 tools and removes the duplicate FAQ section. No breaking changes — shortcodes stay the same.
