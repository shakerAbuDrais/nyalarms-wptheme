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
		'default'           => '(212) 555-0142',
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
		'default'           => '188 Lafayette St, NYC',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'nyas_address', array(
		'label'   => __( 'Headquarters address', 'nyas' ),
		'section' => 'nyas_company',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'nyas_license', array(
		'default'           => 'NY License #12B-0049281',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'nyas_license', array(
		'label'   => __( 'License badge text', 'nyas' ),
		'section' => 'nyas_company',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'nyas_email', array(
		'default'           => 'dispatch@newyorkalarmsystems.com',
		'sanitize_callback' => 'sanitize_email',
	) );
	$wp_customize->add_control( 'nyas_email', array(
		'label'   => __( 'Dispatch email', 'nyas' ),
		'section' => 'nyas_company',
		'type'    => 'email',
	) );
}
add_action( 'customize_register', 'nyas_customize_register' );
