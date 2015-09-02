<?php

        wp_nonce_field(basename(__FILE__), 'wp_quizr_questions_nonce_' . $box['args']['$x']);

        /* Get the saved # of outcomes titles. */
        $number_of_outcomes_titles_input = esc_attr(get_post_meta($post->ID, 'number_of_outcomes_titles_input', true));

        for ($y = 1; $y <= $number_of_outcomes_titles_input; $y++) {

            /* Get the saved outcome title. */
            $wp_quizr_saved_outcomes_title_meta_value = get_post_meta($post->ID, 'wp_quizr_outcomes_title_' . $y, true);
            ?>

            <p>
                <label><?php esc_html_e('Image For Outcome: ' . $wp_quizr_saved_outcomes_title_meta_value, 'wp-quizr'); ?></label>
                <br />
                <br />
                <img style="max-width: 100%; height: auto;" src="<?php echo esc_attr(get_post_meta($post->ID, 'wp_quizr_question_' . $box['args']['$x'] . '_outcome_' . $y . '_image_url', true)); ?>"> 
                <input type="hidden" name="wp_quizr_question_<?php echo $box['args']['$x'] . '_outcome_' . $y . '_image_url'; ?>" id="wp_quizr_question_<?php echo $box['args']['$x'] . '_outcome_' . $y . '_image_url'; ?>" value="<?php echo esc_attr(get_post_meta($post->ID, 'wp_quizr_question_' . $box['args']['$x'] . '_outcome_' . $y . '_image_url', true)); ?>" />
                <br />
                <br />
                <input type="button" class ="wp_quizr_question_outcome_image_button" id="wp_quizr_question_<?php echo $box['args']['$x'] . '_outcome_' . $y . '_image_button'; ?>" class="button" value="Choose or Upload an Image" />
                <br />
                <br />
                <input type="button" class ="wp_quizr_question_outcome_remove_img_button" id="wp_quizr_question_<?php echo $box['args']['$x'] . '_outcome_' . $y . '_remove_img_button'; ?>" class="button" value="Remove Image" />
            </p> 
            <?php
        }

         /* Display the no-outcome images, if any. */
        for ($y = 1; $y <= $number_of_outcomes_titles_input; $y++) {

            $wp_quizr_saved_no_outcome_image_url = get_post_meta($post->ID, 'wp_quizr_question_' . $box['args']['$x'] . '_no_outcome_image_' . $y . '_url', true);

            if ($wp_quizr_saved_no_outcome_image_url) {
                ?>

                <p>
                    <label><?php esc_html_e('Image For No Outcome', 'wp-quizr'); ?></label>
                    <br />
                    <br />
                    <img style="max-width: 100%; height: auto;" src="<?php echo esc_attr(get_post_meta($post->ID, 'wp_quizr_question_' . $box['args']['$x'] . '_no_outcome_image_' . $y . '_url', true)); ?>"> 
                    <input type="hidden" name="wp_quizr_question_<?php echo $box['args']['$x'] . '_no_outcome_image_' . $y . '_url'; ?>" id="wp_quizr_question_<?php echo $box['args']['$x'] . '_no_outcome_image_' . $y . '_url'; ?>" value="<?php echo esc_attr(get_post_meta($post->ID, 'wp_quizr_question_' . $box['args']['$x'] . '_no_outcome_image_' . $y . '_url', true)); ?>" />
                    <br />
                    <br />
                    <input type="button" class ="wp_quizr_question_outcome_image_button" id="wp_quizr_question_<?php echo $box['args']['$x'] . '_no_outcome_image_' . $y . '_button'; ?>" class="button" value="Choose or Upload an Image" />        
                    <br>
                    <br>
                    <input type="button" class="wp_quizr_question_outcome_remove_img_button" value="Remove Image">
                </p> 

                <?php
            }
        }
        ?>    
        <p>
            <label for="re_1"><?php esc_html_e('Add Images With No Associated Outcomes Here', 'wp-quizr'); ?></label>
            <br/>
            <br/>
            <span>
                <img class="add_no_assoc_img" number_of_outcomes="<?php echo get_post_meta($post->ID, 'number_of_outcomes_titles_input', true); ?>" question-number="<?php echo $box['args']['$x']; ?>" src="<?php echo plugins_url( '/images/add.png', dirname(__FILE__)); ?>"> 
            </span>
        </p> 
        <?php

