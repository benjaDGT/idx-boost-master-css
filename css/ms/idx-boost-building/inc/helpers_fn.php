<?php
if (!function_exists('buildings_admin_register_assets')) {
    function buildings_admin_register_assets()
    {   
        wp_enqueue_style( 'idx-buildings-admin-css', BUILDINGS_IDX_URI . 'css/admin_buildings.css', array(), BUILDINGS_IDX_VERSION );
        //wp_enqueue_script( 'google-maps-js', 'https://maps.googleapis.com/maps/api/js?v=3&libraries=drawing&key=' . BUILDINGS_GOOGLE_MAP_KEY, array('jquery'), BUILDINGS_IDX_VERSION, true );
        //wp_enqueue_script( 'infobox-packed-js', BUILDINGS_IDX_URI . 'js/infobox_packed.js', array('jquery'), BUILDINGS_IDX_VERSION, true );
        wp_enqueue_script( 'building-gmap-draw-js', BUILDINGS_IDX_URI . 'js/jquery.gmap-draw.js', array('jquery'), BUILDINGS_IDX_VERSION, true );
        wp_enqueue_script( 'GDouglasPeuker-js', BUILDINGS_IDX_URI . 'js/GDouglasPeuker.js', array('jquery'), BUILDINGS_IDX_VERSION, true );
        wp_enqueue_script( 'idx-buildings-admin-js', BUILDINGS_IDX_URI . 'js/admin_buildings.js', array('jquery'), BUILDINGS_IDX_VERSION, true );
        wp_localize_script('idx-buildings-admin-js', 'dgtCredential', array('ajaxUrl' => admin_url('admin-ajax.php')));
    }
}

if(!function_exists('dgt_get_geocode_buildings_fn')) {
    function dgt_get_geocode_buildings_fn() {
        global $flex_idx_info;
        $address='';
        if (!empty( $flex_idx_info["agent"]["google_maps_api_key"] ))
            $idx_social_mediamaps  = $flex_idx_info["agent"]["google_maps_api_key"];

        if (!empty($_POST['address'])) {
            $address = $_POST['address'];
        }
        $address = str_replace(' ', '+', $address);
        $url_service = sprintf('https://maps.googleapis.com/maps/api/geocode/json?address=%s&key=%s', $address, $idx_social_mediamaps);
        $geocode = file_get_contents($url_service);
        $output= json_decode($geocode);
        
        if(is_array($output->results) && count($output->results)) {
            $latitude = $output->results[0]->geometry->location->lat;
            $longitude = $output->results[0]->geometry->location->lng;
        } else {
            $message = sprintf('%s %s to key %s', $output->status, $output->error_message, GOOGLE_API_KEY);
        }
        $response = ($latitude > 0)? array('status' => 'ok', 'lat' => $latitude, 'lng' => $longitude) :  array('status' => 'fail', 'message' => $message);
        echo wp_send_json($response);
    }
}

if (!function_exists('tgbuilding_pages_admin_columns_head')) {
    function tgbuilding_pages_admin_columns_head($defaults)
    {
        unset($defaults['date']);

        $defaults['neighborhood'] = 'Neighborhood';
        $defaults['community'] = 'Community';
        $defaults['category']        = 'Category';
        $defaults['date']        = 'Date';

        return $defaults;
    }

    add_filter('manage_tgbuilding_posts_columns', 'tgbuilding_pages_admin_columns_head', 10);
}

if (!function_exists('tgbuilding_pages_admin_columns_content')) {
    function tgbuilding_pages_admin_columns_content($column_name, $post_ID)
    {
      global $wpdb;
        switch ($column_name) {
            case 'neighborhood':
                $flex_building_page_id = get_post_meta($post_ID, 'dgt_tgid_neighnorhood', true);
                //NEIGHTBOARDHOOD
                $buildings_loop_tgid_neighnorhood = $wpdb->get_row("SELECT ID,post_title FROM {$wpdb->posts} where post_type in('neighborhood','tgneighborhood') and ID = '".$flex_building_page_id."';", ARRAY_A);
                echo $buildings_loop_tgid_neighnorhood['post_title'];
          break;
            case 'community':
                $flex_building_page_id = get_post_meta($post_ID, 'dgt_tgid_community', true);
                //COMMUITIES
                $buildings_loop_tgid_community = $wpdb->get_row("SELECT ID,post_title FROM {$wpdb->posts} where post_type in('communities','tgcommunities') and ID = '".$flex_building_page_id."';", ARRAY_A);
                echo $buildings_loop_tgid_community['post_title'];
                break;
            case 'category':
                  $termCateg=get_the_terms($post_ID,'category_building');
                  $name_neight='';
                  if ($termCateg != false) {
                      if(array_key_exists(0, $termCateg)) {
                        $name_neight=$termCateg[0]->name;
                      }
                  }
                echo $name_neight;
                break;                                
        }
    }
    add_action('manage_tgbuilding_posts_custom_column', 'tgbuilding_pages_admin_columns_content', 10, 2);
}


