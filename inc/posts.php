<?php
/**
 * Editorial posts — batch 1 of the content plan (Sept 2026).
 *
 * The six prototype demo posts (invented statistics, "our station" claims)
 * are trashed and replaced one-for-one with honest articles written to the
 * client brief: no unprovable numbers, the Long Island central station is a
 * UL-listed partner, fire alarms are residential only, Honeywell Resideo
 * equipment, buy-or-rent, month-to-month monitoring, byline Yonatan.
 *
 * Runs once (option flag). To re-run after editing a post below, delete the
 * `nyas_demo_posts_replaced` option and the post you want regenerated; posts
 * whose slug already exists are never overwritten.
 *
 * @package NYAS
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Copy a theme image into the media library and set it as a post's thumbnail.
 *
 * @param int    $post_id Post ID.
 * @param string $file    File name inside assets/img/.
 * @param string $alt     Alt text.
 * @return int Attachment ID or 0.
 */
function nyas_attach_theme_image( $post_id, $file, $alt ) {
	$path = NYAS_DIR . 'assets/img/' . $file;
	if ( ! file_exists( $path ) ) {
		return 0;
	}
	require_once ABSPATH . 'wp-admin/includes/image.php';

	$bits = wp_upload_bits( $file, null, file_get_contents( $path ) ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
	if ( ! empty( $bits['error'] ) ) {
		return 0;
	}
	$type   = wp_check_filetype( $bits['file'] );
	$att_id = wp_insert_attachment(
		array(
			'post_mime_type' => $type['type'],
			'post_title'     => sanitize_text_field( pathinfo( $file, PATHINFO_FILENAME ) ),
			'post_content'   => '',
			'post_status'    => 'inherit',
			'post_parent'    => $post_id,
		),
		$bits['file'],
		$post_id
	);
	if ( ! $att_id || is_wp_error( $att_id ) ) {
		return 0;
	}
	wp_update_attachment_metadata( $att_id, wp_generate_attachment_metadata( $att_id, $bits['file'] ) );
	update_post_meta( $att_id, '_wp_attachment_image_alt', $alt );
	set_post_thumbnail( $post_id, $att_id );
	return $att_id;
}

/**
 * One-time: trash the demo posts and publish batch 1.
 */
function nyas_replace_demo_posts() {
	if ( get_option( 'nyas_demo_posts_replaced' ) ) {
		return;
	}
	// Flag first so two overlapping requests can't both seed.
	update_option( 'nyas_demo_posts_replaced', 1 );

	$demo_slugs = array( 'wired-vs-wireless-prewar', 'nypd-response-2025', 'no-more-24-month', 'co-op-board-checklist', 'false-alarms', 'video-verification' );
	foreach ( $demo_slugs as $slug ) {
		$post = get_page_by_path( $slug, OBJECT, 'post' );
		if ( $post && 'trash' !== $post->post_status ) {
			wp_trash_post( $post->ID );
		}
	}

	$author    = get_user_by( 'slug', 'yonatan' );
	$author_id = $author ? $author->ID : 1;

	foreach ( nyas_seed_posts_data() as $seed ) {
		if ( get_page_by_path( $seed['slug'], OBJECT, 'post' ) ) {
			continue;
		}
		$term = term_exists( $seed['category'], 'category' );
		if ( ! $term ) {
			$term = wp_insert_term( $seed['category'], 'category' );
		}
		$cat_id = ( is_array( $term ) && ! is_wp_error( $term ) ) ? (int) $term['term_id'] : (int) $term;

		$post_id = wp_insert_post(
			array(
				'post_type'     => 'post',
				'post_status'   => 'publish',
				'post_author'   => $author_id,
				'post_title'    => $seed['title'],
				'post_name'     => $seed['slug'],
				'post_excerpt'  => $seed['excerpt'],
				'post_content'  => $seed['content'],
				'post_date'     => $seed['date'],
				'post_category' => $cat_id ? array( $cat_id ) : array(),
			),
			true
		);
		if ( $post_id && ! is_wp_error( $post_id ) ) {
			nyas_attach_theme_image( $post_id, $seed['image'], $seed['image_alt'] );
		}
	}
}
add_action( 'init', 'nyas_replace_demo_posts', 20 );

/**
 * Batch 1 article data. Slugs are the primary-keyword URLs from the content plan.
 *
 * @return array[]
 */
function nyas_seed_posts_data() {
	return array(

		// ── B1 · alarm system cost ─────────────────────────────────────────
		array(
			'slug'      => 'alarm-system-cost-nyc',
			'title'     => 'How Much Does an Alarm System Cost in NYC? What Actually Drives the Price',
			'excerpt'   => 'We don\'t publish a price list, because two brownstones on the same block can need very different systems. Here is what moves every line on a quote, so you can read anyone\'s.',
			'category'  => 'Buyers guide',
			'date'      => '2026-08-06 09:00:00',
			'image'     => 'scenario-park-slope-brownstone.webp',
			'image_alt' => 'Brownstone block in Park Slope, Brooklyn',
			'content'   => <<<'HTML'
<p>The first thing most people ask when they call is "roughly, what does it cost?" It is a fair question, and the honest answer is that we can't give a useful number until we've walked the property. Two brownstones on the same Park Slope block can need very different systems: one has a garden-level door, a roof hatch and eleven windows on the parlor floor, the other has a new steel back door and a landlord who won't allow drilling.</p>
<p>What we can do is show you exactly what moves the price. Every proposal we send is one page, itemized into the same four lines. If you understand those four lines, you can read our quote, and you can read anyone else's.</p>

<h2>The four lines on every quote</h2>
<ol>
<li><strong>Hardware.</strong> The panel, the sensors, the keypads and the cellular communicator.</li>
<li><strong>Labor.</strong> The site walk, the installation, programming and the walk-through when we hand it over.</li>
<li><strong>Monitoring.</strong> The monthly service that connects your system to a UL-listed central station on Long Island, plus the app.</li>
<li><strong>Video (optional).</strong> Cameras, recording and the verification tier if you want the central station to see what tripped the sensor before anyone is dispatched.</li>
</ol>
<p>We itemize on purpose. Bundled "starter package" pricing hides which of these lines you are actually paying for, and it makes it impossible to compare two companies fairly.</p>

<h2>What moves the hardware line</h2>
<p>Hardware is mostly a count. The questions we answer on the site walk:</p>
<ul>
<li><strong>How many openings need a contact?</strong> Every door and every reachable window is a decision. Ground-floor and garden-level openings in Brooklyn and Queens almost always get one; a fourth-floor window on an air shaft usually doesn't.</li>
<li><strong>How much interior coverage?</strong> Motion detectors cover rooms rather than openings. A long railroad apartment needs more than a boxy two-bedroom.</li>
<li><strong>Glass-break protection.</strong> Storefronts and parlor-floor bay windows often get a glass-break sensor in addition to a contact.</li>
<li><strong>Environmental sensors.</strong> For homes we can add monitored smoke, carbon monoxide, low-temperature and water sensors. (Fire-alarm monitoring is something we do for residential customers only.)</li>
<li><strong>The panel.</strong> We install <a href="/services/residential/">Honeywell Resideo</a> equipment: wired panels where the building allows it, wireless where it doesn't, and hybrid on most brownstone jobs.</li>
<li><strong>The communicator.</strong> Every system we install reports over cellular, so it keeps working when the Wi-Fi or the power is out. That module is a real line item and it should be on every quote you receive.</li>
</ul>

<h2>What moves the labor line</h2>
<p>Labor is where New York is different from the suburbs. The things that add time:</p>
<ul>
<li><strong>Wired vs. wireless.</strong> Running cable through lath-and-plaster walls and masonry takes longer than mounting wireless sensors. We wrote a separate guide on <a href="/wireless-vs-wired-alarm-prewar-nyc/">wireless vs. wired alarms in pre-war buildings</a>.</li>
<li><strong>The building.</strong> A co-op with an alteration agreement, a super who controls the basement, or a landmarked interior all change how we work and how long it takes.</li>
<li><strong>Floors and access.</strong> A four-story townhouse with a roof hatch is more labor than a one-bedroom.</li>
<li><strong>Commercial zoning.</strong> A store with a stockroom, an office, a basement and a roof access needs the system divided into zones so the central station knows exactly which door opened.</li>
</ul>
<p>Our technicians are our own employees. We don't subcontract installation, so the labor line is for people we trained and who will come back if something needs adjusting.</p>

<h2>Monitoring: month-to-month, with a discount for annual</h2>
<p>Monitoring is the part of the bill that recurs, and it is the part that actually protects you: the hardware only detects, the central station is what responds. Our monitoring is <strong>month-to-month</strong>. If you'd rather commit to a year, we discount it. Either way you are never locked into a multi-year term, and the equipment you bought stays yours.</p>
<p>What you're paying for each month is the connection to a UL-listed central station on Long Island, staffed around the clock, the verification call sequence when a sensor trips, and the app on your phone.</p>

<h2>Buy it or rent it</h2>
<p>You can own the system outright, or rent it from us. Buying makes sense if you own the property and plan to stay. Renting makes sense for tenants, for businesses that don't want a capital expense, and for anyone who wants us to carry the replacement cost if a device fails. Ask for both numbers; we'll put them side by side.</p>

<h2>Commercial is priced differently</h2>
<p>For a business the same four lines apply, but three things change the numbers: zoning and the number of partitions (so the manager's office can be armed while the sales floor is open), insurance certificates your carrier may require for a discount, and multi-site accounts. When Tower NY brought seven dealership locations under one system, the work was designing one account that let management see all seven sites, not just installing seven separate alarms. You can read that story in the <a href="/cases/tower-ny/">Tower NY case study</a>.</p>

<h2>How to compare two quotes</h2>
<ul>
<li><strong>Is it itemized?</strong> If you can't see hardware, labor and monitoring separately, ask for it.</li>
<li><strong>How long is the monitoring term?</strong> Multi-year contracts move the cost out of the equipment line and into your future. Ask what happens in month 25.</li>
<li><strong>Who owns the equipment?</strong> Some low upfront prices are rentals that never end.</li>
<li><strong>Who does the install?</strong> Ask whether the technician is an employee or a subcontractor.</li>
<li><strong>Is the company licensed?</strong> New York State requires anyone who installs, services or maintains a security or fire alarm system to hold a Department of State license (General Business Law Article 6-D). Ours is #12000314318. Ask for the number and look it up.</li>
<li><strong>Is there a cellular path?</strong> If the system only reports over your internet, it stops reporting when the router does.</li>
</ul>
<p>One more thing worth a phone call: many homeowners' insurance carriers reduce the premium for a professionally installed, centrally monitored alarm. The amount varies by carrier and policy, so ask yours before you decide on video or fire monitoring; the discount sometimes covers part of the monthly cost.</p>

<h2>Getting a real number</h2>
<p>The fastest way to a price is a site walk. A licensed consultant visits, maps the openings and blind spots, and you get a one-page proposal with the four lines above. Start with the <a href="/#quote">quote wizard</a> or call <a href="tel:+13477780820">(347) 778-0820</a>. A person answers.</p>
HTML
		),

		// ── A1 · alarm monitoring existing system ──────────────────────────
		array(
			'slug'      => 'alarm-monitoring-existing-system',
			'title'     => 'Alarm Monitoring for an Existing System: How to Switch Monitoring Without Replacing the Panel',
			'excerpt'   => 'You already have a panel on the wall. You probably don\'t need a new one. Here is how a monitoring take-over works, when it is possible, and what changes for you.',
			'category'  => 'Field notes',
			'date'      => '2026-08-13 09:00:00',
			'image'     => 'hw-cellular-hub.webp',
			'image_alt' => 'Cellular alarm communicator on a desk',
			'content'   => <<<'HTML'
<p>A lot of the calls we get start the same way: "There's an alarm system in the apartment I just bought and I don't know who monitors it," or "My contract with a national company is ending and I want out, but the panel works fine." In most of those cases the answer is that you don't need a new system. You need someone to take over the one you have.</p>

<h2>What "take-over" means</h2>
<p>An alarm panel does two jobs. It watches the sensors, and it reports to somebody when one of them trips. Take-over monitoring leaves the first job alone and changes the second: we re-program the panel so that its signals go to a UL-listed central station on Long Island instead of wherever they were going before, and we put the system on a <a href="/services/monitoring/">month-to-month monitoring account</a> with us.</p>
<p>Your sensors, keypads and wiring stay where they are. Most of the time the only new piece of hardware is a cellular communicator, if the panel doesn't already have one.</p>

<h2>What we check on the first visit</h2>
<ul>
<li><strong>Make, model and age of the panel.</strong> We install and service Honeywell Resideo equipment, so Honeywell panels are routine for us, and we can work with most other mainstream panels.</li>
<li><strong>How it reports today.</strong> Older systems dialed out over a phone line. Some report over your internet. A surprising number report over nothing at all: when the carriers shut down their 3G networks in 2022, a lot of older cellular communicators went silent, and the owners never knew.</li>
<li><strong>Whether we can get into the programming.</strong> Panels have an installer code. If the previous company locked the panel and won't release the code, we can sometimes default the panel and re-program it from scratch; occasionally we can't, and we'll tell you that on the spot.</li>
<li><strong>Sensor health.</strong> We walk-test every door, window and motion detector and check batteries on wireless devices.</li>
<li><strong>The zone list.</strong> The central station needs to know that "Zone 4" is the garden-level door, not "the back."</li>
</ul>

<h2>When a take-over works, and when it doesn't</h2>
<p><strong>It works</strong> for the large majority of panels from the major manufacturers, including most Honeywell Vista, Lyric and ProSeries systems, as long as we can access programming and the panel can be fitted with a current communicator.</p>
<p><strong>It doesn't work</strong> when the panel is proprietary to the company that installed it and locked against anyone else, when the radio inside it is obsolete and no current communicator fits, or when the system is old enough that replacing it costs about the same as repairing it. If that's the situation we'll say so and quote a replacement, itemized, so you can decide.</p>

<h2>The steps, in order</h2>
<ol>
<li><strong>Check your current agreement.</strong> Find out when it ends and what notice it requires. We don't want you paying two companies for the same month.</li>
<li><strong>Site visit.</strong> The checks above, usually under an hour.</li>
<li><strong>Re-program.</strong> The panel is pointed at the central station and your account is built: your address, your call list, your password.</li>
<li><strong>Add a cellular path if needed.</strong> So the system keeps reporting when the internet or the power is out.</li>
<li><strong>Test every zone.</strong> We trip each sensor and confirm the signal arrives at the station with the right description.</li>
<li><strong>Set up the app.</strong> Arm, disarm and see history from your phone.</li>
<li><strong>Month-to-month begins.</strong> No long-term contract. If you'd like the annual discount, that's available too.</li>
</ol>

<h2>What changes for you</h2>
<p>The keypad looks the same. What's different is who calls when it goes off, and how. When a sensor trips, an operator at the central station follows a call sequence: the premises first, then your contacts, then dispatch if nobody can confirm it's a false alarm. If you add cameras, that operator can look at the event before deciding, which is the subject of our guide to <a href="/video-verified-alarms/">video-verified alarms</a>. And when you call us with a question, you're talking to the people who programmed your panel.</p>

<h2>A note for Honeywell owners</h2>
<p>If you have a Honeywell keypad and the system chirps every few hours, that is usually a low-battery or communication-failure warning, not a fault in the sensors. It's often the first sign that the old monitoring account has lapsed. We can sort out the warning and the monitoring in the same visit.</p>

<h2>Start with the panel you have</h2>
<p>Tell us the make and model, or just send a photo of the keypad through the <a href="/#quote">quote wizard</a>, and we'll tell you whether a take-over is realistic before anyone comes out. Or call <a href="tel:+13477780820">(347) 778-0820</a>.</p>
HTML
		),

		// ── F1 · video alarm verification ──────────────────────────────────
		array(
			'slug'      => 'video-verified-alarms',
			'title'     => 'Video-Verified Alarms: What Happens Between the Sensor and the 911 Call',
			'excerpt'   => 'An alarm signal is a claim. Verification is evidence. Here is the sequence a central-station operator follows, and what cameras change about it.',
			'category'  => 'Field notes',
			'date'      => '2026-08-20 09:00:00',
			'image'     => 'hw-4k-outdoor-camera.webp',
			'image_alt' => 'Outdoor security camera mounted on a brick wall',
			'content'   => <<<'HTML'
<p>When people picture an alarm, they picture the siren. The siren is the least important part. What matters is the chain of events that starts when a sensor trips and ends with someone deciding whether to send the police. Understanding that chain is the best way to decide whether video verification is worth adding to your system.</p>

<h2>The sequence without video</h2>
<ol>
<li><strong>A sensor trips.</strong> A door contact opens, a motion detector sees movement, a glass-break sensor hears the right frequency.</li>
<li><strong>The panel sends a signal.</strong> Every system we install reports over cellular, so this happens whether or not your internet is up. The signal carries the account and the zone: which sensor, in which room.</li>
<li><strong>An operator receives it.</strong> At a UL-listed central station on Long Island, staffed twenty-four hours a day.</li>
<li><strong>Verification by phone.</strong> The operator calls the premises, then the contacts on your call list, asking for the password. If someone answers and gives it, the event is closed as a false alarm.</li>
<li><strong>Dispatch.</strong> If no one can confirm, the operator requests police response and keeps working the call list so you know what's happening.</li>
</ol>
<p>The weak point is step four. At that moment the operator knows only that "Zone 4 tripped." They cannot tell the difference between a burglar and a cleaner who forgot the code, which is why the phone calls exist, and why false alarms are the subject of their <a href="/false-alarms-how-to-stop-them/">own guide</a>.</p>

<h2>What video changes</h2>
<p>With video verification, cameras are tied to the alarm zones. When a zone trips, the seconds around the event are sent to the central station along with the signal. The operator now sees the stockroom, or the front hall, or the fence line, before making any call.</p>
<p>That changes three things:</p>
<ul>
<li><strong>Fewer unnecessary dispatches.</strong> A cat on the counter or a curtain in front of an air vent gets closed without a phone call.</li>
<li><strong>Better information for the people who respond.</strong> "I am watching two people in the stockroom, one carrying a bag" is a very different call than "an alarm went off at this address." Some U.S. cities have gone as far as adopting verified-response policies, where police respond only to alarms that have been confirmed. Whatever the policy where you are, a verified event gives a dispatcher facts.</li>
<li><strong>A record.</strong> Every verified event leaves a time-stamped clip for you, your insurer and, if it comes to it, the police.</li>
</ul>

<h2>Two-way audio</h2>
<p>Verification-capable systems can include a speaker and microphone. When the operator sees someone who shouldn't be there, they can speak through it. In our experience an unexpected voice announcing that the site is being monitored and that police are being called ends most intrusions before anyone arrives. On construction sites and in warehouses this is often the single most useful feature of the whole system.</p>

<h2>What you see</h2>
<p>The same clips the operator sees arrive on your phone. The app shows the event, the clip and the station's actions in order, so if you're woken at 3 a.m. you know within a minute whether it was your teenager or a stranger.</p>

<h2>Privacy: who sees what</h2>
<p>In the systems we install, the central station receives event clips, not a live feed of your home or business. Your cameras record continuously to your own recorder or to cloud storage that you control; the operator sees the seconds around an alarm and nothing else.</p>

<h2>Where it makes the most difference</h2>
<ul>
<li><strong>Retail after hours.</strong> A motion sensor in a stockroom ten minutes after closing is almost always staff. Video settles it without a dispatch.</li>
<li><strong>Construction sites.</strong> Perimeter cameras with human-shape detection, so shadows and animals don't trigger, and a speaker to warn off anyone climbing the fence. See our guide to <a href="/construction-site-security-nyc/">construction site security in NYC</a>.</li>
<li><strong>Warehouses.</strong> Dock doors and high-bay spaces where motion alone is ambiguous.</li>
<li><strong>Homes.</strong> Entry cameras covering the front door, the garden-level door and the roof hatch, the three ways into most brownstones.</li>
</ul>

<h2>What it costs</h2>
<p>Video verification adds two lines to a quote: the cameras and recording, and a verification-capable monitoring tier. Like everything else we sell, both are itemized, so you can see exactly what the verification layer adds and decide zone by zone. It is often added to an existing alarm rather than installed with a new one.</p>

<h2>See it before you decide</h2>
<p>Our <a href="/services/video/">video-integrated alarm systems</a> page covers the equipment. If you'd rather talk it through, call <a href="tel:+13477780820">(347) 778-0820</a> or start with the <a href="/#quote">quote wizard</a>.</p>
HTML
		),

		// ── D2 · wireless alarm system for apartment ───────────────────────
		array(
			'slug'      => 'wireless-vs-wired-alarm-prewar-nyc',
			'title'     => 'Wireless vs. Wired Alarm Systems in Pre-War NYC Apartments and Brownstones',
			'excerpt'   => 'The building decides, not the brochure. Plaster on metal lath, masonry party walls, co-op rules and landmarked interiors all change the answer.',
			'category'  => 'Buyers guide',
			'date'      => '2026-08-27 09:00:00',
			'image'     => 'hw-door-window-contact.webp',
			'image_alt' => 'Wireless door and window contact on a white window frame',
			'content'   => <<<'HTML'
<p>Someone moving into a pre-war one-bedroom on the Upper West Side, or a parlor floor in Cobble Hill, has usually read three contradictory things about alarm systems by the time they call. Should it be wired, the kind their parents had with the keypad in the foyer? Or wireless, with sensors that stick to the molding?</p>
<p>Both work. Both can be done badly. The honest answer is that the building decides, and here is how we decide with it.</p>

<h2>First, what the words mean</h2>
<p>"Wired" and "wireless" describe how the <em>sensors</em> talk to the <em>panel</em>: over low-voltage cable, or over an encrypted radio link. They say nothing about how the panel talks to the outside world. Every system we install, wired or wireless, reports to the central station over cellular, so it keeps reporting when the internet or the power goes out. Don't let anyone sell you a "wired" system that depends on your router.</p>

<h2>What pre-war buildings do to a signal</h2>
<ul>
<li><strong>Plaster on metal lath.</strong> Many buildings from before the Second World War have plaster walls on a mesh of metal lath. Metal mesh attenuates radio. It doesn't block a modern sensor, but it means placement matters.</li>
<li><strong>Masonry party walls and thick floors.</strong> A brownstone is three or four floors of brick and joists. A panel in the basement talking to a sensor at the roof hatch is a long path.</li>
<li><strong>Armored (BX) cable and old chases.</strong> The existing electrical runs are often full, brittle, or both, which makes fishing new cable slow.</li>
<li><strong>Landmarked interiors and co-op rules.</strong> Many boards won't allow drilling through original woodwork, and some alteration agreements require the building's own electrician for any cable work.</li>
</ul>

<h2>When wireless wins</h2>
<ul>
<li>You rent, or you're in a co-op or condo where the board controls what touches the walls.</li>
<li>The interior is finished and you don't want it opened.</li>
<li>You want to add the system in phases: doors and windows now, the roof hatch and the garden level later.</li>
<li>The apartment is a typical size and shape, where a well-placed panel reaches everything.</li>
</ul>
<p>What we do about the radio problem: we place the panel for coverage rather than convenience, add a repeater where a floor is out of reach, and walk-test every single sensor from its final position before it's mounted. Wireless sensors run on batteries for years, and the panel reports a low battery to the central station well before the sensor stops working.</p>

<h2>When wired wins</h2>
<ul>
<li>The walls are open anyway: a gut renovation, a new kitchen, a top-floor addition.</li>
<li>A very large floor plate or an unusual layout where radio coverage would need several repeaters.</li>
<li>You want monitored smoke and carbon monoxide integrated into the same panel, which for a home we can do, and which often favors hardwiring.</li>
<li>A commercial space that needs commercial-grade zoning across a basement, sales floor and office.</li>
</ul>

<h2>Most brownstone jobs are hybrid</h2>
<p>In practice we wire what's easy to wire, usually the garden level and the basement where the panel lives and the ceilings are open, and go wireless on the parlor floor and above. Honeywell Resideo makes both: hardwired panels and wireless sensor lines that work on the same system, so a hybrid install is one panel, one app and one monitoring account.</p>

<h2>A short decision checklist</h2>
<ol>
<li>Do you own the walls? (If no: wireless.)</li>
<li>Are the walls open, or about to be? (If yes: wire what you can.)</li>
<li>How many floors, and where can the panel live?</li>
<li>Do you want monitored smoke and CO on the same system?</li>
<li>Will the system need to grow?</li>
</ol>
<p>Bring those answers to the site walk and the recommendation writes itself. Either way, the cost is itemized the same way; our guide to <a href="/alarm-system-cost-nyc/">what drives the cost of an alarm system in NYC</a> explains the four lines.</p>

<h2>See the building with us</h2>
<p>Our <a href="/services/residential/">residential alarm systems</a> page covers what we install in homes. To have someone look at your walls before you decide anything, start with the <a href="/#quote">quote wizard</a> or call <a href="tel:+13477780820">(347) 778-0820</a>.</p>
HTML
		),

		// ── A9 · false alarms ──────────────────────────────────────────────
		array(
			'slug'      => 'false-alarms-how-to-stop-them',
			'title'     => 'False Alarms: Why They Happen and How to Stop Them (NYC Edition)',
			'excerpt'   => 'Every false alarm costs you a 3 a.m. phone call, some credibility with the people who respond, and in some jurisdictions a fine. Most of them are preventable.',
			'category'  => 'Field notes',
			'date'      => '2026-09-01 09:00:00',
			'image'     => 'hw-indoor-motion-sensor.webp',
			'image_alt' => 'Indoor motion sensor mounted in a living room corner',
			'content'   => <<<'HTML'
<p>A false alarm is not free. It costs you a phone call from the central station, often in the middle of the night. It costs the people who respond, who learn over time which addresses cry wolf. And depending on where you are, it can cost money: a number of jurisdictions around the city fine repeat false alarms. The good news is that almost all of them come from a short list of causes, and the list is fixable.</p>

<h2>First, the rules where you are</h2>
<p>Alarm rules are set locally and they vary. Nassau County runs an alarm-permit program through its police department and fines repeated false alarms. Several Westchester municipalities, Rye and New Rochelle among them, have their own permit-and-fine ordinances. Inside the five boroughs, confirm the current NYPD requirements before you activate a monitored system; we'll walk you through whatever applies to your address as part of the install. Whatever the local rule, the practical goal is the same: the system should only call for help when help is needed.</p>

<h2>Where false alarms actually come from</h2>
<ol>
<li><strong>People.</strong> The biggest cause by far. Someone enters and can't find the code in time, a family member doesn't know the system is armed, a cleaner or contractor lets themselves in without a code.</li>
<li><strong>Pets and motion detectors.</strong> A motion sensor aimed at a sofa the dog sleeps on, or mounted low enough for a cat to walk past it.</li>
<li><strong>Doors that don't latch.</strong> A door that swings a quarter inch in a draft opens a contact. Old brownstone doors are the usual suspects.</li>
<li><strong>Things that move.</strong> Balloons, plants near a heating vent, a ceiling fan in the field of a motion sensor, a curtain in front of an air conditioner.</li>
<li><strong>Low batteries and dead communicators.</strong> A sensor with a dying battery can send trouble signals; a panel that has lost its cellular connection can't report properly at all.</li>
<li><strong>Glass-break sensors placed badly.</strong> Too close to a noisy street, or in a room where dropped dishes sound like breaking glass.</li>
<li><strong>Weather on outdoor devices.</strong> Rain, wind and headlights on an outdoor motion sensor with no human-shape detection.</li>
<li><strong>Renovations nobody told the station about.</strong> Workers, dust on sensors, and doors propped open for a week.</li>
</ol>

<h2>How verification stops a dispatch</h2>
<p>When a sensor trips, an operator at a UL-listed central station on Long Island doesn't send the police immediately. They call the premises, then your contact list, and ask for the password. If you or anyone on the list answers and confirms, the event is closed. With cameras tied to the alarm zones, the operator can also look at the seconds around the event before making any call at all; our guide to <a href="/video-verified-alarms/">video-verified alarms</a> covers that. Most false alarms are caught here. The ones that aren't are the ones where nobody answers the phone, which is why the call list matters as much as the sensors.</p>

<h2>The checklist we go through with every customer</h2>
<ul>
<li><strong>Everyone who enters has their own code.</strong> Family, staff, the dog walker, the super. Codes can be deleted the day they're no longer needed.</li>
<li><strong>Entry and exit delays that fit the building.</strong> Long enough to get from the door to the keypad with groceries, not so long that a burglar has a head start.</li>
<li><strong>Doors latch.</strong> If a door doesn't close on its own, fix the door before you add a sensor to it.</li>
<li><strong>Motion sensors are pet-immune and placed with the pet in mind.</strong> Pet-immune sensors ignore animals up to a certain size when mounted at the right height and angle. They are not magic if a large dog jumps on furniture in front of them.</li>
<li><strong>Nothing moves in front of a sensor.</strong> Walk the room with the heat on and the fan running.</li>
<li><strong>Test monthly.</strong> Put the account on test with the central station, trip a zone, confirm it arrived.</li>
<li><strong>Keep the call list current.</strong> A contact who moved to Florida is a false alarm waiting to happen.</li>
<li><strong>Tell the station about work on the property.</strong> A week of contractors is a week the system should be scheduled around.</li>
<li><strong>Answer the phone.</strong> Save the central station's number in every family member's phone so it isn't sent to voicemail as spam.</li>
</ul>

<h2>When it goes off by accident</h2>
<p>Disarm at the keypad. Answer the call from the central station and give your password. That's it: the event is cancelled and nobody is dispatched. If you don't answer, the operator has no way to know it was you.</p>

<h2>If your current system cries wolf</h2>
<p>A system that false-alarms every month is usually a placement or programming problem, not a reason to rip it out. We take over and re-tune existing systems as well as installing new ones; see <a href="/alarm-monitoring-existing-system/">alarm monitoring for an existing system</a>, or ask about our <a href="/services/monitoring/">monitoring service</a>. Call <a href="tel:+13477780820">(347) 778-0820</a> and a person will pick up.</p>
HTML
		),

		// ── E1 · construction site security ────────────────────────────────
		array(
			'slug'      => 'construction-site-security-nyc',
			'title'     => 'Construction Site Security in NYC: Chapter 33, Watchpersons, and Video Monitoring',
			'excerpt'   => 'What the Building Code requires after hours, where technology fits alongside the watchperson rule, and how a monitored site is put together from foundation to certificate of occupancy.',
			'category'  => 'Industry',
			'date'      => '2026-09-03 09:00:00',
			'image'     => 'scenario-brooklyn-construction-site.webp',
			'image_alt' => 'Tower cranes over a Brooklyn construction site at sunset',
			'content'   => <<<'HTML'
<p>A construction site loses in two ways after the crew goes home. It loses things: tools, copper, fixtures, sometimes equipment. And it takes on risk: anyone who climbs the fence and gets hurt on an open floor is a liability problem before they are a security problem. Insurance carriers know both, which is why site security in New York is as much about documentation as it is about deterrence.</p>
<p>This guide covers what the city requires, where a monitored alarm and camera system fits alongside those requirements, and how we build one that moves with the job.</p>

<h2>What the Building Code says about after-hours</h2>
<p>Chapter 33 of the New York City Building Code ("Safeguards During Construction or Demolition") sets the baseline. The parts that matter for security:</p>
<ul>
<li><strong>Watchperson requirement.</strong> Where a building being constructed or demolished has a footprint between 5,000 and 40,000 square feet, a competent watchperson must be on duty during all hours when operations are not in progress, from the time the foundation is poured until the work is finished and a certificate of occupancy is issued. Above 40,000 square feet, at least one additional watchperson is required for each additional 40,000 square feet or fraction of it.</li>
<li><strong>Who counts as a watchperson.</strong> Someone familiar with the Fire Department's emergency notification procedures, holding a valid New York State security guard registration and an FDNY watchperson certificate, with an OSHA-approved construction course of at least ten hours.</li>
<li><strong>Where technology reduces headcount.</strong> Where the footprint would require two or more watchpersons, the number may be reduced, subject to the Department of Buildings commissioner's approval, where a video monitoring system is in place (or the layout gives continuous line of sight across the whole building), at least one watchperson is still provided, and the building is being actively monitored under a fire safety and evacuation plan approved by the Fire Department.</li>
</ul>
<p>Two cautions. The code is amended periodically, so confirm the current text with your site safety manager or expediter before you plan staffing around it. And a monitored camera system is not a substitute for a required watchperson; it is what lets a large site apply for fewer of them, and what protects every site that falls below the threshold.</p>

<h2>Three situations, three roles for the system</h2>
<ol>
<li><strong>Sites below 5,000 square feet.</strong> No watchperson is required, so after-hours protection is the system, full stop: perimeter detection, verified alarms and a speaker.</li>
<li><strong>Sites that need two or more watchpersons.</strong> The system is the basis for a reduction application, and the record it keeps is what the commissioner is approving.</li>
<li><strong>Every site in between.</strong> One watchperson can't see a whole block. Cameras and sensors cover what a single person can't, and give them a second set of eyes at the central station.</li>
</ol>

<h2>How a monitored site is put together</h2>
<ul>
<li><strong>Perimeter first.</strong> Fence-line and gate sensors and cameras with human-shape detection, so shadows, animals and blowing debris don't trip the system every night.</li>
<li><strong>Power where there isn't any.</strong> Solar and battery-powered towers for lots with no temporary service yet.</li>
<li><strong>Cellular reporting.</strong> Sites rarely have reliable internet. Every system we install reports over cellular.</li>
<li><strong>Verification at the central station.</strong> When a zone trips, an operator at a UL-listed central station on Long Island looks at the clip before deciding anything. Read how that sequence works in our guide to <a href="/video-verified-alarms/">video-verified alarms</a>.</li>
<li><strong>Two-way audio.</strong> A voice from the tower telling someone on the fence that they're being watched and police are being called ends most incidents before anyone arrives.</li>
<li><strong>Notification to the GC.</strong> The super and the project manager get the clip and the station's actions by app, with a time stamp, so the incident report writes itself.</li>
<li><strong>Tool and equipment tracking.</strong> GPS trackers on the items that walk off most.</li>
<li><strong>Progress cameras.</strong> The same cameras that watch the site at night can produce a time-lapse of the build by day.</li>
</ul>

<h2>It has to move with the job</h2>
<p>A site's shape changes every month. Excavation and foundation work needs the whole lot covered from the fence. Once the superstructure goes up, the openings on each floor become the risk, and the towers move inward or up. When the building is enclosed and fit-out starts, the system starts looking like the one the finished building will have. We plan for that from the first visit: temporary equipment that can be repositioned, and a path to converting it into the permanent alarm and camera system at the certificate of occupancy, so the owner isn't paying for the same coverage twice.</p>

<h2>The checklist we walk with every GC</h2>
<ol>
<li>Footprint in square feet, and therefore the watchperson requirement.</li>
<li>Every entry point: gates, fence gaps, adjoining roofs and scaffolds.</li>
<li>Where the valuable material is stored, and whether it can be moved into one zone.</li>
<li>Power and cell coverage on the lot.</li>
<li>Who gets notified, in what order, and who can cancel an alarm.</li>
<li>What the insurer wants to see: coverage, recording retention, incident documentation.</li>
<li>The phases of the build and when the equipment moves.</li>
</ol>

<h2>Multi-site contractors</h2>
<p>If you run more than one job at a time, the system should be one account with every site visible on one screen, not a separate alarm at each address. That was the core of the work when Tower NY brought seven locations under one system; the details are in the <a href="/cases/tower-ny/">Tower NY case study</a>.</p>

<h2>Walk the lot with us</h2>
<p>Our <a href="/services/construction/">construction site alarm systems</a> page covers the equipment. For a site walk and an itemized proposal, start with the <a href="/#quote">quote wizard</a> or call <a href="tel:+13477780820">(347) 778-0820</a>. Licensed by the New York State Department of State, #12000314318.</p>
HTML
		),
	);
}
