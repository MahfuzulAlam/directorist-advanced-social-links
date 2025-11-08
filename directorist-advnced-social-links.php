<?php
/**
 * Plugin Name:       Directorist - Advanced Social Links
 * Plugin URI:        https://wpxplore.com/tools/directorist-advanced-social-links
 * Description:       Advanced social links for Directorist plugins
 * Version:           2.0.0
 * Requires at least: 5.2
 * Author:            wpXplore
 * Author URI:        https://wpxplore.com
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       directorist-advanced-social-links
 * Domain Path:       /languages
 *
 * @package Directorist_Advanced_Social_Links
 */

/**
 * This is an extension for Directorist plugin.
 * It helps using custom code and template overriding of Directorist plugin.
 */

/**
 * If this file is called directly, abort.
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if (!class_exists('Directorist_Advanced_Social')) {

    /**
     * Main plugin class for Directorist Advanced Social Links.
     *
     * @since 1.0.0
     */
    final class Directorist_Advanced_Social
    {
        /**
         * Plugin instance.
         *
         * @var Directorist_Advanced_Social
         */
        private static $instance;

        /**
         * Get the singleton instance of the plugin.
         *
         * @return Directorist_Advanced_Social Plugin instance.
         */
        public static function instance()
        {
            if (!isset(self::$instance) && !(self::$instance instanceof Directorist_Advanced_Social)) {
                self::$instance = new Directorist_Advanced_Social();
                self::$instance->define_constant();
                self::$instance->includes();
                self::$instance->init_settings();
                add_filter('directorist_template', array(self::$instance, 'directorist_template'), 10, 2);
                add_action('wp_head', array(self::$instance, 'custom_css'));
            }
            return self::$instance;
        }

        /**
         * Define plugin constants.
         *
         * @since 1.0.0
         */
        public function define_constant()
        {
            if (!defined('DIRECTORIST_ADVANCED_SOCIAL_URI')) {
                define('DIRECTORIST_ADVANCED_SOCIAL_URI', plugin_dir_url(__FILE__));
            }
        }

        /**
         * Include required files.
         *
         * @since 1.0.0
         */
        private function includes()
        {
            $functions_file = $this->base_dir() . 'inc/functions.php';
            if (file_exists($functions_file)) {
                require_once $functions_file;
            }

            $settings_file = $this->base_dir() . 'inc/class-settings.php';
            if (file_exists($settings_file)) {
                require_once $settings_file;
            }
        }

        /**
         * Initialize settings.
         *
         * @since 1.0.0
         */
        private function init_settings()
        {
            if (class_exists('Directorist_Advanced_Social_Settings')) {
                new Directorist_Advanced_Social_Settings();
            }
        }

        /**
         * Get the base directory path of the plugin.
         *
         * @return string Plugin directory path.
         */
        public function base_dir()
        {
            return plugin_dir_path(__FILE__);
        }

        /**
         * Check if a template file exists.
         *
         * @param string $template_file Template file name (without .php extension).
         * @return bool True if template exists, false otherwise.
         */
        /**
         * Template Exists
         */
        public function template_exists($template_file)
        {
            $file = $this->base_dir() . '/templates/' . $template_file . '.php';

            if (file_exists($file)) {
                return true;
            } else {
                return false;
            }
        }

        /**
         * Get Template
         */
        public function get_template($template_file, $args = array())
        {
            if (is_array($args)) {
                extract($args);
            }

            if (isset($args['form'])) $listing_form = $args['form'];

            $file = $this->base_dir() . '/templates/' . $template_file . '.php';

            if ($this->template_exists($template_file)) {
                include $file;
            }
        }

        /**
         * Directorist Template
         */
        public function directorist_template($template, $field_data)
        {
            if ($this->template_exists($template)) $template = $this->get_template($template, $field_data);
            return $template;
        }

        /**
         * Output custom CSS for social icons on single listing pages.
         *
         * @since 1.0.0
         */
        public function custom_css()
        {
            if (is_singular('at_biz_dir')) {
                ?>
                <style>
                    .directorist-custom-social-icon {
                        filter: invert(23%) sepia(0%) saturate(0%) hue-rotate(0deg) brightness(25%) !important;
                    }
                    .directorist-custom-social-link:hover > .directorist-custom-social-icon {
                        filter: unset !important;
                    }
                </style>
                <?php
            }
        }
    }

    /**
     * Check if a plugin is active.
     *
     * @param string $plugin Plugin basename (e.g., 'plugin-folder/plugin-file.php').
     * @return bool True if plugin is active, false otherwise.
     */
    if (!function_exists('directorist_is_plugin_active')) {
        function directorist_is_plugin_active($plugin)
        {
            if (empty($plugin) || !is_string($plugin)) {
                return false;
            }

            return in_array($plugin, (array) get_option('active_plugins', array()), true) || directorist_is_plugin_active_for_network($plugin);
        }
    }

    /**
     * Check if a plugin is active for the entire network (multisite).
     *
     * @param string $plugin Plugin basename (e.g., 'plugin-folder/plugin-file.php').
     * @return bool True if plugin is network active, false otherwise.
     */
    if (!function_exists('directorist_is_plugin_active_for_network')) {
        function directorist_is_plugin_active_for_network($plugin)
        {
            if (empty($plugin) || !is_string($plugin)) {
                return false;
            }

            if (!is_multisite()) {
                return false;
            }

            $plugins = get_site_option('active_sitewide_plugins', array());
            if (isset($plugins[$plugin])) {
                return true;
            }

            return false;
        }
    }

    /**
     * Get the main plugin instance.
     *
     * @return Directorist_Advanced_Social Plugin instance.
     */
    function Directorist_Advanced_Social()
    {
        return Directorist_Advanced_Social::instance();
    }

    // Initialize the plugin if Directorist is active.
    if (directorist_is_plugin_active('directorist/directorist-base.php')) {
        Directorist_Advanced_Social();
    }
}
