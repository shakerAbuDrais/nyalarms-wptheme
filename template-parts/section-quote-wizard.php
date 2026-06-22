<?php
/**
 * 4-step quote wizard — replaces the old "Find my fit" Service Quiz.
 *
 * Lives in the same dark/ink section as the old quiz so the page rhythm
 * stays the same. Left column: editorial copy (eyebrow + headline + lede
 * + meta bullets). Right column: white wizard card (4 steps, live pricing).
 *
 * Submitting POSTs to the `nyas_submit_lead` admin-ajax endpoint, which
 * stores the lead as a `nyas_lead` post and emails the configured
 * notification address.
 *
 * @package NYAS
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<section class="quiz-section" id="get-quote">
	<div class="container">
		<div class="quiz-shell">
			<div class="quiz-side">
				<h2 class="display-lg" style="color:var(--fg-on-ink)">
					<?php esc_html_e( 'An', 'nyas' ); ?> <em><?php esc_html_e( 'Itemized Quote', 'nyas' ); ?></em> <?php esc_html_e( 'in 60 Seconds.', 'nyas' ); ?>
				</h2>
				<p style="color:rgba(246,243,236,0.78);font-size:17px;line-height:1.6;margin-top:16px;max-width:380px">
					<?php esc_html_e( 'Tell us about the property and the protection you need. We\'ll calculate hardware and monitoring on the spot — no phone call required.', 'nyas' ); ?>
				</p>
				<div class="quiz-meta">
					<div class="quiz-meta-row"><?php nyas_icon( 'check', 14 ); ?><span><?php esc_html_e( 'Real numbers, not "starting from" gimmicks', 'nyas' ); ?></span></div>
					<div class="quiz-meta-row"><?php nyas_icon( 'check', 14 ); ?><span><?php esc_html_e( '4 quick steps · about 60 seconds', 'nyas' ); ?></span></div>
					<div class="quiz-meta-row"><?php nyas_icon( 'check', 14 ); ?><span><?php esc_html_e( 'A specialist follows up to schedule the free site walk', 'nyas' ); ?></span></div>
				</div>
			</div>

			<div class="qz-wrap" data-nyas-quote
				data-ajax-url="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>"
				data-nonce="<?php echo esc_attr( wp_create_nonce( 'nyas_submit_lead' ) ); ?>">

				<div class="qz-progress" aria-hidden="true">
					<div class="qz-progress-bar active" data-pb="1"></div>
					<div class="qz-progress-bar" data-pb="2"></div>
					<div class="qz-progress-bar" data-pb="3"></div>
					<div class="qz-progress-bar" data-pb="4"></div>
				</div>

				<!-- Step 1 — Property -->
				<div class="qz-step active" data-step="1">
					<div class="qz-step-label"><?php esc_html_e( 'Step 1 of 4', 'nyas' ); ?></div>
					<h3 class="qz-title"><?php esc_html_e( 'What type of property?', 'nyas' ); ?></h3>
					<p class="qz-sub"><?php esc_html_e( 'Pick the closest match — we\'ll branch from here.', 'nyas' ); ?></p>

					<div class="qz-group">
						<div class="qz-grid-2" data-name="propertyType">
							<?php
							$ptypes = array(
								array( 'Residential', 'Home or apartment',     'home' ),
								array( 'Office',      'Workplace',             'briefcase' ),
								array( 'Retail',      'Shop or storefront',    'shop' ),
								array( 'Warehouse',   'Storage or industrial', 'warehouse' ),
							);
							foreach ( $ptypes as $p ) :
								?>
								<button type="button" class="qz-choice" data-value="<?php echo esc_attr( $p[0] ); ?>" aria-pressed="false">
									<span class="qz-choice-icon"><?php nyas_icon( $p[2], 22 ); ?></span>
									<span class="qz-choice-text">
										<span class="qz-choice-title"><?php echo esc_html( $p[0] ); ?></span>
										<span class="qz-choice-sub"><?php echo esc_html( $p[1] ); ?></span>
									</span>
								</button>
							<?php endforeach; ?>
						</div>
						<div class="qz-error" data-error="propertyType"><?php esc_html_e( 'Please pick a property type.', 'nyas' ); ?></div>
					</div>
				</div>

				<!-- Step 2 — Services / counts / extras -->
				<div class="qz-step" data-step="2">
					<div class="qz-step-label"><?php esc_html_e( 'Step 2 of 4', 'nyas' ); ?></div>
					<h3 class="qz-title"><?php esc_html_e( 'What needs protecting?', 'nyas' ); ?></h3>
					<p class="qz-sub"><?php esc_html_e( 'Select all that apply. Numbers are ballpark — final spec comes from the site walk.', 'nyas' ); ?></p>

					<div class="qz-group">
						<span class="qz-question"><?php esc_html_e( 'Monitoring services', 'nyas' ); ?></span>
						<div class="qz-pills" data-name="services" data-multi="1">
							<?php
							$services = array(
								array( 'Burglar', __( 'Burglar alarm', 'nyas' ),    'lock' ),
								array( 'Fire',    __( 'Fire / smoke', 'nyas' ),     'fire' ),
								array( 'Video',   __( 'Video surveillance', 'nyas' ),'cam' ),
							);
							foreach ( $services as $s ) :
								?>
								<button type="button" class="qz-pill" data-value="<?php echo esc_attr( $s[0] ); ?>" aria-pressed="false">
									<?php nyas_icon( $s[2], 16 ); ?>
									<span><?php echo esc_html( $s[1] ); ?></span>
								</button>
							<?php endforeach; ?>
						</div>
						<div class="qz-error" data-error="services"><?php esc_html_e( 'Pick at least one service.', 'nyas' ); ?></div>
					</div>

					<?php
					$counters = array(
						array( 'doors',   __( 'Entry doors', 'nyas' ),       __( 'Doors that need sensors', 'nyas' ),         2,  0, 20 ),
						array( 'windows', __( 'Windows', 'nyas' ),           __( 'Ground-floor / accessible windows', 'nyas' ),4,  0, 50 ),
						array( 'zones',   __( 'Rooms / zones', 'nyas' ),     __( 'Rooms (motion + smoke sensors)', 'nyas' ),  3,  0, 30 ),
						array( 'cameras', __( 'Cameras', 'nyas' ),           __( 'Number of cameras needed', 'nyas' ),        4,  0, 32, 'Video' ),
					);
					foreach ( $counters as $c ) :
						$show_when = isset( $c[6] ) ? $c[6] : '';
						?>
						<div class="qz-group"<?php echo $show_when ? ' data-show-when="' . esc_attr( $show_when ) . '" hidden' : ''; ?>>
							<span class="qz-question"><?php echo esc_html( $c[1] ); ?></span>
							<div class="qz-counter" data-counter="<?php echo esc_attr( $c[0] ); ?>" data-min="<?php echo (int) $c[4]; ?>" data-max="<?php echo (int) $c[5]; ?>" data-default="<?php echo (int) $c[3]; ?>">
								<span class="qz-counter-label"><?php echo esc_html( $c[2] ); ?></span>
								<div class="qz-counter-controls">
									<button type="button" class="qz-cbtn" data-action="dec" aria-label="<?php esc_attr_e( 'Decrease', 'nyas' ); ?>">&minus;</button>
									<span class="qz-cval" data-display><?php echo (int) $c[3]; ?></span>
									<button type="button" class="qz-cbtn" data-action="inc" aria-label="<?php esc_attr_e( 'Increase', 'nyas' ); ?>">+</button>
								</div>
							</div>
						</div>
					<?php endforeach; ?>

					<div class="qz-group">
						<span class="qz-question"><?php esc_html_e( 'Special requirements', 'nyas' ); ?></span>
						<div class="qz-extras">
							<?php
							$extras = array(
								array( 'glass',  __( 'Glass walls / skylights', 'nyas' ) ),
								array( 'garage', __( 'Garage doors', 'nyas' ) ),
								array( 'gates',  __( 'Rolling gates', 'nyas' ) ),
								array( 'boiler', __( 'Boiler room', 'nyas' ) ),
								array( 'panic',  __( 'Panic buttons', 'nyas' ) ),
							);
							foreach ( $extras as $e ) :
								?>
								<div class="qz-extra-row" data-extra="<?php echo esc_attr( $e[0] ); ?>" data-default="1">
									<button type="button" class="qz-extra-toggle">
										<span class="qz-extra-checkbox" aria-hidden="true">
											<svg width="12" height="12" viewBox="0 0 12 12" fill="none" stroke="white" stroke-width="2.5"><path d="M2 6l3 3 5-6" stroke-linecap="round" stroke-linejoin="round"/></svg>
										</span>
										<span class="qz-extra-label"><?php echo esc_html( $e[1] ); ?></span>
									</button>
									<div class="qz-extra-qty">
										<span class="qz-extra-qty-label"><?php esc_html_e( 'How many?', 'nyas' ); ?></span>
										<div class="qz-counter-controls">
											<button type="button" class="qz-cbtn" data-action="dec">&minus;</button>
											<span class="qz-cval" data-display>1</span>
											<button type="button" class="qz-cbtn" data-action="inc">+</button>
										</div>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				</div>

				<!-- Step 3 — Contact -->
				<div class="qz-step" data-step="3">
					<div class="qz-step-label"><?php esc_html_e( 'Step 3 of 4', 'nyas' ); ?></div>
					<h3 class="qz-title"><?php esc_html_e( 'Where should we send your quote?', 'nyas' ); ?></h3>
					<p class="qz-sub"><?php esc_html_e( 'A licensed NY consultant follows up within 15 minutes — no high-pressure sales.', 'nyas' ); ?></p>

					<div class="qz-row-2">
						<div class="qz-group">
							<label class="qz-question" for="qz-fname"><?php esc_html_e( 'First name', 'nyas' ); ?></label>
							<input type="text" id="qz-fname" class="qz-input" placeholder="Jane" autocomplete="given-name" />
							<div class="qz-error" data-error="fname"><?php esc_html_e( 'First name required.', 'nyas' ); ?></div>
						</div>
						<div class="qz-group">
							<label class="qz-question" for="qz-lname"><?php esc_html_e( 'Last name', 'nyas' ); ?></label>
							<input type="text" id="qz-lname" class="qz-input" placeholder="Esposito" autocomplete="family-name" />
							<div class="qz-error" data-error="lname"><?php esc_html_e( 'Last name required.', 'nyas' ); ?></div>
						</div>
					</div>

					<div class="qz-group">
						<label class="qz-question" for="qz-phone"><?php esc_html_e( 'Phone', 'nyas' ); ?></label>
						<input type="tel" id="qz-phone" class="qz-input" placeholder="(212) 555-0123" autocomplete="tel" />
						<div class="qz-error" data-error="phone"><?php esc_html_e( 'Valid phone number required.', 'nyas' ); ?></div>
					</div>

					<div class="qz-group">
						<label class="qz-question" for="qz-email"><?php esc_html_e( 'Email', 'nyas' ); ?></label>
						<input type="email" id="qz-email" class="qz-input" placeholder="jane@example.com" autocomplete="email" />
						<div class="qz-error" data-error="email"><?php esc_html_e( 'Valid email required.', 'nyas' ); ?></div>
					</div>

					<p class="qz-cta-note"><?php esc_html_e( 'By submitting you agree to be contacted about your quote. We never share your info.', 'nyas' ); ?></p>
				</div>

				<!-- Step 4 — Quote -->
				<div class="qz-step" data-step="4">
					<div class="qz-step-label"><?php esc_html_e( 'Your estimate', 'nyas' ); ?></div>
					<h3 class="qz-title" data-greeting><?php esc_html_e( 'Here\'s your quote', 'nyas' ); ?></h3>
					<p class="qz-sub"><?php esc_html_e( 'Itemized below. A specialist will reach out shortly to finalize.', 'nyas' ); ?></p>

					<div class="qz-quote-card">
						<div class="qz-quote-label"><?php esc_html_e( 'Estimated installation', 'nyas' ); ?></div>
						<p class="qz-quote-range" data-range>$0 &ndash; $0</p>
						<div class="qz-quote-monthly" data-monthly>+ <?php esc_html_e( 'monitoring from $0/month', 'nyas' ); ?></div>
					</div>

					<div class="qz-breakdown" data-breakdown></div>

					<p class="qz-cta-note"><?php esc_html_e( 'Preliminary range based on standard equipment. Final pricing depends on site survey, wiring, and equipment tier.', 'nyas' ); ?></p>
				</div>

				<div class="qz-actions">
					<button type="button" class="btn btn-md btn-ghost qz-back" data-back hidden>
						<?php nyas_icon( 'arrow-right', 14, 'transform:rotate(180deg)' ); ?>
						<?php esc_html_e( 'Back', 'nyas' ); ?>
					</button>
					<button type="button" class="btn btn-md btn-signal qz-next" data-next>
						<?php esc_html_e( 'Continue', 'nyas' ); ?>
						<?php nyas_icon( 'arrow-right', 14 ); ?>
					</button>
				</div>
			</div>
		</div>
	</div>
</section>
