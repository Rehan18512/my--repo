<?php
/**
 * Cosmic Calculators — functions.php
 *
 * Standalone WordPress theme — no parent required. This file:
 *   1. Declares all required `add_theme_support` features (title-tag,
 *      post-thumbnails, html5, custom-logo, wide/full alignment, etc.)
 *   2. Registers the Primary and Footer nav menus.
 *   3. Enqueues design tokens, shell CSS, calculator skin overrides
 *      and three small vanilla JS modules — in the correct cascade order.
 *   4. Loads Google Fonts (Geist + Instrument Serif + JetBrains Mono)
 *      with preconnect for a perfect LCP.
 *   5. Inlines critical above-the-fold CSS so the page never flashes.
 *   6. Registers five Gutenberg block patterns (hero, calc-grid,
 *      how-it-works, big-cta, FAQ) under the "Cosmic" category.
 *   7. Wraps each calculator plugin's shortcode in the Cosmic chrome
 *      (breadcrumb + neon hero + glass card + related rail) via
 *      `inc/cosmic-bridge.php`. The original plugin output, schema,
 *      AdSense slots and analytics events are preserved untouched.
 *   8. Emits supplementary JSON-LD schema (WebSite, Organization,
 *      Breadcrumbs) via `inc/cosmic-schema.php`.
 *   9. Registers four dynamic Gutenberg blocks (hero, calc-grid, how
 *      it works, big-cta) via `inc/cosmic-blocks.php`.
 *
 * Every callback is wrapped in feature checks so the theme cannot fatal
 * a site that lacks a calculator plugin, an older WP version, or no
 * Gutenberg.
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/* ----------------------------------------------------------------
 *  Constants
 * -------------------------------------------------------------- */
define( 'COSMIC_THEME_VERSION', '1.0.0' );
define( 'COSMIC_THEME_DIR', get_template_directory() );
define( 'COSMIC_THEME_URL', get_template_directory_uri() );

/* Backwards-compat aliases — the old child-theme code paths reference these */
if ( ! defined( 'COSMIC_CHILD_VERSION' ) ) { define( 'COSMIC_CHILD_VERSION', COSMIC_THEME_VERSION ); }
if ( ! defined( 'COSMIC_CHILD_DIR' ) )     { define( 'COSMIC_CHILD_DIR',     COSMIC_THEME_DIR ); }
if ( ! defined( 'COSMIC_CHILD_URL' ) )     { define( 'COSMIC_CHILD_URL',     COSMIC_THEME_URL ); }

/* ----------------------------------------------------------------
 *  Theme setup
 * -------------------------------------------------------------- */
add_action( 'after_setup_theme', function () {

	// i18n
	load_theme_textdomain( 'cosmic-calculators', COSMIC_THEME_DIR . '/languages' );

	// Standard WP supports — required for theme review compliance
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'custom-logo', array(
		'height'      => 60,
		'width'       => 200,
		'flex-height' => true,
		'flex-width'  => true,
	) );
	add_theme_support( 'custom-background', array(
		'default-color' => '07060d',
	) );
	add_theme_support( 'html5', array(
		'comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'style', 'script', 'navigation-widgets',
	) );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );

	// Gutenberg / block editor
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/cosmic-editor.css' );

	// Editor color palette (mirrors theme.json for older WP)
	add_theme_support( 'editor-color-palette', array(
		array( 'name' => __( 'Cosmic Black', 'cosmic-calculators' ), 'slug' => 'cosmic-bg',     'color' => '#07060d' ),
		array( 'name' => __( 'Deep Violet',  'cosmic-calculators' ), 'slug' => 'cosmic-bg-2',   'color' => '#0d0a18' ),
		array( 'name' => __( 'Rose',         'cosmic-calculators' ), 'slug' => 'cosmic-rose',   'color' => '#ff3d8b' ),
		array( 'name' => __( 'Rose Light',   'cosmic-calculators' ), 'slug' => 'cosmic-rose-2', 'color' => '#ff7ab6' ),
		array( 'name' => __( 'Violet',       'cosmic-calculators' ), 'slug' => 'cosmic-violet', 'color' => '#a855ff' ),
		array( 'name' => __( 'Cyan',         'cosmic-calculators' ), 'slug' => 'cosmic-cyan',   'color' => '#22e0f5' ),
		array( 'name' => __( 'Gold',         'cosmic-calculators' ), 'slug' => 'cosmic-gold',   'color' => '#ffd27a' ),
		array( 'name' => __( 'Ink 100',      'cosmic-calculators' ), 'slug' => 'cosmic-ink',    'color' => '#f7f2ff' ),
		array( 'name' => __( 'Ink 60',       'cosmic-calculators' ), 'slug' => 'cosmic-ink-60', 'color' => '#9a90b3' ),
	) );

	add_theme_support( 'editor-gradient-presets', array(
		array( 'name' => __( 'Cosmic Aurora', 'cosmic-calculators' ), 'slug' => 'cosmic-aurora',
			'gradient' => 'linear-gradient(100deg,#ff3d8b 0%,#c084ff 45%,#22e0f5 100%)' ),
		array( 'name' => __( 'Rose Heat',     'cosmic-calculators' ), 'slug' => 'cosmic-rose-heat',
			'gradient' => 'linear-gradient(135deg,#ff3d8b 0%,#a855ff 100%)' ),
	) );

	// Navigation menus
	register_nav_menus( array(
		'primary' => __( 'Primary Menu',  'cosmic-calculators' ),
		'footer'  => __( 'Footer Menu',   'cosmic-calculators' ),
	) );

	// Default content width
	$GLOBALS['content_width'] = 1200;
} );

