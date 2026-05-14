<?php
/**
 * Comments template — `comments.php`
 *
 * @package Cosmic_Calculators
 */

if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="cosmic-comments cosmic-glass" style="padding:32px;border-radius:24px;margin-top:40px">

	<?php if ( have_comments() ) : ?>

		<h2 class="cosmic-comments__title" style="font-size:30px;margin:0 0 24px">
			<?php
			$count = get_comments_number();
			if ( '1' === $count ) {
				esc_html_e( '1 thought', 'cosmic-calculators' );
			} else {
				/* translators: %s: comment count */
				printf( esc_html( _n( '%s thought', '%s thoughts', $count, 'cosmic-calculators' ) ), number_format_i18n( $count ) );
			}
			?>
		</h2>

		<ol class="cosmic-comment-list" style="list-style:none;padding:0;margin:0">
			<?php
			wp_list_comments( array(
				'style'       => 'ol',
				'short_ping'  => true,
				'avatar_size' => 48,
			) );
			?>
		</ol>

		<?php
		the_comments_navigation( array(
			'prev_text' => '&larr; ' . __( 'Older comments', 'cosmic-calculators' ),
			'next_text' => __( 'Newer comments', 'cosmic-calculators' ) . ' &rarr;',
		) );
		?>

		<?php if ( ! comments_open() ) : ?>
			<p class="cosmic-comments__closed" style="color:var(--cosmic-ink-60);margin-top:24px"><?php esc_html_e( 'Comments are closed.', 'cosmic-calculators' ); ?></p>
		<?php endif; ?>

	<?php endif; ?>

	<?php
	comment_form( array(
		'title_reply'        => esc_html__( 'Leave a thought', 'cosmic-calculators' ),
		'title_reply_before' => '<h3 class="cosmic-comments__reply-title" style="font-size:26px;margin:32px 0 18px">',
		'title_reply_after'  => '</h3>',
		'class_form'         => 'cosmic-comment-form',
		'class_submit'       => 'cosmic-btn cosmic-btn--primary',
	) );
	?>

</div>
