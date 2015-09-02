    
    <p>
        
        <label for="wp_quizr_number_of_outcomes"><?php _e("How many outcomes would you like your quiz to have?", 'wp-quizr'); ?></label>
        <br />
        <input class="widefat" type="number" name="wp_quizr_number_of_outcomes" id="wp_quizr_number_of_outcomes" value="<?php echo esc_attr(get_post_meta($post->ID, 'wp_quizr_number_of_outcomes', true)); ?>" size="20" />
    
    </p>

    <p>
        
        <label for="wp_quizr_number_of_questions"><?php _e("How many questions would you like your quiz to have?", 'wp-quizr'); ?></label>
        <br />
        <input class="widefat" type="number" name="wp_quizr_number_of_questions" id="wp_quizr_number_of_questions" value="<?php echo esc_attr(get_post_meta($post->ID, 'wp_quizr_number_of_questions', true)); ?>" size="20" />
    
    </p>