<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       Https://r-fotos.de
 * @since      1.0.0
 *
 * @package    Simple_History_Ngg_Loggers
 * @subpackage Simple_History_Ngg_Loggers/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Simple_History_Ngg_Loggers
 * @subpackage Simple_History_Ngg_Loggers/includes
 * @author     Harald Roeh <hroeh@t-online.de>
 */
class Simple_History_Ngg_Loggers_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'simple-history-ngg-loggers',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
