<?php

function get_listing_offerts($attrs) {
	global $wpdb;

	list($request_url, $params) = get_request_params();
//	if(isset($attrs['category'])){
//		$condition = sprintf('having category_slug = "%s"', $attrs['category']);
//	}

	$order = 'order by post_date desc';
	$current_page = ((int)$params['page'] > 0)? (int)$params['page'] : 1;
	$qformat = 'select %s
							from %s as p
							inner join wp_term_relationships as r on p.ID = r.object_id
							inner join wp_terms as t on r.term_taxonomy_id = t.term_id and t.slug = "%s"
							where post_type = "%s" and post_status = "publish"
							%s %s';

	$offset = ($current_page - 1) * OF_LIMIT_POR_PAGES;
	$offset = sprintf('limit %d, %d', $offset, OF_LIMIT_POR_PAGES);
	//******************
	$query = sprintf($qformat, 'count(p.ID) as total', $wpdb->posts, $attrs['category'], AGENT_PT_SLUG, '', '');
	$row = $wpdb->get_row($query, ARRAY_A);
	$total = $row['total'];
	//******************
	$query = sprintf($qformat, 'p.ID, post_title, post_name, t.`name` as category_name , t.`slug` as category_slug', $wpdb->posts, $attrs['category'], AGENT_PT_SLUG, $order, $offset);

	$results = $wpdb->get_results($query, ARRAY_A);

	foreach($results as $row) {
		$post_id = $row['ID'];
		$post_thumbnail_id = get_post_thumbnail_id($post_id);
		$row['image'] = ($post_thumbnail_id > 0) ? wp_get_attachment_url($post_thumbnail_id) : OF_IMAGE_DEFAULT;
		$row['price'] = get_post_meta($post_id, '_dgt_speciality_precio', true);
		$row['promo_special'] = get_post_meta($post_id, '_dgt_speciality_link', true);
		$new_results[] = $row;
	}
	$results = $new_results;
	unset($new_results);
	$requestURL = implode($request_url, '/');
	$paginator = getPaginator($total, $current_page, OF_LIMIT_POR_PAGES);
	$data = array(
						'params'      => $params,
						'url'         =>  sprintf('%s/%s', get_bloginfo('url'), $requestURL),
						'query'       => $query,
						'counter'     => (int)$total,
						'pagination'  => $paginator,
						'items'       => $results,
					);
	return $data;
}


if (!function_exists('idx_agents_list_fr')){
  function idx_agents_list_fr($atts) {
    global $wpdb;
        $atts = shortcode_atts(array(
            'view'   => 'list',
            'limit'	 => 'default',
            'title'	 => 'default',
            'button_link'	 => '#',
            'sub_title'	 => 'default'
        ), $atts);

        if ($atts['limit']!='default') {
        	$limit=' limit '.$atts['limit'];
        }

        $query_post_cred="SELECT post_prin.ID,post_prin.post_title,post_prin.post_name,post_prin.post_content,post_prin.post_excerpt,post_prin.post_date,post_image.guid as image
                FROM {$wpdb->posts} post_prin
              left join {$wpdb->postmeta} thumbnail_id on thumbnail_id.post_id=post_prin.ID and thumbnail_id.meta_key='_thumbnail_id'
              left join wp_posts as post_image on post_image.ID=thumbnail_id.meta_value and post_image.post_type='attachment' and post_image.post_status='inherit'
            WHERE post_prin.post_type='agent' and post_prin.post_status='publish' order by post_prin.menu_order,post_prin.post_title asc ".$limit." ;";

        $result_post = $wpdb->get_results($query_post_cred, ARRAY_A);

        include OF_PLUGIN_BASE_PATH.'views/shortcodes/loop-agents-list.php';

    ob_start();
    $output = ob_get_clean();   
    return $output;
  }
  add_shortcode('idx_agents_list', 'idx_agents_list_fr' );
}