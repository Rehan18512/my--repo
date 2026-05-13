<?php
/**
 * Plugin Name: Cosmic Calculators Pro - Friendship, Mulank & Crush
 * Plugin URI:  https://cosmiccalculators.in
 * Description: Three premium bilingual (English + हिंदी) calculators in one plugin: Friendship Calculator (by name), Mulank/Bhagyank Numerology Calculator (by birthdate), and Crush Calculator. Animated, SEO-optimized, golden hints, personalized advice, career/pet/song predictions, horoscope &amp; soulmate insights, language toggle. Shortcodes: [friendship_calculator] [mulank_calculator] [crush_calculator]
 * Version:     1.1.0
 * Author:      Cosmic Calculators
 * Author URI:  https://cosmiccalculators.in
 * License:     GPL-2.0+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: cosmic-calculators-pro
 * Requires at least: 5.0
 * Requires PHP: 7.2
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'CCP_VERSION', '1.1.0' );
define( 'CCP_PATH', plugin_dir_path( __FILE__ ) );
define( 'CCP_URL', plugin_dir_url( __FILE__ ) );

require_once CCP_PATH . 'includes/friendship-calculator.php';
require_once CCP_PATH . 'includes/mulank-calculator.php';
require_once CCP_PATH . 'includes/crush-calculator.php';

add_shortcode( 'friendship_calculator', 'ccp_render_friendship_calculator' );
add_shortcode( 'mulank_calculator',     'ccp_render_mulank_calculator' );
add_shortcode( 'crush_calculator',      'ccp_render_crush_calculator' );

/**
 * Optional: add a tiny admin notice with shortcodes after activation so admins know what to use.
 */
add_action( 'admin_notices', 'ccp_activation_notice' );
function ccp_activation_notice() {
    if ( get_transient( 'ccp_activated' ) ) {
        delete_transient( 'ccp_activated' );
        echo '<div class="notice notice-success is-dismissible"><p><strong>Cosmic Calculators Pro activated!</strong> Use the shortcodes <code>[friendship_calculator]</code>, <code>[mulank_calculator]</code>, and <code>[crush_calculator]</code> on any page or post.</p></div>';
    }
}

register_activation_hook( __FILE__, 'ccp_on_activate' );
function ccp_on_activate() {
    set_transient( 'ccp_activated', 1, 60 );
}
