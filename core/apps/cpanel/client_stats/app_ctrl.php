<?php
/**
 * 客户端统计 - 无报错稳定版
 * 仅统计：IP属地、访问URL、客户端、访问日志
 */

//1.基础大盘数据
//1.基础大盘数据
function cl_stats_base($sdate,$edate,$province='',$client='',$url=''){
    global $db;
    $s = $sdate.' 00:00:00';
    $e = $edate.' 23:59:59';
    $where = "created_at between ? and ?";
    $bind = [$s, $e];

    if(!empty($province)){
        $where .= " and province=?";
        $bind[] = $province;
    }
    if(!empty($client)){
        if($client=='app') $where .= " and user_agent like '%NTVUWall%'";
        elseif($client=='wx') $where .= " and user_agent like '%MicroMessenger%'";
        elseif($client=='qq') $where .= " and user_agent like '%QQ%'";
        elseif($client=='browser') $where .= " and (user_agent like '%Chrome%' or user_agent like '%Safari%')";
    }
    if(!empty($url)){
        $where .= " and request_url like ?";
        $bind[] = "%{$url}%";
    }

    $sql = "select count(*) total_req,
                   count(distinct user_id) total_user,
                   sum(case when user_agent like '%NTVUWall%' then 1 else 0 end) app_req,
                   count(distinct province) diff_area 
            from access_logs where {$where}";
    
    $res = $db->rawQuery($sql, $bind);
    // 容错：如果查询结果为空，返回默认0值
    if (empty($res)) {
        return [
            'total_req'  => 0,
            'total_user'  => 0,
            'app_req'     => 0,
            'diff_area'   => 0
        ];
    }
    return $res[0];
}
//2.按省份属地统计（地域分布饼图）
function cl_stats_by_area($sdate,$edate,$province='',$client='',$url=''){
    global $db;
    $s = $sdate.' 00:00:00';$e=$edate.' 23:59:59';
    $where = "created_at between ? and ?";$bind=[$s,$e];
    if(!empty($province)){$where.=" and province=?";$bind[]=$province;}
    if(!empty($client)){
        if($client=='app')$where.=" and user_agent like '%NTVUWall%'";
        elseif($client=='wx')$where.=" and user_agent like '%MicroMessenger%'";
        elseif($client=='qq')$where.=" and user_agent like '%QQ%'";
        elseif($client=='browser')$where.=" and (user_agent like '%Chrome%' or user_agent like '%Safari%')";
    }
    if(!empty($url)){$where.=" and request_url like ?";$bind[]="%{$url}%";}
    $sql="select province,count(*) as cnt from access_logs where {$where} group by province order by cnt desc";
    return $db->rawQuery($sql,$bind);
}

//3.访问URL TOP20排行
function cl_stats_url_top($sdate,$edate,$province='',$client='',$url=''){
    global $db;
    $s = $sdate.' 00:00:00';$e=$edate.' 23:59:59';
    $where = "created_at between ? and ?";$bind=[$s,$e];
    if(!empty($province)){$where.=" and province=?";$bind[]=$province;}
    if(!empty($client)){
        if($client=='app')$where.=" and user_agent like '%NTVUWall%'";
        elseif($client=='wx')$where.=" and user_agent like '%MicroMessenger%'";
        elseif($client=='qq')$where.=" and user_agent like '%QQ%'";
        elseif($client=='browser')$where.=" and (user_agent like '%Chrome%' or user_agent like '%Safari%')";
    }
    if(!empty($url)){$where.=" and request_url like ?";$bind[]="%{$url}%";}
    $sql="select request_url,count(*) cnt from access_logs where {$where} group by request_url order by cnt desc limit 20";
    return $db->rawQuery($sql,$bind);
}

//4.明细分页列表（单条IP/用户/属地/客户端全量）
function cl_stats_detail_list($sdate,$edate,$province='',$client='',$url='',$page=1,$ps=500){
    global $db;
    $s = $sdate.' 00:00:00';$e=$edate.' 23:59:59';
    $where = "created_at between ? and ?";$bind=[$s,$e];
    if(!empty($province)){$where.=" and province=?";$bind[]=$province;}
    if(!empty($client)){
        if($client=='app')$where.=" and user_agent like '%NTVUWall%'";
        elseif($client=='wx')$where.=" and user_agent like '%MicroMessenger%'";
        elseif($client=='qq')$where.=" and user_agent like '%QQ%'";
        elseif($client=='browser')$where.=" and (user_agent like '%Chrome%' or user_agent like '%Safari%')";
    }
    if(!empty($url)){$where.=" and request_url like ?";$bind[]="%{$url}%";}
    $offset = ($page-1)*$ps;
    $sql="select id,user_id,user_nick,username,province,ip,user_agent,request_url,created_at from access_logs where {$where} order by created_at desc limit {$offset},{$ps}";
    return $db->rawQuery($sql,$bind);
}

//明细总条数
function cl_stats_detail_total($sdate,$edate,$province='',$client='',$url=''){
    global $db;
    $s = $sdate.' 00:00:00';$e=$edate.' 23:59:59';
    $where = "created_at between ? and ?";$bind=[$s,$e];
    if(!empty($province)){$where.=" and province=?";$bind[]=$province;}
    if(!empty($client)){
        if($client=='app')$where.=" and user_agent like '%NTVUWall%'";
        elseif($client=='wx')$where.=" and user_agent like '%MicroMessenger%'";
        elseif($client=='qq')$where.=" and user_agent like '%QQ%'";
        elseif($client=='browser')$where.=" and (user_agent like '%Chrome%' or user_agent like '%Safari%')";
    }
    if(!empty($url)){$where.=" and request_url like ?";$bind[]="%{$url}%";}
    $sql="select count(*) total from access_logs where {$where}";
    $res = $db->rawQuery($sql,$bind);
    return $res[0]['total'];
}

