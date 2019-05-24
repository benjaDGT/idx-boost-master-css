<?php if ( $result_neigthboard ) : ?>
	<?php if($map):  if (file_exists(NEIGHBORHOOD_IDX_PATH.'/images/default.jpg'))  $url_thumbdefault = NEIGHBORHOOD_IDX_URI.'/images/default.jpg'; else $url_thumbdefault = '//idxboost.com/i/default_thumbnail.jpg'; ?>
		<div id="wrap-neighborhood-collection">
			<!-- INICIO PROPIEDADES -->
			<div class="wrap-neighborhood-section">
				<h1 id="wrap-neighborhood-title"><?php echo $atts['title']; ?></h1>
				<div class="ib-neighborhood-select">
					<select class="ib-nlist_neighborhoods ib_neig_action_mobile" name="neighborhoodselect">
						<option value="">Select Area</option>
						<?php foreach ($result_neigthboard as $value_neigh) { 
							$url = $value_neigh['link_item'];
							?>
							<option value="<?php echo $url; ?>"><?php echo $value_neigh['post_title']; ?></option>
						<?php } ?>
					</select>
				</div>
				<ul class="wrap-neighborhood-list">
					<?php 
						foreach ($result_neigthboard as $value_neigh) {
						$post_thumbnail_id = get_post_thumbnail_id($value_neigh['ID']);
						$post_thumbnail_url = wp_get_attachment_url($post_thumbnail_id);			
						//if (empty($post_thumbnail_url)) $post_thumbnail_url='//idxboost.com/i/default_thumbnail.jpg';
						if (empty($post_thumbnail_url)) $post_thumbnail_url = $url_thumbdefault;	
						$url = $value_neigh['link_item'];
						?>	

						<li class="wrap-neighborhood-item">
							<div class="wrap-neighborhood-description">
								<div class="wrap-neighborhood-image">
									<img src="/" data-blazy="<?php echo $post_thumbnail_url; ?>" alt="<?php echo $value_neigh['post_title']; ?>" class="blazy">
								</div>
								<h2><?php echo $value_neigh['post_title']; ?></h2>
								<a href="<?php echo $url; ?>" class="wrap-neighborhood-layout"><?php echo $value_neigh['post_title']; ?></a>
							</div>
						</li>
					<?php } wp_reset_postdata(); ?>
				</ul>
			</div>
			<!-- FINAL PROPIEDADES -->
			<!-- INICIO MAPA -->
			<div id="wrap-map">
				<div id="code-map"></div>
			</div>
			<!-- FINAL MAPA -->
		</div>
	<?php endif; ?>
<?php endif; ?>



<script type="text/javascript">
(function($) {
 $('.ib_neig_action_mobile').change(function(){
 	window.location.href=$(this).val();
 });
	/*Variables generales*/
  var $cuerpo = $('body');
  var $ventana = $(window);
  var $document = $(document);

  /*Consultando si nos encontramos en explorer*/
	var userAgent, ieReg, ie;
	userAgent = window.navigator.userAgent;
	ieReg = /msie|Trident.*rv[ :]*11\./gi;
	ie = ieReg.test(userAgent);

  /*Carga por demanda*/
  var ultimoScroll = 0;
  $(window).on("load scroll", function(){
    var $actualScroll = $(window).scrollTop();
    var $loadImage = $('.wrap-neighborhood-image');

		var a = $(window).scrollTop() + $(window).height();
		var b = $loadImage.offset().top +  (($(window).height()) / 100);
		console.log('a='+a+' / b='+b+' /actualScroll='+$actualScroll);

    if ($actualScroll >= ultimoScroll) {
      if ($loadImage.length) {
        if (($(window).scrollTop() + $(window).height()) >= ($loadImage.offset().top +  (($(window).height()) / 100))) {
          if (!$loadImage.hasClass('loaded')) {
            $loadImage.addClass('loaded');
            loadItemSlider($loadImage);
          }
        }
      }
    } 
    ultimoScroll = $actualScroll;
  });

	function loadItemSlider(theItem) {
		var $theBlazy = theItem.find('.blazy');
		var nTheImg = $theBlazy.length;
		if (nTheImg) {
		  if (nTheImg == 1) { // Cuando solo hay un blazy que cargar
		    var $dataBlazy = $theBlazy.attr('data-blazy');
		    if ($dataBlazy !== undefined) {
		      theItem.addClass('loading');
		      if ($theBlazy.is('img')) { // Caso 1: // Cuando es una imagen 
		        
		        /* Si estamos en explorer */
						if(ie) {
							theItem.css("backgroundImage", 'url(' + $theBlazy.attr('data-blazy') + ')').removeClass('loading').addClass("cm-background-img");
							$theBlazy.remove();
						}else{
							$theBlazy.attr('src', $theBlazy.attr('data-blazy')).removeAttr('data-blazy');
			        $theBlazy.on('load', function(){
			          theItem.removeClass('loading');
			          $theBlazy.removeClass('blazy');
			        });
						}

		      } else if ($theBlazy.is('video')){ // Caso 2: // Cuando es un video
		        console.log('es un video.')
		      } else {
		        if ($dataBlazy.indexOf(',') == -1) { // cuando es solo un background
		          $theBlazy.css('background-image', 'url(' + $dataBlazy + ')');
		          $theBlazy.removeClass('blazy');
		        } else { // cuando es backrground multiple
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
		        if ($theBlazy.is('img')) { // Caso 1: // Cuando es una imagen 
		          
		          /* Si estamos en explorer */
							if(ie) {
								$theBlazy.parent().css("backgroundImage", 'url(' + $dataBlazy + ')').removeClass('loading').addClass("cm-background-img");
								$theBlazy.remove();
							}else{
								if(!theItem.hasClass('loading')) theItem.addClass('loading');
			          $theBlazy.attr('src', $theBlazy.attr('data-blazy')).removeAttr('data-blazy');
			          $theBlazy.on('load', function(){
			            theItem.removeClass('loading');
			            $theBlazy.removeClass('blazy');
			          });
			        }

		        } else if ($theBlazy.is('video')){ // Caso 2: // Cuando es un video
		          console.log('es un video.')
		        } else {
		          if ($dataBlazy.indexOf(',') == -1) { // cuando es solo un background
		            $theBlazy.css('background-image', 'url(' + $dataBlazy + ')');
		            $theBlazy.removeClass('blazy');
		          } else { // cuando es backrground multiple
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
})(jQuery); 
</script>