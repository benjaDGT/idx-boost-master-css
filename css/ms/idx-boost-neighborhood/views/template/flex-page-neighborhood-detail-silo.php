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
   <div class="r-overlay"></div>
    
    <main class="basic-theme clidxboost-noscroll" id="wrap-neighborhood">
      <section id="header-title">
        <header>
          <div class="gwr">
            <h1 class="title-header"><?php the_title() ?></h1>
            <a class="clidxboost-btn-link" href="#flex_idx_contact_form" title="Find Your dream home now" rel="nofollow"><span><?php echo __('Request more information', IDXBOOST_DOMAIN_THEME_LANG);?></span></a>
            <div id="wrap-breacrumb">
              <div class="gwr">
                <ol id="breacrumb">
                    <li><a href="<?php echo site_url(); ?>" title="Home"><?php echo __('Home', IDXBOOST_DOMAIN_THEME_LANG);?></a></li>
                    <?php if (!empty($title_parent)) { ?>
                      <li><a href="<?php echo $permalink_parent; ?>" title="<?php echo $title_parent; ?>"><?php echo $title_parent; ?></a></li>
                    <?php } ?>
                    <li><?php the_title() ?></li>
                </ol>
              </div>
            </div>
        <?php
        if ( shortcode_exists( 'idx_silo_general' ) ) 
          echo do_shortcode('[idx_silo_general id_page="'.$idneighboardhood.'" mode="mobile"]');
        ?>
          </div>
        </header>
      </section>
      <section id="neighborhood">

        <section class="gwr block-description">
            <?php if ( $neighboarhood_data['is_hide_top']!='1' && ( !empty($post_thumbnail_url) || (!empty($neighboarhood_data) && $neighboarhood_data['geometry'] != null )  ) ) {?>
            <div class="wrap-map-img">
                <?php
                $default_view = $neighboarhood_data['default_view'];
                $bool_select_map=empty($post_thumbnail_url) && (!empty($neighboarhood_data) && $neighboarhood_data['geometry'] != null ) ;

                 if ( !empty($post_thumbnail_url) ) { ?>
                  <div class="item-im <?php 
                  if( ( $default_view=='photo' && !$bool_select_map ) || ($bool_select_map && $default_view=='photo' ) || $bool_select_map===false ) { 
                    echo 'active'; 
                  } ?>" id="wrap-img">
                    <img src="<?php echo $post_thumbnail_url;?>" >
                  </div>
                <?php } ?>
                
                <div class="item-im <?php 
                if ( ( $bool_select_map && $default_view=='map' ) || (empty($post_thumbnail_url) && $bool_select_map ) || ( !$bool_select_map && $default_view =='map' ) ) 
                 { 
                  echo 'active'; 
                } ?>" id="idx_map_silo_neighboardhood"></div>
                <div class="moptions">
                    <?php if(!empty($post_thumbnail_url)){ ?>
                      <button class="btn-im-op active" data-active="wrap-img"><?php echo __('photo', IDXBOOST_DOMAIN_THEME_LANG);?></button>
                    <?php } ?>

                    <?php if( (!empty($neighboarhood_data) && $neighboarhood_data['geometry'] != null ) ){ ?>
                      <button class="btn-im-op" data-active="idx_map_silo_neighboardhood"><?php echo __('map view', IDXBOOST_DOMAIN_THEME_LANG);?></button>
                    <?php } ?>
                </div>
            </div>
            <?php } ?>        
          <?php the_content(); ?>
        </section>

      </section>
      <section class="nav-aside">
        <?php 
        if ( shortcode_exists( 'idx_silo_general' ) ) 
          echo do_shortcode('[idx_silo_general id_page="'.$idneighboardhood.'"]');
        
        if ( shortcode_exists( 'idx_communities_asociation' ) ) 
          echo do_shortcode('[idx_communities_asociation id_page="'.$id_parent.'"]');
        
        if ( shortcode_exists( 'idx_building_asociation' ) ) 
          echo do_shortcode('[idx_building_asociation id_page="'.$idneighboardhood.'"]');
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

<?php get_footer(); ?> 