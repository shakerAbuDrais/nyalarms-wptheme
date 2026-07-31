<?php
/**
 * Hero spec strip — 4 numbered cards that sit directly below the video hero.
 *
 * @package NYAS
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$cards = array(
	array( 'icon' => 'sensor',  't' => __( 'Sensor', 'nyas' ),   's' => __( 'Door, window, glass-break, motion', 'nyas' ) ),
	array( 'icon' => 'cam',     't' => __( 'Camera', 'nyas' ),   's' => __( '4K, AI verify, two-way audio', 'nyas' ) ),
	array( 'icon' => 'monitor', 't' => __( 'Monitor', 'nyas' ),  's' => __( 'UL-listed, on Long Island', 'nyas' ) ),
	array( 'icon' => 'bell',    't' => __( 'Dispatch', 'nyas' ), 's' => __( '28s median to NYPD/FDNY', 'nyas' ) ),
);
?>
<section class="hero-spec-strip">
	<div class="container">
		<div class="hero-spec-strip-grid">
			<?php foreach ( $cards as $c ) : ?>
				<div class="hero-spec-strip-card">
					<div class="hero-spec-strip-card-icon"><?php nyas_icon( $c['icon'], 22 ); ?></div>
					<div class="hero-spec-strip-card-title"><?php echo esc_html( $c['t'] ); ?></div>
					<div class="hero-spec-strip-card-sub"><?php echo esc_html( $c['s'] ); ?></div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
