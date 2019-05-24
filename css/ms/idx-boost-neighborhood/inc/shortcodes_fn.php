<?php

if (!function_exists('tgneigboardhood_script_collection')){
  function tgneigboardhood_script_collection(){   
      $flex_idx_info_neigh         = flex_idx_get_info_for_neighboardhood();
      wp_enqueue_script('google-maps-api', sprintf('//maps.googleapis.com/maps/api/js?key=%s', $flex_idx_info_neigh["agent"]["google_maps_api_key"] ));
      wp_enqueue_script('idxboost_neighboardhood_maps', NEIGHBORHOOD_IDX_URI . 'js/idxboost_load_maps.js' , NEIGHBORHOOD_IDX_VERSION, true );
      wp_enqueue_script('underscore', NEIGHBORHOOD_IDX_URI . 'js/underscore-min.js' , NEIGHBORHOOD_IDX_VERSION, true );
      wp_enqueue_script('infobox_packed-map', NEIGHBORHOOD_IDX_URI . 'js/infobox_packed.js' , NEIGHBORHOOD_IDX_VERSION, true );
      wp_enqueue_script('richkmarker-map', NEIGHBORHOOD_IDX_URI . 'js/richmarker-compiled.js' , NEIGHBORHOOD_IDX_VERSION, true );
      wp_enqueue_style( 'idx-neighboardhood-css', NEIGHBORHOOD_IDX_URI . 'css/neighborhoods.css', array(),NEIGHBORHOOD_IDX_VERSION );
      if ($GLOBALS['result_feed_neighborhoods_version']=='version2') {
        wp_enqueue_script('idx-neighborhood-js', NEIGHBORHOOD_IDX_URI . 'js/dgt-map-neighborhood_v2.js', NEIGHBORHOOD_IDX_VERSION, true );
      }else{
        wp_enqueue_script('idx-neighborhood-js', NEIGHBORHOOD_IDX_URI . 'js/dgt-map-neighborhood.js', NEIGHBORHOOD_IDX_VERSION, true );
      }
      wp_enqueue_script('google-maps-utility-library-infobox', NEIGHBORHOOD_IDX_URI . 'vendor/google-maps-utility-library/infobox_packed.js', array('google-maps-api'));
      wp_localize_script('idx-neighborhood-js', 'dgtCredential', array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'counter' => -1,
        'only_special' => true,
        'item_neighboardhood' => $GLOBALS['result_feed_neighborhoods_items'],
        'map_style' => $GLOBALS['map_style'],
        'map_zoom' => $GLOBALS['map_zoom'],
        'map_lat' => $GLOBALS['map_lat'],
        'map_color' => $GLOBALS['map_color'],
        'map_fillcolor' => $GLOBALS['map_fillcolor'],
        'map_lng' => $GLOBALS['map_lng']        
        ));     
    }
  }

