<?php
/**
 * Plugin Name: Custom Plugin
 * Plugin URI: https://your-website.com/
 * Description: A clear and concise description of your plugin's functionality.
 * Version: 1.0.0
 * Author: Your Name
 * Author URI: https://your-website.com/
 * License: GPLv2 or GPLv3 (Choose the appropriate license)
 * Text Domain: custom-plugin (Use a unique text domain to avoid conflicts)
 *
 * @package Custom Plugin
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if (!class_exists('CTP')) {
    class CTP
    {
        /**
         * Plugin version for tracking and updates.
         *
         * @var string
         */
        private string $version = '1.0.0';

        public function __construct()
        {
            require_once(ABSPATH . "/wp-load.php");
            require_once(ABSPATH . "/wp-includes/pluggable.php");
            $this->instantiate();
        }

        /**
         * @return void
         */
        private function instantiate(): void
        {
            $this->ctl_define('CTL_DIR', plugin_dir_path(__FILE__));
            $this->ctl_define('CTL_PATH', plugin_dir_url(__FILE__));
            $this->ctl_define('CTL_BASENAME', plugin_basename(__FILE__));

            //------Include functions-----
            include_once CTL_DIR . 'includes/ctl-utility-functions.php';
        }

        /**
         * @param       $name
         * @param mixed $value
         *
         * @return void
         */
        public function ctl_define($name, mixed $value = true): void
        {
            if (!defined($name)) {
                define($name, $value);
            }
        }
    }

    /**
     * Instantiate the class when the plugin is activated.
     *
     * @return void
     */
    function active_ctl_plugin(): void
    {
        // Instantiate the class.
        $ctl_instances = new CTP();
    }

    // Instantiate the plugin when WordPress starts.
    register_activation_hook(__FILE__, 'active_ctl_plugin'); // Hook for activation.
    active_ctl_plugin();
}

