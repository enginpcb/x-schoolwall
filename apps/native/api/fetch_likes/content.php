<?php 
# @*************************************************************************@
# @ @author 松果商城									@
# @ @author_url 1: https://www.bygoukai.com/                      @
# @ @author_url 2: https://www.bygoukai.com/                     @
# @ @author_email: 18581281315@163l.com                                @
# @*************************************************************************@
# @ 松果商城- The Ultimate Modern Social Media Sharing Platform           @
# @ Copyright (c) 21.05.2021 松果商城All rights reserved.                @
# @*************************************************************************@

$post_id   = fetch_or_get($_GET['post_id'], null);
$post_data = cl_raw_post_data($post_id);
$offset    = fetch_or_get($_GET['offset'], null);
$offset    = (is_posnum($offset)) ? $offset : null;
$limit     = fetch_or_get($_GET['page_size'], 15);
$limit     = (is_posnum($limit)) ? $limit: 15;

if (not_empty($post_data)) {
	$post_likes = cl_get_post_likes($post_id, $limit, $offset);

	if (not_empty($post_likes)) {
		$data['valid']    = true;
		$data['code']     = 200;
	    $data['message']  = "Likes fetched successfully";
		$data['data']     = $post_likes;
	}
	else {
		$data['code']     = 404;
	    $data['message']  = "No data found";
		$data['data']     = array();
	}
} 

else {
	$data['code']     = 400;
    $data['err_code'] = "invalid_request_data";
    $data['message']  = "Post id is missing or invalid";
	$data['data']     = array();
}