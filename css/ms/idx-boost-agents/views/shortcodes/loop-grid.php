<?php
global $wpdb;
$buildingAbcQuery='';
if (!empty($_GET)) {
    if (!empty($_GET['abc']))
        $buildingAbcQuery='and post_title like "'.$_GET['abc'].'%"';
    if (!empty($_GET['search']))
        $buildingAbcQuery='and post_title like "%'.$_GET['search'].'%"';
}
$query_post="SELECT ID,post_title,post_name FROM {$wpdb->posts} WHERE {$wpdb->posts}.post_type='agent' and post_status='publish' ".$buildingAbcQuery." order by post_title asc;";
$result_post = $wpdb->get_results($query_post, ARRAY_A);
?>
<div class="wp-filters-agents">
  <div class="gwr">
    <ul class="directory">
        <?php
        for($i=65; $i<=90; $i++) { ?>
            <li><a <?php if (!empty($_GET['abc'])) if($_GET['abc']==strtolower(chr($i))) echo 'class="active"'; ?> href="?abc=<?php echo strtolower(chr($i)); ?>" rel="nofollow"><?php echo chr($i); ?></a></li>
        <?php } ?>
      <li><a href="?" rel="nofollow" class="btn-all"><?php echo __("View all", IDXBOOST_DOMAIN_THEME_LANG); ?>  <span><?php echo __("agents", IDXBOOST_DOMAIN_THEME_LANG); ?></span></a></li>
    </ul>
    <div class="bg-form-agent">
      <form method="get" id="filter-name" autocomplete="off">
        <!-- <input type="hidden" name="action" value="dgt_load_agents">-->
        <input type="text" name="search" value="<?php if(!empty($_GET['search'])) echo $_GET['search']; ?>" name="keyword" placeholder="<?php echo __('Search for an associate...', IDXBOOST_DOMAIN_THEME_LANG); ?>" class="input-search">
        <div id="submit-ms" class="icon-search"><input type="submit" value="Submit"></div>
      </form>
    </div>
  </div>
</div>

<?php
if ( count($result_post) > 0 ): ?>
<section id="flex-agent-content" class="agentsPage <?php echo $category; ?>-dgt-<?php echo $format; ?>">
  <div class="gwr">
    <ul id="flex-agent-list">
      <?php
      foreach($result_post as $keys => $value_post){
          $email = get_post_meta($value_post['ID'], '_agents_speciality_email', true);
          $title = get_post_meta($value_post['ID'], '_dgt_speciality_title', true);
          $phone_office = get_post_meta($value_post['ID'], '_agents_speciality_phone', true);
          $fb = get_post_meta($value_post['ID'], '_agents_speciality_fb', true);
          $tw = get_post_meta($value_post['ID'], '_agents_speciality_tw', true);
          $inst = get_post_meta($value_post['ID'], '_agents_speciality_inst', true);
          $in = get_post_meta($value_post['ID'], '_agents_speciality_in', true);
          $url = get_the_permalink($value_post['ID']);
          $post_thumbnail_id = get_post_thumbnail_id($value_post['ID']);
          $post_thumbnail_url = wp_get_attachment_url($post_thumbnail_id);

          //$short_text = substr(the_content(), 0, 250)."...";
      $redes='';
      if(empty($fb) && empty($tw) && empty($inst) && empty($in))  $redes='idx-nsm'; ?>

        <li class="flex-agent-item">
            <article class="idx-card minimal-card <?php echo $redes; ?> <?php if($keys==1){ echo 'active-card'; } ?>">
                <h2 class="idx-card-title">
                    <span><?php echo $value_post['post_title']; ?></span>
                    <strong><?php echo $title;?></strong>
                </h2>
                <div class="idx-card-content">
                    <div class="idx-card-img">
                        <?php if ( !empty($post_thumbnail_url ) ) { ;?>
                            <img src="<?php echo $post_thumbnail_url; ?>" alt="<?php echo get_the_title($post_thumbnail_id );?>">
                        <?php } else{ ;?>
                            <img src="<?php echo get_template_directory_uri().'/images/agent-default.jpg';?>" alt="<?php the_title();?>">
                        <?php };?>
                    </div>
                    <!--<div class="idx-card-description"><?php echo $short_text; ?></div>-->
                    <div class="idx-card-description">
                        <?php echo __("He rose to international fame with his role as the Man with No Name in Sergio Leone's Dollars trilogy of spaghetti Westerns during the 1960s...", IDXBOOST_DOMAIN_THEME_LANG); ?>
                    </div>
                </div>
                <button class="idx-card-btn-action"><span></span></button>
                <div class="idx-card-footer">
                    <h2 class="idx-card-title mtfoter">
                        <span><?php echo $value_post['post_title']; ?></span>
                        <strong><?php echo $title;?></strong>
                    </h2>
                    <div class="idx-card-contact">
                        <a href="tel:<?php echo $phone_office;?>" class="idx-card-telf"><?php echo $phone_office;?></a>
                        <a href="mailto:<?php echo $email;?>" class="idx-card-email"><?php echo $email;?></a>
                    </div>
                    <?php if(empty($redes) ){ ?>
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
                                <a  href="<?php echo $in; ?>" class="idx-social-link clidxboost-icon-linkedin"><span>LinkedIn</span></a>
                            <?php endif;?>
                        </div>
                    <?php } ?>

                </div>

                <a href="<?php echo $url; ?>" class="idx-card-link"><?php echo __("view detail", IDXBOOST_DOMAIN_THEME_LANG); ?></a>
            </article>
        </li>
        <?php } ?>
    </ul>
  </div>
</section>
<?php endif; ?>