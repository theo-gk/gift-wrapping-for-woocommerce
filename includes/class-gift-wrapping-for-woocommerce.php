<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @since      1.0
 *
 * @package    Tgpc_Wc_Gift_Wrap
 * @subpackage Tgpc_Wc_Gift_Wrap/includes
 */

class Tgpc_Wc_Gift_Wrap {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0
	 * @access   protected
	 * @var      Tgpc_Wc_Gift_Wrap_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0
	 */
	public function __construct() {
		if ( defined( 'GIFT_WRAPPING_FOR_WOOCOMMERCE_VERSION' ) ) {
			$this->version = GIFT_WRAPPING_FOR_WOOCOMMERCE_VERSION;
		} else {
			$this->version = '1.0';
		}
		$this->plugin_name = 'gift-wrapping-for-woocommerce';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Tgpc_Wc_Gift_Wrap_Loader. Orchestrates the hooks of the plugin.
	 * - Tgpc_Wc_Gift_Wrap_i18n. Defines internationalization functionality.
	 * - Tgpc_Wc_Gift_Wrap_Admin. Defines all hooks for the admin area.
	 * - Tgpc_Wc_Gift_Wrap_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-gift-wrapping-for-woocommerce-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-gift-wrapping-for-woocommerce-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-gift-wrapping-for-woocommerce-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-gift-wrapping-for-woocommerce-public.php';

		$this->loader = new Tgpc_Wc_Gift_Wrap_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Tgpc_Wc_Gift_Wrap_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Tgpc_Wc_Gift_Wrap_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
	}

    function tgpc_is_gift_wrapper_enabled() {
        return 'yes' === get_option( 'tgpc_gift_wrapper_enabled' );
    }

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Tgpc_Wc_Gift_Wrap_Admin( $this->get_plugin_name(), $this->get_version() );

        /* WooCommerce settings tabs */
        $this->loader->add_filter( 'woocommerce_get_settings_pages', $plugin_admin, 'tgpc_wc_gift_wrap_add_settings_tab', 999 );

		/* Order list */
        //add icon to orders with gift wrapper selected
		// new wc page column before HPOS
		$this->loader->add_action( 'manage_shop_order_posts_custom_column', $plugin_admin, 'dc_add_gift_icon_to_order_notes_column_before_hpos', 15 );
		// new wc page column with HPOS
		$this->loader->add_action( 'manage_woocommerce_page_wc-orders_custom_column', $plugin_admin, 'dc_add_gift_icon_to_order_notes_column', 15, 2 );

        /* Plugins list */
        $this->loader->add_filter( 'plugin_action_links', $plugin_admin, 'tgpc_wc_gift_wrap_action_links',10,2 );

		/**
		 * Declaring plugin compatibility with High-Performance Order Storage
		 *
		 * @since 1.1
		 */

		$this->loader->add_action( 'before_woocommerce_init', $plugin_admin, 'declare_compatibility_with_wc_features' );

//        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
//        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
    }

	/**
	 * Register all of the hooks related to the public-facing functionality of the plugin.
	 *
	 * @since    1.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public        = new Tgpc_Wc_Gift_Wrap_Public( $this->get_plugin_name(), $this->get_version() );
		$gift_wrapper_enabled = $this->tgpc_is_gift_wrapper_enabled();

		/* Checkout page */
 		if ( $gift_wrapper_enabled ) {

			if ( defined( 'TGPC_GIFT_WRAPPER_CHECKOUT_CHECKBOX_LOCATION_HOOK_PRIORITY' ) ) {
				$checkbox_location_hook_priority = TGPC_GIFT_WRAPPER_CHECKOUT_CHECKBOX_LOCATION_HOOK_PRIORITY;
			} else {
				$checkbox_location_hook_priority = 15;
			}

			if ( defined( 'TGPC_GIFT_WRAPPER_CHECKOUT_CHECKBOX_LOCATION_HOOK_NAME' ) ) {
				$checkbox_location_hook_name = TGPC_GIFT_WRAPPER_CHECKOUT_CHECKBOX_LOCATION_HOOK_NAME;
			} else {
				$checkbox_location_hook_name = get_option( 'tgpc_gift_wrapper_location', 'woocommerce_after_checkout_billing_form' );
			}

			/**
			 * If you need to alter the hook and/or the priority hook by code, you need to
			 * define a string and/or an integer constant in the wp-config.php
			 *
			 * Example:
			 * define( 'TGPC_GIFT_WRAPPER_CHECKOUT_CHECKBOX_LOCATION_HOOK_NAME', 'new_hook_name' );
			 * define( 'TGPC_GIFT_WRAPPER_CHECKOUT_CHECKBOX_LOCATION_HOOK_PRIORITY', 12 );
			 */
            $this->loader->add_action( $checkbox_location_hook_name, $plugin_public, 'tgpc_add_gift_checkbox_on_checkout', $checkbox_location_hook_priority );

			$this->loader->add_action( 'woocommerce_cart_calculate_fees', $plugin_public, 'tgpc_add_gift_wrapper_fee' );
			$this->loader->add_action( 'woocommerce_checkout_create_order', $plugin_public, 'tgpc_save_gift_wrapper_option_to_order_meta' );

//            $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
//            $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		}

        $this->loader->add_action( 'woocommerce_order_get_items', $plugin_public, 'tgpc_show_fee_even_if_gift_wrapper_cost_is_0', 10, 3 );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0
	 * @return    Tgpc_Wc_Gift_Wrap_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
