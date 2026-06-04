<?php
date_default_timezone_set('Asia/Shanghai');
header('Content-Type: text/html; charset=utf-8');

$STATS_FILE = 'assets/stats.json';
$COMMENTS_FILE = 'assets/comments.json';
$APK_URL = 'https://www.ntvu.cn/apk/1.2.1.apk';

// 初始化统计
function initStats() {
    global $STATS_FILE;
    $today = date('Y-m-d');
    $default = [
        'totalVisits' => 0,
        'todayVisits' => 0,
        'totalDownloads' => 0,
        'todayDownloads' => 0,
        'lastDate' => $today
    ];
    if (!file_exists($STATS_FILE)) {
        file_put_contents($STATS_FILE, json_encode($default));
        chmod($STATS_FILE, 0666);
    }
    $stats = json_decode(file_get_contents($STATS_FILE), true) ?: $default;
    foreach ($default as $k => $v) if (!isset($stats[$k])) $stats[$k] = $v;
    if ($stats['lastDate'] != $today) {
        $stats['todayVisits'] = 0;
        $stats['todayDownloads'] = 0;
        $stats['lastDate'] = $today;
    }
    file_put_contents($STATS_FILE, json_encode($stats));
    return $stats;
}

// 访问+1
function visitInc() {
    $s = initStats();
    $s['totalVisits']++;
    $s['todayVisits']++;
    file_put_contents($GLOBALS['STATS_FILE'], json_encode($s));
}

// 下载+1（通用）
function downloadInc() {
    $s = initStats();
    $s['totalDownloads']++;
    $s['todayDownloads']++;
    file_put_contents($GLOBALS['STATS_FILE'], json_encode($s));
}

// AJAX 记录下载（微信复制用）
if ($_GET['act'] === 'count') {
    downloadInc();
    exit('ok');
}

// 直接下载计数
if ($_GET['action'] === 'download') {
    downloadInc();
    header("Location: $APK_URL");
    exit;
}

// 评论
function getComments() {
    global $COMMENTS_FILE;
    if (!file_exists($COMMENTS_FILE)) {
        file_put_contents($COMMENTS_FILE, json_encode([]));
        chmod($COMMENTS_FILE, 0666);
    }
    $list = json_decode(file_get_contents($COMMENTS_FILE), true) ?? [];
    return array_reverse($list);
}

// 发表评论
if ($_POST['action'] === 'postComment') {
    $content = trim($_POST['content']);
    $star = max(1, min(5, (int)$_POST['star']));
    if ($content) {
        $list = json_decode(file_get_contents($COMMENTS_FILE), true) ?? [];
        $list[] = [
            'name' => '匿名用户',
            'star' => $star,
            'content' => mb_substr($content, 0, 50),
            'time' => date('m-d H:i')
        ];
        file_put_contents($COMMENTS_FILE, json_encode($list, JSON_UNESCAPED_UNICODE));
    }
    header('Location: download.php#comment');
    exit;
}

