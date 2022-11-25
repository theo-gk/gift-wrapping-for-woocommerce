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
		$this->label = __( 'Gift Wrapper', 'gift-wrapping-for-woocommerce' );

		parent::__construct();
	}

	/**
	 * Get own sections.
	 *
	 * @return array
	 */
	protected function get_own_sections() {
		return [
			'' => __( 'General Settings', 'gift-wrapping-for-woocommerce' ),
		];
	}

	/**
	 * Get settings for the default section.
	 *
	 * @return array
	 */
	protected function get_settings_for_default_section() {

		$settings['section_title'] = [
			'id'   => 'tgpc_gift_wrapper_main_settings',
			'name' => esc_html__( 'Gift wrapper settings', 'gift-wrapping-for-woocommerce' ),
			'type' => 'title',
			'desc' => '',
		];

		$settings['gift_wrapper_enabled'] = [
			'id'       => 'tgpc_gift_wrapper_enabled',
			'name'     => esc_html__( 'Enable gift wrapper','gift-wrapping-for-woocommerce' ),
			'type'     => 'checkbox',
			'desc'     => esc_html__( 'Enable gift wrapper', 'gift-wrapping-for-woocommerce' ),
			'desc_tip' => esc_html__( 'Enable gift wrapper option on the checkout page.', 'gift-wrapping-for-woocommerce' ),
		];

		$settings['gift_wrapper_checkbox_label'] = [
			'id'      => 'tgpc_gift_wrapper_checkbox_label',
			'name'    => esc_html__( 'Checkbox label', 'gift-wrapping-for-woocommerce' ),
			'type'    => 'text',
			'desc'    => esc_html__( 'The checkbox label on the checkout page.', 'gift-wrapping-for-woocommerce' ),
			'default' => esc_html__( 'Gift wrapper', 'gift-wrapping-for-woocommerce' ),
		];

		$settings['gift_wrapper_cost'] = [
			'id'                => 'tgpc_gift_wrapper_cost',
			'name'              => esc_html__( 'Cost', 'gift-wrapping-for-woocommerce' ),
			'type'              => 'number',
			'custom_attributes' => [ 'step' => '0.01', 'min' => '0' ],
			'css'               => 'width:70px;',
			'desc'              => esc_html__( 'The gift wrapper cost. If taxable, this amount is before taxes. Set number to zero (0) for free gift wrapper.', 'gift-wrapping-for-woocommerce' ),
		];

		$settings['gift_wrapper_cost_tax_status'] = [
			'id'       => 'tgpc_gift_wrapper_cost_tax_status',
			'name'     => esc_html__( 'Cost tax status','gift-wrapping-for-woocommerce' ),
			'type'     => 'checkbox',
			'desc'     => esc_html__( 'Cost is taxable', 'gift-wrapping-for-woocommerce' ),
			'desc_tip' => esc_html__( 'Check if the gift wrapper cost is taxable.', 'gift-wrapping-for-woocommerce' ),
		];

		$settings['gift_wrapper_tax_class'] = [
			'id'        => 'tgpc_gift_wrapper_tax_class',
			'name'      => esc_html__( 'Cost tax class', 'gift-wrapping-for-woocommerce' ),
			'type'      => 'select',
			'options'   => wc_get_product_tax_class_options(),
			'desc'      => esc_html__( 'Select the tax class for gift wrapper cost, if cost is taxable.', 'gift-wrapping-for-woocommerce' ),
		];

		$settings['gift_wrapper_location'] = [
			'id'        => 'tgpc_gift_wrapper_location',
			'name'      => esc_html__( 'Location on checkout', 'gift-wrapping-for-woocommerce' ),
			'type'      => 'select',
			'default'   => 'woocommerce_after_checkout_billing_form',
			'options'   => [
				'woocommerce_checkout_before_customer_details'  => esc_html__( 'Before customer details', 'gift-wrapping-for-woocommerce' ),
				'woocommerce_before_checkout_billing_form'  => esc_html__( 'Before billing details', 'gift-wrapping-for-woocommerce' ),
				'woocommerce_after_checkout_billing_form' => esc_html__( 'After billing details', 'gift-wrapping-for-woocommerce' ),
				'woocommerce_before_order_notes'  => esc_html__( 'Before order notes', 'gift-wrapping-for-woocommerce' ),
				'woocommerce_after_order_notes'  => esc_html__( 'After order notes', 'gift-wrapping-for-woocommerce' ),
				'woocommerce_review_order_before_payment'  => esc_html__( 'Before payments', 'gift-wrapping-for-woocommerce' ),
				'woocommerce_review_order_before_submit'  => esc_html__( 'Before place order button', 'gift-wrapping-for-woocommerce' ),
			],
			'desc'      => esc_html__( 'Select the position to appear in the checkout page.', 'gift-wrapping-for-woocommerce' ),
		];

		$settings['section_end'] = [
			'id'   => 'tgpc_gift_wrapper_main_settings',
			'type' => 'sectionend',
		];

		/**
		 * Plugin settings filter.
		 *
		 * @since 1.0
		 *
		 * @param array $settings The plugin's main settings.
		 */
		$settings = apply_filters( 'tgpc_wc_gift_wrapper_main_settings', $settings );

		return $settings;
	}
}

return new Tgpc_Gift_Wrap_Wc_Settings();