/* ----------------------------------------------------------------
 *  Sidebar (used by Appearance > Widgets — beginners often look here)
 * -------------------------------------------------------------- */
add_action( 'widgets_init', function () {
	register_sidebar( array(
		'name'          => __( 'Footer Widgets', 'cosmic-calculators' ),
		'id'            => 'cosmic-footer-widgets',
		'description'   => __( 'Widgets in this area appear in the site footer.', 'cosmic-calculators' ),
		'before_widget' => '<section id="%1$s" class="cosmic-widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="cosmic-widget__title">',
		'after_title'   => '</h4>',
	) );
} );

/* ----------------------------------------------------------------
 *  Asset enqueue
 *  Order matters:
 *    1. tokens      (variables only)
 *    2. shell       (page chrome)
 *    3. calculators (plugin skin overrides — last for specificity)
 *    4. JS modules  (deferred, footer)
 * -------------------------------------------------------------- */
add_action( 'wp_enqueue_scripts', function () {

	// 1. Fonts — Geist, Instrument Serif, JetBrains Mono. One request, swap.
	wp_enqueue_style(
		'cosmic-fonts',
		'https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Geist:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap',
		array(),
		null
	);

	// 2. Theme stylesheet entry (required by WordPress)
	wp_enqueue_style(
		'cosmic-style',
		get_stylesheet_uri(),
		array( 'cosmic-fonts' ),
		COSMIC_THEME_VERSION
	);

	// 3. Design system
	wp_enqueue_style( 'cosmic-tokens',      COSMIC_THEME_URL . '/assets/css/cosmic-tokens.css',      array( 'cosmic-style' ), COSMIC_THEME_VERSION );
	wp_enqueue_style( 'cosmic-shell',       COSMIC_THEME_URL . '/assets/css/cosmic-shell.css',       array( 'cosmic-tokens' ), COSMIC_THEME_VERSION );
	wp_enqueue_style( 'cosmic-calculators', COSMIC_THEME_URL . '/assets/css/cosmic-calculators.css', array( 'cosmic-tokens', 'cosmic-shell' ), COSMIC_THEME_VERSION );

	// 4. Scripts — small, vanilla, deferred. ~6 kB combined gzipped.
	wp_enqueue_script( 'cosmic-shell-js',   COSMIC_THEME_URL . '/assets/js/cosmic-shell.js',   array(), COSMIC_THEME_VERSION, true );
	wp_enqueue_script( 'cosmic-counter-js', COSMIC_THEME_URL . '/assets/js/cosmic-counter.js', array(), COSMIC_THEME_VERSION, true );
	wp_enqueue_script( 'cosmic-share-js',   COSMIC_THEME_URL . '/assets/js/cosmic-share.js',   array(), COSMIC_THEME_VERSION, true );

	// 5. Comments reply on single posts
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}, 20 );

/* ----------------------------------------------------------------
 *  Preconnect for Google Fonts — Core Web Vitals
 * -------------------------------------------------------------- */
add_filter( 'wp_resource_hints', function ( $urls, $relation ) {
	if ( 'preconnect' === $relation ) {
		$urls[] = array( 'href' => 'https://fonts.googleapis.com', 'crossorigin' );
		$urls[] = array( 'href' => 'https://fonts.gstatic.com',    'crossorigin' );
	}
	return $urls;
}, 10, 2 );

