<?php

use Automattic\WooCommerce\StoreApi\StoreApi;
use Automattic\WooCommerce\StoreApi\Schemas\ExtendSchema;
use Automattic\WooCommerce\StoreApi\Schemas\V1\CheckoutSchema;

class Tgpc_Gift_Wrapping_Checkout_Block {

	/**
	 * The ID of this plugin.
	 *
	 * @var string $plugin_name The ID of this plugin.
	 */
	private string $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @var string $version The current version of this plugin.
	 */
	private string $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $plugin_name The name of the plugin.
	 * @param string $version     The version of this plugin.
	 */
	public function __construct( string $plugin_name, string $version ) {

		// $this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	public function register_checkout_block(): void {

		require_once 'class-gift-wrapping-checkout-block-integration.php';

		add_action(
			'woocommerce_blocks_checkout_block_registration',
			function( $integration_registry ) {
				$integration_registry->register( new Tgpc_Gift_Wrapping_Checkout_Block_Integration( $this->version ) );
			}
		);

		if ( function_exists( 'woocommerce_store_api_register_endpoint_data' ) ) {
			woocommerce_store_api_register_endpoint_data(
				[
					'endpoint'        => CheckoutSchema::IDENTIFIER,
					'namespace'       => 'gift-wrapping-checkout-block',
					'data_callback'   => [ $this, 'cb_data_callback' ],
					'schema_callback' => [ $this, 'cb_schema_callback' ],
					'schema_type'     => ARRAY_A,
				]
			);
		}
	}

	/**
	 * Callback function to register endpoint data for blocks.
	 *
	 * @return array
	 */
	function cb_data_callback(): array {
		return [
			'tgpc_enable_checkout_gift_wrapper' => '',
		];
	}

	/**
	 * Callback function to register schema for data.
	 *
	 * @return array
	 */
	function cb_schema_callback(): array {
		return [
			'tgpc_enable_checkout_gift_wrapper' => [
				'description' => __( 'Gift Wrapping', 'gift-wrapping-for-woocommerce' ),
				'type'        => [ 'string', 'null' ],
				'readonly'    => true,
			],
		];
	}
}