<?php
/**
 * Plugin Name: Cosmic Calculator Trio
 * Plugin URI:  https://example.com/cosmic-calculator-trio
 * Description: Three premium 2026 calculators in one plugin — Friendship Calculator, Mulank (Numerology) Calculator and Crush Calculator. Unique Aurora Mystic theme, animated, bilingual EN+HI, golden hints/pro tips/life lessons per result, emoji + career + pet + song + soulmate + horoscope extras, AdSense + Premium ready. Shortcodes: [friendship_calculator] [mulank_calculator] [crush_calculator].
 * Version:     1.0.0
 * Author:      Cosmic Calculator Trio
 * License:     GPL-2.0+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: cosmic-calculator-trio
 * Requires at least: 5.0
 * Requires PHP: 7.0
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( ! defined( 'CCT_VERSION' ) ) { define( 'CCT_VERSION', '1.0.0' ); }
if ( ! defined( 'CCT_OPTION' ) )  { define( 'CCT_OPTION', 'cct_settings' ); }

/* ---------- Defaults & Activation ---------- */
if ( ! function_exists( 'cct_default_settings' ) ) {
	function cct_default_settings() {
		return array(
			'default_lang'         => 'en',
			'sound_default'        => 1,
			'haptics_default'      => 1,
			'show_history'         => 1,
			'show_share'           => 1,
			'show_premium'         => 0,
			'premium_url'          => '',
			'premium_label'        => 'Get Premium',
			'ad_slot_top'          => '',
			'ad_slot_middle'       => '',
			'ad_slot_bottom'       => '',
			'show_lang_toggle'     => 1,
			'show_advanced_toggle' => 1,
		);
	}
}
if ( ! function_exists( 'cct_get_settings' ) ) {
	function cct_get_settings() {
		$s = get_option( CCT_OPTION, array() );
		if ( ! is_array( $s ) ) { $s = array(); }
		return wp_parse_args( $s, cct_default_settings() );
	}
}
if ( ! function_exists( 'cct_activate' ) ) {
	function cct_activate() {
		if ( false === get_option( CCT_OPTION ) ) {
			add_option( CCT_OPTION, cct_default_settings() );
		}
	}
	register_activation_hook( __FILE__, 'cct_activate' );
}

