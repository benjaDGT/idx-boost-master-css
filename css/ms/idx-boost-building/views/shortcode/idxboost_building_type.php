<section class="BuildingArea" id="cm-featured">
            <h2><?php echo $atts['title']; ?></h2>
            <ul class="BuildingList">
                <?php 
                foreach ($list_pages_buildings as $value) {
                    $post_thumbnail_url='';$post_thumbnail_id='';
                    $post_thumbnail_id = get_post_thumbnail_id($value['ID']);
                    $post_thumbnail_url = wp_get_attachment_url($post_thumbnail_id);
                    
                    if (empty($post_thumbnail_url)){
                        $buildings_gallery_postmeta = $wpdb->get_results("SELECT {$wpdb->posts}.guid,{$wpdb->posts}.post_title FROM {$wpdb->postmeta} INNER JOIN {$wpdb->posts} on {$wpdb->posts}.ID={$wpdb->postmeta}.meta_value WHERE {$wpdb->postmeta}.post_id='".$value['ID']."' and {$wpdb->postmeta}.meta_key='dgt_extra_gallery' limit 1;", ARRAY_A);
                        
                        foreach ($buildings_gallery_postmeta as $value_gallery) {
                          $post_thumbnail_url=$value_gallery['guid'];
                        }   
                        //if (empty($post_thumbnail_url)) { $post_thumbnail_url = '//idxboost.com/i/default_thumbnail.jpg'; }
                        if (empty($post_thumbnail_url)) { if (file_exists(BUILDINGS_IDX_PATH.'/images/default.jpg'))  $post_thumbnail_url = BUILDINGS_IDX_URI.'/images/default.jpg'; else $post_thumbnail_url = '//idxboost.com/i/default_thumbnail.jpg'; }
                    }
                    

                    ?>
                <li>
                    <a href="<?php echo $value['link_building']; ?>">
                        <div class="picArea cm-wrap-img">
                            <img data-blazy="<?php echo $post_thumbnail_url; ?>" class="blazy" src="" alt="<?php echo $value['post_title']; ?>">
                        </div>
                        <h3><?php echo $value['post_title']; ?></h3>
                    </a>
                </li>
                <?php } ?>
            </ul>
        </section>