<?php
/**
 * Response timeline — animated 5-card "0s → 28s" sequence on a navy background.
 *
 * Active state cycles automatically via CSS keyframes (12s loop) so this stays
 * pure-HTML/CSS and doesn't add a JS dependency.
 *
 * @package NYAS
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$steps = array(
	array( 't' => '0s',  'label' => __( 'Trigger', 'nyas' ),  'desc' => __( 'Door contact breaks. Hub pings station.', 'nyas' ),                                  'icon' => 'shield' ),
	array( 't' => '4s',  'label' => __( 'Verify', 'nyas' ),   'desc' => __( 'A real person verifies the camera feed for suspicious activity.', 'nyas' ),         'icon' => 'eye' ),
	array( 't' => '12s', 'label' => __( 'Operator', 'nyas' ), 'desc' => __( 'UL-listed agent live, two-way audio + camera.', 'nyas' ),                          'icon' => 'phone' ),
	array( 't' => '22s', 'label' => __( 'Owner', 'nyas' ),    'desc' => __( 'Push + call to primary contact. 8-second cancel window.', 'nyas' ),                'icon' => 'bell' ),
	array( 't' => '28s', 'label' => __( 'Dispatch', 'nyas' ), 'desc' => __( 'NYPD priority code. Super, concierge, tenants alerted simultaneously.', 'nyas' ), 'icon' => 'pin' ),
);
?>
<section class="response-timeline">
	<div class="response-timeline-bg" aria-hidden="true">
		<div class="rt-glow rt-glow-1"></div>
		<div class="rt-glow rt-glow-2"></div>
	</div>
	<div class="container response-timeline-inner">
		<div class="response-timeline-header">
			<div class="eyebrow"><?php esc_html_e( 'Anatomy of a 28-second response', 'nyas' ); ?></div>
			<h2><?php esc_html_e( 'From a Sensor Alert to', 'nyas' ); ?> <em><?php esc_html_e( 'NYPD Dispatch', 'nyas' ); ?></em> <?php esc_html_e( 'in Less Than Half a Minute.', 'nyas' ); ?></h2>
			<p><?php esc_html_e( 'Median across 12 months of monitored alarms. Measured station-side — no marketing math.', 'nyas' ); ?></p>
		</div>
		<div class="rt-track">
			<div class="rt-rail">
				<div class="rt-rail-fill"></div>
			</div>
			<div class="rt-cards">
				<?php foreach ( $steps as $s ) : ?>
					<div class="rt-card">
						<div class="rt-card-time"><?php echo esc_html( $s['t'] ); ?></div>
						<div class="rt-card-icon"><?php nyas_icon( $s['icon'], 18 ); ?></div>
						<div class="rt-card-label"><?php echo esc_html( $s['label'] ); ?></div>
						<div class="rt-card-desc"><?php echo esc_html( $s['desc'] ); ?></div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>
