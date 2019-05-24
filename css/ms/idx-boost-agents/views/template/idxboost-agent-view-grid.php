<?php
get_header();
$post_thumbnail_id = get_post_thumbnail_id(get_the_id());
$post_thumbnail_url = wp_get_attachment_url($post_thumbnail_id);
while ( have_posts() ) : the_post(); ?>
    <div class="r-overlay"></div>
  <main id="flex-default-theme">
      <div class="gwr grand-breadcrumb">
          <div class="flex-breadcrumb">
              <ol>
                  <li><a href="<?php echo site_url(); ?>" title="Home"><?php echo __("Home", IDXBOOST_DOMAIN_THEME_LANG); ?></a></li>
                  <li><?php echo get_the_title(); ?></li>
              </ol>
          </div>
      </div>
      <article class="flex-block-description agent-header">
        <?php the_content(); ?>
        <!-- CONTENIDO -->
      </article>
      <!-- IMAGEN POR DEFECTO -->
      <?php if ($post_thumbnail_url) { ?>
        <div class="content-full-img"><img src="<?php echo $post_thumbnail_url;?>" title="<?php echo __("About", IDXBOOST_DOMAIN_THEME_LANG); ?>" alt="<?php echo __("About", IDXBOOST_DOMAIN_THEME_LANG); ?>"></div>
      <?php } ?>
    <?php echo do_shortcode('[agents_dgt category="agents" format="grid"]');?>
  </main>
<?php endwhile; ?> 
<style type="text/css">
  .wp-filters-agents .directory li{
        height: fit-content;
  }
</style>
<?php get_footer(); ?> 