<?php
/**
 * NYAS theme bootstrap.
 *
 * @package NYAS
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'NYAS_VERSION', '1.0.4' );
define( 'NYAS_DIR', trailingslashit( get_template_directory() ) );
define( 'NYAS_URI', trailingslashit( get_template_directory_uri() ) );

/**
 * Theme setup.
 */
function nyas_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'custom-logo', array(
		'height'      => 36,
		'width'       => 36,
		'flex-height' => true,
		'flex-width'  => true,
	) );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'editor-styles' );

	register_nav_menus( array(
		'primary'        => __( 'Primary Navigation', 'nyas' ),
		'footer-shop'    => __( 'Footer — Shop', 'nyas' ),
		'footer-industry'=> __( 'Footer — Industry', 'nyas' ),
		'footer-company' => __( 'Footer — Company', 'nyas' ),
	) );

	add_image_size( 'nyas-card', 900, 600, true );
	add_image_size( 'nyas-hero', 1600, 1000, true );
}
add_action( 'after_setup_theme', 'nyas_setup' );

/**
 * Enqueue front-end scripts and styles.
 */
function nyas_enqueue_assets() {
	// Google Fonts (Manrope display, Inter sans, JetBrains Mono).
	wp_enqueue_style(
		'nyas-fonts',
		'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Manrope:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap',
		array(),
		null
	);

	wp_enqueue_style( 'nyas-tokens',     NYAS_URI . 'assets/css/tokens.css',     array( 'nyas-fonts' ), NYAS_VERSION );
	wp_enqueue_style( 'nyas-app',        NYAS_URI . 'assets/css/app.css',        array( 'nyas-tokens' ), NYAS_VERSION );
	wp_enqueue_style( 'nyas-responsive', NYAS_URI . 'assets/css/responsive.css', array( 'nyas-app' ), NYAS_VERSION );
	wp_enqueue_style( 'nyas-overrides',     NYAS_URI . 'assets/css/nyas.css',            array( 'nyas-responsive' ), NYAS_VERSION );
	wp_enqueue_style( 'nyas-responsive-2',  NYAS_URI . 'assets/css/nyas-responsive.css', array( 'nyas-overrides' ), NYAS_VERSION );

	// Theme stylesheet (style.css) — keep loaded so child themes / plugins behave.
	wp_enqueue_style( 'nyas-style', get_stylesheet_uri(), array( 'nyas-responsive-2' ), NYAS_VERSION );

	// Leaflet on the homepage only.
	if ( is_front_page() ) {
		wp_enqueue_style(
			'leaflet',
			'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css',
			array(),
			'1.9.4'
		);
		wp_enqueue_script(
			'leaflet',
			'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js',
			array(),
			'1.9.4',
			true
		);
	}

	wp_enqueue_script( 'nyas-app', NYAS_URI . 'assets/js/app.js', array(), NYAS_VERSION, true );
	wp_enqueue_script( 'nyas-carousel', NYAS_URI . 'assets/js/carousel-dots.js', array(), NYAS_VERSION, true );

	if ( is_front_page() ) {
		wp_enqueue_script( 'nyas-map', NYAS_URI . 'assets/js/map.js', array( 'leaflet', 'nyas-app' ), NYAS_VERSION, true );
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'nyas_enqueue_assets' );

/**
 * Pull in component / helper modules.
 */
require_once NYAS_DIR . 'inc/icons.php';
require_once NYAS_DIR . 'inc/template-helpers.php';
require_once NYAS_DIR . 'inc/customizer.php';
require_once NYAS_DIR . 'inc/data.php';
require_once NYAS_DIR . 'inc/setup-wizard.php';

/**
 * Add a body class for the active page so we can target sticky-header tweaks.
 */
function nyas_body_classes( $classes ) {
	if ( is_front_page() ) {
		$classes[] = 'nyas-home';
	}
	if ( is_page() ) {
		$classes[] = 'nyas-page-' . sanitize_html_class( get_post_field( 'post_name', get_queried_object_id() ) );
	}
	return $classes;
}
add_filter( 'body_class', 'nyas_body_classes' );

/**
 * Excerpt length / read more.
 */
function nyas_excerpt_length() { return 28; }
add_filter( 'excerpt_length', 'nyas_excerpt_length' );

function nyas_excerpt_more() { return '&hellip;'; }
add_filter( 'excerpt_more', 'nyas_excerpt_more' );

/**
 * Reading time helper for blog posts.
 */
function nyas_reading_time( $post_id = null ) {
	$content = get_post_field( 'post_content', $post_id );
	$words   = str_word_count( wp_strip_all_tags( (string) $content ) );
	$minutes = max( 1, (int) ceil( $words / 220 ) );
	/* translators: %d: estimated reading time in minutes. */
	return sprintf( _n( '%d min', '%d min', $minutes, 'nyas' ), $minutes );
}
