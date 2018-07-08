<?php

defined( 'ABSPATH' ) || exit;

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @since             1.0.1
 * @package           WP_Quizr
 *
 * @wordpress-plugin
 * Plugin Name:       WP Quizr
 * Plugin URI:        https://wordpress.org/plugins/wp-quizr/
 * Description:       Create Buzzfeed-style quizzes and allow users to share their results on social media.
 * Version:           2.0.0
 * Author:            Amir Canteetu
 * Author URI:        https://github.com/amir-canteetu
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp_quizr
 * Domain Path:       /languages
 */

    function activate_plugin_name() {

        require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-quizr-activator.php';

        Plugin_Name_Activator::activate();

    }

    function deactivate_plugin_name() {

        require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-quizr-deactivator.php';

        Plugin_Name_Deactivator::deactivate();

    }

    register_activation_hook( __FILE__, 'activate_plugin_name' );

    register_deactivation_hook( __FILE__, 'deactivate_plugin_name' );

    require plugin_dir_path( __FILE__ ) . 'includes/class-wp-quizr.php';

    function run_plugin_name() {

        $plugin = new WP_Quizr();

        $plugin->run();

    }

    run_plugin_name();