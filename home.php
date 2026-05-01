<?php
/**
 * Blog index — recreates blog.html.
 *
 * @package NYAS
 */

get_header();
?>

<section style="padding:72px 0 32px">
	<div class="container">
		<?php nyas_eyebrow( __( 'Insights', 'nyas' ), true, 'margin-bottom:20px' ); ?>
		<div class="nyas-blog-head" style="display:grid;grid-template-columns:1.3fr 1fr;gap:64px;align-items:end">
			<h1 class="display-xl"><?php esc_html_e( 'Field notes from the', 'nyas' ); ?> <em><?php esc_html_e( 'monitoring desk.', 'nyas' ); ?></em></h1>
			<p class="lede" style="margin:0">
				<?php esc_html_e( 'Buyers guides, NYPD response data, lessons from the central station — written by the people on the floor in Long Island City.', 'nyas' ); ?>
			</p>
		</div>
	</div>
</section>

<?php
$featured_query = new WP_Query( array(
	'posts_per_page' => 1,
	'paged'          => 1,
	'post_status'    => 'publish',
	'no_found_rows'  => true,
) );

if ( ! is_paged() && $featured_query->have_posts() ) :
	$featured_query->the_post();
	?>
	<section style="padding:32px 0 64px">
		<div class="container">
			<a href="<?php the_permalink(); ?>" class="nyas-feat-post" style="display:grid;grid-template-columns:1.2fr 1fr;gap:56px;align-items:center;text-decoration:none;color:inherit;padding:32px;background:var(--brand-paper);border:1px solid var(--border);border-radius:16px">
				<?php if ( has_post_thumbnail() ) : ?>
					<?php nyas_photo( get_the_post_thumbnail_url( null, 'nyas-hero' ), get_the_title(), 'aspect-ratio:4/3;border-radius:12px' ); ?>
				<?php endif; ?>
				<div>
					<?php
					$cat = get_the_category();
					$cat_name = $cat ? $cat[0]->name : __( 'Insights', 'nyas' );
					nyas_eyebrow( sprintf( __( 'Featured · %s', 'nyas' ), $cat_name ), false, 'margin-bottom:14px;color:var(--brand-signal-2)' );
					?>
					<h2 class="display-md" style="margin-bottom:16px"><?php the_title(); ?></h2>
					<p style="font-size:16px;line-height:1.6;color:var(--fg-2);margin-bottom:24px"><?php echo esc_html( get_the_excerpt() ); ?></p>
					<div style="display:flex;gap:16px;align-items:center;font-size:13px;color:var(--fg-3);font-family:var(--ff-mono)">
						<span><?php printf( esc_html__( 'By %s', 'nyas' ), esc_html( get_the_author() ) ); ?></span>
						<span>·</span>
						<span><?php echo esc_html( get_the_date() ); ?></span>
						<span>·</span>
						<span><?php echo esc_html( nyas_reading_time() ); ?></span>
					</div>
				</div>
			</a>
		</div>
	</section>
	<?php
	wp_reset_postdata();
endif;
?>

<?php
$categories = get_categories( array( 'hide_empty' => true ) );
if ( ! empty( $categories ) ) : ?>
	<section style="padding:0;border-top:1px solid var(--border);border-bottom:1px solid var(--border);position:sticky;top:0;background:rgba(247,244,237,0.94);backdrop-filter:blur(10px);z-index:10">
		<div class="container" style="display:flex;align-items:center;gap:12px;padding:16px 32px;flex-wrap:wrap">
			<div style="display:flex;gap:6px;flex-wrap:wrap">
				<a href="<?php echo esc_url( get_post_type_archive_link( 'post' ) ?: home_url( '/blog/' ) ); ?>" class="radio-pill on" style="padding:8px 14px"><?php esc_html_e( 'All', 'nyas' ); ?></a>
				<?php foreach ( $categories as $cat_obj ) : ?>
					<a href="<?php echo esc_url( get_category_link( $cat_obj ) ); ?>" class="radio-pill" style="padding:8px 14px"><?php echo esc_html( $cat_obj->name ); ?></a>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
<?php endif; ?>

