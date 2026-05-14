<?php
/**
 * Template Name: Calculator Page
 * Template Post Type: page
 *
 * Use this template for any page that hosts a calculator shortcode.
 * It hides the page title (the Cosmic Bridge renders its own hero)
 * and lets the calculator render edge-to-edge.
 *
 * @package Cosmic_Calculators
 */

get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'cosmic-page cosmic-page--calculator' ); ?>>
		<div class="cosmic-page__body" style="padding:0;font-size:17px;line-height:1.7;color:var(--cosmic-ink-80)">
			<?php the_content(); ?>
		</div>
	</article>
<?php endwhile; ?>

<?php
get_footer();
