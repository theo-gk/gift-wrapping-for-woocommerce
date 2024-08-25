=== Gift Wrapping for WooCommerce ===
Contributors: pexlechris, theogk
Plugin Name: Gift Wrapping for WooCommerce
Tags: woocommerce, gift box, gift wrapper, gift wrapping, wrapping
Author: Pexle Chris, Theo Gkitsos
Version: 1.2.3
Stable tag: 1.2.3
Requires at least: 5.3
Tested up to: 6.6.1
Requires PHP: 5.6
WC requires at least: 5.5.0
WC tested up to: 9.2.2
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
- Customize checkout label text.
- Store managers can easily identify which orders have a gift wrapper selected through a small icon in the order list. Also, gift wrapper full info and cost appear in the order page, at the order items section.
- Customer's checkbox selection is saved on WooCommerce customer session, so it doesn't get lost on page refresh.
- Translation ready. Compatible with all plugins supporting wpml-config.xml (WPML, Polylang etc.) and TranslatePress.
- High-Performance Order Storage (HPOS) compatible.
- Developer friendly, as you can customize pretty much everything via plugin's settings and carefully placed filters. See FAQ below for more info.

== Screenshots ==

1. Plugin settings.
2. Checkout gift wrapper input.

== Frequently Asked Questions ==

 = Can I add a cost to gift wrapper? =
 Yes, you can add a cost easily through the plugin settings.

 = Can I offer gift wrapper for free? =
 Yes, just set the gift wrapper cost to zero (0).

 = Can I modify the gift wrapper cost on the fly? =
 Yes, you can do this using the `tgpc_wc_gift_wrapper_cost` filter.
 Simple example:
 `
 add_filter('tgpc_wc_gift_wrapper_cost', function($cost){
    //Do magic here
    return $cost;
 });
 `
 You should add this code in your child theme's functions.php file or a Code Snippets plugin.

 = Can I change the icon on the checkout? =
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

  = Can I translate this plugin to any language? =
  Yes. All strings in this plugin use the gettext functions, plus an always updated .pot template file is included. This means that they can be translated to any language using a translation plugin like WPML, Polylang, Loco Translate etc.

  For texts like the checkout checkbox label which is user defined in plugin's settings, translation is also supported for all plugins that support the wpml-config.xml protocol like WPML, Polylang etc., and also TranslatePress.
  For example, if you use WPML, use "String Translation" and search for (a) "admin_texts_tgpc_gift_wrapper_checkbox_label" domain, or (b) "tgpc_gift_wrapper_checkbox_label" option name, or (c) simply your own text you inserted in the admin field.

 = Is this plugin compatible with multi-currency plugins? =
 Yes, but not out of the box, you have to add some code yourself. You have to use the filter `tgpc_wc_gift_wrapper_cost` and modify the gift wrapper cost depending on the selected currency.
 You can find some examples in the [support forum](https://wordpress.org/support/plugin/gift-wrapping-for-woocommerce/).

== Installation ==

1. Download the plugin from [Official WP Plugin Repository](https://wordpress.org/plugins/gift-wrapping-for-woocommerce/).
2. Upload Plugin from your WP Dashboard ( Plugins>Add New>Upload Plugin ) the gift-wrapping-for-woocommerce.zip file.
3. Activate the plugin through the 'Plugins' menu in WordPress Dashboard.
4. Go to Woocommerce > Settings > Gift Wrapper, enable and setup the Gift Wrapper.

== Changelog ==

= 1.2.3 =
* Compatibility: Tested up to WP 6.6.x and WC 9.2.x
* Add a new filter `tgpc_wc_gift_wrapper_cost` to modify the gift wrapper cost on the fly.

= 1.2.2 =
* Compatibility: Tested up to WP 6.5 and WC 8.7.x.
* Add WordPress Playground blueprint.

= 1.2.1 =
* Compatibility: Tested up to WP 6.3 and WC 8.0.x.

= 1.2 =
* Feature: Add actions before and after checkout field to add custom data.
* Performance: Plugin settings not auto-loaded anymore to prevent them from loading to all pages.

= 1.1 =
* Feature: Add option to change checkbox label on checkout.
* Feature: Remove gift wrapping option if order has only virtual products.
* i18n: Added multilingual support.
* i18n: Updated .pot file.
* Compatibility: Checked WP & WC compatibility.
* Compatibility: Plugin made HPOS compatible!

 = 1.0 =
* Initial release.
