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

<?php // ── Why NYC is different ── ?>
<section class="section-paper" id="why-nyc">
	<div class="container">
		<div style="display:grid;grid-template-columns:1fr 1.6fr;gap:64px;align-items:start">
			<div>
				<?php nyas_eyebrow( __( 'Why NYC is different', 'nyas' ), true, 'margin-bottom:16px' ); ?>
				<h2 class="display-lg"><?php esc_html_e( 'A New York property isn\'t a', 'nyas' ); ?> <em><?php esc_html_e( 'suburban', 'nyas' ); ?></em> <?php esc_html_e( 'property.', 'nyas' ); ?></h2>
			</div>
			<div class="seo-prose">
				<p><?php esc_html_e( 'Most national alarm companies sell a kit designed for a 2,400-square-foot ranch in Plano, Texas. Then they ship it to a fourth-floor walk-up in Hell\'s Kitchen and wonder why the install takes two days and the customer has questions the technician can\'t answer.', 'nyas' ); ?></p>
				<p><?php esc_html_e( 'We\'ve been wiring brownstones, pre-war co-ops, condos, lofts, warehouses, and storefronts across the five boroughs since 2009. Every build is shaped by what NYC actually is: lath-and-plaster walls, vintage wiring, board approvals, party walls, fire escapes, alley cameras, and the inescapable fact that your neighbor is two inches away.', 'nyas' ); ?></p>
				<p><?php esc_html_e( 'The result is a system specified for the property — not pulled off a shelf. Wireless mesh panels for buildings where you can\'t open a wall. Glass-break sensors tuned for the high-frequency signature of bay-window panes. Door contacts low-profile enough that your co-op board will never write you a letter about them.', 'nyas' ); ?></p>
			</div>
		</div>
	</div>
</section>

