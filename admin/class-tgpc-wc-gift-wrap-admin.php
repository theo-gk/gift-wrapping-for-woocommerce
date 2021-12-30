<?php
/**
 * The admin-specific functionality of the plugin. fdfd
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