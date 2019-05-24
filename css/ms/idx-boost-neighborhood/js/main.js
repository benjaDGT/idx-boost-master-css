// Sliders de neighrborhoods
function sliderNeighborhoods($slider){
	if ($(window).width() < 768) {
		if(!$slider.hasClass('gs-builded')) {
			console.log('lo construyo');
			theSlider = $slider.greatSlider({
				type: 'swipe',
				nav: true,
				bullets: false,
				layout: {
					arrowDefaultStyles: false
				}
			});
		} else {
			console.log('no construyo , ya ta construido');
		}
	} else {
		if ($slider.hasClass('gs-builded')) {
			theSlider.destroy();
		}
	}
}

let $sliderNeighborhoods = $('#lgr-neighborhoods-slider');
if($sliderNeighborhoods.length) {
	sliderNeighborhoods($sliderNeighborhoods);
	$(window).resize(()=>{
		sliderNeighborhoods($sliderNeighborhoods);
	});
}