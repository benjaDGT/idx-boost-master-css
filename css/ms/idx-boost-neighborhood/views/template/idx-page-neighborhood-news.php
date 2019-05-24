<?php
/**
 * Template Name: Neighborhood Detail
 * Template Post Type: page
 */
get_header();
global $flex_idx_info;
$post_thumbnail_id = get_post_thumbnail_id(get_the_id());
$post_thumbnail_url = wp_get_attachment_url($post_thumbnail_id);
$idneighboardhood=0;
while ( have_posts() ) : the_post(); ?>
<?php 

//$idneighboardhood = get_post_meta( get_the_id(), 'tgpost_relacion', true );
$id_parent=wp_get_post_parent_id(get_the_id());
$permalink_parent =''; $title_parent='';


if ($id_parent !=0) {
  $idneighboardhood = get_post_meta( $id_parent, 'tgneigthboardhood_relacion', true );
  $permalink_parent = get_permalink($id_parent);
  $title_parent = get_the_title($id_parent);
  $post_thumbnail_id = get_post_thumbnail_id($id_parent);
  $post_thumbnail_url = wp_get_attachment_url($post_thumbnail_id);  
}else{
  $id_parent=get_the_id();
}
  $result_query_f=$wpdb->get_row("SELECT post_id FROM {$wpdb->postmeta} where meta_key='tgpost_relacion' and meta_value='".$id_parent."';");

  if (!empty($result_query_f)) {
    $idneighboardhood=$result_query_f->post_id;
  }

$communities_data=[];  

