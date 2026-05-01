<?php
/**
 * Homepage — recreates home.html / home.jsx as a static, server-rendered page.
 *
 * Sections:
 *   1. Hero (variant D — spec sheet, the design's default)
 *   2. Trust strip
 *   3. Quote section
 *   4. Services grid (asymmetric "ten ways we keep watch")
 *   5. Service quiz (find-my-fit)
 *   6. How it works
 *   7. Scenarios (tabbed explainer)
 *   8. Why us / differentiators
 *   9. Compare table
 *  10. Featured case study
 *  11. Testimonials
 *  12. Coverage map (Leaflet)
 *  13. FAQ
 *  14. Recent insights
 *  15. Final CTA
 *
 * @package NYAS
 */

get_header();

$services = nyas_services();
?>

<?php
// ─── 1. Hero — Variant D (spec sheet) ───
$hw_panel = 'https://images.unsplash.com/photo-1558002038-1055907df827?w=1400&q=80';
?>
<section class="hero-specsheet">
	<div class="container hero-specsheet-inner">
		<div class="hero-specsheet-left">
			<h1 class="hero-specsheet-title">
				<?php esc_html_e( 'One system.', 'nyas' ); ?><br /><em><?php esc_html_e( 'Every entry point.', 'nyas' ); ?></em>
			</h1>
			<p class="hero-cream-lede">
				<?php esc_html_e( 'Alarm panel, perimeter sensors, AI cameras, and 24/7 NYC monitoring — engineered to work as one.', 'nyas' ); ?>
			</p>
			<div class="hero-fb-cta">
				<a href="#quote" class="btn btn-lg btn-signal"><?php esc_html_e( 'Free quote', 'nyas' ); ?> <?php nyas_icon( 'arrow-right', 15 ); ?></a>
				<a href="<?php echo esc_url( home_url( '/services/' ) ); ?>" class="btn btn-lg btn-ghost"><?php esc_html_e( 'View specs', 'nyas' ); ?></a>
			</div>
		</div>
		<div class="hero-specsheet-right">
			<div class="hero-specsheet-stage">
				<img src="<?php echo esc_url( $hw_panel ); ?>" alt="<?php esc_attr_e( 'System hardware', 'nyas' ); ?>" />
			</div>
			<div class="hero-specsheet-cards">
				<?php
				$spec_cards = array(
					array( 'icon' => 'sensor',  'n' => '01', 't' => __( 'Sensor', 'nyas' ),   's' => __( 'Door, window, glass-break, motion', 'nyas' ) ),
					array( 'icon' => 'cam',     'n' => '02', 't' => __( 'Camera', 'nyas' ),   's' => __( '4K, AI verify, two-way audio', 'nyas' ) ),
					array( 'icon' => 'monitor', 'n' => '03', 't' => __( 'Monitor', 'nyas' ),  's' => __( 'UL-listed, in Long Island City', 'nyas' ) ),
					array( 'icon' => 'bell',    'n' => '04', 't' => __( 'Dispatch', 'nyas' ), 's' => __( '28s median to NYPD/FDNY', 'nyas' ) ),
				);
				foreach ( $spec_cards as $c ) :
					?>
					<div class="hero-specsheet-card">
						<div class="hero-specsheet-card-icon"><?php nyas_icon( $c['icon'], 20 ); ?></div>
						<div class="hero-specsheet-card-meta"><?php echo esc_html( $c['n'] ); ?></div>
						<div class="hero-specsheet-card-title"><?php echo esc_html( $c['t'] ); ?></div>
						<div class="hero-specsheet-card-sub"><?php echo esc_html( $c['s'] ); ?></div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>

