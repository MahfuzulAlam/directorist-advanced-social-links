<?php
/**
 * Settings class for Directorist Advanced Social Links.
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
 * Settings class for Advanced Social Links extension.
 *
 * @since 1.0.0
 */
if (!class_exists('Directorist_Advanced_Social_Settings')) {

    class Directorist_Advanced_Social_Settings
    {
        /**
         * Constructor.
         *
         * @since 1.0.0
         */
        public function __construct()
        {
            add_filter('atbdp_extension_settings_submenu', array($this, 'add_extension_settings_submenu'));
            add_filter('atbdp_listing_type_settings_field_list', array($this, 'add_social_items_field'));
        }

        /**
         * Add extension settings submenu.
         *
         * @since 1.0.0
         * @param array $submenu Existing submenu items.
         * @return array Modified submenu items.
         */
        public function add_extension_settings_submenu($submenu)
        {
            // Validate input.
            if (!is_array($submenu)) {
                return $submenu;
            }

            $submenu['advanced_social_links_submenu'] = array(
                'label'    => __('Advanced Social Links', 'directorist-advanced-social-links'),
                'icon'     => '<i class="fas fa-share-alt"></i>',
                'sections' => apply_filters('atbdp_advanced_social_links_settings_controls', array(
                    'general_section' => array(
                        'title'       => __('Social Links Settings', 'directorist-advanced-social-links'),
                        'description' => __('Select which social networks should be available in the listing form.', 'directorist-advanced-social-links'),
                        'fields'      => array('advanced_social_links_items'),
                    ),
                )),
            );

            return $submenu;
        }

        /**
         * Add social items checkbox field to listing type settings.
         *
         * @since 1.0.0
         * @param array $fields Existing fields.
         * @return array Modified fields.
         */
        public function add_social_items_field($fields)
        {
            // Validate input.
            if (!is_array($fields)) {
                return $fields;
            }

            // Get all available social items (without filtering for settings page).
            $social_items = directorist_advanced_social_links_get_all_social_items();

            if (empty($social_items) || !is_array($social_items)) {
                return $fields;
            }

            // Build options array for checkbox field.
            $social_options = array();
            foreach ($social_items as $social_id => $social_label) {
                // Sanitize values.
                $social_id    = sanitize_key($social_id);
                $social_label = sanitize_text_field($social_label);

                $social_options[] = array(
                    'label' => $social_label,
                    'value' => $social_id,
                );
            }

            // Get default selected items (all items by default).
            $default_values = array_keys($social_items);

            // Get saved value or use defaults.
            $saved_value = get_directorist_option('advanced_social_links_items', $default_values);

            // Ensure saved value is an array.
            if (!is_array($saved_value)) {
                $saved_value = $default_values;
            }

            // Add the field.
            $fields['advanced_social_links_items'] = array(
                'label'       => __('Available Social Networks', 'directorist-advanced-social-links'),
                'type'        => 'checkbox',
                'value'       => $saved_value,
                'options'     => $social_options,
                'description' => __('Select which social networks should be available for users to add in their listings.', 'directorist-advanced-social-links'),
            );

            return $fields;
        }
    }
}