if (!function_exists('sc_neighborhoods')){
  function sc_neighborhoods($atts) {
    global $wpdb;

        $atts = shortcode_atts(array(
           'map' => 'true',
           'counter' => -1,
           'only_special' => 'false',
           'view' => 'default',
           'item_map' => 'default',
           'group' => 'default',
           'title' => 'Neighborhoods',
           'sub_title' => 'default',
           'version' => 'default',
           'map_style' => 'default',
           'map_lat' => 'default',
           'map_lng' => 'default',
           'map_color' => '#ff334b',
           'map_fillcolor' => '#0072ac',
           'view_mobile' => 'default',
           'link_collection' => 'default',
           'map_zoom' => 'default'           
        ), $atts);

    $item_map=$atts['item_map'];

    $map = $atts['map'];
    $only_special = $atts['only_special'];    

    if ($only_special !='false') {
      $having_special_text=' having is_special=1';
    }

    $querygroup='';
    if ($atts['group'] !='default') {
      $querygroup="INNER JOIN {$wpdb->postmeta} dgt_group_neighborhood on dgt_group_neighborhood.post_id={$wpdb->posts}.ID and dgt_group_neighborhood.meta_key='dgt_group_neighborhood' and dgt_group_neighborhood.meta_value='".$atts['group']."'";
    }


    if ($item_map == 'all') {
        
        $query_map_all="SELECT ID,post_title,post_name,post_content,postme_lat.meta_value as lat,postme_lng.meta_value as lng, postme_geometry.meta_value as dgt_geometry,postme_link.meta_value as link_item
    FROM {$wpdb->posts} 
      left join {$wpdb->postmeta}  postme_lat on postme_lat.post_id={$wpdb->posts}.ID and postme_lat.meta_key='dgt_extra_lat'
      left join {$wpdb->postmeta} postme_lng on postme_lng.post_id={$wpdb->posts}.ID and postme_lng.meta_key='dgt_extra_lng'
      left join {$wpdb->postmeta} postme_geometry on postme_geometry.post_id={$wpdb->posts}.ID and postme_geometry.meta_key='dgt_map_geometry'
      left join {$wpdb->postmeta} postme_link on postme_link.post_id={$wpdb->posts}.ID and postme_link.meta_key='neighborhood_url'
      WHERE {$wpdb->posts}.post_type='".NEIGHBORHOOD_IDX_NAME."' and post_status='publish' order by menu_order,post_title asc;";

      $result_neigthboard = $wpdb->get_results($query_map_all, ARRAY_A);

    $query_item_having="SELECT ID,post_title,post_name,post_content,postme_link.meta_value as link_item,IFNULL(dgt_extra_special.meta_value, '0') as is_special, IFNULL(dgt_no_collection.meta_value, '0') as no_collection
    FROM {$wpdb->posts} 
      left join {$wpdb->postmeta} postme_link on postme_link.post_id={$wpdb->posts}.ID and postme_link.meta_key='neighborhood_url'
      left join {$wpdb->postmeta} dgt_extra_special on dgt_extra_special.post_id={$wpdb->posts}.ID and dgt_extra_special.meta_key='dgt_extra_special'
      left join {$wpdb->postmeta} dgt_no_collection on dgt_no_collection.post_id={$wpdb->posts}.ID and dgt_no_collection.meta_key='dgt_no_collection'
      ".$querygroup." 
    WHERE {$wpdb->posts}.post_type='".NEIGHBORHOOD_IDX_NAME."' and post_status='publish' ".$having_special_text." order by menu_order,post_title asc;";

      
    }else if ($item_map == 'default') {
      
    $query_neigthboard="SELECT ID,post_title,post_name,post_content,postme_lat.meta_value as lat,postme_lng.meta_value as lng, postme_geometry.meta_value as dgt_geometry,postme_link.meta_value as link_item,IFNULL(dgt_extra_special.meta_value, '0') as is_special, IFNULL(dgt_no_collection.meta_value, '0') as no_collection
    FROM {$wpdb->posts} 
      left join {$wpdb->postmeta}  postme_lat on postme_lat.post_id={$wpdb->posts}.ID and postme_lat.meta_key='dgt_extra_lat'
      left join {$wpdb->postmeta} postme_lng on postme_lng.post_id={$wpdb->posts}.ID and postme_lng.meta_key='dgt_extra_lng'
      left join {$wpdb->postmeta} postme_geometry on postme_geometry.post_id={$wpdb->posts}.ID and postme_geometry.meta_key='dgt_map_geometry'
      left join {$wpdb->postmeta} postme_link on postme_link.post_id={$wpdb->posts}.ID and postme_link.meta_key='neighborhood_url'
      left join {$wpdb->postmeta} dgt_extra_special on dgt_extra_special.post_id={$wpdb->posts}.ID and dgt_extra_special.meta_key='dgt_extra_special'
      left join {$wpdb->postmeta} dgt_no_collection on dgt_no_collection.post_id={$wpdb->posts}.ID and dgt_no_collection.meta_key='dgt_no_collection'
      ".$querygroup." 
    WHERE {$wpdb->posts}.post_type='".NEIGHBORHOOD_IDX_NAME."' and post_status='publish' ".$having_special_text." order by menu_order,post_title asc;";

    $result_neigthboard = $wpdb->get_results($query_neigthboard, ARRAY_A);

    }

    $neighborhoods_items=[];

    foreach ($result_neigthboard as $value_neigh) {
      $geocode=$value_neigh['dgt_geometry'];
        parse_str($geocode, $geometry);

        $geometry_lat=''; $geometry_lng='';

        if (array_key_exists('lat', $geometry)) {
          $geometry_lat=$geometry['lat'];
        }

        if (array_key_exists('lng', $geometry)) {
          $geometry_lng=$geometry['lng'];
        }

        $neighborhoods_items[]=array(
          'ID' =>$value_neigh['ID'],
          'lat' =>$value_neigh['lat'],
          'lng' =>$value_neigh['lng'],
          'post_content' =>$value_neigh['post_content'],
          'name' =>$value_neigh['post_title'],
          'url' =>$value_neigh['link_item'],
          'geometry' =>$geometry['geometry'],
          'geometry_lat' => $geometry_lat,          
          'geometry_lng' =>$geometry_lng
         );
    }

    if($map) {
      $GLOBALS['result_feed_neighborhoods_items']=$neighborhoods_items;
      $GLOBALS['result_feed_neighborhoods_version']= $atts['version'];
      $GLOBALS['map_zoom'] = $atts['map_zoom'];
      $GLOBALS['map_style'] = $atts['map_style'];
      $GLOBALS['map_lat'] = $atts['map_lat'];
      $GLOBALS['map_lng'] = $atts['map_lng'];      
      $GLOBALS['map_color'] = $atts['map_color'];
      $GLOBALS['map_fillcolor'] = $atts['map_fillcolor'];
      add_action('wp_footer', 'tgneigboardhood_script_collection');
    }

    if ($item_map == 'all'){
      $result_neigthboard = $wpdb->get_results($query_item_having, ARRAY_A);
    }

    ob_start();
    if ($atts['view']=='list') { 
      require NEIGHBORHOOD_IDX_PATH . '/views/shortcode/tgneigboardhood_detail_list.php'; 
    }else if($atts['view']=='map_list_thumbs') { 
      include NEIGHBORHOOD_IDX_PATH . '/views/shortcode/idxboost_group_map_list_thumbs.php'; 
    }else if ($atts['view']=='list_simple') { 
      require NEIGHBORHOOD_IDX_PATH . '/views/shortcode/neighboard_list_simple.php';
    } else{ 
      require NEIGHBORHOOD_IDX_PATH . '/views/shortcode/sc_neighborhoods.php'; 
    }

    $output = ob_get_clean();   
    return $output;
  }
  add_shortcode('IDX_NEIGHBORHOODS', 'sc_neighborhoods' );
}


