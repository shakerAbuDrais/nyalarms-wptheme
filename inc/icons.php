<?php
/**
 * Inline SVG icon set — ported from shared.jsx.
 *
 * @package NYAS
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get the inner SVG paths for a named icon.
 *
 * @param string $name Icon name.
 * @return string Raw SVG markup (paths only).
 */
function nyas_icon_paths( $name ) {
	$paths = array(
		'shield'        => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>',
		'shield-check'  => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/>',
		'home'          => '<path d="m3 10 9-7 9 7v11a2 2 0 0 1-2 2h-4v-7h-6v7H5a2 2 0 0 1-2-2z"/>',
		'building'      => '<rect x="4" y="2" width="16" height="20" rx="2"/><path d="M9 22v-4h6v4M8 6h.01M16 6h.01M8 10h.01M16 10h.01M8 14h.01M16 14h.01"/>',
		'warehouse'     => '<path d="M22 8.35V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V8.35a2 2 0 0 1 1.26-1.86l8-3.2a2 2 0 0 1 1.48 0l8 3.2A2 2 0 0 1 22 8.35Z"/><path d="M6 18h12M6 14h12M6 10h12"/>',
		'hardhat'       => '<path d="M2 18a1 1 0 0 0 1 1h18a1 1 0 0 0 1-1v-2a7 7 0 0 0-14 0M10 11V5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v6"/>',
		'shop'          => '<path d="M3 7h18l-1 4a2 2 0 0 1-2 2 2 2 0 0 1-2-2 2 2 0 0 1-2 2 2 2 0 0 1-2-2 2 2 0 0 1-2 2 2 2 0 0 1-2-2 2 2 0 0 1-2 2 2 2 0 0 1-2-2zM4 13v8h16v-8M3 7l2-4h14l2 4"/>',
		'briefcase'     => '<rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>',
		'school'        => '<path d="m4 6 8-3 8 3M4 10v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8M9 22V12h6v10"/>',
		'medical'       => '<rect x="3" y="4" width="18" height="18" rx="2"/><path d="M12 8v8M8 12h8"/>',
		'monitor'       => '<rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/>',
		'video'         => '<rect x="2" y="6" width="14" height="12" rx="2"/><path d="m22 8-6 4 6 4z"/>',
		'phone'         => '<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>',
		'mail'          => '<rect x="2" y="4" width="20" height="16" rx="2"/><path d="m2 7 10 6 10-6"/>',
		'pin'           => '<path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>',
		'arrow-right'   => '<path d="M5 12h14M12 5l7 7-7 7"/>',
		'chevron-right' => '<path d="m9 18 6-6-6-6"/>',
		'arrow-up-right'=> '<path d="M7 17 17 7M7 7h10v10"/>',
		'check'         => '<path d="M20 6 9 17l-5-5"/>',
		'plus'          => '<path d="M12 5v14M5 12h14"/>',
		'minus'         => '<path d="M5 12h14"/>',
		'menu'          => '<path d="M3 6h18M3 12h18M3 18h18"/>',
		'close'         => '<path d="M18 6 6 18M6 6l12 12"/>',
		'star'          => '<polygon points="12 2 15 9 22 9.5 17 14.5 18.5 22 12 18 5.5 22 7 14.5 2 9.5 9 9"/>',
		'clock'         => '<circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>',
		'bell'          => '<path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/>',
		'lock'          => '<rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>',
		'sensor'        => '<circle cx="12" cy="12" r="2"/><path d="M16.24 7.76a6 6 0 0 1 0 8.48M19.07 4.93a10 10 0 0 1 0 14.14M7.76 16.24a6 6 0 0 1 0-8.48M4.93 19.07a10 10 0 0 1 0-14.14"/>',
		'cam'           => '<path d="M3 7h2l2-3h10l2 3h2a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2z"/><circle cx="12" cy="13" r="4"/>',
		'eye'           => '<path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/>',
		'zap'           => '<polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/>',
		'users'         => '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>',
		'award'         => '<circle cx="12" cy="8" r="6"/><path d="m8.21 13.89-1.21 7.11L12 18l5 3-1.21-7.11"/>',
		'play'          => '<polygon points="5 3 19 12 5 21 5 3"/>',
		'fire'          => '<path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"/>',
		'package'       => '<path d="M16.5 9.4 7.55 4.24M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/>',
		'quote'         => '<path d="M3 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2H4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2h2c0 4-3 5-3 5M15 21c3 0 7-1 7-8V5c0-1.25-.757-2.017-2-2h-4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2h2c0 4-3 5-3 5"/>',
	);

	return isset( $paths[ $name ] ) ? $paths[ $name ] : $paths['shield'];
}

/**
 * Render an inline SVG icon.
 *
 * @param string $name  Icon name.
 * @param int    $size  Width/height in px.
 * @param string $extra Extra inline style.
 */
function nyas_icon( $name, $size = 18, $extra = '' ) {
	$style = 'width:' . (int) $size . 'px;height:' . (int) $size . 'px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;flex-shrink:0;' . $extra;
	echo '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false" style="' . esc_attr( $style ) . '">' . nyas_icon_paths( $name ) . '</svg>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}
