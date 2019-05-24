<?php
/**
 * Plugin Name: DGT - AGENTS
 * Plugin URI: #
 * Description: Provides a bundle of functionality for specialities like custom icon, url and a short description.
 * Author: 
 * Version: 1.0
 * Author URI: #
 */
define('AGENT_PT_NAME', 'Agents');
define('AGENT_PT_SLUG', 'agent');


define('OF_PLUGIN_BASE_PATH', plugin_dir_path(__FILE__));
define('OF_PLUGIN_BASE_URI', plugin_dir_url(__FILE__));

define('OF_LIMIT_POR_PAGES', 6);
define('OF_IMAGE_DEFAULT',  get_template_directory_uri().'/images/blog-default.jpg');

/* Init */
require 'lib/paginator.php';

require OF_PLUGIN_BASE_PATH.'/inc/post_type_fn.php';
require OF_PLUGIN_BASE_PATH.'/inc/helper_fn.php';
require OF_PLUGIN_BASE_PATH.'/inc/controller_fn.php';
