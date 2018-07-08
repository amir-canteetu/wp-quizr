<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, enqueues admin-specific stylesheet and JavaScript,
 * and functions for displaying metaboxes
 * 
 * An instance of this class is passed to the run() function
 * defined in WP_Quizr_Loader (includes/class-wp-quizr-loader.php) as all of the hooks are defined
 * in that particular class.
 *
 * The WP_Quizr_Loader then creates the relationship
 * between the defined hooks and the functions defined in this
 * class.
 *
 * @package    WP_Quizr
 * @subpackage WP_Quizr/admin
 * @author     Amir Canteetu <amircanteetu@gmail.com>
 */

defined( 'ABSPATH' ) || exit;

class WP_Quizr_Admin {

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
         * @since      1.0.0
         * @param      string    $plugin_name       The name of this plugin.
         * @param      string    $version           The version of this plugin.
         */
        public function __construct( $plugin_name, $version ) {

            $this->plugin_name = $plugin_name;

            $this->version = $version;

        }

        /**
         * Enqueue stylesheets for the admin area.
         *
         * @since    1.0.0
         */
        public function enqueue_styles() {

           global $post_type;

            if ('wp_quizr' === $post_type) {
                
                wp_enqueue_style( 'wp_quizr_admin_css', plugin_dir_url( __FILE__ ) . 'css/wp-quizr-admin.min.css', array(), $this->version, 'all' );
                wp_enqueue_style( 'ballooncss', plugin_dir_url( __FILE__ ) . 'css/balloon.min.css', array(), '5.1.0', 'all' );
                wp_enqueue_style( 'fontawesome', plugin_dir_url( __FILE__ ) . 'fonts/fontawesome/css/all.css', array(), '5.1.0', 'all' );
                
                //wp_enqueue_style( 'bootstrapcss', '//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css', array(), '4.0.0', 'all' );

            }

        }

        /**
         *
         * Enqueue javascripts for the admin area
         *
         * @since 1.0.0
         */
        public function enqueue_scripts() {

           global $post_type;

            if ('wp_quizr' === $post_type) {

            wp_enqueue_script( 'wp-quizr-admin-js', plugin_dir_url( __FILE__ ) . 'js/wp-quizr-admin.min.js', array( 'jquery' ), $this->version, false );

            wp_enqueue_media();

            wp_enqueue_script( 'meta-box-image-js', plugin_dir_url( __FILE__ ) . 'js/meta-box-image.min.js', array( 'jquery' ), $this->version, false );

            wp_localize_script('meta-box-image_script', 'meta_image', array(
                    'title' => 'Add Image',
                    'button' => 'Use this image',
                        )
                );
            
            wp_enqueue_script( 'fontawesome', plugin_dir_url( __FILE__ ) . 'fonts/fontawesome/js/all.js', array(), '5.1.0', 'all' );

            }                

        }

        /**
         *
         * Create settings submenu
         *
         * @since 1.0.0
         */    
        public function wp_quizr_create_settings_submenu() {
            //                parent_slug   page_title                menu_title          capability          menu_slug                   function
            add_submenu_page('edit.php?post_type=wp_quizr', 'WP Quizr Settings Page', 'WP Quizr Settings', 'manage_options', 'wp_quizr_settings_menu', 'WP_Quizr_Admin::wp_quizr_display_settings_page');

            //call register settings function
            add_action('admin_init', 'WP_Quizr_Admin::wp_quizr_register_settings');

        }

        /**
         *
         * Register settings
         *
         * @since 1.0.0 
         */     
        public static function wp_quizr_register_settings() {

            //register our settings
            register_setting('wp_quizr_settings_group', 'wp_quizr_options', 'WP_Quizr_Admin::wp_quizr_sanitize_options');    

        }

        /**
         *
         * Display settings page
         *
         * @since 1.0.0
         */  
        public static function wp_quizr_display_settings_page() {

            //allow only admin access to settings
            if ( ! current_user_can( 'publish_posts' ) ) {

                return;

            }

            require_once plugin_dir_path( __FILE__ ) . 'partials/wp-quizr-display-settings-page.php';

        }


