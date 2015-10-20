
      
<p class="shortcode_notice"><?php esc_html_e('When you have finished creating your quiz, copy and paste the following code into the post or page in which you would like it to appear.', 'wp-quizr'); ?></p>
<p class="shortcode_notice"><?php esc_html_e('DON\'T FORGET TO REPLACE "X" WITH THE NUMBER OF COLUMNS YOU WOULD LIKE TO HAVE', 'wp-quizr'); ?></p>
    
    <?php

echo '<h2>[wp_quizr id = "' . $box['args']['id'] . '"  columns = "X"]</h2>';
