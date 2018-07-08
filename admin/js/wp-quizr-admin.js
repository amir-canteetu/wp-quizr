(function( $ ) {
	

	$(function() {
        
            $('img.add_no_assoc_img').on( "click", function(e) {

                var wp_quizr_question_number = $(this).attr('question-number'),

                wp_quizr_number_of_outcomes = $(this).attr('number_of_outcomes'),

                counter = 1;

                e.preventDefault();

                for (x = 1; x <=wp_quizr_number_of_outcomes; x++ ) {

                    if($('#wp_quizr_question_'+wp_quizr_question_number+'_no_outcome_image_'+x+'_url').length) {
                       counter++;
                    }

                }

                var newRow = $('<div class="no_outcome_container"><label>Image For No Outcome:</label><div class="img_container"><a class="remove-action"  data-balloon="Remove" data-balloon-pos="up" href="#"><i class="fas fa-times fa-2x"></i></a><img style="max-width: 300px; height: auto;" src=""></div><input type="hidden" class="img_url" name="wp_quizr_question_' + wp_quizr_question_number + '_no_outcome_image_' + counter + '_url" id="wp_quizr_question_' + wp_quizr_question_number + '_no_outcome_image_' + counter + '_url" value=""><input type="button" class="add_img_btn button button-primary button-large wp_quizr_question_outcome_image_button" id="wp_quizr_question_' + wp_quizr_question_number + '_no_outcome_image_' + counter + '_button" value="Add Image"><input class="widefat image_caption" type="text" name="wp_quizr_question_' + wp_quizr_question_number + '_no_outcome_' + counter + '_image_caption" id="wp_quizr_question_' + wp_quizr_question_number + '_no_outcome_' + counter + '_image_caption" placeholder="Image Caption" value="" size="30"></div>');
                newRow.insertBefore($(this).parent().parent());

            });
            
            $( "#publish-quiz-q-o" ).on( "click", function() {
             
                $( "#publish" ).trigger( "click" );
             
            });
        
	});
	

})( jQuery );
