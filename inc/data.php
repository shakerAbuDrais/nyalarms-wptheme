<?php
/**
 * Static design content — services, cases, testimonials, etc.
 *
 * Reproduces the hard-coded data in home.jsx / services.html / cases.html so
 * every template can render from the same source. Replace these arrays with
 * custom-post-type queries once content lives in WP.
 *
 * @package NYAS
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The ten core services / categories.
 */
function nyas_services() {
	return array(
		array(
			'id'    => 'residential',
			'icon'  => 'home',
			'cat'   => 'Home',
			'name'  => 'Residential alarm systems',
			'short' => 'Residential',
			'desc'  => 'Brownstones, condos, single-family. Wired or wireless installations with 24/7 monitoring.',
			'feats' => array( 'Door & window sensors', 'Motion detection', 'Mobile app', 'Cellular backup' ),
			'img'   => 'https://images.unsplash.com/photo-1568605114967-8130f3a36994?w=900&q=80',
		),
		array(
			'id'    => 'commercial',
			'icon'  => 'building',
			'cat'   => 'Business',
			'name'  => 'Commercial alarm systems',
			'short' => 'Commercial',
			'desc'  => 'Multi-tenant, mixed-use, industry-grade panels rated for 24/7 commercial use.',
			'feats' => array( 'Panel + zoning', 'Access control', 'Multi-site dashboard', 'Insurance certs' ),
			'img'   => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=900&q=80',
		),
		array(
			'id'    => 'warehouse',
			'icon'  => 'warehouse',
			'cat'   => 'Industrial',
			'name'  => 'Warehouse alarm systems',
			'short' => 'Warehouse',
			'desc'  => 'Perimeter, motion, dock-bay sensors. UL fire-rated. Designed for high-bay environments.',
			'feats' => array( 'Perimeter beams', 'Loading dock sensors', 'Fire integration', 'Inventory cameras' ),
			'img'   => 'https://images.unsplash.com/photo-1553413077-190dd305871c?w=900&q=80',
		),
		array(
			'id'    => 'construction',
			'icon'  => 'hardhat',
			'cat'   => 'Industrial',
			'name'  => 'Construction site alarm systems',
			'short' => 'Construction sites',
			'desc'  => 'Temporary towers, GPS-tracked tools, theft deterrence for active job sites.',
			'feats' => array( 'Solar towers', 'Tool tracking', 'Trespasser alerts', 'Time-lapse cameras' ),
			'img'   => 'https://images.unsplash.com/photo-1503387762-592deb58ef4e?w=900&q=80',
		),
		array(
			'id'    => 'retail',
			'icon'  => 'shop',
			'cat'   => 'Business',
			'name'  => 'Retail alarm systems',
			'short' => 'Retail',
			'desc'  => 'POS-integrated, after-hours coverage, smash-and-grab response.',
			'feats' => array( 'Glass-break sensors', 'POS panic buttons', 'Loss-prevention cams', 'After-hours arming' ),
			'img'   => 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=900&q=80',
		),
		array(
			'id'    => 'office',
			'icon'  => 'briefcase',
			'cat'   => 'Business',
			'name'  => 'Office alarm systems',
			'short' => 'Offices',
			'desc'  => 'Access control, after-hours coverage, tenant integration for offices and co-working.',
			'feats' => array( 'Badge access', 'Visitor management', 'After-hours arming', 'Tenant portal' ),
			'img'   => 'https://images.unsplash.com/photo-1497366216548-37526070297c?w=900&q=80',
		),
		array(
			'id'    => 'school',
			'icon'  => 'school',
			'cat'   => 'Emergency',
			'name'  => 'Emergency alarm systems for schools',
			'short' => 'Schools (emergency)',
			'desc'  => 'Lockdown buttons, panic alerts, Title IX-compliant. Direct NYPD escalation.',
			'feats' => array( 'Classroom panic', 'Lockdown system', 'PA integration', 'Drill reporting' ),
			'img'   => 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=900&q=80',
		),
		array(
			'id'    => 'medical',
			'icon'  => 'medical',
			'cat'   => 'Emergency',
			'name'  => 'Emergency alarm systems for medical facilities',
			'short' => 'Medical (emergency)',
			'desc'  => 'HIPAA-aware monitoring, code-blue integration, duress and elopement alerts.',
			'feats' => array( 'Duress buttons', 'Code-blue tie-in', 'Elopement alerts', 'HIPAA logging' ),
			'img'   => 'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?w=900&q=80',
		),
		array(
			'id'    => 'monitoring',
			'icon'  => 'monitor',
			'cat'   => 'Service',
			'name'  => 'Alarm systems monitoring',
			'short' => 'Monitoring',
			'desc'  => '24/7 UL-listed central station in Long Island City. We watch what we install — and what others installed too.',
			'feats' => array( 'UL 827 listed', 'NYPD-recognized', '28s avg dispatch', 'Take-over service' ),
			'img'   => 'https://images.unsplash.com/photo-1555949963-aa79dcee981c?w=900&q=80',
		),
		array(
			'id'    => 'video',
			'icon'  => 'video',
			'cat'   => 'Service',
			'name'  => 'Video integrated alarm systems',
			'short' => 'Video integrated',
			'desc'  => 'Smart cameras, AI analytics, two-way audio. Live verification before dispatch.',
			'feats' => array( 'AI motion analytics', '4K recording', 'Two-way audio', 'Cloud + NVR' ),
			'img'   => 'https://images.unsplash.com/photo-1558002038-1055907df827?w=900&q=80',
		),
	);
}

