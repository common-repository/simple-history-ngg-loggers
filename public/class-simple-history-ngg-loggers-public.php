<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       Https://r-fotos.de
 * @since      1.0.0
 *
 * @package    Simple_History_Ngg_Loggers
 * @subpackage Simple_History_Ngg_Loggers/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Simple_History_Ngg_Loggers
 * @subpackage Simple_History_Ngg_Loggers/public
 * @author     Harald Roeh <hroeh@t-online.de>
 */
class Simple_History_Ngg_Loggers_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/simple-history-ngg-loggers-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/simple-history-ngg-loggers-public.js', array( 'jquery' ), $this->version, false );

	}


	/**
	 * Insert gallery link after breadcrumps if activated
	 * @since    1.0.0
	 */
   public function hr_NGL_after_breadcrumbs( $page_id ) {
       global $table_prefix, $wpdb;
                
       // check if breadcrumb link is activated
       if ( !isset( get_option( 'hr_NGL_settings')['breadcrumb'] ) ) { return; }
        
//       echo " pageid= ", $page_id, " current user= ", get_current_user_id(), "Schalter=", current_user_can('edit_post', $page_id) ;
       // zeige Galerie-Link nur, wenn Benutzer angemeldet ist und wenn er auch edit Rechte an aktueller Seite hat
       if (( get_current_user_id()==0 ) or (!current_user_can('edit_post', $page_id))) { return; } ;
        
       // get gallery object which refers to the given $post_id as pageid
       $hr_sql_gallery = "select gid, galdesc from " . $table_prefix . "ngg_gallery where ( pageid=" . $page_id . " ) ";
       $hr_sql_result = $wpdb->get_results($hr_sql_gallery);
 //       var_dump($hr_sql_result); echo "<br>";

       // füge Direkt-Link auf die Galerie-Verwaltungsseite hinzu, so vorhanden
       if ( isset ( $hr_sql_result[0] -> gid ) ) {
       	  echo "<li style='list-style-type:none;list-style-position:inside;padding-left:20px;'><a class='post-edit-link' href='/wp-admin/admin.php?page=nggallery-manage-gallery&mode=edit&gid=" . 
       	            $hr_sql_result[0] -> gid . "'>Galerie</a></li>" ;
       }
       return;
   }
 
  /**
   * Use the "edit_post_link" filter to add link to gallery if possible
	 * @since    1.0.0
   */
   public function hr_NGL_after_edit_post( $link, $post_id ) {
 
       global $table_prefix, $wpdb;
       
       // check if edit_post link is activated in settings, because user is logged in and can edit current post
       if ( !isset( get_option( 'hr_NGL_settings')['edit_post'] ) ) { return; }
       
       // get gallery object which refers to the given $post_id as pageid
       $hr_sql_gallery = "select gid, galdesc from " . $table_prefix . "ngg_gallery where ( pageid=" . $post_id . " ) ";
       $hr_sql_result = $wpdb->get_results($hr_sql_gallery);
 //      var_dump($hr_sql_result); echo "<br>";
 
       // bei Club-Mitglied Galerien unterdrücke 'bearbeiten' Link für die Seite
       if ( isset ( $hr_sql_result[0] -> galdesc ) && strpos ( $hr_sql_result[0] -> galdesc, "Club-Mitglied Galerie" ) > 0 ) {
       	  $link = "" ;
       }
       
       // füge Direkt-Link auf die Galerie-Verwaltungsseite hinzu, so vorhanden
       if ( isset ( $hr_sql_result[0] -> gid ) ) {
       	  $link .= "<a class='post-edit-link' href='/wp-admin/admin.php?page=nggallery-manage-gallery&mode=edit&gid=" . $hr_sql_result[0] -> gid . "'>Galerie</a>" ;
       }               
 
       return ($link);
   }
   

}
