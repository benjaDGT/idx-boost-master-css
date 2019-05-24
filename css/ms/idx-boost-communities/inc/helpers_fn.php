<?php

if (!function_exists('flex_idx_get_info_for_neighboardhood')) {
    function flex_idx_get_info_for_neighboardhood()
    {
        global $wpdb;

        // fetch info
        $idxboost_search_settings = get_option('idxboost_search_settings');
        $idxboost_pusher_settings = get_option('idxboost_pusher_settings');
        $idxboost_agent_info = get_option('idxboost_agent_info');

        $template_name = get_template_directory();
        $template_name = basename($template_name);

        $output = array();

        // basic info
        $output['website_name'] = get_bloginfo('name');
        $output['website_url']  = get_bloginfo('wpurl');
        $output['template_name'] = $template_name;

        $output['template_directory_url']  = get_template_directory_uri();

        #$list_agent_info = $wpdb->get_results('SELECT `key`,`value` FROM flex_idx_settings WHERE `key` LIKE "agent_%"', ARRAY_A);
        #$output['agent'] = flex_map_array($list_agent_info);
        $output['agent']['agent_first_name'] = isset($idxboost_agent_info['first_name']) ? $idxboost_agent_info['first_name'] : '';
        $output['agent']['agent_last_name'] = isset($idxboost_agent_info['last_name']) ? $idxboost_agent_info['last_name'] : '';
        $output['agent']['agent_email_address'] = isset($idxboost_agent_info['email_address']) ? $idxboost_agent_info['email_address'] : '';
        $output['agent']['agent_phone_number'] = isset($idxboost_agent_info['phone_number']) ? $idxboost_agent_info['phone_number'] : '';
        $output['agent']['agent_address'] = isset($idxboost_agent_info['address']) ? $idxboost_agent_info['address'] : '';
        $output['agent']['agent_city'] = isset($idxboost_agent_info['city']) ? $idxboost_agent_info['city'] : '';
        $output['agent']['agent_state'] = isset($idxboost_agent_info['state']) ? $idxboost_agent_info['state'] : '';
        $output['agent']['agent_zip_code'] = isset($idxboost_agent_info['zip_code']) ? $idxboost_agent_info['zip_code'] : '';
        $output['agent']['agent_website_url'] = isset($idxboost_agent_info['website_url']) ? $idxboost_agent_info['website_url'] : '';
        $output['agent']['agent_contact_first_name'] = isset($idxboost_agent_info['contact_first_name']) ? $idxboost_agent_info['contact_first_name'] : '';
        $output['agent']['agent_contact_last_name'] = isset($idxboost_agent_info['contact_last_name']) ? $idxboost_agent_info['contact_last_name'] : '';
        $output['agent']['agent_contact_email_address'] = isset($idxboost_agent_info['contact_email_address']) ? $idxboost_agent_info['contact_email_address'] : '';
        $output['agent']['agent_contact_phone_number'] = isset($idxboost_agent_info['contact_phone_number']) ? $idxboost_agent_info['contact_phone_number'] : '';
        $output['agent']['agent_contact_photo_profile'] = isset($idxboost_agent_info['contact_photo_profile']) ? $idxboost_agent_info['contact_photo_profile'] : '';
        $output['agent']['agent_logo_file'] = isset($idxboost_agent_info['agent_logo_file']) ? $idxboost_agent_info['agent_logo_file'] : '';
        $output['agent']['broker_logo_file'] = isset($idxboost_agent_info['broker_logo_file']) ? $idxboost_agent_info['broker_logo_file'] : '';
        $output['agent']['agent_address_lat'] = isset($idxboost_agent_info['address_lat']) ? $idxboost_agent_info['address_lat'] : '';
        $output['agent']['agent_address_lng'] = isset($idxboost_agent_info['address_lng']) ? $idxboost_agent_info['address_lng'] : '';
        $output['agent']['force_registration'] = isset($idxboost_agent_info['force_registration']) ? (int) $idxboost_agent_info['force_registration'] : 0;
        $output['agent']['user_show_quizz'] = isset($idxboost_agent_info['user_show_quizz']) ? (int) $idxboost_agent_info['user_show_quizz'] : 0;
        $output['agent']['facebook_app_id'] = isset($idxboost_agent_info['facebook_app_id']) ? $idxboost_agent_info['facebook_app_id'] : "";
        $output['agent']['google_client_id'] = isset($idxboost_agent_info['google_client_id']) ? $idxboost_agent_info['google_client_id'] : "";
        $output['agent']['google_client_id'] = isset($idxboost_agent_info['google_client_id']) ? $idxboost_agent_info['google_client_id'] : "";
        $output['agent']['facebook_login_enabled'] = isset($idxboost_agent_info['facebook_login_enabled']) ? $idxboost_agent_info['facebook_login_enabled'] : false;
        $output['agent']['google_login_enabled'] = isset($idxboost_agent_info['google_login_enabled']) ? $idxboost_agent_info['google_login_enabled'] : false;
        $output['agent']['google_maps_api_key'] = isset($idxboost_agent_info['google_maps_api_key']) ? $idxboost_agent_info['google_maps_api_key'] : "";
        $output['agent']['google_analytics'] = isset($idxboost_agent_info['google_analytics']) ? $idxboost_agent_info['google_analytics'] : "";
        $output['agent']['google_maps_api_key'] = isset($idxboost_agent_info['google_maps_api_key']) ? $idxboost_agent_info['google_maps_api_key'] : "";
        $output['agent']['google_adwords'] = isset($idxboost_agent_info['google_adwords']) ? $idxboost_agent_info['google_adwords'] : "";
        $output['agent']['facebook_pixel'] = isset($idxboost_agent_info['facebook_pixel']) ? $idxboost_agent_info['facebook_pixel'] : "";

        // social info
        #$list_social_info = $wpdb->get_results('SELECT `key`,`value` FROM flex_idx_settings WHERE `key` LIKE "%_social_url"', ARRAY_A);
        #$output['social'] = flex_map_array($list_social_info);

        return $output;
    }
}

