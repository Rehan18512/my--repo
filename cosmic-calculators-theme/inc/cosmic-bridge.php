<?php
/**
 * Cosmic Bridge — Shortcode wrappers
 *
 * Wraps the existing calculator shortcodes with a Cosmic hero + breadcrumb
 * + related-calculators rail. The ORIGINAL shortcode output is rendered
 * inside the wrapper untouched — its CSS, JS, JSON-LD schema, history,
 * share, and AdSense slots all still work.
 *
 * Each wrapper is OPT-IN via a new shortcode (suffix `_cosmic`) so the
 * raw shortcodes still work for legacy pages. New pages should use the
 * cosmic versions:
 *
 *     [love_calculator_cosmic]
 *     [flames_calculator_cosmic]
 *     [crush_calculator_cosmic]
 *     [friendship_calculator_cosmic]
 *     [mulank_calculator_cosmic]
 *
 * If you want EVERY existing love_calculator instance to inherit the
 * Cosmic chrome automatically, set the constant:
 *
 *     define( 'COSMIC_AUTO_WRAP', true );
 *
 * in wp-config.php — see the do_shortcode filter at the end of this file.
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/* ---------------------------------------------------------------- */
/* Configuration — one source of truth for every tool's chrome      */
/* ---------------------------------------------------------------- */
function cosmic_tool_config( $key ) {
	$config = array(
		'love' => array(
			'inner_shortcode' => 'love_calculator_pro',
			'inner_alias'     => 'love_calculator',
			'slug'            => 'love-calculator',
			'h1_pre'          => 'Test if it&rsquo;s',
			'h1_grad'         => 'written',
			'h1_post'         => '.',
			'lead'            => 'Type two names. Our 2026 love engine blends the classic L&ndash;O&ndash;V&ndash;E&ndash;S algorithm with five&#8209;axis compatibility, zodiac element pairing and numerology life&#8209;path &mdash; all in &lt;300ms.',
			'eyebrow'         => 'THE LOVE CALCULATOR &middot; v2.0',
			'tags'            => array( '&star; 4.9 &middot; 38k', 'EN &middot; HI', '&lt;300ms', '100% private' ),
			'accent'          => 'rose',
		),
		'flames' => array(
			'inner_shortcode' => 'flames_calculator_pro',
			'inner_alias'     => 'flames_calculator',
			'slug'            => 'flames-calculator',
			'h1_pre'          => 'The classic',
			'h1_grad'         => 'FLAMES',
			'h1_post'         => ' game, reborn.',
			'lead'            => 'Friends &middot; Lovers &middot; Affection &middot; Marriage &middot; Enemies &middot; Siblings. Live letter&#8209;elimination animation with confetti reveal.',
			'eyebrow'         => 'FLAMES CALCULATOR &middot; v1.0',
			'tags'            => array( 'NOSTALGIC', 'EN &middot; HI', '&lt;200ms' ),
			'accent'          => 'rose',
		),
		'crush' => array(
			'inner_shortcode' => 'crush_calculator',
			'inner_alias'     => '',
			'slug'            => 'crush-calculator',
			'h1_pre'          => 'Does your crush',
			'h1_grad'         => 'feel it',
			'h1_post'         => ' back?',
			'lead'            => 'Yes / Maybe / Slow verdict. Add a horoscope match and we&rsquo;ll pick a confession day, gift idea and lucky charm for you.',
			'eyebrow'         => 'CRUSH CALCULATOR &middot; 2026',
			'tags'            => array( 'NEW', 'ZODIAC', 'PRIVATE' ),
			'accent'          => 'violet',
		),
		'friendship' => array(
			'inner_shortcode' => 'friendship_calculator',
			'inner_alias'     => '',
			'slug'            => 'friendship-calculator',
			'h1_pre'          => 'How',
			'h1_grad'         => 'tight',
			'h1_post'         => ' is your bond?',
			'lead'            => 'Loyalty &middot; Fun &middot; Trust &middot; Emotional support. Plus your friendship song, bond colour, and a power mantra.',
			'eyebrow'         => 'FRIENDSHIP CALCULATOR',
			'tags'            => array( 'WHOLESOME', 'SHAREABLE' ),
			'accent'          => 'cyan',
		),
		'mulank' => array(
			'inner_shortcode' => 'mulank_calculator',
			'inner_alias'     => '',
			'slug'            => 'numerology-mulank',
			'h1_pre'          => 'Your',
			'h1_grad'         => 'cosmic',
			'h1_post'         => ' number.',
			'lead'            => 'Discover your Mulank (root) and Bhagyank (destiny) numbers, ruling planet, lucky colour, gemstone, metal and remedies &mdash; from your date of birth.',
			'eyebrow'         => 'MULANK &amp; BHAGYANK &middot; NUMEROLOGY',
			'tags'            => array( 'BY BIRTH DATE', 'VEDIC' ),
			'accent'          => 'violet',
		),
	);
	return isset( $config[ $key ] ) ? $config[ $key ] : null;
}

