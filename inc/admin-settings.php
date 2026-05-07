<?php
/**
 * NYAS settings page — SMTP + notification email + a "test send" button.
 *
 * Lives at: NYAS → Settings (top-level admin menu, beside Leads).
 *
 * @package NYAS
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Top-level menu so Settings, Leads, and Setup all live under one umbrella.
 */
function nyas_admin_menu() {
	// The Lead CPT registered with menu_position 25 already gives us a
	// top-level "Leads" item. We add a Settings submenu under it.
	add_submenu_page(
		'edit.php?post_type=nyas_lead',
		__( 'NYAS Settings', 'nyas' ),
		__( 'Settings', 'nyas' ),
		'manage_options',
		'nyas-settings',
		'nyas_render_settings_page'
	);
}
add_action( 'admin_menu', 'nyas_admin_menu' );

/**
 * Register settings.
 */
function nyas_register_settings() {
	// Notification email.
	register_setting( 'nyas_settings', 'nyas_notify_email', array(
		'type'              => 'string',
		'sanitize_callback' => 'sanitize_email',
		'default'           => get_option( 'admin_email' ),
	) );
	register_setting( 'nyas_settings', 'nyas_notify_cc', array(
		'type'              => 'string',
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => '',
	) );

	// SMTP settings.
	$smtp_defaults = array(
		'enabled'     => 0,
		'host'        => '',
		'port'        => 587,
		'username'    => '',
		'password'    => '',
		'encryption'  => 'tls',
		'from_email'  => '',
		'from_name'   => '',
	);
	register_setting( 'nyas_settings', 'nyas_smtp', array(
		'type'              => 'array',
		'default'           => $smtp_defaults,
		'sanitize_callback' => 'nyas_sanitize_smtp',
	) );
}
add_action( 'admin_init', 'nyas_register_settings' );

function nyas_sanitize_smtp( $input ) {
	$out = array(
		'enabled'    => ! empty( $input['enabled'] ) ? 1 : 0,
		'host'       => isset( $input['host'] )       ? sanitize_text_field( $input['host'] ) : '',
		'port'       => isset( $input['port'] )       ? max( 1, min( 65535, (int) $input['port'] ) ) : 587,
		'username'   => isset( $input['username'] )   ? sanitize_text_field( $input['username'] ) : '',
		'encryption' => isset( $input['encryption'] ) && in_array( $input['encryption'], array( 'none', 'ssl', 'tls' ), true ) ? $input['encryption'] : 'tls',
		'from_email' => isset( $input['from_email'] ) ? sanitize_email( $input['from_email'] ) : '',
		'from_name'  => isset( $input['from_name'] )  ? sanitize_text_field( $input['from_name'] ) : '',
	);

	// Password: only update if a non-empty value was submitted, otherwise keep old.
	$existing = get_option( 'nyas_smtp', array() );
	if ( isset( $input['password'] ) && '' !== $input['password'] ) {
		$out['password'] = (string) $input['password']; // stored as-is in DB; consider Application Passwords / env in production.
	} else {
		$out['password'] = isset( $existing['password'] ) ? $existing['password'] : '';
	}

	return $out;
}

/**
 * Hook into PHPMailer to apply SMTP settings.
 */
function nyas_configure_phpmailer( $phpmailer ) {
	$smtp = get_option( 'nyas_smtp' );
	if ( empty( $smtp ) || empty( $smtp['enabled'] ) || empty( $smtp['host'] ) ) {
		return;
	}

	$phpmailer->isSMTP();
	$phpmailer->Host       = $smtp['host'];
	$phpmailer->Port       = (int) $smtp['port'];
	$phpmailer->SMTPAuth   = ! empty( $smtp['username'] );
	$phpmailer->Username   = $smtp['username'];
	$phpmailer->Password   = $smtp['password'];
	$phpmailer->SMTPSecure = ( 'none' === $smtp['encryption'] ) ? '' : $smtp['encryption'];

	if ( ! empty( $smtp['from_email'] ) ) {
		$phpmailer->setFrom( $smtp['from_email'], ! empty( $smtp['from_name'] ) ? $smtp['from_name'] : '' );
	}
}
add_action( 'phpmailer_init', 'nyas_configure_phpmailer' );

/**
 * Force From header so wp_mail uses the configured From address.
 */
