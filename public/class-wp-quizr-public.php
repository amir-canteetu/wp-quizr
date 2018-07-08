<?php

defined( 'ABSPATH' ) || exit;

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    WP_Quizr
 * @subpackage WP_Quizr/public
 * @author     Amir Canteetu <amircanteetu@gmail.com>
 */
class WP_Quizr_Public {

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
	 * @param      string    $version           The version of this plugin.
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

                global $post;
                
                if( is_object( $post ) ):
                    /* Load only if custom type "wp_quizr" is being viewed */  
                    if (has_shortcode($post->post_content, 'wp_quizr')) {

                        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-quizr-public.min.css', array(), $this->version, 'all' );

                    }                    
                endif;
                
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
                
                global $post;
                
                if( is_object( $post ) ):
                    
                    /* Load only if custom type "wp_quizr" is being viewed */  
                    if (has_shortcode($post->post_content, 'wp_quizr')) {

                        wp_enqueue_script( 'wp_quizr_js', plugin_dir_url( __FILE__ ) . 'js/wp-quizr-public.min.js', array( 'jquery' ), $this->version, false );

                        /* Get current page protocol */
                        $protocol = isset($_SERVER["HTTPS"]) ? 'https://' : 'http://';

                        /* Output admin-ajax.php URL with same protocol as current page */
                        $params = array();
                        
                        $params['ajaxurl']  = admin_url('admin-ajax.php', $protocol);
                        $params['security'] = wp_create_nonce("ajax_security_nonce");

                        wp_localize_script('wp_quizr_js', 'wp_quizr_js_data', $params);

                    }  
                    
