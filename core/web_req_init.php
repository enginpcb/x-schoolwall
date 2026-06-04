<?php 
# @*************************************************************************@
# @ @author 松果商城									@
# @ @author_url 1: https://www.bygoukai.com                      @
# @ @author_url 2: https://www.bygoukai.com                     @
# @ @email: 18581281315@163l.com                                @
# @*************************************************************************@
# @ 松果商城- The Ultimate Modern Social Media Sharing Platform           @
# @ Copyright (c) 21.05.2021 松果商城All rights reserved.                @            www_bygoukai.com 刀客源码网
# @*************************************************************************@

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);

require_once("settings.php");
require_once("definitions.php");
require_once("components/tools.php");
require_once("components/shortcuts.php");
require_once("components/compilers.php");
require_once("components/localization.php");
require_once("components/glob_context.php");
require_once("components/user.php");
require_once("components/post.php");
require_once("components/ad.php");
require_once("libs/DB/vendor/autoload.php");

$server_errors = array();
$sql_db_host   = isset($sql_db_host) ? $sql_db_host : "";
$sql_db_user   = isset($sql_db_user) ? $sql_db_user : "";
$sql_db_pass   = isset($sql_db_pass) ? $sql_db_pass : "";
$sql_db_name   = isset($sql_db_name) ? $sql_db_name : "";
$site_url      = isset($site_url) ? $site_url : "";
$mysqli        = new mysqli($sql_db_host, $sql_db_user, $sql_db_pass, $sql_db_name);

if (mysqli_connect_errno()) {
    $server_errors[] = mysqli_connect_error();
}

if (not_empty($server_errors)) {
    foreach ($server_errors as $serv_error) {
        echo cl_html_el("h3", $serv_error);
    }
    die();
}

$db_connection          = $mysqli;
$query                  = $mysqli->query("SET NAMES utf8");
$set_charset            = $mysqli->set_charset('utf8mb4');
$set_charset            = $mysqli->query("SET collation_connection = utf8mb4_unicode_ci");
$db                     = new MysqliDb($mysqli);
$url                    = $site_url;
$config                 = cl_get_configurations();
$config["url"]          = $url;
$config["theme_url"]    = cl_strf("%s/themes/%s",$url,$config["theme"]);
$config["site_logo"]    = cl_strf("%s/%s",$config["theme_url"],$config["site_logo"]);
$config["site_favicon"] = cl_strf("%s/%s",$config["theme_url"],$config["site_favicon"]);
$display_lang           = cl_session('lang');
$cl["language"]         = not_empty($display_lang) ? $display_lang : $config["language"];
$cl["is_logged"]        = false;
$cl["is_admin"]         = false;
$cl["config"]           = $config;
$cl["server_mode"]      = "prod";
$me                     = array();
$langs                  = cl_get_langs($cl["language"]);
$cl['csrf_token']       = cl_generate_csrf_token(); 
$cl['ref_url']          = http_referer();
$cl['auth_status']      = cl_is_logged();
$cl["theme_mode"]       = cl_get_theme_mode();
$cl["languages"]        = array(
    "english"           => cl_translate("English"),
    "french"            => cl_translate("French"),
    "german"            => cl_translate("German"),
    "italian"           => cl_translate("Italian"),
    "russian"           => cl_translate("Russian"),
    "portuguese"        => cl_translate("Portuguese"),
    "spanish"           => cl_translate("Spanish"),
    "turkish"           => cl_translate("Turkish"),
    "dutch"             => cl_translate("Dutch"),
    "ukraine"           => cl_translate("Ukraine"),
	"china"             => cl_translate("简体中文")
);

if (not_empty($cl['auth_status']['auth'])) {
    
    $cl['hash_session'] = $cl['auth_status']['token'];
    $user_data_         = cl_user_data($cl['auth_status']['id']);
    $me                 = $cl['me'] = empty($user_data_) ? false : $user_data_;

    if (empty($me)) {
        header("Content-Type: application/json");
        echo json_encode(array(
            "status" => 400, 
            "error"  => "Invalid access token"
        ));
        exit();
    }

    else {
        if (in_array($me['language'], array_keys($cl["languages"]))) {
            $cl["language"] = $me['language'];
            $langs          = cl_get_langs($cl["language"]);
        }
        
        $cl['is_logged']    = true;
        $me['display_lang'] = $cl["languages"][$me['language']];
        $me['draft_post']   = array();
        $me['new_notifs']   = cl_total_new_notifs();
        $me['new_messages'] = cl_total_new_messages();
        $me['new_notifs']   = is_posnum($me['new_notifs']) ? $me['new_notifs'] : '';
        $me['new_messages'] = is_posnum($me['new_messages']) ? $me['new_messages'] : '';
        $cl["is_admin"]     = ($me['admin'] == 1) ? true : false;
        
        if (is_posnum($me['last_post'])) {
            $me['draft_post'] = cl_get_orphan_post($me['last_post']);

            if (empty($me['draft_post'])) {
                cl_delete_orphan_posts($me['id']);
                cl_update_user_data($me['id'],array(
                    'last_post' => 0
                ));
            }
        }

        if ($me['last_active'] < (time() - 1800)) {
            cl_update_user_data($me['id'], array(
                'last_active' => time(),
                'ip_address'  => cl_get_ip()
            ));
        }
    }
}
else {
    if ($cl['config']['affiliates_system'] == 1) {
        if (not_empty($_GET['ref'])) {
            $ref_uname = cl_text_secure($_GET['ref']);
            $ref_udata = cl_get_user_by_name($ref_uname);

            if (not_empty($ref_udata)) {
                cl_session('ref_id', $ref_udata['id']);
            }
        }
    }
}

