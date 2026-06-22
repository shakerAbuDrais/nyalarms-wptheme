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
			'img'   => 'https://images.unsplash.com/photo-1739131936348-aa227601f140?w=900&q=80&auto=format&fit=crop',
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
 * Editorial / blog seed posts (used as fallback if WP has no posts yet,
 * and as the source for the "Import sample blog posts" wizard button).
 *
 * Each post has body content broken into paragraphs and headings —
 * imported as full WP posts when the wizard runs.
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
			'content'  => "Every week, someone calls our Long Island City office with the same question. They're moving into a pre-war one-bedroom — usually somewhere on the Upper West Side, or a brownstone parlor in Cobble Hill — and they've read three contradictory things about alarm systems on Reddit.\n\nShould it be wired, the kind their parents had, with the keypad screwed into the foyer wall? Or should it be wireless, the kind that ships in a box and sticks to the molding?\n\nBoth can work. Both can fail. Here's how we decide, building by building.\n\n<blockquote>The honest answer is that the building decides, not the homeowner. Pre-war NYC plaster walls have opinions about radio frequencies that no marketing brochure mentions.</blockquote>\n\n<h2>The case for wired</h2>\n\nIf your apartment was built before 1945, there's a good chance it has lath-and-plaster walls reinforced with horsehair, brittle BX cable in the chases, and a parlor floor that creaks. Wired panels — meaning a hardwired control box, contact sensors connected by 22/4 cable, and a keypad — have one massive advantage in this kind of building: they don't need to talk through six inches of plaster reinforced with metal mesh. They just send a low-voltage signal down a copper pair.\n\n<h2>The case for wireless</h2>\n\nThat said, ninety percent of our residential installs in 2025 were wireless — even in pre-war buildings. Modern mesh-based panels operate at 915 MHz with 128-bit AES encryption and a five-year battery life on each sensor. They handle plaster fine, as long as the gateway is positioned thoughtfully.\n\n<h2>What we tell people on the call</h2>\n\nHonestly? Most New Yorkers will be perfectly served by a wireless system, properly placed. The exceptions are real but uncommon: extremely old plaster, very large floor plans (over 1,800 sqft), and buildings where an integrated fire system makes hardwiring the smart play anyway.",
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
			'content' => "The NYPD's annual response-time report for 2025 dropped last week, and it's worth a careful read for anyone designing alarm systems in New York City.\n\nThe headline: median response to verified burglar alarms held steady citywide at 7.2 minutes. The story underneath: three precincts (the 19th, the 13th, and the 84th) saw their median climb past 9 minutes, and one precinct (the 109th in Queens) actually improved by almost 90 seconds.\n\n<h2>What changed in the slower precincts</h2>\n\nIn each of the three precincts that slipped, the underlying cause was the same: false-alarm volume drove down the priority of unverified events. Officers don't roll out the door at the same speed for an alarm with a 60% historical false-dispatch rate as they do for one verified by audio or video.\n\n<blockquote>The fastest way to make NYPD respond faster to your alarm is to make sure it's verified. Period.</blockquote>\n\n<h2>How we adjusted</h2>\n\nThis is exactly why our default install spec for 2026 includes either a video-verification camera or two-way audio at the panel — both count as verification under NYPD's 2024 protocol.\n\nIf your existing system is alarm-only with no verification, we can usually retrofit a single PoE camera at the front door for under \$400 in hardware. The math pays for itself the first false alarm you avoid.",
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
			'content' => "For most of our first decade, we offered 24-month monitoring contracts. Not 36, not 60 — but two years felt like a reasonable middle ground.\n\nWe stopped doing them in 2023. Here's why.\n\n<h2>The trap nobody mentions</h2>\n\nWhen you sign a 24-month contract, you're not committing to two years of monitoring. You're committing to two years of <em>your current monitoring vendor</em> — even if their service degrades, even if they get acquired, even if they raise prices.\n\nWe watched two of our customers get stuck after their previous vendor (not us) was acquired by a national. Service quality dropped. Phone calls went to a Texas call center. They couldn't leave for a year. We took them on as soon as their contract ended.\n\n<blockquote>If we're not earning your business every month, you should be free to leave. That's just honest.</blockquote>\n\n<h2>What we do instead</h2>\n\nMonth-to-month monitoring with 30 days' cancel notice. Hardware is purchased one-time and yours to keep. If you cancel, the panel and sensors stay on your wall — you can self-monitor, or hire a new vendor to take over the equipment.\n\nWe've heard exactly two complaints about this in 18 months. Both were from sales reps at competitors.",
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
			'content' => "Co-op boards are not the enemy. They're protecting the building. But every Manhattan co-op we've worked with — and we've done over 400 — wants the same eight things on paper before they'll sign off on alarm hardware.\n\nIf you walk in with all eight ready, your alteration agreement clears in days, not months.\n\n<h2>The eight items</h2>\n\n<strong>1. Certificate of insurance</strong> — naming the building corporation as additional insured, $2M general liability minimum.\n\n<strong>2. Licensed electrician affidavit</strong> — even for low-voltage work in many older buildings.\n\n<strong>3. Schedule of work</strong> — exact dates, times, and floors affected. Most co-ops require weekday-only, 9–5.\n\n<strong>4. Hardware spec sheet</strong> — every component, model number, and where it'll be mounted.\n\n<strong>5. Wall penetration disclosure</strong> — what (if anything) gets drilled, and what's used to seal it after.\n\n<strong>6. Removal plan</strong> — how the system comes out cleanly if you sell or move.\n\n<strong>7. Monitoring company UL listing</strong> — co-ops want to see UL 827 on the cover sheet.\n\n<strong>8. Building rules acknowledgment</strong> — signed by you, confirming you've read the alteration rules.\n\n<h2>What we do</h2>\n\nWe pre-package items 1, 2, 4, 5, 7, and 8 with every co-op install — they're the same for every job. Items 3 and 6 we customize per unit.",
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
			'content' => "NYC issued $9M in false-alarm fines in 2024. Most of them were avoidable.\n\nThe city's ordinance is straightforward: after the second false alarm in a calendar year, fines start at $100 and escalate. Five false alarms and you're at $750 each. Frequent offenders end up on a list that delays NYPD response on real events.\n\n<h2>Why most false alarms happen</h2>\n\nIn our data across 9,400 monitored properties, the top three causes are: motion sensors triggered by HVAC airflow, glass-break sensors mistaking dropped dishes for windows, and pets above weight thresholds.\n\nNone of these are panel failures. They're spec mistakes — the wrong sensor for the room.\n\n<blockquote>A good install is 80% specifying the right sensor for the right room, and 20% the actual mounting.</blockquote>\n\n<h2>Our two-step verification protocol</h2>\n\n<strong>Step one: dual-sensor confirmation.</strong> No single sensor triggers a dispatch. We require two zones to agree (e.g., glass-break + motion) within 90 seconds.\n\n<strong>Step two: human verification.</strong> Operators pull a live camera feed or open two-way audio before any 911 call. This adds 8–12 seconds to dispatch — but cuts false-positive rate by 91%.\n\nOur 2025 rolling false-dispatch rate: 0.38%. Industry average: 7.4%.",
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
			'content' => "If you've watched the NYPD's response data for the last five years, one number jumps out: video-verified alarms get a Priority 2 response on average. Unverified alarms hover between Priority 4 and 5.\n\nThat's the difference between an officer rolling out in 90 seconds versus 7 minutes.\n\n<h2>What \"verified\" means in NYPD's protocol</h2>\n\nFour things count as verification under the 2024 NYPD protocol: live video confirming a person on the property, two-way audio confirming the same, two independent zones agreeing within 90 seconds, or a panic button pressed (panics are always verified).\n\nNote that motion + door contact in the same zone do <em>not</em> count — they have to be different zones.\n\n<h2>Why we default to video</h2>\n\nVideo is the easiest one to retrofit. A single PoE camera at the front entry, integrated with the central station, costs under $400 in hardware and gives you priority response for the rest of the system's life.\n\n<blockquote>If we install one camera in your home or business, that camera is the difference between a 7-minute response and a 90-second response. It's the highest-leverage piece of hardware we sell.</blockquote>\n\nWe spec at least one verification camera on every install since mid-2024.",
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
