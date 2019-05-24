<div class="idx-meta-box">
	<div class="idx-field-section">
			<label for="<?php echo $label_hide_top_section; ?>"><?php echo __("Hide Top section ?", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
			<input name="<?php echo $label_hide_top_section; ?>" id="<?php echo $label_hide_top_section; ?>" type="checkbox" value="1" <?php if($post_hide_top_section) echo 'checked="checked"'; ?>>
	</div>
	
	<div class="idx-field-section">
			<label for="<?php echo $label_address; ?>"><?php echo __("Default view", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
			<select name="<?php echo $label_default_view; ?>">
				<option <?php if($post_default_view=='photo') echo "selected"; ?> value="photo"><?php echo __("Photo", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
				<option <?php if($post_default_view=='map') echo "selected"; ?> value="map"><?php echo __("Map", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
			</select>
	</div>

	<div class="idx-field-section">
			<label for="<?php echo $label_neigbordhood_map; ?>"><?php echo __("Neigbordhood Map", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
			<select name="<?php echo $label_neigbordhood_map; ?>">
				<option <?php if($post_neigbordhood_map=='only_neigboardhood') echo "selected"; ?> value="only_neigboardhood"><?php echo __("Show Only neigbordhood", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
				<option <?php if($post_neigbordhood_map=='only_communities') echo "selected"; ?>  value="only_communities"><?php echo __("Show only its communities", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
			</select>
	</div>
</div>
<style type="text/css">
.idx-field-section select {
    width: 100%;
}
.idx-field-section label {
    font-weight: bold;
}
.idx-field-section {
    width: 100%;
    margin-bottom: 15px;
}	
</style>