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

$cl['follow_suggestion'] = cl_get_follow_suggestions(6);
$cl['hot_topics']        = cl_get_hot_topics(6);
$cl['visitor_uniqid']    = null;

if (empty($_COOKIE['visid'])) {
	$cl_unid_hash = sha1(rand(11111, 99999)) . time() . md5(microtime());

	setcookie("visid", $cl_unid_hash, strtotime("+ 1 year"), '/') or die('unable to create cookie');
}

else {
	$cl['visitor_uniqid'] = $_COOKIE['visid'];
}