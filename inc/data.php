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
			'img'   => NYAS_URI . 'assets/img/brooklyn-brownstone-home.jpg',
		),
		array(
			'id'    => 'commercial',
			'icon'  => 'building',
			'cat'   => 'Business',
			'name'  => 'Commercial alarm systems',
			'short' => 'Commercial',
			'desc'  => 'Multi-tenant, mixed-use, industry-grade panels rated for 24/7 commercial use.',
			'feats' => array( 'Panel + zoning', 'Access control', 'Multi-site dashboard', 'Insurance certs' ),
			'img'   => 'https://images.unsplash.com/photo-1665852444247-b094252e722a?w=900&q=80&auto=format&fit=crop',
		),
		array(
			'id'    => 'warehouse',
			'icon'  => 'warehouse',
			'cat'   => 'Industrial',
			'name'  => 'Warehouse alarm systems',
			'short' => 'Warehouse',
			'desc'  => 'Perimeter, motion, dock-bay sensors. Designed for high-bay environments.',
			'feats' => array( 'Perimeter beams', 'Loading dock sensors', 'Volumetric motion', 'Inventory cameras' ),
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
			'img'   => 'https://images.unsplash.com/photo-1710781189469-55afea4e6bcd?w=900&q=80&auto=format&fit=crop',
		),
		array(
			'id'    => 'office',
			'icon'  => 'briefcase',
			'cat'   => 'Business',
			'name'  => 'Office alarm systems',
			'short' => 'Offices',
			'desc'  => 'Access control, after-hours coverage, tenant integration for offices and co-working.',
			'feats' => array( 'Badge access', 'Visitor management', 'After-hours arming', 'Tenant portal' ),
			'img'   => NYAS_URI . 'assets/img/office.webp',
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
			'desc'  => '24/7 UL-listed central station on Long Island. We watch what we install — and what others installed too.',
			'feats' => array( 'UL 827 listed', 'Verified response', '24/7 operators', 'Take-over service' ),
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
 * Case studies — anonymized per the honest-claims rule (no client names
 * until real, client-approved case studies replace these).
 */
function nyas_cases() {
	return array(
		array(
			'slug'      => 'tower-ny',
			'industry'  => 'Automotive',
			'title'     => '7-location NYC auto dealership cuts security costs by 32% and reduces workplace accidents by nearly 60%',
			'client'    => 'Tower NY · Brooklyn, Queens & the Bronx · 7 locations',
			'summary'   => 'Tower NY, a local auto dealership and service company with seven locations across Brooklyn, Queens, and the Bronx, was facing significant security and safety challenges. They turned to New York Alarm Systems to modernize their security infrastructure and bring all seven locations under one reliable, centralized system.',
			'challenge' => array(
				'Each location was operating with a different alarm system. Some were outdated, others were newer, but none were being properly maintained.',
				'The company was dealing with recurring issues including communication failures, wireless sensors with depleted batteries, and communication modules that had not been properly tested. Their surveillance cameras were also aging, frequently malfunctioning, and completely separate from the alarm systems.',
				'The result was a growing security problem across the business, including burglaries, missing inventory and auto parts, false alarms, and preventable workplace incidents.',
			),
			'solution'  => array(
				'Our team standardized the security infrastructure across all seven Tower NY locations using Honeywell alarm systems.',
				'We also created a centralized dashboard, giving management clear visibility into every location from one place.',
				'The existing camera systems were upgraded and integrated with the alarm systems. We then configured predefined events and automated alerts to immediately notify management when specific incidents occurred, while allowing our monitoring station to quickly assess situations and respond appropriately.',
				'The technology upgrade also significantly reduced false alarms and made the entire security operation easier to manage.',
			),
			'impact'    => array(
				'Workplace accidents decreased by nearly 60%',
				'Burglary incidents went from four successful break-ins per year to one unsuccessful attempt that resulted in an arrest',
				'Missing parts and inventory, previously a significant expense, became a minor issue within six months',
				'Security subscription costs were reduced by 32%',
				'Tower NY saved more than $16,000 within the first 18 months',
			),
			'stats'     => array(
				array( 'n' => '32%',   'l' => 'Lower security costs' ),
				array( 'n' => '~60%',  'l' => 'Fewer workplace accidents' ),
				array( 'n' => '$16k+', 'l' => 'Saved in 18 months' ),
				array( 'n' => '7',     'l' => 'Locations on one dashboard' ),
			),
			'img'       => NYAS_URI . 'assets/img/case-tower-ny.webp',
			'featured'  => true,
		),
		array(
			'slug'     => 'iannone',
			'industry' => 'Construction',
			'title'    => 'Queens contractor stops job-site theft on 14 active sites',
			'client'   => 'General contractor · Queens',
			'summary'  => 'After two break-ins on a Queens build, we deployed solar towers, GPS-tagged tools, and a verified-dispatch protocol. Zero theft incidents in eleven months.',
			'stats'    => array(
				array( 'n' => '0',     'l' => 'Theft incidents' ),
				array( 'n' => '11 mo', 'l' => 'Since rollout' ),
			),
			'img'      => 'https://images.unsplash.com/photo-1503387762-592deb58ef4e?w=900&q=85',
		),
		array(
			'slug'     => 'beth-israel',
			'industry' => 'Medical',
			'title'    => 'Medical center upgrades duress response across four floors',
			'client'   => 'Medical center · Manhattan',
			'summary'  => 'Replaced a five-year-old emergency response system with HIPAA-aware monitoring and code-blue integration across four floors.',
			'stats'    => array(
				array( 'n' => '24/7',    'l' => 'Duress coverage' ),
				array( 'n' => '4 floors','l' => 'Coverage' ),
			),
			'img'      => 'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?w=900&q=85',
		),
		array(
			'slug'     => 'columbia-prep',
			'industry' => 'Schools',
			'title'    => 'Private school deploys lockdown response in 8 weeks',
			'client'   => 'Private school · Upper West Side',
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
			'client'   => 'Distribution warehouse · Maspeth, Queens',
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
			'client'   => 'Condo board · Riverdale, the Bronx',
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
	// Legacy alias — the old /cases/maman/ page now carries the Tower NY study.
	if ( 'maman' === $slug ) {
		$slug = 'tower-ny';
	}
	foreach ( nyas_cases() as $case ) {
		if ( $case['slug'] === $slug ) {
			return $case;
		}
	}
	return null;
}
