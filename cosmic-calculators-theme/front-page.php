<?php
/**
 * Homepage — `front-page.php`
 *
 * Renders the cosmic-branded homepage out of the box. If the site
 * admin sets a static front page via Settings > Reading, that page's
 * content is shown instead of (or below) this template.
 *
 * The hero, calculator grid, "how it works", FAQ and big CTA all
 * use the same patterns / blocks that ship with the theme.
 *
 * @package Cosmic_Calculators
 */

get_header(); ?>

<?php if ( have_posts() ) : the_post(); ?>

	<?php if ( trim( get_the_content() ) !== '' ) : ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'cosmic-front-page-content' ); ?>>
			<?php the_content(); ?>
		</article>
	<?php else : ?>

		<?php /* Default Cosmic homepage — visible when the front page has no content. */ ?>
		<?php echo do_blocks( '<!-- wp:cosmic/hero {"align":"full"} /-->' ); ?>
		<?php echo do_blocks( '<!-- wp:cosmic/calc-grid {"align":"wide"} /-->' ); ?>

		<?php
		// How-It-Works pattern
		$how_it_works = COSMIC_THEME_DIR . '/patterns/how-it-works.php';
		if ( file_exists( $how_it_works ) ) {
			$p = include $how_it_works;
			if ( ! empty( $p['content'] ) ) {
				echo '<div class="cosmic-wide">' . do_blocks( $p['content'] ) . '</div>';
			}
		}

		// FAQ pattern
		$faq = COSMIC_THEME_DIR . '/patterns/faq-block.php';
		if ( file_exists( $faq ) ) {
			$p = include $faq;
			if ( ! empty( $p['content'] ) ) {
				echo '<div class="cosmic-wide">' . do_blocks( $p['content'] ) . '</div>';
			}
		}

		// Big CTA pattern
		$cta = COSMIC_THEME_DIR . '/patterns/big-cta.php';
		if ( file_exists( $cta ) ) {
			$p = include $cta;
			if ( ! empty( $p['content'] ) ) {
				echo '<div class="cosmic-wide">' . do_blocks( $p['content'] ) . '</div>';
			}
		}
		?>

	<?php endif; ?>

<?php endif; ?>

<?php
get_footer();
