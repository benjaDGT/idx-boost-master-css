<?php
/**
 * Plugin Name: TG Microsites Menu
 * Plugin URI: https://tremgroup.com/
 * Description: Provides a post type for adding items to build a menu.
 * Author: TREMGROUP
 * Version: 1.0
 * Author URI: https://tremgroup.com/
 */
defined('ABSPATH') or exit;
// register post type

function dgt_microsite_pt()
{
	$labels = array(
		'name' => _x('TG Microsite', 'post type general name'),
		'singular_name' => _x('TG Microsite','post type singular name'),
		'add_new' => _x('Add New', 'speciality item'),
		'add_new_item' => 'Add New Microsite',
		'edit_item' => 'Edit Microsite',
		'new_item' => 'New Microsite',
		'view_item' => 'View Microsite',
		'search_items' => 'Search Microsite',
		'not_found' => 'Nothing found',
		'not_found_in_trash' => 'Nothing found in Trash',
		'parent_item_colon' => ''
	);

	$args = array(
		'labels' => $labels,
		'public' => false,
		'publicly_queryable' => false,
		'show_ui' => true,
		'show_in_nav_menus' => TRUE,
		'show_in_menu' => true,
		'query_var' => true,
		'rewrite' => array('slug' => 'block-building'),
		'capability_type' => 'page',
		'hierarchical' => false,
		'has_archive' => true,
		//'supports' => array('title', 'editor','thumbnail', 'page-attributes')
		 'supports' => array('title', 'page-attributes')
	);

	register_post_type('tgmicrosite', $args);

	flush_rewrite_rules();
}

add_action('init', 'dgt_microsite_pt');

/*Adding post custom fields */
function _flag_section_create_metabox() {

	add_meta_box(
		'_main_section_metabox', // Metabox ID
		'Additional info', // Title to display
		'eflyer_show_custom_meta_box', // Function to call that contains the metabox content
		'tgmicrosite', // Post type to display metabox on
		'normal', // Where to put it (normal = main colum, side = sidebar, etc.)
		'high' // Priority relative to other metaboxes
	);
}
add_action( 'add_meta_boxes', '_flag_section_create_metabox' );

$prefix = 'eflyer_';

/*main section fields*/
$custom_meta_fields_main = array(
	 array(
		  'label'=> 'Building Image',
		  'desc'  => 'Image of the building related to the microsite.',
		  'id'    => $prefix.'image',
		  'type'  => 'media'
	  ),
	array(
		'label'=> 'Neighborhood',
		'desc'  => 'Enter name of the neighborhood',
		'id'    => $prefix.'neighborhood',
		'type'  => 'text'
	),
	array(
		'label'=> 'Microsite URL',
		'desc'  => 'Enter a valid site URL, home or internal page',
		'id'    => $prefix.'siteurl',
		'type'  => 'text'
	),

);

//render the fileds inside de metabox
// The Callback
function eflyer_show_custom_meta_box($object) {
	global $custom_meta_fields_main, $post;
	// Use nonce for verification
	echo '<input type="hidden" name="custom_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';

	// Begin the field table and loop
	echo '<table class="form-table">';
	foreach ($custom_meta_fields_main as $field) {
		// get value of this field if it exists for this post
		$meta = get_post_meta($post->ID, $field['id'], true);
		// begin a table row with
		echo '<tr>
                <th><label for="'.$field['id'].'">'.$field['label'].'</label></th>
                <td>';
		switch($field['type']) {
			/* case 'media':
				// $close_button = null;
				 $close_button = '<span class="eflyer_image_close"></span>';
				 if ($meta) {
					 $close_button = '<span class="eflyer_image_close"></span>';
				 }
				 echo '<input id="eflyer_image" type="hidden" name="eflyer_image" value="' . esc_attr($meta) . '" />
						 <div class="eflyer_image_container">' . $close_button . '<img id="eflyer_image_src" class="testclass" src="' . wp_get_attachment_thumb_url(eflyer_get_image_id($meta)) . '"></div>
						 <input id="eflyer_image_button" type="button" value="Add Image" />';
				 break; */
			case 'media':
				$close_button = null;
				//$close_button = '<span class="eflyer_image_close"></span>';
				if ($meta) {
					$close_button = '<span class="eflyer_close"></span>';
					//echo '<div class="eflyer_image_container" id="eflyer_image_container_'.$field['id'].'">' . $close_button . '<img id="eflyer_image_src" src="' . wp_get_attachment_thumb_url(eflyer_get_image_id($meta)) . '"></div>';
				}
				echo '<input id="eflyer_image_'.$field['id'].'" type="hidden" name="'.$field['id'].'" value="' . esc_attr($meta) . '" />
                        <div class="eflyer_image_container" id="eflyer_image_container_'.$field['id'].'"><span class="eflyer_image_close" data-fieldid="'.$field['id'].'"><img id="'.$meta.'" src="' . wp_get_attachment_thumb_url($meta) . '"></span></div>
                        <button id="eflyer_image_button_'.$field['id'].'" class="eflyer_image_button" data-fieldid="'.$field['id'].'" >Add/Edit Image</button>
                        ';
				echo '<br><p><small>'.$field['desc'].'</small></p>';
				break;

			case 'text':
				$meta = get_post_meta($post->ID, $field['id'], true);

				echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'"  value="' . esc_attr($meta) . '" style="min-width:50%" />';
				echo '<br><p><small>'.$field['desc'].'</small></p>';
				break;
		} //end switch
		echo '</td></tr>';
	} // end foreach
	echo '</table>'; // end table
}
/**
 * Save the metabox
 * @param  Number $post_id The post ID
 * @param  Array  $post    The post data
 */
