<?php
/**
 * Template Name: Full Width Page
 * Template Post Type: page
 *
 * Full-bleed page (no container) — useful for landing pages built
 * with full-width Gutenberg blocks.
 *
 * @package Cosmic_Calculators
 */

get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'cosmic-page cosmic-page--full' ); ?>>
		<?php the_content(); ?>
	</article>
<?php endwhile; ?>

<?php
get_footer();
