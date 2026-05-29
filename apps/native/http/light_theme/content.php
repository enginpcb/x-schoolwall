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

try {
	unset($_COOKIE['dark_mode']);
	setcookie('dark_mode', null, -1);

	cl_location(http_referer());
} 

catch (Exception $e) {
	cl_redirect("500");
}

