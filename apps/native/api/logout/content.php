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
	cl_db_delete_item(T_SESSIONS, array(
		"user_id"  => $me["id"],
		"platform" => "mobile_ios"
	));

	cl_db_delete_item(T_SESSIONS, array(
		"user_id"  => $me["id"],
		"platform" => "mobile_android"
	));

	$data         = array(
		'valid'   => true,
		'code'    => 200,
		'message' => 'Signout successful',
		'data'    => array()
	);
}