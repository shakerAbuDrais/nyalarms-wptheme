<?php
/**
 * Reusable template helpers — eyebrows, photo wrapper, breadcrumbs, etc.
 *
 * @package NYAS
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Render the standard "eyebrow" — small uppercase blue label.
 */
function nyas_eyebrow( $label, $line = false, $extra_style = '' ) {
	$class = 'eyebrow' . ( $line ? ' eyebrow-line' : '' );
	echo '<div class="' . esc_attr( $class ) . '"' . ( $extra_style ? ' style="' . esc_attr( $extra_style ) . '"' : '' ) . '>' . wp_kses_post( $label ) . '</div>';
}

/**
 * Render a Photo (image inside an aspect-ratio frame).
 *
 * @param string $src   Image URL.
 * @param string $alt   Alt text.
 * @param string $style Inline style for the wrapper.
 * @param string $class Extra classes for the wrapper.
 */
function nyas_photo( $src, $alt = '', $style = '', $class = '' ) {
	$style_attr = $style ? ' style="' . esc_attr( $style ) . '"' : '';
	$class_attr = trim( 'media ' . $class );
	echo '<div class="' . esc_attr( $class_attr ) . '" data-alt="' . esc_attr( $alt ) . '"' . $style_attr . '>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	if ( $src ) {
		echo '<img src="' . esc_url( $src ) . '" alt="' . esc_attr( $alt ) . '" loading="lazy" decoding="async" />';
	}
	echo '</div>';
}

/**
 * Phone number used across the site (filterable / customizer-driven).
 */
function nyas_phone() {
	return apply_filters( 'nyas_phone', get_theme_mod( 'nyas_phone', '(212) 555-0142' ) );
}

function nyas_phone_tel() {
	return preg_replace( '/[^0-9+]/', '', nyas_phone() );
}

/**
 * Mono breadcrumb row.
 *
 * @param array $crumbs Array of `[label, url]` (last item is current; pass null url).
 * @param bool  $on_dark Whether the breadcrumb sits on a dark hero (uses lighter text).
 */
function nyas_breadcrumb( $crumbs, $on_dark = false ) {
	$muted   = $on_dark ? 'rgba(246,243,236,0.55)' : 'var(--fg-3)';
	$current = $on_dark ? 'var(--fg-on-ink)' : 'var(--fg)';
	echo '<div style="font-family:var(--ff-mono);font-size:12px;color:' . esc_attr( $muted ) . ';letter-spacing:0.08em;margin-bottom:24px">';
	$last = count( $crumbs ) - 1;
	foreach ( $crumbs as $i => $crumb ) {
		$label = strtoupper( $crumb[0] );
		$url   = isset( $crumb[1] ) ? $crumb[1] : '';
		if ( $i === $last || empty( $url ) ) {
			echo '<span style="color:' . esc_attr( $current ) . '">' . esc_html( $label ) . '</span>';
		} else {
			echo '<a href="' . esc_url( $url ) . '" style="color:' . esc_attr( $muted ) . '">' . esc_html( $label ) . '</a>';
		}
		if ( $i < $last ) {
			echo ' · ';
		}
	}
	echo '</div>';
}

/**
 * Lead form — used in CTA bands, quote sections, etc.
 *
 * @param array $args Configuration.
 */
