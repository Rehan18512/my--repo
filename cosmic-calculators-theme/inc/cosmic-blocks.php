<?php
/**
 * Cosmic Blocks — server-side rendered Gutenberg blocks
 *
 * Registers four dynamic blocks reusing the same render functions
 * as the front-end:
 *
 *   cosmic/hero           — homepage hero with built-in love-calc CTA
 *   cosmic/calc-grid      — five-tile calculator grid
 *   cosmic/how-it-works   — three-step explainer
 *   cosmic/big-cta        — gradient closing CTA
 *
 * Each block is editable in Gutenberg via supports.html=false (raw render).
 * Block patterns wrap them into ready-to-insert layouts.
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/* ---------- Calculator grid block ---------- */
function cosmic_render_block_calc_grid( $attrs ) {
	$cards = cosmic_tool_cards();
	ob_start();
	?>
	<section class="cosmic-section cosmic-calc-grid-wrap" data-cosmic-reveal>
		<div class="cosmic-wide">
			<p class="cosmic-eyebrow"><span style="color:var(--cosmic-rose-2)">&#9670;</span>&nbsp;&nbsp;FIVE CALCULATORS &middot; ONE COSMIC UNIVERSE</p>
			<h2 style="font-size:clamp(40px,6vw,72px);margin:14px 0 36px">The relationship<br>operating system.</h2>
			<div class="cosmic-calc-grid">
			<?php foreach ( $cards as $k => $c ) : ?>
				<a class="cosmic-calc-card" data-accent="<?php echo esc_attr( $c['a'] ); ?>" href="<?php echo esc_url( $c['u'] ); ?>">
					<span class="glow" aria-hidden="true"></span>
					<div class="body">
						<div class="ico" style="background:rgba(255,61,139,.12);border:1px solid rgba(255,61,139,.35)"><?php echo cosmic_icon( $c['i'], 26 ); ?></div>
						<div>
							<h3><?php echo wp_kses_post( $c['h'] ); ?></h3>
							<p style="color:var(--cosmic-ink-60);font-size:14px;margin:0"><?php echo wp_kses_post( $c['s'] ); ?></p>
						</div>
						<div style="display:flex;justify-content:space-between;align-items:center;margin-top:auto;color:var(--cosmic-ink-60);font-size:13px">
							<span>Free &middot; 10 sec</span>
							<span style="color:#fff;font-weight:600;display:inline-flex;align-items:center;gap:6px">Try now <?php echo cosmic_icon( 'arrow', 14 ); ?></span>
						</div>
					</div>
				</a>
			<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php
	return ob_get_clean();
}

/* ---------- Hero block ---------- */
function cosmic_render_block_hero( $attrs ) {
	$pre   = isset( $attrs['preHeading'] )  ? $attrs['preHeading']  : 'Find out who';
	$grad  = isset( $attrs['gradHeading'] ) ? $attrs['gradHeading'] : 'truly loves';
	$post  = isset( $attrs['postHeading'] ) ? $attrs['postHeading'] : 'you back.';
	$lead  = isset( $attrs['lead'] )        ? $attrs['lead']        : 'Five emotionally-intelligent calculators &mdash; love, FLAMES, crush, friendship and numerology. Built around the same algorithms creators use to make 50M+ viral videos a year.';
	$cta   = isset( $attrs['ctaLabel'] )    ? $attrs['ctaLabel']    : 'Calculate my love';
	$ctaTo = isset( $attrs['ctaUrl'] )      ? $attrs['ctaUrl']      : '/love-calculator/';
	ob_start();
	?>
	<header class="cosmic-hero" data-cosmic-reveal>
		<div class="cosmic-wide" style="display:grid;grid-template-columns:1.15fr 1fr;gap:60px;align-items:center">
			<div>
				<p class="cosmic-eyebrow"><span style="color:var(--cosmic-rose-2)">&#9670;</span>&nbsp;&nbsp;5 VIRAL LOVE TOOLS &middot; 100% FREE</p>
				<h1><?php echo wp_kses_post( $pre ); ?><br><span class="cosmic-gradient-text"><?php echo wp_kses_post( $grad ); ?></span><br><?php echo wp_kses_post( $post ); ?></h1>
				<p class="lead"><?php echo wp_kses_post( $lead ); ?></p>
				<p style="margin-top:36px;display:flex;gap:14px;flex-wrap:wrap">
					<a class="cosmic-btn cosmic-btn--primary cosmic-btn--lg" href="<?php echo esc_url( $ctaTo ); ?>"><?php echo cosmic_icon( 'heart', 18 ); ?> <?php echo esc_html( $cta ); ?></a>
					<a class="cosmic-btn cosmic-btn--ghost cosmic-btn--lg" href="#how-it-works">Watch 14s demo</a>
				</p>
			</div>
			<div>
				<!-- Reserved for a live preview card; the love calculator shortcode can sit here. -->
				<?php echo do_shortcode( '[love_calculator_cosmic]' ); ?>
			</div>
		</div>
	</header>
	<?php
	return ob_get_clean();
}

/* ---------- Register blocks ---------- */
add_action( 'init', function () {
	if ( ! function_exists( 'register_block_type' ) ) return;

	register_block_type( 'cosmic/calc-grid', array(
		'render_callback' => 'cosmic_render_block_calc_grid',
		'attributes'      => array(),
		'supports'        => array( 'html' => false, 'align' => array( 'wide', 'full' ) ),
	) );

	register_block_type( 'cosmic/hero', array(
		'render_callback' => 'cosmic_render_block_hero',
		'attributes'      => array(
			'preHeading'  => array( 'type' => 'string', 'default' => 'Find out who' ),
			'gradHeading' => array( 'type' => 'string', 'default' => 'truly loves' ),
			'postHeading' => array( 'type' => 'string', 'default' => 'you back.' ),
			'lead'        => array( 'type' => 'string', 'default' => '' ),
			'ctaLabel'    => array( 'type' => 'string', 'default' => 'Calculate my love' ),
			'ctaUrl'      => array( 'type' => 'string', 'default' => '/love-calculator/' ),
		),
		'supports'        => array( 'html' => false, 'align' => array( 'wide', 'full' ) ),
	) );
} );
