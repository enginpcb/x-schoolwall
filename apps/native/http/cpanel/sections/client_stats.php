<?php 
if (!$cl["is_admin"]) {
    cl_redirect("/admin_panel/login");
    exit();
}

$cl["cp_section"] = "client_stats";
$cl["page_title"] = "客户端统计";

require_once(cl_full_path("core/apps/cpanel/client_stats/app_ctrl.php"));

// 接收筛选参数
$start_date   = $_GET['start_date'] ?? date('Y-m-d', strtotime('-30 days'));
$end_date     = $_GET['end_date'] ?? date('Y-m-d');
$sel_province = $_GET['province'] ?? '';
$sel_client   = $_GET['client'] ?? '';
$search_url   = $_GET['url'] ?? '';
$page         = isset($_GET['p']) ? max(1, intval($_GET['p'])) : 1;
$pagesize     = 50;

// 统计数据（全部增加空值容错）
$cl['base_stats']   = (array)cl_stats_base($start_date, $end_date, $sel_province, $sel_client, $search_url);
$cl['client_stats'] = (array)cl_stats_client($start_date, $end_date, $sel_province, $sel_client, $search_url);
$cl['area_stats']   = (array)cl_stats_by_area($start_date, $end_date, $sel_province, $sel_client, $search_url);
$cl['url_top']      = (array)cl_stats_url_top($start_date, $end_date, $sel_province, $sel_client, $search_url);
$cl['user_top']     = (array)cl_stats_user_top($start_date, $end_date, $sel_province, $sel_client, $search_url, 20);
$cl['detail_data']  = (array)cl_stats_detail_list($start_date, $end_date, $sel_province, $sel_client, $search_url, $page, $pagesize);
$cl['total_count']  = (int)cl_stats_detail_total($start_date, $end_date, $sel_province, $sel_client, $search_url);

// 分页
$cl['page']     = $page;
$cl['pagesize'] = $pagesize;

// 加载静态资源
$cl["app_statics"] = [
	"scripts" => [
		cl_static_file_path("apps/cpanel/statics/plugins/jquery-countto/jquery.countTo.js"),
		cl_static_file_path("apps/cpanel/statics/plugins/chartjs/Chart.bundle.js"),
	]
];

// 渲染模板
$cl['http_res'] = cl_template("cpanel/assets/client_stats/content");
?>