<?php // ── By property type ── ?>
<section>
	<div class="container">
		<div style="margin-bottom:48px;max-width:720px">
			<?php nyas_eyebrow( __( 'By property type', 'nyas' ), true, 'margin-bottom:16px' ); ?>
			<h2 class="display-lg"><?php esc_html_e( 'A different system for', 'nyas' ); ?> <em><?php esc_html_e( 'each kind of property.', 'nyas' ); ?></em></h2>
			<p class="muted" style="font-size:16px;margin-top:12px">
				<?php esc_html_e( 'What we install depends on what you live or work in. Here\'s how the build changes across the most common NYC property types — and the gotchas we plan around.', 'nyas' ); ?>
			</p>
		</div>
		<div class="grid grid-3">
			<?php
			$ptypes = array(
				array(
					'tag'    => __( 'Brownstone / townhouse', 'nyas' ),
					'title'  => __( 'Three to five floors, often pre-war', 'nyas' ),
					'body'   => __( 'Wired runs through the cellar; wireless above. We protect the parlor-level windows, the kitchen door to the garden, and the cellar hatch. Glass-break for bay windows. Smoke + heat for the kitchen and top-floor mechanical room.', 'nyas' ),
					'points' => array( __( 'Parlor + garden access', 'nyas' ), __( 'Cellar hatch / coal chute', 'nyas' ), __( 'Roof bulkhead door', 'nyas' ) ),
				),
				array(
					'tag'    => __( 'Pre-war co-op or condo', 'nyas' ),
					'title'  => __( 'Plaster walls, board approval', 'nyas' ),
					'body'   => __( 'Wireless-only, no chases. We supply the certificate of insurance and ACR forms before the install, so your super and management never need to chase paperwork. Lithium battery sensors run five years; no drilling for power.', 'nyas' ),
					'points' => array( __( 'Front-door + service-door contacts', 'nyas' ), __( 'In-unit motion + window protection', 'nyas' ), __( 'Board paperwork pre-filed', 'nyas' ) ),
				),
				array(
					'tag'    => __( 'Modern condo / new construction', 'nyas' ),
					'title'  => __( 'Pre-wired, smart-home ready', 'nyas' ),
					'body'   => __( 'Often we integrate with what the developer roughed in — Brilliant, Lutron, Nest, Ecobee, Ring. We run the alarm core, then bridge to your existing devices. Cellular backup is mandatory; building Wi-Fi can\'t be trusted.', 'nyas' ),
					'points' => array( __( 'Smart-home integration', 'nyas' ), __( 'Garage + parking-level monitoring', 'nyas' ), __( 'Two-way audio at the buzzer', 'nyas' ) ),
				),
				array(
					'tag'    => __( 'Single-family detached', 'nyas' ),
					'title'  => __( 'Queens, Bronx, Staten Island', 'nyas' ),
					'body'   => __( 'These look most like a national-spec install — but with NYC twists. We add yard-perimeter motion, driveway cameras, and outdoor sirens that don\'t spook the neighbors at 3 a.m. Outdoor-rated cabling, every joint sealed.', 'nyas' ),
					'points' => array( __( 'Yard + driveway cameras', 'nyas' ), __( 'Outdoor sirens & strobes', 'nyas' ), __( 'Detached garage protection', 'nyas' ) ),
				),
				array(
					'tag'    => __( 'Loft / converted industrial', 'nyas' ),
					'title'  => __( 'High ceilings, big windows', 'nyas' ),
					'body'   => __( 'Long-range PIR + microwave dual-tech to clear 18-foot ceilings. Glass-break for the inevitable warehouse windows. Cameras mounted on column braces. We map the freight-elevator hatch — a frequent blind spot.', 'nyas' ),
					'points' => array( __( 'High-ceiling motion coverage', 'nyas' ), __( 'Freight-elevator zone', 'nyas' ), __( 'Roof-deck access', 'nyas' ) ),
				),
				array(
					'tag'    => __( 'Rental — owner-permitted', 'nyas' ),
					'title'  => __( 'Wireless, removable, lease-friendly', 'nyas' ),
					'body'   => __( 'For renters with a written landlord OK. Everything is peel-and-stick or magnetic mount. No drilling. When you move, the whole system comes with you — or transfers to the next address for a flat fee.', 'nyas' ),
					'points' => array( __( 'No-drill install', 'nyas' ), __( 'Transfers when you move', 'nyas' ), __( 'Landlord-letter included', 'nyas' ) ),
				),
			);
			foreach ( $ptypes as $p ) : ?>
				<div class="card" style="padding:28px;display:flex;flex-direction:column;gap:12px">
					<span class="eyebrow" style="color:var(--brand-signal-2)"><?php echo esc_html( $p['tag'] ); ?></span>
					<h3 style="font-family:var(--ff-display);font-weight:800;font-size:22px;letter-spacing:-0.01em;line-height:1.15"><?php echo esc_html( $p['title'] ); ?></h3>
					<p style="margin:0;font-size:14px;line-height:1.55;color:var(--fg-2)"><?php echo esc_html( $p['body'] ); ?></p>
					<ul style="list-style:none;padding:14px 0 0;margin:8px 0 0;display:flex;flex-direction:column;gap:6px;border-top:1px solid var(--border)">
						<?php foreach ( $p['points'] as $pt ) : ?>
							<li style="display:flex;gap:8px;font-size:13px;color:var(--fg-2)">
								<span style="color:var(--brand-signal-2);flex-shrink:0;margin-top:2px"><?php nyas_icon( 'check', 14 ); ?></span>
								<?php echo esc_html( $pt ); ?>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php // ── Neighborhoods served ── ?>
