<?php
/**
 * Search results — `search.php`
 *
 * @package Cosmic_Calculators
 */

get_header(); ?>

<section class="cosmic-search cosmic-container" style="padding:80px 0 100px">

	<header style="margin-bottom:40px">
		<p class="cosmic-eyebrow"><span style="color:var(--cosmic-rose-2)">&#9670;</span>&nbsp;&nbsp;<?php esc_html_e( 'SEARCH', 'cosmic-calculators' ); ?></p>
		<h1 style="font-size:clamp(40px,6vw,72px);margin-top:14px">
			<?php
			/* translators: %s: search query */
			printf( esc_html__( 'Results for %s', 'cosmic-calculators' ), '<span class="cosmic-gradient-text">' . esc_html( get_search_query() ) . '</span>' );
			?>
		</h1>
	</header>

	<div style="margin-bottom:40px"><?php get_search_form(); ?></div>

	<?php if ( have_posts() ) : ?>
		<div class="cosmic-post-grid" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:24px">
		<?php while ( have_posts() ) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'cosmic-glass' ); ?> style="padding:28px;border-radius:24px">
				<p class="cosmic-eyebrow"><?php echo esc_html( get_the_date() ); ?> &middot; <?php echo esc_html( get_post_type() ); ?></p>
				<h2 style="font-size:24px;margin:10px 0 12px">
					<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
				</h2>
				<div style="color:var(--cosmic-ink-60);font-size:15px;line-height:1.6"><?php the_excerpt(); ?></div>
			</article>
		<?php endwhile; ?>
		</div>

		<nav class="cosmic-pagination" style="margin-top:60px;text-align:center" aria-label="<?php esc_attr_e( 'Posts', 'cosmic-calculators' ); ?>">
			<?php the_posts_pagination(); ?>
		</nav>
	<?php else : ?>
		<p style="color:var(--cosmic-ink-60)"><?php esc_html_e( 'No matches. Try different keywords.', 'cosmic-calculators' ); ?></p>
	<?php endif; ?>

</section>

<?php
get_footer();
