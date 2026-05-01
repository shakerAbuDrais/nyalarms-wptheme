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
 *   8. Service quiz (find-my-fit)
 *   9. Smooth-scroll for in-page anchors with sticky-header offset
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

	/* ── 6. Lead form fake submit ───────────────────────────────── */
	function initLeadForms() {
		document.querySelectorAll('[data-nyas-form]').forEach(function (form) {
			form.addEventListener('submit', function (e) {
				e.preventDefault();
				const fields  = form.querySelector('.nyas-form-fields');
				const success = form.querySelector('.nyas-form-success');
				if (fields)  fields.hidden  = true;
				if (success) success.hidden = false;
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

	/* ── 8. Service quiz ────────────────────────────────────────── */
	function initQuiz() {
		const root = document.querySelector('[data-nyas-quiz]');
		const card = root && root.querySelector('[data-nyas-quiz-card]');
		if (!root || !card) return;

		let quiz, services;
		try {
			quiz     = JSON.parse(root.getAttribute('data-nyas-quiz-data'));
			services = JSON.parse(root.getAttribute('data-nyas-quiz-services'));
		} catch (e) {
			return;
		}

		const ICONS = {
			'home':'m3 10 9-7 9 7v11a2 2 0 0 1-2 2h-4v-7h-6v7H5a2 2 0 0 1-2-2z',
			'briefcase':'<rect x="2" y="7" width="20" height="14" rx="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>',
			'shop':'M3 7h18l-1 4a2 2 0 0 1-2 2 2 2 0 0 1-2-2 2 2 0 0 1-2 2 2 2 0 0 1-2-2 2 2 0 0 1-2 2 2 2 0 0 1-2-2 2 2 0 0 1-2 2 2 2 0 0 1-2-2zM4 13v8h16v-8M3 7l2-4h14l2 4',
			'warehouse':'<path d="M22 8.35V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V8.35a2 2 0 0 1 1.26-1.86l8-3.2a2 2 0 0 1 1.48 0l8 3.2A2 2 0 0 1 22 8.35Z"></path><path d="M6 18h12M6 14h12M6 10h12"></path>',
			'hardhat':'M2 18a1 1 0 0 0 1 1h18a1 1 0 0 0 1-1v-2a7 7 0 0 0-14 0M10 11V5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v6',
			'school':'m4 6 8-3 8 3M4 10v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8M9 22V12h6v10',
			'lock':'<rect x="3" y="11" width="18" height="11" rx="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path>',
			'fire':'M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z',
			'zap':'<polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>',
			'shield-check':'<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><path d="m9 12 2 2 4-4"></path>',
			'eye':'<path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"></path><circle cx="12" cy="12" r="3"></circle>',
			'pin':'<path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle>',
			'building':'<rect x="4" y="2" width="16" height="20" rx="2"></rect><path d="M9 22v-4h6v4M8 6h.01M16 6h.01M8 10h.01M16 10h.01M8 14h.01M16 14h.01"></path>',
			'video':'<rect x="2" y="6" width="14" height="12" rx="2"></rect><path d="m22 8-6 4 6 4z"></path>',
			'monitor':'<rect x="2" y="3" width="20" height="14" rx="2"></rect><path d="M8 21h8M12 17v4"></path>',
			'phone':'M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z',
			'arrow-right':'M5 12h14M12 5l7 7-7 7'
		};
		function svg(name, size) {
			size = size || 18;
			const path = ICONS[name] || ICONS['shield-check'];
			const inner = path.indexOf('<') === 0 ? path : '<path d="' + path + '"></path>';
			return '<svg width="' + size + '" height="' + size + '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' + inner + '</svg>';
		}

		let step = 0;
		const answers = {};
		const total = quiz.length;

		function renderQuestion() {
			const q = quiz[step];
			const pct = Math.round((step / total) * 100);
			let html = '';
			html += '<div class="quiz-progress-row"><span class="quiz-progress-label">Question ' + (step + 1) + ' of ' + total + '</span><span class="quiz-progress-pct">' + pct + '%</span></div>';
			html += '<div class="quiz-progress-bar"><div class="quiz-progress-fill" style="width:' + pct + '%"></div></div>';
			html += '<h3 class="quiz-q">' + escapeHtml(q.q) + '</h3>';
			html += '<p class="quiz-sub">' + escapeHtml(q.sub) + '</p>';
			html += '<div class="quiz-grid">';
			q.opts.forEach(function (opt) {
				const on = answers[step] && answers[step].v === opt.v;
				html += '<button type="button" class="quiz-opt' + (on ? ' on' : '') + '" data-quiz-opt="' + opt.v + '">';
				html += '<span class="quiz-opt-icon">' + svg(opt.icon, 20) + '</span>';
				html += '<span class="quiz-opt-label">' + escapeHtml(opt.label) + '</span>';
				html += '<span class="quiz-opt-check">' + svg('arrow-right', 14) + '</span>';
				html += '</button>';
			});
			html += '</div>';
			html += '<div class="quiz-foot">';
			html += '<button type="button" class="quiz-back"' + (step === 0 ? ' disabled' : '') + '>' + svg('arrow-right', 13) + ' Back</button>';
			html += '<span class="quiz-foot-hint">Click any answer to continue</span>';
			html += '</div>';
			card.innerHTML = html;

			card.querySelectorAll('[data-quiz-opt]').forEach(function (btn) {
				btn.addEventListener('click', function () {
					const v = btn.getAttribute('data-quiz-opt');
					const opt = q.opts.find(function (o) { return o.v === v; });
					answers[step] = opt;
					setTimeout(function () {
						step++;
						if (step >= total) renderResults();
						else renderQuestion();
						if (window.matchMedia('(max-width: 720px)').matches) {
							const y = card.getBoundingClientRect().top + window.scrollY - 24;
							window.scrollTo({ top: y, behavior: 'smooth' });
						}
					}, 200);
				});
			});

			const backBtn = card.querySelector('.quiz-back');
			if (backBtn) {
				const arrow = backBtn.querySelector('svg');
				if (arrow) arrow.style.transform = 'rotate(180deg)';
				backBtn.addEventListener('click', function () {
					if (step > 0) { step--; renderQuestion(); }
				});
			}
		}

		function renderResults() {
			const tally = {};
			Object.values(answers).forEach(function (opt) {
				(opt.tags || []).forEach(function (t) { tally[t] = (tally[t] || 0) + 1; });
			});
			const scored = services.map(function (s) {
				return Object.assign({}, s, { score: tally[s.id] || 0 });
			}).sort(function (a, b) { return b.score - a.score; });

			const top = scored.filter(function (s) { return s.score > 0; }).slice(0, 3);
			const filler = scored.filter(function (s) { return s.score === 0; }).slice(0, Math.max(0, 3 - top.length));
			const recommended = top.length ? top.concat(filler).slice(0, 3) : scored.slice(0, 3);

			let html = '<div class="quiz-results">';
			html += '<div class="eyebrow" style="color:var(--brand-signal-2);margin-bottom:12px">Your match</div>';
			html += '<h3 class="quiz-results-title">Based on your answers, here\'s what we\'d build:</h3>';
			html += '<div class="quiz-results-list">';
			recommended.forEach(function (s, i) {
				html += '<a class="quiz-result" href="' + s.url + '">';
				html += '<span class="quiz-result-rank">' + (i === 0 ? 'Best fit' : ('Also a fit · ' + (i + 1))) + '</span>';
				html += '<span class="quiz-result-name">' + escapeHtml(s.name) + '</span>';
				html += '<span class="quiz-result-desc">' + escapeHtml(s.desc) + '</span>';
				html += '<span class="quiz-result-arrow">' + svg('arrow-right', 16) + '</span>';
				html += '</a>';
			});
			html += '</div>';
			html += '<div class="quiz-results-cta">';
			html += '<a href="#quote" class="btn btn-md btn-signal">Get a quote on this build ' + svg('arrow-right', 14) + '</a>';
			html += '<button type="button" class="btn btn-md btn-ghost" data-quiz-reset>Start over</button>';
			html += '</div></div>';

			card.innerHTML = html;

			const resetBtn = card.querySelector('[data-quiz-reset]');
			if (resetBtn) {
				resetBtn.addEventListener('click', function () {
					step = 0;
					Object.keys(answers).forEach(function (k) { delete answers[k]; });
					renderQuestion();
				});
			}
		}

		function escapeHtml(s) {
			return String(s).replace(/[&<>"']/g, function (c) {
				return { '&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;' }[c];
			});
		}

		renderQuestion();
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
		initQuiz();
		initAnchors();
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}
})();
