<?php

defined( 'ABSPATH' ) || exit;

/**
 * Fired when the plugin is uninstalled.
 *
 * @since      1.0.0
 *
 * @package    WP_Quizr
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    
	exit;
        
}

/* get post-count object*/
$wp_quizr_count_posts_object = wp_count_posts('wp_quizr');

/* get number of quiz posts*/
$wp_quizr_count_posts = intval($wp_quizr_count_posts_object->publish) + intval($wp_quizr_count_posts_object->trash);

$args = array(
              'numberposts' => $wp_quizr_count_posts, 
              'post_type' =>'wp_quizr'
    );

$wp_quizr_posts = get_posts( $args );

/* delete all quizzes and plugin options*/
if (is_array($wp_quizr_posts)) {

   foreach ($wp_quizr_posts as $wp_quizr_post) {

       wp_delete_post( $wp_quizr_post->ID, true);

   }

}

delete_option('wp_quizr_options');