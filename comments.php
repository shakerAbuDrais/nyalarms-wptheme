<?php
/**
 * Comments template.
 *
 * @package NYAS
 */

if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area" style="margin-top:32px">
	<?php if ( have_comments() ) : ?>
		<h2 class="display-md" style="margin-bottom:24px">
			<?php
			$count = get_comments_number();
			printf(
				/* translators: %s: comment count. */
				esc_html( _n( '%s comment', '%s comments', $count, 'nyas' ) ),
				esc_html( number_format_i18n( $count ) )
			);
			?>
		</h2>

		<ol class="comment-list" style="list-style:none;padding:0;margin:0 0 32px">
			<?php
			wp_list_comments( array(
				'style'      => 'ol',
				'short_ping' => true,
				'avatar_size'=> 44,
			) );
			?>
		</ol>

		<?php
		the_comments_pagination( array(
			'prev_text' => '&larr; ' . __( 'Older', 'nyas' ),
			'next_text' => __( 'Newer', 'nyas' ) . ' &rarr;',
		) );
		?>
	<?php endif; ?>

	<?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<p class="muted"><?php esc_html_e( 'Comments are closed.', 'nyas' ); ?></p>
	<?php endif; ?>

	<?php
	comment_form( array(
		'class_form'  => 'comment-form',
		'title_reply' => __( 'Leave a comment', 'nyas' ),
	) );
	?>
</div>
