(function($) {
    Drupal.behaviors.ofenResearcher = {
        attach: function (context, settings) {
            console.log(settings);
            var mainHeight = $('.l-main').height();
            $('.l-region--sidebar').once('adjustHeight').css('height', mainHeight);
        }
    };
})(jQuery);