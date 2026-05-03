<?php
/**
 * One-click theme setup — creates the design's required pages, sets the
 * static homepage and posts page, builds the primary nav menu, and turns
 * on pretty permalinks. Idempotent: safe to run multiple times.
 *
 * Surface: a dismissible admin notice with a "Run setup" button. Disappears
 * once setup has run successfully.
 *
 * @package NYAS
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const NYAS_SETUP_DONE_OPTION  = 'nyas_setup_done';
const NYAS_SETUP_ACTION       = 'nyas_run_setup';
const NYAS_SEED_POSTS_OPTION  = 'nyas_seed_posts_done';
const NYAS_SEED_POSTS_ACTION  = 'nyas_import_seed_posts';

/**
 * Decide whether the notice should appear.
 */
function nyas_setup_should_show_notice() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return false;
	}
	if ( get_option( NYAS_SETUP_DONE_OPTION ) ) {
		return false;
	}
	// Hide once the key pages exist (someone created them by hand).
	$home    = get_page_by_path( 'home' );
	$about   = get_page_by_path( 'about' );
	$svcs    = get_page_by_path( 'services' );
	$cases   = get_page_by_path( 'cases' );
	if ( $home && $about && $svcs && $cases ) {
		return false;
	}
	return true;
}

/**
 * Decide whether the seed-posts notice should appear.
 */
function nyas_seed_posts_should_show() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return false;
	}
	if ( get_option( NYAS_SEED_POSTS_OPTION ) ) {
		return false;
	}
	// Don't show if there are already several published posts (someone's writing).
	$count = wp_count_posts( 'post' );
	if ( $count && (int) $count->publish >= 3 ) {
		return false;
	}
	return true;
}

/**
 * Render the admin notice.
 */
function nyas_setup_admin_notice() {
	if ( ! nyas_setup_should_show_notice() ) {
		return;
	}

	// Surface success / error from the previous request.
	$flash = get_transient( 'nyas_setup_flash' );
	if ( $flash ) {
		delete_transient( 'nyas_setup_flash' );
		$class = 'success' === $flash['type'] ? 'notice-success' : 'notice-error';
		echo '<div class="notice ' . esc_attr( $class ) . ' is-dismissible"><p>' . wp_kses_post( $flash['message'] ) . '</p></div>';
		if ( 'success' === $flash['type'] ) {
			return;
		}
	}

	$action_url = admin_url( 'admin-post.php' );
	?>
	<div class="notice notice-info" style="border-left-color: #1F4DD8;">
		<h3 style="margin: 12px 0 4px; font-size: 16px;">
			<?php esc_html_e( 'Finish setting up the New York Alarm Systems theme', 'nyas' ); ?>
		</h3>
		<p style="margin: 0 0 12px;">
			<?php esc_html_e( 'Create all 21 design pages (Home, About, Services, Case studies, Insights + 10 service detail pages + 6 case studies), assign templates, set the static homepage and posts page, build the primary navigation menu, and switch to pretty permalinks — all in one click.', 'nyas' ); ?>
		</p>
		<p>
			<form method="post" action="<?php echo esc_url( $action_url ); ?>" style="display:inline-block;">
				<input type="hidden" name="action" value="<?php echo esc_attr( NYAS_SETUP_ACTION ); ?>" />
				<?php wp_nonce_field( NYAS_SETUP_ACTION ); ?>
				<button type="submit" class="button button-primary" style="background: #1F4DD8; border-color: #143CB0;">
					<?php esc_html_e( 'Run setup', 'nyas' ); ?>
				</button>
			</form>
			<a href="<?php echo esc_url( wp_nonce_url( add_query_arg( 'nyas_dismiss_setup', 1 ), 'nyas_dismiss_setup' ) ); ?>" style="margin-left: 12px;">
				<?php esc_html_e( 'Dismiss (I\'ll do it manually)', 'nyas' ); ?>
			</a>
		</p>
	</div>
	<?php
}
add_action( 'admin_notices', 'nyas_setup_admin_notice' );