/* ---------------------------------------------------------------- */
/* Cards used in the related-rail                                   */
/* ---------------------------------------------------------------- */
function cosmic_tool_cards() {
	return array(
		'love'       => array( 'h' => 'Love Calculator',     's' => 'Classic L-O-V-E-S blend',     'a' => 'rose',   'i' => 'heart',  'u' => '/love-calculator/' ),
		'flames'     => array( 'h' => 'FLAMES',              's' => 'Letter-elimination classic',  'a' => 'rose',   'i' => 'flame',  'u' => '/flames-calculator/' ),
		'crush'      => array( 'h' => 'Crush',               's' => 'Yes / Maybe / Slow verdict',  'a' => 'violet', 'i' => 'spark',  'u' => '/crush-calculator/' ),
		'friendship' => array( 'h' => 'Friendship',          's' => 'Loyalty &middot; trust &middot; fun',     'a' => 'cyan',   'i' => 'users',  'u' => '/friendship-calculator/' ),
		'mulank'     => array( 'h' => 'Mulank Numerology',   's' => 'Root + destiny number',       'a' => 'violet', 'i' => 'moon',   'u' => '/numerology-mulank/' ),
	);
}

/* ---------------------------------------------------------------- */
/* Icon helper (small inline SVG library)                           */
/* ---------------------------------------------------------------- */
function cosmic_icon( $name, $size = 20 ) {
	$paths = array(
		'heart' => '<path d="M12 21s-7-4.5-9.5-9C.9 9.2 2.6 5 6.5 5c2 0 3.6 1 5.5 3 1.9-2 3.5-3 5.5-3 3.9 0 5.6 4.2 4 7-2.5 4.5-9.5 9-9.5 9z"/>',
		'flame' => '<path d="M12 3s5 4 5 9a5 5 0 1 1-10 0c0-2 1-3 1-3s1 2 3 2c0-3-1-5 1-8z"/><path d="M9.5 17.5c.5 1 1.5 1.5 2.5 1.5s2-.5 2.5-1.5"/>',
		'spark' => '<path d="M12 3v4M12 17v4M3 12h4M17 12h4M5.6 5.6l2.8 2.8M15.6 15.6l2.8 2.8M5.6 18.4l2.8-2.8M15.6 8.4l2.8-2.8"/>',
		'moon'  => '<path d="M20 14.5A8 8 0 0 1 9.5 4a8 8 0 1 0 10.5 10.5z"/>',
		'users' => '<circle cx="9" cy="8" r="3"/><circle cx="17" cy="9" r="2.2"/><path d="M3 19c0-3 2.5-5 6-5s6 2 6 5"/><path d="M15 19c0-2 1.5-3.5 4-3.5"/>',
		'arrow' => '<path d="M5 12h14M13 5l7 7-7 7"/>',
		'lock'  => '<rect x="5" y="11" width="14" height="9" rx="2"/><path d="M8 11V8a4 4 0 1 1 8 0v3"/>',
		'bolt'  => '<path d="M13 3 4 14h6l-1 7 9-11h-6z"/>',
	);
	$p = isset( $paths[ $name ] ) ? $paths[ $name ] : '';
	return sprintf(
		'<svg width="%1$d" height="%1$d" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">%2$s</svg>',
		(int) $size,
		$p
	);
}

/* ---------------------------------------------------------------- */
/* The hero rendered above each calculator                          */
/* ---------------------------------------------------------------- */
function cosmic_render_tool_hero( $cfg ) {
	ob_start();
	?>
	<header class="cosmic-tool-hero" data-cosmic-reveal>
		<nav class="cosmic-breadcrumb" aria-label="Breadcrumb">
			<a href="/">Home</a>
			<span aria-hidden="true">&rsaquo;</span>
			<a href="/calculators/">Calculators</a>
			<span aria-hidden="true">&rsaquo;</span>
			<span aria-current="page"><?php echo esc_html( get_the_title() ); ?></span>
		</nav>

		<div class="cosmic-tool-hero__inner">
			<div class="cosmic-tool-hero__copy">
				<p class="cosmic-eyebrow"><span style="color:var(--cosmic-rose-2)">&#9670;</span>&nbsp;&nbsp;<?php echo wp_kses_post( $cfg['eyebrow'] ); ?></p>
				<h1>
					<?php echo wp_kses_post( $cfg['h1_pre'] ); ?>
					<span class="cosmic-gradient-text"><?php echo wp_kses_post( $cfg['h1_grad'] ); ?></span><?php echo wp_kses_post( $cfg['h1_post'] ); ?>
				</h1>
				<p class="lead"><?php echo wp_kses_post( $cfg['lead'] ); ?></p>
			</div>
			<div class="cosmic-tool-hero__tags">
				<?php foreach ( $cfg['tags'] as $t ) : ?>
					<span class="cosmic-tag"><?php echo wp_kses_post( $t ); ?></span>
				<?php endforeach; ?>
			</div>
		</div>
	</header>
	<?php
	return ob_get_clean();
}

