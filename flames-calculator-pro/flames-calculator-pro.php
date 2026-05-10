<?php
/**
 * Plugin Name: FLAMES Calculator Pro
 * Plugin URI:  https://example.com/flames-calculator-pro
 * Description: Premium FLAMES Calculator with unique 2026 animated UI, advanced zodiac & numerology mode, golden hints, pro tips and life advice for every result. Bilingual EN/HI. AdSense & Premium ready. Use shortcode [flames_calculator_pro].
 * Version:     1.0.0
 * Author:      FLAMES Calculator Pro
 * License:     GPL-2.0+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: flames-calculator-pro
 * Requires at least: 5.0
 * Requires PHP: 7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'FCP_VERSION' ) ) {
	define( 'FCP_VERSION', '1.0.0' );
}
if ( ! defined( 'FCP_OPTION' ) ) {
	define( 'FCP_OPTION', 'fcp_settings' );
}

/* ---------------------------------------------------------------------------
 * Activation / Defaults
 * ------------------------------------------------------------------------- */

if ( ! function_exists( 'fcp_default_settings' ) ) {
	function fcp_default_settings() {
		return array(
			'default_mode'    => 'basic',
			'default_lang'    => 'en',
			'theme_intensity' => 'vibrant',
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
		);
	}
}

if ( ! function_exists( 'fcp_get_settings' ) ) {
	function fcp_get_settings() {
		$saved = get_option( FCP_OPTION, array() );
		if ( ! is_array( $saved ) ) {
			$saved = array();
		}
		return wp_parse_args( $saved, fcp_default_settings() );
	}
}

if ( ! function_exists( 'fcp_activate' ) ) {
	function fcp_activate() {
		if ( false === get_option( FCP_OPTION ) ) {
			add_option( FCP_OPTION, fcp_default_settings() );
		}
	}
	register_activation_hook( __FILE__, 'fcp_activate' );
}

/* ---------------------------------------------------------------------------
 * Admin Settings Page
 * ------------------------------------------------------------------------- */

if ( ! function_exists( 'fcp_admin_menu' ) ) {
	function fcp_admin_menu() {
		add_options_page(
			'FLAMES Calculator Pro',
			'FLAMES Calculator',
			'manage_options',
			'fcp-settings',
			'fcp_render_settings_page'
		);
	}
	add_action( 'admin_menu', 'fcp_admin_menu' );
}

