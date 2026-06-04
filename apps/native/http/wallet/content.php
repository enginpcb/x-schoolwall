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
	cl_redirect("guest");
}
else {

	require_once(cl_full_path("core/apps/wallet/app_ctrl.php"));

	$cl["page_title"]  = cl_translate("Wallet");
	$cl["page_desc"]   = $cl["config"]["description"];
	$cl["page_kw"]     = $cl["config"]["keywords"];
	$cl["pn"]          = "wallet";
	$cl["sbr"]         = true;
	$cl["sbl"]         = true;
	$cl["app_statics"] = array(
		"styles" => array(
			cl_css_template("statics/css/apps/wallet/style.master"),
			cl_css_template("statics/css/apps/wallet/style.mq"),
			cl_css_template("statics/css/apps/wallet/style.custom")
		)
	);

	if ($cl["theme_mode"] == "N") {
		array_push($cl["app_statics"]["styles"], cl_css_template("statics/css/apps/wallet/style.dark"));
	}

	$cl["wallet_history"] = cl_get_account_wallet_history();
	$cl["http_res"]       = cl_template("wallet/content");
}