<?php

use Automattic\WooCommerce\Blocks\Integrations\IntegrationInterface;

class Tgpc_Gift_Wrapping_Checkout_Block_Integration implements IntegrationInterface {

	/**
	 * The version of this plugin.
	 *
	 * @var string $version
	 */
	private string $version;

	/**
	 * The URL of the block assets.
	 *
	 * @var string $block_assets_url
	 */
	private string $block_assets_url;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $version     The version of this plugin.
	 */
	public function __construct( string $version ) {
		$this->version          = $version;
		$this->block_assets_url = plugins_url( GIFT_WRAPPING_FOR_WOOCOMMERCE_SLUG . '/blocks/gift-wrapping-checkout-block/build/' );
	}

	/**
	 * When called invokes any initialization/setup for the integration.
	 */
	public function initialize(): void {
		$this->register_block_frontend_scripts();
		$this->register_block_editor_scripts();
	}

	/**
	 * Returns an array of script handles to enqueue in the frontend context.
	 *
	 * @return string[]
	 */
	public function get_script_handles(): array {
		return [ $this->get_name() . '-frontend' ];
	}

	/**
	 * Returns an array of script handles to enqueue in the editor context.
	 *
	 * @return string[]
	 */
	public function get_editor_script_handles(): array {
		return [ $this->get_name() . '-editor' ];
	}

	/**
	 * An array of key, value pairs of data made available to the block on the client side.
	 *
	 * @return array
	 */
	public function get_script_data(): array {
		return [];
	}

	/**
	 * Register scripts for delivery date block editor.
	 *
	 * @return void
	 */
	public function register_block_editor_scripts(): void {
		$script_url        = $this->block_assets_url . 'index.js';
		$script_asset_path = $this->block_assets_url . 'index.asset.php';
		$script_asset      = file_exists( $script_asset_path )
			? require $script_asset_path
			: [
				'dependencies' => [],
				'version'      => $this->get_file_version(),
			];

		wp_register_script(
			$this->get_name() . '-editor',
			$script_url,
			$script_asset['dependencies'],
			$script_asset['version'],
			true
		);
	}

	/**
	 * Register scripts for frontend block.
	 *
	 * @return void
	 */
	public function register_block_frontend_scripts(): void {
		$script_url        = $this->block_assets_url . 'gift-wrapping-checkout-block-frontend.js';
		$script_asset_path = $this->block_assets_url . 'gift-wrapping-checkout-block-frontend.asset.php';

		$script_asset = file_exists( $script_asset_path )
			? require $script_asset_path
			: [
				'dependencies' => [],
				'version'      => $this->get_file_version(),
			];

		wp_register_script(
			$this->get_name() . '-frontend',
			$script_url,
			$script_asset['dependencies'],
			$script_asset['version'],
			true
		);
	}

	/**
	 * The name of the integration.
	 *
	 * @return string
	 */
	public function get_name(): string {
		return 'gift-wrapping-checkout-block';
	}

	/**
	 * Get the file modified time as a cache buster if we're in dev mode.
	 *
	 * @return string The file version.
	 */
	protected function get_file_version(): string {

		return defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? $this->version . time() : $this->version;
	}
}