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

if (empty($cl["is_logged"])) {
	cl_redirect("404");
}

require_once(cl_full_path("core/apps/notifications/app_ctrl.php"));

$cl["page_tab"]    =  fetch_or_get($_GET["page"],"notifs");
$cl["page_title"]  =  cl_translate("Notifications");
$cl["page_desc"]   =  $cl["config"]["description"];
$cl["page_kw"]     =  $cl["config"]["keywords"];
$cl["pn"]          =  "notifications";
$cl["sbr"]         =  true;
$cl["sbl"]         =  true;
$cl["notifs"]      =  cl_get_notifications(array(
	"type"         => $cl["page_tab"],
	"limit"        => 50
));

$cl["app_statics"] = array(
	"styles" => array(
		cl_css_template("statics/css/apps/notifications/style.master"),
		cl_css_template("statics/css/apps/notifications/style.mq"),
		cl_css_template("statics/css/apps/notifications/style.custom")
	)
);

if ($cl["theme_mode"] == "N") {
	array_push($cl["app_statics"]["styles"], cl_css_template("statics/css/apps/notifications/style.dark"));
}
	
$cl["http_res"] = cl_template("notifications/content");

