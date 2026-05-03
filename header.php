<?php
/**
 * Site header — top bar, sticky main header, mobile drawer.
 *
 * @package NYAS
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="profile" href="https://gmpg.org/xfn/11" />
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="screen-reader-text skip-link" href="#content"><?php esc_html_e( 'Skip to content', 'nyas' ); ?></a>

<?php nyas_topbar(); ?>

<?php
$is_ink_header = (bool) apply_filters( 'nyas_header_ink', false );
$active = '';
if ( is_front_page() ) {
	$active = 'home';
} elseif ( is_page( 'services' ) || is_page_template( 'page-services.php' ) ) {
	$active = 'services';
} elseif ( is_page( 'cases' ) || is_page_template( 'page-cases.php' ) ) {
	$active = 'cases';
} elseif ( is_page( 'about' ) || is_page_template( 'page-about.php' ) ) {
	$active = 'about';
} elseif ( is_home() || is_singular( 'post' ) || is_archive() ) {
	$active = 'blog';
}
?>

<header class="site-header<?php echo $is_ink_header ? ' ink' : ''; ?>" data-nyas-header>
	<div class="nav-row">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="brand" aria-label="<?php bloginfo( 'name' ); ?>">
			<span class="logo-mark">
				<svg width="22" height="22" viewBox="0 0 24 24" fill="none" aria-hidden="true">
					<path d="M12 21s7-3.5 7-8.5V5l-7-2.5L5 5v7.5C5 17.5 12 21 12 21z" stroke="white" stroke-width="2" fill="none" stroke-linejoin="round" />
					<path d="m9 12 2 2 4-4" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none" />
				</svg>
			</span>
			<span class="logo-txt"><?php
				$site_name = get_bloginfo( 'name' );
				if ( false !== stripos( $site_name, 'alarm' ) ) {
					// Highlight the word "alarm" if it appears in the site title.
					echo wp_kses_post( str_ireplace( 'alarm', '<em>alarm</em>', $site_name ) );
				} else {
					echo 'newyork<em>alarm</em>systems';
				}
			?></span>
		</a>

		<nav class="nav" aria-label="<?php esc_attr_e( 'Primary', 'nyas' ); ?>">
			<?php
			if ( has_nav_menu( 'primary' ) ) {
				wp_nav_menu( array(
					'theme_location'  => 'primary',
					'container'       => false,
					'menu_class'      => 'nav-menu',
					'fallback_cb'     => false,
					'depth'           => 1,
					'link_before'     => '',
					'link_after'      => '',
				) );
			} else {
				echo '<ul class="nav-menu">';
				$links = array(
					array( 'home',     home_url( '/' ),                  __( 'Home', 'nyas' ) ),
					array( 'services', home_url( '/services/' ),         __( 'Services', 'nyas' ) ),
					array( 'cases',    home_url( '/cases/' ),            __( 'Case studies', 'nyas' ) ),
					array( 'blog',     get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/blog/' ), __( 'Insights', 'nyas' ) ),
					array( 'about',    home_url( '/about/' ),            __( 'About', 'nyas' ) ),
				);
				foreach ( $links as $link ) {
					list( $id, $href, $label ) = $link;
					$cls = 'menu-item' . ( $active === $id ? ' current-menu-item' : '' );
					echo '<li class="' . esc_attr( $cls ) . '"><a href="' . esc_url( $href ) . '">' . esc_html( $label ) . '</a></li>';
				}
				echo '</ul>';
			}
			?>
		</nav>

		<div class="header-cta">
			<a href="tel:<?php echo esc_attr( nyas_phone_tel() ); ?>" class="header-phone">
				<?php nyas_icon( 'phone', 14 ); ?> <?php echo esc_html( nyas_phone() ); ?>
			</a>
			<a href="#quote" class="btn btn-md btn-signal header-cta-btn"><?php esc_html_e( 'Free quote', 'nyas' ); ?></a>
			<button type="button" class="nav-burger" aria-label="<?php esc_attr_e( 'Open menu', 'nyas' ); ?>" aria-expanded="false" data-nyas-burger>
				<span></span><span></span><span></span>
			</button>
		</div>
	</div>

	<div class="mobile-drawer" data-nyas-drawer style="display:block">
		<div class="mobile-drawer-panel">
			<div class="mobile-drawer-head">
				<div style="display:flex;align-items:center;gap:12px">
					<span class="logo-mark">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">
							<path d="M12 21s7-3.5 7-8.5V5l-7-2.5L5 5v7.5C5 17.5 12 21 12 21z" stroke="white" stroke-width="2.2" fill="none" stroke-linejoin="round" />
							<path d="m9 12 2 2 4-4" stroke="white" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" fill="none" />
						</svg>
					</span>
					<span class="drawer-brand">newyork<em>alarm</em>systems</span>
				</div>
				<button type="button" class="drawer-close" aria-label="<?php esc_attr_e( 'Close menu', 'nyas' ); ?>" data-nyas-drawer-close>
					<?php nyas_icon( 'close', 18 ); ?>
				</button>
			</div>

			<nav class="mobile-nav" aria-label="<?php esc_attr_e( 'Mobile primary', 'nyas' ); ?>">
				<?php
				$mlinks = array(
					array( 'home',     home_url( '/' ),                  __( 'Home', 'nyas' ) ),
					array( 'services', home_url( '/services/' ),         __( 'Services', 'nyas' ) ),
					array( 'cases',    home_url( '/cases/' ),            __( 'Case studies', 'nyas' ) ),
					array( 'blog',     get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/blog/' ), __( 'Insights', 'nyas' ) ),
					array( 'about',    home_url( '/about/' ),            __( 'About', 'nyas' ) ),
				);
				foreach ( $mlinks as $link ) {
					list( $id, $href, $label ) = $link;
					$class = 'mobile-nav-link' . ( $active === $id ? ' active' : '' );
					echo '<a class="' . esc_attr( $class ) . '" href="' . esc_url( $href ) . '"><span>' . esc_html( $label ) . '</span>';
					echo '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>';
					echo '</a>';
				}
				?>
			</nav>

			<div class="mobile-drawer-foot">
				<a href="tel:<?php echo esc_attr( nyas_phone_tel() ); ?>" class="mobile-phone-card">
					<span class="mobile-phone-icon"><?php nyas_icon( 'phone', 18 ); ?></span>
					<div style="flex:1">
						<div class="mobile-phone-card-eyebrow"><?php esc_html_e( '24/7 monitoring · NY', 'nyas' ); ?></div>
						<div class="mobile-phone-card-num"><?php echo esc_html( nyas_phone() ); ?></div>
					</div>
				</a>
				<a href="#quote" class="btn btn-lg btn-signal" style="width:100%;justify-content:center">
					<?php esc_html_e( 'Free quote', 'nyas' ); ?> <?php nyas_icon( 'arrow-right', 15 ); ?>
				</a>
				<div class="mobile-drawer-meta">
					<span class="pill"><?php esc_html_e( 'UL-listed', 'nyas' ); ?></span>
					<span class="pill"><?php echo esc_html( get_theme_mod( 'nyas_license', 'NY License #12B-0049281' ) ); ?></span>
				</div>
			</div>
		</div>
	</div>
</header>

<script>
/* Drawer failsafe — runs immediately so the burger works even if app.js
   hasn't loaded or hits an error elsewhere. */
