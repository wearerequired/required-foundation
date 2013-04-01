(function($) {

    $(document).foundation();

    /**
     * So you set a timeout on your alert-box, it will fade out
     */
    $('.alert-box[data-req-timeout]').each(function() {
        var alert_timeout = parseInt($(this).data('req-timeout'));
        $(this).delay(alert_timeout).fadeOut(function () {
            $(this).remove();
        });
    });
    /**
     * Add a wrapper to all the videos with an iframe embed
     */
    $('iframe[src*="vimeo.com"]').wrap('<div class="flex-video vimeo widescreen" />');
    $('iframe[src*="youtube.com"]').wrap('<div class="flex-video widescreen" />');
}(jQuery));