/**
 * Lookup a single service by id.
 */
function nyas_service( $id ) {
	foreach ( nyas_services() as $svc ) {
		if ( $svc['id'] === $id ) {
			return $svc;
		}
	}
	return null;
}

/**
 * Case studies.
 */
function nyas_cases() {
	return array(
		array(
			'slug'     => 'maman',
			'industry' => 'Retail',
			'title'    => 'Maman cuts shrinkage 41% across 12 NYC locations',
			'client'   => 'Maman · SoHo, Tribeca, Williamsburg + 9 more',
			'summary'  => 'Replaced four legacy alarm vendors with one integrated stack. Twelve stores, one dashboard, fourteen days.',
			'stats'    => array(
				array( 'n' => '41%', 'l' => 'Shrinkage drop' ),
				array( 'n' => '$73k', 'l' => 'Annual savings' ),
			),
			'img'      => 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=1200&q=85',
			'featured' => true,
		),
		array(
			'slug'     => 'iannone',
			'industry' => 'Construction',
			'title'    => 'Iannone Brothers stops job-site theft on 14 active sites',
			'client'   => 'Iannone Brothers Construction · Queens',
			'summary'  => 'After two break-ins on a Long Island City build, we deployed solar towers, GPS-tagged tools, and a verified-dispatch protocol. Zero theft incidents in eleven months.',
			'stats'    => array(
				array( 'n' => '0',     'l' => 'Theft incidents' ),
				array( 'n' => '11 mo', 'l' => 'Since rollout' ),
			),
			'img'      => 'https://images.unsplash.com/photo-1503387762-592deb58ef4e?w=900&q=85',
		),
		array(
			'slug'     => 'beth-israel',
			'industry' => 'Medical',
			'title'    => 'Beth Israel hits 28-second median dispatch on duress alerts',
			'client'   => 'Beth Israel Medical Center · Manhattan',
			'summary'  => 'Replaced a five-year-old emergency response system with HIPAA-aware monitoring and code-blue integration across four floors.',
			'stats'    => array(
				array( 'n' => '28s',     'l' => 'Median dispatch' ),
				array( 'n' => '4 floors','l' => 'Coverage' ),
			),
			'img'      => 'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?w=900&q=85',
		),
		array(
			'slug'     => 'columbia-prep',
			'industry' => 'Schools',
			'title'    => 'Columbia Prep deploys lockdown response in 8 weeks',
			'client'   => 'Columbia Prep · Upper West Side',
			'summary'  => 'Classroom panic buttons, PA integration, and a NYPD direct-line protocol — rolled out before Labor Day.',
			'stats'    => array(
				array( 'n' => '8 wk', 'l' => 'Rollout' ),
				array( 'n' => '32',   'l' => 'Classrooms' ),
			),
			'img'      => 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=900&q=85',
		),
		array(
			'slug'     => 'maspeth-warehouse',
			'industry' => 'Warehouse',
			'title'    => 'Maspeth distribution warehouse lowers premiums 18%',
			'client'   => 'Hudson Logistics · Maspeth, Queens',
			'summary'  => 'Perimeter beams, 32 dock-bay sensors, and AI video analytics — insurance discount letter the same week.',
			'stats'    => array(
				array( 'n' => '18%', 'l' => 'Premium drop' ),
				array( 'n' => '32',  'l' => 'Dock bays' ),
			),
			'img'      => 'https://images.unsplash.com/photo-1553413077-190dd305871c?w=900&q=85',
		),
		array(
			'slug'     => 'bronx-condo',
			'industry' => 'Residential',
			'title'    => 'Riverdale condo board picks one alarm vendor for 84 units',
			'client'   => 'The Whitehall · Riverdale, the Bronx',
			'summary'  => 'After three years of mismatched vendors, the board signed a single-source agreement covering all units, common areas, and the lobby.',
			'stats'    => array(
				array( 'n' => '84', 'l' => 'Units' ),
				array( 'n' => '1',  'l' => 'Vendor' ),
			),
			'img'      => 'https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?w=900&q=85',
		),
	);
}

