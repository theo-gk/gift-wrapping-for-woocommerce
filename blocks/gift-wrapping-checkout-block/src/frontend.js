import metadata from './block.json';
import { CheckboxControl } from '@woocommerce/blocks-checkout';
import { __ } from '@wordpress/i18n';
import { useState, useCallback } from '@wordpress/element';

// Global import
const { registerCheckoutBlock } = wc.blocksCheckout;

const GiftWrapper = ({ children, checkoutExtensionData, value }) => {
	const [ giftWrapperEnabled, setgiftWrapperEnabled ] = useState('');
	const { setExtensionData } = checkoutExtensionData;

	return (
		<div className={ 'wc-block-checkout__gift-wrapping-checkout-block' }>
			<CheckboxControl
				id="tgpc_enable_checkout_gift_wrapper"
				label={ __( 'Gift Wrapping', 'gift-wrapping-for-woocommerce' ) }
				required={false}
				checked={ giftWrapperEnabled }
				onChange={ ( isChecked ) => {
					setgiftWrapperEnabled( isChecked );
					setExtensionData( 'gift-wrapping-checkout-block', 'tgpc_enable_checkout_gift_wrapper', isChecked );
				} }
			/>
		</div>
	)
}

const options = {
	metadata,
	component: GiftWrapper
};

registerCheckoutBlock( options );