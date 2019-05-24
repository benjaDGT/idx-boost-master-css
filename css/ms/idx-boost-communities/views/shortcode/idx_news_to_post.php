<?php
global $post;

function custom_excerpt_length( $length ) {
    return 35;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );
?>
<section id="nr-articles" class="nr-section-left">
    <?php if (!empty($idx_noticias) && is_array($idx_noticias) ) { ?>
        <div class="nr-related-article-list">
            <?php foreach ($idx_noticias as $news) {
                $post_thumbnail_id = get_post_thumbnail_id($news['ID']);
                $post_thumbnail_url = wp_get_attachment_url($post_thumbnail_id,'medium');
                if (empty($post_thumbnail_url)) {
                    $post_thumbnail_url= get_template_directory_uri().'/images/coming-soon.png';
                }
                $category_list = get_the_category($news['ID']);
                $post = get_post($news['ID']);
                setup_postdata($post);
                ?>
                <section class="nr-item-article">
                    <article class="nr-wrap-item">
                        <h3 class="nr-item-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <h4 class="nr-item-date"><?php echo get_the_date( 'F j, Y' ); ?></h4>
                        <p><?php the_excerpt(); ?></p>
                        <div class="nr-wrap-categories">
                            <?php if(!empty($category_list[0]->name)): ?>
                            <a href="<?php echo get_term_link($category_list[0]->term_id); ?>" title="<?php echo $category_list[0]->name; ?>"><span class="nr-item-label"><?php echo $category_list[0]->name; ?></span></a>
                            <?php endif; ?>
                            <?php if(!empty($category_list[1]->name)): ?>
                            <a href="<?php echo get_term_link($category_list[1]->term_id); ?>" title="<?php echo $category_list[1]->name; ?>"><span class="nr-item-label"><?php echo $category_list[1]->name; ?></span></a>
                            <?php endif; ?>
                            <?php if(!empty($category_list[2]->name)): ?>
                            <a href="<?php echo get_term_link($category_list[2]->term_id); ?>" title="<?php echo $category_list[2]->name; ?>"><span class="nr-item-label"><?php echo $category_list[2]->name; ?></span></a>
                            <?php endif; ?>
                        </div>
                    </article>
                    <a href="<?php the_permalink(); ?>" class="nr-wrap-img">
                        <img src="<?php echo $post_thumbnail_url; ?>" >
                    </a>
                </section>
            <?php } wp_reset_postdata(); ?>
        </div>
    <?php } ?>

            <?php
            $name_community='';
            if (array_key_exists('community', $GLOBALS) && is_array($GLOBALS['community']) ) {
              $name_community='?community='.urlencode($GLOBALS['community']['name']);
            }
            ?>

    <div class="nr-wrap-btn text-center">
        <a href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?><?php echo $name_community; ?>" class="nr-btn">
            <span><?php echo __('View MORE', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
        </a>
    </div>

    <div id="flex-default-theme">
        <h3 class="nr-title">Featured Properties</h3>
        <?php the_content(); ?>
    </div>
    <div class="nr-wrap-btn text-center">
        <a href="<?php echo get_bloginfo('url').'/'.$post->post_name; ?>-properties" class="nr-btn">
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
                <h3 class="nr-title">Market Reports</h3>
                <ul>
                    <?php foreach ($idx_noticias_market as $news) { ?>
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

