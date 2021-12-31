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

}
