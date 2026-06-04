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
	$data['err_code']  = 0;
	$user_data_fileds  = array(
		'old_password' => fetch_or_get($_POST['old_password'], null),
        'new_password' => fetch_or_get($_POST['new_password'], null)
	);

	foreach ($user_data_fileds as $field_name => $field_val) {
		if ($field_name == 'old_password') {
			if (empty($field_val) || len_between($field_val, 6, 20) != true || password_verify($user_data_fileds["old_password"], $me["password"]) != true) {
	            $data['err_code'] = cl_strf("invalid_%s", $field_name);
	            $data['code']     = 402;
	        	$data['message']  = "Incorrect old password value";
	        	$data['data']     = array(); break;
	        }
		}

		else if ($field_name == 'new_password') {
			if (empty($field_val) || len_between($field_val, 6, 20) != true) {
	            $data['err_code'] = cl_strf("invalid_%s", $field_name);
	            $data['code']     = 402;
	        	$data['message']  = "Incorrect new password value";
	        	$data['data']     = array(); break;
	        }
		}
	}

	if (empty($data['err_code'])) {
		$data['code']    = 200;
        $data['message'] = "Password changed";
        $data['data']    = array();

        cl_update_user_data($me["id"], array(
        	"password" => password_hash($user_data_fileds["new_password"], PASSWORD_DEFAULT)
        ));
	}
}