/**
 * Render the seed-posts admin notice (separate button).
 */
function nyas_seed_posts_admin_notice() {
	if ( ! nyas_seed_posts_should_show() ) {
		return;
	}

	$flash = get_transient( 'nyas_seed_posts_flash' );
	if ( $flash ) {
		delete_transient( 'nyas_seed_posts_flash' );
		$class = 'success' === $flash['type'] ? 'notice-success' : 'notice-error';
		echo '<div class="notice ' . esc_attr( $class ) . ' is-dismissible"><p>' . wp_kses_post( $flash['message'] ) . '</p></div>';
		if ( 'success' === $flash['type'] ) {
			return;
		}
	}

	$action_url = admin_url( 'admin-post.php' );
	?>
	<div class="notice notice-info" style="border-left-color: #1F4DD8;">
		<h3 style="margin: 12px 0 4px; font-size: 16px;">
			<?php esc_html_e( 'Import sample blog posts', 'nyas' ); ?>
		</h3>
		<p style="margin: 0 0 12px;">
			<?php esc_html_e( 'Create the 6 design-spec sample posts (Buyers guide / Industry / Field notes), with categories, dates, body content, and Unsplash featured images attached. Useful for filling the Insights archive while you write your own.', 'nyas' ); ?>
		</p>
		<p>
			<form method="post" action="<?php echo esc_url( $action_url ); ?>" style="display:inline-block;">
				<input type="hidden" name="action" value="<?php echo esc_attr( NYAS_SEED_POSTS_ACTION ); ?>" />
				<?php wp_nonce_field( NYAS_SEED_POSTS_ACTION ); ?>
				<button type="submit" class="button button-primary" style="background: #1F4DD8; border-color: #143CB0;">
					<?php esc_html_e( 'Import sample posts', 'nyas' ); ?>
				</button>
			</form>
			<a href="<?php echo esc_url( wp_nonce_url( add_query_arg( 'nyas_dismiss_seed_posts', 1 ), 'nyas_dismiss_seed_posts' ) ); ?>" style="margin-left: 12px;">
				<?php esc_html_e( 'Dismiss (I\'ll write my own)', 'nyas' ); ?>
			</a>
		</p>
	</div>
	<?php
}
add_action( 'admin_notices', 'nyas_seed_posts_admin_notice' );

/**
 * Dismiss handler for seed posts notice.
 */
function nyas_seed_posts_handle_dismiss() {
	if ( ! isset( $_GET['nyas_dismiss_seed_posts'] ) ) {
		return;
	}
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	check_admin_referer( 'nyas_dismiss_seed_posts' );
	update_option( NYAS_SEED_POSTS_OPTION, time() );
	wp_safe_redirect( remove_query_arg( array( 'nyas_dismiss_seed_posts', '_wpnonce' ) ) );
	exit;
}
add_action( 'admin_init', 'nyas_seed_posts_handle_dismiss' );

/**
 * Seed-posts importer handler.
 */
