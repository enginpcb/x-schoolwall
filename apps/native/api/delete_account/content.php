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
	$acc_password = fetch_or_get($_POST['password'], false);

    if (empty($acc_password) || (password_verify($acc_password, $me['password']) != true)) {
        $data['code']     = 400;
        $data['err_code'] = "invalid_request_data";
        $data['message']  = "Account password is missing or invalid";
        $data['data']     = array();
    }

    else {
        $data["code"]    = 200;
        $data["valid"]   = true;
        $data["message"] = "Account deleted successfully";
        $data["data"]    = array();

        cl_delete_user_data($me['id']);
    }
}