        /**
         *
         * Sanitize all data from plugin settings
         * 
         * @param string settings saved in form
         * 
         * @return string sanitized form input
         *
         * @since 1.0.0
         */ 
        public static function wp_quizr_sanitize_options($input) {

            $input['option_fb_id'] = sanitize_text_field($input['option_fb_id']);

            $input['option_twtr_handle'] = sanitize_text_field($input['option_twtr_handle']);

            $input['option_custom_css'] = sanitize_text_field($input['option_custom_css']);
            
            $input['option_table_width'] = sanitize_text_field($input['option_table_width']);
            
            $input['random'] = sanitize_text_field($input['random']);

            return $input;

        }


        /**
         * Meta box setup function
         *
         * @since 1.0.0
         */
        public function wp_quizr_meta_boxes_setup() {

            $wp_quizr_options = get_option('wp_quizr_options');
            
            /*Check if app IDs have been submitted; if so, show metaboxes*/
            if ((empty($wp_quizr_options['option_fb_id'])) && (empty($wp_quizr_options['option_twtr_handle']))) {
                
            /* If no social id given, remind user to submit them. */
           
            
            }
            
            /* Add meta boxes on the 'add_meta_boxes' hook. */
            add_action('add_meta_boxes_wp_quizr', array( $this, 'wp_quizr_add_number_of_outcomes_and_questions_meta_boxes'));

            /* Save post meta on the 'save_post' hook. */
            add_action('save_post', array( $this, 'wp_quizr_save_meta_info'), 10, 2);        

        }

        /**
         * Create meta boxes to be displayed on the quiz editor screen.
         *
         * @since 1.0.0
         */
        public function wp_quizr_add_number_of_outcomes_and_questions_meta_boxes() {

            global $post;

            $number_of_outcomes                 = esc_attr(get_post_meta($post->ID, 'wp_quizr_number_of_outcomes', true));
            $number_of_questions                = esc_attr(get_post_meta($post->ID, 'wp_quizr_number_of_questions', true));
            $number_of_outcomes_titles_input    = esc_attr(get_post_meta($post->ID, 'number_of_outcomes_titles_input', true));
            $number_of_question_titles_input    = esc_attr(get_post_meta($post->ID, 'number_of_question_titles_input', true));

            //Add the number of questions and outcomes metabox unconditionally so these can be edited when needed on post page: add_meta_box( $id, $title, $callback, $screen, $context, $priority, $callback_args );
            add_meta_box('wp_quizr_number_of_questions_and_outcomes', esc_html__('Number Of Questions & Outcomes', 'wp-quizr'), array( $this, 'wp_quizr_display_number_of_questions_and_outcomes_meta_box'), 'wp_quizr', 'normal', 'default');

            add_meta_box('wp_quizr_outcomes_titles', esc_html__('Quiz Outcomes', 'wp-quizr'), array( $this, 'wp_quizr_display_outcomes_titles_meta_box'), 'wp_quizr', 'normal', 'default', array('number_of_outcomes' => $number_of_outcomes));

            add_meta_box('wp_quizr_question_titles', esc_html__('Quiz Questions', 'wp-quizr'), array( $this, 'wp_quizr_display_question_titles_meta_box'), 'wp_quizr', 'normal', 'default', array('number_of_questions' => $number_of_questions));


            //if the number of outcomes titles actually saved is equal to the number of outcomes setting, then display the outcomes meta-box
            if ($number_of_outcomes_titles_input == $number_of_outcomes) {

                for ($x = 1; $x <= $number_of_outcomes_titles_input; $x++) {

                    /* Get the saved outcome title. */
                    $wp_quizr_saved_outcomes_title_meta_value = get_post_meta($post->ID, 'wp_quizr_outcomes_title_' . $x, true);
                    add_meta_box('wp_quizr_outcomes_' . $x, esc_html__('Details For Outcome: ' . $wp_quizr_saved_outcomes_title_meta_value, 'wp-quizr'), array( $this,'wp_quizr_display_outcomes_meta_box'), 'wp_quizr', 'normal', 'default', array('$x' => $x, 'title' => $wp_quizr_saved_outcomes_title_meta_value));

                }

            }

            //if the number of question titles actually saved is equal to the number of questions setting, then display the questions meta-box
            if ($number_of_question_titles_input == $number_of_questions) {

                for ($x = 1; $x <= $number_of_question_titles_input; $x++) {

                    /* Get the saved question title. */
                    $wp_quizr_saved_question_title_meta_value = get_post_meta($post->ID, 'wp_quizr_question_title_' . $x, true);
                    add_meta_box('wp_quizr_questions_' . $x, esc_html__('Answer Choices For Question: ' . $wp_quizr_saved_question_title_meta_value, 'wp-quizr'), array( $this,'wp_quizr_display_questions_meta_box'), 'wp_quizr', 'normal', 'default', array('$x' => $x, 'title' => $wp_quizr_saved_question_title_meta_value));

                }

            }


            //if the post ID is available, display the quizz's shortcode
            if ($post->ID !== null) {

                //add_meta_box( $id, $title, $callback, $screen, $context, $priority, $callback_args );
                add_meta_box('wp_quizr_quiz_shortcode', esc_html__('Quiz Shortcode', 'wp-quizr'), array( $this,'wp_quizr_display_shortcode_meta_box'), 'wp_quizr', 'normal', 'high', array('id' => $post->ID));

            }                

        }