/* ---------- Admin ---------- */
if ( ! function_exists( 'cct_admin_menu' ) ) {
	function cct_admin_menu() {
		add_options_page(
			'Cosmic Calculator Trio',
			'Cosmic Trio',
			'manage_options',
			'cct-settings',
			'cct_render_settings_page'
		);
	}
	add_action( 'admin_menu', 'cct_admin_menu' );
}
if ( ! function_exists( 'cct_render_settings_page' ) ) {
	function cct_render_settings_page() {
		if ( ! current_user_can( 'manage_options' ) ) { return; }
		if ( isset( $_POST['cct_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['cct_nonce'] ) ), 'cct_save' ) ) {
			$new = array(
				'default_lang'         => in_array( ( $_POST['default_lang'] ?? '' ), array( 'en','hi' ), true ) ? $_POST['default_lang'] : 'en',
				'sound_default'        => isset( $_POST['sound_default'] ) ? 1 : 0,
				'haptics_default'      => isset( $_POST['haptics_default'] ) ? 1 : 0,
				'show_history'         => isset( $_POST['show_history'] ) ? 1 : 0,
				'show_share'           => isset( $_POST['show_share'] ) ? 1 : 0,
				'show_premium'         => isset( $_POST['show_premium'] ) ? 1 : 0,
				'premium_url'          => esc_url_raw( wp_unslash( $_POST['premium_url'] ?? '' ) ),
				'premium_label'        => sanitize_text_field( wp_unslash( $_POST['premium_label'] ?? 'Get Premium' ) ),
				'ad_slot_top'          => wp_kses_post( wp_unslash( $_POST['ad_slot_top'] ?? '' ) ),
				'ad_slot_middle'       => wp_kses_post( wp_unslash( $_POST['ad_slot_middle'] ?? '' ) ),
				'ad_slot_bottom'       => wp_kses_post( wp_unslash( $_POST['ad_slot_bottom'] ?? '' ) ),
				'show_lang_toggle'     => isset( $_POST['show_lang_toggle'] ) ? 1 : 0,
				'show_advanced_toggle' => isset( $_POST['show_advanced_toggle'] ) ? 1 : 0,
			);
			update_option( CCT_OPTION, $new );
			echo '<div class="notice notice-success is-dismissible"><p><strong>Settings saved.</strong></p></div>';
		}
		$s = cct_get_settings();
		?>
		<div class="wrap">
			<h1>Cosmic Calculator Trio</h1>
			<p>This plugin provides three calculators with one shared Aurora Mystic theme. Use the shortcodes:</p>
			<ul style="list-style:disc;padding-left:24px">
				<li><code>[friendship_calculator]</code> — Friendship by Name</li>
				<li><code>[mulank_calculator]</code> — Mulank &amp; Bhagyank (Numerology)</li>
				<li><code>[crush_calculator]</code> — Crush Compatibility</li>
			</ul>
			<p>Optional shortcode attributes: <code>lang="en|hi"</code>.</p>
			<form method="post" action="">
				<?php wp_nonce_field( 'cct_save', 'cct_nonce' ); ?>
				<table class="form-table" role="presentation">
					<tr><th scope="row"><label for="default_lang">Default Language</label></th>
						<td><select name="default_lang" id="default_lang">
							<option value="en" <?php selected( $s['default_lang'], 'en' ); ?>>English</option>
							<option value="hi" <?php selected( $s['default_lang'], 'hi' ); ?>>Hindi</option>
						</select></td></tr>
					<tr><th scope="row">Toggles</th><td>
						<label><input type="checkbox" name="show_lang_toggle" value="1" <?php checked( $s['show_lang_toggle'], 1 ); ?>> Show Language toggle (EN / HI)</label><br>
						<label><input type="checkbox" name="show_advanced_toggle" value="1" <?php checked( $s['show_advanced_toggle'], 1 ); ?>> Show Advanced Mode toggle (where applicable)</label><br>
						<label><input type="checkbox" name="show_history" value="1" <?php checked( $s['show_history'], 1 ); ?>> Save user history</label><br>
						<label><input type="checkbox" name="show_share" value="1" <?php checked( $s['show_share'], 1 ); ?>> Show Share buttons</label><br>
						<label><input type="checkbox" name="sound_default" value="1" <?php checked( $s['sound_default'], 1 ); ?>> Sound ON by default</label><br>
						<label><input type="checkbox" name="haptics_default" value="1" <?php checked( $s['haptics_default'], 1 ); ?>> Haptics ON by default</label>
					</td></tr>
					<tr><th scope="row"><label for="show_premium">Premium Upsell</label></th>
						<td><label><input type="checkbox" name="show_premium" id="show_premium" value="1" <?php checked( $s['show_premium'], 1 ); ?>> Show Premium upsell on result</label>
							<p><label for="premium_url">Premium URL:</label><br><input type="url" name="premium_url" id="premium_url" value="<?php echo esc_attr( $s['premium_url'] ); ?>" class="regular-text"></p>
							<p><label for="premium_label">Premium Button Label:</label><br><input type="text" name="premium_label" id="premium_label" value="<?php echo esc_attr( $s['premium_label'] ); ?>" class="regular-text"></p></td></tr>
					<tr><th scope="row"><label for="ad_slot_top">AdSense — Top</label></th>
						<td><textarea name="ad_slot_top" rows="4" class="large-text code"><?php echo esc_textarea( $s['ad_slot_top'] ); ?></textarea></td></tr>
					<tr><th scope="row"><label for="ad_slot_middle">AdSense — After Result</label></th>
						<td><textarea name="ad_slot_middle" rows="4" class="large-text code"><?php echo esc_textarea( $s['ad_slot_middle'] ); ?></textarea></td></tr>
					<tr><th scope="row"><label for="ad_slot_bottom">AdSense — Bottom</label></th>
						<td><textarea name="ad_slot_bottom" rows="4" class="large-text code"><?php echo esc_textarea( $s['ad_slot_bottom'] ); ?></textarea></td></tr>
				</table>
				<?php submit_button( 'Save Settings' ); ?>
			</form>
		</div>
		<?php
	}
}

/* ---------- Shortcodes ---------- */
if ( ! function_exists( 'cct_shortcode_friendship' ) ) {
	function cct_shortcode_friendship( $atts = array() ) { return cct_run_shortcode( 'friendship', $atts ); }
	add_shortcode( 'friendship_calculator', 'cct_shortcode_friendship' );
}
if ( ! function_exists( 'cct_shortcode_mulank' ) ) {
	function cct_shortcode_mulank( $atts = array() ) { return cct_run_shortcode( 'mulank', $atts ); }
	add_shortcode( 'mulank_calculator', 'cct_shortcode_mulank' );
	add_shortcode( 'numerology_calculator', 'cct_shortcode_mulank' );
}
if ( ! function_exists( 'cct_shortcode_crush' ) ) {
	function cct_shortcode_crush( $atts = array() ) { return cct_run_shortcode( 'crush', $atts ); }
	add_shortcode( 'crush_calculator', 'cct_shortcode_crush' );
}
if ( ! function_exists( 'cct_run_shortcode' ) ) {
	function cct_run_shortcode( $tool, $atts ) {
		$atts = shortcode_atts( array( 'lang' => '', 'mode' => '' ), $atts, 'cct_' . $tool );
		$s = cct_get_settings();
		$lang = in_array( $atts['lang'], array( 'en', 'hi' ), true ) ? $atts['lang'] : $s['default_lang'];
		$mode = in_array( $atts['mode'], array( 'basic', 'advanced' ), true ) ? $atts['mode'] : 'basic';
		$GLOBALS['cct_used'] = true;
		$html = cct_get_markup( $tool, $lang, $mode, $s );
		if ( did_action( 'wp_head' ) && empty( $GLOBALS['cct_css_printed'] ) ) {
			$GLOBALS['cct_css_printed'] = true;
			$html = '<style id="cct-styles-fb">' . cct_get_css() . '</style>' . $html;
		}
		return $html;
	}
}

/* ---------- Asset printing (wpautop-safe) ---------- */
if ( ! function_exists( 'cct_should_print_assets' ) ) {
	function cct_should_print_assets() {
		if ( is_admin() ) { return false; }
		if ( ! empty( $GLOBALS['cct_used'] ) ) { return true; }
		if ( function_exists( 'is_singular' ) && is_singular() ) {
			$post = get_post();
			if ( $post ) {
				$codes = array( 'friendship_calculator', 'mulank_calculator', 'numerology_calculator', 'crush_calculator' );
				foreach ( $codes as $c ) { if ( has_shortcode( $post->post_content, $c ) ) { return true; } }
			}
		}
		return false;
	}
}
if ( ! function_exists( 'cct_print_head_css' ) ) {
	function cct_print_head_css() {
		if ( ! cct_should_print_assets() ) { return; }
		if ( ! empty( $GLOBALS['cct_css_printed'] ) ) { return; }
		$GLOBALS['cct_css_printed'] = true;
		echo "\n<style id=\"cct-styles\">" . cct_get_css() . "</style>\n";
	}
	add_action( 'wp_head', 'cct_print_head_css', 99 );
}
if ( ! function_exists( 'cct_print_footer_js' ) ) {
	function cct_print_footer_js() {
		if ( empty( $GLOBALS['cct_used'] ) && ! cct_should_print_assets() ) { return; }
		if ( ! empty( $GLOBALS['cct_js_printed'] ) ) { return; }
		$GLOBALS['cct_js_printed'] = true;
		echo "\n<script id=\"cct-script\">/* Cosmic Calculator Trio */\n" . cct_get_js() . "\n/* end */</script>\n";
	}
	add_action( 'wp_footer', 'cct_print_footer_js', 99 );
}

/* ---------- Markup ---------- */
if ( ! function_exists( 'cct_get_markup' ) ) {
	function cct_get_markup( $tool, $lang, $mode, $s ) {
		$uid = 'cct-' . wp_generate_password( 8, false, false );
		$ad_top = $s['ad_slot_top']; $ad_mid = $s['ad_slot_middle']; $ad_bot = $s['ad_slot_bottom'];
		$icon_svg = cct_get_icon( $tool, $uid );
		$titles = array(
			'friendship' => array( 'en' => 'Friendship Calculator', 'hi' => 'फ्रेंडशिप कैलकुलेटर' ),
			'mulank'     => array( 'en' => 'Mulank Calculator',     'hi' => 'मूलांक कैलकुलेटर' ),
			'crush'      => array( 'en' => 'Crush Calculator',      'hi' => 'क्रश कैलकुलेटर' ),
		);
		$subs = array(
			'friendship' => array( 'en' => 'How strong is your friendship by name?', 'hi' => 'नाम से अपनी दोस्ती की मज़बूती जानें' ),
			'mulank'     => array( 'en' => 'Unlock your Mulank & Bhagyank secrets', 'hi' => 'अपना मूलांक और भाग्यांक रहस्य जानें' ),
			'crush'      => array( 'en' => 'Reveal the truth about your secret crush', 'hi' => 'अपने सीक्रेट क्रश का सच जानें' ),
		);
		ob_start();
		?>
<div class="cct-wrap" id="<?php echo esc_attr( $uid ); ?>" data-tool="<?php echo esc_attr( $tool ); ?>" data-mode="<?php echo esc_attr( $mode ); ?>" data-lang="<?php echo esc_attr( $lang ); ?>" data-sound="<?php echo (int) $s['sound_default']; ?>" data-haptics="<?php echo (int) $s['haptics_default']; ?>" data-history="<?php echo (int) $s['show_history']; ?>" data-share="<?php echo (int) $s['show_share']; ?>" data-premium="<?php echo (int) $s['show_premium']; ?>" data-premium-url="<?php echo esc_attr( $s['premium_url'] ); ?>" data-premium-label="<?php echo esc_attr( $s['premium_label'] ); ?>"><?php if ( ! empty( $ad_top ) ) : ?><div class="cct-ad cct-ad-top"><?php echo $ad_top; ?></div><?php endif; ?><div class="cct-bg" aria-hidden="true"><span class="cct-orb cct-orb-1"></span><span class="cct-orb cct-orb-2"></span><span class="cct-orb cct-orb-3"></span><span class="cct-st"></span><span class="cct-st"></span><span class="cct-st"></span><span class="cct-st"></span><span class="cct-st"></span><span class="cct-st"></span><span class="cct-st"></span><span class="cct-st"></span></div><div class="cct-shell"><header class="cct-head"><div class="cct-icon" aria-hidden="true"><?php echo $icon_svg; ?></div><h2 class="cct-title"><?php echo esc_html( $titles[ $tool ][ $lang ] ?? $titles[ $tool ]['en'] ); ?></h2><p class="cct-sub"><?php echo esc_html( $subs[ $tool ][ $lang ] ?? $subs[ $tool ]['en'] ); ?></p><div class="cct-toggles"><?php if ( $s['show_advanced_toggle'] && 'mulank' !== $tool ) : ?><label class="cct-tgl"><input type="checkbox" class="cct-adv-toggle" <?php checked( $mode, 'advanced' ); ?>><span class="cct-tgl-track"><span class="cct-tgl-knob"></span></span><span data-i18n="advanced">Advanced</span></label><?php endif; ?><?php if ( $s['show_lang_toggle'] ) : ?><div class="cct-lang"><button type="button" class="cct-lang-btn <?php echo 'en' === $lang ? 'is-on' : ''; ?>" data-lang="en">EN</button><button type="button" class="cct-lang-btn <?php echo 'hi' === $lang ? 'is-on' : ''; ?>" data-lang="hi">हि</button></div><?php endif; ?><button type="button" class="cct-mini cct-sound-btn" aria-label="Sound"><span class="cct-snd-on">🔊</span><span class="cct-snd-off">🔇</span></button></div></header><section class="cct-card cct-input-card"><form class="cct-form" novalidate onsubmit="return false;"><?php echo cct_form_fields( $tool, $uid ); ?><div class="cct-err" role="alert"></div><button type="submit" class="cct-btn cct-go"><span class="cct-btn-bg"></span><span class="cct-btn-txt" data-i18n="calculate"><?php echo esc_html( cct_btn_text( $tool, $lang ) ); ?></span><span class="cct-btn-spark">✨</span></button><div class="cct-trust"><span data-i18n="trust1">⚡ Instant</span><span data-i18n="trust2">🔒 Private</span><span data-i18n="trust3">🎯 Free</span></div></form></section><section class="cct-card cct-loading-card" style="display:none"><div class="cct-loader"><div class="cct-lo-orbit"><span>✨</span><span>💫</span><span>🌟</span><span>💖</span><span>🔮</span><span>⭐</span></div><div class="cct-lo-core"><?php echo cct_lo_emoji( $tool ); ?></div></div><p class="cct-load-txt" data-i18n="reading">Reading the cosmic energy…</p><div class="cct-progress"><span class="cct-progress-bar"></span></div></section><section class="cct-card cct-result-card" style="display:none"><div class="cct-confetti" aria-hidden="true"></div><div class="cct-result-head"></div><div class="cct-result-body"></div><div class="cct-actions"><button type="button" class="cct-act cct-act-again" data-i18n="try_again">Try Again</button><button type="button" class="cct-act cct-act-share" data-i18n="share">Share</button><button type="button" class="cct-act cct-act-save" data-i18n="save">Save</button><button type="button" class="cct-act cct-act-card" data-i18n="download">Download Card</button></div></section><?php if ( ! empty( $ad_mid ) ) : ?><div class="cct-ad cct-ad-mid" style="display:none"><?php echo $ad_mid; ?></div><?php endif; ?><section class="cct-advice" style="display:none"><div class="cct-adv-tabs"><button class="cct-adv-tab is-on" data-tab="golden" data-i18n="tab_golden">✨ Golden Hint</button><button class="cct-adv-tab" data-tab="protip" data-i18n="tab_pro">💡 Pro Tip</button><button class="cct-adv-tab" data-tab="life" data-i18n="tab_life">🌿 Life Lesson</button><button class="cct-adv-tab" data-tab="boost" data-i18n="tab_boost">🚀 Boost</button><button class="cct-adv-tab" data-tab="next" data-i18n="tab_next">🎯 What Next</button></div><div class="cct-adv-stage"><article class="cct-adv-card is-on" data-pane="golden"><h4></h4><p></p></article><article class="cct-adv-card" data-pane="protip"><h4></h4><p></p></article><article class="cct-adv-card" data-pane="life"><h4></h4><p></p></article><article class="cct-adv-card" data-pane="boost"><h4></h4><p></p></article><article class="cct-adv-card" data-pane="next"><h4></h4><p></p></article></div></section><section class="cct-extras" style="display:none"><div class="cct-ex-grid"></div></section><section class="cct-history" style="display:none"><div class="cct-hist-head"><h4 data-i18n="history">Your History</h4><button type="button" class="cct-hist-clear" data-i18n="clear">Clear</button></div><ul class="cct-hist-list"></ul></section><aside class="cct-premium" style="display:none"><div class="cct-prem-icon">👑</div><div class="cct-prem-body"><h4 data-i18n="prem_title">Unlock Full Cosmic Report</h4><p data-i18n="prem_text">Get full birth-chart analysis, daily forecast and personalized rituals.</p><a class="cct-prem-cta" href="#" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $s['premium_label'] ); ?></a></div></aside><?php if ( ! empty( $ad_bot ) ) : ?><div class="cct-ad cct-ad-bot"><?php echo $ad_bot; ?></div><?php endif; ?><canvas class="cct-share-canvas" width="1080" height="1080" style="display:none"></canvas></div></div>
		<?php
		return ob_get_clean();
	}
}

if ( ! function_exists( 'cct_form_fields' ) ) {
	function cct_form_fields( $tool, $uid ) {
		ob_start();
		if ( 'friendship' === $tool || 'crush' === $tool ) :
			$lbl1 = 'friendship' === $tool ? 'your_name' : 'your_name';
			$lbl2 = 'friendship' === $tool ? 'friend_name' : 'crush_name';
			?>
<div class="cct-row"><div class="cct-field"><label class="cct-lbl" for="<?php echo esc_attr( $uid ); ?>-n1" data-i18n="<?php echo esc_attr( $lbl1 ); ?>">Your Name</label><input type="text" class="cct-input cct-name1" id="<?php echo esc_attr( $uid ); ?>-n1" autocomplete="off" maxlength="40" placeholder="e.g. Aarav"></div><div class="cct-link-mid"><span class="cct-link-emoji"><?php echo 'friendship' === $tool ? '🤝' : '💘'; ?></span></div><div class="cct-field"><label class="cct-lbl" for="<?php echo esc_attr( $uid ); ?>-n2" data-i18n="<?php echo esc_attr( $lbl2 ); ?>"><?php echo 'friendship' === $tool ? "Friend's Name" : "Crush's Name"; ?></label><input type="text" class="cct-input cct-name2" id="<?php echo esc_attr( $uid ); ?>-n2" autocomplete="off" maxlength="40" placeholder="e.g. Priya"></div></div><div class="cct-adv"><div class="cct-row cct-adv-row"><div class="cct-field"><label class="cct-lbl" data-i18n="your_dob">Your DOB</label><input type="date" class="cct-input cct-dob1" max=""></div><div class="cct-spacer"></div><div class="cct-field"><label class="cct-lbl" data-i18n="partner_dob">Partner DOB</label><input type="date" class="cct-input cct-dob2" max=""></div></div></div>
			<?php
		elseif ( 'mulank' === $tool ) :
			?>
<div class="cct-row cct-row-mulank"><div class="cct-field"><label class="cct-lbl" for="<?php echo esc_attr( $uid ); ?>-name" data-i18n="full_name">Your Full Name (Optional)</label><input type="text" class="cct-input cct-name1" id="<?php echo esc_attr( $uid ); ?>-name" autocomplete="off" maxlength="60" placeholder="e.g. Aarav Sharma"></div><div class="cct-field"><label class="cct-lbl" for="<?php echo esc_attr( $uid ); ?>-dob" data-i18n="your_dob">Your Date of Birth</label><input type="date" class="cct-input cct-dob1" id="<?php echo esc_attr( $uid ); ?>-dob" max="" required></div></div>
			<?php
		endif;
		return ob_get_clean();
	}
}

if ( ! function_exists( 'cct_btn_text' ) ) {
	function cct_btn_text( $tool, $lang ) {
		$map = array(
			'friendship' => array( 'en' => 'Check Friendship', 'hi' => 'दोस्ती जाँचें' ),
			'mulank'     => array( 'en' => 'Reveal My Mulank', 'hi' => 'मेरा मूलांक जानें' ),
			'crush'      => array( 'en' => 'Reveal My Crush',  'hi' => 'क्रश रिज़ल्ट देखें' ),
		);
		return $map[ $tool ][ $lang ] ?? $map[ $tool ]['en'];
	}
}

if ( ! function_exists( 'cct_lo_emoji' ) ) {
	function cct_lo_emoji( $tool ) {
		return $tool === 'mulank' ? '🔢' : ( $tool === 'crush' ? '💘' : '🤝' );
	}
}

if ( ! function_exists( 'cct_get_icon' ) ) {
	function cct_get_icon( $tool, $uid ) {
		$grad = '<defs><linearGradient id="' . esc_attr( $uid ) . '-g" x1="0" y1="0" x2="1" y2="1"><stop offset="0%" stop-color="#7C3AED"/><stop offset="55%" stop-color="#EC4899"/><stop offset="100%" stop-color="#10B981"/></linearGradient></defs>';
		if ( 'friendship' === $tool ) {
			return '<svg viewBox="0 0 64 64" width="58" height="58">' . $grad . '<path d="M20 28a8 8 0 1 1 16 0v6c0 6 8 8 8 14H12c0-6 8-8 8-14v-6z M44 24a6 6 0 1 1 12 0v4c0 5 6 6 6 12h-14" fill="url(#' . esc_attr( $uid ) . '-g)"/></svg>';
		}
		if ( 'mulank' === $tool ) {
			return '<svg viewBox="0 0 64 64" width="58" height="58">' . $grad . '<circle cx="32" cy="32" r="26" fill="none" stroke="url(#' . esc_attr( $uid ) . '-g)" stroke-width="3"/><text x="32" y="42" text-anchor="middle" font-size="28" font-weight="900" font-family="Georgia,serif" fill="url(#' . esc_attr( $uid ) . '-g)">N</text></svg>';
		}
		return '<svg viewBox="0 0 64 64" width="58" height="58">' . $grad . '<path d="M32 56s-22-12-22-28a12 12 0 0 1 22-6 12 12 0 0 1 22 6c0 16-22 28-22 28z" fill="url(#' . esc_attr( $uid ) . '-g)"/><circle cx="42" cy="22" r="3" fill="#fff"/></svg>';
	}
}

/* ---------- CSS ---------- */
if ( ! function_exists( 'cct_get_css' ) ) {
	function cct_get_css() {
		return <<<CSS
.cct-wrap,.cct-wrap *,.cct-wrap *::before,.cct-wrap *::after{box-sizing:border-box}
.cct-wrap [style*="display:none"],.cct-wrap [hidden]{display:none !important}
.cct-wrap{position:relative;max-width:960px;margin:32px auto;padding:18px;font-family:'Inter','DM Sans',system-ui,-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;color:#1E1B4B;line-height:1.55;isolation:isolate}
.cct-wrap h2,.cct-wrap h3,.cct-wrap h4{font-family:'Space Grotesk','Playfair Display',Georgia,serif;font-weight:800;letter-spacing:-0.01em;margin:0}
.cct-bg{position:absolute;inset:0;border-radius:36px;overflow:hidden;z-index:-1;background:linear-gradient(135deg,#FAFAF7 0%,#F5F3FF 50%,#F0FDF4 100%)}
.cct-orb{position:absolute;border-radius:50%;filter:blur(60px);opacity:0.55;animation:cct-drift 16s ease-in-out infinite alternate}
.cct-orb-1{width:300px;height:300px;background:radial-gradient(circle,#7C3AED,transparent 70%);top:-50px;left:-50px}
.cct-orb-2{width:280px;height:280px;background:radial-gradient(circle,#EC4899,transparent 70%);bottom:-60px;right:-40px;animation-delay:-4s}
.cct-orb-3{width:260px;height:260px;background:radial-gradient(circle,#10B981,transparent 70%);top:50%;left:50%;transform:translate(-50%,-50%);animation-delay:-8s}
@keyframes cct-drift{0%{transform:translate(0,0) scale(1)}100%{transform:translate(40px,-30px) scale(1.1)}}
.cct-st{position:absolute;width:4px;height:4px;border-radius:50%;background:#F59E0B;box-shadow:0 0 10px #F59E0B;animation:cct-twinkle 3s ease-in-out infinite}
.cct-st:nth-of-type(1){top:14%;left:8%;animation-delay:0s}
.cct-st:nth-of-type(2){top:22%;right:14%;animation-delay:0.5s;width:3px;height:3px}
.cct-st:nth-of-type(3){top:62%;left:6%;animation-delay:1s}
.cct-st:nth-of-type(4){top:78%;right:18%;animation-delay:1.5s;width:3px;height:3px}
.cct-st:nth-of-type(5){top:34%;left:48%;animation-delay:2s}
.cct-st:nth-of-type(6){top:88%;left:42%;animation-delay:0.7s;width:5px;height:5px}
.cct-st:nth-of-type(7){top:50%;right:8%;animation-delay:1.3s}
.cct-st:nth-of-type(8){top:6%;left:64%;animation-delay:2.5s;width:3px;height:3px}
@keyframes cct-twinkle{0%,100%{opacity:0.3;transform:scale(1)}50%{opacity:1;transform:scale(1.4)}}
.cct-shell{position:relative;padding:24px 18px}
.cct-head{text-align:center;padding:6px 4px 22px}
.cct-icon{display:inline-block;filter:drop-shadow(0 10px 24px rgba(124,58,237,0.30));animation:cct-bob 3s ease-in-out infinite}
@keyframes cct-bob{0%,100%{transform:translateY(0) rotate(-2deg)}50%{transform:translateY(-6px) rotate(2deg)}}
.cct-title{font-size:clamp(28px,5vw,42px);margin:8px 0 4px;background:linear-gradient(120deg,#7C3AED,#EC4899 50%,#10B981);-webkit-background-clip:text;background-clip:text;color:transparent}
.cct-sub{margin:0;opacity:0.72;font-size:15px;font-style:italic}
.cct-toggles{display:flex;justify-content:center;align-items:center;gap:12px;margin-top:14px;flex-wrap:wrap}
.cct-tgl{display:inline-flex;align-items:center;gap:8px;cursor:pointer;font-size:13px;font-weight:600;user-select:none}
.cct-tgl input{position:absolute;opacity:0;pointer-events:none}
.cct-tgl-track{position:relative;width:44px;height:24px;border-radius:999px;background:rgba(124,58,237,0.15);border:1px solid rgba(124,58,237,0.25);transition:background .25s}
.cct-tgl-knob{position:absolute;top:2px;left:2px;width:18px;height:18px;border-radius:50%;background:linear-gradient(135deg,#7C3AED,#EC4899);transition:transform .25s;box-shadow:0 4px 10px rgba(124,58,237,0.35)}
.cct-tgl input:checked + .cct-tgl-track{background:linear-gradient(90deg,rgba(124,58,237,0.35),rgba(236,72,153,0.35))}
.cct-tgl input:checked + .cct-tgl-track .cct-tgl-knob{transform:translateX(20px);background:linear-gradient(135deg,#10B981,#7C3AED)}
.cct-lang{display:inline-flex;border-radius:999px;padding:3px;background:rgba(124,58,237,0.10);border:1px solid rgba(124,58,237,0.20)}
.cct-lang-btn{background:transparent;color:#1E1B4B;border:0;padding:4px 12px;border-radius:999px;cursor:pointer;font-weight:700;font-size:12px;min-height:26px;transition:background .2s;font-family:inherit}
.cct-lang-btn.is-on{background:linear-gradient(120deg,#7C3AED,#EC4899);color:#fff;box-shadow:0 6px 14px rgba(124,58,237,0.30)}
.cct-mini{background:rgba(124,58,237,0.10);border:1px solid rgba(124,58,237,0.20);color:inherit;width:32px;height:32px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;cursor:pointer;font-size:14px;transition:transform .15s}
.cct-mini:hover{transform:scale(1.06)}
.cct-snd-off{display:none}
.cct-wrap[data-sound="0"] .cct-snd-on{display:none}
.cct-wrap[data-sound="0"] .cct-snd-off{display:inline}
.cct-card{position:relative;background:#fff;border-radius:28px;padding:28px 24px;box-shadow:0 30px 80px rgba(124,58,237,0.12),0 2px 6px rgba(124,58,237,0.06);margin-top:18px;overflow:hidden;border:1px solid rgba(124,58,237,0.10)}
.cct-card::before{content:"";position:absolute;left:0;right:0;top:0;height:4px;background:linear-gradient(90deg,#7C3AED,#EC4899 50%,#10B981);border-radius:4px 4px 0 0}
.cct-row{display:grid;grid-template-columns:1fr 90px 1fr;gap:14px;align-items:start}
.cct-row-mulank{grid-template-columns:1fr 1fr;gap:18px}
.cct-field{display:flex;flex-direction:column;gap:8px;min-width:0}
.cct-lbl{font-size:12px;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;opacity:0.7}
.cct-input{width:100%;min-height:52px;padding:14px 16px;font-size:16px;background:#FAFAF7;border:1.5px solid rgba(124,58,237,0.18);border-radius:14px;color:inherit;outline:none;transition:border-color .25s,background .25s,box-shadow .25s;font-family:inherit}
.cct-input::placeholder{color:rgba(30,27,75,0.40)}
.cct-input:focus{border-color:#7C3AED;background:#fff;box-shadow:0 0 0 4px rgba(124,58,237,0.14)}
.cct-link-mid{position:relative;height:52px;display:flex;align-items:center;justify-content:center;margin-top:24px}
.cct-link-emoji{font-size:30px;animation:cct-beat 1.4s ease-in-out infinite;filter:drop-shadow(0 4px 10px rgba(124,58,237,0.40))}
@keyframes cct-beat{0%,40%,60%,100%{transform:scale(1)}20%{transform:scale(1.18)}50%{transform:scale(1.10)}}
.cct-adv{max-height:0;overflow:hidden;transition:max-height .4s,opacity .35s,margin .35s;opacity:0}
.cct-wrap[data-mode="advanced"] .cct-adv{max-height:200px;opacity:1;margin-top:16px}
.cct-adv-row{grid-template-columns:1fr 24px 1fr}
.cct-spacer{width:24px}
.cct-err{display:none;margin-top:14px;background:#FEE2E2;border:1px solid #EF4444;color:#991B1B;border-radius:12px;padding:10px 14px;font-size:14px;text-align:center}
.cct-err.is-on{display:block !important;animation:cct-shake .35s}
@keyframes cct-shake{0%,100%{transform:translateX(0)}25%{transform:translateX(-6px)}75%{transform:translateX(6px)}}
.cct-btn{position:relative;display:inline-flex;align-items:center;justify-content:center;gap:10px;width:100%;min-height:60px;padding:18px 22px;margin-top:20px;border:0;border-radius:18px;cursor:pointer;color:#fff;font-family:inherit;font-weight:800;font-size:17px;overflow:hidden;transition:transform .15s,box-shadow .25s;box-shadow:0 16px 40px rgba(124,58,237,0.32)}
.cct-btn-bg{position:absolute;inset:0;background:linear-gradient(120deg,#7C3AED,#EC4899 50%,#10B981);background-size:200% 200%;animation:cct-grad 5s ease infinite;z-index:0}
@keyframes cct-grad{0%,100%{background-position:0 0}50%{background-position:100% 100%}}
.cct-btn-txt,.cct-btn-spark{position:relative;z-index:1}
.cct-btn-spark{animation:cct-spin 4s linear infinite}
@keyframes cct-spin{to{transform:rotate(360deg)}}
.cct-btn:hover{transform:translateY(-2px);box-shadow:0 22px 50px rgba(124,58,237,0.45)}
.cct-trust{display:flex;gap:8px;justify-content:center;flex-wrap:wrap;margin-top:14px}
.cct-trust span{font-size:12px;padding:6px 12px;background:rgba(124,58,237,0.08);color:#5B21B6;border-radius:999px;font-weight:600}
.cct-loader{position:relative;width:160px;height:160px;margin:6px auto 16px}
.cct-lo-orbit{position:absolute;inset:0;animation:cct-spin 9s linear infinite}
.cct-lo-orbit span{position:absolute;left:50%;top:50%;transform-origin:0 0;font-size:22px}
.cct-lo-orbit span:nth-of-type(1){transform:rotate(0deg) translate(72px) rotate(0deg)}
.cct-lo-orbit span:nth-of-type(2){transform:rotate(60deg) translate(72px) rotate(-60deg)}
.cct-lo-orbit span:nth-of-type(3){transform:rotate(120deg) translate(72px) rotate(-120deg)}
.cct-lo-orbit span:nth-of-type(4){transform:rotate(180deg) translate(72px) rotate(-180deg)}
.cct-lo-orbit span:nth-of-type(5){transform:rotate(240deg) translate(72px) rotate(-240deg)}
.cct-lo-orbit span:nth-of-type(6){transform:rotate(300deg) translate(72px) rotate(-300deg)}
.cct-lo-core{position:absolute;left:50%;top:50%;transform:translate(-50%,-50%);font-size:54px;animation:cct-beat 1.2s ease-in-out infinite;filter:drop-shadow(0 8px 18px rgba(124,58,237,0.35))}
.cct-load-txt{text-align:center;font-weight:600;opacity:0.85;font-style:italic}
.cct-progress{height:6px;max-width:380px;margin:12px auto 0;background:rgba(124,58,237,0.10);border-radius:999px;overflow:hidden}
.cct-progress-bar{display:block;height:100%;width:0%;background:linear-gradient(90deg,#7C3AED,#EC4899,#10B981);border-radius:999px;transition:width .4s ease}
.cct-confetti{pointer-events:none;position:absolute;left:0;right:0;top:0;height:0}
.cct-confetti.is-go{height:1px}
.cct-conf-piece{position:absolute;font-size:18px;opacity:0;animation:cct-conf 1500ms ease-out forwards}
@keyframes cct-conf{0%{opacity:1;transform:translate(0,0) rotate(0) scale(1)}100%{opacity:0;transform:translate(var(--cct-x),var(--cct-y)) rotate(540deg) scale(0.5)}}
.cct-result-head{text-align:center;margin-bottom:10px}
.cct-couple{display:flex;align-items:center;justify-content:center;gap:14px;margin-bottom:12px;flex-wrap:wrap}
.cct-cp{display:inline-flex;align-items:center;gap:8px;padding:6px 14px;background:#F5F3FF;border-radius:999px;font-weight:700;color:#5B21B6}
.cct-cp .cct-init{width:28px;height:28px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;font-size:13px;font-weight:800;color:#fff;background:linear-gradient(135deg,#7C3AED,#EC4899)}
.cct-cp-2 .cct-init{background:linear-gradient(135deg,#EC4899,#10B981)}
.cct-link-result{font-size:20px;animation:cct-beat 1.2s ease-in-out infinite}
.cct-score-meter{position:relative;width:200px;height:200px;margin:14px auto 6px}
.cct-score-meter svg{width:100%;height:100%;transform:rotate(-90deg)}
.cct-score-bg{fill:none;stroke:rgba(124,58,237,0.10);stroke-width:14}
.cct-score-fg{fill:none;stroke:url(#cct-grad);stroke-width:14;stroke-linecap:round;stroke-dasharray:534;stroke-dashoffset:534;transition:stroke-dashoffset 1.8s cubic-bezier(.2,.9,.3,1);filter:drop-shadow(0 8px 20px rgba(124,58,237,0.40))}
.cct-score-num{position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;font-family:'Space Grotesk',sans-serif}
.cct-score-emoji{font-size:32px;margin-bottom:4px}
.cct-score-val{font-size:52px;font-weight:800;line-height:1;background:linear-gradient(120deg,#7C3AED,#EC4899);-webkit-background-clip:text;background-clip:text;color:transparent}
.cct-score-pct{font-size:20px;font-weight:700;opacity:0.65;margin-left:2px}
.cct-tier-name{text-align:center;font-size:clamp(20px,3.4vw,28px);margin-top:4px;background:linear-gradient(120deg,#5B21B6,#7C3AED);-webkit-background-clip:text;background-clip:text;color:transparent}
.cct-tier-tag{text-align:center;margin:4px 0 12px;opacity:0.65;font-size:13px;letter-spacing:0.06em;text-transform:uppercase;font-weight:700}
.cct-quote{position:relative;padding:14px 18px 14px 30px;margin:14px auto;max-width:560px;background:linear-gradient(120deg,#F5F3FF,#FDF2F8);border-left:4px solid #7C3AED;border-radius:14px;font-style:italic;font-size:14.5px;line-height:1.65}
.cct-quote::before{content:"\"";position:absolute;left:8px;top:-2px;font-size:34px;color:#7C3AED;opacity:0.4;font-family:Georgia,serif}
.cct-num-display{text-align:center;padding:14px 0}
.cct-num-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px;margin:14px 0}
.cct-num-cell{padding:18px;background:linear-gradient(135deg,#F5F3FF,#FDF2F8);border-radius:16px;border:1px solid rgba(124,58,237,0.12);text-align:center}
.cct-num-lbl{font-size:11px;font-weight:800;letter-spacing:0.08em;text-transform:uppercase;color:#5B21B6;opacity:0.75}
.cct-num-big{font-family:'Space Grotesk',sans-serif;font-size:60px;font-weight:900;line-height:1;margin:8px 0;background:linear-gradient(120deg,#7C3AED,#EC4899);-webkit-background-clip:text;background-clip:text;color:transparent}
.cct-num-sub{font-size:13px;font-weight:600;opacity:0.85}
.cct-num-planet{display:inline-block;padding:4px 12px;background:rgba(245,158,11,0.15);color:#92400E;border-radius:999px;font-size:11px;font-weight:700;letter-spacing:0.04em;text-transform:uppercase;margin-top:6px}
.cct-radar{margin-top:18px;padding:16px;background:linear-gradient(120deg,#F5F3FF,#FDF2F8);border-radius:18px;border:1px solid rgba(124,58,237,0.10)}
.cct-radar h4{font-size:15px;margin-bottom:10px;color:#5B21B6}
.cct-bars{display:flex;flex-direction:column;gap:10px}
.cct-bar{display:grid;grid-template-columns:120px 1fr;gap:12px;align-items:center}
.cct-bar label{font-size:13px;font-weight:600;opacity:0.85}
.cct-bar-track{position:relative;height:10px;background:rgba(124,58,237,0.12);border-radius:999px;overflow:visible}
.cct-bar-fill{display:block;height:100%;width:0%;background:linear-gradient(90deg,#7C3AED,#EC4899,#10B981);border-radius:999px;transition:width 1.2s cubic-bezier(.2,.9,.3,1)}
.cct-bar-val{position:absolute;right:6px;top:-22px;font-size:12px;font-weight:700;color:#7C3AED}
.cct-actions{display:flex;flex-wrap:wrap;gap:8px;justify-content:center;margin-top:20px}
.cct-act{background:#F5F3FF;color:#5B21B6;border:1.5px solid rgba(124,58,237,0.18);padding:10px 16px;border-radius:12px;font-weight:700;cursor:pointer;font-family:inherit;font-size:14px;transition:all .2s}
.cct-act:hover{background:#EDE9FE;transform:translateY(-1px)}
.cct-act-share{background:linear-gradient(120deg,#7C3AED,#EC4899);color:#fff;border-color:transparent}
.cct-act-share:hover{background:linear-gradient(120deg,#EC4899,#7C3AED)}
.cct-advice{margin-top:18px}
.cct-adv-tabs{display:flex;gap:6px;padding:6px;background:#F5F3FF;border-radius:14px;overflow-x:auto;scrollbar-width:none}
.cct-adv-tabs::-webkit-scrollbar{display:none}
.cct-adv-tab{background:transparent;color:#5B21B6;border:0;padding:8px 14px;border-radius:10px;font-weight:700;font-size:13px;cursor:pointer;white-space:nowrap;font-family:inherit;transition:background .25s,color .25s}
.cct-adv-tab.is-on{background:linear-gradient(120deg,#7C3AED,#EC4899);color:#fff;box-shadow:0 6px 16px rgba(124,58,237,0.30)}
.cct-adv-stage{position:relative;margin-top:12px;min-height:140px}
.cct-adv-card{display:none;padding:18px;background:#fff;border:1px solid rgba(124,58,237,0.12);border-radius:16px;box-shadow:0 8px 24px rgba(124,58,237,0.08);animation:cct-fade .35s ease both}
.cct-adv-card.is-on{display:block !important}
.cct-adv-card h4{font-size:17px;margin-bottom:6px;background:linear-gradient(120deg,#5B21B6,#EC4899);-webkit-background-clip:text;background-clip:text;color:transparent}
.cct-adv-card p{margin:0;font-size:14.5px;opacity:0.92;line-height:1.7}
@keyframes cct-fade{from{opacity:0;transform:translateY(6px)}to{opacity:1;transform:translateY(0)}}
.cct-ex-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:10px;margin-top:18px}
.cct-ex{display:flex;gap:10px;padding:14px;background:#fff;border:1px solid rgba(124,58,237,0.12);border-radius:14px;align-items:flex-start;box-shadow:0 4px 12px rgba(124,58,237,0.06)}
.cct-ex-icon{font-size:24px;flex-shrink:0}
.cct-ex b{display:block;font-size:13px;color:#5B21B6;margin-bottom:2px;font-weight:800}
.cct-ex p{margin:0;font-size:13.5px;line-height:1.5;opacity:0.88}
.cct-history{margin-top:18px;padding:16px;background:#fff;border:1px solid rgba(124,58,237,0.12);border-radius:16px}
.cct-hist-head{display:flex;justify-content:space-between;align-items:center;margin-bottom:8px}
.cct-hist-head h4{font-size:15px;color:#5B21B6}
.cct-hist-clear{background:transparent;color:#EC4899;border:0;cursor:pointer;font-size:12px;font-family:inherit;font-weight:700}
.cct-hist-list{list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:6px}
.cct-hist-list li{display:flex;justify-content:space-between;align-items:center;padding:8px 12px;background:#F5F3FF;border-radius:10px;font-size:13px}
.cct-hist-list li b{color:#7C3AED;font-weight:800}
.cct-premium{display:flex;gap:14px;align-items:center;margin-top:18px;padding:18px;background:linear-gradient(120deg,#FEF3C7,#FCE7F3);border:1px solid rgba(245,158,11,0.30);border-radius:18px}
.cct-prem-icon{font-size:36px}
.cct-prem-body{flex:1}
.cct-prem-body h4{font-size:16px;color:#92400E}
.cct-prem-body p{margin:4px 0 10px;font-size:13.5px;opacity:0.88}
.cct-prem-cta{display:inline-block;padding:9px 18px;border-radius:10px;background:linear-gradient(120deg,#F59E0B,#EC4899);color:#fff;font-weight:800;text-decoration:none;font-size:13.5px;transition:transform .15s}
.cct-prem-cta:hover{transform:translateY(-1px)}
.cct-ad{margin:14px 0;text-align:center;min-height:50px}
.cct-ad-mid{margin-top:18px}
@media (max-width:680px){
.cct-wrap{padding:12px;margin:16px auto}
.cct-shell{padding:16px 8px}
.cct-card{padding:20px 16px;border-radius:22px}
.cct-row{grid-template-columns:1fr;gap:18px}
.cct-row .cct-link-mid{order:2;height:40px;margin-top:0;transform:rotate(90deg)}
.cct-row .cct-field:nth-child(3){order:3}
.cct-row-mulank{grid-template-columns:1fr}
.cct-adv-row{grid-template-columns:1fr}
.cct-spacer{display:none}
.cct-ex-grid{grid-template-columns:1fr}
.cct-num-grid{grid-template-columns:1fr}
.cct-bar{grid-template-columns:100px 1fr}
.cct-actions .cct-act{flex:1 1 calc(50% - 8px)}
.cct-score-meter{width:170px;height:170px}
.cct-score-val{font-size:42px}
}
@media (prefers-reduced-motion:reduce){
.cct-orb,.cct-st,.cct-icon,.cct-link-emoji,.cct-lo-orbit,.cct-lo-core,.cct-btn-bg,.cct-btn-spark,.cct-link-result{animation:none !important}
}
CSS;
	}
}

/* ---------- JavaScript ---------- */
if ( ! function_exists( 'cct_get_js' ) ) {
	function cct_get_js() {
		return <<<'JS'
(function(){
"use strict";
var I18N={
en:{advanced:"Advanced",your_name:"Your Name",friend_name:"Friend's Name",crush_name:"Crush's Name",full_name:"Your Full Name (Optional)",your_dob:"Your Date of Birth",partner_dob:"Partner's DOB",reading:"Reading the cosmic energy…",try_again:"Try Again",share:"Share",save:"Save",download:"Download Card",tab_golden:"✨ Golden Hint",tab_pro:"💡 Pro Tip",tab_life:"🌿 Life Lesson",tab_boost:"🚀 Boost",tab_next:"🎯 What Next",history:"Your History",clear:"Clear",prem_title:"Unlock Full Cosmic Report",prem_text:"Get full birth-chart analysis, daily forecast and personalized rituals.",trust1:"⚡ Instant",trust2:"🔒 Private",trust3:"🎯 Free",err_required:"Please enter both names.",err_dob_required:"Please select your date of birth.",err_short:"Names should be at least 2 letters long.",err_same:"Names look identical. Try slightly different ones.",step1:"Crunching the cosmic data…",step2:"Reading numerology vibrations…",step3:"Aligning the stars…",step4:"Crafting your insights…",save_done:"Saved!",copy_done:"Result copied!",calculate:"Calculate"},
hi:{advanced:"एडवांस्ड",your_name:"आपका नाम",friend_name:"दोस्त का नाम",crush_name:"क्रश का नाम",full_name:"आपका पूरा नाम (वैकल्पिक)",your_dob:"आपकी जन्म तिथि",partner_dob:"पार्टनर की जन्म तिथि",reading:"कॉस्मिक ऊर्जा पढ़ी जा रही है…",try_again:"फिर से करें",share:"शेयर करें",save:"सेव करें",download:"कार्ड डाउनलोड",tab_golden:"✨ गोल्डन हिंट",tab_pro:"💡 प्रो टिप",tab_life:"🌿 ज़िंदगी का सबक",tab_boost:"🚀 बूस्ट",tab_next:"🎯 आगे क्या",history:"आपकी हिस्ट्री",clear:"मिटाएँ",prem_title:"पूरी कॉस्मिक रिपोर्ट पाएँ",prem_text:"पूरी जन्म-कुंडली, डेली फ़ोरकास्ट और निजी उपाय पाएँ।",trust1:"⚡ तुरंत",trust2:"🔒 निजी",trust3:"🎯 फ्री",err_required:"कृपया दोनों नाम भरें।",err_dob_required:"कृपया जन्म तिथि चुनें।",err_short:"नाम कम से कम 2 अक्षर का हो।",err_same:"नाम एक जैसे लग रहे हैं, अलग आज़माएँ।",step1:"कॉस्मिक डेटा निकाला जा रहा है…",step2:"अंक ऊर्जा पढ़ी जा रही है…",step3:"सितारे मिलाए जा रहे हैं…",step4:"आपकी रिपोर्ट बन रही है…",save_done:"सेव हुआ!",copy_done:"रिज़ल्ट कॉपी हो गया!",calculate:"कैलकुलेट"}
};

/* ===== FRIENDSHIP TIERS ===== */
var FRIEND_TIERS={
soul:{min:90,emoji:"💞",name:{en:"Soul Buddies",hi:"आत्मा के दोस्त"},quote:{en:"This is the rare friendship that becomes family. Protect it fiercely.",hi:"ये वो दुर्लभ दोस्ती है जो परिवार बन जाती है। पूरी ताक़त से संभालो।"},content:{en:{golden:{h:"You found a 1-in-100 friend",t:"This level of bond doesn't happen randomly. They get you, you get them — that mutual understanding is priceless. Many people search a lifetime and never find this."},protip:{h:"Be the friend, don't just have one",t:"The friendships that last decades are built on showing up — not just for fun, but for the boring days, the heavy days, the small wins. Be that for them."},life:{h:"True friends are mirrors and windows",t:"They mirror your best self and open windows to your blind spots. Listen when they tell you hard truths — those words come from love."},boost:{h:"Push it to 99%",t:"Pick one annual ritual you'll never miss — a birthday call at midnight, a yearly trip, a shared photo album. Small consistency builds legendary friendship."},next:{h:"Build a memory archive",t:"Save voice notes, share playlists, write each other letters once a year. 20 years from now, these are the treasures you'll re-read."}},hi:{golden:{h:"100 में 1 जैसा दोस्त मिला है",t:"इतनी गहरी बॉन्डिंग संयोग से नहीं होती। वो आपको समझते हैं, आप उन्हें — ये आपसी समझ अनमोल है। बहुत लोग पूरी ज़िंदगी ऐसा नहीं पाते।"},protip:{h:"दोस्त रखो नहीं, बनो",t:"दशकों तक चलने वाली दोस्तियाँ 'मौजूदगी' पर बनती हैं — सिर्फ़ मज़े के नहीं, बल्कि उदास दिनों, भारी पलों, छोटी जीतों के लिए भी।"},life:{h:"सच्चे दोस्त आइना और खिड़की होते हैं",t:"वो आपके अच्छेपन का आइना दिखाते हैं और आपकी कमज़ोरियों की खिड़कियाँ खोलते हैं। जब वो कड़वी सच्चाई कहें, सुनो — वो प्यार से कहते हैं।"},boost:{h:"99% तक ले जाओ",t:"एक सालाना रिवाज़ चुनो जो कभी मिस नहीं करोगे — आधी रात की बर्थडे कॉल, साल में एक ट्रिप, साझा एल्बम। छोटी निरंतरता दोस्ती को दंतकथा बनाती है।"},next:{h:"यादों का ख़ज़ाना बनाओ",t:"वॉइस नोट सेव करो, प्लेलिस्ट शेयर करो, साल में एक चिट्ठी लिखो। 20 साल बाद यही सबसे क़ीमती चीज़ें होंगी।"}}}},
close:{min:75,emoji:"💖",name:{en:"Close Friends",hi:"घनिष्ठ दोस्त"},quote:{en:"You two have something real. Keep watering it and watch it grow.",hi:"आप दोनों के बीच कुछ सच्चा है। सींचते रहो, देखो ये कैसे बढ़ता है।"},content:{en:{golden:{h:"Don't take this friendship for granted",t:"You have something most people don't — comfort, trust and laughter in one package. Keep noticing it, keep appreciating it out loud."},protip:{h:"Be the first to reach out",t:"Friendships fade not from fights but from silence. Send the random message. Drop the meme. Plan the catch-up. Be the spark, not the wait."},life:{h:"Quality beats quantity",t:"Two real friends are worth a hundred shallow ones. Invest in the relationships that already give you energy, not the ones that drain you."},boost:{h:"Take it from 80% to 95%",t:"Try the 'vulnerable share' rule: each month, tell them one thing you've never told anyone. Deep trust grows from intentional openness."},next:{h:"Make it official",t:"Plan something significant together — a trip, a shared goal, even a tradition. Friendships level up when you build something together, not just hang out."}},hi:{golden:{h:"इस दोस्ती को कम मत समझो",t:"आपके पास वो है जो ज़्यादातर लोगों के पास नहीं — आराम, भरोसा और हँसी एक साथ। इसे पहचानते रहो, खुलकर सराहना करते रहो।"},protip:{h:"पहले संदेश भेजने वाले बनो",t:"दोस्तियाँ झगड़ों से नहीं, चुप्पी से मरती हैं। बिना वजह मैसेज भेजो। मीम शेयर करो। मिलना प्लान करो। चिंगारी बनो, इंतज़ार नहीं।"},life:{h:"मात्रा नहीं, गुणवत्ता",t:"दो असली दोस्त सौ सतही दोस्तों से बेहतर हैं। उन रिश्तों में निवेश करो जो ऊर्जा देते हैं, उन में नहीं जो थकाते हैं।"},boost:{h:"80% से 95% तक",t:"'वल्नरेबल शेयर' नियम आज़माओ: हर महीने एक बात बताओ जो कभी किसी से नहीं कही। जान-बूझ कर खुलापन गहरा भरोसा बनाता है।"},next:{h:"दोस्ती को आधिकारिक बनाओ",t:"साथ कुछ बड़ा प्लान करो — ट्रिप, साझा लक्ष्य, परंपरा। साथ कुछ बनाने से दोस्ती लेवल अप होती है, सिर्फ़ मिलने से नहीं।"}}}},
good:{min:60,emoji:"😊",name:{en:"Good Friends",hi:"अच्छे दोस्त"},quote:{en:"Solid foundation. With effort, this can become something deeper.",hi:"नींव अच्छी है। मेहनत से ये गहरी दोस्ती बन सकती है।"},content:{en:{golden:{h:"Comfortable, but not yet deep",t:"You enjoy each other's company and that's valuable. The next level — vulnerability and shared struggle — is where casual becomes close."},protip:{h:"Share something a little personal",t:"Most friendships stay surface-level because both people wait for the other to go first. Be the one who opens up a little — the other follows."},life:{h:"Time + intention = deep friendship",t:"Acquaintances become friends through hours together. Friends become close friends through honest hours together. Make the honest hours intentional."},boost:{h:"From 65% to 80%",t:"Plan one 'no agenda' hangout per month — no event, no movie, just talk. Long unstructured time is where real friendship is built."},next:{h:"Discover a shared passion",t:"Find one hobby, skill or cause you both care about and pursue it together. Shared growth builds the strongest bonds."}},hi:{golden:{h:"आरामदायक है, पर अभी गहरा नहीं",t:"आप एक-दूसरे की कंपनी का मज़ा लेते हैं — ये क़ीमती है। अगला स्तर — खुलापन और साझा संघर्ष — वहीं casual close बनती है।"},protip:{h:"कुछ निजी शेयर करो",t:"ज़्यादातर दोस्तियाँ इसलिए सतही रहती हैं क्योंकि दोनों इंतज़ार करते हैं कि पहले दूसरा खुले। आप पहले खुलो — दूसरा फॉलो करेगा।"},life:{h:"समय + इरादा = गहरी दोस्ती",t:"परिचित दोस्त बनते हैं घंटों साथ बिताने से। दोस्त घनिष्ठ बनते हैं ईमानदार घंटों से। ईमानदार घंटों को जान-बूझ कर बनाओ।"},boost:{h:"65% से 80% तक",t:"महीने में एक 'बिना एजेंडे' की मुलाक़ात प्लान करो — कोई इवेंट नहीं, मूवी नहीं, बस बात। लंबा बिना-संरचना का समय असली दोस्ती बनाता है।"},next:{h:"साझा शौक़ ढूँढो",t:"एक हॉबी, स्किल या मक़सद चुनो जिसमें दोनों रुचि लें और साथ बढ़ो। साझा विकास सबसे मज़बूत बंधन बनाता है।"}}}},
casual:{min:40,emoji:"🙂",name:{en:"Casual Friends",hi:"कैजुअल दोस्त"},quote:{en:"You orbit each other. Whether you collide depends on who reaches out.",hi:"आप एक-दूसरे के आसपास हैं। टकराओगे या नहीं, ये कौन पहले पहल करता है, पर निर्भर है।"},content:{en:{golden:{h:"Potential — but it needs activation",t:"You like each other. That's the seed. Friendships need watering — reach out without a reason, share something random, just because."},protip:{h:"Drop the 'we should hang out sometime'",t:"That phrase kills friendships. Replace it with 'are you free Saturday?' Specific plans turn into actual friendships."},life:{h:"You are who you spend time with",t:"Your closest 5 friends shape your future. Choose carefully whose orbit you stay in. Some people you keep, some you politely outgrow."},boost:{h:"From 50% to 70%",t:"Pick 3 small actions: one DM, one shared meme, one 30-minute call this week. Three small actions beat one big one."},next:{h:"Decide who they are in your life",t:"Are they someone you want to invest in, or someone you naturally see at gatherings? Both are valid. Knowing the difference saves your energy."}},hi:{golden:{h:"संभावना है — पर activation चाहिए",t:"आप एक-दूसरे को पसंद करते हो। यही बीज है। दोस्ती को पानी चाहिए — बिना वजह संपर्क करो, कुछ रैंडम शेयर करो, बस ऐसे ही।"},protip:{h:"'कभी मिलते हैं' छोड़ो",t:"ये वाक्य दोस्तियाँ मारता है। इसकी जगह कहो 'शनिवार को फ्री हो?' सटीक प्लान असली दोस्ती बनते हैं।"},life:{h:"आप वही बनते हो जिनके साथ रहते हो",t:"आपके 5 सबसे क़रीबी दोस्त आपका भविष्य बनाते हैं। सोच-समझ कर चुनो किसकी कक्षा में रहना है। कुछ को रखो, कुछ से धीरे-धीरे आगे बढ़ जाओ।"},boost:{h:"50% से 70% तक",t:"3 छोटी क्रियाएँ चुनो — एक DM, एक शेयर्ड मीम, इस हफ़्ते 30 मिनट की कॉल। तीन छोटी क्रियाएँ एक बड़ी से बेहतर हैं।"},next:{h:"उनकी जगह तय करो",t:"क्या आप इनमें निवेश करना चाहते हो, या ये सिर्फ़ गैदरिंग में मिलने वाले हैं? दोनों सही हैं। फ़र्क समझना आपकी ऊर्जा बचाता है।"}}}},
distant:{min:0,emoji:"🌫️",name:{en:"Distant Friends",hi:"दूर के दोस्त"},quote:{en:"Low connection now — but distance doesn't mean disrespect.",hi:"अभी जुड़ाव कम है — पर दूरी का मतलब अनादर नहीं।"},content:{en:{golden:{h:"Distance isn't always bad",t:"Some people are meant for chapters, not the whole book. A 'low score' doesn't mean someone is bad — they're just not your inner circle, and that's okay."},protip:{h:"Don't fake closeness",t:"Performing friendship drains both people. Be warm and respectful, but don't pretend to be best buddies. Authenticity is a kindness."},life:{h:"Your circle should fit you",t:"You don't need to be close with everyone. Quality over quantity. Save your deep energy for the 3-5 who truly know you."},boost:{h:"Try one honest conversation",t:"If you feel there's potential, send one meaningful message: 'I miss our chats — coffee soon?' If they respond warmly, great. If not, no loss."},next:{h:"Audit and choose",t:"Audit your friendships every 6 months. Some you'll invest more in, some you'll let drift — both are healthy. Time is your most valuable currency."}},hi:{golden:{h:"दूरी हमेशा बुरी नहीं",t:"कुछ लोग अध्यायों के लिए होते हैं, पूरी किताब के लिए नहीं। 'कम स्कोर' का मतलब वो बुरे नहीं — बस आपके अंदरूनी घेरे में नहीं, और ये ठीक है।"},protip:{h:"नक़ली निकटता मत दिखाओ",t:"दोस्ती का दिखावा दोनों को थकाता है। गर्मजोशी से पेश आओ, सम्मान दो, पर बेस्ट बडीज़ होने का नाटक मत करो। सच्चाई एक तरह की दयालुता है।"},life:{h:"आपका दायरा आपके लायक़ हो",t:"सबसे क़रीबी होना ज़रूरी नहीं। मात्रा से ज़्यादा गुणवत्ता। अपनी गहरी ऊर्जा उन 3-5 के लिए बचाओ जो आपको सच में जानते हैं।"},boost:{h:"एक ईमानदार बातचीत करो",t:"अगर लगे कि संभावना है, एक मतलब भरी बात भेजो: 'आपकी कमी महसूस होती है — कॉफी पर मिलते हैं?' गर्मजोशी से जवाब मिले तो बेहतरीन। नहीं तो कोई नुक़सान नहीं।"},next:{h:"ऑडिट करो और चुनो",t:"हर 6 महीने में अपनी दोस्तियों का ऑडिट करो। कुछ में ज़्यादा निवेश करो, कुछ को बहने दो — दोनों स्वस्थ हैं। समय आपकी सबसे क़ीमती मुद्रा है।"}}}}
};

/* ===== CRUSH TIERS ===== */
var CRUSH_TIERS={
destined:{min:90,emoji:"💘",name:{en:"Destined Crush",hi:"लिखी हुई जोड़ी"},future:{en:"The signs are loud — they're thinking about you too. A confession in the next 30 days could change everything for the better.",hi:"संकेत साफ़ हैं — वो भी आपके बारे में सोच रहे हैं। अगले 30 दिनों में इज़हार सब कुछ बेहतर बदल सकता है।"},soulmate:{en:"YES — strong soulmate signal",hi:"हाँ — मज़बूत सोलमेट संकेत"},horoscope:{en:"Mars + Venus alignment favors confession this lunar cycle. Brave moves are blessed.",hi:"मंगल + शुक्र की युति इस चंद्र-चक्र में इज़हार के लिए शुभ है। साहसी क़दम वरदान पाते हैं।"},content:{en:{golden:{h:"This isn't a normal crush",t:"When numbers, names and vibes align this strongly, it's not random. Listen to it. Most people regret not saying it more than they regret saying it."},protip:{h:"Confess in person, not over text",t:"For a connection this strong, words on a screen lose 70% of their magic. Face to face, calm voice, no expectations — that's the script."},life:{h:"The biggest regret is the unsaid",t:"Years from now you won't remember the awkwardness of speaking up — you'll remember whether you did. Future-you is begging current-you to act."},boost:{h:"Increase your odds further",t:"Look your best, plan a private setting, lead with a compliment, then say it plainly: 'I have feelings for you. I had to tell you.' Clean. Honest. Brave."},next:{h:"Make a plan in 7 days",t:"Don't drift. Set a date in your calendar to talk to them. Tell a trusted friend so you stay accountable. Then walk forward — fortune favors the brave."}},hi:{golden:{h:"ये साधारण क्रश नहीं है",t:"जब अंक, नाम और वाइब इतनी मज़बूती से मिलें, तो इत्तेफ़ाक नहीं। सुनो। ज़्यादातर लोग कह कर पछताते से ज़्यादा न कह कर पछताते हैं।"},protip:{h:"मैसेज से नहीं, मिल कर बोलो",t:"इतने मज़बूत connection के लिए स्क्रीन पर शब्द 70% जादू खो देते हैं। आमने-सामने, शांत आवाज़, बिना उम्मीद — यही स्क्रिप्ट है।"},life:{h:"सबसे बड़ी अफ़सोस अनकही बात की होती है",t:"सालों बाद आपको बोलने की झिझक याद नहीं रहेगी — आपको ये याद रहेगा कि बोला या नहीं। भविष्य का आप, अभी के आप से क़दम उठाने की भीख माँग रहा है।"},boost:{h:"अपनी संभावना और बढ़ाओ",t:"अच्छे कपड़े पहनो, अकेली जगह चुनो, तारीफ़ से शुरू करो, फिर साफ़ कहो: 'मेरे दिल में आपके लिए जज़्बात हैं। मुझे बताना ज़रूरी था।' साफ़, सच्चा, साहसी।"},next:{h:"7 दिनों में प्लान बनाओ",t:"बहो मत। कैलेंडर पर तारीख़ रखो जब बात करनी है। एक भरोसेमंद दोस्त को बताओ ताकि जिम्मेदारी रहे। फिर आगे बढ़ो — किस्मत बहादुरों का साथ देती है।"}}}},
strong:{min:75,emoji:"💗",name:{en:"Strong Crush",hi:"मज़बूत क्रश"},future:{en:"There's real chemistry here. A casual hangout in the next few weeks could turn the corner — they're more interested than they let on.",hi:"असली केमिस्ट्री है। अगले कुछ हफ़्तों में हलकी-फुलकी मुलाक़ात मोड़ ला सकती है — वो दिखाने से ज़्यादा रुचि रखते हैं।"},soulmate:{en:"MAYBE — promising signs",hi:"शायद — आशाजनक संकेत"},horoscope:{en:"Venus is friendly to your zodiac this month. Subtle flirting works better than direct confession.",hi:"शुक्र इस महीने आपकी राशि पर मेहरबान है। सीधे इज़हार से ज़्यादा हलकी-फुलकी फ्लर्टिंग काम करेगी।"},content:{en:{golden:{h:"Don't rush, but don't sleep on it",t:"There's clearly something here. Move with confidence but not desperation. Slow flirting + showing up consistently builds the kind of crush that becomes love."},protip:{h:"Be 5% more interesting in their feed",t:"Subtly upgrade your social presence — a new hobby, a great photo, a witty story. Make them curious. Curiosity is the gateway drug to love."},life:{h:"Mystery is the ultimate flirt",t:"Don't dump your whole life on them. Be present but a little reserved. The space you leave is where their imagination grows."},boost:{h:"From 78% to 90%",t:"Find one shared moment to engineer — a group dinner, a study session, a coincidental meet. Proximity + a good vibe = chemistry."},next:{h:"Test the waters with care",t:"Send one slightly flirty message, then read the response carefully. Warm reply = green light. Cold reply = give space, try again in 2 weeks."}},hi:{golden:{h:"जल्दबाज़ी नहीं, पर देरी भी नहीं",t:"साफ़ है यहाँ कुछ है। आत्मविश्वास से बढ़ो, बेचैनी से नहीं। धीमी फ्लर्टिंग + निरंतर मौजूदगी ऐसा क्रश बनाती है जो प्यार बनता है।"},protip:{h:"उनकी फीड में 5% ज़्यादा दिलचस्प बनो",t:"धीरे-धीरे अपनी सोशल मौजूदगी अपग्रेड करो — नई हॉबी, बढ़िया फोटो, मज़ेदार कहानी। उन्हें कुरेदो। जिज्ञासा प्यार की पहली सीढ़ी है।"},life:{h:"रहस्य सबसे अच्छी फ्लर्ट है",t:"अपनी पूरी ज़िंदगी उन पर मत उँड़ेलो। मौजूद रहो पर थोड़ा सुरक्षित। जो जगह आप छोड़ते हो, वहीं उनकी कल्पना बढ़ती है।"},boost:{h:"78% से 90% तक",t:"एक साझा पल बनाओ — ग्रुप डिनर, स्टडी सेशन, इत्तेफ़ाक से मुलाक़ात। नज़दीकी + अच्छी वाइब = केमिस्ट्री।"},next:{h:"सावधानी से माहौल टटोलो",t:"एक हलकी फ्लर्टी बात भेजो, फिर जवाब ध्यान से पढ़ो। गर्म जवाब = हरी झंडी। ठंडा जवाब = जगह दो, 2 हफ़्ते बाद फिर।"}}}},
real:{min:60,emoji:"💕",name:{en:"Real Crush",hi:"सच्चा क्रश"},future:{en:"You feel something genuine. They notice you too but haven't decided yet. Patience + presence will tip it your way.",hi:"आप कुछ सच्चा महसूस कर रहे हैं। वो भी आपको देखते हैं पर अभी तय नहीं कर पाए। धैर्य + मौजूदगी इसे आपकी तरफ़ झुकाएगी।"},soulmate:{en:"POSSIBLE — needs time",hi:"संभव — समय चाहिए"},horoscope:{en:"Mercury favors meaningful conversations this fortnight. Talk more, text less.",hi:"बुध इस पखवाड़े गहरी बातचीत पर मेहरबान है। बात ज़्यादा, मैसेज कम।"},content:{en:{golden:{h:"You like them — and that matters",t:"Not every crush has to lead somewhere. Just feeling it deeply is a beautiful experience. But if you want more, you'll need to act."},protip:{h:"Become a friend first",t:"Skip-the-friendship-and-confess almost never works. Build real friendship — laugh, listen, show up — and let romantic feelings emerge naturally."},life:{h:"You can't rush a slow heart",t:"Some people fall fast, some slow. If they're slow, pushing scares them away. Be steady, be warm, be patient — and let them catch up."},boost:{h:"From 65% to 80%",t:"Three things this month: 1 meaningful one-on-one chat, 1 small thoughtful gesture, 1 moment of genuine laughter. Repeat."},next:{h:"Earn trust, then earn romance",t:"Trust is the soil of love. Be reliable, be a good listener, remember the small things. Romance grows in that soil naturally."}},hi:{golden:{h:"आप उन्हें पसंद करते हो — और ये क़ीमती है",t:"हर क्रश को कहीं ले जाना ज़रूरी नहीं। बस गहराई से महसूस करना भी एक सुंदर अनुभव है। पर अगर ज़्यादा चाहिए, क़दम उठाने होंगे।"},protip:{h:"पहले दोस्त बनो",t:"दोस्ती छोड़ कर सीधे इज़हार लगभग कभी काम नहीं करता। असली दोस्ती बनाओ — हँसो, सुनो, मौजूद रहो — और रोमांटिक भाव अपने आप उभरने दो।"},life:{h:"धीमे दिल को तेज़ नहीं किया जा सकता",t:"कुछ लोग जल्दी गिरते हैं, कुछ धीरे। अगर वो धीरे हैं, धक्का देने से डर जाते हैं। स्थिर रहो, गर्म रहो, धैर्य रखो — और उन्हें पकड़ने दो।"},boost:{h:"65% से 80% तक",t:"इस महीने तीन चीज़ें: 1 मतलब भरी अकेली बातचीत, 1 छोटा सोच-समझ कर इशारा, 1 असली हँसी का पल। दोहराओ।"},next:{h:"भरोसा कमाओ, फिर रोमांस",t:"भरोसा प्यार की मिट्टी है। भरोसेमंद बनो, अच्छे श्रोता बनो, छोटी बातें याद रखो। रोमांस उसी मिट्टी में अपने आप उगता है।"}}}},
mild:{min:40,emoji:"🌸",name:{en:"Mild Crush",hi:"हल्का क्रश"},future:{en:"Right now it's mostly your side. Whether it grows depends on real-life moments together — not screen time.",hi:"अभी ज़्यादा आपकी तरफ़ से है। बढ़ेगा या नहीं ये असली ज़िंदगी के पलों पर निर्भर है — स्क्रीन समय पर नहीं।"},soulmate:{en:"UNLIKELY — but possible",hi:"असंभावित — पर मुमकिन"},horoscope:{en:"This is a learning crush. Even if it doesn't go anywhere, you'll grow from it.",hi:"ये सीखने वाला क्रश है। अगर कहीं नहीं जाता तब भी आप इससे बढ़ोगे।"},content:{en:{golden:{h:"Some crushes are just lessons",t:"Not every spark is meant to start a fire. Some crushes teach you what you like, what you want, what you're worth. That's valuable in itself."},protip:{h:"Don't build a fantasy",t:"The biggest mistake with mild crushes is creating a version of them in your head that doesn't match reality. Spend real time before falling deeper."},life:{h:"Attraction is data, not destiny",t:"Liking someone tells you about your taste — it doesn't promise anything in return. Hold attraction loosely. Let it inform, not control you."},boost:{h:"Or — don't boost, observe",t:"Before pursuing, just watch for 2 weeks. Notice how they treat people, how they handle stress, whether they're consistent. The truth reveals itself."},next:{h:"Decide if they're worth pursuing",t:"Ask yourself honestly: would my best friend be excited about this person for me? If the answer is hesitation, listen to that hesitation."}},hi:{golden:{h:"कुछ क्रश सिर्फ़ सबक होते हैं",t:"हर चिंगारी आग जलाने के लिए नहीं होती। कुछ क्रश आपको सिखाते हैं — आपको क्या पसंद है, क्या चाहिए, आप किस लायक़ हैं। यही क़ीमती है।"},protip:{h:"कल्पना मत बनाओ",t:"हल्के क्रश की सबसे बड़ी ग़लती है दिमाग़ में उनका एक वर्शन बनाना जो असलियत से मेल नहीं खाता। और गहरे गिरने से पहले असली वक़्त बिताओ।"},life:{h:"आकर्षण डेटा है, क़िस्मत नहीं",t:"किसी को पसंद करना आपके स्वाद के बारे में बताता है — बदले में कुछ वादा नहीं करता। आकर्षण को ढीला पकड़ो। उसे जानकारी बनने दो, क़ाबू नहीं।"},boost:{h:"या — मत बढ़ाओ, देखो",t:"पीछा करने से पहले 2 हफ़्ते देखो। कैसे लोगों से व्यवहार करते हैं, तनाव में क्या करते हैं, क्या निरंतर हैं। सच ख़ुद सामने आता है।"},next:{h:"तय करो क्या वो लायक़ हैं",t:"ख़ुद से ईमानदारी से पूछो: क्या मेरा बेस्ट फ्रेंड इस इंसान के लिए मेरे लिए उत्साहित होगा? अगर जवाब हिचकिचाहट है, उसे सुनो।"}}}},
curiosity:{min:0,emoji:"🤔",name:{en:"Just Curiosity",hi:"बस जिज्ञासा"},future:{en:"This might be more interest than feelings. Spend real time with them before deciding if it's a real crush.",hi:"ये जज़्बात से ज़्यादा कुतूहल हो सकता है। असली क्रश है या नहीं, ये तय करने से पहले असली वक़्त बिताओ।"},soulmate:{en:"NO — different energies",hi:"नहीं — अलग ऊर्जाएँ"},horoscope:{en:"You're not aligned right now. Focus on your own growth — the right energy will find you.",hi:"अभी मेल नहीं है। अपनी ग्रोथ पर ध्यान दो — सही ऊर्जा ख़ुद मिलेगी।"},content:{en:{golden:{h:"Not every spark is romantic",t:"Sometimes we confuse attention with attraction, or curiosity with crush. Pause and ask: do I actually want THEM, or just the idea of someone like them?"},protip:{h:"Date yourself first",t:"The most magnetic people aren't desperately searching — they're busy building lives they love. Become that person, and the right crush will appear."},life:{h:"Lonely is not love",t:"Lonely chasing creates fake crushes. Heal the loneliness first, then attraction becomes a choice, not a need. That's where healthy love starts."},boost:{h:"Don't boost — redirect",t:"Use this energy on yourself. New skill, new style, new social circle. The version of you in 6 months will attract the right energy effortlessly."},next:{h:"Audit your romantic life",t:"What patterns do you see? Same type of crush, same outcome? Awareness is step one. Therapy or honest self-reflection can unlock new chapters."}},hi:{golden:{h:"हर चिंगारी रोमांटिक नहीं होती",t:"कई बार हम ध्यान को आकर्षण समझ लेते हैं, या कुतूहल को क्रश। रुक कर पूछो: क्या मुझे सच में 'वो' चाहिए, या बस उन जैसा कोई?"},protip:{h:"पहले ख़ुद को डेट करो",t:"सबसे चुंबकीय लोग बेताबी से नहीं ढूँढ रहे होते — वो अपनी ज़िंदगी बना रहे होते हैं जो उन्हें पसंद है। वैसे बनो, और सही क्रश ख़ुद आएगा।"},life:{h:"अकेलापन प्यार नहीं है",t:"अकेलेपन वाला पीछा नक़ली क्रश बनाता है। पहले अकेलापन सुधारो, फिर आकर्षण ज़रूरत नहीं, चुनाव बन जाता है। वहीं से स्वस्थ प्यार शुरू होता है।"},boost:{h:"मत बढ़ाओ — दिशा बदलो",t:"इस ऊर्जा को ख़ुद पर लगाओ। नई स्किल, नया स्टाइल, नया दायरा। 6 महीने बाद का आप का वर्शन बिना मेहनत सही ऊर्जा आकर्षित करेगा।"},next:{h:"अपनी रोमांटिक ज़िंदगी का ऑडिट करो",t:"कौन से पैटर्न दिखते हैं? वही टाइप का क्रश, वही नतीजा? जागरूकता पहला क़दम है। थेरेपी या ईमानदार आत्म-चिंतन नए अध्याय खोल सकता है।"}}}}
};

/* ===== MULANK 1-9 PROFILES ===== */
var MULANK={
1:{planet:{en:"Sun",hi:"सूर्य"},color:{en:"Golden, Orange",hi:"सुनहरा, नारंगी"},day:{en:"Sunday",hi:"रविवार"},lucky:{en:"1, 4, 9",hi:"1, 4, 9"},compat:{en:"1, 3, 5, 9",hi:"1, 3, 5, 9"},personality:{en:"Natural leader, ambitious, confident, original thinker. You walk in like the room belongs to you. Born to lead, hates being told what to do.",hi:"प्राकृतिक नेता, महत्वाकांक्षी, आत्मविश्वासी, मौलिक सोच। आप ऐसे आते हैं जैसे कमरा आपका है। नेतृत्व के लिए बने, आदेश सुनना पसंद नहीं।"},career:{en:"CEO, Entrepreneur, Politician, Manager, Government Officer, Brand Founder, Director",hi:"CEO, उद्यमी, राजनेता, मैनेजर, सरकारी अधिकारी, ब्रांड फ़ाउंडर, डायरेक्टर"},golden:{en:"You were born to lead — but the best leaders also know when to listen. Mastering both will be your superpower.",hi:"आप नेतृत्व के लिए बने हो — पर सबसे अच्छे नेता वो होते हैं जो सुनना भी जानते हैं। दोनों में महारत आपकी असली ताक़त होगी।"},pro:{en:"Sun energy burns out if unmanaged. Schedule rest like you schedule meetings. Your fire needs feeding, not constant action.",hi:"सूर्य ऊर्जा बिना संभाले जल जाती है। आराम को मीटिंग की तरह शेड्यूल करो। आपकी आग को खुराक चाहिए, लगातार कार्य नहीं।"},life:{en:"Independence is your strength and your trap. Learn to receive help — not as weakness but as connection.",hi:"स्वतंत्रता आपकी ताक़त और जाल दोनों है। मदद लेना सीखो — कमज़ोरी के तौर पर नहीं, जुड़ाव के तौर पर।"},boost:{en:"Wake before sunrise twice a week, take leadership of one project this month, donate to a sun-related cause.",hi:"हफ़्ते में दो बार सूर्योदय से पहले उठो, इस महीने एक प्रोजेक्ट का नेतृत्व लो, सूर्य से जुड़े किसी कारण को दान करो।"},next:{en:"Pick one bold goal — only 1. Mulank 1s achieve through focused fire, not scattered effort.",hi:"एक साहसी लक्ष्य चुनो — सिर्फ़ 1। मूलांक 1 बिखरी मेहनत से नहीं, केंद्रित आग से उपलब्धि पाते हैं।"}},
2:{planet:{en:"Moon",hi:"चंद्र"},color:{en:"White, Silver, Cream",hi:"सफ़ेद, चाँदी, क्रीम"},day:{en:"Monday",hi:"सोमवार"},lucky:{en:"2, 7, 11",hi:"2, 7, 11"},compat:{en:"1, 2, 7, 9",hi:"1, 2, 7, 9"},personality:{en:"Gentle, intuitive, deeply emotional, peace-maker. You feel everything 2x as much. Born diplomat, natural caretaker, sensitive soul.",hi:"नर्म, सहज ज्ञान, गहरे भावुक, शांति बनाने वाले। आप सब कुछ 2 गुना महसूस करते हो। जन्मजात राजनयिक, सहज देखभाल करने वाले, संवेदनशील आत्मा।"},career:{en:"Counsellor, Teacher, Nurse, Diplomat, Artist, Writer, Hospitality, Therapist",hi:"काउंसलर, शिक्षक, नर्स, राजनयिक, कलाकार, लेखक, हॉस्पिटैलिटी, थेरेपिस्ट"},golden:{en:"Your emotions are not a weakness — they're your radar. The world needs more people who feel deeply, not fewer.",hi:"आपकी भावनाएँ कमज़ोरी नहीं — आपका रडार हैं। दुनिया को ऐसे लोग और चाहिए जो गहराई से महसूस करें।"},pro:{en:"Protect your energy fiercely. You absorb others' moods. Limit time with draining people; recharge in solitude.",hi:"अपनी ऊर्जा की कड़ी रक्षा करो। आप दूसरों के मूड सोखते हो। थकाने वाले लोगों से समय कम, अकेलेपन में रिचार्ज ज़्यादा।"},life:{en:"Sensitivity is your gift. Stop apologizing for caring too much — the world is harder, not better, when no one cares.",hi:"संवेदनशीलता आपका तोहफ़ा है। ज़्यादा परवाह करने के लिए माफ़ी माँगना बंद करो — दुनिया तब कठिन है, अच्छी नहीं, जब कोई परवाह नहीं करता।"},boost:{en:"Spend time near water, journal nightly, surround yourself with white/silver tones, meditate under moonlight.",hi:"पानी के पास समय बिताओ, रात में डायरी लिखो, ख़ुद को सफ़ेद/चाँदी रंगों से घेरो, चाँदनी में ध्यान करो।"},next:{en:"Trust your gut more — Mulank 2 intuition is often correct before logic catches up.",hi:"अपने अंदर की आवाज़ पर ज़्यादा भरोसा करो — मूलांक 2 का सहज ज्ञान अक्सर तर्क से पहले सही होता है।"}},
3:{planet:{en:"Jupiter",hi:"बृहस्पति"},color:{en:"Yellow, Purple",hi:"पीला, बैंगनी"},day:{en:"Thursday",hi:"गुरुवार"},lucky:{en:"3, 6, 9",hi:"3, 6, 9"},compat:{en:"3, 6, 9, 1",hi:"3, 6, 9, 1"},personality:{en:"Optimistic, expressive, creative, magnetic. You light up rooms and conversations. Born storyteller, generous spirit, wisdom-seeker.",hi:"आशावादी, अभिव्यक्तिशील, रचनात्मक, चुंबकीय। आप कमरे और बातचीत रोशन करते हैं। जन्मजात कहानीकार, उदार आत्मा, ज्ञान खोजने वाले।"},career:{en:"Writer, Teacher, Speaker, Actor, Lawyer, Spiritual Guide, Content Creator, Designer",hi:"लेखक, शिक्षक, वक्ता, अभिनेता, वकील, आध्यात्मिक गुरु, कंटेंट क्रिएटर, डिज़ाइनर"},golden:{en:"Your words have power — use them to build, never to wound. Mulank 3 carries Jupiter's blessing of wisdom.",hi:"आपके शब्दों में ताक़त है — इन्हें बनाने के लिए इस्तेमाल करो, चोट देने के लिए नहीं। मूलांक 3 बृहस्पति के ज्ञान का आशीर्वाद रखता है।"},pro:{en:"You can talk anyone into anything — including yourself. Pause before big decisions. Check with a Mulank 4 or 8 friend.",hi:"आप किसी को भी कुछ भी मनवा सकते हो — ख़ुद को भी। बड़े फ़ैसलों से पहले रुको। मूलांक 4 या 8 दोस्त से सलाह लो।"},life:{en:"Your optimism is contagious — but reality still exists. Balance dreams with execution. Big talk + small action = nothing.",hi:"आपका आशावाद संक्रामक है — पर हक़ीक़त भी है। सपनों को अमल से संतुलित करो। बड़ी बात + छोटा काम = कुछ नहीं।"},boost:{en:"Wear yellow on Thursdays, donate to teachers/students, learn one new word daily, write daily for 21 days.",hi:"गुरुवार को पीला पहनो, शिक्षकों/छात्रों को दान करो, रोज़ एक नया शब्द सीखो, 21 दिन रोज़ लिखो।"},next:{en:"Choose ONE creative outlet and master it. Mulank 3 power scatters when divided across too many passions.",hi:"एक रचनात्मक क्षेत्र चुनो और महारत हासिल करो। मूलांक 3 की शक्ति बहुत सारे शौक़ों में बँट कर बिखर जाती है।"}},
4:{planet:{en:"Rahu",hi:"राहु"},color:{en:"Blue, Grey",hi:"नीला, स्लेटी"},day:{en:"Saturday",hi:"शनिवार"},lucky:{en:"4, 8, 22",hi:"4, 8, 22"},compat:{en:"1, 5, 7, 8",hi:"1, 5, 7, 8"},personality:{en:"Disciplined, original, hard worker, rebel inside. You build things others quit on. Methodical mind, unconventional path, late bloomer.",hi:"अनुशासित, मौलिक, मेहनती, अंदर से बाग़ी। आप वो बनाते हो जो दूसरे छोड़ देते हैं। पद्धतिगत दिमाग़, अनोखा रास्ता, देर से खिलने वाले।"},career:{en:"Engineer, Architect, Researcher, IT/Tech, Strategist, Banker, Logistics, Systems Builder",hi:"इंजीनियर, आर्किटेक्ट, शोधकर्ता, IT/Tech, रणनीतिकार, बैंकर, लॉजिस्टिक्स, सिस्टम बिल्डर"},golden:{en:"Your journey is non-linear by design. Trust the slow build — Mulank 4 success arrives late but lasts longest.",hi:"आपकी यात्रा डिज़ाइन से ही टेढ़ी है। धीमी निर्माण पर भरोसा करो — मूलांक 4 की सफलता देर से आती है पर सबसे लंबी टिकती है।"},pro:{en:"You over-think. Set a 5-minute decision timer for small things and a 5-day max for big ones. Action beats analysis.",hi:"आप ज़्यादा सोचते हो। छोटी बातों के लिए 5 मिनट का टाइमर, बड़ी के लिए 5 दिन की सीमा। कार्य विश्लेषण से बेहतर है।"},life:{en:"Mulank 4 rewrites the rules. You'll feel out of place often — that's because you're meant to create new spaces, not fit old ones.",hi:"मूलांक 4 नियम फिर से लिखते हैं। आप अक्सर बेमेल महसूस करोगे — क्योंकि आपको नई जगहें बनानी हैं, पुरानी में फिट होना नहीं।"},boost:{en:"Avoid clutter — physical and mental. Donate something every Saturday. Wear deep blue on key meetings.",hi:"बिखराव से बचो — शारीरिक और मानसिक। हर शनिवार कुछ दान करो। ज़रूरी मीटिंग पर गहरा नीला पहनो।"},next:{en:"Pick one long-term project (3+ years) and commit. Mulank 4 builds empires, not quick wins.",hi:"एक लंबा (3+ साल) प्रोजेक्ट चुनो और जुट जाओ। मूलांक 4 साम्राज्य बनाते हैं, जल्दी जीत नहीं।"}},
5:{planet:{en:"Mercury",hi:"बुध"},color:{en:"Green, Light Blue",hi:"हरा, हल्का नीला"},day:{en:"Wednesday",hi:"बुधवार"},lucky:{en:"5, 14, 23",hi:"5, 14, 23"},compat:{en:"1, 5, 6, 9",hi:"1, 5, 6, 9"},personality:{en:"Quick-witted, adaptable, restless, communicator. You think fast, talk faster, get bored faster. Born networker, eternal student, free spirit.",hi:"तेज़ बुद्धि, अनुकूल, बेचैन, संवाद-कुशल। आप तेज़ सोचते हो, उससे तेज़ बोलते हो, और जल्दी ऊब जाते हो। जन्मजात नेटवर्कर, हमेशा छात्र, मुक्त आत्मा।"},career:{en:"Marketing, Sales, Journalism, Trading, Social Media, Consulting, Translation, Tech Sales",hi:"मार्केटिंग, सेल्स, पत्रकारिता, ट्रेडिंग, सोशल मीडिया, कंसल्टिंग, अनुवाद, टेक सेल्स"},golden:{en:"Your mind is your fortune. Read 30 minutes daily — Mulank 5 success is built on a constantly upgraded mind.",hi:"आपका दिमाग़ आपकी क़िस्मत है। रोज़ 30 मिनट पढ़ो — मूलांक 5 की सफलता लगातार अपग्रेड दिमाग़ से बनती है।"},pro:{en:"You start fast but lose interest. Pick 3 projects max, finish them before starting new ones. Discipline is your missing ingredient.",hi:"आप तेज़ शुरू करते हो पर रुचि खो देते हो। ज़्यादा से ज़्यादा 3 प्रोजेक्ट, नए शुरू करने से पहले उन्हें पूरा करो। अनुशासन आपकी कमी है।"},life:{en:"Freedom is your air. Don't accept jobs, relationships or lifestyles that cage you. Adapt or move — never settle.",hi:"स्वतंत्रता आपकी हवा है। वो नौकरी, रिश्ते या जीवनशैली मत स्वीकारो जो पिंजरा बने। अनुकूलित हो या आगे बढ़ो — समझौता मत करो।"},boost:{en:"Travel often (even short trips), learn one skill per quarter, wear green on Wednesdays, network 5 new people/month.",hi:"अक्सर सफ़र करो (छोटे भी), तिमाही में एक स्किल सीखो, बुधवार को हरा पहनो, महीने में 5 नए लोगों से मिलो।"},next:{en:"Stop changing direction every 6 months. Pick a 3-year arc and stick to it — speed compounds when direction is fixed.",hi:"हर 6 महीने में दिशा बदलना बंद करो। 3-साल का चाप चुनो और टिको — दिशा तय हो तो रफ़्तार गुणा होती है।"}},
6:{planet:{en:"Venus",hi:"शुक्र"},color:{en:"Pink, White, Pastel",hi:"गुलाबी, सफ़ेद, पेस्टल"},day:{en:"Friday",hi:"शुक्रवार"},lucky:{en:"6, 15, 24",hi:"6, 15, 24"},compat:{en:"3, 6, 9",hi:"3, 6, 9"},personality:{en:"Charming, artistic, loving, harmony-seeker. People are drawn to you. Born beautifier — of spaces, relationships and lives.",hi:"मोहक, कलात्मक, प्यार करने वाले, सामंजस्य खोजी। लोग आपकी ओर खिंचते हैं। जन्मजात सुंदरता लाने वाले — जगहों, रिश्तों और ज़िंदगियों में।"},career:{en:"Designer, Artist, Beauty, Fashion, Hospitality, Wedding Planner, Entertainment, Real Estate",hi:"डिज़ाइनर, कलाकार, ब्यूटी, फ़ैशन, हॉस्पिटैलिटी, वेडिंग प्लानर, मनोरंजन, रियल एस्टेट"},golden:{en:"Your charm is currency — but currency runs out if you only spend, never invest. Build skills behind your beauty.",hi:"आपका आकर्षण मुद्रा है — पर मुद्रा ख़त्म हो जाती है अगर सिर्फ़ खर्च करो, निवेश नहीं। ख़ूबसूरती के पीछे स्किल बनाओ।"},pro:{en:"You give too much, too fast. Slow down. Test reciprocity. Love yourself enough to be selective with whom you pour into.",hi:"आप जल्दी, ज़्यादा देते हो। धीमे हो। आदान-प्रदान जाँचो। ख़ुद से इतना प्यार करो कि सोच-समझ कर चुनो किस पर बहो।"},life:{en:"You attract chaos to fix and people to save. Stop being the rescuer. People grow when you stop carrying them.",hi:"आप अराजकता और बचाने लायक़ लोगों को आकर्षित करते हो। बचाने वाला बनना बंद करो। लोग तब बढ़ते हैं जब आप उठाना बंद करते हो।"},boost:{en:"Surround yourself with art and music, donate to women/children causes on Friday, wear pastels, take care of your skin and home.",hi:"कला और संगीत से ख़ुद को घेरो, शुक्रवार को महिला/बच्चों को दान करो, पेस्टल पहनो, अपनी त्वचा और घर का ख्याल रखो।"},next:{en:"Build one income source that doesn't depend on your charm — a skill, a product, an investment. Future you will thank you.",hi:"एक आय का स्रोत बनाओ जो आपके आकर्षण पर निर्भर न हो — एक स्किल, एक उत्पाद, एक निवेश। भविष्य का आप शुक्रिया कहेगा।"}},
7:{planet:{en:"Ketu",hi:"केतु"},color:{en:"Purple, Teal",hi:"बैंगनी, टील"},day:{en:"Monday",hi:"सोमवार"},lucky:{en:"7, 16, 25",hi:"7, 16, 25"},compat:{en:"2, 4, 7",hi:"2, 4, 7"},personality:{en:"Mystical, philosophical, deep thinker, introvert. You live half in this world, half in another. Born seeker, spiritual researcher, lone wolf.",hi:"रहस्यमय, दार्शनिक, गहरे विचारक, अंतर्मुखी। आप आधे इस दुनिया में, आधे दूसरी में रहते हो। जन्मजात खोजी, आध्यात्मिक शोधकर्ता, अकेला भेड़िया।"},career:{en:"Researcher, Writer, Spiritual Healer, Astrologer, Data Scientist, Psychologist, Photographer, Monk",hi:"शोधकर्ता, लेखक, आध्यात्मिक हीलर, ज्योतिषी, डेटा साइंटिस्ट, मनोवैज्ञानिक, फ़ोटोग्राफ़र, साधु"},golden:{en:"Your loneliness isn't loneliness — it's depth. You see what others miss. Trust the inner voice; it's louder than logic.",hi:"आपका अकेलापन अकेलापन नहीं — गहराई है। आप वो देखते हो जो दूसरे चूकते हैं। अंदर की आवाज़ पर भरोसा करो; ये तर्क से तेज़ है।"},pro:{en:"Overthinking will eat you alive. Set a 'thought stop' rule: 10 minutes thinking, then move. Action grounds the mind.",hi:"ज़्यादा सोचना आपको खा जाएगा। 'सोच रोको' नियम बनाओ: 10 मिनट सोच, फिर हरकत। कार्य दिमाग़ को ज़मीन देता है।"},life:{en:"You'll find your tribe late — but they'll be the right tribe. Don't dilute yourself to fit in faster.",hi:"आपको अपना क़बीला देर से मिलेगा — पर वो सही क़बीला होगा। जल्दी फ़िट होने के लिए ख़ुद को पतला मत करो।"},boost:{en:"Meditate 15 min daily, read philosophy/poetry, spend time alone in nature, avoid alcohol & overstimulation.",hi:"रोज़ 15 मिनट ध्यान, दर्शन/कविता पढ़ो, प्रकृति में अकेले समय बिताओ, शराब और अति-उत्तेजना से बचो।"},next:{en:"Write your thoughts. Mulank 7 wisdom is meant to be shared — through writing, teaching, or quiet 1-on-1 guidance.",hi:"अपने विचार लिखो। मूलांक 7 का ज्ञान बाँटने के लिए है — लिखने से, सिखाने से, या शांत 1-पर-1 मार्गदर्शन से।"}},
8:{planet:{en:"Saturn",hi:"शनि"},color:{en:"Black, Dark Blue",hi:"काला, गहरा नीला"},day:{en:"Saturday",hi:"शनिवार"},lucky:{en:"8, 17, 26",hi:"8, 17, 26"},compat:{en:"4, 5, 8",hi:"4, 5, 8"},personality:{en:"Ambitious, persistent, karmic, justice-oriented. Life tests you hardest because you're built strongest. Born for material mastery, late success.",hi:"महत्वाकांक्षी, दृढ़, कर्म-केंद्रित, न्याय-पसंद। ज़िंदगी आपकी सबसे कठिन परीक्षा लेती है क्योंकि आप सबसे मज़बूत बनाए गए हो। भौतिक महारत के लिए जन्मे, देर से सफलता।"},career:{en:"Business Owner, Real Estate, Banking, Law, Politics, Mining, Manufacturing, Executive Roles",hi:"व्यवसायी, रियल एस्टेट, बैंकिंग, क़ानून, राजनीति, खनन, निर्माण, कार्यकारी पद"},golden:{en:"Saturn rewards patience like no other planet. Mulank 8 success is delayed, not denied. Your 35-50 phase will shock people.",hi:"शनि धैर्य का इनाम और किसी ग्रह जैसा नहीं देता। मूलांक 8 की सफलता टली है, टूटी नहीं। आपका 35-50 का दौर लोगों को चौंकाएगा।"},pro:{en:"Karma is your law. Cut corners and Saturn will collect. Be ethical, even when slow — Mulank 8 wealth must be earned cleanly.",hi:"कर्म आपका क़ानून है। शॉर्टकट लोगे और शनि वसूल लेगा। नैतिक रहो, चाहे धीमा हो — मूलांक 8 की दौलत साफ़ कमानी होती है।"},life:{en:"Your struggles aren't punishments — they're forging. Every Mulank 8 has a backstory worthy of a movie. Yours will too.",hi:"आपके संघर्ष सज़ा नहीं — गढ़ाई हैं। हर मूलांक 8 के पास फ़िल्म जैसी कहानी होती है। आपकी भी होगी।"},boost:{en:"Donate to elderly/disabled on Saturdays, wear dark blue/black, plant a tree, avoid alcohol on Saturdays.",hi:"शनिवार को बुज़ुर्गों/दिव्यांगों को दान करो, गहरा नीला/काला पहनो, पेड़ लगाओ, शनिवार को शराब से बचो।"},next:{en:"Play the long game. Mulank 8 wins come after 3 failures and 7 lessons. Document, learn, persist — you will arrive.",hi:"लंबा खेल खेलो। मूलांक 8 की जीत 3 असफलताओं और 7 सबकों के बाद आती है। दस्तावेज़, सीखो, टिको — आप पहुँचोगे।"}},
9:{planet:{en:"Mars",hi:"मंगल"},color:{en:"Red, Maroon",hi:"लाल, मरून"},day:{en:"Tuesday",hi:"मंगलवार"},lucky:{en:"9, 18, 27",hi:"9, 18, 27"},compat:{en:"3, 6, 9",hi:"3, 6, 9"},personality:{en:"Bold, passionate, warrior, protector. You feel fire in your bones. Born to fight for causes, defend the weak, blaze trails.",hi:"साहसी, जुनूनी, योद्धा, रक्षक। आप हड्डियों में आग महसूस करते हो। कारणों के लिए लड़ने, कमज़ोरों की रक्षा करने, रास्ते बनाने को जन्मे।"},career:{en:"Military, Police, Doctor, Surgeon, Engineer, Athlete, Activist, Cause-driven Entrepreneur",hi:"सेना, पुलिस, डॉक्टर, सर्जन, इंजीनियर, खिलाड़ी, कार्यकर्ता, उद्देश्य-केंद्रित उद्यमी"},golden:{en:"Your anger is a tool — but only if you control it. Untamed Mars destroys; trained Mars liberates. Channel the fire.",hi:"आपका ग़ुस्सा एक औज़ार है — पर तभी जब आप उसे क़ाबू में रखो। बेलगाम मंगल तबाह करता है; प्रशिक्षित मंगल मुक्त करता है। आग को दिशा दो।"},pro:{en:"You react before you think. Install a 24-hour rule on heated decisions. The world is bigger than the moment.",hi:"आप सोचने से पहले प्रतिक्रिया करते हो। गुस्से वाले फ़ैसलों पर 24-घंटे का नियम लगाओ। दुनिया पल से बड़ी है।"},life:{en:"You'll fight wars others run from. That's your gift and your weight. Choose your battles — not every fight is yours.",hi:"आप वो जंगें लड़ोगे जिनसे दूसरे भागते हैं। यही आपका तोहफ़ा और बोझ है। जंगें चुनो — हर लड़ाई आपकी नहीं है।"},boost:{en:"Exercise hard 4x/week, wear red on Tuesdays, donate blood/serve at gurudwara, avoid red meat on Tuesdays.",hi:"हफ़्ते में 4 बार कठिन व्यायाम, मंगलवार को लाल पहनो, रक्तदान/गुरुद्वारे में सेवा, मंगलवार को लाल मांस से बचो।"},next:{en:"Pick a cause worth your fire. Mulank 9 burns out without a mission. With a mission, you're unstoppable.",hi:"अपनी आग के लायक़ कारण चुनो। बिना मक़सद मूलांक 9 जल कर ख़त्म हो जाता है। मक़सद के साथ आप अजेय हो।"}}
};

/* ===== EXTRAS POOLS ===== */
var SONGS=["Yaaron — KK","Best Friend — Doja Cat","Count on Me — Bruno Mars","Tera Yaar Hoon Main — Arijit Singh","Lean on Me — Bill Withers","You've Got a Friend — Carole King","Tum Hi Ho — Arijit Singh","Perfect — Ed Sheeran","All of Me — John Legend","Pehla Nasha — Udit Narayan","Tera Ban Jaunga — Akhil","Channa Mereya — Arijit Singh"];
var PETS=["Golden Retriever — loyal and joyful","Persian Cat — calm and elegant","Beagle — curious and friendly","Cockatiel — chatty and playful","Hamster — small and low-key","Rabbit — gentle and bonding","Labrador — protective and warm","Fish (Betta) — peaceful and meditative","German Shepherd — loyal and brave","Siberian Husky — independent yet caring"];
var CAREERS_FRIEND=["Co-founding a business together","Travel vlogging duo","Joint freelance studio","Podcast hosts","Co-investing in real estate","Charity initiative partners","YouTube channel duo","Café/restaurant co-owners","Adventure trip leaders","Music band partners"];
var DATES=["A long walk at sunset with chai","Cook a new recipe together","Stargazing on the terrace","Mini road-trip — no plan","Movie marathon with their favourites","Bookstore — pick books for each other","Try a new cuisine","Plant a tree together","Spa night at home","Watch the first rain together"];

/* ===== INIT ===== */
function init(ROOT){
if(!ROOT||ROOT.dataset.cctInit==="1")return;
ROOT.dataset.cctInit="1";
function $(s,r){return (r||ROOT).querySelector(s);}
function $$(s,r){return Array.prototype.slice.call((r||ROOT).querySelectorAll(s));}
function clamp(v,a,b){return Math.max(a,Math.min(b,v));}
function show(el){if(el){el.style.display="";el.removeAttribute("hidden");}}
function hide(el){if(el){el.style.display="none";}}
function esc(s){return (s||"").replace(/[&<>"']/g,function(c){return ({"&":"&amp;","<":"&lt;",">":"&gt;","\"":"&quot;","'":"&#39;"})[c];});}
function capWords(s){return (s||"").replace(/\b[a-zऀ-ॿ]/g,function(c){return c.toUpperCase();});}
function cleanName(s){return (s||"").toLowerCase().replace(/[^a-zऀ-ॿ]/g,"");}
function pickFrom(arr,seed){return arr[Math.abs(seed)%arr.length];}
function luckyDay(seed){var d=["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"];var h=["सोमवार","मंगलवार","बुधवार","गुरुवार","शुक्रवार","शनिवार","रविवार"];return lang==="hi"?h[Math.abs(seed)%7]:d[Math.abs(seed)%7];}

var tool=ROOT.dataset.tool;
var lang=ROOT.dataset.lang==="hi"?"hi":"en";
var mode=ROOT.dataset.mode==="advanced"?"advanced":"basic";
var soundOn=ROOT.dataset.sound==="1";
var hapticsOn=ROOT.dataset.haptics==="1";

function applyI18n(){var dict=I18N[lang];$$("[data-i18n]").forEach(function(el){var k=el.getAttribute("data-i18n");if(dict[k])el.textContent=dict[k];});var today=new Date().toISOString().split("T")[0];$$(".cct-input[type=date]").forEach(function(d){d.setAttribute("max",today);});}

/* ===== ALGORITHMS ===== */
function letterScore(letters,combined){var counts=[];for(var i=0;i<letters.length;i++){var c=0;for(var j=0;j<combined.length;j++)if(combined[j]===letters[i])c++;counts.push(c);}var digits=counts.join("");while(digits.length>2){var nd="";var a=0,b=digits.length-1;while(a<b){nd+=(parseInt(digits[a],10)+parseInt(digits[b],10));a++;b--;}if(a===b)nd+=digits[a];digits=nd;}var v=parseInt(digits,10)||0;if(v>100)v=parseInt(String(v).slice(-2),10);return v;}
function nameOverlap(a,b){var sa=a.split(""),sb=b.split(""),common=0,bc=sb.slice();sa.forEach(function(c){var i=bc.indexOf(c);if(i>-1){common++;bc.splice(i,1);}});var total=sa.length+sb.length;return total===0?50:Math.round((common*2/total)*100);}
function nameNum(n){var s=n.toLowerCase().replace(/[^a-z]/g,"");var sum=0;for(var i=0;i<s.length;i++)sum+=(s.charCodeAt(i)-96);while(sum>9&&sum!==11&&sum!==22){var t=0;String(sum).split("").forEach(function(d){t+=parseInt(d,10);});sum=t;}return sum||1;}
function dobMulank(d){if(!d)return 0;var dt=new Date(d);if(isNaN(dt))return 0;var day=dt.getDate();while(day>9){var t=0;String(day).split("").forEach(function(x){t+=parseInt(x,10);});day=t;}return day;}
function dobBhagyank(d){if(!d)return 0;var dt=new Date(d);if(isNaN(dt))return 0;var s=String(dt.getDate())+String(dt.getMonth()+1)+String(dt.getFullYear());var sum=0;s.split("").forEach(function(x){sum+=parseInt(x,10);});while(sum>9){var t=0;String(sum).split("").forEach(function(x){t+=parseInt(x,10);});sum=t;}return sum;}
function zodiacFromDate(d){if(!d)return null;var dt=new Date(d);if(isNaN(dt))return null;var m=dt.getMonth()+1,day=dt.getDate();var r=[["Capricorn",[12,22],[1,19]],["Aquarius",[1,20],[2,18]],["Pisces",[2,19],[3,20]],["Aries",[3,21],[4,19]],["Taurus",[4,20],[5,20]],["Gemini",[5,21],[6,20]],["Cancer",[6,21],[7,22]],["Leo",[7,23],[8,22]],["Virgo",[8,23],[9,22]],["Libra",[9,23],[10,22]],["Scorpio",[10,23],[11,21]],["Sagittarius",[11,22],[12,21]]];for(var i=0;i<r.length;i++){var z=r[i],s=z[1],e=z[2];if((m===s[0]&&day>=s[1])||(m===e[0]&&day<=e[1]))return z[0];}return "Capricorn";}

/* ===== AUDIO/HAPTICS ===== */
var audioCtx=null;
function beep(f,d,t){if(!soundOn)return;try{audioCtx=audioCtx||new (window.AudioContext||window.webkitAudioContext)();var o=audioCtx.createOscillator();var g=audioCtx.createGain();o.type=t||"sine";o.frequency.value=f;g.gain.value=0.06;o.connect(g);g.connect(audioCtx.destination);o.start();g.gain.exponentialRampToValueAtTime(0.0001,audioCtx.currentTime+(d||0.18));o.stop(audioCtx.currentTime+(d||0.18)+0.02);}catch(e){}}
function buzz(ms){if(!hapticsOn)return;try{if(navigator.vibrate)navigator.vibrate(ms||12);}catch(e){}}
function setError(m){var b=$(".cct-err");if(!b)return;if(m){b.textContent=m;b.classList.add("is-on");b.style.display="block";buzz(40);}else{b.classList.remove("is-on");b.style.display="none";b.textContent="";}}
function confetti(){var box=$(".cct-confetti");if(!box)return;box.innerHTML="";box.classList.add("is-go");var emojis=tool==="crush"?["💘","💖","💕","💗","💝","🌹"]:tool==="mulank"?["✨","💫","🌟","⭐","🔮","🪄"]:["🤝","💛","💜","💚","🌟","✨"];for(var i=0;i<32;i++){var p=document.createElement("span");p.className="cct-conf-piece";p.textContent=emojis[i%emojis.length];p.style.left=(50+(Math.random()*40-20))+"%";p.style.top="100px";p.style.setProperty("--cct-x",(Math.random()*600-300)+"px");p.style.setProperty("--cct-y",(Math.random()*-360-60)+"px");p.style.animationDelay=(Math.random()*0.25)+"s";box.appendChild(p);}setTimeout(function(){box.classList.remove("is-go");box.innerHTML="";},1700);}

function animateNum(el,from,to,dur){if(!el)return;var t0=(typeof performance!=="undefined"&&performance.now)?performance.now():Date.now();function step(){var now=(typeof performance!=="undefined"&&performance.now)?performance.now():Date.now();var p=clamp((now-t0)/dur,0,1);var v=Math.round(from+(to-from)*(1-Math.pow(1-p,3)));if(!isNaN(v))el.textContent=v;if(p<1)requestAnimationFrame(step);else el.textContent=to;}step();}

/* ===== RESULT RENDERERS ===== */
function getTierFriend(s){if(s>=90)return FRIEND_TIERS.soul;if(s>=75)return FRIEND_TIERS.close;if(s>=60)return FRIEND_TIERS.good;if(s>=40)return FRIEND_TIERS.casual;return FRIEND_TIERS.distant;}
function getTierCrush(s){if(s>=90)return CRUSH_TIERS.destined;if(s>=75)return CRUSH_TIERS.strong;if(s>=60)return CRUSH_TIERS.real;if(s>=40)return CRUSH_TIERS.mild;return CRUSH_TIERS.curiosity;}

function renderScoreHead(score,emoji,tier,n1,n2){
  var head=$(".cct-result-head");
  var coupleHtml=n2?'<div class="cct-couple"><div class="cct-cp cct-cp-1"><span class="cct-init">'+esc((n1[0]||"?").toUpperCase())+'</span>'+esc(capWords(n1))+'</div><div class="cct-link-result">'+(tool==="crush"?"💘":"🤝")+'</div><div class="cct-cp cct-cp-2"><span class="cct-init">'+esc((n2[0]||"?").toUpperCase())+'</span>'+esc(capWords(n2))+'</div></div>':"";
  var qSrc=tier.quote||tier.future||null;
  var qText=qSrc?(qSrc[lang]||qSrc.en||""):"";
  head.innerHTML=coupleHtml+
    '<div class="cct-score-meter"><svg viewBox="0 0 200 200"><defs><linearGradient id="cct-grad" x1="0" y1="0" x2="1" y2="1"><stop offset="0%" stop-color="#7C3AED"/><stop offset="50%" stop-color="#EC4899"/><stop offset="100%" stop-color="#10B981"/></linearGradient></defs><circle class="cct-score-bg" cx="100" cy="100" r="85"/><circle class="cct-score-fg" cx="100" cy="100" r="85"/></svg><div class="cct-score-num"><div class="cct-score-emoji">'+emoji+'</div><div><span class="cct-score-val">0</span><span class="cct-score-pct">%</span></div></div></div>'+
    '<h3 class="cct-tier-name">'+esc(tier.name[lang])+'</h3>'+
    '<p class="cct-tier-tag">'+(tool==="friendship"?(lang==="hi"?"फ्रेंडशिप वाइब":"FRIENDSHIP VIBE"):(lang==="hi"?"क्रश वाइब":"CRUSH VIBE"))+'</p>'+
    (qText?'<blockquote class="cct-quote">'+esc(qText)+'</blockquote>':'');
  setTimeout(function(){var fg=$(".cct-score-fg");if(fg){var circ=2*Math.PI*85;fg.style.strokeDasharray=circ;fg.style.strokeDashoffset=circ-(circ*score/100);}animateNum($(".cct-score-val"),0,score,1500);},80);
}

function showResultFriend(state){
  var t=getTierFriend(state.total);
  renderScoreHead(state.total,t.emoji,t,state.names.n1,state.names.n2);
  var c=t.content[lang]||t.content.en;
  fillAdvice("golden",c.golden);fillAdvice("protip",c.protip);fillAdvice("life",c.life);fillAdvice("boost",c.boost);fillAdvice("next",c.next);
  show($(".cct-advice"));
  var seed=(state.names.n1+state.names.n2).split("").reduce(function(a,c){return a+c.charCodeAt(0);},0);
  var emojiList=["💛","💜","💚","💙","💖","🤝","🌟","✨","🔥","🌈"];
  var bestEmoji=pickFrom(emojiList,seed*5);
  var song=pickFrom(SONGS,seed);
  var pet=pickFrom(PETS,seed*3);
  var career=pickFrom(CAREERS_FRIEND,seed*7);
  $(".cct-ex-grid").innerHTML=
    '<div class="cct-ex"><span class="cct-ex-icon">'+bestEmoji+'</span><div><b>'+(lang==="hi"?"आपका दोस्ती इमोजी":"Your Friendship Emoji")+'</b><p>'+bestEmoji+' '+(lang==="hi"?"यही आप दोनों की वाइब है":"This is your shared vibe")+'</p></div></div>'+
    '<div class="cct-ex"><span class="cct-ex-icon">🎵</span><div><b>'+(lang==="hi"?"आपके लिए दोस्ती गीत":"Friendship Song")+'</b><p>'+esc(song)+'</p></div></div>'+
    '<div class="cct-ex"><span class="cct-ex-icon">🐾</span><div><b>'+(lang==="hi"?"आदर्श साझा पालतू":"Ideal Shared Pet")+'</b><p>'+esc(pet)+'</p></div></div>'+
    '<div class="cct-ex"><span class="cct-ex-icon">💼</span><div><b>'+(lang==="hi"?"साथ करियर":"Career Together")+'</b><p>'+esc(career)+'</p></div></div>'+
    '<div class="cct-ex"><span class="cct-ex-icon">🎁</span><div><b>'+(lang==="hi"?"लकी दिन मिलने का":"Best Day to Meet")+'</b><p>'+luckyDay(seed)+'</p></div></div>'+
    '<div class="cct-ex"><span class="cct-ex-icon">💡</span><div><b>'+(lang==="hi"?"डेट आइडिया":"Date Idea")+'</b><p>'+esc(pickFrom(DATES,seed*11))+'</p></div></div>';
  show($(".cct-extras"));
  finalizeResult(state);
}

function showResultCrush(state){
  var t=getTierCrush(state.total);
  renderScoreHead(state.total,t.emoji,t,state.names.n1,state.names.n2);
  var c=t.content[lang]||t.content.en;
  fillAdvice("golden",c.golden);fillAdvice("protip",c.protip);fillAdvice("life",c.life);fillAdvice("boost",c.boost);fillAdvice("next",c.next);
  show($(".cct-advice"));
  var seed=(state.names.n1+state.names.n2).split("").reduce(function(a,c){return a+c.charCodeAt(0);},0);
  var emojiList=["💘","💖","💕","💗","💓","💞","🌹","🔥","✨","💫"];
  var bestEmoji=pickFrom(emojiList,seed*5);
  $(".cct-ex-grid").innerHTML=
    '<div class="cct-ex"><span class="cct-ex-icon">'+bestEmoji+'</span><div><b>'+(lang==="hi"?"आपका क्रश इमोजी":"Your Crush Emoji")+'</b><p>'+bestEmoji+' '+(lang==="hi"?"आप दोनों की वाइब":"Your shared vibe")+'</p></div></div>'+
    '<div class="cct-ex"><span class="cct-ex-icon">🔮</span><div><b>'+(lang==="hi"?"भविष्य की भविष्यवाणी":"Future Prediction")+'</b><p>'+esc(t.future[lang]||t.future.en)+'</p></div></div>'+
    '<div class="cct-ex"><span class="cct-ex-icon">💞</span><div><b>'+(lang==="hi"?"सोलमेट संकेत":"Soulmate Signal")+'</b><p>'+esc(t.soulmate[lang]||t.soulmate.en)+'</p></div></div>'+
    '<div class="cct-ex"><span class="cct-ex-icon">♍</span><div><b>'+(lang==="hi"?"हॉरोस्कोप नोट":"Horoscope Note")+'</b><p>'+esc(t.horoscope[lang]||t.horoscope.en)+'</p></div></div>'+
    '<div class="cct-ex"><span class="cct-ex-icon">🎵</span><div><b>'+(lang==="hi"?"क्रश गीत":"Crush Song")+'</b><p>'+esc(pickFrom(SONGS,seed*3))+'</p></div></div>'+
    '<div class="cct-ex"><span class="cct-ex-icon">📅</span><div><b>'+(lang==="hi"?"इज़हार का लकी दिन":"Lucky Day to Confess")+'</b><p>'+luckyDay(seed*7)+'</p></div></div>';
  show($(".cct-extras"));
  finalizeResult(state);
}

function showResultMulank(state){
  var m=MULANK[state.mulank]||MULANK[1];
  var b=MULANK[state.bhagyank]||MULANK[1];
  var head=$(".cct-result-head");
  head.innerHTML=
    '<div class="cct-num-grid">'+
      '<div class="cct-num-cell"><div class="cct-num-lbl">'+(lang==="hi"?"मूलांक":"Mulank")+'</div><div class="cct-num-big">'+state.mulank+'</div><div class="cct-num-sub">'+(lang==="hi"?"शासक ग्रह":"Ruling Planet")+'</div><div class="cct-num-planet">'+esc(m.planet[lang])+'</div></div>'+
      '<div class="cct-num-cell"><div class="cct-num-lbl">'+(lang==="hi"?"भाग्यांक":"Bhagyank")+'</div><div class="cct-num-big">'+state.bhagyank+'</div><div class="cct-num-sub">'+(lang==="hi"?"भाग्य ग्रह":"Destiny Planet")+'</div><div class="cct-num-planet">'+esc(b.planet[lang])+'</div></div>'+
    '</div>'+
    '<blockquote class="cct-quote">'+esc(m.personality[lang])+'</blockquote>';
  fillAdvice("golden",{h:lang==="hi"?"गोल्डन हिंट":"Golden Hint",t:m.golden[lang]});
  fillAdvice("protip",{h:lang==="hi"?"प्रो टिप":"Pro Tip",t:m.pro[lang]});
  fillAdvice("life",{h:lang==="hi"?"ज़िंदगी का सबक":"Life Lesson",t:m.life[lang]});
  fillAdvice("boost",{h:lang==="hi"?"मूलांक बूस्ट":"Mulank Boost",t:m.boost[lang]});
  fillAdvice("next",{h:lang==="hi"?"आगे क्या":"What Next",t:m.next[lang]});
  show($(".cct-advice"));
  $(".cct-ex-grid").innerHTML=
    '<div class="cct-ex"><span class="cct-ex-icon">🎨</span><div><b>'+(lang==="hi"?"लकी रंग":"Lucky Colors")+'</b><p>'+esc(m.color[lang])+'</p></div></div>'+
    '<div class="cct-ex"><span class="cct-ex-icon">📅</span><div><b>'+(lang==="hi"?"लकी दिन":"Lucky Day")+'</b><p>'+esc(m.day[lang])+'</p></div></div>'+
    '<div class="cct-ex"><span class="cct-ex-icon">🔢</span><div><b>'+(lang==="hi"?"लकी अंक":"Lucky Numbers")+'</b><p>'+esc(m.lucky[lang])+'</p></div></div>'+
    '<div class="cct-ex"><span class="cct-ex-icon">💼</span><div><b>'+(lang==="hi"?"बेहतरीन करियर":"Best Career")+'</b><p>'+esc(m.career[lang])+'</p></div></div>'+
    '<div class="cct-ex"><span class="cct-ex-icon">💞</span><div><b>'+(lang==="hi"?"साझेदार अंक":"Compatible Numbers")+'</b><p>'+esc(m.compat[lang])+'</p></div></div>'+
    '<div class="cct-ex"><span class="cct-ex-icon">🪐</span><div><b>'+(lang==="hi"?"प्लानेट":"Your Planet")+'</b><p>'+esc(m.planet[lang])+'</p></div></div>';
  show($(".cct-extras"));
  finalizeResult(state);
}

function fillAdvice(pane,obj){var c=$(".cct-adv-card[data-pane=\""+pane+"\"]");if(c){c.querySelector("h4").textContent=obj.h;c.querySelector("p").textContent=obj.t;}}

function finalizeResult(state){
  confetti();buzz([20,40,20]);beep(880,0.18,"sine");
  var prem=$(".cct-premium");
  if(ROOT.dataset.premium==="1"&&ROOT.dataset.premiumUrl){prem.querySelector(".cct-prem-cta").href=ROOT.dataset.premiumUrl;prem.querySelector(".cct-prem-cta").textContent=ROOT.dataset.premiumLabel||"Premium";show(prem);}
  var midAd=ROOT.querySelector(".cct-ad-mid");if(midAd)show(midAd);
  ROOT._cctState=state;
  if(ROOT.dataset.history==="1")saveHist(state);
}

/* ===== HISTORY ===== */
var HKEY="cct_history_"+tool;
function loadHist(){try{return JSON.parse(localStorage.getItem(HKEY)||"[]");}catch(e){return [];}}
function saveHistArr(a){try{localStorage.setItem(HKEY,JSON.stringify(a.slice(0,8)));}catch(e){}}
function saveHist(state){var a=loadHist();var entry;if(tool==="mulank"){entry={n:state.name||"",m:state.mulank,b:state.bhagyank,t:Date.now()};}else{entry={a:state.names.n1,b:state.names.n2,s:state.total,t:Date.now()};}a.unshift(entry);saveHistArr(a);renderHist();}
function renderHist(){if(ROOT.dataset.history!=="1")return;var a=loadHist();var box=$(".cct-history"),list=$(".cct-hist-list");if(!box||!list)return;if(!a.length){hide(box);return;}show(box);list.innerHTML="";a.forEach(function(it){var li=document.createElement("li");if(tool==="mulank"){li.innerHTML="<span>"+esc(capWords(it.n||"—"))+"</span> <b>"+(lang==="hi"?"मू":"M")+" "+it.m+" / "+(lang==="hi"?"भा":"B")+" "+it.b+"</b>";}else{li.innerHTML="<span>"+esc(capWords(it.a))+" "+(tool==="crush"?"💘":"🤝")+" "+esc(capWords(it.b))+"</span> <b>"+it.s+"%</b>";}list.appendChild(li);});}

/* ===== SHARE / DOWNLOAD ===== */
function shareResult(){var st=ROOT._cctState;if(!st)return;var txt;if(tool==="mulank"){txt=(lang==="hi"?"मेरा मूलांक: ":"My Mulank: ")+st.mulank+" / "+(lang==="hi"?"भाग्यांक: ":"Bhagyank: ")+st.bhagyank;}else{var t=tool==="friendship"?getTierFriend(st.total):getTierCrush(st.total);txt=capWords(st.names.n1)+(tool==="crush"?" 💘 ":" 🤝 ")+capWords(st.names.n2)+" = "+st.total+"% — "+t.name[lang];}if(navigator.share){navigator.share({title:document.title,text:txt,url:location.href}).catch(function(){});}else{if(navigator.clipboard)navigator.clipboard.writeText(txt+" — "+location.href);toast(I18N[lang].copy_done);}}
function downloadCard(){var st=ROOT._cctState;if(!st)return;var canvas=$(".cct-share-canvas");var ctx=canvas.getContext("2d");var W=canvas.width,H=canvas.height;var g=ctx.createLinearGradient(0,0,W,H);g.addColorStop(0,"#FAFAF7");g.addColorStop(0.5,"#F5F3FF");g.addColorStop(1,"#F0FDF4");ctx.fillStyle=g;ctx.fillRect(0,0,W,H);var rg=ctx.createRadialGradient(W*0.7,H*0.25,0,W*0.7,H*0.25,W*0.6);rg.addColorStop(0,"rgba(124,58,237,0.25)");rg.addColorStop(1,"transparent");ctx.fillStyle=rg;ctx.fillRect(0,0,W,H);ctx.fillStyle="#5B21B6";ctx.font="bold 60px Georgia,serif";ctx.textAlign="center";var title=tool==="friendship"?(lang==="hi"?"फ्रेंडशिप कैलकुलेटर":"Friendship Calculator"):tool==="crush"?(lang==="hi"?"क्रश कैलकुलेटर":"Crush Calculator"):(lang==="hi"?"मूलांक कैलकुलेटर":"Mulank Calculator");ctx.fillText(title,W/2,140);ctx.fillStyle="#1E1B4B";if(tool==="mulank"){ctx.font="bold 240px Georgia,serif";var lg=ctx.createLinearGradient(0,300,0,600);lg.addColorStop(0,"#7C3AED");lg.addColorStop(1,"#EC4899");ctx.fillStyle=lg;ctx.fillText(String(st.mulank),W*0.32,580);ctx.fillText(String(st.bhagyank),W*0.68,580);ctx.fillStyle="#5B21B6";ctx.font="bold 40px Georgia,serif";ctx.fillText(lang==="hi"?"मूलांक":"Mulank",W*0.32,640);ctx.fillText(lang==="hi"?"भाग्यांक":"Bhagyank",W*0.68,640);var m=MULANK[st.mulank];if(m){ctx.font="italic 32px Georgia,serif";ctx.fillStyle="#1E1B4B";ctx.fillText(m.personality[lang].slice(0,70),W/2,800);}}else{ctx.font="36px Georgia,serif";ctx.fillStyle="#1E1B4B";ctx.fillText(capWords(st.names.n1)+"   "+(tool==="crush"?"💘":"🤝")+"   "+capWords(st.names.n2),W/2,240);ctx.font="bold 180px Georgia,serif";var lg2=ctx.createLinearGradient(0,300,0,600);lg2.addColorStop(0,"#7C3AED");lg2.addColorStop(1,"#EC4899");ctx.fillStyle=lg2;ctx.fillText(st.total+"%",W/2,560);var t=tool==="friendship"?getTierFriend(st.total):getTierCrush(st.total);ctx.fillStyle="#5B21B6";ctx.font="bold 50px Georgia,serif";ctx.fillText(t.emoji+" "+t.name[lang],W/2,720);ctx.font="italic 26px Georgia,serif";ctx.fillStyle="#1E1B4B";var qSrc=t.quote||t.future||null;var qt=qSrc?(qSrc[lang]||qSrc.en||""):"";if(qt)ctx.fillText('"'+qt.slice(0,68)+'"',W/2,800);}ctx.font="20px sans-serif";ctx.fillStyle="rgba(30,27,75,0.5)";ctx.fillText(location.host,W/2,1020);var link=document.createElement("a");link.download=tool+"-result.png";link.href=canvas.toDataURL("image/png");link.click();}
function toast(m){var t=document.createElement("div");t.textContent=m;t.style.cssText="position:fixed;left:50%;bottom:24px;transform:translateX(-50%);background:#1E1B4B;color:#fff;padding:10px 18px;border-radius:12px;font-family:system-ui,sans-serif;font-size:14px;z-index:99999;box-shadow:0 12px 30px rgba(0,0,0,0.4)";document.body.appendChild(t);setTimeout(function(){t.style.transition="opacity .35s";t.style.opacity="0";setTimeout(function(){t.remove();},400);},1800);}

/* ===== CALCULATE ===== */
function doCalc(e){
  if(e){e.preventDefault();e.stopPropagation();}
  setError("");
  var inp=$(".cct-input-card"),load=$(".cct-loading-card"),res=$(".cct-result-card");
  if(tool==="mulank"){
    var dob=$(".cct-dob1").value;
    if(!dob){setError(I18N[lang].err_dob_required);return false;}
    var nameRaw=$(".cct-name1")?$(".cct-name1").value.trim():"";
    var mu=dobMulank(dob);
    var bh=dobBhagyank(dob);
    hide(inp);show(load);hide(res);hide($(".cct-advice"));hide($(".cct-extras"));hide($(".cct-premium"));
    var midAd=ROOT.querySelector(".cct-ad-mid");if(midAd)hide(midAd);
    progressSteps(function(){
      hide(load);show(res);
      showResultMulank({mulank:mu,bhagyank:bh,name:nameRaw,dob:dob});
    });
    return false;
  }
  var n1raw=$(".cct-name1").value.trim();
  var n2raw=$(".cct-name2").value.trim();
  var n1=cleanName(n1raw),n2=cleanName(n2raw);
  if(!n1||!n2){setError(I18N[lang].err_required);return false;}
  if(n1.length<2||n2.length<2){setError(I18N[lang].err_short);return false;}
  if(n1===n2){setError(I18N[lang].err_same);return false;}
  var combined=(n1+n2).replace(/[^a-z]/g,"");
  var letters=tool==="crush"?"crush":"friends";
  var base=letterScore(letters,combined);
  var ovr=nameOverlap(n1,n2);
  var floor=tool==="crush"?30:35;
  var bias=tool==="crush"?15:25;
  var total=Math.round(base*0.55+ovr*0.45)+bias;
  total=clamp(total,floor,99);
  hide(inp);show(load);hide(res);hide($(".cct-advice"));hide($(".cct-extras"));hide($(".cct-premium"));
  var midAd2=ROOT.querySelector(".cct-ad-mid");if(midAd2)hide(midAd2);
  progressSteps(function(){
    hide(load);show(res);
    if(tool==="crush")showResultCrush({names:{n1:n1raw,n2:n2raw},total:total});
    else showResultFriend({names:{n1:n1raw,n2:n2raw},total:total});
  });
  return false;
}

function progressSteps(cb){
  var bar=$(".cct-progress-bar"),txt=$(".cct-load-txt");bar.style.width="0%";
  var steps=[I18N[lang].step1,I18N[lang].step2,I18N[lang].step3,I18N[lang].step4];
  var i=0;txt.textContent=steps[0];
  var tk=setInterval(function(){i++;if(i>=steps.length){clearInterval(tk);return;}txt.textContent=steps[i];bar.style.width=((i+1)*25)+"%";},380);
  setTimeout(function(){clearInterval(tk);bar.style.width="100%";cb();},1700);
}

/* ===== BIND ===== */
var form=$(".cct-form");if(form){form.addEventListener("submit",doCalc);}
var go=$(".cct-go");if(go){go.addEventListener("click",doCalc);}
var again=$(".cct-act-again");if(again){again.addEventListener("click",function(){hide($(".cct-result-card"));hide($(".cct-advice"));hide($(".cct-extras"));hide($(".cct-premium"));var m=ROOT.querySelector(".cct-ad-mid");if(m)hide(m);show($(".cct-input-card"));setError("");ROOT.scrollIntoView({behavior:"smooth",block:"start"});});}
var sh=$(".cct-act-share");if(sh){sh.addEventListener("click",shareResult);}
var dc=$(".cct-act-card");if(dc){dc.addEventListener("click",downloadCard);}
var sv=$(".cct-act-save");if(sv){sv.addEventListener("click",function(){var st=ROOT._cctState;if(!st)return;saveHist(st);toast(I18N[lang].save_done);});}
$$(".cct-adv-tab").forEach(function(b){b.addEventListener("click",function(){$$(".cct-adv-tab").forEach(function(x){x.classList.remove("is-on");});$$(".cct-adv-card").forEach(function(x){x.classList.remove("is-on");});b.classList.add("is-on");var p=b.getAttribute("data-tab");var c=$(".cct-adv-card[data-pane=\""+p+"\"]");if(c)c.classList.add("is-on");});});
var advT=$(".cct-adv-toggle");if(advT){advT.addEventListener("change",function(){mode=advT.checked?"advanced":"basic";ROOT.dataset.mode=mode;});}
$$(".cct-lang-btn").forEach(function(b){b.addEventListener("click",function(){$$(".cct-lang-btn").forEach(function(x){x.classList.remove("is-on");});b.classList.add("is-on");lang=b.getAttribute("data-lang")==="hi"?"hi":"en";ROOT.dataset.lang=lang;applyI18n();renderHist();var st=ROOT._cctState;if(st){if(tool==="mulank")showResultMulank(st);else if(tool==="crush")showResultCrush(st);else showResultFriend(st);}});});
var snd=$(".cct-sound-btn");if(snd){snd.addEventListener("click",function(){soundOn=!soundOn;ROOT.dataset.sound=soundOn?"1":"0";});}
var hc=$(".cct-hist-clear");if(hc){hc.addEventListener("click",function(){saveHistArr([]);renderHist();});}
applyI18n();renderHist();
}
function bootAll(){var nodes=document.querySelectorAll(".cct-wrap");for(var i=0;i<nodes.length;i++)init(nodes[i]);}
if(document.readyState==="loading"){document.addEventListener("DOMContentLoaded",bootAll);}else{bootAll();}
window.addEventListener("load",bootAll);
})();
JS;
	}
}
