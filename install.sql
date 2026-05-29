-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1
-- 生成日期： 2021-05-24 15:06:08
-- 服务器版本： 10.4.17-MariaDB
-- PHP 版本： 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `wp`
--

-- --------------------------------------------------------

--
-- 表的结构 `cl_ads`
--

CREATE TABLE `cl_ads` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `cover` varchar(3000) NOT NULL DEFAULT '',
  `company` varchar(120) NOT NULL DEFAULT '',
  `target_url` varchar(1200) NOT NULL DEFAULT '',
  `status` enum('orphan','active','inactive') NOT NULL DEFAULT 'orphan',
  `audience` varchar(3000) NOT NULL DEFAULT '[]',
  `description` varchar(600) NOT NULL DEFAULT '',
  `cta` varchar(300) NOT NULL DEFAULT '',
  `budget` varchar(15) NOT NULL DEFAULT '0.00',
  `clicks` int(11) NOT NULL DEFAULT 0,
  `views` int(11) NOT NULL DEFAULT 0,
  `time` varchar(25) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `cl_ads`
--

INSERT INTO `cl_ads` (`id`, `user_id`, `cover`, `company`, `target_url`, `status`, `audience`, `description`, `cta`, `budget`, `clicks`, `views`, `time`) VALUES
(1, 1, '', '', '', 'orphan', '[]', '', '', '0.00', 0, 0, '1611293508');

-- --------------------------------------------------------

--
-- 表的结构 `cl_affiliate_payouts`
--