<section>
	<div class="container">
		<div style="display:grid;grid-template-columns:1fr 1.5fr;gap:56px;align-items:start">
			<div>
				<?php nyas_eyebrow( __( 'Where we install', 'nyas' ), true, 'margin-bottom:16px' ); ?>
				<h2 class="display-lg" style="margin-bottom:16px"><?php esc_html_e( 'All five boroughs.', 'nyas' ); ?> <em><?php esc_html_e( 'One number.', 'nyas' ); ?></em></h2>
				<p style="font-size:16px;line-height:1.6;color:var(--fg-2);max-width:380px">
					<?php esc_html_e( 'Same-week site walks across NYC. Most properties are visited within 48 hours of the first call. We dispatch from three depots: Long Island City, the South Bronx, and Sunset Park.', 'nyas' ); ?>
				</p>
			</div>
			<div class="grid grid-2" style="gap:16px">
				<?php
				$regions = array(
					array( 'Manhattan',     'Upper East Side · Upper West Side · Hell\'s Kitchen · Tribeca · West Village · East Village · Harlem · Washington Heights · Inwood · Murray Hill' ),
					array( 'Brooklyn',      'Park Slope · Brooklyn Heights · Cobble Hill · Carroll Gardens · Williamsburg · Greenpoint · Bed-Stuy · Crown Heights · Prospect Heights · Bay Ridge' ),
					array( 'Queens',        'Astoria · Long Island City · Forest Hills · Sunnyside · Jackson Heights · Bayside · Flushing · Rego Park · Forest Park · Howard Beach' ),
					array( 'The Bronx',     'Riverdale · Kingsbridge · Pelham Bay · Throggs Neck · Country Club · Fieldston · Morris Park · Pelham Gardens · Schuylerville' ),
					array( 'Staten Island', 'St. George · Tottenville · Great Kills · Eltingville · Annadale · Westerleigh · Dongan Hills · New Springville · Todt Hill' ),
					array( 'Beyond NYC',    'Yonkers · Mount Vernon · Hoboken · Jersey City · Edgewater · Greenwich (limited) · Larchmont · Pelham · Bronxville · Scarsdale' ),
				);
				foreach ( $regions as $r ) : ?>
					<div style="padding:20px 0;border-top:1px solid var(--border-strong)">
						<h3 style="font-family:var(--ff-display);font-weight:800;font-size:17px;margin-bottom:8px"><?php echo esc_html( $r[0] ); ?></h3>
						<p style="margin:0;font-size:13px;color:var(--fg-2);line-height:1.5"><?php echo esc_html( $r[1] ); ?></p>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>

