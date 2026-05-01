<?php
/**
 * 404 — page not found.
 *
 * @package NYAS
 */

get_header();
?>

<section style="padding:120px 0">
	<div class="container-narrow" style="text-align:center">
		<?php nyas_eyebrow( __( 'Error 404', 'nyas' ), false, 'margin-bottom:20px;justify-content:center;display:flex' ); ?>
		<h1 class="display-xl" style="margin-bottom:24px"><?php esc_html_e( 'This door isn\'t', 'nyas' ); ?> <em><?php esc_html_e( 'monitored.', 'nyas' ); ?></em></h1>
		<p class="lede" style="max-width:560px;margin:0 auto 40px"><?php esc_html_e( 'The page you tried to reach doesn\'t exist (or moved). Try our services, case studies, or call the number below.', 'nyas' ); ?></p>
		<div style="display:flex;gap:12px;flex-wrap:wrap;justify-content:center">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-lg btn-signal"><?php esc_html_e( 'Back to home', 'nyas' ); ?> <?php nyas_icon( 'arrow-right', 15 ); ?></a>
			<a href="tel:<?php echo esc_attr( nyas_phone_tel() ); ?>" class="btn btn-lg btn-ghost"><?php nyas_icon( 'phone', 14 ); ?> <?php echo esc_html( nyas_phone() ); ?></a>
		</div>
	</div>
</section>

<?php get_footer();
