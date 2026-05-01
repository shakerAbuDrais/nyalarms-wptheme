<?php
/**
 * Search results — uses archive layout.
 *
 * @package NYAS
 */

get_header();
?>

<section style="padding:72px 0 32px">
	<div class="container">
		<?php nyas_eyebrow( __( 'Search', 'nyas' ), true, 'margin-bottom:20px' ); ?>
		<h1 class="display-lg"><?php
			/* translators: %s: search query. */
			printf( esc_html__( 'Results for "%s"', 'nyas' ), esc_html( get_search_query() ) );
		?></h1>
	</div>
</section>

<section style="padding:48px 0 96px">
	<div class="container">
		<?php if ( have_posts() ) : ?>
			<div class="grid grid-3">
				<?php while ( have_posts() ) : the_post(); ?>
					<a href="<?php the_permalink(); ?>" class="card" style="text-decoration:none;color:inherit;padding:24px;display:flex;flex-direction:column;gap:8px">
						<h3 style="font-family:var(--ff-display);font-weight:700;font-size:20px;line-height:1.15"><?php the_title(); ?></h3>
						<p style="margin:0;font-size:14px;color:var(--fg-2)"><?php echo esc_html( get_the_excerpt() ); ?></p>
					</a>
				<?php endwhile; ?>
			</div>
			<div style="margin-top:48px;text-align:center">
				<?php echo paginate_links(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
		<?php else : ?>
			<p class="muted" style="font-size:18px;text-align:center;padding:48px"><?php esc_html_e( 'No results. Try another search.', 'nyas' ); ?></p>
			<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" style="max-width:400px;margin:0 auto;display:flex;gap:8px">
				<input type="search" class="input" name="s" placeholder="<?php esc_attr_e( 'Search posts…', 'nyas' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" />
				<button type="submit" class="btn btn-md btn-signal"><?php esc_html_e( 'Search', 'nyas' ); ?></button>
			</form>
		<?php endif; ?>
	</div>
</section>

<?php get_footer();
