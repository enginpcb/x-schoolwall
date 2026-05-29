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

if (not_empty($cl['is_logged'])) {
	cl_redirect('404');
}

else if(empty(cl_session('validated_user_data'))) {
	cl_redirect('404');
}

$cl["app_statics"] = array(
	"styles" => array(
		cl_css_template("statics/css/apps/confirm_reg/style.master"),
		cl_css_template("statics/css/apps/confirm_reg/style.mq"),
		cl_css_template("statics/css/apps/confirm_reg/style.custom")
	)
);

if ($cl["theme_mode"] == "N") {
	array_push($cl["app_statics"]["styles"], cl_css_template("statics/css/apps/confirm_reg/style.dark"));
}

$cl["page_title"] = cl_translate("Confirm registration");
$cl["page_desc"]  = $cl["config"]["description"];
$cl["page_kw"]    = $cl["config"]["keywords"];
$cl["pn"]         = "confirm_reg";
$cl["sbr"]        = true;
$cl["sbl"]        = true;
$cl["http_res"]   = cl_template("confirm_reg/content");