<?php // ── Mistakes we see ── ?>
<section class="section-paper">
	<div class="container">
		<div style="margin-bottom:48px;max-width:720px">
			<?php nyas_eyebrow( __( 'Mistakes we see', 'nyas' ), true, 'margin-bottom:16px' ); ?>
			<h2 class="display-lg"><?php esc_html_e( 'Five mistakes NYC buyers make', 'nyas' ); ?> <em><?php esc_html_e( 'before they call us.', 'nyas' ); ?></em></h2>
		</div>
		<div class="grid grid-2" style="gap:24px">
			<?php
			$mistakes = array(
				array( '01', __( 'Buying a national kit off Amazon', 'nyas' ),         __( 'Most consumer kits depend on Wi-Fi, ship without a cellular module, and use sensors tuned for new-construction drywall. They miss glass-break events on bay windows and cry false-alarm on every steam-radiator click.', 'nyas' ) ),
				array( '02', __( 'Skipping the cellular backup', 'nyas' ),             __( 'If your alarm reports over Wi-Fi only, a thief who unplugs the router has just disarmed your property. Every NYAS install ships with an LTE-M cellular module that runs even when power and internet are down.', 'nyas' ) ),
				array( '03', __( 'Locking into a 36-month contract', 'nyas' ),         __( 'National companies subsidize the hardware in exchange for a long-term monitoring contract. The math only works for them. Hardware should be one-time. Monitoring should be month-to-month. Period.', 'nyas' ) ),
				array( '04', __( 'Forgetting the cellar hatch', 'nyas' ),              __( 'In brownstones, the cellar hatch is the most-broken-in entry point in the city — and the most-overlooked on a self-installed system. Same goes for fire escapes, garden gates, and roof bulkheads.', 'nyas' ) ),
				array( '05', __( 'Ignoring the insurance discount', 'nyas' ),          __( 'Most NYC insurers (Chubb, Travelers, Liberty, Pure) discount 5–20% on premiums for a centrally-monitored system with a stamped certificate. Over a decade, the discount typically pays for the entire monitoring fee.', 'nyas' ) ),
				array( '06', __( 'Not telling the co-op board', 'nyas' ),              __( 'Some boards require notification (or pre-approval) before any device is installed. We pre-file ACR forms, supply the cert of insurance, and brief the super before we arrive. It\'s the difference between an install and a stop-work order.', 'nyas' ) ),
			);
			foreach ( $mistakes as $m ) : ?>
				<div style="padding:28px;background:var(--n-0);border:1px solid var(--border);border-radius:16px;display:flex;flex-direction:column;gap:10px">
					<span style="font-family:var(--ff-mono);font-size:12px;letter-spacing:0.12em;color:var(--brand-signal-2)"><?php
						/* translators: %s: zero-padded mistake number. */
						printf( esc_html__( 'MISTAKE %s', 'nyas' ), esc_html( $m[0] ) );
					?></span>
					<h3 style="font-family:var(--ff-display);font-weight:800;font-size:20px;letter-spacing:-0.01em"><?php echo esc_html( $m[1] ); ?></h3>
					<p style="margin:0;font-size:14px;line-height:1.55;color:var(--fg-2)"><?php echo esc_html( $m[2] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php // ── Glossary ── ?>
<section>
	<div class="container">
		<div style="display:grid;grid-template-columns:1fr 1.5fr;gap:56px;align-items:start">
			<div>
				<?php nyas_eyebrow( __( 'Glossary', 'nyas' ), true, 'margin-bottom:16px' ); ?>
				<h2 class="display-lg"><?php esc_html_e( 'Plain English on', 'nyas' ); ?> <em><?php esc_html_e( 'alarm jargon.', 'nyas' ); ?></em></h2>
				<p style="font-size:15px;line-height:1.6;color:var(--fg-2);margin-top:12px;max-width:320px">
					<?php esc_html_e( 'Most quotes you\'ll receive from competitors are written to confuse. Here\'s what each term actually means.', 'nyas' ); ?>
				</p>
			</div>
			<div>
				<?php
				$glossary = array(
					array( __( 'UL-listed monitoring', 'nyas' ),    __( 'Underwriters Laboratories certifies central stations that meet operational and physical-security standards (UL 827). Insurers usually require it for premium discounts. Ours is in Long Island City.', 'nyas' ) ),
					array( __( 'LTE-M / cellular backup', 'nyas' ), __( 'A small cellular radio inside the panel that reports alarms even when your internet, Wi-Fi, or power is out. Non-negotiable in NYC.', 'nyas' ) ),
					array( __( 'Glass-break sensor', 'nyas' ),      __( 'A microphone tuned to the high-frequency signature of breaking glass. Catches break-ins before the intruder reaches the window contact.', 'nyas' ) ),
					array( __( 'Dual-tech motion', 'nyas' ),        __( 'A motion sensor that requires both passive infrared (PIR) and microwave to trigger together. Cuts false alarms from steam radiators, sun, and pets.', 'nyas' ) ),
					array( __( 'Verified video', 'nyas' ),          __( 'Before we dispatch police, our operator opens the camera feed and confirms a real event. Verified video drops false dispatches by 91% — saving you fines and saving the NYPD trips.', 'nyas' ) ),
					array( __( 'Two-way audio', 'nyas' ),           __( 'Speaker + mic at the panel and at the doorbell. Operators can challenge an intruder by name — which usually ends the encounter on its own.', 'nyas' ) ),
					array( __( 'ACR / building work permit', 'nyas' ), __( 'New York-specific paperwork some co-ops or condos require before any wall penetration. We handle it for you.', 'nyas' ) ),
					array( __( 'Month-to-month', 'nyas' ),          __( 'You can cancel monitoring with 30 days\' written notice. No early-termination fee. Hardware stays yours.', 'nyas' ) ),
				);
				foreach ( $glossary as $g ) : ?>
					<div style="padding:18px 0;border-top:1px solid var(--border)">
						<h3 style="font-family:var(--ff-display);font-weight:700;font-size:17px;margin-bottom:6px"><?php echo esc_html( $g[0] ); ?></h3>
						<p style="margin:0;font-size:14px;line-height:1.55;color:var(--fg-2)"><?php echo esc_html( $g[1] ); ?></p>
					</div>
				<?php endforeach; ?>
			</div>
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
