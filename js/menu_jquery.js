$( document ).ready(function() {
    $('.cssmenu > #I > li > a').click(function() {
      $('#I li').removeClass('active');
      $(this).closest('li').addClass('active'); 
      var checkElement = $(this).next();
      if((checkElement.is('ul')) && (checkElement.is(':visible'))) {
        $(this).closest('li').removeClass('active');
        checkElement.slideUp('normal');
      }
      if((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
        $('.cssmenu ul #I:visible').slideUp('normal');
        checkElement.slideDown('normal');
      }
      if($(this).closest('li').find('ul').children().length == 0) {
        return true;
      } else {
        return false; 
      }   
    });
    $('.cssmenu > #C > li > a').click(function() {
      $('#C li').removeClass('active');
      $(this).closest('li').addClass('active'); 
      var checkElement = $(this).next();
      if((checkElement.is('ul')) && (checkElement.is(':visible'))) {
        $(this).closest('li').removeClass('active');
        checkElement.slideUp('normal');
      }
      if((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
        $('.cssmenu ul #C:visible').slideUp('normal');
        checkElement.slideDown('normal');
      }
      if($(this).closest('li').find('ul').children().length == 0) {
        return true;
      } else {
        return false; 
      }   
    });

    // $('#inputBusquedaI').on('focus',function(){
    //   $('.cssmenu > #I > li > a').click();
    // });
    // $('#inputBusquedaC').on('focus',function(){
    //   $('.cssmenu > #C > li > a').click();
    // });
});