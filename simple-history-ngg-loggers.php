<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://r-fotos.de/wordpress-plugins
 * @since             1.0.0
 * @package           Simple_History_NGG_Loggers
 *
 * @wordpress-plugin
 * Plugin Name:       Simple History NGG Loggers
 * Plugin URI:        https://r-fotos.de/wordpress-plugins/simple-history-ngg-loggers/
 * Description:       This plugin is an extension of the Simple History plugin. It adds specific loggers for NextGEN Gallery user activities like uploading / deleting / moving / copying images.
 * Version:           1.2
 * Author:            Harald R&ouml;h
 * Author URI:        https://r-fotos.de
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       simple-history-ngg-loggers
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-simple-history-ngg-loggers-activator.php
 */
function activate_simple_history_ngg_loggers() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-simple-history-ngg-loggers-activator.php';
	Simple_History_Ngg_Loggers_Activator::activate();
}

register_activation_hook( __FILE__, 'activate_simple_history_ngg_loggers' );

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-simple-history-ngg-loggers-deactivator.php
 */
function deactivate_simple_history_ngg_loggers() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-simple-history-ngg-loggers-deactivator.php';
	Simple_History_Ngg_Loggers_Deactivator::deactivate();
}

register_deactivation_hook( __FILE__, 'deactivate_simple_history_ngg_loggers' );
 
/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-simple-history-ngg-loggers.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_simple_history_ngg_loggers() {

	$plugin = new Simple_History_Ngg_Loggers();
	$plugin->run();

}
run_simple_history_ngg_loggers();