function nyas_seed_posts_handle_run() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'Insufficient permissions.', 'nyas' ) );
	}
	check_admin_referer( NYAS_SEED_POSTS_ACTION );

	// Need these for media_sideload_image.
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	$created = 0;
	$skipped = 0;
	$failed  = 0;

	foreach ( nyas_seed_posts() as $seed ) {
		// Skip if already imported by slug.
		$existing = get_page_by_path( $seed['slug'], OBJECT, 'post' );
		if ( $existing ) {
			$skipped++;
			continue;
		}

		// Build content with a simple intro paragraph + body.
		$content = isset( $seed['content'] ) ? $seed['content'] : $seed['excerpt'];
		// Convert blank-line-separated blocks into <p>...</p>.
		$paragraphs = preg_split( '/\n\s*\n/', trim( $content ) );
		$wrapped    = array();
		foreach ( $paragraphs as $p ) {
			$p = trim( $p );
			if ( '' === $p ) {
				continue;
			}
			// Don't double-wrap already-wrapped HTML (h2, blockquote, ul, etc.).
			if ( preg_match( '/^<(h2|h3|blockquote|ul|ol|p|div)/i', $p ) ) {
				$wrapped[] = $p;
			} else {
				$wrapped[] = '<p>' . $p . '</p>';
			}
		}
		$post_content = implode( "\n\n", $wrapped );

		// Date — try to parse seed date string.
		$ts = strtotime( $seed['date'] );
		if ( ! $ts ) {
			$ts = time();
		}
		$post_date = date( 'Y-m-d H:i:s', $ts );

		$post_id = wp_insert_post( array(
			'post_type'    => 'post',
			'post_status'  => 'publish',
			'post_title'   => $seed['title'],
			'post_name'    => $seed['slug'],
			'post_excerpt' => $seed['excerpt'],
			'post_content' => $post_content,
			'post_date'    => $post_date,
			'post_date_gmt'=> get_gmt_from_date( $post_date ),
		), true );

		if ( is_wp_error( $post_id ) || ! $post_id ) {
			$failed++;
			continue;
		}

		// Category — create if missing, then assign.
		if ( ! empty( $seed['tag'] ) ) {
			$term = term_exists( $seed['tag'], 'category' );
			if ( ! $term ) {
				$term = wp_insert_term( $seed['tag'], 'category' );
			}
			if ( ! is_wp_error( $term ) && isset( $term['term_id'] ) ) {
				wp_set_post_categories( $post_id, array( (int) $term['term_id'] ) );
			}
		}

		// Featured image — sideload Unsplash URL into media library.
		if ( ! empty( $seed['img'] ) && ! has_post_thumbnail( $post_id ) ) {
			$attach_id = nyas_seed_sideload_image( $seed['img'], $post_id, $seed['title'] );
			if ( $attach_id && ! is_wp_error( $attach_id ) ) {
				set_post_thumbnail( $post_id, $attach_id );
			}
		}

		$created++;
	}

	if ( $created > 0 ) {
		update_option( NYAS_SEED_POSTS_OPTION, time() );
	}

	$msg = sprintf(
		/* translators: 1: number created, 2: number skipped, 3: link to insights archive. */
		__( 'Imported %1$d sample posts (%2$d already existed). View them on your <a href="%3$s">Insights page</a>.', 'nyas' ),
		$created,
		$skipped,
		esc_url( get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/' ) )
	);
	if ( $failed > 0 ) {
		$msg .= ' ' . sprintf( __( '%d failed (check error log).', 'nyas' ), $failed );
	}

	set_transient(
		'nyas_seed_posts_flash',
		array(
			'type'    => $failed > 0 ? 'error' : 'success',
			'message' => $msg,
		),
		MINUTE_IN_SECONDS
	);

	wp_safe_redirect( admin_url( 'edit.php' ) );
	exit;
}
add_action( 'admin_post_' . NYAS_SEED_POSTS_ACTION, 'nyas_seed_posts_handle_run' );

/**
 * Sideload an image from a URL into the media library and attach it to a post.
 * Returns attachment ID on success or 0 on failure.
 */
function nyas_seed_sideload_image( $url, $post_id, $alt = '' ) {
	if ( empty( $url ) ) {
		return 0;
	}

	$tmp = download_url( $url, 30 );
	if ( is_wp_error( $tmp ) ) {
		return 0;
	}

	// Use a stable filename derived from the URL path.
	$path = parse_url( $url, PHP_URL_PATH );
	$ext  = pathinfo( $path, PATHINFO_EXTENSION );
	if ( ! $ext ) {
		$ext = 'jpg';
	}
	$file_array = array(
		'name'     => sanitize_title_with_dashes( $alt ?: 'nyas-seed' ) . '.' . $ext,
		'tmp_name' => $tmp,
	);

	$attach_id = media_handle_sideload( $file_array, $post_id, $alt );

	// Clean up tmp file if sideload didn't.
	if ( file_exists( $tmp ) ) {
		@unlink( $tmp ); // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged
	}

	if ( is_wp_error( $attach_id ) ) {
		return 0;
	}

	if ( $alt ) {
		update_post_meta( $attach_id, '_wp_attachment_image_alt', $alt );
	}

	return $attach_id;
}

