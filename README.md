=== OptimWP ===
Contributors: UfukArt  
Donate link: https://www.paypal.com/donate/?business=53EHQKQ3T87J8&no_recurring=0&currency_code=USD  
Tags: optimize, optimization, clean, tweak  
Requires at least: 5.0  
Tested up to: 6.8  
Requires PHP: 7.1  
Stable tag: 1.1  
License: GPLv2 or later  
License URI: http://www.gnu.org/licenses/gpl-2.0.html  

Manage and clean up WordPress core leftovers and tweaks — no coding required.

== Description ==

**OptimWP** is a lightweight tweak tool to optimize WordPress by disabling unnecessary features and removing common “WordPress footprints” — all without touching a single line of code.

Whether you want to speed up your site, reduce backend noise, or just have more control, OptimWP gives you dozens of cleanup options in a single, easy-to-use interface.

== Features ==

- Disable Comments
- Disable XML-RPC
- Disable REST API
- Disable RSS Feeds
- Disable Login Language Switcher
- Disable Auto-Update for:
  - WordPress Core
  - Plugins
  - Themes
  - Translations
- Disable Auto-Update Email Notifications for:
  - Core
  - Plugins
  - Themes
- Remove Version from:
  - Stylesheets
  - Scripts
- Remove Meta Tags:
  - Generator
  - Visual Composer
  - Revolution Slider
  - Yoast SEO HTML Comments
  - WPML Generator
  - RSD Link
  - Short Link
  - WLW Manifest
- Remove WordPress Dashicons (frontend)
- Disable File Editor (theme/plugin editor)
- Change Login Error Message
- Remove "Powered By" HTTP header
- Disable Auto Linking of URLs in comments
- Remove "Capital P Dangit"
- Disable Post Revisions

== ⚠️ Caution ==

This plugin includes the ability to disable WordPress core, plugin, theme, and translation auto-updates.  
**Disabling these updates is not recommended** unless you are managing updates through another process (e.g., CI/CD, managed hosting, etc.), as it may expose your site to security risks.

== Installation ==

1. Go to `Plugins` → `Add New` → `Upload Plugin`.
2. Upload the `optimwp.zip` file.
3. Activate the plugin.
4. Visit `Settings` → `OptimWP` to configure the options.

== Frequently Asked Questions ==

= How can I reset settings to default? =

Simply deactivate and reactivate the plugin on the WordPress Plugins page.

== Changelog ==

= 1.1 =
- Added: Remove Powered By HTTP header
- Added: Disable Auto Linking of URLs in comment section
- Added: Remove Capital P Dangit
- Major code optimizations

= 1.0 =
- Initial release

== Support ==

Found a bug or want to suggest a feature? Visit the [GitHub repository](https://github.com/ufukart/optimwp) or open a topic on the [WordPress support forum](https://wordpress.org/support/plugin/optimwp).

Love this plugin? [Leave a review](https://wordpress.org/support/plugin/optimwp/reviews/) and share it!