if (!function_exists('communities_admin_register_assets')) {
    function communities_admin_register_assets()
    {   
        $flex_idx_info_neigh         = flex_idx_get_info_for_neighboardhood();
        wp_enqueue_style( 'idx-communities-admin-css', COMMUNITIES_IDX_URI . 'css/admin_communities.css', array(), COMMUNITIES_IDX_VERSION );
        wp_enqueue_script( 'google-maps-js', 'https://maps.googleapis.com/maps/api/js?v=3&libraries=drawing&key=' . $flex_idx_info_neigh["agent"]["google_maps_api_key"], array('jquery'), COMMUNITIES_IDX_VERSION, true );
        // wp_enqueue_script( 'markerwithlabel-packed-js', COMMUNITIES_IDX_URI . 'js/markerwithlabel_packed.js', array('jquery'), COMMUNITIES_IDX_VERSION);
        wp_enqueue_script( 'infobox-packed-js', COMMUNITIES_IDX_URI . 'js/infobox_packed.js', array('jquery'), COMMUNITIES_IDX_VERSION, true );
        wp_enqueue_script( 'gmap-draw-js', COMMUNITIES_IDX_URI . 'js/jquery.gmap-draw.js', array('jquery'), COMMUNITIES_IDX_VERSION, true );
        wp_enqueue_script( 'GDouglasPeuker-js', COMMUNITIES_IDX_URI . 'js/GDouglasPeuker.js', array('jquery'), COMMUNITIES_IDX_VERSION, true );
        wp_enqueue_script( 'idx-communities-admin-js', COMMUNITIES_IDX_URI . 'js/admin_communities.js', array('jquery'), COMMUNITIES_IDX_VERSION, true );
        wp_localize_script('idx-communities-admin-js', 'dgtCredential', array('ajaxUrl' => admin_url('admin-ajax.php')));
    }
}

if(!function_exists('dgt_get_geocode_communities_fn')) {
    function dgt_get_geocode_communities_fn() {
        $flex_idx_info_neigh         = flex_idx_get_info_for_neighboardhood();
        $address='';
        if (!empty($_POST['address'])) {
            $address = $_POST['address'];
        }
        $address = str_replace(' ', '+', $address);
        $url_service = sprintf('https://maps.googleapis.com/maps/api/geocode/json?address=%s&key=%s', $address, $flex_idx_info_neigh["agent"]["google_maps_api_key"]);
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


function dgt_load_communities_fn( ) {
    $only_special =  $_POST['only_special'];
    $counter =  $_POST['counter'];
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

    $label_url = COMMUNITIES_IDX_NAME . '_url';
    $label_address = DGTIDX_PREFIX . '_extra_address';
    $label_lat = DGTIDX_PREFIX . '_extra_lat';
    $label_lng = DGTIDX_PREFIX . '_extra_lng';
    $label_geometry = DGTIDX_PREFIX . '_map_geometry';

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



class IdxboostPagTemplateCommunities {

    private static $instance;
    protected $templates;

    public static function get_instance() {

        if ( null == self::$instance ) {
            self::$instance = new IdxboostPagTemplateCommunities();
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
            'flex-page-communities.php' => 'TG Communities Collection',
            'flex-page-communities-detail-silo.php' => 'TG Communities Details',
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

        $file = COMMUNITIES_IDX_PATH.'views/template/'. get_post_meta(  $post->ID, '_wp_page_template', true );

        if ( file_exists( $file ) ) {
            return $file;
        } else {
            echo $file;
        }
        return $template;
    }
} 
add_action( 'plugins_loaded', array( 'IdxboostPagTemplateCommunities', 'get_instance' ) );