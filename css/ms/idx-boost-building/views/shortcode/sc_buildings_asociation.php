<?php 
if (!empty($list_pages_buildings) && is_array($list_pages_buildings) && count($list_pages_buildings)>0 ) {  ?>
        <div class="content-nav">
          <div class="similar-properties">
            <h2 class="title-similar-list"><?php echo __("Buildings", IDXBOOST_DOMAIN_THEME_LANG); ?></h2>
            <ul>
              <?php foreach($list_pages_buildings as $item){  
                  $permalink_communities = get_post_meta( $item['ID'], 'tgbuilding_url', true ); 
                  $address_buildings = get_post_meta( $item['ID'], 'dgt_extra_address', true ); 
                  
                  //if (empty($post_thumbnail_url)) { $post_thumbnail_url = '//idxboost.com/i/default_thumbnail.jpg'; }
                  if (empty($post_thumbnail_url)) { if (file_exists(BUILDINGS_IDX_PATH.'/images/default.jpg'))  $post_thumbnail_url = BUILDINGS_IDX_URI.'/images/default.jpg'; else $post_thumbnail_url = '//idxboost.com/i/default_thumbnail.jpg'; }

                    $buildings_gallery_postmeta = $wpdb->get_results("SELECT {$wpdb->postmeta}.meta_value as path_image FROM {$wpdb->postmeta} WHERE {$wpdb->postmeta}.post_id='".$item['ID']."' and {$wpdb->postmeta}.meta_key='dgt_tg_gallery'  limit 1;", ARRAY_A);

                    if (!is_array($buildings_gallery_postmeta) || count($buildings_gallery_postmeta)==0) {
                      $buildings_gallery_postmeta = $wpdb->get_results("SELECT {$wpdb->posts}.guid as path_image,{$wpdb->posts}.post_title FROM {$wpdb->postmeta} INNER JOIN {$wpdb->posts} on {$wpdb->posts}.ID={$wpdb->postmeta}.meta_value WHERE {$wpdb->postmeta}.post_id='".$item['ID']."' and {$wpdb->postmeta}.meta_key='dgt_extra_gallery' limit 1;", ARRAY_A);
                    }


                  foreach ($buildings_gallery_postmeta as $value_gallery) {
                    $post_thumbnail_url=$value_gallery['path_image'];
                  }        

                  if (empty($post_thumbnail_url)) { if (file_exists(BUILDINGS_IDX_PATH.'/images/default.jpg'))  $post_thumbnail_url = BUILDINGS_IDX_URI.'/images/default.jpg'; else $post_thumbnail_url = '//idxboost.com/i/default_thumbnail.jpg'; }
                  if (empty($permalink_communities))  $permalink_communities='#'; ?>
                  
                  <li>
                  <article>
                    <h2> <a href="<?php echo $permalink_communities; ?>" title="<?php echo $item['post_title']; ?>"><?php echo $item['post_title']; ?></a></h2>
                    <ul>
                      <li class="price"><?php echo $address_buildings; ?></li>
                    </ul>
                    <a href="<?php echo $permalink_communities; ?>" title="<?php echo $item['post_title']; ?>" class="layout-img">
                      <img title="<?php echo $item['post_title']; ?>" alt="<?php echo $item['post_title']; ?>" class="lazy-img active" src="<?php echo $post_thumbnail_url; ?>">
                    </a>
                      <a href="<?php echo $permalink_communities; ?>" title="<?php echo $item['post_title']; ?>" class="full-link"><?php echo $item['post_title']; ?></a>
                  </article>
                  </li>
                  
                <?php } ?>

            </ul>

            <?php
            $name_neighboarhood='';
            if (array_key_exists('neighboarhood_data', $GLOBALS) && is_array($GLOBALS['neighboarhood_data']) ) {
              $name_neighboarhood='/luxury-condos/?area='.urlencode($GLOBALS['neighboarhood_data']['name']);
            }
            ?>

            <a href="<?php echo $name_neighboarhood; ?>" title="view more properties" rel="nofollow" class="show-more"><?php echo __("View More Buildings", IDXBOOST_DOMAIN_THEME_LANG); ?></a>
          </div>
        </div>
<?php } ?>