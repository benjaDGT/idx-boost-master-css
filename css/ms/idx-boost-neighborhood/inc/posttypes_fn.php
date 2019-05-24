<?php
function ModuloNeighborhood()
{
	$show_idx_ui = true;

	$post_plural = 'TG Neighborhoods';
	$post_single = 'Neighborhood';

	$labels = array(
      'name' => _x($post_plural, 'post type name', DGTIDX_PREFIX),
      'singular_name' => _x($post_single, 'post type singular name', DGTIDX_PREFIX),
      'add_new' => _x('Add New', 'admin menu: add new '.$post_single, DGTIDX_PREFIX),
      'add_new_item' => __('Add New '.$post_single, DGTIDX_PREFIX),
      'edit_item' => __('Edit '.$post_single, DGTIDX_PREFIX),
      'new_item' => __('New '.$post_single, DGTIDX_PREFIX),
      'view_item' => __('View '.$post_single, DGTIDX_PREFIX),
      'search_items' => __('Search '.$post_plural, DGTIDX_PREFIX),
      'not_found' => __(sprintf('No %s found', strtolower($post_plural)), DGTIDX_PREFIX),
      'not_found_in_trash' => __(sprintf('No %s found in Trash', strtolower($post_plural)), DGTIDX_PREFIX),
      'menu_name' => __($post_plural, DGTIDX_PREFIX)
    );

    $dgt_pocket_posttype_settings = array(
      'labels'             => $labels,
      'public'             => false,
      'publicly_queryable' => false,
      'show_ui'            => true,
      'show_in_menu'       => true,
      'query_var'          => false,
            // 'rewrite'            => array('slug' => DGT_POCKET_PT_NAME, 'with_front' => false),
      'capability_type'    => 'page',
      'has_archive'        => false,
            // 'menu_position'      => null,
      'menu_icon'          => 'dashicons-pressthis',
      'supports'           => array('title', 'editor', 'page-attributes', 'thumbnail'),
      'menu_position'      => 25,
      );

    register_post_type( NEIGHBORHOOD_IDX_NAME, $dgt_pocket_posttype_settings);

	// register_post_type( NEIGHBORHOOD_IDX_NAME, array(
	// 	'with_front'          => false,
	// 	'public'              => true,
	// 	'has_archive'         => true,
	// 	'exclude_from_search' => true,
	// 	'show_ui'             => $show_idx_ui,
	// 	'show_in_nav_menus'   => $show_idx_ui,
		/*'show_in_menu' => $show_idx_ui,
		'show_in_admin_bar' => $show_idx_ui,*/
	// 	'show_in_menu'        => false,
	// 	'show_in_admin_bar'   => false,
	// 	'label'               => 'My IDX Neighborhoods',
	// 	'rewrite'             => array(
	// 		'slug' => NEIGHBORHOOD_IDX_NAME,
	// 		),
	// 	'supports'            => array('title', 'page-attributes', 'post-formats'),
	// 	'capability_type'     => 'post',
	// ) );
}

// Hooking up our function to theme setup
add_action('init', 'ModuloNeighborhood');



function neighborhood_metaboxes( $post )
{
	// add_meta_box( $id, $title, $callback, $screen, $context, $priority, $callback_args );
	add_meta_box('neighborhood_info', 'Additional Information', 'cb_neighborhood_info', NEIGHBORHOOD_IDX_NAME, 'normal');
	add_meta_box('neighborhood_top_section', 'Neighborhood Top Section', 'fc_top_information', NEIGHBORHOOD_IDX_NAME, 'normal');
  add_meta_box('news_neighborhood_info_box', 'News to Neighborhood', 'idx_news_neighborhood', 'post' , 'normal');
}
add_action('add_meta_boxes', 'neighborhood_metaboxes');


//add_action('add_meta_boxes', 'buildings_metaboxes');

function idx_news_neighborhood( $post ) {
  global $wpdb;
  $label_news_neighborhood ='idx_news_neighborhood';
  $idx_news_neighborhood_trend ='idx_news_neighborhood_trend';
  $idx_news_neighborhood_market ='idx_news_neighborhood_market';

    $list_pages_neighborhood = $wpdb->get_results("SELECT ID as id,post_title as label,post_type FROM {$wpdb->posts} where post_type in('neighborhood') and post_status = 'publish' order by post_title asc;", ARRAY_A);

  $value_news = get_post_meta( $post->ID, $label_news_neighborhood, true );

  $value_news_trend = get_post_meta( $post->ID, $idx_news_neighborhood_trend, true );
  $value_news_market = get_post_meta( $post->ID, $idx_news_neighborhood_market, true );

    require NEIGHBORHOOD_IDX_PATH . '/views/admin/idx_news_neighborhood.php';

}

function fc_top_information( $post ) {
	wp_nonce_field(basename(__FILE__), 'neighborhood_meta_box_nonce');
	$label_hide_top_section = DGTIDX_PREFIX . '_extra_hide_top_section';
	$label_default_view = DGTIDX_PREFIX . '_extra_default_view';
	$label_neigbordhood_map = DGTIDX_PREFIX . '_extra_neigbordhood_map';

	$post_hide_top_section = get_post_meta( $post->ID, $label_hide_top_section, true );
	$post_default_view = get_post_meta( $post->ID, $label_default_view, true );
	$post_neigbordhood_map = get_post_meta( $post->ID, $label_neigbordhood_map, true );

	require NEIGHBORHOOD_IDX_PATH . '/views/admin/admin_top_information.php';

}

