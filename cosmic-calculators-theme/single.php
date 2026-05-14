<?php
/**
 * Single post — `single.php`
 *
 * Renders an individual blog post with the Cosmic hero treatment,
 * featured image hero, post content, post navigation and comments.
 *
 * @package Cosmic_Calculators
 */

get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'cosmic-single' ); ?>>

		<header class="cosmic-single__header cosmic-container" style="padding:80px 0 30px;max-width:840px">
			<p class="cosmic-eyebrow">
				<span style="color:var(--cosmic-rose-2)">&#9670;</span>&nbsp;&nbsp;<?php echo esc_html( get_the_date() ); ?>
			</p>
			<h1 style="font-size:clamp(40px,6vw,80px);margin-top:14px;line-height:1"><?php the_title(); ?></h1>
			<p style="color:var(--cosmic-ink-60);font-size:14px;margin-top:18px;font-family:var(--cosmic-f-mono)">
				<?php printf( esc_html__( 'By %s', 'cosmic-calculators' ), esc_html( get_the_author() ) ); ?> &middot;
				<?php echo esc_html( get_the_category_list( ', ' ) ); ?>
			</p>
		</header>

		<?php if ( has_post_thumbnail() ) : ?>
			<div class="cosmic-single__thumb cosmic-container" style="padding:0;margin:40px auto;max-width:1100px">
				<?php the_post_thumbnail( 'full', array( 'style' => 'width:100%;height:auto;border-radius:32px;box-shadow:0 24px 80px rgba(0,0,0,.55)' ) ); ?>
			</div>
		<?php endif; ?>

		<div class="cosmic-single__body cosmic-container" style="max-width:780px;padding:0 0 60px;font-size:18px;line-height:1.75;color:var(--cosmic-ink-80)">
			<?php
			the_content();
			wp_link_pages( array(
				'before' => '<p class="cosmic-single__links" style="margin-top:30px;font-family:var(--cosmic-f-mono);font-size:13px">' . esc_html__( 'Pages:', 'cosmic-calculators' ) . ' ',
				'after'  => '</p>',
			) );
			?>
		</div>

		<?php if ( has_tag() ) : ?>
			<div class="cosmic-single__tags cosmic-container" style="max-width:780px;padding:0 0 40px;display:flex;flex-wrap:wrap;gap:8px">
				<?php
				$tags = get_the_tags();
				if ( $tags ) {
					foreach ( $tags as $t ) {
						echo '<a class="cosmic-tag" href="' . esc_url( get_tag_link( $t->term_id ) ) . '">#' . esc_html( $t->name ) . '</a>';
					}
				}
				?>
			</div>
		<?php endif; ?>

		<nav class="cosmic-single__nav cosmic-container" style="max-width:780px;padding:0 0 60px;display:flex;justify-content:space-between;gap:20px;flex-wrap:wrap" aria-label="<?php esc_attr_e( 'Posts', 'cosmic-calculators' ); ?>">
			<?php
			$prev = get_previous_post_link( '<div class="cosmic-glass" style="padding:18px 22px;border-radius:18px;flex:1">&larr; %link</div>', '%title' );
			$next = get_next_post_link(     '<div class="cosmic-glass" style="padding:18px 22px;border-radius:18px;flex:1;text-align:right">%link &rarr;</div>', '%title' );
			echo $prev;
			echo $next;
			?>
		</nav>

		<?php if ( comments_open() || get_comments_number() ) : ?>
			<div class="cosmic-single__comments cosmic-container" style="max-width:780px;padding:0 0 80px"><?php comments_template(); ?></div>
		<?php endif; ?>

	</article>

<?php endwhile; ?>

<?php
get_footer();
