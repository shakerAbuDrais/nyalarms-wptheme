/* NYAS — Leaflet coverage map (5 boroughs + 3 depots).
 * Mirrors NYMap from home.jsx.
 */
(function () {
	'use strict';

	function init() {
		const el = document.querySelector('[data-nyas-map]');
		if (!el || !window.L || el._mapInit) return;
		el._mapInit = true;

		const map = window.L.map(el, {
			center: [40.7308, -73.9973],
			zoom: 10,
			zoomControl: true,
			scrollWheelZoom: false,
			attributionControl: true
		});

		window.L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
			attribution: '&copy; OpenStreetMap, &copy; CARTO',
			subdomains: 'abcd',
			maxZoom: 19
		}).addTo(map);

		const cs = getComputedStyle(document.documentElement);
		const accent = (cs.getPropertyValue('--brand-signal-2') || '#1F4DD8').trim() || '#1F4DD8';

		const depots = [
			{ name: 'Long Island City depot', lat: 40.7448, lng: -73.9485, kind: 'HQ + Monitoring' },
			{ name: 'South Bronx depot',      lat: 40.8120, lng: -73.9220, kind: 'Field crews' },
			{ name: 'Sunset Park depot',      lat: 40.6470, lng: -74.0050, kind: 'Field crews' }
		];

		const boroughs = [
			{ name: 'Manhattan',     lat: 40.7831, lng: -73.9712 },
			{ name: 'Brooklyn',      lat: 40.6782, lng: -73.9442 },
			{ name: 'Queens',        lat: 40.7282, lng: -73.7949 },
			{ name: 'The Bronx',     lat: 40.8448, lng: -73.8648 },
			{ name: 'Staten Island', lat: 40.5795, lng: -74.1502 }
		];

		boroughs.forEach(function (b) {
			window.L.circleMarker([b.lat, b.lng], {
				radius: 9, color: accent, weight: 2,
				fillColor: accent, fillOpacity: 0.18
			}).addTo(map).bindTooltip(b.name, {
				permanent: true, direction: 'top', className: 'ny-map-label'
			});
		});

		depots.forEach(function (d) {
			const icon = window.L.divIcon({
				className: 'ny-depot-marker',
				html: '<div class="ny-depot-pin" style="--accent:' + accent + '"><span></span></div>',
				iconSize: [22, 22],
				iconAnchor: [11, 11]
			});
			window.L.marker([d.lat, d.lng], { icon: icon }).addTo(map)
				.bindPopup('<strong>' + d.name + '</strong><br/><span style="color:#475569;font-size:12px">' + d.kind + '</span>');
		});

		map.fitBounds([[40.50, -74.27], [40.92, -73.70]], { padding: [20, 20] });
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}
})();
