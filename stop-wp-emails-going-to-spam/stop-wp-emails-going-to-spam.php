<?php

/**
 *
 *
 *
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 *
 * Plugin Name:       Stop WP Emails Going to Spam
 * Plugin URI:        http://fullworks.net/wordpress-plugins/stop-wp-emails-going-to-spam/
 * Description:       Fixes WordPress PHP-Mailer emails going to spam/junk folders. The default settings often resolve the issue.
 * Version:           2.2
 * Author:            Alan Fuller
 * Author URI:        http://fullworks.net/
 * License:           GPL-3.0+
 * Requires at least: 4.8.1
 * Requires PHP: 7.4
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       stop-wp-emails-going-to-spam
 * Domain Path:       /languages
 *
 * @package stop-wp-emails-going-to-spam
 */

namespace Stop_Wp_Emails_Going_To_Spam;

use Fullworks_WP_Autoloader\AutoloaderPlugin;
use \Stop_Wp_Emails_Going_To_Spam\Includes\Core;

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}
if (!function_exists('Stop_Wp_Emails_Going_To_Spam\run_Stop_Wp_Emails_Going_To_Spam')) {
    define('STOP_WP_EMAILS_GOING_TO_SPAM_PLUGIN_DIR', plugin_dir_path(__FILE__));
    define('STOP_WP_EMAILS_GOING_TO_SPAM_PLUGIN_VERSION', '2.2');

// Include the autoloader so we can dynamically include the classes.
	require_once STOP_WP_EMAILS_GOING_TO_SPAM_PLUGIN_DIR . 'includes/vendor/autoload.php';
	new AutoloaderPlugin(__NAMESPACE__, __DIR__);

    /**
     * Begins execution of the plugin.
     */
    function run_Stop_Wp_Emails_Going_To_Spam()
    {

	    /**
	     * The code that runs during plugin activation.
	     * This action is documented in includes/class-activator.php
	     */
	    register_activation_hook(__FILE__, array('\Stop_Wp_Emails_Going_To_Spam\Includes\Activator', 'activate'));



	    /**
	     * The code that runs during plugin uninstall.
	     * This action is documented in includes/class-uninstall.php
	     */
	    register_uninstall_hook(__FILE__, array('\Stop_Wp_Emails_Going_To_Spam\Includes\Uninstall', 'uninstall'));
	    ;
	    new \Fullworks_Free_Plugin_Lib\Main('stop-wp-emails-going-to-spam/stop-wp-emails-going-to-spam.php',
		    admin_url( 'options-general.php?page=stop-wp-emails-going-to-spam-settings' ),
		    'SWEGTS',
		    'stop-wp-emails-going-to-spam-settings',
		    'Stop WP Emails Going to Spam'
	    );
        /**
         * The core plugin class that is used to define internationalization,
         * admin-specific hooks, and public-facing site hooks.
         */
        $plugin = new Core();
        $plugin->run();
    }

    run_Stop_Wp_Emails_Going_To_Spam();
}  else {
    die( esc_html__( 'Cannot execute as the plugin already exists', 'stop-wp-emails-going-to-spam' ) );
}