<section style="padding:64px 0 96px">
	<div class="container">
		<?php
		// Skip the featured post (first one) on the front of page 1.
		$paged       = max( 1, get_query_var( 'paged' ) );
		$skip_first  = ( 1 === $paged && $featured_query->have_posts() );

		$grid_query = new WP_Query( array(
			'posts_per_page' => $skip_first ? 5 : 6,
			'offset'         => $skip_first ? 1 : 0,
			'paged'          => $paged,
			'post_status'    => 'publish',
		) );

		if ( $grid_query->have_posts() ) : ?>
			<div class="grid grid-3">
				<?php while ( $grid_query->have_posts() ) :
					$grid_query->the_post();
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
					'total'     => $grid_query->max_num_pages,
					'current'   => $paged,
					'prev_text' => '&larr; ' . __( 'Previous', 'nyas' ),
					'next_text' => __( 'Next', 'nyas' ) . ' &rarr;',
				) );
				?>
			</div>
		<?php else : ?>
			<div class="grid grid-3">
				<?php foreach ( array_slice( nyas_seed_posts(), 1 ) as $p ) : ?>
					<a href="<?php echo esc_url( home_url( '/blog/' . $p['slug'] . '/' ) ); ?>" class="card" style="text-decoration:none;color:inherit;padding:0;overflow:hidden;display:flex;flex-direction:column">
						<?php nyas_photo( $p['img'], $p['title'], 'aspect-ratio:4/3;border-radius:0;border-bottom:1px solid var(--border)' ); ?>
						<div style="padding:24px;display:flex;flex-direction:column;gap:10px;flex:1">
							<div style="display:flex;justify-content:space-between;align-items:center;gap:12px">
								<span class="pill pill-paper"><?php echo esc_html( $p['tag'] ); ?></span>
								<span style="font-size:12px;color:var(--fg-3)"><?php echo esc_html( $p['read'] ); ?></span>
							</div>
							<h3 style="font-family:var(--ff-display);font-weight:800;font-size:22px;line-height:1.15;letter-spacing:-0.01em"><?php echo esc_html( $p['title'] ); ?></h3>
							<p style="margin:0;font-size:14px;color:var(--fg-2)"><?php echo esc_html( $p['excerpt'] ); ?></p>
							<div style="margin-top:auto;padding-top:16px;border-top:1px solid var(--border);font-size:12px;color:var(--fg-3);font-family:var(--ff-mono)"><?php echo esc_html( $p['date'] . ' · ' . $p['author'] ); ?></div>
						</div>
					</a>
				<?php endforeach; ?>
			</div>
		<?php endif; wp_reset_postdata(); ?>
	</div>
</section>

<section class="section-ink" style="padding:64px 0">
	<div class="container nyas-newsletter" style="display:grid;grid-template-columns:1fr 1fr;gap:56px;align-items:center">
		<div>
			<?php nyas_eyebrow( __( 'Newsletter', 'nyas' ), false, 'color:rgba(246,243,236,0.55);margin-bottom:14px' ); ?>
			<h2 class="display-md" style="color:var(--fg-on-ink);margin-bottom:12px"><?php esc_html_e( 'One email a month.', 'nyas' ); ?> <em style="color:#3CD68C"><?php esc_html_e( 'Worth opening.', 'nyas' ); ?></em></h2>
			<p style="color:rgba(246,243,236,0.78);font-size:15px;margin:0"><?php esc_html_e( 'Field notes, NYC response data, buyer\'s guides — no sales emails.', 'nyas' ); ?></p>
		</div>
		<form data-nyas-newsletter style="display:flex;gap:8px;flex-wrap:wrap">
			<label class="screen-reader-text" for="nyas-newsletter-email"><?php esc_html_e( 'Email', 'nyas' ); ?></label>
			<input id="nyas-newsletter-email" type="email" required class="input" placeholder="you@email.com" style="flex:1;background:rgba(246,243,236,0.06);border-color:rgba(246,243,236,0.20);color:var(--fg-on-ink);min-width:200px" />
			<button type="submit" class="btn btn-lg btn-signal"><?php esc_html_e( 'Subscribe', 'nyas' ); ?></button>
		</form>
	</div>
</section>

<?php get_footer();
