// ─── Mobile carousel dots ──────────────────────────────────────────
// Adds a dot pagination indicator under any element that has been
// converted into a one-card-per-view horizontal pager on mobile.
//
// Runs only when viewport ≤ 720px. Watches for resize.
// ───────────────────────────────────────────────────────────────────
(function () {
  'use strict';

  const SELECTORS = [
    'section .container > .grid-3',
    'section .container > .grid-4',
    '.section-sunk .container > div.grid',
    'ul.services-list',
    '.blog-grid',
    '.case-grid',
  ];

  const isMobile = () => window.matchMedia('(max-width: 720px)').matches;

  function buildDots(carousel) {
    if (carousel.dataset.dotsAttached === '1') return;
    const items = Array.from(carousel.children).filter(c => c.nodeType === 1);
    if (items.length < 2) return;

    const dots = document.createElement('div');
    dots.className = 'carousel-dots';
    dots.setAttribute('aria-hidden', 'true');
    for (let i = 0; i < items.length; i++) {
      const d = document.createElement('button');
      d.type = 'button';
      d.className = 'carousel-dot';
      d.dataset.idx = i;
      if (i === 0) d.classList.add('on');
      d.addEventListener('click', () => {
        const target = items[i];
        carousel.scrollTo({ left: target.offsetLeft - carousel.offsetLeft, behavior: 'smooth' });
      });
      dots.appendChild(d);
    }
    // Insert after carousel
    carousel.parentNode.insertBefore(dots, carousel.nextSibling);
    carousel.dataset.dotsAttached = '1';
    carousel._dotsEl = dots;

    // Track scroll position → active dot
    let raf = null;
    carousel.addEventListener('scroll', () => {
      if (raf) return;
      raf = requestAnimationFrame(() => {
        raf = null;
        const center = carousel.scrollLeft + carousel.clientWidth / 2;
        let bestIdx = 0;
        let bestDist = Infinity;
        items.forEach((it, idx) => {
          const itCenter = it.offsetLeft - carousel.offsetLeft + it.offsetWidth / 2;
          const dist = Math.abs(itCenter - center);
          if (dist < bestDist) { bestDist = dist; bestIdx = idx; }
        });
        Array.from(dots.children).forEach((d, idx) => {
          d.classList.toggle('on', idx === bestIdx);
        });
      });
    }, { passive: true });
  }

  function teardown(carousel) {
    if (carousel._dotsEl && carousel._dotsEl.parentNode) {
      carousel._dotsEl.parentNode.removeChild(carousel._dotsEl);
    }
    carousel._dotsEl = null;
    delete carousel.dataset.dotsAttached;
  }

  function scan() {
    const mobile = isMobile();
    const all = new Set();
    SELECTORS.forEach(sel => {
      document.querySelectorAll(sel).forEach(el => all.add(el));
    });
    all.forEach(el => {
      if (mobile) buildDots(el);
      else teardown(el);
    });
  }

  // Run once DOM stable, then again after a short delay to catch React renders.
  function init() {
    scan();
    setTimeout(scan, 400);
    setTimeout(scan, 1200);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

  // Re-scan on resize (debounced)
  let rt = null;
  window.addEventListener('resize', () => {
    clearTimeout(rt);
    rt = setTimeout(scan, 200);
  });

  // Re-scan on hash/route changes
  window.addEventListener('hashchange', () => setTimeout(scan, 200));
})();