function nyas_mail_from( $email ) {
	$smtp = get_option( 'nyas_smtp' );
	if ( ! empty( $smtp['enabled'] ) && ! empty( $smtp['from_email'] ) ) {
		return $smtp['from_email'];
	}
	return $email;
}
add_filter( 'wp_mail_from', 'nyas_mail_from' );

function nyas_mail_from_name( $name ) {
	$smtp = get_option( 'nyas_smtp' );
	if ( ! empty( $smtp['enabled'] ) && ! empty( $smtp['from_name'] ) ) {
		return $smtp['from_name'];
	}
	return $name;
}
add_filter( 'wp_mail_from_name', 'nyas_mail_from_name' );

/**
 * "Send test email" handler.
 */
function nyas_handle_test_email() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'Insufficient permissions.', 'nyas' ) );
	}
	check_admin_referer( 'nyas_send_test' );

	$to = trim( get_option( 'nyas_notify_email', get_option( 'admin_email' ) ) );
	if ( ! is_email( $to ) ) {
		set_transient( 'nyas_test_flash', array( 'type' => 'error', 'msg' => __( 'No valid notification email set.', 'nyas' ) ), 60 );
		wp_safe_redirect( wp_get_referer() );
		exit;
	}

	$site = get_bloginfo( 'name' );
	$ok   = wp_mail(
		$to,
		'[' . $site . '] ' . __( 'Test email from NYAS', 'nyas' ),
		'<p>' . sprintf( esc_html__( 'This is a test email from %s.', 'nyas' ), esc_html( $site ) ) . '</p><p>' . esc_html__( 'If you received this, your SMTP settings are working.', 'nyas' ) . '</p>',
		array( 'Content-Type: text/html; charset=UTF-8' )
	);

	set_transient(
		'nyas_test_flash',
		array(
			'type' => $ok ? 'success' : 'error',
			'msg'  => $ok
				? sprintf( __( 'Test email sent to %s. Check inbox (and spam).', 'nyas' ), $to )
				: __( 'Test email failed. Check SMTP settings and server logs.', 'nyas' ),
		),
		60
	);

	wp_safe_redirect( wp_get_referer() );
	exit;
}
add_action( 'admin_post_nyas_send_test', 'nyas_handle_test_email' );

/**
 * Render the settings page.
 */
