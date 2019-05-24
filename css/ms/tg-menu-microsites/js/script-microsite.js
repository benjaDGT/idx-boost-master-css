(function( $ ) {
	
		setTimeout(function(){ 

			var $maintest= jQuery(".carousel_tg_neighborhood");
			if($maintest.length) {
					console.log(" exite")
			    $maintest.greatSlider({
			      type: 'swipe',
			      nav: true,
			      lazyLoad: true,
			      bullets: true,
			      autoDestroy: true,
			      items: 1,
			      breakPoints: {
			        640: {
			          items: 2,
			        },
			        960: {
			          items: 3,
			        },
			        1366: {
			          items: 5
			        },
			        1450: {
			          items: 7
			        },
			      },
			      layout: {
			        bulletDefaultStyles: false,
			        wrapperBulletsClass: 'clidxboost-gs-wrapper-bullets'
			      }
			    });
			}else{
				console.log("no exite")
			}
		}, 100);
})(jQuery);