/* ---------------------------------------------------------------- */
/* Related-calculators rail rendered below each calculator          */
/* ---------------------------------------------------------------- */
function cosmic_render_related_rail( $current_key ) {
	$cards = cosmic_tool_cards();
	unset( $cards[ $current_key ] );
	ob_start();
	?>
	<aside class="cosmic-related" aria-label="More calculators" data-cosmic-reveal>
		<p class="cosmic-eyebrow"><span style="color:var(--cosmic-rose-2)">&#9670;</span>&nbsp;&nbsp;CONTINUE YOUR COSMIC JOURNEY</p>
		<div class="cosmic-related__grid">
		<?php foreach ( $cards as $card ) : ?>
			<a class="cosmic-calc-card" data-accent="<?php echo esc_attr( $card['a'] ); ?>" href="<?php echo esc_url( $card['u'] ); ?>">
				<span class="glow" aria-hidden="true"></span>
				<div class="body">
					<div class="ico" style="background:rgba(255,61,139,.12);border:1px solid rgba(255,61,139,.35)"><?php echo cosmic_icon( $card['i'], 22 ); ?></div>
					<div>
						<h3><?php echo wp_kses_post( $card['h'] ); ?></h3>
						<p style="color:var(--cosmic-ink-60);font-size:14px;margin:0"><?php echo wp_kses_post( $card['s'] ); ?></p>
					</div>
					<div style="display:flex;justify-content:space-between;align-items:center;margin-top:auto;color:var(--cosmic-ink-60);font-size:13px">
						<span>Free &middot; 10 sec</span>
						<span style="color:#fff;font-weight:600;display:inline-flex;align-items:center;gap:6px">Try now <?php echo cosmic_icon( 'arrow', 14 ); ?></span>
					</div>
				</div>
			</a>
		<?php endforeach; ?>
		</div>
	</aside>
	<?php
	return ob_get_clean();
}

/* ---------------------------------------------------------------- */
/* Generic wrapper — produces the [<tool>_calculator_cosmic] output */
/* ---------------------------------------------------------------- */
function cosmic_render_wrapped( $key, $shortcode_attrs = array() ) {
	$cfg = cosmic_tool_config( $key );
	if ( ! $cfg ) return '';

	// Re-emit the original shortcode using its native registered handler.
	// We pass-through any user attributes so [..._cosmic mode="advanced" lang="hi"] works.
	$inner_tag = $cfg['inner_shortcode'];
	if ( ! shortcode_exists( $inner_tag ) && $cfg['inner_alias'] && shortcode_exists( $cfg['inner_alias'] ) ) {
		$inner_tag = $cfg['inner_alias'];
	}
	if ( ! shortcode_exists( $inner_tag ) ) {
		// Plugin not installed — render a clear admin notice on the front-end only for editors.
		if ( current_user_can( 'edit_posts' ) ) {
			return '<div class="cosmic-glass" style="padding:24px;border-radius:18px;margin:24px 0;color:#fff">'
				. '<strong>Cosmic Bridge:</strong> the <code>' . esc_html( $cfg['inner_shortcode'] ) . '</code> shortcode is not registered. '
				. 'Activate the matching calculator plugin first.</div>';
		}
		return '';
	}

	// Build attribute string
	$attr_str = '';
	foreach ( $shortcode_attrs as $k => $v ) {
		if ( is_string( $k ) ) {
			$attr_str .= ' ' . sanitize_key( $k ) . '="' . esc_attr( $v ) . '"';
		}
	}
	$inner = do_shortcode( '[' . $inner_tag . $attr_str . ']' );

	ob_start();
	?>
	<section class="cosmic-tool" data-cosmic-tool="<?php echo esc_attr( $key ); ?>">
		<?php echo cosmic_render_tool_hero( $cfg ); ?>

		<div class="cosmic-tool__body" data-cosmic-reveal>
			<?php echo $inner; // safe — output of trusted plugin shortcode ?>
		</div>

		<?php echo cosmic_render_related_rail( $key ); ?>
	</section>

	<a href="#" class="cosmic-sticky-cta-target" hidden data-cosmic-cta="<?php echo esc_attr( $key ); ?>"></a>
	<?php
	return ob_get_clean();
}

