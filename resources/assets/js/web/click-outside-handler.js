$(document).click(function(event) {
  if(!$(event.target).is('.cart-white-mobile > img') && !$(event.target).is('.cart-white-mobile > span')){
    $('.cart-inside-mobile').css('visibility', 'hidden');
  }

  if(!$(event.target).is('.bipolar-shopping-cart-content > img') && !$(event.target).is('.bipolar-shopping-cart-content > span')){
    $('.cart-inside').css('visibility', 'hidden');
  }

  if(!$(event.target).is('.text-heading-account') && !$(event.target).is('.text-heading-account > i') && !$(event.target).is('.navbar-right-text') && !$(event.target).is('.navbar-right-text > i')){
    $('.bipolar-dropdown-menu').css('display', 'none');
  }
});