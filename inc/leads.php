<?php
/**
 * NYAS leads — custom post type + admin-ajax handler + admin list customisations.
 *
 * Stores wizard submissions as `nyas_lead` posts. Sends an HTML notification
 * email to the address configured in Settings → NYAS Settings → Notifications.
 *
 * @package NYAS
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the Lead custom post type — admin-only, not public.
 */
function nyas_register_lead_cpt() {
	register_post_type( 'nyas_lead', array(
		'labels' => array(
			'name'               => __( 'Leads', 'nyas' ),
			'singular_name'      => __( 'Lead', 'nyas' ),
			'menu_name'          => __( 'Leads', 'nyas' ),
			'all_items'          => __( 'All Leads', 'nyas' ),
			'view_item'          => __( 'View Lead', 'nyas' ),
			'edit_item'          => __( 'Edit Lead', 'nyas' ),
			'search_items'       => __( 'Search Leads', 'nyas' ),
			'not_found'          => __( 'No leads found yet.', 'nyas' ),
			'not_found_in_trash' => __( 'No leads in trash.', 'nyas' ),
		),
		'public'             => false,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_admin_bar'  => false,
		'menu_position'      => 25,
		'menu_icon'          => 'dashicons-email-alt',
		'capability_type'    => 'post',
		'capabilities'       => array(
			'create_posts' => 'do_not_allow', // leads come from the form, not authoring.
		),
		'map_meta_cap'       => true,
		'supports'           => array( 'title' ),
		'has_archive'        => false,
		'rewrite'            => false,
		'hierarchical'       => false,
		'show_in_rest'       => false,
	) );
}
add_action( 'init', 'nyas_register_lead_cpt' );

/**
 * Custom columns on the Leads list table.
 */
function nyas_lead_columns( $cols ) {
	return array(
		'cb'          => $cols['cb'],
		'title'       => __( 'Lead', 'nyas' ),
		'nyas_phone'  => __( 'Phone', 'nyas' ),
		'nyas_email'  => __( 'Email', 'nyas' ),
		'nyas_prop'   => __( 'Property', 'nyas' ),
		'nyas_quote'  => __( 'Quote', 'nyas' ),
		'date'        => __( 'Submitted', 'nyas' ),
	);
}
add_filter( 'manage_nyas_lead_posts_columns', 'nyas_lead_columns' );

function nyas_lead_column_value( $col, $post_id ) {
	switch ( $col ) {
		case 'nyas_phone':
			$v = get_post_meta( $post_id, 'nyas_phone', true );
			if ( $v ) {
				echo '<a href="tel:' . esc_attr( preg_replace( '/[^0-9+]/', '', $v ) ) . '">' . esc_html( $v ) . '</a>';
			}
			break;
		case 'nyas_email':
			$v = get_post_meta( $post_id, 'nyas_email', true );
			if ( $v ) {
				echo '<a href="mailto:' . esc_attr( $v ) . '">' . esc_html( $v ) . '</a>';
			}
			break;
		case 'nyas_prop':
			echo esc_html( get_post_meta( $post_id, 'nyas_property', true ) );
			$svc = get_post_meta( $post_id, 'nyas_services', true );
			if ( is_array( $svc ) && $svc ) {
				echo '<br><small style="color:#646970">' . esc_html( implode( ' · ', $svc ) ) . '</small>';
			}
			break;
		case 'nyas_quote':
			$low  = (int) get_post_meta( $post_id, 'nyas_quote_low', true );
			$high = (int) get_post_meta( $post_id, 'nyas_quote_high', true );
			$mo   = (int) get_post_meta( $post_id, 'nyas_quote_monthly', true );
			if ( $low || $high ) {
				echo '$' . esc_html( number_format( $low ) ) . ' – $' . esc_html( number_format( $high ) );
				if ( $mo ) {
					echo '<br><small style="color:#646970">+ $' . esc_html( $mo ) . '/mo</small>';
				}
			}
			break;
	}
}
add_action( 'manage_nyas_lead_posts_custom_column', 'nyas_lead_column_value', 10, 2 );

/**
 * Detail meta box on the Edit Lead screen.
 */
