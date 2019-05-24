<?php
// load assets for admin
add_action('admin_enqueue_scripts', 'communities_admin_register_assets');

// update geocode in admin
add_action('wp_ajax_dgt_get_geocode_communities', 'dgt_get_geocode_communities_fn');
add_action('wp_ajax_nopriv_dgt_get_geocode_communities', 'dgt_get_geocode_communities_fn');

add_action('wp_ajax_dgt_load_communities', 'dgt_load_communities_fn');
add_action('wp_ajax_nopriv_dgt_load_communities', 'dgt_load_communities_fn');