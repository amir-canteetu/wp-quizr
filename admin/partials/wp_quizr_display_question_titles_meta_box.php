
    <p>
        
        <label for="wp_quizr_question_titles"><?php esc_html_e('Question ' . $x . '.', 'wp-quizr') ; ?></label>
        <br />
        <input class="widefat" type="text" name="wp_quizr_question_title_<?php echo $x; ?>" id="wp_quizr_question_title_<?php echo $x; ?>" value="<?php echo esc_attr(get_post_meta($post->ID, 'wp_quizr_question_title_' . $x, true)); ?>" size="30" />
    
    <br />
    <br />
    
    <label for="wp_quizr_show_question_<?php echo $x; ?>_text"><?php esc_html_e('Show Text For This Question?', 'wp-quizr'); ?></label>
    
    <select name="wp_quizr_show_question_<?php echo $x; ?>_text" id="wp_quizr_show_question_<?php echo $x; ?>_text">
        <option value="1" <?php echo ($wp_quizr_show_question_text_meta_value == "1") ? 'selected="selected"' : '' ; ?> >Yes</option>                
        <option value="0" <?php echo ($wp_quizr_show_question_text_meta_value == "0") ? 'selected="selected"' : '' ; ?>>No</option>
    </select>
    
    <br />
    <br />
    
    <label for="wp_quizr_question_title_<?php echo $x.'_image'; ?>">Question <?php echo $x; ?> Image:</label>
    
    <br />
    <br />
    
    <img style="max-width: 100%; height: auto;" src="<?php echo esc_attr(get_post_meta($post->ID, 'wp_quizr_question_title_' . $x. '_image_url', true)); ?>">   
    
    
    <input type="hidden" name="wp_quizr_question_title_<?php echo $x.'_image_url'; ?>" id="wp_quizr_question_title_<?php echo $x.'_image_url'; ?>" value="<?php echo esc_attr(get_post_meta($post->ID, 'wp_quizr_question_title_' . $x. '_image_url', true)); ?>" />
    
    <br />
    <br />
    
    <input type="button" class ="wp_quizr_question_title_image_button" id="wp_quizr_question_title_<?php echo $x. '_image_button'; ?>" class="button" value="<?php esc_html_e('Choose or Upload an Image', 'wp-quizr'); ?>" />
    
    <br />
    <br />
    
    <input type="button" class ="wp_quizr_question_title_image_remove_img_button" id="wp_quizr_question_<?php echo $x.'_image_url_remove_img_button'; ?>" class="button" value="<?php esc_html_e('Remove Image', 'wp-quizr'); ?>" />        
    
    </p>            



