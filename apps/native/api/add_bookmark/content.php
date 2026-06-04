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

if (empty($cl['is_logged'])) {
	$data         = array(
		'code'    => 401,
		'data'    => array(),
		'message' => 'Unauthorized Access'
	);
}
else {
	$post_id   = fetch_or_get($_POST['post_id'], 0);
	$post_data = cl_raw_post_data($post_id);

	if (not_empty($post_data)) {
		if (cl_has_saved($me['id'], $post_id) != true) {
            cl_db_insert(T_BOOKMARKS, array(
                'publication_id' => $post_id,
                'user_id'        => $me['id'],
                'time'           => time()
            ));

            $data['code']    = 200;
            $data['valid']   = true;
            $data['message'] = "";
            $data['data']    = array(
                "bookmark"   => true
            );
        }
        else {
            cl_db_delete_item(T_BOOKMARKS, array(
                'publication_id' => $post_id,
                'user_id'        => $me['id']
            ));

            $data['code']    = 200;
            $data['valid']   = true;
            $data['message'] = "";
            $data['data']    = array(
                "bookmark"   => false
            );
        }
	}
	else {
		$data['code']     = 400;
        $data['err_code'] = "invalid_request_data";
        $data['message']  = "Post id is missing or invalid";
    	$data['data']     = array();
	}
}