<?php
/**
 * Archive — `archive.php`
 *
 * Renders category, tag, author and date archives. Falls back to the
 * same grid layout used by index.php.
 *
 * @package Cosmic_Calculators
 */

get_header(); ?>

<section class="cosmic-archive cosmic-container" style="padding:80px 0 100px">

	<header class="cosmic-archive__header" style="margin-bottom:60px">
		<p class="cosmic-eyebrow"><span style="color:var(--cosmic-rose-2)">&#9670;</span>&nbsp;&nbsp;<?php esc_html_e( 'ARCHIVE', 'cosmic-calculators' ); ?></p>
		<h1 style="font-size:clamp(48px,7vw,84px);margin-top:14px"><?php the_archive_title(); ?></h1>
		<?php the_archive_description( '<p style="color:var(--cosmic-ink-60);font-size:17px;max-width:600px;margin-top:18px">', '</p>' ); ?>
	</header>

	<?php if ( have_posts() ) : ?>

		<div class="cosmic-post-grid" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:24px">
		<?php while ( have_posts() ) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'cosmic-glass' ); ?> style="padding:28px;border-radius:24px">
				<?php if ( has_post_thumbnail() ) : ?>
					<a href="<?php the_permalink(); ?>" style="display:block;margin:-28px -28px 18px;overflow:hidden;border-radius:24px 24px 0 0;aspect-ratio:16/9">
						<?php the_post_thumbnail( 'large', array( 'style' => 'width:100%;height:100%;object-fit:cover' ) ); ?>
					</a>
				<?php endif; ?>
				<p class="cosmic-eyebrow"><?php echo esc_html( get_the_date() ); ?></p>
				<h2 style="font-size:26px;margin:12px 0 14px">
					<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
				</h2>
				<div style="color:var(--cosmic-ink-60);font-size:15px;line-height:1.6"><?php the_excerpt(); ?></div>
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

		<p style="color:var(--cosmic-ink-60)"><?php esc_html_e( 'Nothing matched. Try a search.', 'cosmic-calculators' ); ?></p>
		<?php get_search_form(); ?>

	<?php endif; ?>

</section>

<?php
get_footer();
