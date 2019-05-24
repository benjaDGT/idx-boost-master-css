<?php
/**
 * Plugin Name: TG - Communities
 * Description: 
 * Version: 1.0.0
 * Plugin URI: https://www.idxboost.com
 * Author: IDX Boost
 * Author URI: https://www.idxboost.com
 */

defined('ABSPATH') or exit;

/**
 * Define constants
 */
//communities
global $flex_idx_info;

define('COMMUNITIES_IDX_PATH', plugin_dir_path(__FILE__));
define('COMMUNITIES_IDX_URI', plugin_dir_url(__FILE__));
define('COMMUNITIES_IDX_VERSION', '1.0.0');
define('COMMUNITIES_IDX_NAME', 'Communities');

//Temporal Constant
if (empty( get_theme_mod( 'idx_social_media' )['google_maps'] ))  $idx_social_mediamaps  = ''; else  $idx_social_mediamaps  = get_theme_mod( 'idx_social_media')['google_maps'];
if (empty( get_theme_mod( 'idx_social_media' )['google_geocode_maps'] ))  $idx_social_mediagoogle_geocode_maps  = ''; else  $idx_social_mediagoogle_geocode_maps  = get_theme_mod( 'idx_social_media')['google_geocode_maps'];

define('COMMUNITIES_GOOGLE_MAP_KEY', $flex_idx_info["agent"]["google_maps_api_key"] );
define('COMMUNITIES_GOOGLE_GEOCODE_KEY', $idx_social_mediagoogle_geocode_maps);

define('DGTIDX_PREFIX_COMMUNITIES', 'dgt');


require COMMUNITIES_IDX_PATH . '/inc/helpers_fn.php';


require COMMUNITIES_IDX_PATH . '/inc/posttypes_fn.php';

/**
 * Define actions
 */

require COMMUNITIES_IDX_PATH . '/inc/hooks_fn.php';

require COMMUNITIES_IDX_PATH . '/inc/shortcodes_fn.php';


if (!function_exists('tg_communities_social_maps')) {
	
function tg_communities_social_maps($wp_customize){

    $wp_customize->add_section('idx_social_media_customizer_scheme', array('title'    => __('Social Networks Setup', 'idx_social_media_customizer'),'priority' => 101,));

$wp_customize->add_setting('idx_social_media[google_maps]', array('capability' => 'edit_theme_options', 'default' => '', 'sanitize_callback' => 'sanitize_text_field'));
$wp_customize->add_control('idx_social_media[google_maps]', array('type' => 'text', 'section' => 'idx_social_media_customizer_scheme', 'label' => __('Google MAP APi Keys'), 'settings' => 'idx_social_media[google_maps]'));
$wp_customize->selective_refresh->add_partial('idx_social_media[google_maps]', array('selector' => '.idx_social_media_google_maps', 'render_callback' => array($wp_customize, '_idx_social_media_google_maps'), 'container_inclusive' => true));

$wp_customize->add_setting('idx_social_media[google_geocode_maps]', array('capability' => 'edit_theme_options', 'default' => '', 'sanitize_callback' => 'sanitize_text_field'));
$wp_customize->add_control('idx_social_media[google_geocode_maps]', array('type' => 'text', 'section' => 'idx_social_media_customizer_scheme', 'label' => __('Google MAP Geocode APi Keys'), 'settings' => 'idx_social_media[google_geocode_maps]'));
$wp_customize->selective_refresh->add_partial('idx_social_media[google_geocode_maps]', array('selector' => '.idx_social_media_google_maps', 'render_callback' => array($wp_customize, '_idx_social_google_geocode_maps'), 'container_inclusive' => true));

}
add_action('customize_register', 'tg_communities_social_maps');
}