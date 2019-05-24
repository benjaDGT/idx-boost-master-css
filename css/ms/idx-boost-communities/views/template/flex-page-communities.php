<?php get_header();
$post_thumbnail_id = get_post_thumbnail_id(get_the_id());
$post_thumbnail_url = wp_get_attachment_url($post_thumbnail_id);
while ( have_posts() ) : the_post(); ?>
    <div class="r-overlay"></div>
  <main id="flex-default-theme">
    <?php the_content(); ?>
    <?php echo do_shortcode('[IDX_COMMUNITIES]');?>
  </main>
    <link href="<?php echo COMMUNITIES_IDX_URI; ?>css/communities_page.css" rel="stylesheet">
<?php endwhile; get_footer(); ?> 