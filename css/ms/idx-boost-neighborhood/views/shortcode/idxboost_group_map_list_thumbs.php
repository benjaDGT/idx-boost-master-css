<?php
 if (count($result_neigthboard)>0) { ?>
<section class="mg-neighborhoods <?php if($atts['view_mobile']=='expand') { echo 'ib-view-map-mobile'; } ?>">
  <div class="mg-npa" id="wrap-map">
    <div id="code-map-neighboardhood"></div>

    <?php  if ($atts['view_mobile']=='expand') { ?>
      <div class="ib-neighborhoods-navs">
            <div class="ib-newselect">
              <select class="ib-neselect idx_item_neigh_mobile">
                <option value="0">Select All Neighborhood</option>
                <?php  foreach($result_neigthboard as $item_neigh){ ?>
                  <option value="<?php echo $item_neigh['ID']; ?>"><?php echo $item_neigh['post_title']; ?></option>
                <?php } ?>                
                </select>
            </div>

            <div class="ib-nebtns">
              <a href="<?php echo $atts['link_collection']; ?>" title="View Neighborhoods" class="ib-neblink">View Neighborhoods</a>
              <a href="#" class="ib-neblink idx_link_detailt_neig">View Detail</a>
            </div>

          </div>
    <?php } ?>

  </div>

  <div class="mg-npb">
    <div class="mg-nheader">
      <h2 class="mg-nhtitle"><?php echo $atts['title']; ?></h2>
      <?php if (!empty($atts['sub_title'])) { ?>
        <span class="mg-nsubtitle"><?php echo $atts['sub_title']; ?></span>
      <?php } ?>
      <a class="mg-nexplore" href="<?php echo $atts['link_collection']; ?>" title="Explore">Explore</a>
    </div>
    <div class="mg-sliderneighborhoods gs-container-slider">
      <?php 
      foreach($result_neigthboard as $item_neigh){
            $post_thumbnail_id = get_post_thumbnail_id($item_neigh['ID']);
            $post_thumbnail_url = wp_get_attachment_url($post_thumbnail_id);                                                   
            $attachment_title = get_the_title($post_thumbnail_id);

            if (empty($post_thumbnail_url)) 
              $post_thumbnail_url='//idxboost.com/i/default_thumbnail.jpg';

      ?>
          <a class="mg-nsitem" href="<?php echo $item_neigh['link_item']; ?>" title="<?php echo $item_neigh['post_title']; ?>">
              <h3 class="mg-nsititle"><?php echo $item_neigh['post_title']; ?></h3>
              <img class="mg-nsimg gs-lazy" data-lazy="<?php echo $post_thumbnail_url; ?>" alt="<?php echo $item_neigh['post_title']; ?>"></a>
        <?php } ?>
      </div>
  </div>
</section>
<style type="text/css">
  #code-map-neighboardhood{
    height: 100%;
  }
</style>
 
<?php } ?>
