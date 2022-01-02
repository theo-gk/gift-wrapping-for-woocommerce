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

		$label_text = esc_html__('Gift wrapper', 'tgpc-wc-gift-wrap' );
		$label_icon = '';

		$gift_icon_url = apply_filters( 'tgpc_wc_gift_wrapper_icon', trailingslashit( TGPC_WC_GIFT_WRAP_PLUGIN_DIR_URL ) . 'assets/gift-outline.svg' );
		$inline_style  = 'style="display: inline-block; vertical-align: text-bottom; margin-right: 4px;"';

		if ( !empty( $gift_icon_url ) ) {
			$label_icon = '<img src="' . esc_url( $gift_icon_url ) . '" class="tgpc-gift-box-icon" ' . $inline_style . ' alt="'. esc_html__( 'Gift wrapper selected', 'tgpc-wc-gift-wrap' ).'" width="17" height="17" >';
		}

		woocommerce_form_field( 'tgpc_enable_checkout_gift_wrapper', [
			'type'          => 'checkbox',
			'label'         => $label_icon . $label_text,
			'required'      => false,
			'class'         => [ 'form-row-wide', 'update_totals_on_change' ],
		], '' );
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

		}
	}

	public function tgpc_save_gift_box_option_to_order( $order_id ){

		if ( !empty( $_POST['tgpc_enable_checkout_gift_wrapper'] ) ) {
			update_post_meta( $order_id, 'tgpc_gift_wrapper_selected', 1 );
		}

	}

}
