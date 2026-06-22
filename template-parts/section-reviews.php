<?php
/**
 * Customer reviews — carousel with prev/next arrows + pagination dots.
 *
 * Replaces the static 3-up testimonials grid from the original home.html port.
 *
 * @package NYAS
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$reviews = array(
	array( 'quote' => __( 'They installed a real system, not a contract trap. I own my hardware. Monitoring is month-to-month. Refreshing.', 'nyas' ),       'name' => __( 'Verified homeowner', 'nyas' ), 'role' => __( 'Brooklyn', 'nyas' ) ),
	array( 'quote' => __( 'Our previous vendor took 4 minutes to dispatch. NYAS is under 30 seconds. We saw the difference the first month.', 'nyas' ),    'name' => __( 'Verified review', 'nyas' ),    'role' => __( 'Healthcare operations · Manhattan', 'nyas' ) ),
	array( 'quote' => __( 'Build site got hit twice in 2024. After NYAS rolled out cameras + temporary towers, zero incidents in 11 months.', 'nyas' ),    'name' => __( 'Verified review', 'nyas' ),    'role' => __( 'General contractor · Queens', 'nyas' ) ),
	array( 'quote' => __( 'The team handled every co-op board form and the permit filing. All I did was unlock the door. Truly local people.', 'nyas' ),  'name' => __( 'Verified review', 'nyas' ),    'role' => __( 'Co-op resident · Upper West Side', 'nyas' ) ),
	array( 'quote' => __( 'Cellular backup kicked in the night our block lost power. The alarm never went dark. That is exactly why we switched.', 'nyas' ), 'name' => __( 'Verified homeowner', 'nyas' ), 'role' => __( 'Park Slope', 'nyas' ) ),
	array( 'quote' => __( 'Wired our three storefronts on one dashboard. False alarms dropped to almost none thanks to verified video.', 'nyas' ),       'name' => __( 'Verified review', 'nyas' ),    'role' => __( 'Retail owner · Brooklyn', 'nyas' ) ),
);
?>
<section>
	<div class="container" data-nyas-reviews>
		<div style="display:flex;justify-content:space-between;align-items:end;margin-bottom:40px;gap:32px;flex-wrap:wrap">
			<div>
				<h2 class="display-lg" style="max-width:720px"><?php esc_html_e( '4.9 Stars Across', 'nyas' ); ?> <em><?php esc_html_e( '2,100 Reviews.', 'nyas' ); ?></em></h2>
			</div>
			<div style="display:flex;gap:4px;align-items:center;color:var(--brand-signal)">
				<?php for ( $i = 0; $i < 5; $i++ ) { nyas_icon( 'star', 20 ); } ?>
				<span style="margin-left:10px;font-family:var(--ff-mono);font-size:13px;color:var(--fg-2)"><?php esc_html_e( '4.94 avg.', 'nyas' ); ?></span>
			</div>
		</div>

		<div class="reviews-carousel">
			<button type="button" class="reviews-arrow" data-reviews-prev aria-label="<?php esc_attr_e( 'Previous review', 'nyas' ); ?>">
				<?php nyas_icon( 'arrow-right', 20, 'transform:rotate(180deg)' ); ?>
			</button>

			<div class="reviews-track" data-reviews-track>
				<?php foreach ( $reviews as $r ) : ?>
					<figure class="review-card">
						<div style="color:var(--brand-signal-2)"><?php nyas_icon( 'quote', 28 ); ?></div>
						<blockquote style="margin:0;font-family:var(--ff-display);font-weight:700;font-size:20px;line-height:1.4;color:var(--fg)">&ldquo;<?php echo esc_html( $r['quote'] ); ?>&rdquo;</blockquote>
						<figcaption style="display:flex;flex-direction:column;gap:2px;margin-top:auto;padding-top:16px;border-top:1px solid var(--border)">
							<div style="font-weight:600;font-size:14px"><?php echo esc_html( $r['name'] ); ?></div>
							<div style="font-size:12px;color:var(--fg-3)"><?php echo esc_html( $r['role'] ); ?></div>
						</figcaption>
					</figure>
				<?php endforeach; ?>
			</div>

			<button type="button" class="reviews-arrow" data-reviews-next aria-label="<?php esc_attr_e( 'Next review', 'nyas' ); ?>">
				<?php nyas_icon( 'arrow-right', 20 ); ?>
			</button>
		</div>

		<div class="reviews-dots">
			<?php foreach ( $reviews as $i => $r ) : ?>
				<button type="button" class="reviews-dot<?php echo 0 === $i ? ' on' : ''; ?>" data-reviews-dot aria-label="<?php echo esc_attr( sprintf( __( 'Go to review %d', 'nyas' ), $i + 1 ) ); ?>"></button>
			<?php endforeach; ?>
		</div>
	</div>
</section>