function cb_neighborhood_info( $post ) 
{
	wp_nonce_field(basename(__FILE__), 'neighborhood_meta_box_nonce');

	/* Define label by old version of Elite 2017 */
	$label_url = NEIGHBORHOOD_IDX_NAME . '_url';
	$label_address = DGTIDX_PREFIX . '_extra_address';
	$label_lat = DGTIDX_PREFIX . '_extra_lat';
	$label_lng = DGTIDX_PREFIX . '_extra_lng';
	$label_geometry = DGTIDX_PREFIX . '_map_geometry';
	$label_special = DGTIDX_PREFIX . '_extra_special';

	$neighborhood_url = get_post_meta( $post->ID, $label_url, true );
	$neighborhood_address = get_post_meta( $post->ID, $label_address, true );
	$neighborhood_lat = get_post_meta( $post->ID, $label_lat, true );
	$neighborhood_lng = get_post_meta( $post->ID, $label_lng, true );
	$neighborhood_special = get_post_meta( $post->ID, $label_special, true );

  $geocode_coorde='';

	$geometry = get_post_meta($post->ID, $label_geometry, true);
	if( !empty( $geometry ) ) {
		parse_str($geometry, $map_params);

    if (is_array($map_params) && array_key_exists('geometry', $map_params)) {
      $geocode_coorde=$map_params['geometry'];
    }

		$tmp_geometry = str_replace(array('POLYGON ((', '))'), '', $map_params['geometry']);
		$tmp_geometry = explode(', ', $tmp_geometry );
		$geo = array();
		foreach($tmp_geometry as $coordinate) {
			$bound =explode(' ', $coordinate);
			$geo[] = array($bound[0], $bound[1]);
		}
		$polygonGeocode = $geo; 
	}

	require NEIGHBORHOOD_IDX_PATH . '/views/admin/cb_neighborhood_info.php';
}

function neighborhood_save_post($post_id)
{
    // return if autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check the user's permissions.
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

  $label_news_neighborhood ='idx_news_neighborhood';
  $idx_news_neighborhood_trend ='idx_news_neighborhood_trend';
  $idx_news_neighborhood_market ='idx_news_neighborhood_market';

	$label_url = NEIGHBORHOOD_IDX_NAME . '_url';
	$label_address = DGTIDX_PREFIX . '_extra_address';
	$label_lat = DGTIDX_PREFIX . '_extra_lat';
	$label_lng = DGTIDX_PREFIX . '_extra_lng';
	$label_geometry = DGTIDX_PREFIX . '_map_geometry';
	$label_special = DGTIDX_PREFIX . '_extra_special';

	$label_hide_top_section = DGTIDX_PREFIX . '_extra_hide_top_section';
	$label_default_view = DGTIDX_PREFIX . '_extra_default_view';
	$label_neigbordhood_map = DGTIDX_PREFIX . '_extra_neigbordhood_map';

    if (isset($_POST[$label_news_neighborhood])) {
        update_post_meta( $post_id, $label_news_neighborhood, sanitize_text_field($_POST[$label_news_neighborhood]) );
    } else {
      delete_post_meta( $post_id, $label_news_neighborhood );
    }

    if (isset($_POST[$idx_news_neighborhood_trend])) {
        update_post_meta( $post_id, $idx_news_neighborhood_trend, sanitize_text_field($_POST[$idx_news_neighborhood_trend]) );
    } else {
      delete_post_meta( $post_id, $idx_news_neighborhood_trend );
    }

    if (isset($_POST[$idx_news_neighborhood_market])) {
        update_post_meta( $post_id, $idx_news_neighborhood_market, sanitize_text_field($_POST[$idx_news_neighborhood_market]) );
    } else {
      delete_post_meta( $post_id, $idx_news_neighborhood_market );
    }


    if (isset($_POST[$label_url])) {
        update_post_meta($post_id, $label_url, sanitize_text_field($_POST[$label_url]));
    }

    if (isset($_POST[$label_address])) {
        update_post_meta($post_id, $label_address, sanitize_text_field($_POST[$label_address]));
    }

    if (isset($_POST[$label_lat])) {
        update_post_meta($post_id, $label_lat, sanitize_text_field($_POST[$label_lat]));
    }

    if (isset($_POST[$label_lng])) {
        update_post_meta($post_id, $label_lng, sanitize_text_field($_POST[$label_lng]));
    }

    if (isset($_POST[$label_special])) {
        update_post_meta( $post_id, $label_special, sanitize_text_field($_POST[$label_special]) );
    } else {
    	delete_post_meta( $post_id, $label_special );
    }
    
 	if (isset($_POST[$label_geometry])) {
 		update_post_meta( $post_id, $label_geometry, $_POST[$label_geometry] );
    }

    if (isset($_POST[$label_hide_top_section])) {
        update_post_meta( $post_id, $label_hide_top_section, sanitize_text_field($_POST[$label_hide_top_section]) );
    } else {
    	delete_post_meta( $post_id, $label_hide_top_section );
    }

    if (isset($_POST[$label_default_view])) {
        update_post_meta( $post_id, $label_default_view, sanitize_text_field($_POST[$label_default_view]) );
    } else {
    	delete_post_meta( $post_id, $label_default_view );
    }

    if (isset($_POST[$label_neigbordhood_map])) {
        update_post_meta( $post_id, $label_neigbordhood_map, sanitize_text_field($_POST[$label_neigbordhood_map]) );
    } else {
    	delete_post_meta( $post_id, $label_neigbordhood_map );
    }        
}
add_action('save_post', 'neighborhood_save_post', 10, 2);
