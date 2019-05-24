<div class="idx-meta-box">
	<div class="idx-field">
			<label for="<?php echo $label_url; ?>"><?php echo __("BUILDING PAGE URL", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
			<input name="<?php echo $label_url; ?>" id="<?php echo $label_url; ?>" placeholder="http://" type="text" value="<?php echo esc_url($neighborhood_url); ?>" >
			<!-- <p id="neighborhood_link-description" class="description">Select Color</p> -->
	</div>
	<div class="idx-field">
			<label for="<?php echo $label_special; ?>"><?php echo __("Is Featured", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
			<input name="<?php echo $label_special; ?>" id="<?php echo $label_special; ?>" type="checkbox" value="1" <?php if($neighborhood_special) echo 'checked="checked"'; ?>>
	</div>
	<hr>
	<div class="idx-field">
			<label for="<?php echo $label_address; ?>"><?php echo __("Address", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
			<input name="<?php echo $label_address; ?>" id="<?php echo $label_address; ?>" type="text" value="<?php echo esc_attr($neighborhood_address); ?>" >
			<a id="<?php echo $label_address; ?>-description" class="description" href="#"><?php echo __("Update geocode", IDXBOOST_DOMAIN_THEME_LANG); ?></a>
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

	<div class="idx-field">
			<label for="<?php echo $label_unit; ?>"><?php echo __("Units", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
			<input name="<?php echo $label_unit; ?>" id="<?php echo $label_unit; ?>" type="text" value="<?php echo esc_attr($units_postmeta); ?>" >
	</div>

	<div class="idx-field">
			<label for="<?php echo $label_floor; ?>"><?php echo __("Floors", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
			<input name="<?php echo $label_floor; ?>" id="<?php echo $label_floor; ?>" type="text" value="<?php echo esc_attr($floor_postmeta); ?>" >
	</div>
	
	<div class="idx-field">
			<label for="<?php echo $label_idxboost_building; ?>">IDX BOOST SHORTCODE</label>
			<input name="<?php echo $label_idxboost_building; ?>" id="<?php echo $label_idxboost_building; ?>" type="text" value="<?php echo esc_attr($idxboost_building_postmeta); ?>" >
	</div>

	
	<div class="idx-field" style="display:none;">
			<label for="<?php echo $label_tgbuilding_id; ?>"><?php echo __("TG ID", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
			<input name="<?php echo $label_tgbuilding_id; ?>" id="<?php echo $label_tgbuilding_id; ?>" type="text" value="<?php echo esc_attr($tgbuilding_id_postmeta); ?>" >
	</div>

	<hr>
	<div class="idx-field">
			<label for="<?php echo $label_address; ?>"><?php echo __("Neighborhood", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
			<select name="<?php echo $label_tgid_neighnorhood; ?>" id="<?php echo $label_tgid_neighnorhood; ?>">
				<option value="0" ><?php echo __("Select Neighborhood", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
				<?php 				
				foreach ($list_pages_neighborhood as $value_neigth) { ?>
					<option value="<?php echo $value_neigth['ID'];?>" <?php if ($tgid_neighnorhood===$value_neigth['ID']) echo "selected";	?> ><?php echo $value_neigth['post_title'];?></option>
				<?php }
				?>
			</select>
	</div>	

	<hr>
	<div class="idx-field">
			<label for="<?php echo $label_tgid_community; ?>"><?php echo __("Community", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
			<select name="<?php echo $label_tgid_community; ?>" id="<?php echo $label_tgid_community; ?>">
				<option value="0" ><?php echo __("Select Community", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
				<?php 
				foreach ($list_pages_community as $value_community) { ?>
					<option value="<?php echo $value_community['ID'];?>" <?php if ($tgid_community ==$value_community['ID']) echo "selected";	?> ><?php echo $value_community['post_title'];?></option>
				<?php }
				?>
			</select>
	</div>	 

	<hr>
	<div class="idx-field">
			<label for="<?php echo $label_year_building; ?>"><?php echo __("Year Building", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
			<input name="<?php echo $label_year_building; ?>" id="<?php echo $label_year_building; ?>" type="text" value="<?php echo esc_attr($year_building_postmeta); ?>" >
	</div>	
	<input name="<?php echo $label_kml; ?>" id="<?php echo $label_kml; ?>" type="hidden" value="<?php echo $kml_building; ?>" >	
</div>
<?php
?>