if(!function_exists('dgt_search_buildings_fn')) {
    function dgt_search_buildings_fn() {
  global $wpdb; 
  $type_search='all';
  $neighborhood_select='';
  $condos_select='';
  $response=[];
  $building_list=[];
  $response_data=[];
  $response['success']=false;
  $building_text_query='';  
  $metodo='any';
/*FORM DATA POST*/
        if (!empty($_POST['neighborhood_select'])) $neighborhood_select = $_POST['neighborhood_select'];
        if (!empty($_POST['condos_select'])) $condos_select = $_POST['condos_select'];
        if (!empty($_POST['type_search'])) $type_search = $_POST['type_search'];
/*FORM DATA POST*/
        if ($condos_select==0 && $neighborhood_select=='all' && $type_search=='all') {
            $metodo='all';
            $buildings_loop = $wpdb->get_results("SELECT ID,post_title,post_content,post_excerpt FROM {$wpdb->posts} where post_type='tgbuilding' and post_status = 'publish';", ARRAY_A);            
        
        }else if (intval($condos_select) != 0) {
            $metodo='all';
            $buildings_loop = $wpdb->get_results("SELECT ID,post_title,post_content,post_excerpt FROM {$wpdb->posts} where post_type='tgbuilding' and post_status = 'publish' AND ID={$condos_select};", ARRAY_A);            
        
        }else if ( $neighborhood_select !='all' && $type_search !='all' ) {
            
            $neighborhood_loop = $wpdb->get_results("SELECT {$wpdb->term_relationships}.object_id FROM {$wpdb->term_relationships} WHERE {$wpdb->term_relationships}.term_taxonomy_id='".$neighborhood_select."'");
            $list_temp=[];
            $text_query_temp='';
            foreach ($neighborhood_loop as $value_item) {
                if (!empty($value_item->object_id)) {
                    $list_temp[]=$value_item->object_id;
                }
            }
            $text_query_temp=implode(',', $list_temp);
            
            $taxonomys_loop = $wpdb->get_results("SELECT {$wpdb->term_relationships}.object_id FROM {$wpdb->term_relationships} WHERE {$wpdb->term_relationships}.term_taxonomy_id='".$type_search."' AND {$wpdb->term_relationships}.object_id in({$text_query_temp}); ");

        }else if ( $neighborhood_select !='all' && $type_search =='all' ) {
            $taxonomys_loop = $wpdb->get_results("SELECT {$wpdb->term_relationships}.object_id FROM {$wpdb->term_relationships} WHERE {$wpdb->term_relationships}.term_taxonomy_id='".$neighborhood_select."'");
        }else if ($type_search !='all' ) {
            $taxonomys_loop = $wpdb->get_results("SELECT {$wpdb->term_relationships}.object_id FROM {$wpdb->term_relationships} WHERE {$wpdb->term_relationships}.term_taxonomy_id='".$type_search."'");            
        }


        if ($metodo=='any') {
            foreach ($taxonomys_loop as $value_item) {
                if (!empty($value_item->object_id)) {
                    $building_list[]=$value_item->object_id;
                }
            }
            $building_text_query= implode(',', $building_list);

            $buildings_loop = $wpdb->get_results("SELECT ID,post_title,post_content,post_excerpt FROM {$wpdb->posts} where post_type='tgbuilding' and post_status = 'publish' AND  ( post_excerpt IN({$building_text_query}) OR  ID IN({$building_text_query})      );", ARRAY_A);
        }

        foreach ($buildings_loop as $buildings_loop_item) {
/***************************************************/
          $buildings_loop_postmeta = $wpdb->get_results("SELECT meta_key,meta_value FROM {$wpdb->postmeta} where post_id='".$buildings_loop_item['ID']."';", ARRAY_A);
          $postmeta_building=[];
          foreach ($buildings_loop_postmeta as $value_postmeta) {
            
            if ( $value_postmeta['meta_key']=='dgt_extra_lat') 
                $postmeta_building['lat']=$value_postmeta['meta_value'];


            if ( $value_postmeta['meta_key']=='dgt_extra_lng') 
                $postmeta_building['lng']=$value_postmeta['meta_value'];

            if ( $value_postmeta['meta_key']=='dgt_extra_address') 
                $postmeta_building['dgt_extra_address']=$value_postmeta['meta_value'];

            if ( $value_postmeta['meta_key']=='dgt_year_building') 
                $postmeta_building['dgt_year_building']=$value_postmeta['meta_value'];           

            if ( $value_postmeta['meta_key']=='tgbuilding_url') 
                $postmeta_building['tgbuilding_url']=$value_postmeta['meta_value'];           
              
          }
          $post_thumbnail_id = get_post_thumbnail_id($buildings_loop_item['post_excerpt']);
          $post_thumbnail_url = wp_get_attachment_url($post_thumbnail_id);
          if (empty($post_thumbnail_url)) { $post_thumbnail_url = 'http://idxb031.staging.wpengine.com/wp-content/themes/millenniumib/images/coming-soon_02.jpg'; }
          $postmeta_building['tgbuilding_image'] =$post_thumbnail_url;

          $termCateg=get_the_terms($buildings_loop_item['ID'],'category_building');
          $name_neight='';
          if(array_key_exists(0, $termCateg)) $name_neight=$termCateg[0]->name;
          $postmeta_building['type_category'] =$name_neight;
          
          $name_city='';
          $termCities=get_the_terms($buildings_loop_item['post_excerpt'],'cities');
          if(array_key_exists(0, $termCities)) $name_city=$termCities[0]->name;
          $postmeta_building['city_building'] =$name_city;
          
          $termneighborhood='';
          $termneighborhood=get_the_terms($buildings_loop_item['post_excerpt'],'neighborhood');
          if(array_key_exists(0, $termCities)) 
            if ($termneighborhood[0]->name !=null )  
                $termneighborhood=$termneighborhood[0]->name;

          $postmeta_building['neighborhood'] =$termneighborhood;                    
/***************************************************/
        $postmeta_building['ID'] =$buildings_loop_item['ID'];
        $postmeta_building['post_title'] =$buildings_loop_item['post_title'];
        $postmeta_building['post_content'] =$buildings_loop_item['post_content'];
        $postmeta_building['post_excerpt'] =$buildings_loop_item['post_excerpt'];
/***************************************************/        
        $response_data[]=$postmeta_building;
        $response['success']=true;
        }
    $response['result']=$response_data;

        echo wp_send_json($response);
    }
}
if(!function_exists('dgt_search_buildings_autocomplete_fn')) {
    function dgt_search_buildings_autocomplete_fn() {
  global $wpdb; 
  $type_search='all';
  $neighborhood_select='';
  $condos_select='';
  $response=[];
  $building_list=[];
  $response_data=[];
  $response['success']=false;
  $building_text_query='';  
  $search_building='%';
  $metodo='any';
    
    if (!empty($_POST['search_building'])) $search_building = $_POST['search_building'];
    $building_text_query='%'.$search_building.'%';

    $buildings_loop = $wpdb->get_results("SELECT ID,post_title,post_content,post_excerpt FROM {$wpdb->posts} where post_type='tgbuilding' and post_status = 'publish' AND post_title like '{$building_text_query}' ;", ARRAY_A);

        foreach ($buildings_loop as $buildings_loop_item) {
/***************************************************/
          $buildings_loop_postmeta = $wpdb->get_results("SELECT meta_key,meta_value FROM {$wpdb->postmeta} where post_id='".$buildings_loop_item['ID']."';", ARRAY_A);
          $postmeta_building=[];
          foreach ($buildings_loop_postmeta as $value_postmeta) {
            
            if ( $value_postmeta['meta_key']=='dgt_extra_lat') 
                $postmeta_building['lat']=$value_postmeta['meta_value'];


            if ( $value_postmeta['meta_key']=='dgt_extra_lng') 
                $postmeta_building['lng']=$value_postmeta['meta_value'];

            if ( $value_postmeta['meta_key']=='dgt_extra_address') 
                $postmeta_building['dgt_extra_address']=$value_postmeta['meta_value'];

            if ( $value_postmeta['meta_key']=='dgt_year_building') 
                $postmeta_building['dgt_year_building']=$value_postmeta['meta_value'];           

            if ( $value_postmeta['meta_key']=='tgbuilding_url') 
                $postmeta_building['tgbuilding_url']=$value_postmeta['meta_value'];           
              
          }
          $post_thumbnail_id = get_post_thumbnail_id($buildings_loop_item['post_excerpt']);
          $post_thumbnail_url = wp_get_attachment_url($post_thumbnail_id);
          if (empty($post_thumbnail_url)) { if (file_exists(BUILDINGS_IDX_PATH.'/images/default.jpg'))  $post_thumbnail_url = BUILDINGS_IDX_URI.'/images/default.jpg'; else $post_thumbnail_url = '//idxboost.com/i/default_thumbnail.jpg'; }
          $postmeta_building['tgbuilding_image'] =$post_thumbnail_url;

          $termCateg=get_the_terms($buildings_loop_item['ID'],'category_building');
          $name_neight='';
          if(array_key_exists(0, $termCateg)) $name_neight=$termCateg[0]->name;
          $postmeta_building['type_category'] =$name_neight;
          
          $name_city='';
          $termCities=get_the_terms($buildings_loop_item['post_excerpt'],'cities');
          if(array_key_exists(0, $termCities)) $name_city=$termCities[0]->name;
          $postmeta_building['city_building'] =$name_city;
          
          $termneighborhood='';
          $termneighborhood=get_the_terms($buildings_loop_item['post_excerpt'],'neighborhood');
          if(array_key_exists(0, $termCities)) 
            if ($termneighborhood[0]->name !=null )  
                $termneighborhood=$termneighborhood[0]->name;
              
          
          $postmeta_building['neighborhood'] =$termneighborhood;                    
/***************************************************/
        $postmeta_building['ID'] =$buildings_loop_item['ID'];
        $postmeta_building['post_title'] =$buildings_loop_item['post_title'];
        $postmeta_building['post_content'] =$buildings_loop_item['post_content'];
        $postmeta_building['post_excerpt'] =$buildings_loop_item['post_excerpt'];
/***************************************************/        
        $response_data[]=$postmeta_building;
        $response['success']=true;
        }
    $response['result']=$response_data;

        echo wp_send_json($response);

    }
}
if (!function_exists('get_feed_file_building')) {    
    function get_feed_file_building(){
        $path_feed = BUILDINGS_IDX_PATH.'feed/';
        $post_building=$path_feed.'condos.json';        
        $result=file_get_contents($post_building);
        return wp_send_json( json_decode($result) );
    }
}

