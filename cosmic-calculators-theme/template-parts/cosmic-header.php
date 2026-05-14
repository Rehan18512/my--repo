<?php
/**
 * Cosmic — Site header template part
 *
 * Loaded by header.php. Renders the cosmic decorative background layer
 * plus the sticky pill-style nav. If the site admin has assigned a
 * "Primary" menu via Appearance > Menus, we render that — otherwise
 * we fall back to the built-in default that links to the calculator
 * pages (works on a fresh install with zero configuration).
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$home_url = home_url( '/' );
?>
<a class="cosmic-skip-link screen-reader-text" href="#cosmic-content"><?php esc_html_e( 'Skip to content', 'cosmic-calculators' ); ?></a>

<div class="cosmic-bg" aria-hidden="true"></div>

<header class="cosmic-nav" role="banner">
	<?php if ( has_custom_logo() ) : ?>
		<div class="cosmic-logo cosmic-logo--custom"><?php the_custom_logo(); ?></div>
	<?php else : ?>
		<a class="cosmic-logo" href="<?php echo esc_url( $home_url ); ?>" aria-label="<?php bloginfo( 'name' ); ?>">
			<svg viewBox="0 0 32 32" fill="none" aria-hidden="true">
				<defs>
					<linearGradient id="cosmic-logo-grad" x1="0" x2="1" y1="0" y2="1">
						<stop offset="0" stop-color="#ff3d8b"/><stop offset=".5" stop-color="#a855ff"/><stop offset="1" stop-color="#22e0f5"/>
					</linearGradient>
				</defs>
				<path d="M16 28 C 6 22 2 16 2 10 C 2 5 6 2 10 2 C 13 2 15 4 16 6 C 17 4 19 2 22 2 C 26 2 30 5 30 10 C 30 16 26 22 16 28 Z" fill="url(#cosmic-logo-grad)"/>
				<circle cx="16" cy="13" r="2.6" fill="#fff" opacity=".95"/>
			</svg>
			<?php bloginfo( 'name' ); ?><b>.</b>
		</a>
	<?php endif; ?>

	<button class="cosmic-nav-toggle" aria-expanded="false" aria-controls="cosmic-primary-menu" aria-label="<?php esc_attr_e( 'Toggle navigation', 'cosmic-calculators' ); ?>">
		<span aria-hidden="true"></span><span aria-hidden="true"></span><span aria-hidden="true"></span>
	</button>

	<nav class="cosmic-navlinks" id="cosmic-primary-menu" aria-label="<?php esc_attr_e( 'Primary', 'cosmic-calculators' ); ?>">
		<?php
		if ( has_nav_menu( 'primary' ) ) {
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => 'cosmic-menu',
				'fallback_cb'    => false,
				'depth'          => 1,
				'items_wrap'     => '%3$s',
			) );
		} else {
			$current = '';
			if ( is_page() )           { $current = sanitize_key( get_post_field( 'post_name' ) ); }
			elseif ( is_home() )       { $current = 'blog'; }
			elseif ( is_front_page() ) { $current = 'home'; }
			?>
			<a href="<?php echo esc_url( $home_url ); ?>"                            <?php echo $current === 'home'                  ? 'aria-current="page"' : ''; ?>><?php esc_html_e( 'Home', 'cosmic-calculators' ); ?></a>
			<a href="<?php echo esc_url( $home_url . 'love-calculator/' ); ?>"       <?php echo $current === 'love-calculator'       ? 'aria-current="page"' : ''; ?>><?php esc_html_e( 'Love', 'cosmic-calculators' ); ?></a>
			<a href="<?php echo esc_url( $home_url . 'flames-calculator/' ); ?>"     <?php echo $current === 'flames-calculator'     ? 'aria-current="page"' : ''; ?>><?php esc_html_e( 'FLAMES', 'cosmic-calculators' ); ?></a>
			<a href="<?php echo esc_url( $home_url . 'crush-calculator/' ); ?>"      <?php echo $current === 'crush-calculator'      ? 'aria-current="page"' : ''; ?>><?php esc_html_e( 'Crush', 'cosmic-calculators' ); ?></a>
			<a href="<?php echo esc_url( $home_url . 'friendship-calculator/' ); ?>" <?php echo $current === 'friendship-calculator' ? 'aria-current="page"' : ''; ?>><?php esc_html_e( 'Friendship', 'cosmic-calculators' ); ?></a>
			<a href="<?php echo esc_url( $home_url . 'numerology-mulank/' ); ?>"     <?php echo $current === 'numerology-mulank'     ? 'aria-current="page"' : ''; ?>><?php esc_html_e( 'Mulank', 'cosmic-calculators' ); ?></a>
			<a href="<?php echo esc_url( $home_url . 'blog/' ); ?>"                  <?php echo $current === 'blog'                  ? 'aria-current="page"' : ''; ?>><?php esc_html_e( 'Blog', 'cosmic-calculators' ); ?></a>
			<?php
		}
		?>
	</nav>

	<div class="cosmic-nav__cta">
		<span class="cosmic-chip" aria-hidden="true">
			<span style="width:6px;height:6px;border-radius:50%;background:#4ade80;box-shadow:0 0 8px #4ade80"></span>
			<span data-cosmic-count="12840" data-suffix=" online">12,840 online</span>
		</span>
		<a class="cosmic-btn cosmic-btn--primary" href="<?php echo esc_url( $home_url . 'love-calculator/' ); ?>">
			<?php esc_html_e( 'Try love test', 'cosmic-calculators' ); ?>
			<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 5l7 7-7 7"/></svg>
		</a>
	</div>
</header>
