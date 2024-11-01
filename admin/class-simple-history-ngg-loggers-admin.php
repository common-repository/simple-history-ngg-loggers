<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       Https://r-fotos.de
 * @since      1.0.0
 *
 * @package    Simple_History_Ngg_Loggers
 * @subpackage Simple_History_Ngg_Loggers/admin
 */

define('hr_NGL_setting_mode', 'public');  


/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Simple_History_Ngg_Loggers
 * @subpackage Simple_History_Ngg_Loggers/admin
 * @author     Harald Roeh <hroeh@t-online.de>
 */
class Simple_History_Ngg_Loggers_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;


	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version           The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Simple_History_Ngg_Loggers_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Simple_History_Ngg_Loggers_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/simple-history-ngg-loggers-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Simple_History_Ngg_Loggers_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Simple_History_Ngg_Loggers_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/simple-history-ngg-loggers-admin.js', array( 'jquery' ), $this->version, false );

	}

  /**
   * Register the administration menu for this plugin into the WordPress Dashboard menu.
   *
   * @since    1.0.0
   */
   public function hr_NGL_add_admin_menu(  ) { 
  
      /*
       * Add a settings page for this plugin to the Settings menu.
       *
       *  add_options_page( $page_title, $menu_title, $capability, $menu_slug, $function);
       *
       * NOTE:  Alternative menu locations are available via WordPress administration menu functions.
       *
       *        Administration Menus: http://codex.wordpress.org/Administration_Menus
       *
       */
      add_options_page( 'Simple History NGG Loggers', 'Simple History NGG Loggers', 'manage_options', 'simple_history_ngg_loggers', 'hr_NGL_options_page' );
      
   }
 
 
   /**
   * Add settings action link to the plugins page.
   * Documentation : https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
   * @since    1.0.0
   */
   public function hr_NGL_add_action_links( $links ) {
     $settings_link = array(
      '<a href="' . admin_url( 'options-general.php?page=' . 'simple_history_ngg_loggers' ) . '">' . __('Settings', $this->plugin_name) . '</a>',
     );
     return array_merge( $links, $settings_link );
   }  

   /**
   * Issue warnings, if either of the needed plugins Simple History or NextGEN Gallery is not installed or not activated
   * @since    1.0.0
   */
   public function hr_NGL_check_plugins(  ) {
     	global $pagenow;
     	$hr_NGL_options = get_option( 'hr_NGL_settings');
     	$hr_NGL_show_warnings = false;
     	
     	if ( isset( $hr_NGL_options['show_notifications'] ) ) {
    		 switch ( $hr_NGL_options['show_notifications'] ) {
     		 	  case "none":
     		 	      // show no warnings
     		 	      break;
     		 	  case "only option":
              	// show warnings only on own settings page
     	          if ( ($pagenow == 'options-general.php') && isset($_GET['page']) && ($_GET['page'] == 'simple_history_ngg_loggers') ) {
     	             $hr_NGL_show_warnings = true;
     	          }   	
     		        break;
     		 	  case "both":
               	// show warnings only on plugin page or on own settings page
     		 	      if ( ($pagenow == 'plugins.php') || 
     	             ( ($pagenow == 'options-general.php') && isset($_GET['page']) && ($_GET['page'] == 'simple_history_ngg_loggers') ) ) {
     	             $hr_NGL_show_warnings = true;
     	          }   	
     		 	      break;
     		 	  default:
     		 	      echo "-----> ", "Unexpected value for option show_notifications", "<br>";
     		 }
    	}
  	
//     	var_dump("Variable pagenow: ", $pagenow); echo "<br><br>";
//     	var_dump("Aufrufparameter _GET: ", $_GET); echo "<br><br>";
//      __( 'xxxx', 'simple-history-ngg-loggers' ),
     	
     	// show warnings only on plugin page or on own settings page
     	if ( $hr_NGL_show_warnings ) {
     		// check if nextgen gallery plugin is installed		
     		if (get_plugins('/nextgen-gallery')) {
     			
       		// check if nextgen gallery plugin is activated
       		if (!is_plugin_active('nextgen-gallery/nggallery.php')) {
            // nextgen gallery is not activated, issue warning
       			$hr_NGL_warning = '<div class="notice notice-warning is-dismissible"><p>';
       			$hr_NGL_warning.= '<b>' . __( 'Warning:', 'simple-history-ngg-loggers' ) . ' </b>';
       			$hr_NGL_warning.= sprintf( __( 'Simple History NGG Loggers is an add-on for the %1$s WordPress plugin, but <b>%1$s is not <i>activated</i></b>.', 'simple-history-ngg-loggers' ), 'NextGEN Gallery' );
       			$hr_NGL_warning.= '<br /></p></div>';
       			
       			echo $hr_NGL_warning;
       		}	

       		// check if nextgen gallery plugin has version 2.1.43 or newer
          $hr_NGL_NextGEN_version = get_plugins('/nextgen-gallery')['nggallery.php']['Version'];
          if (version_compare($hr_NGL_NextGEN_version, '2.1.43', '<')) {
       			$hr_NGL_warning = '<div class="notice notice-warning is-dismissible"><p>';
       			$hr_NGL_warning.= '<b>' . __( 'Warning:', 'simple-history-ngg-loggers' ) . ' </b>';
       			$hr_NGL_warning.= sprintf( __( 'NextGEN Gallery version 2.1.43 needed or higher for full functionality. You only have version %s. Please upgrade NextGEN Gallery.', 'simple-history-ngg-loggers' ), $hr_NGL_NextGEN_version );
       			$hr_NGL_warning.= '<br /></p></div>';
       			
       			echo $hr_NGL_warning;
          }
     		} else {
          //  nextgen gallery is not installed, issue warning
       			$hr_NGL_warning = '<div class="notice notice-error"><p>';
       			$hr_NGL_warning.= '<b>' . __( 'Error:', 'simple-history-ngg-loggers' ) . ' </b>';
       			$hr_NGL_warning.= sprintf( __( 'Simple History NGG Loggers is an add-on for the %1$s WordPress plugin, but <b>%1$s is not <i>installed</i></b>.', 'simple-history-ngg-loggers' ), 'NextGEN Gallery' );
     			  $hr_NGL_warning.= '<br /></p></div>';
     			
     			echo $hr_NGL_warning;
     		}
     		
     		// check if simple history plugin is installed		
   			$hr_NGL_plugin = 'Simple History' ;
     		if (get_plugins('/simple-history')) {
     			
       		// check if simple history plugin is activated
       		if (!is_plugin_active('simple-history/index.php')) {
            // simple history plugin is installed, but not activated, issue warning
       			$hr_NGL_warning = '<div class="notice notice-warning is-dismissible"><p>';
       			$hr_NGL_warning.= '<b>' . __( 'Warning:', 'simple-history-ngg-loggers' ) . ' </b>';
       			$hr_NGL_warning.= sprintf( __( 'Simple History NGG Loggers is an add-on for the %1$s WordPress plugin, but <b>%1$s is not <i>activated</i></b>.', 'simple-history-ngg-loggers' ), $hr_NGL_plugin );
       			$hr_NGL_warning.= '</p></div>';
       			
       			echo $hr_NGL_warning;
       		}
     		} else {
          //  simple history plugin is not installed, issue error
       			$hr_NGL_warning = '<div class="notice notice-error"><p>';
       			$hr_NGL_warning.= '<b>' . __( 'Error:', 'simple-history-ngg-loggers' ) . ' </b>';
       			$hr_NGL_warning.= sprintf( __( 'Simple History NGG Loggers is an add-on for the %1$s WordPress plugin, but <b>%1$s is not <i>installed</i></b>.', 'simple-history-ngg-loggers' ), $hr_NGL_plugin );
       			$hr_NGL_warning.= '</p></div>';
     			
     			echo $hr_NGL_warning;
     		}

    	}	     
   }  

  
  /**
   * Register sections and fields for the settings page of this plugin.
   *
   * @since    1.0.0
   */
  public function hr_NGL_settings_init(  ) { 
  
//    echo "............................................................... function settings init hr-NGL aufgerufen.<br>";
  
      /* register_setting( $option_group, $option_name, $sanitize_callback );   */
      /*  hint:  option_group  should match option_name  to avoid problems      */
  	register_setting( 'hr_NGL_pluginPage', 'hr_NGL_settings');
  
  	/*  add_settings_section( $id, $title, $callback, $page );  */
  	/*                              */
  	add_settings_section(
  		'hr_NGL_pluginPage_section', 
  		__( 'Logging NextGEN Gallery user activities:', 'simple-history-ngg-loggers' ), 
  		'hr_NGL_settings_section_callback', 
  		'hr_NGL_pluginPage'
  	);
  
  	add_settings_field( 
  		'hr_NGL_checkbox_image_actions', 
  		__( 'images', 'simple-history-ngg-loggers' ), 
  		'hr_NGL_checkbox_image_actions_render', 
  		'hr_NGL_pluginPage', 
  		'hr_NGL_pluginPage_section' 
  	);
  
  	add_settings_field( 
  		'hr_NGL_checkbox_gallery_actions', 
  		__( 'galleries', 'simple-history-ngg-loggers' ), 
  		'hr_NGL_checkbox_gallery_actions_render', 
  		'hr_NGL_pluginPage', 
  		'hr_NGL_pluginPage_section' 
  	);
  
  	add_settings_field( 
  		'hr_NGL_checkbox_album_actions', 
  		__( 'albums', 'simple-history-ngg-loggers' ), 
  		'hr_NGL_checkbox_album_actions_render', 
  		'hr_NGL_pluginPage', 
  		'hr_NGL_pluginPage_section' 
  	);

  	/*  add_settings_section( $id, $title, $callback, $page );  */
  	/*  second section for miscellaneous                            */
  	add_settings_section(
  		'hr_NGL_pluginPage_section2', 
  		__( 'Miscellaneous options:', 'simple-history-ngg-loggers' ), 
  		'hr_NGL_settings_section2_callback', 
  		'hr_NGL_pluginPage'
  	);
  
  	add_settings_field( 
  		'hr_NGL_radio_show_notifications', 
  		__( 'Show notifications', 'simple-history-ngg-loggers' ), 
  		'hr_NGL_radio_show_notifications_render', 
  		'hr_NGL_pluginPage', 
  		'hr_NGL_pluginPage_section2' 
  	);

  	
  	add_settings_field( 
  		'hr_NGL_checkbox_gallery_links', 
  		__( 'gallery links', 'simple-history-ngg-loggers' ), 
  		'hr_NGL_checkbox_gallery_links_render', 
  		'hr_NGL_pluginPage', 
  		'hr_NGL_pluginPage_section2' 
  	);

  	add_settings_field( 
  		'hr_NGL_checkbox_filter_log_entries', 
  		__( 'filter log entries', 'simple-history-ngg-loggers' ),  
  		'hr_NGL_checkbox_filter_log_entries_render', 
  		'hr_NGL_pluginPage', 
  		'hr_NGL_pluginPage_section2' 
  	);

  	add_settings_field( 
  		'hr_NGL_checkbox_empty_log_intervall', 
  		__( 'empty log intervall', 'simple-history-ngg-loggers' ),  
  		'hr_NGL_checkbox_empty_log_intervall_render', 
  		'hr_NGL_pluginPage', 
  		'hr_NGL_pluginPage_section2' 
  	);

   	if ( hr_NGL_setting_mode == 'modified' ) { 
    	add_settings_field( 
    		'hr_NGL_checkbox_customized_gallery_list', 
    		__( 'customized gallery list', 'simple-history-ngg-loggers' ),  
    		'hr_NGL_checkbox_customized_gallery_list_render', 
    		'hr_NGL_pluginPage', 
    		'hr_NGL_pluginPage_section2' 
    	);

    	add_settings_field( 
    		'hr_NGL_checkbox_save_uploader', 
    		__( 'save uploader', 'simple-history-ngg-loggers' ),  
    		'hr_NGL_checkbox_save_uploader_render', 
    		'hr_NGL_pluginPage', 
    		'hr_NGL_pluginPage_section2' 
    	);

    	add_settings_field( 
    		'hr_NGL_checkbox_log_emails', 
    		__( 'log emails', 'simple-history-ngg-loggers' ),  
    		'hr_NGL_checkbox_log_emails_render', 
    		'hr_NGL_pluginPage', 
    		'hr_NGL_pluginPage_section2' 
    	);
    }

  
  }

	/**
	 * log copied images between NextGEN galleries with simple history
	 * @since    1.0.0
	 */
   public function hr_NGL_log_copied_image($image_pid_map, $old_gallery_ids, $gallery_id) {
   	  
//   	 var_dump("par1 ", $image_pid_map); echo "<br>";
//   	 var_dump("par2 ", $old_gallery_ids); echo "<br>";
//   	 var_dump("par3 ", $gallery_id); echo "<br>";

       // check if logging copy images is activated, otherwise return
       if ( !isset( get_option( 'hr_NGL_settings')['copy_image'] ) ) { return; }
   	  
       foreach ( $image_pid_map as $image_old => $image_copied ) {
            $hr_image        = nggdb::find_image($image_old); 
         	  $hr_image_copied = nggdb::find_image($image_copied);
            $hr_gallery_old  = nggdb::find_gallery($old_gallery_ids[0]);
            $hr_gallery_new  = nggdb::find_gallery($gallery_id);
        	  $context = array( __( "image_id1", "simple-history-ngg-loggers") => $image_old,
                      	      __( "image_title1", "simple-history-ngg-loggers") => $hr_image->alttext,
                 	            __( "image_filename", "simple-history-ngg-loggers") => $hr_image->filename,
                      	      __( "gallery_id1", "simple-history-ngg-loggers") => $old_gallery_ids[0],
                      	      __( "gallery_title1", "simple-history-ngg-loggers") => $hr_gallery_old->title,
                      	      __( "gallery_description1", "simple-history-ngg-loggers") => $hr_gallery_old->galdesc,
                      	      __( "image_id2", "simple-history-ngg-loggers") => $image_copied,
                      	      __( "image_title2", "simple-history-ngg-loggers") => $hr_image->alttext,
                 	            __( "image_filename2", "simple-history-ngg-loggers") => $hr_image_copied->filename,
                      	      __( "gallery_id2", "simple-history-ngg-loggers") => $gallery_id,
                      	      __( "gallery_title2", "simple-history-ngg-loggers") => $hr_gallery_new->title,
                      	      __( "gallery_description2", "simple-history-ngg-loggers") => $hr_gallery_new->galdesc,
                      	      __( "action", "simple-history-ngg-loggers") => "ngg_copied_images"
        	  );
            SimpleLogger()->info( sprintf( __( "copies image %s from gallery %s as image %s to gallery %s.", "simple-history-ngg-loggers"),
                                            "#{" . __( "image_id1", "simple-history-ngg-loggers") . "} '{" . __( "image_title1", "simple-history-ngg-loggers") . "}'",
                                            "#{" . __( "gallery_id1", "simple-history-ngg-loggers") . "} '{" . __( "gallery_title1", "simple-history-ngg-loggers") . "}'", 
                                            "#{" . __( "image_id2", "simple-history-ngg-loggers") . "} '{" . __( "image_title2", "simple-history-ngg-loggers") . "}'",
                                            "#{" . __( "gallery_id2", "simple-history-ngg-loggers") . "} '{" . __( "gallery_title2", "simple-history-ngg-loggers") . "}'" ), $context);
            
            // as an addon: check if backupfile of image exists and is not yet moved/copied to target gallery
            $hr_backupfile_old = $_SERVER['DOCUMENT_ROOT'] . $hr_gallery_old->path . "/" . $hr_image->filename . "_backup" ;
            $hr_backupfile_new = $_SERVER['DOCUMENT_ROOT'] . $hr_gallery_new->path . "/" . $hr_image_copied->filename . "_backup" ;
            if ( ( file_exists($hr_backupfile_old) ) && ( !file_exists($hr_backupfile_new) ) ) {
      		   	  // NextGEN Gallery forgot to move this file, just do it now
      		   	  copy ( $hr_backupfile_old, $hr_backupfile_new ) ;
//      		   	  echo "Kopiere Backupfile " . $hr_backupfile_old . " nach " . $hr_backupfile_new . ".<br>" ;
//      			} else {
//      			    echo "Backupfile " . $hr_backupfile_old . " nicht gefunden oder Backupfile " . $hr_backupfile_new . " existiert schon.<br>" ;
      			}  			  
        }
        return;
   }

	/**
	 * log deleted NextGEN gallery images with simple history
	 * @since    1.0.0
	 */
   public function hr_NGL_log_deleted_image($hr_this_pid, $image) {
               
       // check if logging deleted images is activated, otherwise return
       if ( !isset( get_option( 'hr_NGL_settings')['delete_image'] ) ) { return; }


//      	var_dump("par1 ", $hr_this_pid); echo "<br>";
//     	  var_dump("par2 ", $image); echo "<br>";
//        $image = nggdb::find_image( $hr_this_pid ); 
        $hr_gallery = nggdb::find_gallery($image->gid);
        $context = array( __( "image_id", "simple-history-ngg-loggers") => $hr_this_pid,
                  	      __( "image_title", "simple-history-ngg-loggers") => $image->alttext,
                 	        __( "image_filename", "simple-history-ngg-loggers") => $image->filename,
                  	      __( "gallery_id", "simple-history-ngg-loggers") => $image->gid,
                  	      __( "gallery_title", "simple-history-ngg-loggers") => $hr_gallery->title,
                  	      __( "gallery_description", "simple-history-ngg-loggers") => $hr_gallery->galdesc,
                          __( "action", "simple-history-ngg-loggers") => "ngg_delete_picture"
        );
        SimpleLogger()->info( sprintf( __( "deletes image %s in gallery %s.", "simple-history-ngg-loggers"),
                                       "#{" . __( "image_id", "simple-history-ngg-loggers") . "} '{" . __( "image_title", "simple-history-ngg-loggers") . "}'",
                                       "#{" . __( "gallery_id", "simple-history-ngg-loggers") . "} '{" . __( "gallery_title", "simple-history-ngg-loggers") . "}'" ), $context);
        return;
   }

	/**
	 * log moved images between NextGEN galleries with simple history
	 * @since    1.0.0
	 */
   public function hr_NGL_log_moved_image($images, $old_gallery_ids, $gallery_id) {

       // check if logging moved images is activated, otherwise return
       if ( !isset( get_option( 'hr_NGL_settings')['move_image'] ) ) { return; }

    	 foreach ( $images as $image ) {
    	  
    	      $hr_image        = nggdb::find_image($image); 
            $hr_gallery_old  = nggdb::find_gallery($old_gallery_ids[0]);
            $hr_gallery_new  = nggdb::find_gallery($gallery_id);
        	  $context = array( __( "image_id", "simple-history-ngg-loggers") => $image,
                      	      __( "image_title", "simple-history-ngg-loggers") => $hr_image->alttext,
                 	            __( "image_filename", "simple-history-ngg-loggers") => $hr_image->filename,
                      	      __( "gallery_id1", "simple-history-ngg-loggers") => $old_gallery_ids[0],
                      	      __( "gallery_title1", "simple-history-ngg-loggers") => $hr_gallery_old->title,
                      	      __( "gallery_description1", "simple-history-ngg-loggers") => $hr_gallery_old->galdesc,
                      	      __( "gallery_id2", "simple-history-ngg-loggers") => $gallery_id,
                      	      __( "gallery_title2", "simple-history-ngg-loggers") => $hr_gallery_new->title,
                      	      __( "gallery_description2", "simple-history-ngg-loggers") => $hr_gallery_new->galdesc,
                      	      __( "action", "simple-history-ngg-loggers") => "ngg_moved_images"
        	  );
            SimpleLogger()->info( sprintf( __( "moves image %s from gallery %s to gallery %s.", "simple-history-ngg-loggers"),
                                            "#{" . __( "image_id", "simple-history-ngg-loggers") . "} '{" . __( "image_title", "simple-history-ngg-loggers") . "}'",
                                            "#{" . __( "gallery_id1", "simple-history-ngg-loggers") . "} '{" . __( "gallery_title1", "simple-history-ngg-loggers") . "}'", 
                                            "#{" . __( "gallery_id2", "simple-history-ngg-loggers") . "} '{" . __( "gallery_title2", "simple-history-ngg-loggers") . "}'" ), $context);
            
            // as an addon: check if backupfile of image exists and is not yet moved/copied to target gallery
            $hr_backupfile_old = $_SERVER['DOCUMENT_ROOT'] . $hr_gallery_old->path . "/" . $hr_image->filename . "_backup" ;
            $hr_backupfile_new = $_SERVER['DOCUMENT_ROOT'] . $hr_gallery_new->path . "/" . $hr_image->filename . "_backup" ;
            if ( ( file_exists($hr_backupfile_old) ) && ( !file_exists($hr_backupfile_new) ) ) {
      		   	  // NextGEN Gallery forgot to move this file, just do it now
      		   	  rename ( $hr_backupfile_old, $hr_backupfile_new ) ;
//      		   	  echo "Verschiebe Backupfile " . $hr_backupfile_old . " nach " . $hr_backupfile_new . ".<br>" ;
      			} else {
      			    // check for modified filename while moving
      			    $hr_filename_moved = $hr_image->filename ;
      			    $hr_filename_original = preg_replace( '/-(\d+).jpg/', '.jpg', $hr_filename_moved ) ;
      			    $hr_backupfile_original = $_SERVER['DOCUMENT_ROOT'] . $hr_gallery_old->path . "/" . $hr_filename_original . "_backup" ;
      			    if ( ( $hr_filename_original <> $hr_filename_moved ) &&       // filename was changed during move
      			         ( !file_exists($hr_filename_original) ) &&               // original filename no longer exists
      			         ( file_exists($hr_backupfile_original) ) && ( !file_exists($hr_backupfile_new) ) ) {     // but original backupfile still existent
      			        rename ( $hr_backupfile_original, $hr_backupfile_new ) ;
//      			    } else {
//      			        echo "Backupfile " . $hr_backupfile_old . " oder " . $hr_backupfile_original . " nicht gefunden oder Backupfile " . $hr_backupfile_new . " existiert schon.<br>" ;
      			    }
      			}  			  
       }
        return;
   }

	/**
	 * special action for non ngg initiated internal image move
	 * log moved images between NextGEN galleries with simple history
	 * @since    1.0.0
	 */
   public function hr_NGL_log_movedX_image($art, $old_pid, $old_titel, $old_gid, $old_gid_title, $new_gid, $new_gid_title) {

	      $hr_image        = nggdb::find_image($old_pid); 
        $hr_gallery_old  = nggdb::find_gallery($old_gid);
        $hr_gallery_new  = nggdb::find_gallery($new_gid);
    	  $context = array( __( "image_id", "simple-history-ngg-loggers") => $old_pid,
                  	      __( "image_title", "simple-history-ngg-loggers") => $old_titel,
             	            __( "image_filename", "simple-history-ngg-loggers") => $hr_image->filename,
                  	      __( "gallery_id1", "simple-history-ngg-loggers") => $old_gid,
                  	      __( "gallery_title1", "simple-history-ngg-loggers") => $old_gid_title,
                  	      __( "gallery_description1", "simple-history-ngg-loggers") => $hr_gallery_old->galdesc,
                  	      __( "gallery_id2", "simple-history-ngg-loggers") => $new_gid,
                  	      __( "gallery_title2", "simple-history-ngg-loggers") => $new_gid_title,
                  	      __( "gallery_description2", "simple-history-ngg-loggers") => $hr_gallery_new->galdesc,
                  	      __( "action", "simple-history-ngg-loggers") => "hr_ngg_movedX_images"
    	  );
        SimpleLogger()->info( sprintf( __( "moves image %s from gallery %s to gallery %s.", "simple-history-ngg-loggers"),
                                        "#{" . __( "image_id", "simple-history-ngg-loggers") . "} '{" . __( "image_title", "simple-history-ngg-loggers") . "}'",
                                        "#{" . __( "gallery_id1", "simple-history-ngg-loggers") . "} '{" . __( "gallery_title1", "simple-history-ngg-loggers") . "}'", 
                                        "#{" . __( "gallery_id2", "simple-history-ngg-loggers") . "} '{" . __( "gallery_title2", "simple-history-ngg-loggers") . "}'" ), $context);
        
        // as an addon: check if backupfile of image exists and is not yet moved/copied to target gallery
        $hr_backupfile_old = $_SERVER['DOCUMENT_ROOT'] . $hr_gallery_old->path . "/" . $hr_image->filename . "_backup" ;
        $hr_backupfile_new = $_SERVER['DOCUMENT_ROOT'] . $hr_gallery_new->path . "/" . $hr_image->filename . "_backup" ;
        if ( ( file_exists($hr_backupfile_old) ) && ( !file_exists($hr_backupfile_new) ) ) {
  		   	  // NextGEN Gallery forgot to move this file, just do it now
  		   	  rename ( $hr_backupfile_old, $hr_backupfile_new ) ;
//      		   	  echo "Verschiebe Backupfile " . $hr_backupfile_old . " nach " . $hr_backupfile_new . ".<br>" ;
//      			} else {
//      			    echo "Backupfile " . $hr_backupfile_old . " nicht gefunden oder Backupfile " . $hr_backupfile_new . " existiert schon.<br>" ;
      			}  			  
        return;
   }



	/**
	 * log uploaded images to NextGEN galleries with simple history
	 * @since    1.0.0
	 */
   public function hr_NGL_log_uploaded_image($image) {

       // check if logging uploaded images is activated, otherwise return
       $hr_NGL_options = get_option( 'hr_NGL_settings');
       if ( !isset( $hr_NGL_options['add_image'] ) ) { return; }

//       $hrtyp = gettype($image) ;
       $hrarray = get_object_vars($image) ;
//       $hrtyp2 = gettype($hrarray['_stdObject']);
       $hrarray2 = get_object_vars($hrarray['_stdObject']) ;
                
       $hr_galleryid = $hrarray2['galleryid'];
       $hr_gallery = nggdb::find_gallery($hr_galleryid);
                
   	   $context = array( __( "image_id", "simple-history-ngg-loggers") => $hrarray2['pid'],
                 	       __( "image_title", "simple-history-ngg-loggers") =>  $hrarray2['alttext'],
                 	       __( "image_description", "simple-history-ngg-loggers") =>  $hrarray2['description'],
                 	       __( "image_filename", "simple-history-ngg-loggers") => $hrarray2['filename'],
                 	       __( "gallery_id", "simple-history-ngg-loggers") => $hr_galleryid,
                 	       __( "gallery_title", "simple-history-ngg-loggers") => $hr_gallery->title,
                 	       __( "gallery_description", "simple-history-ngg-loggers") => $hr_gallery->galdesc,
                 	       __( "action", "simple-history-ngg-loggers") => "ngg_added_new_images"
       );

       // check for backupfile of picture
       $hr_filename_backup  = $_SERVER['DOCUMENT_ROOT'] . $hr_gallery->path .  "/" . $hrarray2['filename'] . "_backup" ;
       if (file_exists($hr_filename_backup )) {
       	   echo "backupfile bereits gefunden<br><hr>";
 	    	   // check for title in iptc data
 	    	   $hr_size = getimagesize($hr_filename_backup, $hr_data);
 	  	 	   $hr_tags = iptcparse ( $hr_data['APP13'] ) ;
 	  	 	   if ( isset ($hr_tags['2#005'][0] ) ) {
 	  	 	   	   $hr_meta_title = $hr_tags['2#005'][0] ;
 	  	 	   	   $context[__( "image_title", "simple-history-ngg-loggers")] = $hr_meta_title ;
 	  	 	   } else {
 	  	 	   	   $hr_meta_title = "" ;
 	  	 	   }  
            
            // check for descriptionin IFD0 data
            $hr_exif = exif_read_data($hr_filename_backup,0,true);
  	  	 	   if ( isset ($hr_exif['IFD0']['ImageDescription'] ) ) {
  	  	 	   	   $hr_meta_description = $hr_exif['IFD0']['ImageDescription'] ;
  	  	 	   	   $context[__( "image_description", "simple-history-ngg-loggers")] = $hr_meta_description ;
  	  	 	   } else {
  	  	 	   	   $hr_meta_description = "" ;
  	  	 	   }          	  	 	   
       } else {
           // no backupfile, no meta data
           echo "kein backup file gefunden<br><hr>";
           $hr_meta_title = "" ;
           $hr_meta_description = "" ;
       }

			 // save user id as uploader for picture, also if present meta data title and description
			 $user_ID = get_current_user_id();    // aktueller Benutzer
			 global $table_prefix, $wpdb;
			 $hr_NGL_update = 0;
  		 if ( ( hr_NGL_setting_mode == 'modified' ) && ( isset( $hr_NGL_options['save_uploader'] ) ) ) { 
			     // update ngg_pictures tabel with uploader id and optionally with meta data
    			 $hr_sql_upd = "UPDATE " . $table_prefix . "ngg_pictures nggp " .
    			               " SET nggp.uploader=" . $user_ID ;
    			 if ( !($hr_meta_title == "") ) {
    				   $hr_sql_upd .= ", nggp.alttext = '" . $hr_meta_title . "'";
    			 }
    			 if ( !($hr_meta_description == "") ) {
    				   $hr_sql_upd .= ", nggp.description = '" . $hr_meta_description . "'";
    			 }
    			 $hr_NGL_update = 1;
			 } else {
			 	   // optionally update  ngg_pictures tabel with optionally meta data
			 	   if ( ( !($hr_meta_title == "") ) || ( !($hr_meta_description == "") ) ) {
			 	   	   $hr_sql_upd = "UPDATE " . $table_prefix . "ngg_pictures nggp SET " ;
        			 if ( !($hr_meta_title == "") ) {
        				   $hr_sql_upd .= "nggp.alttext = '" . $hr_meta_title . "'";
        			     if ( !($hr_meta_description == "") ) {
        				       $hr_sql_upd .= ", nggp.description = '" . $hr_meta_description . "'";
        			     }
        			 } else {
     				       $hr_sql_upd .= "nggp.description = '" . $hr_meta_description . "'";
        			 }
        			 $hr_NGL_update = 1;
			 	   }
			 }
			 if ( $hr_NGL_update ) {
			     // issue update call for uploaded picture
			     $hr_sql_upd .=    " WHERE nggp.pid=" . $hrarray2['pid'] ;
//			     var_dump("Update SQL call =", $hr_sql_upd) ; echo "<br><br>";
			     $hr_sql_check = $wpdb->query($hr_sql_upd); 
			 }	   
        
       SimpleLogger()->info( sprintf( __( "uploads image %s into gallery %s.", "simple-history-ngg-loggers"),
                                      "#{" . __( "image_id", "simple-history-ngg-loggers") . "} '{" . __( "image_title", "simple-history-ngg-loggers") . "}'",
                                      "#{" . __( "gallery_id", "simple-history-ngg-loggers") . "} '{" . __( "gallery_title", "simple-history-ngg-loggers") . "}'" ), $context);
       return;
   }
   
	/**
	 * NextGEN gallery writes many posts with only generic content, which need not be logged, because no information is provided
	 * @since    1.0.0
	 */
   public function hr_NGL_filter_log_post_entries($doLog, $loggerSlug, $messageKey, $SimpleLoggerLogLevelsLevel, $context) {
       $hr_NGL_options = get_option( 'hr_NGL_settings');
       if ( isset( $hr_NGL_options['log_ngg_pictures'] ) ) { 
           // Don't log standard ngg_updated / ngg_deleted messages
           if ( ( $messageKey == "post_updated" ) && ( $context['post_type'] == "ngg_pictures" ) ) { $doLog = false; }
           if ( ( $messageKey == "post_deleted" ) && ( $context['post_type'] == "ngg_pictures" ) ) { $doLog = false; }
       } 
       if ( isset( $hr_NGL_options['log_ngg_gallery'] ) ) { 
           // Don't log standard ngg_updated / ngg_deleted messages
           if ( ( $messageKey == "post_updated" ) && ( $context['post_type'] == "ngg_gallery" ) ) { $doLog = false; }
           if ( ( $messageKey == "post_deleted" ) && ( $context['post_type'] == "ngg_gallery" ) ) { $doLog = false; }
       } 
       if ( isset( $hr_NGL_options['log_ngg_album'] ) ) { 
           // Don't log standard ngg_updated / ngg_deleted messages
           if ( ( $messageKey == "post_updated" ) && ( $context['post_type'] == "ngg_album" ) ) { $doLog = false; }
           if ( ( $messageKey == "post_deleted" ) && ( $context['post_type'] == "ngg_album" ) ) { $doLog = false; }
   	   }
       return $doLog;
   }



	/**
	 * log updated NextGEN galleries with simple history
	 * @since    1.0.0
	 */
   public function hr_NGL_log_updated_gallery($gid,$post) {

       // check if logging updated galleries is activated, otherwise return
       if ( !isset( get_option( 'hr_NGL_settings')['update_gallery'] ) ) { return; }
       
       $gallery = nggdb::find_gallery($gid);
   	   $context = array( __( "gallery_id", "simple-history-ngg-loggers") => $gid,
                 	       __( "gallery_title", "simple-history-ngg-loggers") => $gallery->title,
                 	       __( "gallery_description", "simple-history-ngg-loggers") => $gallery->galdesc,
                 	       __( "action", "simple-history-ngg-loggers") => "ngg_update_gallery"
       );
       SimpleLogger()->info( sprintf( __( "updates  (image) descriptions in gallery %s.", "simple-history-ngg-loggers"),
                                      "#{" . __( "gallery_id", "simple-history-ngg-loggers") . "} '{" . __( "gallery_title", "simple-history-ngg-loggers") . "}'" ), $context);
       return;
   }

	/**
	 * log new created  NextGEN gallery with simple history
	 * @since    1.0.0
	 */
   public function hr_NGL_log_created_new_gallery( $gid ) {

       // check if logging newly created galleries is activated, otherwise return
       if ( !isset( get_option( 'hr_NGL_settings')['add_gallery'] ) ) { return; }

       $gallery = nggdb::find_gallery($gid);
   	   $context = array( __( "gallery_id", "simple-history-ngg-loggers") => $gid,
                 	       __( "gallery_title", "simple-history-ngg-loggers") => $gallery->title,
                 	       __( "gallery_description", "simple-history-ngg-loggers") => $gallery->galdesc,
                 	       __( "action", "simple-history-ngg-loggers") => "ngg_created_new_gallery"
       );
       SimpleLogger()->info( sprintf( __( "creates new gallery %s.", "simple-history-ngg-loggers"),
                                      "#{" . __( "gallery_id", "simple-history-ngg-loggers") . "} '{" . __( "gallery_title", "simple-history-ngg-loggers") . "}'" ), $context);
       return;
   }

	/**
	 * log deleted  NextGEN gallery with simple history
	 * @since    1.0.0
	 */
   public function hr_NGL_log_delete_gallery( $gid ) {

       // check if logging deleted galleries is activated, otherwise return
       if ( !isset( get_option( 'hr_NGL_settings')['delete_gallery'] ) ) { return; }

//       var_dump("Galerie ", $gallery); echo "<br><hr>";
       $gallery = nggdb::find_gallery($gid);
   	   $context = array( __( "gallery_id", "simple-history-ngg-loggers") => $gid,
                 	       __( "gallery_title", "simple-history-ngg-loggers") => $gallery->title,
                 	       __( "gallery_description", "simple-history-ngg-loggers") => $gallery->galdesc,
                 	       __( "action", "simple-history-ngg-loggers") => "ngg_delete_gallery"
       );
       SimpleLogger()->info( sprintf( __( "deletes gallery %s.", "simple-history-ngg-loggers"),
                                      "#{" . __( "gallery_id", "simple-history-ngg-loggers") . "} '{" . __( "gallery_title", "simple-history-ngg-loggers") . "}'" ), $context);
       return;
   }

	/**
	 * log new created  NextGEN album with simple history
	 * @since    1.0.0
	 */
   public function hr_NGL_add_album( $currentid ) {

       // check if logging newly created albums is activated, otherwise return
       if ( !isset( get_option( 'hr_NGL_settings')['add_album'] ) ) { return; }

//       var_dump("AlbumID ", $currentid); echo "<br><hr>";
       $album = nggdb::find_album($currentid);
//       var_dump("Album ", $album); echo "<br><hr>";
   	   $context = array( __( "album_id", "simple-history-ngg-loggers") => $currentid,
                 	       __( "album_title", "simple-history-ngg-loggers") => $album->name,
                 	       __( "album_description", "simple-history-ngg-loggers") => $album->albumdesc,
                 	       __( "action", "simple-history-ngg-loggers") => "ngg_add_album"
       );
       SimpleLogger()->info( sprintf( __( "creates new album %s.", "simple-history-ngg-loggers"),
                                      "#{" . __( "album_id", "simple-history-ngg-loggers") . "} '{" . __( "album_title", "simple-history-ngg-loggers") . "}'" ), $context);
       return;
   }

	/**
	 * log deletion of NextGEN album with simple history
	 * @since    1.0.0
	 */
   public function hr_NGL_delete_album( $currentid ) {

       // check if logging deleted albums is activated, otherwise return
       if ( !isset( get_option( 'hr_NGL_settings')['delete_album'] ) ) { return; }

//       var_dump("AlbumID ", $currentid); echo "<br><hr>";
       // album is already deleted, so no album info can be retrieved any longer
   	   $context = array( __( "album_id", "simple-history-ngg-loggers") => $currentid,
                 	       __( "album_title", "simple-history-ngg-loggers") => __( "not available, deleted before logging", "simple-history-ngg-loggers"),
                 	       __( "album_description", "simple-history-ngg-loggers") => __( "not available, deleted before logging", "simple-history-ngg-loggers"),
                 	       __( "action", "simple-history-ngg-loggers") => "ngg_delete_album"
       );
       SimpleLogger()->info( sprintf( __( "deletes album %s.", "simple-history-ngg-loggers"),
                                      "#{" . __( "album_id", "simple-history-ngg-loggers") . "}" ), $context);
       return;
   }

	/**
	 * log updated NextGEN album with simple history
	 * @since    1.0.0
	 */
   public function hr_NGL_update_album( $currentid ) {

       // check if logging updated albums is activated, otherwise return
       if ( !isset( get_option( 'hr_NGL_settings')['update_album'] ) ) { return; }

//       var_dump("AlbumID ", $currentid); echo "<br><hr>";
       $album = nggdb::find_album($currentid);
//       var_dump("Album ", $album); echo "<br><hr>";
       $hr_NGL_galerie_IDs = stripcslashes($album->sortorder);
       $hr_NGL_galerie_IDs = json_decode(base64_decode($hr_NGL_galerie_IDs), TRUE);
//       var_dump("hr_galerie_IDs: ", $hr_NGL_galerie_IDs); echo "<br>" ;
       $hr_NGL_gallery_ids = implode (",", $hr_NGL_galerie_IDs);
       if ( $hr_NGL_gallery_ids == '' ) {
       	    $hr_NGL_gallery_ids = __( "empty list", "simple-history-ngg-loggers") ;
       }
//       var_dump("hr_select_ids: ", $hr_NGL_gallery_ids); echo "<br>" ;
   	   $context = array( __( "album_id", "simple-history-ngg-loggers") => $currentid,
                 	       __( "album_title", "simple-history-ngg-loggers") => $album->name,
                 	       __( "album_description", "simple-history-ngg-loggers") => $album->albumdesc,
                 	       __( "album_content", "simple-history-ngg-loggers") => $hr_NGL_gallery_ids,
                 	       __( "action", "simple-history-ngg-loggers") => "ngg_update_album"
       );
       SimpleLogger()->info( sprintf( __( "updates metadata for album %s.", "simple-history-ngg-loggers"),
                                      "#{" . __( "album_id", "simple-history-ngg-loggers") . "} '{" . __( "album_title", "simple-history-ngg-loggers") . "}'" ), $context);
       return;
   }

	/**
	 * log updated NextGEN album with simple history
	 * @since    1.0.0
	 */
   public function hr_NGL_update_album_sortorder( $currentid ) {

       // check if logging updated albums is activated, otherwise return
       if ( !isset( get_option( 'hr_NGL_settings')['update_album'] ) ) { return; }

//       var_dump("AlbumID ", $currentid); echo "<br><hr>";
       $album = nggdb::find_album($currentid);
//       var_dump("Album ", $album); echo "<br><hr>";
       $hr_NGL_galerie_IDs = stripcslashes($album->sortorder);
       $hr_NGL_galerie_IDs = json_decode(base64_decode($hr_NGL_galerie_IDs), TRUE);
//       var_dump("hr_galerie_IDs: ", $hr_NGL_galerie_IDs); echo "<br>" ;
       $hr_NGL_gallery_ids = implode (",", $hr_NGL_galerie_IDs);
       if ( $hr_NGL_gallery_ids == '' ) {
       	    $hr_NGL_gallery_ids = __( "empty list", "simple-history-ngg-loggers") ;
       }
//       var_dump("hr_select_ids: ", $hr_NGL_gallery_ids); echo "<br>" ;
   	   $context = array( __( "album_id", "simple-history-ngg-loggers") => $currentid,
                 	       __( "album_title", "simple-history-ngg-loggers") => $album->name,
                 	       __( "album_description", "simple-history-ngg-loggers") => $album->albumdesc,
                 	       __( "album_content", "simple-history-ngg-loggers") => $hr_NGL_gallery_ids,
                 	       __( "action", "simple-history-ngg-loggers") => "ngg_update_album_sortorder"
       );
       SimpleLogger()->info( sprintf( __( "updates gallery list for album %s.", "simple-history-ngg-loggers"),
                                      "#{" . __( "album_id", "simple-history-ngg-loggers") . "} '{" . __( "album_title", "simple-history-ngg-loggers") . "}'" ), $context);
       return;
   }


	/**
	 * modifies length of an internal gallery list depending on user capability
	 *   only needed for some advanced NextGEN Gallery source code modification
	 *   not available in public settup
	 * @since    1.0.0
   */
   public function hr_NGL_set_items_per_page($hr_NGL_length) {
  	 if ( hr_NGL_setting_mode == 'modified' ) {                         // check for private mode
       $hr_NGL_options = get_option( 'hr_NGL_settings');
       if ( isset ( $hr_NGL_options['customized_gallery_list'] ) ) {    // check if option is activated
    	     if ( current_user_can( 'NextGEN Manage others gallery' ) ) { // check if user has necessary capability
   	  	       // don't change anything for users with this capability
   	       } else {
   	  	       $hr_NGL_length = 200 ;                                   // extend list size to maximum to enable gallery search on one go
   	       }
   	   }
   	 }
   	 return ($hr_NGL_length) ;
   }

   /**
   * this filter adjusts simple history logger so that no older entries are deleted
	 * @since    1.0.0
   */
   public function hr_NGL_set_purge_days_intervall($days) {
       $hr_NGL_options = get_option( 'hr_NGL_settings');
       if ( isset( $hr_NGL_options['never_empty_log'] ) ) {
       	  // set $days to 0 so that no entries are deleted
   	      $days = 0;
   	   } else {
   	   	  $days = 60;
   	   	  unset( $hr_NGL_options['never_empty_log'] );
   	   	  update_option( 'hr_NGL_settings', $hr_NGL_options );
   	   }	
   	   return ($days) ;
   }


}      // end of definition Simple_History_Ngg_Loggers_Admin
 

  /**
   * Render the settings page for this plugin.
   *
   * @since    1.0.0
   */
  function hr_NGL_options_page(  ) { 
  		$hr_NGL_options = get_option( 'hr_NGL_settings');
//  		var_dump($hr_NGL_options); echo "<br>";

  	?>
  	<form action='options.php' method='post'>
  		<h1 class='hr_NGL_h1'><?php echo __( 'Settings', 'simple-history-ngg-loggers' ) . ' &gt; ' . __( 'Simple History NGG Loggers', 'simple-history-ngg-loggers' ) ;
  		   if ( hr_NGL_setting_mode == 'modified' ) { 
  		   	  echo " &gt; ", __( 'extended mode', 'simple-history-ngg-loggers' ) ;
  		   }  ?></h1><?php

    		/*  settings_fields( $option_group ), must be called inside of the form tag  */
    		/*  This should match the group name used in register_setting()  */
  		settings_fields( 'hr_NGL_pluginPage' );
  
    		/*  do_settings_sections( $page );  with slug name of page */
    		/*  print out all setting sections */
  		do_settings_sections( 'hr_NGL_pluginPage' );
  		
  		?><span style='padding-right:50px;'><?php
  		submit_button( __( 'Save Changes', 'simple-history-ngg-loggers' ), 'primary', 'submit' , false);
  		?></span>
  	</form>
  	<?php
  }

 
  /**
   * define callback functions to build up the setting page
   *
   * @since    1.0.0
   */
  function hr_NGL_settings_section_callback(  ) { 
  	echo "<p class='hr_NGL_p'>", __( 'Individually enable logging for each of the following user activities:', 'simple-history-ngg-loggers' ), "</p>";
  }
  
  function hr_NGL_checkbox_image_actions_render(  ) { 
  	$hr_NGL_options = get_option( 'hr_NGL_settings');
  	?>
  	<span style='padding-bottom: 15px; line-height:2;'> <input type='checkbox' name='hr_NGL_settings[add_image]' <?php checked( $hr_NGL_options['add_image'], 1 ); ?> value='1'><?php echo __( 'upload images (and set titel and description, if available in exif data)', 'simple-history-ngg-loggers' )?></span><br> 
  	<span style='padding-bottom: 15px; line-height:2;'> <input type='checkbox' name='hr_NGL_settings[move_image]' <?php checked( $hr_NGL_options['move_image'], 1 ); ?> value='1'><?php echo __( 'move images', 'simple-history-ngg-loggers' )?></span><br>
  	<span style='padding-bottom: 15px; line-height:2;'> <input type='checkbox' name='hr_NGL_settings[copy_image]' <?php checked( $hr_NGL_options['copy_image'], 1 ); ?> value='1'><?php echo __( 'copy images', 'simple-history-ngg-loggers' )?></span><br>
  	<span style='padding-bottom: 15px; line-height:2;'> <input type='checkbox' name='hr_NGL_settings[delete_image]' <?php checked( $hr_NGL_options['delete_image'], 1 ); ?> value='1'><?php echo __( 'delete images', 'simple-history-ngg-loggers' )?></span><br>
  	<?php 
  }
  
  function hr_NGL_checkbox_gallery_actions_render(  ) { 
  	$hr_NGL_options = get_option( 'hr_NGL_settings');
  	?>
  	<span style='padding-bottom: 15px; line-height:2;'> <input type='checkbox' name='hr_NGL_settings[add_gallery]' <?php checked( $hr_NGL_options['add_gallery'], 1 ); ?> value='1'><?php echo __( 'create new gallery', 'simple-history-ngg-loggers' )?></span><br> 
  	<span style='padding-bottom: 15px; line-height:2;'> <input type='checkbox' name='hr_NGL_settings[update_gallery]' <?php checked( $hr_NGL_options['update_gallery'], 1 ); ?> value='1'><?php echo __( 'update gallery metadata (including picture titels, descriptions and tags)', 'simple-history-ngg-loggers' )?></span><br>
  	<span style='padding-bottom: 15px; line-height:2;'> <input type='checkbox' name='hr_NGL_settings[delete_gallery]' <?php checked( $hr_NGL_options['delete_gallery'], 1 ); ?> value='1'><?php echo __( 'delete gallery (and images in such galleries)', 'simple-history-ngg-loggers' )?></span><br>
  	<?php 
  }
  
  function hr_NGL_checkbox_album_actions_render(  ) { 
  	$hr_NGL_options = get_option( 'hr_NGL_settings');
  	?>
  	<span style='padding-bottom: 15px; line-height:2;'> <input type='checkbox' name='hr_NGL_settings[add_album]' <?php checked( $hr_NGL_options['add_album'], 1 ); ?> value='1'><?php echo __( 'create new album', 'simple-history-ngg-loggers' )?></span><br> 
  	<span style='padding-bottom: 15px; line-height:2;'> <input type='checkbox' name='hr_NGL_settings[update_album]' <?php checked( $hr_NGL_options['update_album'], 1 ); ?> value='1'><?php echo __( 'update album metadata (see gallery list in log details)', 'simple-history-ngg-loggers' )?></span><br>
  	<span style='padding-bottom: 15px; line-height:2;'> <input type='checkbox' name='hr_NGL_settings[delete_album]' <?php checked( $hr_NGL_options['delete_album'], 1 ); ?> value='1'><?php echo __( 'delete album', 'simple-history-ngg-loggers' )?></span><br>
  	<?php 
  }
  
  function hr_NGL_settings_section2_callback(  ) { 
  	 echo "<p class='hr_NGL_p'>", __( 'Miscellaneous further settings related to NextGEN Gallery or Simple History plugins:', 'simple-history-ngg-loggers' ), "</p>";
  	
  	 // check in public mode that private options are cleared
  	 if ( hr_NGL_setting_mode == 'public' ) {   
         $hr_NGL_options = get_option( 'hr_NGL_settings');
         $hr_NGL_update = 0 ;
         if ( isset ( $hr_NGL_options['breadcrumb'] ) ) {
    	   	  unset( $hr_NGL_options['breadcrumb'] );
    	   	  $hr_NGL_update = 1 ;
         }
         if ( isset ( $hr_NGL_options['customized_gallery_list'] ) ) {
    	   	  unset( $hr_NGL_options['customized_gallery_list'] );
    	   	  $hr_NGL_update = 1 ;
         }
         if ( isset ( $hr_NGL_options['save_uploader'] ) ) {
    	   	  unset( $hr_NGL_options['save_uploader'] );
    	   	  $hr_NGL_update = 1 ;
         }
         if ( isset ( $hr_NGL_options['log_email'] ) ) {
    	   	  unset( $hr_NGL_options['log_email'] );
    	   	  $hr_NGL_update = 1 ;
         }
         if ( $hr_NGL_update ) {
    	   	  update_option( 'hr_NGL_settings', $hr_NGL_options );
         }
  	 }
  }

  function hr_NGL_radio_show_notifications_render(  ) { 
  	$hr_NGL_options = get_option( 'hr_NGL_settings');
  	?>
  	<span style='padding-right:40px;'><input type='radio' name='hr_NGL_settings[show_notifications]' value='both' <?php checked( $hr_NGL_options['show_notifications'], 'both' ); ?>>
    <?php echo __( 'on plugin page and on settings page', 'simple-history-ngg-loggers' ) ; ?></span>
   	<span style='padding-right:40px;'><input type='radio' name='hr_NGL_settings[show_notifications]' value='only option' <?php checked( $hr_NGL_options['show_notifications'], 'only option' ); ?>>
    <?php echo __( 'only on settings page', 'simple-history-ngg-loggers' ) ; ?></span>
  	<input type='radio' name='hr_NGL_settings[show_notifications]' value='none' <?php checked( $hr_NGL_options['show_notifications'], 'none' ); ?>>
    <?php echo __( 'show no notification', 'simple-history-ngg-loggers' ) ; ?><br>
    <?php echo __( 'Plugin sets notifications if either of the two needed plugins (Simple History or NextGEN Gallery) is not installed or activated.', 'simple-history-ngg-loggers' ) ; ?>
  	<?php
  }
  
  function hr_NGL_checkbox_gallery_links_render(  ) { 
  	$hr_NGL_options = get_option( 'hr_NGL_settings');
  	?>
    <span style='padding-right:40px; padding-bottom:0px;'><input type='checkbox' name='hr_NGL_settings[edit_post]' value='1' <?php checked( $hr_NGL_options['edit_post'], 1 ); ?>>
  	<?php echo __( 'add edit_post_link', 'simple-history-ngg-loggers' ) ; ?></span>

  	<?php // private modification, not for public 
  	    if ( hr_NGL_setting_mode == 'modified' ) {   ?>
  	       <input type='checkbox' name='hr_NGL_settings[breadcrumb]' value='1' <?php checked( $hr_NGL_options['breadcrumb'], 1 ); 
            echo ">", __( 'add breadcrumb link', 'simple-history-ngg-loggers' ) ; 
        } 
  	    echo "<br>", __( 'add a direct link into the backend manage gallery page for frontend pages, which itself are directly linked to a NextGEN gallery', 'simple-history-ngg-loggers' ) ; 
  }
 
  function hr_NGL_checkbox_filter_log_entries_render(  ) { 
  	$hr_NGL_options = get_option( 'hr_NGL_settings');
  	?>
  	<span style='padding-right:40px;'><input type='checkbox' name='hr_NGL_settings[log_ngg_pictures]' value='1' <?php checked( $hr_NGL_options['log_ngg_pictures'], 1 ); ?>>
   <?php echo __( 'filter log post entries generated by NextGEN Gallery for pictures', 'simple-history-ngg-loggers' ) ; ?></span>
  	<input type='checkbox' name='hr_NGL_settings[log_ngg_gallery]' value='1' <?php checked( $hr_NGL_options['log_ngg_gallery'], 1 ); ?>>
  	<?php echo __( 'filter log post entries generated by NextGEN Gallery for galleries', 'simple-history-ngg-loggers' ) ; ?><br>
  	<input type='checkbox' name='hr_NGL_settings[log_ngg_album]' value='1' <?php checked( $hr_NGL_options['log_ngg_album'], 1 ); ?>>
  	<?php echo __( 'filter log post entries generated by NextGEN Gallery for albums', 'simple-history-ngg-loggers' ) ; ?><br>
    <?php echo __( 'NextGEN gallery creates many generic posts to document picture, gallery and album actions, without providing any explicite information.', 'simple-history-ngg-loggers' ) ; ?>
  	<?php
  }
 
  function hr_NGL_checkbox_empty_log_intervall_render(  ) { 
  	$hr_NGL_options = get_option( 'hr_NGL_settings');
  	?>
  	<span style='padding-right:40px;'><input type='checkbox' name='hr_NGL_settings[never_empty_log]' value='1' <?php checked( $hr_NGL_options['never_empty_log'], 1 ); ?>>
   <?php echo __( 'set empty log intervall to zero for Simple History', 'simple-history-ngg-loggers' ) ; ?></span><br>
    <?php echo __( 'Never empty log for Simple History.', 'simple-history-ngg-loggers' ) ; ?>
  	<?php
  }
 
  function hr_NGL_checkbox_customized_gallery_list_render(  ) { 
  	$hr_NGL_options = get_option( 'hr_NGL_settings');
  	?>
  	<span style='padding-right:40px;'><input type='checkbox' name='hr_NGL_settings[customized_gallery_list]' value='1' <?php checked( $hr_NGL_options['customized_gallery_list'], 1 ); ?>>
   <?php echo __( 'only list own galleries on manage gallery page', 'simple-history-ngg-loggers' ) ; ?></span><br>
    <?php echo __( 'This restriction applies to all NextGEN gallery users, who can only manage their own galleries.', 'simple-history-ngg-loggers' ) ; ?>
  	<?php
  }
 
  function hr_NGL_checkbox_save_uploader_render(  ) { 

  	global $table_prefix, $wpdb;

    // check if uploader column already exists
  	$hr_NGL_SQL_check_column = 'SHOW COLUMNS FROM ' . $table_prefix . 'ngg_pictures LIKE %s ' ;
    $hr_NGL_check_uploader  = $wpdb->get_results($wpdb->prepare( $hr_NGL_SQL_check_column, 'uploader' ) );
//    var_dump ( $hr_NGL_check_uploader ); echo "<br>";
    if ( count($hr_NGL_check_uploader) == 1 ) {
        $hr_NGL_uploader_status = __( 'Field <em>uploader</em> exists, option enabled.', 'simple-history-ngg-loggers' ) ;
        $hr_NGL_marker = 1 ;
    } else {
        $hr_NGL_uploader_status = __( 'Field <em>uploader</em> does not exist, option disabled.', 'simple-history-ngg-loggers' ) ;
        $hr_NGL_marker = 0 ;
    }
    
    $hr_NGL_options = get_option( 'hr_NGL_settings');

  	?>
  	<input type='checkbox' name='hr_NGL_settings[save_uploader]' value='<?php echo $hr_NGL_marker ; ?>' <?php checked( $hr_NGL_options['save_uploader'], 1 ); ?>>
    <span style='padding-right:40px;'><?php echo __( 'save uploader to custom field in NextGEN Gallery pictures table', 'simple-history-ngg-loggers' ) ;?> </span> 
    <?php
     echo  "(" . $hr_NGL_uploader_status . ")" ;
  }
  		 
  function hr_NGL_checkbox_log_emails_render(  ) { 
    $hr_NGL_options = get_option( 'hr_NGL_settings');
  	?>
  	<input type='checkbox' name='hr_NGL_settings[log_email]' value='1' <?php checked( $hr_NGL_options['log_email'], 1 ); ?>>
  	<?php echo __( 'log emails being automatically send out by wordpress', 'simple-history-ngg-loggers' ) ; 
  }
 
?>
