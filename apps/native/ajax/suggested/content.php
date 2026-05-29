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

if ($action == 'load_more') {
	$data['err_code'] = "invalid_req_data";
    $data['status']   = 400;
    $offset           = fetch_or_get($_GET['offset'], 0);
    $users_list       = array();
    $html_arr         = array();

    if (is_posnum($offset)) {
    	
    	$users_list = cl_get_follow_suggestions(30, $offset);

    	if (not_empty($users_list)) {
			foreach ($users_list as $cl['li']) {
				$html_arr[] = cl_template('suggested/includes/list_item');
			}

			$data['status'] = 200;
			$data['html']   = implode("", $html_arr);
		}
    }
}