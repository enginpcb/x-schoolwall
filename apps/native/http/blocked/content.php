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
		cl_css_template("statics/css/apps/blocked/style.master"),
		cl_css_template("statics/css/apps/blocked/style.master"),
		cl_css_template("statics/css/apps/blocked/style.mq")
	)
);

$cl["page_title"] = cl_translate('You are blocked!');
$cl["page_desc"]  = $cl["config"]["description"];
$cl["page_kw"]    = $cl["config"]["keywords"];
$cl["pn"]         = "blocked";
$cl["sbr"]        = true;
$cl["sbl"]        = true;
$cl["http_res"]   = cl_template("blocked/content");
