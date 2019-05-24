(function($) {

  $(document).on('click', '.idx-box-item .idx-active', function() {
    $(this).parent().find('.idx-table-body').toggleClass('active-list');
  });

  $(document).on('click', '.idx-icon-grid', function() {
  	$(".idx-btn-action button").removeClass("active");
  	$(this).addClass("active");
    $(".idx-list-n-condo").removeClass("view-list").addClass("view-grid");
    eventchange='view_change';
    search_condos();
  });
  
  $(document).on('click', '.idx-icon-list', function() {
  	$(".idx-btn-action button").removeClass("active");
  	$(this).addClass("active");
    $(".idx-list-n-condo").removeClass("view-grid").addClass("view-list");
    eventchange='view_change';
    search_condos();
  });

  /*Variables generales*/
  var $cuerpo = $('body');
  var $ventana = $(window);
  var $widthVentana = $ventana.width();
  var $heightVentana = $ventana.height();
  var $htmlcuerpo = $('html, body');
  var $document = $(document);

  /*Consultando si nos encontramos en explorer*/
	var userAgent, ieReg, ie;
	userAgent = window.navigator.userAgent;
	ieReg = /msie|Trident.*rv[ :]*11\./gi;
	ie = ieReg.test(userAgent);

  /*----------------------------------------------------------------------------------*/
	/* Carga por demanda
	/*----------------------------------------------------------------------------------*/
  var ultimoScroll = 0;
  /*
  $(window).on('load scroll', function(){
    var $actualScroll = $(window).scrollTop();
    if ($actualScroll > ultimoScroll) {
      var $loadImage = $('.idx-wrap-img');
      if ($loadImage.length) {
        if (($(window).scrollTop() + $(window).height()) > ($loadImage.offset().top +  (($(window).height()) / 100))) {
          if (!$loadImage.hasClass('loaded')) {
            $loadImage.addClass('loaded');
            loadItemSlider($loadImage);
          }
        }
      }
    } 
    ultimoScroll = $actualScroll;
  });
  */
/*
  function loadItemSlider(theItem) {
		var $theBlazy = theItem.find('.blazy');
		var nTheImg = $theBlazy.length;
		if (nTheImg) {
		  if (nTheImg == 1) {
		    var $dataBlazy = $theBlazy.attr('data-blazy');
		    if ($dataBlazy !== undefined) {
		      theItem.addClass('op-loading');
		      if ($theBlazy.is('img')) {
						if(ie) {
							theItem.css("backgroundImage", 'url(' + $theBlazy.attr('data-blazy') + ')').removeClass('op-loading').addClass("idx-wrap-img");
							$theBlazy.remove();
						}else{
							$theBlazy.attr('src', $theBlazy.attr('data-blazy')).removeAttr('data-blazy');
			        $theBlazy.on('load', function(){
			          theItem.removeClass('op-loading');
			          $theBlazy.removeClass('blazy');
			        });
						}
		      } else if ($theBlazy.is('video')){
		        console.log('es un video.')
		      } else {
		        if ($dataBlazy.indexOf(',') == -1) {
		          $theBlazy.css('background-image', 'url(' + $dataBlazy + ')');
		          $theBlazy.removeClass('blazy');
		        } else {
		          var listBackgrounds = $dataBlazy.split(',');
		          console.log(listBackgrounds);
		          var theBgs = [];
		          $.each(listBackgrounds, function(){
		            theBgs.push('url(' + $(this) + ')');
		          });
		          $theBlazy.css({
		            'background-image' : theBgs.join(',')
		          });
		          $theBlazy.removeClass('blazy');
		        }
		      }
		      $theBlazy.removeAttr('data-blazy');
		    }
		  } else {
		    $theBlazy.each(function(){
		      var $theBlazy = $(this);
		      var $dataBlazy = $theBlazy.attr('data-blazy');
		      if ($dataBlazy !== undefined) {
		        if ($theBlazy.is('img')) {  
		          
							if(ie) {
								$theBlazy.parent().css("backgroundImage", 'url(' + $dataBlazy + ')').removeClass('op-loading').addClass("idx-wrap-img");
								$theBlazy.remove();
							}else{
								if(!theItem.hasClass('op-loading')) theItem.addClass('op-loading');
			          $theBlazy.attr('src', $theBlazy.attr('data-blazy')).removeAttr('data-blazy');
			          $theBlazy.on('load', function(){
			            theItem.removeClass('op-loading');
			            $theBlazy.removeClass('blazy');
			          });
			        }

		        } else if ($theBlazy.is('video')){
		          console.log('es un video.')
		        } else {
		          if ($dataBlazy.indexOf(',') == -1) {
		            $theBlazy.css('background-image', 'url(' + $dataBlazy + ')');
		            $theBlazy.removeClass('blazy');
		          } else {
		            var listBackgrounds = $dataBlazy.split(',');
		            var theBgs = [];
		            listBackgrounds.forEach(function(entry) {
		              theBgs.push('url(' + entry + ')');
		            });
		            $theBlazy.css({
		              'background-image' : theBgs.join(',')
		            });
		            $theBlazy.removeClass('blazy');
		          }
		        }
		        $theBlazy.removeAttr('data-blazy');
		      }
		    });
		  }
		}
	}
*/
}(jQuery));