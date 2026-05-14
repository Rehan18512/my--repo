# Installation guide — Cosmic Calculators theme

This guide assumes you have **never installed a WordPress theme before**.
If anything feels unclear, follow the screenshots-based walk-through on the
WordPress.org handbook: <https://wordpress.org/support/article/using-themes/>.

---

## 1. Get the ZIP

You need a file called **`cosmic-calculators-theme.zip`**.

* **Option A — use the pre-built ZIP.** It ships alongside this folder in the
  repository. Download it directly.
* **Option B — build it yourself.** Open a terminal, `cd` to the folder
  *containing* `cosmic-calculators-theme/`, and run:

  ```bash
  zip -r cosmic-calculators-theme.zip cosmic-calculators-theme \
      -x "cosmic-calculators-theme/*.DS_Store" \
      -x "cosmic-calculators-theme/.*"
  ```

  On Windows: right-click the `cosmic-calculators-theme` folder &rarr;
  *Send to* &rarr; *Compressed (zipped) folder*. The resulting ZIP will work.

> Make sure the ZIP, when opened, contains the **folder** `cosmic-calculators-theme/`
> at its top level, *not* the files directly. WordPress requires that.

---

## 2. Upload the theme

1. Log in to your WordPress admin (`https://your-site.com/wp-admin/`).
2. Open **Appearance &rarr; Themes**.
3. Click the **Add New** button at the top.
4. Click **Upload Theme**.
5. Click **Choose File**, pick `cosmic-calculators-theme.zip`, then **Install Now**.
6. After it finishes, click **Activate**.

Visit your homepage — you should now see the cosmic dark UI.

---

## 3. Install the calculator plugin(s) (optional, but recommended)

The theme is a complete site even without the plugins. To get working
calculators on your pages, also upload these plugin ZIPs from
**Plugins &rarr; Add New &rarr; Upload Plugin**:

* `love-calculator-pro` &rarr; provides `[love_calculator_pro]` /
  `[love_calculator]`
* `flames-calculator-pro` &rarr; provides `[flames_calculator_pro]` /
  `[flames_calculator]`
* `cosmic-calculators-pro` &rarr; provides `[crush_calculator]`,
  `[friendship_calculator]`, `[mulank_calculator]`

Activate each plugin. The theme will auto-skin the calculator output the
moment a plugin is active.

---

## 4. Create the calculator pages

Beginners can do this in 60 seconds per page.

1. In WordPress admin, open **Pages &rarr; Add New**.
2. Title the page (e.g. **"Love Calculator"**).
3. Click the **+** icon &rarr; add a **Shortcode** block.
4. Paste one of these in the shortcode field:

   | Page title              | Suggested slug             | Shortcode                            |
   | ----------------------- | -------------------------- | ------------------------------------ |
   | Love Calculator         | `love-calculator`          | `[love_calculator_cosmic]`           |
   | FLAMES Calculator       | `flames-calculator`        | `[flames_calculator_cosmic]`         |
   | Crush Calculator        | `crush-calculator`         | `[crush_calculator_cosmic]`          |
   | Friendship Calculator   | `friendship-calculator`    | `[friendship_calculator_cosmic]`     |
   | Mulank Numerology       | `numerology-mulank`        | `[mulank_calculator_cosmic]`         |

5. Open the **Page** panel on the right &rarr; **Template** &rarr; pick
   **Calculator Page**. This hides the page title (the calculator renders
   its own hero).
6. Click **Publish**.

Once you have the five pages above with the matching slugs, the homepage's
"five calculators" grid and the default header menu will link to them
automatically.

---

## 5. Set up the menus (optional)

The theme ships with a sensible default menu. To customise it:

1. Go to **Appearance &rarr; Menus**.
2. Click **create a new menu**, name it "Primary", click **Create Menu**.
3. Add the calculator pages from the left-hand box.
4. Tick **Primary Menu** under *Menu Settings*, then **Save Menu**.

Repeat for a **Footer** menu if you want.

---

## 6. Customise colors, logo and identity

* **Appearance &rarr; Customize &rarr; Site Identity** — upload your logo,
  set the tagline.
* **Appearance &rarr; Editor (if available)** — tweak block colors via
  `theme.json`.
* Want a different rose-pink? Edit `assets/css/cosmic-tokens.css` and
  change `--cosmic-rose: #ff3d8b;` to your colour. All buttons, focus rings
  and gradient text update at once.

---

## 7. Add the cosmic homepage sections (optional)

The homepage renders by default if you leave **Settings &rarr; Reading**
set to *Your latest posts* — the front-page template will run the cosmic
hero + calc grid + how-it-works + FAQ + big CTA automatically.

To override with a hand-built page:

1. Create a new Page called **"Home"**.
2. In the editor, click **+** &rarr; **Patterns** &rarr; **Cosmic** category.
3. Drag in any of:
   * **Cosmic — Home Hero**
   * **Cosmic — Calculator Grid**
   * **Cosmic — How It Works**
   * **Cosmic — FAQ Block**
   * **Cosmic — Big CTA**
4. Publish.
5. Go to **Settings &rarr; Reading**, choose *A static page*, pick "Home".

---

## 8. SEO checklist

Out of the box you get:

* `<title>` and meta from WordPress core (`title-tag` support enabled).
* JSON-LD: WebSite, Organization and BreadcrumbList schema on the right
  pages. The calculator plugins each emit their own SoftwareApplication
  and FAQPage schema, so you do **not** need a separate schema plugin.
* Semantic HTML5 elements (`<header>`, `<nav>`, `<main>`, `<article>`,
  `<aside>`, `<footer>`).
* No render-blocking JS (all scripts deferred).

If you want sitemaps and `robots.txt` fine-tuning, install **Rank Math**
or **Yoast** — they will play nicely with this theme.

---

## 9. Troubleshooting

* **"This theme is missing the style.css stylesheet."**
  Your ZIP has an extra folder layer. Re-zip so the folder
  `cosmic-calculators-theme/` is at the ZIP's top level.
* **"Are you sure you want to do this?"**
  The upload exceeded your host's PHP upload limit. The theme is small
  (~250 KB), so this is almost always a permission issue — try uploading
  the folder over (S)FTP into `wp-content/themes/` instead.
* **Calculator looks unstyled.**
  Activate the matching plugin (`love-calculator-pro` etc.). The theme
  only re-skins — it doesn't ship the calculator engine itself.
* **No animations.**
  Check that your OS isn't in *Reduce motion* mode — the theme honours
  the `prefers-reduced-motion` system setting on purpose for
  accessibility.

---

## 10. Updating

Updating is identical to installing. Re-upload the new ZIP via
**Appearance &rarr; Themes &rarr; Add New &rarr; Upload Theme** and tick
*Replace current with uploaded*.

Your pages, menus and customizer settings are stored in the database, so
they survive the update.

---

That's it. Welcome to the universe.