if (!function_exists('idx_neighboardhood_group_fr')){
  function idx_neighboardhood_group_fr($atts) {
    global $wpdb;
        $atts = shortcode_atts(array(
            'link'   => '#',
            'limit'   => 'default',
            'mode'   => 'default',
            'query_featured'   => '1',
        ), $atts);

        $text_featured="
          SELECT ID,post_title,post_name, IFNULL({$wpdb->postmeta}.meta_value, '0') as meta_value_especial, wp_postmeta_link.meta_value as link_neighboardhood,dgt_map_geometry.meta_value as geometry
          FROM {$wpdb->posts} 
          left join {$wpdb->postmeta} on {$wpdb->postmeta}.post_id={$wpdb->posts}.ID and {$wpdb->postmeta}.meta_key='dgt_extra_special' 
          LEFT JOIN {$wpdb->postmeta} as wp_postmeta_link on wp_postmeta_link.meta_key='neighborhood_url' and wp_postmeta_link.post_id={$wpdb->posts}.ID 
          left join {$wpdb->postmeta} as dgt_map_geometry on dgt_map_geometry.post_id={$wpdb->posts}.ID and dgt_map_geometry.meta_key='dgt_map_geometry'           
        WHERE {$wpdb->posts}.post_type in('tgneighborhood','neighborhood') and post_status='publish' having meta_value_especial={$atts['query_featured']} order by menu_order,post_title asc  ;";
     
        $list_pages_neighboardhood = $wpdb->get_results($text_featured, ARRAY_A);

        if ($atts['mode']=='default') {
          include NEIGHBORHOOD_IDX_PATH . '/views/shortcode/idxboost_neighboardhood_group.php';
        }else if($atts['mode']=='map_thumbs') {
          include NEIGHBORHOOD_IDX_PATH . '/views/shortcode/idxboost_group_map_thumbs.php';
        }       
      //$list_pages_inventory = implode(', ', array_map(function($pag) { return $pag['ID']; }, $list_pages_buildings));
    ob_start();
    $output = ob_get_clean();   
    return $output;
  }
  add_shortcode('tg_neighboardhood_group', 'idx_neighboardhood_group_fr' );
}