<?php // ─── 2. Trust strip ─── ?>
<section style="padding:32px 0;border-top:1px solid var(--border);border-bottom:1px solid var(--border);background:var(--brand-paper)">
	<div class="container">
		<div class="featured-in" style="display:grid;grid-template-columns:auto 1fr;gap:48px;align-items:center">
			<div class="eyebrow" style="white-space:nowrap"><?php esc_html_e( 'As featured in', 'nyas' ); ?></div>
			<div class="featured-in-logos" style="display:flex;justify-content:space-between;align-items:center;gap:32px;flex-wrap:wrap;opacity:0.62">
				<?php
				$pubs = array( 'New York Times', 'Crain&rsquo;s', 'Brick Underground', 'Time Out NY', 'amNewYork', 'Brooklyn Eagle' );
				foreach ( $pubs as $p ) {
					echo '<span style="font-family:var(--ff-display);font-weight:800;font-size:22px;color:var(--fg);letter-spacing:-0.01em">' . wp_kses_post( $p ) . '</span>';
				}
				?>
			</div>
		</div>
	</div>
</section>

<?php // ─── 3. Quote section ─── ?>
<section class="quote-section section-paper">
	<div class="container quote-section-inner">
		<div class="quote-section-copy">
			<?php nyas_eyebrow( __( 'Get started', 'nyas' ), true, 'margin-bottom:16px' ); ?>
			<h2 class="display-lg" style="margin-bottom:20px"><?php esc_html_e( 'Free quote in', 'nyas' ); ?> <em><?php esc_html_e( '15 minutes.', 'nyas' ); ?></em></h2>
			<p style="font-size:17px;line-height:1.6;color:var(--fg-2);margin-bottom:28px;max-width:480px">
				<?php esc_html_e( 'Tell us about the space. A licensed NY consultant calls or texts you back today — no high-pressure sales, no obligation.', 'nyas' ); ?>
			</p>
			<ul class="quote-bullets">
				<li><?php nyas_icon( 'check', 16 ); ?> <?php esc_html_e( 'Free site walk within 48 hours', 'nyas' ); ?></li>
				<li><?php nyas_icon( 'check', 16 ); ?> <?php esc_html_e( 'One-page proposal, no bundles', 'nyas' ); ?></li>
				<li><?php nyas_icon( 'check', 16 ); ?> <?php esc_html_e( 'Equipment you own, monitoring month-to-month', 'nyas' ); ?></li>
				<li><?php nyas_icon( 'check', 16 ); ?> <?php esc_html_e( 'Insurance-discount certificate included', 'nyas' ); ?></li>
			</ul>
		</div>
		<div id="quote" class="quote-section-form">
			<div style="display:inline-flex;align-items:center;gap:8px;padding:5px 12px;border-radius:999px;background:var(--brand-signal-soft);color:var(--brand-signal-2);font-size:11px;font-weight:800;letter-spacing:0.10em;text-transform:uppercase;margin-bottom:16px">
				<span style="width:6px;height:6px;border-radius:50%;background:var(--brand-signal)"></span>
				<?php esc_html_e( 'Free, no-obligation', 'nyas' ); ?>
			</div>
			<h3 style="font-family:var(--ff-display);font-size:28px;font-weight:800;line-height:1.05;margin-bottom:8px;letter-spacing:-0.02em">
				<?php esc_html_e( 'Get my quote', 'nyas' ); ?>
			</h3>
			<p style="font-size:14px;color:var(--fg-2);margin:0 0 22px"><?php esc_html_e( 'Licensed NY consultant calls within 15 min.', 'nyas' ); ?></p>
			<?php nyas_lead_form(); ?>
		</div>
	</div>
</section>

