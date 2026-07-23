<?php
/**
 * Plugin Name:       Advanced Social Links for Directorist
 * Plugin URI:        https://github.com/MahfuzulAlam/directorist-advanced-social-links
 * Description:       Adds more social networks, custom icons, and display controls to Directorist listings.
 * Version:           2.2.0
 * Requires at least: 6.5
 * Requires PHP:      7.4
 * Requires Plugins:  directorist
 * Author:            wpXplore
 * Author URI:        https://wpxplore.com
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       advanced-social-links-for-directorist
 * Domain Path:       /languages
 *
 * @package Directorist_Advanced_Social_Links
 */

defined( 'ABSPATH' ) || exit;

define( 'DIRECTORIST_ADVANCED_SOCIAL_VERSION', '2.2.0' );
define( 'DIRECTORIST_ADVANCED_SOCIAL_PATH', plugin_dir_path( __FILE__ ) );
define( 'DIRECTORIST_ADVANCED_SOCIAL_URI', plugin_dir_url( __FILE__ ) );

require_once DIRECTORIST_ADVANCED_SOCIAL_PATH . 'inc/functions.php';
require_once DIRECTORIST_ADVANCED_SOCIAL_PATH . 'inc/class-directorist-advanced-social-settings.php';
require_once DIRECTORIST_ADVANCED_SOCIAL_PATH . 'inc/class-directorist-advanced-social.php';

/**
 * Get the main plugin instance.
 *
 * @since 2.2.0
 * @return Directorist_Advanced_Social
 */
function directorist_advanced_social_links() {
	return Directorist_Advanced_Social::instance();
}

/**
 * Backward-compatible instance accessor.
 *
 * @since 1.0.0
 * @deprecated 2.2.0 Use directorist_advanced_social_links().
 * @return Directorist_Advanced_Social
 */
function Directorist_Advanced_Social() { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName.FunctionNameInvalid
	return directorist_advanced_social_links();
}

/**
 * Initialize after all active plugins are loaded.
 *
 * @return void
 */
function directorist_advanced_social_links_bootstrap() {
	if ( ! function_exists( 'ATBDP' ) ) {
		add_action( 'admin_notices', 'directorist_advanced_social_links_dependency_notice' );
		return;
	}

	directorist_advanced_social_links();
}
add_action( 'plugins_loaded', 'directorist_advanced_social_links_bootstrap', 20 );

/**
 * Show a fallback dependency notice on WordPress versions that do not enforce
 * the Requires Plugins header.
 *
 * @return void
 */
function directorist_advanced_social_links_dependency_notice() {
	if ( ! current_user_can( 'activate_plugins' ) ) {
		return;
	}

	?>
	<div class="notice notice-error">
		<p>
			<?php
			esc_html_e(
				'Advanced Social Links for Directorist requires the Directorist plugin to be installed and active.',
				'advanced-social-links-for-directorist'
			);
			?>
		</p>
	</div>
	<?php
}
