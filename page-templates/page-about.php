<?php
/**
 * Template Name: About
 *
 * Recreates about.html.
 *
 * @package NYAS
 */

get_header();
?>

<section style="padding:88px 0 48px">
	<div class="container-narrow" style="text-align:center">
		<?php nyas_eyebrow( __( 'About us', 'nyas' ), false, 'margin-bottom:20px;justify-content:center;display:flex' ); ?>
		<h1 class="display-xl" style="margin-bottom:28px">
			<?php esc_html_e( 'Born in', 'nyas' ); ?> <em><?php esc_html_e( 'Brooklyn.', 'nyas' ); ?></em> <?php esc_html_e( 'Built for the five boroughs.', 'nyas' ); ?>
		</h1>
		<p class="lede" style="max-width:680px;margin:0 auto">
			<?php esc_html_e( 'Twelve years of alarm and camera installations for homes and businesses across the New York area — with every system watched every day of the year.', 'nyas' ); ?>
		</p>
	</div>
</section>

<section style="padding:0 0 80px">
	<div class="container">
		<div class="about-mosaic">
			<?php nyas_photo( 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=800&q=80', 'NYC skyline', 'grid-column:span 2;grid-row:span 2' ); ?>
			<?php nyas_photo( 'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?w=600&q=80', 'Brownstone' ); ?>
			<?php nyas_photo( 'https://images.unsplash.com/photo-1558002038-1055907df827?w=600&q=80', 'Camera' ); ?>
			<?php nyas_photo( 'https://images.unsplash.com/photo-1521737604893-d14cc237f11d?w=600&q=80', 'Team' ); ?>
			<?php nyas_photo( NYAS_URI . 'assets/img/office.webp', 'Office' ); ?>
		</div>
	</div>
</section>

<section class="section-paper">
	<div class="container">
		<div class="nyas-about-story nyas-2col" style="display:grid;grid-template-columns:1fr 2fr;gap:64px">
			<div>
				<?php nyas_eyebrow( __( 'Our story', 'nyas' ), true, 'margin-bottom:16px' ); ?>
				<h2 class="display-lg"><?php esc_html_e( 'A different kind of alarm company.', 'nyas' ); ?></h2>
			</div>
			<div style="font-size:17px;line-height:1.7;color:var(--fg-2)">
				<p style="margin-top:0"><?php esc_html_e( 'New York Alarm Systems has spent the last twelve years designing, installing, and monitoring alarm and camera systems for residential and commercial customers across the New York area. Every job — from a single-family home to a multi-site business — is handled by our own team, from the first site visit to the day the system goes live.', 'nyas' ); ?></p>
				<p><?php esc_html_e( 'That focus on professional installation is the whole business. We don\'t ship kits and wish you luck. We walk the property, design a system around how the building is actually used, install it ourselves, and stand behind it with 24/7 monitoring.', 'nyas' ); ?></p>
				<p><?php esc_html_e( 'We don\'t sell hardware bundles. We don\'t lock contracts. We don\'t outsource. The day we have to do any of those things to grow is the day we\'ll have stopped being the company we set out to build.', 'nyas' ); ?></p>
			</div>
		</div>
	</div>
</section>

<section>
	<div class="container">
		<div style="margin-bottom:48px">
			<?php nyas_eyebrow( __( 'By the numbers', 'nyas' ), true, 'margin-bottom:16px' ); ?>
			<h2 class="display-lg" style="max-width:720px"><?php esc_html_e( 'Twelve Years,', 'nyas' ); ?> <em><?php esc_html_e( 'Quietly Counted.', 'nyas' ); ?></em></h2>
		</div>
		<div class="grid grid-4" style="border-top:1px solid var(--border-strong)">
			<?php
			$nums = array(
				array( '9,400+',  'NYC properties protected' ),
				array( '28s',     'Median dispatch time, 2025' ),
				array( '99.96%',  'Central-station uptime' ),
				array( '22',      'In-house W-2 technicians' ),
			);
			foreach ( $nums as $s ) :
				?>
				<div style="padding:32px 4px;border-bottom:1px solid var(--border)">
					<div class="stat-num" style="font-size:56px"><?php echo esc_html( $s[0] ); ?></div>
					<div class="stat-lbl" style="margin-top:8px"><?php echo esc_html( $s[1] ); ?></div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="section-sunk">
	<div class="container">
		<div style="margin-bottom:48px">
			<?php nyas_eyebrow( __( 'The owner', 'nyas' ), true, 'margin-bottom:16px' ); ?>
			<h2 class="display-lg"><?php esc_html_e( 'The Name', 'nyas' ); ?> <em><?php esc_html_e( 'on the Door.', 'nyas' ); ?></em></h2>
		</div>
		<div class="nyas-2col" style="display:grid;grid-template-columns:1fr 1.6fr;gap:56px;align-items:start">
			<div>
				<?php
				// Owner portrait — bundled photo by default; overridable via the
				// `nyas_owner_photo` theme mod or filter.
				$owner_photo = apply_filters( 'nyas_owner_photo', get_theme_mod( 'nyas_owner_photo', NYAS_URI . 'assets/img/owner-yonatan.jpg' ) );
				if ( $owner_photo ) {
					nyas_photo( $owner_photo, 'Yonatan Yekutiel', 'aspect-ratio:4/5;border-radius:14px' );
				} else {
					?>
					<div style="aspect-ratio:4/5;border-radius:14px;background:var(--brand-ink);display:flex;flex-direction:column;align-items:center;justify-content:center;gap:16px;color:#fff">
						<span style="width:72px;height:72px;border-radius:18px;background:var(--brand-signal);display:inline-flex;align-items:center;justify-content:center">
							<svg width="40" height="40" viewBox="0 0 24 24" fill="none" aria-hidden="true">
								<path d="M12 21s7-3.5 7-8.5V5l-7-2.5L5 5v7.5C5 17.5 12 21 12 21z" stroke="white" stroke-width="2" fill="none" stroke-linejoin="round" />
								<path d="m9 12 2 2 4-4" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none" />
							</svg>
						</span>
						<span style="font-family:var(--ff-display);font-weight:800;font-size:22px;letter-spacing:-0.01em">Yonatan Yekutiel</span>
					</div>
					<?php
				}
				?>
			</div>
			<div>
				<h3 style="font-family:var(--ff-display);font-weight:800;font-size:32px;letter-spacing:-0.015em;margin-bottom:4px"><?php esc_html_e( 'Yonatan Yekutiel', 'nyas' ); ?></h3>
				<div style="font-size:12px;color:var(--fg-3);text-transform:uppercase;letter-spacing:0.1em;font-weight:600;margin-bottom:20px"><?php esc_html_e( 'Owner', 'nyas' ); ?></div>
				<div style="font-size:17px;line-height:1.7;color:var(--fg-2)">
					<p style="margin-top:0"><?php esc_html_e( 'Yonatan has spent twelve years building New York Alarm Systems into a trusted name for residential and commercial security across the New York area. He stays personally involved in the work — from how a system is designed for a specific building to how it\'s installed and monitored once it goes live.', 'nyas' ); ?></p>
					<p style="margin-bottom:0"><?php esc_html_e( 'The business runs on a simple standard: professional installation, honest advice, and systems that respond the moment they\'re needed. When you call, you\'re dealing with the person whose name is on the work.', 'nyas' ); ?></p>
				</div>
			</div>
		</div>
	</div>
</section>

<section>
	<div class="container">
		<div style="margin-bottom:48px">
			<?php nyas_eyebrow( __( 'What we believe', 'nyas' ), true, 'margin-bottom:16px' ); ?>
			<h2 class="display-lg" style="max-width:720px"><?php esc_html_e( 'Four', 'nyas' ); ?> <em><?php esc_html_e( 'simple', 'nyas' ); ?></em> <?php esc_html_e( 'commitments.', 'nyas' ); ?></h2>
		</div>
		<div class="grid grid-2" style="gap:0">
			<?php
			$values = array(
				array( 'No subcontractors, ever.',     'Every technician on your property is a W-2 employee, background-checked, and badge-carrying. We don\'t rent labor.' ),
				array( 'You own your hardware.',       'No leased equipment. No surprise removals. The system you bought is yours, including if you cancel monitoring.' ),
				array( 'Month-to-month monitoring.',   'Cancel anytime with 30 days\' notice. We earn your business in 30-day increments, not 60-month contracts.' ),
				array( 'A real human picks up.',       'No phone trees, no overseas call centers. The first ring goes to a New Yorker in Long Island City.' ),
			);
			foreach ( $values as $i => $v ) :
				$right = 0 === $i % 2 ? '1px solid var(--border)' : 'none';
				?>
				<div style="padding:36px;border-top:1px solid var(--border-strong);border-right:<?php echo esc_attr( $right ); ?>">
					<h3 style="font-family:var(--ff-display);font-weight:800;font-size:32px;letter-spacing:-0.015em;margin-bottom:12px"><?php echo esc_html( $v[0] ); ?></h3>
					<p style="margin:0;font-size:15px"><?php echo esc_html( $v[1] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php nyas_final_cta( array(
	'eyebrow' => __( 'Talk to us', 'nyas' ),
	'heading' => __( 'Pick up the phone. We\'ll <em>actually answer.</em>', 'nyas' ),
	'lede'    => __( 'The number on this site reaches a real person, twenty-four hours a day, in our Long Island City office.', 'nyas' ),
) ); ?>

<?php get_footer();
