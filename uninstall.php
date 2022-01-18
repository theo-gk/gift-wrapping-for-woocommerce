<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @since      1.0
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

delete_option( 'tgpc_gift_wrapper_enabled' );
delete_option( 'tgpc_gift_wrapper_cost' );
delete_option( 'tgpc_gift_wrapper_cost_tax_status' );
delete_option( 'tgpc_gift_wrapper_tax_class' );
delete_option( 'tgpc_gift_wrapper_location' );