(function () {
	function ready(fn) {
		if (document.readyState !== 'loading') fn();
		else document.addEventListener('DOMContentLoaded', fn);
	}
	ready(function () {
		var burger = document.querySelector('[data-nyas-burger]');
		var drawer = document.querySelector('[data-nyas-drawer]');
		var close  = document.querySelector('[data-nyas-drawer-close]');
		var header = document.querySelector('[data-nyas-header]');
		if (!burger || !drawer || burger.dataset.nyasBound) return;
		burger.dataset.nyasBound = '1';

		function setOpen(open) {
			drawer.classList.toggle('open', open);
			burger.setAttribute('aria-expanded', String(open));
			if (header) header.classList.toggle('menu-open', open);
			document.body.style.overflow = open ? 'hidden' : '';
		}
		burger.addEventListener('click', function (e) {
			e.preventDefault();
			setOpen(!drawer.classList.contains('open'));
		});
		if (close) close.addEventListener('click', function () { setOpen(false); });
		drawer.addEventListener('click', function (e) {
			if (e.target === drawer) setOpen(false);
		});
		drawer.querySelectorAll('a').forEach(function (a) {
			a.addEventListener('click', function () { setOpen(false); });
		});
		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape' && drawer.classList.contains('open')) setOpen(false);
		});
	});
})();
</script>

<main id="content" class="site-main">