if (!empty($idneighboardhood)) {
      $get_neighboarhood = $wpdb->get_results("
        SELECT post.ID,post.post_title,meta_klm.meta_value as dgt_geometry,dgt_extra_hide_top_section.meta_value as is_hide_top,dgt_extra_default_view.meta_value as default_view,dgt_extra_neigbordhood_map.meta_value as method_map
        FROM {$wpdb->posts} post 
          left join {$wpdb->postmeta} meta_klm on meta_klm.post_id=post.ID and meta_klm.meta_key='dgt_map_geometry'
          left join {$wpdb->postmeta} dgt_extra_hide_top_section on dgt_extra_hide_top_section.post_id=post.ID and dgt_extra_hide_top_section.meta_key='dgt_extra_hide_top_section'
          left join {$wpdb->postmeta} dgt_extra_default_view on dgt_extra_default_view.post_id=post.ID and dgt_extra_default_view.meta_key='dgt_extra_default_view'
          left join {$wpdb->postmeta} dgt_extra_neigbordhood_map on dgt_extra_neigbordhood_map.post_id=post.ID and dgt_extra_neigbordhood_map.meta_key='dgt_extra_neigbordhood_map'
        where post.post_type in('neighborhood','tgneighborhood') and post.ID=".$idneighboardhood.";", ARRAY_A);

      $neighboarhood_data = [];
      if (is_array($get_neighboarhood) && count($get_neighboarhood) >0 ) {

        $GLOBALS['neighboarhood_data'] = $get_neighboarhood;

        foreach ($get_neighboarhood as $value_neigh) {
          if (!empty($value_neigh['dgt_geometry'])) {
            $geocode=$value_neigh['dgt_geometry'];
              parse_str($geocode, $geometry);
              $geometry_lat=''; $geometry_lng=''; $geometry_zoom='';

              if (array_key_exists('lat', $geometry)) {
                $geometry_lat=$geometry['lat'];
              }

              if (array_key_exists('lng', $geometry)) {
                $geometry_lng=$geometry['lng'];
              }

              if (array_key_exists('zoom', $geometry)) {
                $geometry_zoom=$geometry['zoom'];
              }
          }
          $default_view='photo';
          if (!empty($value_neigh['default_view']))
            $default_view=$value_neigh['default_view'];

            $neighboarhood_data=array(
              'ID' =>$value_neigh['ID'],
              'is_hide_top' =>$value_neigh['is_hide_top'],
              'method_map' =>$value_neigh['method_map'],
              'default_view' =>$default_view,
              'name' =>$value_neigh['post_title'],
              'geometry' =>$geometry['geometry'],
              'geometry_lat' => $geometry_lat,          
              'geometry_lng' =>$geometry_lng,
              'geometry_zoom' =>$geometry_zoom
             );

             if ($neighboarhood_data['method_map'] == 'only_communities' ) {

          $communities_data_query = $wpdb->get_results("SELECT post_commun.post_title,post_page.ID ,meta_prin.post_id as id_community
            ,postme_geometry.meta_value as dgt_geometry,url.meta_value as url
            from {$wpdb->postmeta} as meta_prin
            inner join {$wpdb->posts} as post_commun on post_commun.ID=meta_prin.post_id 
            inner join {$wpdb->posts} as post_page on post_page.ID=meta_prin.meta_value and post_page.post_parent={$id_parent}
            left join {$wpdb->postmeta} postme_geometry on postme_geometry.post_id=meta_prin.post_id and postme_geometry.meta_key='dgt_map_geometry'
            left join {$wpdb->postmeta} url on url.post_id=meta_prin.post_id and url.meta_key='Communities_url'
            where meta_prin.meta_key='tgpost_relacion_communitity' order by post_commun.post_title asc;", ARRAY_A);

        foreach ($communities_data_query as $value_neigh) {
          if (!empty($value_neigh['dgt_geometry'])) {
            
            $geocode=$value_neigh['dgt_geometry'];

              parse_str($geocode, $geometry);
              $geometry_lat=''; $geometry_lng=''; $geometry_zoom='';

              if (array_key_exists('lat', $geometry)) {
                $geometry_lat=$geometry['lat'];
              }

              if (array_key_exists('lng', $geometry)) {
                $geometry_lng=$geometry['lng'];
              }

              if (array_key_exists('zoom', $geometry)) {
                $geometry_zoom=$geometry['zoom'];
              }
            }

            $communities_data[]=array(
              'ID' =>$value_neigh['ID'],
              'name' =>$value_neigh['post_title'],
              'url' =>$value_neigh['url'],
              'geometry' =>$geometry['geometry'],
              'geometry_lat' => $geometry_lat,          
              'geometry_lng' =>$geometry_lng,
              'geometry_zoom' =>$geometry_zoom
             );
        }

/*                $list_pages_silo = $wpdb->get_results("SELECT post_commun.post_title,post_page.ID 
                  from {$wpdb->postmeta} as meta_prin
                  inner join {$wpdb->posts} as post_commun on post_commun.ID=meta_prin.post_id 
                  inner join {$wpdb->posts} as post_page on post_page.ID=meta_prin.meta_value and post_page.post_parent={$id_parent}
                  where meta_prin.meta_key='tgpost_relacion_communitity' order by post_commun.post_title asc;", ARRAY_A);              
                  */
                $GLOBALS['result_community_on_neig'] = $communities_data_query;
             }
          }
      }
  }

  


  if (!empty( $flex_idx_info["agent"]["google_maps_api_key"] ))
      $idx_social_mediamaps  = $flex_idx_info["agent"]["google_maps_api_key"];

      wp_enqueue_script('google-maps-api', sprintf('//maps.googleapis.com/maps/api/js?key=%s', $idx_social_mediamaps ));
      wp_enqueue_script('underscore', NEIGHBORHOOD_IDX_URI . 'js/underscore-min.js' , NEIGHBORHOOD_IDX_VERSION, true );
      wp_enqueue_script('infobox_packed-map', NEIGHBORHOOD_IDX_URI . 'js/infobox_packed.js' , NEIGHBORHOOD_IDX_VERSION, true );
      wp_enqueue_script('richkmarker-map', NEIGHBORHOOD_IDX_URI . 'js/richmarker-compiled.js' , NEIGHBORHOOD_IDX_VERSION, true );
      wp_enqueue_script('idx-neighborhood-silo-js', NEIGHBORHOOD_IDX_URI . 'js/idxboost_script_silo.js', NEIGHBORHOOD_IDX_VERSION, true );
      wp_enqueue_script('google-maps-utility-library-infobox', NEIGHBORHOOD_IDX_URI . 'vendor/google-maps-utility-library/infobox_packed.js', array('google-maps-api'));
      wp_localize_script('idx-neighborhood-silo-js', 'idx_neighboardhood', array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'item_neighboardhood' => $neighboarhood_data,
        'item_community' => $communities_data,
        'method_map' => $neighboarhood_data['method_map']
        ));     
?>

    <sectio class="nr-section nr-wrap-gwr">
      <header class="nr-header-page">
        <h1 class="nr-title"><?php the_title() ?> Real Estate News</h1>
        <a href="#" class="nr-btn-link">All Neighborhoods</a>
      </header>

      <div class="nr-section-content">
        <?php
        if ( shortcode_exists( 'sc_news_to_neighborhood' ) ) 
          echo do_shortcode('[sc_news_to_neighborhood id_neighborhood="'.$idneighboardhood.'"]');
        ?>        

        <aside id="nr-aside" class="nr-section-right">

        <?php
          if ( shortcode_exists( 'idx_silo_general' ) )  
          echo do_shortcode('[idx_silo_general id_page="'.$idneighboardhood.'"]'); 

        if ( shortcode_exists( 'idx_communities_asociation' ) ) 
          echo do_shortcode('[idx_communities_asociation id_page="'.$id_parent.'"]');
        
        if ( shortcode_exists( 'idx_building_asociation' ) ) 
          echo do_shortcode('[idx_building_asociation id_page="'.$idneighboardhood.'"]');
        ?>

          <div class="nr-widget borderd">
            <img src="https://newsluxlife.staging.wpengine.com/wp-content/themes/minimalib/project/images/blog/david-lateral.jpg" class="nr-img">
            <div class="nr-banner">
              <span class="nr-icon-logo"></span>
              <h3 class="nr-title">DAVID SIDDONS GROUP</h3>
              <span class="nr-sub-title">Miami’s #1 Real Estate Market Analysts</span>
              <p>Get information before hits the market, Receive the latest news in the Miami Real.</p>
              <a href="#" class="nr-btn-link">Say Hello!</a>
            </div>
          </div>

          <div class="nr-widget nr-search">
            <span class="nr-icon-newsletter"></span>
            <h2 class="nr-widget-search-title">Get on the list!</h2>
            <span class="nr-widget-search-msg">Get information before hits the market andthe latest news in the Miami Real Estate Market.</span>
            <div class="form_1 form-master container_dgt_form">
              <div class="form-content  large-form">
                <form class="dgtFormAction" id="dgtform-1">
                  <div class="gform_body body_md">
                    <ul class="gform_fields">
                      <li class="gfield ">
                        <label class="gfield_label" for="input_1_2">Email *</label>
                        <div class="ginput_container">
                          <input tabindex="11" placeholder="Email*" name="input_2" type="email" class="medium" id="input_1_2" required="">
                        </div>
                      </li>
                      <li class="gfield ">
                        <label class="gfield_label" for="input_1_1">Name *</label>
                        <div class="ginput_container">
                          <input placeholder="Name*" tabindex="12" name="input_1" type="text" class="medium" id="input_1_1" required="">
                        </div>
                      </li>
                      <li class="gfield requiredFields">* Required Fields</li>
                    </ul>
                  </div>
                  <div class="gform_footer">
                    <input type="hidden" name="action" value="dgt_dgtform">
                    <input type="hidden" name="i" value="1">
                    <input type="hidden" name="post_id" value="28984">
                    <input type="submit" tabindex="13" value="Join Now" class="btn button">
                  </div>
                </form>
              </div>
              <div class="cd-cover-layer"></div>
              <div class="cd-loading-bar"></div>
              <div class="cd-loading-message" style="display: none;">We are processing your message...</div>
            </div>
          </div>

          <?php 
            if( 
              !empty($flex_idx_info["social"]["facebook_social_url"]) ||
              !empty($flex_idx_info["social"]["twitter_social_url"]) ||
              !empty($flex_idx_info["social"]["gplus_social_url"]) ||
              !empty($flex_idx_info["social"]["youtube_social_url"]) ||
              !empty($flex_idx_info["social"]["instagram_social_url"]) ||
              !empty($flex_idx_info["social"]["linkedin_social_url"]) ||
              !empty($flex_idx_info["social"]["pinterest_social_url"]) 
            ) {  ?>

            <div class="nr-widget nr-social-box borderd">
              <h2 class="nr-widget-title-st text-center">CONNECT WITH US!</h2>
              <ul class="social-networks notranslate">
                <?php if (!empty($flex_idx_info["social"]["facebook_social_url"])): ?>
                  <li><a href="<?php echo $flex_idx_info["social"]["facebook_social_url"]; ?>" target="_blank" rel="nofollow" class="idx-icon-facebook"><span>Facebook</span></a></li>
                <?php endif; ?>
                <?php if (!empty($flex_idx_info["social"]["twitter_social_url"])): ?>
                  <li><a class="idx-icon-twitter" href="<?php echo $flex_idx_info["social"]["twitter_social_url"]; ?>" title="Twitter" target="_blank" rel="nofollow"><span>Twitter</span></a></li>
                <?php endif; ?>
                <?php if (!empty($flex_idx_info["social"]["gplus_social_url"])): ?>
                  <li><a class="clidxboost-icon-google-plus" href="<?php echo $flex_idx_info["social"]["gplus_social_url"]; ?>" title="Google+" target="_blank" rel="nofollow"><span>Google+</span></a></li>
                <?php endif; ?>
                <?php if (!empty($flex_idx_info["social"]["youtube_social_url"])): ?>
                  <li><a class="idx-icon-youtube" href="<?php echo $flex_idx_info["social"]["youtube_social_url"]; ?>" title="Youtube" target="_blank" rel="nofollow"><span>YouTube</span></a></li>
                <?php endif; ?>
                <?php if (!empty($flex_idx_info["social"]["instagram_social_url"])): ?>
                  <li><a href="<?php echo $flex_idx_info["social"]["instagram_social_url"]; ?>" target="_blank" rel="nofollow" class="idx-icon-instagram"><span><span>Instagram</span></span></a></li>
                <?php endif; ?>
                <?php if (!empty($flex_idx_info["social"]["linkedin_social_url"])): ?>
                  <li><a class="idx-icon-linkedin2" href="<?php echo $flex_idx_info["social"]["linkedin_social_url"]; ?>" title="Linked In" target="_blank" rel="nofollow"><span>Linked In</span></a></li>
                <?php endif; ?>
                <?php if (!empty($flex_idx_info["social"]["pinterest_social_url"])): ?>
                  <li><a class="clidxboost-icon-pinterest" href="<?php echo $flex_idx_info["social"]["pinterest_social_url"]; ?>" title="Pinterest" target="_blank" rel="nofollow"><span>Pinterest</span></a></li>
                <?php endif; ?>
              </ul>
            </div>

          <?php } ?>

        </aside>
      </div>
    </sectio>

   
    

<?php endwhile; ?> 

<?php get_footer(); ?> 