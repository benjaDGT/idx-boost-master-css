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
   <div class="r-overlay"></div>
    
    <main class="basic-theme clidxboost-noscroll" id="wrap-neighborhood">
      <section id="header-title">
        <header>
          <div class="gwr">
            <h1 class="title-header"><?php the_title() ?></h1><a class="btnb-blue" href="#flex_idx_contact_form" title="Find Your dream home now" rel="nofollow"><?php echo __("Request more information", IDXBOOST_DOMAIN_THEME_LANG); ?></a>
            <div id="wrap-breacrumb">
              <div class="gwr">
                <ol id="breacrumb">
                    <li><a href="<?php echo site_url(); ?>" title="Home"><?php echo __("Home", IDXBOOST_DOMAIN_THEME_LANG); ?></a></li>
                    <?php if (!empty($title_parent)) { ?>
                      <li><a href="<?php echo $permalink_parent; ?>" title="<?php echo $title_parent; ?>"><?php echo $title_parent; ?></a></li>
                    <?php } ?>
                    <li><?php the_title() ?></li>
                </ol>
              </div>
            </div>
              <?php
              if ( shortcode_exists( 'idx_silo_general' ) ) 
                echo do_shortcode('[idx_silo_general id_page="'.$idcommunitites.'" mode="mobile"]');
              ?>            
          </div>
        </header>
      </section>

      <section id="neighborhood">
        <section class="gwr block-description">
            <?php if ( $community_data['is_hide_top']!='1' && ( !empty($post_thumbnail_url) || (!empty($community_data) && $community_data['geometry'] != null )  ) ) {?>
            <div class="wrap-map-img">
                <?php
                $default_view = $community_data['default_view'];
                $bool_select_map=empty($post_thumbnail_url) && (!empty($community_data) && $community_data['geometry'] != null ) || (!empty($community_data) && $community_data['geometry'] != null ) ;
                 if ( !empty($post_thumbnail_url) ) { ?>
                  <div class="item-im 
                  <?php if( $bool_select_map ==false || ( $default_view=='photo' && !$bool_select_map ) || ($bool_select_map && $default_view=='photo' )  ) { 
                    echo 'active'; } ?>" id="wrap-img"><img src="<?php echo $post_thumbnail_url;?>"></div>
                <?php } ?>
                
                <?php if($bool_select_map != false){ ?>
                <div class="item-im <?php if ( ( $bool_select_map && $default_view=='map' ) || (empty($post_thumbnail_url) && $bool_select_map ) || ( !$bool_select_map && $default_view =='map' ) ) {  echo 'active'; } ?> " id="idx_map_silo_community"></div>
              <?php } ?>

                <div class="moptions">
                    <?php if(!empty($post_thumbnail_url)){ ?>
                      <button class="btn-im-op active" data-active="wrap-img"><?php echo __("photo", IDXBOOST_DOMAIN_THEME_LANG); ?></button>
                    <?php } ?>

                    <?php if( (!empty($community_data) && $community_data['geometry'] != null ) ){ ?>
                      <button class="btn-im-op" data-active="idx_map_silo_community"><?php echo __("map view", IDXBOOST_DOMAIN_THEME_LANG); ?></button>
                    <?php } ?>
                </div>
            </div>
            <?php } ?>
        
          <?php the_content(); ?>

        </section>
      </section>
      <section class="nav-aside">
        <?php 

        do_shortcode('[idx_silo_general id_page="'.$idcommunitites.'" ]');

        if ( shortcode_exists( 'idx_communities_asociation' ) ) 
          echo do_shortcode('[idx_communities_asociation id_page="'.$array_page_neighboardhood['id'].'" mode="page_comunity"  page_id_neighborhood="'.$array_page_neighboardhood['id'].'" page_name_neighborhood="'.$array_page_neighboardhood['name'].'" page_link_neighborhood="'.$array_page_neighboardhood['link'].'" ]');

        do_shortcode('[idx_building_asociation id_page="'.$icommunityselect.'"]');

        ?>
    <?php echo do_shortcode('[flex_idx_contact_form type_form="neighborhood"]'); ?>                
      </section>
    </main>

<?php endwhile; ?> 

<script type="text/javascript">
jQuery('.moptions .btn-im-op').click(function(){
    jQuery('.moptions .btn-im-op').removeClass('active');
    jQuery(this).addClass('active');
    jQuery('.wrap-map-img .item-im').removeClass('active');
    jQuery('#'+jQuery(this).attr('data-active')).addClass('active');
});    
</script>
<style>
.content-nav .similar-properties article h2{
  min-height: 70px;
  display: flex;
  align-items: center;
}
</style>
<?php get_footer(); ?> 