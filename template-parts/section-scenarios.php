<?php
/**
 * Tabbed scenario explainer — "A real alarm. A real response."
 *
 * @package NYAS
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$scenarios = array(
	'home' => array(
		'label'  => __( 'At home', 'nyas' ),
		'icon'   => 'home',
		'live'   => __( 'Brooklyn', 'nyas' ),
		'title'  => 'Park Slope brownstone, 2:14 a.m.',
		'story'  => 'Glass-break sensor on the parlor-floor bay window picks up a high-frequency signature. Within four seconds, the panel sends an encrypted alarm over LTE-M cellular — bypassing your Wi-Fi entirely.',
		'events' => array(
			array( '00:00', 'Glass-break detected on Zone 3 (parlor window).' ),
			array( '00:04', 'Cellular alarm received at the Long Island monitoring station.' ),
			array( '00:18', 'Operator calls the homeowner. No answer.' ),
			array( '00:28', 'NYPD dispatched. Officers en route.' ),
			array( '00:46', 'Dispatcher shares live video with NYPD.' ),
		),
		'img'    => 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=900&q=80',
	),
	'business' => array(
		'label'  => __( 'At your business', 'nyas' ),
		'icon'   => 'shop',
		'live'   => __( 'Manhattan', 'nyas' ),
		'title'  => 'Madison Ave. storefront, after close',
		'story'  => 'A motion sensor in the stockroom triggers ten minutes after the last employee badged out. Our station verifies through the camera before any dispatch — cutting false alarms by 91%.',
		'events' => array(
			array( '00:00', 'Stockroom motion + door contact disagree.' ),
			array( '00:06', 'Operator pulls live camera, verifies movement.' ),
			array( '00:14', 'Two-way speaker challenges intruder by name.' ),
			array( '00:22', 'NYPD + you receive simultaneous alert.' ),
			array( '00:51', 'Officers on scene; suspect detained.' ),
		),
		'img'    => 'https://images.unsplash.com/photo-1604754742629-3e5728249d73?w=900&q=80',
	),
	'site' => array(
		'label'  => __( 'On-site', 'nyas' ),
		'icon'   => 'hardhat',
		'live'   => __( 'Brooklyn', 'nyas' ),
		'title'  => 'Brooklyn construction site, Sunday',
		'story'  => 'Temporary tower with 360° thermal cameras detects a person climbing the perimeter fence. AI verifies humans (not animals or shadows), and the speakerphone issues a live warning.',
		'events' => array(
			array( '00:00', 'Thermal AI flags human-shape at perimeter.' ),
			array( '00:03', 'Operator confirms; broadcast warning fires.' ),
			array( '00:11', 'Suspect retreats. Tower keeps tracking.' ),
			array( '00:23', 'GC notified by SMS with timestamped clip.' ),
			array( '00:34', 'Police log filed; insurance evidence packaged.' ),
		),
		'img'    => 'https://images.unsplash.com/photo-1503387762-592deb58ef4e?w=900&q=80',
	),
	'fire' => array(
		'label'  => __( 'When fire strikes', 'nyas' ),
		'icon'   => 'fire',
		'live'   => __( 'Manhattan', 'nyas' ),
		'title'  => 'Upper East Side townhouse, 4:09 a.m.',
		'story'  => 'Photoelectric smoke + heat-rate sensors in the basement trigger together. The local siren and strobes fire instantly — waking the family with enough time to evacuate — while alarms auto-dispatch to FDNY without operator delay.',
		'events' => array(
			array( '00:00', 'Smoke + 12°/min heat rise detected on Zone 7 (basement).' ),
			array( '00:02', 'Local sirens + strobes wake the family — evacuation underway.' ),
			array( '00:04', 'Auto-dispatch to FDNY (no callback delay).' ),
			array( '00:14', 'Family voice-line opens; head-count confirmed safe outside.' ),
			array( '04:30', 'FDNY arrives. Family already evacuated; damage limited to basement.' ),
		),
		'img'    => 'https://images.unsplash.com/photo-1571055107559-3e67626fa8be?w=900&q=80',
	),
);
?>

<section class="section-paper" data-nyas-scenarios>
	<div class="container">
		<div style="margin-bottom:32px;max-width:720px">
			<?php nyas_eyebrow( __( 'What happens when', 'nyas' ), false, 'margin-bottom:16px' ); ?>
			<h2 class="display-lg"><?php esc_html_e( 'A Real Alarm. A Real Response.', 'nyas' ); ?> <em><?php esc_html_e( 'In Under a Minute.', 'nyas' ); ?></em></h2>
			<p class="muted" style="font-size:17px;line-height:1.6;margin-top:12px">
				<?php esc_html_e( 'See exactly what our monitoring station does the moment a sensor trips — at home, at your business, on a construction site, or during a fire.', 'nyas' ); ?>
			</p>
		</div>

		<div class="scenario-tabs" role="tablist">
			<?php foreach ( $scenarios as $key => $s ) : ?>
				<button role="tab" type="button" class="scenario-tab<?php echo 'home' === $key ? ' on' : ''; ?>" data-scenario-tab="<?php echo esc_attr( $key ); ?>" aria-selected="<?php echo 'home' === $key ? 'true' : 'false'; ?>">
					<span style="display:inline-flex;align-items:center;gap:8px">
						<?php nyas_icon( $s['icon'], 16 ); ?> <?php echo esc_html( $s['label'] ); ?>
					</span>
				</button>
			<?php endforeach; ?>
		</div>

		<?php foreach ( $scenarios as $key => $d ) : ?>
			<div class="scenario-body nyas-scenario-body" data-scenario-body="<?php echo esc_attr( $key ); ?>" style="display:<?php echo 'home' === $key ? 'grid' : 'none'; ?>;grid-template-columns:1.1fr 1fr;gap:48px;align-items:stretch">
				<div>
					<h3 style="font-family:var(--ff-display);font-weight:800;font-size:32px;letter-spacing:-0.02em;margin-bottom:16px"><?php echo esc_html( $d['title'] ); ?></h3>
					<p style="font-size:16px;line-height:1.6;color:var(--fg-2);margin-bottom:28px;max-width:520px"><?php echo esc_html( $d['story'] ); ?></p>
					<div style="background:var(--bg-sunk);border-radius:14px;padding:4px">
						<?php
						$count = count( $d['events'] );
						foreach ( $d['events'] as $i => $ev ) :
							$is_last = $i === $count - 1;
							$tcol    = $is_last ? 'var(--brand-success)' : 'var(--brand-signal-2)';
							$border  = $is_last ? 'none' : '1px solid var(--border)';
							?>
							<div style="display:grid;grid-template-columns:64px 1fr;gap:16px;padding:14px 18px;border-bottom:<?php echo esc_attr( $border ); ?>;align-items:center">
								<span style="font-family:var(--ff-mono);font-size:13px;font-weight:600;color:<?php echo esc_attr( $tcol ); ?>"><?php echo esc_html( $ev[0] ); ?></span>
								<span style="font-size:14px;line-height:1.5;color:var(--fg)"><?php echo esc_html( $ev[1] ); ?></span>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
				<div style="position:relative;border-radius:16px;overflow:hidden;min-height:420px">
					<?php nyas_photo( $d['img'], $d['title'], 'position:absolute;inset:0;border-radius:16px' ); ?>
					<div style="position:absolute;top:20px;left:20px;right:20px;display:flex;justify-content:space-between;align-items:center">
						<span style="background:rgba(11,18,32,0.85);backdrop-filter:blur(8px);color:#fff;font-size:11px;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;padding:6px 12px;border-radius:999px">
							<span style="display:inline-block;width:7px;height:7px;border-radius:50%;background:#7AA0FF;margin-right:8px;vertical-align:middle"></span>
							<?php
							/* translators: %s: borough name. */
							printf( esc_html__( 'Live · %s', 'nyas' ), esc_html( $d['live'] ) );
							?>
						</span>
						<span style="background:rgba(11,18,32,0.85);backdrop-filter:blur(8px);color:#fff;font-size:11px;font-weight:700;padding:6px 12px;border-radius:999px;font-family:var(--ff-mono)">
							<?php esc_html_e( 'Avg dispatch · 28s', 'nyas' ); ?>
						</span>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</section>
