<div class="idx-ng-wrap">
  <div id="neighborhood-shortcode" class="idx-wrap-grid idx-sp-view">
    <?php
      foreach($list_pages_neighboardhood as $item_neigh){
      $post_thumbnail_id = get_post_thumbnail_id($item_neigh['ID']);
      $post_thumbnail_url = wp_get_attachment_url($post_thumbnail_id);                                                   
      $attachment_title = get_the_title($post_thumbnail_id);
      $image_map_kml_url='';

      if (!empty($item_neigh['geometry'])) {
          parse_str($item_neigh['geometry'], $geometry);   
          $image_map_kml_url=idxboost_convert_image_map($geometry);
      }

      if (empty($post_thumbnail_url)) 
        $post_thumbnail_url='//idxboost.com/i/default_thumbnail.jpg';
    ?>
    <div class="idx-wrap-item-grid">
      <div class="idx-item-grid">
        <div class="idx-item-grid-img">
          <img data-lazy="<?php echo $post_thumbnail_url; ?>" class="img-slider gs-lazy idx-sp-img">
          <img data-blazy="<?php echo $image_map_kml_url; ?>" class="idx-item-grid-map">
        </div>
        <div class="idx-btn-content">
          <h3 class="idx-item-title idx-item-act">
            <a href="<?php echo $item_neigh['link_neighboardhood']; ?>"><?php echo $item_neigh['post_title']; ?></a>
          </h3>
          <button class="idx-btn-map idx-item-act">
            <span class="text-btn">View map</span>
            <span class="text-btn-close">Close map</span>
          </button>
        </div>
        <a href="<?php echo $item_neigh['link_neighboardhood']; ?>" class="idx-item-link">View detail</a>
      </div>
    </div>
    <?php } ?>
  </div>
  <div class="idx-wrap-action" id="idx-mp-item">
    <h3>Featured Neighborhoods</h3>
    <p>The most sought areas in miami</p>
    <a href="<?php echo $atts['link']; ?>">view neighborhoods</a>
  </div>
</div>
<script type="text/javascript">
  jQuery(document).on('click', '.idx-wrap-grid .idx-btn-map', function() {
    var imgMap = jQuery(this).parents('.idx-item-grid').find('.idx-item-grid-map').attr('data-blazy');
    jQuery(this).parents('.idx-item-grid').find('.idx-item-grid-map').attr('src',imgMap).removeAttr('data-blazy');
    jQuery(this).parents('.idx-wrap-item-grid').toggleClass("active-map");
  });
</script>