<section class="nr-section">
          <h2 class="nr-title"><?php echo __('Related Articles', IDXBOOST_DOMAIN_THEME_LANG); ?></h2>
          <?php

           if (!empty($idx_noticias) && is_array($idx_noticias) ) { ?>
            <div class="nr-related-article-list">
              <?php foreach ($idx_noticias as $news) { 
                $post_thumbnail_id = get_post_thumbnail_id($news['ID']); 
                $post_thumbnail_url = wp_get_attachment_url($post_thumbnail_id,'medium'); 
                if (empty($post_thumbnail_url)) {
                  $post_thumbnail_url= get_template_directory_uri().'/images/coming-soon.png';
                }
                ?>
              <article class="nr-related-article">
                <h3 class="nr-article-title"><a href="#"><?php echo $news['post_title']; ?></a></h3>
                <a class="nr-wrap-img" href="<?php echo get_site_url().'/'.$news['post_name']; ?>">
                  <img src="<?php echo $post_thumbnail_url; ?>">
                </a>
              </article>
              <?php } ?>
            </div>
          <?php } ?>

          <div class="nr-wrap-btn">
            <a href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>?condos=<?php echo $atts['id_building']; ?>">
            <button class="nr-btn">
              <span><?php echo __('View MORE', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
            </button>
            </a>
          </div>
        </section>