CREATE TABLE `cl_affiliate_payouts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `email` varchar(120) NOT NULL DEFAULT '',
  `amount` varchar(25) NOT NULL DEFAULT '0.00',
  `bonuses` int(11) NOT NULL DEFAULT 0,
  `status` enum('pending','paid') NOT NULL DEFAULT 'pending',
  `time` varchar(25) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `cl_blocks`
--

CREATE TABLE `cl_blocks` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `profile_id` int(11) NOT NULL DEFAULT 0,
  `time` varchar(25) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `cl_bookmarks`
--

CREATE TABLE `cl_bookmarks` (
  `id` int(11) NOT NULL,
  `publication_id` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `time` varchar(25) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `cl_chats`
--

CREATE TABLE `cl_chats` (
  `id` int(11) NOT NULL,
  `user_one` int(11) NOT NULL DEFAULT 0,
  `user_two` int(11) NOT NULL DEFAULT 0,
  `time` varchar(25) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `cl_configs`
--

CREATE TABLE `cl_configs` (
  `id` int(11) NOT NULL,
  `title` varchar(120) NOT NULL DEFAULT '',
  `name` varchar(120) NOT NULL DEFAULT '',
  `value` varchar(3000) NOT NULL DEFAULT '',
  `regex` varchar(120) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `cl_configs`
--

INSERT INTO `cl_configs` (`id`, `title`, `name`, `value`, `regex`) VALUES
(1, 'Theme', 'theme', 'default', ''),
(2, 'Site name', 'name', 'Twitter', '/^(.){0,50}$/'),
(3, 'Site title', 'title', 'Twitter —— 狗凯之家源码网。', '/^(.){0,150}$/'),
(4, 'Site description', 'description', '关注你的兴趣所在。 听听大家在谈论什么。 加入对话。', '/^(.){0,350}$/'),
(5, 'SEO keywords', 'keywords', '狗凯之家源码,Twitter', ''),
(6, 'Site logo', 'site_logo', 'statics/img/logo.png', ''),
(7, 'Site favicon', 'site_favicon', 'statics/img/favicon.png', ''),
(8, 'Chat wallpaper', 'chat_wp', 'statics/img/chatwp/default.png', ''),
(9, 'Account activation', 'acc_validation', 'off', '/^(on|off)$/'),
(10, 'Default language', 'language', 'china', ''),
(11, 'AS3 storage', 'as3_storage', 'off', '/^(on|off)$/'),
(12, 'E-mail address', 'email', 'admin@qq.com', ''),
(13, 'SMTP server', 'smtp_or_mail', 'smtp', '/^(smtp|mail)$/'),
(14, 'SMTP host', 'smtp_host', '', ''),
(15, 'SMTP password', 'smtp_password', '', '/^(.){0,50}$/'),
(16, 'SMTP encryption', 'smtp_encryption', 'tls', '/^(ssl|tls)$/'),
(17, 'SMTP port', 'smtp_port', '587', '/^[0-9]{1,11}$/'),
(18, 'SMTP username', 'smtp_username', '', ''),
(19, 'FFMPEG binary', 'ffmpeg_binary', 'core/libs/ffmpeg/bin/ffmpeg.exe', '/^(.){0,550}$/'),
(20, 'Giphy api', 'giphy_api_key', 'EEoFiCosGuyEIWlXnRuw4McTLxfjCrl1', '/^(.){0,150}$/'),
(21, 'Google analytics', 'google_analytics', '', ''),
(22, 'Facebook API ID', 'facebook_api_id', '', '/^(.){0,150}$/'),
(23, 'Facebook API Key', 'facebook_api_key', '', '/^(.){0,150}$/'),
(24, 'Twitter API ID', 'twitter_api_id', '', '/^(.){0,150}$/'),
(25, 'Twitter API Key', 'twitter_api_key', '', '/^(.){0,150}$/'),
(26, 'Google API ID', 'google_api_id', '', '/^(.){0,150}$/'),
(27, 'Google API Key', 'google_api_key', '', '/^(.){0,150}$/'),
(28, 'Script version', 'version', '1.0.8', ''),
(29, 'Last backup', 'last_backup', '0', ''),
(30, 'Sitemap last update', 'sitemap_update', '', ''),
(31, 'Affiliate bonus rate', 'aff_bonus_rate', '0.10', '/^([0-9]{1,3}\\.[0-9]{1,3}|[0-9]{1,3})$/'),
(32, 'Affiliates System', 'affiliates_system', 'on', '/^(on|off)$/'),
(33, 'PayPal API Public key', 'paypal_api_key', '', ''),
(34, 'PayPal API Secret key', 'paypal_api_pass', '', ''),
(35, 'PayPal Payment Mode', 'paypal_mode', 'sandbox', '/^(sandbox|live)$/'),
(36, 'Site currency', 'site_currency', 'jpy', ' \r\n/^([a-zA-Z]){2,7}$/'),
(37, 'Advertising system', 'advertising_system', 'off', '/^(on|off)$/'),
(38, 'Ad conversion rate', 'ad_conversion_rate', '0.05', '/^([0-9]{1,3}\\.[0-9]{1,3}|[0-9]{1,3})$/'),
(39, 'Max post length', 'max_post_len', '600', '/^[0-9]{1,11}$/');

-- --------------------------------------------------------

--
-- 表的结构 `cl_connections`
--

CREATE TABLE `cl_connections` (
  `id` int(11) NOT NULL,
  `follower_id` int(11) NOT NULL DEFAULT 0,
  `following_id` int(11) NOT NULL DEFAULT 0,
  `status` enum('active','pending') NOT NULL DEFAULT 'active',
  `time` varchar(25) NOT NULL DEFAULT '25'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `cl_hashtags`
--

CREATE TABLE `cl_hashtags` (
  `id` int(11) NOT NULL,
  `posts` int(11) NOT NULL DEFAULT 0,
  `tag` varchar(200) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `time` varchar(25) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `cl_hashtags`
--

INSERT INTO `cl_hashtags` (`id`, `posts`, `tag`, `time`) VALUES
(2, 1, '经典语录', '1616137941'),
(3, 1, '幼儿园男孩帮女同学扎丸子头', '1616138030'),
(4, 1, '上海哈啰单车半小时收费2', '1616138256'),
(5, 1, '美研究称印度贫困人口增加7500万', '1616138487'),
(6, 1, '喜欢春天的星光灿烂', '1616138811'),
(7, 1, '中美高层战略对话', '1616139070');

-- --------------------------------------------------------

--
-- 表的结构 `cl_messages`
--

CREATE TABLE `cl_messages` (
  `id` int(11) NOT NULL,
  `sent_by` int(11) NOT NULL DEFAULT 0,
  `sent_to` int(11) NOT NULL DEFAULT 0,
  `owner` int(11) NOT NULL DEFAULT 0,
  `message` varchar(3000) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `media_file` varchar(1000) NOT NULL DEFAULT '',
  `media_type` varchar(25) NOT NULL DEFAULT 'none',
  `seen` varchar(25) NOT NULL DEFAULT '0',
  `deleted_fs1` enum('Y','N') NOT NULL DEFAULT 'N',
  `deleted_fs2` enum('Y','N') NOT NULL DEFAULT 'N',
  `time` varchar(25) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `cl_notifications`
--

CREATE TABLE `cl_notifications` (
  `id` int(11) NOT NULL,
  `notifier_id` int(11) NOT NULL DEFAULT 0,
  `recipient_id` int(11) NOT NULL DEFAULT 0,
  `status` enum('0','1') NOT NULL DEFAULT '0',
  `subject` varchar(32) NOT NULL DEFAULT 'none',
  `entry_id` int(11) NOT NULL DEFAULT 0,
  `json` varchar(1200) NOT NULL DEFAULT '[]',
  `time` varchar(25) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `cl_notifications`
--

INSERT INTO `cl_notifications` (`id`, `notifier_id`, `recipient_id`, `status`, `subject`, `entry_id`, `json`, `time`) VALUES
(10, 11, 8, '0', 'visit', 11, '[]', '1616136948'),
(11, 1, 6, '0', 'visit', 1, '[]', '1621849206');

-- --------------------------------------------------------

--
-- 表的结构 `cl_posts`
--

CREATE TABLE `cl_posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `publication_id` int(11) NOT NULL DEFAULT 0,
  `type` enum('post','repost') NOT NULL DEFAULT 'post',
  `time` varchar(25) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `cl_posts`