function nyas_lead_form( $args = array() ) {
	$args = wp_parse_args( $args, array(
		'compact' => false,
		'id'      => 'nyas-form-' . wp_rand( 1000, 9999 ),
	) );

	$id = sanitize_html_class( $args['id'] );
	?>
	<form class="nyas-lead-form" id="<?php echo esc_attr( $id ); ?>" data-nyas-form data-nyas-form-id="<?php echo esc_attr( $id ); ?>" novalidate>
		<div class="nyas-form-fields" style="display:flex;flex-direction:column;gap:12px">
			<?php if ( ! $args['compact'] ) : ?>
				<div class="radios" data-nyas-radio-group>
					<?php foreach ( array( 'Home', 'Business', 'Warehouse' ) as $i => $type ) : ?>
						<label class="radio-pill<?php echo 0 === $i ? ' on' : ''; ?>">
							<input type="radio" name="<?php echo esc_attr( $id ); ?>-type" value="<?php echo esc_attr( $type ); ?>" <?php checked( 0 === $i ); ?> />
							<?php echo esc_html( $type ); ?>
						</label>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<div class="field">
				<label for="<?php echo esc_attr( $id ); ?>-name"><?php esc_html_e( 'Full name', 'nyas' ); ?></label>
				<input class="input" id="<?php echo esc_attr( $id ); ?>-name" name="name" required placeholder="Jane Esposito" />
			</div>
			<div class="field-row">
				<div class="field">
					<label for="<?php echo esc_attr( $id ); ?>-phone"><?php esc_html_e( 'Phone', 'nyas' ); ?></label>
					<input class="input" id="<?php echo esc_attr( $id ); ?>-phone" name="phone" type="tel" required placeholder="(212) 555-0123" />
				</div>
				<div class="field">
					<label for="<?php echo esc_attr( $id ); ?>-zip"><?php esc_html_e( 'ZIP', 'nyas' ); ?></label>
					<input class="input" id="<?php echo esc_attr( $id ); ?>-zip" name="zip" required placeholder="10013" />
				</div>
			</div>
			<button type="submit" class="btn btn-lg btn-signal">
				<?php esc_html_e( 'Get my free quote', 'nyas' ); ?>
				<?php nyas_icon( 'arrow-right', 15 ); ?>
			</button>
			<p class="muted" style="font-size:12px;text-align:center;margin:0">
				<?php
				printf(
					/* translators: %s: minutes. */
					esc_html__( 'Free, no-obligation. Licensed NY consultant calls within %s.', 'nyas' ),
					'<strong>15 min</strong>' // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				);
				?>
			</p>
		</div>

		<div class="nyas-form-success" hidden style="padding:20px;text-align:center">
			<div style="width:56px;height:56px;border-radius:50%;background:var(--brand-signal-soft);display:inline-flex;align-items:center;justify-content:center;margin-bottom:14px;color:var(--brand-signal)">
				<?php nyas_icon( 'check', 28 ); ?>
			</div>
			<h3 style="font-family:var(--ff-display);font-size:24px;font-weight:800;margin-bottom:8px"><?php esc_html_e( 'Got it. Thanks.', 'nyas' ); ?></h3>
			<p style="color:var(--fg-2);font-size:14px;margin:0">
				<?php
				printf(
					/* translators: %s: minutes. */
					esc_html__( 'A licensed NY consultant will text you within %s.', 'nyas' ),
					'<strong>15 min</strong>' // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				);
				?>
			</p>
		</div>
	</form>
	<?php
}

/**
 * Render a top utility / phone bar.
 */
function nyas_topbar() {
	if ( ! get_theme_mod( 'nyas_show_topbar', true ) ) {
		return;
	}
	?>
	<div class="topbar">
		<div class="container">
			<span class="pill"><span class="dot"></span> <?php esc_html_e( 'Monitoring station online · 24/7', 'nyas' ); ?></span>
			<div style="display:flex;gap:22px;align-items:center;font-size:13px">
				<span style="color:rgba(255,255,255,0.78)"><?php esc_html_e( 'Licensed NY · UL-listed', 'nyas' ); ?></span>
				<a href="tel:<?php echo esc_attr( nyas_phone_tel() ); ?>" style="display:inline-flex;align-items:center;gap:6px;font-weight:600">
					<?php nyas_icon( 'phone', 13 ); ?>
					<?php esc_html_e( 'Call sales:', 'nyas' ); ?> <?php echo esc_html( nyas_phone() ); ?>
				</a>
			</div>
		</div>
	</div>
	<?php
}

/**
 * Render the bottom CTA band ("Tell us about the space. We do the rest.").
 *
 * @param array $args
 */
function nyas_final_cta( $args = array() ) {
	$args = wp_parse_args( $args, array(
		'eyebrow'   => __( 'Ready when you are', 'nyas' ),
		'heading'   => __( 'Tell us about the space. <em>We do the rest.</em>', 'nyas' ),
		'lede'      => __( 'Free site walk, written quote, no high-pressure sales. Most NYC homeowners and operators have a working system within ten business days of first call.', 'nyas' ),
		'cta_label' => __( 'Schedule my site walk', 'nyas' ),
		'show_form' => true,
	) );
	?>
	<section style="padding:96px 0;background:var(--brand-ink);color:var(--fg-on-ink);position:relative;overflow:hidden">
		<div style="position:absolute;inset:0;opacity:0.04;background-image:linear-gradient(to right,#fff 1px,transparent 1px),linear-gradient(to bottom,#fff 1px,transparent 1px);background-size:32px 32px"></div>
		<div class="container nyas-final-cta" style="position:relative;display:grid;grid-template-columns:<?php echo $args['show_form'] ? '1.2fr 1fr' : '1fr'; ?>;gap:64px;align-items:center">
			<div>
				<div class="eyebrow" style="color:rgba(246,243,236,0.55);margin-bottom:20px"><?php echo wp_kses_post( $args['eyebrow'] ); ?></div>
				<h2 class="display-lg" style="color:var(--fg-on-ink);margin-bottom:24px"><?php echo wp_kses_post( $args['heading'] ); ?></h2>
				<p style="color:rgba(246,243,236,0.78);font-size:17px;line-height:1.6;margin-bottom:32px;max-width:480px"><?php echo wp_kses_post( $args['lede'] ); ?></p>
				<div style="display:flex;gap:12px;flex-wrap:wrap">
					<a href="#cta-form" class="btn btn-lg btn-signal"><?php echo esc_html( $args['cta_label'] ); ?> <?php nyas_icon( 'arrow-right', 15 ); ?></a>
					<a href="tel:<?php echo esc_attr( nyas_phone_tel() ); ?>" class="btn btn-lg" style="background:rgba(246,243,236,0.10);color:var(--fg-on-ink);border:1px solid rgba(246,243,236,0.20)"><?php nyas_icon( 'phone', 14 ); ?> <?php echo esc_html( nyas_phone() ); ?></a>
				</div>
			</div>
			<?php if ( $args['show_form'] ) : ?>
				<div id="cta-form" style="background:var(--brand-paper);border-radius:16px;padding:28px;color:var(--fg)">
					<h3 style="font-family:var(--ff-display);font-weight:800;font-size:26px;margin-bottom:6px;letter-spacing:-0.02em"><?php esc_html_e( 'Free site walk', 'nyas' ); ?></h3>
					<p style="font-size:13px;color:var(--fg-2);margin-bottom:18px"><?php esc_html_e( 'Within 48 hours. Anywhere in the five boroughs.', 'nyas' ); ?></p>
					<?php nyas_lead_form( array( 'compact' => true ) ); ?>
				</div>
			<?php endif; ?>
		</div>
	</section>
	<?php
}