        /**
         *
         * Save the meta box's post metadata.
         * 
         * @param int $post_id The quiz's ID
         * @param object $post The quiz object
         * 
         * @return Null
         *
         * @since 1.0.0
         */ 
        public function wp_quizr_save_meta_info($post_id, $post) {

            /* Don't save if the user hasn't submitted the changes  */
            if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
                return;
            } 
            
            $post_args = filter_input_array(INPUT_POST);

            /* Verify the nonce before proceeding. */
            if (!isset($post_args['wp_quizr_nonce']) || !wp_verify_nonce($post_args['wp_quizr_nonce'], basename(__FILE__))) {

                return $post_id;
            }

            /* Make sure the user has permissions to post */
            if ( 'wp_quizr' == $post_args['post_type'] ) {
                if ( ! current_user_can( 'edit_post', $post_id ) ) {
                    return;
                } 
            } 

            /* Get the post type object. */
            $post_type = get_post_type_object($post->post_type);

            /* Check if the current user has permission to edit the post. */
            if (!current_user_can($post_type->cap->edit_post, $post_id)) {

                return $post_id;
            }

             /* Process and save/update # of questions & outcomes info. */

            $new_wp_quizr_number_of_outcomes = ( (isset($post_args['wp_quizr_number_of_outcomes']) && (is_numeric($post_args['wp_quizr_number_of_outcomes']))) ? $post_args['wp_quizr_number_of_outcomes'] : '' );

            /* Get the saved meta values, if any. */
            $wp_quizr_saved_number_of_outcomes_meta_value = get_post_meta($post_id, 'wp_quizr_number_of_outcomes', true);

            /* If a new meta value was added and there was no previous value, add it. */
            if ($new_wp_quizr_number_of_outcomes && '' == $wp_quizr_saved_number_of_outcomes_meta_value) {

                add_post_meta($post_id, 'wp_quizr_number_of_outcomes', $new_wp_quizr_number_of_outcomes, true);

            } elseif ($new_wp_quizr_number_of_outcomes && $new_wp_quizr_number_of_outcomes != $wp_quizr_saved_number_of_outcomes_meta_value) {

                update_post_meta($post_id, 'wp_quizr_number_of_outcomes', $new_wp_quizr_number_of_outcomes);

            } elseif ('' == $new_wp_quizr_number_of_outcomes && $wp_quizr_saved_number_of_outcomes_meta_value) {

                delete_post_meta($post_id, 'wp_quizr_number_of_outcomes');
            }


            $new_wp_quizr_number_of_questions = ( (isset($post_args['wp_quizr_number_of_questions']) && (is_numeric($post_args['wp_quizr_number_of_questions']))) ? $post_args['wp_quizr_number_of_questions'] : '' );

            $wp_quizr_saved_number_of_questions_meta_value = get_post_meta($post_id, 'wp_quizr_number_of_questions', true);

