<?php

add_action('init', 'agents_specialities_pt');
add_action('init', 'agents_specialities_taxonomies' );

add_action('admin_init', 'agents_specialities_register_metaboxes');
add_action('save_post', 'agents_specialities_metaboxes_save');

add_shortcode('agents_dgt', 'agents_specialities_sc');

// register post type
function agents_specialities_pt() {
	$args = array(
		'label' => AGENT_PT_NAME,
		'menu_icon' => 'dashicons-groups',
		'capability_type' => 'post',
		'public' => TRUE,
		'show_ui' => TRUE,
		'show_in_nav_menus' => TRUE,
		'show_in_menu' => true,
		'query_var' => true,
		'rewrite' => array('slug' => 'agents'),
        'has_archive' => false,
		'supports' => array('title', 'editor',  'thumbnail', 'excerpt', 'page-attributes'),
	);
	register_post_type(AGENT_PT_SLUG, $args);
}

// register metaboxes
function agents_specialities_register_metaboxes() {
	add_meta_box('agents-speciality-title', 'Associate Information ','agents_specialities_metabox_title_render', AGENT_PT_SLUG);
	add_meta_box('agents-speciality-fb','Social Networks','agents_specialities_metabox_fb_render',AGENT_PT_SLUG);
	add_meta_box('agents-speciality-shortdescription','My Listings','agents_specialities_metabox_short_description_render',AGENT_PT_SLUG);
}

function agents_specialities_metabox_title_render($post) {
	$title = get_post_meta($post->ID, '_agents_speciality_title', true);
    $phone = get_post_meta($post->ID, '_agents_speciality_phone', true);
    $phone_office = get_post_meta($post->ID, '_agents_speciality_phone_office', true);
    $email = get_post_meta($post->ID, '_agents_speciality_email', true);
	include OF_PLUGIN_BASE_PATH.'views/metaboxes/speciality-info.php';
}



function agents_specialities_metabox_fb_render($post) {
	$fb = get_post_meta($post->ID, '_agents_speciality_fb', true);
    $tw = get_post_meta($post->ID, '_agents_speciality_tw', true);
    $in = get_post_meta($post->ID, '_agents_speciality_in', true);
    $inst = get_post_meta($post->ID, '_agents_speciality_inst', true);
    $rating = get_post_meta($post->ID, '_agents_speciality_rating', true);
	include OF_PLUGIN_BASE_PATH.'views/metaboxes/speciality-networks.php';
}

function agents_specialities_metabox_short_description_render($post) {
	$agent_idx = get_post_meta($post->ID, '_agents_speciality_agent_idx', true);
	$office_idx = get_post_meta($post->ID, '_agents_speciality_office_idx', true);
	include OF_PLUGIN_BASE_PATH.'views/metaboxes/speciality-shortdescription.php';
}

