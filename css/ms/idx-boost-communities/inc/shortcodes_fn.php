<?php

if (!function_exists('idx_agent_filter_sc')):
  /**
   * ShortCode control for Filter pages
   * 
   * @param boolean $map     show map
   * @param int $counter    default 5, max item in grid
   * @param boolean $class      show only special neighborhoods
   * @return html
   */
  function sc_communities($atts) {
    extract(shortcode_atts(array( 'map' => 'true', 'counter' => -1, 'only_special' => 'false'), $atts ));

    $map = $map === 'true'? true: false;
    $only_special = $only_special === 'true'? true: false;

    $query_arr = array(
      'post_type' => COMMUNITIES_IDX_NAME,
      'orderby' => 'date',
      'order' => 'DESC',
      'posts_per_page' => $counter
      );

    if($only_special == true) {
      $query_arr['meta_query'] = array(
        array(
          'key'     => DGTIDX_PREFIX_COMMUNITIES . '_extra_special',
          'value'   => 1,
          ),
        );
    }

    $neighborhoods = new WP_Query( $query_arr );

    if($map) {
      // Flex idx Contact - temporal carga de js
      wp_enqueue_script('google-maps-api', sprintf('//maps.googleapis.com/maps/api/js?key=%s', NEIGHBORHOOD_GOOGLE_MAP_KEY));
      wp_enqueue_script('idxboost_communities_maps', COMMUNITIES_IDX_URI . 'js/idxboost_load_maps.js' , COMMUNITIES_IDX_VERSION, true );
      wp_enqueue_script('underscore', COMMUNITIES_IDX_URI . 'js/underscore-min.js', COMMUNITIES_IDX_VERSION, true );
      wp_enqueue_script('infobox_packed-map', COMMUNITIES_IDX_URI . 'js/infobox_packed.js' ,  COMMUNITIES_IDX_VERSION, true );
      wp_enqueue_script('richkmarker-map', COMMUNITIES_IDX_URI . 'js/richmarker-compiled.js' ,  COMMUNITIES_IDX_VERSION, true );
      wp_enqueue_script('idx-communities-js', COMMUNITIES_IDX_URI . 'js/dgt-map-communities.js',  COMMUNITIES_IDX_VERSION, true );
      wp_enqueue_script('google-maps-utility-library-infobox', COMMUNITIES_IDX_URI . 'vendor/google-maps-utility-library/infobox_packed.js', array('google-maps-api'));

      wp_localize_script('idx-communities-js', 'dgtCredential', array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'counter' => $counter,
        'only_special' => $only_special
        ));
    }
    ob_start();
  	require COMMUNITIES_IDX_PATH . '/views/shortcode/sc_communities.php';
    $output = ob_get_clean();   
    return $output;
  }
  add_shortcode('IDX_COMMUNITIES', 'sc_communities' );
endif;

if (!function_exists('idx_news_to_community')){
  function idx_news_to_community($atts) {
  global $wpdb; 
  $atts = shortcode_atts(array('id_community' => '0'), $atts);
  $query_search='"'.$atts['id_community'].'"';

  $idx_noticias = $wpdb->get_results("
    SELECT post.ID,post.post_title,post.post_name 
    FROM {$wpdb->postmeta} meta
    inner join {$wpdb->posts} post on post.ID=meta.post_id
   where meta.meta_key='idx_news_community' and meta.meta_value like '%".$query_search."%' limit 6;", ARRAY_A);   

  if (empty($idx_noticias) || !is_array($idx_noticias)) {
    return false;
  }

  require COMMUNITIES_IDX_PATH . '/views/shortcode/idx_news_to_post.php';

    
  $output = ob_get_clean();   
  return $output;

  }
    add_shortcode('sc_idx_news_to_community', 'idx_news_to_community' );
}