--

INSERT INTO `cl_posts` (`id`, `user_id`, `publication_id`, `type`, `time`) VALUES
(32, 1, 31, 'post', '1616137416'),
(33, 1, 32, 'post', '1616137740'),
(34, 1, 33, 'post', '1616137941'),
(35, 1, 34, 'post', '1616138030'),
(36, 1, 35, 'post', '1616138256'),
(37, 1, 36, 'post', '1616138487'),
(38, 1, 37, 'post', '1616138811'),
(39, 1, 38, 'post', '1616139070');

-- --------------------------------------------------------

--
-- 表的结构 `cl_profile_reports`
--

CREATE TABLE `cl_profile_reports` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `profile_id` int(11) NOT NULL DEFAULT 0,
  `reason` int(3) NOT NULL DEFAULT 0,
  `comment` varchar(3000) NOT NULL DEFAULT '',
  `seen` enum('0','1') NOT NULL DEFAULT '0',
  `time` varchar(25) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `cl_publications`
--

CREATE TABLE `cl_publications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `text` text CHARACTER SET utf8mb4 DEFAULT NULL,
  `type` enum('text','video','image','gif','poll') NOT NULL DEFAULT 'text',
  `replys_count` int(11) NOT NULL DEFAULT 0,
  `reposts_count` int(11) NOT NULL DEFAULT 0,
  `likes_count` int(11) NOT NULL DEFAULT 0,
  `status` enum('active','inactive','deleted','orphan') NOT NULL DEFAULT 'active',
  `thread_id` int(11) NOT NULL DEFAULT 0,
  `target` enum('publication','pub_reply') NOT NULL DEFAULT 'publication',
  `og_data` varchar(3000) DEFAULT '',
  `poll_data` text DEFAULT NULL,
  `priv_wcs` enum('everyone','followers') NOT NULL DEFAULT 'everyone',
  `priv_wcr` enum('everyone','followers','mentioned') NOT NULL DEFAULT 'everyone',
  `time` varchar(25) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `cl_publications`
--

INSERT INTO `cl_publications` (`id`, `user_id`, `text`, `type`, `replys_count`, `reposts_count`, `likes_count`, `status`, `thread_id`, `target`, `og_data`, `poll_data`, `priv_wcs`, `priv_wcr`, `time`) VALUES
(31, 1, '😍爱你的人，忙完手头的事，马上就会联系你，生怕冷落了你。不爱你的人，忙着忙着就消失了，睡着睡着就去世了，吃着吃着就死在饭桌上了，喝着喝着就送去火葬场了。', 'image', 0, 0, 0, 'active', 0, 'publication', '', NULL, 'everyone', 'everyone', '1616137416'),
(32, 1, '你希望如何重新安装Windows系统？☹️', 'poll', 0, 0, 0, 'active', 0, 'publication', '', '[{\"option\": \"通过硬盘\",\"voters\": [],\"votes\": 0},{\"option\": \"通过优盘\",\"voters\": [1],\"votes\": 1},{\"option\": \"通过电脑城\",\"voters\": [],\"votes\": 0}]', 'everyone', 'everyone', '1616137740'),
(33, 1, '{#id:2#} 以前总以为爱的人就是合适的人，就算不合适磨合磨合也就合适了，然而磨合得伤痕累累，别扭的地方仍然太多，这才醒悟过来，爱不一定合适，合适的人爱起来根本不会满身伤痕。', 'text', 0, 0, 0, 'active', 0, 'publication', '', NULL, 'everyone', 'everyone', '1616137941'),
(34, 1, '{#id:3#} 手法娴熟 网友惊呼：自愧不如3月17日，四川西昌，幼儿园大班的小男孩为班里女孩梳丸子头的视频走红。视频中，男孩用娴熟的手法给女孩梳头。老师称，当时是孩子们正在看书，“为了方便看书，就帮女孩扎了头发。', 'text', 0, 0, 0, 'active', 0, 'publication', '', NULL, 'everyone', 'everyone', '1616138030'),
(35, 1, '{#id:4#}.5元 \\r\\n上海的哈啰单车涨价了。目前，哈啰单车的收费规则为前15分钟1.5元，之后每15分钟1元，相当于1小时4.5元。2019年4月29日，哈啰单车曾将计费标准从每30分钟1元调整为每30分钟1.5元。目前，上海的美团单车与青桔单车价格均为前15分钟1.5元。', 'image', 0, 0, 0, 'active', 0, 'publication', '', NULL, 'everyone', 'everyone', '1616138256'),
(36, 1, '【{#id:5#} 】俄罗斯卫星通讯社19日报道称，美国皮尤研究中心最新研究显示，新冠病毒大流行引发的经济危机对全球居民生活水平产生重大影响，致使大批人脱离中产或陷入贫困，其中印度2020年中产将骤减3200万、贫困人口增加7500万。（海外网；LX） ​​​', 'video', 0, 0, 0, 'active', 0, 'publication', '', NULL, 'everyone', 'everyone', '1616138487'),
(37, 1, '👢☂️{#id:6#}', 'image', 0, 0, 0, 'active', 0, 'publication', '', NULL, 'everyone', 'everyone', '1616138811'),
(38, 1, '{#id:7#} 这里边美国人用数据说自己没超时。但视频里有中方英语喊的是这不公平，你们说了两轮，我们只说了一轮。唇枪舌战也讲就回合，我出一招，你出两招，你不能说你反手一挡就不能算出招，但贵国看客觉得你已经反击了，你的目的就达到了。', 'image', 0, 0, 0, 'active', 0, 'publication', '', NULL, 'everyone', 'everyone', '1616139070');

-- --------------------------------------------------------

--
-- 表的结构 `cl_publikes`
--

CREATE TABLE `cl_publikes` (
  `id` int(11) NOT NULL,
  `pub_id` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `time` varchar(25) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `cl_pubmedia`
--

CREATE TABLE `cl_pubmedia` (
  `id` int(11) NOT NULL,
  `pub_id` int(11) NOT NULL DEFAULT 0,
  `type` enum('image','video','gif') NOT NULL,
  `src` varchar(1200) NOT NULL DEFAULT '',
  `json_data` varchar(3000) NOT NULL DEFAULT '[]',
  `time` varchar(25) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `cl_pubmedia`
--

INSERT INTO `cl_pubmedia` (`id`, `pub_id`, `type`, `src`, `json_data`, `time`) VALUES
(19, 31, 'image', 'upload/images/2021/03/9KMhhkPNcpAdYrHL9qMp_19_9268e35b4eaf6e71d28e6c4d625a920b_image_original.jpg', '{\n    \"image_thumb\": \"upload\\/images\\/2021\\/03\\/8sx7KqdsFtKgLLUWqn59_19_9268e35b4eaf6e71d28e6c4d625a920b_image_300x300.jpg\"\n}', '1616137411'),
(20, 35, 'image', 'upload/images/2021/03/Ph3cbiZg7KaPYR2GPgNE_19_4269f56c66c4dac35540bd3c0bcb387c_image_original.jpg', '{\n    \"image_thumb\": \"upload\\/images\\/2021\\/03\\/sBDomoOBdfwt2odS6jyz_19_4269f56c66c4dac35540bd3c0bcb387c_image_300x300.jpg\"\n}', '1616138251'),
(21, 36, 'video', 'upload/videos/2021/03/WFhb1Hr6MYkZaWEJsbE6_19_667942af9a6f4a0d7b4aa14d1e96ae5d_video_original.mp4', '{\n    \"poster_thumb\": \"upload\\/images\\/2021\\/03\\/SuIktl6PjmnETJ8dSfsM_19_667942af9a6f4a0d7b4aa14d1e96ae5d_image_poster.jpeg\"\n}', '1616138482'),
(22, 37, 'image', 'upload/images/2021/03/2fKj19piHYVJTPXdukK2_19_856a2e299cca345b679e77d5787585a3_image_original.jpg', '{\n    \"image_thumb\": \"upload\\/images\\/2021\\/03\\/eXSXeRRjKALITs4sTNb8_19_856a2e299cca345b679e77d5787585a3_image_300x300.jpg\"\n}', '1616138806'),
(23, 37, 'image', 'upload/images/2021/03/9AdqM8j5pedpgUAfMMY5_19_dae2819d90e2966006e49f60d22b68de_image_original.jpg', '{\n    \"image_thumb\": \"upload\\/images\\/2021\\/03\\/wrHloWXiguWmB55aNeTa_19_dae2819d90e2966006e49f60d22b68de_image_300x300.jpg\"\n}', '1616138806'),
(24, 37, 'image', 'upload/images/2021/03/VTaMh7PeaSJE6xByvaAW_19_dae2819d90e2966006e49f60d22b68de_image_original.jpg', '{\n    \"image_thumb\": \"upload\\/images\\/2021\\/03\\/EHXlczInCpPvYL7FyBhf_19_dae2819d90e2966006e49f60d22b68de_image_300x300.jpg\"\n}', '1616138806'),
(25, 37, 'image', 'upload/images/2021/03/vQ1MME9aWk3qxKOfjz1Z_19_dae2819d90e2966006e49f60d22b68de_image_original.jpg', '{\n    \"image_thumb\": \"upload\\/images\\/2021\\/03\\/xeOZt4qfFM3T5cxVLhxw_19_dae2819d90e2966006e49f60d22b68de_image_300x300.jpg\"\n}', '1616138806'),
(26, 37, 'image', 'upload/images/2021/03/HnzzbzhSP58Ehlar1rKZ_19_dae2819d90e2966006e49f60d22b68de_image_original.jpg', '{\n    \"image_thumb\": \"upload\\/images\\/2021\\/03\\/mPYtOpkgo7ErHyVYUcYl_19_dae2819d90e2966006e49f60d22b68de_image_300x300.jpg\"\n}', '1616138807'),
(27, 37, 'image', 'upload/images/2021/03/sxAaBvZIe1OSZNTepuFP_19_34e6e60eb374fbd288b313e575e482be_image_original.jpg', '{\n    \"image_thumb\": \"upload\\/images\\/2021\\/03\\/nqQvxmUv8Qhrdrvi1SVe_19_34e6e60eb374fbd288b313e575e482be_image_300x300.jpg\"\n}', '1616138807'),
(28, 38, 'image', 'upload/images/2021/03/3VNEK5StUnkDnCcr6uL2_19_d75cacf9f8a0eb4d8c8fd7ed1f013fd0_image_original.png', '{\n    \"image_thumb\": \"upload\\/images\\/2021\\/03\\/5UD3oNy7eNJg4T37IcYj_19_d75cacf9f8a0eb4d8c8fd7ed1f013fd0_image_300x300.png\"\n}', '1616139065');

-- --------------------------------------------------------

--
-- 表的结构 `cl_sessions`
--

CREATE TABLE `cl_sessions` (
  `id` int(11) NOT NULL,
  `session_id` varchar(120) NOT NULL DEFAULT '',
  `user_id` varchar(11) NOT NULL DEFAULT '0',
  `platform` varchar(15) NOT NULL DEFAULT 'web',
  `time` varchar(25) NOT NULL DEFAULT '0',
  `lifespan` varchar(25) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `cl_sessions`
--

INSERT INTO `cl_sessions` (`id`, `session_id`, `user_id`, `platform`, `time`, `lifespan`) VALUES
(3, 'c0ec8f6b2b9480d402084ef9426a79f355d579f416113141206a50b7b93e633bb3a64e40dd64ca0277', '1', 'web', '1611314120', '1642850120'),
(31, 'fa5754d5d0f187486d0a13e28f63de4994d568f21616146308afc266914701457b2bf85dab0cab3ce7', '1', 'web', '1616146308', '1647682308'),
(36, 'ebf489df36421a8601fda56e0fab5f7e43b0ccbb1621835959e3bd8f23ab56895ee044f5c2196e0117', '1', 'web', '1621835959', '1653371959'),
(39, '4682dfb0e9ac0ef75bfa7d281362977cc0275a4e162185895249f06d1d1d652d3309c7aecaa12e5a69', '1', 'web', '1621858952', '1653394952');

-- --------------------------------------------------------

--
-- 表的结构 `cl_users`
--

CREATE TABLE `cl_users` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL DEFAULT '',
  `fname` varchar(30) NOT NULL DEFAULT '',
  `lname` varchar(30) NOT NULL DEFAULT '',
  `about` varchar(150) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `gender` enum('M','F') NOT NULL DEFAULT 'M',
  `email` varchar(60) NOT NULL DEFAULT '',
  `em_code` varchar(100) NOT NULL DEFAULT '',
  `password` varchar(140) NOT NULL DEFAULT '',
  `joined` varchar(20) NOT NULL DEFAULT '0',
  `last_active` varchar(20) NOT NULL DEFAULT '0',
  `ip_address` varchar(140) NOT NULL DEFAULT '0.0.0.0',
  `language` varchar(32) NOT NULL DEFAULT 'default',
  `avatar` varchar(300) NOT NULL DEFAULT 'upload/default/avatar.png',
  `cover` varchar(300) NOT NULL DEFAULT 'upload/default/cover.png',
  `cover_orig` varchar(300) NOT NULL DEFAULT 'upload/default/cover.png',
  `active` enum('0','1','2') NOT NULL DEFAULT '0',
  `verified` enum('0','1','2') NOT NULL DEFAULT '0',
  `admin` enum('0','1') NOT NULL DEFAULT '0',
  `posts` int(11) NOT NULL DEFAULT 0,
  `followers` int(11) NOT NULL DEFAULT 0,
  `following` int(11) NOT NULL DEFAULT 0,
  `website` varchar(120) NOT NULL DEFAULT '',
  `country_id` int(3) NOT NULL DEFAULT 1,
  `last_post` int(11) NOT NULL DEFAULT 0,
  `last_swift` varchar(135) NOT NULL DEFAULT '',
  `last_ad` int(11) NOT NULL DEFAULT 0,
  `profile_privacy` enum('everyone','followers') NOT NULL DEFAULT 'everyone',
  `follow_privacy` enum('everyone','approved') NOT NULL DEFAULT 'everyone',
  `contact_privacy` enum('everyone','followed') NOT NULL DEFAULT 'everyone',
  `index_privacy` enum('Y','N') NOT NULL DEFAULT 'Y',
  `aff_bonuses` int(11) NOT NULL DEFAULT 0,
  `wallet` varchar(25) NOT NULL DEFAULT '0.00',
  `pnotif_token` varchar(600) NOT NULL DEFAULT '{"token": "","type": "android"}',
  `refresh_token` varchar(220) NOT NULL DEFAULT '0',
  `settings` varchar(3000) NOT NULL DEFAULT '{"notifs":{"like":1,"subscribe":1,"subscribe_request":1,"subscribe_accept":1,"reply":1,"repost":1,"mention":1,"visit":1}}',
  `swift` text CHARACTER SET utf8mb4 DEFAULT NULL,
  `swift_update` varchar(25) NOT NULL DEFAULT '0',
  `info_file` varchar(300) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `cl_users`
--

INSERT INTO `cl_users` (`id`, `username`, `fname`, `lname`, `about`, `gender`, `email`, `em_code`, `password`, `joined`, `last_active`, `ip_address`, `language`, `avatar`, `cover`, `cover_orig`, `active`, `verified`, `admin`, `posts`, `followers`, `following`, `website`, `country_id`, `last_post`, `last_swift`, `last_ad`, `profile_privacy`, `follow_privacy`, `contact_privacy`, `index_privacy`, `aff_bonuses`, `wallet`, `pnotif_token`, `refresh_token`, `settings`, `swift`, `swift_update`, `info_file`) VALUES
(1, 'administrator', 'Site', 'Admin', '', 'M', 'admin@qq.com', '', '$2y$10$txMDpfxeN9wjlh4KNxAOtu9nXfp9jCw/YCMGwsV68xWQ0V4gt6Iye', '1611292370', '1621859951', '::1', 'china', 'upload/avatars/2021/01/pdRQEFCTswBgoUBnePpk_22_03ffaab482fffbc687b0ea12ff68043b_thumbnail_512x512.jpg', 'upload/covers/2021/01/ezH6BIFZaep9ZecMlEyl_22_e86af5d78aaf7be096cef18370981b53_image_cover_600x200.jpg', 'upload/covers/2021/01/ezH6BIFZaep9ZecMlEyl_22_e86af5d78aaf7be096cef18370981b53_image_cover.jpg', '1', '1', '1', 8, 0, 0, '', 45, 0, '', 1, 'everyone', 'everyone', 'everyone', 'Y', 0, '0.00', '{\"token\": \"\",\"type\": \"android\"}', '0', '{\"notifs\":{\"like\":1,\"subscribe\":1,\"subscribe_request\":1,\"subscribe_accept\":1,\"reply\":1,\"repost\":1,\"mention\":1,\"visit\":1}}', '[]', '1611391307', ''),
(6, 'linazhang', '阿乐源码网', '源码', '', 'M', 'linazhang@163.com', 'bd13c30972945f8f8fe22c2e787adc9e8aff75c6', '$2y$10$1QR4CoN5CQLl9WLwh5MWIuuhREnOLusM0k7DvOO6SmpTNsMeNXWCC', '1616133621', '1616134422', '127.0.0.1', 'china', 'upload/avatars/2021/03/Qn7TA7hqVlUUwy2wXBRY_19_11bbcbd9472f8df69608b1b41be2a575_thumbnail_512x512.jpg', 'upload/covers/2021/03/pIciBOGwQ6suT8YEVQBy_19_7b840e6b29da3ce3cb9015ba4f687ae1_image_cover_600x200.jpg', 'upload/covers/2021/03/pIciBOGwQ6suT8YEVQBy_19_7b840e6b29da3ce3cb9015ba4f687ae1_image_cover.jpg', '1', '0', '0', 0, 0, 0, '', 1, 0, '', 0, 'everyone', 'everyone', 'everyone', 'Y', 0, '0.00', '{\"token\": \"\",\"type\": \"android\"}', '0', '{\"notifs\":{\"like\":1,\"subscribe\":1,\"subscribe_request\":1,\"subscribe_accept\":1,\"reply\":1,\"repost\":1,\"mention\":1,\"visit\":1}}', NULL, '0', ''),
(7, 'suxiqing', '苏', '西芹', '', 'M', 'suxiqing@163.com', 'a9a9613c3841f571a2e0d7549a60c343360c699c', '$2y$10$A90j9wCgFmAL5kiWp/zg7eLJvJNXT9AYked73npyXjbIxs2SLCjOK', '1616135972', '1616136060', '127.0.0.1', 'china', 'upload/avatars/2021/03/RlnxrYFDiuK85QZ64UEC_19_c84379e2fbc8081f39db62f6945dd579_thumbnail_512x512.jpg', 'upload/covers/2021/03/DM1Kogh4qy5qTtP4ZjAX_19_bcd0f7f25c2be656a9c1b7dd2866277c_image_cover_600x200.jpg', 'upload/covers/2021/03/DM1Kogh4qy5qTtP4ZjAX_19_bcd0f7f25c2be656a9c1b7dd2866277c_image_cover.jpg', '1', '0', '0', 0, 0, 0, '', 1, 0, '', 0, 'everyone', 'everyone', 'everyone', 'Y', 0, '0.00', '{\"token\": \"\",\"type\": \"android\"}', '0', '{\"notifs\":{\"like\":1,\"subscribe\":1,\"subscribe_request\":1,\"subscribe_accept\":1,\"reply\":1,\"repost\":1,\"mention\":1,\"visit\":1}}', NULL, '0', ''),
(8, 'huangxubing', '黄', '徐冰', '', 'M', 'huangxubing@163.com', '4dc08b26d3049e903331dbdf5b8a662b80620431', '$2y$10$bnvVNJkZLTF2DPqf6PHSbuYyIYrn5N9cVNun/k9.Noyz8die64VEO', '1616136184', '1616136215', '127.0.0.1', 'china', 'upload/avatars/2021/03/5qipeSyW29CFprARPRnm_19_3f2a786c1e8be6a47acc82c550756c9c_thumbnail_512x512.jpg', 'upload/covers/2021/03/JljXgrVBXjvUFhhXAzrt_19_8e8007380c1770c66d281de380669ab0_image_cover_600x200.jpg', 'upload/covers/2021/03/JljXgrVBXjvUFhhXAzrt_19_8e8007380c1770c66d281de380669ab0_image_cover.jpg', '1', '0', '0', 0, 0, 0, '', 1, 0, '', 0, 'everyone', 'everyone', 'everyone', 'Y', 0, '0.00', '{\"token\": \"\",\"type\": \"android\"}', '0', '{\"notifs\":{\"like\":1,\"subscribe\":1,\"subscribe_request\":1,\"subscribe_accept\":1,\"reply\":1,\"repost\":1,\"mention\":1,\"visit\":1}}', NULL, '0', ''),
(9, 'cxiisyun', '陈', '小云', '', 'M', 'cxiisyun@163.com', 'cb0733f6645a5c571ff71bba3551afd7aafb0349', '$2y$10$FlXUbtiMmTH9SOLD7Vj75.IRCFAAZszJ7/mzXq10bgjsmDj3CXxqC', '1616136359', '1616136359', '127.0.0.1', 'china', 'upload/avatars/2021/03/ixHTEcUIJRz5tBdCH7qG_19_a84969a37bf3559952eba4f049ad2702_thumbnail_512x512.jpg', 'upload/covers/2021/03/rb9hUkAkCuv2LeGeevso_19_df197accf7a27012920e1fd8f9a048ee_image_cover_600x200.jpg', 'upload/covers/2021/03/rb9hUkAkCuv2LeGeevso_19_df197accf7a27012920e1fd8f9a048ee_image_cover.jpg', '1', '0', '0', 0, 0, 0, '', 1, 0, '', 0, 'everyone', 'everyone', 'everyone', 'Y', 0, '0.00', '{\"token\": \"\",\"type\": \"android\"}', '0', '{\"notifs\":{\"like\":1,\"subscribe\":1,\"subscribe_request\":1,\"subscribe_accept\":1,\"reply\":1,\"repost\":1,\"mention\":1,\"visit\":1}}', NULL, '0', ''),
(10, 'xiangxx', '向', '晓晓', '', 'M', 'xiangxx@163.com', '058ac2155f42a724e044bc0cfb356823c81d5bd2', '$2y$10$Rjy0CufPDlBN2Pe2/ij0JeW2ULcR8xkp11vDXLYyNq0LR48DXBFFG', '1616136512', '1616136542', '127.0.0.1', 'china', 'upload/avatars/2021/03/gr9wwRCZJRYkLTWWkVuF_19_c13e24e97bb9829e99c395c180f9c7e5_thumbnail_512x512.jpg', 'upload/covers/2021/03/LRuqTz37jIaGWQq2dOTx_19_f0f3bd682a3fc325dafc7009752ee368_image_cover_600x200.jpg', 'upload/covers/2021/03/LRuqTz37jIaGWQq2dOTx_19_f0f3bd682a3fc325dafc7009752ee368_image_cover.jpg', '1', '0', '0', 0, 0, 0, '', 1, 0, '', 0, 'everyone', 'everyone', 'everyone', 'Y', 0, '0.00', '{\"token\": \"\",\"type\": \"android\"}', '0', '{\"notifs\":{\"like\":1,\"subscribe\":1,\"subscribe_request\":1,\"subscribe_accept\":1,\"reply\":1,\"repost\":1,\"mention\":1,\"visit\":1}}', NULL, '0', ''),
(11, 'huyunjun', '胡', '韵菌', '', 'M', 'huyunjun@163.com', '145d9eace4a09c43a63b8ef57eaeed012ee2b9b7', '$2y$10$bUuhqKRN1QFkjQ1CPzP5iuF4Q.qkb3jcueTRJPwBrozYNkunyJUIG', '1616136687', '1616136959', '127.0.0.1', 'china', 'upload/avatars/2021/03/YfXB3Iihoq8XeMZdd8FN_19_cf71ec4307e63a741d9e2d4c2974f1c7_thumbnail_512x512.jpg', 'upload/covers/2021/03/TnmLHjkt4nohMxmcN2YX_19_bc0cce65770772119807e695f415d066_image_cover_600x200.jpg', 'upload/covers/2021/03/TnmLHjkt4nohMxmcN2YX_19_bc0cce65770772119807e695f415d066_image_cover.jpg', '1', '0', '0', 0, 0, 0, '', 1, 0, '', 0, 'everyone', 'everyone', 'everyone', 'Y', 0, '0.00', '{\"token\": \"\",\"type\": \"android\"}', '0', '{\"notifs\":{\"like\":1,\"subscribe\":1,\"subscribe_request\":1,\"subscribe_accept\":1,\"reply\":1,\"repost\":1,\"mention\":1,\"visit\":1}}', NULL, '0', '');

-- --------------------------------------------------------

--
-- 表的结构 `cl_verifications`
--

CREATE TABLE `cl_verifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `full_name` varchar(120) NOT NULL DEFAULT '',
  `text_message` varchar(1200) NOT NULL DEFAULT '',
  `video_message` varchar(300) NOT NULL DEFAULT '',
  `time` int(25) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `cl_wallet_history`
