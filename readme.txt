=== Gift Wrapping for WooCommerce ===
Contributors: pexlechris, theogk
Plugin Name: Gift Wrapping for WooCommerce
Tags: woocommerce, gift box, gift wrapper, gift wrapping, wrapping, checkout, packaging
Author: Pexle Chris, Theo Gkitsos
Version: 1.0
Stable tag: 1.0
Requires at least: 5.3
Tested up to: 6.0
Requires PHP: 5.6
WC requires at least: 5.5.0
WC tested up to: 6.5.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Allow customers to select a gift wrapper for their orders.

== Description ==

This plugin allows customers to select a gift wrapper for their orders, via a checkbox in the checkout page.

With focus on performance and flexibility, this lightweight plugin adds the gift wrapper cost, using the WooCommerce Fees API.

Through simple and straight-forward settings, you can set a cost for the gift wrapper or offer it for free, select the tax class, or change the checkbox position on the checkout.

= Full features list (free version) =

- Customers can select a gift wrapper for their order through a checkout field on the checkout page.
- Set an extra cost if gift wrapper is selected. Of course, you can also offer it for free if you want.
- Select if the extra cost is taxable and select its tax rate.
- If selected, an extra fee appears on the checkout totals table, adding the gift wrapper cost to the cart total. The fee also appears on the thank you page and the admin and customer emails.
- Store managers can easily identify which orders have a gift wrapper selected through a small icon in the order list. Also, gift wrapper full info and cost appear in the order page, at the order items section.
- Customer's checkbox selection is saved on WooCommerce customer session, so it doesn't get lost on page refresh.
- Developer friendly, as you can customize pretty much everything via plugin's settings and carefully placed filters. See FAQ below for more info.
- Translation ready.

== Screenshots ==

1. Plugin settings.
2. Checkout gift wrapper input.

== Frequently Asked Questions ==

 = Can I add a cost to gift wrapper? =
 Yes, you can add a cost easily through the plugin settings.

 = Can I offer gift wrapper for free? =
 Yes, just set the gift wrapper cost to zero (0).

 = Is there any hook that allow me to change the cost on the fly? =
 Yes, you can do this, using the Options API.
 `
 add_filter('pre_option_tgpc_gift_wrapper_cost', function($cost){
    //Do magic here
    return $cost;
 });
 `

 = Can I change the icon? =
 Yes, you can use the filter `tgpc_wc_gift_wrapper_icon_url` in order to return the public url of the image you want
 OR
 the filter `tgpc_wc_gift_wrapper_icon_html` in order to filter the printed html of the icon.

 = How can I hide the gift wrapper icon? =
 You can do this easily with the following php snippet:
 `
 add_filter('tgpc_wc_gift_wrapper_icon_html', function($icon_html){
    return '';
 });
 `

 = The gift wrapper icon is not perfectly aligned with the checkbox. How to fix it? =
This highly depends on your theme's CSS, and there is no universal solution. If the icon is not aligned with the checkbox and the label, then you have to add some CSS to fix this.

Try setting a vertical align property to the icon to align it correctly:
 `
 .tgpc-enable-checkout-gift-wrapper--label_icon {
    vertical-align: middle;
 }
 `
 See [here](https://developer.mozilla.org/en-US/docs/Web/CSS/vertical-align) the list of all available vertical-align CSS property values.

 = Can I change gift wrapper checkbox position? =
 Yes, you can choose between several checkout page locations through the plugin settings.

 If you want to use some other hook, read below.

 = Can I set different gift wrapper checkbox position, instead of these in dropdown in the plugin settings? =
 Yes, you need to define the hook that prints the input. And maybe the hook's priority.

 - To change the hook add this line to your wp-config.php:
 `define( 'TGPC_GIFT_WRAPPER_CHECKOUT_CHECKBOX_LOCATION_HOOK_NAME', 'new_hook_name' );`

 - To change the hook's priority (default is 15), you will need to add a constant in your wp-config.php:
 `define( 'TGPC_GIFT_WRAPPER_CHECKOUT_CHECKBOX_LOCATION_HOOK_PRIORITY', 12 );`

 = Can I apply my own styling to the gift wrapper checkbox? =
 Yes, you can write your own CSS to style it as you like. There are appropriate classes in all the right places, so you can apply your CSS wherever you need to.

== Installation ==

1. Download the plugin from [Official WP Plugin Repository](https://wordpress.org/plugins/gift-wrapping-for-woocommerce/).
2. Upload Plugin from your WP Dashboard ( Plugins>Add New>Upload Plugin ) the gift-wrapping-for-woocommerce.zip file.
3. Activate the plugin through the 'Plugins' menu in WordPress Dashboard.
4. Go to Woocommerce > Settings > Gift Wrapper, enable and setup the Gift Wrapper.

== Changelog ==

 = 1.0 =
* Initial release
