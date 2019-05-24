<?php

if (!function_exists('sc_buildings_maps')):
  function sc_buildings_maps($atts) {
    extract(shortcode_atts(array( 'map' => 'true', 'counter' => -1, 'only_special' => 'false'), $atts ));

    $map = $map === 'true'? true: false;
    $only_special = $only_special === 'true'? true: false;

    $query_arr = array(
      'post_type' => BUILDINGS_IDX_NAME,
      'orderby' => 'date',
      'order' => 'DESC',
      'posts_per_page' => $counter
      );

    if($only_special == true) {
      $query_arr['meta_query'] = array(
        array(
          'key'     => DGTIDX_PREFIX_BUILDINGS . '_extra_special',
          'value'   => 1,
          ),
        );
    }

    $neighborhoods = new WP_Query( $query_arr );

    if($map) {
      // Flex idx Contact - temporal carga de js
      wp_enqueue_script('google-maps-api', sprintf('//maps.googleapis.com/maps/api/js?key=%s', BUILDINGS_GOOGLE_MAP_KEY));
      wp_enqueue_script('idxboost_communities_maps', BUILDINGS_IDX_URI . 'js/idxboost_load_maps.js' , BUILDINGS_IDX_VERSION, true );
      wp_enqueue_script('underscore', BUILDINGS_IDX_URI . 'js/underscore-min.js', BUILDINGS_IDX_VERSION, true );
      wp_enqueue_style( 'idx-buildings-css', BUILDINGS_IDX_URI . 'css/area-idx.css', array(), BUILDINGS_IDX_VERSION );
      wp_enqueue_script('infobox_packed-map', BUILDINGS_IDX_URI . 'js/infobox_packed.js' ,  BUILDINGS_IDX_VERSION, true );
      wp_enqueue_script('richkmarker-map', BUILDINGS_IDX_URI . 'js/richmarker-compiled.js' ,  BUILDINGS_IDX_VERSION, true );
      wp_enqueue_script('infobubble-compiled', BUILDINGS_IDX_URI . 'js/infobubble-compiled.js' ,  BUILDINGS_IDX_VERSION, true );
      wp_enqueue_script('idx-buildings-js', BUILDINGS_IDX_URI . 'js/dgt-map-buildings.js',  BUILDINGS_IDX_VERSION, true );
      wp_enqueue_script('google-maps-utility-library-infobox', BUILDINGS_IDX_URI . 'vendor/google-maps-utility-library/infobox_packed.js', array('google-maps-api'));

      wp_localize_script('idx-buildings-js', 'dgtCredential', array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'counter' => $counter,
        'only_special' => $only_special
        ));
    }
    ob_start();
    require BUILDINGS_IDX_PATH . '/views/shortcode/sc_buildings.php';
    $output = ob_get_clean();   
    return $output;
  }
  add_shortcode('IDX_BUILDINGS_MAPS', 'sc_buildings_maps' );
endif;


if (!function_exists('order_by_neighborhood_building')) {
  function order_by_neighborhood_building($a, $b)
  {
      return strcmp($a["neighborhood"], $b["neighborhood"]);
  }
}

if (!function_exists('sc_list_buildings_script_search')){
  function sc_list_buildings_script_search() {
      wp_enqueue_script('jquery-building-ui-js', BUILDINGS_IDX_URI . 'js/jquery_ui.js', BUILDINGS_IDX_VERSION, true );
      wp_enqueue_script('idx-list-script', BUILDINGS_IDX_URI . 'js/list-script.js', BUILDINGS_IDX_VERSION, true );
      wp_enqueue_style( 'idx-list-buildings-css', BUILDINGS_IDX_URI . 'css/list-new-condo-list.css', array(), BUILDINGS_IDX_VERSION );          
      wp_enqueue_script('underscore-mixins');
      wp_enqueue_script('flex-lazyload-plugin');
      wp_enqueue_script('idx-list-buildings-search-js', BUILDINGS_IDX_URI . 'js/idx-list-buildings-search.js',  BUILDINGS_IDX_VERSION, true );
      //wp_enqueue_script('idx-buildings-search-js', BUILDINGS_IDX_URI . 'js/idxboost_building_search.js',  BUILDINGS_IDX_VERSION, true );      
      wp_localize_script('idx-list-buildings-search-js', 'idxboostConf', array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'ItemSearchResult' => $GLOBALS['result_feed_decode'],
        ));      
    }
  }

