<?php
/**
 * Plugin Name: Love Calculator Pro
 * Plugin URI:  https://example.com/love-calculator-pro
 * Description: Premium Love Calculator with unique 2026 light-romantic UI, heart-shaped percentage meter, 5-dimensional compatibility radar, golden hints / pro tips / life lessons per love tier, advanced numerology + zodiac mode, bilingual EN/HI, AdSense & Premium ready. Use shortcode [love_calculator_pro].
 * Version:     2.0.0
 * Author:      Love Calculator Pro
 * License:     GPL-2.0+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: love-calculator-pro
 * Requires at least: 5.0
 * Requires PHP: 7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'LCP_VERSION' ) ) {
	define( 'LCP_VERSION', '2.0.0' );
}
if ( ! defined( 'LCP_OPTION' ) ) {
	define( 'LCP_OPTION', 'lcp_settings' );
}

/* ---------------------------------------------------------------------------
 * Defaults / Activation
 * ------------------------------------------------------------------------- */

if ( ! function_exists( 'lcp_default_settings' ) ) {
	function lcp_default_settings() {
		return array(
			'default_mode'    => 'basic',
			'default_lang'    => 'en',
			'theme_skin'      => 'rose',
			'sound_default'   => 1,
			'haptics_default' => 1,
			'show_history'    => 1,
			'show_share'      => 1,
			'show_premium'    => 0,
			'premium_url'     => '',
			'premium_label'   => 'Get Premium',
			'ad_slot_top'     => '',
			'ad_slot_middle'  => '',
			'ad_slot_bottom'  => '',
			'show_advanced_toggle' => 1,
			'show_lang_toggle'     => 1,
			'show_gender'          => 1,
			'show_status'          => 1,
		);
	}
}

if ( ! function_exists( 'lcp_get_settings' ) ) {
	function lcp_get_settings() {
		$saved = get_option( LCP_OPTION, array() );
		if ( ! is_array( $saved ) ) {
			$saved = array();
		}
		return wp_parse_args( $saved, lcp_default_settings() );
	}
}

if ( ! function_exists( 'lcp_activate' ) ) {
	function lcp_activate() {
		if ( false === get_option( LCP_OPTION ) ) {
			add_option( LCP_OPTION, lcp_default_settings() );
		}
	}
	register_activation_hook( __FILE__, 'lcp_activate' );
}

/* ---------------------------------------------------------------------------
 * Admin Settings
 * ------------------------------------------------------------------------- */

if ( ! function_exists( 'lcp_admin_menu' ) ) {
	function lcp_admin_menu() {
		add_options_page(
			'Love Calculator Pro',
			'Love Calculator',
			'manage_options',
			'lcp-settings',
			'lcp_render_settings_page'
		);
	}
	add_action( 'admin_menu', 'lcp_admin_menu' );
}

