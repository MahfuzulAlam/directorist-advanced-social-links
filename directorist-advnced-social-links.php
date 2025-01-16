<?php

/** 
 * @package  Directorist - Advanced Social Links
 */

/**
 * Plugin Name:       Directorist - Advanced Social Links
 * Plugin URI:        https://wpwax.com
 * Description:       Advanced social links for direcorist plugins
 * Version:           2.0.0
 * Requires at least: 5.2
 * Author:            wpWax
 * Author URI:        https://wpwax.com
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       directorist-tiktok-social
 * Domain Path:       /languages
 */

/* This is an extension for Directorist plugin. It helps using custom code and template overriding of Directorist plugin.*/

/**
 * If this file is called directly, abrot!!!
 */
if (!defined('ABSPATH')) {
    exit;                      // Exit if accessed
}

if (!class_exists('Directorist_Advanced_Social')) {

    final class Directorist_Advanced_Social
    {
        /**
         * Instance
         */
        private static $instance;

        /**
         * Instance
         */
        public static function instance()
        {
            if (!isset(self::$instance) && !(self::$instance instanceof Directorist_Advanced_Social)) {
                self::$instance = new Directorist_Advanced_Social;
                self::$instance->define_constant();
                add_filter('directorist_template', array(self::$instance, 'directorist_template'), 10, 2);
                add_action( 'wp_head', array( self::$instance, 'custom_css' ));
            }
            return self::$instance;
        }

        /**
         * Define
         */
        public function define_constant()
        {
            define('ADVANCED_SOCIAL_URI', plugin_dir_url(__FILE__));
        }

        /**
         * Base Directory
         */
        public function base_dir()
        {
            return plugin_dir_path(__FILE__);
        }

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
            //$data = $args;

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
         * Custom CSS
         */
        public function custom_css()
        {
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

    if (!function_exists('directorist_is_plugin_active')) {
        function directorist_is_plugin_active($plugin)
        {
            return in_array($plugin, (array) get_option('active_plugins', array()), true) || directorist_is_plugin_active_for_network($plugin);
        }
    }

    if (!function_exists('directorist_is_plugin_active_for_network')) {
        function directorist_is_plugin_active_for_network($plugin)
        {
            if (!is_multisite()) {
                return false;
            }

            $plugins = get_site_option('active_sitewide_plugins');
            if (isset($plugins[$plugin])) {
                return true;
            }

            return false;
        }
    }

    function Directorist_Advanced_Social()
    {
        return Directorist_Advanced_Social::instance();
    }

    if (directorist_is_plugin_active('directorist/directorist-base.php')) {
        Directorist_Advanced_Social(); // get the plugin running
    }
}
