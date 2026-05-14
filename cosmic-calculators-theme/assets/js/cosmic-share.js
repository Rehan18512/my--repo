/*!
 * Cosmic — 1080×1080 share-card generator (canvas-based)
 *
 * The existing plugins already provide their own share-card download. This
 * script offers an ALTERNATIVE Cosmic-branded share card that any plugin
 * can opt into by adding the attribute  data-cosmic-share  to a button
 * inside its result panel, e.g.:
 *
 *   <button class="lcp-share-btn" data-cosmic-share
 *           data-percent="87" data-tier="Soul Connection"
 *           data-a="Aanya" data-b="Rohan"
 *           data-quote="You don't have chemistry — you have continuity.">
 *     Share my love score
 *   </button>
 *
 * If a button is rendered without data-cosmic-share, the plugin's own
 * canvas exporter handles it — we never collide.
 *
 * Zero deps.
 */
(function () {
	'use strict';

	function $(sel, root) { return (root || document).querySelector(sel); }

	function loadFonts() {
		// Force-load the display + UI fonts before drawing so the canvas
		// doesn't fall back to system fonts during export.
		if (!document.fonts || !document.fonts.load) return Promise.resolve();
		return Promise.all([
			document.fonts.load('400 60px "Instrument Serif"'),
			document.fonts.load('600 18px "Geist"'),
			document.fonts.load('500 14px "JetBrains Mono"')
		]);
	}

	function render(opts) {
		var W = 1080, H = 1080;
		var c = document.createElement('canvas');
		c.width = W; c.height = H;
		var x = c.getContext('2d');

		// 1. Aurora gradient background
		var g = x.createLinearGradient(0, 0, W, H);
		g.addColorStop(0, '#ff3d8b');
		g.addColorStop(0.5, '#a855ff');
		g.addColorStop(1, '#22e0f5');
		x.fillStyle = g; x.fillRect(0, 0, W, H);

		// 2. Soft dot grid
		x.globalAlpha = 0.18; x.fillStyle = '#fff';
		for (var py = 30; py < H; py += 40) {
			for (var px = 30; px < W; px += 40) {
				x.beginPath(); x.arc(px, py, 2, 0, Math.PI * 2); x.fill();
			}
		}
		x.globalAlpha = 1;

		// 3. Logo + label (top-left / top-right)
		x.fillStyle = '#fff';
		x.font = '600 28px "Geist", system-ui, sans-serif';
		x.fillText('cosmic.', 80, 110);

		x.textAlign = 'right';
		x.font = '500 22px "JetBrains Mono", monospace';
		x.globalAlpha = 0.85;
		x.fillText('LOVE · READOUT', W - 80, 110);
		x.globalAlpha = 1;

		// 4. Couple line
		x.textAlign = 'left';
		x.font = '500 30px "JetBrains Mono", monospace';
		x.globalAlpha = 0.9;
		var couple = (opts.a || 'You') + ' × ' + (opts.b || 'Them');
		x.fillText(couple.toUpperCase(), 80, 580);
		x.globalAlpha = 1;

		// 5. Percentage — huge
		x.font = '400 360px "Instrument Serif", serif';
		x.fillText((opts.percent != null ? opts.percent : '87') + '%', 70, 800);

		// 6. Tier
		x.font = '400 64px "Instrument Serif", serif';
		x.fillText((opts.tier || 'Soul connection') + '.', 80, 870);

		// 7. Quote
		x.font = '400 28px "Geist", system-ui, sans-serif';
		x.globalAlpha = 0.9;
		wrap(x, '"' + (opts.quote || 'Written in the stars.') + '"', 80, 950, 920, 36);
		x.globalAlpha = 1;

		// 8. URL bottom-right
		x.textAlign = 'right';
		x.font = '500 22px "JetBrains Mono", monospace';
		x.globalAlpha = 0.75;
		x.fillText(opts.url || 'cosmiccalculators.in', W - 80, 1020);
		x.globalAlpha = 1;

		return c;
	}

	function wrap(x, text, cx, cy, maxW, lh) {
		var words = text.split(' '), line = '', y = cy;
		for (var i = 0; i < words.length; i++) {
			var test = line + words[i] + ' ';
			if (x.measureText(test).width > maxW && i > 0) {
				x.fillText(line, cx, y); line = words[i] + ' '; y += lh;
			} else { line = test; }
		}
		x.fillText(line, cx, y);
	}

	function download(canvas, name) {
		canvas.toBlob(function (blob) {
			if (!blob) return;
			var url = URL.createObjectURL(blob);
			var a = document.createElement('a');
			a.href = url; a.download = name + '.png';
			document.body.appendChild(a); a.click(); a.remove();
			setTimeout(function () { URL.revokeObjectURL(url); }, 1000);
		}, 'image/png', 0.95);
	}

	async function handle(e) {
		var btn = e.target.closest('[data-cosmic-share]');
		if (!btn) return;
		e.preventDefault();
		var orig = btn.textContent;
		btn.textContent = 'Generating…'; btn.disabled = true;
		try {
			await loadFonts();
			var opts = {
				percent: btn.dataset.percent,
				tier: btn.dataset.tier,
				a: btn.dataset.a,
				b: btn.dataset.b,
				quote: btn.dataset.quote,
				url: btn.dataset.url || (location.host + location.pathname),
			};
			var canvas = render(opts);
			var slug = ((opts.a || 'you') + '-' + (opts.b || 'them')).toLowerCase().replace(/[^a-z0-9]+/g, '-');
			download(canvas, 'cosmic-love-' + slug);
		} finally {
			btn.textContent = orig; btn.disabled = false;
		}
	}

	document.addEventListener('click', handle);

	// Expose for manual triggering from the calculator plugins if desired
	window.cosmicShare = { render: render, download: download };
})();