if ( ! function_exists( 'lcp_render_settings_page' ) ) {
	function lcp_render_settings_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		if ( isset( $_POST['lcp_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['lcp_nonce'] ) ), 'lcp_save' ) ) {
			$allowed_modes = array( 'basic', 'advanced' );
			$allowed_langs = array( 'en', 'hi' );
			$allowed_skin  = array( 'rose', 'sunset', 'royal' );
			$new = array(
				'default_mode'    => in_array( ( $_POST['default_mode'] ?? '' ), $allowed_modes, true ) ? $_POST['default_mode'] : 'basic',
				'default_lang'    => in_array( ( $_POST['default_lang'] ?? '' ), $allowed_langs, true ) ? $_POST['default_lang'] : 'en',
				'theme_skin'      => in_array( ( $_POST['theme_skin'] ?? '' ), $allowed_skin, true ) ? $_POST['theme_skin'] : 'rose',
				'sound_default'   => isset( $_POST['sound_default'] ) ? 1 : 0,
				'haptics_default' => isset( $_POST['haptics_default'] ) ? 1 : 0,
				'show_history'    => isset( $_POST['show_history'] ) ? 1 : 0,
				'show_share'      => isset( $_POST['show_share'] ) ? 1 : 0,
				'show_premium'    => isset( $_POST['show_premium'] ) ? 1 : 0,
				'premium_url'     => esc_url_raw( wp_unslash( $_POST['premium_url'] ?? '' ) ),
				'premium_label'   => sanitize_text_field( wp_unslash( $_POST['premium_label'] ?? 'Get Premium' ) ),
				'ad_slot_top'     => wp_kses_post( wp_unslash( $_POST['ad_slot_top'] ?? '' ) ),
				'ad_slot_middle'  => wp_kses_post( wp_unslash( $_POST['ad_slot_middle'] ?? '' ) ),
				'ad_slot_bottom'  => wp_kses_post( wp_unslash( $_POST['ad_slot_bottom'] ?? '' ) ),
				'show_advanced_toggle' => isset( $_POST['show_advanced_toggle'] ) ? 1 : 0,
				'show_lang_toggle'     => isset( $_POST['show_lang_toggle'] ) ? 1 : 0,
				'show_gender'          => isset( $_POST['show_gender'] ) ? 1 : 0,
				'show_status'          => isset( $_POST['show_status'] ) ? 1 : 0,
			);
			update_option( LCP_OPTION, $new );
			echo '<div class="notice notice-success is-dismissible"><p><strong>Settings saved.</strong></p></div>';
		}
		$s = lcp_get_settings();
		?>
		<div class="wrap">
			<h1>Love Calculator Pro</h1>
			<p>Display the calculator using the shortcode: <code>[love_calculator_pro]</code> or <code>[love_calculator]</code>.</p>
			<p>Optional shortcode attributes: <code>mode="basic|advanced"</code> and <code>lang="en|hi"</code>.</p>
			<form method="post" action="">
				<?php wp_nonce_field( 'lcp_save', 'lcp_nonce' ); ?>
				<table class="form-table" role="presentation">
					<tr><th scope="row"><label for="default_mode">Default Mode</label></th>
						<td><select name="default_mode" id="default_mode">
							<option value="basic"    <?php selected( $s['default_mode'], 'basic' ); ?>>Basic (Love %)</option>
							<option value="advanced" <?php selected( $s['default_mode'], 'advanced' ); ?>>Advanced (Numerology + Zodiac + Radar)</option>
						</select></td></tr>
					<tr><th scope="row"><label for="default_lang">Default Language</label></th>
						<td><select name="default_lang" id="default_lang">
							<option value="en" <?php selected( $s['default_lang'], 'en' ); ?>>English</option>
							<option value="hi" <?php selected( $s['default_lang'], 'hi' ); ?>>Hindi</option>
						</select></td></tr>
					<tr><th scope="row"><label for="theme_skin">Theme Skin</label></th>
						<td><select name="theme_skin" id="theme_skin">
							<option value="rose"   <?php selected( $s['theme_skin'], 'rose' ); ?>>Rose Blush (recommended)</option>
							<option value="sunset" <?php selected( $s['theme_skin'], 'sunset' ); ?>>Sunset Peach</option>
							<option value="royal"  <?php selected( $s['theme_skin'], 'royal' ); ?>>Royal Wine (dark)</option>
						</select></td></tr>
					<tr><th scope="row">Toggles</th><td>
						<label><input type="checkbox" name="show_advanced_toggle" value="1" <?php checked( $s['show_advanced_toggle'], 1 ); ?>> Show Advanced Mode toggle</label><br>
						<label><input type="checkbox" name="show_lang_toggle" value="1" <?php checked( $s['show_lang_toggle'], 1 ); ?>> Show Language toggle (EN / HI)</label><br>
						<label><input type="checkbox" name="show_gender" value="1" <?php checked( $s['show_gender'], 1 ); ?>> Show Gender chips</label><br>
						<label><input type="checkbox" name="show_status" value="1" <?php checked( $s['show_status'], 1 ); ?>> Show Relationship Status</label><br>
						<label><input type="checkbox" name="show_history" value="1" <?php checked( $s['show_history'], 1 ); ?>> Save user history</label><br>
						<label><input type="checkbox" name="show_share" value="1" <?php checked( $s['show_share'], 1 ); ?>> Show Share buttons</label><br>
						<label><input type="checkbox" name="sound_default" value="1" <?php checked( $s['sound_default'], 1 ); ?>> Sound ON by default</label><br>
						<label><input type="checkbox" name="haptics_default" value="1" <?php checked( $s['haptics_default'], 1 ); ?>> Haptics ON by default</label>
					</td></tr>
					<tr><th scope="row"><label for="show_premium">Premium Upsell</label></th>
						<td><label><input type="checkbox" name="show_premium" id="show_premium" value="1" <?php checked( $s['show_premium'], 1 ); ?>> Show Premium upsell on result</label>
							<p><label for="premium_url">Premium URL:</label><br><input type="url" name="premium_url" id="premium_url" value="<?php echo esc_attr( $s['premium_url'] ); ?>" class="regular-text" placeholder="https://yoursite.com/premium"></p>
							<p><label for="premium_label">Premium Button Label:</label><br><input type="text" name="premium_label" id="premium_label" value="<?php echo esc_attr( $s['premium_label'] ); ?>" class="regular-text" placeholder="Get Premium"></p></td></tr>
					<tr><th scope="row"><label for="ad_slot_top">AdSense — Top</label></th>
						<td><textarea name="ad_slot_top" id="ad_slot_top" rows="4" class="large-text code"><?php echo esc_textarea( $s['ad_slot_top'] ); ?></textarea></td></tr>
					<tr><th scope="row"><label for="ad_slot_middle">AdSense — After Result</label></th>
						<td><textarea name="ad_slot_middle" id="ad_slot_middle" rows="4" class="large-text code"><?php echo esc_textarea( $s['ad_slot_middle'] ); ?></textarea></td></tr>
					<tr><th scope="row"><label for="ad_slot_bottom">AdSense — Bottom</label></th>
						<td><textarea name="ad_slot_bottom" id="ad_slot_bottom" rows="4" class="large-text code"><?php echo esc_textarea( $s['ad_slot_bottom'] ); ?></textarea></td></tr>
				</table>
				<?php submit_button( 'Save Settings' ); ?>
			</form>
		</div>
		<?php
	}
}

/* ---------------------------------------------------------------------------
 * Shortcode
 * ------------------------------------------------------------------------- */

if ( ! function_exists( 'lcp_shortcode' ) ) {
	function lcp_shortcode( $atts = array(), $content = '' ) {
		$atts = shortcode_atts(
			array(
				'mode' => '',
				'lang' => '',
				'skin' => '',
			),
			$atts,
			'love_calculator_pro'
		);
		$s = lcp_get_settings();
		$mode = in_array( $atts['mode'], array( 'basic', 'advanced' ), true ) ? $atts['mode'] : $s['default_mode'];
		$lang = in_array( $atts['lang'], array( 'en', 'hi' ), true ) ? $atts['lang'] : $s['default_lang'];
		$skin = in_array( $atts['skin'], array( 'rose', 'sunset', 'royal' ), true ) ? $atts['skin'] : $s['theme_skin'];

		$GLOBALS['lcp_used'] = true;
		$html = lcp_get_markup( $mode, $lang, $skin, $s );

		if ( did_action( 'wp_head' ) && empty( $GLOBALS['lcp_css_printed'] ) ) {
			$GLOBALS['lcp_css_printed'] = true;
			$html = '<style id="lcp-styles-fb">' . lcp_get_css() . '</style>' . $html;
		}
		return $html;
	}
	add_shortcode( 'love_calculator_pro', 'lcp_shortcode' );
	add_shortcode( 'love_calculator', 'lcp_shortcode' );
}

/* ---------------------------------------------------------------------------
 * Asset printing (wp_head CSS + wp_footer JS — wpautop-safe)
 * ------------------------------------------------------------------------- */

if ( ! function_exists( 'lcp_should_print_assets' ) ) {
	function lcp_should_print_assets() {
		if ( is_admin() ) {
			return false;
		}
		if ( ! empty( $GLOBALS['lcp_used'] ) ) {
			return true;
		}
		if ( function_exists( 'is_singular' ) && is_singular() ) {
			$post = get_post();
			if ( $post && ( has_shortcode( $post->post_content, 'love_calculator_pro' ) || has_shortcode( $post->post_content, 'love_calculator' ) ) ) {
				return true;
			}
		}
		return false;
	}
}

if ( ! function_exists( 'lcp_print_head_css' ) ) {
	function lcp_print_head_css() {
		if ( ! lcp_should_print_assets() ) {
			return;
		}
		if ( ! empty( $GLOBALS['lcp_css_printed'] ) ) {
			return;
		}
		$GLOBALS['lcp_css_printed'] = true;
		echo "\n<style id=\"lcp-styles\">" . lcp_get_css() . "</style>\n";
	}
	add_action( 'wp_head', 'lcp_print_head_css', 99 );
}

if ( ! function_exists( 'lcp_print_footer_js' ) ) {
	function lcp_print_footer_js() {
		if ( empty( $GLOBALS['lcp_used'] ) && ! lcp_should_print_assets() ) {
			return;
		}
		if ( ! empty( $GLOBALS['lcp_js_printed'] ) ) {
			return;
		}
		$GLOBALS['lcp_js_printed'] = true;
		echo "\n<script id=\"lcp-script\">/* Love Calculator Pro */\n" . lcp_get_js() . "\n/* end */</script>\n";
	}
	add_action( 'wp_footer', 'lcp_print_footer_js', 99 );
}

/* ---------------------------------------------------------------------------
 * HTML markup
 * ------------------------------------------------------------------------- */

if ( ! function_exists( 'lcp_get_markup' ) ) {
	function lcp_get_markup( $mode, $lang, $skin, $s ) {
		$uid = 'lcp-' . wp_generate_password( 8, false, false );
		$ad_top = $s['ad_slot_top']; $ad_mid = $s['ad_slot_middle']; $ad_bot = $s['ad_slot_bottom'];
		ob_start();
		?>
<div class="lcp-wrap lcp-skin-<?php echo esc_attr( $skin ); ?>" id="<?php echo esc_attr( $uid ); ?>" data-mode="<?php echo esc_attr( $mode ); ?>" data-lang="<?php echo esc_attr( $lang ); ?>" data-sound="<?php echo (int) $s['sound_default']; ?>" data-haptics="<?php echo (int) $s['haptics_default']; ?>" data-history="<?php echo (int) $s['show_history']; ?>" data-share="<?php echo (int) $s['show_share']; ?>" data-premium="<?php echo (int) $s['show_premium']; ?>" data-premium-url="<?php echo esc_attr( $s['premium_url'] ); ?>" data-premium-label="<?php echo esc_attr( $s['premium_label'] ); ?>"><?php if ( ! empty( $ad_top ) ) : ?><div class="lcp-ad lcp-ad-top"><?php echo $ad_top; ?></div><?php endif; ?><div class="lcp-bg" aria-hidden="true"><span class="lcp-h">❤</span><span class="lcp-h">❤</span><span class="lcp-h">❤</span><span class="lcp-h">❤</span><span class="lcp-h">❤</span><span class="lcp-h">❤</span><span class="lcp-h">❤</span><span class="lcp-h">❤</span><span class="lcp-h">❤</span><span class="lcp-h">❤</span></div><div class="lcp-shell"><header class="lcp-head"><div class="lcp-crown" aria-hidden="true"><svg viewBox="0 0 64 64" width="58" height="58"><defs><linearGradient id="<?php echo esc_attr( $uid ); ?>-h" x1="0" y1="0" x2="1" y2="1"><stop offset="0%" stop-color="#FF6F91"/><stop offset="100%" stop-color="#E63E62"/></linearGradient></defs><path d="M32 56s-22-12-22-28a12 12 0 0 1 22-6 12 12 0 0 1 22 6c0 16-22 28-22 28z" fill="url(#<?php echo esc_attr( $uid ); ?>-h)"/></svg></div><h2 class="lcp-title" data-i18n="title">Love Calculator</h2><p class="lcp-sub" data-i18n="sub">Find your true love percentage</p><div class="lcp-toggles"><?php if ( $s['show_advanced_toggle'] ) : ?><label class="lcp-tgl"><input type="checkbox" class="lcp-adv-toggle" <?php checked( $mode, 'advanced' ); ?>><span class="lcp-tgl-track"><span class="lcp-tgl-knob"></span></span><span class="lcp-tgl-txt" data-i18n="advanced">Advanced</span></label><?php endif; ?><?php if ( $s['show_lang_toggle'] ) : ?><div class="lcp-lang"><button type="button" class="lcp-lang-btn <?php echo 'en' === $lang ? 'is-on' : ''; ?>" data-lang="en">EN</button><button type="button" class="lcp-lang-btn <?php echo 'hi' === $lang ? 'is-on' : ''; ?>" data-lang="hi">हि</button></div><?php endif; ?><button type="button" class="lcp-mini lcp-sound-btn" aria-label="Toggle sound"><span class="lcp-snd-on">🔊</span><span class="lcp-snd-off">🔇</span></button></div></header><section class="lcp-card lcp-input-card"><form class="lcp-form" novalidate onsubmit="return false;"><div class="lcp-row"><div class="lcp-field"><label class="lcp-lbl" for="<?php echo esc_attr( $uid ); ?>-n1" data-i18n="your_name">Your Name</label><div class="lcp-input-wrap"><input type="text" class="lcp-input lcp-name1" id="<?php echo esc_attr( $uid ); ?>-n1" autocomplete="off" maxlength="40" placeholder="e.g. Aarav"><span class="lcp-und"></span></div><?php if ( $s['show_gender'] ) : ?><div class="lcp-chips lcp-gender1"><button type="button" class="lcp-chip is-on" data-v="male" data-i18n="male">Male</button><button type="button" class="lcp-chip" data-v="female" data-i18n="female">Female</button></div><?php endif; ?></div><div class="lcp-cupid" aria-hidden="true"><svg viewBox="0 0 80 24" width="80" height="24"><path d="M2 12 L70 12" stroke="#E63E62" stroke-width="2" stroke-linecap="round" fill="none"/><path d="M64 6 L74 12 L64 18" stroke="#E63E62" stroke-width="2" stroke-linejoin="round" fill="none"/><path d="M2 12 L8 8 M2 12 L8 16 M6 12 L12 9 M6 12 L12 15" stroke="#E63E62" stroke-width="1.5" stroke-linecap="round" fill="none"/></svg><span class="lcp-heart-mid">❤</span></div><div class="lcp-field"><label class="lcp-lbl" for="<?php echo esc_attr( $uid ); ?>-n2" data-i18n="partner_name">Partner's Name</label><div class="lcp-input-wrap"><input type="text" class="lcp-input lcp-name2" id="<?php echo esc_attr( $uid ); ?>-n2" autocomplete="off" maxlength="40" placeholder="e.g. Priya"><span class="lcp-und"></span></div><?php if ( $s['show_gender'] ) : ?><div class="lcp-chips lcp-gender2"><button type="button" class="lcp-chip" data-v="male" data-i18n="male">Male</button><button type="button" class="lcp-chip is-on" data-v="female" data-i18n="female">Female</button></div><?php endif; ?></div></div><div class="lcp-adv"><div class="lcp-row lcp-adv-row"><div class="lcp-field"><label class="lcp-lbl" data-i18n="your_dob">Your Date of Birth</label><input type="date" class="lcp-input lcp-dob1" max=""></div><div class="lcp-spacer"></div><div class="lcp-field"><label class="lcp-lbl" data-i18n="partner_dob">Partner's Date of Birth</label><input type="date" class="lcp-input lcp-dob2" max=""></div></div></div><?php if ( $s['show_status'] ) : ?><div class="lcp-status-wrap"><label class="lcp-lbl" data-i18n="status">Relationship Status</label><div class="lcp-status-grid"><button type="button" class="lcp-status-chip is-on" data-v="crush" data-i18n="st_crush">💕 Crush</button><button type="button" class="lcp-status-chip" data-v="dating" data-i18n="st_dating">💑 Dating</button><button type="button" class="lcp-status-chip" data-v="committed" data-i18n="st_committed">💖 Committed</button><button type="button" class="lcp-status-chip" data-v="married" data-i18n="st_married">💍 Married</button></div></div><?php endif; ?><div class="lcp-err" role="alert"></div><button type="submit" class="lcp-btn lcp-go"><span class="lcp-btn-bg"></span><span class="lcp-btn-txt" data-i18n="calculate">Calculate Love</span><span class="lcp-btn-heart">❤</span></button><div class="lcp-trust"><span data-i18n="trust1">⚡ Instant</span><span data-i18n="trust2">🔒 100% Private</span><span data-i18n="trust3">💝 Free Forever</span></div></form></section><section class="lcp-card lcp-loading-card" style="display:none"><div class="lcp-loader"><div class="lcp-lo-heart">❤</div><div class="lcp-lo-ring"></div><div class="lcp-lo-ring lcp-lo-ring-2"></div><div class="lcp-lo-ring lcp-lo-ring-3"></div></div><p class="lcp-load-txt" data-i18n="reading">Reading the energy of love…</p><div class="lcp-progress"><span class="lcp-progress-bar"></span></div></section><section class="lcp-card lcp-result-card" style="display:none"><div class="lcp-confetti" aria-hidden="true"></div><div class="lcp-couple"><div class="lcp-cp-name lcp-cp-a"><span class="lcp-init"></span><strong></strong></div><div class="lcp-cp-link">❤</div><div class="lcp-cp-name lcp-cp-b"><span class="lcp-init"></span><strong></strong></div></div><div class="lcp-meter"><svg viewBox="0 0 200 200" width="220" height="220" class="lcp-heart-svg" aria-hidden="true"><defs><linearGradient id="<?php echo esc_attr( $uid ); ?>-fill" x1="0" y1="1" x2="0" y2="0"><stop offset="0%" stop-color="#FF6F91"/><stop offset="100%" stop-color="#E63E62"/></linearGradient><clipPath id="<?php echo esc_attr( $uid ); ?>-clip"><path d="M100 175 C 30 130 10 80 35 50 C 55 25 90 30 100 60 C 110 30 145 25 165 50 C 190 80 170 130 100 175 Z"/></clipPath></defs><path d="M100 175 C 30 130 10 80 35 50 C 55 25 90 30 100 60 C 110 30 145 25 165 50 C 190 80 170 130 100 175 Z" fill="rgba(230,62,98,0.08)" stroke="#E63E62" stroke-width="2"/><g clip-path="url(#<?php echo esc_attr( $uid ); ?>-clip)"><rect class="lcp-heart-fill" x="0" y="200" width="200" height="200" fill="url(#<?php echo esc_attr( $uid ); ?>-fill)"/><circle class="lcp-bubble" cx="60" cy="180" r="3" fill="rgba(255,255,255,0.5)"/><circle class="lcp-bubble" cx="120" cy="190" r="4" fill="rgba(255,255,255,0.5)"/><circle class="lcp-bubble" cx="90" cy="170" r="2" fill="rgba(255,255,255,0.4)"/><circle class="lcp-bubble" cx="140" cy="175" r="3" fill="rgba(255,255,255,0.4)"/></g></svg><div class="lcp-meter-num"><span class="lcp-pct">0</span><i>%</i></div></div><h3 class="lcp-tier-name">Soul Connection</h3><p class="lcp-tier-tag" data-i18n="result_tag">Your love story</p><div class="lcp-quote"><span class="lcp-q-mark">"</span><em class="lcp-quote-text"></em></div><div class="lcp-radar" style="display:none"><h4 class="lcp-radar-title" data-i18n="dimensions">Compatibility Dimensions</h4><div class="lcp-bars"><div class="lcp-bar"><label data-i18n="emotional">Emotional</label><div class="lcp-bar-track"><i class="lcp-bar-fill" data-k="emo"></i><b class="lcp-bar-val"></b></div></div><div class="lcp-bar"><label data-i18n="communication">Communication</label><div class="lcp-bar-track"><i class="lcp-bar-fill" data-k="com"></i><b class="lcp-bar-val"></b></div></div><div class="lcp-bar"><label data-i18n="trust">Trust</label><div class="lcp-bar-track"><i class="lcp-bar-fill" data-k="tru"></i><b class="lcp-bar-val"></b></div></div><div class="lcp-bar"><label data-i18n="romance">Romance</label><div class="lcp-bar-track"><i class="lcp-bar-fill" data-k="rom"></i><b class="lcp-bar-val"></b></div></div><div class="lcp-bar"><label data-i18n="future">Future Vision</label><div class="lcp-bar-track"><i class="lcp-bar-fill" data-k="fut"></i><b class="lcp-bar-val"></b></div></div></div></div><div class="lcp-actions"><button type="button" class="lcp-act lcp-act-again" data-i18n="try_again">Try Again</button><button type="button" class="lcp-act lcp-act-share" data-i18n="share">Share</button><button type="button" class="lcp-act lcp-act-save" data-i18n="save">Save</button><button type="button" class="lcp-act lcp-act-card" data-i18n="download">Download Card</button></div></section><?php if ( ! empty( $ad_mid ) ) : ?><div class="lcp-ad lcp-ad-mid" style="display:none"><?php echo $ad_mid; ?></div><?php endif; ?><section class="lcp-advice" style="display:none"><div class="lcp-adv-tabs" role="tablist"><button class="lcp-adv-tab is-on" data-tab="golden" data-i18n="tab_golden">✨ Golden Hint</button><button class="lcp-adv-tab" data-tab="protip" data-i18n="tab_pro">💡 Pro Tip</button><button class="lcp-adv-tab" data-tab="life" data-i18n="tab_life">🌿 Life Lesson</button><button class="lcp-adv-tab" data-tab="boost" data-i18n="tab_boost">🚀 Score Boost</button><button class="lcp-adv-tab" data-tab="next" data-i18n="tab_next">🎯 What Next</button></div><div class="lcp-adv-stage"><article class="lcp-adv-card is-on" data-pane="golden"><h4></h4><p></p></article><article class="lcp-adv-card" data-pane="protip"><h4></h4><p></p></article><article class="lcp-adv-card" data-pane="life"><h4></h4><p></p></article><article class="lcp-adv-card" data-pane="boost"><h4></h4><p></p></article><article class="lcp-adv-card" data-pane="next"><h4></h4><p></p></article></div></section><section class="lcp-extras" style="display:none"><div class="lcp-ex-grid"><div class="lcp-ex"><span class="lcp-ex-icon">🎵</span><div><b data-i18n="ex_song">Love Song for You</b><p class="lcp-ex-song"></p></div></div><div class="lcp-ex"><span class="lcp-ex-icon">🌹</span><div><b data-i18n="ex_date">Date Idea</b><p class="lcp-ex-date"></p></div></div><div class="lcp-ex"><span class="lcp-ex-icon">🔮</span><div><b data-i18n="ex_lucky">Lucky Day</b><p class="lcp-ex-lucky"></p></div></div></div></section><section class="lcp-history" style="display:none"><div class="lcp-hist-head"><h4 data-i18n="history">Your History</h4><button type="button" class="lcp-hist-clear" data-i18n="clear">Clear</button></div><ul class="lcp-hist-list"></ul></section><aside class="lcp-premium" style="display:none"><div class="lcp-prem-icon">👑</div><div class="lcp-prem-body"><h4 data-i18n="prem_title">Get Your Couple Report</h4><p data-i18n="prem_text">Full birth-chart compatibility, daily love forecast and 50-page personal couple analysis.</p><a class="lcp-prem-cta" href="#" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $s['premium_label'] ); ?></a></div></aside><?php if ( ! empty( $ad_bot ) ) : ?><div class="lcp-ad lcp-ad-bot"><?php echo $ad_bot; ?></div><?php endif; ?><canvas class="lcp-share-canvas" width="1080" height="1080" style="display:none"></canvas></div></div>
		<?php
		return ob_get_clean();
	}
}

/* ---------------------------------------------------------------------------
 * CSS
 * ------------------------------------------------------------------------- */

if ( ! function_exists( 'lcp_get_css' ) ) {
	function lcp_get_css() {
		return <<<CSS
.lcp-wrap,.lcp-wrap *,.lcp-wrap *::before,.lcp-wrap *::after{box-sizing:border-box}
.lcp-wrap [style*="display:none"],.lcp-wrap [hidden]{display:none !important}
.lcp-wrap{position:relative;max-width:960px;margin:32px auto;padding:18px;font-family:'Inter','DM Sans',system-ui,-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;color:#3a1f33;line-height:1.55;isolation:isolate}
.lcp-wrap input,.lcp-wrap button,.lcp-wrap select,.lcp-wrap textarea{-webkit-font-smoothing:antialiased}
.lcp-wrap h2,.lcp-wrap h3,.lcp-wrap h4{font-family:'Playfair Display','Cormorant Garamond',Georgia,serif;font-weight:700;letter-spacing:-0.01em;margin:0}
.lcp-bg{position:absolute;inset:0;border-radius:36px;overflow:hidden;z-index:-1;background:radial-gradient(circle at 18% 18%,#FFE4EC 0%,transparent 55%),radial-gradient(circle at 82% 28%,#FFEAD5 0%,transparent 55%),radial-gradient(circle at 50% 92%,#FFF1F4 0%,transparent 60%),linear-gradient(135deg,#FFF8F2 0%,#FFEDF1 100%)}
.lcp-skin-sunset .lcp-bg{background:radial-gradient(circle at 18% 18%,#FFE5D0 0%,transparent 55%),radial-gradient(circle at 82% 28%,#FFD9C0 0%,transparent 55%),radial-gradient(circle at 50% 92%,#FFF1E6 0%,transparent 60%),linear-gradient(135deg,#FFF6EA 0%,#FFE3D2 100%)}
.lcp-skin-royal{color:#fff}
.lcp-skin-royal .lcp-bg{background:radial-gradient(circle at 18% 18%,#5B0B2A 0%,transparent 55%),radial-gradient(circle at 82% 28%,#7A1543 0%,transparent 55%),radial-gradient(circle at 50% 92%,#3D061B 0%,transparent 60%),linear-gradient(135deg,#2A0414 0%,#4A0B26 100%)}
.lcp-h{position:absolute;font-size:24px;color:#FFB6C7;opacity:0;animation:lcp-float 12s linear infinite;pointer-events:none}
.lcp-skin-royal .lcp-h{color:rgba(255,182,199,0.4)}
.lcp-h:nth-child(1){left:6%;bottom:-30px;animation-delay:0s;font-size:18px}
.lcp-h:nth-child(2){left:18%;bottom:-30px;animation-delay:1.5s;font-size:14px}
.lcp-h:nth-child(3){left:30%;bottom:-30px;animation-delay:3s;font-size:22px}
.lcp-h:nth-child(4){left:42%;bottom:-30px;animation-delay:4.5s;font-size:16px}
.lcp-h:nth-child(5){left:55%;bottom:-30px;animation-delay:6s;font-size:20px}
.lcp-h:nth-child(6){left:66%;bottom:-30px;animation-delay:7.5s;font-size:18px}
.lcp-h:nth-child(7){left:78%;bottom:-30px;animation-delay:9s;font-size:14px}
.lcp-h:nth-child(8){left:88%;bottom:-30px;animation-delay:10.5s;font-size:22px}
.lcp-h:nth-child(9){left:12%;bottom:-30px;animation-delay:2.2s;font-size:16px}
.lcp-h:nth-child(10){left:72%;bottom:-30px;animation-delay:5.4s;font-size:18px}
@keyframes lcp-float{0%{transform:translateY(0) scale(1) rotate(0deg);opacity:0}10%{opacity:0.6}50%{transform:translateY(-300px) scale(1.1) rotate(15deg);opacity:0.8}100%{transform:translateY(-700px) scale(0.7) rotate(-15deg);opacity:0}}
.lcp-shell{position:relative;padding:24px 18px}
.lcp-head{text-align:center;padding:6px 4px 22px}
.lcp-crown{display:inline-block;animation:lcp-beat 1.4s ease-in-out infinite;filter:drop-shadow(0 8px 18px rgba(230,62,98,0.35))}
@keyframes lcp-beat{0%,40%,60%,100%{transform:scale(1)}20%{transform:scale(1.15)}50%{transform:scale(1.08)}}
.lcp-title{font-size:clamp(30px,5.2vw,46px);margin:8px 0 4px;background:linear-gradient(120deg,#8B1A3A,#E63E62 50%,#FF6F91);-webkit-background-clip:text;background-clip:text;color:transparent}
.lcp-skin-royal .lcp-title{background:linear-gradient(120deg,#FFD9DC,#FFB6C7 50%,#FF8FA3);-webkit-background-clip:text;background-clip:text}
.lcp-sub{margin:0;opacity:0.7;font-size:15px;font-style:italic}
.lcp-toggles{display:flex;justify-content:center;align-items:center;gap:12px;margin-top:14px;flex-wrap:wrap}
.lcp-tgl{display:inline-flex;align-items:center;gap:8px;cursor:pointer;user-select:none;font-size:13px;font-weight:600}
.lcp-tgl input{position:absolute;opacity:0;pointer-events:none}
.lcp-tgl-track{position:relative;width:44px;height:24px;border-radius:999px;background:rgba(230,62,98,0.12);border:1px solid rgba(230,62,98,0.20);transition:background .25s}
.lcp-tgl-knob{position:absolute;top:2px;left:2px;width:18px;height:18px;border-radius:50%;background:linear-gradient(135deg,#FF6F91,#E63E62);transition:transform .25s;box-shadow:0 4px 10px rgba(230,62,98,0.35)}
.lcp-tgl input:checked + .lcp-tgl-track{background:linear-gradient(90deg,rgba(230,62,98,0.30),rgba(212,165,116,0.30))}
.lcp-tgl input:checked + .lcp-tgl-track .lcp-tgl-knob{transform:translateX(20px);background:linear-gradient(135deg,#D4A574,#E63E62)}
.lcp-lang{display:inline-flex;border-radius:999px;padding:3px;background:rgba(230,62,98,0.08);border:1px solid rgba(230,62,98,0.18)}
.lcp-skin-royal .lcp-lang{background:rgba(255,182,199,0.10);border-color:rgba(255,182,199,0.20)}
.lcp-lang-btn{background:transparent;color:inherit;border:0;padding:4px 12px;border-radius:999px;cursor:pointer;font-weight:700;font-size:12px;min-height:26px;transition:background .2s}
.lcp-lang-btn.is-on{background:linear-gradient(120deg,#E63E62,#FF6F91);color:#fff;box-shadow:0 6px 14px rgba(230,62,98,0.30)}
.lcp-mini{background:rgba(230,62,98,0.08);border:1px solid rgba(230,62,98,0.18);color:inherit;width:32px;height:32px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;cursor:pointer;transition:transform .15s;font-size:14px}
.lcp-skin-royal .lcp-mini{background:rgba(255,182,199,0.10);border-color:rgba(255,182,199,0.20)}
.lcp-mini:hover{transform:scale(1.06)}
.lcp-snd-off{display:none}
.lcp-wrap[data-sound="0"] .lcp-snd-on{display:none}
.lcp-wrap[data-sound="0"] .lcp-snd-off{display:inline}
.lcp-card{position:relative;background:#fff;border-radius:28px;padding:28px 24px;box-shadow:0 30px 80px rgba(140,30,70,0.12),0 2px 6px rgba(140,30,70,0.06);margin-top:18px;overflow:hidden;border:1px solid rgba(230,62,98,0.10)}
.lcp-skin-royal .lcp-card{background:rgba(60,12,32,0.55);backdrop-filter:blur(20px);-webkit-backdrop-filter:blur(20px);border-color:rgba(255,182,199,0.18);color:#fff}
.lcp-card::before{content:"";position:absolute;left:0;right:0;top:0;height:4px;background:linear-gradient(90deg,#E63E62,#FF6F91 50%,#D4A574);border-radius:4px 4px 0 0}
.lcp-row{display:grid;grid-template-columns:1fr 90px 1fr;gap:14px;align-items:start}
.lcp-field{display:flex;flex-direction:column;gap:8px;min-width:0}
.lcp-lbl{font-size:12px;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;opacity:0.7}
.lcp-input-wrap{position:relative}
.lcp-input{width:100%;min-height:50px;padding:12px 16px 14px;font-size:16px;background:#FFF8FA;border:1.5px solid rgba(230,62,98,0.18);border-radius:14px;color:inherit;outline:none;transition:border-color .25s,background .25s,box-shadow .25s;font-family:inherit}
.lcp-skin-royal .lcp-input{background:rgba(255,255,255,0.10);border-color:rgba(255,182,199,0.25);color:#fff}
.lcp-input::placeholder{color:rgba(58,31,51,0.40)}
.lcp-skin-royal .lcp-input::placeholder{color:rgba(255,255,255,0.40)}
.lcp-input:focus{border-color:#E63E62;background:#fff;box-shadow:0 0 0 4px rgba(230,62,98,0.12)}
.lcp-skin-royal .lcp-input:focus{background:rgba(255,255,255,0.18)}
.lcp-und{position:absolute;left:14px;right:14px;bottom:8px;height:2px;background:linear-gradient(90deg,#E63E62,#D4A574);border-radius:2px;transform:scaleX(0);transform-origin:left;transition:transform .35s}
.lcp-input:focus + .lcp-und{transform:scaleX(1)}
.lcp-chips{display:flex;gap:6px;flex-wrap:wrap;margin-top:2px}
.lcp-chip{padding:5px 12px;border-radius:999px;background:#FFF0F4;border:1.5px solid transparent;cursor:pointer;font-size:12px;font-weight:600;color:#8B1A3A;transition:all .2s;font-family:inherit}
.lcp-skin-royal .lcp-chip{background:rgba(255,182,199,0.12);color:#FFD9DC}
.lcp-chip:hover{background:#FFE4EC}
.lcp-chip.is-on{background:linear-gradient(120deg,#E63E62,#FF6F91);color:#fff;border-color:transparent;box-shadow:0 4px 12px rgba(230,62,98,0.25)}
.lcp-cupid{position:relative;height:50px;display:flex;align-items:center;justify-content:center;margin-top:24px}
.lcp-cupid svg{width:90%;max-width:90px;height:auto;animation:lcp-fly 3.5s ease-in-out infinite}
@keyframes lcp-fly{0%,100%{transform:translateX(-4px)}50%{transform:translateX(4px)}}
.lcp-heart-mid{position:absolute;top:-14px;font-size:18px;color:#E63E62;animation:lcp-beat 1.4s ease-in-out infinite}
.lcp-adv{max-height:0;overflow:hidden;transition:max-height .4s ease,opacity .35s,margin .35s;opacity:0}
.lcp-wrap[data-mode="advanced"] .lcp-adv{max-height:200px;opacity:1;margin-top:16px}
.lcp-adv-row{grid-template-columns:1fr 24px 1fr}
.lcp-spacer{width:24px}
.lcp-skin-royal .lcp-input[type="date"]::-webkit-calendar-picker-indicator{filter:invert(1) brightness(1.4)}
.lcp-status-wrap{margin-top:18px}
.lcp-status-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:8px;margin-top:8px}
.lcp-status-chip{padding:10px 6px;background:#FFF0F4;border:1.5px solid transparent;border-radius:14px;color:#8B1A3A;font-size:13px;font-weight:600;cursor:pointer;transition:all .2s;font-family:inherit}
.lcp-skin-royal .lcp-status-chip{background:rgba(255,182,199,0.10);color:#FFD9DC}
.lcp-status-chip:hover{background:#FFE4EC}
.lcp-status-chip.is-on{background:linear-gradient(120deg,#E63E62,#FF6F91);color:#fff;box-shadow:0 6px 16px rgba(230,62,98,0.30)}
.lcp-err{display:none;margin-top:14px;background:#FFE0E6;border:1px solid #E63E62;color:#8B1A3A;border-radius:12px;padding:10px 14px;font-size:14px;text-align:center}
.lcp-err.is-on{display:block !important;animation:lcp-shake .35s}
@keyframes lcp-shake{0%,100%{transform:translateX(0)}25%{transform:translateX(-6px)}75%{transform:translateX(6px)}}
.lcp-btn{position:relative;display:inline-flex;align-items:center;justify-content:center;gap:10px;width:100%;min-height:60px;padding:18px 22px;margin-top:20px;border:0;border-radius:18px;cursor:pointer;color:#fff;font-family:inherit;font-weight:800;font-size:17px;letter-spacing:0.01em;overflow:hidden;transition:transform .15s,box-shadow .25s;box-shadow:0 16px 40px rgba(230,62,98,0.32)}
.lcp-btn-bg{position:absolute;inset:0;background:linear-gradient(120deg,#E63E62,#FF6F91 50%,#D4A574);background-size:200% 200%;animation:lcp-grad 4s ease infinite;z-index:0}
@keyframes lcp-grad{0%,100%{background-position:0 0}50%{background-position:100% 100%}}
.lcp-btn-txt,.lcp-btn-heart{position:relative;z-index:1}
.lcp-btn-heart{font-size:22px;animation:lcp-beat 1.2s ease-in-out infinite}
.lcp-btn:hover{transform:translateY(-2px);box-shadow:0 22px 50px rgba(230,62,98,0.45)}
.lcp-btn:active{transform:translateY(0)}
.lcp-trust{display:flex;gap:8px;justify-content:center;flex-wrap:wrap;margin-top:14px}
.lcp-trust span{font-size:12px;padding:6px 12px;background:#FFF0F4;border-radius:999px;color:#8B1A3A;font-weight:600}
.lcp-skin-royal .lcp-trust span{background:rgba(255,182,199,0.12);color:#FFD9DC}
.lcp-loader{position:relative;width:140px;height:140px;margin:6px auto 16px}
.lcp-lo-heart{position:absolute;inset:0;display:flex;align-items:center;justify-content:center;font-size:60px;color:#E63E62;animation:lcp-beat 1s ease-in-out infinite}
.lcp-lo-ring{position:absolute;inset:0;border:3px solid rgba(230,62,98,0.4);border-radius:50%;animation:lcp-pulse-out 2s ease-out infinite}
.lcp-lo-ring-2{animation-delay:0.66s;border-color:rgba(255,111,145,0.4)}
.lcp-lo-ring-3{animation-delay:1.33s;border-color:rgba(212,165,116,0.4)}
@keyframes lcp-pulse-out{0%{transform:scale(0.6);opacity:1}100%{transform:scale(1.5);opacity:0}}
.lcp-load-txt{text-align:center;font-weight:600;opacity:0.8;font-style:italic}
.lcp-progress{height:6px;max-width:380px;margin:12px auto 0;background:#FFE4EC;border-radius:999px;overflow:hidden}
.lcp-skin-royal .lcp-progress{background:rgba(255,182,199,0.15)}
.lcp-progress-bar{display:block;height:100%;width:0%;background:linear-gradient(90deg,#E63E62,#FF6F91,#D4A574);border-radius:999px;transition:width .4s ease}
.lcp-couple{display:flex;align-items:center;justify-content:center;gap:14px;margin-bottom:8px;flex-wrap:wrap}
.lcp-cp-name{display:inline-flex;align-items:center;gap:8px;padding:6px 14px;background:#FFF0F4;border-radius:999px;font-weight:700}
.lcp-skin-royal .lcp-cp-name{background:rgba(255,182,199,0.15)}
.lcp-init{width:28px;height:28px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;font-size:13px;font-weight:800;color:#fff}
.lcp-cp-a .lcp-init{background:linear-gradient(135deg,#FF6F91,#E63E62)}
.lcp-cp-b .lcp-init{background:linear-gradient(135deg,#D4A574,#E63E62)}
.lcp-cp-link{font-size:18px;color:#E63E62;animation:lcp-beat 1.2s ease-in-out infinite}
.lcp-meter{position:relative;width:220px;height:220px;margin:14px auto 6px}
.lcp-heart-svg{width:100%;height:100%;filter:drop-shadow(0 16px 40px rgba(230,62,98,0.35))}
.lcp-heart-fill{transition:y 2.2s cubic-bezier(.2,.9,.3,1)}
.lcp-bubble{animation:lcp-bubble-rise 2.5s ease-in-out infinite}
.lcp-bubble:nth-of-type(2){animation-delay:0.7s}
.lcp-bubble:nth-of-type(3){animation-delay:1.4s}
.lcp-bubble:nth-of-type(4){animation-delay:2.1s}
@keyframes lcp-bubble-rise{0%{transform:translateY(0);opacity:0}30%{opacity:1}100%{transform:translateY(-120px);opacity:0}}
.lcp-meter-num{position:absolute;inset:0;display:flex;align-items:center;justify-content:center;font-family:'Playfair Display',Georgia,serif;color:#fff;text-shadow:0 4px 12px rgba(140,30,70,0.45)}
.lcp-pct{font-size:56px;font-weight:800;line-height:1}
.lcp-meter-num i{font-style:normal;font-size:26px;font-weight:700;opacity:0.85;margin-left:2px}
.lcp-tier-name{text-align:center;font-size:clamp(22px,3.6vw,32px);margin-top:6px;background:linear-gradient(120deg,#8B1A3A,#E63E62);-webkit-background-clip:text;background-clip:text;color:transparent}
.lcp-skin-royal .lcp-tier-name{background:linear-gradient(120deg,#FFD9DC,#FF8FA3);-webkit-background-clip:text;background-clip:text}
.lcp-tier-tag{text-align:center;margin:4px 0 12px;opacity:0.7;font-size:13px;letter-spacing:0.06em;text-transform:uppercase}
.lcp-quote{position:relative;padding:14px 18px;margin:12px auto;max-width:540px;background:linear-gradient(120deg,#FFF8F2,#FFF0F4);border-left:4px solid #E63E62;border-radius:14px;color:#3a1f33;text-align:left}
.lcp-skin-royal .lcp-quote{background:rgba(255,182,199,0.08);color:#FFD9DC}
.lcp-q-mark{position:absolute;left:8px;top:-4px;font-size:32px;font-family:Georgia,serif;color:#E63E62;opacity:0.4}
.lcp-quote-text{display:block;padding-left:22px;font-style:italic;font-size:14.5px;line-height:1.65}
.lcp-confetti{pointer-events:none;position:absolute;left:0;right:0;top:0;height:0}
.lcp-confetti.is-go{height:1px}
.lcp-conf-piece{position:absolute;font-size:18px;opacity:0;animation:lcp-conf 1500ms ease-out forwards}
@keyframes lcp-conf{0%{opacity:1;transform:translate(0,0) rotate(0) scale(1)}100%{opacity:0;transform:translate(var(--lcp-x),var(--lcp-y)) rotate(540deg) scale(0.5)}}
.lcp-radar{margin-top:18px;padding:16px;background:linear-gradient(120deg,#FFF8FA,#FFF0F4);border-radius:18px;border:1px solid rgba(230,62,98,0.10)}
.lcp-skin-royal .lcp-radar{background:rgba(255,182,199,0.08);border-color:rgba(255,182,199,0.18)}
.lcp-radar-title{font-size:15px;margin-bottom:10px;color:#8B1A3A}
.lcp-skin-royal .lcp-radar-title{color:#FFD9DC}
.lcp-bars{display:flex;flex-direction:column;gap:10px}
.lcp-bar{display:grid;grid-template-columns:120px 1fr;gap:12px;align-items:center}
.lcp-bar label{font-size:13px;font-weight:600;opacity:0.85}
.lcp-bar-track{position:relative;height:10px;background:rgba(230,62,98,0.10);border-radius:999px;overflow:visible}
.lcp-skin-royal .lcp-bar-track{background:rgba(255,182,199,0.12)}
.lcp-bar-fill{display:block;height:100%;width:0%;background:linear-gradient(90deg,#E63E62,#FF6F91,#D4A574);border-radius:999px;transition:width 1.2s cubic-bezier(.2,.9,.3,1)}
.lcp-bar-val{position:absolute;right:6px;top:-22px;font-size:12px;font-weight:700;color:#E63E62}
.lcp-skin-royal .lcp-bar-val{color:#FF8FA3}
.lcp-actions{display:flex;flex-wrap:wrap;gap:8px;justify-content:center;margin-top:20px}
.lcp-act{background:#FFF0F4;color:#8B1A3A;border:1.5px solid rgba(230,62,98,0.15);padding:10px 16px;border-radius:12px;font-weight:700;cursor:pointer;font-family:inherit;font-size:14px;transition:all .2s}
.lcp-skin-royal .lcp-act{background:rgba(255,182,199,0.12);color:#FFD9DC;border-color:rgba(255,182,199,0.20)}
.lcp-act:hover{background:#FFE4EC;transform:translateY(-1px)}
.lcp-act-share{background:linear-gradient(120deg,#E63E62,#FF6F91);color:#fff;border-color:transparent}
.lcp-act-share:hover{background:linear-gradient(120deg,#FF6F91,#E63E62)}
.lcp-advice{margin-top:18px}
.lcp-adv-tabs{display:flex;gap:6px;padding:6px;background:#FFF0F4;border-radius:14px;overflow-x:auto;scrollbar-width:none}
.lcp-skin-royal .lcp-adv-tabs{background:rgba(255,182,199,0.10)}
.lcp-adv-tabs::-webkit-scrollbar{display:none}
.lcp-adv-tab{background:transparent;color:#8B1A3A;border:0;padding:8px 14px;border-radius:10px;font-weight:700;font-size:13px;cursor:pointer;white-space:nowrap;font-family:inherit;transition:background .25s,color .25s}
.lcp-skin-royal .lcp-adv-tab{color:#FFD9DC}
.lcp-adv-tab.is-on{background:linear-gradient(120deg,#E63E62,#FF6F91);color:#fff;box-shadow:0 6px 16px rgba(230,62,98,0.30)}
.lcp-adv-stage{position:relative;margin-top:12px;min-height:140px}
.lcp-adv-card{display:none;padding:18px 18px;background:#fff;border:1px solid rgba(230,62,98,0.10);border-radius:16px;box-shadow:0 8px 24px rgba(140,30,70,0.06);animation:lcp-fade .35s ease both}
.lcp-skin-royal .lcp-adv-card{background:rgba(60,12,32,0.55);border-color:rgba(255,182,199,0.18);color:#fff}
.lcp-adv-card.is-on{display:block !important}
.lcp-adv-card h4{font-size:17px;margin-bottom:6px;background:linear-gradient(120deg,#8B1A3A,#E63E62);-webkit-background-clip:text;background-clip:text;color:transparent}
.lcp-skin-royal .lcp-adv-card h4{background:linear-gradient(120deg,#FFD9DC,#FF8FA3);-webkit-background-clip:text;background-clip:text}
.lcp-adv-card p{margin:0;font-size:14.5px;opacity:0.92;line-height:1.7}
@keyframes lcp-fade{from{opacity:0;transform:translateY(6px)}to{opacity:1;transform:translateY(0)}}
.lcp-extras{margin-top:18px}
.lcp-ex-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:10px}
.lcp-ex{display:flex;gap:10px;padding:14px;background:#fff;border:1px solid rgba(230,62,98,0.10);border-radius:14px;align-items:flex-start}
.lcp-skin-royal .lcp-ex{background:rgba(60,12,32,0.55);border-color:rgba(255,182,199,0.18)}
.lcp-ex-icon{font-size:24px;flex-shrink:0}
.lcp-ex b{display:block;font-size:13px;color:#8B1A3A;margin-bottom:2px}
.lcp-skin-royal .lcp-ex b{color:#FFD9DC}
.lcp-ex p{margin:0;font-size:13.5px;line-height:1.5;opacity:0.85}
.lcp-history{margin-top:18px;padding:16px;background:#fff;border:1px solid rgba(230,62,98,0.10);border-radius:16px}
.lcp-skin-royal .lcp-history{background:rgba(60,12,32,0.55);border-color:rgba(255,182,199,0.18)}
.lcp-hist-head{display:flex;justify-content:space-between;align-items:center;margin-bottom:8px}
.lcp-hist-head h4{font-size:15px;color:#8B1A3A}
.lcp-skin-royal .lcp-hist-head h4{color:#FFD9DC}
.lcp-hist-clear{background:transparent;color:#E63E62;border:0;cursor:pointer;font-size:12px;font-family:inherit;font-weight:600}
.lcp-hist-list{list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:6px}
.lcp-hist-list li{display:flex;justify-content:space-between;align-items:center;padding:8px 12px;background:#FFF0F4;border-radius:10px;font-size:13px}
.lcp-skin-royal .lcp-hist-list li{background:rgba(255,182,199,0.10)}
.lcp-hist-list li b{color:#E63E62;font-weight:800}
.lcp-premium{display:flex;gap:14px;align-items:center;margin-top:18px;padding:18px;background:linear-gradient(120deg,#FFF1E6,#FFE4EC);border:1px solid rgba(212,165,116,0.30);border-radius:18px}
.lcp-skin-royal .lcp-premium{background:linear-gradient(120deg,rgba(212,165,116,0.20),rgba(230,62,98,0.20));border-color:rgba(212,165,116,0.40)}
.lcp-prem-icon{font-size:36px}
.lcp-prem-body{flex:1}
.lcp-prem-body h4{font-size:16px;color:#8B1A3A}
.lcp-skin-royal .lcp-prem-body h4{color:#FFD9DC}
.lcp-prem-body p{margin:4px 0 10px;font-size:13.5px;opacity:0.88}
.lcp-prem-cta{display:inline-block;padding:9px 18px;border-radius:10px;background:linear-gradient(120deg,#D4A574,#E63E62);color:#fff;font-weight:800;text-decoration:none;font-size:13.5px;transition:transform .15s}
.lcp-prem-cta:hover{transform:translateY(-1px)}
.lcp-ad{margin:14px 0;text-align:center;min-height:50px}
.lcp-ad-mid{margin-top:18px}
@media (max-width:680px){
.lcp-wrap{padding:12px;margin:16px auto}
.lcp-shell{padding:16px 8px}
.lcp-card{padding:20px 16px;border-radius:22px}
.lcp-row{grid-template-columns:1fr;gap:18px}
.lcp-row .lcp-cupid{order:2;height:40px;margin-top:0;transform:rotate(90deg)}
.lcp-row .lcp-field:nth-child(3){order:3}
.lcp-adv-row{grid-template-columns:1fr}
.lcp-spacer{display:none}
.lcp-status-grid{grid-template-columns:repeat(2,1fr)}
.lcp-ex-grid{grid-template-columns:1fr}
.lcp-bar{grid-template-columns:100px 1fr}
.lcp-actions .lcp-act{flex:1 1 calc(50% - 8px)}
.lcp-meter{width:180px;height:180px}
.lcp-pct{font-size:46px}
}
@media (prefers-reduced-motion:reduce){
.lcp-h,.lcp-crown,.lcp-heart-mid,.lcp-cupid svg,.lcp-lo-heart,.lcp-lo-ring,.lcp-btn-bg,.lcp-btn-heart,.lcp-cp-link,.lcp-bubble{animation:none !important}
.lcp-card{transition:none !important}
}
CSS;
	}
}

/* ---------------------------------------------------------------------------
 * JavaScript
 * ------------------------------------------------------------------------- */

if ( ! function_exists( 'lcp_get_js' ) ) {
	function lcp_get_js() {
		return <<<'JS'
(function(){
"use strict";
var I18N={
en:{title:"Love Calculator",sub:"Find your true love percentage",advanced:"Advanced",your_name:"Your Name",partner_name:"Partner's Name",your_dob:"Your Date of Birth",partner_dob:"Partner's Date of Birth",male:"Male",female:"Female",status:"Relationship Status",st_crush:"💕 Crush",st_dating:"💑 Dating",st_committed:"💖 Committed",st_married:"💍 Married",calculate:"Calculate Love",trust1:"⚡ Instant",trust2:"🔒 100% Private",trust3:"💝 Free Forever",reading:"Reading the energy of love…",dimensions:"Compatibility Dimensions",emotional:"Emotional",communication:"Communication",trust:"Trust",romance:"Romance",future:"Future Vision",result_tag:"Your love story",try_again:"Try Again",share:"Share",save:"Save",download:"Download Card",tab_golden:"✨ Golden Hint",tab_pro:"💡 Pro Tip",tab_life:"🌿 Life Lesson",tab_boost:"🚀 Score Boost",tab_next:"🎯 What Next",ex_song:"Love Song for You",ex_date:"Date Idea",ex_lucky:"Lucky Day",history:"Your History",clear:"Clear",prem_title:"Get Your Couple Report",prem_text:"Full birth-chart compatibility, daily love forecast and 50-page personal couple analysis.",err_required:"Please enter both names.",err_short:"Names should be at least 2 letters long.",err_same:"Names look identical. Try slightly different ones.",err_dob:"Please add both dates of birth for advanced mode.",step1:"Counting heartbeats…",step2:"Reading the LOVES letters…",step3:"Aligning the stars…",step4:"Crafting your love story…",save_done:"Saved to your history!",copy_done:"Result copied to clipboard!"},
hi:{title:"लव कैलकुलेटर",sub:"अपना सच्चा प्यार प्रतिशत जानें",advanced:"एडवांस्ड",your_name:"आपका नाम",partner_name:"साथी का नाम",your_dob:"आपकी जन्म तिथि",partner_dob:"साथी की जन्म तिथि",male:"पुरुष",female:"महिला",status:"रिश्ते की स्थिति",st_crush:"💕 क्रश",st_dating:"💑 डेटिंग",st_committed:"💖 कमिटेड",st_married:"💍 शादीशुदा",calculate:"लव कैलकुलेट करें",trust1:"⚡ तुरंत",trust2:"🔒 पूरी तरह निजी",trust3:"💝 हमेशा फ्री",reading:"प्यार की ऊर्जा पढ़ी जा रही है…",dimensions:"कम्पैटिबिलिटी डायमेंशन्स",emotional:"भावनात्मक",communication:"संवाद",trust:"विश्वास",romance:"रोमांस",future:"भविष्य दृष्टि",result_tag:"आपकी प्रेम कहानी",try_again:"फिर से करें",share:"शेयर करें",save:"सेव करें",download:"कार्ड डाउनलोड",tab_golden:"✨ गोल्डन हिंट",tab_pro:"💡 प्रो टिप",tab_life:"🌿 ज़िंदगी का सबक",tab_boost:"🚀 स्कोर बूस्ट",tab_next:"🎯 आगे क्या",ex_song:"आपके लिए लव सॉन्ग",ex_date:"डेट आइडिया",ex_lucky:"लकी दिन",history:"आपकी हिस्ट्री",clear:"मिटाएँ",prem_title:"अपनी कपल रिपोर्ट पाएँ",prem_text:"पूरा जन्म-कुंडली मिलान, डेली लव हॉरोस्कोप और 50-पेज की निजी कपल एनालिसिस।",err_required:"कृपया दोनों नाम भरें।",err_short:"नाम कम से कम 2 अक्षर का हो।",err_same:"दोनों नाम एक जैसे लग रहे हैं, थोड़े अलग आज़माएँ।",err_dob:"एडवांस्ड मोड के लिए दोनों जन्म तिथि भरें।",step1:"दिल की धड़कनें गिनी जा रही हैं…",step2:"L-O-V-E-S अक्षर पढ़े जा रहे हैं…",step3:"सितारों का मिलान हो रहा है…",step4:"आपकी प्रेम कहानी बन रही है…",save_done:"हिस्ट्री में सेव हुआ!",copy_done:"रिज़ल्ट कॉपी हो गया!"}
};
var TIERS={
soul:{min:90,max:100,name:{en:"Soul Connection",hi:"आत्मा का बंधन"},quote:{en:"Two souls that recognize each other from the start — this is rare. Treat it like the gift it is.",hi:"दो आत्माएँ जो पहली बार में ही पहचान लें — ये दुर्लभ है। इसे एक तोहफ़े की तरह संभालो।"},content:{en:{golden:{h:"You found your home, not just a person",t:"This level of compatibility doesn't happen by accident. The universe rarely gives the same opportunity twice — protect it with respect, honesty and intentional choices every single day."},protip:{h:"Don't get lazy with the magic",t:"The biggest risk for soul-level couples is taking it for granted. Schedule romance like you schedule meetings. Send the message. Plan the date. Say the words."},life:{h:"Love this real changes you",t:"You will grow because of them — and they because of you. Don't fear the change. The healthiest love expands both people, never shrinks them."},boost:{h:"From 90% to 99%",t:"Add one weekly ritual: a no-phone hour together, a Sunday gratitude exchange, or a couple journal. Tiny rituals turn extraordinary love into legendary love."},next:{h:"Build a forever blueprint",t:"Talk about the next 5 years — not just feelings but logistics: home, finances, family, lifestyle. Soul connection plus clarity equals an unshakable forever."}},hi:{golden:{h:"आपको इंसान नहीं, घर मिला है",t:"इतना गहरा मेल इत्तेफ़ाक से नहीं होता। ब्रह्मांड एक मौक़ा बार-बार नहीं देता — रोज़ ईमानदारी, सम्मान और सोच-समझ कर इसकी हिफ़ाज़त करो।"},protip:{h:"जादू को आदत मत बनने दो",t:"सोल-लेवल जोड़ी के लिए सबसे बड़ा ख़तरा है — इसे फॉर ग्रांटेड लेना। रोमांस को मीटिंग की तरह शेड्यूल करो। मैसेज भेजो। डेट प्लान करो। शब्द बोलो।"},life:{h:"ये सच्चा प्यार आपको बदल देगा",t:"उनकी वजह से आप बढ़ेंगे, और आपकी वजह से वो। बदलाव से मत डरो। सबसे स्वस्थ प्यार दोनों को फैलाता है, सिकोड़ता नहीं।"},boost:{h:"90% से 99% तक",t:"एक साप्ताहिक रिवाज़ जोड़ो — बिना फ़ोन का एक घंटा साथ, रविवार की कृतज्ञता बातचीत, या कपल जर्नल। छोटी आदतें असाधारण प्यार को अमर बना देती हैं।"},next:{h:"हमेशा का खाका बनाओ",t:"अगले 5 साल पर बात करो — भावनाएँ ही नहीं, ज़मीनी बातें: घर, पैसा, परिवार, लाइफस्टाइल। सोल कनेक्शन + साफ़ नज़र = अटूट रिश्ता।"}}}},
strong:{min:75,max:89,name:{en:"Strong Love",hi:"मज़बूत प्यार"},quote:{en:"This is real, this is solid, this can go the distance — if you both keep showing up.",hi:"ये असली है, ठोस है, और लंबा चल सकता है — अगर दोनों मौजूद रहें।"},content:{en:{golden:{h:"You have a solid foundation",t:"This is the love most people are looking for. You have the chemistry, the comfort and the capacity. Don't second-guess what's working — water it instead of testing it."},protip:{h:"Move from passion to partnership",t:"In the first stage you chase, in the second you build. Decide together — what are we building? A home? A family? A dream? Shared building doubles the bond."},life:{h:"The honeymoon ends, the love deepens",t:"Strong love isn't about constant fireworks. It's the steady fire you can warm a whole life beside. Stop chasing the spark, start tending the flame."},boost:{h:"From 80% to 90%",t:"Pick one thing each that frustrates the other and quietly improve it for 30 days. Don't announce it. Let them notice. Silent self-improvement is the deepest love letter."},next:{h:"Define your version of forever",t:"Have the honest 'state of us' conversation. Where do we want to live? Kids or not? Career sacrifices? The earlier you align, the smoother the road."}},hi:{golden:{h:"आपकी नींव मज़बूत है",t:"ज़्यादातर लोग ऐसे ही प्यार की तलाश में रहते हैं। आप में केमिस्ट्री, आराम और क्षमता तीनों हैं। जो चल रहा है उसे टेस्ट मत करो — सींचो।"},protip:{h:"पैशन से पार्टनरशिप तक बढ़ो",t:"पहले स्टेज में पीछा करते हैं, दूसरे में बनाते हैं। साथ तय करो — हम क्या बना रहे हैं? घर? परिवार? सपना? साथ बनाना रिश्ता दोगुना मज़बूत करता है।"},life:{h:"हनीमून ख़त्म, प्यार गहरा",t:"मज़बूत प्यार लगातार आतिशबाज़ी नहीं है। ये वो धीमी आँच है जिसके पास पूरी ज़िंदगी गर्म रह सकती है। चिंगारी ढूँढना बंद करो, लौ संभालना शुरू करो।"},boost:{h:"80% से 90% तक",t:"एक-एक बात चुनो जो दूसरे को परेशान करती है और 30 दिन चुपचाप उसे सुधारो। मत बताओ। उन्हें ख़ुद देखने दो। चुपचाप का सुधार सबसे गहरा लव लेटर है।"},next:{h:"अपना 'हमेशा' तय करो",t:"ईमानदार 'हम कहाँ हैं' बातचीत करो। कहाँ रहना है? बच्चे? करियर बलिदान? जितनी जल्दी मेल खाएँगे, उतना सफ़र आसान।"}}}},
warm:{min:60,max:74,name:{en:"Warm Match",hi:"गर्म जोड़ी"},quote:{en:"You're a good match — the foundations are there, the fire just needs feeding.",hi:"आप अच्छी जोड़ी हैं — नींव तैयार है, बस आग को खुराक चाहिए।"},content:{en:{golden:{h:"Potential is high — effort is everything",t:"You're not at 'meant to be' yet, but you have enough material to build it. Most great loves started here. Don't dismiss this just because it isn't fireworks yet."},protip:{h:"Stop testing, start investing",t:"Many relationships at this stage fail because both people are waiting to see if the other will commit first. Be the one who invests. Real love grows where consistent effort is poured."},life:{h:"Comfort over chemistry",t:"Sometimes 'meh' chemistry hides 'wow' compatibility. Don't chase butterflies — chase peace. The right person makes your life calmer, not more dramatic."},boost:{h:"From 65% to 80%",t:"Spend deliberate quality time — phones away, real conversations, shared experiences. Score grows fastest when both people choose presence over performance."},next:{h:"Decide your direction",t:"Don't drift. Have a casual but clear chat about where this is going. Mutual clarity is a relationship multiplier. Mismatched expectations is the silent killer."}},hi:{golden:{h:"संभावना ज़्यादा है — मेहनत ही सब कुछ है",t:"अभी 'हमेशा के लिए' तक नहीं पहुँचे, लेकिन इतना मसाला है कि बना सकते हो। बड़ी प्रेम कहानियाँ यहीं से शुरू हुई हैं। अभी आतिशबाज़ी नहीं है, इसलिए इसे कम मत समझो।"},protip:{h:"टेस्ट करना बंद, इन्वेस्ट करना शुरू",t:"इस स्टेज पर बहुत से रिश्ते इसलिए टूटते हैं क्योंकि दोनों इंतज़ार कर रहे होते हैं कि दूसरा पहले कमिट करे। आप पहले इन्वेस्ट करो। जहाँ निरंतर मेहनत बहती है, वहीं असली प्यार उगता है।"},life:{h:"केमिस्ट्री से ज़्यादा सुकून",t:"कई बार 'सो-सो' केमिस्ट्री के पीछे 'वाह' कम्पैटिबिलिटी छिपी होती है। तितलियों के पीछे मत भागो — शांति के पीछे भागो। सही इंसान ज़िंदगी शांत करता है, नाटकीय नहीं।"},boost:{h:"65% से 80% तक",t:"जानबूझकर क्वालिटी टाइम बिताओ — फ़ोन दूर, असली बातचीत, साझा अनुभव। जब दोनों परफ़ॉर्मेंस छोड़ कर मौजूदगी चुनते हैं, स्कोर सबसे तेज़ बढ़ता है।"},next:{h:"दिशा तय करो",t:"बहो मत। हलकी-फुलकी मगर साफ़ बातचीत करो कि ये कहाँ जा रहा है। साझा साफ़ नज़र रिश्ता दोगुना करती है। बिना-कहा अंदाज़ा सबसे चुप क़ातिल है।"}}}},
spark:{min:40,max:59,name:{en:"Light Spark",hi:"हल्की चिंगारी"},quote:{en:"There's something here — small, but real. Whether it grows depends on what you both feed it.",hi:"यहाँ कुछ है — छोटा, लेकिन सच्चा। बढ़ेगा या नहीं ये आप दोनों के पोषण पर निर्भर है।"},content:{en:{golden:{h:"It's early — don't write the ending",t:"A 40-59% score doesn't mean 'no'. It means 'too early to tell'. Many lifelong loves looked exactly like this in the first few months. Time, effort and honesty will reveal the truth."},protip:{h:"Build chemistry through shared moments",t:"Chemistry isn't magic — it's manufactured. New experiences, eye contact, vulnerability, laughter, music. Engineer the conditions and watch the spark grow."},life:{h:"Love at first sight is rare — love after deep knowing is everywhere",t:"Don't worship the first impression. The best partners often grow on you. Stay open without forcing. The right answer reveals itself in time."},boost:{h:"From 50% to 70%",t:"Try the 7-7-7 plan: 7 long conversations, 7 shared activities, 7 meals together — over 7 weeks. If the score grows, it's real. If not, you've learned something valuable."},next:{h:"Choose curiosity over conclusion",t:"Don't decide yet. Ask better questions. Listen with full attention. Notice how you feel after spending time — energized or drained? Your body knows before your mind does."}},hi:{golden:{h:"अभी जल्दी है — अंत मत लिखो",t:"40-59% का मतलब 'नहीं' नहीं है। मतलब है 'अभी कहना जल्दबाज़ी'। बहुत सी ज़िंदगी भर की प्रेम कहानियाँ शुरुआत में ऐसी ही दिखती थीं। समय, मेहनत और ईमानदारी सच्चाई दिखाएगी।"},protip:{h:"साझा पलों से केमिस्ट्री बनाओ",t:"केमिस्ट्री जादू नहीं है — बनाई जाती है। नए अनुभव, आँखों का संपर्क, खुलापन, हँसी, संगीत। हालात बनाओ और चिंगारी को बढ़ते देखो।"},life:{h:"पहली नज़र का प्यार दुर्लभ — गहरे जानने के बाद का प्यार सब जगह",t:"पहली छाप की पूजा मत करो। बेहतरीन साथी अक्सर धीरे-धीरे दिल में बसते हैं। ज़बरदस्ती के बिना खुले रहो। सही जवाब वक़्त के साथ ख़ुद सामने आता है।"},boost:{h:"50% से 70% तक",t:"7-7-7 प्लान आज़माओ: 7 लंबी बातचीत, 7 साझा गतिविधियाँ, 7 साथ खाने — 7 हफ़्तों में। अगर स्कोर बढ़े तो सच्चा है। नहीं बढ़े तो भी सीख ज़रूर मिली।"},next:{h:"नतीजे से ज़्यादा जिज्ञासा चुनो",t:"अभी फ़ैसला मत करो। बेहतर सवाल पूछो। ध्यान से सुनो। समय बिताने के बाद ध्यान दो — ऊर्जा मिली या निकली? शरीर दिमाग से पहले जान जाता है।"}}}},
cool:{min:0,max:39,name:{en:"Cool Waters",hi:"ठंडा पानी"},quote:{en:"The score is low — but low love doesn't mean low value. Maybe this is exactly the right kind of distance.",hi:"स्कोर कम है — मगर कम प्यार का मतलब कम क़ीमत नहीं। शायद यही सही दूरी है।"},content:{en:{golden:{h:"Low score isn't failure — it's information",t:"Sometimes the score is telling you what you already know but don't want to hear. Some people are wonderful, just not for you. Friendship, business, family — same person can be perfect in a different lane."},protip:{h:"Friendship may be the real prize",t:"Some of the strongest friendships exist between people who are 'wrong' for romance but 'right' for life. Don't waste a beautiful friendship trying to force it into a romance."},life:{h:"The wrong person is just the wrong person",t:"It's nobody's fault. No one is broken. You just don't fit the way two pieces of a puzzle don't fit — and that's totally okay. Save your love for where it actually multiplies."},boost:{h:"Or — don't boost it",t:"This is the rare case where the best advice is: maybe don't. Save your energy for someone the universe actually built for you. A low score with the wrong person can become a high score with the right one."},next:{h:"Re-define the relationship",t:"Have an honest, kind conversation. 'I value you but I don't think we're meant to be romantic.' Real strength is choosing truth over comfortable lies. Both of you deserve the right kind of love."}},hi:{golden:{h:"कम स्कोर असफलता नहीं — जानकारी है",t:"कई बार स्कोर वो बताता है जो आप पहले से जानते हैं पर सुनना नहीं चाहते। कुछ लोग शानदार होते हैं, बस आपके लिए नहीं। दोस्ती, कारोबार, परिवार — वही इंसान दूसरी राह पर परफ़ेक्ट हो सकता है।"},protip:{h:"शायद असली इनाम दोस्ती है",t:"कुछ सबसे मज़बूत दोस्तियाँ उन लोगों में होती हैं जो रोमांस के लिए 'ग़लत' हैं पर ज़िंदगी के लिए 'सही'। एक खूबसूरत दोस्ती को ज़बरदस्ती रोमांस में मत बदलो।"},life:{h:"ग़लत इंसान सिर्फ़ ग़लत इंसान है",t:"किसी की ग़लती नहीं है। कोई टूटा नहीं है। आप बस फिट नहीं होते जैसे दो पज़ल पीस फिट नहीं होते — और ये बिल्कुल ठीक है। अपना प्यार वहाँ बचाओ जहाँ वो वाक़ई गुणा हो।"},boost:{h:"या — मत बढ़ाओ",t:"ये वो दुर्लभ केस है जहाँ सबसे अच्छी सलाह है: शायद मत करो। अपनी ऊर्जा उस इंसान के लिए बचाओ जिसे ब्रह्मांड ने आपके लिए बनाया है। ग़लत इंसान के साथ कम स्कोर, सही के साथ ऊँचा स्कोर बन सकता है।"},next:{h:"रिश्ते की नई परिभाषा बनाओ",t:"ईमानदार, नर्म बातचीत करो — 'मैं आपकी क़द्र करता हूँ पर मुझे नहीं लगता हम रोमांटिक रूप से सही हैं।' असली ताक़त है सच्चाई चुनना, झूठी राहत नहीं। दोनों को सही तरह का प्यार मिलने का हक़ है।"}}}}
};
var SONGS=["Perfect — Ed Sheeran","All of Me — John Legend","Tum Hi Ho — Arijit Singh","Tera Ban Jaunga — Akhil Sachdeva","Thinking Out Loud — Ed Sheeran","Kabira — Tochi Raina","A Thousand Years — Christina Perri","Pehla Nasha — Udit Narayan","Can't Help Falling in Love — Elvis","Channa Mereya — Arijit Singh","At My Worst — Pink Sweat$","Tum Se Hi — Mohit Chauhan"];
var DATES=["A long walk at sunset with hot chai","Cooking a new recipe together","Stargazing on a terrace","A surprise mini road-trip","Movie marathon with their favourite snacks","Visit a bookstore — pick a book for each other","Try a new cuisine you've never had","Plant a tree together","Spa night at home","Watch the first rain together"];
function init(ROOT){
if(!ROOT||ROOT.dataset.lcpInit==="1")return;
ROOT.dataset.lcpInit="1";
function $(s,r){return (r||ROOT).querySelector(s);}
function $$(s,r){return Array.prototype.slice.call((r||ROOT).querySelectorAll(s));}
function clamp(v,a,b){return Math.max(a,Math.min(b,v));}
function show(el){if(el){el.style.display="";el.removeAttribute("hidden");}}
function hide(el){if(el){el.style.display="none";}}
var lang=ROOT.dataset.lang==="hi"?"hi":"en";
var mode=ROOT.dataset.mode==="advanced"?"advanced":"basic";
var soundOn=ROOT.dataset.sound==="1";
var hapticsOn=ROOT.dataset.haptics==="1";
var gender1="male",gender2="female",status="crush";
function applyI18n(){var dict=I18N[lang];$$("[data-i18n]").forEach(function(el){var key=el.getAttribute("data-i18n");if(dict[key])el.textContent=dict[key];});var today=new Date().toISOString().split("T")[0];var d1=$(".lcp-dob1"),d2=$(".lcp-dob2");if(d1)d1.setAttribute("max",today);if(d2)d2.setAttribute("max",today);}
function cleanName(s){return (s||"").toLowerCase().replace(/[^a-zऀ-ॿ]/g,"");}
function lovesScore(n1,n2){
  var combined=(n1+n2).toLowerCase().replace(/[^a-z]/g,"");
  if(!combined)return 50;
  var loves="loves";
  var counts=[];
  for(var i=0;i<loves.length;i++){var c=0;for(var j=0;j<combined.length;j++)if(combined[j]===loves[i])c++;counts.push(c);}
  var digits=counts.join("");
  while(digits.length>2){
    var nd="";var a=0,b=digits.length-1;
    while(a<b){nd+=(parseInt(digits[a],10)+parseInt(digits[b],10));a++;b--;}
    if(a===b)nd+=digits[a];
    digits=nd;
  }
  var v=parseInt(digits,10)||0;
  if(v>100)v=parseInt(String(v).slice(-2),10);
  return clamp(v,5,99);
}
function nameOverlap(a,b){var sa=a.toLowerCase().replace(/[^a-z]/g,"").split("");var sb=b.toLowerCase().replace(/[^a-z]/g,"").split("");var common=0;var bc=sb.slice();sa.forEach(function(c){var i=bc.indexOf(c);if(i>-1){common++;bc.splice(i,1);}});var total=sa.length+sb.length;return total===0?50:Math.round((common*2/total)*100);}
function nameNum(n){var s=n.toLowerCase().replace(/[^a-z]/g,"");var sum=0;for(var i=0;i<s.length;i++)sum+=(s.charCodeAt(i)-96);while(sum>9&&sum!==11&&sum!==22){var t=0;String(sum).split("").forEach(function(d){t+=parseInt(d,10);});sum=t;}return sum||1;}
function numerologyMatch(a,b){var key=Math.min(a,b)+"-"+Math.max(a,b);var t={"1-1":82,"1-2":70,"1-3":88,"1-4":60,"1-5":92,"1-6":74,"1-7":66,"1-8":70,"1-9":86,"2-2":80,"2-3":72,"2-4":84,"2-5":66,"2-6":92,"2-7":82,"2-8":78,"2-9":70,"3-3":84,"3-4":62,"3-5":86,"3-6":92,"3-7":74,"3-8":70,"3-9":94,"4-4":82,"4-5":62,"4-6":82,"4-7":86,"4-8":92,"4-9":62,"5-5":80,"5-6":70,"5-7":82,"5-8":70,"5-9":84,"6-6":92,"6-7":70,"6-8":82,"6-9":94,"7-7":86,"7-8":70,"7-9":80,"8-8":84,"8-9":70,"9-9":92};return t[key]||70;}
function zodiacFromDate(d){if(!d)return null;var dt=new Date(d);if(isNaN(dt))return null;var m=dt.getMonth()+1,day=dt.getDate();var r=[["Capricorn",[12,22],[1,19]],["Aquarius",[1,20],[2,18]],["Pisces",[2,19],[3,20]],["Aries",[3,21],[4,19]],["Taurus",[4,20],[5,20]],["Gemini",[5,21],[6,20]],["Cancer",[6,21],[7,22]],["Leo",[7,23],[8,22]],["Virgo",[8,23],[9,22]],["Libra",[9,23],[10,22]],["Scorpio",[10,23],[11,21]],["Sagittarius",[11,22],[12,21]]];for(var i=0;i<r.length;i++){var z=r[i],s=z[1],e=z[2];if((m===s[0]&&day>=s[1])||(m===e[0]&&day<=e[1]))return z[0];}return "Capricorn";}
function zodiacScore(a,b){if(!a||!b)return 70;var el={fire:["Aries","Leo","Sagittarius"],earth:["Taurus","Virgo","Capricorn"],air:["Gemini","Libra","Aquarius"],water:["Cancer","Scorpio","Pisces"]};function eo(z){for(var k in el)if(el[k].indexOf(z)>-1)return k;return "";}var e1=eo(a),e2=eo(b);if(a===b)return 86;if(e1===e2)return 90;if((e1==="fire"&&e2==="air")||(e1==="air"&&e2==="fire"))return 88;if((e1==="earth"&&e2==="water")||(e1==="water"&&e2==="earth"))return 88;if((e1==="fire"&&e2==="water")||(e1==="water"&&e2==="fire"))return 60;if((e1==="earth"&&e2==="air")||(e1==="air"&&e2==="earth"))return 64;return 72;}
function dimsFrom(total,statusBonus){function dist(seed,base){var v=base+((seed%23)-11);return clamp(v,30,99);}var s=Math.abs(total*31+7);var bias=statusBonus||0;return {emo:dist(s,total)+bias,com:dist(s>>1,total-4)+bias,tru:dist(s>>2,total-2)+bias,rom:dist(s>>3,total+3),fut:dist(s>>4,total-6)+bias};}
function getTier(score){if(score>=90)return TIERS.soul;if(score>=75)return TIERS.strong;if(score>=60)return TIERS.warm;if(score>=40)return TIERS.spark;return TIERS.cool;}
function pickFrom(arr,seed){return arr[Math.abs(seed)%arr.length];}
function luckyDay(seed){var days=["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"];var daysHi=["सोमवार","मंगलवार","बुधवार","गुरुवार","शुक्रवार","शनिवार","रविवार"];return lang==="hi"?daysHi[Math.abs(seed)%7]:days[Math.abs(seed)%7];}
var audioCtx=null;
function beep(freq,dur,type){if(!soundOn)return;try{audioCtx=audioCtx||new (window.AudioContext||window.webkitAudioContext)();var o=audioCtx.createOscillator();var g=audioCtx.createGain();o.type=type||"sine";o.frequency.value=freq;g.gain.value=0.06;o.connect(g);g.connect(audioCtx.destination);o.start();g.gain.exponentialRampToValueAtTime(0.0001,audioCtx.currentTime+(dur||0.18));o.stop(audioCtx.currentTime+(dur||0.18)+0.02);}catch(e){}}
function buzz(ms){if(!hapticsOn)return;try{if(navigator.vibrate)navigator.vibrate(ms||12);}catch(e){}}
function setError(msg){var box=$(".lcp-err");if(!box)return;if(msg){box.textContent=msg;box.classList.add("is-on");box.style.display="block";buzz(40);}else{box.textContent="";box.classList.remove("is-on");box.style.display="none";}}
function capWords(s){return (s||"").replace(/\b[a-zऀ-ॿ]/g,function(c){return c.toUpperCase();});}
function animateNum(el,from,to,dur){if(!el)return;var t0=(typeof performance!=="undefined"&&performance.now)?performance.now():Date.now();function step(t){var now=t||((typeof performance!=="undefined"&&performance.now)?performance.now():Date.now());var p=clamp((now-t0)/dur,0,1);var v=Math.round(from+(to-from)*(1-Math.pow(1-p,3)));if(!isNaN(v))el.textContent=v;if(p<1)requestAnimationFrame(step);else el.textContent=to;}step();}
function confetti(){var box=$(".lcp-confetti");if(!box)return;box.innerHTML="";box.classList.add("is-go");var emojis=["❤","💖","💕","💗","💝","🌹"];for(var i=0;i<28;i++){var p=document.createElement("span");p.className="lcp-conf-piece";p.textContent=emojis[i%emojis.length];p.style.left=(50+(Math.random()*40-20))+"%";p.style.top="100px";p.style.setProperty("--lcp-x",(Math.random()*600-300)+"px");p.style.setProperty("--lcp-y",(Math.random()*-360-60)+"px");p.style.animationDelay=(Math.random()*0.25)+"s";box.appendChild(p);}setTimeout(function(){box.classList.remove("is-go");box.innerHTML="";},1700);}
function fillAdvice(pane,obj){var card=$(".lcp-adv-card[data-pane=\""+pane+"\"]");if(card){card.querySelector("h4").textContent=obj.h;card.querySelector("p").textContent=obj.t;}}
function showResult(state){
  var tier=getTier(state.total);
  var initA=(state.names.n1[0]||"?").toUpperCase();
  var initB=(state.names.n2[0]||"?").toUpperCase();
  $(".lcp-cp-a .lcp-init").textContent=initA;
  $(".lcp-cp-b .lcp-init").textContent=initB;
  $(".lcp-cp-a strong").textContent=capWords(state.names.n1);
  $(".lcp-cp-b strong").textContent=capWords(state.names.n2);
  setTimeout(function(){
    var fill=$(".lcp-heart-fill");
    if(fill){fill.setAttribute("y", String(200 - (state.total*2)));}
    animateNum($(".lcp-pct"),0,state.total,1600);
  },80);
  $(".lcp-tier-name").textContent=tier.name[lang];
  var qt=(tier.quote && (tier.quote[lang] || tier.quote.en))||"";
  $(".lcp-quote-text").textContent=qt;
  var content=tier.content[lang]||tier.content.en;
  fillAdvice("golden",content.golden);
  fillAdvice("protip",content.protip);
  fillAdvice("life",content.life);
  fillAdvice("boost",content.boost);
  fillAdvice("next",content.next);
  if(state.dims){
    show($(".lcp-radar"));
    var keys=["emo","com","tru","rom","fut"];
    setTimeout(function(){
      keys.forEach(function(k){
        var bar=ROOT.querySelector(".lcp-bar-fill[data-k=\""+k+"\"]");
        if(bar){bar.style.width=state.dims[k]+"%";var lbl=bar.parentNode.querySelector(".lcp-bar-val");if(lbl)lbl.textContent=state.dims[k]+"%";}
      });
    },120);
  }else{hide($(".lcp-radar"));}
  show($(".lcp-advice"));
  var seed=(state.names.n1+state.names.n2).split("").reduce(function(a,c){return a+c.charCodeAt(0);},0);
  $(".lcp-ex-song").textContent=pickFrom(SONGS,seed);
  $(".lcp-ex-date").textContent=pickFrom(DATES,seed*3);
  $(".lcp-ex-lucky").textContent=luckyDay(seed*7);
  show($(".lcp-extras"));
  confetti();buzz([20,40,20]);beep(880,0.18,"sine");
  var prem=$(".lcp-premium");
  if(ROOT.dataset.premium==="1"&&ROOT.dataset.premiumUrl){prem.querySelector(".lcp-prem-cta").href=ROOT.dataset.premiumUrl;prem.querySelector(".lcp-prem-cta").textContent=ROOT.dataset.premiumLabel||"Premium";show(prem);}
  var midAd=ROOT.querySelector(".lcp-ad-mid");if(midAd)show(midAd);
  ROOT._lcpState=state;
  if(ROOT.dataset.history==="1")saveHist(state);
}
var HKEY="lcp_history_v1";
function loadHist(){try{return JSON.parse(localStorage.getItem(HKEY)||"[]");}catch(e){return [];}}
function saveHistArr(a){try{localStorage.setItem(HKEY,JSON.stringify(a.slice(0,8)));}catch(e){}}
function saveHist(state){var a=loadHist();a.unshift({a:state.names.n1,b:state.names.n2,s:state.total,t:Date.now()});saveHistArr(a);renderHist();}
function renderHist(){if(ROOT.dataset.history!=="1")return;var a=loadHist();var box=$(".lcp-history"),list=$(".lcp-hist-list");if(!box||!list)return;if(!a.length){hide(box);return;}show(box);list.innerHTML="";a.forEach(function(it){var li=document.createElement("li");li.innerHTML="<span>"+esc(capWords(it.a))+" ❤ "+esc(capWords(it.b))+"</span> <b>"+it.s+"%</b>";list.appendChild(li);});}
function esc(s){return (s||"").replace(/[&<>"']/g,function(c){return ({"&":"&amp;","<":"&lt;",">":"&gt;","\"":"&quot;","'":"&#39;"})[c];});}
function shareResult(){var st=ROOT._lcpState;if(!st)return;var tier=getTier(st.total);var txt=capWords(st.names.n1)+" ❤ "+capWords(st.names.n2)+" = "+st.total+"% — "+tier.name[lang];if(navigator.share){navigator.share({title:I18N[lang].title,text:txt,url:location.href}).catch(function(){});}else{if(navigator.clipboard)navigator.clipboard.writeText(txt+" — "+location.href);toast(I18N[lang].copy_done);}}
function downloadCard(){var st=ROOT._lcpState;if(!st)return;var tier=getTier(st.total);var canvas=$(".lcp-share-canvas");var ctx=canvas.getContext("2d");var W=canvas.width,H=canvas.height;var g=ctx.createLinearGradient(0,0,W,H);g.addColorStop(0,"#FFF8F2");g.addColorStop(1,"#FFE4EC");ctx.fillStyle=g;ctx.fillRect(0,0,W,H);var rg=ctx.createRadialGradient(W*0.7,H*0.25,0,W*0.7,H*0.25,W*0.6);rg.addColorStop(0,"rgba(230,62,98,0.20)");rg.addColorStop(1,"transparent");ctx.fillStyle=rg;ctx.fillRect(0,0,W,H);ctx.fillStyle="#8B1A3A";ctx.font="bold 56px Georgia,serif";ctx.textAlign="center";ctx.fillText(I18N[lang].title,W/2,140);ctx.font="38px Georgia,serif";ctx.fillStyle="#3a1f33";ctx.fillText(capWords(st.names.n1)+"   ❤   "+capWords(st.names.n2),W/2,240);ctx.beginPath();var cx=W/2,cy=600,sz=200;ctx.moveTo(cx,cy+sz*0.8);ctx.bezierCurveTo(cx-sz*1.5,cy,cx-sz,cy-sz,cx,cy-sz*0.4);ctx.bezierCurveTo(cx+sz,cy-sz,cx+sz*1.5,cy,cx,cy+sz*0.8);var hg=ctx.createLinearGradient(0,cy-sz,0,cy+sz);hg.addColorStop(0,"#FF6F91");hg.addColorStop(1,"#E63E62");ctx.fillStyle=hg;ctx.fill();ctx.fillStyle="#fff";ctx.font="bold 130px Georgia,serif";ctx.fillText(st.total+"%",W/2,640);ctx.fillStyle="#8B1A3A";ctx.font="bold 56px Georgia,serif";ctx.fillText(tier.name[lang],W/2,860);ctx.font="italic 26px Georgia,serif";ctx.fillStyle="#3a1f33";var qt=(tier.quote && (tier.quote[lang]||tier.quote.en))||"";if(qt.length>70)qt=qt.slice(0,68)+"…";ctx.fillText('"'+qt+'"',W/2,920);ctx.font="22px sans-serif";ctx.fillStyle="rgba(58,31,51,0.5)";ctx.fillText(location.host,W/2,1020);var link=document.createElement("a");link.download="love-result.png";link.href=canvas.toDataURL("image/png");link.click();}
function toast(msg){var t=document.createElement("div");t.textContent=msg;t.style.cssText="position:fixed;left:50%;bottom:24px;transform:translateX(-50%);background:rgba(60,12,32,0.95);color:#fff;padding:10px 18px;border-radius:12px;font-family:system-ui,sans-serif;font-size:14px;z-index:99999;box-shadow:0 12px 30px rgba(0,0,0,0.4)";document.body.appendChild(t);setTimeout(function(){t.style.transition="opacity .35s";t.style.opacity="0";setTimeout(function(){t.remove();},400);},1800);}
function doCalc(e){
  if(e){e.preventDefault();e.stopPropagation();}
  setError("");
  var n1raw=$(".lcp-name1").value.trim();
  var n2raw=$(".lcp-name2").value.trim();
  var n1=cleanName(n1raw),n2=cleanName(n2raw);
  if(!n1||!n2){setError(I18N[lang].err_required);return false;}
  if(n1.length<2||n2.length<2){setError(I18N[lang].err_short);return false;}
  if(n1===n2){setError(I18N[lang].err_same);return false;}
  var dob1=$(".lcp-dob1")?$(".lcp-dob1").value:"";
  var dob2=$(".lcp-dob2")?$(".lcp-dob2").value:"";
  if(mode==="advanced"&&(!dob1||!dob2)){setError(I18N[lang].err_dob);return false;}
  var inp=$(".lcp-input-card"),load=$(".lcp-loading-card"),res=$(".lcp-result-card");
  hide(inp);show(load);hide(res);hide($(".lcp-advice"));hide($(".lcp-extras"));hide($(".lcp-premium"));
  var midAd=ROOT.querySelector(".lcp-ad-mid");if(midAd)hide(midAd);
  var bar=$(".lcp-progress-bar"),txt=$(".lcp-load-txt");
  bar.style.width="0%";
  var steps=[I18N[lang].step1,I18N[lang].step2,I18N[lang].step3,I18N[lang].step4];
  var idx=0;txt.textContent=steps[0];
  var tk=setInterval(function(){idx++;if(idx>=steps.length){clearInterval(tk);return;}txt.textContent=steps[idx];bar.style.width=((idx+1)*25)+"%";},380);
  var lovesV=lovesScore(n1,n2);
  var ovr=nameOverlap(n1,n2);
  var statusBonus={crush:0,dating:3,committed:5,married:7}[status]||0;
  var total,dims=null;
  if(mode==="advanced"){
    var nm=numerologyMatch(nameNum(n1),nameNum(n2));
    var zs=zodiacScore(zodiacFromDate(dob1),zodiacFromDate(dob2));
    total=Math.round(lovesV*0.45+nm*0.20+zs*0.20+ovr*0.15)+statusBonus;
  }else{
    total=Math.round(lovesV*0.65+ovr*0.35)+statusBonus;
  }
  total=clamp(total,15,99);
  dims=dimsFrom(total,Math.round(statusBonus/2));
  setTimeout(function(){
    clearInterval(tk);bar.style.width="100%";
    hide(load);show(res);
    showResult({names:{n1:n1raw,n2:n2raw},total:total,dims:dims,gender:[gender1,gender2],status:status});
  },1700);
  return false;
}
var form=$(".lcp-form");if(form){form.addEventListener("submit",doCalc);}
var goBtn=$(".lcp-go");if(goBtn){goBtn.addEventListener("click",doCalc);}
var againBtn=$(".lcp-act-again");if(againBtn){againBtn.addEventListener("click",function(){hide($(".lcp-result-card"));hide($(".lcp-advice"));hide($(".lcp-extras"));hide($(".lcp-premium"));var midAd2=ROOT.querySelector(".lcp-ad-mid");if(midAd2)hide(midAd2);show($(".lcp-input-card"));setError("");ROOT.scrollIntoView({behavior:"smooth",block:"start"});});}
var shareBtn=$(".lcp-act-share");if(shareBtn){shareBtn.addEventListener("click",shareResult);}
var cardBtn=$(".lcp-act-card");if(cardBtn){cardBtn.addEventListener("click",downloadCard);}
var saveBtn=$(".lcp-act-save");if(saveBtn){saveBtn.addEventListener("click",function(){var st=ROOT._lcpState;if(!st)return;saveHist(st);toast(I18N[lang].save_done);});}
$$(".lcp-adv-tab").forEach(function(btn){btn.addEventListener("click",function(){$$(".lcp-adv-tab").forEach(function(b){b.classList.remove("is-on");});$$(".lcp-adv-card").forEach(function(c){c.classList.remove("is-on");});btn.classList.add("is-on");var pane=btn.getAttribute("data-tab");var card=$(".lcp-adv-card[data-pane=\""+pane+"\"]");if(card)card.classList.add("is-on");});});
var advTgl=$(".lcp-adv-toggle");if(advTgl){advTgl.addEventListener("change",function(){mode=advTgl.checked?"advanced":"basic";ROOT.dataset.mode=mode;});}
$$(".lcp-lang-btn").forEach(function(btn){btn.addEventListener("click",function(){$$(".lcp-lang-btn").forEach(function(b){b.classList.remove("is-on");});btn.classList.add("is-on");lang=btn.getAttribute("data-lang")==="hi"?"hi":"en";ROOT.dataset.lang=lang;applyI18n();renderHist();var st=ROOT._lcpState;if(st){showResult(st);}});});
var sndBtn=$(".lcp-sound-btn");if(sndBtn){sndBtn.addEventListener("click",function(){soundOn=!soundOn;ROOT.dataset.sound=soundOn?"1":"0";});}
var hcBtn=$(".lcp-hist-clear");if(hcBtn){hcBtn.addEventListener("click",function(){saveHistArr([]);renderHist();});}
$$(".lcp-gender1 .lcp-chip").forEach(function(c){c.addEventListener("click",function(){$$(".lcp-gender1 .lcp-chip").forEach(function(b){b.classList.remove("is-on");});c.classList.add("is-on");gender1=c.getAttribute("data-v");});});
$$(".lcp-gender2 .lcp-chip").forEach(function(c){c.addEventListener("click",function(){$$(".lcp-gender2 .lcp-chip").forEach(function(b){b.classList.remove("is-on");});c.classList.add("is-on");gender2=c.getAttribute("data-v");});});
$$(".lcp-status-chip").forEach(function(c){c.addEventListener("click",function(){$$(".lcp-status-chip").forEach(function(b){b.classList.remove("is-on");});c.classList.add("is-on");status=c.getAttribute("data-v");});});
applyI18n();renderHist();
}
function bootAll(){var nodes=document.querySelectorAll(".lcp-wrap");for(var i=0;i<nodes.length;i++)init(nodes[i]);}
if(document.readyState==="loading"){document.addEventListener("DOMContentLoaded",bootAll);}else{bootAll();}
window.addEventListener("load",bootAll);
})();
JS;
	}
}
