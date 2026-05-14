<?php
/**
 * Main template — `index.php`
 *
 * The default WordPress fallback. Renders the post loop (blog index,
 * archives, search results when no more specific template exists).
 *
 * @package Cosmic_Calculators
 */

get_header(); ?>

<section class="cosmic-archive cosmic-container" style="padding:80px 0 100px">

	<?php if ( have_posts() ) : ?>

		<?php if ( is_home() && ! is_front_page() ) : ?>
			<header class="cosmic-archive__header" style="margin-bottom:60px">
				<p class="cosmic-eyebrow"><span style="color:var(--cosmic-rose-2)">&#9670;</span>&nbsp;&nbsp;<?php esc_html_e( 'JOURNAL', 'cosmic-calculators' ); ?></p>
				<h1 style="font-size:clamp(48px,7vw,84px);margin-top:14px"><?php single_post_title(); ?></h1>
			</header>
		<?php endif; ?>

		<div class="cosmic-post-grid" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:24px">

		<?php while ( have_posts() ) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class( 'cosmic-glass' ); ?> style="padding:28px;border-radius:24px">

				<?php if ( has_post_thumbnail() ) : ?>
					<a href="<?php the_permalink(); ?>" class="cosmic-post-thumb" style="display:block;margin:-28px -28px 18px;overflow:hidden;border-radius:24px 24px 0 0;aspect-ratio:16/9">
						<?php the_post_thumbnail( 'large', array( 'style' => 'width:100%;height:100%;object-fit:cover' ) ); ?>
					</a>
				<?php endif; ?>

				<p class="cosmic-eyebrow"><?php echo esc_html( get_the_date() ); ?></p>
				<h2 style="font-size:28px;margin:12px 0 14px">
					<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
				</h2>
				<div style="color:var(--cosmic-ink-60);font-size:15px;line-height:1.6">
					<?php the_excerpt(); ?>
				</div>
				<p style="margin-top:18px">
					<a class="cosmic-btn cosmic-btn--ghost" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read article', 'cosmic-calculators' ); ?> &rarr;</a>
				</p>
			</article>

		<?php endwhile; ?>

		</div>

		<nav class="cosmic-pagination" style="margin-top:60px;text-align:center" aria-label="<?php esc_attr_e( 'Posts', 'cosmic-calculators' ); ?>">
			<?php
			the_posts_pagination( array(
				'prev_text' => '&larr; ' . __( 'Newer', 'cosmic-calculators' ),
				'next_text' => __( 'Older', 'cosmic-calculators' ) . ' &rarr;',
			) );
			?>
		</nav>

	<?php else : ?>

		<div class="cosmic-glass" style="padding:60px;border-radius:32px;text-align:center">
			<h1 style="font-size:48px;margin:0 0 16px"><?php esc_html_e( 'Nothing here yet.', 'cosmic-calculators' ); ?></h1>
			<p style="color:var(--cosmic-ink-60)"><?php esc_html_e( 'Try a search, or head back home.', 'cosmic-calculators' ); ?></p>
			<p style="margin-top:24px"><?php get_search_form(); ?></p>
		</div>

	<?php endif; ?>

</section>

<?php
get_footer();