if (!function_exists('sc_buildings_script_search')){
  function sc_buildings_script_search() {
    global $flex_idx_info;
      wp_enqueue_style( 'idx-buildings-css', BUILDINGS_IDX_URI . 'css/area-idx.css', array(), BUILDINGS_IDX_VERSION );
      wp_enqueue_style( 'idx-buildings-info-css', BUILDINGS_IDX_URI . 'css/infowindows.css', array(), BUILDINGS_IDX_VERSION );
      wp_enqueue_style( 'idx-buildings-style-css', BUILDINGS_IDX_URI . 'css/luxury-condos.css', array(), BUILDINGS_IDX_VERSION );
      wp_enqueue_script('google-maps-api', sprintf('//maps.googleapis.com/maps/api/js?key=%s', $flex_idx_info["agent"]["google_maps_api_key"]));
      wp_enqueue_script('underscore', BUILDINGS_IDX_URI . 'js/underscore-min.js', BUILDINGS_IDX_VERSION, true );
      wp_enqueue_script('jquery-building-ui-js', BUILDINGS_IDX_URI . 'js/jquery_ui.js', BUILDINGS_IDX_VERSION, true );
      wp_enqueue_script('flex-lazyload-plugin');
      wp_enqueue_script('infobox_packed-map', BUILDINGS_IDX_URI . 'js/infobox_packed.js' ,  BUILDINGS_IDX_VERSION, true );
      wp_enqueue_script('richkmarker-map', BUILDINGS_IDX_URI . 'js/richmarker-compiled.js' ,  BUILDINGS_IDX_VERSION, true );
      wp_enqueue_script('infobubble-compiled', BUILDINGS_IDX_URI . 'js/infobubble-compiled.js' ,  BUILDINGS_IDX_VERSION, true );
      wp_enqueue_script('idx-buildings-search-js', BUILDINGS_IDX_URI . 'js/idxboost_building_search.js',  BUILDINGS_IDX_VERSION, true );
      #wp_enqueue_script('idx-scroll-building-js', BUILDINGS_IDX_URI . 'js/perfect-scrollbar.jquery.min.js',  BUILDINGS_IDX_VERSION, true );
      wp_enqueue_script('google-maps-utility-library-infobox', BUILDINGS_IDX_URI . 'vendor/google-maps-utility-library/infobox_packed.js', array('google-maps-api'));
      wp_localize_script('idx-buildings-search-js', 'idxboostConf', array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'ItemSearchResult' => $GLOBALS['result_feed_decode'],
        'idxboost_labels' => $GLOBALS['idxboost_labels'],
        'idxboost_neigboardhood' => $GLOBALS['result_neigthboard'],
        'idxboost_lat'=>  $GLOBALS['idxboost_lat'],
        'idxboost_lng' => $GLOBALS['idxboost_lng'],
        'idxboost_zoom' => $GLOBALS['idxboost_zoom']
        ));      
    }
  }

