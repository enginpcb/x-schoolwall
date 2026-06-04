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
	$profile_privacy  = fetch_or_get($_POST['profile_visibility'], null);
    $contact_privacy  = fetch_or_get($_POST['contact_privacy'], null);
    $index_privacy    = fetch_or_get($_POST['search_visibility'], null);

    if (in_array($profile_privacy, array('everyone', 'followers', 'nobody')) != true) {
        $data['err_code'] = "invalid_profile_privacy";
        $data["code"]     = 400;
        $data["data"]     = array();
        $data["message"]  = "Invalid request data";
    }

    else if (in_array($contact_privacy, array('everyone', 'followed')) != true) {
        $data['err_code'] = "invalid_contact_privacy";
        $data["code"]     = 400;
        $data["data"]     = array();
        $data["message"]  = "Invalid request data";
    }

    else if (in_array($index_privacy, array('Y', 'N')) != true) {
        $data['err_code'] = "invalid_index_privacy";
        $data["code"]     = 400;
        $data["data"]     = array();
        $data["message"]  = "Invalid request data";
    }

    else {
        cl_update_user_data($me["id"], array(
            'profile_privacy' => $profile_privacy,
            'contact_privacy' => $contact_privacy,
            'index_privacy'   => $index_privacy
        ));

        $data["code"]    = 200;
		$data["valid"]   = true;
		$data["message"] = "User privacy settings updated";
		$data["data"]    = array();
    }
}