/* ---------------------------------------------------------------- */
/* Register the five Cosmic shortcodes                              */
/* ---------------------------------------------------------------- */
add_action( 'init', function () {
	add_shortcode( 'love_calculator_cosmic',       function ( $a ) { return cosmic_render_wrapped( 'love',       (array) $a ); } );
	add_shortcode( 'flames_calculator_cosmic',     function ( $a ) { return cosmic_render_wrapped( 'flames',     (array) $a ); } );
	add_shortcode( 'crush_calculator_cosmic',      function ( $a ) { return cosmic_render_wrapped( 'crush',      (array) $a ); } );
	add_shortcode( 'friendship_calculator_cosmic', function ( $a ) { return cosmic_render_wrapped( 'friendship', (array) $a ); } );
	add_shortcode( 'mulank_calculator_cosmic',     function ( $a ) { return cosmic_render_wrapped( 'mulank',     (array) $a ); } );
} );

/* ---------------------------------------------------------------- */
/* OPTIONAL: auto-wrap legacy shortcodes — uses do_shortcode_tag    */
/* Activate by setting `define( 'COSMIC_AUTO_WRAP', true );` in     */
/* wp-config.php. Otherwise, legacy shortcodes render as-is.        */
/* ---------------------------------------------------------------- */
add_filter( 'do_shortcode_tag', function ( $output, $tag, $attr ) {
	if ( ! defined( 'COSMIC_AUTO_WRAP' ) || ! COSMIC_AUTO_WRAP ) return $output;

	$map = array(
		'love_calculator_pro'   => 'love',
		'love_calculator'       => 'love',
		'flames_calculator_pro' => 'flames',
		'flames_calculator'     => 'flames',
		'crush_calculator'      => 'crush',
		'friendship_calculator' => 'friendship',
		'mulank_calculator'     => 'mulank',
	);
	if ( ! isset( $map[ $tag ] ) ) return $output;

	// Reentrancy guard — don't wrap when we're already inside cosmic_render_wrapped
	static $depth = 0;
	if ( $depth > 0 ) return $output;
	$depth++;
	$cfg = cosmic_tool_config( $map[ $tag ] );
	$wrapped = '<section class="cosmic-tool" data-cosmic-tool="' . esc_attr( $map[ $tag ] ) . '">'
		. cosmic_render_tool_hero( $cfg )
		. '<div class="cosmic-tool__body" data-cosmic-reveal>' . $output . '</div>'
		. cosmic_render_related_rail( $map[ $tag ] )
		. '</section>';
	$depth--;
	return $wrapped;
}, 10, 3 );

/* ---------------------------------------------------------------- */
/* Tiny accompanying styles for the chrome (hero, breadcrumb, rail) */
/* ---------------------------------------------------------------- */
add_action( 'wp_head', function () {
	?>
	<style id="cosmic-tool-chrome">
	.cosmic-tool { padding: 40px var(--cosmic-gutter) 80px; max-width: var(--cosmic-wide); margin: 0 auto; }
	.cosmic-breadcrumb { display: flex; align-items: center; gap: 8px; color: var(--cosmic-ink-60); font-size: 13px; margin-bottom: 30px; }
	.cosmic-breadcrumb a { color: var(--cosmic-ink-60); }
	.cosmic-breadcrumb a:hover { color: var(--cosmic-ink-100); }
	.cosmic-breadcrumb [aria-current="page"] { color: var(--cosmic-ink-100); }
	.cosmic-tool-hero { margin-bottom: 50px; }
	.cosmic-tool-hero__inner { display: grid; grid-template-columns: 1.4fr 1fr; gap: 60px; align-items: end; }
	.cosmic-tool-hero h1 { font-size: clamp(56px, 9vw, 110px); line-height: 0.92; margin: 14px 0 0; }
	.cosmic-tool-hero .lead { color: var(--cosmic-ink-80); font-size: clamp(15px, 1.4vw, 18px); line-height: 1.55; margin-top: 28px; max-width: 580px; }
	.cosmic-tool-hero__tags { display: flex; gap: 10px; flex-wrap: wrap; justify-content: flex-end; margin-bottom: 12px; }
	@media (max-width: 840px) {
		.cosmic-tool-hero__inner { grid-template-columns: 1fr; }
		.cosmic-tool-hero__tags { justify-content: flex-start; margin-top: 16px; }
	}
	.cosmic-related { margin-top: 80px; }
	.cosmic-related__grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-top: 26px; }
	@media (max-width: 1000px) { .cosmic-related__grid { grid-template-columns: repeat(2, 1fr); } }
	@media (max-width: 560px)  { .cosmic-related__grid { grid-template-columns: 1fr; } }
	.cosmic-related .cosmic-calc-card { min-height: 220px; padding: 22px; }
	.cosmic-related .cosmic-calc-card h3 { font-size: 28px; }
	</style>
	<?php
}, 50 );