if (!function_exists('feed_file_building')) {    
    function feed_file_building(){
        $path_feed = BUILDINGS_IDX_PATH.'feed/';
        $post_building=$path_feed.'condos.json';

  global $wpdb; 
  $type_search='all';
  $neighborhood_select='all';
  $condos_select=0;
  $response=[];
  $building_list=[];
  $response_data=[];
  $response['success']=false;
  $building_text_query='';  
  $metodo='any'; $alt_tag_data='';
/*FORM DATA POST*/
        if ($condos_select==0 && $neighborhood_select=='all' && $type_search=='all') {
            $metodo='all';
            $buildings_loop = $wpdb->get_results("SELECT ID,post_title,post_content,post_excerpt FROM {$wpdb->posts} where post_type='tgbuilding' and post_status = 'publish';", ARRAY_A);            
        }

        foreach ($buildings_loop as $buildings_loop_item) {
/***************************************************/
          $buildings_loop_postmeta = $wpdb->get_results("SELECT meta_key,meta_value FROM {$wpdb->postmeta} where post_id='".$buildings_loop_item['ID']."';", ARRAY_A);
          $postmeta_building=[]; $buildings_gallery_postmeta=[]; $buildings_alt_tag_image =[]; $post_thumbnail_url=''; $alt_tag_data='';
          foreach ($buildings_loop_postmeta as $value_postmeta) {
            
            if ( $value_postmeta['meta_key']=='dgt_extra_lat') 
                $postmeta_building['lat']=$value_postmeta['meta_value'];


            if ( $value_postmeta['meta_key']=='dgt_extra_lng') 
                $postmeta_building['lng']=$value_postmeta['meta_value'];

            if ( $value_postmeta['meta_key']=='dgt_extra_address') 
                if (!empty($value_postmeta['meta_value']))
                  $postmeta_building['dgt_extra_address']=$value_postmeta['meta_value'];
                else
                  $postmeta_building['dgt_extra_address']='';

            if ( $value_postmeta['meta_key']=='dgt_year_building') 
                if (!empty($value_postmeta['meta_value']))
                  $postmeta_building['dgt_year_building']=$value_postmeta['meta_value'];
                else
                  $postmeta_building['dgt_year_building']='';

            if ( $value_postmeta['meta_key']=='tgbuilding_url') 
                if (!empty($value_postmeta['meta_value']))
                  $postmeta_building['tgbuilding_url']=$value_postmeta['meta_value'];
                else
                  $postmeta_building['tgbuilding_url']='';
            
            if ( $value_postmeta['meta_key']=='dgt_tgid_neighnorhood') 
                if (!empty($value_postmeta['meta_value']))
                  $dgt_tgid_neighnorhood=$value_postmeta['meta_value'];
                else
                  $dgt_tgid_neighnorhood='';

            if ( $value_postmeta['meta_key']=='dgt_tgid_community') 
                if (!empty($value_postmeta['meta_value'])) 
                  $dgt_tgid_community=$value_postmeta['meta_value'];                                         
                else
                  $dgt_tgid_community='';


            if ( $value_postmeta['meta_key']=='dgt_tgbuildingid') 
                if (!empty($value_postmeta['meta_value']))
                  $postmeta_building['dgt_tgbuildingid']=$value_postmeta['meta_value'];
                else
                  $postmeta_building['dgt_tgbuildingid']='';

            if ( $value_postmeta['meta_key']=='dgt_extra_unit') 
                if (!empty($value_postmeta['meta_value']))
                  $postmeta_building['dgt_extra_unit']=$value_postmeta['meta_value'];
                else
                  $postmeta_building['dgt_extra_unit']='';

            if ( $value_postmeta['meta_key']=='dgt_extra_floor') 
                if (!empty($value_postmeta['meta_value']))
                  $postmeta_building['floor']=$value_postmeta['meta_value'];
                else
                  $postmeta_building['floor']='';
                                
          }

          $post_thumbnail_url=''; $post_thumbnail_id='';
          $post_thumbnail_id = get_post_thumbnail_id($buildings_loop_item['ID']);
          $post_thumbnail_url = wp_get_attachment_url($post_thumbnail_id);

          if (empty($post_thumbnail_url)) {
            
            $buildings_gallery_default = $wpdb->get_row("SELECT meta_value FROM {$wpdb->postmeta} WHERE wp_postmeta.meta_key='dgt_tg_gallery' and post_id='".$buildings_loop_item['ID']."';", ARRAY_A);          

            if (!empty($buildings_gallery_default)) {
              $post_thumbnail_url=$buildings_gallery_default['meta_value'];
              $alt_tag_data='';
            }else{
              
              $buildings_gallery_postmeta = $wpdb->get_results("SELECT {$wpdb->posts}.guid,{$wpdb->posts}.post_title FROM {$wpdb->postmeta} INNER JOIN {$wpdb->posts} on {$wpdb->posts}.ID={$wpdb->postmeta}.meta_value WHERE {$wpdb->postmeta}.post_id='".$buildings_loop_item['ID']."' and {$wpdb->postmeta}.meta_key='dgt_extra_gallery' limit 1;", ARRAY_A);

              
              $buildings_alt_tag_image = $wpdb->get_results("SELECT meta_value FROM {$wpdb->postmeta} WHERE wp_postmeta.meta_key='dgt_alt_tag' and post_id='".$buildings_loop_item['ID']."' limit 1;", ARRAY_A);          
              

                foreach ($buildings_gallery_postmeta as $value_gallery) {
                  $is_image=preg_match('/(https)|(http)/',$value_gallery['post_title'] );
                  if (!empty($value_gallery['post_title']) &&  is_numeric($is_image) && $is_image !=0 )
                      $post_thumbnail_url=$value_gallery['post_title'];
                  else if(!empty($value_gallery['guid']))
                    $post_thumbnail_url=$value_gallery['guid'];                  
                }     

                foreach ($buildings_alt_tag_image as $value_alt) {
                     $alt_tag_data=$value_alt['meta_value'];
                   }                 
            }

          }

          if (empty($post_thumbnail_url)) { $post_thumbnail_url = '//idxboost.com/i/default_thumbnail.jpg'; }
          $postmeta_building['tgbuilding_image'] =$post_thumbnail_url;
          $postmeta_building['image_alt'] =$alt_tag_data;
          

          $termCateg=get_the_terms($buildings_loop_item['ID'],'category_building',ARRAY_A);
          $ar_cat_id=[];
          $ar_cat_name=[];
          if( is_array($termCateg) && count($termCateg)>0 ){
            foreach ($termCateg as $key_cat => $value_cat) {
              $postmeta_building['ctId_'.$value_cat->term_id] =$value_cat->term_id;
              $postmeta_building['ctName_'.$value_cat->term_id] =$value_cat->name;
            }
            
          }

          $name_neight='';
          $id_neight=0;
          if ($termCateg != false) {
              if(array_key_exists(0, $termCateg)) {
                $name_neight=$termCateg[0]->name;
                $id_neight=$termCateg[0]->term_id;
              }
              
          }
          $postmeta_building['type_category_id'] =$id_neight;
          $postmeta_building['type_category'] =$name_neight;
          
          /*
          $name_city='';
          $id_city=0;
          $termCities=get_the_terms($buildings_loop_item['post_excerpt'],'cities');
          if ($termCities !=false)  {
              if(array_key_exists(0, $termCities)){
                $name_city=$termCities[0]->name;
                $id_city =$termCities[0]->term_id;            
              } 
              
          }
          $postmeta_building['city_building'] =$name_city;
          $postmeta_building['city_building_id'] = $id_city;
          */
          /*
          $termneighborhood='';
          $termneighborhoodtext='';
          $termneighborhoodid=0;
          $termneighborhood=get_the_terms($buildings_loop_item['post_excerpt'],'neighborhood');
          if ($termneighborhood != false ) {
              if(array_key_exists(0, $termCities)) 
                if ($termneighborhood[0]->name != false){
                    $termneighborhoodtext=$termneighborhood[0]->name;
                    $termneighborhoodid=$termneighborhood[0]->term_id;
                }
          }
          $postmeta_building['neighborhood'] =$termneighborhoodtext;
          $postmeta_building['neighborhood_id'] =$termneighborhoodid;          
          */     
          $postmeta_building['neighborhood'] = '';
          $postmeta_building['neighborhood_id'] ='';
          $postmeta_building['community_building'] = '';
          $postmeta_building['community_building_id'] = '';
          //NEIGHTBOARDHOOD
          $buildings_loop_tgid_neighnorhood = $wpdb->get_results("SELECT ID,post_title FROM {$wpdb->posts} where post_type in('neighborhood','tgneighborhood') and ID = '".$dgt_tgid_neighnorhood."';", ARRAY_A);
          foreach ($buildings_loop_tgid_neighnorhood as $value_neigth) {
            $postmeta_building['neighborhood'] = $value_neigth['post_title'];
            $postmeta_building['neighborhood_id'] =$value_neigth['ID'];      
          }
          //COMMUITIES
          $buildings_loop_tgid_community = $wpdb->get_results("SELECT ID,post_title FROM {$wpdb->posts} where post_type in('communities','tgcommunities') and ID = '".$dgt_tgid_community."';", ARRAY_A);
          foreach ($buildings_loop_tgid_community as $value_commu) {
            /*COMMUNITY_DATA*/
            $postmeta_building['community_building'] = $value_commu['post_title'];
            $postmeta_building['community_building_id'] =$value_commu['ID'];                  
          }          
          
/***************************************************/
        $postmeta_building['ID'] =$buildings_loop_item['ID'];
        $postmeta_building['post_title'] =$buildings_loop_item['post_title'];
/***************************************************/        
        $response_data[]=$postmeta_building;
        $response['success']=true;
        }
    
    usort($response_data, "order_by_neighborhood_building");

    $response['result']=$response_data;
    $result=file_put_contents($post_building, json_encode($response));
    //return $result;
    }
}

