=== New York Alarm Systems ===
Contributors: nyas
Requires at least: 6.0
Tested up to: 6.5
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPL v2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A marketing theme for newyorkalarmsystems.com — a five-borough alarm and 24/7
monitoring service. Ports the Claude Design HTML/CSS/JS prototypes
(home, about, services, services archive, single service, cases, single case,
blog, single post) to WordPress page templates.

== Setup ==

Once activated, finish wiring up the site:

1. Settings → Reading
   - "Your homepage displays" → A static page
   - "Homepage" → create a page called "Home" (any template; front-page.php
     bypasses the page template)
   - "Posts page" → create a page called "Insights" (or "Blog")

2. Pages → Add New (one for each), then under "Page Attributes → Template":
   - "About"               → Template: About
   - "Services"            → Template: Services Archive
   - "Case studies"        → Template: Case Studies Archive
   - For each individual service (e.g. "Residential"), create a child page of
     "Services" with the matching slug (residential, commercial, warehouse,
     construction, retail, office, school, medical, monitoring, video) and
     Template: Single Service.
   - For each case study (e.g. "Maman"), create a child page of "Case studies"
     with the matching slug and Template: Single Case Study.

3. Appearance → Menus
   - Create a menu, assign to "Primary Navigation" (5 items: Home, Services,
     Case studies, Insights, About).
   - Optional: assign menus to "Footer — Shop", "Footer — Industry",
     "Footer — Company".

4. Appearance → Customize → "NYAS — Company info"
   - Phone, address, license badge, dispatch email, top bar toggle.

5. Optional: install posts under "Insights" with a featured image; the blog
   index uses the first post as the editorial hero.

== Content data ==

The hard-coded design content (services, case studies, testimonials,
seed posts) lives in `inc/data.php` so every template renders from the same
source. Replace these arrays with custom-post-type queries when content
moves into WP — the array shape doubles as a contract.

== Files ==

- style.css                        Theme header.
- functions.php                    Theme bootstrap, enqueue, helpers.
- inc/icons.php                    Inline SVG icon set (Lucide-style).
- inc/template-helpers.php         Eyebrow, photo, breadcrumb, lead form,
                                   topbar, final-CTA renderers.
- inc/customizer.php               Phone / address / license customizer.
- inc/data.php                     Static design content.
- header.php / footer.php          Shared shell + mobile drawer.
- front-page.php                   Homepage (15 sections incl. Leaflet map).
- home.php                         Blog index.
- single.php                       Blog post.
- page.php                         Generic page.
- archive.php / search.php /
  index.php / 404.php              Standard fallbacks.
- comments.php                     Comments template.
- page-templates/
    page-about.php                 About page.
    page-services.php              Services archive (filterable).
    page-cases.php                 Case studies archive (filterable).
    page-service.php               Single service.
    page-case.php                  Single case study.
- template-parts/
    section-quiz.php               Find-my-fit quiz (interactive).
    section-scenarios.php          Tabbed scenario explainer.
    section-faq.php                One-open-at-a-time FAQ accordion.
- assets/css/
    tokens.css                     Design tokens (colors, type, spacing).
    app.css                        Component styles.
    responsive.css                 Mobile breakpoints + drawer.
    nyas.css                       WP-specific overrides (menu walker,
                                   prose, comments, alignments).
- assets/js/
    app.js                         All theme behaviour (drawer, FAQ,
                                   scenarios, services preview, filters,
                                   lead-form fake-submit, quiz,
                                   smooth-scroll).
    map.js                         Leaflet coverage map (5 boroughs,
                                   3 depots; homepage only).
    carousel-dots.js               Carousel pagination (from design bundle).

== Credits ==

Design system © Claude Design handoff. Photography placeholders
courtesy of Unsplash (replace with licensed assets in production).
Fonts: Manrope, Inter, JetBrains Mono via Google Fonts.
Map tiles: CARTO + OpenStreetMap.
Icons: hand-rolled inline SVG (Lucide-named).
