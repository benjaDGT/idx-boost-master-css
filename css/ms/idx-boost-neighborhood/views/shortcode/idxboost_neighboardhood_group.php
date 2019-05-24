<?php if (is_array($list_pages_neighboardhood)) { if (count($list_pages_neighboardhood)>0) { ?>
    <article class="lgr-neighborhoods">
      <div class="lgr-mw lgr-niblock">
        <div class="lgr-niacces">
          <div class="lgr-accwrapper">
            <h2 class="lgr-nhtitle">Neighborhoods</h2><span class="lgr-nhsubtitle">Explore our beautiful areas in South Florida</span><a class="lgr-niview" href="<?php echo $atts['link']; ?>" title="Explore Project">View Neighborhoods</a>
          </div>
        </div>
        <div class="lgr-ncslider" id="lgr-neighborhoods-slider">
        <?php 
          if (file_exists(NEIGHBORHOOD_IDX_PATH.'/images/default.jpg'))  $url_thumbdefault = NEIGHBORHOOD_IDX_URI.'/images/default.jpg'; else $url_thumbdefault = '//idxboost.com/i/default_thumbnail.jpg';

          foreach($list_pages_neighboardhood as $item_neigh){
          $post_thumbnail_id = get_post_thumbnail_id($item_neigh['ID']);
          $post_thumbnail_url = wp_get_attachment_url($post_thumbnail_id);

          if (empty($post_thumbnail_url)) 
            $post_thumbnail_url = $url_thumbdefault;

          echo '<div class="lgr-nitem"><a class="lgr-nilink" href="'.$item_neigh['link_neighboardhood'].'" title="'.$item_neigh['post_title'].'"><h3 class="lgr-nititle">'.$item_neigh['post_title'].'</h3><img class="lgr-niimg" src="'.$post_thumbnail_url.'" alt="'.$item_neigh['post_title'].'"></a></div>';
      }
      ?>
        </div>
      </div>
    </article>    
<?php } } ?>