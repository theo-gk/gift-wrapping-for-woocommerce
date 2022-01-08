<?php
/**
 * The plugin settings inside WooCommerce settings.
 *
 * @package    Tgpc_Wc_Gift_Wrap
 * @subpackage Tgpc_Wc_Gift_Wrap/admin
 */

defined( 'ABSPATH' ) || exit;

/**
 * Settings for API.
 */
if ( class_exists( 'Tgpc_Gift_Wrap_Wc_Settings', false ) ) {
	return new Tgpc_Gift_Wrap_Wc_Settings();
}

/**
 * Tgpc_Gift_Wrap_Wc_Settings.
 */
class Tgpc_Gift_Wrap_Wc_Settings extends WC_Settings_Page {

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->id    = 'tgpc_wc_gift_wrap';
		$this->label = __( 'Gift Wrapper', 'tgpc-wc-gift-wrap' );

		parent::__construct();
	}

	/**
	 * Get own sections.
	 *
	 * @return array
	 */
	protected function get_own_sections() {
		return array(
			''                => __( 'General Settings', 'tgpc-wc-gift-wrap' ),
		);
	}

	/**
	 * Get settings for the default section.
	 *
	 * @return array
	 */
	protected function get_settings_for_default_section() {

        $settings['section_title'] = [
            'name' => esc_html__( 'Gift Wrapper Settings', 'tgpc-wc-gift-wrap' ),
            'type' => 'title',
            'desc' => '',
            'id'   => 'wc_settings_tab_tgpc_main_settings',
        ];

        $settings['gift_wrapper_enabled'] = [
            'name' => esc_html__( 'Enable Gift Wrapper','tgpc-wc-gift-wrap' ),
            'type' => 'checkbox',
            'desc' => esc_html__( 'Enable Gift Wrapper', 'tgpc-wc-gift-wrap' ),
            'desc_tip' => esc_html__( 'Enable gift wrapper option on the checkout page.', 'tgpc-wc-gift-wrap' ),
            'id'   => 'wc_settings_tab_tgpc_gift_wrapper_enabled',
        ];

        $settings['gift_wrapper_cost'] = [
            'name' => esc_html__( 'Gift Wrapper Cost', 'tgpc-wc-gift-wrap' ),
            'type' => 'number',
            'custom_attributes' => [ 'step' => '0.01', 'min' => '0' ],
            'css'  => 'width:70px;',
            'desc' => esc_html__( 'The gift wrapper cost. If taxable, this amount is before taxes.', 'tgpc-wc-gift-wrap' ),
            'id'   => 'wc_settings_tab_tgpc_gift_wrapper_cost',
        ];

		//TODO
        $settings['cost_tax_status'] = [
            'name' => esc_html__( 'Cost tax status','tgpc-wc-gift-wrap' ),
            'type' => 'checkbox',
            'desc' => esc_html__( 'Cost is taxable', 'tgpc-wc-gift-wrap' ),
            'desc_tip' => esc_html__( 'Check if the gift wrapper cost is taxable.', 'tgpc-wc-gift-wrap' ),
            'id'   => 'wc_settings_tab_tgpc_cost_tax_status',
        ];

        $settings['gift_wrapper_tax_class'] = [
            'name'      => esc_html__( 'Cost tax class', 'tgpc-wc-gift-wrap' ),
            'type'      => 'select',
            'options'   => wc_get_product_tax_class_options(),
            'desc'      => esc_html__( 'Select the tax class.', 'tgpc-wc-gift-wrap' ),
            'id'        => 'wc_settings_tab_tgpc_gift_wrapper_tax_class',
        ];

		// Doc: https://www.businessbloomer.com/woocommerce-visual-hook-guide-checkout-page/
        $settings['gift_wrapper_location'] = [
            'name'      => esc_html__( 'Location on Checkout', 'tgpc-wc-gift-wrap' ),
            'type'      => 'select',
            'default'   => 'woocommerce_after_checkout_billing_form',
            'options'   => [
				'woocommerce_checkout_before_customer_details'  => esc_html__( 'Before customer details', 'tgpc-wc-gift-wrap' ),

				'woocommerce_before_checkout_billing_form'  => esc_html__( 'Before billing details', 'tgpc-wc-gift-wrap' ),
                'woocommerce_after_checkout_billing_form' => esc_html__( 'After billing details', 'tgpc-wc-gift-wrap' ),

				'woocommerce_before_order_notes'  => esc_html__( 'Before order notes', 'tgpc-wc-gift-wrap' ),
				'woocommerce_after_order_notes'  => esc_html__( 'After order notes', 'tgpc-wc-gift-wrap' ),

				'woocommerce_review_order_before_payment'  => esc_html__( 'Before payments', 'tgpc-wc-gift-wrap' ),
				'woocommerce_review_order_before_submit'  => esc_html__( 'Before place order button', 'tgpc-wc-gift-wrap' ),
            ],
            'desc'      => esc_html__( 'Select the position to appear in the checkout page.', 'tgpc-wc-gift-wrap' ),
            'id'        => 'wc_settings_tab_tgpc_gift_wrapper_location',
        ];

        $settings['section_end'] = [
            'type' => 'sectionend',
            'id'   => 'wc_settings_tab_tgpc_main_settings',
        ];

		$settings = apply_filters( 'tgpc_wc_gift_wrapper_general_settings', $settings );

		return $settings;
	}

}

return new Tgpc_Gift_Wrap_Wc_Settings();