if ( ! function_exists( 'fcp_render_settings_page' ) ) {
	function fcp_render_settings_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		if ( isset( $_POST['fcp_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['fcp_nonce'] ) ), 'fcp_save' ) ) {
			$allowed_modes = array( 'basic', 'advanced' );
			$allowed_langs = array( 'en', 'hi' );
			$allowed_int   = array( 'subtle', 'vibrant' );

			$new = array(
				'default_mode'    => in_array( ( $_POST['default_mode'] ?? '' ), $allowed_modes, true ) ? $_POST['default_mode'] : 'basic',
				'default_lang'    => in_array( ( $_POST['default_lang'] ?? '' ), $allowed_langs, true ) ? $_POST['default_lang'] : 'en',
				'theme_intensity' => in_array( ( $_POST['theme_intensity'] ?? '' ), $allowed_int, true ) ? $_POST['theme_intensity'] : 'vibrant',
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
			);
			update_option( FCP_OPTION, $new );
			echo '<div class="notice notice-success is-dismissible"><p><strong>Settings saved.</strong></p></div>';
		}

		$s = fcp_get_settings();
		?>
		<div class="wrap">
			<h1>FLAMES Calculator Pro</h1>
			<p>Display the calculator using the shortcode: <code>[flames_calculator_pro]</code> or <code>[flames_calculator]</code>.</p>
			<p>Optional shortcode attributes: <code>mode="basic|advanced"</code> and <code>lang="en|hi"</code>.</p>

			<form method="post" action="">
				<?php wp_nonce_field( 'fcp_save', 'fcp_nonce' ); ?>
				<table class="form-table" role="presentation">
					<tr>
						<th scope="row"><label for="default_mode">Default Mode</label></th>
						<td>
							<select name="default_mode" id="default_mode">
								<option value="basic"    <?php selected( $s['default_mode'], 'basic' ); ?>>Basic (FLAMES only)</option>
								<option value="advanced" <?php selected( $s['default_mode'], 'advanced' ); ?>>Advanced (Zodiac + Numerology + Score)</option>
							</select>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="default_lang">Default Language</label></th>
						<td>
							<select name="default_lang" id="default_lang">
								<option value="en" <?php selected( $s['default_lang'], 'en' ); ?>>English</option>
								<option value="hi" <?php selected( $s['default_lang'], 'hi' ); ?>>Hindi</option>
							</select>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="theme_intensity">Theme Intensity</label></th>
						<td>
							<select name="theme_intensity" id="theme_intensity">
								<option value="vibrant" <?php selected( $s['theme_intensity'], 'vibrant' ); ?>>Vibrant (recommended)</option>
								<option value="subtle"  <?php selected( $s['theme_intensity'], 'subtle' ); ?>>Subtle</option>
							</select>
						</td>
					</tr>
					<tr>
						<th scope="row">Toggles</th>
						<td>
							<label><input type="checkbox" name="show_advanced_toggle" value="1" <?php checked( $s['show_advanced_toggle'], 1 ); ?>> Show Advanced Mode toggle</label><br>
							<label><input type="checkbox" name="show_lang_toggle" value="1" <?php checked( $s['show_lang_toggle'], 1 ); ?>> Show Language toggle (EN / HI)</label><br>
							<label><input type="checkbox" name="show_history" value="1" <?php checked( $s['show_history'], 1 ); ?>> Save user history (localStorage)</label><br>
							<label><input type="checkbox" name="show_share" value="1" <?php checked( $s['show_share'], 1 ); ?>> Show Share buttons</label><br>
							<label><input type="checkbox" name="sound_default" value="1" <?php checked( $s['sound_default'], 1 ); ?>> Sound ON by default</label><br>
							<label><input type="checkbox" name="haptics_default" value="1" <?php checked( $s['haptics_default'], 1 ); ?>> Haptics ON by default (mobile)</label>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="show_premium">Premium Upsell</label></th>
						<td>
							<label><input type="checkbox" name="show_premium" id="show_premium" value="1" <?php checked( $s['show_premium'], 1 ); ?>> Show Premium upsell card on result</label>
							<p><label for="premium_url">Premium URL:</label><br>
								<input type="url" name="premium_url" id="premium_url" value="<?php echo esc_attr( $s['premium_url'] ); ?>" class="regular-text" placeholder="https://yoursite.com/premium"></p>
							<p><label for="premium_label">Premium Button Label:</label><br>
								<input type="text" name="premium_label" id="premium_label" value="<?php echo esc_attr( $s['premium_label'] ); ?>" class="regular-text" placeholder="Get Premium"></p>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="ad_slot_top">AdSense Slot — Top</label></th>
						<td><textarea name="ad_slot_top" id="ad_slot_top" rows="4" class="large-text code" placeholder="Paste full <ins> AdSense ad code here"><?php echo esc_textarea( $s['ad_slot_top'] ); ?></textarea>
						<p class="description">Shown above the calculator.</p></td>
					</tr>
					<tr>
						<th scope="row"><label for="ad_slot_middle">AdSense Slot — After Result</label></th>
						<td><textarea name="ad_slot_middle" id="ad_slot_middle" rows="4" class="large-text code" placeholder="Paste full AdSense ad code"><?php echo esc_textarea( $s['ad_slot_middle'] ); ?></textarea>
						<p class="description">Shown right after the result card.</p></td>
					</tr>
					<tr>
						<th scope="row"><label for="ad_slot_bottom">AdSense Slot — Bottom</label></th>
						<td><textarea name="ad_slot_bottom" id="ad_slot_bottom" rows="4" class="large-text code" placeholder="Paste full AdSense ad code"><?php echo esc_textarea( $s['ad_slot_bottom'] ); ?></textarea>
						<p class="description">Shown below all advice cards.</p></td>
					</tr>
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

if ( ! function_exists( 'fcp_shortcode' ) ) {
	function fcp_shortcode( $atts = array(), $content = '' ) {
		$atts = shortcode_atts(
			array(
				'mode' => '',
				'lang' => '',
			),
			$atts,
			'flames_calculator_pro'
		);
		$s = fcp_get_settings();

		$mode = in_array( $atts['mode'], array( 'basic', 'advanced' ), true ) ? $atts['mode'] : $s['default_mode'];
		$lang = in_array( $atts['lang'], array( 'en', 'hi' ), true ) ? $atts['lang'] : $s['default_lang'];

		ob_start();
		fcp_render_calculator( $mode, $lang, $s );
		return ob_get_clean();
	}
	add_shortcode( 'flames_calculator_pro', 'fcp_shortcode' );
	add_shortcode( 'flames_calculator', 'fcp_shortcode' );
}

/* ---------------------------------------------------------------------------
 * Front-end Renderer
 * ------------------------------------------------------------------------- */

if ( ! function_exists( 'fcp_render_calculator' ) ) {
	function fcp_render_calculator( $mode, $lang, $s ) {
		$uid = 'fcp-' . wp_generate_password( 8, false, false );
		$ad_top    = $s['ad_slot_top'];
		$ad_mid    = $s['ad_slot_middle'];
		$ad_bot    = $s['ad_slot_bottom'];
		$intensity = $s['theme_intensity'];
		?>
<div class="fcp-wrap fcp-int-<?php echo esc_attr( $intensity ); ?>" id="<?php echo esc_attr( $uid ); ?>" data-mode="<?php echo esc_attr( $mode ); ?>" data-lang="<?php echo esc_attr( $lang ); ?>" data-sound="<?php echo (int) $s['sound_default']; ?>" data-haptics="<?php echo (int) $s['haptics_default']; ?>" data-history="<?php echo (int) $s['show_history']; ?>" data-share="<?php echo (int) $s['show_share']; ?>" data-premium="<?php echo (int) $s['show_premium']; ?>" data-premium-url="<?php echo esc_attr( $s['premium_url'] ); ?>" data-premium-label="<?php echo esc_attr( $s['premium_label'] ); ?>" data-show-adv-toggle="<?php echo (int) $s['show_advanced_toggle']; ?>" data-show-lang-toggle="<?php echo (int) $s['show_lang_toggle']; ?>">

	<?php fcp_inline_styles(); ?>

	<?php if ( ! empty( $ad_top ) ) : ?>
		<div class="fcp-ad fcp-ad-top"><?php echo $ad_top; // already kses_post sanitized on save ?></div>
	<?php endif; ?>

	<!-- Animated background ember layer -->
	<div class="fcp-bg" aria-hidden="true">
		<span class="fcp-ember"></span><span class="fcp-ember"></span><span class="fcp-ember"></span>
		<span class="fcp-ember"></span><span class="fcp-ember"></span><span class="fcp-ember"></span>
		<span class="fcp-ember"></span><span class="fcp-ember"></span>
	</div>

	<div class="fcp-shell">

		<header class="fcp-head">
			<div class="fcp-flame" aria-hidden="true">
				<svg viewBox="0 0 64 64" width="56" height="56">
					<defs>
						<linearGradient id="<?php echo esc_attr( $uid ); ?>-fg" x1="0" y1="1" x2="0" y2="0">
							<stop offset="0%" stop-color="#FF1B6B"/>
							<stop offset="55%" stop-color="#FF6B35"/>
							<stop offset="100%" stop-color="#FFD23F"/>
						</linearGradient>
					</defs>
					<path d="M32 4c4 10-6 14-6 22 0 6 4 10 4 16 0 4-2 6-2 6s10-2 14-10c5-9-2-15-1-22 0-4-2-8-9-12z m-9 28c-4 4-7 9-7 14 0 8 7 14 16 14s16-6 16-14c0-3-1-6-3-9-1 6-5 11-9 11s-7-4-7-9c0-3 1-5-6-7z" fill="url(#<?php echo esc_attr( $uid ); ?>-fg)"/>
				</svg>
			</div>
			<h2 class="fcp-title" data-i18n="title">FLAMES Calculator</h2>
			<p class="fcp-sub" data-i18n="sub">Discover what your relationship truly is</p>

			<div class="fcp-toggles" role="group" aria-label="Tool options">
				<?php if ( $s['show_advanced_toggle'] ) : ?>
				<label class="fcp-tgl">
					<input type="checkbox" class="fcp-adv-toggle" <?php checked( $mode, 'advanced' ); ?>>
					<span class="fcp-tgl-track"><span class="fcp-tgl-knob"></span></span>
					<span class="fcp-tgl-text" data-i18n="advanced">Advanced</span>
				</label>
				<?php endif; ?>

				<?php if ( $s['show_lang_toggle'] ) : ?>
				<div class="fcp-lang">
					<button type="button" class="fcp-lang-btn <?php echo 'en' === $lang ? 'is-on' : ''; ?>" data-lang="en" aria-label="English">EN</button>
					<button type="button" class="fcp-lang-btn <?php echo 'hi' === $lang ? 'is-on' : ''; ?>" data-lang="hi" aria-label="Hindi">हि</button>
				</div>
				<?php endif; ?>

				<button type="button" class="fcp-mini fcp-sound-btn" aria-label="Toggle sound" title="Sound">
					<span class="fcp-snd-on">🔊</span><span class="fcp-snd-off">🔇</span>
				</button>
			</div>
		</header>

		<!-- INPUT PHASE -->
		<section class="fcp-card fcp-input-card" aria-live="polite">
			<form class="fcp-form" novalidate>
				<div class="fcp-row">
					<div class="fcp-field">
						<label class="fcp-lbl" for="<?php echo esc_attr( $uid ); ?>-n1" data-i18n="your_name">Your Name</label>
						<div class="fcp-input-wrap">
							<input type="text" class="fcp-input fcp-name1" id="<?php echo esc_attr( $uid ); ?>-n1" autocomplete="off" maxlength="40" placeholder="e.g. Aarav">
							<span class="fcp-glow"></span>
						</div>
					</div>

					<div class="fcp-heart" aria-hidden="true">
						<span class="fcp-heart-emoji">🔥</span>
						<span class="fcp-heart-ring"></span>
					</div>

					<div class="fcp-field">
						<label class="fcp-lbl" for="<?php echo esc_attr( $uid ); ?>-n2" data-i18n="partner_name">Partner's Name</label>
						<div class="fcp-input-wrap">
							<input type="text" class="fcp-input fcp-name2" id="<?php echo esc_attr( $uid ); ?>-n2" autocomplete="off" maxlength="40" placeholder="e.g. Priya">
							<span class="fcp-glow"></span>
						</div>
					</div>
				</div>

				<!-- Advanced fields -->
				<div class="fcp-adv">
					<div class="fcp-row fcp-adv-row">
						<div class="fcp-field">
							<label class="fcp-lbl" data-i18n="your_dob">Your Date of Birth</label>
							<input type="date" class="fcp-input fcp-dob1" max="">
						</div>
						<div class="fcp-spacer"></div>
						<div class="fcp-field">
							<label class="fcp-lbl" data-i18n="partner_dob">Partner's Date of Birth</label>
							<input type="date" class="fcp-input fcp-dob2" max="">
						</div>
					</div>
				</div>

				<div class="fcp-err" role="alert"></div>

				<button type="submit" class="fcp-btn fcp-go">
					<span class="fcp-btn-bg"></span>
					<span class="fcp-btn-txt" data-i18n="calculate">Calculate FLAMES</span>
					<span class="fcp-btn-spark">✨</span>
				</button>

				<div class="fcp-trust">
					<span data-i18n="trust1">⚡ Instant</span>
					<span data-i18n="trust2">🔒 100% Private</span>
					<span data-i18n="trust3">🎯 Free Forever</span>
				</div>
			</form>
		</section>

		<!-- LOADING PHASE -->
		<section class="fcp-card fcp-loading-card" hidden>
			<div class="fcp-loader" aria-hidden="true">
				<div class="fcp-orbit">
					<span>🔥</span><span>💫</span><span>💖</span><span>✨</span><span>🌟</span><span>🔮</span>
				</div>
				<div class="fcp-orbit-core">F</div>
			</div>
			<p class="fcp-load-txt" data-i18n="reading">Reading the cosmic vibes…</p>
			<div class="fcp-progress"><span class="fcp-progress-bar"></span></div>
		</section>

		<!-- RESULT PHASE -->
		<section class="fcp-card fcp-result-card" hidden>
			<div class="fcp-confetti" aria-hidden="true"></div>

			<div class="fcp-couple">
				<div class="fcp-cp-name fcp-cp-a"><span class="fcp-init"></span><strong></strong></div>
				<div class="fcp-cp-link">×</div>
				<div class="fcp-cp-name fcp-cp-b"><span class="fcp-init"></span><strong></strong></div>
			</div>

			<!-- Letter elimination viewer -->
			<div class="fcp-elim" aria-label="Letter elimination">
				<div class="fcp-elim-row fcp-elim-a"></div>
				<div class="fcp-elim-row fcp-elim-b"></div>
				<div class="fcp-elim-count"><span data-i18n="remaining">Remaining</span>: <strong>0</strong></div>
			</div>

			<!-- FLAMES wheel -->
			<div class="fcp-wheel" aria-hidden="true">
				<span class="fcp-w-letter" data-l="F">F</span>
				<span class="fcp-w-letter" data-l="L">L</span>
				<span class="fcp-w-letter" data-l="A">A</span>
				<span class="fcp-w-letter" data-l="M">M</span>
				<span class="fcp-w-letter" data-l="E">E</span>
				<span class="fcp-w-letter" data-l="S">S</span>
			</div>

			<!-- Final reveal -->
			<div class="fcp-reveal">
				<div class="fcp-letter-big">F</div>
				<h3 class="fcp-result-name">Friends</h3>
				<p class="fcp-result-tag" data-i18n="result_tag">Your relationship vibe</p>
			</div>

			<!-- Score (advanced) -->
			<div class="fcp-score" hidden>
				<div class="fcp-ring">
					<svg viewBox="0 0 120 120" width="160" height="160">
						<defs>
							<linearGradient id="<?php echo esc_attr( $uid ); ?>-rg" x1="0" y1="0" x2="1" y2="1">
								<stop offset="0%"   stop-color="#FF1B6B"/>
								<stop offset="50%"  stop-color="#FF6B35"/>
								<stop offset="100%" stop-color="#B814FF"/>
							</linearGradient>
						</defs>
						<circle cx="60" cy="60" r="52" fill="none" stroke="rgba(255,255,255,0.10)" stroke-width="10"/>
						<circle class="fcp-ring-fg" cx="60" cy="60" r="52" fill="none" stroke="url(#<?php echo esc_attr( $uid ); ?>-rg)" stroke-width="10" stroke-linecap="round" stroke-dasharray="326.7" stroke-dashoffset="326.7" transform="rotate(-90 60 60)"/>
					</svg>
					<div class="fcp-ring-num"><span class="fcp-ring-val">0</span><i>%</i></div>
				</div>
				<div class="fcp-score-bars">
					<div class="fcp-sb"><span data-i18n="numerology">Numerology</span><b><i></i></b></div>
					<div class="fcp-sb"><span data-i18n="zodiac">Zodiac</span><b><i></i></b></div>
					<div class="fcp-sb"><span data-i18n="name_match">Name Match</span><b><i></i></b></div>
					<div class="fcp-sb"><span data-i18n="flames_score">FLAMES Vibe</span><b><i></i></b></div>
				</div>
			</div>

			<!-- Action buttons -->
			<div class="fcp-actions">
				<button type="button" class="fcp-act fcp-act-again" data-i18n="try_again">Try Again</button>
				<button type="button" class="fcp-act fcp-act-share" data-i18n="share">Share</button>
				<button type="button" class="fcp-act fcp-act-save" data-i18n="save">Save</button>
				<button type="button" class="fcp-act fcp-act-card" data-i18n="download">Download Card</button>
			</div>
		</section>

		<?php if ( ! empty( $ad_mid ) ) : ?>
			<div class="fcp-ad fcp-ad-mid" hidden><?php echo $ad_mid; ?></div>
		<?php endif; ?>

		<!-- ADVICE CAROUSEL -->
		<section class="fcp-advice" hidden>
			<div class="fcp-adv-tabs" role="tablist">
				<button class="fcp-adv-tab is-on" data-tab="golden" data-i18n="tab_golden">✨ Golden Hint</button>
				<button class="fcp-adv-tab" data-tab="protip" data-i18n="tab_pro">💡 Pro Tip</button>
				<button class="fcp-adv-tab" data-tab="life" data-i18n="tab_life">🌿 Life Lesson</button>
				<button class="fcp-adv-tab" data-tab="boost" data-i18n="tab_boost">🚀 Score Boost</button>
				<button class="fcp-adv-tab" data-tab="next" data-i18n="tab_next">🎯 What Next</button>
			</div>
			<div class="fcp-adv-stage">
				<article class="fcp-adv-card is-on" data-pane="golden"><h4></h4><p></p></article>
				<article class="fcp-adv-card" data-pane="protip"><h4></h4><p></p></article>
				<article class="fcp-adv-card" data-pane="life"><h4></h4><p></p></article>
				<article class="fcp-adv-card" data-pane="boost"><h4></h4><p></p></article>
				<article class="fcp-adv-card" data-pane="next"><h4></h4><p></p></article>
			</div>
		</section>

		<!-- HISTORY -->
		<section class="fcp-history" hidden>
			<div class="fcp-hist-head">
				<h4 data-i18n="history">Your History</h4>
				<button type="button" class="fcp-hist-clear" data-i18n="clear">Clear</button>
			</div>
			<ul class="fcp-hist-list"></ul>
		</section>

		<!-- PREMIUM UPSELL -->
		<aside class="fcp-premium" hidden>
			<div class="fcp-prem-icon">👑</div>
			<div class="fcp-prem-body">
				<h4 data-i18n="prem_title">Unlock Deeper Insights</h4>
				<p data-i18n="prem_text">Get full birth-chart compatibility, daily love forecast and personalized rituals.</p>
				<a class="fcp-prem-cta" href="#" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $s['premium_label'] ); ?></a>
			</div>
		</aside>

		<?php if ( ! empty( $ad_bot ) ) : ?>
			<div class="fcp-ad fcp-ad-bot"><?php echo $ad_bot; ?></div>
		<?php endif; ?>

		<!-- Hidden canvas for share image -->
		<canvas class="fcp-share-canvas" width="1080" height="1080" hidden></canvas>

	</div><!-- /.fcp-shell -->

	<?php fcp_inline_script( $uid ); ?>
</div>
		<?php
	}
}

/* ---------------------------------------------------------------------------
 * Inline CSS
 * ------------------------------------------------------------------------- */

if ( ! function_exists( 'fcp_inline_styles' ) ) {
	function fcp_inline_styles() {
		static $printed = false;
		if ( $printed ) {
			return;
		}
		$printed = true;
		?>
<style id="fcp-styles">
.fcp-wrap, .fcp-wrap *, .fcp-wrap *::before, .fcp-wrap *::after { box-sizing: border-box; }
.fcp-wrap { position: relative; max-width: 920px; margin: 28px auto; padding: 18px; font-family: 'Inter', 'DM Sans', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; color: #f4ecff; line-height: 1.55; isolation: isolate; }
.fcp-wrap, .fcp-wrap input, .fcp-wrap button, .fcp-wrap select, .fcp-wrap textarea { -webkit-font-smoothing: antialiased; }
.fcp-wrap h2, .fcp-wrap h3, .fcp-wrap h4 { font-family: 'Space Grotesk','Poppins', system-ui, sans-serif; font-weight: 800; letter-spacing: -0.01em; margin: 0; }

/* Background — animated mesh + embers */
.fcp-bg { position: absolute; inset: 0; border-radius: 32px; overflow: hidden; z-index: -1; background:
	radial-gradient(circle at 18% 20%, rgba(184,20,255,0.55), transparent 55%),
	radial-gradient(circle at 82% 30%, rgba(255,27,107,0.55), transparent 55%),
	radial-gradient(circle at 45% 90%, rgba(255,107,53,0.50), transparent 60%),
	linear-gradient(135deg, #0a0420 0%, #14062e 45%, #1c0a3e 100%);
	animation: fcp-mesh 18s ease-in-out infinite alternate; }
@keyframes fcp-mesh { 0% { background-position: 0 0; filter: hue-rotate(0deg);} 100% { background-position: 80% 20%; filter: hue-rotate(20deg);} }
.fcp-int-subtle .fcp-bg { opacity: 0.55; }

.fcp-ember { position: absolute; bottom: -20px; width: 8px; height: 8px; border-radius: 50%; background: radial-gradient(circle, #FFD23F, #FF6B35 60%, transparent 70%); filter: blur(0.5px); opacity: 0; animation: fcp-rise 9s linear infinite; }
.fcp-ember:nth-child(1){ left: 8%;  animation-delay: 0s; }
.fcp-ember:nth-child(2){ left: 22%; animation-delay: 1.4s; width: 6px; height: 6px; }
.fcp-ember:nth-child(3){ left: 38%; animation-delay: 2.8s; }
.fcp-ember:nth-child(4){ left: 52%; animation-delay: 4.2s; width: 10px; height: 10px; }
.fcp-ember:nth-child(5){ left: 64%; animation-delay: 5.6s; }
.fcp-ember:nth-child(6){ left: 76%; animation-delay: 7s; width: 7px; height: 7px; }
.fcp-ember:nth-child(7){ left: 88%; animation-delay: 0.7s; }
.fcp-ember:nth-child(8){ left: 14%; animation-delay: 4.6s; width: 5px; height: 5px; }
@keyframes fcp-rise { 0% { transform: translateY(0) scale(1); opacity: 0;} 12% { opacity: 1;} 80% { opacity: 0.6;} 100% { transform: translateY(-720px) scale(0.4); opacity: 0;} }

.fcp-shell { position: relative; padding: 24px 18px; }

/* Header */
.fcp-head { text-align: center; padding: 8px 4px 22px; }
.fcp-flame { display: inline-block; filter: drop-shadow(0 8px 18px rgba(255,107,53,0.55)); animation: fcp-bob 3s ease-in-out infinite; }
@keyframes fcp-bob { 0%,100% { transform: translateY(0) rotate(-2deg);} 50% { transform: translateY(-6px) rotate(2deg);} }
.fcp-title { font-size: clamp(28px, 5vw, 44px); margin: 6px 0 4px; background: linear-gradient(120deg, #FFD23F, #FF6B35 40%, #FF1B6B 70%, #B814FF); -webkit-background-clip: text; background-clip: text; color: transparent; }
.fcp-sub { margin: 0; opacity: 0.78; font-size: 15px; }

.fcp-toggles { display: flex; justify-content: center; align-items: center; gap: 12px; margin-top: 14px; flex-wrap: wrap; }
.fcp-tgl { display: inline-flex; align-items: center; gap: 8px; cursor: pointer; user-select: none; font-size: 13px; font-weight: 600; }
.fcp-tgl input { position: absolute; opacity: 0; pointer-events: none; }
.fcp-tgl-track { position: relative; width: 44px; height: 24px; border-radius: 999px; background: rgba(255,255,255,0.14); border: 1px solid rgba(255,255,255,0.18); transition: background .25s; }
.fcp-tgl-knob { position: absolute; top: 2px; left: 2px; width: 18px; height: 18px; border-radius: 50%; background: linear-gradient(135deg, #FFD23F, #FF6B35); transition: transform .25s, box-shadow .25s; box-shadow: 0 4px 10px rgba(255,107,53,0.45); }
.fcp-tgl input:checked + .fcp-tgl-track { background: linear-gradient(90deg, rgba(255,27,107,0.45), rgba(184,20,255,0.45)); }
.fcp-tgl input:checked + .fcp-tgl-track .fcp-tgl-knob { transform: translateX(20px); background: linear-gradient(135deg, #FF1B6B, #B814FF); }
.fcp-lang { display: inline-flex; border-radius: 999px; padding: 3px; background: rgba(255,255,255,0.10); border: 1px solid rgba(255,255,255,0.16); }
.fcp-lang-btn { background: transparent; color: #f4ecff; border: 0; padding: 4px 12px; border-radius: 999px; cursor: pointer; font-weight: 700; font-size: 12px; min-height: 26px; transition: background .2s, transform .15s; }
.fcp-lang-btn.is-on { background: linear-gradient(120deg, #FF1B6B, #B814FF); box-shadow: 0 6px 14px rgba(255,27,107,0.35); }
.fcp-mini { background: rgba(255,255,255,0.10); border: 1px solid rgba(255,255,255,0.18); color: #f4ecff; width: 32px; height: 32px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; transition: transform .15s, background .2s; font-size: 14px; }
.fcp-mini:hover { transform: scale(1.06); background: rgba(255,255,255,0.16); }
.fcp-snd-off { display: none; }
.fcp-wrap[data-sound="0"] .fcp-snd-on { display: none; }
.fcp-wrap[data-sound="0"] .fcp-snd-off { display: inline; }

/* Glass card */
.fcp-card { position: relative; background: linear-gradient(160deg, rgba(255,255,255,0.10), rgba(255,255,255,0.04)); backdrop-filter: blur(20px) saturate(140%); -webkit-backdrop-filter: blur(20px) saturate(140%); border: 1px solid rgba(255,255,255,0.16); border-radius: 24px; padding: 26px 22px; box-shadow: 0 30px 80px rgba(0,0,0,0.35), inset 0 1px 0 rgba(255,255,255,0.10); margin-top: 16px; overflow: hidden; }
.fcp-card::before { content: ""; position: absolute; inset: 0; border-radius: 24px; padding: 1px; background: linear-gradient(120deg, rgba(255,27,107,0.45), rgba(184,20,255,0.35), rgba(255,210,63,0.35)); -webkit-mask: linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0); -webkit-mask-composite: xor; mask-composite: exclude; pointer-events: none; opacity: 0.6; }

/* Form */
.fcp-row { display: grid; grid-template-columns: 1fr 60px 1fr; gap: 12px; align-items: end; }
.fcp-field { display: flex; flex-direction: column; gap: 6px; min-width: 0; }
.fcp-lbl { font-size: 12.5px; font-weight: 700; letter-spacing: 0.04em; text-transform: uppercase; opacity: 0.78; }
.fcp-input-wrap { position: relative; }
.fcp-input { width: 100%; min-height: 52px; padding: 14px 16px; font-size: 16px; background: rgba(15,8,32,0.55); border: 1.5px solid rgba(255,255,255,0.18); border-radius: 14px; color: #fff; outline: none; transition: border-color .25s, background .25s, box-shadow .25s; font-family: inherit; }
.fcp-input::placeholder { color: rgba(255,255,255,0.40); }
.fcp-input:focus { border-color: rgba(255,107,53,0.85); background: rgba(15,8,32,0.85); box-shadow: 0 0 0 4px rgba(255,107,53,0.18); }
.fcp-glow { pointer-events: none; position: absolute; inset: -2px; border-radius: 16px; background: radial-gradient(120% 80% at 50% 100%, rgba(255,27,107,0.30), transparent 70%); opacity: 0; transition: opacity .35s; }
.fcp-input:focus + .fcp-glow { opacity: 1; }

.fcp-heart { display: flex; align-items: center; justify-content: center; height: 52px; position: relative; }
.fcp-heart-emoji { font-size: 28px; animation: fcp-pulse 1.4s ease-in-out infinite; filter: drop-shadow(0 4px 10px rgba(255,107,53,0.55)); }
.fcp-heart-ring { position: absolute; width: 28px; height: 28px; border-radius: 50%; border: 2px solid rgba(255,107,53,0.55); animation: fcp-ring 2s ease-out infinite; }
@keyframes fcp-pulse { 0%,100% { transform: scale(1);} 50% { transform: scale(1.18);} }
@keyframes fcp-ring { 0% { transform: scale(0.7); opacity: 0.8;} 100% { transform: scale(2.4); opacity: 0;} }

/* Advanced row */
.fcp-adv { max-height: 0; overflow: hidden; transition: max-height .45s ease, opacity .35s, margin .35s; opacity: 0; }
.fcp-wrap[data-mode="advanced"] .fcp-adv { max-height: 220px; opacity: 1; margin-top: 14px; }
.fcp-adv-row { grid-template-columns: 1fr 24px 1fr; }
.fcp-spacer { width: 24px; }
.fcp-input[type="date"] { color: #fff; }
.fcp-input[type="date"]::-webkit-calendar-picker-indicator { filter: invert(1) brightness(1.4); cursor: pointer; }

/* Error */
.fcp-err { display: none; margin-top: 12px; background: rgba(255,27,107,0.12); border: 1px solid rgba(255,27,107,0.45); color: #ffb6cf; border-radius: 12px; padding: 10px 14px; font-size: 14px; text-align: center; }
.fcp-err.is-on { display: block; animation: fcp-shake .35s; }
@keyframes fcp-shake { 0%,100% { transform: translateX(0);} 25% { transform: translateX(-6px);} 75% { transform: translateX(6px);} }

/* Submit button */
.fcp-btn { position: relative; display: inline-flex; align-items: center; justify-content: center; gap: 10px; width: 100%; min-height: 58px; padding: 16px 22px; margin-top: 18px; border: 0; border-radius: 16px; cursor: pointer; color: #fff; font-family: inherit; font-weight: 800; font-size: 17px; letter-spacing: 0.01em; overflow: hidden; transition: transform .15s ease, box-shadow .25s ease; box-shadow: 0 16px 40px rgba(255,27,107,0.35); }
.fcp-btn-bg { position: absolute; inset: 0; background: linear-gradient(120deg, #FF6B35, #FF1B6B 50%, #B814FF); background-size: 200% 200%; animation: fcp-grad 4s ease infinite; z-index: 0; }
@keyframes fcp-grad { 0%,100% { background-position: 0 0;} 50% { background-position: 100% 100%;} }
.fcp-btn-txt, .fcp-btn-spark { position: relative; z-index: 1; }
.fcp-btn-spark { animation: fcp-spin 4s linear infinite; }
@keyframes fcp-spin { to { transform: rotate(360deg);} }
.fcp-btn:hover { transform: translateY(-2px); box-shadow: 0 22px 50px rgba(255,27,107,0.50); }
.fcp-btn:active { transform: translateY(0); }
.fcp-btn:disabled { opacity: 0.6; cursor: not-allowed; }

.fcp-trust { display: flex; gap: 8px; justify-content: center; flex-wrap: wrap; margin-top: 14px; }
.fcp-trust span { font-size: 12px; padding: 6px 12px; background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.14); border-radius: 999px; opacity: 0.85; }

/* Loading */
.fcp-loader { position: relative; width: 180px; height: 180px; margin: 4px auto 14px; }
.fcp-orbit { position: absolute; inset: 0; animation: fcp-spin 8s linear infinite; }
.fcp-orbit span { position: absolute; left: 50%; top: 50%; transform-origin: 0 0; font-size: 22px; }
.fcp-orbit span:nth-child(1){ transform: rotate(0deg) translate(80px) rotate(0deg);}
.fcp-orbit span:nth-child(2){ transform: rotate(60deg) translate(80px) rotate(-60deg);}
.fcp-orbit span:nth-child(3){ transform: rotate(120deg) translate(80px) rotate(-120deg);}
.fcp-orbit span:nth-child(4){ transform: rotate(180deg) translate(80px) rotate(-180deg);}
.fcp-orbit span:nth-child(5){ transform: rotate(240deg) translate(80px) rotate(-240deg);}
.fcp-orbit span:nth-child(6){ transform: rotate(300deg) translate(80px) rotate(-300deg);}
.fcp-orbit-core { position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); font-size: 56px; font-weight: 800; font-family: 'Space Grotesk', sans-serif; background: linear-gradient(120deg, #FFD23F, #FF1B6B, #B814FF); -webkit-background-clip: text; background-clip: text; color: transparent; animation: fcp-pulse 1.6s ease-in-out infinite; }
.fcp-load-txt { text-align: center; font-weight: 600; opacity: 0.9; }
.fcp-progress { height: 6px; max-width: 380px; margin: 12px auto 0; background: rgba(255,255,255,0.08); border-radius: 999px; overflow: hidden; }
.fcp-progress-bar { display: block; height: 100%; width: 0%; background: linear-gradient(90deg, #FF1B6B, #B814FF); border-radius: 999px; transition: width .4s ease; }

/* Result phase */
.fcp-couple { display: flex; align-items: center; justify-content: center; gap: 14px; margin-bottom: 8px; flex-wrap: wrap; }
.fcp-cp-name { display: inline-flex; align-items: center; gap: 8px; padding: 6px 12px; background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.16); border-radius: 999px; font-weight: 700; }
.fcp-cp-name strong { font-weight: 700; }
.fcp-init { width: 28px; height: 28px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 800; }
.fcp-cp-a .fcp-init { background: linear-gradient(135deg, #FFD23F, #FF6B35); color: #1a0533; }
.fcp-cp-b .fcp-init { background: linear-gradient(135deg, #FF1B6B, #B814FF); color: #fff; }
.fcp-cp-link { font-size: 18px; opacity: 0.7; }

/* Letter elimination */
.fcp-elim { background: rgba(15,8,32,0.45); border: 1px solid rgba(255,255,255,0.12); border-radius: 16px; padding: 14px 12px; margin: 12px 0; text-align: center; }
.fcp-elim-row { display: flex; justify-content: center; flex-wrap: wrap; gap: 4px; margin: 6px 0; min-height: 30px; }
.fcp-letter { display: inline-flex; align-items: center; justify-content: center; min-width: 26px; height: 30px; padding: 0 6px; background: rgba(255,255,255,0.10); border-radius: 8px; font-weight: 800; font-family: 'Space Grotesk', sans-serif; font-size: 16px; transition: all .35s ease; position: relative; }
.fcp-letter.is-cross { color: rgba(255,255,255,0.30); background: rgba(255,27,107,0.18); }
.fcp-letter.is-cross::after { content: ""; position: absolute; left: 4px; right: 4px; top: 50%; height: 2px; background: linear-gradient(90deg, #FF1B6B, #FF6B35); transform: translateY(-50%) rotate(-12deg); border-radius: 2px; }
.fcp-letter.is-flash { animation: fcp-flash .6s ease; }
@keyframes fcp-flash { 0% { background: rgba(255,210,63,0.6); transform: scale(1.25);} 100% { background: rgba(255,27,107,0.18); transform: scale(1);} }
.fcp-elim-count { margin-top: 6px; font-size: 13px; opacity: 0.75; }
.fcp-elim-count strong { color: #FFD23F; }

/* Wheel */
.fcp-wheel { display: flex; justify-content: center; gap: 8px; margin: 16px 0 12px; flex-wrap: wrap; }
.fcp-w-letter { width: 44px; height: 44px; border-radius: 12px; display: inline-flex; align-items: center; justify-content: center; font-family: 'Space Grotesk', sans-serif; font-weight: 800; font-size: 18px; background: rgba(255,255,255,0.10); border: 1px solid rgba(255,255,255,0.18); transition: all .35s; }
.fcp-w-letter.is-out { opacity: 0.25; transform: scale(0.85) rotate(-6deg); }
.fcp-w-letter.is-final { background: linear-gradient(135deg, #FF1B6B, #B814FF); border-color: rgba(255,255,255,0.55); transform: scale(1.18); box-shadow: 0 12px 28px rgba(184,20,255,0.55); animation: fcp-pop .6s ease; }
@keyframes fcp-pop { 0% { transform: scale(0.6) rotate(-12deg);} 60% { transform: scale(1.32) rotate(6deg);} 100% { transform: scale(1.18) rotate(0deg);} }

/* Reveal */
.fcp-reveal { text-align: center; padding: 8px 0 4px; position: relative; }
.fcp-letter-big { display: inline-block; font-family: 'Space Grotesk', sans-serif; font-weight: 800; font-size: clamp(72px, 14vw, 112px); line-height: 1; background: linear-gradient(135deg, var(--fcp-c1, #FFD23F), var(--fcp-c2, #FF1B6B)); -webkit-background-clip: text; background-clip: text; color: transparent; filter: drop-shadow(0 12px 32px rgba(255,27,107,0.55)); animation: fcp-rise-in .7s cubic-bezier(.2,.9,.3,1.2) both; }
@keyframes fcp-rise-in { from { transform: translateY(20px) scale(0.7); opacity: 0;} to { transform: translateY(0) scale(1); opacity: 1;} }
.fcp-result-name { font-size: clamp(22px, 3.6vw, 30px); margin-top: 6px; background: linear-gradient(120deg, #fff, #ffd1e1); -webkit-background-clip: text; background-clip: text; color: transparent; }
.fcp-result-tag { margin: 4px 0 0; opacity: 0.7; font-size: 13px; letter-spacing: 0.06em; text-transform: uppercase; }

/* Confetti */
.fcp-confetti { pointer-events: none; position: absolute; left: 0; right: 0; top: 0; height: 0; }
.fcp-confetti.is-go { height: 1px; }
.fcp-conf-piece { position: absolute; width: 8px; height: 14px; border-radius: 2px; opacity: 0; animation: fcp-conf 1400ms ease-out forwards; }
@keyframes fcp-conf { 0% { opacity: 1; transform: translate(0,0) rotate(0);} 100% { opacity: 0; transform: translate(var(--fcp-x), var(--fcp-y)) rotate(540deg);} }

/* Score ring */
.fcp-score { display: flex; align-items: center; gap: 22px; flex-wrap: wrap; justify-content: center; margin-top: 16px; padding: 16px 6px; background: rgba(15,8,32,0.45); border: 1px solid rgba(255,255,255,0.12); border-radius: 18px; }
.fcp-ring { position: relative; }
.fcp-ring-num { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; font-family: 'Space Grotesk', sans-serif; font-weight: 800; font-size: 38px; color: #fff; }
.fcp-ring-num i { font-style: normal; font-size: 18px; opacity: 0.7; margin-left: 2px; }
.fcp-score-bars { flex: 1; min-width: 220px; }
.fcp-sb { display: flex; align-items: center; gap: 10px; margin: 8px 0; font-size: 13px; font-weight: 600; }
.fcp-sb span { min-width: 92px; opacity: 0.8; }
.fcp-sb b { flex: 1; height: 8px; background: rgba(255,255,255,0.10); border-radius: 999px; overflow: hidden; display: block; font-weight: 400; }
.fcp-sb b i { display: block; height: 100%; width: 0%; background: linear-gradient(90deg, #FF6B35, #FF1B6B, #B814FF); border-radius: 999px; transition: width 1.2s cubic-bezier(.2,.9,.3,1); }

/* Actions */
.fcp-actions { display: flex; flex-wrap: wrap; gap: 8px; justify-content: center; margin-top: 18px; }
.fcp-act { background: rgba(255,255,255,0.10); color: #fff; border: 1px solid rgba(255,255,255,0.20); padding: 10px 16px; border-radius: 12px; font-weight: 700; cursor: pointer; font-family: inherit; font-size: 14px; transition: transform .15s, background .2s, border-color .2s; }
.fcp-act:hover { transform: translateY(-1px); background: rgba(255,255,255,0.18); border-color: rgba(255,255,255,0.32); }
.fcp-act-share { background: linear-gradient(120deg, #FF1B6B, #B814FF); border-color: transparent; }
.fcp-act-share:hover { background: linear-gradient(120deg, #B814FF, #FF1B6B); }

/* Advice */
.fcp-advice { margin-top: 16px; }
.fcp-adv-tabs { display: flex; gap: 6px; padding: 6px; background: rgba(15,8,32,0.5); border: 1px solid rgba(255,255,255,0.12); border-radius: 14px; overflow-x: auto; scrollbar-width: none; }
.fcp-adv-tabs::-webkit-scrollbar { display: none; }
.fcp-adv-tab { background: transparent; color: #f4ecff; border: 0; padding: 8px 14px; border-radius: 10px; font-weight: 700; font-size: 13px; cursor: pointer; white-space: nowrap; font-family: inherit; transition: background .25s, color .25s; }
.fcp-adv-tab.is-on { background: linear-gradient(120deg, #FF1B6B, #B814FF); box-shadow: 0 6px 18px rgba(184,20,255,0.4); }
.fcp-adv-stage { position: relative; margin-top: 12px; min-height: 140px; }
.fcp-adv-card { display: none; padding: 18px 16px; background: linear-gradient(160deg, rgba(255,255,255,0.10), rgba(255,255,255,0.04)); border: 1px solid rgba(255,255,255,0.14); border-radius: 16px; animation: fcp-fade .35s ease both; }
.fcp-adv-card.is-on { display: block; }
.fcp-adv-card h4 { font-size: 17px; margin-bottom: 6px; background: linear-gradient(120deg, #FFD23F, #FF1B6B); -webkit-background-clip: text; background-clip: text; color: transparent; }
.fcp-adv-card p { margin: 0; font-size: 14.5px; opacity: 0.92; line-height: 1.65; }
@keyframes fcp-fade { from { opacity: 0; transform: translateY(6px);} to { opacity: 1; transform: translateY(0);} }

/* History */
.fcp-history { margin-top: 16px; padding: 16px; background: rgba(15,8,32,0.45); border: 1px solid rgba(255,255,255,0.12); border-radius: 16px; }
.fcp-hist-head { display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px; }
.fcp-hist-head h4 { font-size: 15px; }
.fcp-hist-clear { background: transparent; color: #ffb6cf; border: 0; cursor: pointer; font-size: 12px; font-family: inherit; }
.fcp-hist-list { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 6px; }
.fcp-hist-list li { display: flex; justify-content: space-between; align-items: center; padding: 8px 12px; background: rgba(255,255,255,0.06); border-radius: 10px; font-size: 13px; }
.fcp-hist-list li b { color: #FFD23F; font-weight: 800; }

/* Premium */
.fcp-premium { display: flex; gap: 14px; align-items: center; margin-top: 16px; padding: 16px; background: linear-gradient(120deg, rgba(255,210,63,0.15), rgba(184,20,255,0.15)); border: 1px solid rgba(255,210,63,0.35); border-radius: 16px; }
.fcp-prem-icon { font-size: 34px; }
.fcp-prem-body { flex: 1; }
.fcp-prem-body h4 { font-size: 16px; }
.fcp-prem-body p { margin: 4px 0 8px; font-size: 13.5px; opacity: 0.88; }
.fcp-prem-cta { display: inline-block; padding: 8px 16px; border-radius: 10px; background: linear-gradient(120deg, #FFD23F, #FF6B35); color: #1a0533; font-weight: 800; text-decoration: none; font-size: 13.5px; transition: transform .15s; }
.fcp-prem-cta:hover { transform: translateY(-1px); }

/* Ads */
.fcp-ad { margin: 12px 0; text-align: center; min-height: 50px; }
.fcp-ad-mid { margin-top: 16px; }

/* Mobile */
@media (max-width: 640px) {
	.fcp-wrap { padding: 12px; margin: 14px auto; }
	.fcp-shell { padding: 16px 8px; }
	.fcp-card { padding: 18px 14px; }
	.fcp-row { grid-template-columns: 1fr; gap: 14px; }
	.fcp-row .fcp-heart { order: 2; height: 32px; }
	.fcp-row .fcp-field:nth-child(3) { order: 3; }
	.fcp-adv-row { grid-template-columns: 1fr; }
	.fcp-spacer { display: none; }
	.fcp-w-letter { width: 38px; height: 38px; font-size: 16px; }
	.fcp-orbit span:nth-child(1){ transform: rotate(0deg) translate(64px) rotate(0deg);}
	.fcp-orbit span:nth-child(2){ transform: rotate(60deg) translate(64px) rotate(-60deg);}
	.fcp-orbit span:nth-child(3){ transform: rotate(120deg) translate(64px) rotate(-120deg);}
	.fcp-orbit span:nth-child(4){ transform: rotate(180deg) translate(64px) rotate(-180deg);}
	.fcp-orbit span:nth-child(5){ transform: rotate(240deg) translate(64px) rotate(-240deg);}
	.fcp-orbit span:nth-child(6){ transform: rotate(300deg) translate(64px) rotate(-300deg);}
	.fcp-loader { width: 150px; height: 150px; }
	.fcp-orbit-core { font-size: 44px; }
	.fcp-actions .fcp-act { flex: 1 1 calc(50% - 8px); }
}

/* Reduced motion */
@media (prefers-reduced-motion: reduce) {
	.fcp-bg, .fcp-ember, .fcp-flame, .fcp-heart-emoji, .fcp-heart-ring, .fcp-orbit, .fcp-orbit-core, .fcp-btn-bg, .fcp-btn-spark, .fcp-letter-big { animation: none !important; }
	.fcp-card { transition: none !important; }
}
</style>
		<?php
	}
}

/* ---------------------------------------------------------------------------
 * Inline JS (with i18n strings + advice content)
 * ------------------------------------------------------------------------- */

if ( ! function_exists( 'fcp_inline_script' ) ) {
	function fcp_inline_script( $uid ) {
		?>
<script>
(function(){
	"use strict";
	var ROOT = document.getElementById(<?php echo wp_json_encode( $uid ); ?>);
	if (!ROOT || ROOT.dataset.fcpInit === "1") return;
	ROOT.dataset.fcpInit = "1";

	/* ---------- i18n ---------- */
	var I18N = {
		en: {
			title: "FLAMES Calculator",
			sub: "Discover what your relationship truly is",
			advanced: "Advanced",
			your_name: "Your Name",
			partner_name: "Partner's Name",
			your_dob: "Your Date of Birth",
			partner_dob: "Partner's Date of Birth",
			calculate: "Calculate FLAMES",
			trust1: "⚡ Instant",
			trust2: "🔒 100% Private",
			trust3: "🎯 Free Forever",
			reading: "Reading the cosmic vibes…",
			remaining: "Remaining",
			result_tag: "Your relationship vibe",
			numerology: "Numerology",
			zodiac: "Zodiac",
			name_match: "Name Match",
			flames_score: "FLAMES Vibe",
			try_again: "Try Again",
			share: "Share",
			save: "Save",
			download: "Download Card",
			tab_golden: "✨ Golden Hint",
			tab_pro: "💡 Pro Tip",
			tab_life: "🌿 Life Lesson",
			tab_boost: "🚀 Score Boost",
			tab_next: "🎯 What Next",
			history: "Your History",
			clear: "Clear",
			prem_title: "Unlock Deeper Insights",
			prem_text: "Get full birth-chart compatibility, daily love forecast and personalized rituals.",
			err_required: "Please enter both names.",
			err_short: "Names should be at least 2 letters long.",
			err_same: "Names look identical. Try slightly different ones.",
			err_dob: "Please add both dates of birth for advanced mode.",
			step1: "Crossing common letters…",
			step2: "Counting the spark…",
			step3: "Spinning F-L-A-M-E-S…",
			step4: "Reading your cosmic vibe…",
			save_done: "Saved to your history!",
			copy_done: "Result copied to clipboard!"
		},
		hi: {
			title: "फ्लेम्स कैलकुलेटर",
			sub: "जानिए आपके रिश्ते की असली पहचान",
			advanced: "एडवांस्ड",
			your_name: "आपका नाम",
			partner_name: "साथी का नाम",
			your_dob: "आपकी जन्म तिथि",
			partner_dob: "साथी की जन्म तिथि",
			calculate: "FLAMES निकालें",
			trust1: "⚡ तुरंत",
			trust2: "🔒 पूरी तरह निजी",
			trust3: "🎯 हमेशा फ्री",
			reading: "रिश्ते की ऊर्जा पढ़ी जा रही है…",
			remaining: "बचे अक्षर",
			result_tag: "आपके रिश्ते का अंदाज़",
			numerology: "अंक ज्योतिष",
			zodiac: "राशि मिलान",
			name_match: "नाम मिलान",
			flames_score: "FLAMES वाइब",
			try_again: "फिर से करें",
			share: "शेयर करें",
			save: "सेव करें",
			download: "कार्ड डाउनलोड",
			tab_golden: "✨ गोल्डन हिंट",
			tab_pro: "💡 प्रो टिप",
			tab_life: "🌿 ज़िंदगी का सबक",
			tab_boost: "🚀 स्कोर बूस्ट",
			tab_next: "🎯 आगे क्या",
			history: "आपकी हिस्ट्री",
			clear: "मिटाएँ",
			prem_title: "और गहरी जानकारी पाएँ",
			prem_text: "पूरा जन्म-कुंडली मिलान, डेली लव हॉरोस्कोप और निजी उपाय पाएँ।",
			err_required: "कृपया दोनों नाम भरें।",
			err_short: "नाम कम से कम 2 अक्षर का हो।",
			err_same: "दोनों नाम एक जैसे लग रहे हैं, थोड़े अलग आज़माएँ।",
			err_dob: "एडवांस्ड मोड के लिए दोनों जन्म तिथि भरें।",
			step1: "मिलते अक्षर काटे जा रहे हैं…",
			step2: "स्पार्क गिना जा रहा है…",
			step3: "F-L-A-M-E-S घुमाया जा रहा है…",
			step4: "आपकी कॉस्मिक वाइब पढ़ी जा रही है…",
			save_done: "हिस्ट्री में सेव हुआ!",
			copy_done: "रिज़ल्ट कॉपी हो गया!"
		}
	};

	/* ---------- Result content (per letter, per language) ---------- */
	var RESULT = {
		F: {
			name: { en: "Friends", hi: "दोस्त" },
			emoji: "🤝",
			tag:  { en: "Best Friends Forever", hi: "सच्चे दोस्त" },
			c1: "#00D4FF", c2: "#00FFB3",
			base: 76,
			content: {
				en: {
					golden: { h: "Friendship is the gold standard", t: "Romance comes and goes but a real friend is your safety net. Don't downgrade what you already have — friendship like yours often grows into the deepest love or stays a lifelong anchor." },
					protip: { h: "Keep it light, keep it real", t: "Make a tiny ritual — a meme drop every morning, a 5-minute call every night. Small consistent contact builds an unbreakable bond." },
					life:   { h: "True friends know your silence", t: "If they understand what you didn't say, that's rare. Protect this — apologise fast, listen slow, never keep score." },
					boost:  { h: "Boost your bond by 20%", t: "Plan one new shared experience this month — a workout, a recipe, a road-trip. Shared firsts wire your brains together." },
					next:   { h: "Should you confess?", t: "Test the waters with playful flirting. If they laugh and lean in, share a soft 'I really like our vibe.' If not, friendship intact — no loss." }
				},
				hi: {
					golden: { h: "दोस्ती सबसे बड़ा खज़ाना है", t: "प्यार आते-जाते रहते हैं, मगर सच्चा दोस्त ज़िंदगी का सहारा है। जो तुम्हारे पास है उसकी कीमत समझो — ऐसी दोस्ती अक्सर सबसे गहरे प्यार में बदलती है।" },
					protip: { h: "सरल रखो, सच्चा रखो", t: "एक छोटी आदत बना लो — रोज़ सुबह एक मीम, रात में 5 मिनट की बात। छोटी निरंतरता मज़बूत रिश्ता बनाती है।" },
					life:   { h: "असली दोस्त चुप्पी समझ लेता है", t: "जो बिना कहे समझ ले, उसे संभालो — माफ़ी जल्दी माँगो, सुनो ठहर कर, हिसाब कभी मत रखो।" },
					boost:  { h: "अपनी बॉन्डिंग 20% बढ़ाओ", t: "इस महीने एक नया अनुभव साथ करो — वर्कआउट, नई रेसिपी, छोटा ट्रिप। नए अनुभव दिमाग में गहरी छाप छोड़ते हैं।" },
					next:   { h: "क्या इज़हार करना चाहिए?", t: "हलकी-फुलकी फ्लर्टिंग से माहौल टटोलो। हँसी और झुकाव दिखे तो धीरे से बोलो 'मुझे ये वाइब बहुत पसंद है।' नहीं तो दोस्ती सलामत है।" }
				}
			}
		},
		L: {
			name: { en: "Lovers", hi: "प्रेमी" },
			emoji: "💖",
			tag:  { en: "Cosmic Soulmates", hi: "रूह से जुड़े" },
			c1: "#FF1B6B", c2: "#FF6B35",
			base: 88,
			content: {
				en: {
					golden: { h: "Love is verb, not just feeling", t: "Butterflies fade — what stays is the choice you make every morning. Choose them in small ways daily, and the spark never dies." },
					protip: { h: "The 5-second rule of love", t: "When something nice crosses your mind about them, say it within 5 seconds. Unsaid praise dies; spoken praise multiplies the bond." },
					life:   { h: "Don't compare your love story", t: "Every couple is on a different chapter. Stop measuring your love by social media — your real story is the one nobody is filming." },
					boost:  { h: "Boost your love score", t: "Try the '36 questions to fall in love' tonight, write a tiny love note before bed, and never go to sleep angry. These three habits change everything." },
					next:   { h: "Take it deeper", t: "Plan one future moment together — a trip, a goal, a tradition. People who plan together, stay together. Talk dreams, not just plans." }
				},
				hi: {
					golden: { h: "प्यार सिर्फ एहसास नहीं, चुनाव है", t: "तितलियाँ कुछ देर की होती हैं, असली बात है हर सुबह उन्हें फिर चुनना। छोटे-छोटे इशारों में रोज़ चुनो, स्पार्क कभी नहीं मरेगा।" },
					protip: { h: "प्यार का 5-सेकंड नियम", t: "जब उनके बारे में कोई अच्छी बात मन में आए, 5 सेकंड में कह दो। अनकही तारीफें मर जाती हैं, कही गई तारीफें रिश्ता बढ़ाती हैं।" },
					life:   { h: "अपनी लव स्टोरी की तुलना मत करो", t: "हर जोड़ी अलग पन्ने पर है। सोशल मीडिया से अपने प्यार को मत आँको — असली कहानी वो है जो कोई फिल्म नहीं रहा।" },
					boost:  { h: "अपना लव स्कोर बढ़ाओ", t: "आज रात '36 questions' खेलो, सोने से पहले एक छोटी प्यार भरी चिट्ठी लिखो, और कभी गुस्से में मत सोओ। ये तीन आदतें सब कुछ बदल देती हैं।" },
					next:   { h: "रिश्ते को गहरा करो", t: "एक भविष्य का पल साथ प्लान करो — ट्रिप, लक्ष्य, परंपरा। जो साथ प्लान करते हैं, साथ रहते हैं। बस प्लान नहीं, सपने भी बाँटो।" }
				}
			}
		},
		A: {
			name: { en: "Affection", hi: "स्नेह" },
			emoji: "🌸",
			tag:  { en: "Tender Hearts", hi: "नाज़ुक एहसास" },
			c1: "#B814FF", c2: "#FF6BFB",
			base: 80,
			content: {
				en: {
					golden: { h: "Affection is quieter than love", t: "It doesn't shout — it shows up. The morning chai, the saved seat, the remembered medicine. Notice these. They are love wearing a soft outfit." },
					protip: { h: "Speak their love language", t: "Find out if they feel loved by words, gifts, time, touch or acts of service. Then double down on theirs — not yours." },
					life:   { h: "Care without keeping score", t: "Affection dies the moment you start counting who did more. Give freely; if it's mutual the universe balances itself." },
					boost:  { h: "Add the warmth touch", t: "Replace one daily 'okay' with a 'how are you really?' Replace one emoji with a voice note. Small warmth upgrades the whole vibe." },
					next:   { h: "Build a soft tradition", t: "Pick one ritual — Sunday breakfast, Thursday playlist swap, monthly photo. Tiny traditions create lifelong glue." }
				},
				hi: {
					golden: { h: "स्नेह प्यार से ज़्यादा शांत है", t: "ये चिल्लाता नहीं, दिखाता है — सुबह की चाय, बचाई हुई सीट, याद रखी हुई दवाई। इन्हें पहचानो। ये प्यार है, बस नर्म लिबास में।" },
					protip: { h: "उनकी 'लव लैंग्वेज' समझो", t: "क्या उन्हें शब्दों से, गिफ्ट से, समय से, छुअन से या मदद से प्यार महसूस होता है? जो उनकी भाषा है, उसी में दो — अपनी नहीं।" },
					life:   { h: "बिना हिसाब के परवाह करो", t: "जिस पल हिसाब शुरू हुआ, स्नेह खत्म। खुलकर दो; अगर दो-तरफा है तो ब्रह्मांड अपने आप संतुलन कर लेगा।" },
					boost:  { h: "गर्माहट का स्पर्श जोड़ो", t: "रोज़ का एक 'ठीक है' बदलकर 'सच में कैसे हो?' करो। एक इमोजी की जगह एक वॉइस नोट भेजो। छोटी गर्माहट पूरी वाइब बदल देती है।" },
					next:   { h: "एक छोटी परंपरा बनाओ", t: "एक रिवाज़ चुनो — रविवार की ब्रेकफास्ट, गुरुवार की प्लेलिस्ट, महीने की फोटो। छोटी परंपराएँ ज़िंदगी भर का गोंद हैं।" }
				}
			}
		},
		M: {
			name: { en: "Marriage", hi: "विवाह" },
			emoji: "💍",
			tag:  { en: "Forever Match", hi: "सदा का साथ" },
			c1: "#FFD23F", c2: "#FF8800",
			base: 92,
			content: {
				en: {
					golden: { h: "The best marriages are slow-cooked", t: "Don't rush, don't ghost, don't hide red flags. Build trust like you build a house — brick by honest brick." },
					protip: { h: "Talk money, family, kids, ego — early", t: "These four kill more marriages than any 'love problem'. Have the awkward chats now and save 10 years of guessing." },
					life:   { h: "Marriage is two people on the same team", t: "It's not 'me vs you' — it's 'us vs the problem'. The day you start saying 'we', you start winning." },
					boost:  { h: "The 90-day upgrade", t: "Pick one habit each that bothers the other and improve it for 90 days. Not for them — for the team. This compounds into a fortress." },
					next:   { h: "Plan, don't drift", t: "Have a 'state of us' chat every 3 months — what's working, what's heavy, what's exciting. Couples who review, grow." }
				},
				hi: {
					golden: { h: "अच्छी शादी धीमी आँच पर पकती है", t: "जल्दबाज़ी मत करो, ग़ायब मत हो, लाल झंडे मत छिपाओ। भरोसा घर की तरह बनाओ — एक-एक ईंट सच्चाई की।" },
					protip: { h: "पैसा, परिवार, बच्चे, अहंकार — पहले बात करो", t: "ये चार किसी भी 'लव प्रॉब्लम' से ज़्यादा शादियाँ तोड़ते हैं। असुविधाजनक बातें अभी कर लो, 10 साल का अंदाज़ा बच जाएगा।" },
					life:   { h: "शादी मतलब एक टीम के दो खिलाड़ी", t: "'मैं बनाम तुम' नहीं, 'हम बनाम समस्या'। जिस दिन 'हम' कहना शुरू, उस दिन से जीतना शुरू।" },
					boost:  { h: "90-दिन अपग्रेड", t: "एक-एक आदत चुनो जो दूसरे को परेशान करती है और 90 दिन सुधारो। उनके लिए नहीं — टीम के लिए। यही किला बनाती है।" },
					next:   { h: "बहो मत, प्लान करो", t: "हर 3 महीने में 'हम कहाँ हैं' पर बात करो — क्या चल रहा है, क्या भारी है, क्या रोमांचक है। जो रिव्यू करते हैं, वो बढ़ते हैं।" }
				}
			}
		},
		E: {
			name: { en: "Enemies", hi: "विरोधी" },
			emoji: "⚔️",
			tag:  { en: "Crackling Tension", hi: "तीखी ऊर्जा" },
			c1: "#FF0040", c2: "#FF4500",
			base: 55,
			content: {
				en: {
					golden: { h: "Enemies often hide hurt friends", t: "Behind every 'enemy' is usually one moment that hurt and never got resolved. The opposite of love isn't hate — it's indifference. So if there's fire, there's still something." },
					protip: { h: "Don't reply, respond", t: "Replies are reactive, responses are chosen. Wait 6 hours before any heated message. You'll never regret what you didn't send." },
					life:   { h: "You can't pour into a leaking cup", t: "If a relationship constantly drains you, distance is not cruelty — it's self-respect. Choose peace over proving a point." },
					boost:  { h: "Try one honest conversation", t: "Send a single line: 'I don't want this energy between us. Can we talk?' Most enemies become acquaintances after one real chat." },
					next:   { h: "Decide the next chapter", t: "Either repair, redefine, or release. Sitting in unresolved hostility eats both people. Choose, then act — your peace depends on it." }
				},
				hi: {
					golden: { h: "विरोधी अक्सर चोट खाए दोस्त होते हैं", t: "हर 'दुश्मन' के पीछे आमतौर पर एक चोट होती है जो कभी हल नहीं हुई। प्यार का उलट नफ़रत नहीं, बेरुख़ी है। आग बची है, मतलब कुछ बचा है।" },
					protip: { h: "जवाब मत दो, सोच कर बोलो", t: "जल्दी का जवाब रिएक्शन है, सोच कर बोलना चुनाव। गुस्से वाला कोई भी मैसेज 6 घंटे रोको — जो नहीं भेजा, उसका कभी अफ़सोस नहीं होगा।" },
					life:   { h: "टपकते बर्तन में पानी नहीं भरा जाता", t: "अगर रिश्ता लगातार थकाता है तो दूरी क्रूरता नहीं — आत्म-सम्मान है। बात जीतने से ज़्यादा शांति चुनो।" },
					boost:  { h: "एक ईमानदार बातचीत आज़माओ", t: "बस एक लाइन भेजो — 'मुझे ये बीच की एनर्जी अच्छी नहीं लगती। बात कर सकते हैं?' एक असली बातचीत के बाद ज़्यादातर दुश्मन परिचित बन जाते हैं।" },
					next:   { h: "अगला अध्याय तय करो", t: "या सुधारो, या नया रूप दो, या जाने दो। बिना हल वाली कड़वाहट दोनों को खाती है। फ़ैसला लो, फिर अमल करो।" }
				}
			}
		},
		S: {
			name: { en: "Siblings", hi: "भाई-बहन जैसा" },
			emoji: "🌱",
			tag:  { en: "Family Bond", hi: "अपनापन" },
			c1: "#00FFB3", c2: "#00C9A7",
			base: 72,
			content: {
				en: {
					golden: { h: "Sibling-style love is the safest love", t: "It's the love that doesn't demand. The kind where you can be ugly, broke, weird and still welcome. Don't underestimate this — many spouses wish they had it." },
					protip: { h: "Show up without invitation", t: "Sibling-energy means presence over performance. Drop by, send the random meme, remember the small wins. Be the one who shows up." },
					life:   { h: "Family isn't only blood", t: "The people who feel like home — keep them. Build your own circle of chosen siblings. They will save your life one day." },
					boost:  { h: "Strengthen this bond", t: "Have one regular ritual — Sunday call, monthly meetup, shared playlist. Sibling-love survives on repetition, not intensity." },
					next:   { h: "Define the lane clearly", t: "If both of you read it as friendship/family, beautiful — keep it that way. If one feels romantic, talk it out before unsaid feelings poison the bond." }
				},
				hi: {
					golden: { h: "भाई-बहन जैसा प्यार सबसे सुरक्षित है", t: "ये वो प्यार है जो माँगता नहीं। जहाँ तुम बिखरे हुए, बेकार दिखते भी अपने हो। इसे कम मत समझो — बहुत से जीवनसाथी ये चाहते हैं और नहीं पाते।" },
					protip: { h: "बिना बुलाए हाज़िर रहो", t: "भाई-बहन की एनर्जी 'दिखावे' से ज़्यादा 'मौजूदगी' है। बिना वजह मिलो, मीम भेजो, छोटी जीत याद रखो। वो बनो जो हर वक़्त साथ है।" },
					life:   { h: "परिवार सिर्फ खून का नहीं होता", t: "जो लोग 'घर' जैसे लगते हैं, उन्हें संभालो। अपना खुद का चुना हुआ परिवार बनाओ। एक दिन ये ज़िंदगी बचाएँगे।" },
					boost:  { h: "इस बंधन को मज़बूत करो", t: "एक नियमित आदत — रविवार की कॉल, महीने की मुलाक़ात, साझी प्लेलिस्ट। ये रिश्ता बार-बार से चलता है, तीव्रता से नहीं।" },
					next:   { h: "लेन साफ़ करो", t: "अगर दोनों इसे दोस्ती/परिवार मानते हैं, बेहतरीन — वैसे ही रखो। अगर किसी एक के मन में रोमांटिक भाव है, बात करो — अनकहे जज़्बात रिश्ते को ज़हर देते हैं।" }
				}
			}
		}
	};

	/* ---------- Helpers ---------- */
	function $(sel, root){ return (root || ROOT).querySelector(sel); }
	function $$(sel, root){ return Array.prototype.slice.call((root || ROOT).querySelectorAll(sel)); }
	function clamp(v, a, b){ return Math.max(a, Math.min(b, v)); }

	var lang = ROOT.dataset.lang === 'hi' ? 'hi' : 'en';
	var mode = ROOT.dataset.mode === 'advanced' ? 'advanced' : 'basic';
	var soundOn = ROOT.dataset.sound === '1';
	var hapticsOn = ROOT.dataset.haptics === '1';

	function applyI18n(){
		var dict = I18N[lang];
		$$('[data-i18n]').forEach(function(el){
			var key = el.getAttribute('data-i18n');
			if (dict[key]) el.textContent = dict[key];
		});
		// max date today for DOB
		var today = new Date().toISOString().split('T')[0];
		var d1 = $('.fcp-dob1'), d2 = $('.fcp-dob2');
		if (d1) d1.setAttribute('max', today);
		if (d2) d2.setAttribute('max', today);
	}

	/* ---------- FLAMES core ---------- */
	function cleanName(s){ return (s||'').toLowerCase().replace(/[^a-zऀ-ॿ]/g, ''); }

	function computeElim(n1, n2){
		var a = n1.split('');
		var b = n2.split('');
		// Track original indexes for animation
		var aMarks = a.map(function(){ return false; });
		var bMarks = b.map(function(){ return false; });
		var pairs = [];
		for (var i = 0; i < a.length; i++){
			for (var j = 0; j < b.length; j++){
				if (!bMarks[j] && !aMarks[i] && a[i] === b[j]){
					aMarks[i] = true;
					bMarks[j] = true;
					pairs.push([i, j]);
					break;
				}
			}
		}
		var remaining = aMarks.filter(function(x){return !x;}).length + bMarks.filter(function(x){return !x;}).length;
		return { aMarks: aMarks, bMarks: bMarks, pairs: pairs, remaining: remaining };
	}

	function flamesLetter(count){
		if (count <= 0) count = 1;
		var arr = ['F','L','A','M','E','S'];
		var idx = 0;
		while (arr.length > 1){
			idx = ((idx + count - 1) % arr.length);
			arr.splice(idx, 1);
			if (idx >= arr.length) idx = 0;
		}
		return arr[0];
	}

	/* ---------- Numerology ---------- */
	function nameNum(n){
		var s = n.toLowerCase().replace(/[^a-z]/g, '');
		var sum = 0;
		for (var i = 0; i < s.length; i++) sum += (s.charCodeAt(i) - 96);
		while (sum > 9 && sum !== 11 && sum !== 22) {
			var t = 0; String(sum).split('').forEach(function(d){ t += parseInt(d, 10); });
			sum = t;
		}
		return sum || 1;
	}
	function numerologyMatch(a, b){
		// Simple compatibility table (1-9). Higher = better.
		var key = Math.min(a,b) + '-' + Math.max(a,b);
		var table = {
			'1-1':82,'1-2':70,'1-3':88,'1-4':60,'1-5':92,'1-6':74,'1-7':66,'1-8':70,'1-9':86,
			'2-2':80,'2-3':72,'2-4':84,'2-5':66,'2-6':92,'2-7':82,'2-8':78,'2-9':70,
			'3-3':84,'3-4':62,'3-5':86,'3-6':92,'3-7':74,'3-8':70,'3-9':94,
			'4-4':82,'4-5':62,'4-6':82,'4-7':86,'4-8':92,'4-9':62,
			'5-5':80,'5-6':70,'5-7':82,'5-8':70,'5-9':84,
			'6-6':92,'6-7':70,'6-8':82,'6-9':94,
			'7-7':86,'7-8':70,'7-9':80,
			'8-8':84,'8-9':70,
			'9-9':92
		};
		return table[key] || 70;
	}

	/* ---------- Zodiac ---------- */
	function zodiacFromDate(d){
		if (!d) return null;
		var dt = new Date(d);
		if (isNaN(dt)) return null;
		var m = dt.getMonth() + 1, day = dt.getDate();
		var ranges = [
			['Capricorn', [12,22], [1,19]], ['Aquarius', [1,20], [2,18]],
			['Pisces', [2,19], [3,20]], ['Aries', [3,21], [4,19]],
			['Taurus', [4,20], [5,20]], ['Gemini', [5,21], [6,20]],
			['Cancer', [6,21], [7,22]], ['Leo', [7,23], [8,22]],
			['Virgo', [8,23], [9,22]], ['Libra', [9,23], [10,22]],
			['Scorpio', [10,23], [11,21]], ['Sagittarius', [11,22], [12,21]]
		];
		for (var i = 0; i < ranges.length; i++){
			var z = ranges[i], s = z[1], e = z[2];
			if ((m === s[0] && day >= s[1]) || (m === e[0] && day <= e[1])) return z[0];
		}
		return 'Capricorn';
	}
	function zodiacScore(a, b){
		if (!a || !b) return 70;
		var elements = { fire:['Aries','Leo','Sagittarius'], earth:['Taurus','Virgo','Capricorn'], air:['Gemini','Libra','Aquarius'], water:['Cancer','Scorpio','Pisces'] };
		function elOf(z){ for (var k in elements) if (elements[k].indexOf(z) > -1) return k; return ''; }
		var e1 = elOf(a), e2 = elOf(b);
		if (a === b) return 86;
		if (e1 === e2) return 90;
		if ((e1==='fire'&&e2==='air')||(e1==='air'&&e2==='fire')) return 88;
		if ((e1==='earth'&&e2==='water')||(e1==='water'&&e2==='earth')) return 88;
		if ((e1==='fire'&&e2==='water')||(e1==='water'&&e2==='fire')) return 60;
		if ((e1==='earth'&&e2==='air')||(e1==='air'&&e2==='earth')) return 64;
		return 72;
	}

	function nameOverlap(a, b){
		var sa = a.toLowerCase().replace(/[^a-z]/g,'').split('');
		var sb = b.toLowerCase().replace(/[^a-z]/g,'').split('');
		var common = 0;
		var bcopy = sb.slice();
		sa.forEach(function(c){
			var i = bcopy.indexOf(c);
			if (i > -1){ common++; bcopy.splice(i,1); }
		});
		var total = sa.length + sb.length;
		return total === 0 ? 50 : Math.round((common * 2 / total) * 100);
	}

	/* ---------- Sound ---------- */
	var audioCtx = null;
	function beep(freq, dur, type){
		if (!soundOn) return;
		try {
			audioCtx = audioCtx || new (window.AudioContext || window.webkitAudioContext)();
			var o = audioCtx.createOscillator();
			var g = audioCtx.createGain();
			o.type = type || 'sine';
			o.frequency.value = freq;
			g.gain.value = 0.06;
			o.connect(g); g.connect(audioCtx.destination);
			o.start();
			g.gain.exponentialRampToValueAtTime(0.0001, audioCtx.currentTime + (dur||0.18));
			o.stop(audioCtx.currentTime + (dur||0.18) + 0.02);
		} catch(e){}
	}
	function buzz(ms){
		if (!hapticsOn) return;
		try { if (navigator.vibrate) navigator.vibrate(ms || 12); } catch(e){}
	}

	/* ---------- UI helpers ---------- */
	function show(el){ if (el) el.hidden = false; }
	function hide(el){ if (el) el.hidden = true; }

	function setError(msg){
		var box = $('.fcp-err');
		if (!box) return;
		if (msg){ box.textContent = msg; box.classList.add('is-on'); buzz(40); }
		else { box.textContent = ''; box.classList.remove('is-on'); }
	}

	/* ---------- Letter elimination animation ---------- */
	function renderElim(n1, n2, marks, cb){
		var rowA = $('.fcp-elim-a'), rowB = $('.fcp-elim-b'), cnt = $('.fcp-elim-count strong');
		rowA.innerHTML = ''; rowB.innerHTML = '';
		var aLetters = [], bLetters = [];
		n1.split('').forEach(function(ch){
			var s = document.createElement('span'); s.className = 'fcp-letter'; s.textContent = ch.toUpperCase();
			rowA.appendChild(s); aLetters.push(s);
		});
		n2.split('').forEach(function(ch){
			var s = document.createElement('span'); s.className = 'fcp-letter'; s.textContent = ch.toUpperCase();
			rowB.appendChild(s); bLetters.push(s);
		});
		cnt.textContent = (n1.length + n2.length);
		var pairs = marks.pairs.slice();
		var remaining = n1.length + n2.length;
		(function step(){
			if (!pairs.length){ cb && cb(); return; }
			var pr = pairs.shift();
			var elA = aLetters[pr[0]], elB = bLetters[pr[1]];
			elA.classList.add('is-flash'); elB.classList.add('is-flash');
			beep(880, 0.06, 'square'); buzz(8);
			setTimeout(function(){
				elA.classList.add('is-cross'); elB.classList.add('is-cross');
				remaining -= 2; cnt.textContent = remaining;
				setTimeout(step, 110);
			}, 90);
		})();
	}

	/* ---------- Wheel animation ---------- */
	function spinWheel(count, finalLetter, cb){
		var letters = $$('.fcp-w-letter');
		letters.forEach(function(el){ el.classList.remove('is-out','is-final'); });
		var arr = ['F','L','A','M','E','S'];
		var idx = 0;
		function eliminate(){
			if (arr.length <= 1){
				var fin = letters.filter(function(el){ return el.dataset.l === finalLetter; })[0];
				if (fin){ fin.classList.add('is-final'); beep(660, 0.5, 'sine'); buzz(40); }
				cb && cb();
				return;
			}
			idx = ((idx + count - 1) % arr.length);
			var rem = arr.splice(idx, 1)[0];
			var dom = letters.filter(function(el){ return el.dataset.l === rem; })[0];
			if (dom){ dom.classList.add('is-out'); beep(440 + arr.length * 60, 0.10, 'triangle'); }
			if (idx >= arr.length) idx = 0;
			setTimeout(eliminate, 320);
		}
		setTimeout(eliminate, 250);
	}

	/* ---------- Confetti ---------- */
	function confetti(){
		var box = $('.fcp-confetti'); if (!box) return;
		box.innerHTML = ''; box.classList.add('is-go');
		var colors = ['#FFD23F','#FF6B35','#FF1B6B','#B814FF','#00FFB3','#00D4FF'];
		for (var i = 0; i < 36; i++){
			var p = document.createElement('span');
			p.className = 'fcp-conf-piece';
			p.style.left = (50 + (Math.random()*40 - 20)) + '%';
			p.style.top = '120px';
			p.style.background = colors[i % colors.length];
			p.style.setProperty('--fcp-x', (Math.random()*600 - 300) + 'px');
			p.style.setProperty('--fcp-y', (Math.random()*-380 - 80) + 'px');
			p.style.animationDelay = (Math.random()*0.2) + 's';
			box.appendChild(p);
		}
		setTimeout(function(){ box.classList.remove('is-go'); box.innerHTML=''; }, 1600);
	}

	/* ---------- Reveal result ---------- */
	function showResult(letter, names, scores){
		var data = RESULT[letter];
		ROOT.style.setProperty('--fcp-c1', data.c1);
		ROOT.style.setProperty('--fcp-c2', data.c2);

		var initA = (names.n1[0]||'?').toUpperCase();
		var initB = (names.n2[0]||'?').toUpperCase();
		$('.fcp-cp-a .fcp-init').textContent = initA;
		$('.fcp-cp-b .fcp-init').textContent = initB;
		$('.fcp-cp-a strong').textContent = capWords(names.n1);
		$('.fcp-cp-b strong').textContent = capWords(names.n2);

		var bigLetter = $('.fcp-letter-big'); bigLetter.textContent = letter;
		bigLetter.style.background = 'linear-gradient(135deg, '+data.c1+', '+data.c2+')';
		bigLetter.style.webkitBackgroundClip = 'text';
		bigLetter.style.backgroundClip = 'text';
		bigLetter.style.color = 'transparent';

		$('.fcp-result-name').textContent = data.emoji + ' ' + data.name[lang];
		$('.fcp-result-tag').textContent  = data.tag[lang];

		// Score block (advanced only)
		var scoreEl = $('.fcp-score');
		if (scores){
			show(scoreEl);
			setTimeout(function(){
				var ring = $('.fcp-ring-fg');
				var circ = 326.7;
				var off = circ - (circ * (scores.total/100));
				ring.style.strokeDashoffset = off;
				animateNumber($('.fcp-ring-val'), 0, scores.total, 1200);
				var bars = $$('.fcp-sb b i');
				if (bars[0]) bars[0].style.width = scores.numerology + '%';
				if (bars[1]) bars[1].style.width = scores.zodiac + '%';
				if (bars[2]) bars[2].style.width = scores.name + '%';
				if (bars[3]) bars[3].style.width = scores.flames + '%';
			}, 60);
		} else {
			hide(scoreEl);
		}

		// Advice
		var advBox = $('.fcp-advice'); show(advBox);
		var content = data.content[lang];
		fillAdvice('golden', content.golden);
		fillAdvice('protip', content.protip);
		fillAdvice('life',   content.life);
		fillAdvice('boost',  content.boost);
		fillAdvice('next',   content.next);

		confetti();
		buzz([20,30,20]);
		beep(880, 0.18, 'sine');

		// Premium upsell
		var prem = $('.fcp-premium');
		if (ROOT.dataset.premium === '1' && ROOT.dataset.premiumUrl){
			prem.querySelector('.fcp-prem-cta').href = ROOT.dataset.premiumUrl;
			prem.querySelector('.fcp-prem-cta').textContent = ROOT.dataset.premiumLabel || 'Premium';
			show(prem);
		}

		// Mid ad
		var midAd = ROOT.querySelector('.fcp-ad-mid'); if (midAd) show(midAd);

		// Save state for actions
		ROOT._fcpState = { letter: letter, names: names, scores: scores };

		// Auto-save to history (if enabled and visible)
		if (ROOT.dataset.history === '1') saveToHistory(letter, names, scores);
	}

	function fillAdvice(pane, obj){
		var card = $('.fcp-adv-card[data-pane="'+pane+'"]');
		if (card){
			card.querySelector('h4').textContent = obj.h;
			card.querySelector('p').textContent  = obj.t;
		}
	}

	function capWords(s){
		return (s||'').replace(/\b[a-zऀ-ॿ]/g, function(c){ return c.toUpperCase(); });
	}

	function animateNumber(el, from, to, dur){
		if (!el) return;
		var start = performance.now();
		(function step(t){
			var p = clamp((t - start) / dur, 0, 1);
			var v = Math.round(from + (to - from) * (1 - Math.pow(1 - p, 3)));
			el.textContent = v;
			if (p < 1) requestAnimationFrame(step);
		})(start);
	}

	/* ---------- History ---------- */
	var HKEY = 'fcp_history_v1';
	function loadHistory(){
		try { return JSON.parse(localStorage.getItem(HKEY) || '[]'); } catch(e){ return []; }
	}
	function saveHistory(arr){
		try { localStorage.setItem(HKEY, JSON.stringify(arr.slice(0, 8))); } catch(e){}
	}
	function saveToHistory(letter, names, scores){
		var arr = loadHistory();
		arr.unshift({ l: letter, a: names.n1, b: names.n2, s: scores ? scores.total : null, t: Date.now() });
		saveHistory(arr);
		renderHistory();
	}
	function renderHistory(){
		if (ROOT.dataset.history !== '1') return;
		var arr = loadHistory();
		var box = $('.fcp-history'), list = $('.fcp-hist-list');
		if (!box || !list) return;
		if (!arr.length){ hide(box); return; }
		show(box);
		list.innerHTML = '';
		arr.forEach(function(it){
			var li = document.createElement('li');
			var nm = capWords(it.a) + ' × ' + capWords(it.b);
			var lbl = RESULT[it.l] ? RESULT[it.l].name[lang] : it.l;
			li.innerHTML = '<span>'+ escapeHtml(nm) +'</span> <b>'+ escapeHtml(lbl) + (it.s ? ' · '+it.s+'%' : '') +'</b>';
			list.appendChild(li);
		});
	}
	function escapeHtml(s){ return (s||'').replace(/[&<>"']/g, function(c){ return ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'})[c]; }); }

	/* ---------- Share ---------- */
	function shareResult(){
		var st = ROOT._fcpState; if (!st) return;
		var data = RESULT[st.letter];
		var txt = capWords(st.names.n1) + ' × ' + capWords(st.names.n2) + ' → ' + data.emoji + ' ' + data.name[lang] + (st.scores ? ' (' + st.scores.total + '%)' : '');
		if (navigator.share){
			navigator.share({ title: I18N[lang].title, text: txt, url: location.href }).catch(function(){});
		} else {
			navigator.clipboard && navigator.clipboard.writeText(txt + ' — ' + location.href);
			toast(I18N[lang].copy_done);
		}
	}

	function downloadCard(){
		var st = ROOT._fcpState; if (!st) return;
		var data = RESULT[st.letter];
		var canvas = $('.fcp-share-canvas'); var ctx = canvas.getContext('2d');
		var W = canvas.width, H = canvas.height;
		var grad = ctx.createLinearGradient(0,0,W,H);
		grad.addColorStop(0, '#0a0420'); grad.addColorStop(1, '#1c0a3e');
		ctx.fillStyle = grad; ctx.fillRect(0,0,W,H);
		var rg = ctx.createRadialGradient(W*0.7, H*0.3, 0, W*0.7, H*0.3, W*0.6);
		rg.addColorStop(0, data.c1 + 'aa'); rg.addColorStop(1, 'transparent');
		ctx.fillStyle = rg; ctx.fillRect(0,0,W,H);
		ctx.fillStyle = '#ffffff';
		ctx.font = 'bold 56px system-ui, sans-serif'; ctx.textAlign='center';
		ctx.fillText(I18N[lang].title, W/2, 130);
		ctx.font = '36px system-ui, sans-serif'; ctx.fillStyle='rgba(255,255,255,0.85)';
		ctx.fillText(capWords(st.names.n1) + '   ×   ' + capWords(st.names.n2), W/2, 220);
		ctx.font = 'bold 380px system-ui, sans-serif';
		var lg = ctx.createLinearGradient(0, 300, 0, 700);
		lg.addColorStop(0, data.c1); lg.addColorStop(1, data.c2);
		ctx.fillStyle = lg; ctx.fillText(st.letter, W/2, 700);
		ctx.fillStyle = '#fff'; ctx.font = 'bold 64px system-ui, sans-serif';
		ctx.fillText(data.emoji + ' ' + data.name[lang], W/2, 820);
		if (st.scores){
			ctx.font = 'bold 42px system-ui, sans-serif'; ctx.fillStyle = '#FFD23F';
			ctx.fillText('Compatibility ' + st.scores.total + '%', W/2, 900);
		}
		ctx.font = '28px system-ui, sans-serif'; ctx.fillStyle = 'rgba(255,255,255,0.5)';
		ctx.fillText(location.host, W/2, 1020);
		var link = document.createElement('a');
		link.download = 'flames-result.png';
		link.href = canvas.toDataURL('image/png');
		link.click();
	}

	function toast(msg){
		var t = document.createElement('div');
		t.textContent = msg;
		t.style.cssText = 'position:fixed;left:50%;bottom:24px;transform:translateX(-50%);background:rgba(20,6,46,0.95);color:#fff;padding:10px 18px;border-radius:12px;font-family:system-ui,sans-serif;font-size:14px;z-index:99999;box-shadow:0 12px 30px rgba(0,0,0,0.4);border:1px solid rgba(255,255,255,0.18)';
		document.body.appendChild(t);
		setTimeout(function(){ t.style.transition='opacity .35s'; t.style.opacity='0'; setTimeout(function(){ t.remove(); }, 400); }, 1800);
	}

	/* ---------- Submit handler ---------- */
	function onSubmit(e){
		if (e) e.preventDefault();
		setError('');
		var n1raw = $('.fcp-name1').value.trim();
		var n2raw = $('.fcp-name2').value.trim();
		var n1 = cleanName(n1raw), n2 = cleanName(n2raw);
		if (!n1 || !n2) return setError(I18N[lang].err_required);
		if (n1.length < 2 || n2.length < 2) return setError(I18N[lang].err_short);
		if (n1 === n2) return setError(I18N[lang].err_same);

		var dob1 = $('.fcp-dob1') ? $('.fcp-dob1').value : '';
		var dob2 = $('.fcp-dob2') ? $('.fcp-dob2').value : '';
		if (mode === 'advanced' && (!dob1 || !dob2)) return setError(I18N[lang].err_dob);

		// Phase 1: loading
		var inputCard = $('.fcp-input-card'), loadCard = $('.fcp-loading-card'), resultCard = $('.fcp-result-card');
		hide(inputCard); show(loadCard); hide(resultCard);
		hide($('.fcp-advice')); hide($('.fcp-premium'));
		var midAd = ROOT.querySelector('.fcp-ad-mid'); if (midAd) hide(midAd);

		var bar = $('.fcp-progress-bar'), txt = $('.fcp-load-txt');
		bar.style.width = '0%';
		var steps = [I18N[lang].step1, I18N[lang].step2, I18N[lang].step3, I18N[lang].step4];
		var i = 0;
		txt.textContent = steps[0];
		var tk = setInterval(function(){
			i++; if (i >= steps.length){ clearInterval(tk); return; }
			txt.textContent = steps[i];
			bar.style.width = ((i+1) * 25) + '%';
		}, 380);

		// Compute
		var marks = computeElim(n1, n2);
		var letter = flamesLetter(marks.remaining || 1);

		setTimeout(function(){
			clearInterval(tk); bar.style.width = '100%';
			hide(loadCard); show(resultCard);

			// Animations
			renderElim(n1, n2, marks, function(){
				spinWheel(marks.remaining || 1, letter, function(){
					var scores = null;
					if (mode === 'advanced'){
						var nm  = numerologyMatch(nameNum(n1), nameNum(n2));
						var z1  = zodiacFromDate(dob1), z2 = zodiacFromDate(dob2);
						var zs  = zodiacScore(z1, z2);
						var ovr = nameOverlap(n1, n2);
						var fb  = RESULT[letter].base;
						var total = Math.round(fb*0.4 + nm*0.25 + zs*0.25 + ovr*0.10);
						total = clamp(total, 48, 99);
						scores = { numerology: nm, zodiac: zs, name: ovr, flames: fb, total: total };
					}
					showResult(letter, { n1: n1raw, n2: n2raw }, scores);
				});
			});
		}, 1700);
	}

	/* ---------- Bind ---------- */
	$('.fcp-form').addEventListener('submit', onSubmit);

	$('.fcp-act-again').addEventListener('click', function(){
		hide($('.fcp-result-card'));
		hide($('.fcp-advice'));
		hide($('.fcp-premium'));
		var midAd = ROOT.querySelector('.fcp-ad-mid'); if (midAd) hide(midAd);
		show($('.fcp-input-card'));
		setError('');
		ROOT.scrollIntoView({ behavior: 'smooth', block: 'start' });
	});
	$('.fcp-act-share').addEventListener('click', shareResult);
	$('.fcp-act-card').addEventListener('click', downloadCard);
	$('.fcp-act-save').addEventListener('click', function(){
		var st = ROOT._fcpState; if (!st) return;
		saveToHistory(st.letter, st.names, st.scores);
		toast(I18N[lang].save_done);
	});

	$$('.fcp-adv-tab').forEach(function(btn){
		btn.addEventListener('click', function(){
			$$('.fcp-adv-tab').forEach(function(b){ b.classList.remove('is-on'); });
			$$('.fcp-adv-card').forEach(function(c){ c.classList.remove('is-on'); });
			btn.classList.add('is-on');
			var pane = btn.getAttribute('data-tab');
			var card = $('.fcp-adv-card[data-pane="'+pane+'"]');
			if (card) card.classList.add('is-on');
		});
	});

	// Advanced toggle
	var advTgl = $('.fcp-adv-toggle');
	if (advTgl){
		advTgl.addEventListener('change', function(){
			mode = advTgl.checked ? 'advanced' : 'basic';
			ROOT.dataset.mode = mode;
		});
	}

	// Language toggle
	$$('.fcp-lang-btn').forEach(function(btn){
		btn.addEventListener('click', function(){
			$$('.fcp-lang-btn').forEach(function(b){ b.classList.remove('is-on'); });
			btn.classList.add('is-on');
			lang = btn.getAttribute('data-lang') === 'hi' ? 'hi' : 'en';
			ROOT.dataset.lang = lang;
			applyI18n();
			renderHistory();
			// If a result exists, refresh its language
			var st = ROOT._fcpState;
			if (st){
				var data = RESULT[st.letter];
				$('.fcp-result-name').textContent = data.emoji + ' ' + data.name[lang];
				$('.fcp-result-tag').textContent  = data.tag[lang];
				var content = data.content[lang];
				fillAdvice('golden', content.golden);
				fillAdvice('protip', content.protip);
				fillAdvice('life',   content.life);
				fillAdvice('boost',  content.boost);
				fillAdvice('next',   content.next);
			}
		});
	});

	// Sound toggle
	var sndBtn = $('.fcp-sound-btn');
	if (sndBtn){
		sndBtn.addEventListener('click', function(){
			soundOn = !soundOn;
			ROOT.dataset.sound = soundOn ? '1' : '0';
		});
	}

	// History clear
	var hcBtn = $('.fcp-hist-clear');
	if (hcBtn){
		hcBtn.addEventListener('click', function(){
			saveHistory([]); renderHistory();
		});
	}

	// Init
	applyI18n();
	renderHistory();

})();
</script>
		<?php
	}
}
