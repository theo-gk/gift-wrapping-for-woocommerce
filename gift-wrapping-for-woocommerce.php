<?php
/**
 * Plugin Name:       Gift Wrapping for WooCommerce
 * Description:       Allow customers to select a gift wrapper for their order.
 * Version:           1.1
 * Stable tag:        1.1
 * Author:            Pexle Chris, Theo Gkitsos
 * Text Domain:       gift-wrapping-for-woocommerce
 * Domain Path:       /languages
 *
 * Requires at least: 5.3
 * Tested up to: 6.1.1
 * Requires PHP: 5.6
 * WC requires at least: 5.5.0
 * WC tested up to: 7.1.0
 *
 * License:           GPLv2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.html
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Plugin's constants.
 */
define( 'GIFT_WRAPPING_FOR_WOOCOMMERCE_VERSION', '1.1' );
define( 'GIFT_WRAPPING_FOR_WOOCOMMERCE_PLUGIN_FILE', __FILE__);
define( 'GIFT_WRAPPING_FOR_WOOCOMMERCE_PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );
define( 'GIFT_WRAPPING_FOR_WOOCOMMERCE_PLUGIN_DIR', dirname( __FILE__ ) );
define( 'GIFT_WRAPPING_FOR_WOOCOMMERCE_BASE_FILE', 'gift-wrapping-for-woocommerce/gift-wrapping-for-woocommerce.php' );
define( 'GIFT_WRAPPING_FOR_WOOCOMMERCE_SLUG', 'gift-wrapping-for-woocommerce' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-gift-wrapping-for-woocommerce-activator.php
 */
function activate_tgpc_wc_gift_wrap() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-gift-wrapping-for-woocommerce-activator.php';
	Tgpc_Wc_Gift_Wrap_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-gift-wrapping-for-woocommerce-deactivator.php
 */
function deactivate_tgpc_wc_gift_wrap() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-gift-wrapping-for-woocommerce-deactivator.php';
	Tgpc_Wc_Gift_Wrap_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_tgpc_wc_gift_wrap' );
register_deactivation_hook( __FILE__, 'deactivate_tgpc_wc_gift_wrap' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-gift-wrapping-for-woocommerce.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0
 */
function run_tgpc_wc_gift_wrap() {

	$plugin = new Tgpc_Wc_Gift_Wrap();
	$plugin->run();
}


/**
 * If WooCommerce is inactive, this plugin is not executed.
 */
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	run_tgpc_wc_gift_wrap();
}


