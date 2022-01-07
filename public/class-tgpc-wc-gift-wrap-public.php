<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.dicha.gr/
 * @since      1.0
 *
 * @package    Tgpc_Wc_Gift_Wrap
 * @subpackage Tgpc_Wc_Gift_Wrap/public
 */

class Tgpc_Wc_Gift_Wrap_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/tgpc-wc-gift-wrap-public.css', array(), $this->version .time() );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0
	 */
	public function enqueue_scripts() {

        if ( is_checkout() ) {

            $script_data = [
                'xzy' => '',
            ];

            wp_register_script( 'tgpc-wc-gift-wrap-checkout', plugin_dir_url(__FILE__) . 'js/tgpc-wc-gift-wrap-public.js', array('jquery'), $this->version . time(), true );
            wp_localize_script( 'tgpc-wc-gift-wrap-checkout', 'script_data', $script_data );
            wp_enqueue_script( 'tgpc-wc-gift-wrap-checkout' );
        }

	}

	public function tgpc_add_gift_checkbox_on_checkout( $checkout ) {

		$inline_style  = 'display: inline-block; vertical-align: text-bottom; margin-right: 4px;';
		$width = '17px';
		$height = '17px';
		$img_class = 'tgpc-enable-checkout-gift-wrapper--label_icon';


		$gift_icon_url = '';

		/**
		 * Gift wrapper icon's url.
		 *
		 * This filter determines the url of the icon that will be used.
		 * If is empty, the default svg icon will be used.
		 *
		 * @since 1.0.0
		 *
		 * @param string $gift_icon_url The gift icon's url. Default is empty.
		 */
		$gift_icon_url = apply_filters( 'tgpc_wc_gift_wrapper_icon_url', $gift_icon_url);

		if ( empty( $gift_icon_url ) ) {
			$label_icon = '<svg class="' . $img_class . '" style="' . $inline_style . '" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="' . $width . '" height="' . $height . '" viewBox="0 0 24 24"><path d="M22,12V20A2,2 0 0,1 20,22H4A2,2 0 0,1 2,20V12A1,1 0 0,1 1,11V8A2,2 0 0,1 3,6H6.17C6.06,5.69 6,5.35 6,5A3,3 0 0,1 9,2C10,2 10.88,2.5 11.43,3.24V3.23L12,4L12.57,3.23V3.24C13.12,2.5 14,2 15,2A3,3 0 0,1 18,5C18,5.35 17.94,5.69 17.83,6H21A2,2 0 0,1 23,8V11A1,1 0 0,1 22,12M4,20H11V12H4V20M20,20V12H13V20H20M9,4A1,1 0 0,0 8,5A1,1 0 0,0 9,6A1,1 0 0,0 10,5A1,1 0 0,0 9,4M15,4A1,1 0 0,0 14,5A1,1 0 0,0 15,6A1,1 0 0,0 16,5A1,1 0 0,0 15,4M3,8V10H11V8H3M13,8V10H21V8H13Z" /></svg>';
		} else {
			$label_icon = '<img src="' . esc_url( $gift_icon_url ) . '" class="' . $img_class . '" style="' . $inline_style . '" width="' . $width . '" height="' . $height . '" alt="" >';
		}

		/**
		 * Gift wrapper icon's html.
		 *
		 * With this filter, you can alter the html of the gift wrapper icon.
		 * If $gift_icon_url is not set, svg tag is the icon.
		 * If $gift_icon_url is set, img tag is the icon.
		 *
		 * @since 1.0.0
		 *
		 * @param string $label_icon The html of the icon.
		 * @param string $img_class The class of the html tag, svg or img.
		 * @param string $width The width the html tag, svg or img.
		 * @param string $height The height of the html tag, svg or img.
		 * @param string $inline_style The inline style of the icon.
		 */
		$label_icon = apply_filters( 'tgpc_wc_gift_wrapper_icon_html', $label_icon, $img_class, $width, $height, $inline_style);

		$label_text = esc_html__('Gift wrapper', 'tgpc-wc-gift-wrap' );

		$label = $label_icon . '<span class="tgpc-enable-checkout-gift-wrapper--label_text">' . $label_text . '</span>';

		/**
		 * The checkout label filter.
		 *
		 * With this filter, you can alter the label.
		 *
		 * @since 1.0.0
		 *
		 * @param string $label The input label as html.
		 * @param string $label_text The escaped text of the label.
		 */
		$label = apply_filters('tgpc_wc_gift_wrapper_checkout_label', $label, $label_icon, $label_text);

		$checkbox_state = WC()->session->get( 'tgpc_gw_enabled', 0 );

		woocommerce_form_field( 'tgpc_enable_checkout_gift_wrapper', [
			'type'          => 'checkbox',
			'label'         => $label,
			'required'      => false,
			'class'         => [ 'form-row-wide', 'update_totals_on_change' ],
		], $checkbox_state );
	}

	public function tgpc_add_gift_wrapper_fee() {

		if ( is_admin() && !wp_doing_ajax() ) return;
		if ( empty( $_POST ) ) return;

		$post_data = [];

		if ( isset( $_POST[ 'post_data' ] ) ) {
			parse_str( $_POST[ 'post_data' ], $post_data );
		}

		if ( !empty( $post_data[ 'tgpc_enable_checkout_gift_wrapper' ] )
			|| !empty( $_POST[ 'tgpc_enable_checkout_gift_wrapper' ] ) ) {

			$fee_cost   = (float) get_option( 'wc_settings_tab_tgpc_gift_wrapper_cost' );
			$is_taxable = 'yes' === get_option( 'wc_settings_tab_tgpc_cost_tax_status' );
			$tax_class  = get_option( 'wc_settings_tab_tgpc_gift_wrapper_tax_class', '' );

			WC()->cart->add_fee( esc_html__( 'Gift wrapper', 'tgpc-wc-gift-wrap' ), $fee_cost, $is_taxable, $tax_class );

            WC()->session->set( 'tgpc_gw_enabled', 1 );
		}
        else {
            WC()->session->set( 'tgpc_gw_enabled', 0 );
        }
	}


	public function tgpc_save_gift_box_option_to_order( $order ){

		if ( !empty( $_POST['tgpc_enable_checkout_gift_wrapper'] ) ) {
			$order->add_meta_data( '_tgpc_gift_wrapper_selected', 'yes' );
		}

	}

}
