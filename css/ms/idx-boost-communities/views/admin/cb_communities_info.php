<div class="idx-meta-box">

	<div class="idx-field">
			<label><?php echo __("TG Neighborhood", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
            <select name="tgpost_relacion_neighborhood" id="tgpost_relacion_neighborhood">
                <?php               
                foreach ($list_pages_neighborhood as $value_neigth) { ?>
                    <option value="<?php echo $value_neigth['ID'];?>" <?php if ($tgid_neighnorhood===$value_neigth['ID']) echo "selected";  ?> ><?php echo $value_neigth['post_title'];?></option>
                <?php }
                ?>
            </select>
	</div>

	<div class="idx-field">
			<label for="<?php echo $label_url; ?>"><?php echo __("Link URL", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
			<input name="<?php echo $label_url; ?>" id="<?php echo $label_url; ?>" placeholder="http://" type="text" value="<?php echo esc_url($neighborhood_url); ?>" >
			<!-- <p id="neighborhood_link-description" class="description">Select Color</p> -->
	</div>

	<div class="idx-field">
			<label><?php echo __("Show Neighborhood Parent Buildings?", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
			<input name="tg_show_building" type="checkbox" value="1" <?php if(!empty($tg_show_building)) {if ($tg_show_building==1) echo 'checked="checked"';  }else{ echo 'checked="checked"'; } ?> >
	</div>

	<div class="idx-field">
			<label for="<?php echo $label_special; ?>"><?php echo __("Is special?", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
			<input name="<?php echo $label_special; ?>" id="<?php echo $label_special; ?>" type="checkbox" value="1" <?php if($neighborhood_special) echo 'checked="checked"'; ?>>
	</div>
	<hr>
	<div class="idx-field">
			<label for="<?php echo $label_address; ?>"><?php echo __("Address", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
			<input name="<?php echo $label_address; ?>" id="<?php echo $label_address; ?>" type="text" value="<?php echo esc_attr($neighborhood_address); ?>" >
			<a id="<?php echo $label_address; ?>-description" class="description" href="#">Update geocode</a>
	</div>
	<hr>
	<div class="idx-field grid-50">
			<label for="<?php echo $label_lat; ?>"><?php echo __("Latitude", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
			<input name="<?php echo $label_lat; ?>" id="<?php echo $label_lat; ?>" type="number" value="<?php echo $neighborhood_lat; ?>" step="any">
	</div>
	<div class="idx-field grid-50">
			<label for="<?php echo $label_lng; ?>"><?php echo __("Longitude", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
			<input name="<?php echo $label_lng; ?>" id="<?php echo $label_lng; ?>" type="number" value="<?php echo $neighborhood_lng; ?>" step="any">
	</div>
	<hr>
	<div class="idx-field">
			<h3 class="<?php echo $label_geometry; ?>"><?php echo __("Map", IDXBOOST_DOMAIN_THEME_LANG); ?></h3>
			<div id="gmap"></div>
			<input name="<?php echo $label_geometry; ?>" id="<?php echo $label_geometry; ?>" type="hidden" value="<?php echo esc_attr( $geometry ); ?>" >
	</div>
</div>
<?php
?>
<!-- Add dgt map -->
<!--<a href="#" class="regetate-kml">OPTIMIZATION KML</a>-->
<script>
;(function($, window, undefined){
  $(document).ready(function(){
      tmp_params = {};
      tmp_params.shape_type=	'polygon';
      tmp_params.limit = 500;
      tmp_params.board = 2;
<?php if (!empty($map_params)){ ?>
    <?php if($map_params['lat'] > 0 ): ?>
      tmp_params.center_lat = '<?php echo $map_params['lat']; ?>';
      tmp_params.center_lng = '<?php echo $map_params['lng']; ?>';
      tmp_params.geom = '<?php echo $map_params['geometry']; ?>';
      gZoom = <?php echo $map_params['zoom']; ?>;
      $dgt.loadMap('<?php echo $map_params['lat']; ?>', '<?php echo $map_params['lng']; ?>');
      $dgt.addPolygon(<?php echo json_encode($polygonGeocode); ?>);
      $('#gmap_submit').click();
    <?php else: ?>
    	$dgt.loadMap(41.88067705065692,-87.64952217758787);
    <?php endif; ?>
    <?php }else{ ?>
    	$dgt.loadMap(41.88067705065692,-87.64952217758787);
    <?php } ?>
  });
})(jQuery, window);
</script>