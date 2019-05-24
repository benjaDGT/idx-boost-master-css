<?php
 if (count($result_neigthboard)>0) { ?>
<section class="mg-neighborhoods ib-view-list">
  <div class="mg-npa" id="wrap-map">
    <div id="code-map"></div>
  </div>
  <div class="mg-npb">
    <div class="mg-nheader-list">
      <h2 class="mg-nhtitle">NEIGHBORHOOD GUIDE</h2>
      <span class="mg-nsubtitle">Featured Luxury Communities</span>
    </div>
    <div class="mg-sliderneighborhoods gs-container-slider" data-gs='{"bullets":true,"nav":false}'>
      <?php 
        foreach($result_neigthboard as $item_neigh){
          $post_thumbnail_id = get_post_thumbnail_id($item_neigh['ID']);
          $post_thumbnail_url = wp_get_attachment_url($post_thumbnail_id);                                                   
          $attachment_title = get_the_title($post_thumbnail_id);
        ?>
        <a class="mg-nsitem" href="<?php echo $item_neigh['link_item']; ?>" title="<?php echo $item_neigh['post_title']; ?>">
          <h3 class="mg-nsititle"><?php echo $item_neigh['post_title']; ?></h3>
        </a>
      <?php } ?>
    </div>
    <a class="mg-nexplore" href="<?php echo get_home_url(); ?>/neighborhoods/" title="Explore">Explore All Neighborhoods</a>
  </div>
</section>
<?php } ?>