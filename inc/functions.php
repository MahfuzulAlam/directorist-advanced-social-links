<?php
/**
 * Directorist Advanced Social Links Functions
 *
 * @package Directorist_Advanced_Social_Links
 * @since   1.0.0
 */

/**
 * If this file is called directly, abort.
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Get available social link items.
 *
 * Merges default Directorist social links with additional advanced social networks.
 *
 * @since 1.0.0
 * @return array Associative array of social network IDs and labels.
 */
function directorist_advanced_social_links_get_social_items()
{
    $extras = array(
        'meetup'      => 'Meetup.com',
        'discord'     => 'Discord',
        'telegram'    => 'Telegram',
        'tiktok'      => 'TikTok',
        'twitch'      => 'Twitch',
        'medium'      => 'Medium',
        'whatsapp'    => 'WhatsApp',
        'alignable'   => 'Alignable',
        'threads'     => 'Threads',
        'nextdoor'    => 'Nextdoor',
        'yelp'        => 'Yelp',
        'google'      => 'Google Review',
        'tripadvisor' => 'Tripadvisor',
        'bluesky'     => 'BlueSky',
    );

    // Get default social links from Directorist if available.
    $default_socials = array();
    if ( ATBDP()->helper->social_links() ) {
        $default_socials = ATBDP()->helper->social_links();
    }

    $default_socials = array_merge($default_socials, $extras);

    /**
     * Filter the available advanced social link items.
     *
     * @since 1.0.0
     * @param array $default_socials The available social networks, id => label.
     */
    return apply_filters('directorist_advanced_social_links_items', $default_socials);
}

/**
 * Get and output social icon HTML.
 *
 * Outputs either a custom SVG icon or a default icon class based on the social network ID.
 *
 * @since 1.0.0
 * @param string $social_id Social network identifier (e.g., 'facebook', 'tiktok').
 * @return void
 */
function directorist_advanced_social_links_get_social_icon($social_id)
{
    if (empty($social_id) || !is_string($social_id)) {
        return;
    }

    // Sanitize social ID to prevent XSS.
    $social_id = sanitize_key($social_id);

    /**
     * Filter the list of social IDs that use custom SVG icons.
     *
     * @since 1.0.0
     * @param array $custom_icons Array of social network IDs that use custom icons.
     */
    $custom_icons = apply_filters(
        'directorist_advanced_social_links_custom_icons',
        array('tiktok', 'alignable', 'threads', 'nextdoor', 'bluesky')
    );

    if (in_array($social_id, $custom_icons, true)) {
        // Sanitize file name to prevent directory traversal.
        $icon_filename = sanitize_file_name($social_id . '.svg');
        $icon_url      = DIRECTORIST_ADVANCED_SOCIAL_URI . 'assets/icon/' . $icon_filename;
        $icon_alt      = esc_attr(ucfirst($social_id));

        $output = sprintf(
            '<img class="directorist-custom-social-icon" width="15" height="15" src="%s" alt="%s">',
            esc_url($icon_url),
            $icon_alt
        );

        /**
         * Filter the output HTML for a custom advanced social icon.
         *
         * @since 1.0.0
         * @param string $output   HTML for the custom icon.
         * @param string $social_id The social network identifier.
         */
        $output = apply_filters('directorist_advanced_social_links_icon_output', $output, $social_id);
        echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    } else {
        /**
         * Filter the default icon classname for a social network before rendering.
         *
         * @since 1.0.0
         * @param string $icon_class The icon classname.
         * @param string $social_id  The social network identifier.
         */
        $icon_class = apply_filters(
            'directorist_advanced_social_links_default_icon_class',
            'lab la-' . esc_attr($social_id),
            $social_id
        );

        // Only call directorist_icon if the function exists.
        if (function_exists('directorist_icon')) {
            directorist_icon($icon_class);
        }
    }
}