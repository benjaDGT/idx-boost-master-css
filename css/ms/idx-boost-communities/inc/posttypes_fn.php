<?php
function ModuloCommunities()
{
	$show_idx_ui = true;

	$post_plural = 'TG Communities';
	$post_single = 'Communities';

	$labels = array(
      'name' => _x($post_plural, 'post type name', DGTIDX_PREFIX_COMMUNITIES),
      'singular_name' => _x($post_single, 'post type singular name', DGTIDX_PREFIX_COMMUNITIES),
      'add_new' => _x('Add New', 'admin menu: add new '.$post_single, DGTIDX_PREFIX_COMMUNITIES),
      'add_new_item' => __('Add New '.$post_single, DGTIDX_PREFIX_COMMUNITIES),
      'edit_item' => __('Edit '.$post_single, DGTIDX_PREFIX_COMMUNITIES),
      'new_item' => __('New '.$post_single, DGTIDX_PREFIX_COMMUNITIES),
      'view_item' => __('View '.$post_single, DGTIDX_PREFIX_COMMUNITIES),
      'search_items' => __('Search '.$post_plural, DGTIDX_PREFIX_COMMUNITIES),
      'not_found' => __(sprintf('No %s found', strtolower($post_plural)), DGTIDX_PREFIX_COMMUNITIES),
      'not_found_in_trash' => __(sprintf('No %s found in Trash', strtolower($post_plural)), DGTIDX_PREFIX_COMMUNITIES),
      'menu_name' => __($post_plural, DGTIDX_PREFIX_COMMUNITIES)
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

    register_post_type( COMMUNITIES_IDX_NAME, $dgt_pocket_posttype_settings);

	// register_post_type( COMMUNITIES_IDX_NAME, array(
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
	// 		'slug' => COMMUNITIES_IDX_NAME,
	// 		),
	// 	'supports'            => array('title', 'page-attributes', 'post-formats'),
	// 	'capability_type'     => 'post',
	// ) );
}

// Hooking up our function to theme setup
add_action('init', 'ModuloCommunities');

function communities_metaboxes( $post )
{
    add_meta_box('communities_info_box', 'Additional Information Communities', 'cb_communities_info', COMMUNITIES_IDX_NAME , 'normal');
    add_meta_box('communities_top_section', 'Community Top Section', 'fc_top_information_community', COMMUNITIES_IDX_NAME, 'normal');
    add_meta_box('news_communities_info_box', 'News to Community', 'idx_news_community', 'post' , 'normal');
}
add_action('add_meta_boxes', 'communities_metaboxes');

//add_action('add_meta_boxes_' .COMMUNITIES_IDX_NAME, 'communities_metaboxes');

function idx_news_community( $post ) {
  global $wpdb;
  $label_news_community ='idx_news_community';

    $list_pages_community = $wpdb->get_results("SELECT ID as id,post_title as label,post_type FROM {$wpdb->posts} where post_type in('communities') and post_status = 'publish' order by post_title asc;", ARRAY_A);

  $value_news = get_post_meta( $post->ID, $label_news_community, true );

    require COMMUNITIES_IDX_PATH . '/views/admin/idx_news_community.php';

}

function fc_top_information_community( $post ) {
  wp_nonce_field(basename(__FILE__), 'communities_meta_box_nonce');
  $label_hide_top_section = DGTIDX_PREFIX_COMMUNITIES . '_extra_hide_top_section';
  $label_default_view = DGTIDX_PREFIX_COMMUNITIES . '_extra_default_view';

  $post_hide_top_section = get_post_meta( $post->ID, $label_hide_top_section, true );
  $post_default_view = get_post_meta( $post->ID, $label_default_view, true );

  require COMMUNITIES_IDX_PATH . '/views/admin/admin_top_information.php';

}

function cb_communities_info( $post ) 
{
  global $wpdb;
  wp_nonce_field(basename(__FILE__), 'communities_meta_box_nonce');
	/* Define label by old version of Elite 2017 */
	$label_url = COMMUNITIES_IDX_NAME . '_url';
	$label_address = DGTIDX_PREFIX_COMMUNITIES . '_extra_address';
	$label_lat = DGTIDX_PREFIX_COMMUNITIES . '_extra_lat';
	$label_lng = DGTIDX_PREFIX_COMMUNITIES . '_extra_lng';
	$label_geometry = DGTIDX_PREFIX_COMMUNITIES . '_map_geometry';
	$label_special = DGTIDX_PREFIX_COMMUNITIES . '_extra_special';

	$neighborhood_url = get_post_meta( $post->ID, $label_url, true );
	$neighborhood_address = get_post_meta( $post->ID, $label_address, true );
	$neighborhood_lat = get_post_meta( $post->ID, $label_lat, true );
	$neighborhood_lng = get_post_meta( $post->ID, $label_lng, true );
	$neighborhood_special = get_post_meta( $post->ID, $label_special, true );

	$geometry = get_post_meta($post->ID, $label_geometry, true);
	if( !empty( $geometry ) ) {
		parse_str($geometry, $map_params);
		$tmp_geometry = str_replace(array('POLYGON ((', '))'), '', $map_params['geometry']);
		$tmp_geometry = explode(', ', $tmp_geometry );
		$geo = array();
		foreach($tmp_geometry as $coordinate) {
			$bound =explode(' ', $coordinate);
			$geo[] = array($bound[0], $bound[1]);
		}
		$polygonGeocode = $geo; 
	}

    $tgid_neighnorhood = get_post_meta( $post->ID, 'tgpost_relacion_neighborhood', true );
    $tg_show_building = get_post_meta( $post->ID, 'tg_show_building', true );

    $list_pages_neighborhood = $wpdb->get_results("SELECT ID,post_title,post_type FROM {$wpdb->posts} where post_type in('neighborhood','tgneighborhood') and post_status = 'publish' order by post_type DESC;", ARRAY_A);


	require COMMUNITIES_IDX_PATH . '/views/admin/cb_communities_info.php';
}

function custom_save_communities_post($post_id, $post)
{
    // return if autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    // Check the user's permissions.
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

  $label_hide_top_section = DGTIDX_PREFIX_COMMUNITIES . '_extra_hide_top_section';
  $label_default_view = DGTIDX_PREFIX_COMMUNITIES . '_extra_default_view';

	$label_url = COMMUNITIES_IDX_NAME . '_url';
	$label_address = DGTIDX_PREFIX_COMMUNITIES . '_extra_address';
	$label_lat = DGTIDX_PREFIX_COMMUNITIES . '_extra_lat';
	$label_lng = DGTIDX_PREFIX_COMMUNITIES . '_extra_lng';
	$label_geometry = DGTIDX_PREFIX_COMMUNITIES . '_map_geometry';
	$label_special = DGTIDX_PREFIX_COMMUNITIES . '_extra_special';
  $tgneigthboardhood_relacion = 'tgpost_relacion_neighborhood';
  $tg_show_building = 'tg_show_building';
  $label_news_community ='idx_news_community';

    if (isset($_POST[$label_news_community])) {
        update_post_meta( $post_id, $label_news_community, sanitize_text_field($_POST[$label_news_community]) );
    } else {
      delete_post_meta( $post_id, $label_news_community );
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

  if (isset($_POST[$tgneigthboardhood_relacion])) {
    update_post_meta($post_id, $tgneigthboardhood_relacion, sanitize_text_field($_POST[$tgneigthboardhood_relacion]));
  } 
  
  if (isset($_POST[$tg_show_building])) {
    update_post_meta($post_id, $tg_show_building, sanitize_text_field($_POST[$tg_show_building]));
  } else {
      update_post_meta($post_id, $tg_show_building, sanitize_text_field('2'));
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
  
         
}
add_action('save_post', 'custom_save_communities_post', 10, 2);
