
(function($) { "use strict";

    /* DOCUMENT READY */
    $(function() {

        // HEADER MENU TOGGLE
        $('.menu-toggle').click(function(e) {
            e.stopPropagation();
            $('html').toggleClass('is-menu-toggled-on');
            $('html').removeClass('is-search-toggled-on');
            $('html').removeClass('is-social-toggled-on');
        });

        // close on anywhere click
        $(document).click (function (e) {
            $('html').removeClass('is-search-toggled-on');
            $('html').removeClass('is-social-toggled-on');
            $('html').removeClass('is-menu-toggled-on');
        });
        // ------------------------------
     });
})(jQuery);
