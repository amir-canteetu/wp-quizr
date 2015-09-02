    <p>
        <label for="wp_quizr_outcomes_<?php echo $box['args']['$x'] . '_image'; ?>"><?php esc_html_e('Outcome Image:', 'wp-quizr'); ?></label>
        <br />
        <br />
        <img style="max-width: 100%; height: auto;" src="<?php echo esc_attr(get_post_meta($post->ID, 'wp_quizr_outcome_' . $box['args']['$x'] . '_image_url', true)); ?>">   
        <input type="hidden" name="wp_quizr_outcome_<?php echo $box['args']['$x'] . '_image_url'; ?>" id="wp_quizr_outcome_<?php echo $box['args']['$x'] . '_image_url'; ?>" value="<?php echo esc_attr(get_post_meta($post->ID, 'wp_quizr_outcome_' . $box['args']['$x'] . '_image_url', true)); ?>" />
        <br />
        <br />
        <input type="button" class ="wp_quizr_outcome_image_button" id="wp_quizr_outcome_<?php echo $box['args']['$x'] . '_image_button'; ?>" class="button" value="<?php esc_html_e('Choose or Upload an Image', 'wp-quizr'); ?>" />
    </p>    

    <p>
        <label for="wp_quizr_outcome_<?php echo $box['args']['$x'] . '_description'; ?>"><?php echo 'Description'; ?></label>
        <br />
        <textarea name="wp_quizr_outcome_<?php echo $box['args']['$x'] . '_description'; ?>" id="wp_quizr_outcome_<?php echo $box['args']['$x'] . '_description'; ?>" style cols = "80" rows = "10"> <?php echo esc_attr(get_post_meta($post->ID, 'wp_quizr_outcome_' . $box['args']['$x'] . '_description', true)); ?> </textarea>
    </p>

    <p>
        <label for="wp_quizr_outcome_<?php echo $box['args']['$x'] . '_url'; ?>"><?php echo 'Outcome URL Link'; ?></label>
        <br />
        <input class="widefat" type="text" name="wp_quizr_outcome_<?php echo $box['args']['$x'] . '_url'; ?>" id="wp_quizr_outcome_<?php echo $box['args']['$x'] . '_url'; ?>" value="<?php echo esc_attr(get_post_meta($post->ID, 'wp_quizr_outcome_' . $box['args']['$x'] . '_url', true)); ?>" size="30" />
    </p>

