(function($) {
  if ($("body").hasClass("home")) {
    $('.navbar').addClass('navbar-ondark');

    $(window).scroll(function () {
        if ($(window).scrollTop() > 80) {
            $('.navbar').removeClass('navbar-ondark');
        } else {
            $('.navbar').addClass('navbar-ondark');
        }
    });
  }
})(jQuery);
