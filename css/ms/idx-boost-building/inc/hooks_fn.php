<?php
// load assets for admin
add_action('admin_enqueue_scripts', 'buildings_admin_register_assets');

// update geocode in admin
add_action('wp_ajax_dgt_get_geocode_buildings', 'dgt_get_geocode_buildings_fn');
add_action('wp_ajax_nopriv_get_geocode_buildings', 'dgt_get_geocode_buildings_fn');

add_action('wp_ajax_dgt_load_buildings', 'dgt_load_buildings_fn');
add_action('wp_ajax_nopriv_dgt_load_buildings', 'dgt_load_buildings_fn');

add_action('wp_ajax_dgt_search_buildings', 'dgt_search_buildings_fn');
add_action('wp_ajax_nopriv_dgt_search_buildings', 'dgt_search_buildings_fn');

add_action('wp_ajax_dgt_search_buildings_autocomplete', 'dgt_search_buildings_autocomplete_fn');
add_action('wp_ajax_nopriv_dgt_search_buildings_autocomplete', 'dgt_search_buildings_autocomplete_fn');

add_action('wp_ajax_search_buildings_test', 'get_feed_file_building');
add_action('wp_ajax_nopriv_search_buildings_test', 'get_feed_file_building');