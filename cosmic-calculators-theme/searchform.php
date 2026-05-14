<?php
/**
 * Search form — `searchform.php`
 *
 * @package Cosmic_Calculators
 */
?>
<form role="search" method="get" class="cosmic-searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" style="display:flex;gap:10px;max-width:520px">
	<label class="screen-reader-text" for="cosmic-s"><?php esc_html_e( 'Search for:', 'cosmic-calculators' ); ?></label>
	<input id="cosmic-s" type="search" name="s" value="<?php echo esc_attr( get_search_query() ); ?>"
		placeholder="<?php esc_attr_e( 'Search the cosmos&hellip;', 'cosmic-calculators' ); ?>"
		style="flex:1;height:54px;padding:0 22px;background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.1);border-radius:999px;color:#fff;font-family:var(--cosmic-f-ui);font-size:16px">
	<button type="submit" class="cosmic-btn cosmic-btn--primary"><?php esc_html_e( 'Search', 'cosmic-calculators' ); ?></button>
</form>
