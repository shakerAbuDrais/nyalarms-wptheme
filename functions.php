<?php
/**
 * NYAS theme bootstrap.
 *
 * @package NYAS
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'NYAS_VERSION', '1.3.1' );
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
		wp_enqueue_style( 'nyas-quote-wizard', NYAS_URI . 'assets/css/quote-wizard.css', array( 'nyas-overrides' ), NYAS_VERSION );
		wp_enqueue_style( 'nyas-home2', NYAS_URI . 'assets/css/home2.css', array( 'nyas-responsive-2' ), NYAS_VERSION );
		wp_enqueue_script( 'nyas-quote-wizard', NYAS_URI . 'assets/js/quote-wizard.js', array(), NYAS_VERSION, true );
		wp_enqueue_script( 'nyas-home2', NYAS_URI . 'assets/js/home2.js', array(), NYAS_VERSION, true );
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
require_once NYAS_DIR . 'inc/leads.php';
require_once NYAS_DIR . 'inc/admin-settings.php';

/**
 * Redirect the commonly guessed /blog/ URL to the real posts page.
 */
function nyas_blog_redirect() {
	if ( ! is_404() ) {
		return;
	}
	$path = isset( $_SERVER['REQUEST_URI'] ) ? wp_parse_url( wp_unslash( $_SERVER['REQUEST_URI'] ), PHP_URL_PATH ) : '';
	if ( '/blog' === untrailingslashit( (string) $path ) ) {
		$posts_page = get_option( 'page_for_posts' );
		wp_safe_redirect( $posts_page ? get_permalink( $posts_page ) : home_url( '/' ), 301 );
		exit;
	}
}
add_action( 'template_redirect', 'nyas_blog_redirect' );

/**
 * One-time cleanup — trash WordPress's default sample content ("Hello
 * world!" post and "Sample Page") if it's still published. Trashing is
 * reversible from wp-admin; a flag option makes this run only once.
 */
function nyas_cleanup_default_content() {
	if ( get_option( 'nyas_default_content_cleaned' ) ) {
		return;
	}
	$hello = get_page_by_path( 'hello-world', OBJECT, 'post' );
	if ( $hello && 'trash' !== $hello->post_status ) {
		wp_trash_post( $hello->ID );
	}
	$sample = get_page_by_path( 'sample-page', OBJECT, 'page' );
	if ( $sample && 'trash' !== $sample->post_status ) {
		wp_trash_post( $sample->ID );
	}
	update_option( 'nyas_default_content_cleaned', 1 );
}
add_action( 'init', 'nyas_cleanup_default_content' );

/**
 * One-time migration — the fabricated "Maman" case page becomes the real
 * Tower NY case study (Aug 2026 client doc). Renames the page slug and
 * title; WordPress's old-slug redirect keeps /cases/maman/ working.
 */
function nyas_migrate_tower_case() {
	if ( get_option( 'nyas_tower_case_migrated' ) ) {
		return;
	}
	$page = get_page_by_path( 'cases/maman' );
	if ( $page ) {
		wp_update_post( array(
			'ID'         => $page->ID,
			'post_name'  => 'tower-ny',
			'post_title' => 'Tower NY',
		) );
	}
	update_option( 'nyas_tower_case_migrated', 1 );
}
add_action( 'init', 'nyas_migrate_tower_case' );

/**
 * Favicon — shield mark on brand blue. Defers to a Customizer Site Icon
 * when one is set (WP outputs that itself).
 */
function nyas_favicon() {
	if ( function_exists( 'has_site_icon' ) && has_site_icon() ) {
		return;
	}
	echo '<link rel="icon" type="image/svg+xml" href="' . esc_url( NYAS_URI . 'assets/img/favicon.svg?v=' . NYAS_VERSION ) . '" />' . "\n";
}
add_action( 'wp_head', 'nyas_favicon', 5 );
add_action( 'admin_head', 'nyas_favicon', 5 );

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
