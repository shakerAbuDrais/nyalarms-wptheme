<?php
/**
 * Service quiz / Find-my-fit — interactive island, hydrated by app.js.
 *
 * @package NYAS
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$quiz = array(
	array(
		'q'    => 'What kind of property are we protecting?',
		'sub'  => 'Pick the one that\'s closest. We\'ll branch from here.',
		'opts' => array(
			array( 'v' => 'home',        'label' => 'Home or apartment',         'icon' => 'home',       'tags' => array( 'residential' ) ),
			array( 'v' => 'office',      'label' => 'Office space',              'icon' => 'briefcase',  'tags' => array( 'office', 'commercial' ) ),
			array( 'v' => 'shop',        'label' => 'Retail / storefront',       'icon' => 'shop',       'tags' => array( 'retail', 'commercial' ) ),
			array( 'v' => 'warehouse',   'label' => 'Warehouse / industrial',    'icon' => 'warehouse',  'tags' => array( 'warehouse', 'commercial' ) ),
			array( 'v' => 'site',        'label' => 'Construction site',         'icon' => 'hardhat',    'tags' => array( 'construction' ) ),
			array( 'v' => 'institution', 'label' => 'School or medical facility','icon' => 'school',     'tags' => array( 'school', 'medical' ) ),
		),
	),
	array(
		'q'    => 'What worries you most?',
		'sub'  => 'There\'s a right system for each.',
		'opts' => array(
			array( 'v' => 'break-in',    'label' => 'Break-in / theft',       'icon' => 'lock',         'tags' => array( 'monitoring', 'video' ) ),
			array( 'v' => 'fire',        'label' => 'Fire & smoke',           'icon' => 'fire',         'tags' => array( 'monitoring' ) ),
			array( 'v' => 'after-hours', 'label' => 'After-hours intrusion',  'icon' => 'zap',          'tags' => array( 'video', 'monitoring' ) ),
			array( 'v' => 'liability',   'label' => 'Liability / panic events','icon' => 'shield-check','tags' => array( 'school', 'medical' ) ),
			array( 'v' => 'tools',       'label' => 'Tools / inventory theft','icon' => 'hardhat',      'tags' => array( 'construction', 'warehouse' ) ),
			array( 'v' => 'unsure',      'label' => 'Honestly, all of it',    'icon' => 'eye',          'tags' => array( 'monitoring', 'video' ) ),
		),
	),
	array(
		'q'    => 'How many entry points roughly?',
		'sub'  => 'Doors + ground-floor windows. Ballpark is fine.',
		'opts' => array(
			array( 'v' => 'lt5',    'label' => 'Fewer than 5','icon' => 'pin',       'tags' => array( 'residential' ) ),
			array( 'v' => '5-12',   'label' => '5 – 12',      'icon' => 'pin',       'tags' => array( 'residential', 'office' ) ),
			array( 'v' => '12-30',  'label' => '12 – 30',     'icon' => 'building',  'tags' => array( 'commercial', 'office' ) ),
			array( 'v' => '30plus', 'label' => '30+',         'icon' => 'warehouse', 'tags' => array( 'warehouse', 'commercial' ) ),
		),
	),
	array(
		'q'    => 'Do you want video on top of the alarm?',
		'sub'  => 'Verified video cuts false dispatches by 91%.',
		'opts' => array(
			array( 'v' => 'yes',     'label' => 'Yes, full coverage',  'icon' => 'video', 'tags' => array( 'video' ) ),
			array( 'v' => 'partial', 'label' => 'A few key spots',     'icon' => 'video', 'tags' => array( 'video' ) ),
			array( 'v' => 'no',      'label' => 'No, alarm only',      'icon' => 'lock',  'tags' => array( 'monitoring' ) ),
			array( 'v' => 'unsure',  'label' => 'Help me decide',      'icon' => 'eye',   'tags' => array( 'video', 'monitoring' ) ),
		),
	),
	array(
		'q'    => 'Who\'s watching it?',
		'sub'  => '24/7 UL-listed monitoring is what changes response from 4 minutes to 28 seconds.',
		'opts' => array(
			array( 'v' => 'pro',    'label' => '24/7 pro monitoring',         'icon' => 'monitor',      'tags' => array( 'monitoring' ) ),
			array( 'v' => 'self',   'label' => 'Self-monitor (alerts to me)', 'icon' => 'phone',        'tags' => array() ),
			array( 'v' => 'hybrid', 'label' => 'Pro + I get alerts too',      'icon' => 'shield-check', 'tags' => array( 'monitoring' ) ),
		),
	),
);

// Pre-collect SERVICES for client-side scoring.
$services_for_js = array();
foreach ( nyas_services() as $s ) {
	$services_for_js[] = array(
		'id'   => $s['id'],
		'name' => $s['short'],
		'desc' => $s['desc'],
		'url'  => home_url( '/services/' . $s['id'] . '/' ),
	);
}
?>

<section class="quiz-section" id="find-my-fit"
	data-nyas-quiz
	data-nyas-quiz-data="<?php echo esc_attr( wp_json_encode( $quiz ) ); ?>"
	data-nyas-quiz-services="<?php echo esc_attr( wp_json_encode( $services_for_js ) ); ?>">
	<div class="container">
		<div class="quiz-shell">
			<div class="quiz-side">
				<?php nyas_eyebrow( __( 'Find my fit', 'nyas' ), true, 'margin-bottom:16px;color:rgba(246,243,236,0.55)' ); ?>
				<h2 class="display-lg" style="color:var(--fg-on-ink)">
					<?php esc_html_e( 'Five questions.', 'nyas' ); ?> <em><?php esc_html_e( 'One right system.', 'nyas' ); ?></em>
				</h2>
				<p style="color:rgba(246,243,236,0.78);font-size:16px;line-height:1.6;margin-top:16px;max-width:380px">
					<?php esc_html_e( 'No call, no email required. Answer five quick questions and we\'ll show you which of our services actually fits — and which to skip.', 'nyas' ); ?>
				</p>
				<div class="quiz-meta">
					<div class="quiz-meta-row"><?php nyas_icon( 'check', 14 ); ?><span><?php esc_html_e( 'Takes about 45 seconds', 'nyas' ); ?></span></div>
					<div class="quiz-meta-row"><?php nyas_icon( 'check', 14 ); ?><span><?php esc_html_e( 'No spam — your answers stay on this page', 'nyas' ); ?></span></div>
					<div class="quiz-meta-row"><?php nyas_icon( 'check', 14 ); ?><span><?php esc_html_e( 'Recommendations from a real consultant on request', 'nyas' ); ?></span></div>
				</div>
			</div>

			<div class="quiz-card" data-nyas-quiz-card>
				<noscript>
					<p style="color:var(--fg-2);margin:0"><?php esc_html_e( 'Enable JavaScript to use the quiz, or scroll down to fill out the free quote form.', 'nyas' ); ?></p>
				</noscript>
				<!-- Hydrated by app.js -->
			</div>
		</div>
	</div>
</section>
