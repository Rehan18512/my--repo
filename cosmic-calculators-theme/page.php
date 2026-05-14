<?php
/**
 * Single page — `page.php`
 *
 * Renders any "Page" post type. If the page's content embeds a
 * calculator shortcode (love_calculator_cosmic, mulank_calculator,
 * etc.), `cosmic-bridge.php` will wrap it in the Cosmic hero and
 * related-rail chrome automatically.
 *
 * @package Cosmic_Calculators
 */

get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'cosmic-page' ); ?>>

		<?php
		// We only show a title hero if the page does NOT begin with a calculator shortcode.
		// The Cosmic Bridge will render its own hero in that case.
		$first_chunk = trim( substr( get_the_content(), 0, 200 ) );
		$tool_shortcodes = array(
			'[love_calculator_cosmic', '[flames_calculator_cosmic', '[crush_calculator_cosmic',
			'[friendship_calculator_cosmic', '[mulank_calculator_cosmic',
			'[love_calculator_pro', '[love_calculator', '[flames_calculator_pro', '[flames_calculator',
			'[crush_calculator', '[friendship_calculator', '[mulank_calculator',
		);
		$has_tool_shortcode = false;
		foreach ( $tool_shortcodes as $sc ) {
			if ( false !== strpos( $first_chunk, $sc ) ) { $has_tool_shortcode = true; break; }
		}
		?>

		<?php if ( ! $has_tool_shortcode ) : ?>
			<header class="cosmic-page__header cosmic-container" style="padding:80px 0 30px">
				<p class="cosmic-eyebrow"><span style="color:var(--cosmic-rose-2)">&#9670;</span>&nbsp;&nbsp;<?php esc_html_e( 'COSMIC', 'cosmic-calculators' ); ?></p>
				<h1 style="font-size:clamp(48px,8vw,96px);margin-top:14px;line-height:.95"><?php the_title(); ?></h1>
				<?php if ( has_excerpt() ) : ?>
					<p style="color:var(--cosmic-ink-60);font-size:clamp(15px,1.4vw,19px);line-height:1.55;max-width:640px;margin-top:24px"><?php the_excerpt(); ?></p>
				<?php endif; ?>
			</header>
		<?php endif; ?>

		<div class="cosmic-page__body cosmic-container" style="padding:30px 0 80px;font-size:17px;line-height:1.7;color:var(--cosmic-ink-80)">
			<?php the_content(); ?>
			<?php
			wp_link_pages( array(
				'before' => '<p class="cosmic-page__links" style="margin-top:30px;font-family:var(--cosmic-f-mono);font-size:13px">' . esc_html__( 'Pages:', 'cosmic-calculators' ) . ' ',
				'after'  => '</p>',
			) );
			?>
		</div>

		<?php if ( comments_open() || get_comments_number() ) : ?>
			<div class="cosmic-page__comments cosmic-container" style="padding:0 0 80px"><?php comments_template(); ?></div>
		<?php endif; ?>

	</article>

<?php endwhile; ?>

<?php
get_footer();