<?php // ─── 4. Services grid (asymmetric) ─── ?>
<section class="services-modern">
	<div class="container">
		<div class="services-header">
			<div>
				<?php nyas_eyebrow( __( 'Services', 'nyas' ), true, 'margin-bottom:16px' ); ?>
				<h2 class="display-lg"><?php esc_html_e( 'Ten ways we keep', 'nyas' ); ?> <em><?php esc_html_e( 'watch.', 'nyas' ); ?></em></h2>
			</div>
			<p class="muted" style="max-width:380px;margin:0">
				<?php esc_html_e( 'One installer, one number to call, one app for every property you own — from a Park Slope walk-up to a fleet of Bronx warehouses.', 'nyas' ); ?>
			</p>
		</div>

		<div class="services-stage">
			<?php $featured = $services[0]; ?>
			<div class="services-preview" data-nyas-services-preview>
				<?php foreach ( $services as $idx => $svc ) : ?>
					<div class="services-preview-img" data-services-preview-id="<?php echo esc_attr( $svc['id'] ); ?>"<?php echo $idx === 0 ? '' : ' hidden'; ?>>
						<?php nyas_photo( $svc['img'], $svc['name'], 'position:absolute;inset:0;border-radius:0' ); ?>
						<div class="services-preview-overlay"></div>
						<div class="services-preview-meta">
							<span class="services-preview-num"><?php echo esc_html( str_pad( (string) ( $idx + 1 ), 2, '0', STR_PAD_LEFT ) . ' / ' . count( $services ) ); ?></span>
							<span class="services-preview-icon"><?php nyas_icon( $svc['icon'], 18 ); ?></span>
						</div>
						<div class="services-preview-body">
							<h3><?php echo esc_html( $svc['short'] ); ?></h3>
							<p><?php echo esc_html( $svc['desc'] ); ?></p>
							<a href="<?php echo esc_url( home_url( '/services/' . $svc['id'] . '/' ) ); ?>" class="services-preview-cta">
								<?php
								/* translators: %s: service name. */
								printf( esc_html__( 'Explore %s', 'nyas' ), esc_html( strtolower( $svc['short'] ) ) );
								?>
								<?php nyas_icon( 'arrow-right', 14 ); ?>
							</a>
						</div>
					</div>
				<?php endforeach; ?>
			</div>

			<ul class="services-list">
				<?php foreach ( $services as $idx => $svc ) : ?>
					<li>
						<a href="<?php echo esc_url( home_url( '/services/' . $svc['id'] . '/' ) ); ?>" class="services-tile<?php echo $idx === 0 ? ' on' : ''; ?>" data-services-tile="<?php echo esc_attr( $svc['id'] ); ?>">
							<span class="services-tile-num"><?php echo esc_html( str_pad( (string) ( $idx + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span>
							<span class="services-tile-icon"><?php nyas_icon( $svc['icon'], 20 ); ?></span>
							<span class="services-tile-name"><?php echo esc_html( $svc['short'] ); ?></span>
							<span class="services-tile-arrow"><?php nyas_icon( 'arrow-right', 16 ); ?></span>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
</section>

<?php // ─── 5. Service quiz ─── ?>
<?php get_template_part( 'template-parts/section', 'quiz' ); ?>

<?php // ─── 6. How it works ─── ?>
<section class="how-modern">
	<div class="container">
		<div class="how-header">
			<div>
				<?php nyas_eyebrow( __( 'How it works', 'nyas' ), true, 'margin-bottom:16px' ); ?>
				<h2 class="display-lg" style="max-width:720px"><?php esc_html_e( 'Four steps. No', 'nyas' ); ?> <em><?php esc_html_e( 'upsell.', 'nyas' ); ?></em></h2>
			</div>
			<p class="muted" style="max-width:420px;margin:0">
				<?php esc_html_e( 'From the first call to the day we go live — here\'s what every NYAS install looks like.', 'nyas' ); ?>
			</p>
		</div>

		<div class="how-rail">
			<div class="how-line"></div>
			<?php
			$steps = array(
				array( 'n' => '01', 'icon' => 'pin',          'title' => 'Free site walk',     'when' => 'Within 48 hours', 'body' => 'A licensed NY consultant visits your property — usually within 48 hours — to map entry points, blind spots, and risk vectors.' ),
				array( 'n' => '02', 'icon' => 'briefcase',    'title' => 'Right-sized quote',  'when' => 'Same week',       'body' => 'You get a one-page proposal with hardware, monitoring, and labor itemized. No bundles. No "starter" gimmicks.' ),
				array( 'n' => '03', 'icon' => 'shield-check', 'title' => 'Clean installation', 'when' => '1 – 2 days on site', 'body' => 'In-house technicians (no subcontractors) wire and configure your system, typically in a day for a home, two for a small business.' ),
				array( 'n' => '04', 'icon' => 'monitor',      'title' => 'We watch, you live', 'when' => '24 / 7 / 365',    'body' => 'Our UL-listed station in Long Island City confirms alarms, calls 911, and reaches you — every day of the year.' ),
			);
			foreach ( $steps as $s ) : ?>
				<div class="how-card">
					<div class="how-node">
						<div class="how-node-dot"></div>
						<div class="how-node-icon"><?php nyas_icon( $s['icon'], 22 ); ?></div>
					</div>
					<div class="how-when"><?php echo esc_html( $s['when'] ); ?></div>
					<div class="how-num"><?php echo esc_html( $s['n'] ); ?></div>
					<h3 class="how-title"><?php echo esc_html( $s['title'] ); ?></h3>
					<p class="how-body"><?php echo esc_html( $s['body'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php // ─── 7. Scenarios (tabbed) ─── ?>
<?php get_template_part( 'template-parts/section', 'scenarios' ); ?>

<?php // ─── 8. Why us ─── ?>
<section class="section-sunk">
	<div class="container">
		<div style="display:grid;grid-template-columns:1fr 2fr;gap:64px;align-items:start;margin-bottom:48px" class="nyas-why-head">
			<div>
				<?php nyas_eyebrow( __( 'Why us', 'nyas' ), true, 'margin-bottom:16px' ); ?>
				<h2 class="display-lg"><?php esc_html_e( 'Six reasons', 'nyas' ); ?> <em><?php esc_html_e( 'NY chooses us.', 'nyas' ); ?></em></h2>
			</div>
			<p style="font-size:17px;line-height:1.6;color:var(--fg-2);max-width:580px">
				<?php esc_html_e( 'Most national alarm companies sell hardware. We sell response time, accountability, and a phone number that gets answered the first ring — even at 3 a.m. on a Tuesday.', 'nyas' ); ?>
			</p>
		</div>
		<div class="grid" style="grid-template-columns:repeat(3,1fr)">
			<?php
			$why = array(
				array( 'icon' => 'zap',          'title' => '30-second dispatch', 'desc' => 'We measure every alarm. Our 12-month rolling median is 28 seconds, station to officer.' ),
				array( 'icon' => 'users',        'title' => 'No subcontractors', 'desc' => 'Every technician on your property is a W-2 employee, background-checked, and badge-carrying.' ),
				array( 'icon' => 'pin',          'title' => 'Local monitoring',   'desc' => 'Your alarm is watched from Long Island City — not a third-party center in Texas or Manila.' ),
				array( 'icon' => 'lock',         'title' => 'Equipment you own',  'desc' => 'No leases. No predatory 5-year contracts. Cancel monitoring with 30 days\' notice, anytime.' ),
				array( 'icon' => 'award',        'title' => 'UL & FM listed',     'desc' => 'Our central station carries UL 827, FM 3010, and NYPD-recognized burglar response certifications.' ),
				array( 'icon' => 'shield-check', 'title' => 'Insurance-grade',    'desc' => 'Direct integration with Chubb, Travelers, and most NY commercial insurers for premium discounts.' ),
			);
			foreach ( $why as $it ) : ?>
				<div style="padding:28px 4px;border-top:1px solid var(--border-strong)">
					<div style="width:44px;height:44px;border-radius:10px;background:var(--brand-ink);color:var(--brand-signal);display:inline-flex;align-items:center;justify-content:center;margin-bottom:16px">
						<?php nyas_icon( $it['icon'], 22 ); ?>
					</div>
					<h3 style="font-family:var(--ff-display);font-weight:800;font-size:22px;letter-spacing:-0.01em;margin-bottom:8px"><?php echo esc_html( $it['title'] ); ?></h3>
					<p style="margin:0;font-size:14px"><?php echo esc_html( $it['desc'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php // ─── 9. Compare ─── ?>
<section>
	<div class="container">
		<div style="margin-bottom:40px;max-width:720px">
			<?php nyas_eyebrow( __( 'How we compare', 'nyas' ), true, 'margin-bottom:16px' ); ?>
			<h2 class="display-lg"><?php esc_html_e( 'Same alarm category.', 'nyas' ); ?> <em><?php esc_html_e( 'Different company.', 'nyas' ); ?></em></h2>
			<p class="muted" style="font-size:16px;margin-top:12px">
				<?php esc_html_e( 'We\'re an independent NYC operator. Here\'s how we stack up against the three biggest national names you\'ve probably called.', 'nyas' ); ?>
			</p>
		</div>
		<div style="overflow-x:auto">
			<table class="compare-table">
				<thead>
					<tr>
						<th></th>
						<th class="us">NYAS</th>
						<th>NationalCo A</th>
						<th>NationalCo B</th>
						<th>NationalCo C</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$rows = array(
						array( 'Equipment ownership',     'You own it',         'Leased',          'Leased',         'You own it' ),
						array( 'Contract length',         'Month-to-month',     '36-month',        '60-month',       '12-month' ),
						array( 'Monitoring location',     'Long Island City',   'Texas / Manila',  'Texas',          'Indiana' ),
						array( 'In-house technicians',    'yes',                'partial',         'no',             'partial' ),
						array( 'Avg dispatch time',       '28 seconds',         '~3 minutes',      '~4 minutes',     '~2 minutes' ),
						array( 'Insurance discount cert.','yes',                'yes',             'partial',        'yes' ),
						array( 'NYC permit handling',     'yes',                'no',              'no',             'no' ),
						array( 'Cancel notice',           '30 days',            'Full term',       'Full term',      '90 days' ),
					);
					foreach ( $rows as $r ) {
						echo '<tr>';
						echo '<td>' . esc_html( $r[0] ) . '</td>';
						$cells = array(
							array( $r[1], 'col-us' ),
							array( $r[2], '' ),
							array( $r[3], '' ),
							array( $r[4], '' ),
						);
						foreach ( $cells as $cell ) {
							list( $val, $cls ) = $cell;
							echo '<td' . ( $cls ? ' class="' . esc_attr( $cls ) . '"' : '' ) . '>';
							if ( 'yes' === $val ) {
								echo '<span class="yes">&#10003;</span>';
							} elseif ( 'no' === $val ) {
								echo '<span class="no">&mdash;</span>';
							} elseif ( 'partial' === $val ) {
								echo '<span class="partial">' . esc_html__( 'Partial', 'nyas' ) . '</span>';
							} else {
								echo '<span style="font-size:14px;font-weight:600">' . esc_html( $val ) . '</span>';
							}
							echo '</td>';
						}
						echo '</tr>';
					}
					?>
				</tbody>
			</table>
		</div>
		<p class="muted" style="font-size:12px;margin-top:16px;text-align:center">
			<?php esc_html_e( 'Comparison based on publicly available info (April 2026). Competitor names withheld; happy to share specifics on request.', 'nyas' ); ?>
		</p>
	</div>
</section>

<?php // ─── 10. Featured case study ─── ?>
<section class="section-ink" style="padding:96px 0;position:relative;overflow:hidden">
	<div class="container">
		<div class="nyas-feat-case" style="display:grid;grid-template-columns:1fr 1.1fr;gap:56px;align-items:center">
			<div>
				<?php nyas_eyebrow( __( 'Case study · 12 retail locations · Manhattan + Brooklyn', 'nyas' ), false, 'color:rgba(246,243,236,0.55);margin-bottom:16px' ); ?>
				<h2 class="display-lg" style="color:var(--fg-on-ink);margin-bottom:24px">
					<?php esc_html_e( 'How', 'nyas' ); ?> <em style="color:#3CD68C"><?php esc_html_e( 'Maman', 'nyas' ); ?></em> <?php esc_html_e( 'cut shrinkage 41% in a year.', 'nyas' ); ?>
				</h2>
				<p style="color:rgba(246,243,236,0.78);font-size:17px;line-height:1.6;margin-bottom:32px;max-width:520px">
					<?php esc_html_e( 'When the SoHo bakery chain expanded to twelve locations, after-hours theft was costing $180k a year. We replaced four alarm vendors with one integrated stack — cameras, panic buttons, and a single dashboard.', 'nyas' ); ?>
				</p>
				<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:24px;margin-bottom:32px;padding-top:28px;border-top:1px solid rgba(246,243,236,0.12)">
					<div class="stat"><span class="stat-num" style="color:var(--fg-on-ink)"><em style="color:#3CD68C">41%</em></span><span class="stat-lbl" style="color:rgba(246,243,236,0.55)"><?php esc_html_e( 'Shrinkage drop', 'nyas' ); ?></span></div>
					<div class="stat"><span class="stat-num" style="color:var(--fg-on-ink)">$73k</span><span class="stat-lbl" style="color:rgba(246,243,236,0.55)"><?php esc_html_e( 'Annual savings', 'nyas' ); ?></span></div>
					<div class="stat"><span class="stat-num" style="color:var(--fg-on-ink)">14 days</span><span class="stat-lbl" style="color:rgba(246,243,236,0.55)"><?php esc_html_e( 'Full rollout', 'nyas' ); ?></span></div>
				</div>
				<a href="<?php echo esc_url( home_url( '/cases/maman/' ) ); ?>" class="btn btn-lg btn-signal"><?php esc_html_e( 'Read the case study', 'nyas' ); ?> <?php nyas_icon( 'arrow-right', 15 ); ?></a>
			</div>
			<div style="position:relative">
				<?php nyas_photo( 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=900&q=80', 'Retail interior at night', 'aspect-ratio:4/5;border-radius:16px' ); ?>
				<div style="position:absolute;bottom:24px;left:24px;right:24px;background:rgba(11,18,32,0.85);backdrop-filter:blur(8px);border:1px solid rgba(246,243,236,0.12);border-radius:12px;padding:20px;color:var(--fg-on-ink)">
					<div style="font-size:11px;letter-spacing:0.12em;text-transform:uppercase;color:rgba(246,243,236,0.55);margin-bottom:8px"><?php esc_html_e( 'Live · 02:14 a.m.', 'nyas' ); ?></div>
					<div style="font-family:var(--ff-mono);font-size:13px;color:rgba(246,243,236,0.78);margin-bottom:4px"><?php esc_html_e( 'Maman · Spring St — Zone 4 motion', 'nyas' ); ?></div>
					<div style="font-family:var(--ff-mono);font-size:13px;color:#3CD68C"><?php esc_html_e( 'Verified false (cleaning crew). NYPD not dispatched.', 'nyas' ); ?></div>
				</div>
			</div>
		</div>
	</div>
</section>

<?php // ─── 11. Testimonials ─── ?>
<section>
	<div class="container">
		<div style="display:flex;justify-content:space-between;align-items:end;margin-bottom:48px;gap:32px;flex-wrap:wrap">
			<div>
				<?php nyas_eyebrow( __( 'What our customers say', 'nyas' ), true, 'margin-bottom:16px' ); ?>
				<h2 class="display-lg" style="max-width:720px"><?php esc_html_e( '4.9 stars across', 'nyas' ); ?> <em><?php esc_html_e( '2,100 reviews.', 'nyas' ); ?></em></h2>
			</div>
			<div style="display:flex;gap:4px;align-items:center;color:var(--brand-signal)">
				<?php for ( $i = 0; $i < 5; $i++ ) { nyas_icon( 'star', 20 ); } ?>
				<span style="margin-left:10px;font-family:var(--ff-mono);font-size:13px;color:var(--fg-2)"><?php esc_html_e( '4.94 avg.', 'nyas' ); ?></span>
			</div>
		</div>
		<div class="grid grid-3">
			<?php foreach ( nyas_testimonials() as $t ) : ?>
				<figure style="margin:0;padding:32px;background:var(--brand-paper);border:1px solid var(--border);border-radius:14px;display:flex;flex-direction:column;gap:20px">
					<div style="color:var(--brand-signal-2)"><?php nyas_icon( 'quote', 28 ); ?></div>
					<blockquote style="margin:0;font-family:var(--ff-display);font-weight:700;font-size:20px;line-height:1.4;color:var(--fg)">&ldquo;<?php echo esc_html( $t['quote'] ); ?>&rdquo;</blockquote>
					<figcaption style="display:flex;gap:12px;align-items:center;margin-top:auto;padding-top:16px;border-top:1px solid var(--border)">
						<img src="<?php echo esc_url( $t['img'] ); ?>" alt="<?php echo esc_attr( $t['name'] ); ?>" style="width:44px;height:44px;border-radius:50%;object-fit:cover" />
						<div>
							<div style="font-weight:600;font-size:14px"><?php echo esc_html( $t['name'] ); ?></div>
							<div style="font-size:12px;color:var(--fg-3)"><?php echo esc_html( $t['role'] ); ?></div>
						</div>
					</figcaption>
				</figure>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php // ─── 12. Coverage map ─── ?>
<section class="section-paper">
	<div class="container">
		<div class="nyas-coverage" style="display:grid;grid-template-columns:1fr 1fr;gap:56px;align-items:center">
			<div>
				<?php nyas_eyebrow( __( 'Coverage', 'nyas' ), true, 'margin-bottom:16px' ); ?>
				<h2 class="display-lg" style="margin-bottom:24px"><?php esc_html_e( 'All five boroughs.', 'nyas' ); ?> <em><?php esc_html_e( 'One number.', 'nyas' ); ?></em></h2>
				<p style="font-size:17px;line-height:1.6;color:var(--fg-2);max-width:480px;margin-bottom:32px">
					<?php esc_html_e( 'We don\'t outsource installation, monitoring, or service calls. Every technician dispatches from one of three NYC depots: Long Island City, the South Bronx, or Sunset Park.', 'nyas' ); ?>
				</p>
				<div style="display:flex;flex-direction:column;gap:4px">
					<?php
					$boroughs = array(
						array( 'Manhattan',     '3,420', 'Tribeca · UES · Harlem · Inwood' ),
						array( 'Brooklyn',      '2,810', 'Park Slope · Williamsburg · Bay Ridge' ),
						array( 'Queens',        '1,940', 'Astoria · LIC · Forest Hills · Jamaica' ),
						array( 'The Bronx',     '780',   'Riverdale · Fordham · Throgs Neck' ),
						array( 'Staten Island', '450',   'St. George · New Dorp · Tottenville' ),
					);
					foreach ( $boroughs as $i => $b ) :
						$top_border = 0 === $i ? '1px solid var(--border-strong)' : '1px solid var(--border)';
						?>
						<div style="display:grid;grid-template-columns:1.5fr 0.5fr 2fr;gap:16px;padding:14px 0;border-top:<?php echo esc_attr( $top_border ); ?>;align-items:baseline">
							<span style="font-family:var(--ff-display);font-weight:700;font-size:22px;letter-spacing:-0.01em"><?php echo esc_html( $b[0] ); ?></span>
							<span style="font-size:14px;color:var(--fg-3);text-align:right"><?php echo esc_html( $b[1] ); ?></span>
							<span style="font-size:13px;color:var(--fg-3);text-align:right"><?php echo esc_html( $b[2] ); ?></span>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="ny-map-wrap">
				<div id="nyas-leaflet" class="ny-map" data-nyas-map></div>
				<div class="ny-map-foot"><?php esc_html_e( '3 depots · 9,400+ properties · all five boroughs', 'nyas' ); ?></div>
			</div>
		</div>
	</div>
</section>

<?php // ─── 13. FAQ ─── ?>
<?php get_template_part( 'template-parts/section', 'faq' ); ?>

<?php // ─── 14. Recent insights ─── ?>
<section>
	<div class="container">
		<div style="display:flex;justify-content:space-between;align-items:end;margin-bottom:48px;gap:32px;flex-wrap:wrap">
			<div>
				<?php nyas_eyebrow( __( 'Insights', 'nyas' ), true, 'margin-bottom:16px' ); ?>
				<h2 class="display-lg"><?php esc_html_e( 'Field notes from the', 'nyas' ); ?> <em><?php esc_html_e( 'monitoring desk.', 'nyas' ); ?></em></h2>
			</div>
			<a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/blog/' ) ); ?>" class="btn btn-md btn-ghost"><?php esc_html_e( 'All posts', 'nyas' ); ?> <?php nyas_icon( 'arrow-right', 14 ); ?></a>
		</div>

		<div class="grid grid-3">
			<?php
			$recent = new WP_Query( array(
				'posts_per_page' => 3,
				'post_status'    => 'publish',
				'no_found_rows'  => true,
			) );

			if ( $recent->have_posts() ) {
				while ( $recent->have_posts() ) {
					$recent->the_post();
					$cat = get_the_category();
					$tag = $cat ? $cat[0]->name : __( 'Insights', 'nyas' );
					?>
					<a href="<?php the_permalink(); ?>" class="card" style="text-decoration:none;color:inherit;padding:0;overflow:hidden;display:flex;flex-direction:column">
						<?php if ( has_post_thumbnail() ) : ?>
							<?php nyas_photo( get_the_post_thumbnail_url( null, 'nyas-card' ), get_the_title(), 'aspect-ratio:4/3;border-radius:0;border-bottom:1px solid var(--border)' ); ?>
						<?php endif; ?>
						<div style="padding:24px;display:flex;flex-direction:column;gap:10px;flex:1">
							<div style="display:flex;justify-content:space-between;align-items:center;gap:12px">
								<span class="pill pill-paper"><?php echo esc_html( $tag ); ?></span>
								<span style="font-size:12px;color:var(--fg-3)"><?php echo esc_html( nyas_reading_time() ); ?></span>
							</div>
							<h3 style="font-family:var(--ff-display);font-weight:800;font-size:22px;line-height:1.15;letter-spacing:-0.01em"><?php the_title(); ?></h3>
							<div style="margin-top:auto;padding-top:16px;border-top:1px solid var(--border);font-size:12px;color:var(--fg-3);font-family:var(--ff-mono)"><?php echo esc_html( get_the_date() ); ?></div>
						</div>
					</a>
					<?php
				}
				wp_reset_postdata();
			} else {
				// Fallback to seeded posts when no WP content exists.
				foreach ( array_slice( nyas_seed_posts(), 0, 3 ) as $p ) {
					?>
					<a href="<?php echo esc_url( home_url( '/blog/' . $p['slug'] . '/' ) ); ?>" class="card" style="text-decoration:none;color:inherit;padding:0;overflow:hidden;display:flex;flex-direction:column">
						<?php nyas_photo( $p['img'], $p['title'], 'aspect-ratio:4/3;border-radius:0;border-bottom:1px solid var(--border)' ); ?>
						<div style="padding:24px;display:flex;flex-direction:column;gap:10px;flex:1">
							<div style="display:flex;justify-content:space-between;align-items:center;gap:12px">
								<span class="pill pill-paper"><?php echo esc_html( $p['tag'] ); ?></span>
								<span style="font-size:12px;color:var(--fg-3)"><?php echo esc_html( $p['read'] ); ?></span>
							</div>
							<h3 style="font-family:var(--ff-display);font-weight:800;font-size:22px;line-height:1.15;letter-spacing:-0.01em"><?php echo esc_html( $p['title'] ); ?></h3>
							<div style="margin-top:auto;padding-top:16px;border-top:1px solid var(--border);font-size:12px;color:var(--fg-3);font-family:var(--ff-mono)"><?php echo esc_html( $p['date'] ); ?></div>
						</div>
					</a>
					<?php
				}
			}
			?>
		</div>
	</div>
</section>

<?php // ─── 15. Final CTA ─── ?>
<?php nyas_final_cta(); ?>

<?php get_footer();
