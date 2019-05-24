<?php  

if(count($list_pages_buildings)>0){ ?>

<div class="gs-container-slider general-slider clidxboost-development">
  <?php  foreach ($list_pages_buildings as $value) {
    $post_thumbnail_url='';$post_thumbnail_id='';
    $post_thumbnail_id = get_post_thumbnail_id($value['ID']);
    $post_thumbnail_url = wp_get_attachment_url($post_thumbnail_id);
    
    if (empty($post_thumbnail_url)){
        $buildings_gallery_postmeta = $wpdb->get_results("SELECT {$wpdb->posts}.guid,{$wpdb->posts}.post_title FROM {$wpdb->postmeta} INNER JOIN {$wpdb->posts} on {$wpdb->posts}.ID={$wpdb->postmeta}.meta_value WHERE {$wpdb->postmeta}.post_id='".$value['ID']."' and {$wpdb->postmeta}.meta_key='dgt_extra_gallery' limit 1;", ARRAY_A);
        
        foreach ($buildings_gallery_postmeta as $value_gallery) {
          $post_thumbnail_url=$value_gallery['guid'];
        }   
        if (empty($post_thumbnail_url)) { $post_thumbnail_url = 'http://idxb031.staging.wpengine.com/wp-content/themes/millenniumib/images/coming-soon_02.jpg'; }
    } ?>
  <a href="<?php echo $value['link_building']; ?>" class="general-item-ls">
    <div class="figure-general-ls">
      <img class="img-slider gs-lazy" data-lazy="<?php echo $post_thumbnail_url; ?>"">
    </div>
    <h3 class="gs-item-title"><?php echo $value['post_title']; ?></h3>
  </a>
  <?php } ?>
</div>
<?php } ?>