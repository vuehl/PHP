-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 2017-06-02 09:14:51
-- 服务器版本： 5.7.17-log
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `textguest`
--
CREATE DATABASE IF NOT EXISTS `textguest` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `textguest`;

-- --------------------------------------------------------

--
-- 表的结构 `tg_arcticle`
--

CREATE TABLE `tg_arcticle` (
  `tg_id` mediumint(8) UNSIGNED NOT NULL COMMENT '//id',
  `tg_reid` mediumint(8) NOT NULL DEFAULT '0' COMMENT '//评论的id',
  `tg_username` varchar(20) NOT NULL COMMENT '//发贴人',
  `tg_title` varchar(40) NOT NULL COMMENT '//发帖标题',
  `tg_content` text NOT NULL COMMENT '//发帖内容',
  `tg_readcount` smallint(5) NOT NULL DEFAULT '0' COMMENT '//阅读量',
  `tg_commendcount` smallint(5) NOT NULL DEFAULT '0' COMMENT '//评论量',
  `tg_nice` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '//這个是设置精华帖的部分',
  `tg_date` datetime NOT NULL COMMENT '//发表时间',
  `tg_last_modify_date` datetime NOT NULL COMMENT '//最后登录修改的时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `tg_arcticle`
--

INSERT INTO `tg_arcticle` (`tg_id`, `tg_reid`, `tg_username`, `tg_title`, `tg_content`, `tg_readcount`, `tg_commendcount`, `tg_nice`, `tg_date`, `tg_last_modify_date`) VALUES
(6, 5, 'heleilei', 'RE:我是瓜娃子何尧我是瓜娃子何尧我是瓜娃子何尧', '没意思,好烦呀,挺无聊的[img]qpic/1/3.gif[/img][img]qpic/1/7.gif[/img]', 0, 0, 0, '2017-05-10 13:10:14', '0000-00-00 00:00:00'),
(7, 5, 'heleilei', 'RE:RE:我是瓜娃子何尧我是瓜娃子何尧我是瓜娃子何尧', '465464641654654[img]qpic/1/2.gif[/img]', 0, 0, 0, '2017-05-11 12:40:17', '0000-00-00 00:00:00'),
(8, 5, 'heleilei', 'RE:RE:RE:我是瓜娃子何尧我是瓜娃子何尧我是瓜娃子何尧', '216546456546546', 0, 0, 0, '2017-05-11 13:32:02', '0000-00-00 00:00:00'),
(9, 5, 'heleilei', 'RE:RE:RE:RE:我是瓜娃子何尧我是瓜娃子何尧我是瓜娃子何尧', 'khjlkhlkh lhlhl', 0, 0, 0, '2017-05-11 13:35:39', '0000-00-00 00:00:00'),
(10, 5, 'heleilei', 'RE:我是瓜娃子何尧我是瓜娃子何尧我是瓜娃子何尧', '125646546546', 0, 0, 0, '2017-05-11 13:44:04', '0000-00-00 00:00:00'),
(11, 5, 'heleilei', 'RE:RE:我是瓜娃子何尧我是瓜娃子何尧我是瓜娃子何尧', 'jghkgknbkgkgkj', 0, 0, 0, '2017-05-11 13:50:13', '0000-00-00 00:00:00'),
(12, 5, 'heleilei', 'RE:RE:我是瓜娃子何尧我是瓜娃子何尧我是瓜娃子何尧', '5464654654', 0, 0, 0, '2017-05-11 13:51:28', '0000-00-00 00:00:00'),
(14, 13, 'zyq520', 'RE:瓜娃子何尧', '你长的真乖  [img]qpic/1/7.gif[/img][img]qpic/1/13.gif[/img]', 0, 0, 0, '2017-05-11 16:14:32', '0000-00-00 00:00:00'),
(15, 5, '彭宇123', 'RE:我是瓜娃子何尧我是瓜娃子何尧我是瓜娃子何尧', '[img]qpic/1/1.gif[/img]', 0, 0, 0, '2017-05-14 15:54:34', '0000-00-00 00:00:00'),
(16, 5, '彭宇123', 'RE:我是瓜娃子何尧我是瓜娃子何尧我是瓜娃子何尧', '[img]qpic/1/2.gif[/img]', 0, 0, 0, '2017-05-14 15:55:00', '0000-00-00 00:00:00'),
(17, 5, '彭宇123', 'RE:我是瓜娃子何尧我是瓜娃子何尧我是瓜娃子何尧', '我是第10楼,我好开心呀[img]qpic/1/3.gif[/img]', 0, 0, 0, '2017-05-14 16:21:36', '0000-00-00 00:00:00'),
(18, 5, '彭宇123', 'RE:我是瓜娃子何尧我是瓜娃子何尧我是瓜娃子何尧', '我是第12楼  拉啦啦[img]qpic/1/4.gif[/img]', 0, 0, 0, '2017-05-14 16:23:00', '0000-00-00 00:00:00'),
(19, 5, '何尧123', 'RE:我是瓜娃子何尧我是瓜娃子何尧我是瓜娃子何尧', '大家觉得怎么样[img]qpic/1/11.gif[/img]', 0, 0, 0, '2017-05-14 16:28:11', '0000-00-00 00:00:00'),
(20, 5, '何尧123', 'RE:我是瓜娃子何尧我是瓜娃子何尧我是瓜娃子何尧', '大家好 我是楼主,欢迎你们的评论[img]qpic/1/7.gif[/img]', 0, 0, 0, '2017-05-14 16:30:43', '0000-00-00 00:00:00'),
(21, 5, '何尧123', 'RE:我是瓜娃子何尧我是瓜娃子何尧我是瓜娃子何尧', '[img]qpic/1/4.gif[/img][img]qpic/1/3.gif[/img]', 0, 0, 0, '2017-05-14 16:33:24', '0000-00-00 00:00:00'),
(22, 4, '何尧123', 'RE:我是瓜娃子何尧', '[img]qpic/1/2.gif[/img]', 0, 0, 0, '2017-05-14 16:40:50', '0000-00-00 00:00:00'),
(23, 3, '何尧123', 'RE:我要发帖子了', '欢迎大家来一起评论哦。。。。。', 0, 0, 0, '2017-05-14 19:25:17', '0000-00-00 00:00:00'),
(24, 2, '何尧123', 'RE:我是瓜娃子何尧', '我是一个笨蛋,我是一个小笨蛋,啦啦啦', 0, 0, 0, '2017-05-14 19:26:03', '0000-00-00 00:00:00'),
(25, 4, '何磊1', '回复2楼的何尧123', 'fgsdsdfsrqwffasqrsd', 0, 0, 0, '2017-05-15 13:14:26', '0000-00-00 00:00:00'),
(26, 3, '何磊1', 'RE:我要发帖子了', 'htdtdhttdtdud', 0, 0, 0, '2017-05-16 13:26:47', '0000-00-00 00:00:00'),
(27, 3, '何磊1', '回复:3楼的何磊1', 'dfsdfsdfasa', 0, 0, 0, '2017-05-16 13:28:55', '0000-00-00 00:00:00'),
(28, 4, '何尧123', 'RE:我是瓜娃子何尧asdas', 'erwfsdfweeeasdas', 0, 0, 0, '2017-05-16 13:38:17', '0000-00-00 00:00:00'),
(29, 3, '何尧123', 'RE:我要发帖子了', '123123123123', 0, 0, 0, '2017-05-16 13:43:09', '0000-00-00 00:00:00'),
(30, 2, '123456', 'RE:我是瓜娃子何尧', '34wdqweqwe[img]qpic/1/2.gif[/img]', 0, 0, 0, '2017-05-16 13:54:31', '0000-00-00 00:00:00'),
(31, 2, '123456', 'RE:我是瓜娃子何尧', 'qweqweqw', 0, 0, 0, '2017-05-16 13:56:37', '0000-00-00 00:00:00'),
(32, 5, '1234567', 'RE:瓜娃子何尧asdasdas', '34sdsaffasda', 0, 0, 0, '2017-05-16 14:09:07', '0000-00-00 00:00:00'),
(33, 2, '娜美', 'RE:我是瓜娃子何尧', 'werwerwerw', 0, 0, 0, '2017-05-16 14:25:59', '0000-00-00 00:00:00'),
(34, 2, '1234563', 'RE:我是瓜娃子何尧', 'sdfdfdsfa', 0, 0, 0, '2017-05-16 14:37:27', '0000-00-00 00:00:00'),
(35, 3, '娜美', 'RE:我要发帖子了', '64165465456', 0, 0, 0, '2017-05-16 14:49:19', '0000-00-00 00:00:00'),
(36, 2, '娜美', 'RE:我是瓜娃子何尧', '243546546', 0, 0, 0, '2017-05-16 14:54:03', '0000-00-00 00:00:00'),
(37, 2, '娜美', 'RE:我是瓜娃子何尧', '2416546132465', 0, 0, 0, '2017-05-16 14:55:40', '0000-00-00 00:00:00'),
(47, 45, '彭宇123', 'RE:瓜娃子何尧', 'sdfsdfsd', 0, 0, 0, '2017-05-17 18:07:13', '0000-00-00 00:00:00'),
(48, 46, '胡林', 'RE:瓜娃子何尧', '524654654654', 0, 0, 0, '2017-05-18 12:34:51', '0000-00-00 00:00:00'),
(49, 0, '冯焕新', '瓜娃子何尧', '      [img]qpic/1/4.gif[/img][img]qpic/1/3.gif[/img][img]qpic/1/6.gif[/img]  sdfasfaezxcaras    ', 17, 2, 0, '2017-05-19 19:05:23', '2017-05-19 19:06:15'),
(50, 49, '冯焕新', 'RE:瓜娃子何尧', 'wetwegdsgweetdsfst[img]qpic/1/3.gif[/img]', 0, 0, 0, '2017-05-19 19:05:44', '0000-00-00 00:00:00'),
(51, 49, '冯焕新', 'RE:瓜娃子何尧', 'werfwevsdfwefsafqqr', 0, 0, 0, '2017-05-19 19:07:04', '0000-00-00 00:00:00'),
(53, 52, '胡林', 'RE:国产115', '士大夫士大夫[img]qpic/1/2.gif[/img]', 0, 0, 0, '2017-05-19 20:21:53', '0000-00-00 00:00:00'),
(54, 0, '胡林', '国产115', 'afasfasf', 4, 0, 0, '2017-05-20 12:34:58', '0000-00-00 00:00:00'),
(55, 0, '胡林', '恭喜师姐回来', '何尧最开心,啦啦啦[img]qpic/1/5.gif[/img]', 7, 0, 0, '2017-05-20 14:24:06', '0000-00-00 00:00:00'),
(56, 0, '胡林', '技能大赛', '[img]qpic/1/1.gif[/img]\r\n\r\n\r\n[b]希望能够 完美的结束[/b][s][/s][u][/u]', 101, 2, 0, '2017-05-25 20:18:53', '0000-00-00 00:00:00'),
(57, 56, '疾风剑豪', 'RE:技能大赛', '我也希望 能够 完美的结束[img]qpic/1/12.gif[/img]', 0, 0, 0, '2017-05-25 20:21:03', '0000-00-00 00:00:00'),
(58, 56, '何磊', '回复:2楼的疾风剑豪', '我也是  希望這样', 0, 0, 0, '2017-05-25 20:22:54', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- 表的结构 `tg_dir`
--

CREATE TABLE `tg_dir` (
  `tg_id` mediumint(8) UNSIGNED NOT NULL COMMENT '//ID',
  `tg_name` varchar(20) NOT NULL COMMENT '//相册的名称',
  `tg_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '//相册的类型',
  `tg_password` char(40) DEFAULT NULL COMMENT '//相册的加密',
  `tg_content` varchar(200) DEFAULT NULL COMMENT '//相册的描述',
  `tg_face` varchar(200) DEFAULT NULL COMMENT '//封面的地址',
  `tg_dir` varchar(200) NOT NULL COMMENT '//相册的物理地址',
  `tg_date` datetime NOT NULL COMMENT '//相册的时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `tg_dir`
--

INSERT INTO `tg_dir` (`tg_id`, `tg_name`, `tg_type`, `tg_password`, `tg_content`, `tg_face`, `tg_dir`, `tg_date`) VALUES
(5, '动漫2', 1, '7c4a8d09ca3762af61e59520943dc26494f8941b', '                ', 'monipic/dongman1.jpg', 'photo/1495507397', '2017-05-23 10:43:17');

-- --------------------------------------------------------

--
-- 表的结构 `tg_flower`
--

CREATE TABLE `tg_flower` (
  `tg_id` mediumint(8) UNSIGNED NOT NULL COMMENT '//id',
  `tg_touser` varchar(20) NOT NULL COMMENT '//送花者',
  `tg_fromuser` varchar(20) NOT NULL COMMENT '//收花人',
  `tg_flower` mediumint(8) UNSIGNED NOT NULL COMMENT '//送花的个数',
  `tg_content` text NOT NULL COMMENT '//送花的内容',
  `tg_date` datetime NOT NULL COMMENT '//送花的时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `tg_flower`
--

INSERT INTO `tg_flower` (`tg_id`, `tg_touser`, `tg_fromuser`, `tg_flower`, `tg_content`, `tg_date`) VALUES
(1, 'heleilei', 'zyq520', 88, '', '2017-05-05 14:51:14'),
(2, 'pengyu', 'zyq520', 99, '我非常的喜欢你,给你送花啦~~~', '2017-05-05 14:52:40'),
(3, 'zyq520', 'heleilei', 88, '我非常的喜欢你,给你送花啦~~~', '2017-05-05 15:14:19'),
(5, 'heleilei', 'heleilei', 12, '我非常的喜欢你,给你送花啦~~~', '2017-05-05 15:26:45'),
(6, 'pengyu', 'heleilei', 12, '我非常的喜欢你,给你送花啦~~~', '2017-05-05 15:27:02'),
(7, 'zyq520', 'heleilei', 12, '我非常的喜欢你,给你送花啦~~~', '2017-05-05 15:27:18'),
(8, 'zyq520', '何尧123', 88, '非常喜欢你,给你送花啦~~', '2017-05-08 21:35:28'),
(9, '李青1', '李青', 30, '非常喜欢你,给你送花啦~~', '2017-05-11 16:12:43'),
(10, '李青1', 'zyq520', 17, '非常喜欢你,给你送花啦~~', '2017-05-11 16:15:47'),
(11, '何尧1', '冯焕新', 88, '非常喜欢你,给你送花啦~~', '2017-05-19 19:04:29'),
(12, '冯焕新', '李青', 88, '非常喜欢你,给你送花啦~~', '2017-05-19 20:19:13'),
(13, '娜美', '胡林', 1, '非常喜欢你,给你送花啦~~', '2017-05-22 20:52:33'),
(14, '李青', '疾风剑豪', 99, '非常喜欢你,给你送花啦~~', '2017-05-25 20:14:38');

-- --------------------------------------------------------

--
-- 表的结构 `tg_friend`
--

CREATE TABLE `tg_friend` (
  `tg_id` mediumint(8) UNSIGNED NOT NULL COMMENT '//ID',
  `tg_touser` varchar(20) NOT NULL COMMENT '//被添加的好友',
  `tg_fromuser` varchar(20) NOT NULL COMMENT '//添加的人',
  `tg_content` varchar(200) NOT NULL COMMENT '//验证的内容',
  `tg_state` tinyint(1) NOT NULL COMMENT '//是否添加成功',
  `tg_date` datetime NOT NULL COMMENT '//添加的时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `tg_friend`
--

INSERT INTO `tg_friend` (`tg_id`, `tg_touser`, `tg_fromuser`, `tg_content`, `tg_state`, `tg_date`) VALUES
(4, 'zyq520', 'pengyu', '我非常想和你交朋友!', 1, '2017-05-01 21:34:56'),
(5, '何尧1', 'zyq520', '我非常想和你交朋友!', 0, '2017-05-02 21:44:05'),
(6, '小女朋友', '何尧123', '我非常想和你交朋友!', 0, '2017-05-08 21:34:28'),
(7, 'zyq520', '何尧123', '我非常想和你交朋友!', 1, '2017-05-08 21:34:51'),
(8, '李青1', '李青', '我非常想和你交朋友!', 1, '2017-05-11 16:12:25'),
(9, '李青1', 'zyq520', '我非常想和你交朋友!', 1, '2017-05-11 16:15:58'),
(10, '彭宇123', '冯焕新', '我非常想和你交朋友!', 0, '2017-05-19 19:03:49'),
(11, '胡林', '李青', '我非常想和你交朋友!', 1, '2017-05-19 20:16:41'),
(12, '胡林', '疾风剑豪', '我非常想和你交朋友!', 1, '2017-05-25 20:14:02');

-- --------------------------------------------------------

--
-- 表的结构 `tg_message`
--

CREATE TABLE `tg_message` (
  `tg_id` mediumint(8) UNSIGNED NOT NULL COMMENT '//id',
  `tg_touser` varchar(20) NOT NULL COMMENT '//收件人',
  `tg_fromuser` varchar(20) NOT NULL COMMENT '//发件人',
  `tg_content` varchar(200) NOT NULL COMMENT '//发送内容',
  `tg_state` tinyint(1) NOT NULL DEFAULT '0' COMMENT '//短信状态',
  `tg_date` datetime NOT NULL COMMENT '//发送时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `tg_message`
--

INSERT INTO `tg_message` (`tg_id`, `tg_touser`, `tg_fromuser`, `tg_content`, `tg_state`, `tg_date`) VALUES
(6, '123456', 'lsy123', '链接；就；看', 1, '2017-04-23 22:55:36'),
(8, 'helei123', 'heleilei', '1545646544654', 1, '2017-05-01 14:34:03'),
(9, '何尧1', 'zyq520', '何尧,我知道你是猪,我想跟你做朋友', 1, '2017-05-01 15:30:26'),
(10, 'zyq520', 'heleilei', '我非常的喜欢你哦', 1, '2017-05-05 15:13:46');

-- --------------------------------------------------------

--
-- 表的结构 `tg_photo`
--

CREATE TABLE `tg_photo` (
  `tg_id` mediumint(8) UNSIGNED NOT NULL COMMENT '//ID',
  `tg_name` varchar(20) NOT NULL COMMENT '//相册的名称',
  `tg_url` varchar(200) NOT NULL COMMENT '//图片的地址',
  `tg_content` varchar(200) NOT NULL COMMENT '//图片的内容',
  `tg_sid` mediumint(8) UNSIGNED NOT NULL COMMENT '//图片所在的id',
  `tg_username` varchar(20) NOT NULL COMMENT '//上传者的名字',
  `tg_readcount` smallint(5) UNSIGNED NOT NULL DEFAULT '0' COMMENT '//浏览量',
  `tg_commendcount` smallint(5) UNSIGNED NOT NULL DEFAULT '0' COMMENT '//评论量',
  `tg_date` datetime NOT NULL COMMENT '//图片的时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `tg_photo`
--

INSERT INTO `tg_photo` (`tg_id`, `tg_name`, `tg_url`, `tg_content`, `tg_sid`, `tg_username`, `tg_readcount`, `tg_commendcount`, `tg_date`) VALUES
(1, 'trhrt', 'photo/1495507397/1495511103.jpg', 'rtyrty', 5, '炎日', 18, 0, '2017-05-23 11:45:06'),
(5, '123456', 'photo/1495507397/1495539249.jpg', 'werwer', 5, '胡林', 149, 1, '2017-05-23 19:34:15');

-- --------------------------------------------------------

--
-- 表的结构 `tg_photo_commend`
--

CREATE TABLE `tg_photo_commend` (
  `tg_id` mediumint(8) UNSIGNED NOT NULL COMMENT '//ID',
  `tg_title` varchar(20) NOT NULL COMMENT '//标题量',
  `tg_content` text NOT NULL COMMENT '//图片的内容',
  `tg_sid` mediumint(8) NOT NULL COMMENT '//图片的id',
  `tg_username` varchar(20) NOT NULL COMMENT '//图片的名称',
  `tg_date` datetime NOT NULL COMMENT '//图片的时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `tg_photo_commend`
--

INSERT INTO `tg_photo_commend` (`tg_id`, `tg_title`, `tg_content`, `tg_sid`, `tg_username`, `tg_date`) VALUES
(710, 'RE:123456', 'sdfsdfasfas[img]qpic/1/2.gif[/img]', 5, '胡林', '2017-05-24 18:43:19'),
(711, 'RE:24654', 'asdasdasdasdasd', 8, '胡林', '2017-05-24 20:05:59');

-- --------------------------------------------------------

--
-- 表的结构 `tg_system`
--

CREATE TABLE `tg_system` (
  `tg_id` mediumint(8) UNSIGNED NOT NULL COMMENT '//ID',
  `tg_webname` varchar(20) NOT NULL COMMENT '//web的名称',
  `tg_article` tinyint(2) UNSIGNED NOT NULL DEFAULT '0' COMMENT '//文章的显示条数',
  `tg_blog` tinyint(2) UNSIGNED NOT NULL DEFAULT '0' COMMENT '/博客的显示条数',
  `tg_photo` tinyint(2) UNSIGNED NOT NULL DEFAULT '0' COMMENT '//相册的显示条数',
  `tg_skin` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '//网站皮肤',
  `tg_string` varchar(200) NOT NULL COMMENT '//网站铭感字符',
  `tg_post` tinyint(3) UNSIGNED NOT NULL DEFAULT '3' COMMENT '//发帖限制',
  `tg_re` tinyint(3) UNSIGNED NOT NULL DEFAULT '3' COMMENT '//回帖限制',
  `tg_code` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '//是否启用验证码',
  `tg_register` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '//是否开放会员'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `tg_system`
--

INSERT INTO `tg_system` (`tg_id`, `tg_webname`, `tg_article`, `tg_blog`, `tg_photo`, `tg_skin`, `tg_string`, `tg_post`, `tg_re`, `tg_code`, `tg_register`) VALUES
(1, '国产115', 8, 15, 12, 3, '他妈的 | SB | 操', 60, 15, 1, 1);

-- --------------------------------------------------------

--
-- 表的结构 `tg_user`
--

CREATE TABLE `tg_user` (
  `tg_id` mediumint(8) UNSIGNED NOT NULL COMMENT '//用户的自动编号',
  `tg_uniqid` char(40) NOT NULL COMMENT '//用户的唯一标识符',
  `tg_active` char(40) NOT NULL COMMENT '//激活登录的',
  `tg_username` varchar(14) CHARACTER SET utf8 NOT NULL COMMENT '//用户',
  `tg_password` char(40) NOT NULL COMMENT '//密码',
  `tg_question` varchar(20) CHARACTER SET utf8 NOT NULL COMMENT '//提问',
  `tg_answer` char(40) NOT NULL COMMENT '//回答',
  `tg_email` varchar(40) DEFAULT NULL COMMENT '//email',
  `tg_qq` varchar(10) DEFAULT NULL COMMENT '//qq',
  `tg_url` varchar(40) DEFAULT NULL COMMENT '//url',
  `tg_sex` char(1) CHARACTER SET utf8 NOT NULL COMMENT '//性别',
  `tg_face` char(16) CHARACTER SET utf8 NOT NULL COMMENT '//头像',
  `tg_switch` tinyint(1) NOT NULL DEFAULT '0' COMMENT '//个性签名的开关',
  `tg_autograph` varchar(200) DEFAULT NULL COMMENT '//个性签名的内容',
  `tg_level` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '//会员等级',
  `tg_post_time` varchar(20) NOT NULL DEFAULT '0' COMMENT '//发帖子的时间戳',
  `tg_article_time` varchar(20) NOT NULL DEFAULT '0' COMMENT '//回帖的时间戳',
  `tg_reg_time` datetime NOT NULL COMMENT '//最后注册的时间',
  `tg_login_time` datetime DEFAULT NULL COMMENT '//最后登录的时间',
  `tg_reg_ip` char(20) CHARACTER SET utf8 NOT NULL COMMENT '//最后登录的IP',
  `tg_login_count` smallint(4) UNSIGNED NOT NULL DEFAULT '0' COMMENT '//登录次数'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `tg_user`
--

INSERT INTO `tg_user` (`tg_id`, `tg_uniqid`, `tg_active`, `tg_username`, `tg_password`, `tg_question`, `tg_answer`, `tg_email`, `tg_qq`, `tg_url`, `tg_sex`, `tg_face`, `tg_switch`, `tg_autograph`, `tg_level`, `tg_post_time`, `tg_article_time`, `tg_reg_time`, `tg_login_time`, `tg_reg_ip`, `tg_login_count`) VALUES
(8, 'dc9e73fd88ff65a5b9259cf7c6a23f5596d8289b', '', '娜美', '123456', '你最喜欢什么', 'ce344b311dc643a5cdfd75175cbab0bcc54bb037', '5201314@qq.com', '1395747849', 'http://15yc.com', '男', 'face/m19.jpg', 0, '', 0, '0', '0', '2017-05-16 14:48:19', '2017-04-15 12:37:57', '::1', 6),
(10, '7f28251c52dcce90a0703f363ae7f41f42497d73', '', '红狼', '7c4a8d09ca3762af61e59520943dc26494f8941b', '你最喜欢什么', '40f5a38b23dbce89b0067bc85deee24e0d58cfd6', '5201314@qq.com', '', '', '男', 'face/m31.jpg', 0, NULL, 0, '0', '0', '2017-04-15 12:39:36', '2017-04-15 12:39:36', '::1', 0),
(22, 'edd37da26239ed8050443e2cd6dfabe3bdbe0917', '', 'heleilei', '7c4a8d09ca3762af61e59520943dc26494f8941b', '123123', '9ec470553891c49a8e89c8a5f10f0d56a72ab5ec', '1395747849@qq.com', '1395747849', 'http://15yc.com', '男', 'face/m30.jpg', 0, NULL, 0, '0', '0', '2017-05-10 13:09:36', '2017-04-25 19:38:45', '::1', 4),
(32, '83e0393d04a1900223cf8b47b38c05ae4275330a', '', '1234563', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', '彭宇最喜欢吃什么', '7ad9fb6f774fafe6ca416c54ce449a7bb83f4476', '1395747849@qq.cm', '1395747849', 'http://15yc.com', '男', 'face/m17.jpg', 0, NULL, 0, '0', '0', '2017-05-16 14:37:06', '2017-05-16 14:36:48', '::1', 1),
(35, '4b8add2fe5a043320900cbafaa5fee758e701a90', '', '李青', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我喜欢的一句话', '7ad9fb6f774fafe6ca416c54ce449a7bb83f4476', '1395747849@qq.com', '1395747849', 'http://www.baidu.com', '男', 'face/m07.jpg', 0, NULL, 0, '0', '0', '2017-05-25 18:21:52', '2017-05-19 20:13:56', '::1', 3),
(37, '2094472b93b148a3272941c2b91d1b1d011a9da3', '', '胡林', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我最喜欢的东西', 'a1a427713653c4e00ad25650b2e7964608c9e2d0', '1395747849@qq.com', '1395747849', 'http://www.baidu.com', '男', 'face/m18.jpg', 0, NULL, 1, '1495714733', '0', '2017-06-02 16:48:59', '2017-05-21 13:06:07', '::1', 20),
(38, '68f58a8024a9992e3fec47bb74dd040a824efb90', '', 'admin', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我喜欢的一句话', 'a1a427713653c4e00ad25650b2e7964608c9e2d0', '1395747849@qq.com', '1395747849', 'http://www.baidu.com', '男', 'face/m27.jpg', 0, NULL, 0, '0', '0', '2017-05-21 20:45:41', '2017-05-21 20:45:29', '::1', 1),
(39, '4733b300a368b7daa96e04c22f54cc8d685d891a', '', '何磊', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我喜欢的一句话', 'a1a427713653c4e00ad25650b2e7964608c9e2d0', '5101314@qq.com', '5201314', 'http://www.baidu.com', '男', 'face/m03.jpg', 0, NULL, 0, '0', '1495714974', '2017-05-25 20:21:57', '2017-05-25 18:16:13', '::1', 1),
(40, '4597b4119845b077956b59810137148035dea268', '', '彭宇', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我喜欢的一句话', 'a1a427713653c4e00ad25650b2e7964608c9e2d0', '1395747849@qq.com', '5201314', 'http://www.baidu.com', '男', 'face/m06.jpg', 0, NULL, 1, '0', '0', '2017-05-25 18:17:05', '2017-05-25 18:17:05', '::1', 0),
(41, '007622261fbf5e06a243df275fa2d752775090a9', '', '刘松源', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我最喜欢的东西', '7ad9fb6f774fafe6ca416c54ce449a7bb83f4476', '1395747849@qq.com', '5201314', 'http://www.baidu.com', '男', 'face/m11.jpg', 0, NULL, 1, '0', '0', '2017-05-25 18:18:11', '2017-05-25 18:18:11', '::1', 0),
(42, '58175b6dc6ba2a7e93ae808dcdc921220e3ce2d6', '', '王栋钢', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我最喜欢的东西', '7ad9fb6f774fafe6ca416c54ce449a7bb83f4476', '1395747849@qq.com', '1395747849', 'http://www.baidu.com', '男', 'face/m15.jpg', 0, NULL, 1, '0', '0', '2017-05-25 18:19:02', '2017-05-25 18:19:02', '::1', 0),
(43, '13538e9c94be6fddea826eb3cb29abbdbcd39a4e', '', '何尧', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我最喜欢的东西', '7ad9fb6f774fafe6ca416c54ce449a7bb83f4476', '1395747849@qq.com', '5201314', 'http://www.baidu.com', '男', 'face/m01.jpg', 0, NULL, 1, '0', '0', '2017-05-25 18:19:40', '2017-05-25 18:19:40', '::1', 0),
(44, '844d24fa2b7f889c407fa219ed18c0a1b7ce88ce', '', '疾风剑豪', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我喜欢什么', '871c4dad76bbcdea4971006377f5a87e91a75a36', '1395747849@qq.com', '1395747849', 'http://www.baidu.com', '男', 'face/m38.jpg', 0, NULL, 0, '0', '1495714863', '2017-05-25 20:20:17', '2017-05-25 20:10:02', '::1', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tg_arcticle`
--
ALTER TABLE `tg_arcticle`
  ADD PRIMARY KEY (`tg_id`);

--
-- Indexes for table `tg_dir`
--
ALTER TABLE `tg_dir`
  ADD PRIMARY KEY (`tg_id`);

--
-- Indexes for table `tg_flower`
--
ALTER TABLE `tg_flower`
  ADD PRIMARY KEY (`tg_id`);

--
-- Indexes for table `tg_friend`
--
ALTER TABLE `tg_friend`
  ADD PRIMARY KEY (`tg_id`);

--
-- Indexes for table `tg_message`
--
ALTER TABLE `tg_message`
  ADD PRIMARY KEY (`tg_id`);

--
-- Indexes for table `tg_photo`
--
ALTER TABLE `tg_photo`
  ADD PRIMARY KEY (`tg_id`);

--
-- Indexes for table `tg_photo_commend`
--
ALTER TABLE `tg_photo_commend`
  ADD PRIMARY KEY (`tg_id`);

--
-- Indexes for table `tg_system`
--
ALTER TABLE `tg_system`
  ADD PRIMARY KEY (`tg_id`);

--
-- Indexes for table `tg_user`
--
ALTER TABLE `tg_user`
  ADD PRIMARY KEY (`tg_id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `tg_arcticle`
--
ALTER TABLE `tg_arcticle`
  MODIFY `tg_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '//id', AUTO_INCREMENT=59;
--
-- 使用表AUTO_INCREMENT `tg_dir`
--
ALTER TABLE `tg_dir`
  MODIFY `tg_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '//ID', AUTO_INCREMENT=6;
--
-- 使用表AUTO_INCREMENT `tg_flower`
--
ALTER TABLE `tg_flower`
  MODIFY `tg_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '//id', AUTO_INCREMENT=15;
--
-- 使用表AUTO_INCREMENT `tg_friend`
--
ALTER TABLE `tg_friend`
  MODIFY `tg_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '//ID', AUTO_INCREMENT=13;
--
-- 使用表AUTO_INCREMENT `tg_message`
--
ALTER TABLE `tg_message`
  MODIFY `tg_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '//id', AUTO_INCREMENT=11;
--
-- 使用表AUTO_INCREMENT `tg_photo`
--
ALTER TABLE `tg_photo`
  MODIFY `tg_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '//ID', AUTO_INCREMENT=6;
--
-- 使用表AUTO_INCREMENT `tg_photo_commend`
--
ALTER TABLE `tg_photo_commend`
  MODIFY `tg_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '//ID', AUTO_INCREMENT=712;
--
-- 使用表AUTO_INCREMENT `tg_system`
--
ALTER TABLE `tg_system`
  MODIFY `tg_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '//ID', AUTO_INCREMENT=2;
--
-- 使用表AUTO_INCREMENT `tg_user`
--
ALTER TABLE `tg_user`
  MODIFY `tg_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '//用户的自动编号', AUTO_INCREMENT=45;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
