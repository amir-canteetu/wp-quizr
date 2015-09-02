/*
 * Attaches the image uploader to the input field
 */
jQuery(document).ready(function($){
 
    // Instantiates the variable that holds the media library frame.
    var meta_image_frame;
 
    // Runs when the image button is clicked.
    $('.wp_quizr_outcome_image_button, .wp_quizr_question_outcome_image_button, .wp_quizr_question_title_image_button').live("click", function(e){
        
        //just in case a global of the same name exists.
        if(typeof $this !== 'undefined') {
         var $that = $this;   
        }
        
        
        $this = $(this);
 
        // Prevents the default action from occuring.
        e.preventDefault();
 
        // If the frame already exists, re-open it.
        if ( meta_image_frame ) {
            meta_image_frame.open();
            return;
        }
 
        // Sets up the media library frame
        meta_image_frame = wp.media.frames.meta_image_frame = wp.media({
            title: 'Choose An Image',
            button: { text:  'Use This Image' },
            library: { type: 'image' }
        });
 
        // Runs when an image is selected.
        meta_image_frame.on('select', function(){
 
            // Grabs the attachment selection and creates a JSON representation of the model.
            var media_attachment = meta_image_frame.state().get('selection').first().toJSON();
 
            // Sends the attachment URL to our custom image input field.
            $this.prev().prev().prev().val(media_attachment.url);
            $this.prev().prev().prev().prev().attr("src", media_attachment.url);
            $this = $that;
            
        });
 
        // Opens the media library frame.
        meta_image_frame.open();
    });
    
    $('.wp_quizr_question_outcome_remove_img_button, .wp_quizr_question_title_image_remove_img_button').live("click", function(e){
        $(this).prev().prev().prev().prev().prev().prev().prev().attr("src", "");
        $(this).prev().prev().prev().prev().prev().prev().attr({"id": "", "value":"", "name": ""});
        
    });
    
});