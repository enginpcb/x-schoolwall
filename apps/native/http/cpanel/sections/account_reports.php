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

require_once(cl_full_path("core/apps/cpanel/account_reports/app_ctrl.php"));

$cl['total_reports']   = cl_get_total_profile_reports();
$cl['account_reports'] = cl_get_profile_reports();
$cl['http_res']        = cl_template("cpanel/assets/account_reports/content");