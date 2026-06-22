<?php
/**
 * Limited offer banner — "3 months free monitoring" ticket-stamp section.
 *
 * @package NYAS
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$benefits = array(
	array( 'icon' => 'shield-check', 'title' => __( '24/7 monitoring', 'nyas' ),     'sub' => __( 'UL-listed central station, never offline', 'nyas' ) ),
	array( 'icon' => 'zap',          'title' => __( 'Immediate response', 'nyas' ),  'sub' => __( 'Median 28-second dispatch decision', 'nyas' ) ),
	array( 'icon' => 'bell',         'title' => __( 'Police call & dispatch', 'nyas' ), 'sub' => __( 'NYPD verified-response protocol', 'nyas' ) ),
);
?>
<section class="offer-banner" id="offer">
	<div class="container offer-shell">
		<aside class="offer-stamp" aria-hidden="true">
			<div class="offer-stamp-inner">
				<span class="offer-stamp-eyebrow"><?php esc_html_e( 'Limited offer', 'nyas' ); ?></span>
				<span class="offer-stamp-num">3</span>
				<span class="offer-stamp-unit"><?php esc_html_e( 'months', 'nyas' ); ?></span>
				<span class="offer-stamp-divider"></span>
				<span class="offer-stamp-free"><?php esc_html_e( 'FREE', 'nyas' ); ?><br /><?php esc_html_e( 'monitoring', 'nyas' ); ?></span>
			</div>
			<div class="offer-stamp-perforation left"></div>
			<div class="offer-stamp-perforation right"></div>
		</aside>

		<div class="offer-body">
			<div class="offer-eyebrow">
				<span class="offer-eyebrow-pulse"></span>
				<?php esc_html_e( 'New customers · Burglary alarm systems', 'nyas' ); ?>
			</div>
			<h2 class="offer-title">
				<?php esc_html_e( 'Three Months of', 'nyas' ); ?> <em><?php esc_html_e( 'Free Monitoring', 'nyas' ); ?></em><br />
				<?php esc_html_e( 'on Every Burglary Alarm.', 'nyas' ); ?>
			</h2>
			<p class="offer-lede">
				<?php esc_html_e( 'Sign up as a new residential or commercial customer and we\'ll cover your first 90 days of UL-listed central-station monitoring — the same service that pays for itself the night you actually need it.', 'nyas' ); ?>
			</p>

			<ul class="offer-benefits">
				<?php foreach ( $benefits as $b ) : ?>
					<li>
						<span class="offer-benefit-icon"><?php nyas_icon( $b['icon'], 20 ); ?></span>
						<div>
							<strong><?php echo esc_html( $b['title'] ); ?></strong>
							<span><?php echo esc_html( $b['sub'] ); ?></span>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>

			<div class="offer-actions">
				<a class="btn btn-lg btn-signal" href="#quote"><?php esc_html_e( 'Claim my 3 free months', 'nyas' ); ?> <?php nyas_icon( 'arrow-right', 14 ); ?></a>
				<a class="btn btn-lg btn-ghost-light" href="tel:<?php echo esc_attr( nyas_phone_tel() ); ?>"><?php nyas_icon( 'phone', 14 ); ?> <?php
					/* translators: %s: phone number. */
					printf( esc_html__( 'Call %s', 'nyas' ), esc_html( nyas_phone() ) );
				?></a>
			</div>

			<div class="offer-fineprint">
				<span class="offer-fineprint-label"><?php esc_html_e( 'Terms & conditions', 'nyas' ); ?></span>
				<p><?php esc_html_e( 'Valid with a 1-year monitoring contract. New customers only. Applies to residential and commercial accounts. Full annual payment required in advance. Offer cannot be combined with other promotions.', 'nyas' ); ?></p>
			</div>
		</div>
	</div>
</section>
