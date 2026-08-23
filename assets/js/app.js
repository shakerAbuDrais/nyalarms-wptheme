/* NYAS theme — front-end behaviour
 *
 * Modules:
 *   1. Mobile drawer (hamburger menu + body scroll lock)
 *   2. FAQ accordion (one-open-at-a-time)
 *   3. Scenario tabs
 *   4. Services preview switcher (homepage asymmetric grid)
 *   5. Filter chips (services/cases archives)
 *   6. Lead form fake submit (success card swap)
 *   7. Lead-form radio pills
 *   8. Smooth-scroll for in-page anchors with sticky-header offset
 */
(function () {
	'use strict';

	/* ── 1. Mobile drawer ───────────────────────────────────────── */
	function initDrawer() {
		const burger = document.querySelector('[data-nyas-burger]');
		const drawer = document.querySelector('[data-nyas-drawer]');
		const close  = document.querySelector('[data-nyas-drawer-close]');
		const header = document.querySelector('[data-nyas-header]');
		if (!burger || !drawer) return;
		// Skip if the inline failsafe in header.php already bound listeners.
		if (burger.dataset.nyasBound === '1') return;
		burger.dataset.nyasBound = '1';

		function setOpen(open) {
			drawer.classList.toggle('open', open);
			burger.setAttribute('aria-expanded', String(open));
			if (header) header.classList.toggle('menu-open', open);
			document.body.style.overflow = open ? 'hidden' : '';
		}

		burger.addEventListener('click', function () {
			setOpen(!drawer.classList.contains('open'));
		});
		if (close) close.addEventListener('click', function () { setOpen(false); });

		drawer.addEventListener('click', function (e) {
			if (e.target === drawer) setOpen(false);
		});

		// Close drawer when an in-drawer link is tapped.
		drawer.querySelectorAll('a').forEach(function (a) {
			a.addEventListener('click', function () { setOpen(false); });
		});

		// Esc closes drawer.
		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape' && drawer.classList.contains('open')) setOpen(false);
		});
	}

	/* ── 2. FAQ accordion ───────────────────────────────────────── */
	function initFAQ() {
		const root = document.querySelector('[data-nyas-faq]');
		if (!root) return;
		root.querySelectorAll('details').forEach(function (det) {
			det.addEventListener('toggle', function () {
				if (det.open) {
					root.querySelectorAll('details').forEach(function (other) {
						if (other !== det) other.removeAttribute('open');
					});
				}
				const toggle = det.querySelector('.nyas-faq-toggle svg');
				if (!toggle) return;
				// Swap plus/minus path inline (keeps Icon set in PHP).
				toggle.innerHTML = det.open
					? '<path d="M5 12h14"></path>'
					: '<path d="M12 5v14M5 12h14"></path>';
			});
			// Initialise icon state on load.
			const t = det.querySelector('.nyas-faq-toggle svg');
			if (t && det.open) t.innerHTML = '<path d="M5 12h14"></path>';
		});
	}

	/* ── 3. Scenario tabs ───────────────────────────────────────── */
	function initScenarios() {
		const root = document.querySelector('[data-nyas-scenarios]');
		if (!root) return;
		const tabs   = root.querySelectorAll('[data-scenario-tab]');
		const bodies = root.querySelectorAll('[data-scenario-body]');
		tabs.forEach(function (tab) {
			tab.addEventListener('click', function () {
				const key = tab.getAttribute('data-scenario-tab');
				tabs.forEach(function (t) {
					t.classList.toggle('on', t === tab);
					t.setAttribute('aria-selected', t === tab ? 'true' : 'false');
				});
				bodies.forEach(function (b) {
					const match = b.getAttribute('data-scenario-body') === key;
					b.style.display = match ? 'grid' : 'none';
				});
			});
		});
	}

	/* ── 4. Services preview switcher ───────────────────────────── */
	function initServicesPreview() {
		const root = document.querySelector('[data-nyas-services-preview]');
		if (!root) return;
		const tiles    = document.querySelectorAll('[data-services-tile]');
		const previews = root.querySelectorAll('[data-services-preview-id]');

		function show(id) {
			tiles.forEach(function (t) {
				t.classList.toggle('on', t.getAttribute('data-services-tile') === id);
			});
			previews.forEach(function (p) {
				p.hidden = p.getAttribute('data-services-preview-id') !== id;
			});
		}
		tiles.forEach(function (t) {
			t.addEventListener('mouseenter', function () { show(t.getAttribute('data-services-tile')); });
			t.addEventListener('focus',      function () { show(t.getAttribute('data-services-tile')); });
		});
	}

	/* ── 5. Filter chips (services/cases archives) ──────────────── */
	function initFilters() {
		document.querySelectorAll('[data-nyas-filter]').forEach(function (bar) {
			const grid    = document.querySelector('[data-nyas-filter-grid]');
			const counter = document.querySelector('[data-nyas-filter-count]');
			if (!grid) return;
			const chips = bar.querySelectorAll('[data-nyas-filter-cat]');
			chips.forEach(function (chip) {
				chip.addEventListener('click', function () {
					chips.forEach(function (c) { c.classList.remove('on'); });
					chip.classList.add('on');
					const cat = chip.getAttribute('data-nyas-filter-cat');
					let visible = 0;
					grid.querySelectorAll('[data-nyas-filter-item]').forEach(function (item) {
						const match = cat === 'All' || item.getAttribute('data-nyas-filter-item') === cat;
						item.style.display = match ? '' : 'none';
						if (match) visible++;
					});
					if (counter) counter.textContent = visible + ' services';
				});
			});
		});
	}

	/* ── 6. Lead form submit — stores a lead via admin-ajax ─────── */
	function initLeadForms() {
		document.querySelectorAll('[data-nyas-form]').forEach(function (form) {
			form.addEventListener('submit', function (e) {
				e.preventDefault();
				const nameEl  = form.querySelector('input[name="name"]');
				const phoneEl = form.querySelector('input[name="phone"]');
				const zipEl   = form.querySelector('input[name="zip"]');
				const typeEl  = form.querySelector('input[type="radio"]:checked');
				const name  = nameEl ? nameEl.value.trim() : '';
				const phone = phoneEl ? phoneEl.value.trim() : '';
				if (!name || !phone) {
					if (form.reportValidity) form.reportValidity();
					return;
				}
				const parts = name.split(/\s+/);
				const payload = {
					contact: { fname: parts.shift() || name, lname: parts.join(' '), phone: phone, email: '' },
					property: typeEl ? typeEl.value : 'General inquiry',
					services: [],
					counts: {},
					extras: {},
					zip: zipEl ? zipEl.value.trim() : '',
					quote: { low: 0, high: 0, monthly: 0, items: [] },
					url: window.location.href
				};

				function showSuccess() {
					const fields  = form.querySelector('.nyas-form-fields');
					const success = form.querySelector('.nyas-form-success');
					if (fields)  fields.hidden  = true;
					if (success) success.hidden = false;
				}

				const url   = form.getAttribute('data-ajax-url');
				const nonce = form.getAttribute('data-nonce');
				if (url && nonce && window.fetch) {
					const fd = new FormData();
					fd.append('action', 'nyas_submit_lead');
					fd.append('_wpnonce', nonce);
					fd.append('payload', JSON.stringify(payload));
					fetch(url, { method: 'POST', body: fd, credentials: 'same-origin' })
						.catch(function () { /* lead submit failed; success card already shown */ });
				}
				showSuccess();
			});
		});
	}

	/* ── 7. Radio pill groups (lead form Home / Business / Warehouse) ── */
	function initRadioPills() {
		document.querySelectorAll('[data-nyas-radio-group]').forEach(function (group) {
			const labels = group.querySelectorAll('label.radio-pill');
			labels.forEach(function (l) {
				const input = l.querySelector('input[type="radio"]');
				if (!input) return;
				input.addEventListener('change', function () {
					labels.forEach(function (other) { other.classList.remove('on'); });
					if (input.checked) l.classList.add('on');
				});
			});
		});
	}

	/* ── 9. Smooth-scroll for in-page anchors ───────────────────── */
	function initAnchors() {
		document.addEventListener('click', function (e) {
			const a = e.target.closest('a[href^="#"]');
			if (!a) return;
			const id = a.getAttribute('href');
			if (id.length < 2 || !document.querySelector(id)) return;
			const target = document.querySelector(id);
			if (!target) return;
			e.preventDefault();
			const header = document.querySelector('[data-nyas-header]');
			const offset = header ? header.offsetHeight + 12 : 80;
			window.scrollTo({
				top: target.getBoundingClientRect().top + window.scrollY - offset,
				behavior: 'smooth'
			});
		});
	}

	function init() {
		initDrawer();
		initFAQ();
		initScenarios();
		initServicesPreview();
		initFilters();
		initLeadForms();
		initRadioPills();
		initAnchors();
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}
})();
