<?php
/**
 * Public helper functions.
 *
 * @package Directorist_Advanced_Social_Links
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Get every available social network.
 *
 * @return array<string,string> Network IDs and labels.
 */
function directorist_advanced_social_links_get_all_social_items() {
	$extras = array(
		'meetup'      => __( 'Meetup.com', 'advanced-social-links-for-directorist' ),
		'discord'     => __( 'Discord', 'advanced-social-links-for-directorist' ),
		'telegram'    => __( 'Telegram', 'advanced-social-links-for-directorist' ),
		'tiktok'      => __( 'TikTok', 'advanced-social-links-for-directorist' ),
		'twitch'      => __( 'Twitch', 'advanced-social-links-for-directorist' ),
		'medium'      => __( 'Medium', 'advanced-social-links-for-directorist' ),
		'whatsapp'    => __( 'WhatsApp', 'advanced-social-links-for-directorist' ),
		'alignable'   => __( 'Alignable', 'advanced-social-links-for-directorist' ),
		'threads'     => __( 'Threads', 'advanced-social-links-for-directorist' ),
		'nextdoor'    => __( 'Nextdoor', 'advanced-social-links-for-directorist' ),
		'yelp'        => __( 'Yelp', 'advanced-social-links-for-directorist' ),
		'google'      => __( 'Google Review', 'advanced-social-links-for-directorist' ),
		'tripadvisor' => __( 'Tripadvisor', 'advanced-social-links-for-directorist' ),
		'bluesky'     => __( 'Bluesky', 'advanced-social-links-for-directorist' ),
	);

	$default_socials = array();
	$directorist     = ATBDP();

	if (
		is_object( $directorist )
		&& isset( $directorist->helper )
		&& is_callable( array( $directorist->helper, 'social_links' ) )
	) {
		$directorist_socials = $directorist->helper->social_links();

		if ( is_array( $directorist_socials ) ) {
			$default_socials = $directorist_socials;
		}
	}

	/**
	 * Filter all available networks before settings are applied.
	 *
	 * @param array<string,string> $social_items Available networks.
	 */
	return apply_filters(
		'directorist_advanced_social_links_all_items',
		array_merge( $default_socials, $extras )
	);
}

/**
 * Get the social networks enabled in plugin settings.
 *
 * @return array<string,string> Enabled network IDs and labels.
 */
function directorist_advanced_social_links_get_social_items() {
	$all_socials = directorist_advanced_social_links_get_all_social_items();

	if ( ! is_array( $all_socials ) ) {
		$all_socials = array();
	}

	$enabled_items = get_directorist_option(
		'advanced_social_links_items',
		array_keys( $all_socials )
	);

	if ( ! is_array( $enabled_items ) ) {
		$enabled_items = array_keys( $all_socials );
	}

	$filtered_socials = array();

	foreach ( $enabled_items as $social_id ) {
		$social_id = sanitize_key( $social_id );

		if ( isset( $all_socials[ $social_id ] ) ) {
			$filtered_socials[ $social_id ] = $all_socials[ $social_id ];
		}
	}

	/**
	 * Filter the networks shown in the listing form.
	 *
	 * @param array<string,string> $filtered_socials Enabled networks.
	 */
	return apply_filters(
		'directorist_advanced_social_links_items',
		$filtered_socials
	);
}

/**
 * Sanitize a whitespace-separated list of CSS classes.
 *
 * @param string $classes CSS classes.
 * @return string
 */
function directorist_advanced_social_links_sanitize_classes( $classes ) {
	$classes = preg_split( '/\s+/', (string) $classes );
	$classes = array_filter( array_map( 'sanitize_html_class', $classes ) );

	return implode( ' ', $classes );
}

/**
 * Output a social network icon.
 *
 * @param string $social_id Network identifier.
 * @return void
 */
