/* NYAS quote wizard — 4-step lead form with live pricing.
 * Mirrors alarm-quote-questionnaire.html, adapted to theme + AJAX submit.
 */
(function () {
	'use strict';

	var PRICE = {
		BASE: 580,
		BASE_INCL_CONTACTS: 2,
		BASE_INCL_MOTIONS:  2,
		motion: 90,
		contact: 60,
		smoke: 180,
		glassbreak: 95,
		waterleak: 140,
		gate: 280,
		panic: 60,
		camera: 325,
		monthly_residential: 55,
		monthly_commercial:  65,
		monthly_per_camera:  21
	};

	function init(root) {
		if (!root || root._nyasQuoteInit) return;
		root._nyasQuoteInit = true;

		var state = {
			step: 1,
			propertyType: null,
			services: [],
			doors: 2, windows: 4, zones: 3, cameras: 4,
			extras: {},
			fname: '', lname: '', phone: '', email: ''
		};

		var totalSteps = root.querySelectorAll('.qz-step').length;

		// ── Property-type cards (single-select) ──
		root.querySelectorAll('[data-name="propertyType"] .qz-choice').forEach(function (btn) {
			btn.addEventListener('click', function () {
				root.querySelectorAll('[data-name="propertyType"] .qz-choice').forEach(function (other) {
					other.setAttribute('aria-pressed', 'false');
				});
				btn.setAttribute('aria-pressed', 'true');
				state.propertyType = btn.dataset.value;
				clearError('propertyType');
			});
		});

		// ── Services pills (multi-select) ──
		root.querySelectorAll('[data-name="services"] .qz-pill').forEach(function (btn) {
			btn.addEventListener('click', function () {
				var v = btn.dataset.value;
				var idx = state.services.indexOf(v);
				if (idx === -1) {
					state.services.push(v);
					btn.setAttribute('aria-pressed', 'true');
				} else {
					state.services.splice(idx, 1);
					btn.setAttribute('aria-pressed', 'false');
				}
				toggleConditionalGroups();
				clearError('services');
			});
		});

		// ── Counters ──
		root.querySelectorAll('[data-counter]').forEach(function (counter) {
			var name = counter.dataset.counter;
			var min = parseInt(counter.dataset.min, 10);
			var max = parseInt(counter.dataset.max, 10);
			var display = counter.querySelector('[data-display]');
			var dec = counter.querySelector('[data-action="dec"]');
			var inc = counter.querySelector('[data-action="inc"]');
			function refresh() {
				display.textContent = state[name];
				dec.disabled = state[name] <= min;
				inc.disabled = state[name] >= max;
			}
			dec.addEventListener('click', function () { if (state[name] > min) { state[name]--; refresh(); } });
			inc.addEventListener('click', function () { if (state[name] < max) { state[name]++; refresh(); } });
			refresh();
		});

		// ── Extras (toggle row + nested counter) ──
		root.querySelectorAll('.qz-extra-row').forEach(function (row) {
			var key = row.dataset.extra;
			var def = parseInt(row.dataset.default, 10) || 1;
			var toggle = row.querySelector('.qz-extra-toggle');
			var qty = row.querySelector('.qz-extra-qty');
			var display = qty.querySelector('[data-display]');
			var dec = qty.querySelector('[data-action="dec"]');
			var inc = qty.querySelector('[data-action="inc"]');

			function refresh() {
				if (state.extras[key] !== undefined) {
					display.textContent = state.extras[key];
					dec.disabled = state.extras[key] <= 1;
					inc.disabled = state.extras[key] >= 50;
				}
			}
			toggle.addEventListener('click', function () {
				if (state.extras[key] !== undefined) {
					delete state.extras[key];
					row.classList.remove('selected');
				} else {
					state.extras[key] = def;
					row.classList.add('selected');
					refresh();
				}
			});
			dec.addEventListener('click', function (e) {
				e.stopPropagation();
				if (state.extras[key] !== undefined && state.extras[key] > 1) {
					state.extras[key]--;
					refresh();
				}
			});
			inc.addEventListener('click', function (e) {
				e.stopPropagation();
				if (state.extras[key] !== undefined && state.extras[key] < 50) {
					state.extras[key]++;
					refresh();
				}
			});
		});

		function toggleConditionalGroups() {
			root.querySelectorAll('[data-show-when]').forEach(function (g) {
				var trigger = g.dataset.showWhen;
				if (state.services.indexOf(trigger) !== -1) {
					g.hidden = false;
				} else {
					g.hidden = true;
				}
			});
		}
		toggleConditionalGroups();

		// ── Contact inputs ──
		['fname', 'lname', 'phone', 'email'].forEach(function (k) {
			var el = root.querySelector('#qz-' + k);
			if (!el) return;
			el.addEventListener('input', function () {
				state[k] = el.value.trim();
				clearError(k);
			});
		});

		function clearError(key) {
			var el = root.querySelector('[data-error="' + key + '"]');
			if (el) el.classList.remove('show');
		}
		function showError(key) {
			var el = root.querySelector('[data-error="' + key + '"]');
			if (el) el.classList.add('show');
		}

		function validate(step) {
			if (step === 1) {
				if (!state.propertyType) { showError('propertyType'); return false; }
			}
			if (step === 2) {
				if (state.services.length === 0) { showError('services'); return false; }
			}
			if (step === 3) {
				var ok = true;
				if (!state.fname) { showError('fname'); ok = false; }
				if (!state.lname) { showError('lname'); ok = false; }
				if (!/^[\d\s\-+()]{7,}$/.test(state.phone)) { showError('phone'); ok = false; }
				if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(state.email)) { showError('email'); ok = false; }
				return ok;
			}
			return true;
		}

		// ── Pricing calc ──
		function calc() {
			var items = [];
			var total = PRICE.BASE;
			items.push({ label: 'Base system (panel + 2 contacts + 2 motions)', qty: 1, unit: PRICE.BASE, sub: PRICE.BASE });

			var hasBurglar = state.services.indexOf('Burglar') !== -1;
			var hasFire    = state.services.indexOf('Fire') !== -1;
			var hasVideo   = state.services.indexOf('Video') !== -1;

			if (hasBurglar) {
				var totalContacts = state.doors + state.windows;
				var extraContacts = Math.max(0, totalContacts - PRICE.BASE_INCL_CONTACTS);
				if (extraContacts > 0) {
					var sub = extraContacts * PRICE.contact;
					items.push({ label: 'Door / window contacts', qty: extraContacts, unit: PRICE.contact, sub: sub });
					total += sub;
				}
				var motionsNeeded = state.doors + Math.ceil(state.zones / 3);
				var extraMotions = Math.max(0, motionsNeeded - PRICE.BASE_INCL_MOTIONS);
				if (extraMotions > 0) {
					var msub = extraMotions * PRICE.motion;
					items.push({ label: 'Motion sensors', qty: extraMotions, unit: PRICE.motion, sub: msub });
					total += msub;
				}
			}
			if (hasFire && state.zones > 0) {
				var fsub = state.zones * PRICE.smoke;
				items.push({ label: 'Smoke / carbon sensors', qty: state.zones, unit: PRICE.smoke, sub: fsub });
				total += fsub;
			}
			if (hasVideo && state.cameras > 0) {
				var vsub = state.cameras * PRICE.camera;
				items.push({ label: 'Cameras', qty: state.cameras, unit: PRICE.camera, sub: vsub });
				total += vsub;
			}
			if (state.extras.glass) {
				var gsub = state.extras.glass * PRICE.glassbreak;
				items.push({ label: 'Glass-break sensors', qty: state.extras.glass, unit: PRICE.glassbreak, sub: gsub });
				total += gsub;
			}
			var gateCount = (state.extras.garage || 0) + (state.extras.gates || 0);
			if (gateCount > 0) {
				var gtsub = gateCount * PRICE.gate;
				items.push({ label: 'Gate sensors (garage / rolling)', qty: gateCount, unit: PRICE.gate, sub: gtsub });
				total += gtsub;
			}
			if (state.extras.boiler) {
				var bsub = state.extras.boiler * PRICE.waterleak;
				items.push({ label: 'Water-leak sensors', qty: state.extras.boiler, unit: PRICE.waterleak, sub: bsub });
				total += bsub;
			}
			if (state.extras.panic) {
				var psub = state.extras.panic * PRICE.panic;
				items.push({ label: 'Panic buttons', qty: state.extras.panic, unit: PRICE.panic, sub: psub });
				total += psub;
			}

			var low = total;
			var high = Math.round(total * 1.15 / 10) * 10;
			var monthly = state.propertyType === 'Residential' ? PRICE.monthly_residential : PRICE.monthly_commercial;
			if (hasVideo) monthly += state.cameras * PRICE.monthly_per_camera;

			return { items: items, low: low, high: high, monthly: monthly };
		}

		function renderQuote() {
			var q = calc();
			var greeting = root.querySelector('[data-greeting]');
			if (greeting) {
				greeting.textContent = state.fname ? "Here's your quote, " + state.fname : "Here's your quote";
			}
			root.querySelector('[data-range]').textContent = '$' + q.low.toLocaleString() + ' – $' + q.high.toLocaleString();
			root.querySelector('[data-monthly]').textContent = '+ monitoring from $' + q.monthly + '/month';

			var bd = root.querySelector('[data-breakdown]');
			var html = '<div class="qz-breakdown-title">Equipment breakdown</div>';
			q.items.forEach(function (it) {
				var qtyText = it.qty > 1 ? ' (' + it.qty + ' × $' + it.unit + ')' : '';
				html += '<div class="qz-breakdown-row"><span class="qz-breakdown-label">' + escapeHtml(it.label) + qtyText + '</span><span class="qz-breakdown-val">$' + it.sub.toLocaleString() + '</span></div>';
			});
			html += '<div class="qz-breakdown-row total"><span class="qz-breakdown-label">Equipment subtotal</span><span class="qz-breakdown-val">$' + q.low.toLocaleString() + '</span></div>';
			bd.innerHTML = html;
			return q;
		}

		function escapeHtml(s) {
			return String(s).replace(/[&<>"']/g, function (c) {
				return { '&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;' }[c];
			});
		}

		// ── Submit lead via admin-ajax ──
		function submitLead(quote) {
			var url = root.dataset.ajaxUrl;
			var nonce = root.dataset.nonce;
			if (!url || !nonce) return Promise.resolve();

			var fd = new FormData();
			fd.append('action', 'nyas_submit_lead');
			fd.append('_wpnonce', nonce);
			fd.append('payload', JSON.stringify({
				contact: { fname: state.fname, lname: state.lname, phone: state.phone, email: state.email },
				property: state.propertyType,
				services: state.services,
				counts: { doors: state.doors, windows: state.windows, zones: state.zones, cameras: state.cameras },
				extras: state.extras,
				quote: { low: quote.low, high: quote.high, monthly: quote.monthly, items: quote.items },
				url: window.location.href
			}));

			return fetch(url, { method: 'POST', body: fd, credentials: 'same-origin' })
				.then(function (r) { return r.json().catch(function () { return { success: false }; }); });
		}

		// ── Navigation ──
		var nextBtn = root.querySelector('[data-next]');
		var backBtn = root.querySelector('[data-back]');

		function goTo(n) {
			root.querySelectorAll('.qz-step').forEach(function (s) { s.classList.remove('active'); });
			var step = root.querySelector('[data-step="' + n + '"]');
			if (step) step.classList.add('active');
			state.step = n;

			root.querySelectorAll('.qz-progress-bar').forEach(function (b, i) {
				b.classList.remove('active', 'done');
				if (i + 1 < n) b.classList.add('done');
				else if (i + 1 === n) b.classList.add('active');
			});

			backBtn.hidden = (n <= 1 || n >= totalSteps);
			if (n === 3) {
				nextBtn.innerHTML = 'Get my quote <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>';
			} else if (n === 4) {
				nextBtn.innerHTML = 'Schedule consultation <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>';
			} else {
				nextBtn.innerHTML = 'Continue <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>';
			}

			// Scroll the wizard into view on mobile so the user sees the new step
			if (window.matchMedia('(max-width: 720px)').matches) {
				var y = root.getBoundingClientRect().top + window.scrollY - 16;
				window.scrollTo({ top: y, behavior: 'smooth' });
			}
		}

		nextBtn.addEventListener('click', function () {
			if (state.step === 4) {
				// "Schedule consultation" — scroll to or navigate
				var contact = document.querySelector('#cta-form, #contact');
				if (contact) {
					contact.scrollIntoView({ behavior: 'smooth', block: 'start' });
				} else {
					window.location.href = 'tel:' + (document.querySelector('a[href^="tel:"]') ? document.querySelector('a[href^="tel:"]').getAttribute('href').replace('tel:', '') : '');
				}
				return;
			}
			if (!validate(state.step)) return;

			if (state.step === 3) {
				// Step 3 → 4 transition: render quote first, then submit lead in background
				var q = renderQuote();
				root.classList.add('submitting');
				submitLead(q).finally(function () {
					root.classList.remove('submitting');
				});
				goTo(4);
				return;
			}

			goTo(state.step + 1);
		});

		backBtn.addEventListener('click', function () {
			if (state.step > 1) goTo(state.step - 1);
		});
	}

	function ready(fn) {
		if (document.readyState !== 'loading') fn();
		else document.addEventListener('DOMContentLoaded', fn);
	}

	ready(function () {
		document.querySelectorAll('[data-nyas-quote]').forEach(init);
	});
})();