$stats = initStats();
$comments = getComments();
visitInc();
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>职大校园墙 - 官方下载</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <style>
        *{-webkit-tap-highlight-color:transparent;}
        body{font-family:system-ui,sans-serif;background:#f5f7fa;}
        .scrollbar-hide::-webkit-scrollbar{display:none;}
        .app-card{background:#fff;border-radius:16px;box-shadow:0 2px 12px rgba(0,0,0,.06);}
        .star-rating{display:flex;gap:4px;cursor:pointer;}
        .star{color:#ccc;font-size:18px;transition:.2s;}
        .star.active{color:#ffc107;}
    </style>
</head>
<body class="min-h-screen text-gray-800">

<div class="px-4 pt-6 pb-4">
    <?php $isWechat = strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'micromessenger') !== false; ?>
    <?php if ($isWechat): ?>
    <button onclick="copyAndCount()" class="w-full bg-blue-600 text-white py-4 rounded-xl text-lg font-bold flex items-center justify-center gap-2 shadow-lg">
        <i class="fa fa-link text-2xl"></i> 复制下载链接
    </button>
    <p class="text-center text-xs text-red-500 mt-2">微信内无法下载 → 复制到浏览器打开</p>
    <?php else: ?>
    <a href="?action=download" class="w-full bg-blue-600 text-white py-4 rounded-xl text-lg font-bold flex items-center justify-center gap-2 shadow-lg">
        <i class="fa fa-android text-2xl"></i> 立即下载
    </a>
    <?php endif; ?>
    <p class="text-center text-xs text-gray-500 mt-1">Android 6.0+ | 安全无广告</p>
</div>

<div class="px-4 mb-4">
    <div class="app-card p-4">
        <div class="flex items-center gap-3">
            <div class="w-16 h-16 rounded-xl overflow-hidden">
                <img src="/themes/default/statics/img/logo.png" class="w-full h-full object-cover">
            </div>
            <div>
                <h1 class="text-xl font-bold">职大校园墙</h1>
                <p class="text-xs text-gray-500">v1.2.1 | 官方正版</p>
            </div>
        </div>
    </div>
</div>

<div class="px-4 mb-4">
    <div class="app-card p-4">
        <h2 class="text-base font-bold mb-3">应用数据</h2>
        <div class="grid grid-cols-4 text-center">
            <div><div class="text-lg font-bold"><?=$stats['totalVisits']?></div><div class="text-xs text-gray-500">总访问</div></div>
            <div><div class="text-lg font-bold"><?=$stats['todayVisits']?></div><div class="text-xs text-gray-500">今日访问</div></div>
            <div><div class="text-lg font-bold"><?=$stats['totalDownloads']?></div><div class="text-xs text-gray-500">总下载</div></div>
            <div><div class="text-lg font-bold"><?=$stats['todayDownloads']?></div><div class="text-xs text-gray-500">今日下载</div></div>
        </div>
    </div>
</div>

<div class="px-4 mb-4">
    <h2 class="text-base font-bold px-1 mb-3">应用截图</h2>
    <div class="overflow-x-auto scrollbar-hide">
        <div class="flex gap-3 px-1 min-w-max">
            <div class="w-[160px] rounded-xl shadow"><img src="assets/img/1.jpg" class="w-full"></div>
            <div class="w-[160px] rounded-xl shadow"><img src="assets/img/2.jpg" class="w-full"></div>
            <div class="w-[160px] rounded-xl shadow"><img src="assets/img/3.jpg" class="w-full"></div>
        </div>
    </div>
</div>

<div class="px-4 mb-4">
    <div class="app-card p-4">
        <h2 class="text-base font-bold mb-3">应用介绍</h2>
        <p class="text-sm text-gray-600 leading-relaxed">
            职大学生专属校园平台，失物招领、交友脱单、校园资讯、二手交易、表白投稿，安全纯净。
        </p>
    </div>
</div>

<div id="comment" class="px-4 mb-10">
    <div class="app-card p-4">
        <h2 class="text-base font-bold mb-3">用户评论</h2>
        <form method="post" class="mb-4">
            <input type="hidden" name="action" value="postComment">
            <input type="hidden" id="star" name="star" value="5">
            <div class="star-rating mb-3">
                <span class="star active" data-val="1"><i class="fa fa-star"></i></span>
                <span class="star active" data-val="2"><i class="fa fa-star"></i></span>
                <span class="star active" data-val="3"><i class="fa fa-star"></i></span>
                <span class="star active" data-val="4"><i class="fa fa-star"></i></span>
                <span class="star active" data-val="5"><i class="fa fa-star"></i></span>
            </div>
            <textarea name="content" placeholder="说点什么..." required class="w-full px-3 py-2 text-sm border rounded-lg h-16"></textarea>
            <button type="submit" class="mt-2 w-full bg-blue-600 text-white py-2 rounded-lg">发布评论</button>
        </form>
        <div class="space-y-3 max-h-[400px] overflow-y-auto">
            <?php if(!$comments):?>
            <div class="text-xs text-gray-400 py-4 text-center">暂无评论</div>
            <?php endif;?>
            <?php foreach($comments as $c):?>
            <div class="border-b pb-2">
                <div class="flex justify-between text-xs">
                    <span><?=$c['name']?></span>
                    <span class="text-gray-400"><?=$c['time']?></span>
                </div>
                <div class="my-1">
                    <?php for($i=1;$i<=5;$i++):?>
                        <i class="fa fa-star text-xs <?=$i<=$c['star']?'text-yellow-400':'text-gray-200'?>"></i>
                    <?php endfor;?>
                </div>
                <p class="text-sm"><?=htmlspecialchars($c['content'])?></p>
            </div>
            <?php endforeach;?>
        </div>
    </div>
</div>

<div class="py-4 text-center text-xs text-gray-400">© 2026 职大校园墙 版权所有</div>

<script>
const APK_URL = "<?=$APK_URL?>";

// 复制链接 + 统计下载
function copyAndCount() {
    navigator.clipboard.writeText(APK_URL).then(() => {
        alert("复制成功，请打开浏览器粘贴下载");
        // 统计下载次数
        fetch("?act=count");
    }).catch(() => {
        alert("复制失败："+APK_URL);
    });
}

// 星级评分
document.querySelectorAll('.star').forEach(s => {
    s.addEventListener('click', () => {
        const v = s.dataset.val;
        document.getElementById('star').value = v;
        document.querySelectorAll('.star').forEach((star, i) => {
            star.classList.toggle('active', i < v);
        });
    });
});
</script>
</body>
</html>