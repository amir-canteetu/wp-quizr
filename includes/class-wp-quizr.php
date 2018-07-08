<?php

defined( 'ABSPATH' ) || exit;

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
 * @package    WP_Quizr
 * @subpackage WP_Quizr/includes
 * @author     Amir Canteetu 
 */
class WP_Quizr {

	/**
	 * The loader responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      WP_Quizr_Loader    $loader    Maintains and registers all hooks for the plugin.
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

		$this->plugin_name = 'wp_quizr';
                
		$this->version = '2.0.0';
                
                add_action('init', array($this, 'wp_quizr_add_custom_post_type'));
                
		$this->load_dependencies();
                
		$this->set_locale();
                
		$this->define_admin_hooks();
                
		$this->define_public_hooks();

	}
        
        
        /**
	 * Create the custom post type, wp_quizr.
         *
	 * @since    1.0.0
	 * @access   public
	 */
        
        public function wp_quizr_add_custom_post_type() {

            $labels = array(
                'name' => _x('Quizzes', 'wp_quizr'),
                'menu_name' => _x('Quizzes', 'wp_quizr'),
                'add_new' => _x('Add New ', 'wp_quizr'),
                'add_new_item' => _x('Add New Quiz', 'wp_quizr'),
                'new_item' => _x('New Quiz', 'wp_quizr'),
                'all_items' => _x('All Quizzes', 'wp_quizr'),
                'edit_item' => _x('Edit Quiz', 'wp_quizr'),
                'view_item' => _x('View Quiz', 'wp_quizr'),
                'search_items' => _x('Search Quizzes', 'wp_quizr'),
                'not_found' => _x('No Quizzes Found', 'wp_quizr'),
            );



            $args = array(
                'labels' => $labels,
                'hierarchical' => false,
                'description' => 'Quizzes',
                'supports' => array('title'),
                'public' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'show_in_nav_menus' => true,
                'publicly_queryable' => true,
                'exclude_from_search' => false,
                'has_archive' => true,
                'query_var' => true,
                'can_export' => true,
                'rewrite' => true,
                'capability_type' => 'post'
            );

            register_post_type('wp_quizr', $args);
            
        }        

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - WP_Quizr_Loader. Orchestrates the hooks of the plugin.
	 * - WP_Quizr_i18n. Defines internationalization functionality.
	 * - WP_Quizr_Admin. Defines all hooks for the admin area.
	 * - WP_Quizr_Public. Defines all hooks for the public side of the site.
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
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-quizr-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-quizr-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wp-quizr-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wp-quizr-public.php';

		$this->loader = new WP_Quizr_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the WP_Quizr_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

            $plugin_i18n = new WP_Quizr_i18n();
            
            $plugin_i18n->set_domain( $this->get_plugin_name() );

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

            $plugin_admin = new WP_Quizr_Admin( $this->get_plugin_name(), $this->get_version() );

            $this->loader->add_action( 'admin_menu', $plugin_admin, 'wp_quizr_create_settings_submenu' );

            /* Add our meta box setup function on the post editor screen. */
            $this->loader->add_action( 'load-post.php', $plugin_admin, 'wp_quizr_meta_boxes_setup' );
            
            $this->loader->add_action( 'load-post-new.php', $plugin_admin, 'wp_quizr_meta_boxes_setup' );
            
            $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );

            $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
            
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

            $plugin_public = new WP_Quizr_Public( $this->get_plugin_name(), $this->get_version() );

            $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
            
            $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
            
            $this->loader->add_action( 'init', $plugin_public, 'wp_quizr_register_shortcode' );
            
            // Ajax handler
            $this->loader->add_action('wp_ajax_nopriv_wp_quizr_ajax', $plugin_public, 'wp_quizr_ajax');
            
            $this->loader->add_action('wp_ajax_wp_quizr_ajax', $plugin_public, 'wp_quizr_ajax');
            
            $this->loader->add_action('wp_head', $plugin_public, 'wp_quizr_add_meta_tags');
            
            $this->loader->add_action('wp_head', $plugin_public, 'wp_quizr_add_custom_css');

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
	 * @return    WP_Quizr_Loader    Orchestrates the hooks of the plugin.
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
