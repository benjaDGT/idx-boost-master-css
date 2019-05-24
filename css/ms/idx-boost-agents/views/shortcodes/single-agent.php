<?php
get_header();
$post_id = get_the_ID();
$filter_agent = get_post_meta($post_id, '_agents_speciality_agent_idx', true);
//$filter_office = get_post_meta($post_id, '_dgt_speciality_office_idx', true);
$email = get_post_meta(get_the_ID(), '_agents_speciality_email', true);
$title = get_post_meta(get_the_ID(), '_dgt_speciality_title', true);
$phone_office = get_post_meta(get_the_ID(), '_agents_speciality_phone_office', true);
$fb = get_post_meta(get_the_ID(), '_agents_speciality_fb', true);
$tw = get_post_meta(get_the_ID(), '_agents_speciality_tw', true);
$inst = get_post_meta(get_the_ID(), '_agents_speciality_inst', true);
$in = get_post_meta(get_the_ID(), '_agents_speciality_in', true);         
$phone = get_post_meta(get_the_ID(), '_agents_speciality_phone', true);

$languages = wp_get_post_terms($post_id, 'language', array("fields" => "all"));
while ( have_posts() ) : the_post();
?>

<section id="flex-agent-information">
  <div class="flex-wrap-information">
    <div class="flex-text-img-content">
      <div class="flex-agent-img">
        <?php if ( has_post_thumbnail() ) { ;?>
        <?php the_post_thumbnail('full'); ?>
        <?php } else{ ;?>
        <img src="<?php echo get_template_directory_uri().'/images/blog-default.jpg';?>" alt="<?php the_title();?>">
        <?php };?>
      </div>
      <article class="flex-agent-description">
        <h1 class="flex-ag-title"><?php echo get_the_title(); ?></h1>
        <h3 class="flex-ag-position"><?php echo $title ;?></h3>
        <div class="idx-card-social">
          <?php if(!empty($fb)): 
               $tempfb=parse_url($fb);
               if (is_array($tempfb) ) {
                    if ( !array_key_exists('scheme', $tempfb))
                         $fb='https://'.$fb;
               }
            ?>
          <a href="<?php echo $fb; ?>" class="idx-social-link clidxboost-icon-facebook"><span>Facebook</span></a>
          <?php endif;?>
          <?php if(!empty($tw)):
               $temptw=parse_url($tw);
               if (is_array($temptw) ) {
                    if ( !array_key_exists('scheme', $temptw))
                         $tw='https://'.$tw;
               }
           ?>
          <a href="<?php echo $tw; ?>" class="idx-social-link clidxboost-icon-twitter"><span>Twitter</span></a>
          <?php endif;?>
          <?php if(!empty($inst)):
               $tempinst=parse_url($inst);
               if (is_array($tempinst) ) {
                    if ( !array_key_exists('scheme', $tempinst))
                         $inst='https://'.$inst;
               }
           ?>
          <a href="<?php echo $inst; ?>" class="idx-social-link clidxboost-icon-instagram"><span>Instagram</span></a>
          <?php endif;?>
          <?php if(!empty($in)):
               $tempin=parse_url($in);
               if (is_array($tempin) ) {
                    if ( !array_key_exists('scheme', $tempin))
                         $in='https://'.$in;
               }
           ?>
          <a href="<?php echo $in; ?>" class="idx-social-link clidxboost-icon-linkedin"><span>LinkedIn</span></a>
          <?php endif;?>
        </div>
        <div class="idx-ag-content">
          <?php the_content(); ?>
        </div>
      </article>
      <button id="btn-read">
        <span class="tx_a"><?php echo __("Read more", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
        <span class="tx_b"><?php echo __("Read less", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
      </button>
    </div>
    <div class="flex-agent-form">
      <div class="form-content">
        <div class="avatar-content">
          <div class="avatar-information">
            <h2>Contact Realtor</h2>
            <?php if (!empty($phone)){ ?>
              <a class="phone-avatar" href="tel:<?php echo $phone; ?>"><?php echo __("Tel.", IDXBOOST_DOMAIN_THEME_LANG); ?> <?php echo $phone; ?></a>
            <?php } ?>
            <?php if (!empty($email)){ ?>
            <a class="phone-avatar" href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a>
            <?php } ?>
          </div>
        </div>
          <?php if (isset($dgtForms)): ?>
          <?php echo $dgtForms->loadGF(2, ['header' => false, 'orientation'=>'horizontal', 'title'=>false]); ?>
          <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<?php if(!empty($filter_agent)): ?>
<section id="flex-agent-listing">
  <article class="flex-block-description">
      <?php echo do_shortcode('[idx_agent_filter id="'.$filter_agent.'" type="agent"]')?>
  </article>
</section>
<?php endif;?>

<?php endwhile; get_footer(); ?>
<?php get_footer(); ?>
<script type="text/javascript">
  jQuery(document).on('click', '#btn-read', function() {
    jQuery(this).parent().toggleClass('view-more-text');
  });
</script>
 
 <?php get_footer(); ?>