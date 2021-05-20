jQuery( document ).ready( function($) {

    var review_request_functions = {

        ajax_init : function() {

            $review_request_notice.on( 'click' , '.button' , function(e) {

                e.preventDefault();

                var $button   = $(this),
                    response  = $button.data( 'response' )
                    ajax_args = {
                        url      : ajaxurl,
                        type     : "POST",
                        data     : {
                            action                  : "ta_request_review_response",
                            review_request_response : response
                        },
                        dataType : "json"
                    };

                $.ajax( ajax_args );

                if ( response === 'review' )
                    window.open( $button.prop( 'href' ) );

                $review_request_notice.fadeOut( 'fast' );
            } );

        }

    };

    var $review_request_notice = $( '.ta-review-request.notice' );

    review_request_functions.ajax_init();
});
