(function($) {
  if ($("body").hasClass("home-index")) {
    $('.navbar').addClass('navbar-ondark');

    $(window).scroll(function () {
        if ($(window).scrollTop() > 80) {
            $('.navbar').removeClass('navbar-ondark');
        } else {
            $('.navbar').addClass('navbar-ondark');
        }
    });
  }

  $(".fitvids").fitVids();
})(jQuery);
