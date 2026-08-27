<?php
/**
 * Template Name: Single Case Study
 *
 * Recreates case.html. Pick the case via:
 *   - The page slug, OR
 *   - A `?c=maman` query string.
 *
 * @package NYAS
 */

add_filter( 'nyas_header_ink', '__return_true' );

// Resolve the case BEFORE any output so unknown slugs (e.g. removed demo
// cases) can bounce to the archive instead of rendering the wrong study.
$slug    = sanitize_key( get_post_field( 'post_name' ) );
$qs_slug = isset( $_GET['c'] ) ? sanitize_key( wp_unslash( $_GET['c'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
$case    = nyas_case( $qs_slug ) ?: nyas_case( $slug );

if ( ! $case ) {
	wp_safe_redirect( home_url( '/cases/' ), 302 );
	exit;
}

get_header();
?>

<section class="section-ink" style="padding:72px 0 96px">
	<div class="container">
		<?php nyas_breadcrumb( array(
			array( 'Home',          home_url( '/' ) ),
			array( 'Case studies',  home_url( '/cases/' ) ),
			array( $case['industry'] ),
		), true ); ?>

		<div class="nyas-case-hero" style="display:grid;grid-template-columns:1.3fr 1fr;gap:64px;align-items:end">
			<div>
				<?php nyas_eyebrow( sprintf( __( 'Case study · %s', 'nyas' ), $case['industry'] ), false, 'color:rgba(246,243,236,0.55);margin-bottom:16px' ); ?>
				<h1 class="display-xl" style="color:var(--fg-on-ink);margin-bottom:24px">
					<?php echo wp_kses_post( $case['title'] ); ?>
				</h1>
				<p style="font-size:21px;line-height:1.5;color:rgba(246,243,236,0.85);font-family:var(--ff-display);font-weight:500;max-width:640px">
					<?php echo esc_html( $case['summary'] ); ?>
				</p>
			</div>
			<div>
				<div style="display:grid;grid-template-columns:repeat(2,1fr);gap:20px">
					<?php foreach ( $case['stats'] as $s ) : ?>
						<div style="padding:16px 0;border-top:1px solid rgba(246,243,236,0.20)">
							<div style="font-family:var(--ff-display);font-weight:800;font-size:48px;color:#7AA0FF;line-height:1;letter-spacing:-0.025em"><?php echo esc_html( $s['n'] ); ?></div>
							<div style="font-size:11px;color:rgba(246,243,236,0.55);text-transform:uppercase;letter-spacing:0.12em;margin-top:6px"><?php echo esc_html( $s['l'] ); ?></div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</section>

<section style="padding:64px 0">
	<div class="container">
		<?php nyas_photo( $case['img'], $case['title'], 'aspect-ratio:21/9;border-radius:16px' ); ?>
	</div>
</section>

<section class="case-prose">
	<div class="container-narrow">
		<div class="grid grid-4" style="padding:32px 0;border-top:1px solid var(--border);border-bottom:1px solid var(--border);margin-bottom:48px">
			<div><div class="eyebrow" style="margin-bottom:4px"><?php esc_html_e( 'Client', 'nyas' ); ?></div><div style="font-size:14px;font-weight:600"><?php echo esc_html( $case['client'] ); ?></div></div>
			<div><div class="eyebrow" style="margin-bottom:4px"><?php esc_html_e( 'Industry', 'nyas' ); ?></div><div style="font-size:14px;font-weight:600"><?php echo esc_html( $case['industry'] ); ?></div></div>
			<div><div class="eyebrow" style="margin-bottom:4px"><?php esc_html_e( 'Stats', 'nyas' ); ?></div><div style="font-size:14px;font-weight:600"><?php echo esc_html( $case['stats'][0]['n'] . ' ' . $case['stats'][0]['l'] ); ?></div></div>
			<div><div class="eyebrow" style="margin-bottom:4px"><?php esc_html_e( 'Summary', 'nyas' ); ?></div><div style="font-size:14px;font-weight:600"><?php echo esc_html( wp_trim_words( $case['summary'], 8 ) ); ?></div></div>
		</div>

		<?php if ( ! empty( $case['challenge'] ) ) : ?>
			<h2><?php esc_html_e( 'The Challenge', 'nyas' ); ?></h2>
			<?php foreach ( (array) $case['challenge'] as $para ) : ?>
				<p><?php echo esc_html( $para ); ?></p>
			<?php endforeach; ?>
		<?php else : ?>
			<h2><?php esc_html_e( 'The problem', 'nyas' ); ?></h2>
			<p><?php echo esc_html( $case['summary'] ); ?></p>
		<?php endif; ?>

		<?php if ( ! empty( $case['solution'] ) ) : ?>
			<h2><?php esc_html_e( 'The Solution', 'nyas' ); ?></h2>
			<?php foreach ( (array) $case['solution'] as $para ) : ?>
				<p><?php echo esc_html( $para ); ?></p>
			<?php endforeach; ?>
		<?php endif; ?>

		<?php if ( ! empty( $case['impact'] ) ) : ?>
			<h2><?php esc_html_e( 'The Impact', 'nyas' ); ?></h2>
			<ul>
				<?php foreach ( (array) $case['impact'] as $point ) : ?>
					<li><?php echo esc_html( $point ); ?></li>
				<?php endforeach; ?>
			</ul>
		<?php else : ?>
			<h2><?php esc_html_e( 'The result', 'nyas' ); ?></h2>
			<?php foreach ( $case['stats'] as $s ) : ?>
				<p><strong><?php echo esc_html( $s['n'] ); ?></strong> — <?php echo esc_html( $s['l'] ); ?>.</p>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
</section>

<section style="padding:64px 0;background:var(--brand-paper);border-top:1px solid var(--border);border-bottom:1px solid var(--border)">
	<div class="container">
		<div class="grid grid-4">
			<?php foreach ( $case['stats'] as $s ) : ?>
				<div>
					<div class="stat-num"><em><?php echo esc_html( $s['n'] ); ?></em></div>
					<div class="stat-lbl" style="margin-top:8px"><?php echo esc_html( $s['l'] ); ?></div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php
$related = array_slice( array_filter( nyas_cases(), function ( $c ) use ( $case ) { return $c['slug'] !== $case['slug']; } ), 0, 3 );
if ( ! empty( $related ) ) : ?>
<section style="padding:64px 0">
	<div class="container">
		<div style="display:flex;justify-content:space-between;align-items:end;margin-bottom:32px">
			<h2 class="display-md"><?php esc_html_e( 'More Case Studies', 'nyas' ); ?></h2>
			<a href="<?php echo esc_url( home_url( '/cases/' ) ); ?>" class="btn btn-sm btn-ghost"><?php esc_html_e( 'All cases', 'nyas' ); ?> <?php nyas_icon( 'arrow-right', 12 ); ?></a>
		</div>
		<div class="grid grid-3">
			<?php foreach ( $related as $r ) : ?>
				<a href="<?php echo esc_url( home_url( '/cases/' . $r['slug'] . '/' ) ); ?>" class="card" style="text-decoration:none;color:inherit;padding:0;overflow:hidden">
					<?php nyas_photo( $r['img'], $r['title'], 'aspect-ratio:4/3;border-radius:0' ); ?>
					<div style="padding:20px">
						<span class="pill pill-paper" style="margin-bottom:10px"><?php echo esc_html( $r['industry'] ); ?></span>
						<h3 style="font-family:var(--ff-display);font-weight:700;font-size:20px;margin-top:10px"><?php echo esc_html( $r['title'] ); ?></h3>
					</div>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<section class="section-ink" style="padding:88px 0">
	<div class="container nyas-case-cta" style="display:grid;grid-template-columns:1.3fr 1fr;gap:56px;align-items:center">
		<div>
			<h2 class="display-md" style="color:var(--fg-on-ink);margin-bottom:16px"><?php esc_html_e( 'Tell Us About', 'nyas' ); ?> <em style="color:#7AA0FF"><?php esc_html_e( 'Your Space', 'nyas' ); ?></em>.</h2>
			<p style="color:rgba(246,243,236,0.78);font-size:17px;margin-bottom:24px;max-width:480px"><?php esc_html_e( 'Multi-location operators — we\'ll quote a single-source rollout in 48 hours.', 'nyas' ); ?></p>
			<a href="tel:<?php echo esc_attr( nyas_phone_tel() ); ?>" class="btn btn-lg btn-signal"><?php nyas_icon( 'phone', 15 ); ?> <?php echo esc_html( nyas_phone() ); ?></a>
		</div>
		<div style="background:var(--brand-paper);border-radius:16px;padding:24px">
			<?php nyas_lead_form( array( 'compact' => true ) ); ?>
		</div>
	</div>
</section>

<?php get_footer();
