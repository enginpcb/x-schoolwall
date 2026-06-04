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
		if (cl_has_reposted($me['id'], $post_id) != true) {
            cl_db_insert(T_POSTS, array(
                'publication_id'  => $post_id,
                'user_id'         => $me['id'],
                'type'            => 'repost',
                'time'            => time()
            ));

            $reposts_count        = ($post_data['reposts_count'] += 1);
            $data['post_reposts'] = $reposts_count;
            $data['valid']        = true;
            $data['message']      = "";
            $data['code']         = 200;
            $data['data']         = array("repost" => true);

            cl_update_post_data($post_id, array(
                'reposts_count' => $reposts_count
            ));

            if ($post_data['user_id'] != $me['id']) {
                cl_notify_user(array(
                    'subject'  => 'repost',
                    'user_id'  => $post_data['user_id'],
                    'entry_id' => $post_id,
                ));
            }
        }
        else {
   
            $reposts_count        = ($post_data['reposts_count'] -= 1);
            $data['post_reposts'] = $reposts_count;
            $data['valid']        = true;
            $data['message']      = "";
            $data['code']         = 200;
            $data['data']         = array("repost" => false);

            cl_update_post_data($post_id, array(
                'reposts_count' => $reposts_count
            ));

            cl_db_delete_item(T_NOTIFS, array(
                'notifier_id'  => $me['id'],
                'recipient_id' => $post_data['user_id'],
                'subject'      => 'repost',
                'entry_id'     => $post_id
            ));

            cl_db_delete_item(T_POSTS, array(
                'publication_id' => $post_id,
                'user_id'        => $me['id'],
                'type'           => 'repost'
            ));
        }
	}
	else {
		$data['code']     = 400;
        $data['err_code'] = "invalid_request_data";
        $data['message']  = "Post id is missing or invalid";
    	$data['data']     = array();
	}
}