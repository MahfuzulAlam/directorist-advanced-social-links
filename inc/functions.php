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
 * Get all available social link items (without filtering).
 *
 * Merges default Directorist social links with additional advanced social networks.
 * This is the base function that returns all available social networks.
 *
 * @since 1.0.0
 * @return array Associative array of social network IDs and labels.
 */
function directorist_advanced_social_links_get_all_social_items()
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
        $directorist_socials = ATBDP()->helper->social_links();
        if (!empty($directorist_socials) && is_array($directorist_socials)) {
            $default_socials = $directorist_socials;
        }
    }

    $default_socials = array_merge($default_socials, $extras);

    /**
     * Filter all available advanced social link items (before settings filtering).
     *
     * @since 1.0.0
     * @param array $default_socials The available social networks, id => label.
     */
    return apply_filters('directorist_advanced_social_links_all_items', $default_socials);
}

/**
 * Get available social link items (with filtering based on settings).
 *
 * Merges default Directorist social links with additional advanced social networks
 * and filters them based on saved settings.
 *
 * @since 1.0.0
 * @return array Associative array of social network IDs and labels.
 */
function directorist_advanced_social_links_get_social_items()
{
    // Get all available social items first.
    $default_socials = directorist_advanced_social_links_get_all_social_items();

    // Filter social items based on saved settings.
    $enabled_social_items = get_directorist_option('advanced_social_links_items', array());

    // If settings are configured, filter the social items.
    if (!empty($enabled_social_items) && is_array($enabled_social_items)) {
        $filtered_socials = array();
        foreach ($enabled_social_items as $social_id) {
            $social_id = sanitize_key($social_id);
            if (isset($default_socials[$social_id])) {
                $filtered_socials[$social_id] = $default_socials[$social_id];
            }
        }
        // Only use filtered list if it's not empty, otherwise use all items.
        if (!empty($filtered_socials)) {
            $default_socials = $filtered_socials;
        }
    }

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

/**
 * Filter to add description field to social info widget.
 */
add_filter('atbdp_form_preset_widgets', function($widgets)
{
    // Add description field.
    $widgets['social_info']['options']['description'] = array(
        'label'   => __('Instructions', 'directorist-advanced-social-links'),
        'type'    => 'textarea',
        'default' => '',
    );

    return $widgets;
});

/**
 * Brand color of all social icons in an array.
 * @return array Associative array of social network IDs and their brand colors.
 */
function directorist_advanced_social_links_get_brand_color()
{
    $brand_colors = array(
        'facebook'       => '#1877F2',
        'twitter'        => '#000000',
        'linkedin'       => '#0A66C2',
        'pinterest'      => '#E60023',
        'instagram'      => '#E1306C',
        'tumblr'         => '#36465D',
        'flickr'         => '#0063DC',
        'snapchat'       => '#FFFC00',
        'reddit'         => '#FF4500',
        'youtube'        => '#FF0000',
        'vimeo'          => '#1AB7EA',
        'vine'           => '#00B488',
        'github'         => '#181717',
        'dribbble'       => '#EA4C89',
        'behance'        => '#1769FF',
        'soundcloud'     => '#FF5500',
        'stack-overflow' => '#F48024',
        'meetup'         => '#ED1C40',
        'discord'        => '#5865F2',
        'telegram'       => '#0088CC',
        'tiktok'         => '#010101',
        'twitch'         => '#9146FF',
        'medium'         => '#12100E',
        'whatsapp'       => '#25D366',
        'alignable'      => '#663399',
        'threads'        => '#000000',
        'nextdoor'       => '#00B246',
        'yelp'           => '#D32323',
        'google'         => '#4285F4',
        'tripadvisor'    => '#34E0A1',
        'bluesky'        => '#1185FE',
    );     
    return apply_filters('directorist_advanced_social_links_brand_color', $brand_colors);
}

/**
 * On single listing page, add a css class to the social link based on the brand color. on hover effect should be applied.
 */
add_action('wp_head', function() {
    // Check if brand color hover effect is enabled.
    if (!get_directorist_option('enable_brand_color_hover', false)) {
        return;
    }

    if (!is_singular('at_biz_dir')) {
        return;
    }

    $brand_colors = directorist_advanced_social_links_get_brand_color();
    
    if (empty($brand_colors) || !is_array($brand_colors)) {
        return;
    }

    // Build CSS rules.
    $css_rules = array();
    foreach ($brand_colors as $social_id => $color) {
        // Sanitize social ID and color.
        $social_id = sanitize_key($social_id);
        $color     = sanitize_hex_color($color);
        
        if (empty($color)) {
            continue;
        }
        
        $css_rules[] = sprintf(
            '.directorist-custom-social-link.%s:hover { background-color: %s !important; }',
            esc_attr($social_id),
            esc_attr($color)
        );
    }

    if (empty($css_rules)) {
        return;
    }

    ?>
    <style>
        <?php echo implode("\n        ", $css_rules); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
    </style>
    <?php
});