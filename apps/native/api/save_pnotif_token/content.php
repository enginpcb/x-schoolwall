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
	$data['err_code'] = 0;
	$token = fetch_or_get($_POST['token'], null);
	$type  = fetch_or_get($_POST['type'], null);
	
	if (empty($token) || len_between($token, 50, 250) != true) {
		$data['err_code'] = 'invalid_token';
		$data['code']     = 400;
		$data['message']  = "Incorrect token value";
		$data['data']     = array();
	}

	else if (empty($type) || in_array($type, array("ios", "android")) != true) {
		$data['err_code'] = 'invalid_device_type';
		$data['code']     = 400;
		$data['message']  = "Incorrect device type value";
		$data['data']     = array();
	}

	else {
		$data['err_code'] = '0';
		$data['code']     = 200;
		$data['message']  = "Notification token saved";
		$data['data']     = array();

		cl_update_user_data($me["id"], array(
			"pnotif_token" => json(array(
				"token"    => cl_text_secure($token),
				"type"     => $type
			), true)
		));
	}
}