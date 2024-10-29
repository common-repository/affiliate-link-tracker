=== Affiliate Link Tracker ===
Contributors: SEOSEON
Donate link: https://seoseon.com
Tags: affiliate, affiliate links, affiliate link tracker, affiliate link tracking, tracking, link tracking, link tracker, cloaking, link masking, pretty links, affiliate marketing, affiliate link manager, affiliate tool, outbound links
Requires at least: 3.0.1
Tested up to: 5.5.1
Requires PHP: 5.2
Stable tag: 0.2
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Advanced affiliate link tracker for tracking where your affiliate conversions come from.

== Description ==
This advanced affiliate link tracking plugin allows you to forward key information about your visitors to your affiliate network's backend. Mask and make pretty affiliate links that automatically append UTM tags and referral information as a sub id.

= The problem =
You can use analytics tools to see who visits your website, where they come from and which links they click on your website, but in your affiliate network's backend, you can only see which affiliate link they clicked - not how they got to your website.

= The solution =
Forward the key information to your affiliate network with our advanced affiliate link tracker WordPress plugin!

= How does it work? =
This plugin works by creating a cookie containing the incoming URL parameters (UTM tags) and HTTP referrer for each user, and appends this information to your outbound affiliate links, via a tracking tag supplied by the specific affiliate network (ex: sub ID, source, ref, epi).

== Features ==
The cookie will automatically append your selected links with the following information (if they are set):
* HTTP referrer
* Standard UTM tags

The HTTP referrer is simply the website they came from (if any). It could be google.com if they found it via organic search, a social network, or another website that links to yours.

[UTM tags](https://support.google.com/analytics/answer/1033863?hl=en) are commonly used to append URLs with information about their usage and placement. The standard UTM tags and their typical usage is listed below, but any information can be placed inside any tag.

= Supported tags: =
* utm_source = The website, app or service
* utm_campaign = The specific campaign
* utm_medium = The type of, or the specific ad
* utm_term = The specific keyword used
* utm_content = The specific placement of the link

**NOTE** This plugin does not set your links to "nofollow" or block any crawlers from visiting them. If you don't want non-human visitors to follow these links, you will have to block them yourself.

== About ==
This is a free plugin from digital marketing agency [SEOSEON](https://seoseon.com). It is based on [Redirect List](https://wordpress.org/plugins/redirect-list/), but has been modified to function as an affiliate link tracker. The goal was to create a very simple, light redirect plugin with advanced affiliate link tracking features built in. Future versions may add more tags, features and customization options.

== Installation ==
1. Install the plugin via the WordPress.org plugin directory, or upload it to your plugins directory.
2. Activate the plugin.
3. Under 'Settings' -> 'Affiliate Links', enter the urls to redirect from and to.
4. Select the corresponding tracking tag
5. Enjoy the detailed information in your affiliate backend!

== How to use it ==
**NOTE** In order to get the most out of this plugin, you need to append your inbound links with UTM tags containing information about the link. 

1. Enter the URL you want to redirect FROM in the LEFT input box.
2. Enter the URL you want to redirect TO in the RIGHT input box.
3. Select the tracking tag that your affiliate network uses from the dropdown menu.

The FROM URL should be an internal link in your website, for example: /go/amazon

The TO URL should be your unique affiliate tracking link, for example: https://amzn.to/2nD9fjb9A

This plugin will add the UTM tags and the HTTP referrer to the tracking tag as a text string, for example: https://amzn.to/2nD9fjb9A?r=google-cpc-sunglasses-goole.com

You can now see this string of text in your affiliate backend, so that you can tell which campaign, ad, website, blog or social media post led to the conversion. Finally!

If the URL contains other URL parameters (or not), this plugin will automatically add a preceding '?' or '&' symbol as needed.

For testing purposes, you can use the shortcode [aff_lnk_view_cookie] to display the string of text currently stored in your current cookie.

Every time a particular link is clicked, a hit will be added to the hit counter. This helps you spot missing conversions.

== Changelog ==

= 0.2 =
Cleaner code and added support for ShareASale network.

= 0.1 =
* Initial release