/*!
 * Cosmic — Site shell
 * - Sticky mobile CTA reveal
 * - Scroll-reveal IntersectionObserver
 * - Smooth-scroll for in-page anchors
 * - Active-section nav highlighting
 *
 * Zero deps. ~1.5 kB gzipped. Honors prefers-reduced-motion.
 */
(function () {
	'use strict';

	var reduce = matchMedia('(prefers-reduced-motion: reduce)').matches;

	/* ------------ Scroll reveal -------------- */
	if ('IntersectionObserver' in window) {
		var io = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				if (entry.isIntersecting) {
					entry.target.classList.add('is-visible');
					io.unobserve(entry.target);
				}
			});
		}, { rootMargin: '0px 0px -60px 0px', threshold: 0.1 });

		document.querySelectorAll('[data-cosmic-reveal]').forEach(function (el) { io.observe(el); });
	} else {
		document.querySelectorAll('[data-cosmic-reveal]').forEach(function (el) { el.classList.add('is-visible'); });
	}

	/* ------------ Sticky mobile CTA -------------- */
	var sticky = document.querySelector('.cosmic-sticky-cta');
	if (sticky) {
		var hero = document.querySelector('.cosmic-hero');
		var threshold = hero ? hero.offsetTop + hero.offsetHeight * 0.6 : 400;
		var last = 0, ticking = false;
		function update() {
			var y = window.scrollY;
			sticky.classList.toggle('is-visible', y > threshold);
			ticking = false; last = y;
		}
		window.addEventListener('scroll', function () {
			if (!ticking) { requestAnimationFrame(update); ticking = true; }
		}, { passive: true });
		update();
	}

	/* ------------ Smooth anchor scroll -------------- */
	document.addEventListener('click', function (e) {
		var link = e.target.closest('a[href^="#"]:not([href="#"])');
		if (!link) return;
		var id = link.getAttribute('href').slice(1);
		var target = document.getElementById(id);
		if (!target) return;
		e.preventDefault();
		target.scrollIntoView({ behavior: reduce ? 'auto' : 'smooth', block: 'start' });
		history.replaceState(null, '', '#' + id);
	});

	/* ------------ Active nav link by scroll -------------- */
	var navLinks = document.querySelectorAll('.cosmic-navlinks a[href^="#"]');
	if (navLinks.length && 'IntersectionObserver' in window) {
		var sectionMap = {};
		navLinks.forEach(function (a) {
			var id = a.getAttribute('href').slice(1);
			var sec = document.getElementById(id);
			if (sec) sectionMap[id] = a;
		});
		var navObs = new IntersectionObserver(function (entries) {
			entries.forEach(function (e) {
				if (e.isIntersecting) {
					navLinks.forEach(function (a) { a.classList.remove('is-active'); });
					var a = sectionMap[e.target.id];
					if (a) a.classList.add('is-active');
				}
			});
		}, { rootMargin: '-40% 0px -50% 0px' });
		Object.keys(sectionMap).forEach(function (id) {
			var s = document.getElementById(id);
			if (s) navObs.observe(s);
		});
	}

	/* ------------ Mobile menu toggle -------------- */
	var toggle = document.querySelector('.cosmic-nav-toggle');
	var menu   = document.getElementById('cosmic-primary-menu');
	if (toggle && menu) {
		toggle.addEventListener('click', function () {
			var open = toggle.getAttribute('aria-expanded') === 'true';
			toggle.setAttribute('aria-expanded', open ? 'false' : 'true');
			menu.classList.toggle('is-open', !open);
		});
		// Close on link click (mobile UX)
		menu.addEventListener('click', function (e) {
			if (e.target.closest('a')) {
				toggle.setAttribute('aria-expanded', 'false');
				menu.classList.remove('is-open');
			}
		});
		// Close on escape
		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape' && menu.classList.contains('is-open')) {
				toggle.setAttribute('aria-expanded', 'false');
				menu.classList.remove('is-open');
				toggle.focus();
			}
		});
	}
})();
