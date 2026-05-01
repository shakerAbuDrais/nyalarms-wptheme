<?php
/**
 * Category / tag / archive template — uses index layout.
 *
 * @package NYAS
 */

get_header();
?>

<section style="padding:72px 0 32px">
	<div class="container">
		<?php nyas_eyebrow( __( 'Insights', 'nyas' ), true, 'margin-bottom:20px' ); ?>
		<h1 class="display-xl"><?php
			if ( is_category() ) {
				single_cat_title();
			} elseif ( is_tag() ) {
				single_tag_title();
			} elseif ( is_author() ) {
				the_author();
			} else {
				the_archive_title();
			}
		?></h1>
		<?php if ( category_description() ) : ?>
			<div class="lede" style="max-width:680px;margin-top:16px"><?php echo wp_kses_post( category_description() ); ?></div>
		<?php endif; ?>
	</div>
</section>

<section style="padding:64px 0 96px">
	<div class="container">
		<?php if ( have_posts() ) : ?>
			<div class="grid grid-3">
				<?php while ( have_posts() ) : the_post();
					$cat = get_the_category();
					$cat_name = $cat ? $cat[0]->name : __( 'Insights', 'nyas' );
					?>
					<a href="<?php the_permalink(); ?>" class="card" style="text-decoration:none;color:inherit;padding:0;overflow:hidden;display:flex;flex-direction:column">
						<?php if ( has_post_thumbnail() ) : ?>
							<?php nyas_photo( get_the_post_thumbnail_url( null, 'nyas-card' ), get_the_title(), 'aspect-ratio:4/3;border-radius:0;border-bottom:1px solid var(--border)' ); ?>
						<?php endif; ?>
						<div style="padding:24px;display:flex;flex-direction:column;gap:10px;flex:1">
							<div style="display:flex;justify-content:space-between;align-items:center;gap:12px">
								<span class="pill pill-paper"><?php echo esc_html( $cat_name ); ?></span>
								<span style="font-size:12px;color:var(--fg-3)"><?php echo esc_html( nyas_reading_time() ); ?></span>
							</div>
							<h3 style="font-family:var(--ff-display);font-weight:800;font-size:22px;line-height:1.15;letter-spacing:-0.01em"><?php the_title(); ?></h3>
							<p style="margin:0;font-size:14px;color:var(--fg-2)"><?php echo esc_html( get_the_excerpt() ); ?></p>
							<div style="margin-top:auto;padding-top:16px;border-top:1px solid var(--border);font-size:12px;color:var(--fg-3);font-family:var(--ff-mono)"><?php echo esc_html( get_the_date() . ' · ' . get_the_author() ); ?></div>
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
