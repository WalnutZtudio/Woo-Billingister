<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://walnutztudio.com
 * @since             1.0.0
 * @package           Woo_Billingister
 *
 * @wordpress-plugin
 * Plugin Name:       Woo Billingister
 * Plugin URI:        https://walnutztudio.com
 * Description:       Add billing fields to register page for WooCommerce.
 * Version:           1.0.0
 * Author:            WalnutZtudio
 * Author URI:        https://walnutztudio.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woo billingister
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PLUGIN_NAME_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-woo billingister-activator.php
 */
function activate_woo billingister() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woo billingister-activator.php';
	Woo_Billingister_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-woo billingister-deactivator.php
 */
function deactivate_woo billingister() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woo billingister-deactivator.php';
	Woo_Billingister_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_woo billingister' );
register_deactivation_hook( __FILE__, 'deactivate_woo billingister' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-woo billingister.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_woo billingister() {

	$plugin = new Woo_Billingister();
	$plugin->run();

}
run_woo billingister();
