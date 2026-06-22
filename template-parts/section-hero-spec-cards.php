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
	array( 'icon' => 'sensor',  'n' => '01', 't' => __( 'Sensor', 'nyas' ),   's' => __( 'Door, window, glass-break, motion', 'nyas' ) ),
	array( 'icon' => 'cam',     'n' => '02', 't' => __( 'Camera', 'nyas' ),   's' => __( '4K, AI verify, two-way audio', 'nyas' ) ),
	array( 'icon' => 'monitor', 'n' => '03', 't' => __( 'Monitor', 'nyas' ),  's' => __( 'UL-listed, on Long Island', 'nyas' ) ),
	array( 'icon' => 'bell',    'n' => '04', 't' => __( 'Dispatch', 'nyas' ), 's' => __( '28s median to NYPD/FDNY', 'nyas' ) ),
);
?>
<section class="hero-spec-strip">
	<div class="container">
		<div class="hero-spec-strip-grid">
			<?php foreach ( $cards as $c ) : ?>
				<div class="hero-spec-strip-card">
					<div class="hero-spec-strip-card-icon"><?php nyas_icon( $c['icon'], 22 ); ?></div>
					<div class="hero-spec-strip-card-meta"><?php echo esc_html( $c['n'] ); ?></div>
					<div class="hero-spec-strip-card-title"><?php echo esc_html( $c['t'] ); ?></div>
					<div class="hero-spec-strip-card-sub"><?php echo esc_html( $c['s'] ); ?></div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
