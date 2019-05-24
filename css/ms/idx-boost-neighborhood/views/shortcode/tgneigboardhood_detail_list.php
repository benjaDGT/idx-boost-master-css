<?php if ( $result_neigthboard ) : ?>
        <ul class="reset AreaMap">
            <li class="item">
                <div id="wrap-map">
                    <div id="code-map"></div>
                </div>
            </li>
            <li class="item ConteText">
                <div class="AreaInfo">
                    <h2 class="fontd"> </h2>
                    <p>
                        
                    </p>
                    <ul class="reset list_items">
                        <?php

                        if (file_exists(NEIGHBORHOOD_IDX_PATH.'/images/default.jpg'))  $url_thumbdefault = NEIGHBORHOOD_IDX_URI.'/images/default.jpg'; else $url_thumbdefault = '//idxboost.com/i/default_thumbnail.jpg';
                        
                        foreach ($result_neigthboard as $value_neigh) {
                            $post_thumbnail_id = get_post_thumbnail_id($value_neigh['ID']);
                            $post_thumbnail_url = wp_get_attachment_url($post_thumbnail_id);
                            if (empty($post_thumbnail_url)) $post_thumbnail_url = $url_thumbdefault;
                            $url = $value_neigh['link_item'];
                            ?>
                            <li >
                                <a href="<?php echo $url; ?>"><?php echo $value_neigh['post_title']; ?></a>
                            </li>
                        <?php } wp_reset_postdata(); ?>
                    </ul>
                    <a href="#" class="readmore"><i class="iconArrow"></i><span></span></a>
                </div>
            </li>
        </ul>
<?php endif; ?>