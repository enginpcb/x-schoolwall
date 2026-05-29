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

	if (empty($post_data) || ($post_data["user_id"] != $me["id"] && empty($cl["is_admin"]))) {
		$data['code']     = 400;
        $data['err_code'] = "invalid_request_data";
        $data['message']  = "Post id is missing or invalid";
        $data['data']     = array();
	}
    else {
        $post_owner = cl_raw_user_data($post_data['user_id']);

        if ($post_data['target'] == 'publication') {

            if (not_empty($post_owner)) {
                cl_update_user_data($post_data['user_id'], array(
                    'posts' => ($post_owner['posts'] -= 1)
                ));
            }

            cl_db_delete_item(T_POSTS, array(
                'publication_id' => $post_id
            ));
        }

        else {
            cl_update_thread_replys($post_data['thread_id'], 'minus');
        }

        $data["code"]    = 200;
        $data["valid"]   = true;
        $data["message"] = "Post deleted successfully";
        $data["data"]    = array();

        cl_recursive_delete_post($post_id);
    }
}