<?php

        wp_nonce_field(basename(__FILE__), 'wp_quizr_questions_nonce_' . $box['args']['$x']);

        /* Get the saved # of outcomes titles. */
        $number_of_outcomes_titles_input = esc_attr(get_post_meta($post->ID, 'number_of_outcomes_titles_input', true));  ?>
        
<div class="answer_choices_container"> 
    
        <p><strong>NB: For the best layout, choose images of equal size in this section.</strong></p>

        <?php for ($y = 1; $y <= $number_of_outcomes_titles_input; $y++) {

            /* Get the saved outcome title. */
            $wp_quizr_saved_outcomes_title_meta_value = get_post_meta($post->ID, 'wp_quizr_outcomes_title_' . $y, true); ?>
            

        <div>
                <label><?php esc_html_e('Image For Outcome: ' . $wp_quizr_saved_outcomes_title_meta_value, 'wp-quizr'); ?></label>

                <div class="img_container">
                    <a class="remove-action"  data-balloon="Remove" data-balloon-pos="up" href="#">
                        <i class="fas fa-times fa-2x"></i>
                    </a>
                    <img style="max-width: 300px; height: auto;" src="<?php echo esc_attr(get_post_meta($post->ID, 'wp_quizr_question_' . $box['args']['$x'] . '_outcome_' . $y . '_image_url', true)); ?>"> 
                </div> 
                
                <input type="hidden" class="img_url" name="wp_quizr_question_<?php echo $box['args']['$x'] . '_outcome_' . $y . '_image_url'; ?>" id="wp_quizr_question_<?php echo $box['args']['$x'] . '_outcome_' . $y . '_image_url'; ?>" value="<?php echo esc_attr(get_post_meta($post->ID, 'wp_quizr_question_' . $box['args']['$x'] . '_outcome_' . $y . '_image_url', true)); ?>" />

                <input type="button" style="display: <?php echo esc_attr( get_post_meta( $post->ID, 'wp_quizr_question_' . $box['args']['$x'] . '_outcome_' . $y . '_image_url', true ) ) ? 'none' : 'inline-block' ?>" class ="wp_quizr_question_outcome_image_button add_img_btn button button-primary button-large" id="wp_quizr_question_<?php echo $box['args']['$x'] . '_outcome_' . $y . '_image_button'; ?>" value="Add Image" />
           
                <input class="widefat image_caption" type="text" name="wp_quizr_question_<?php echo $box['args']['$x'] . '_outcome_' . $y . '_image_caption'; ?>" id="wp_quizr_question_<?php echo $box['args']['$x'] . '_outcome_' . $y . '_image_caption'; ?>" placeholder="Image Caption" value="<?php echo esc_attr(get_post_meta($post->ID, 'wp_quizr_question_' . $box['args']['$x'] . '_outcome_' . $y . '_image_caption', true)) ? esc_attr(get_post_meta($post->ID, 'wp_quizr_question_' . $box['args']['$x'] . '_outcome_' . $y . '_image_caption', true)) : ''; ?>" size="30">                
           
        </div>
            <?php
        }

         /* Display the no-outcome images, if any. */
        for ($y = 1; $y <= $number_of_outcomes_titles_input; $y++) {

            $wp_quizr_saved_no_outcome_image_url = get_post_meta($post->ID, 'wp_quizr_question_' . $box['args']['$x'] . '_no_outcome_image_' . $y . '_url', true);

            if ($wp_quizr_saved_no_outcome_image_url) {
                ?>

        <div class="no_outcome_container">
            
                    <label><?php esc_html_e('Image For No Outcome:', 'wp-quizr'); ?></label>

                    <div class="img_container">
                        <a class="remove-action"  data-balloon="Remove" data-balloon-pos="up" href="#">
                            <i class="fas fa-times fa-2x"></i>
                        </a>
                        <img style="max-width: 300px; height: auto;" src="<?php echo esc_attr(get_post_meta($post->ID, 'wp_quizr_question_' . $box['args']['$x'] . '_no_outcome_image_' . $y . '_url', true)); ?>">
                    </div> 
                    
                    <input type="hidden" class="img_url" name="wp_quizr_question_<?php echo $box['args']['$x'] . '_no_outcome_image_' . $y . '_url'; ?>" id="wp_quizr_question_<?php echo $box['args']['$x'] . '_no_outcome_image_' . $y . '_url'; ?>" value="<?php echo esc_attr(get_post_meta($post->ID, 'wp_quizr_question_' . $box['args']['$x'] . '_no_outcome_image_' . $y . '_url', true)); ?>" />

                    <input type="button" style="display: <?php echo esc_attr(get_post_meta($post->ID, 'wp_quizr_question_' . $box['args']['$x'] . '_no_outcome_image_' . $y . '_url', true)) ? 'none' : 'inline-block' ?>" class ="wp_quizr_question_outcome_image_button add_img_btn button button-primary button-large" id="wp_quizr_question_<?php echo $box['args']['$x'] . '_no_outcome_image_' . $y . '_button'; ?>" value="Add Image" />        
                 
                    <input class="widefat image_caption" type="text" name="wp_quizr_question_<?php echo $box['args']['$x'] . '_no_outcome_' . $y . '_image_caption'; ?>" id="wp_quizr_question_<?php echo $box['args']['$x'] . '_no_outcome_' . $y . '_image_caption'; ?>" placeholder="Image Caption" value="<?php echo esc_attr(get_post_meta($post->ID, 'wp_quizr_question_' . $box['args']['$x'] . '_no_outcome_' . $y . '_image_caption', true)) ? esc_attr(get_post_meta($post->ID, 'wp_quizr_question_' . $box['args']['$x'] . '_no_outcome_' . $y . '_image_caption', true)) : ''; ?>" size="30">                
                     
        </div>

                <?php
            }
        }
        ?>    
        <div>
            <label for="re_1">
                <?php esc_html_e('Add Images With No Associated Outcomes Here (Optional)', 'wp-quizr'); ?>
            </label>
            <span>
                <img class="add_no_assoc_img" number_of_outcomes="<?php echo get_post_meta($post->ID, 'number_of_outcomes_titles_input', true); ?>" question-number="<?php echo $box['args']['$x']; ?>" src="<?php echo plugins_url( '/images/add.png', dirname(__FILE__)); ?>"> 
            </span>
        </div>
    
</div>          
        <?php

