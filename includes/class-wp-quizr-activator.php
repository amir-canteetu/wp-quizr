<?php

defined( 'ABSPATH' ) || exit;

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    WP_Quizr
 * @subpackage WP_Quizr/includes
 * @author     Amir Canteetu 
 */
class Plugin_Name_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
      
            add_option( 'wp_quizr_options', array('option_table_width' =>'100',
                                                            'random' => true) );

	}

}
