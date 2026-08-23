<?php
/**
 * Customizer settings — phone, address, license, top bar toggle.
 *
 * @package NYAS
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function nyas_customize_register( $wp_customize ) {
	$wp_customize->add_section( 'nyas_company', array(
		'title'    => __( 'NYAS — Company info', 'nyas' ),
		'priority' => 30,
	) );

	$wp_customize->add_setting( 'nyas_phone', array(
		'default'           => '(347) 778-0820',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'nyas_phone', array(
		'label'   => __( 'Display phone number', 'nyas' ),
		'section' => 'nyas_company',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'nyas_show_topbar', array(
		'default'           => true,
		'sanitize_callback' => 'wp_validate_boolean',
	) );
	$wp_customize->add_control( 'nyas_show_topbar', array(
		'label'   => __( 'Show top utility bar', 'nyas' ),
		'section' => 'nyas_company',
		'type'    => 'checkbox',
	) );

	$wp_customize->add_setting( 'nyas_address', array(
		'default'           => '750 Grand St, Unit 8S, Brooklyn, NY 11211',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'nyas_address', array(
		'label'       => __( 'Headquarters address', 'nyas' ),
		'description' => __( 'Client-confirmed interim address (July 2026 brief). Leave blank to hide the footer address line.', 'nyas' ),
		'section'     => 'nyas_company',
		'type'        => 'text',
	) );

	$wp_customize->add_setting( 'nyas_license', array(
		'default'           => 'NY License #12000314318',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'nyas_license', array(
		'label'   => __( 'License badge text', 'nyas' ),
		'section' => 'nyas_company',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'nyas_email', array(
		'default'           => 'info@newyorkalarmsystems.com',
		'sanitize_callback' => 'sanitize_email',
	) );
	$wp_customize->add_control( 'nyas_email', array(
		'label'   => __( 'Dispatch email', 'nyas' ),
		'section' => 'nyas_company',
		'type'    => 'email',
	) );
}
add_action( 'customize_register', 'nyas_customize_register' );
