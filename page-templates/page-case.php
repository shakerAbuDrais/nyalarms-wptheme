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

get_header();

$slug    = sanitize_key( get_post_field( 'post_name' ) );
$qs_slug = isset( $_GET['c'] ) ? sanitize_key( wp_unslash( $_GET['c'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
$case    = nyas_case( $qs_slug ) ?: nyas_case( $slug ) ?: nyas_cases()[0];
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
							<div style="font-family:var(--ff-display);font-weight:800;font-size:48px;color:#3CD68C;line-height:1;letter-spacing:-0.025em"><?php echo esc_html( $s['n'] ); ?></div>
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

		<h2><?php esc_html_e( 'The problem', 'nyas' ); ?></h2>
		<p><?php echo esc_html( $case['summary'] ); ?></p>
		<p><?php esc_html_e( 'Most incidents were after-hours: cleaning crews helping themselves, a back-door propped during deliveries, the occasional smash-and-grab on Spring Street.', 'nyas' ); ?></p>

		<blockquote>
			&ldquo;<?php esc_html_e( 'We had four vendor portals open on four browser tabs. Three of them logged us out every fifteen minutes. We didn\'t have a security problem. We had a logistics problem dressed up as a security problem.', 'nyas' ); ?>&rdquo;
		</blockquote>

		<h2><?php esc_html_e( 'What we did', 'nyas' ); ?></h2>
		<p><?php esc_html_e( 'Over a fourteen-day window, our team replaced every alarm panel, every camera, and every monitoring contract with a single integrated stack:', 'nyas' ); ?></p>
		<ul>
			<li><strong><?php esc_html_e( 'Panel + sensors.', 'nyas' ); ?></strong> <?php esc_html_e( 'DSC PowerG panels in every store, with door, motion, and glass-break sensors per zone.', 'nyas' ); ?></li>
			<li><strong><?php esc_html_e( 'Video.', 'nyas' ); ?></strong> <?php esc_html_e( 'Twelve 4K cameras per location with on-prem NVR and AI-based loitering detection.', 'nyas' ); ?></li>
			<li><strong><?php esc_html_e( 'POS panic.', 'nyas' ); ?></strong> <?php esc_html_e( 'Discreet panic buttons under each register, integrated with our central station for silent dispatch.', 'nyas' ); ?></li>
			<li><strong><?php esc_html_e( 'One dashboard.', 'nyas' ); ?></strong> <?php esc_html_e( 'Operators log in to one portal. Every store, every camera, every alarm event — one tab.', 'nyas' ); ?></li>
		</ul>

		<h2><?php esc_html_e( 'The result', 'nyas' ); ?></h2>
		<?php foreach ( $case['stats'] as $s ) : ?>
			<p><strong><?php echo esc_html( $s['n'] ); ?></strong> — <?php echo esc_html( $s['l'] ); ?>.</p>
		<?php endforeach; ?>
	</div>
</section>

<section style="padding:64px 0;background:var(--brand-paper);border-top:1px solid var(--border);border-bottom:1px solid var(--border)">
	<div class="container">
		<div class="grid grid-4">
			<?php
			$bigs = $case['stats'];
			foreach ( $bigs as $s ) : ?>
				<div>
					<div class="stat-num"><em><?php echo esc_html( $s['n'] ); ?></em></div>
					<div class="stat-lbl" style="margin-top:8px"><?php echo esc_html( $s['l'] ); ?></div>
				</div>
			<?php endforeach; ?>
			<div>
				<div class="stat-num"><em>14 days</em></div>
				<div class="stat-lbl" style="margin-top:8px"><?php esc_html_e( 'Full multi-site rollout', 'nyas' ); ?></div>
			</div>
			<div>
				<div class="stat-num"><em>&lt; 3 min</em></div>
				<div class="stat-lbl" style="margin-top:8px"><?php esc_html_e( 'NYPD response, verified events', 'nyas' ); ?></div>
			</div>
		</div>
	</div>
</section>

<section style="padding:64px 0">
	<div class="container">
		<div style="display:flex;justify-content:space-between;align-items:end;margin-bottom:32px">
			<h2 class="display-md"><?php esc_html_e( 'More case studies', 'nyas' ); ?></h2>
			<a href="<?php echo esc_url( home_url( '/cases/' ) ); ?>" class="btn btn-sm btn-ghost"><?php esc_html_e( 'All cases', 'nyas' ); ?> <?php nyas_icon( 'arrow-right', 12 ); ?></a>
		</div>
		<div class="grid grid-3">
			<?php
			$related = array_slice( array_filter( nyas_cases(), function ( $c ) use ( $case ) { return $c['slug'] !== $case['slug']; } ), 0, 3 );
			foreach ( $related as $r ) : ?>
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

<section class="section-ink" style="padding:88px 0">
	<div class="container nyas-case-cta" style="display:grid;grid-template-columns:1.3fr 1fr;gap:56px;align-items:center">
		<div>
			<h2 class="display-md" style="color:var(--fg-on-ink);margin-bottom:16px"><?php esc_html_e( 'Tell us about', 'nyas' ); ?> <em style="color:#3CD68C"><?php esc_html_e( 'your stores', 'nyas' ); ?></em>.</h2>
			<p style="color:rgba(246,243,236,0.78);font-size:17px;margin-bottom:24px;max-width:480px"><?php esc_html_e( 'Multi-location operators — we\'ll quote a single-source rollout in 48 hours.', 'nyas' ); ?></p>
			<a href="tel:<?php echo esc_attr( nyas_phone_tel() ); ?>" class="btn btn-lg btn-signal"><?php nyas_icon( 'phone', 15 ); ?> <?php echo esc_html( nyas_phone() ); ?></a>
		</div>
		<div style="background:var(--brand-paper);border-radius:16px;padding:24px">
			<?php nyas_lead_form( array( 'compact' => true ) ); ?>
		</div>
	</div>
</section>

<?php get_footer();