/* ----------------------------------------------------------------
 *  Inline critical CSS (above-the-fold) — keeps LCP fast even on
 *  the first paint before the stylesheets resolve.
 * -------------------------------------------------------------- */
add_action( 'wp_head', function () {
	echo "<style id=\"cosmic-critical\">"
		. "html,body{background:#07060d;color:#f7f2ff;margin:0}"
		. "body{font-family:'Geist',system-ui,-apple-system,sans-serif;-webkit-font-smoothing:antialiased}"
		. ".cosmic-hero h1{font-family:'Instrument Serif',serif;font-weight:400;letter-spacing:-.02em;line-height:.92;margin:0}"
		. ".cosmic-hero{padding:70px 24px 110px;position:relative}"
		. "</style>\n";
}, 1 );

/* ----------------------------------------------------------------
 *  Register Gutenberg block-pattern category + patterns
 * -------------------------------------------------------------- */
add_action( 'init', function () {
	if ( ! function_exists( 'register_block_pattern_category' ) ) { return; }

	register_block_pattern_category( 'cosmic', array(
		'label' => __( 'Cosmic', 'cosmic-calculators' ),
	) );

	$patterns = array( 'home-hero', 'calculator-grid', 'how-it-works', 'big-cta', 'faq-block' );
	foreach ( $patterns as $slug ) {
		$file = COSMIC_THEME_DIR . "/patterns/{$slug}.php";
		if ( file_exists( $file ) ) {
			register_block_pattern( "cosmic/{$slug}", include $file );
		}
	}
} );

/* ----------------------------------------------------------------
 *  Cosmic chrome modules — bridge, schema, blocks
 * -------------------------------------------------------------- */
require_once COSMIC_THEME_DIR . '/inc/template-functions.php';
require_once COSMIC_THEME_DIR . '/inc/cosmic-bridge.php';
require_once COSMIC_THEME_DIR . '/inc/cosmic-schema.php';
require_once COSMIC_THEME_DIR . '/inc/cosmic-blocks.php';

/* ----------------------------------------------------------------
 *  Body classes — let CSS scope itself to calculator pages
 * -------------------------------------------------------------- */
add_filter( 'body_class', function ( $classes ) {
	$classes[] = 'cosmic-2026';

	if ( is_singular() ) {
		global $post;
		if ( ! $post ) { return $classes; }

		$tool_map = array(
			'love_calculator_pro'       => 'cosmic-page-love',
			'love_calculator'           => 'cosmic-page-love',
			'love_calculator_cosmic'    => 'cosmic-page-love',
			'flames_calculator_pro'     => 'cosmic-page-flames',
			'flames_calculator'         => 'cosmic-page-flames',
			'flames_calculator_cosmic'  => 'cosmic-page-flames',
			'crush_calculator'          => 'cosmic-page-crush',
			'crush_calculator_cosmic'   => 'cosmic-page-crush',
			'friendship_calculator'     => 'cosmic-page-friendship',
			'friendship_calculator_cosmic' => 'cosmic-page-friendship',
			'mulank_calculator'         => 'cosmic-page-mulank',
			'mulank_calculator_cosmic'  => 'cosmic-page-mulank',
		);
		foreach ( $tool_map as $sc => $cls ) {
			if ( has_shortcode( $post->post_content, $sc ) ) {
				$classes[] = $cls;
				$classes[] = 'cosmic-page-tool';
				break; // one tool per page
			}
		}
	}
	return $classes;
} );

/* ----------------------------------------------------------------
 *  Trim WordPress auto-paragraphs inside calculator shortcodes —
 *  the plugins emit their own structured markup and `wpautop`
 *  occasionally inserts stray <p> tags inside <details>/<svg>.
 * -------------------------------------------------------------- */
add_filter( 'the_content', function ( $content ) {
	$shortcodes = array(
		'love_calculator', 'love_calculator_pro', 'love_calculator_cosmic',
		'flames_calculator', 'flames_calculator_pro', 'flames_calculator_cosmic',
		'crush_calculator', 'crush_calculator_cosmic',
		'friendship_calculator', 'friendship_calculator_cosmic',
		'mulank_calculator', 'mulank_calculator_cosmic',
	);
	foreach ( $shortcodes as $sc ) {
		if ( false !== strpos( $content, '[' . $sc ) ) {
			remove_filter( 'the_content', 'wpautop' );
			break;
		}
	}
	return $content;
}, 8 );
