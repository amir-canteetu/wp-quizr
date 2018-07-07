
<div class="wp_quizr_questions_container">
        
        <label for="wp_quizr_question_titles">
            <?php esc_html_e('Question ' . $x . '.', 'wp-quizr') ; ?>
        </label>

        <input class="widefat wp_quizr_question_titles" type="text" name="wp_quizr_question_title_<?php echo $x; ?>" id="wp_quizr_question_title_<?php echo $x; ?>" value="<?php echo esc_attr(get_post_meta($post->ID, 'wp_quizr_question_title_' . $x, true)); ?>" size="30" />
        
        <p>
            <label for="wp_quizr_show_question_<?php echo $x; ?>_text">
                
                <?php esc_html_e('Show Text For This Question?', 'wp-quizr'); ?>
                
                <a data-balloon="Select Yes if you would like the Question text to show (in addition to the image)." data-balloon-pos="up" href="#">
                    <i class="fa">&#xf059</i>
                </a>
                
            </label>  

        </p>      

        <select name="wp_quizr_show_question_<?php echo $x; ?>_text" id="wp_quizr_show_question_<?php echo $x; ?>_text" class="wp_quizr_show_question">
            <option value="1" <?php echo ($wp_quizr_show_question_text_meta_value == "1") ? 'selected="selected"' : '' ; ?> >Yes</option>                
            <option value="0" <?php echo ($wp_quizr_show_question_text_meta_value == "0") ? 'selected="selected"' : '' ; ?>>No</option>
        </select>

        <p>
           <label for="wp_quizr_question_title_<?php echo $x.'_image'; ?>">
               Question <?php echo $x; ?> Image:
           </label> 
        </p>

        <div class="img_container">
            <a class="remove-action"  data-balloon="Remove" data-balloon-pos="up" href="#">
                <i class="fas fa-times fa-2x"></i>
            </a>
            <img class="wp_quizr_question_img" style="max-width: 300px; height: auto;" src="<?php echo esc_attr(get_post_meta($post->ID, 'wp_quizr_question_title_' . $x. '_image_url', true)); ?>">
        </div>    

        <input type="hidden" class="img_url" name="wp_quizr_question_title_<?php echo $x.'_image_url'; ?>" id="wp_quizr_question_title_<?php echo $x.'_image_url'; ?>" value="<?php echo esc_attr(get_post_meta($post->ID, 'wp_quizr_question_title_' . $x. '_image_url', true)); ?>" />

        <input type="button" style="display: <?php echo esc_attr(get_post_meta($post->ID, 'wp_quizr_question_title_' . $x. '_image_url', true)) ? 'none' : 'inline-block' ?>" class ="wp_quizr_question_title_image_button add_img_btn  button button-primary button-large" id="wp_quizr_question_title_<?php echo $x. '_image_button'; ?>" class="button" value="<?php esc_html_e('Add Image', 'wp-quizr'); ?>" />

</div>            