// 用户访问次数TOP排行
function cl_stats_user_top($sdate,$edate,$province='',$client='',$url='',$limit=20){
    global $db;
    $s = $sdate.' 00:00:00';
    $e = $edate.' 23:59:59';
    
    $where = "created_at between ? AND ?";
    $bind = array($s, $e);

    if(!empty($province)){
        $where .= " AND province=?";
        $bind[] = $province;
    }
    if(!empty($client)){
        if($client=='app') $where .= " AND user_agent LIKE '%NTVUWall%'";
        elseif($client=='wx') $where .= " AND user_agent LIKE '%MicroMessenger%'";
        elseif($client=='qq') $where .= " AND user_agent LIKE '%QQ%'";
        elseif($client=='browser') $where .= " AND (user_agent LIKE '%Chrome%' OR user_agent LIKE '%Safari%')";
    }
    if(!empty($url)){
        $where .= " AND request_url LIKE ?";
        $bind[] = "%{$url}%";
    }

    $sql = "
        SELECT 
            user_id,
            user_nick,
            username,
            COUNT(*) AS visit_count,
            COUNT(DISTINCT ip) AS ip_num
        FROM access_logs
        WHERE $where
        GROUP BY user_id, user_nick, username
        ORDER BY visit_count DESC
        LIMIT ?
    ";
    
    $bind[] = (int)$limit;
    return $db->rawQuery($sql, $bind);
}

// 客户端统计（PV + 独立用户 UV）→ 支持双柱状图
function cl_stats_client($sdate,$edate,$province='',$client='',$url=''){
    global $db;
    $s = $sdate.' 00:00:00';
    $e = $edate.' 23:59:59';
    $where = "created_at between ? AND ?";
    $bind = [$s, $e];

    if(!empty($province)){
        $where .= " AND province=?";
        $bind[] = $province;
    }
    if(!empty($client)){
        if($client=='app') $where .= " AND user_agent LIKE '%NTVUWall%'";
        elseif($client=='wx') $where .= " AND user_agent LIKE '%MicroMessenger%'";
        elseif($client=='qq') $where .= " AND user_agent LIKE '%QQ%'";
        elseif($client=='browser') $where .= " AND (user_agent LIKE '%Chrome%' OR user_agent LIKE '%Safari%')";
    }
    if(!empty($url)){
        $where .= " AND request_url LIKE ?";
        $bind[] = "%{$url}%";
    }

    $sql = "
        SELECT 
            -- 访问次数 PV
            SUM(CASE WHEN user_agent LIKE '%NTVUWall%' THEN 1 ELSE 0 END) AS app,
            SUM(CASE WHEN user_agent LIKE '%MicroMessenger%' THEN 1 ELSE 0 END) AS wx,
            SUM(CASE WHEN user_agent LIKE '%QQ%' THEN 1 ELSE 0 END) AS qq,
            SUM(CASE WHEN (user_agent LIKE '%Chrome%' OR user_agent LIKE '%Safari%') THEN 1 ELSE 0 END) AS browser,
            SUM(CASE WHEN 
                user_agent NOT LIKE '%NTVUWall%' 
                AND user_agent NOT LIKE '%MicroMessenger%' 
                AND user_agent NOT LIKE '%QQ%' 
                AND user_agent NOT LIKE '%Chrome%' 
                AND user_agent NOT LIKE '%Safari%' 
            THEN 1 ELSE 0 END) AS other,

            -- 独立用户 UV
            COUNT(DISTINCT CASE WHEN user_agent LIKE '%NTVUWall%' THEN user_id END) AS app_uv,
            COUNT(DISTINCT CASE WHEN user_agent LIKE '%MicroMessenger%' THEN user_id END) AS wx_uv,
            COUNT(DISTINCT CASE WHEN user_agent LIKE '%QQ%' THEN user_id END) AS qq_uv,
            COUNT(DISTINCT CASE WHEN (user_agent LIKE '%Chrome%' OR user_agent LIKE '%Safari%') THEN user_id END) AS browser_uv,
            COUNT(DISTINCT CASE WHEN 
                user_agent NOT LIKE '%NTVUWall%' 
                AND user_agent NOT LIKE '%MicroMessenger%' 
                AND user_agent NOT LIKE '%QQ%' 
                AND user_agent NOT LIKE '%Chrome%' 
                AND user_agent NOT LIKE '%Safari%' 
            THEN user_id END) AS other_uv
        FROM access_logs
        WHERE $where
    ";

    $data = $db->rawQuery($sql, $bind)[0];
    return [
        'app'        => (int)($data['app'] ?? 0),
        'wx'         => (int)($data['wx'] ?? 0),
        'qq'         => (int)($data['qq'] ?? 0),
        'browser'    => (int)($data['browser'] ?? 0),
        'other'      => (int)($data['other'] ?? 0),
        'app_uv'     => (int)($data['app_uv'] ?? 0),
        'wx_uv'      => (int)($data['wx_uv'] ?? 0),
        'qq_uv'      => (int)($data['qq_uv'] ?? 0),
        'browser_uv' => (int)($data['browser_uv'] ?? 0),
        'other_uv'   => (int)($data['other_uv'] ?? 0)
    ];
}
?>