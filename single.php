<?php
/**
 * Single blog post — recreates post.html.
 *
 * @package NYAS
 */

get_header();

while ( have_posts() ) : the_post();
	$cat       = get_the_category();
	$cat_name  = $cat ? $cat[0]->name : __( 'Insights', 'nyas' );
	$author_id = get_the_author_meta( 'ID' );
	?>

	<article>
		<header style="padding:64px 0 48px">
			<div class="container-narrow" style="text-align:center">
				<?php nyas_breadcrumb( array(
					array( 'Insights', get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/blog/' ) ),
					array( $cat_name ),
				) ); ?>

				<h1 class="display-xl" style="margin-bottom:24px"><?php the_title(); ?></h1>

				<?php if ( get_the_excerpt() ) : ?>
					<p class="lede" style="max-width:640px;margin:0 auto 32px"><?php echo esc_html( get_the_excerpt() ); ?></p>
				<?php endif; ?>

				<div style="display:flex;gap:16px;justify-content:center;align-items:center;flex-wrap:wrap;font-size:13px;color:var(--fg-3);font-family:var(--ff-mono)">
					<?php echo get_avatar( $author_id, 32, '', '', array( 'style' => 'width:32px;height:32px;border-radius:50%' ) ); ?>
					<span><?php echo esc_html( get_the_author() ); ?></span>
					<span>·</span>
					<span><?php echo esc_html( get_the_date() ); ?></span>
					<span>·</span>
					<span><?php echo esc_html( nyas_reading_time() ); ?></span>
				</div>
			</div>
		</header>

		<?php if ( has_post_thumbnail() ) : ?>
			<div class="container">
				<?php nyas_photo( get_the_post_thumbnail_url( null, 'nyas-hero' ), get_the_title(), 'aspect-ratio:21/9;border-radius:16px;margin-bottom:64px' ); ?>
			</div>
		<?php endif; ?>

		<div class="container-narrow post-prose">
			<?php the_content(); ?>
		</div>
	</article>

	<section style="padding:64px 0">
		<div class="container-narrow">
			<div style="padding:28px;background:var(--brand-paper);border:1px solid var(--border);border-radius:14px;display:flex;gap:20px;align-items:flex-start;flex-wrap:wrap">
				<?php echo get_avatar( $author_id, 64, '', '', array( 'style' => 'width:64px;height:64px;border-radius:50%' ) ); ?>
				<div style="flex:1;min-width:240px">
					<div style="font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:0.12em;color:var(--fg-3);margin-bottom:4px"><?php esc_html_e( 'About the author', 'nyas' ); ?></div>
					<h3 style="font-family:var(--ff-display);font-weight:700;font-size:24px;letter-spacing:-0.01em"><?php echo esc_html( get_the_author() ); ?></h3>
					<?php $desc = get_the_author_meta( 'description' ); if ( $desc ) : ?>
						<p style="margin:6px 0 14px;font-size:14px"><?php echo esc_html( $desc ); ?></p>
					<?php endif; ?>
					<a href="<?php echo esc_url( home_url( '/about/' ) ); ?>" class="btn btn-sm btn-ghost"><?php esc_html_e( 'More about us', 'nyas' ); ?> <?php nyas_icon( 'arrow-right', 12 ); ?></a>
				</div>
			</div>
		</div>
	</section>

	<?php
	$related = new WP_Query( array(
		'posts_per_page' => 3,
		'post__not_in'   => array( get_the_ID() ),
		'category__in'   => wp_list_pluck( get_the_category(), 'term_id' ),
		'no_found_rows'  => true,
	) );

	if ( $related->have_posts() ) : ?>
		<section style="padding:0 0 64px">
			<div class="container">
				<div style="display:flex;justify-content:space-between;align-items:end;margin-bottom:32px">
					<h2 class="display-md"><?php esc_html_e( 'Keep reading', 'nyas' ); ?></h2>
					<a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/blog/' ) ); ?>" class="btn btn-sm btn-ghost"><?php esc_html_e( 'All posts', 'nyas' ); ?> <?php nyas_icon( 'arrow-right', 12 ); ?></a>
				</div>
				<div class="grid grid-3">
					<?php while ( $related->have_posts() ) : $related->the_post();
						$rcat = get_the_category();
						$rcat_name = $rcat ? $rcat[0]->name : __( 'Insights', 'nyas' );
						?>
						<a href="<?php the_permalink(); ?>" class="card" style="text-decoration:none;color:inherit;padding:0;overflow:hidden">
							<?php if ( has_post_thumbnail() ) : ?>
								<?php nyas_photo( get_the_post_thumbnail_url( null, 'nyas-card' ), get_the_title(), 'aspect-ratio:4/3;border-radius:0' ); ?>
							<?php endif; ?>
							<div style="padding:20px">
								<span class="pill pill-paper" style="margin-bottom:10px"><?php echo esc_html( $rcat_name ); ?></span>
								<h3 style="font-family:var(--ff-display);font-weight:700;font-size:20px;margin-top:10px"><?php the_title(); ?></h3>
								<div style="margin-top:12px;font-family:var(--ff-mono);font-size:12px;color:var(--fg-3)"><?php echo esc_html( get_the_date() ); ?></div>
							</div>
						</a>
					<?php endwhile; ?>
				</div>
			</div>
		</section>
	<?php endif; wp_reset_postdata(); ?>

	<section class="section-ink" style="padding:64px 0">
		<div class="container nyas-post-cta" style="display:grid;grid-template-columns:1.3fr 1fr;gap:48px;align-items:center">
			<div>
				<h2 class="display-md" style="color:var(--fg-on-ink);margin-bottom:12px"><?php esc_html_e( 'Want a real opinion on your apartment?', 'nyas' ); ?></h2>
				<p style="color:rgba(246,243,236,0.78);font-size:16px;margin-bottom:20px"><?php esc_html_e( 'Free site walk anywhere in the five boroughs — usually within 48 hours.', 'nyas' ); ?></p>
				<a href="#cta-form" class="btn btn-lg btn-signal"><?php esc_html_e( 'Get my free quote', 'nyas' ); ?> <?php nyas_icon( 'arrow-right', 15 ); ?></a>
			</div>
			<div id="cta-form" style="background:var(--brand-paper);border-radius:16px;padding:24px">
				<?php nyas_lead_form( array( 'compact' => true ) ); ?>
			</div>
		</div>
	</section>

	<?php
	if ( comments_open() || get_comments_number() ) :
		?>
		<section style="padding:64px 0;background:var(--brand-paper);border-top:1px solid var(--border)">
			<div class="container-narrow">
				<?php comments_template(); ?>
			</div>
		</section>
		<?php
	endif;
	?>

<?php endwhile;

get_footer();
