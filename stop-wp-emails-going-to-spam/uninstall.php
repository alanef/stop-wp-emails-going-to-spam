<?php
/**
 * Fired when the plugin is deleted.
 *
 * WordPress runs this file in preference to any registered uninstall hook, and removes the
 * entry an older version left in the uninstall_plugins option. Removes the plugin's settings
 * and the opt-in library's status option, which the library no longer cleans up itself
 * (since 1.3.0).
 *
 * @package stop-wp-emails-going-to-spam
 */

// Exit if not called by WordPress during uninstall.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	die;
}

require_once plugin_dir_path( __FILE__ ) . 'includes/vendor/autoload.php';

delete_option( 'stop-wp-emails-going-to-spam-settings-1' );
\Fullworks_Free_Plugin_Lib\Main::plugin_uninstall( 'SWEGTS' );
