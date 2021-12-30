<?php
/**
 * The plugin bootstrap file
 *
 * @link              https://www.xzy.gr/
 * @since             1.0.0
 * @package           Tgpc_Wc_Gift_Wrap
 *
 * @wordpress-plugin
 * Plugin Name:       Gift Wrapper for WooCommerce
 * Plugin URI:        https://www.xzy.gr/
 * Description:       Plugin description
 * Version:           2.1
 * Author:            xzy
 * Author URI:        https://www.xzy.gr/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       tgpc-wc-gift-wrap
 * Domain Path:       /languages
 * Requires at least: 5.3
 * Tested up to:      5.8.2
 * Stable tag:        1.0
 * WC requires at least: 4.6.0
 * WC tested up to:   6.0.0
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 */
define( 'TGPC_WC_GIFT_WRAP_VERSION', '1.0' );
define ('TGPC_WC_GIFT_WRAP_PLUGIN_FILE', __FILE__);
define( 'TGPC_WC_GIFT_WRAP_PLUGIN_DIR_URL', plugin_dir_url( __file__ ));
define( 'TGPC_WC_GIFT_WRAP_PLUGIN_DIR', dirname(__FILE__) . '' );
define( 'TGPC_WC_GIFT_WRAP_BASE_FILE', 'tgpc-wc-gift-wrap/tgpc-wc-gift-wrap.php' );
define( 'TGPC_WC_GIFT_WRAP_SLUG', 'tgpc-wc-gift-wrap' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-tgpc-wc-gift-wrap-activator.php
 */
function activate_tgpc_wc_gift_wrap() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-tgpc-wc-gift-wrap-activator.php';
	Tgpc_Wc_Gift_Wrap_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-tgpc-wc-gift-wrap-deactivator.php
 */
function deactivate_tgpc_wc_gift_wrap() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-tgpc-wc-gift-wrap-deactivator.php';
	Tgpc_Wc_Gift_Wrap_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_tgpc_wc_gift_wrap' );
register_deactivation_hook( __FILE__, 'deactivate_tgpc_wc_gift_wrap' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-tgpc-wc-gift-wrap.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_tgpc_wc_gift_wrap() {

	$plugin = new Tgpc_Wc_Gift_Wrap();
	$plugin->run();

}
run_tgpc_wc_gift_wrap();
