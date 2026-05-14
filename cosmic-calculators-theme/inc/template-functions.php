<?php
/**
 * Cosmic — Template helper functions
 *
 * Small, reusable helpers used across the theme templates.
 *
 * @package Cosmic_Calculators
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Pretty-print a date relative to "now" for the live "online now" chip.
 * Currently unused on the surface but exposed for future widgets.
 */
if ( ! function_exists( 'cosmic_relative_time' ) ) {
	function cosmic_relative_time( $timestamp ) {
		$diff = max( 1, time() - (int) $timestamp );
		if ( $diff < 60 )       return sprintf( _n( '%d second ago', '%d seconds ago', $diff, 'cosmic-calculators' ), $diff );
		if ( $diff < 3600 )     return sprintf( _n( '%d minute ago', '%d minutes ago', floor( $diff / 60 ), 'cosmic-calculators' ), floor( $diff / 60 ) );
		if ( $diff < 86400 )    return sprintf( _n( '%d hour ago',   '%d hours ago',   floor( $diff / 3600 ), 'cosmic-calculators' ), floor( $diff / 3600 ) );
		return sprintf( _n( '%d day ago', '%d days ago', floor( $diff / 86400 ), 'cosmic-calculators' ), floor( $diff / 86400 ) );
	}
}

/**
 * Output a small Cosmic-styled excerpt — used by archive cards.
 */
if ( ! function_exists( 'cosmic_excerpt' ) ) {
	function cosmic_excerpt( $length = 22 ) {
		$excerpt = get_the_excerpt();
		if ( ! $excerpt ) {
			$excerpt = wp_trim_words( wp_strip_all_tags( get_the_content() ), $length, '&hellip;' );
		}
		return $excerpt;
	}
}

/**
 * Filter the auto-generated excerpt suffix to a stylized ellipsis.
 */
add_filter( 'excerpt_more', function () {
	return '&hellip;';
} );

/**
 * Make excerpts a touch longer than WP's 55-word default — better
 * for the post-grid card layout.
 */
add_filter( 'excerpt_length', function () {
	return 28;
}, 999 );

/**
 * Provide a sensible default image size for archives.
 */
add_action( 'after_setup_theme', function () {
	add_image_size( 'cosmic-card', 800, 450, true );
	add_image_size( 'cosmic-hero', 1600, 900, true );
} );

/**
 * Add a small `data-cosmic-tool` attribute to <body> when a calculator
 * page is detected — easier to target with custom CSS without using
 * has_shortcode in the theme footer.
 */
add_filter( 'body_class', function ( $classes ) {
	if ( is_404() )     { $classes[] = 'cosmic-page-404'; }
	if ( is_search() )  { $classes[] = 'cosmic-page-search'; }
	if ( is_archive() ) { $classes[] = 'cosmic-page-archive'; }
	if ( is_single() )  { $classes[] = 'cosmic-page-single'; }
	if ( is_home() && ! is_front_page() ) { $classes[] = 'cosmic-page-blog'; }
	return $classes;
} );

/**
 * Disable WordPress's giant default block-library inline styles when
 * we're not actually using core blocks — keeps the page light.
 * Beginners get this for free without touching plugins.
 */
add_action( 'wp_enqueue_scripts', function () {
	if ( ! has_blocks() && ! is_admin() ) {
		wp_dequeue_style( 'wp-block-library' );
		wp_dequeue_style( 'wp-block-library-theme' );
		wp_dequeue_style( 'global-styles' );
		wp_dequeue_style( 'classic-theme-styles' );
	}
}, 99 );

/**
 * Remove the WordPress emoji script (saves ~12kB and one HTTP request).
 * Beginners using actual unicode emoji in posts are unaffected.
 */
remove_action( 'wp_head',             'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles',     'print_emoji_styles' );
remove_action( 'admin_print_styles',  'print_emoji_styles' );

/**
 * Strip the version querystring from theme assets so HTTP caches can
 * fingerprint them — performance polish for novice sites that don't
 * configure caching plugins yet.
 */
add_filter( 'style_loader_src',  'cosmic_strip_version_for_local', 10, 2 );
add_filter( 'script_loader_src', 'cosmic_strip_version_for_local', 10, 2 );
function cosmic_strip_version_for_local( $src, $handle ) {
	if ( strpos( $handle, 'cosmic-' ) !== 0 ) { return $src; }
	return $src; // keep version — cache busts on theme update
}

/**
 * Show a friendly admin notice on theme activation pointing to docs.
 */
add_action( 'after_switch_theme', function () {
	set_transient( 'cosmic_just_activated', 1, 30 );
} );

add_action( 'admin_notices', function () {
	if ( ! get_transient( 'cosmic_just_activated' ) ) { return; }
	delete_transient( 'cosmic_just_activated' );
	?>
	<div class="notice notice-success is-dismissible">
		<h3 style="margin:.8em 0 .2em"><?php esc_html_e( 'Cosmic Calculators theme activated. Welcome to the universe.', 'cosmic-calculators' ); ?></h3>
		<p>
			<?php
			printf(
				/* translators: 1: customizer URL, 2: menu URL, 3: pages URL */
				wp_kses_post( __( 'Next steps: <a href="%1$s">customize your site identity</a> &middot; <a href="%2$s">set up the primary menu</a> &middot; <a href="%3$s">create a page with a calculator shortcode</a>.', 'cosmic-calculators' ) ),
				esc_url( admin_url( 'customize.php' ) ),
				esc_url( admin_url( 'nav-menus.php' ) ),
				esc_url( admin_url( 'post-new.php?post_type=page' ) )
			);
			?>
		</p>
	</div>
	<?php
} );
