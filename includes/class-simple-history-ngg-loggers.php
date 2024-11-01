<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       Https://r-fotos.de
 * @since      1.0.0
 *
 * @package    Simple_History_Ngg_Loggers
 * @subpackage Simple_History_Ngg_Loggers/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Simple_History_Ngg_Loggers
 * @subpackage Simple_History_Ngg_Loggers/includes
 * @author     Harald Roeh <hroeh@t-online.de>
 */
class Simple_History_Ngg_Loggers {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Simple_History_Ngg_Loggers_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'simple-history-ngg-loggers';
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Simple_History_Ngg_Loggers_Loader. Orchestrates the hooks of the plugin.
	 * - Simple_History_Ngg_Loggers_i18n. Defines internationalization functionality.
	 * - Simple_History_Ngg_Loggers_Admin. Defines all hooks for the admin area.
	 * - Simple_History_Ngg_Loggers_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-simple-history-ngg-loggers-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-simple-history-ngg-loggers-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-simple-history-ngg-loggers-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-simple-history-ngg-loggers-public.php';

		$this->loader = new Simple_History_Ngg_Loggers_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Simple_History_Ngg_Loggers_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Simple_History_Ngg_Loggers_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Simple_History_Ngg_Loggers_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		
		// Add menu item
    $this->loader->add_action( 'admin_menu', $plugin_admin, 'hr_NGL_add_admin_menu' );
    
    // Save/Update our plugin options
    $this->loader->add_action( 'admin_init', $plugin_admin, 'hr_NGL_settings_init');

    // Add Settings link to the plugin
    $plugin_basename = plugin_basename( plugin_dir_path( __DIR__ ) . $this->plugin_name . '.php' );
    $this->loader->add_filter( 'plugin_action_links_' . $plugin_basename, $plugin_admin, 'hr_NGL_add_action_links' );
    
    // Add warning / error notifications for backend side
    $this->loader->add_action( 'admin_notices', $plugin_admin, 'hr_NGL_check_plugins');

    // log deleted images
    $this->loader->add_action( 'ngg_delete_picture', $plugin_admin, 'hr_NGL_log_deleted_image', 10, 2 );

    // log copied images
    $this->loader->add_action('ngg_copied_images', $plugin_admin, 'hr_NGL_log_copied_image', 10, 3 );
 
    // log moved images
    $this->loader->add_action('ngg_moved_images', $plugin_admin, 'hr_NGL_log_moved_image', 10, 3 );
 
    // log moved images
    $this->loader->add_action('hr_ngg_moveX_image', $plugin_admin, 'hr_NGL_log_movedX_image', 10, 7 );

    // log uploaded images
    $this->loader->add_action( 'ngg_added_new_image',  $plugin_admin, 'hr_NGL_log_uploaded_image', 10, 1 );

    // filter logging of posts which are extensively generated by NextGEN gallery
    $this->loader->add_filter("simple_history/simple_logger/log_message_key", $plugin_admin, 'hr_NGL_filter_log_post_entries', 10, 5 );

    // log updated galleries 
    $this->loader->add_action( 'ngg_update_gallery',$plugin_admin, 'hr_NGL_log_updated_gallery', 10, 2 );

    // log new created galleries
    $this->loader->add_action( 'ngg_created_new_gallery',$plugin_admin, 'hr_NGL_log_created_new_gallery', 10, 1 );

    // log new created galleries 
    $this->loader->add_action( 'ngg_delete_gallery',$plugin_admin, 'hr_NGL_log_delete_gallery', 10, 1 );

    // log new created album 
    $this->loader->add_action( 'ngg_add_album',$plugin_admin, 'hr_NGL_add_album', 10, 1 );

    // log new created album 
    $this->loader->add_action( 'ngg_delete_album',$plugin_admin, 'hr_NGL_delete_album', 10, 1 );

    // log new created album 
    $this->loader->add_action( 'ngg_update_album',$plugin_admin, 'hr_NGL_update_album', 10, 1 );

    // log new created album 
    $this->loader->add_action( 'ngg_update_album_sortorder',$plugin_admin, 'hr_NGL_update_album_sortorder', 10, 1 );


    // advanced filter setting purge days intervall to zero for simple history, meaning no automatic log delete
    $this->loader->add_filter( 'simple_history_db_purge_days_interval', $plugin_admin, 'hr_NGL_set_purge_days_intervall');


    // advanced filter for some NextGEN gallery source code modifiation
    $this->loader->add_filter( 'ngg_manage_galleries_items_per_page', $plugin_admin, 'hr_NGL_set_items_per_page');

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Simple_History_Ngg_Loggers_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

    // Add direct gallery link to backend manage gallery frame after breadcrumbs
    $this->loader->add_action( 'hr_after_breadcrumps', $plugin_public, 'hr_NGL_after_breadcrumbs' );

    // Add direct gallery link to backend manage gallery frame for edit_post links
    $this->loader->add_filter( 'edit_post_link', $plugin_public, 'hr_NGL_after_edit_post', 5, 2 );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Simple_History_Ngg_Loggers_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}

?>
