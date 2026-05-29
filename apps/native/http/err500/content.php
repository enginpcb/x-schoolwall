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

$cl["app_statics"] = array(
	"styles" => array(
		cl_css_template("statics/css/apps/err500/style.master"),
		cl_css_template("statics/css/apps/err500/style.custom")
	)
);

if ($cl["theme_mode"] == "N") {
	array_push($cl["app_statics"]["styles"], cl_css_template("statics/css/apps/err500/style.dark"));
}

$cl["page_title"] = cl_translate('Server error 500!');
$cl["page_desc"]  = $cl["config"]["description"];
$cl["page_kw"]    = $cl["config"]["keywords"];
$cl["pn"]         = "err500";
$cl["sbr"]        = true;
$cl["sbl"]        = true;
$cl["err_msg"]    = cl_session('err500_message');

if ($cl["err_msg"]) {
	cl_session_unset('err500_message');
}

$cl["http_res"] = cl_template("err500/content");
