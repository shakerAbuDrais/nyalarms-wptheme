<?php
/**
 * Template Name: Single Service
 *
 * Recreates service.html. Pick the service via:
 *   - The page slug (e.g. /services/residential/), OR
 *   - A `?s=residential` query string.
 *
 * @package NYAS
 */

get_header();

$slug    = sanitize_key( get_post_field( 'post_name' ) );
$qs_slug = isset( $_GET['s'] ) ? sanitize_key( wp_unslash( $_GET['s'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
$service = nyas_service( $qs_slug ) ?: nyas_service( $slug ) ?: nyas_services()[0];
?>

<section style="padding:32px 0 0">
	<div class="container">
		<?php nyas_breadcrumb( array(
			array( 'Home',     home_url( '/' ) ),
			array( 'Services', home_url( '/services/' ) ),
			array( $service['short'] ),
		) ); ?>

		<div class="nyas-service-hero" style="display:grid;grid-template-columns:1.3fr 1fr;gap:56px;align-items:start">
			<div>
				<div style="display:inline-flex;align-items:center;gap:10px;margin-bottom:20px;color:var(--brand-signal-2)">
					<?php nyas_icon( $service['icon'], 20 ); ?>
					<div class="eyebrow" style="color:var(--brand-signal-2)"><?php echo esc_html( $service['cat'] ); ?></div>
				</div>
				<h1 class="display-xl" style="margin-bottom:24px">
					<?php echo esc_html( $service['name'] ); ?>
				</h1>
				<p class="lede" style="max-width:540px;margin-bottom:32px">
					<?php echo esc_html( $service['desc'] ); ?>
				</p>
				<div style="display:flex;gap:12px;flex-wrap:wrap;margin-bottom:32px">
					<a href="#quote" class="btn btn-lg btn-signal"><?php esc_html_e( 'Free quote', 'nyas' ); ?> <?php nyas_icon( 'arrow-right', 15 ); ?></a>
					<a href="tel:<?php echo esc_attr( nyas_phone_tel() ); ?>" class="btn btn-lg btn-ghost"><?php nyas_icon( 'phone', 14 ); ?> <?php echo esc_html( nyas_phone() ); ?></a>
				</div>
				<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:24px;padding-top:28px;border-top:1px solid var(--border)">
					<div class="stat"><span class="stat-num">5,420+</span><span class="stat-lbl"><?php esc_html_e( 'NYC properties', 'nyas' ); ?></span></div>
					<div class="stat"><span class="stat-num">28s</span><span class="stat-lbl"><?php esc_html_e( 'Median dispatch', 'nyas' ); ?></span></div>
					<div class="stat"><span class="stat-num">1 day</span><span class="stat-lbl"><?php esc_html_e( 'Typical install', 'nyas' ); ?></span></div>
				</div>
			</div>
			<div id="quote" style="background:var(--brand-paper);border:1px solid var(--border);border-radius:16px;padding:26px;position:sticky;top:100px">
				<h3 style="font-family:var(--ff-display);font-weight:800;font-size:24px;letter-spacing:-0.01em;margin-bottom:4px"><?php esc_html_e( 'Free home assessment', 'nyas' ); ?></h3>
				<p style="font-size:13px;color:var(--fg-2);margin-bottom:18px"><?php esc_html_e( '15-minute call. No pressure.', 'nyas' ); ?></p>
				<?php nyas_lead_form( array( 'compact' => true ) ); ?>
			</div>
		</div>
	</div>
</section>

<section style="padding:64px 0">
	<div class="container">
		<?php nyas_photo( $service['img'], $service['name'], 'aspect-ratio:21/9;border-radius:16px' ); ?>
	</div>
</section>

<section class="section-paper">
	<div class="container">
		<div class="nyas-included" style="display:grid;grid-template-columns:1fr 1.5fr;gap:64px;align-items:start">
			<div>
				<?php nyas_eyebrow( __( 'What\'s included', 'nyas' ), true, 'margin-bottom:16px' ); ?>
				<h2 class="display-lg"><?php esc_html_e( 'Built around', 'nyas' ); ?> <em><?php esc_html_e( 'your space', 'nyas' ); ?></em>, <?php esc_html_e( 'not a bundle.', 'nyas' ); ?></h2>
			</div>
			<div class="grid grid-2">
				<?php
				$included = array(
					array( 'sensor',       'Door & window sensors', 'Wireless or wired. Lithium battery, 5-year life. Low-profile contact switches.' ),
					array( 'eye',          'Motion detection',      'Dual-tech PIR + microwave. Pet-immune up to 80 lbs.' ),
					array( 'cam',          'Indoor & outdoor cams', '4K, color night vision, two-way audio. Cloud + local NVR.' ),
					array( 'monitor',      'Smart panel',           'Touchscreen panel. Wi-Fi + LTE backup. Smart-home ready.' ),
					array( 'phone',        'Mobile app',            'iOS and Android. Arm, disarm, view live, share with family.' ),
					array( 'shield-check', '24/7 monitoring',       'UL-listed central station, Long Island City. 28-second median dispatch.' ),
				);
				foreach ( $included as $it ) :
					?>
					<div style="padding:20px 0;border-top:1px solid var(--border-strong)">
						<div style="display:flex;gap:14px;align-items:flex-start">
							<div style="width:40px;height:40px;border-radius:10px;background:var(--bull-bg);color:var(--brand-signal-2);display:inline-flex;align-items:center;justify-content:center;flex-shrink:0">
								<?php nyas_icon( $it[0], 20 ); ?>
							</div>
							<div>
								<h3 style="font-size:16px;font-weight:600;margin-bottom:4px"><?php echo esc_html( $it[1] ); ?></h3>
								<p style="margin:0;font-size:14px"><?php echo esc_html( $it[2] ); ?></p>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>

<section>
	<div class="container">
		<div style="margin-bottom:48px">
			<?php nyas_eyebrow( __( 'How an install actually goes', 'nyas' ), true, 'margin-bottom:16px' ); ?>
			<h2 class="display-lg" style="max-width:720px"><?php esc_html_e( 'Five days from call to', 'nyas' ); ?> <em><?php esc_html_e( 'armed.', 'nyas' ); ?></em></h2>
		</div>
		<div class="grid grid-5" style="gap:0;border:1px solid var(--border);border-radius:14px;overflow:hidden;background:var(--brand-paper)">
			<?php
			$timeline = array(
				array( 'Day 1', 'You call',  'Five-minute fact-find on the phone or text.' ),
				array( 'Day 2', 'Site walk', 'Engineer visits. Maps doors, windows, blind spots.' ),
				array( 'Day 3', 'Quote',     'One-page proposal. Hardware + monitoring itemized.' ),
				array( 'Day 4', 'Schedule',  'You pick the install slot. Most are 8a–12p.' ),
				array( 'Day 5', 'Armed',     'In-house tech installs in 4–6 hours. App handed over.' ),
			);
			$last = count( $timeline ) - 1;
			foreach ( $timeline as $i => $s ) :
				$br = $i < $last ? '1px solid var(--border)' : 'none';
				?>
				<div style="padding:24px;border-right:<?php echo esc_attr( $br ); ?>">
					<div style="font-family:var(--ff-mono);font-size:11px;color:var(--brand-signal-2);letter-spacing:0.1em;margin-bottom:8px"><?php echo esc_html( strtoupper( $s[0] ) ); ?></div>
					<h3 style="font-family:var(--ff-display);font-weight:700;font-size:22px;letter-spacing:-0.01em;margin-bottom:8px"><?php echo esc_html( $s[1] ); ?></h3>
					<p style="margin:0;font-size:13px"><?php echo esc_html( $s[2] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="section-sunk">
	<div class="container">
		<div style="margin-bottom:32px;max-width:720px">
			<?php nyas_eyebrow( __( 'Specs at a glance', 'nyas' ), true, 'margin-bottom:16px' ); ?>
			<h2 class="display-lg"><?php esc_html_e( 'What ships in the box.', 'nyas' ); ?></h2>
		</div>
		<div class="grid grid-2" style="gap:0;border:1px solid var(--border);border-radius:14px;overflow:hidden;background:var(--brand-paper)">
			<?php
			$specs = array(
				array( 'Panel',                'DSC PowerG / Honeywell Lyric, encrypted mesh' ),
				array( 'Comms',                'Dual-path: broadband + LTE-M cellular backup' ),
				array( 'Sensors',              'Door, window, glass-break, motion (PIR + microwave)' ),
				array( 'Cameras',              'Indoor & outdoor 4K with two-way audio' ),
				array( 'Monitoring',           'UL-listed central station, Long Island City' ),
				array( 'Avg dispatch',         '28 seconds (12-month rolling median)' ),
				array( 'Insurance certificate','Stamped, mailed within 5 business days of go-live' ),
				array( 'Cancel notice',        '30 days. Equipment is yours — no removal fee.' ),
			);
			foreach ( $specs as $sp ) : ?>
				<div style="padding:18px 22px;display:grid;grid-template-columns:140px 1fr;gap:20px;border-top:1px solid var(--border)">
					<div class="eyebrow" style="color:var(--fg-3)"><?php echo esc_html( $sp[0] ); ?></div>
					<div style="font-size:14px;color:var(--fg)"><?php echo esc_html( $sp[1] ); ?></div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php // Related services. ?>
<section>
	<div class="container">
		<div style="display:flex;justify-content:space-between;align-items:end;margin-bottom:32px;gap:24px;flex-wrap:wrap">
			<h2 class="display-md"><?php esc_html_e( 'Related systems', 'nyas' ); ?></h2>
			<a href="<?php echo esc_url( home_url( '/services/' ) ); ?>" class="btn btn-sm btn-ghost"><?php esc_html_e( 'All services', 'nyas' ); ?> <?php nyas_icon( 'arrow-right', 12 ); ?></a>
		</div>
		<div class="grid grid-3">
			<?php
			$related = array_slice( array_filter( nyas_services(), function ( $s ) use ( $service ) { return $s['id'] !== $service['id']; } ), 0, 3 );
			foreach ( $related as $r ) : ?>
				<a href="<?php echo esc_url( home_url( '/services/' . $r['id'] . '/' ) ); ?>" class="card" style="text-decoration:none;color:inherit;padding:0;overflow:hidden">
					<?php nyas_photo( $r['img'], $r['name'], 'aspect-ratio:4/3;border-radius:0' ); ?>
					<div style="padding:20px">
						<span class="pill pill-paper" style="margin-bottom:10px"><?php echo esc_html( $r['cat'] ); ?></span>
						<h3 style="font-family:var(--ff-display);font-weight:700;font-size:20px;margin-top:10px"><?php echo esc_html( $r['short'] ); ?></h3>
					</div>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php nyas_final_cta(); ?>

<?php get_footer();
