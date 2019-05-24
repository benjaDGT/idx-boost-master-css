<?php


function getPaginator($counter, $current_page, $offset = 24) {
	// Custom Paginator
	$paginator = new Paginator();
	$paginator->setTotalItemsCount($counter);
	$paginator->setItemCountPerPage($offset);
	$paginator->setCurrentPageNumber($current_page);
	$paginator->setPageRange(6);

	$items_count_per_page   = $paginator->getItemCountPerPage();
	$current_page_number    = $paginator->getCurrentPageNumber();
	$total_items_count      = $paginator->getTotalItemsCount();

	$end = $items_count_per_page * $current_page_number;
	$start = ($end - $items_count_per_page) + 1;
	$end = ($end > $total_items_count) ? $total_items_count : $end;

	return array(
		'has_next_page'         => $paginator->hasNext(),
		'items_per_page'        => $items_count_per_page,
		'current_page'          => $current_page_number,
		'total_pages_count'     => $paginator->count(),
		'total_items_count'     => (int)$total_items_count,
		'offset'                => array('start' => $start, 'end' => $end)
	);
}

function getHtmlPaginationNoAjax($pagination, $request_url) {
	$current_page  = (int)$pagination['current_page'];
	$total_pages   = (int)$pagination['total_pages_count'];
	if($current_page === 1 && $total_pages === 1) return '';
	if( $current_page> 0 && $total_pages > 0) {
		if($total_pages >= 1) {
			if($current_page > 1) {
				$outPrev = sprintf('<li class="previous"><a href="%s%s" rel="nofollow"">Previus </a>', $request_url, ($current_page - 1));
			}
			if($current_page < $total_pages) {
				$outNext = sprintf('<li class="next"><a href="%s%s" rel="nofollow">Next</a></li>', $request_url, ($current_page + 1));
			}
			$numOffsetBtn = 2;
			$lis = '';
			$a = $b = $current_page;
			if( $a > $numOffsetBtn ){ $start =  $a - $numOffsetBtn;
			} else { $start = 1; }

			if( ($b + $numOffsetBtn) > $total_pages ){ $end = $total_pages;
			} else { $end = $b + $numOffsetBtn; }

			for( $x = $start; $x <= $end; $x++) {
				$class = ($x == $current_page)? 'class="active"' : '';
				$lis .= sprintf('<li %s ><a href="%s%s">%s</a></li>', $class, $request_url, $x, $x);
			}
			$outCnt = sprintf('<ul class="pager">%s %s</ul><ul class="pagination">%s</ul>', $outPrev, $outNext, $lis );
			return $outCnt;
		}
	} else {
		return '';
	}
}


function get_request_params() {
	global $wp;
	$request_params =array();
	$wp_request_exp = explode('/', $wp->request);
	foreach($wp_request_exp as $params) {
		list($key, $value) = explode('_', $params);

		if (!empty($value)):
			$request_params[$key] = $value;
		else:
			$request_uri[] = $key;
		endif;
	}
	if(array_key_exists('page', $request_params)) $request_params['page'] = (int)$request_params['page'];
	return array($request_uri, $request_params);
}