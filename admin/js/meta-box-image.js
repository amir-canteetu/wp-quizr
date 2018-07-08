/*
 * Attaches the image uploader to the input field
 */
jQuery(document).ready(function($){
 
    // Instantiates the variable that holds the media library frame.
    var meta_image_frame;
 
    // Runs when the image button is clicked.
    $('.postbox').on("click", ".add_img_btn", function(e) {
        
                //just in case a global of the same name exists.
                if(typeof $this !== 'undefined') {
                 var $that = $this;   
                }

                $this = $(this);

                e.preventDefault();

                // If the frame already exists, re-open it.
                if ( meta_image_frame ) {
                    meta_image_frame.open();
                    return;
                }

                // Sets up the media library frame
                meta_image_frame = wp.media.frames.meta_image_frame = wp.media({
                    title   : 'Choose An Image',
                    button  : { text:  'Use This Image' },
                    library : { type: 'image' }
                });

                // Runs when an image is selected.
                meta_image_frame.on('select', function(){

                    // Grabs the attachment selection and creates a JSON representation of the model.
                    var media_attachment = meta_image_frame.state().get('selection').first().toJSON();

                    // Sends the attachment URL to our custom image input field.
                    $this.siblings( "input.img_url" ).val( media_attachment.url );
                    $this.siblings( "input.img_url" ).attr( "imgid", media_attachment.id );
                    $this.siblings( ".img_container" ).find( "img" ).attr( "src", media_attachment.sizes.medium.url );
                    $this.hide();

                    $this = $that;

                });

                // Opens the media library frame.
                meta_image_frame.open();
    });
    
    $('.postbox').on("click", 'a.remove-action', function(e){
        
                e.preventDefault();

                if(typeof $this !== 'undefined') {
                 var $that = $this;   
                } 

                $this = $(this);

                $this.hide();
                $this.siblings( "img" ).attr( "src", "" );
                $this.parent( ".img_container" ).siblings('input.img_url').attr( {"value":""} );
                $this.parent( ".img_container" ).siblings('input.img_url').attr( "imgid", '' );

                $this.parent( ".img_container" ).siblings('.add_img_btn').show( );

                $this = $that;
        
    });    
    
    $( "div.img_container" ).hover(
        function() {
          $( this ).find( "a.remove-action" ).fadeIn(300);
        }, function() {
          $( this ).find( "a.remove-action" ).fadeOut(300);
        }
    ); 
    
});