# Cosmic Calculators — WordPress Theme

A premium **dark / glass / neon** WordPress theme purpose-built for the Cosmic
family of relationship calculators (Love, FLAMES, Crush, Friendship and Mulank
Numerology).

* Standalone — **no parent theme required**
* Beginner-friendly — install in 3 clicks
* Responsive (mobile menu included)
* Dark neon glassmorphism UI with subtle animations
* SEO-friendly (semantic HTML5, JSON-LD schema, fast LCP)
* Compatible drop-in replacement for GeneratePress / Kadence setups
* Preserves every calculator shortcode (`[love_calculator_cosmic]`,
  `[flames_calculator_cosmic]`, `[crush_calculator_cosmic]`,
  `[friendship_calculator_cosmic]`, `[mulank_calculator_cosmic]`)

---

## Quick install (3 steps)

1. Zip the `cosmic-calculators-theme/` folder so you have
   **cosmic-calculators-theme.zip** (a pre-built ZIP also ships beside this
   folder in the repository — see *cosmic-calculators-theme.zip*).
2. In WordPress admin, go to **Appearance → Themes → Add New → Upload Theme**.
   Pick the ZIP, click **Install Now**, then **Activate**.
3. Done. Visit your homepage to see the cosmic UI.

For the full step-by-step (including making the calculator pages and menus),
see **INSTALL.md**.

---

## Folder structure

```
cosmic-calculators-theme/
├── style.css                   <- required WordPress theme header
├── theme.json                  <- block editor colors, fonts, spacing
├── functions.php               <- enqueues, supports, menus, patterns
├── screenshot.png              <- 1200x900 preview for Appearance > Themes
├── header.php                  <- HTML <head> + site header
├── footer.php                  <- site footer
├── index.php                   <- WordPress fallback / blog index
├── front-page.php              <- homepage
├── page.php                    <- standard page
├── page-calculator.php         <- Calculator Page template (Templates picker)
├── page-full-width.php         <- Full Width Page template
├── single.php                  <- blog post
├── archive.php                 <- category / tag / author archives
├── search.php                  <- search results
├── searchform.php              <- reusable search input
├── 404.php                     <- pretty 404
├── comments.php                <- comments and reply form
├── sidebar.php                 <- footer widgets area
├── README.md                   <- this file
├── INSTALL.md                  <- full installation walk-through
├── assets/
│   ├── css/
│   │   ├── cosmic-tokens.css        design tokens (CSS variables)
│   │   ├── cosmic-shell.css         page chrome (nav / hero / cards)
│   │   ├── cosmic-calculators.css   shortcode skin overrides
│   │   └── cosmic-editor.css        Gutenberg editor preview
│   ├── js/
│   │   ├── cosmic-shell.js          mobile nav + scroll reveal + sticky CTA
│   │   ├── cosmic-counter.js        animated number count-up
│   │   └── cosmic-share.js          1080x1080 share-card generator
│   └── img/                         (empty — for your custom imagery)
├── inc/
│   ├── template-functions.php  small helpers (excerpt, image sizes, perf)
│   ├── cosmic-bridge.php       wraps calculator shortcodes in the Cosmic UI
│   ├── cosmic-schema.php       JSON-LD (WebSite / Organization / Breadcrumb)
│   └── cosmic-blocks.php       dynamic Gutenberg blocks (hero, calc grid)
├── patterns/
│   ├── home-hero.php           homepage hero
│   ├── calculator-grid.php     five-tile calculator grid
│   ├── how-it-works.php        3-step explainer
│   ├── big-cta.php             gradient closing CTA
│   └── faq-block.php           FAQ accordion (FAQPage schema-ready)
├── template-parts/
│   ├── cosmic-header.php       site header partial
│   └── cosmic-footer.php       site footer partial
├── parts/                      (reserved for future block-template parts)
├── templates/                  (reserved for future block templates)
└── languages/                  (reserved for .pot / .mo translations)
```

---

## What the theme does for you

* **Loads fonts once** — Geist (UI), Instrument Serif (display), JetBrains Mono
  (mono). Preconnected to `fonts.gstatic.com` for great Core Web Vitals.
* **Inlines critical CSS** above the fold so the first paint has no flash.
* **Skins the calculator plugins** without changing their code. Original
  shortcode markup, schema, analytics events and AdSense slots all keep
  working — we override styles via higher CSS specificity.
* **Registers five block patterns** under the "Cosmic" category so you can
  build new pages by dragging in pre-built sections.
* **Provides a mobile nav** with a hamburger button on screens below 940px.
* **Adds breadcrumb + organization + WebSite schema** as JSON-LD on every
  page — boosts search snippets without an SEO plugin.
* **Disables emoji + unused block-library CSS** when you're not using blocks
  — saves ~15 KB on simple pages.

## Compatible plugins

All calculator plugins from the **Cosmic Calculators** family work out of the
box, including:

* `love-calculator-pro` &mdash; `[love_calculator_pro]`, `[love_calculator]`
* `flames-calculator-pro` &mdash; `[flames_calculator_pro]`, `[flames_calculator]`
* `cosmic-calculators-pro` &mdash; `[crush_calculator]`,
  `[friendship_calculator]`, `[mulank_calculator]`

To get the Cosmic chrome (breadcrumb + hero + related rail) around any of
those, wrap them in the `_cosmic` variants:

```
[love_calculator_cosmic]
[flames_calculator_cosmic]
[crush_calculator_cosmic]
[friendship_calculator_cosmic]
[mulank_calculator_cosmic]
```

You can also opt-in to auto-wrapping every legacy shortcode by adding this
to `wp-config.php`:

```php
define( 'COSMIC_AUTO_WRAP', true );
```

## Performance budget

* HTML: ~3 KB gzipped above the fold
* Critical inline CSS: < 1 KB
* External CSS (after first paint): ~12 KB gzipped
* JavaScript: ~6 KB gzipped (zero dependencies, deferred)
* Total: typically scores **95+ on Lighthouse mobile** out of the box.

## License

GPL-2.0-or-later — same license as WordPress core.
