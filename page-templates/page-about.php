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
			<?php esc_html_e( 'Two founders, one Long Island City monitoring station, and 9,400 NYC properties under our watch — every day of the year.', 'nyas' ); ?>
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
			<?php nyas_photo( 'https://images.unsplash.com/photo-1497366216548-37526070297c?w=600&q=80', 'Office' ); ?>
		</div>
	</div>
</section>

<section class="section-paper">
	<div class="container">
		<div class="nyas-about-story" style="display:grid;grid-template-columns:1fr 2fr;gap:64px">
			<div>
				<?php nyas_eyebrow( __( 'Our story', 'nyas' ), true, 'margin-bottom:16px' ); ?>
				<h2 class="display-lg"><?php esc_html_e( 'A different kind of alarm company.', 'nyas' ); ?></h2>
			</div>
			<div style="font-size:17px;line-height:1.7;color:var(--fg-2)">
				<p style="margin-top:0"><?php esc_html_e( 'In 2009, Diana Velez was running operations for a national alarm company in midtown. She watched her best customers — landlords, restauranteurs, small medical practices — get locked into 60-month contracts they couldn\'t escape, with response times that drifted north of four minutes.', 'nyas' ); ?></p>
				<p><?php esc_html_e( 'That December, Diana and Marcus Tan rented a basement in Greenpoint, hired one technician, and answered every call themselves. Sixteen years later, we still answer every call ourselves — just from a slightly larger room in Long Island City, with twenty-two technicians and a UL-listed central station.', 'nyas' ); ?></p>
				<p><?php esc_html_e( 'We don\'t sell hardware bundles. We don\'t lock contracts. We don\'t outsource. The day we have to do any of those things to grow is the day we\'ll have stopped being the company we set out to build.', 'nyas' ); ?></p>
				<div style="display:flex;gap:18px;margin-top:32px;align-items:center">
					<img src="https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?w=120&q=80" alt="" style="width:56px;height:56px;border-radius:50%;object-fit:cover" />
					<div>
						<div style="font-family:var(--ff-display);font-weight:700;font-size:22px;letter-spacing:-0.01em">Diana Velez</div>
						<div style="font-size:13px;color:var(--fg-3)"><?php esc_html_e( 'Co-founder · Operations', 'nyas' ); ?></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<section>
	<div class="container">
		<div style="margin-bottom:48px">
			<?php nyas_eyebrow( __( 'By the numbers', 'nyas' ), true, 'margin-bottom:16px' ); ?>
			<h2 class="display-lg" style="max-width:720px"><?php esc_html_e( 'Sixteen years,', 'nyas' ); ?> <em><?php esc_html_e( 'quietly counted.', 'nyas' ); ?></em></h2>
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
			<?php nyas_eyebrow( __( 'The people', 'nyas' ), true, 'margin-bottom:16px' ); ?>
			<h2 class="display-lg"><?php esc_html_e( 'Whose name is', 'nyas' ); ?> <em><?php esc_html_e( 'actually', 'nyas' ); ?></em> <?php esc_html_e( 'on the door.', 'nyas' ); ?></h2>
		</div>
		<div class="grid grid-4">
			<?php
			$team = array(
				array( 'Diana Velez',   'Co-founder / Operations', 'Brooklyn native. 18 years in commercial security, formerly at Stanley.', 'https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?w=400&q=80' ),
				array( 'Marcus Tan',    'Co-founder / CTO',        'NYU. Built the original monitoring platform; ex-Verisure engineer.',     'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=400&q=80' ),
				array( 'Priya Iyer',    'Director, Monitoring',    'Runs the LIC central station. UL 827 certified for 12 years.',          'https://images.unsplash.com/photo-1580489944761-15a19d654956?w=400&q=80' ),
				array( 'Rashaan Cole',  'Field Operations Lead',   'Leads our 22 in-house technicians. Bronx, born and raised.',            'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=400&q=80' ),
			);
			foreach ( $team as $p ) :
				?>
				<div>
					<?php nyas_photo( $p[3], $p[0], 'aspect-ratio:4/5;border-radius:12px;margin-bottom:16px' ); ?>
					<h3 style="font-family:var(--ff-display);font-weight:700;font-size:22px;letter-spacing:-0.01em;margin-bottom:4px"><?php echo esc_html( $p[0] ); ?></h3>
					<div style="font-size:12px;color:var(--fg-3);text-transform:uppercase;letter-spacing:0.1em;font-weight:600;margin-bottom:8px"><?php echo esc_html( $p[1] ); ?></div>
					<p style="margin:0;font-size:14px"><?php echo esc_html( $p[2] ); ?></p>
				</div>
			<?php endforeach; ?>
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
					<div style="font-family:var(--ff-mono);font-size:12px;color:var(--brand-signal-2);margin-bottom:12px">0<?php echo (int) ( $i + 1 ); ?></div>
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
