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

$cl["page_title"] = $cl["config"]["name"];
$cl["page_desc"]  = $cl["config"]["description"];
$cl["page_kw"]    = $cl["config"]["keywords"];
$cl["pn"]         = "suggested";
$cl["sbr"]        = true;
$cl["sbl"]        = true;
$cl["users_list"] = cl_get_follow_suggestions(30);

if (empty($cl["users_list"])) {
	cl_redirect("404");
}

else {
	$cl["app_statics"] = array(
		"styles" => array(
			cl_css_template("statics/css/apps/suggested/style.master"),
			cl_css_template("statics/css/apps/suggested/style.custom")
		)
	);

	if ($cl["theme_mode"] == "N") {
		array_push($cl["app_statics"]["styles"], cl_css_template("statics/css/apps/suggested/style.dark"));
	}

	$cl["http_res"] = cl_template("suggested/content");
}