            if ($new_wp_quizr_number_of_questions && '' == $wp_quizr_saved_number_of_questions_meta_value) {

                add_post_meta($post_id, 'wp_quizr_number_of_questions', $new_wp_quizr_number_of_questions, true);

            } elseif ($new_wp_quizr_number_of_questions && $new_wp_quizr_number_of_questions != $wp_quizr_saved_number_of_questions_meta_value) {

                update_post_meta($post_id, 'wp_quizr_number_of_questions', $new_wp_quizr_number_of_questions);

            } elseif ('' == $new_wp_quizr_number_of_questions && $wp_quizr_saved_number_of_questions_meta_value) {

                delete_post_meta($post_id, 'wp_quizr_number_of_questions');

            }


            /* Process and save/update outcomes titles info. */
            $number_of_outcomes = get_post_meta($post->ID, 'wp_quizr_number_of_outcomes', true);


            $number_of_outcomes_titles_input = 0;

            for ($x = 1; $x <= $number_of_outcomes; $x++) {

                $new_wp_quizr_outcomes_title = ( (isset($post_args['wp_quizr_outcomes_title_' . $x]) && (is_string($post_args['wp_quizr_outcomes_title_' . $x]))) ? $post_args['wp_quizr_outcomes_title_' . $x] : '' );

                /* Get the saved meta values, if any. */
                $wp_quizr_saved_outcomes_title_meta_value = get_post_meta($post_id, 'wp_quizr_outcomes_title_' . $x, true);

                /* If a new meta value was added, add it. */
                if ($new_wp_quizr_outcomes_title) {

                    update_post_meta($post_id, 'wp_quizr_outcomes_title_' . $x, $new_wp_quizr_outcomes_title);

                } elseif ('' == $new_wp_quizr_outcomes_title) {

                    delete_post_meta($post_id, 'wp_quizr_outcomes_title_' . $x);
                }

                if ($new_wp_quizr_outcomes_title) {

                    $number_of_outcomes_titles_input++;

                }

            }

            update_post_meta($post_id, 'number_of_outcomes_titles_input', $number_of_outcomes_titles_input);


            /* Process and save/update question titles info. */

            $number_of_questions = get_post_meta($post->ID, 'wp_quizr_number_of_questions', true);


            $number_of_question_titles_input = 0;

            for ($x = 1; $x <= $number_of_questions; $x++) {

                /* Get new values from form POST, if any.*/
                $new_wp_quizr_show_question_text = ( (isset($post_args['wp_quizr_show_question_' . $x . '_text'])) ? $post_args['wp_quizr_show_question_' . $x . '_text'] : '0' );            

                /* Get the saved meta values, if any. */
                $wp_quizr_show_question_text_meta_value = get_post_meta($post_id, 'wp_quizr_show_question_' . $x . '_text', true);

                /* If a new meta value was added, add it. */
                if ($new_wp_quizr_show_question_text != $wp_quizr_show_question_text_meta_value) {

                    update_post_meta($post_id, 'wp_quizr_show_question_' . $x . '_text', $new_wp_quizr_show_question_text);

                }


                /* Get new values from form POST, if any. */
                $new_wp_quizr_question_title_image_url = ( (isset($post_args['wp_quizr_question_title_' . $x . '_image_url']) && (is_string($post_args['wp_quizr_question_title_' . $x . '_image_url']))) ? $post_args['wp_quizr_question_title_' . $x . '_image_url'] : '' );            

                /* Get the saved meta values, if any. */
                $wp_quizr_saved_question_title_image_url_meta_value = get_post_meta($post_id, 'wp_quizr_question_title_' . $x . '_image_url', true);

                /* If a new meta value was added, add it. */
                if ($new_wp_quizr_question_title_image_url) {

                    update_post_meta($post_id, 'wp_quizr_question_title_' . $x . '_image_url', $new_wp_quizr_question_title_image_url);

                } elseif ('' == $new_wp_quizr_question_title_image_url) {

                    delete_post_meta($post_id, 'wp_quizr_question_title_' . $x . '_image_url');

                }



                /* Get new values from form POST, if any. */
                $new_wp_quizr_question_title = ( (isset($post_args['wp_quizr_question_title_' . $x ]) && (is_string($post_args['wp_quizr_question_title_' . $x]))) ? $post_args['wp_quizr_question_title_' . $x] : '' );

                /* Get the saved meta values, if any. */
                $wp_quizr_saved_question_title_meta_value = get_post_meta($post_id, 'wp_quizr_question_title_' . $x, true);

                if ($new_wp_quizr_question_title) {

                    update_post_meta($post_id, 'wp_quizr_question_title_' . $x, $new_wp_quizr_question_title);

                } elseif ('' == $new_wp_quizr_question_title) {

                    delete_post_meta($post_id, 'wp_quizr_question_title_' . $x);

                }

                if ($new_wp_quizr_question_title) {

                    $number_of_question_titles_input++;

                }
            }