--

CREATE TABLE `cl_wallet_history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `operation` varchar(60) NOT NULL DEFAULT '',
  `amount` varchar(25) NOT NULL DEFAULT '0.00',
  `json_data` varchar(3000) NOT NULL DEFAULT '[]',
  `time` varchar(25) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转储表的索引
--

--
-- 表的索引 `cl_ads`
--
ALTER TABLE `cl_ads`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `cl_affiliate_payouts`
--
ALTER TABLE `cl_affiliate_payouts`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `cl_blocks`
--
ALTER TABLE `cl_blocks`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `cl_bookmarks`
--
ALTER TABLE `cl_bookmarks`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `cl_chats`
--
ALTER TABLE `cl_chats`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `cl_configs`
--
ALTER TABLE `cl_configs`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `cl_connections`
--
ALTER TABLE `cl_connections`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `cl_hashtags`
--
ALTER TABLE `cl_hashtags`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `cl_messages`
--
ALTER TABLE `cl_messages`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `cl_notifications`
--
ALTER TABLE `cl_notifications`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `cl_posts`
--
ALTER TABLE `cl_posts`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `cl_profile_reports`
--
ALTER TABLE `cl_profile_reports`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `cl_publications`
--
ALTER TABLE `cl_publications`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `cl_publikes`
--
ALTER TABLE `cl_publikes`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `cl_pubmedia`
--
ALTER TABLE `cl_pubmedia`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `cl_sessions`
--
ALTER TABLE `cl_sessions`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `cl_users`
--
ALTER TABLE `cl_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `posts` (`posts`);

