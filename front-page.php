<?php
/**
 * Homepage — recreates home.html / home.jsx as a static, server-rendered page.
 *
 * Sections:
 *   1. Hero (variant D — spec sheet, the design's default)
 *   2. Trust strip
 *   3. Quote section
 *   4. Services grid (asymmetric "ten ways we keep watch")
 *   5. Quote wizard (4-step instant quote)
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

<?php // ─── 1. Hero — full-bleed video (home2 canonical) ─── ?>
<?php get_template_part( 'template-parts/section', 'hero-video' ); ?>

<?php // ─── 1b. Hero spec strip ─── ?>
<?php get_template_part( 'template-parts/section', 'hero-spec-cards' ); ?>

<?php nyas_seam( 'ink', __( 'Limited offer', 'nyas' ) ); ?>

<?php // ─── 2. Offer banner — 3 months free monitoring ─── ?>
<?php get_template_part( 'template-parts/section', 'offer' ); ?>

<?php nyas_seam( 'paper' ); ?>

<?php // ─── 4. Services grid (v2 asymmetric — image thumbs on tiles) ─── ?>
<section class="services-modern services-modern-v2">
	<div class="container">
		<div class="services-header services-header-v2">
			<div class="eyebrow services-header-eyebrow"><?php esc_html_e( 'What we protect', 'nyas' ); ?></div>
			<h2 class="display-lg"><?php esc_html_e( 'Different Properties.', 'nyas' ); ?> <em><?php esc_html_e( 'Different Security Needs.', 'nyas' ); ?></em></h2>
			<p class="services-header-intro">
				<?php esc_html_e( 'From private homes and retail stores to schools, clinics, offices, and construction sites, we design and install alarm systems around the way each property is used.', 'nyas' ); ?>
			</p>
		</div>

		<div class="services-stage">
			<div class="services-preview" data-nyas-services-preview>
				<?php foreach ( $services as $idx => $svc ) : ?>
					<div class="services-preview-img" data-services-preview-id="<?php echo esc_attr( $svc['id'] ); ?>"<?php echo $idx === 0 ? '' : ' hidden'; ?>>
						<?php nyas_photo( $svc['img'], $svc['name'], 'position:absolute;inset:0;border-radius:0' ); ?>
						<div class="services-preview-overlay"></div>
						<div class="services-preview-meta">
							<span class="services-preview-num"><?php nyas_icon( $svc['icon'], 14, 'margin-right:8px;vertical-align:middle' ); ?> <?php echo esc_html( $svc['short'] ); ?></span>
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

			<ul class="services-list services-list-v2">
				<?php foreach ( $services as $idx => $svc ) : ?>
					<li>
						<a href="<?php echo esc_url( home_url( '/services/' . $svc['id'] . '/' ) ); ?>" class="services-tile services-tile-v2<?php echo $idx === 0 ? ' on' : ''; ?>" data-services-tile="<?php echo esc_attr( $svc['id'] ); ?>">
							<span class="services-tile-thumb" style="background-image:url('<?php echo esc_url( $svc['img'] ); ?>')" aria-hidden="true"></span>
							<span class="services-tile-icon"><?php nyas_icon( $svc['icon'], 18 ); ?></span>
							<span class="services-tile-text">
								<span class="services-tile-name"><?php echo esc_html( $svc['short'] ); ?></span>
								<span class="services-tile-sub"><?php echo esc_html( $svc['desc'] ); ?></span>
							</span>
							<span class="services-tile-arrow"><?php nyas_icon( 'arrow-right', 16 ); ?></span>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
</section>

<?php // ─── 4b. Hardware showcase ─── ?>
<?php get_template_part( 'template-parts/section', 'hardware' ); ?>

<?php nyas_seam( 'ink', __( 'Find your fit', 'nyas' ) ); ?>

<?php // ─── 5. Quote wizard (replaces the old Find-my-fit quiz) ─── ?>
<?php get_template_part( 'template-parts/section', 'quote-wizard' ); ?>

<?php nyas_seam( 'paper' ); ?>

<?php // ─── 6. How it works ─── ?>
<section class="how-modern">
	<div class="container">
		<div class="how-header how-header-stacked">
			<h2 class="display-lg" style="max-width:720px;margin-bottom:14px"><?php esc_html_e( 'From First Call to', 'nyas' ); ?> <em><?php esc_html_e( 'Fully Armed.', 'nyas' ); ?></em></h2>
			<p class="muted" style="font-size:17px;line-height:1.6;max-width:620px;margin:0">
				<?php esc_html_e( 'Four stages, no surprises. Here\'s exactly what every NYAS install looks like, from the consultant\'s first visit to the day your system goes live.', 'nyas' ); ?>
			</p>
		</div>

		<div class="how-rail">
			<div class="how-line"></div>
			<?php
			$steps = array(
				array( 'icon' => 'pin',          'title' => 'Free site walk',     'when' => 'Within 48 hours', 'body' => 'A licensed NY consultant visits your property — usually within 48 hours — to map entry points, blind spots, and risk vectors.' ),
				array( 'icon' => 'briefcase',    'title' => 'Right-sized quote',  'when' => 'Same week',       'body' => 'You get a one-page proposal with hardware, monitoring, and labor itemized. No bundles. No "starter" gimmicks.' ),
				array( 'icon' => 'shield-check', 'title' => 'Clean installation', 'when' => '1 – 2 days on site', 'body' => 'In-house technicians (no subcontractors) wire and configure your system, typically in a day for a home, two for a small business.' ),
				array( 'icon' => 'monitor',      'title' => 'We watch, you live', 'when' => '24 / 7 / 365',    'body' => 'A UL-listed central station on Long Island confirms alarms, calls 911, and reaches you — every day of the year.' ),
			);
			foreach ( $steps as $s ) : ?>
				<div class="how-card">
					<div class="how-node">
						<div class="how-node-dot"></div>
						<div class="how-node-icon"><?php nyas_icon( $s['icon'], 22 ); ?></div>
					</div>
					<div class="how-when"><?php echo esc_html( $s['when'] ); ?></div>
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
<section class="section-sunk nyas-why">
	<div class="container">
		<div style="margin-bottom:48px;max-width:640px">
			<h2 class="display-lg" style="margin-bottom:14px"><?php esc_html_e( 'Why New Yorkers', 'nyas' ); ?> <em><?php esc_html_e( 'Choose Us.', 'nyas' ); ?></em></h2>
			<p style="font-size:17px;line-height:1.6;color:var(--fg-2);max-width:580px">
				<?php esc_html_e( 'Most national alarm companies sell hardware. We sell response time, accountability, and a phone number that gets answered the first ring — even at 3 a.m. on a Tuesday.', 'nyas' ); ?>
			</p>
		</div>
		<div class="why-grid">
			<?php
			$why = array(
				array( 'icon' => 'zap',          'title' => __( 'Verified response', 'nyas' ),  'desc' => __( 'Camera or two-way audio verification before dispatch — so police treat our alarms as confirmed events, not guesses.', 'nyas' ) ),
				array( 'icon' => 'users',        'title' => __( 'No subcontractors', 'nyas' ),  'desc' => __( 'Every technician on your property is our own, background-checked, and badge-carrying.', 'nyas' ) ),
				array( 'icon' => 'pin',          'title' => __( 'Local monitoring', 'nyas' ),   'desc' => __( 'Your alarm is watched from a UL-listed station in Long Island, NY — not an out-of-state call center in Texas, or an overseas one in Manila.', 'nyas' ) ),
				array( 'icon' => 'lock',         'title' => __( 'Buy it or rent it', 'nyas' ),  'desc' => __( 'Own your equipment outright or rent it — monitoring stays month-to-month either way, with a discount on annual agreements.', 'nyas' ) ),
				array( 'icon' => 'award',        'title' => __( 'UL listed', 'nyas' ),          'desc' => __( 'Our central station carries UL 827 and NYPD-recognized burglar response certifications.', 'nyas' ) ),
				array( 'icon' => 'shield-check', 'title' => __( 'Insurance-grade', 'nyas' ),    'desc' => __( 'We issue a UL-listed monitoring certificate accepted by major NY insurers — qualifying you for premium discounts and policy preferences.', 'nyas' ) ),
			);
			foreach ( $why as $it ) : ?>
				<div class="why-cell">
					<div class="why-cell-icon">
						<?php nyas_icon( $it['icon'], 22 ); ?>
					</div>
					<h3><?php echo esc_html( $it['title'] ); ?></h3>
					<p><?php echo esc_html( $it['desc'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php nyas_seam( 'paper', __( 'Free quote', 'nyas' ) ); ?>

<?php // ─── 8b. Quote section (simple LeadForm) ─── ?>
<section class="quote-section section-paper">
	<div class="container quote-section-inner">
		<div class="quote-section-copy">
			<h2 class="display-lg" style="margin-bottom:20px"><?php esc_html_e( 'Free Quote,', 'nyas' ); ?> <em><?php esc_html_e( '15 Minutes Flat.', 'nyas' ); ?></em></h2>
			<p style="font-size:17px;line-height:1.6;color:var(--fg-2);margin-bottom:28px;max-width:480px">
				<?php esc_html_e( 'Tell us about the space. A licensed NY consultant calls or texts you back today — no high-pressure sales, no obligation.', 'nyas' ); ?>
			</p>
			<ul class="quote-bullets">
				<li><?php nyas_icon( 'check', 16 ); ?> <?php esc_html_e( 'Free site walk within 48 hours', 'nyas' ); ?></li>
				<li><?php nyas_icon( 'check', 16 ); ?> <?php esc_html_e( 'One-page proposal, no bundles', 'nyas' ); ?></li>
				<li><?php nyas_icon( 'check', 16 ); ?> <?php esc_html_e( 'Buy or rent your equipment — monitoring month-to-month', 'nyas' ); ?></li>
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

<?php // ─── 9. Compare ─── ?>
<section>
	<div class="container">
		<div style="margin-bottom:40px;max-width:720px">
			<h2 class="display-lg"><?php esc_html_e( 'A Different', 'nyas' ); ?> <em><?php esc_html_e( 'Approach.', 'nyas' ); ?></em></h2>
			<p class="muted" style="font-size:17px;line-height:1.6;margin-top:12px">
				<?php esc_html_e( 'We\'re an independent NYC operator. Here\'s how we compare against the three names New Yorkers ask about most — ADT, DGA, and SimpliSafe.', 'nyas' ); ?>
			</p>
		</div>
		<div style="overflow-x:auto">
			<table class="compare-table">
				<thead>
					<tr>
						<th></th>
						<th class="us">NYAS</th>
						<th>ADT</th>
						<th>DGA</th>
						<th>SimpliSafe</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$rows = array(
						array( 'Monitoring location',      'Long Island, NY',           'Texas / Colorado',   'New York City',          'Rapid Response (3rd-party)' ),
						array( 'Contract length',          'Month-to-month or annual',  '36-month',           'Multi-year (commercial)','Month-to-month' ),
						array( 'Equipment ownership',      'Buy or rent',               'Leased',             'Proprietary',            'You own it' ),
						array( 'In-house technicians',      'yes',                       'partial',            'yes',                    'no' ),
						array( 'Avg dispatch time',        'Verified response',         '~60 seconds',        'Residential + Commercial', '~90 seconds' ),
						array( 'Avg service response time','1.5 days',                  '7–8 days',           '4.5 days',               'None' ),
						array( 'UL monitoring certificate','yes',                       'yes',                'yes',                    'partial' ),
						array( 'NYC permits & FDNY filings','yes',                      'no',                 'yes',                    'no' ),
						array( 'Residential + commercial', 'yes',                       'yes',                'yes',                    'residential only' ),
						array( 'Free in-person site survey','yes',                      'partial',            'yes',                    'no' ),
						array( 'Cancel terms',             '30-day notice',             '75% of balance',     'Full term',              'Anytime' ),
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
			<?php esc_html_e( 'Comparison based on each company\'s published terms and third-party reviews as of April 2026. Trademarks belong to their respective owners.', 'nyas' ); ?>
		</p>
		<div class="compare-cta">
			<div class="compare-cta-text">
				<span class="compare-cta-eyebrow"><?php esc_html_e( 'Independent. Local. Accountable.', 'nyas' ); ?></span>
				<h3 class="compare-cta-title"><?php esc_html_e( 'See what an honest quote looks like.', 'nyas' ); ?></h3>
			</div>
			<a href="#quote" class="btn btn-lg btn-signal"><?php esc_html_e( 'Get my free quote', 'nyas' ); ?> <?php nyas_icon( 'arrow-right', 15 ); ?></a>
		</div>
	</div>
</section>

<?php // ─── 10. Featured case study ─── ?>
<section style="background:var(--brand-paper);padding:96px 0;position:relative;overflow:hidden;border-top:1px solid var(--border);border-bottom:1px solid var(--border)">
	<div class="container">
		<div class="nyas-feat-case" style="display:grid;grid-template-columns:1fr 1.1fr;gap:56px;align-items:center">
			<div>
				<?php nyas_eyebrow( __( 'Case study · 7 locations · Brooklyn, Queens & the Bronx', 'nyas' ), false, 'color:var(--brand-signal);margin-bottom:16px' ); ?>
				<h2 class="display-lg" style="color:var(--fg);margin-bottom:24px">
					<?php esc_html_e( 'How', 'nyas' ); ?> <em style="color:var(--brand-signal)"><?php esc_html_e( 'Tower NY', 'nyas' ); ?></em> <?php esc_html_e( 'Cut Security Costs 32% Across 7 Dealerships.', 'nyas' ); ?>
				</h2>
				<p style="color:var(--fg-2);font-size:17px;line-height:1.6;margin-bottom:32px;max-width:520px">
					<?php esc_html_e( 'Seven dealership and service locations, each running a different aging alarm system. We standardized everything on Honeywell, integrated the cameras, and put every location on one centralized dashboard — cutting false alarms, break-ins, and preventable workplace incidents.', 'nyas' ); ?>
				</p>
				<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:24px;margin-bottom:32px;padding-top:28px;border-top:1px solid var(--border)">
					<div class="stat"><span class="stat-num" style="color:var(--fg)"><em style="color:var(--brand-signal)">32%</em></span><span class="stat-lbl" style="color:var(--fg-3)"><?php esc_html_e( 'Lower security costs', 'nyas' ); ?></span></div>
					<div class="stat"><span class="stat-num" style="color:var(--fg)">~60%</span><span class="stat-lbl" style="color:var(--fg-3)"><?php esc_html_e( 'Fewer workplace accidents', 'nyas' ); ?></span></div>
					<div class="stat"><span class="stat-num" style="color:var(--fg)">$16k+</span><span class="stat-lbl" style="color:var(--fg-3)"><?php esc_html_e( 'Saved in 18 months', 'nyas' ); ?></span></div>
				</div>
				<a href="<?php echo esc_url( home_url( '/cases/tower-ny/' ) ); ?>" class="btn btn-lg btn-signal"><?php esc_html_e( 'Read the case study', 'nyas' ); ?> <?php nyas_icon( 'arrow-right', 15 ); ?></a>
			</div>
			<div style="position:relative">
				<?php nyas_photo( NYAS_URI . 'assets/img/case-tower-ny.webp', 'Tower NY dealership showroom', 'aspect-ratio:4/5;border-radius:16px' ); ?>
				<div style="position:absolute;bottom:24px;left:24px;right:24px;background:rgba(255,255,255,0.96);backdrop-filter:blur(8px);border:1px solid var(--border);border-radius:12px;padding:20px;color:var(--fg)">
					<div style="font-size:11px;letter-spacing:0.12em;text-transform:uppercase;color:var(--fg-3);margin-bottom:8px"><?php esc_html_e( 'One dashboard · 7 locations', 'nyas' ); ?></div>
					<div style="font-family:var(--ff-mono);font-size:13px;color:var(--fg-2);margin-bottom:4px"><?php esc_html_e( 'Honeywell alarms + integrated cameras', 'nyas' ); ?></div>
					<div style="font-family:var(--ff-mono);font-size:13px;color:var(--brand-signal)"><?php esc_html_e( 'Automated alerts · verified before dispatch', 'nyas' ); ?></div>
				</div>
			</div>
		</div>
	</div>
</section>

<?php nyas_seam( 'navy', __( 'Real story', 'nyas' ) ); ?>

<?php // ─── 10b. Response timeline (animated 5-step) ─── ?>
<?php get_template_part( 'template-parts/section', 'response-timeline' ); ?>

<?php nyas_seam( 'paper' ); ?>

<?php
// ─── 11. Reviews carousel — intentionally NOT rendered. The prototype's
// review quotes are unverifiable ("Nothing we can prove" — client brief,
// July 2026). Re-add via get_template_part( 'template-parts/section',
// 'reviews' ) once real customer reviews are supplied.
?>

<?php // ─── 11b. Mid-page CTA ─── ?>
<section class="midpage-cta-section">
	<div class="container">
		<div class="midpage-cta">
			<div class="midpage-cta-text">
				<span class="midpage-cta-eyebrow"><?php esc_html_e( 'Ready when you are', 'nyas' ); ?></span>
				<h2 class="midpage-cta-title"><?php esc_html_e( 'Free Site Walk', 'nyas' ); ?> <em><?php esc_html_e( 'Within 48 Hours.', 'nyas' ); ?></em></h2>
				<p class="midpage-cta-sub"><?php esc_html_e( 'Anywhere in the five boroughs. One licensed NY consultant. One written quote. Zero high-pressure sales.', 'nyas' ); ?></p>
			</div>
			<div class="midpage-cta-actions">
				<a href="#quote" class="btn btn-lg btn-signal"><?php esc_html_e( 'Get my free quote', 'nyas' ); ?> <?php nyas_icon( 'arrow-right', 15 ); ?></a>
				<a href="tel:<?php echo esc_attr( nyas_phone_tel() ); ?>" class="btn btn-lg btn-ghost"><?php nyas_icon( 'phone', 14 ); ?> <?php echo esc_html( nyas_phone() ); ?></a>
			</div>
		</div>
	</div>
</section>

<?php // ─── 12. Coverage map ─── ?>
<section class="section-paper">
	<div class="container">
		<div class="nyas-coverage" style="display:grid;grid-template-columns:1fr 1fr;gap:56px;align-items:center">
			<div>
				<h2 class="display-lg" style="margin-bottom:24px"><?php esc_html_e( 'NYC\'s Alarms.', 'nyas' ); ?> <em><?php esc_html_e( 'Watched From Long Island.', 'nyas' ); ?></em></h2>
				<p style="font-size:17px;line-height:1.6;color:var(--fg-2);max-width:480px;margin-bottom:32px">
					<?php esc_html_e( 'Every system reports to a UL-listed central station in Long Island, NY — close enough that operators know your block, your precinct, and your weather. Local people watching local properties. No overseas call centers.', 'nyas' ); ?>
				</p>
				<div style="display:flex;flex-direction:column;gap:4px">
					<?php
					$boroughs = array(
						array( 'Manhattan', '3,420', 'Tribeca · UES · Harlem · Inwood' ),
						array( 'Brooklyn',  '2,810', 'Park Slope · Williamsburg · Bay Ridge' ),
						array( 'Queens',    '1,940', 'Astoria · Long Island City · Forest Hills · Jamaica' ),
						array( 'The Bronx', '780',   'Riverdale · Fordham · Throgs Neck' ),
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
				<div class="ny-map-foot"><?php esc_html_e( 'UL-listed monitoring · Serving NYC, Long Island & Westchester', 'nyas' ); ?></div>
			</div>
		</div>
	</div>
</section>

<?php // ─── 13. FAQ ─── ?>
<?php get_template_part( 'template-parts/section', 'faq' ); ?>

<?php // ─── 14. Recent insights (hidden entirely until real posts exist) ─── ?>
<?php
$recent = new WP_Query( array(
	'posts_per_page' => 3,
	'post_status'    => 'publish',
	'no_found_rows'  => true,
) );

if ( $recent->have_posts() ) :
	?>
<section>
	<div class="container">
		<div style="display:flex;justify-content:space-between;align-items:end;margin-bottom:48px;gap:32px;flex-wrap:wrap">
			<div>
				<?php nyas_eyebrow( __( 'Insights', 'nyas' ), true, 'margin-bottom:16px' ); ?>
				<h2 class="display-lg"><?php esc_html_e( 'Field Notes From the', 'nyas' ); ?> <em><?php esc_html_e( 'Monitoring Desk.', 'nyas' ); ?></em></h2>
			</div>
			<a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/' ) ); ?>" class="btn btn-md btn-ghost"><?php esc_html_e( 'All posts', 'nyas' ); ?> <?php nyas_icon( 'arrow-right', 14 ); ?></a>
		</div>

		<div class="grid grid-3">
			<?php
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
			?>
		</div>
	</div>
</section>
<?php endif; ?>

<?php nyas_seam( 'ink', __( 'Get protected', 'nyas' ) ); ?>

<?php // ─── 15. Final CTA ─── ?>
<?php nyas_final_cta(); ?>

<?php get_footer();