            update_post_meta($post_id, 'number_of_question_titles_input', $number_of_question_titles_input);


            /* Process and save/update outcomes image, description & outcome_url info. */

            $number_of_outcomes_titles_input = esc_attr(get_post_meta($post->ID, 'number_of_outcomes_titles_input', true));

            for ($x = 1; $x <= $number_of_outcomes_titles_input; $x++) {

                $new_wp_quizr_outcome_image_url = ( (isset($post_args['wp_quizr_outcome_' . $x . '_image_url']) && (is_string($post_args['wp_quizr_outcome_' . $x . '_image_url']))) ? $post_args['wp_quizr_outcome_' . $x . '_image_url'] : '' );

                $new_wp_quizr_outcome_description = ( (isset($post_args['wp_quizr_outcome_' . $x . '_description']) && (is_string($post_args['wp_quizr_outcome_' . $x . '_description']))) ? $post_args['wp_quizr_outcome_' . $x . '_description'] : '' );

                $new_wp_quizr_outcome_url = ( (isset($post_args['wp_quizr_outcome_' . $x . '_url']) && (is_string($post_args['wp_quizr_outcome_' . $x . '_url']))) ? $post_args['wp_quizr_outcome_' . $x . '_url'] : '' );


                /* Get the saved meta values, if any. */
                $wp_quizr_saved_outcome_image_url_meta_value = get_post_meta($post_id, 'wp_quizr_outcome_' . $x . '_image_url', true);

                $wp_quizr_saved_outcome_description = get_post_meta($post_id, 'wp_quizr_outcome_' . $x . '_description', true);

                $wp_quizr_saved_outcome_url = get_post_meta($post_id, 'wp_quizr_outcome_' . $x . '_url', true);

                /* If a new meta value was added, add it. */
                if ($new_wp_quizr_outcome_image_url) {

                    update_post_meta($post_id, 'wp_quizr_outcome_' . $x . '_image_url', $new_wp_quizr_outcome_image_url);
                }

                if ($new_wp_quizr_outcome_description) {

                    update_post_meta($post_id, 'wp_quizr_outcome_' . $x . '_description', $new_wp_quizr_outcome_description);
                }

                if ($new_wp_quizr_outcome_url) {

                    update_post_meta($post_id, 'wp_quizr_outcome_' . $x . '_url', $new_wp_quizr_outcome_url);
                }
            }


            /* Process and save/update questions & answer image asssociation info. */

            /* Get the saved # of outcomes titles. */
            $number_of_outcomes_titles_input = get_post_meta($post->ID, 'number_of_outcomes_titles_input', true);