function _namespace_save_metabox( $post_id, $post ) {
	global $custom_meta_fields_main;
	global $custom_meta_fields_content;
	global $custom_meta_fields_footer;
	// Check autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		return $post_id;
	// Verify user has permission to edit post
	if ( !current_user_can( 'edit_post', $post->ID )) {
		return $post->ID;
	}

// Loop through meta fields
	foreach ($custom_meta_fields_main as $field) {
		$new_meta_value = esc_attr($_POST[$field['id']]);
		$meta_key = $field['id'];
		$meta_value = get_post_meta( $post_id, $meta_key, true );

		// If theres a new meta value and the existing meta value is empty
		if ( $new_meta_value && $meta_value == null ) {
			add_post_meta( $post_id, $meta_key, $new_meta_value, true );
			// If theres a new meta value and the existing meta value is different
		} elseif ( $new_meta_value && $new_meta_value != $meta_value ) {
			update_post_meta( $post_id, $meta_key, $new_meta_value );
		} elseif ( $new_meta_value == null && $meta_value ) {
			delete_post_meta( $post_id, $meta_key, $meta_value );
		}
	}

}
add_action( 'save_post', '_namespace_save_metabox', 1, 2 );


/*Help functions*/
// Get image ID from URL
function eflyer_get_image_id($image_url) {
	global $wpdb;
	$attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url ));
	return $attachment[0];
}
// Register admin scripts for custom fields
function eflyer_load_wp_admin_style() {
	wp_enqueue_media();
	wp_enqueue_script('media-upload');
	wp_enqueue_style( 'shift8_portfolio_admin_css', plugin_dir_url(dirname(__FILE__)) . 'tg-menu-microsites/css/shift8_portfolio_admin.css' );
	wp_enqueue_script( 'eflyer_admin_script', plugin_dir_url(dirname(__FILE__)) . 'tg-menu-microsites/js/eflyer-admin.js' );

}

add_action( 'admin_enqueue_scripts', 'eflyer_load_wp_admin_style' );
//add_action( 'wp_enqueue_scripts', 'eflyer_load_wp_admin_style' );

/*Helping functions*/
add_filter('enter_title_here', 'my_title_place_holder' , 20 , 2 ); //to change the default title placeholder
function my_title_place_holder($title , $post){

	if( $post->post_type == 'tgmicrosite' ){
		$my_title = "Enter building or microsite name";
		return $my_title;
	}
	return $title;
}

/*Bring microsites*/
function get_microsites(){
			$sites = get_posts(
				array(
					'showposts' => -1,
					'post_type' => 'tgmicrosite',
					'orderby' => 'menu_order',
					'post_status'=> 'publish',
					'order' => 'asc'
				)
			);
			if (count($sites)>1){
				echo '<div class="wp_tg_microsites">';
					echo '<div class="carousel_tg_neighborhood  gs-container-slider">';
					foreach ($sites as $site){	
						$imageid = get_post_meta($site->ID,'eflyer_image',true);
						$image = wp_get_attachment_url($imageid);
						$neighborhood = get_post_meta($site->ID,'eflyer_neighborhood',true);					
						$url = get_post_meta($site->ID,'eflyer_siteurl',true);					
						echo '<div>';
							echo '<div class="item_tg_neigh">';
								echo '<div class="figure_tg"><img src="'.$image.'" alt="'.$site->post_title.'"></div>';
								echo '<h2>'.$site->post_title.'</h2>';
								echo '<h4>'.$neighborhood.'</h4>';
								echo '<a href="'.$url.'"></a>';
							echo '</div>';
						echo '</div>';
					}
					echo '</div>';
				echo '</div>';
			}
			
}

add_shortcode('microsites','get_microsites');
function greatslider() {
	wp_enqueue_style( 'style_microsite', plugin_dir_url(dirname(__FILE__)) . 'tg-menu-microsites/css/style-microsite.css' );
	//wp_enqueue_style( 'styles_great', plugin_dir_url(dirname(__FILE__)) . 'tg-menu-microsites/css/great/styles.css' );
	wp_enqueue_script( 'greatslider_js', plugin_dir_url(dirname(__FILE__)) . 'tg-menu-microsites/js/greatslider.jquery.min.js','','',true );
	wp_enqueue_script( 'script_microsite', plugin_dir_url(dirname(__FILE__)) . 'tg-menu-microsites/js/script-microsite.js','','',true );
	
}
add_action( 'wp_enqueue_scripts', 'greatslider' );