if (!function_exists('idx_neighboardhood_group_building_fr')){
  function idx_neighboardhood_group_building_fr($atts) {
    global $wpdb;
        $atts = shortcode_atts(array(
            'view'   => 'default',
            'limit'   => 'default',
            'query_featured'   => '1',
        ), $atts);

        wp_enqueue_script('jquery-min-lib', NEIGHBORHOOD_IDX_URI . 'js/jquery-3.3.1.min.js' , NEIGHBORHOOD_IDX_VERSION, true );
        wp_enqueue_script('greatslider_jquery', NEIGHBORHOOD_IDX_URI . 'js/greatslider.jquery.min.js' , NEIGHBORHOOD_IDX_VERSION, true );
        wp_enqueue_script('neighborhood_explorer_main', NEIGHBORHOOD_IDX_URI . 'js/main.js' , NEIGHBORHOOD_IDX_VERSION, true );

        $text_featured="SELECT ID,post_title,post_name, IFNULL(wp_postmeta_luxe.meta_value, '0') as meta_value_especial FROM {$wpdb->posts} 
          left join {$wpdb->postmeta} as wp_postmeta_luxe on wp_postmeta_luxe.post_id={$wpdb->posts}.ID and wp_postmeta_luxe.meta_key='dgt_extra_luxe' 
        WHERE {$wpdb->posts}.post_type in('tgneighborhood','neighborhood') and post_status='publish' having meta_value_especial={$atts['query_featured']} order by menu_order,post_title asc  ;";
     
        $list_pages_neighboardhood = $wpdb->get_results($text_featured, ARRAY_A);
        if ($atts['view']=='menu') {
          include NEIGHBORHOOD_IDX_PATH . '/views/shortcode/neighboard_building_menu.php';
        }else{
          include NEIGHBORHOOD_IDX_PATH . '/views/shortcode/neighboard_building_group.php';
        }
       
      //$list_pages_inventory = implode(', ', array_map(function($pag) { return $pag['ID']; }, $list_pages_buildings));
    ob_start();
    $output = ob_get_clean();   
    return $output;
  }
  add_shortcode('tg_neighboardhood_group_building', 'idx_neighboardhood_group_building_fr' );
}

if (!function_exists('idx_news_to_neighborhood')){
  function idx_news_to_neighborhood($atts) {
  global $wpdb; 
  $atts = shortcode_atts(array('id_neighborhood' => '0'), $atts);
  $query_search='"'.$atts['id_neighborhood'].'"';
  $idx_noticias = $wpdb->get_results("
    SELECT post.ID,post.post_title,post.post_name 
    FROM {$wpdb->postmeta} meta
    inner join {$wpdb->posts} post on post.ID=meta.post_id
   where meta.meta_key='idx_news_neighborhood' and meta.meta_value like '%".$query_search."%' limit 6;", ARRAY_A);   

  $idx_noticias_trending = $wpdb->get_results("
    SELECT post.ID,post.post_title,post.post_name 
    FROM {$wpdb->postmeta} meta
    inner join {$wpdb->posts} post on post.ID=meta.post_id
   where meta.meta_key='idx_news_neighborhood_trend' and meta.meta_value like '%".$query_search."%' order by post.post_date desc limit 5;", ARRAY_A);     

  $idx_noticias_market = $wpdb->get_results("
    SELECT post.ID,post.post_title,post.post_name 
    FROM {$wpdb->postmeta} meta
    inner join {$wpdb->posts} post on post.ID=meta.post_id
   where meta.meta_key='idx_news_neighborhood_market' and meta.meta_value like '%".$query_search."%' order by post.post_date desc limit 5;", ARRAY_A);       
  
    
  if (empty($idx_noticias) || !is_array($idx_noticias)) {
    return false;
  }

  require NEIGHBORHOOD_IDX_PATH . '/views/shortcode/idx_news_to_post.php';

    
  $output = ob_get_clean();   
  return $output;

  }
    add_shortcode('sc_news_to_neighborhood', 'idx_news_to_neighborhood' );
}