function agents_specialities_metaboxes_save($post_id){
	// Checks save status
	$is_autosave = wp_is_post_autosave( $post_id );
	$is_revision = wp_is_post_revision( $post_id );

	// Exits script depending on save status
	if ( $is_autosave || $is_revision ) {
		return;
	}
	$_agents_speciality_agent_idx = isset($_POST['_agents_speciality_agent_idx']) ? sanitize_text_field($_POST['_agents_speciality_agent_idx']) : '';
	$_agents_speciality_office_idx = isset($_POST['_agents_speciality_office_idx']) ? sanitize_text_field($_POST['_agents_speciality_office_idx']) : '';

	$_agents_speciality_title = isset($_POST['_agents_speciality_title']) ? sanitize_text_field($_POST['_agents_speciality_title']) : '';
	$_agents_speciality_email = isset($_POST['_agents_speciality_email']) ? sanitize_text_field($_POST['_agents_speciality_email']) : '';

	$_agents_speciality_phone = isset($_POST['_agents_speciality_phone']) ? sanitize_text_field($_POST['_agents_speciality_phone']) : '';
	$_agents_speciality_phone_office = isset($_POST['_agents_speciality_phone_office']) ? sanitize_text_field($_POST['_agents_speciality_phone_office']) : '';

	$_agents_speciality_fb = isset($_POST['_agents_speciality_fb']) ? sanitize_text_field($_POST['_agents_speciality_fb']) : '';
	$_agents_speciality_tw = isset($_POST['_agents_speciality_tw']) ? sanitize_text_field($_POST['_agents_speciality_tw']) : '';
	$_agents_speciality_in = isset($_POST['_agents_speciality_in']) ? sanitize_text_field($_POST['_agents_speciality_in']) : '';
	$_agents_speciality_inst = isset($_POST['_agents_speciality_inst']) ? sanitize_text_field($_POST['_agents_speciality_inst']) : '';

	update_post_meta($post_id, '_agents_speciality_agent_idx', $_agents_speciality_agent_idx);
	update_post_meta($post_id, '_agents_speciality_office_idx', $_agents_speciality_office_idx);

	update_post_meta($post_id, '_agents_speciality_title', $_agents_speciality_title);
	update_post_meta($post_id, '_agents_speciality_email', $_agents_speciality_email);

	update_post_meta($post_id, '_agents_speciality_phone', $_agents_speciality_phone);
	update_post_meta($post_id, '_agents_speciality_phone_office', $_agents_speciality_phone_office);

	update_post_meta($post_id, '_agents_speciality_fb', $_agents_speciality_fb);
	update_post_meta($post_id, '_agents_speciality_tw', $_agents_speciality_tw);
	update_post_meta($post_id, '_agents_speciality_in', $_agents_speciality_in);
	update_post_meta($post_id, '_agents_speciality_inst', $_agents_speciality_inst);
}

// register taxonomy
function agents_specialities_taxonomies() {
	register_taxonomy(
		'agents',
        AGENT_PT_SLUG,
		array(
			'label' => __( 'Category ' ),
			'rewrite' => array( 'slug' => 'agents' ),
			'hierarchical' => true,
		)
	);
    register_taxonomy(
        'language',
        AGENT_PT_SLUG,
        array(
            'hierarchical' => false,
            'label' => 'Language',
            'query_var' => true,
            'rewrite' => true
        )
    );
    flush_rewrite_rules();
}

// register shortcode
function agents_specialities_sc($atts, $content = null) {
	extract(shortcode_atts(array(
		'category' => '',
		'format' => 'grid'
	), $atts));

	ob_start();

	switch($format) {
		case 'grid':
			include OF_PLUGIN_BASE_PATH.'views/shortcodes/loop-grid.php';
			break;
		case 'list':
			$query_args_list = array(
				'post_type' => AGENT_PT_SLUG,
				'posts_per_page' => 6,
				'tax_query' => array(
					array(
						'taxonomy' => 'agents',
						'field' => 'slug',
						'operator' => 'IN',
						'terms' => $category,
						'include_children' => false
					)
				),
				'orderby' => 'post_date',
				'order' => 'desc'
			);

			$loop_list = new WP_Query($query_args_list);

			include OF_PLUGIN_BASE_PATH.'views/shortcodes/loop-list.php';
			break;
		case 'linkable':
			$query_args_grid = array(
				'post_type' => AGENT_PT_SLUG,
				'posts_per_page' => 6,
				'tax_query' => array(
					array(
						'taxonomy' => 'agents',
						'field' => 'slug',
						'operator' => 'IN',
						'terms' => $category,
						'include_children' => false
					)
				),
				'orderby' => 'post_date',
				'order' => 'desc'
			);

			$loop_linkable = new WP_Query($query_args_grid);

			include OF_PLUGIN_BASE_PATH.'views/shortcodes/loop-linkable.php';
			break;
	}

	$output = ob_get_clean();

	return $output;
}

/* customs columns listing post type */
add_filter(sprintf('manage_%s_posts_columns', AGENT_PT_SLUG), 'manage_columns');
add_filter(sprintf('manage_%s_posts_custom_column', AGENT_PT_SLUG),  'manage_post_columns', 10, 2);

