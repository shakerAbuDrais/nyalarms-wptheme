/* NYAS homepage v2 — interactivity for the new sections.
 *
 * Modules:
 *   1. Hardware showcase — hover/focus a rail row to swap the featured product
 *   2. Reviews carousel — arrow buttons + dots track the scroll position
 */
(function () {
	'use strict';

	/* ── 1. Hardware showcase ─────────────────────────────── */
	function initHardware() {
		var root = document.querySelector('[data-nyas-hardware]');
		if (!root) return;
		var rows    = root.querySelectorAll('[data-hw-row]');
		var img     = root.querySelector('[data-hw-feature-img]');
		var code    = root.querySelector('[data-hw-feature-code]');
		var name    = root.querySelector('[data-hw-feature-name]');
		var spec    = root.querySelector('[data-hw-feature-spec]');
		if (!rows.length || !img) return;

		function activate(row) {
			rows.forEach(function (r) { r.classList.remove('on'); });
			row.classList.add('on');
			var src = row.getAttribute('data-hw-img');
			if (src) img.style.backgroundImage = 'url(' + src + ')';
			if (code) code.textContent = row.getAttribute('data-hw-code') || '';
			if (name) name.textContent = row.getAttribute('data-hw-name') || '';
			if (spec) spec.textContent = row.getAttribute('data-hw-spec') || '';
		}

		rows.forEach(function (row) {
			row.addEventListener('mouseenter', function () { activate(row); });
			row.addEventListener('focus', function () { activate(row); });
		});
	}

	/* ── 2. Reviews carousel ──────────────────────────────── */
	function initReviews() {
		document.querySelectorAll('[data-nyas-reviews]').forEach(function (root) {
			var track = root.querySelector('[data-reviews-track]');
			var prev  = root.querySelector('[data-reviews-prev]');
			var next  = root.querySelector('[data-reviews-next]');
			var dots  = root.querySelectorAll('[data-reviews-dot]');
			if (!track) return;
			var cards = Array.prototype.slice.call(track.children).filter(function (c) { return c.nodeType === 1; });
			if (cards.length < 2) return;
			var idx = 0;

			function scrollToIdx(i) {
				var clamped = Math.max(0, Math.min(cards.length - 1, i));
				var card = cards[clamped];
				if (!card) return;
				track.scrollTo({ left: card.offsetLeft - track.offsetLeft, behavior: 'smooth' });
				idx = clamped;
				updateChrome();
			}

			function updateChrome() {
				if (prev) prev.disabled = idx === 0;
				if (next) next.disabled = idx === cards.length - 1;
				dots.forEach(function (d, i) { d.classList.toggle('on', i === idx); });
			}

			if (prev) prev.addEventListener('click', function () { scrollToIdx(idx - 1); });
			if (next) next.addEventListener('click', function () { scrollToIdx(idx + 1); });
			dots.forEach(function (d, i) {
				d.addEventListener('click', function () { scrollToIdx(i); });
			});

			var raf = null;
			track.addEventListener('scroll', function () {
				if (raf) return;
				raf = requestAnimationFrame(function () {
					raf = null;
					var center = track.scrollLeft + track.clientWidth / 2;
					var best = 0, bestD = Infinity;
					cards.forEach(function (c, i) {
						var cc = c.offsetLeft - track.offsetLeft + c.offsetWidth / 2;
						var d = Math.abs(cc - center);
						if (d < bestD) { bestD = d; best = i; }
					});
					if (best !== idx) {
						idx = best;
						updateChrome();
					}
				});
			}, { passive: true });

			updateChrome();
		});
	}

	function init() {
		initHardware();
		initReviews();
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}
})();
