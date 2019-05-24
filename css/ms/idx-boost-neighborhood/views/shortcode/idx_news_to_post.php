        <section id="nr-articles" class="nr-section-left">

          <?php if (!empty($idx_noticias) && is_array($idx_noticias) ) { ?>
            <div class="nr-related-article-list">
              <?php foreach ($idx_noticias as $news) { 
                $post_thumbnail_id = get_post_thumbnail_id($news['ID']); 
                $post_thumbnail_url = wp_get_attachment_url($post_thumbnail_id,'medium'); 
                if (empty($post_thumbnail_url)) {
                  $post_thumbnail_url= get_template_directory_uri().'/images/coming-soon.png';
                }
                ?>
              <section class="nr-item-article">
                <article class="nr-wrap-item">
                  <h3 class="nr-item-title"><a href="<?php echo get_site_url().'/'.$news['post_name']; ?>"><?php echo $news['post_title']; ?></a></h3>
                  <p>Coconut Grove is known for its high-end lifestyle. Its bohemian chic atmosphere was even covered by the Wall Street Journal in an article describing the Grove’s transformation from ...</p>
                  <!--<span class="nr-item-label">Relocating to Miami</span>-->
                </article>
                <a href="<?php echo get_site_url().'/'.$news['post_name']; ?>" class="nr-wrap-img">
                  <img src="<?php echo $post_thumbnail_url; ?>" >
                </a>
              </section>

              <?php } ?>
            </div>
          <?php } ?>

          <div class="nr-wrap-btn text-center">
            <a href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>?neighborhood=<?php echo $atts['id_neighborhood']; ?>" class="nr-btn">
              <span><?php echo __('View MORE', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
            </a>
          </div>
          
          <div class="nr-flex">
            <?php if (!empty($idx_noticias_trending) && is_array($idx_noticias_trending) ) { ?>
              <div class="nr-sp-list">
                <h3 class="nr-title">Top Trending</h3>
                <ul>
                  <?php foreach ($idx_noticias_trending as $news) {  ?>
                    <li>
                      <span class="nr-icon-play"></span>
                      <a href="<?php echo get_site_url().'/'.$news['post_name']; ?>"><?php echo $news['post_title']; ?></a>
                    </li>
                  <?php } ?>
                </ul>
              </div>
            <?php } ?>

                <?php if (!empty($idx_noticias_market) && is_array($idx_noticias_market) ) { ?>
                  <div class="nr-sp-list">
                    <h3 class="nr-title">Top Trending</h3>
                    <ul>
                      <?php foreach ($idx_noticias_market as $news) {  ?>
                        <li>
                          <span class="nr-icon-play"></span>
                          <a href="<?php echo get_site_url().'/'.$news['post_name']; ?>"><?php echo $news['post_title']; ?></a>
                        </li>
                      <?php } ?>
                    </ul>
                  </div>
                <?php } ?>                
              
          </div>
        </section>

