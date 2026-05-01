<?php
/**
 * Fallback template — defers to home.php for blog listings.
 *
 * @package NYAS
 */

get_header();
?>

<section style="padding:72px 0 96px">
	<div class="container">
		<?php if ( have_posts() ) : ?>
			<h1 class="display-lg" style="margin-bottom:48px"><?php
				if ( is_category() ) {
					single_cat_title();
				} elseif ( is_tag() ) {
					single_tag_title();
				} elseif ( is_author() ) {
					echo esc_html__( 'Posts by ', 'nyas' );
					the_author();
				} elseif ( is_search() ) {
					/* translators: %s: search query. */
					printf( esc_html__( 'Search: %s', 'nyas' ), esc_html( get_search_query() ) );
				} else {
					esc_html_e( 'Latest', 'nyas' );
				}
			?></h1>

			<div class="grid grid-3">
				<?php while ( have_posts() ) : the_post(); ?>
					<a href="<?php the_permalink(); ?>" class="card" style="text-decoration:none;color:inherit;padding:0;overflow:hidden;display:flex;flex-direction:column">
						<?php if ( has_post_thumbnail() ) : ?>
							<?php nyas_photo( get_the_post_thumbnail_url( null, 'nyas-card' ), get_the_title(), 'aspect-ratio:4/3;border-radius:0' ); ?>
						<?php endif; ?>
						<div style="padding:24px;display:flex;flex-direction:column;gap:10px;flex:1">
							<h3 style="font-family:var(--ff-display);font-weight:700;font-size:22px;line-height:1.15;letter-spacing:-0.01em"><?php the_title(); ?></h3>
							<p style="margin:0;font-size:14px;color:var(--fg-2)"><?php echo esc_html( get_the_excerpt() ); ?></p>
							<div style="margin-top:auto;padding-top:16px;border-top:1px solid var(--border);font-size:12px;color:var(--fg-3);font-family:var(--ff-mono)"><?php echo esc_html( get_the_date() ); ?></div>
						</div>
					</a>
				<?php endwhile; ?>
			</div>

			<div style="margin-top:48px;text-align:center">
				<?php
				echo paginate_links( array( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					'prev_text' => '&larr; ' . __( 'Previous', 'nyas' ),
					'next_text' => __( 'Next', 'nyas' ) . ' &rarr;',
				) );
				?>
			</div>
		<?php else : ?>
			<p class="muted" style="font-size:18px;text-align:center;padding:48px"><?php esc_html_e( 'Nothing here yet.', 'nyas' ); ?></p>
		<?php endif; ?>
	</div>
</section>

<?php get_footer();
