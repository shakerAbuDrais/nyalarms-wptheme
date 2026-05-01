<?php
/**
 * Site footer.
 *
 * @package NYAS
 */
?>
</main><!-- #content -->

<footer class="site-footer">
	<div class="container">
		<div class="footer-grid">
			<div>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="brand" style="color:#fff">
					<span class="logo-mark">
						<svg width="22" height="22" viewBox="0 0 24 24" fill="none" aria-hidden="true">
							<path d="M12 21s7-3.5 7-8.5V5l-7-2.5L5 5v7.5C5 17.5 12 21 12 21z" stroke="white" stroke-width="2" fill="none" stroke-linejoin="round" />
							<path d="m9 12 2 2 4-4" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none" />
						</svg>
					</span>
					<span class="logo-txt" style="color:#fff">newyork<em>alarm</em>systems</span>
				</a>
				<p style="color:rgba(255,255,255,0.65);font-size:14px;margin-top:16px;max-width:340px;line-height:1.65">
					<?php esc_html_e( 'Independent, locally-owned alarm and monitoring company protecting homes and businesses across the five boroughs since 2009.', 'nyas' ); ?>
				</p>
				<div style="display:flex;gap:8px;margin-top:20px;flex-wrap:wrap">
					<span class="pill" style="background:rgba(255,255,255,0.10);color:#fff"><?php esc_html_e( 'UL-listed', 'nyas' ); ?></span>
					<span class="pill" style="background:rgba(255,255,255,0.10);color:#fff"><?php echo esc_html( get_theme_mod( 'nyas_license', 'NY License #12B-0049281' ) ); ?></span>
				</div>
			</div>

			<div>
				<h4><?php esc_html_e( 'Shop', 'nyas' ); ?></h4>
				<div class="flex-col">
					<?php if ( has_nav_menu( 'footer-shop' ) ) {
						wp_nav_menu( array(
							'theme_location' => 'footer-shop',
							'container'      => false,
							'items_wrap'     => '%3$s',
							'fallback_cb'    => false,
							'depth'          => 1,
						) );
					} else { ?>
						<a href="<?php echo esc_url( home_url( '/services/residential/' ) ); ?>"><?php esc_html_e( 'Residential', 'nyas' ); ?></a>
						<a href="<?php echo esc_url( home_url( '/services/commercial/' ) ); ?>"><?php esc_html_e( 'Commercial', 'nyas' ); ?></a>
						<a href="<?php echo esc_url( home_url( '/services/warehouse/' ) ); ?>"><?php esc_html_e( 'Warehouse', 'nyas' ); ?></a>
						<a href="<?php echo esc_url( home_url( '/services/construction/' ) ); ?>"><?php esc_html_e( 'Construction', 'nyas' ); ?></a>
						<a href="<?php echo esc_url( home_url( '/services/retail/' ) ); ?>"><?php esc_html_e( 'Retail', 'nyas' ); ?></a>
					<?php } ?>
				</div>
			</div>

			<div>
				<h4><?php esc_html_e( 'Industry', 'nyas' ); ?></h4>
				<div class="flex-col">
					<?php if ( has_nav_menu( 'footer-industry' ) ) {
						wp_nav_menu( array(
							'theme_location' => 'footer-industry',
							'container'      => false,
							'items_wrap'     => '%3$s',
							'fallback_cb'    => false,
							'depth'          => 1,
						) );
					} else { ?>
						<a href="<?php echo esc_url( home_url( '/services/school/' ) ); ?>"><?php esc_html_e( 'Schools', 'nyas' ); ?></a>
						<a href="<?php echo esc_url( home_url( '/services/medical/' ) ); ?>"><?php esc_html_e( 'Medical', 'nyas' ); ?></a>
						<a href="<?php echo esc_url( home_url( '/services/monitoring/' ) ); ?>"><?php esc_html_e( 'Monitoring', 'nyas' ); ?></a>
						<a href="<?php echo esc_url( home_url( '/services/video/' ) ); ?>"><?php esc_html_e( 'Video integrated', 'nyas' ); ?></a>
					<?php } ?>
				</div>
			</div>

			<div>
				<h4><?php esc_html_e( 'Company', 'nyas' ); ?></h4>
				<div class="flex-col">
					<?php if ( has_nav_menu( 'footer-company' ) ) {
						wp_nav_menu( array(
							'theme_location' => 'footer-company',
							'container'      => false,
							'items_wrap'     => '%3$s',
							'fallback_cb'    => false,
							'depth'          => 1,
						) );
					} else { ?>
						<a href="<?php echo esc_url( home_url( '/about/' ) ); ?>"><?php esc_html_e( 'About', 'nyas' ); ?></a>
						<a href="<?php echo esc_url( home_url( '/cases/' ) ); ?>"><?php esc_html_e( 'Case studies', 'nyas' ); ?></a>
						<a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/blog/' ) ); ?>"><?php esc_html_e( 'Insights', 'nyas' ); ?></a>
						<a href="#quote"><?php esc_html_e( 'Free quote', 'nyas' ); ?></a>
					<?php } ?>
				</div>
			</div>

			<div>
				<h4><?php esc_html_e( 'Contact', 'nyas' ); ?></h4>
				<div class="flex-col" style="font-size:13px">
					<a href="tel:<?php echo esc_attr( nyas_phone_tel() ); ?>"><?php echo esc_html( nyas_phone() ); ?></a>
					<a href="mailto:<?php echo esc_attr( get_theme_mod( 'nyas_email', 'dispatch@newyorkalarmsystems.com' ) ); ?>"><?php echo esc_html( get_theme_mod( 'nyas_email', 'dispatch@nyas.com' ) ); ?></a>
					<span style="color:rgba(255,255,255,0.50)"><?php echo esc_html( get_theme_mod( 'nyas_address', '188 Lafayette St, NYC' ) ); ?></span>
				</div>
			</div>
		</div>

		<div class="footer-bottom">
			<span>&copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?></span>
			<span><?php esc_html_e( 'Brooklyn · Manhattan · Queens · Bronx · Staten Island', 'nyas' ); ?></span>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