function directorist_advanced_social_links_get_social_icon( $social_id ) {
	$social_id = sanitize_key( $social_id );

	if ( ! $social_id ) {
		return;
	}

	/**
	 * Filter the network IDs that use bundled SVG icons.
	 *
	 * An SVG named after each ID must exist in assets/icon.
	 *
	 * @param string[] $custom_icons Network IDs.
	 */
	$custom_icons = apply_filters(
		'directorist_advanced_social_links_custom_icons',
		array( 'tiktok', 'alignable', 'threads', 'nextdoor', 'bluesky' )
	);

	if ( ! is_array( $custom_icons ) ) {
		$custom_icons = array();
	}

	$custom_icons = array_map( 'sanitize_key', $custom_icons );
	$icon_file    = DIRECTORIST_ADVANCED_SOCIAL_PATH . 'assets/icon/' . $social_id . '.svg';

	if ( in_array( $social_id, $custom_icons, true ) && is_readable( $icon_file ) ) {
		$output = sprintf(
			'<img class="directorist-custom-social-icon" width="15" height="15" src="%s" alt="" aria-hidden="true">',
			esc_url( DIRECTORIST_ADVANCED_SOCIAL_URI . 'assets/icon/' . $social_id . '.svg' )
		);

		/**
		 * Filter the custom icon HTML.
		 *
		 * Unsupported tags and attributes are removed before output.
		 *
		 * @param string $output    Icon HTML.
		 * @param string $social_id Network identifier.
		 */
		$output = apply_filters(
			'directorist_advanced_social_links_icon_output',
			$output,
			$social_id
		);

		echo wp_kses(
			$output,
			array(
				'img' => array(
					'class'       => true,
					'width'       => true,
					'height'      => true,
					'src'         => true,
					'alt'         => true,
					'aria-hidden' => true,
				),
			)
		);
		return;
	}

	/**
	 * Filter the Directorist icon classes for a network.
	 *
	 * @param string $icon_class Icon classes.
	 * @param string $social_id  Network identifier.
	 */
	$icon_class = apply_filters(
		'directorist_advanced_social_links_default_icon_class',
		'lab la-' . $social_id,
		$social_id
	);
	$icon_class = directorist_advanced_social_links_sanitize_classes( $icon_class );

	if ( $icon_class && function_exists( 'directorist_icon' ) ) {
		directorist_icon( $icon_class );
	}
}

/**
 * Add an instructions option to Directorist's social information widget.
 *
 * @param array $widgets Preset widgets.
 * @return array
 */
function directorist_advanced_social_links_add_widget_description( $widgets ) {
	if (
		! is_array( $widgets )
		|| ! isset( $widgets['social_info'] )
		|| ! is_array( $widgets['social_info'] )
	) {
		return $widgets;
	}

	if ( ! isset( $widgets['social_info']['options'] ) || ! is_array( $widgets['social_info']['options'] ) ) {
		$widgets['social_info']['options'] = array();
	}

	$widgets['social_info']['options']['description'] = array(
		'label'   => __( 'Instructions', 'advanced-social-links-for-directorist' ),
		'type'    => 'textarea',
		'default' => '',
	);

	return $widgets;
}
add_filter( 'atbdp_form_preset_widgets', 'directorist_advanced_social_links_add_widget_description' );

/**
 * Get social network brand colors.
 *
 * @return array<string,string> Network IDs and hexadecimal colors.
 */
function directorist_advanced_social_links_get_brand_color() {
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

	/**
	 * Filter social network brand colors.
	 *
	 * @param array<string,string> $brand_colors Network colors.
	 */
	return apply_filters(
		'directorist_advanced_social_links_brand_color',
		$brand_colors
	);
}

/**
 * Build the plugin's inline frontend CSS.
 *
 * @return string
 */
function directorist_advanced_social_links_get_inline_css() {
	$css = '.directorist-custom-social-icon{filter:invert(23%) sepia(0%) saturate(0%) hue-rotate(0deg) brightness(25%)}'
		. '.directorist-custom-social-link:hover>.directorist-custom-social-icon{filter:none}';

	if ( ! get_directorist_option( 'enable_brand_color_hover', false ) ) {
		return $css;
	}

	$brand_colors = directorist_advanced_social_links_get_brand_color();

	if ( ! is_array( $brand_colors ) ) {
		return $css;
	}

	foreach ( $brand_colors as $social_id => $color ) {
		$social_id = sanitize_html_class( $social_id );
		$color     = sanitize_hex_color( $color );

		if ( ! $social_id || ! $color ) {
			continue;
		}

		$css .= sprintf(
			'.directorist-custom-social-link.%s:hover{background-color:%s!important}',
			$social_id,
			$color
		);
	}

	return $css;
}
