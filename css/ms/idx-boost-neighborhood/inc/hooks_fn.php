<?php
// load assets for admin
add_action('admin_enqueue_scripts', 'neighborhood_admin_register_assets');

// update geocode in admin
add_action('wp_ajax_dgt_get_geocode', 'dgt_get_geocode_fn');
add_action('wp_ajax_nopriv_dgt_get_geocode', 'dgt_get_geocode_fn');

add_action('wp_ajax_dgt_load_neighborhoods', 'dgt_load_neighborhoods_fn');
add_action('wp_ajax_nopriv_dgt_load_neighborhoods', 'dgt_load_neighborhoods_fn');