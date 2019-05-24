<?php
/**
 * Plugin Name: TG - Neighborhoods
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

define('NEIGHBORHOOD_IDX_PATH', plugin_dir_path(__FILE__));
define('NEIGHBORHOOD_IDX_URI', plugin_dir_url(__FILE__));
define('NEIGHBORHOOD_IDX_VERSION', '1.0.0');
define('NEIGHBORHOOD_IDX_NAME', 'neighborhood');

//Temporal Constant
if (empty( get_theme_mod( 'idx_social_media' )['google_maps'] ))  $idx_social_mediamaps  = ''; else  $idx_social_mediamaps  = get_theme_mod( 'idx_social_media')['google_maps'];
if (empty( get_theme_mod( 'idx_social_media' )['google_geocode_maps'] ))  $idx_social_mediagoogle_geocode_maps  = ''; else  $idx_social_mediagoogle_geocode_maps  = get_theme_mod( 'idx_social_media')['google_geocode_maps'];
define('NEIGHBORHOOD_GOOGLE_MAP_KEY', $idx_social_mediamaps );
define('NEIGHBORHOOD_GOOGLE_GEOCODE_KEY', $idx_social_mediagoogle_geocode_maps);
//'AIzaSyD_AYpfZKSAVljjPNR0WehEeGy7cj-xLB0'
define('DGTIDX_PREFIX', 'dgt');

// if (empty( get_theme_mod( 'idx_social_media' )['google_maps'] ))  $idx_social_mediamaps  = ''; else  $idx_social_mediamaps  = get_theme_mod( 'idx_social_media')['google_maps'];
// define('NEIGHBORHOOD_GOOGLE_MAP_KEY', $idx_social_mediamaps );

// define('FLEX_IDX_BASE_URL', 'https://api.idxboost.com');
// define('FLEX_IDX_CPANEL_URL', 'https://cpanel.idxboost.com');
// define('IDX_BOOTS_NICHE', 'https://alerts.flexidx.com/niche/filter/parameters');
// define('IDXBOOST_GITHUB_USERNAME', 'dgtalliance');
// define('IDXBOOST_GITHUB_ACCESS_TOKEN', 'e29ce38be63decdf51e979519ff62dc94c68467f');


/**
 * Import Third Partie Libraries
 */
// require FLEX_IDX_PATH . '/inc/Parsedown.php';
// require FLEX_IDX_PATH . '/idxboost-updater.php';
// require FLEX_IDX_PATH . '/idxboost-theme-updater.php';
// require FLEX_IDX_PATH . '/idxboost-rest.php';

/**
 * Define helpers
 */

require NEIGHBORHOOD_IDX_PATH . '/inc/helpers_fn.php';

/**
 * Define global variables
 */

// $flex_idx_pages_static = flex_idx_get_list_pages_fn();
// $flex_idx_info         = flex_idx_get_info();
// $flex_idx_lead         = is_flex_user_logged_in();

/**
 * Define addons
 */

// require FLEX_IDX_PATH . '/addons/idx-boost-testimonial/idx-boost-testimonial.php';

/**
 * Define post types
 */

require NEIGHBORHOOD_IDX_PATH . '/inc/posttypes_fn.php';

/**
 * Define actions
 */

require NEIGHBORHOOD_IDX_PATH . '/inc/hooks_fn.php';

/**
 * Define shortcodes
 */

require NEIGHBORHOOD_IDX_PATH . '/inc/shortcodes_fn.php';

/**
 * Define hooks for activation and deactivation plugin
 */
// JA
// register_activation_hook(__FILE__, 'flex_idx_on_activation');
// register_deactivation_hook(__FILE__, 'flex_idx_on_deactivation');
// register_uninstall_hook(__FILE__, 'flex_idx_on_uninstall');

// plugin updater
// $IDXBoostUpdater = new IDXBoostUpdater(__FILE__);
// $IDXBoostUpdater->set_username(IDXBOOST_GITHUB_USERNAME);
// $IDXBoostUpdater->set_repository('idx-boost');
// $IDXBoostUpdater->authorize(IDXBOOST_GITHUB_ACCESS_TOKEN);
// $IDXBoostUpdater->initialize();

// themes updater
// $whitelist_themes = array("millenniumib", "fortuneib", "relatedisgib", "resfib", "edgeib", "minimalib");
// $theme_instances_check = array();
//
// foreach($whitelist_themes as $index => $idxboost_theme) {
//   $theme_instances_check[$index] = new IDXBoostThemeUpdater($idxboost_theme);
//   $theme_instances_check[$index]->set_username(IDXBOOST_GITHUB_USERNAME);
//   $theme_instances_check[$index]->set_repository($idxboost_theme);
//   $theme_instances_check[$index]->authorize(IDXBOOST_GITHUB_ACCESS_TOKEN);
//   $theme_instances_check[$index]->initialize();
// }

if (!function_exists('tg_neigthboardhood_social_maps')) {
	
function tg_neigthboardhood_social_maps($wp_customize){

    $wp_customize->add_section('idx_social_media_customizer_scheme', array('title'    => __('Social Networks Setup', 'idx_social_media_customizer'),'priority' => 101,));

$wp_customize->add_setting('idx_social_media[google_maps]', array('capability' => 'edit_theme_options', 'default' => '', 'sanitize_callback' => 'sanitize_text_field'));
$wp_customize->add_control('idx_social_media[google_maps]', array('type' => 'text', 'section' => 'idx_social_media_customizer_scheme', 'label' => __('Google MAP APi Keys'), 'settings' => 'idx_social_media[google_maps]'));
$wp_customize->selective_refresh->add_partial('idx_social_media[google_maps]', array('selector' => '.idx_social_media_google_maps', 'render_callback' => array($wp_customize, '_idx_social_media_google_maps'), 'container_inclusive' => true));

$wp_customize->add_setting('idx_social_media[google_geocode_maps]', array('capability' => 'edit_theme_options', 'default' => '', 'sanitize_callback' => 'sanitize_text_field'));
$wp_customize->add_control('idx_social_media[google_geocode_maps]', array('type' => 'text', 'section' => 'idx_social_media_customizer_scheme', 'label' => __('Google MAP Geocode APi Keys'), 'settings' => 'idx_social_media[google_geocode_maps]'));
$wp_customize->selective_refresh->add_partial('idx_social_media[google_geocode_maps]', array('selector' => '.idx_social_media_google_maps', 'render_callback' => array($wp_customize, '_idx_social_google_geocode_maps'), 'container_inclusive' => true));

}
add_action('customize_register', 'tg_neigthboardhood_social_maps');
}