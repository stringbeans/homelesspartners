(function($) {
  var midHeight = jQuery(window).height() / 3 //Splits screen in half
  $(window).scroll(function () {
      if ($(window).scrollTop() > 80) {
          $('.navbar').addClass('navbar-default');
          $('.navbar').removeClass('navbar-ondark');
      } else {
          $('.navbar').removeClass('navbar-default');
          $('.navbar').addClass('navbar-ondark');
      }
  })
})(jQuery);