if (!function_exists('order_by_title_building')) {
  function order_by_title_building($a, $b){
    if (empty($a["post_title"]))  return 1;   
    if (empty($b["post_title"]))  return -1;

    if ($a["post_title"] == $b["post_title"]) {
        return 0;
    }
    return ($a["post_title"] < $b["post_title"]) ? -1 : 1;
  }
}

if (!function_exists('order_by_neighborhood_building')) {
  function order_by_neighborhood_building($a, $b){
    if (empty($a["neighborhood"]))  return 1;   
    if (empty($b["neighborhood"]))  return -1;

    if ($a["neighborhood"] == $b["neighborhood"]) {
        return 0;
    }
    return ($a["neighborhood"] < $b["neighborhood"]) ? -1 : 1;
  }
}

function dgt_load_buildings_fn( ) {
    $only_special =  $_POST['only_special'];
    $counter =  $_POST['counter'];
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

    $label_url = BUILDINGS_IDX_NAME . '_url';
    $label_address = DGTIDX_PREFIX_BUILDINGS . '_extra_address';
    $label_lat = DGTIDX_PREFIX_BUILDINGS . '_extra_lat';
    $label_lng = DGTIDX_PREFIX_BUILDINGS . '_extra_lng';
    $label_geometry = DGTIDX_PREFIX_BUILDINGS . '_map_geometry';

    $items = array();
    while ( $neighborhoods->have_posts() ) : $neighborhoods->the_post();
        $counter = $neighborhoods->current_post;
        $items[$counter]['ID'] = get_the_id();
        $items[$counter]['name'] = get_the_title();
        $items[$counter]['image'] = get_the_post_thumbnail_url( get_the_id(), 'full' ); 
        $items[$counter]['lat'] = get_post_meta( get_the_id(), $label_lat, true );
        $items[$counter]['lng'] = get_post_meta( get_the_id(), $label_lng, true );
        $items[$counter]['url'] = get_post_meta( get_the_id(), $label_url, true );

        $geocode = get_post_meta( get_the_id(), $label_geometry, true );
        parse_str($geocode, $geometry);
        $items[$counter]['geometry'] = $geometry['geometry'];
    endwhile; wp_reset_postdata();

    $response = array(
        'items'         => $items,
    );
    echo wp_send_json( $response );
    die;
}