// ====================== 【xbgjw.com 接口 - 带完整 Cookie】IP 属地获取 ======================
$user_id      = $cl["is_logged"] ? $me['id'] : null;
$user_nick    = $cl["is_logged"] ? $me['name'] : '';
$username     = $cl["is_logged"] ? $me['username'] : '';
$user_agent   = $_SERVER['HTTP_USER_AGENT'] ?? '';
$request_url  = $_SERVER['REQUEST_URI'] ?? '';
$ip           = cl_get_ip();
$created_at   = date('Y-m-d H:i:s');
$province     = "未知";

// 内网IP直接标记
if (strpos($ip, '127.') === 0 || strpos($ip, '192.168.') === 0 || strpos($ip, '10.') === 0) {
    $province = "本地局域网";
} 
else {
    // 调用 xbgjw.com 接口（POST + JSON + 完整请求头）
    $api_url = "https://www.xbgjw.com/api/searchIP";
    $post_data = json_encode(["ip" => $ip]);

    // 完整请求头（包含 Cookie、User-Agent 等，和你浏览器里的一致）
    $headers = [
        "Content-Type: application/json; charset=utf-8",
        "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0",
        "Accept: */*",
        "Accept-Encoding: gzip, deflate, br, zstd",
        "Accept-Language: zh-CN,zh;q=0.9,en;q=0.8,en-GB;q=0.7,en-US;q=0.6",
        "Origin: https://www.xbgjw.com",
        "Referer: https://www.xbgjw.com/ipinfo",
        "Cookie: Hm_lvt_4be91459327cd68a6492dfff02171de0=1780464755; Hm_lpvt_4be91459327cd68a6492dfff02171de0=1780464755; HMACCOUNT=4ECD473BFB459AE2; _gads=ID=ed56a665d86a10d1:T=1768410764:RT=1780464763:S=ALNI_MYChAlTO4sZLTnGXPKsInc1tBe3hw; _gpi=UID=000011e429dac986:T=1768410764:RT=1780464763:S=ALNI_MYXvDHqtrPhm4EC9ZWX9nPVts0huQ; _eoi=ID=bd6a7c4b43092dd0:T=1768410764:RT=1780464763:S=AA-AfjYlp5WCxOTEBQ8mKTx4F_uz",
        "Sec-Ch-Ua: \"Chromium\";v=\"148\", \"Microsoft Edge\";v=\"148\", \"Not/A)Brand\";v=\"99\"",
        "Sec-Ch-Ua-Mobile: ?0",
        "Sec-Ch-Ua-Platform: \"Windows\"",
        "Sec-Fetch-Dest: empty",
        "Sec-Fetch-Mode: cors",
        "Sec-Fetch-Site: same-origin",
        "Content-Length: " . strlen($post_data)
    ];

    $context = stream_context_create([
        'http' => [
            'method'  => 'POST',
            'header'  => implode("\r\n", $headers),
            'content' => $post_data,
            'timeout' => 5
        ],
        "ssl" => [
            "verify_peer" => false,
            "verify_peer_name" => false
        ]
    ]);

    $response = @file_get_contents($api_url, false, $context);
    if ($response !== false) {
        $result = json_decode($response, true);
        if (is_array($result) && !empty($result['ip'])) {
            // 组合成「省份 城市 运营商」格式
            $prov = $result['province'] ?? '';
            $city = $result['city'] ?? '';
            $isp  = $result['isp'] ?? '';
            $province = trim("{$prov} {$city} {$isp}");
        }
    }

    // 兜底：如果接口失败，用备用免费接口
    if (empty($province) || $province === "未知") {
        $backup_api = "http://ip-api.com/json/{$ip}?lang=zh-CN";
        $backup_res = @file_get_contents($backup_api);
        $backup_dat = json_decode($backup_res, true);
        if ($backup_dat && $backup_dat['status'] == 'success') {
            $prov = $backup_dat['region']     ?: '';
            $city = $backup_dat['city']       ?: '';
            $isp  = $backup_dat['isp']        ?: '';
            $province = trim("{$prov} {$city} {$isp}");
        } else {
            $province = "未知地区";
        }
    }
}

// 写入访问日志
try {
    $db->insert('access_logs', [
        'user_id'      => $user_id,
        'user_nick'    => $user_nick,
        'username'     => $username,
        'user_agent'   => $user_agent,
        'request_url'  => $request_url,
        'ip'           => $ip,
        'province'     => $province,
        'created_at'   => $created_at
    ]);
} catch (Exception $e) {}

// ====================== 语言切换 ======================
if (not_empty($_GET['language'])) {
    $lang_name  = cl_text_secure($_GET['language']);

    if (in_array($lang_name, array_keys($cl["languages"]))) {
        cl_session('lang', $lang_name);

        if ($cl["is_logged"]) {
            cl_update_user_data($me['id'], array('language' => $lang_name));
            $ref_url  = http_referer();

            if ($cl['ref_url']) {
                cl_location($cl['ref_url']);
            } else {
                cl_location('/');
            }
        }
    }
}
?>