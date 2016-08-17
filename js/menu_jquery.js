/*$( document ).ready(function() {
$('#cssmenu > ul > li > a').click(function() {
  $('#cssmenu li').removeClass('active');
  $(this).closest('li').addClass('active');	
  var checkElement = $(this).next();
  if((checkElement.is('ul')) && (checkElement.is(':visible'))) {
    $(this).closest('li').removeClass('active');
    checkElement.slideUp('normal');
  }
  if((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
    $('#cssmenu ul ul:visible').slideUp('normal');
    checkElement.slideDown('normal');
  }
  if($(this).closest('li').find('ul').children().length == 0) {
    return true;
  } else {
    return false;	
  }		
});
});*/



$(document).ready(function () {
    $('#cssmenu a').click(function () {
        //$('#cssmenu li').removeClass('active');
        var hasClass = $(this).closest('li').hasClass('active');
		if(hasClass){
			$(this).closest('li').removeClass('active');
		}else{
				$(this).closest('li').addClass('active');
		}
        var checkElement = $(this).next();
        if ((checkElement.is('ul')) && (checkElement.is(':visible'))) {
            console.log(checkElement);
            if (!$(checkElement).hasClass('innerLevel')) {
                $(this).closest('li').removeClass('active');
            }
            checkElement.slideUp('normal');
        }
        if ((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
            if (!$(checkElement).hasClass('innerLevel')) {
                $('#cssmenu ul ul:visible').slideUp('normal');
            }
            checkElement.slideDown('normal');
        }
        if ($(this).closest('li').find('ul').children().length == 0) {
            return true;
        } else {
            return false;
        }
    });
});