(function( $ ) {
	'use strict';

        $(function() {
            
            
            var results = [],

            number_of_questions = $('.quiz-question').length,

            remaining_questions = number_of_questions;

            $('.quiz-img-contain').click(function () {

                if(!($(this).hasClass('quiz-item-disabled')) && !($(this).hasClass('quiz-item-selected'))) {            

                    var answer = $(this).attr('data-id');

                    results.push(answer);

                    $(this).removeClass('quiz-item-hover');

                    $(this).addClass('quiz-item-selected');

                    $(this).removeClass('notselected');

                    $(this).parent().parent().parent().find(".notselected").addClass('quiz-item-disabled');

                    if(remaining_questions > 0) {

                        --remaining_questions;

                    }; 

                    if (remaining_questions == 0) {

                              $('#see-results-container').removeClass('hide');
                              $('#ajax-loader').removeClass('hide');


                        var frequency = {},  // object of frequency.
                        max = 0,  // holds the max frequency.
                        result;   // holds the max frequency element.
                        for(var v in results) {
                            frequency[results[v]]=(frequency[results[v]] || 0)+1; // increment frequency.
                            if(frequency[results[v]] > max) { // is this frequency > max so far ?
                                max = frequency[results[v]];  // update max.
                                result = results[v];          // update result.
                            }
                        }

                        var post_ID = $('#take-the-quiz').attr('data-id');

                        wp_quizr_js_data.result = result;

                        // Prepare Ajax data: action and post id
                        var data = {
                            action: 'wp_quizr_ajax',
                            post_ID: post_ID,
                            result: result
                        };

                        $.ajax({
                            url: wp_quizr_js_data.ajaxurl,
                            data: data,
                            dataType : "json",
                            success: function(resp) {

                               $('#ajax-loader').addClass('hide');
                               $('#answer-img-result').attr('src', resp.image_url);
                               $('.you-got-answer').text(resp.outcome_title);
                               $('.img-desc-contain #description').html(resp.outcome_description);
                               $('.outcome_image_link').attr('href', resp.outcome_link);
                               $('.quiz-result-container').removeClass('hide');

                               // share attributes.
                               $('meta[name=image_url]').attr('content', resp.image_url);
                               $('meta[name=outcome_title]').attr('content', encodeURIComponent("I got " + resp.outcome_title + "! "));
                               $('meta[name=outcome_description]').attr('content', encodeURIComponent(resp.outcome_description));

                            }
                        });

                    };

                }

              return false;
        });

            $('.quiz-img-contain').hover(
              function() {
                if (!$(this).hasClass('quiz-item-selected')) {
                  $(this).addClass('quiz-item-hover');
                }
              },
              function() {
                $(this).removeClass('quiz-item-hover');
              }
            );

            $(function() {
                $('.twitter-share').click(function() {
                  var twitterShare = $('meta[name="outcome_title"]').attr('content') + " " + $('meta[name="shareUrl"]').attr('content') +
                      " via @" + $('meta[name="twtr_handle"]').attr('content'),
                    url = 'http://twitter.com/share?text=' + twitterShare + '&url=/&counturl=' + $('meta[name="shareUrl"]').attr('content'),
                    opts   = 'status=1' +
                      ',width=' + 575 +
                      ',height=' + 400 +
                      ',top=' + 50 +
                      ',left=' + 50;

                  window.open(url, 'twitter', opts);
                  return false;
                });
            });


            $(function() {

                $('.fb-share').click(function() {

                  var url = 'https://www.facebook.com/dialog/feed?link=display=popup&app_id=' + $('meta[name="fbAppId"]').attr('content')+
                          '&redirect_uri=' + $('meta[name="shareUrl"]').attr('content')+
                          '&picture=' + $('meta[name="image_url"]').attr('content')+
                          '&description=' + $('meta[name="outcome_description"]').attr('content')+
                          '&link=' + $('meta[name="shareUrl"]').attr('content')+
                          '&name=' + $('meta[name="outcome_title"]').attr('content'),
                    opts   = 'toolbar=0, status=0, top=50, left=50,width=580, height=400';

                  window.open(url, 'Sharer', opts);

                  return false;

                });

            });

            $(function() {

                $('#take-quiz-again-link').click(function() {

                    location.reload();

                });

            });            
            
            
            
	  });

})( jQuery );