function nyas_case( $slug ) {
	foreach ( nyas_cases() as $case ) {
		if ( $case['slug'] === $slug ) {
			return $case;
		}
	}
	return null;
}

/**
 * Editorial / blog seed posts (used as fallback if WP has no posts yet).
 */
function nyas_seed_posts() {
	return array(
		array(
			'slug'     => 'wired-vs-wireless-prewar',
			'tag'      => 'Buyers guide',
			'title'    => 'Wireless vs. wired alarms in pre-war NYC apartments',
			'excerpt'  => 'When a Park Slope brownstone\'s plaster walls and a 1923 BX cable run meet a 2026 mesh sensor, who wins?',
			'date'     => 'Apr 18, 2026',
			'read'     => '6 min',
			'author'   => 'Marcus Tan',
			'img'      => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=1200&q=80',
			'featured' => true,
		),
		array(
			'slug'    => 'nypd-response-2025',
			'tag'     => 'Industry',
			'title'   => 'NYPD response data: what the 2025 numbers tell us',
			'excerpt' => 'Median dispatch climbed in three precincts. Here\'s what changed and how to plan around it.',
			'date'    => 'Apr 9, 2026',
			'read'    => '9 min',
			'author'  => 'Diana Velez',
			'img'     => 'https://images.unsplash.com/photo-1569163139394-de4798aa62b6?w=900&q=80',
		),
		array(
			'slug'    => 'no-more-24-month',
			'tag'     => 'Field notes',
			'title'   => 'Why we stopped recommending 24-month contracts',
			'excerpt' => 'A reflection on the industry\'s favourite trap, and what we replaced it with.',
			'date'    => 'Mar 27, 2026',
			'read'    => '4 min',
			'author'  => 'Diana Velez',
			'img'     => 'https://images.unsplash.com/photo-1504384308090-c894fdcc538d?w=900&q=80',
		),
		array(
			'slug'    => 'co-op-board-checklist',
			'tag'     => 'Buyers guide',
			'title'   => 'The co-op board checklist before you install',
			'excerpt' => 'Eight items every Manhattan co-op wants before they\'ll sign off on alarm hardware.',
			'date'    => 'Mar 14, 2026',
			'read'    => '5 min',
			'author'  => 'Priya Iyer',
			'img'     => 'https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?w=900&q=80',
		),
		array(
			'slug'    => 'false-alarms',
			'tag'     => 'Field notes',
			'title'   => 'False alarms cost the city $9M last year. Here\'s how to avoid yours.',
			'excerpt' => 'A simple two-step verification protocol that we use to keep our false-dispatch rate under 0.4%.',
			'date'    => 'Feb 28, 2026',
			'read'    => '7 min',
			'author'  => 'Rashaan Cole',
			'img'     => 'https://images.unsplash.com/photo-1485827404703-89b55fcc595e?w=900&q=80',
		),
		array(
			'slug'    => 'video-verification',
			'tag'     => 'Industry',
			'title'   => 'The case for video-verified dispatch',
			'excerpt' => 'Why NYPD prioritizes alarms backed by live video confirmation.',
			'date'    => 'Feb 11, 2026',
			'read'    => '6 min',
			'author'  => 'Marcus Tan',
			'img'     => 'https://images.unsplash.com/photo-1551703599-6b3e8379aa8c?w=900&q=80',
		),
	);
}

/**
 * Testimonials.
 */
function nyas_testimonials() {
	return array(
		array(
			'quote' => 'They installed a real system, not a contract trap. I own my hardware. Monitoring is month-to-month. Refreshing.',
			'name'  => 'Devon Rawlins',
			'role'  => 'Homeowner · Park Slope',
			'img'   => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=200&q=80',
		),
		array(
			'quote' => 'Our previous vendor took 4 minutes to dispatch. NYAS is under 30 seconds. We saw the difference the first month.',
			'name'  => 'Anita Mehra',
			'role'  => 'Operations Director · Beth Israel',
			'img'   => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=200&q=80',
		),
		array(
			'quote' => 'Build site got hit twice in 2024. After NYAS rolled out cameras + temporary towers, zero incidents in 11 months.',
			'name'  => 'Marco Iannone',
			'role'  => 'GC · Iannone Brothers Construction',
			'img'   => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=200&q=80',
		),
	);
}
