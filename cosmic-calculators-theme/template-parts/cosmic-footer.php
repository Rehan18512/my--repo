<?php
/**
 * Cosmic — Footer template part
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

$home = home_url( '/' );
?>
<footer class="cosmic-footer" role="contentinfo">
	<div class="cosmic-wide">
		<div class="cols">
			<div>
				<a class="cosmic-logo" href="<?php echo esc_url( $home ); ?>" style="font-size:32px"><svg viewBox="0 0 32 32" fill="none" aria-hidden="true">
					<defs><linearGradient id="cf-logo" x1="0" x2="1" y1="0" y2="1"><stop offset="0" stop-color="#ff3d8b"/><stop offset=".5" stop-color="#a855ff"/><stop offset="1" stop-color="#22e0f5"/></linearGradient></defs>
					<path d="M16 28 C 6 22 2 16 2 10 C 2 5 6 2 10 2 C 13 2 15 4 16 6 C 17 4 19 2 22 2 C 26 2 30 5 30 10 C 30 16 26 22 16 28 Z" fill="url(#cf-logo)"/>
					<circle cx="16" cy="13" r="2.6" fill="#fff" opacity=".95"/>
				</svg>cosmic<b>.</b></a>
				<p style="color:var(--cosmic-ink-60);font-size:14px;line-height:1.6;margin-top:18px;max-width:320px">
					Romantic, numerology &amp; viral relationship calculators &mdash; designed for the TikTok generation. 100% client-side. Nothing is sent to a server, ever.
				</p>
			</div>
			<div>
				<h4>Calculators</h4>
				<ul>
					<li><a href="<?php echo esc_url( $home . 'love-calculator/' ); ?>">Love Calculator</a></li>
					<li><a href="<?php echo esc_url( $home . 'flames-calculator/' ); ?>">FLAMES Calculator</a></li>
					<li><a href="<?php echo esc_url( $home . 'crush-calculator/' ); ?>">Crush Calculator</a></li>
					<li><a href="<?php echo esc_url( $home . 'friendship-calculator/' ); ?>">Friendship Calculator</a></li>
					<li><a href="<?php echo esc_url( $home . 'numerology-mulank/' ); ?>">Mulank Numerology</a></li>
				</ul>
			</div>
			<div>
				<h4>Explore</h4>
				<ul>
					<li><a href="<?php echo esc_url( $home . 'horoscope/' ); ?>">Daily Horoscope</a></li>
					<li><a href="<?php echo esc_url( $home . 'soulmate/' ); ?>">Soulmate Reading</a></li>
					<li><a href="<?php echo esc_url( $home . 'numerology/' ); ?>">Numerology Guide</a></li>
					<li><a href="<?php echo esc_url( $home . 'zodiac/' ); ?>">Zodiac Compatibility</a></li>
					<li><a href="<?php echo esc_url( $home . 'blog/' ); ?>">Blog</a></li>
				</ul>
			</div>
			<div>
				<h4>Company</h4>
				<ul>
					<li><a href="<?php echo esc_url( $home . 'about/' ); ?>">About us</a></li>
					<li><a href="<?php echo esc_url( $home . 'press/' ); ?>">Press kit</a></li>
					<li><a href="<?php echo esc_url( $home . 'privacy/' ); ?>">Privacy</a></li>
					<li><a href="<?php echo esc_url( $home . 'terms/' ); ?>">Terms</a></li>
					<li><a href="<?php echo esc_url( $home . 'contact/' ); ?>">Contact</a></li>
				</ul>
			</div>
		</div>
		<hr style="border:none;height:1px;background:linear-gradient(90deg,transparent,rgba(255,255,255,.12),transparent);margin:0">
		<p style="display:flex;justify-content:space-between;align-items:center;padding-top:24px;font-size:12px;color:var(--cosmic-ink-40);font-family:var(--cosmic-f-mono);margin:0;flex-wrap:wrap;gap:12px">
			<span>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php echo esc_html( strtoupper( get_bloginfo( 'name' ) ) ); ?> &middot; <?php esc_html_e( 'Made with', 'cosmic-calculators' ); ?> &hearts; <?php esc_html_e( 'in the cloud', 'cosmic-calculators' ); ?></span>
			<span>v<?php echo esc_html( defined( 'COSMIC_THEME_VERSION' ) ? COSMIC_THEME_VERSION : '1.0.0' ); ?> &middot; <?php esc_html_e( 'Built for the 2026 web', 'cosmic-calculators' ); ?></span>
		</p>

		<?php if ( has_nav_menu( 'footer' ) ) : ?>
		<nav class="cosmic-footer__bottomnav" aria-label="<?php esc_attr_e( 'Footer', 'cosmic-calculators' ); ?>" style="padding-top:18px">
			<?php
			wp_nav_menu( array(
				'theme_location' => 'footer',
				'container'      => false,
				'menu_class'     => 'cosmic-footer__menu',
				'fallback_cb'    => false,
				'depth'          => 1,
			) );
			?>
		</nav>
		<?php endif; ?>

		<?php if ( is_active_sidebar( 'cosmic-footer-widgets' ) ) : ?>
		<div class="cosmic-footer__widgets" style="padding-top:32px">
			<?php dynamic_sidebar( 'cosmic-footer-widgets' ); ?>
		</div>
		<?php endif; ?>
	</div>
</footer>

<?php /* Sticky mobile CTA — hidden until scroll past hero (JS toggles is-visible) */ ?>
<div class="cosmic-sticky-cta" aria-hidden="true">
	<a class="cosmic-btn cosmic-btn--primary" href="<?php echo esc_url( $home . 'love-calculator/' ); ?>">
		<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 21s-7-4.5-9.5-9C.9 9.2 2.6 5 6.5 5c2 0 3.6 1 5.5 3 1.9-2 3.5-3 5.5-3 3.9 0 5.6 4.2 4 7-2.5 4.5-9.5 9-9.5 9z"/></svg>
		<?php esc_html_e( 'Run my love test', 'cosmic-calculators' ); ?>
	</a>
</div>
