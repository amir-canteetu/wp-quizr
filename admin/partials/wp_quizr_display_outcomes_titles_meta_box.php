    
    <p>
        <label for="wp_quizr_outcomes_titles"><?php esc_html_e( 'Outcome Title ' . $x . '.', 'wp-quizr'); ?></label>
        <br />
        <input class="widefat" type="text" name="wp_quizr_outcomes_title_<?php echo $x; ?>" id="wp_quizr_outcomes_title_<?php echo $x; ?>" value="<?php echo esc_attr(get_post_meta($post->ID, 'wp_quizr_outcomes_title_' . $x, true)); ?>" size="30" />
    </p>