                endif;
                
	}
        
        
        /*  Register the shortcode. 
        * 
        *   @since 1.0.0
        */  
        public function wp_quizr_register_shortcode() {

            //Register shortcode [wp_quizr]
            add_shortcode('wp_quizr', array( $this, 'wp_quizr_shortcode_callback') );

        }  
        
        
        /*  Display the shortcode content. 
        * 
        *   @since 1.0.0
        */     
        public function wp_quizr_shortcode_callback($atts) {

            extract(shortcode_atts(array(), $atts));

            $post_id                            = $atts['id'];
            $number_of_columns                  = is_numeric($atts['columns']) ? $atts['columns'] : 2;
            $quiz_title                         = get_the_title( $post_id );
            $wp_quizr_options                   = get_option('wp_quizr_options');
            $table_width                        = $wp_quizr_options['option_table_width'] ? $wp_quizr_options['option_table_width']  : '100';
            $number_of_outcomes_titles_input    = esc_attr(get_post_meta($post_id, 'number_of_outcomes_titles_input', true));
            $number_of_question_titles_input    = esc_attr(get_post_meta($post_id, 'number_of_question_titles_input', true));
            //store the post's ID in the form so we can use it later for Ajax request               
            $quiz_content                       = '<form id = "take-the-quiz" data-id="' . $post_id . '" class="quiz-form" name="wp_quizr_form" method = "post" style="width:' .$table_width.'%">';

            for ($x = 1; $x <= $number_of_question_titles_input; $x++) {
                
                $wp_quizr_cell_array = array();

                $question_title = get_post_meta($post_id, 'wp_quizr_question_title_' . $x . '', true);

                $wp_quizr_question_title_image_url =  get_post_meta($post_id, 'wp_quizr_question_title_' . $x . '_image_url', true);

                $wp_quizr_show_question_text_meta_value = get_post_meta($post_id, 'wp_quizr_show_question_' . $x . '_text', true);

                $quiz_content .= $wp_quizr_show_question_text_meta_value ? '<h4 class="quiz-question-title">' . $question_title . '</h4>' : '';

                $quiz_content .= '<table class="quiz-table-listing" id="quiz_question_' . $x . '">';

                $quiz_content .= '<tbody class="quiz-question">';
                    //if question image exists, show it
                    if($wp_quizr_question_title_image_url) {

                        $quiz_content .= '<tr><td colspan="'. $number_of_columns .'"><img class="responsive" src="'. $wp_quizr_question_title_image_url .'" class="question_title_image"></td></tr>';

                    }

                for ($y = 1; $y <= $number_of_outcomes_titles_input; $y++) {

                    $wp_quizr_saved_question_outcome_image_url_meta_value = get_post_meta($post_id, 'wp_quizr_question_' . $x . '_outcome_' . $y . '_image_url', true);

                    $wp_quizr_saved_no_outcome_image_url = get_post_meta($post_id, 'wp_quizr_question_' . $x . '_no_outcome_image_' . $y . '_url', true);

                    $wp_quizr_saved_question_outcome_image_caption_meta_value = get_post_meta($post_id, 'wp_quizr_question_' . $x . '_outcome_' . $y . '_image_caption', true);
                    
                    $wp_quizr_saved_question_no_outcome_image_caption_meta_value = get_post_meta($post_id, 'wp_quizr_question_' . $x . '_no_outcome_' . $y . '_image_caption', true);
                    
                    if ($wp_quizr_saved_question_outcome_image_url_meta_value) {

                        $wp_quizr_cell_array[] = '<td>' . '<div class="quiz-img-contain notselected" data-id="' . $y . '">' . '<img class="responsive" src="' . $wp_quizr_saved_question_outcome_image_url_meta_value . '" class="quiz-img">' . '<div class="quiz_checkbox_wrp"><span class="quiz_checkbox quiz-checkbox_unchecked"></span><span class="quiz_answer_text">'. $wp_quizr_saved_question_outcome_image_caption_meta_value .'</span></span></div>' . '</td>';

                    }

                    if ($wp_quizr_saved_no_outcome_image_url) {

                        $wp_quizr_cell_array[]  = '<td>' . '<div class="quiz-img-contain notselected">' . '<img class="responsive" src="' . $wp_quizr_saved_no_outcome_image_url . '" class="quiz-img">' . '<div class="quiz_checkbox_wrp"><span class="quiz_checkbox quiz-checkbox_unchecked"></span><span class="quiz_answer_text">'. $wp_quizr_saved_question_no_outcome_image_caption_meta_value .'</span></span></div>' . '</td>';

                    }

                }
                
                if($wp_quizr_options['random'] == true) {
                    
                    shuffle ( $wp_quizr_cell_array );
                    
                }
                
                for($i=0; $i < count($wp_quizr_cell_array); $i++) {
                    
                    $quiz_content .= ($i==0 || ($i % $number_of_columns == 0))? '<tr>' : '';
                    
                    $quiz_content .= $wp_quizr_cell_array[$i]; 
                    
                    $quiz_content .= ($i==($number_of_columns-1) || $i==count($wp_quizr_cell_array))? '</tr>' : '';
                    
                }

                $quiz_content .= '</tbody></table>';

            }

            $quiz_content .= '</form>';

            $quiz_content .= '<div id="ajax-loader" class="hide"></div>';

            $quiz_content .= '<div class="quiz-result-container hide" id="quiz-result-container" style="width:' .$table_width.'%">';

            $quiz_content .= '<p class="quiz-title"><span class="quiz-title">'. $quiz_title .'</span></p>';        

            $quiz_content .= '<p class="quiz-results-p"><span class="you-got">You Got:</span><span class="you-got-answer"></span></p>';

            $quiz_content .= '<div class="img-desc-contain">
                                        <a href="" class="outcome_image_link">
                                            <img class="responsive" id="answer-img-result" src="">
                                        </a>';

            $quiz_content .= '<div class="desc">
                                    <p id="description"></p>
                                        <p id="cta"></p>
                              </div>

                              </div> <!-- end img-desc-contain -->';

            $quiz_content .= '<div class="share-your-results-container">';

            $quiz_content .= '<p>Share Your Results!</p>';

            $quiz_content .= '<div id="share-buttons">';

            $quiz_content .= '<a  class="fb-share" href="#"><i class="fa fa-facebook"></i><span>SHARE</span>                            </a>';

            $quiz_content .= '<a href="#" class="twitter-share"><i class="fa fa-twitter"></i><span>TWEET</span></a>
                              
                            </div>
                            
                            </div>

                            </div>';

            return $quiz_content;
            
        }  
        
        
        /*  Get post meta using Ajax. 
        * 
        *   @since 1.0.0
        */      
        public function wp_quizr_ajax() {
            
            check_ajax_referer( 'ajax_security_nonce', 'security' );
            $post_args = filter_input_array(INPUT_POST);
            
            $outcome_array                          = array();
            $outcome_array['image_url']             = get_post_meta($post_args['post_ID'], 'wp_quizr_outcome_' .        $post_args['result'] . '_image_url', true);
            $outcome_array['outcome_title']         = get_post_meta($post_args['post_ID'], 'wp_quizr_outcomes_title_' . $post_args['result'] . '', true);
            $outcome_array['outcome_description']   = get_post_meta($post_args['post_ID'], 'wp_quizr_outcome_' .        $post_args['result'] . '_description', true);
            $outcome_array['outcome_link']          = get_post_meta($post_args['post_ID'], 'wp_quizr_outcome_' .        $post_args['result'] . '_url', true);

            $outcome_json = json_encode( $outcome_array );
            echo $outcome_json;

            wp_die();

        }
        
        
        /*  Display meta content in <head>. 
        * 
        *   @since 1.0.0
        */  
        public function wp_quizr_add_meta_tags() {

            global $post;
            
                if( is_object( $post ) ):
                    if (has_shortcode($post->post_content, 'wp_quizr')) {
                            require_once plugin_dir_path( __FILE__ ) . 'partials/wp_quizr_add_meta_tags.php';
                    }                    
                endif;

        }
        
        
        /*  Custom css in <head>. 
        * 
        *   @since 1.0.0
        */     
        public function wp_quizr_add_custom_css() {

            if( $wp_quizr_options = get_option( 'wp_quizr_options' ) ): ?>

                    <style type="text/css" lang="engl">
                        <?php echo $wp_quizr_options['option_custom_css'];?>
                    </style>  
                    
            <?php endif;

            }
      

}