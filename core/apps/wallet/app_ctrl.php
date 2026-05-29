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

function cl_get_account_wallet_history($offset = false, $limit = 10) {
	global $db, $cl;

	$data    = array();
	$db      = $db->where('user_id', $cl['me']['id']);
	$db      = (is_posnum($offset)) ? $db->where('id', $offset, '<') : $db;
	$db      = $db->orderBy('id','DESC');
	$history = $db->get(T_WALLET_HISTORY, $limit);

	if (cl_queryset($history)) {
		foreach ($history as $row) {
			$row['time']      = cl_time2str($row['time']);
			$row['json_data'] = json($row['json_data']);
			$data[]           = $row;
		}
	}

	return $data;
}