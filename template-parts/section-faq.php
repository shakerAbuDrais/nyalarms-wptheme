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
	array( 'q' => 'How fast can you install?',                              'a' => 'Most residential installs are scheduled within 5 business days of signed quote. Commercial timelines depend on scope — small offices in 3 days, multi-floor in 2–3 weeks.' ),
	array( 'q' => 'Do I have to sign a long-term contract?',                'a' => 'No. Hardware is purchased one-time. Monitoring is month-to-month with 30-day cancel notice. We don\'t do 36-month bundles.' ),
	array( 'q' => 'Will my homeowner\'s insurance discount apply?',         'a' => 'Yes — we provide a stamped certificate of installation and central-station monitoring credentials. Most NY insurers (Chubb, Travelers, Liberty) discount 5–20%.' ),
	array( 'q' => 'What happens if my internet goes down?',                 'a' => 'Every system ships with a cellular backup module (LTE-M / NB-IoT). The alarm reports to the central station even with no Wi-Fi or power.' ),
	array( 'q' => 'Can I integrate with my existing cameras?',              'a' => 'Most likely yes. We support ONVIF-compliant IP cameras and the major consumer brands (Ring, Nest, Arlo). Our consultant will inventory your hardware on the site walk.' ),
	array( 'q' => 'Do you service co-ops and condos?',                      'a' => 'Frequently. We work directly with super and management; we\'ll handle ACR forms and board insurance certs. Common in pre-war Manhattan and Park Slope.' ),
);
?>

<section class="section-sunk">
	<div class="container">
		<div class="nyas-faq-grid" style="display:grid;grid-template-columns:1fr 2fr;gap:64px;align-items:start">
			<div>
				<?php nyas_eyebrow( __( 'FAQ', 'nyas' ), true, 'margin-bottom:16px' ); ?>
				<h2 class="display-lg" style="margin-bottom:16px"><?php esc_html_e( 'Questions,', 'nyas' ); ?> <em><?php esc_html_e( 'answered.', 'nyas' ); ?></em></h2>
				<p style="font-size:15px;color:var(--fg-2);max-width:320px">
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
