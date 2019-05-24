<?php
/**
 * Template Name: Neighborhood Detail
 * Template Post Type: page
 */
get_header();
$post_thumbnail_id = get_post_thumbnail_id(get_the_id());
$post_thumbnail_url = wp_get_attachment_url($post_thumbnail_id);
$image_map_kml_url='';
$idcommunitites=0;
$id_page_community =get_the_id();
global $flex_idx_info;
while ( have_posts() ) : the_post(); ?>

<?php 

function get_all_inherit($id_page_now,$response_temp = [] ){
  global $wpdb;
  $response=[];
  $response=$response_temp;
  $response_query=$wpdb->get_row("SELECT ID,post_title,post_name,post_parent FROM {$wpdb->posts} where ID='".$id_page_now."';", ARRAY_A);
  
  $response[]=array('id' => $response_query['ID'],'name'=>$response_query['post_title'],'link'=> $response_query['post_name'],'parent'=>$response_query['post_parent'] );
  if ($response_query['post_parent'] !=0 ) {
    $response=get_all_inherit($response_query['post_parent'],$response);
  }
  return $response;
}

function fc_order_all_inherit($reponse_inherit){
  if (is_array($reponse_inherit) && count($reponse_inherit)>0) {
    $reponse_inherit=array_reverse($reponse_inherit); /*se cambia del final para ordenar de padres a hijos*/ 
    foreach ($reponse_inherit as $key_response => $value_response) {

      if ($value_response['parent']=="0") {
        $reponse_inherit[$key_response]['link'] = site_url().'/'.$value_response['link'].'/';
      }else{
        $post_anterior=($key_response-1);
        if (array_key_exists($post_anterior, $reponse_inherit)) {
            $reponse_inherit[$key_response]['link'] = $reponse_inherit[$post_anterior]['link'].$value_response['link'].'/';
        }
      }
    }
  }
  return $reponse_inherit;
}

//$idcommunitites = get_post_meta( get_the_id(), 'tgpost_relacion', true );
$id_parent=wp_get_post_parent_id(get_the_id());
$permalink_parent =''; $title_parent='';
$is_inherit=false;
$id_community=get_the_id();
if ($id_parent !=0) {
  //$idcommunitites = get_post_meta( $id_parent, 'tgneigthboardhood_relacion', true );
  $is_inherit=true;
  $permalink_parent = get_permalink($id_parent);
  $title_parent = get_the_title($id_parent);
}else{
  $id_parent=$id_community;
}

$reponse_inherit=fc_order_all_inherit(get_all_inherit($id_page_community));

/*traemos los key*/
$key_page_now_inherit = array_search($id_page_community, array_column($reponse_inherit, 'id'));
$key_parent_neighboardhood_inherit = array_search('0', array_column($reponse_inherit, 'parent'));
$key_page_community_father = intval($key_page_now_inherit)-1;

if (array_key_exists($key_page_community_father, $reponse_inherit) && $key_page_community_father!=$key_parent_neighboardhood_inherit ) {
  $array_page_community_father=$reponse_inherit[$key_page_community_father];
}else{
  $array_page_community_father=$reponse_inherit[$key_page_now_inherit];
}

$array_page_community_now = $reponse_inherit[$key_page_now_inherit];
$array_page_neighboardhood = $reponse_inherit[$key_parent_neighboardhood_inherit];


$GLOBALS["neighboardhood"]=$array_page_neighboardhood['name'];

