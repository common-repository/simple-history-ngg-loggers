<?php

/**
 * Fired during plugin activation
 *
 * @link       Https://r-fotos.de
 * @since      1.0.0
 *
 * @package    Simple_History_Ngg_Loggers
 * @subpackage Simple_History_Ngg_Loggers/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Simple_History_Ngg_Loggers
 * @subpackage Simple_History_Ngg_Loggers/includes
 * @author     Harald Roeh <hroeh@t-online.de>
 */
class Simple_History_Ngg_Loggers_Activator {

	/**
	 * Activate plugin only when NextGEN gallery and Simple History are also activated. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
  public function activate () {
  	
  	 if ( null == get_option( 'hr_NGL_settings' ) ) {
  	     // no option set yet, init options
  	     $$hr_NGL_options = array() ;
  	     $hr_NGL_options['add_image'] = 1;
  	     $hr_NGL_options['move_image'] = 1;
  	     $hr_NGL_options['copy_image'] = 1;
  	     $hr_NGL_options['delete_image'] = 1;
  	     
  	     $hr_NGL_options['add_gallery'] = 1;
  	     $hr_NGL_options['update_gallery'] = 1;
  	     $hr_NGL_options['delete_gallery'] = 1;
  	     
  	     $hr_NGL_options['add_album'] = 1;
  	     $hr_NGL_options['update_album'] = 1;
  	     $hr_NGL_options['delete_album'] = 1;
  	     
  	     $hr_NGL_options['show_notifications'] = 'both';
//  	     $hr_NGL_options['edit_post'] = 1;
  	     $hr_NGL_options['log_ngg_pictures'] = 1;
  	     $hr_NGL_options['log_ngg_gallery'] = 1;
  	     $hr_NGL_options['log_ngg_album'] = 1;
  	     $hr_NGL_options['never_empty_log'] = 1;
    	     
  	     update_option( 'hr_NGL_settings', $hr_NGL_options );
  	 }
  }

}
