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

function cl_get_guest_feed($limit = false, $offset = false) {
	global $db, $cl;

	$data         =  array();
	$sql          =  cl_sqltepmlate("apps/guest/sql/fetch_guest_feed",array(
		"t_posts" => T_POSTS,
		"t_pubs"  => T_PUBS,
		"limit"   => $limit,
		"offset"  => $offset
 	));

	$query_res = $db->rawQuery($sql);

	if (cl_queryset($query_res)) {
		foreach ($query_res as $row) {
			$post_data = cl_raw_post_data($row['publication_id']);
			if (not_empty($post_data) && in_array($post_data['status'], array('active'))) {
				$post_data['offset_id'] = $row['offset_id'];
				$data[]                 = cl_post_data($post_data);
			}
		}
	}

	return $data;
}