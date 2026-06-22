<?php
/**
 * Hardware showcase — featured product + spec rail of 4 items + facts strip.
 *
 * Rail rows aren't clickable (per home2 client feedback #8); hover swaps the
 * featured product via JS. The first row is rendered as the initial featured.
 *
 * @package NYAS
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$items = array(
	array(
		'code' => 'NYS-01',
		'name' => __( 'Cellular hub', 'nyas' ),
		'spec' => __( 'LTE-M + Z-Wave Plus · 24h battery', 'nyas' ),
		'img'  => 'https://images.unsplash.com/photo-1581094288338-2314dddb7ece?w=1400&q=80',
	),
	array(
		'code' => 'NYS-02',
		'name' => __( 'Door / window contact', 'nyas' ),
		'spec' => __( 'Encrypted 915MHz · 5-year cell', 'nyas' ),
		'img'  => 'https://images.unsplash.com/photo-1558002038-1055907df827?w=1400&q=80',
	),
	array(
		'code' => 'NYS-03',
		'name' => __( '4K outdoor camera', 'nyas' ),
		'spec' => __( 'IR 100ft · IP67 · onboard AI', 'nyas' ),
		'img'  => 'https://images.unsplash.com/photo-1557804506-669a67965ba0?w=1800&q=80',
	),
	array(
		'code' => 'NYS-04',
		'name' => __( 'Indoor motion sensor', 'nyas' ),
		'spec' => __( 'Pet-immune · 30ft · 7-year battery', 'nyas' ),
		'img'  => 'https://images.unsplash.com/photo-1545987796-200677ee1011?w=1400&q=80',
	),
);

$facts = array(
	array( 'k' => 'AES-128', 'v' => __( 'Encryption every link', 'nyas' ) ),
	array( 'k' => '< 28s',   'v' => __( 'Median dispatch time', 'nyas' ) ),
	array( 'k' => '24h',     'v' => __( 'Cellular battery backup', 'nyas' ) ),
	array( 'k' => 'IP67',    'v' => __( 'Weather-rated outdoor', 'nyas' ) ),
);

$current = $items[0];
?>
<section class="hardware-showcase-v2" data-nyas-hardware>
	<div class="container">
		<div class="hardware-v2-header">
			<div>
				<div class="eyebrow" style="margin-bottom:14px"><?php esc_html_e( 'The hardware', 'nyas' ); ?></div>
				<h2 class="h2" style="margin-bottom:16px;max-width:680px"><?php esc_html_e( 'Engineered', 'nyas' ); ?> <em><?php esc_html_e( 'for the Building', 'nyas' ); ?></em>, <?php esc_html_e( 'Not the Demo.', 'nyas' ); ?></h2>
				<p class="lede" style="font-size:17px;line-height:1.6;max-width:540px"><?php esc_html_e( 'Every part of the stack is chosen because it survives the actual conditions of NYC: brick walls, cellular dead spots, freezing fire-escapes, sub-basements without Wi-Fi.', 'nyas' ); ?></p>
			</div>
			<a href="<?php echo esc_url( home_url( '/services/' ) ); ?>" class="btn btn-lg btn-ink hardware-v2-cta"><?php esc_html_e( 'See full equipment list', 'nyas' ); ?> <?php nyas_icon( 'arrow-right', 14 ); ?></a>
		</div>

		<div class="hardware-v2-grid">
			<div class="hardware-v2-feature">
				<div class="hardware-v2-feature-img" data-hw-feature-img style="background-image:url('<?php echo esc_url( $current['img'] ); ?>')">
					<span class="hardware-v2-feature-code" data-hw-feature-code><?php echo esc_html( $current['code'] ); ?></span>
					<div class="hardware-v2-feature-pulse"></div>
				</div>
				<div class="hardware-v2-feature-meta">
					<div class="hardware-v2-feature-name" data-hw-feature-name><?php echo esc_html( $current['name'] ); ?></div>
					<div class="hardware-v2-feature-spec" data-hw-feature-spec><?php echo esc_html( $current['spec'] ); ?></div>
				</div>
			</div>

			<div class="hardware-v2-rail">
				<?php foreach ( $items as $i => $it ) : ?>
					<div
						class="hardware-v2-row<?php echo 0 === $i ? ' on' : ''; ?>"
						data-hw-row
						tabindex="0"
						data-hw-img="<?php echo esc_url( $it['img'] ); ?>"
						data-hw-code="<?php echo esc_attr( $it['code'] ); ?>"
						data-hw-name="<?php echo esc_attr( $it['name'] ); ?>"
						data-hw-spec="<?php echo esc_attr( $it['spec'] ); ?>"
					>
						<span class="hardware-v2-row-thumb" style="background-image:url('<?php echo esc_url( $it['img'] ); ?>')" aria-hidden="true"></span>
						<span class="hardware-v2-row-text">
							<span class="hardware-v2-row-code"><?php echo esc_html( $it['code'] ); ?></span>
							<span class="hardware-v2-row-name"><?php echo esc_html( $it['name'] ); ?></span>
							<span class="hardware-v2-row-spec"><?php echo esc_html( $it['spec'] ); ?></span>
						</span>
					</div>
				<?php endforeach; ?>
			</div>
		</div>

		<div class="hardware-v2-facts">
			<?php foreach ( $facts as $f ) : ?>
				<div class="hw-fact">
					<div class="hw-fact-k"><?php echo esc_html( $f['k'] ); ?></div>
					<div class="hw-fact-v"><?php echo esc_html( $f['v'] ); ?></div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
