<?php
/**
 * Plugin Name: Calculator Tools Suite
 * Plugin URI: https://lovecalculator.in
 * Description: Three premium, animated, SEO-friendly calculators in one plugin — Friendship Calculator, Mulank & Bhagyank Calculator, and Crush Calculator. Hindi + English, Advanced mode, golden hints, personalized advice, share + downloadable result cards. Shortcodes: [friendship_calculator], [mulank_calculator], [crush_calculator].
 * Version: 1.0.0
 * Author: lovecalculator.in
 * Author URI: https://lovecalculator.in
 * License: GPL-2.0+
 * Text Domain: calculator-tools-suite
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'CTS_VERSION', '1.0.0' );
define( 'CTS_DIR', plugin_dir_path( __FILE__ ) );

/**
 * Load all components.
 */
require_once CTS_DIR . 'includes/shared.php';
require_once CTS_DIR . 'includes/friendship.php';
require_once CTS_DIR . 'includes/mulank.php';
require_once CTS_DIR . 'includes/crush.php';
