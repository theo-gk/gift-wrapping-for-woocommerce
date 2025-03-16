<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Tgpc_Wc_Gift_Wrap
 * @subpackage Tgpc_Wc_Gift_Wrap/admin
 */
class Tgpc_Wc_Gift_Wrap_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @var string $plugin_name
	 */
	private string $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @var string $version
	 */
	private string $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $plugin_name The name of this plugin.
	 * @param string $version The version of this plugin.
	 */
	public function __construct( string $plugin_name, string $version ) {

		// $this->plugin_name = $plugin_name;
		// $this->version = $version;
	}

	/**
	 * Adds the settings tab in the WooCommerce settings page.
	 *
	 * @param array $settings
	 *
	 * @return array
	 */
    function tgpc_wc_gift_wrap_add_settings_tab( array $settings ): array {
        $settings[] = include GIFT_WRAPPING_FOR_WOOCOMMERCE_PLUGIN_DIR . '/admin/class-gift-wrapping-for-woocommerce-settings.php';
        return $settings;
    }

	/**
	 * Adds a gift box icon in the admin order page if an order has gift wrapper selected.
	 *
	 * @param string   $column The Column ID.
	 * @param WC_Order $order  The order object.
	 */
	function dc_add_gift_icon_to_order_notes_column( string $column, WC_Order $order ): void {

		if ( 'order_number' === $column ) {

		    if ( $order->meta_exists( '_tgpc_gift_wrapper' ) ) {

			    $inline_style  = 'display: inline-block; vertical-align: text-bottom; margin-left: 4px;';
			    $width         = '17px';
			    $height        = '17px';
			    $img_class     = 'tgpc-order-list-gift-wrapper--label_icon';
			    $gift_icon_url = '';

			    /**
			     * Gift wrapper icon's url.
			     *
			     * This filter determines the url of the icon that will be used.
			     * If is empty, the default svg icon will be used.
			     * This filter will be also used for gift wrapper in checkout.
			     *
			     * @param string $gift_icon_url The gift icon's url. Default is empty.
			     *
			     * @since 1.0
			     */
			    $gift_icon_url = apply_filters( 'tgpc_wc_gift_wrapper_icon_url', $gift_icon_url );

			    if ( empty( $gift_icon_url ) ) {
				    $label_icon = '<svg class="' . $img_class . '" width="' . $width . '" height="' . $height . '" style="' . $inline_style . '" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" viewBox="0 0 24 24"><path d="M22,12V20A2,2 0 0,1 20,22H4A2,2 0 0,1 2,20V12A1,1 0 0,1 1,11V8A2,2 0 0,1 3,6H6.17C6.06,5.69 6,5.35 6,5A3,3 0 0,1 9,2C10,2 10.88,2.5 11.43,3.24V3.23L12,4L12.57,3.23V3.24C13.12,2.5 14,2 15,2A3,3 0 0,1 18,5C18,5.35 17.94,5.69 17.83,6H21A2,2 0 0,1 23,8V11A1,1 0 0,1 22,12M4,20H11V12H4V20M20,20V12H13V20H20M9,4A1,1 0 0,0 8,5A1,1 0 0,0 9,6A1,1 0 0,0 10,5A1,1 0 0,0 9,4M15,4A1,1 0 0,0 14,5A1,1 0 0,0 15,6A1,1 0 0,0 16,5A1,1 0 0,0 15,4M3,8V10H11V8H3M13,8V10H21V8H13Z" /></svg>';
			    }
			    else {
				    $label_icon = '<img src="' . esc_url( $gift_icon_url ) . '" class="' . $img_class . '" style="' . $inline_style . '" width="' . $width . '" height="' . $height . '" alt="" >';
			    }

			    /**
			     * Gift wrapper icon's html.
			     *
			     * With this filter, you can alter the html of the gift wrapper icon.
			     * This filter will be also used for gift wrapper in checkout.
			     * USE CASES
			     * - If $gift_icon_url is not set above, the icon is <svg>.
			     * - If $gift_icon_url is set above, the icon is <img>.
			     * - if $label_icon is an empty string, icon isn't printed
			     *
			     * @param string $label_icon   The html of the icon.
			     * @param string $img_class    The class of the html tag, svg or img.
			     * @param string $width        The width the html tag, svg or img.
			     * @param string $height       The height of the html tag, svg or img.
			     * @param string $inline_style The inline style of the icon.
			     *
			     * @since 1.0
			     */
			    $label_icon = apply_filters( 'tgpc_wc_gift_wrapper_icon_html', $label_icon, $img_class, $width, $height, $inline_style );

			    if ( ! empty( $label_icon ) ) {
				    echo $label_icon;
			    }
		    }
        }
    }

	/**
	 * Adds a gift box icon in the admin order page if an order has gift wrapper selected.
	 * For stores without HPOS enabled.
	 *
	 * @param string $column The Column ID.
	 *
	 * @return void
	 */
	function dc_add_gift_icon_to_order_notes_column_before_hpos( string $column ): void {

		global $the_order;

		$this->dc_add_gift_icon_to_order_notes_column( $column, $the_order );
	}

	/**
	 * Add Settings link in plugin page.
	 *
	 * @param array  $actions     The actions array.
	 * @param string $plugin_file Path to the plugin file relative to the 'plugins' directory.
	 *
	 * @return array The actions array.
	 */
	function add_plugin_action_links( array $actions, string $plugin_file ): array {

		if ( $plugin_file === GIFT_WRAPPING_FOR_WOOCOMMERCE_BASE_FILE ) {

			$settings_link = [
				'settings' => sprintf( '<a href="%1$s">%2$s</a>',
					esc_url( admin_url( 'admin.php?page=wc-settings&tab=tgpc_wc_gift_wrap' ) ),
					esc_html__( 'Settings', 'gift-wrapping-for-woocommerce' )
				)
			];

			$actions = array_merge( $settings_link, $actions );
		}

		return $actions;
	}

	/**
	 * Declare compatibility with WooCommerce Features (HPOS, Cart & Checkout Blocks)
	 *
	 * @return void
	 * @since 1.1
	 */
	function declare_compatibility_with_wc_features(): void {
		if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
			\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', GIFT_WRAPPING_FOR_WOOCOMMERCE_PLUGIN_FILE );
			\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'cart_checkout_blocks', GIFT_WRAPPING_FOR_WOOCOMMERCE_PLUGIN_FILE ); // todo
		}
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @param string $hook
	 */
	public function enqueue_styles( string $hook ): void {}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @param string $hook
	 */
	public function enqueue_scripts( string $hook ): void {}
}