function manage_columns($posts_columns = array()) {
	$default = array('cb','image', 'title', 'category','order', 'date');
	$new_posts_columns = array();
	foreach ($default as $k) {
		switch ($k) {
			case 'category': $new_posts_columns[$k] = 'Category'; break;
            case 'image':  $new_posts_columns[$k] = 'Image'; break;
			case 'order': $new_posts_columns[$k] = 'Order'; break;
			default: $new_posts_columns[$k] = isset($posts_columns[$k]) ? $posts_columns[$k] : '';
				break;
		}
	}
	return $new_posts_columns;
}

function manage_post_columns($column_name, $ID) {
    global $post;
	switch ($column_name) {
        case 'order':
            $order = $post->menu_order;
            echo $order;
            break;
        case 'image':
            $attr = get_post_meta($ID, '_thumbnail_id');
            $att_id = $attr[0];
            if ($att_id > 0) {
                $src = wp_get_attachment_image_src($att_id, 'thumbnail');
                if (!empty($src)) {
                    $image = $src[0];
                    echo sprintf('<img src="%s" width="60" height="60" />', $image);
                }
            }
            break;
		case 'category':
			$taxonomies = get_the_terms( $ID, 'agents' );
			$labels = array();
			if ($taxonomies != false) {
				foreach($taxonomies as $taxonomy){
					$labels[] = $taxonomy->name;
				}
			}
			echo implode($labels, ', ');
			break;
	}
}

function function_single_agent($single_template)
{
    global $post;
    if ($post->post_type == 'agent') {
          $single_template = OF_PLUGIN_BASE_PATH . 'views/shortcodes/single-agent.php';
    }
    return $single_template;
}
add_filter('single_template', 'function_single_agent');



class IdxboostPagTemplateAgents {

    private static $instance;
    protected $templates;

    public static function get_instance() {

        if ( null == self::$instance ) {
            self::$instance = new IdxboostPagTemplateAgents();
        } 

        return self::$instance;
    } 

    private function __construct() {

        $this->templates = array();

        if ( version_compare( floatval( get_bloginfo( 'version' ) ), '4.7', '<' ) ) {
            add_filter('page_attributes_dropdown_pages_args', array( $this, 'register_project_templates' ) );
        } else {
            add_filter('theme_page_templates', array( $this, 'add_new_template' ) );
        }

        add_filter('wp_insert_post_data', array( $this, 'register_project_templates' )  );

        add_filter('template_include', array( $this, 'view_project_template') );

        $this->templates = array(
            'idxboost-agent-view-grid.php' => 'TG Agents Collection',
        );
    } 

    public function add_new_template( $posts_templates ) {
        $posts_templates = array_merge( $posts_templates, $this->templates );
        return $posts_templates;
    }

    public function register_project_templates( $atts ) {
        $cache_key = 'page_templates-' . md5( get_theme_root() . '/' . get_stylesheet() );
        $templates = wp_get_theme()->get_page_templates();
        if ( empty( $templates ) ) {
            $templates = array();
        } 

        wp_cache_delete( $cache_key , 'themes');
        $templates = array_merge( $templates, $this->templates );
        wp_cache_add( $cache_key, $templates, 'themes', 1800 );
        return $atts;
    } 

    public function view_project_template( $template ) {
        global $post;

        if ( ! $post ) { return $template; }

        if ( ! isset( $this->templates[get_post_meta( 
            $post->ID, '_wp_page_template', true 
        )] ) ) {
            return $template;
        } 

        $file = OF_PLUGIN_BASE_PATH.'views/template/'. get_post_meta(  $post->ID, '_wp_page_template', true );

        if ( file_exists( $file ) ) {
            return $file;
        } else {
            echo $file;
        }
        return $template;
    }
} 
add_action( 'plugins_loaded', array( 'IdxboostPagTemplateAgents', 'get_instance' ) );