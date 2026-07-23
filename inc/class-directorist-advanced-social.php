<?php
/**
 * Main plugin class.
 *
 * @package Directorist_Advanced_Social_Links
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Directorist_Advanced_Social' ) ) {
	/**
	 * Main plugin class.
	 *
	 * @since 1.0.0
	 */
	final class Directorist_Advanced_Social {
		/**
		 * Plugin instance.
		 *
		 * @var Directorist_Advanced_Social|null
		 */
		private static $instance = null;

		/**
		 * Get the singleton instance.
		 *
		 * @return Directorist_Advanced_Social
		 */
		public static function instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
				self::$instance->register_hooks();
			}

			return self::$instance;
		}

		/**
		 * Prevent direct construction.
		 */
		private function __construct() {}

		/**
		 * Register plugin hooks.
		 *
		 * @return void
		 */
		private function register_hooks() {
			new Directorist_Advanced_Social_Settings();

			add_filter(
				'directorist_template_file_path',
				array( $this, 'filter_template_file_path' ),
				20,
				3
			);
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ), 20 );
		}

		/**
		 * Use the plugin templates for the supported Directorist views.
		 *
		 * A theme can override these files by placing them under:
		 * advanced-social-links-for-directorist/{template-name}.php
		 *
		 * @param string $template      Resolved Directorist template path.
		 * @param string $template_name Directorist template name.
		 * @param array  $template_args Template arguments.
		 * @return string
		 */
		public function filter_template_file_path( $template, $template_name, $template_args ) {
			unset( $template_args );

			$templates = array(
				'listing-form/fields/social_info' => 'listing-form/fields/social-info.php',
				'listing-form/social-item'        => 'listing-form/social-item.php',
				'single/fields/social_info'       => 'single/fields/social-info.php',
			);

			if ( ! is_string( $template_name ) || ! isset( $templates[ $template_name ] ) ) {
				return $template;
			}

			$theme_template = locate_template(
				'advanced-social-links-for-directorist/' . $templates[ $template_name ]
			);

			if ( $theme_template ) {
				return $theme_template;
			}

			return DIRECTORIST_ADVANCED_SOCIAL_PATH . 'templates/' . $templates[ $template_name ];
		}

		/**
		 * Add frontend styles to Directorist's registered stylesheet.
		 *
		 * @return void
		 */
		public function enqueue_styles() {
			if ( ! defined( 'ATBDP_POST_TYPE' ) || ! is_singular( ATBDP_POST_TYPE ) ) {
				return;
			}

			$css = directorist_advanced_social_links_get_inline_css();

			if ( $css ) {
				wp_add_inline_style( 'directorist-main-style', $css );
			}
		}
	}
}