function nyas_render_settings_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$smtp   = get_option( 'nyas_smtp', array() );
	$notify = get_option( 'nyas_notify_email', get_option( 'admin_email' ) );
	$cc     = get_option( 'nyas_notify_cc', '' );

	$flash = get_transient( 'nyas_test_flash' );
	if ( $flash ) {
		delete_transient( 'nyas_test_flash' );
		echo '<div class="notice notice-' . esc_attr( $flash['type'] ) . ' is-dismissible"><p>' . esc_html( $flash['msg'] ) . '</p></div>';
	}
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'NYAS Settings', 'nyas' ); ?></h1>
		<p style="font-size: 14px; color: #50575e; max-width: 640px;">
			<?php esc_html_e( 'Configure who receives lead notifications and (optionally) the SMTP server used to send them. WordPress\'s default email setup often lands in spam — using a real SMTP relay (Gmail, SendGrid, Postmark, Mailgun, etc.) fixes that.', 'nyas' ); ?>
		</p>

		<form method="post" action="options.php">
			<?php settings_fields( 'nyas_settings' ); ?>

			<h2 style="margin-top: 32px;"><?php esc_html_e( 'Notifications', 'nyas' ); ?></h2>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><label for="nyas_notify_email"><?php esc_html_e( 'Notification email', 'nyas' ); ?></label></th>
					<td>
						<input type="email" id="nyas_notify_email" name="nyas_notify_email" value="<?php echo esc_attr( $notify ); ?>" class="regular-text" />
						<p class="description"><?php esc_html_e( 'Lead notifications go to this address whenever someone submits the homepage quote wizard.', 'nyas' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="nyas_notify_cc"><?php esc_html_e( 'Cc (optional)', 'nyas' ); ?></label></th>
					<td>
						<input type="text" id="nyas_notify_cc" name="nyas_notify_cc" value="<?php echo esc_attr( $cc ); ?>" class="regular-text" placeholder="ops@example.com, sales@example.com" />
						<p class="description"><?php esc_html_e( 'Comma-separated list of additional recipients (currently informational — wire into wp_mail headers if needed).', 'nyas' ); ?></p>
					</td>
				</tr>
			</table>

			<h2 style="margin-top: 32px;"><?php esc_html_e( 'SMTP', 'nyas' ); ?></h2>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><?php esc_html_e( 'Enable custom SMTP', 'nyas' ); ?></th>
					<td>
						<label>
							<input type="checkbox" name="nyas_smtp[enabled]" value="1" <?php checked( ! empty( $smtp['enabled'] ) ); ?> />
							<?php esc_html_e( 'Use the SMTP server below instead of the host\'s default mail (recommended).', 'nyas' ); ?>
						</label>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="nyas_smtp_host"><?php esc_html_e( 'Host', 'nyas' ); ?></label></th>
					<td>
						<input type="text" id="nyas_smtp_host" name="nyas_smtp[host]" value="<?php echo esc_attr( $smtp['host'] ?? '' ); ?>" class="regular-text" placeholder="smtp.gmail.com" />
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="nyas_smtp_port"><?php esc_html_e( 'Port', 'nyas' ); ?></label></th>
					<td>
						<input type="number" min="1" max="65535" id="nyas_smtp_port" name="nyas_smtp[port]" value="<?php echo esc_attr( $smtp['port'] ?? 587 ); ?>" />
						<p class="description"><?php esc_html_e( 'Common: 587 (TLS), 465 (SSL), 25 (none).', 'nyas' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'Encryption', 'nyas' ); ?></th>
					<td>
						<?php $enc = $smtp['encryption'] ?? 'tls'; ?>
						<label><input type="radio" name="nyas_smtp[encryption]" value="tls"  <?php checked( $enc, 'tls' ); ?> /> TLS</label>
						&nbsp;&nbsp;
						<label><input type="radio" name="nyas_smtp[encryption]" value="ssl"  <?php checked( $enc, 'ssl' ); ?> /> SSL</label>
						&nbsp;&nbsp;
						<label><input type="radio" name="nyas_smtp[encryption]" value="none" <?php checked( $enc, 'none' ); ?> /> <?php esc_html_e( 'None', 'nyas' ); ?></label>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="nyas_smtp_username"><?php esc_html_e( 'Username', 'nyas' ); ?></label></th>
					<td>
						<input type="text" id="nyas_smtp_username" name="nyas_smtp[username]" value="<?php echo esc_attr( $smtp['username'] ?? '' ); ?>" class="regular-text" autocomplete="off" />
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="nyas_smtp_password"><?php esc_html_e( 'Password', 'nyas' ); ?></label></th>
					<td>
						<input type="password" id="nyas_smtp_password" name="nyas_smtp[password]" value="" class="regular-text" placeholder="<?php echo ! empty( $smtp['password'] ) ? esc_attr__( '(saved — leave blank to keep)', 'nyas' ) : ''; ?>" autocomplete="new-password" />
						<p class="description"><?php esc_html_e( 'For Gmail, use an App Password. Leave blank to keep the saved value.', 'nyas' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="nyas_smtp_from_email"><?php esc_html_e( 'From email', 'nyas' ); ?></label></th>
					<td>
						<input type="email" id="nyas_smtp_from_email" name="nyas_smtp[from_email]" value="<?php echo esc_attr( $smtp['from_email'] ?? '' ); ?>" class="regular-text" placeholder="no-reply@yourdomain.com" />
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="nyas_smtp_from_name"><?php esc_html_e( 'From name', 'nyas' ); ?></label></th>
					<td>
						<input type="text" id="nyas_smtp_from_name" name="nyas_smtp[from_name]" value="<?php echo esc_attr( $smtp['from_name'] ?? '' ); ?>" class="regular-text" placeholder="<?php bloginfo( 'name' ); ?>" />
					</td>
				</tr>
			</table>

			<?php submit_button(); ?>
		</form>

		<hr style="margin: 40px 0 24px;" />

		<h2><?php esc_html_e( 'Send a test email', 'nyas' ); ?></h2>
		<p><?php esc_html_e( 'Sends a quick HTML test message to the notification address above. Use this after saving SMTP settings to confirm delivery.', 'nyas' ); ?></p>
		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<input type="hidden" name="action" value="nyas_send_test" />
			<?php wp_nonce_field( 'nyas_send_test' ); ?>
			<button type="submit" class="button button-primary"><?php esc_html_e( 'Send test email', 'nyas' ); ?></button>
		</form>
	</div>
	<?php
}