if (!function_exists('sc_buildings_search')):
  function sc_buildings_search($atts) {
  global $wpdb; 
      $path_feed = BUILDINGS_IDX_PATH.'feed/';
      $post_building=$path_feed.'condos.json';        
      $result_feed=file_get_contents($post_building);
      $result_feed_decode=json_decode(file_get_contents($post_building),true);
      $GLOBALS['result_feed_decode']=$result_feed_decode;

        $atts = shortcode_atts(array(
            'view'   => 'list',
            'area'   => 'all',
            'labels'   => 'default',
            'hide_category'   => 'yes',
            'lat'   => 'default',
            'lng'   => 'default',
            'zoom'   => 'default',
            'category' => 'all',
        ), $atts);

    
    $display_cat='';

    if ($atts['hide_category']=='yes') {
      $display_cat='style="display:none"';
    }

    $GLOBALS['idxboost_zoom']=$atts['zoom'];
    $GLOBALS['idxboost_lat']=$atts['lat'];
    $GLOBALS['idxboost_lng']=$atts['lng'];
    $GLOBALS['idxboost_labels']=$atts['labels'];    
    $neighborhood_loop=[];
    $categorys_loop_temp=[];
    foreach ($result_feed_decode['result'] as $value_neight) {
      $neighborhood_id=0;
      $neighborhood_text='';

      if (!empty($value_neight['neighborhood'])){
        $neighborhood_id=$value_neight['neighborhood_id'];
        $neighborhood_text=$value_neight['neighborhood'];
      }

        $exist_neig_in_collection=array_search($neighborhood_id, array_column($neighborhood_loop, 'id'));
        if (!is_numeric($exist_neig_in_collection)) {
          $neighborhood_loop[]= array('id' => $neighborhood_id, 'name' => $neighborhood_text );
        }
        
        $categorys_loop_temp[$value_neight['type_category_id']]= $value_neight['type_category'];
    }

    $list_neig_actives=implode(',',array_column($neighborhood_loop,'id') );

    $query_neigthboard="SELECT ID,post_title,postme_geometry.meta_value as geometry FROM {$wpdb->posts} left join {$wpdb->postmeta} postme_geometry on postme_geometry.post_id={$wpdb->posts}.ID and postme_geometry.meta_key='dgt_map_geometry' WHERE {$wpdb->posts}.post_type='".NEIGHBORHOOD_IDX_NAME."' and post_status='publish' AND ID in(".$list_neig_actives.") order by post_title asc;";
    $result_neigthboard = $wpdb->get_results($query_neigthboard, ARRAY_A);

    $neighborhoods_items=[];

    foreach ($result_neigthboard as $value_neigh) {
      $geocode=$value_neigh['geometry'];
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
          'name' =>$value_neigh['post_title'],
          'zoom' =>$geometry['zoom'],
          'geometry' =>$geometry['geometry'],
          'geometry_lat' => $geometry_lat,          
          'geometry_lng' =>$geometry_lng
         );
    }

    $GLOBALS['result_neigthboard']=$neighborhoods_items;

    $categorys_loop = $wpdb->get_results("SELECT {$wpdb->terms}.name,{$wpdb->terms}.slug,{$wpdb->terms}.term_id FROM {$wpdb->term_taxonomy} INNER JOIN {$wpdb->terms} ON {$wpdb->terms}.term_id={$wpdb->term_taxonomy}.term_id AND {$wpdb->term_taxonomy}.taxonomy='category_building';");   

    add_action('wp_footer', 'sc_buildings_script_search');

    ob_start();
    //get_template_part(BUILDINGS_IDX_PATH . '/views/shortcode/collection_building_search.php');
    require BUILDINGS_IDX_PATH . '/views/shortcode/sc_buildings_search.php';
    
    $output = ob_get_clean();   
    return $output;
  }
  add_shortcode('idx_building_search', 'sc_buildings_search' );
endif;


if (!function_exists('sc_buildings_list_search')){
  function sc_buildings_list_search($atts) {
  global $wpdb; 
      $path_feed = BUILDINGS_IDX_PATH.'feed/';
      $post_building=$path_feed.'list_condos.json';        
      $result_feed=file_get_contents($post_building);
      $result_feed_decode=json_decode(file_get_contents($post_building),true);
      $GLOBALS['result_feed_decode']=$result_feed_decode;

        $atts = shortcode_atts(array(
            'view'   => 'grid',
            'area'   => 'all',
            'category' => 'all',
        ), $atts);
    
    $neighborhood_loop=[];
    $categorys_loop_temp=[];
    foreach ($result_feed_decode['result'] as $value_neight) {
      $neighborhood_id=0;
      $neighborhood_text='';

      if (!empty($value_neight['neighborhood'])){
        $neighborhood_id=$value_neight['neighborhood_id'];
        $neighborhood_text=$value_neight['neighborhood'];
      }
        $neighborhood_loop[$neighborhood_id]= $neighborhood_text;
      $categorys_loop_temp[$value_neight['type_category_id']]= $value_neight['type_category'];
    }

    add_action('wp_footer', 'sc_list_buildings_script_search');

    ob_start();
    //get_template_part(BUILDINGS_IDX_PATH . '/views/shortcode/collection_building_search.php');
    require BUILDINGS_IDX_PATH . '/views/shortcode/idxboost_list_condos.php';
    
    $output = ob_get_clean();   
    return $output;
  }
  add_shortcode('buildings_list_search', 'sc_buildings_list_search' );
}


