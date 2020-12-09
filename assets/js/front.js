(function($) {

    FWP.hooks.addAction('facetwp/loaded', function() {
        $('.facetwp-color').each(function() {
            if ( $(this).attr('data-img') ) {
                $(this).css('background-image', 'url("'+$(this).attr('data-img')+'"');
                $(this).css('background-position', 'center');
                $(this).css('background-size', 'cover');
            }            
        });
    });

})(jQuery);