if(!function_exists('my_admin_footer_tgbuilding_order_sort')) {
function my_admin_footer_tgbuilding_order_sort() { ?>
<script type="text/javascript">
jQuery(document).ready(function(){
  var href_real=jQuery('.menu-icon-tgbuilding a').attr('href');
  href_real +='&orderby=title&order=asc';
  jQuery('.menu-icon-tgbuilding a').eq(0).attr('href',href_real );  
  jQuery('.menu-icon-tgbuilding a').eq(1).attr('href',href_real );  
});
</script>
  <?php 
  }
  add_action('admin_footer', 'my_admin_footer_tgbuilding_order_sort');
}

if (!function_exists('idxboost_cache_relation_building_neighboard_xhr_fn')) {
    function idxboost_cache_relation_building_neighboard_xhr_fn() {
        global $wp, $wpdb;
        $path_feed = BUILDINGS_IDX_PATH.'feed/';
        $post_building=$path_feed.'condos_neigh_building.json';

        $text_featured="SELECT post.ID,post.post_title,post.post_name,idx_neigh.meta_value as id_neigh,idx_name_neigh.post_title as neighnorhood ,idx_link.meta_value as link
          FROM {$wpdb->posts} post 
          inner join {$wpdb->postmeta} idx_code on idx_code.post_id=post.ID and idx_code.meta_key='dgt_tg_idxboost_building'
          left  join {$wpdb->postmeta} idx_link on idx_link.post_id=post.ID and idx_link.meta_key='tgbuilding_url'
          inner join {$wpdb->postmeta} idx_neigh on idx_neigh.post_id=post.ID and idx_neigh.meta_key='dgt_tgid_neighnorhood'
          inner join {$wpdb->posts} idx_name_neigh on idx_name_neigh.ID=idx_neigh.meta_value and idx_name_neigh.post_status='publish'
        WHERE post.post_type='tgbuilding' and post.post_status='publish'  order by post.post_title asc; ";
        $list_pages_buildings = $wpdb->get_results($text_featured, ARRAY_A);
        $data_json=json_encode($list_pages_buildings);
        $result=file_put_contents($post_building, $data_json);
        return '1';
    }
}