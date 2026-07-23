# Advanced Social Links for Directorist

Advanced Social Links for Directorist extends Directorist's social-links field
with more networks, bundled icons, configurable network availability, and an
optional brand-color hover effect.

## Requirements

- WordPress 6.5 or later
- PHP 7.4 or later
- [Directorist](https://wordpress.org/plugins/directorist/)

## Installation

1. Install and activate Directorist.
2. Upload this plugin to `wp-content/plugins/advanced-social-links-for-directorist`,
   or install its ZIP from the WordPress admin.
3. Activate **Advanced Social Links for Directorist**.
4. Open **Directorist > Settings > Extensions > Advanced Social Links**.

WordPress.org-facing documentation is maintained in
[`readme.txt`](readme.txt).

## Networks added

Meetup.com, Discord, Telegram, TikTok, Twitch, Medium, WhatsApp, Alignable,
Threads, Nextdoor, Yelp, Google Review, Tripadvisor, and Bluesky.

## Template overrides

Themes can override a bundled template by copying it below:

`your-theme/advanced-social-links-for-directorist/`

The relative path must match the plugin template. For example:

`templates/single/fields/social-info.php`

becomes:

`your-theme/advanced-social-links-for-directorist/single/fields/social-info.php`

## Developer API

### Functions

- `directorist_advanced_social_links_get_all_social_items()`
- `directorist_advanced_social_links_get_social_items()`
- `directorist_advanced_social_links_get_social_icon( $social_id )`
- `directorist_advanced_social_links_get_brand_color()`

### Filters

- `directorist_advanced_social_links_all_items`
- `directorist_advanced_social_links_items`
- `directorist_advanced_social_links_custom_icons`
- `directorist_advanced_social_links_icon_output`
- `directorist_advanced_social_links_default_icon_class`
- `directorist_advanced_social_links_brand_color`
- `atbdp_advanced_social_links_settings_controls`

## Privacy

The plugin does not transmit data to external services or add tracking. It
stores configuration inside Directorist's existing settings option. Social URLs
entered by listing authors are stored with their associated listings by
Directorist.

## License

GPL-2.0-or-later. See [LICENSE.md](LICENSE.md) and
[THIRD-PARTY-NOTICES.md](THIRD-PARTY-NOTICES.md).