/**
 * Manual dismiss handler — sets the done flag without running the wizard.
 */
function nyas_setup_handle_dismiss() {
	if ( ! isset( $_GET['nyas_dismiss_setup'] ) ) {
		return;
	}
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	check_admin_referer( 'nyas_dismiss_setup' );
	update_option( NYAS_SETUP_DONE_OPTION, time() );
	wp_safe_redirect( remove_query_arg( array( 'nyas_dismiss_setup', '_wpnonce' ) ) );
	exit;
}
add_action( 'admin_init', 'nyas_setup_handle_dismiss' );

/**
 * The runner — does the work.
 */
function nyas_setup_handle_run() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'Insufficient permissions.', 'nyas' ) );
	}
	check_admin_referer( NYAS_SETUP_ACTION );

	$result = nyas_setup_run();

	set_transient(
		'nyas_setup_flash',
		array(
			'type'    => $result['success'] ? 'success' : 'error',
			'message' => $result['message'],
		),
		MINUTE_IN_SECONDS
	);

	if ( $result['success'] ) {
		update_option( NYAS_SETUP_DONE_OPTION, time() );
	}

	wp_safe_redirect( admin_url( 'index.php' ) );
	exit;
}
add_action( 'admin_post_' . NYAS_SETUP_ACTION, 'nyas_setup_handle_run' );

/**
 * Create / update a page by slug. Idempotent.
 *
 * @param string $title    Title.
 * @param string $slug     Page slug (post_name).
 * @param string $template Template path relative to theme (or '').
 * @param int    $parent   Parent page ID (or 0).
 * @return int Page ID.
 */
function nyas_setup_ensure_page( $title, $slug, $template = '', $parent = 0 ) {
	$existing = get_page_by_path( $slug );
	if ( $existing ) {
		// Make sure template + parent are correct in case a hand-created page exists.
		if ( $template ) {
			update_post_meta( $existing->ID, '_wp_page_template', $template );
		}
		if ( $parent && (int) $existing->post_parent !== (int) $parent ) {
			wp_update_post( array(
				'ID'          => $existing->ID,
				'post_parent' => $parent,
			) );
		}
		return $existing->ID;
	}

	$post_id = wp_insert_post( array(
		'post_type'    => 'page',
		'post_status'  => 'publish',
		'post_title'   => $title,
		'post_name'    => $slug,
		'post_parent'  => $parent,
		'post_content' => '',
	), true );

	if ( is_wp_error( $post_id ) ) {
		return 0;
	}

	if ( $template ) {
		update_post_meta( $post_id, '_wp_page_template', $template );
	}

	return $post_id;
}

/**
 * Do the work. Returns ['success' => bool, 'message' => string].
 */
