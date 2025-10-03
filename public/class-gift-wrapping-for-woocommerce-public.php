<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @package    Tgpc_Wc_Gift_Wrap
 * @subpackage Tgpc_Wc_Gift_Wrap/public
 */

class Tgpc_Wc_Gift_Wrap_Public {

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
	 * @param string $version The version of this plugin.
	 */
	public function __construct( string $plugin_name, string $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Add gift wrapper checkbox input on checkout page.
	 *
	 * @param $checkout WC_Checkout
	 *
	 * @since 1.1 Remove input for virtual orders
	 */
	public function tgpc_add_gift_checkbox_on_checkout( $checkout ) {

		$cart = WC()->cart;
		if ( ! is_a( $cart, 'WC_Cart' ) || ! $cart->needs_shipping() ) return;

		$inline_style  = 'display: inline-block; margin-right: 4px;';
		$width         = '17px';
		$height        = '17px';
		$img_class     = 'tgpc-enable-checkout-gift-wrapper--label_icon';
		$gift_icon_url = '';

		/**
		 * Gift wrapper icon's url.
		 *
		 * This filter determines the url of the icon that will be used.
		 * If is empty, the default svg icon will be used.
		 * This filter will be also used for gift wrapper in order list in Dashboard.
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
		 * This filter will be also used for gift wrapper in order list in Dashboard.
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

		$label_text = get_option( 'tgpc_gift_wrapper_checkbox_label', __( 'Gift wrapper', 'gift-wrapping-for-woocommerce' ) );

		$label = $label_icon . '<span class="tgpc-enable-checkout-gift-wrapper--label_text">' . wp_kses_post( $label_text ) . '</span>';

		/**
		 * The checkout label filter.
		 *
		 * With this filter, you can alter the label.
		 *
		 * @param string $label      The input label as html.
		 * @param string $label_text The escaped text of the label.
		 *
		 * @since 1.0
		 */
		$label = apply_filters( 'tgpc_wc_gift_wrapper_checkout_label', $label, $label_icon, $label_text );

		$saved_cost     = WC()->session->get( 'tgpc_gw_cost', false );
		$checkbox_state = false === $saved_cost ? 0 : 1;

		do_action( 'tgpc_wc_gift_wrapper_checkout_field_before' );

		/**
		 * Since WC 8.7.0, the <label> content is cleaned with `wp_kses_post`, so the default SVG icon is stripped away.
		 * So we temporarily allow svg using the following filter.
		 * After label is printed, we remove the filter to restore the original `wp_kses_post` functionality.
		 *
		 * @since 1.2.2
		 */
		add_filter( 'wp_kses_allowed_html', [ $this, 'add_svg_to_allowed_tags_for_label' ], 10, 2 );

		woocommerce_form_field( 'tgpc_enable_checkout_gift_wrapper', [
			'type'     => 'checkbox',
			'label'    => $label,
			'required' => false,
			'class'    => [ 'form-row-wide', 'update_totals_on_change' ],
		], $checkbox_state );

		remove_filter( 'wp_kses_allowed_html', [ $this, 'add_svg_to_allowed_tags_for_label' ] );

		do_action( 'tgpc_wc_gift_wrapper_checkout_field_after' );
	}

	/**
	 * Add the fee to cart totals.
	 * Also saves checkbox value to session.
	 */
	public function tgpc_add_gift_wrapper_fee(): void {

		if ( is_admin() && ! wp_doing_ajax() ) return;
		if ( empty( $_POST ) ) return;

		$post_data = [];

		if ( isset( $_POST['post_data'] ) ) {
			parse_str( $_POST['post_data'], $post_data );
		}

		if ( ! empty( $post_data['tgpc_enable_checkout_gift_wrapper'] )
		     || ! empty( $_POST['tgpc_enable_checkout_gift_wrapper'] ) ) {

			$fee_name   = esc_html__( 'Gift wrapper', 'gift-wrapping-for-woocommerce' );
			$fee_cost   = (float) apply_filters( 'tgpc_wc_gift_wrapper_cost', get_option( 'tgpc_gift_wrapper_cost', 0 ) );
			$is_taxable = 'yes' === get_option( 'tgpc_gift_wrapper_cost_tax_status' );
			$tax_class  = get_option( 'tgpc_gift_wrapper_tax_class', '' );

			WC()->cart->add_fee( $fee_name, $fee_cost, $is_taxable, $tax_class );

			WC()->session->set( 'tgpc_gw_cost', $fee_cost );
			WC()->session->set( 'tgpc_gw_name', $fee_name );
		}
		else {
			WC()->session->set( 'tgpc_gw_cost', false );
		}
	}

	/**
	 * Save checkbox value to order data.
	 *
	 * @param WC_Abstract_Order $order The order object.
	 */
	public function tgpc_save_gift_wrapper_option_to_order_meta( $order ): void {

		if ( ! empty( $_POST['tgpc_enable_checkout_gift_wrapper'] ) ) {
			$cost = WC()->session->get( 'tgpc_gw_cost' );
			$name = WC()->session->get( 'tgpc_gw_name' );
			$order->add_meta_data( '_tgpc_gift_wrapper', [ 'cost' => $cost, 'name' => $name ] );
		}
	}

	/**
	 * Hook that enables the display fee in emails.
	 *
	 * By default, when the fee cost is 0, the cart fee is not displayed.
	 * With this hook, we allow to display the gift wrapper fee in the emails,
	 * using the hook `woocommerce_get_order_item_totals_excl_free_fees`.
	 *
	 * @param WC_Order_Item[]   $items An array of items/products within this order.
	 * @param WC_Abstract_Order $order The order object.
	 * @param array             $types Types of line items.
	 *
	 * @return array The fees variable that isn't changed.
	 */
	public function tgpc_show_fee_even_if_gift_wrapper_cost_is_0( array $items, WC_Abstract_Order $order, array $types ): array {

		if ( ! in_array( 'fee', $types ) ) return $items;

		$tgpc_gift_wrapper = $order->get_meta( '_tgpc_gift_wrapper' );

		if ( ! empty( $tgpc_gift_wrapper ) && is_array( $tgpc_gift_wrapper ) ) {
			$saved_cost = $tgpc_gift_wrapper['cost'];
			$saved_name = $tgpc_gift_wrapper['name'];

			if ( 0 == $saved_cost ) {
				foreach ( $items as $fee_id => $fee ) {
					if ( $saved_name == $fee->get_name() ) {
						add_filter( 'woocommerce_get_order_item_totals_excl_free_fees', function( $bool, $id ) use ( $fee_id ) {
							if ( $id == $fee_id ) {
								$bool = false;
							}

							return $bool;
						}, 10, 2 );
						break;
					}
				}
			}
		}

		return $items;
	}

	/**
	 * Stop `wp_kses_post` from stripping away SVGs.
	 *
	 * @param array  $tags    Allowed tags and attributes.
	 * @param string $context Content context.
	 *
	 * @return array
	 * @since 1.2.2
	 */
	function add_svg_to_allowed_tags_for_label( array $tags, string $context ): array {

		if ( 'post' !== $context ) return $tags;

		$tags['svg'] = [
			'xmlns'       => [],
			'width'       => [],
			'height'      => [],
			'style'       => [],
			'class'       => [],
			'fill'        => [],
			'viewbox'     => [],
			'viewBox'     => [],
			'role'        => [],
			'aria-hidden' => [],
			'focusable'   => [],
			'version'     => [],
		];

		$tags['path'] = [
			'd'    => [],
			'fill' => [],
		];

		return $tags;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @param string $hook
	 */
	public function enqueue_styles( string $hook ) {}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @param string $hook
	 */
	public function enqueue_scripts( string $hook ) {}
}