$result_query_f=$wpdb->get_row("SELECT post_id FROM {$wpdb->postmeta} where meta_key='tgpost_relacion_communitity' and meta_value='".$array_page_community_father['id']."';");
  
  if (!empty($result_query_f)) {
    $idcommunitites=$result_query_f->post_id;
  }

  if (!empty($idcommunitites) && $idcommunitites!=0) {
      
      $get_community = $wpdb->get_results("
        SELECT post.ID,post.post_title,meta_klm.meta_value as dgt_geometry,dgt_extra_hide_top_section.meta_value as is_hide_top,dgt_extra_default_view.meta_value as default_view,url.meta_value as url
        FROM {$wpdb->posts} post 
          left join {$wpdb->postmeta} meta_klm on meta_klm.post_id=post.ID and meta_klm.meta_key='dgt_map_geometry'
          left join {$wpdb->postmeta} dgt_extra_hide_top_section on dgt_extra_hide_top_section.post_id=post.ID and dgt_extra_hide_top_section.meta_key='dgt_extra_hide_top_section'
          left join {$wpdb->postmeta} dgt_extra_default_view on dgt_extra_default_view.post_id=post.ID and dgt_extra_default_view.meta_key='dgt_extra_default_view'         

          left join {$wpdb->postmeta} url on url.post_id=post.ID and url.meta_key='Communities_url'

        where post.post_type in('communities','tgcommunities') and post.ID=".$idcommunitites.";", ARRAY_A);

      $community_data = [];
      if (is_array($get_community) && count($get_community) >0 ) {

        foreach ($get_community as $value_neigh) {
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
          $icommunityselect=$value_neigh['ID'];

          $default_view='photo';
          if (!empty($value_neigh['default_view']))
            $default_view=$value_neigh['default_view'];

            $community_data=array(
              'ID' =>$value_neigh['ID'],
              'name' =>$value_neigh['post_title'],
              'is_hide_top' =>$value_neigh['is_hide_top'],
              'url' =>$value_neigh['url'],
              'default_view' =>$default_view,              
              'geometry' =>$geometry['geometry'],
              'geometry_lat' => $geometry_lat,          
              'geometry_lng' =>$geometry_lng,
              'geometry_zoom' =>$geometry_zoom
             );
          }
      } 
  }

  if (!empty( $flex_idx_info["agent"]["google_maps_api_key"] ))
      $idx_social_mediamaps  = $flex_idx_info["agent"]["google_maps_api_key"];

      wp_enqueue_script('google-maps-api', sprintf('//maps.googleapis.com/maps/api/js?key=%s', $idx_social_mediamaps ));
      wp_enqueue_script('underscore', COMMUNITIES_IDX_URI . 'js/underscore-min.js' , COMMUNITIES_IDX_VERSION, true );
      wp_enqueue_script('infobox_packed-map', COMMUNITIES_IDX_URI . 'js/infobox_packed.js' , COMMUNITIES_IDX_VERSION, true );
      wp_enqueue_script('idx-neighborhood-silo-js', COMMUNITIES_IDX_URI . 'js/idxboost_script_silo.js', COMMUNITIES_IDX_VERSION, true );
      wp_enqueue_script('google-maps-utility-library-infobox', COMMUNITIES_IDX_URI . 'vendor/google-maps-utility-library/infobox_packed.js', array('google-maps-api'));
      wp_localize_script('idx-neighborhood-silo-js', 'idx_community', array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'item_community' => $community_data
        ));      

?>

    <section class="nr-section nr-wrap-gwr">
      <header class="nr-header-page">
        <h1 class="nr-title"><?php the_title() ?> Real Estate News</h1>
        <a href="/neighborhoods" class="nr-btn-link">All Neighborhoods</a>
      </header>

      <div class="nr-section-content">

        <?php
            if ( shortcode_exists( 'sc_idx_news_to_community' ) )
                echo do_shortcode('[sc_idx_news_to_community id_community="'.$idcommunitites.'"]');
        ?>


        <aside id="nr-aside" class="nr-section-right">

        <?php
          if ( shortcode_exists( 'idx_silo_general' ) )  
            echo do_shortcode('[idx_silo_general id_page="'.$idcommunitites.'" ]');

        if ( shortcode_exists( 'idx_communities_asociation' ) ) 
          echo do_shortcode('[idx_communities_asociation id_page="'.$array_page_neighboardhood['id'].'" mode="page_comunity"  page_id_neighborhood="'.$array_page_neighboardhood['id'].'" page_name_neighborhood="'.$array_page_neighboardhood['name'].'" page_link_neighborhood="'.$array_page_neighboardhood['link'].'" ]');
        
        if ( shortcode_exists( 'idx_building_asociation' ) ) 
          echo do_shortcode('[idx_building_asociation id_page="'.$icommunityselect.'"]');
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
        <div id="flex-default-theme">
        <?php the_content(); ?>
        </div>
    </section>

   
    

<?php endwhile; ?> 

<?php get_footer(); ?> 