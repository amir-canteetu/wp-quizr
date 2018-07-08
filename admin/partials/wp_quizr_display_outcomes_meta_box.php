    
<div class="wp_quizr_outcomes_container">

    <div>
        <label for="wp_quizr_outcomes_<?php echo $box['args']['$x'] . '_image'; ?>"><?php esc_html_e('Outcome Image:', 'wp-quizr'); ?></label>

        <div class="img_container">
            <a class="remove-action"  data-balloon="Remove" data-balloon-pos="up" href="#">
                <i class="fas fa-times fa-2x"></i>
            </a>
            <img style="max-width: 300px; height: auto;" src="<?php echo esc_attr(get_post_meta($post->ID, 'wp_quizr_outcome_' . $box['args']['$x'] . '_image_url', true)); ?>">
        </div>  
        
        <input type="hidden" name="wp_quizr_outcome_<?php echo $box['args']['$x'] . '_image_url'; ?>" class="img_url" id="wp_quizr_outcome_<?php echo $box['args']['$x'] . '_image_url'; ?>" value="<?php echo esc_attr(get_post_meta($post->ID, 'wp_quizr_outcome_' . $box['args']['$x'] . '_image_url', true)); ?>" />
        <input type="button" class ="wp_quizr_outcome_image_button add_img_btn button button-primary button-large"  style="display: <?php echo esc_attr(get_post_meta($post->ID, 'wp_quizr_outcome_' . $box['args']['$x'] . '_image_url', true)) ? 'none' : 'inline-block' ?>"  id="wp_quizr_outcome_<?php echo $box['args']['$x'] . '_image_button'; ?>" class="button" value="<?php esc_html_e('Add Image', 'wp-quizr'); ?>" />
    </div> 
    
    <div>
            <label for="wp_quizr_outcome_<?php echo $box['args']['$x'] . '_description'; ?>"><?php echo 'Description'; ?></label>
            <textarea name="wp_quizr_outcome_<?php echo $box['args']['$x'] . '_description'; ?>" id="wp_quizr_outcome_<?php echo $box['args']['$x'] . '_description'; ?>" style cols = "80" rows = "10"> <?php echo esc_attr(get_post_meta($post->ID, 'wp_quizr_outcome_' . $box['args']['$x'] . '_description', true)); ?> </textarea>    
    </div>


    <div>
        <label for="wp_quizr_outcome_<?php echo $box['args']['$x'] . '_url'; ?>">
            
            <?php echo 'Outcome URL Link'; ?>
            <a data-balloon="Where would you like this outcome image to link to?" data-balloon-pos="up" href="#">
                <i class="fa">&#xf059</i>
            </a>   
            
        </label>
        <input class="widefat" type="text" name="wp_quizr_outcome_<?php echo $box['args']['$x'] . '_url'; ?>" id="wp_quizr_outcome_<?php echo $box['args']['$x'] . '_url'; ?>" value="<?php echo esc_attr(get_post_meta($post->ID, 'wp_quizr_outcome_' . $box['args']['$x'] . '_url', true)); ?>" size="30" />
    </div>
    
</div>







