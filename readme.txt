=== Advanced Social Links for Directorist ===
Contributors: mahfuz87
Tags: social links, social media, business directory, listings
Requires at least: 6.5
Tested up to: 7.0
Stable tag: 2.2.0
Requires PHP: 7.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Adds more social networks, custom icons, and display controls to Directorist listings.

== Description ==

Advanced Social Links for Directorist extends the social links field provided
by the Directorist plugin.

It adds these networks:

* Meetup.com
* Discord
* Telegram
* TikTok
* Twitch
* Medium
* WhatsApp
* Alignable
* Threads
* Nextdoor
* Yelp
* Google Review
* Tripadvisor
* Bluesky

The plugin also provides bundled icons for networks that are not included in
Directorist's icon font, lets administrators choose which networks listing
authors can use, and can show each network's brand color on hover.

This plugin requires the free
[Directorist](https://wordpress.org/plugins/directorist/) plugin. It does not
transmit data to external services or add tracking. Social URLs entered by
listing authors are stored with the associated listing by Directorist.

== Installation ==

1. Install and activate Directorist.
2. Upload the plugin ZIP from **Plugins > Add Plugin > Upload Plugin**, or install it from the WordPress Plugin Directory.
3. Activate **Advanced Social Links for Directorist**.
4. Open **Directorist > Settings > Extensions > Advanced Social Links**.
5. Choose the available networks and optional brand-color hover effect.

== Frequently Asked Questions ==

= Is Directorist required? =

Yes. Directorist must be installed and active. WordPress displays and enforces
this dependency before activation.

= Which networks are enabled by default? =

All networks supplied by Directorist and this plugin are enabled until you save
a different selection in the plugin settings.

= Can I disable every network? =

Yes. Clear all selections under **Available Social Networks** and save the
Directorist settings.

= Can a theme override the bundled templates? =

Yes. Copy a template into a matching path below:

`your-theme/advanced-social-links-for-directorist/`

For example:

`your-theme/advanced-social-links-for-directorist/single/fields/social-info.php`

= Does the plugin send data to social networks? =

No. It only stores and displays the links entered for a listing. A visitor
contacts a social network only after choosing a displayed link.

== Changelog ==

= 2.2.0 =

* Declared Directorist as a required plugin.
* Added WordPress.org-compatible metadata and documentation.
* Changed the public name to follow third-party trademark guidelines.
* Reworked template loading to use Directorist's template path API.
* Improved escaping, filtered output validation, and external-link safety.
* Fixed empty network selections so administrators can disable every network.
* Added accessibility labels to frontend social links.
* Replaced unprovenanced icon files and documented bundled asset licensing.
* Tested with WordPress 7.0 and Directorist 8.8.

= 2.0.0 =

* Added social-network settings.
* Added optional brand-color hover effects.
* Added custom SVG icons and template overrides.

= 1.0.0 =

* Initial release.

== Upgrade Notice ==

= 2.2.0 =

Requires WordPress 6.5 or later, PHP 7.4 or later, and the Directorist plugin.