function nyas_lead_meta_box() {
	add_meta_box(
		'nyas_lead_details',
		__( 'Lead details', 'nyas' ),
		'nyas_render_lead_details',
		'nyas_lead',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes_nyas_lead', 'nyas_lead_meta_box' );

function nyas_render_lead_details( $post ) {
	$fields = array(
		'nyas_fname'         => __( 'First name', 'nyas' ),
		'nyas_lname'         => __( 'Last name', 'nyas' ),
		'nyas_phone'         => __( 'Phone', 'nyas' ),
		'nyas_email'         => __( 'Email', 'nyas' ),
		'nyas_property'      => __( 'Property type', 'nyas' ),
		'nyas_services'      => __( 'Services', 'nyas' ),
		'nyas_doors'         => __( 'Doors', 'nyas' ),
		'nyas_windows'       => __( 'Windows', 'nyas' ),
		'nyas_zones'         => __( 'Zones / rooms', 'nyas' ),
		'nyas_cameras'       => __( 'Cameras', 'nyas' ),
		'nyas_extras'        => __( 'Extras', 'nyas' ),
		'nyas_quote_low'     => __( 'Estimate (low)', 'nyas' ),
		'nyas_quote_high'    => __( 'Estimate (high)', 'nyas' ),
		'nyas_quote_monthly' => __( 'Monthly monitoring', 'nyas' ),
		'nyas_url'           => __( 'Submitted from', 'nyas' ),
		'nyas_ip'            => __( 'IP', 'nyas' ),
	);
	echo '<table class="widefat striped" style="border:0">';
	foreach ( $fields as $key => $label ) {
		$v = get_post_meta( $post->ID, $key, true );
		if ( is_array( $v ) ) {
			$v = implode( ', ', array_map( function ( $a, $b ) {
				return is_array( $b ) ? $a . ': ' . wp_json_encode( $b ) : ( is_string( $b ) ? $b : ( $a . ': ' . $b ) );
			}, array_keys( $v ), array_values( $v ) ) );
		}
		echo '<tr>';
		echo '<th style="width:180px;text-align:left;padding:8px 12px">' . esc_html( $label ) . '</th>';
		echo '<td style="padding:8px 12px">' . esc_html( (string) $v ) . '</td>';
		echo '</tr>';
	}
	echo '</table>';

	$items = get_post_meta( $post->ID, 'nyas_quote_items', true );
	if ( is_array( $items ) && $items ) {
		echo '<h3 style="margin-top:24px">' . esc_html__( 'Equipment breakdown', 'nyas' ) . '</h3>';
		echo '<table class="widefat striped"><thead><tr><th>Item</th><th>Qty</th><th>Unit</th><th>Subtotal</th></tr></thead><tbody>';
		foreach ( $items as $it ) {
			echo '<tr>';
			echo '<td>' . esc_html( $it['label'] ?? '' ) . '</td>';
			echo '<td>' . (int) ( $it['qty'] ?? 0 ) . '</td>';
			echo '<td>$' . esc_html( number_format( (int) ( $it['unit'] ?? 0 ) ) ) . '</td>';
			echo '<td>$' . esc_html( number_format( (int) ( $it['sub'] ?? 0 ) ) ) . '</td>';
			echo '</tr>';
		}
		echo '</tbody></table>';
	}
}

/**
 * Submission handler — admin-ajax POST nyas_submit_lead.
 */
function nyas_handle_lead_submit() {
	if ( ! check_ajax_referer( 'nyas_submit_lead', '_wpnonce', false ) ) {
		wp_send_json_error( array( 'message' => __( 'Invalid nonce.', 'nyas' ) ), 403 );
	}

	$raw = isset( $_POST['payload'] ) ? wp_unslash( $_POST['payload'] ) : ''; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.MissingUnslash
	if ( ! is_string( $raw ) || '' === $raw ) {
		wp_send_json_error( array( 'message' => __( 'Empty payload.', 'nyas' ) ), 400 );
	}

	$data = json_decode( $raw, true );
	if ( ! is_array( $data ) ) {
		wp_send_json_error( array( 'message' => __( 'Bad payload.', 'nyas' ) ), 400 );
	}

	$contact  = isset( $data['contact'] )  && is_array( $data['contact'] )  ? $data['contact']  : array();
	$property = isset( $data['property'] ) ? sanitize_text_field( $data['property'] ) : '';
	$services = isset( $data['services'] ) && is_array( $data['services'] ) ? array_map( 'sanitize_text_field', $data['services'] ) : array();
	$counts   = isset( $data['counts'] )   && is_array( $data['counts'] )   ? $data['counts']   : array();
	$extras   = isset( $data['extras'] )   && is_array( $data['extras'] )   ? $data['extras']   : array();
	$quote    = isset( $data['quote'] )    && is_array( $data['quote'] )    ? $data['quote']    : array();
	$url      = isset( $data['url'] )      ? esc_url_raw( $data['url'] )    : '';

	$fname = isset( $contact['fname'] ) ? sanitize_text_field( $contact['fname'] ) : '';
	$lname = isset( $contact['lname'] ) ? sanitize_text_field( $contact['lname'] ) : '';
	$phone = isset( $contact['phone'] ) ? sanitize_text_field( $contact['phone'] ) : '';
	$email = isset( $contact['email'] ) ? sanitize_email( $contact['email'] )      : '';

	if ( empty( $email ) || ! is_email( $email ) ) {
		wp_send_json_error( array( 'message' => __( 'Invalid email.', 'nyas' ) ), 400 );
	}

	$title = trim( $fname . ' ' . $lname ) . ' — ' . $property;

	$post_id = wp_insert_post( array(
		'post_type'   => 'nyas_lead',
		'post_status' => 'publish',
		'post_title'  => $title ?: __( 'Lead', 'nyas' ) . ' ' . current_time( 'Y-m-d H:i' ),
	), true );

	if ( is_wp_error( $post_id ) || ! $post_id ) {
		wp_send_json_error( array( 'message' => __( 'Could not save lead.', 'nyas' ) ), 500 );
	}

	update_post_meta( $post_id, 'nyas_fname',         $fname );
	update_post_meta( $post_id, 'nyas_lname',         $lname );
	update_post_meta( $post_id, 'nyas_phone',         $phone );
	update_post_meta( $post_id, 'nyas_email',         $email );
	update_post_meta( $post_id, 'nyas_property',      $property );
	update_post_meta( $post_id, 'nyas_services',      $services );
	update_post_meta( $post_id, 'nyas_doors',         (int) ( $counts['doors']   ?? 0 ) );
	update_post_meta( $post_id, 'nyas_windows',       (int) ( $counts['windows'] ?? 0 ) );
	update_post_meta( $post_id, 'nyas_zones',         (int) ( $counts['zones']   ?? 0 ) );
	update_post_meta( $post_id, 'nyas_cameras',       (int) ( $counts['cameras'] ?? 0 ) );
	update_post_meta( $post_id, 'nyas_extras',        $extras );
	update_post_meta( $post_id, 'nyas_quote_low',     (int) ( $quote['low']     ?? 0 ) );
	update_post_meta( $post_id, 'nyas_quote_high',    (int) ( $quote['high']    ?? 0 ) );
	update_post_meta( $post_id, 'nyas_quote_monthly', (int) ( $quote['monthly'] ?? 0 ) );
	update_post_meta( $post_id, 'nyas_quote_items',   isset( $quote['items'] ) && is_array( $quote['items'] ) ? $quote['items'] : array() );
	update_post_meta( $post_id, 'nyas_url',           $url );
	update_post_meta( $post_id, 'nyas_ip',            isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '' );

	// Notification email.
	nyas_send_lead_notification( $post_id );

	wp_send_json_success( array( 'id' => $post_id ) );
}
add_action( 'wp_ajax_nyas_submit_lead',        'nyas_handle_lead_submit' );
add_action( 'wp_ajax_nopriv_nyas_submit_lead', 'nyas_handle_lead_submit' );

/**
 * Send the HTML notification email to the configured recipient.
 */
function nyas_send_lead_notification( $post_id ) {
	$to = trim( get_option( 'nyas_notify_email', get_option( 'admin_email' ) ) );
	if ( ! $to || ! is_email( $to ) ) {
		return;
	}

	$fname    = get_post_meta( $post_id, 'nyas_fname', true );
	$lname    = get_post_meta( $post_id, 'nyas_lname', true );
	$phone    = get_post_meta( $post_id, 'nyas_phone', true );
	$email    = get_post_meta( $post_id, 'nyas_email', true );
	$property = get_post_meta( $post_id, 'nyas_property', true );
	$services = get_post_meta( $post_id, 'nyas_services', true );
	$low      = (int) get_post_meta( $post_id, 'nyas_quote_low', true );
	$high     = (int) get_post_meta( $post_id, 'nyas_quote_high', true );
	$monthly  = (int) get_post_meta( $post_id, 'nyas_quote_monthly', true );
	$items    = get_post_meta( $post_id, 'nyas_quote_items', true );
	$edit_url = admin_url( 'post.php?post=' . $post_id . '&action=edit' );

	$site_name = get_bloginfo( 'name' );
	$subject   = sprintf( '[%s] New lead: %s %s', $site_name, $fname, $lname );

	$rows = '';
	if ( is_array( $items ) ) {
		foreach ( $items as $it ) {
			$rows .= sprintf(
				'<tr><td style="padding:8px 12px;border-bottom:1px solid #eee">%s</td><td style="padding:8px 12px;border-bottom:1px solid #eee;text-align:right">$%s</td></tr>',
				esc_html( $it['label'] ?? '' ) . ( ! empty( $it['qty'] ) && $it['qty'] > 1 ? ' (' . (int) $it['qty'] . ' × $' . (int) $it['unit'] . ')' : '' ),
				number_format( (int) ( $it['sub'] ?? 0 ) )
			);
		}
	}

	$service_str = is_array( $services ) ? implode( ' · ', $services ) : (string) $services;

	$body = '<!doctype html><html><body style="font-family:-apple-system,BlinkMacSystemFont,sans-serif;color:#0E1116;background:#F1F4F8;margin:0;padding:24px">'
		. '<div style="max-width:600px;margin:0 auto;background:#fff;border-radius:14px;overflow:hidden;box-shadow:0 4px 12px rgba(0,0,0,0.06)">'
		. '<div style="background:#0E1116;color:#fff;padding:24px 28px"><div style="font-size:11px;letter-spacing:0.14em;text-transform:uppercase;color:rgba(255,255,255,0.6);margin-bottom:8px">' . esc_html__( 'New lead', 'nyas' ) . '</div>'
		. '<h1 style="margin:0;font-size:24px;font-weight:800">' . esc_html( $fname . ' ' . $lname ) . '</h1>'
		. '<p style="margin:6px 0 0;color:rgba(255,255,255,0.78);font-size:14px">' . esc_html( $property ) . ' · ' . esc_html( $service_str ) . '</p></div>'
		. '<div style="padding:24px 28px">'
		. '<table style="width:100%;border-collapse:collapse;margin-bottom:16px"><tbody>'
		. '<tr><td style="padding:6px 0;color:#5A6273;font-size:13px;width:120px">Phone</td><td style="padding:6px 0"><a href="tel:' . esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ) . '" style="color:#1F4DD8">' . esc_html( $phone ) . '</a></td></tr>'
		. '<tr><td style="padding:6px 0;color:#5A6273;font-size:13px">Email</td><td style="padding:6px 0"><a href="mailto:' . esc_attr( $email ) . '" style="color:#1F4DD8">' . esc_html( $email ) . '</a></td></tr>'
		. '</tbody></table>'
		. '<div style="background:#F1F4F8;border-radius:10px;padding:16px;margin-bottom:16px">'
		. '<div style="font-family:ui-monospace,monospace;font-size:11px;letter-spacing:0.12em;text-transform:uppercase;color:#5A6273;margin-bottom:8px">Estimated installation</div>'
		. '<div style="font-size:28px;font-weight:800;color:#0E1116">$' . number_format( $low ) . ' – $' . number_format( $high ) . '</div>'
		. '<div style="font-size:13px;color:#5A6273;margin-top:4px">+ monitoring from $' . (int) $monthly . '/month</div>'
		. '</div>'
		. ( $rows ? '<table style="width:100%;border-collapse:collapse;font-size:13px"><tbody>' . $rows . '</tbody></table>' : '' )
		. '<div style="margin-top:24px;text-align:center"><a href="' . esc_url( $edit_url ) . '" style="display:inline-block;padding:12px 22px;background:#1F4DD8;color:#fff;text-decoration:none;border-radius:999px;font-weight:700;font-size:14px">View in admin</a></div>'
		. '</div></div></body></html>';

	$headers = array(
		'Content-Type: text/html; charset=UTF-8',
	);
	if ( $email ) {
		$headers[] = 'Reply-To: ' . $fname . ' ' . $lname . ' <' . $email . '>';
	}

	wp_mail( $to, $subject, $body, $headers );
}
