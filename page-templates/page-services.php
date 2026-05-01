<?php
/**
 * Template Name: Services Archive
 *
 * Recreates services.html.
 *
 * @package NYAS
 */

get_header();

$services   = nyas_services();
$categories = array( 'All', 'Home', 'Business', 'Industrial', 'Emergency', 'Service' );
?>

<section style="padding:72px 0 48px">
	<div class="container">
		<?php nyas_eyebrow( __( 'All services', 'nyas' ), true, 'margin-bottom:20px' ); ?>
		<div class="nyas-services-head" style="display:grid;grid-template-columns:1.5fr 1fr;gap:64px;align-items:end">
			<h1 class="display-xl"><?php esc_html_e( 'Ten ways we keep', 'nyas' ); ?> <em><?php esc_html_e( 'watch.', 'nyas' ); ?></em></h1>
			<p class="lede" style="margin:0">
				<?php esc_html_e( 'From brownstone studios in Park Slope to twelve-story warehouses in Maspeth — one number, one team, one app.', 'nyas' ); ?>
			</p>
		</div>
	</div>
</section>

<section class="nyas-filter-bar" data-nyas-filter="services" style="padding:24px 0;border-top:1px solid var(--border);border-bottom:1px solid var(--border);position:sticky;top:0;background:rgba(247,244,237,0.94);backdrop-filter:blur(10px);z-index:10">
	<div class="container" style="display:flex;gap:8px;overflow-x:auto;align-items:center">
		<?php foreach ( $categories as $i => $c ) : ?>
			<button type="button" class="radio-pill<?php echo 0 === $i ? ' on' : ''; ?>" data-nyas-filter-cat="<?php echo esc_attr( $c ); ?>" style="white-space:nowrap"><?php echo esc_html( $c ); ?></button>
		<?php endforeach; ?>
		<span data-nyas-filter-count style="margin-left:auto;align-self:center;font-family:var(--ff-mono);font-size:12px;color:var(--fg-3)"><?php echo (int) count( $services ); ?> services</span>
	</div>
</section>

<section style="padding:64px 0 96px">
	<div class="container">
		<div class="grid grid-3" data-nyas-filter-grid>
			<?php foreach ( $services as $svc ) : ?>
				<a href="<?php echo esc_url( home_url( '/services/' . $svc['id'] . '/' ) ); ?>"
				   class="card"
				   data-nyas-filter-item="<?php echo esc_attr( $svc['cat'] ); ?>"
				   style="text-decoration:none;color:inherit;padding:0;overflow:hidden;display:flex;flex-direction:column">
					<?php nyas_photo( $svc['img'], $svc['name'], 'aspect-ratio:5/3;border-radius:0;border-bottom:1px solid var(--border)' ); ?>
					<div style="padding:24px;display:flex;flex-direction:column;gap:12px;flex:1">
						<div style="display:flex;justify-content:space-between;align-items:center">
							<span style="display:inline-flex;align-items:center;gap:8px;color:var(--brand-signal-2)">
								<?php nyas_icon( $svc['icon'], 18 ); ?>
								<span class="eyebrow" style="color:var(--brand-signal-2)"><?php echo esc_html( $svc['cat'] ); ?></span>
							</span>
						</div>
						<h3 style="font-family:var(--ff-display);font-weight:800;font-size:24px;line-height:1.15;letter-spacing:-0.01em"><?php echo esc_html( $svc['name'] ); ?></h3>
						<p style="margin:0;font-size:14px"><?php echo esc_html( $svc['desc'] ); ?></p>
						<div style="display:flex;flex-wrap:wrap;gap:6px;margin-top:4px">
							<?php foreach ( array_slice( $svc['feats'], 0, 4 ) as $f ) : ?>
								<span class="pill pill-paper"><?php echo esc_html( $f ); ?></span>
							<?php endforeach; ?>
						</div>
						<div style="margin-top:auto;padding-top:16px;border-top:1px solid var(--border);display:inline-flex;align-items:center;gap:6px;color:var(--brand-signal-2);font-size:13px;font-weight:600">
							<?php esc_html_e( 'Learn more', 'nyas' ); ?> <?php nyas_icon( 'arrow-right', 13 ); ?>
						</div>
					</div>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php nyas_final_cta( array(
	'eyebrow'   => __( 'Not sure where to start?', 'nyas' ),
	'heading'   => __( 'Tell us the address. We\'ll <em>tell you what fits.</em>', 'nyas' ),
	'lede'      => __( 'One free site walk, one written quote — no obligation, no high-pressure sales.', 'nyas' ),
	'cta_label' => __( 'Free quote in 15 min', 'nyas' ),
) ); ?>

<?php get_footer();
