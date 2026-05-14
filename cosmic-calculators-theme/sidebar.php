<?php
/**
 * Sidebar — `sidebar.php`
 *
 * The Cosmic theme is single-column by design; this sidebar is here
 * to satisfy themes that explicitly call `get_sidebar()` (e.g. third
 * party blog templates). It exposes the "Footer Widgets" area for
 * convenience.
 *
 * @package Cosmic_Calculators
 */
if ( ! is_active_sidebar( 'cosmic-footer-widgets' ) ) {
	return;
}
?>
<aside class="cosmic-sidebar cosmic-glass" style="padding:24px;border-radius:20px;margin:30px 0">
	<?php dynamic_sidebar( 'cosmic-footer-widgets' ); ?>
</aside>
