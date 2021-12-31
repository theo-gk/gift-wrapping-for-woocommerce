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
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}


	/**
	 * Adds the settings tab in the WooCommerce settings page.
     *
     * @since 1.0.0
     *
	 */
    function tgpc_wc_gift_wrap_add_settings_tab( $settings ) {
        $settings[] = include TGPC_WC_GIFT_WRAP_PLUGIN_DIR . '/admin/class-tgpc-wc-gift-wrap-settings.php';
        return $settings;
    }


    function tgpc_add_gift_checkbox_on_checkout( $checkout ) {

        woocommerce_form_field( 'tgpc_enable_checkout_gift_wrapper', [
            'type'          => 'checkbox',
            'label'         => esc_html__('Gift wrapper', 'tgpc-wc-gift-wrap' ),
            'required'      => false,
            'class'         => [ 'form-row-wide', 'update_totals_on_change' ],
        ], '' );
    }

    function tgpc_add_gift_wrapper_fee() {

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








    /**
     * Adds an invoice icon in the admin order page if an order has invoice.
     *
     * @param $column
     * @since 1.0.0
     */
    function dc_icon_to_order_notes_column( $column ) {

        global $the_order;

        if ( 'order_number' === $column ) {

        }
    }


    /**
     * Add Settings link in plugin page
     *
     * @since   1.0.0
     *
     * @param   array $actions
     * @param   string $plugin_file
     *
     * @return  array $actions
     */
    function tgpc_wc_gift_wrap_action_links( $actions, $plugin_file ) {

        $this_plugin = TGPC_WC_GIFT_WRAP_BASE_FILE;

        if ( $plugin_file == $this_plugin ) {

            $settings_link = '<a href="' . esc_url( get_admin_url( null, 'admin.php?page=wc-settings&tab=tgpc_wc_gift_wrap' ) ) . '">' . esc_html__( 'Settings', 'tgpc-wc-gift-wrap' ) . '</a>';
            array_unshift( $actions, $settings_link );
        }

        return $actions;
    }


	/**
	 * Register the stylesheets for the admin area.
	 *
     * @param $hook
	 * @since    1.0.0
	 */
	public function enqueue_styles( $hook ) {

        $screen = get_current_screen();

        if ( ( isset( $screen->id ) && 'shop_order' === $screen->id ) || ( 'woocommerce_page_wc-settings' === $hook && isset( $_GET['tab'] ) && ( 'tgpc_wc_gift_wrap' === $_GET['tab'] ) ) ) {
            wp_enqueue_style( 'tgpc-wc-gift-wrap-admin-css', plugin_dir_url( __FILE__ ) . 'css/tgpc-wc-gift-wrap-admin-css.css', array(), $this->version.time() );
        }

	}

    /**
     * Register the JavaScript for the admin area.
     *
     * @param $hook
     * @since    1.0.0
     */
	public function enqueue_scripts( $hook ) {

        if ( 'woocommerce_page_wc-settings' === $hook && isset( $_GET['tab'] ) && ( 'tgpc_wc_gift_wrap' === $_GET['tab'] ) ) {
            wp_enqueue_script( 'tgpc-wc-gift-wrap-admin-js', TGPC_WC_GIFT_WRAP_PLUGIN_DIR_URL . 'admin/js/tgpc-wc-gift-wrap-admin-js.js', array( 'jquery' ), $this->version.time(), true );
		}
	}
}