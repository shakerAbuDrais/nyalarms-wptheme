<?php
/**
 * Template Name: Case Studies Archive
 *
 * Recreates cases.html.
 *
 * @package NYAS
 */

get_header();

$cases      = nyas_cases();
$industries = array( 'All', 'Retail', 'Construction', 'Medical', 'Schools', 'Warehouse', 'Residential' );
$featured   = null;
foreach ( $cases as $c ) {
	if ( ! empty( $c['featured'] ) ) {
		$featured = $c;
		break;
	}
}
?>

<section style="padding:72px 0 32px">
	<div class="container">
		<?php nyas_eyebrow( __( 'Case studies', 'nyas' ), true, 'margin-bottom:20px' ); ?>
		<div class="nyas-cases-head" style="display:grid;grid-template-columns:1.3fr 1fr;gap:64px;align-items:end">
			<h1 class="display-xl"><?php esc_html_e( 'The work,', 'nyas' ); ?> <em><?php esc_html_e( 'signed and dated.', 'nyas' ); ?></em></h1>
			<p class="lede" style="margin:0">
				<?php esc_html_e( 'Six stories from the field — with real stats, real names, and the people who lived through them.', 'nyas' ); ?>
			</p>
		</div>
	</div>
</section>

<?php if ( $featured ) : ?>
	<section style="padding:32px 0 64px" data-nyas-cases-featured>
		<div class="container">
			<a href="<?php echo esc_url( home_url( '/cases/' . $featured['slug'] . '/' ) ); ?>" class="section-ink" style="display:grid;grid-template-columns:1fr 1fr;gap:0;text-decoration:none;border-radius:16px;overflow:hidden;background:var(--brand-ink);color:var(--fg-on-ink)">
				<?php nyas_photo( $featured['img'], $featured['title'], 'aspect-ratio:4/3;border-radius:0' ); ?>
				<div style="padding:48px;display:flex;flex-direction:column;justify-content:center">
					<?php nyas_eyebrow( sprintf( __( 'Featured · %s', 'nyas' ), $featured['industry'] ), false, 'color:rgba(246,243,236,0.55);margin-bottom:14px' ); ?>
					<h2 class="display-md" style="color:var(--fg-on-ink);margin-bottom:16px"><?php echo esc_html( $featured['title'] ); ?></h2>
					<p style="color:rgba(246,243,236,0.78);font-size:16px;margin-bottom:24px"><?php echo esc_html( $featured['summary'] ); ?></p>
					<div style="display:flex;gap:32px;padding-top:24px;border-top:1px solid rgba(246,243,236,0.12)">
						<?php foreach ( $featured['stats'] as $s ) : ?>
							<div>
								<div style="font-family:var(--ff-display);font-weight:800;font-size:40px;color:#3CD68C;letter-spacing:-0.02em"><?php echo esc_html( $s['n'] ); ?></div>
								<div style="font-size:11px;color:rgba(246,243,236,0.55);text-transform:uppercase;letter-spacing:0.12em"><?php echo esc_html( $s['l'] ); ?></div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</a>
		</div>
	</section>
<?php endif; ?>

<section data-nyas-filter="cases" style="padding:0;border-top:1px solid var(--border);border-bottom:1px solid var(--border)">
	<div class="container" style="display:flex;align-items:center;gap:8px;padding:16px 32px;overflow-x:auto">
		<?php foreach ( $industries as $i => $ind ) : ?>
			<button type="button" class="radio-pill<?php echo 0 === $i ? ' on' : ''; ?>" data-nyas-filter-cat="<?php echo esc_attr( $ind ); ?>" style="white-space:nowrap"><?php echo esc_html( $ind ); ?></button>
		<?php endforeach; ?>
	</div>
</section>

<section style="padding:64px 0 96px">
	<div class="container">
		<div class="grid grid-3" data-nyas-filter-grid>
			<?php foreach ( $cases as $c ) : if ( ! empty( $c['featured'] ) ) continue; ?>
				<a href="<?php echo esc_url( home_url( '/cases/' . $c['slug'] . '/' ) ); ?>"
				   class="card"
				   data-nyas-filter-item="<?php echo esc_attr( $c['industry'] ); ?>"
				   style="text-decoration:none;color:inherit;padding:0;overflow:hidden;display:flex;flex-direction:column">
					<?php nyas_photo( $c['img'], $c['title'], 'aspect-ratio:4/3;border-radius:0;border-bottom:1px solid var(--border)' ); ?>
					<div style="padding:24px;display:flex;flex-direction:column;gap:12px;flex:1">
						<span class="pill pill-paper"><?php echo esc_html( $c['industry'] ); ?></span>
						<h3 style="font-family:var(--ff-display);font-weight:800;font-size:22px;line-height:1.15;letter-spacing:-0.01em"><?php echo esc_html( $c['title'] ); ?></h3>
						<p style="margin:0;font-size:14px"><?php echo esc_html( $c['summary'] ); ?></p>
						<div style="margin-top:auto;padding-top:16px;border-top:1px solid var(--border);display:flex;gap:24px">
							<?php foreach ( $c['stats'] as $s ) : ?>
								<div>
									<div style="font-family:var(--ff-display);font-weight:800;font-size:24px;color:var(--brand-signal-2);letter-spacing:-0.02em"><?php echo esc_html( $s['n'] ); ?></div>
									<div style="font-size:10px;color:var(--fg-3);text-transform:uppercase;letter-spacing:0.12em"><?php echo esc_html( $s['l'] ); ?></div>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="section-ink" style="padding:64px 0">
	<div class="container" style="text-align:center">
		<h2 class="display-md" style="color:var(--fg-on-ink);margin-bottom:16px"><?php esc_html_e( 'Want yours', 'nyas' ); ?> <em style="color:#3CD68C"><?php esc_html_e( 'here', 'nyas' ); ?></em> <?php esc_html_e( 'next year?', 'nyas' ); ?></h2>
		<a href="#quote" class="btn btn-lg btn-signal"><?php esc_html_e( 'Start with a free quote', 'nyas' ); ?> <?php nyas_icon( 'arrow-right', 15 ); ?></a>
	</div>
</section>

<?php get_footer();