--
-- 表的索引 `cl_verifications`
--
ALTER TABLE `cl_verifications`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `cl_wallet_history`
--
ALTER TABLE `cl_wallet_history`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `cl_ads`
--
ALTER TABLE `cl_ads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `cl_affiliate_payouts`
--
ALTER TABLE `cl_affiliate_payouts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `cl_blocks`
--
ALTER TABLE `cl_blocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `cl_bookmarks`
--
ALTER TABLE `cl_bookmarks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `cl_chats`
--
ALTER TABLE `cl_chats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `cl_configs`
--
ALTER TABLE `cl_configs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- 使用表AUTO_INCREMENT `cl_connections`
--
ALTER TABLE `cl_connections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `cl_hashtags`
--
ALTER TABLE `cl_hashtags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- 使用表AUTO_INCREMENT `cl_messages`
--
ALTER TABLE `cl_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `cl_notifications`
--
ALTER TABLE `cl_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- 使用表AUTO_INCREMENT `cl_posts`
--
ALTER TABLE `cl_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- 使用表AUTO_INCREMENT `cl_profile_reports`
--
ALTER TABLE `cl_profile_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `cl_publications`
--
ALTER TABLE `cl_publications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- 使用表AUTO_INCREMENT `cl_publikes`
--
ALTER TABLE `cl_publikes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `cl_pubmedia`
--
ALTER TABLE `cl_pubmedia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- 使用表AUTO_INCREMENT `cl_sessions`
--
ALTER TABLE `cl_sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- 使用表AUTO_INCREMENT `cl_users`
--
ALTER TABLE `cl_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- 使用表AUTO_INCREMENT `cl_verifications`
--
ALTER TABLE `cl_verifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `cl_wallet_history`
--
ALTER TABLE `cl_wallet_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