function nyas_setup_run() {
	$created = array();

	// 1. Top-level pages.
	$home_id     = nyas_setup_ensure_page( __( 'Home', 'nyas' ),         'home' );
	$insights_id = nyas_setup_ensure_page( __( 'Insights', 'nyas' ),     'insights' );
	$about_id    = nyas_setup_ensure_page( __( 'About', 'nyas' ),        'about',    'page-templates/page-about.php' );
	$services_id = nyas_setup_ensure_page( __( 'Services', 'nyas' ),     'services', 'page-templates/page-services.php' );
	$cases_id    = nyas_setup_ensure_page( __( 'Case studies', 'nyas' ), 'cases',    'page-templates/page-cases.php' );

	if ( ! $home_id || ! $insights_id || ! $about_id || ! $services_id || ! $cases_id ) {
		return array(
			'success' => false,
			'message' => __( 'Failed to create one or more top-level pages. Please try again or check the logs.', 'nyas' ),
		);
	}

	// 2. Static homepage + posts page.
	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $home_id );
	update_option( 'page_for_posts', $insights_id );

	// 3. Service detail pages.
	$services = array(
		'residential'  => __( 'Residential', 'nyas' ),
		'commercial'   => __( 'Commercial', 'nyas' ),
		'warehouse'    => __( 'Warehouse', 'nyas' ),
		'construction' => __( 'Construction', 'nyas' ),
		'retail'       => __( 'Retail', 'nyas' ),
		'office'       => __( 'Office', 'nyas' ),
		'school'       => __( 'School', 'nyas' ),
		'medical'      => __( 'Medical', 'nyas' ),
		'monitoring'   => __( 'Monitoring', 'nyas' ),
		'video'        => __( 'Video', 'nyas' ),
	);
	foreach ( $services as $slug => $title ) {
		nyas_setup_ensure_page( $title, $slug, 'page-templates/page-service.php', $services_id );
	}

	// 4. Case study detail pages.
	$cases = array(
		'maman'             => __( 'Maman', 'nyas' ),
		'iannone'           => __( 'Iannone Brothers', 'nyas' ),
		'beth-israel'       => __( 'Beth Israel', 'nyas' ),
		'columbia-prep'     => __( 'Columbia Prep', 'nyas' ),
		'maspeth-warehouse' => __( 'Maspeth Warehouse', 'nyas' ),
		'bronx-condo'       => __( 'Bronx Condo', 'nyas' ),
	);
	foreach ( $cases as $slug => $title ) {
		nyas_setup_ensure_page( $title, $slug, 'page-templates/page-case.php', $cases_id );
	}

	// 5. Pretty permalinks.
	if ( '' === get_option( 'permalink_structure' ) ) {
		global $wp_rewrite;
		$wp_rewrite->set_permalink_structure( '/%postname%/' );
		update_option( 'permalink_structure', '/%postname%/' );
	}

	// 6. Build / update primary nav menu.
	$menu_name     = 'Primary';
	$menu_obj      = wp_get_nav_menu_object( $menu_name );
	$menu_id       = $menu_obj ? (int) $menu_obj->term_id : (int) wp_create_nav_menu( $menu_name );
	$menu_pages    = array( $home_id, $services_id, $cases_id, $insights_id, $about_id );
	$existing_items = wp_get_nav_menu_items( $menu_id );
	$existing_object_ids = array();
	if ( $existing_items ) {
		foreach ( $existing_items as $item ) {
			$existing_object_ids[ (int) $item->object_id ] = true;
		}
	}
	foreach ( $menu_pages as $pid ) {
		if ( isset( $existing_object_ids[ $pid ] ) ) {
			continue;
		}
		wp_update_nav_menu_item( $menu_id, 0, array(
			'menu-item-object'    => 'page',
			'menu-item-object-id' => $pid,
			'menu-item-type'      => 'post_type',
			'menu-item-status'    => 'publish',
		) );
	}

	// Assign to "primary" location.
	$locations = get_theme_mod( 'nav_menu_locations', array() );
	$locations['primary'] = $menu_id;
	set_theme_mod( 'nav_menu_locations', $locations );

	// 7. Flush rewrites.
	flush_rewrite_rules( false );

	return array(
		'success' => true,
		'message' => sprintf(
			/* translators: 1: link to homepage, 2: link to services, 3: link to cases, 4: link to about. */
			__( 'Setup complete. Visit your <a href="%1$s">homepage</a>, <a href="%2$s">services</a>, <a href="%3$s">case studies</a>, or <a href="%4$s">about page</a>.', 'nyas' ),
			esc_url( home_url( '/' ) ),
			esc_url( home_url( '/services/' ) ),
			esc_url( home_url( '/cases/' ) ),
			esc_url( home_url( '/about/' ) )
		),
	);
}
