<?php
/**
 * FAQ accordion — server-rendered <details> for native open/close, JS coordinates "one-open-at-a-time".
 *
 * @package NYAS
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$items = array(
	array( 'q' => 'How much does a home security system cost in NYC?',                  'a' => 'For a typical NYC apartment or brownstone, equipment runs about $500&ndash;$1,500 one-time depending on the number of doors, windows, and cameras, plus monitoring from $29&ndash;$55/month. Our instant-quote tool gives you an itemized estimate in about 60 seconds — no phone call required.' ),
	array( 'q' => 'Do I need a permit for a burglar or fire alarm in New York City?',   'a' => 'Yes. NYC requires an alarm permit, and FDNY filings are required for most commercial fire systems. We handle the paperwork for you — permits, ACR forms, and FDNY filings are included with every install.' ),
	array( 'q' => 'What is the best alarm system for a NYC apartment or co-op?',        'a' => 'A wireless, cellular-backed system is usually best for apartments and pre-war co-ops — no drilling through plaster or running wires past board approval. We work directly with your super and management and provide the certificates your board needs.' ),
	array( 'q' => 'Will a security system lower my home or renters insurance?',         'a' => 'Usually, yes. We issue a UL-listed central-station monitoring certificate that most NY insurers (Chubb, Travelers, Liberty) accept for premium discounts of 5&ndash;20%. We send it to you and your agent after install.' ),
	array( 'q' => 'Does the alarm still work if the Wi-Fi or power goes out?',          'a' => 'Yes. Every system ships with a cellular backup module (LTE-M / NB-IoT) and a battery, so it keeps reporting to our monitoring station even with no internet or power — common during NYC outages.' ),
	array( 'q' => 'How fast do police respond to a monitored alarm in NYC?',            'a' => 'Our UL-listed station makes a dispatch decision in a median of 28 seconds and uses verified response (camera or two-way audio) to prioritize real events with NYPD, which cuts false-alarm fines.' ),
	array( 'q' => 'Can I keep my existing cameras and equipment?',                      'a' => 'Most likely yes. We support ONVIF-compliant IP cameras and the major consumer brands (Ring, Nest, Arlo). Your consultant inventories what you have during the free site walk and reuses whatever makes sense.' ),
	array( 'q' => 'Is there a long-term contract, or can I cancel anytime?',            'a' => 'No long-term trap. You own the hardware outright, and monitoring is month-to-month or annual — cancel with 30 days\' notice. We don\'t do 36- or 60-month bundles.' ),
);
?>

<section class="section-sunk">
	<div class="container">
		<div class="nyas-faq-grid" style="display:grid;grid-template-columns:1fr 2fr;gap:64px;align-items:start">
			<div>
				<h2 class="display-lg" style="margin-bottom:16px"><?php esc_html_e( 'Questions,', 'nyas' ); ?> <em><?php esc_html_e( 'Answered.', 'nyas' ); ?></em></h2>
				<p style="font-size:17px;line-height:1.6;color:var(--fg-2);max-width:380px">
					<?php
					printf(
						/* translators: %s: phone link. */
						esc_html__( 'Don\'t see what you\'re looking for? Call %s or text the same number — a real person responds.', 'nyas' ),
						'<a href="tel:' . esc_attr( nyas_phone_tel() ) . '" style="color:var(--brand-signal-2)">' . esc_html( nyas_phone() ) . '</a>' // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					);
					?>
				</p>
			</div>
			<div data-nyas-faq>
				<?php foreach ( $items as $i => $it ) : ?>
					<details class="nyas-faq-item" style="border-bottom:1px solid var(--border)"<?php echo 0 === $i ? ' open' : ''; ?>>
						<summary style="list-style:none;padding:20px 0;cursor:pointer;display:flex;justify-content:space-between;align-items:center;gap:16px">
							<span style="font-family:var(--ff-display);font-weight:700;font-size:22px;letter-spacing:-0.01em;color:var(--fg)"><?php echo esc_html( $it['q'] ); ?></span>
							<span class="nyas-faq-toggle" aria-hidden="true" style="color:var(--fg-3);flex-shrink:0">
								<?php nyas_icon( 'plus', 20 ); ?>
							</span>
						</summary>
						<div style="padding:0 0 20px;font-size:15px;line-height:1.65;color:var(--fg-2);max-width:640px">
							<?php echo wp_kses_post( $it['a'] ); ?>
						</div>
					</details>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>
