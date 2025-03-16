import { ValidatedTextInput, CheckboxControl } from '@woocommerce/blocks-checkout';
import {
	useBlockProps,
} from '@wordpress/block-editor';

import { __ } from '@wordpress/i18n';

export const Edit = ({ attributes, setAttributes }) => {
	const blockProps = useBlockProps();
	return (
		<div {...blockProps}>
			<div className={ 'tgpc-enable-checkout-gift-wrapper-container' }>
				<CheckboxControl
					id="tgpc_enable_checkout_gift_wrapper"
					label={ __( 'Gift Wrapping', 'gift-wrapping-for-woocommerce' ) }
					required={false}
				/>
			</div>
		</div>
	);
};