<?php
function ModuloBuildingsTG()
{
	$show_idx_ui = true;

	$post_plural = 'TG Buildings';
	$post_single = 'building';

	$labels = array(
      'name' => _x($post_plural, 'post type name', DGTIDX_PREFIX_BUILDINGS),
      'singular_name' => _x($post_single, 'post type singular name', DGTIDX_PREFIX_BUILDINGS),
      'add_new' => _x('Add New', 'admin menu: add new '.$post_single, DGTIDX_PREFIX_BUILDINGS),
      'add_new_item' => __('Add New '.$post_single, DGTIDX_PREFIX_BUILDINGS),
      'edit_item' => __('Edit '.$post_single, DGTIDX_PREFIX_BUILDINGS),
      'new_item' => __('New '.$post_single, DGTIDX_PREFIX_BUILDINGS),
      'view_item' => __('View '.$post_single, DGTIDX_PREFIX_BUILDINGS),
      'search_items' => __('Search '.$post_plural, DGTIDX_PREFIX_BUILDINGS),
      'not_found' => __(sprintf('No %s found', strtolower($post_plural)), DGTIDX_PREFIX_BUILDINGS),
      'not_found_in_trash' => __(sprintf('No %s found in Trash', strtolower($post_plural)), DGTIDX_PREFIX_BUILDINGS),
      'menu_name' => __($post_plural, DGTIDX_PREFIX_BUILDINGS)
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

    register_post_type( BUILDINGS_IDX_NAME, $dgt_pocket_posttype_settings);

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
add_action('init', 'ModuloBuildingsTG');

function buildings_metaboxes( $post )
{
    add_meta_box('buildings_info_box', 'Additional Information Buildings', 'cb_buildings_info', BUILDINGS_IDX_NAME , 'normal');
    add_meta_box('news_buildings_info_box', 'News to building', 'idx_news_building', 'post' , 'normal');
}
add_action('add_meta_boxes', 'buildings_metaboxes');

//add_action('add_meta_boxes_' .COMMUNITIES_IDX_NAME, 'communities_metaboxes');


function idx_news_building( $post ) {
  global $wpdb;
  $label_news_building ='idx_news_building';

    $list_pages_building = $wpdb->get_results("SELECT ID as id,post_title as label,post_type FROM {$wpdb->posts} where post_type in('flex-idx-building') and post_status = 'publish' order by post_title asc;", ARRAY_A);

  $value_news = get_post_meta( $post->ID, $label_news_building, true );

    require BUILDINGS_IDX_PATH . '/views/admin/idx_news_building.php';

}

function cb_buildings_info( $post ) 
{
  global $wpdb;
	wp_nonce_field(basename(__FILE__), 'buildings_meta_box_nonce');

	/* Define label by old version of Elite 2017 */
	$label_url = BUILDINGS_IDX_NAME . '_url';
	$label_address = DGTIDX_PREFIX_BUILDINGS . '_extra_address';
	$label_lat = DGTIDX_PREFIX_BUILDINGS . '_extra_lat';
	$label_lng = DGTIDX_PREFIX_BUILDINGS . '_extra_lng';
	$label_geometry = DGTIDX_PREFIX_BUILDINGS . '_map_geometry';
  $label_kml = DGTIDX_PREFIX_BUILDINGS . '_extra_kml';
	$label_special = DGTIDX_PREFIX_BUILDINGS . '_extra_special';
  $label_year_building = DGTIDX_PREFIX_BUILDINGS . '_year_building';
  $label_tgbuilding_id = DGTIDX_PREFIX_BUILDINGS . '_tgbuildingid';

  $label_tgid_neighnorhood = DGTIDX_PREFIX_BUILDINGS . '_tgid_neighnorhood';
  $label_tgid_community = DGTIDX_PREFIX_BUILDINGS . '_tgid_community';

  $label_idxboost_building = DGTIDX_PREFIX_BUILDINGS . '_tg_idxboost_building';
  $label_unit = DGTIDX_PREFIX_BUILDINGS. '_extra_unit';
  $label_floor = DGTIDX_PREFIX_BUILDINGS. '_extra_floor';

	$neighborhood_url = get_post_meta( $post->ID, $label_url, true );
	$neighborhood_address = get_post_meta( $post->ID, $label_address, true );
	$neighborhood_lat = get_post_meta( $post->ID, $label_lat, true );
	$neighborhood_lng = get_post_meta( $post->ID, $label_lng, true );
	$neighborhood_special = get_post_meta( $post->ID, $label_special, true );
  $year_building_postmeta = get_post_meta( $post->ID, $label_year_building, true );
  $tgbuilding_id_postmeta = get_post_meta( $post->ID, $label_tgbuilding_id, true ); 
  $idxboost_building_postmeta = get_post_meta( $post->ID, $label_idxboost_building, true ); 
  $units_postmeta = get_post_meta( $post->ID, $label_unit, true );
  $floor_postmeta = get_post_meta( $post->ID, $label_floor, true );

  if (empty($tgbuilding_id_postmeta)) 
      $tgbuilding_id_postmeta=time();
  
  $kml_building = get_post_meta( $post->ID, $label_kml, true );

  $tgid_neighnorhood = get_post_meta( $post->ID, $label_tgid_neighnorhood, true );
  $tgid_community = get_post_meta( $post->ID, $label_tgid_community, true );

  $list_pages_neighborhood = $wpdb->get_results("SELECT ID,post_title,post_type FROM {$wpdb->posts} where post_type in('neighborhood','tgneighborhood') and post_status = 'publish';", ARRAY_A);
  $list_pages_community = $wpdb->get_results("SELECT ID,post_title,post_type FROM {$wpdb->posts} where post_type in('communities','tgcommunities') and post_status = 'publish';", ARRAY_A);

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
	require BUILDINGS_IDX_PATH . '/views/admin/cb_communities_info.php';
}

function custom_save_tgbuildings_post($post_id, $post)
{
    // return if autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    // Check the user's permissions.
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
  $label_news_building ='idx_news_building';
	$label_url = BUILDINGS_IDX_NAME . '_url';
	$label_address = DGTIDX_PREFIX_BUILDINGS . '_extra_address';
	$label_lat = DGTIDX_PREFIX_BUILDINGS . '_extra_lat';
	$label_lng = DGTIDX_PREFIX_BUILDINGS . '_extra_lng';
	$label_kml = DGTIDX_PREFIX_BUILDINGS . '_extra_kml';
  $label_unit = DGTIDX_PREFIX_BUILDINGS. '_extra_unit';
  $label_geometry = DGTIDX_PREFIX_BUILDINGS . '_map_geometry';
	$label_special = DGTIDX_PREFIX_BUILDINGS . '_extra_special';
  $label_year_building = DGTIDX_PREFIX_BUILDINGS . '_year_building';
  $label_tgbuilding_id = DGTIDX_PREFIX_BUILDINGS . '_tgbuildingid';
  $label_tgid_neighnorhood = DGTIDX_PREFIX_BUILDINGS . '_tgid_neighnorhood';
  $label_tgid_community = DGTIDX_PREFIX_BUILDINGS . '_tgid_community';
  $label_idxboost_building = DGTIDX_PREFIX_BUILDINGS . '_tg_idxboost_building';
  $label_floor = DGTIDX_PREFIX_BUILDINGS. '_extra_floor';

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

    if (isset($_POST[$label_news_building])) {
        update_post_meta( $post_id, $label_news_building, sanitize_text_field($_POST[$label_news_building]) );
    } else {
      delete_post_meta( $post_id, $label_news_building );
    }

    
 	if (isset($_POST[$label_geometry])) {
 		update_post_meta( $post_id, $label_geometry, $_POST[$label_geometry] );
    }

  if (isset($_POST[$label_kml])) {
    update_post_meta( $post_id, $label_kml, $_POST[$label_kml] );
    }    

  if (isset($_POST[$label_year_building])) {
    update_post_meta( $post_id, $label_year_building, $_POST[$label_year_building] );
    }    

  if (isset($_POST[$label_tgbuilding_id])) {
    update_post_meta( $post_id, $label_tgbuilding_id, $_POST[$label_tgbuilding_id] );
    }

  if (isset($_POST[$label_tgid_neighnorhood])) {
    update_post_meta( $post_id, $label_tgid_neighnorhood, $_POST[$label_tgid_neighnorhood] );
    }

  if (isset($_POST[$label_tgid_community])) {
    update_post_meta( $post_id, $label_tgid_community, $_POST[$label_tgid_community] );
    }        

  if (isset($_POST[$label_idxboost_building])) {
    update_post_meta( $post_id, $label_idxboost_building, $_POST[$label_idxboost_building] );
    }            

  if (isset($_POST[$label_unit])) {
    update_post_meta( $post_id, $label_unit, $_POST[$label_unit] );
    }  

  if (isset($_POST[$label_floor])) {
    update_post_meta( $post_id, $label_floor, $_POST[$label_floor] );
    }      

    feed_file_building();    
}
add_action('save_post', 'custom_save_tgbuildings_post', 10, 2);


add_action( 'init', 'taxonomy_category_tgbuilding' );

function taxonomy_category_tgbuilding() {
$taxonomy='category_building';
$object_type='tgbuilding';
  register_taxonomy( $taxonomy, $object_type,     array(
      'label' => __( 'Category Building' ),
      'rewrite' => array( 'slug' => $taxonomy ),
      'hierarchical' => true,
    ) );
}