if (!function_exists('idx_buildings_asociation_fr')){
  function idx_buildings_asociation_fr($atts) {
    global $wpdb;
        $atts = shortcode_atts(array(
            'id_page'   => '0'
        ), $atts);

      if (!empty($atts['id_page']) && $atts['id_page'] !=0) {
        $list_pages_buildings = $wpdb->get_results("SELECT post.ID,post.post_title,year.meta_value as year,units.meta_value as units FROM {$wpdb->posts} as post
          INNER JOIN {$wpdb->postmeta} as relation on post.ID=relation.post_id 
          LEFT JOIN {$wpdb->postmeta} as year on post.ID=year.post_id  and  year.meta_key='dgt_year_building'
          LEFT JOIN {$wpdb->postmeta} as units on post.ID=units.post_id  and  units.meta_key='dgt_extra_unit'
          WHERE relation.meta_key='dgt_tgid_neighnorhood' and relation.meta_value={$atts['id_page']} and post.post_type='tgbuilding' order by post_title asc limit 5;", ARRAY_A);
        include BUILDINGS_IDX_PATH . '/views/shortcode/sc_buildings_asociation.php';      
      }
      
      //$list_pages_inventory = implode(', ', array_map(function($pag) { return $pag['ID']; }, $list_pages_buildings));
    ob_start();
    $output = ob_get_clean();   
    return $output;
  }
  add_shortcode('idx_building_asociation', 'idx_buildings_asociation_fr' );
}


if (!function_exists('idx_buildings_featured_fr')){
  function idx_buildings_featured_fr($atts) {
    global $wpdb;
        $atts = shortcode_atts(array(
            'title'   => 'Featured',
            'limit'   => 'default',
            'mode'   => 'default',
            'slider_item_large'   => "3",
            'slider_item_medium'   => "3",
            'slider_item_mobile'   => "2",
            'link'   => '#',
        ), $atts);

      if ($atts['limit']=='default') {
        $text_limit='';
      }else{
        $text_limit='limit '.$atts['limit'];
      }

        $list_pages_buildings = $wpdb->get_results("
          SELECT {$wpdb->posts}.ID,{$wpdb->posts}.post_title,{$wpdb->posts}.post_name, wp_postmeta_link.meta_value as link_building FROM {$wpdb->posts} 
            INNER join {$wpdb->postmeta} as wp_postmeta_special on wp_postmeta_special.post_id={$wpdb->posts}.ID  and wp_postmeta_special.meta_key='dgt_extra_special' and wp_postmeta_special.meta_value='1' 
            LEFT JOIN {$wpdb->postmeta} as wp_postmeta_link on wp_postmeta_link.meta_key='tgbuilding_url' and wp_postmeta_link.post_id={$wpdb->posts}.ID 
          where post_type='tgbuilding' and post_status='publish' order by post_title asc {$text_limit} ; ", ARRAY_A);

      if ($atts['mode']=='default'){
       include BUILDINGS_IDX_PATH . '/views/shortcode/idxboost_building_featured.php';       
      }else if ($atts['mode']=='slider') {
        wp_enqueue_style('flex-idx-filter-pages-css');

        wp_localize_script('sweetalert-js', 'idx_develop_slider_item_large', $atts['slider_item_large'] );
        wp_localize_script('sweetalert-js', 'idx_develop_slider_item_medium', $atts['slider_item_medium'] );
        wp_localize_script('sweetalert-js', 'idx_develop_slider_item_mobile', $atts['slider_item_mobile'] );
        wp_enqueue_script('flex-idx-filter-js');

        include BUILDINGS_IDX_PATH . '/views/shortcode/idxboost_building_slider.php';       
      }
       ob_start();
    $output = ob_get_clean();   
    return $output;
  }
  add_shortcode('idx_buildings_featured', 'idx_buildings_featured_fr' );
}



if (!function_exists('idx_buildings_type_fr')){
  function idx_buildings_type_fr($atts) {
    global $wpdb;
        $atts = shortcode_atts(array(
            'title'   => 'Featured',
            'limit'   => 'default',
            'query_featured'   => '1',
        ), $atts);

        $text_featured="
        SELECT ID,post_title,post_name, IFNULL({$wpdb->postmeta}.meta_value, '0') as meta_value_especial, wp_postmeta_link.meta_value as link_building
          FROM {$wpdb->posts} 
          left join {$wpdb->postmeta} on {$wpdb->postmeta}.post_id={$wpdb->posts}.ID and {$wpdb->postmeta}.meta_key='dgt_extra_special' 
          LEFT JOIN {$wpdb->postmeta} as wp_postmeta_link on wp_postmeta_link.meta_key='tgbuilding_url' and wp_postmeta_link.post_id={$wpdb->posts}.ID 
        WHERE {$wpdb->posts}.post_type='tgbuilding' and post_status='publish' having meta_value_especial={$atts['query_featured']} order by post_title asc  ;";
      
        $list_pages_buildings = $wpdb->get_results($text_featured, ARRAY_A);

       include BUILDINGS_IDX_PATH . '/views/shortcode/idxboost_building_type.php';      
      //$list_pages_inventory = implode(', ', array_map(function($pag) { return $pag['ID']; }, $list_pages_buildings));
    ob_start();
    $output = ob_get_clean();   
    return $output;
  }
  add_shortcode('idx_buildings_type', 'idx_buildings_type_fr' );
}

if (!function_exists('idx_buildings_relacion_neigth_fr')){
  function idx_buildings_relacion_neigth_fr($atts) {
    global $wpdb;
    $path_feed = BUILDINGS_IDX_PATH.'feed/';
        $atts = shortcode_atts(array(
            'title'   => 'Featured',
            'limit'   => 'default',
            'mode'    => 'default',
            'query_featured'   => 'default',
        ), $atts);

        $query_featured='';

        if ($atts['query_featured']=='1') {
          //$query_featured=" and {$wpdb->postmeta}.meta_key='dgt_extra_special' AND {$wpdb->postmeta}.meta_value='1' ";
        }
        $list_pages_neighnorhood = [];
        $post_building=$path_feed.'condos_neigh_building.json';

        if (!array_key_exists('result_list_neig', $GLOBALS)) {
            $date_now=date_create(date("Y-m-d H:i:s"));
            $date_file=date_create(date("Y-m-d H:i:s"));
            if (file_exists($post_building))
              $date_file=date_create(date("Y-m-d H:i:s", filemtime($post_building) ));
            $diff_file=date_diff($date_now,$date_file);

            if (!file_exists($post_building)) {
                idxboost_cache_relation_building_neighboard_xhr_fn();
            }else{
                if ($diff_file->format("%a")>0) {
                    idxboost_cache_relation_building_neighboard_xhr_fn();
                }
            }

            if (file_exists($post_building)) {
              $result_feed_decode=json_decode(file_get_contents($post_building),true);
              $GLOBALS['result_neigh_building']=$result_feed_decode;                  

              $list_pages_buildings=$GLOBALS['result_neigh_building'];
              $list_pages_neighnorhood=array_unique( array_map(function($pag) { return $pag['neighnorhood']; }, $list_pages_buildings ) ) ;
              $GLOBALS['result_list_neig']=$list_pages_neighnorhood;
              wp_localize_script('flex-auth-check', 'items_relation_neig_building', $GLOBALS['result_neigh_building'] );
            }

        }else{
          $list_pages_buildings=$GLOBALS['result_neigh_building'];
          $list_pages_neighnorhood=$GLOBALS['result_list_neig']; 
        }

        usort($list_pages_neighnorhood,'order_by_title_neightboardhood');

        if ($atts['mode']=='mobile') {
          include BUILDINGS_IDX_PATH . '/views/shortcode/idx_neighboardhood_building_mobile.php';
        }else{
          include BUILDINGS_IDX_PATH . '/views/shortcode/idxboost_condo_relacion_neigthboar.php';      
        }

    ob_start();
    $output = ob_get_clean();   
    return $output;
  }
  add_shortcode('idx_buildings_neightboardhood', 'idx_buildings_relacion_neigth_fr' );
}


if (!function_exists('order_by_title_neightboardhood_with_key')) {
  function order_by_title_neightboardhood_with_key($a, $b)
  {
    if (empty($a['name']))  return 1;   
    if (empty($b['name']))  return -1;

    if ($a['name'] == $b['name']) {
        return 0;
    }
    return ($a['name'] < $b['name']) ? -1 : 1;

  }
}

if (!function_exists('order_by_title_neightboardhood')) {
  function order_by_title_neightboardhood($a, $b)
  {
      return strcmp($a, $b);
  }
}


/*idx_building_autocomplete*/

if (!function_exists('sc_building_script_autocomplete')){
  function sc_building_script_autocomplete() {
      wp_enqueue_script('jquery-building-ui-js', BUILDINGS_IDX_URI . 'js/jquery_ui.js', BUILDINGS_IDX_VERSION, true );
      wp_enqueue_script('idx-buildings-autocomplete-js', BUILDINGS_IDX_URI . 'js/idxboost_building_autocomplete.js',  BUILDINGS_IDX_VERSION, true );
      wp_localize_script('idx-buildings-autocomplete-js', 'building_complete', array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'item' => $GLOBALS['result_feed_decode'],
        ));      
    }
  }

if (!function_exists('sc_idx_building_autocomplete')){
  function sc_idx_building_autocomplete($atts) {
  global $wpdb; 
      $path_feed = BUILDINGS_IDX_PATH.'feed/';
      $post_building=$path_feed.'condos.json';        
      $result_feed=file_get_contents($post_building);
      $result_feed_decode=json_decode(file_get_contents($post_building),true);
      $GLOBALS['result_feed_decode']=$result_feed_decode;

        $atts = shortcode_atts(array(
            'view'   => 'grid',
            'area'   => 'all',
            'labels'   => 'default',
            'category' => 'all',
        ), $atts);

    $GLOBALS['idxboost_labels']=$atts['labels'];    
    $neighborhood_loop=[];
    $categorys_loop_temp=[];
    foreach ($result_feed_decode['result'] as $value_neight) {
      $neighborhood_id=0;
      $neighborhood_text='';

      if (!empty($value_neight['neighborhood'])){
        $neighborhood_id=$value_neight['neighborhood_id'];
        $neighborhood_text=$value_neight['neighborhood'];
      }
        $neighborhood_loop[$neighborhood_id]= $neighborhood_text;
        //var_dump($result_neigthboard);
      $categorys_loop_temp[$value_neight['type_category_id']]= $value_neight['type_category'];
    }

    $categorys_loop = $wpdb->get_results("SELECT {$wpdb->terms}.name,{$wpdb->terms}.slug,{$wpdb->terms}.term_id FROM {$wpdb->term_taxonomy} INNER JOIN {$wpdb->terms} ON {$wpdb->terms}.term_id={$wpdb->term_taxonomy}.term_id AND {$wpdb->term_taxonomy}.taxonomy='category_building';");   

    add_action('wp_footer', 'sc_building_script_autocomplete');

    ob_start();
    //get_template_part(BUILDINGS_IDX_PATH . '/views/shortcode/collection_building_search.php');
    require BUILDINGS_IDX_PATH . '/views/shortcode/idx_building_autcomplete.php';
    
    $output = ob_get_clean();   
    return $output;
  }
  add_shortcode('idx_building_autocomplete', 'sc_idx_building_autocomplete' );
}
/*idx_building_autocomplete*/


if (!function_exists('idx_news_to_building')){
  function idx_news_to_building($atts) {
  global $wpdb; 
  $atts = shortcode_atts(array('id_building' => '0'), $atts);
  $query_search='"'.$atts['id_building'].'"';
  $idx_noticias = $wpdb->get_results("
    SELECT post.ID,post.post_title,post.post_name 
    FROM {$wpdb->postmeta} meta
    inner join {$wpdb->posts} post on post.ID=meta.post_id
   where meta.meta_key='idx_news_building' and meta.meta_value like '%".$query_search."%' limit 6;", ARRAY_A);   
  
  if (empty($idx_noticias) || !is_array($idx_noticias)) {
    return false;
  }

  require BUILDINGS_IDX_PATH . '/views/shortcode/idx_news_to_post.php';

    
  $output = ob_get_clean();   
  return $output;

  }
    add_shortcode('sc_news_to_building', 'idx_news_to_building' );
}