            for ($x = 1; $x <= $number_of_question_titles_input; $x++) {

                for ($y = 1; $y <= $number_of_outcomes_titles_input; $y++) {

                    $new_wp_quizr_question_outcome_image_url = ( (isset($post_args['wp_quizr_question_' . $x . '_outcome_' . $y . '_image_url']) && (is_string($post_args['wp_quizr_question_' . $x . '_outcome_' . $y . '_image_url']))) ? $post_args['wp_quizr_question_' . $x . '_outcome_' . $y . '_image_url'] : '' );

                    /* Get the saved meta values, if any. */
                    $wp_quizr_saved_question_outcome_image_url_meta_value = get_post_meta($post_id, 'wp_quizr_question_' . $x . '_outcome_' . $y . '_image_url', true);

                    /* If a new meta value was added, add it. */
                    if ($new_wp_quizr_question_outcome_image_url) {

                        update_post_meta($post_id, 'wp_quizr_question_' . $x . '_outcome_' . $y . '_image_url', $new_wp_quizr_question_outcome_image_url);

                    }

                    /* If a there's no meta value delete the one in the database. */
                    if ($new_wp_quizr_question_outcome_image_url == '') {

                        delete_post_meta($post_id, 'wp_quizr_question_' . $x . '_outcome_' . $y . '_image_url');

                    }

                    $new_wp_quizr_question_outcome_image_caption = ( (isset($post_args['wp_quizr_question_' . $x . '_outcome_' . $y . '_image_caption']) && (is_string($post_args['wp_quizr_question_' . $x . '_outcome_' . $y . '_image_caption']))) ? $post_args['wp_quizr_question_' . $x . '_outcome_' . $y . '_image_caption'] : '' );

                    /* Get the saved meta values, if any. */
                    $wp_quizr_saved_question_outcome_image_caption_meta_value = get_post_meta($post_id, 'wp_quizr_question_' . $x . '_outcome_' . $y . '_image_caption', true);                    

                    /* If a new meta value was added, add it. */
                    if ($new_wp_quizr_question_outcome_image_caption) {

                        update_post_meta($post_id, 'wp_quizr_question_' . $x . '_outcome_' . $y . '_image_caption', $new_wp_quizr_question_outcome_image_caption);

                    }

                    /* If a there's no meta value delete the one in the database. */
                    if ($new_wp_quizr_question_outcome_image_caption == '') {

                        delete_post_meta($post_id, 'wp_quizr_question_' . $x . '_outcome_' . $y . '_image_caption');

                    }
                    
                    

                    $new_wp_quizr_question_no_outcome_image_caption = ( (isset($post_args['wp_quizr_question_' . $x . '_no_outcome_' . $y . '_image_caption']) && (is_string($post_args['wp_quizr_question_' . $x . '_no_outcome_' . $y . '_image_caption']))) ? $post_args['wp_quizr_question_' . $x . '_no_outcome_' . $y . '_image_caption'] : '' );

                    /* Get the saved meta values, if any. */
                    $wp_quizr_saved_question_no_outcome_image_caption_meta_value = get_post_meta($post_id, 'wp_quizr_question_' . $x . '_no_outcome_' . $y . '_image_caption', true);                    

                    /* If a new meta value was added, add it. */
                    if ($new_wp_quizr_question_no_outcome_image_caption) {

                        update_post_meta($post_id, 'wp_quizr_question_' . $x . '_no_outcome_' . $y . '_image_caption', $new_wp_quizr_question_no_outcome_image_caption);

                    }

                    /* If a there's no meta value delete the one in the database. */
                    if ($new_wp_quizr_question_no_outcome_image_caption == '') {

                        delete_post_meta($post_id, 'wp_quizr_question_' . $x . '_no_outcome_' . $y . '_image_caption');

                    }
                    
                    
                    $new_wp_quizr_no_outcome_image_url = ( (isset($post_args['wp_quizr_question_' . $x . '_no_outcome_image_' . $y . '_url']) && (is_string($post_args['wp_quizr_question_' . $x . '_no_outcome_image_' . $y . '_url']))) ? $post_args['wp_quizr_question_' . $x . '_no_outcome_image_' . $y . '_url'] : '' );

                    $wp_quizr_saved_no_outcome_image_url = get_post_meta($post->ID, 'wp_quizr_question_' . $x . '_no_outcome_image_' . $y . '_url', true);


                    /* If a new meta value was added, add it. */
                    if ($new_wp_quizr_no_outcome_image_url) {

                        update_post_meta($post_id, 'wp_quizr_question_' . $x . '_no_outcome_image_' . $y . '_url', $new_wp_quizr_no_outcome_image_url);

                    }

                    if ($new_wp_quizr_no_outcome_image_url == '') {

                        delete_post_meta($post_id, 'wp_quizr_question_' . $x . '_no_outcome_image_' . $y . '_url');

                    }
                }
            }
        }

        /**
         * Displays the  number of questions and outcomes meta boxes
         * 
         * @param array  $box  Argument passed into this callback function from add_meta_box() above.
         * @param object $post The quiz object
         * 
         * @since 1.0.0
         */
        public function wp_quizr_display_number_of_questions_and_outcomes_meta_box($post, $box) {

            wp_nonce_field(basename(__FILE__), 'wp_quizr_nonce');

            require_once plugin_dir_path( __FILE__ ) . 'partials/wp_quizr_display_number_of_questions_and_outcomes_meta_box.php';

        }             

        /**
         * Displays the outcomes titles meta boxes
         * 
         * @param array  $box  Argument passed into this callback function from add_meta_box() above.
         * @param object $post The quiz object
         * 
         * @since 1.0.0
         */      
        public function wp_quizr_display_outcomes_titles_meta_box($post, $box) {

            wp_nonce_field(basename(__FILE__), 'wp_quizr_outcomes_nonce');

            for ($x = 1; $x <= $box['args']['number_of_outcomes']; $x++) {

                require plugin_dir_path( __FILE__ ) . 'partials/wp_quizr_display_outcomes_titles_meta_box.php';

            }
        }

        /**
         * Displays the question titles meta boxes
         * 
         * @param array  $box  Argument passed into this callback function from add_meta_box() above.
         * @param object $post The quiz object
         * 
         * @since 1.0.0
         */   
        public function wp_quizr_display_question_titles_meta_box($post, $box) {

            global $post;

            wp_nonce_field(basename(__FILE__), 'wp_quizr_question_titles_nonce');

            for ($x = 1; $x <= $box['args']['number_of_questions']; $x++) {

                $wp_quizr_show_question_text_meta_value = get_post_meta($post->ID, 'wp_quizr_show_question_' . $x . '_text', true);

                $wp_quizr_show_question_text_selected   = !empty($wp_quizr_show_question_text_meta_value) ? 'selected="selected"' : '' ;

                require plugin_dir_path( __FILE__ ) . 'partials/wp_quizr_display_question_titles_meta_box.php';

            }
        } 

        /**
         * Displays the outcomes meta boxes
         * 
         * @param array  $box  Argument passed into this callback function from add_meta_box() above.
         * @param object $post The quiz object
         * 
         * @since 1.0.0
         */          
        public function wp_quizr_display_outcomes_meta_box($post, $box) {

            wp_nonce_field(basename(__FILE__), 'wp_quizr_outcomes_nonce_' . $box['args']['$x']);

            require plugin_dir_path( __FILE__ ) . 'partials/wp_quizr_display_outcomes_meta_box.php';

        }

        /**
         * Displays the questions meta boxes
         * 
         * @param array  $box  Argument passed into this callback function from add_meta_box() above.
         * @param object $post The quiz object
         * 
         * @since 1.0.0
         */          
        public function wp_quizr_display_questions_meta_box($post, $box) {

            require plugin_dir_path( __FILE__ ) . 'partials/wp_quizr_display_questions_meta_box.php';

        }

        /**
         * Displays the shortcode meta box
         * 
         * @param array  $box  Argument passed into this callback function from add_meta_box() above.
         * @param object $post The quiz object
         * 
         * @since 1.0.0
         */          
        public function wp_quizr_display_shortcode_meta_box($post, $box) {

            require plugin_dir_path( __FILE__ ) . 'partials/wp_quizr_display_shortcode_meta_box.php';

        } 

        /*  If social IDs have not been submitted, add the meta box with social IDs reminder
        * 
        *   @since 1.0.0
        */ 
        public function wp_quizr_remind_about_social_IDs() {

            add_meta_box('social_ids_notice', esc_html__('Important Notice:', 'wp-quizr'), array( $this,'wp_quizr_display_social_ids_reminder'), 'wp_quizr', 'normal', 'high');

        }

        /* Display meta box with social IDs reminder. */
        public function wp_quizr_display_social_ids_reminder () {
            
            require_once plugin_dir_path( __FILE__ ) . 'partials/wp-quizr-display-social-ids-reminder.php';

        }

}