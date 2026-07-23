<?php
/**
 * Settings integration.
 *
 * @package Directorist_Advanced_Social_Links
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Directorist_Advanced_Social_Settings' ) ) {
	/**
	 * Register settings with Directorist.
	 */
	class Directorist_Advanced_Social_Settings {
		/**
		 * Register hooks.
		 */
		public function __construct() {
			add_filter(
				'atbdp_extension_settings_submenu',
				array( $this, 'add_extension_settings_submenu' )
			);
			add_filter(
				'atbdp_listing_type_settings_field_list',
				array( $this, 'add_social_items_field' )
			);
		}

		/**
		 * Add the extension settings submenu.
		 *
		 * @param array $submenu Existing submenu items.
		 * @return array
		 */
		public function add_extension_settings_submenu( $submenu ) {
			if ( ! is_array( $submenu ) ) {
				return $submenu;
			}

			$submenu['advanced_social_links_submenu'] = array(
				'label'    => __( 'Advanced Social Links', 'advanced-social-links-for-directorist' ),
				'icon'     => '<i class="fas fa-share-alt" aria-hidden="true"></i>',
				'sections' => apply_filters(
					'atbdp_advanced_social_links_settings_controls',
					array(
						'general_section' => array(
							'title'       => __( 'Social Links Settings', 'advanced-social-links-for-directorist' ),
							'description' => __( 'Choose the social networks available in the listing form.', 'advanced-social-links-for-directorist' ),
							'fields'      => array(
								'enable_brand_color_hover',
								'advanced_social_links_items',
							),
						),
					)
				),
			);

			return $submenu;
		}

		/**
		 * Add the extension fields to Directorist's settings registry.
		 *
		 * @param array $fields Existing settings fields.
		 * @return array
		 */
		public function add_social_items_field( $fields ) {
			if ( ! is_array( $fields ) ) {
				return $fields;
			}

			$social_items = directorist_advanced_social_links_get_all_social_items();

			if ( ! is_array( $social_items ) || ! $social_items ) {
				return $fields;
			}

			$social_options = array();

			foreach ( $social_items as $social_id => $social_label ) {
				$social_id = sanitize_key( $social_id );

				if ( ! $social_id ) {
					continue;
				}

				$social_options[] = array(
					'label' => sanitize_text_field( $social_label ),
					'value' => $social_id,
				);
			}

			$default_values = array_map( 'sanitize_key', array_keys( $social_items ) );
			$saved_value    = get_directorist_option(
				'advanced_social_links_items',
				$default_values
			);

			if ( ! is_array( $saved_value ) ) {
				$saved_value = $default_values;
			}

			$fields['enable_brand_color_hover'] = array(
				'label'       => __( 'Enable Brand Color Hover Effect', 'advanced-social-links-for-directorist' ),
				'type'        => 'toggle',
				'value'       => (bool) get_directorist_option( 'enable_brand_color_hover', false ),
				'description' => __( 'Use each social network’s brand color when a visitor hovers over its link.', 'advanced-social-links-for-directorist' ),
			);

			$fields['advanced_social_links_items'] = array(
				'label'       => __( 'Available Social Networks', 'advanced-social-links-for-directorist' ),
				'type'        => 'checkbox',
				'value'       => array_map( 'sanitize_key', $saved_value ),
				'options'     => $social_options,
				'description' => __( 'Choose which social networks listing authors can add.', 'advanced-social-links-for-directorist' ),
			);

			return $fields;
		}
	}
}
