(function( $ ) {
	

	$(function() {
	
        
            jQuery('img.add_no_assoc_img').click(function(event){

                var wp_quizr_question_number = jQuery(this).attr('question-number'),

                wp_quizr_number_of_outcomes = jQuery(this).attr('number_of_outcomes'),

                counter = 1;

                event.preventDefault();

                for (x = 1; x <=wp_quizr_number_of_outcomes; x++ ) {

                 if(jQuery('#wp_quizr_question_'+wp_quizr_question_number+'_no_outcome_image_'+x+'_url').length) {

                    counter++;

                    }

                }

                var newRow = jQuery('<p><label>Image For No Outcome</label><br><br><img style="max-width: 100%; height: auto;" src=""><input type="hidden" name="wp_quizr_question_' + wp_quizr_question_number + '_no_outcome_image_' + counter + '_url" id="wp_quizr_question_' + wp_quizr_question_number + '_no_outcome_image_' + counter + '_url" value=""><br><br><input type="button" class="wp_quizr_question_outcome_image_button" id="wp_quizr_question_' + wp_quizr_question_number + '_no_outcome_image_' + counter + '_button" value="Choose or Upload an Image"><br><br><input type="button" class="wp_quizr_question_outcome_remove_img_button" value="Remove Image"></p>');

                newRow.insertBefore(jQuery(this).parent().parent());

                //remove handler if the number of no-outcome images is the same as the total number of outcomes; to prevent excess no-outcome images
                if(counter == wp_quizr_number_of_outcomes) {

                   jQuery(this).unbind("click"); 

                }
            });        
        
        
	});
	

})( jQuery );
