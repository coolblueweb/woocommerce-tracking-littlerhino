// tracking.js
jQuery(document).ready(function($) {
    // On click.
    $('.trackinginfo-past-header').on('click', function() {
        // Toggle arrow.
        $('.trackinginfo-past-header i').toggleClass('down');
        $('.trackinginfo-past-header i').toggleClass('up');
        // Toggle history.
        $('div#trackinginfo-history').toggleClass('active');
    });
});
