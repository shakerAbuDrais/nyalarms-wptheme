<?php
/**
 * Hero — full-bleed video background (home2 canonical variant D).
 *
 * Defaults to a Pexels NYC b-roll clip; can be overridden via the
 * `nyas_hero_video_src` filter or by setting the `nyas_hero_video_src`
 * theme mod through Customizer.
 *
 * @package NYAS
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$video_src = apply_filters(
	'nyas_hero_video_src',
	get_theme_mod( 'nyas_hero_video_src', 'https://videos.pexels.com/video-files/7255101/7255101-uhd_2732_1440_30fps.mp4' )
);
$poster = apply_filters(
	'nyas_hero_video_poster',
	'https://images.unsplash.com/photo-1581094288338-2314dddb7ece?w=1400&q=80'
);
?>
<section class="hero-videobg">
	<video
		class="hero-videobg-media"
		autoplay
		loop
		muted
		playsinline
		preload="metadata"
		poster="<?php echo esc_url( $poster ); ?>"
	>
		<source src="<?php echo esc_url( $video_src ); ?>" type="video/mp4" />
	</video>
	<div class="hero-videobg-scrim" aria-hidden="true"></div>
	<div class="container hero-videobg-inner">
		<div class="hero-videobg-content">
			<div class="hero-videobg-tag">
				<span class="hero-videobg-tag-pulse"></span>
				<?php esc_html_e( 'Live monitoring · 24/7 on Long Island', 'nyas' ); ?>
			</div>
			<h1 class="hero-videobg-title">
				<?php esc_html_e( 'One System.', 'nyas' ); ?><br /><em><?php esc_html_e( 'Every Entry Point.', 'nyas' ); ?></em>
			</h1>
			<p class="hero-videobg-lede">
				<?php esc_html_e( 'Alarm panel, perimeter sensors, AI cameras, and 24/7 NYC monitoring — engineered to work as one.', 'nyas' ); ?>
			</p>
			<div class="hero-fb-cta">
				<a href="#quote" class="btn btn-lg btn-signal"><?php esc_html_e( 'Free quote', 'nyas' ); ?> <?php nyas_icon( 'arrow-right', 15 ); ?></a>
				<a href="<?php echo esc_url( home_url( '/services/' ) ); ?>" class="btn btn-lg btn-hero-ghost"><?php esc_html_e( 'View specs', 'nyas' ); ?></a>
			</div>
		</div>
	</div>
</section>
