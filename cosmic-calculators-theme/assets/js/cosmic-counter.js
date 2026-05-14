/*!
 * Cosmic — Animated number counter
 * - Drives [data-cosmic-count="87"] elements with an easing count-up
 * - Hooks into the calculator plugins:  whenever .lcp-percent /
 *   .fcp-percent / .fc-percent / .cc-percent appears in the DOM with
 *   a numeric text content, we animate the count from 0 → that value.
 * - MutationObserver-based — no plugin code change required.
 *
 * Zero deps. Honors prefers-reduced-motion.
 */
(function () {
	'use strict';

	var reduce = matchMedia('(prefers-reduced-motion: reduce)').matches;

	function easeOutCubic(t) { return 1 - Math.pow(1 - t, 3); }

	function animate(el, to, opts) {
		opts = opts || {};
		var dur = opts.duration || 1400;
		var from = opts.from || 0;
		var suffix = opts.suffix != null ? opts.suffix : (el.dataset.suffix || '%');
		if (reduce) { el.textContent = to + suffix; return; }
		var t0 = performance.now();
		function tick(now) {
			var t = Math.min(1, (now - t0) / dur);
			var v = from + (to - from) * easeOutCubic(t);
			el.textContent = Math.round(v) + suffix;
			if (t < 1) requestAnimationFrame(tick);
		}
		requestAnimationFrame(tick);
	}

	// 1. Manual hooks: anything with [data-cosmic-count]
	if ('IntersectionObserver' in window) {
		var io = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				if (!entry.isIntersecting) return;
				var el = entry.target;
				var to = parseFloat(el.dataset.cosmicCount);
				if (!isNaN(to)) animate(el, to);
				io.unobserve(el);
			});
		}, { threshold: 0.4 });
		document.querySelectorAll('[data-cosmic-count]').forEach(function (el) { io.observe(el); });
	}

	// 2. Plugin hook — observe percentage elements as they're inserted/updated
	var PLUGIN_PERCENT_SELECTORS = ['.lcp-percent', '.fcp-percent', '.fc-percent', '.cc-percent'];
	var seen = new WeakSet();

	function bindPercent(el) {
		if (!el || seen.has(el)) return;
		seen.add(el);
		var raw = (el.textContent || '').trim();
		var match = raw.match(/(-?\d+(?:\.\d+)?)/);
		if (!match) return;
		var target = parseFloat(match[1]);
		// Reset DOM to 0% to begin animation
		el.dataset.cosmicTarget = target;
		animate(el, target, { duration: 1600, suffix: '%' });
	}

	// Initial pass
	PLUGIN_PERCENT_SELECTORS.forEach(function (sel) {
		document.querySelectorAll(sel).forEach(bindPercent);
	});

	// Observe future mutations — calculator reveals result on submit
	var mo = new MutationObserver(function (mutations) {
		mutations.forEach(function (m) {
			m.addedNodes && m.addedNodes.forEach(function (n) {
				if (n.nodeType !== 1) return;
				PLUGIN_PERCENT_SELECTORS.forEach(function (sel) {
					if (n.matches && n.matches(sel)) bindPercent(n);
					if (n.querySelectorAll) n.querySelectorAll(sel).forEach(bindPercent);
				});
			});
			// Also catch text-content updates to the same node
			if (m.type === 'characterData' && m.target.parentElement) {
				var p = m.target.parentElement;
				PLUGIN_PERCENT_SELECTORS.forEach(function (sel) {
					if (p.matches(sel)) {
						seen.delete(p);
						bindPercent(p);
					}
				});
			}
		});
	});
	mo.observe(document.body, { childList: true, subtree: true, characterData: true });
})();
