<?php
/**
 * 404 page — `404.php`
 *
 * @package Cosmic_Calculators
 */

get_header(); ?>

<section class="cosmic-404 cosmic-container" style="padding:120px 0 140px;text-align:center;max-width:780px">

	<p class="cosmic-eyebrow"><span style="color:var(--cosmic-rose-2)">&#9670;</span>&nbsp;&nbsp;<?php esc_html_e( '404 &middot; LOST IN SPACE', 'cosmic-calculators' ); ?></p>
	<h1 class="cosmic-gradient-text" style="font-size:clamp(96px,18vw,220px);line-height:.85;margin:30px 0 14px">404</h1>
	<h2 style="font-size:clamp(32px,5vw,56px);margin:0 0 18px"><?php esc_html_e( 'This star isn\'t on the map.', 'cosmic-calculators' ); ?></h2>
	<p style="color:var(--cosmic-ink-60);font-size:17px;line-height:1.6;margin:0 auto 36px;max-width:520px">
		<?php esc_html_e( 'The page you were looking for has drifted into another dimension. Try the search below, or head back home.', 'cosmic-calculators' ); ?>
	</p>

	<div style="display:flex;justify-content:center;gap:14px;flex-wrap:wrap;margin-bottom:40px">
		<a class="cosmic-btn cosmic-btn--primary cosmic-btn--lg" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Take me home', 'cosmic-calculators' ); ?></a>
		<a class="cosmic-btn cosmic-btn--ghost cosmic-btn--lg" href="<?php echo esc_url( home_url( '/love-calculator/' ) ); ?>"><?php esc_html_e( 'Try love test', 'cosmic-calculators' ); ?></a>
	</div>

	<?php get_search_form(); ?>

</section>

<?php
get_footer();
