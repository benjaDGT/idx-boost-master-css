<?php get_header();
$post_thumbnail_id = get_post_thumbnail_id(get_the_id());
$post_thumbnail_url = wp_get_attachment_url($post_thumbnail_id);
while ( have_posts() ) : the_post(); ?>
<div class="r-overlay"></div>
  <main id="flex-default-theme">
    <?php the_content(); ?>
  </main>
<link href="<?php echo NEIGHBORHOOD_IDX_URI; ?>css/neighborhoods_page.css" rel="stylesheet">
<?php endwhile; get_footer(); ?>
<script type="text/javascript">
	jQuery("body").addClass("active-full-page");
</script>
<style type="text/css">
  #wrap-neighborhood-collection .wrap-neighborhood-section{
        height: calc(100% - 140px);
  }
</style>