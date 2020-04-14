-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1
-- 生成日期： 2020-04-14 16:31:51
-- 服务器版本： 10.1.38-MariaDB
-- PHP 版本： 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `s1624230229`
--
CREATE DATABASE IF NOT EXISTS `s1624230229` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `s1624230229`;

-- --------------------------------------------------------

--
-- 表的结构 `liked`
--

CREATE TABLE `liked` (
  `id` int(11) NOT NULL COMMENT '用户id',
  `uid` int(11) NOT NULL COMMENT '用户的ID',
  `mid` varchar(50) NOT NULL COMMENT '音乐的MID',
  `status` tinyint(2) NOT NULL DEFAULT '2' COMMENT '状态',
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '登入时间',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `liked`
--

INSERT INTO `liked` (`id`, `uid`, `mid`, `status`, `update_time`, `create_time`) VALUES
(1, 1, '000I9Epx0vKv7k', 1, 1586513139, 0),
(2, 1, '004S8i2e3TzJwd', 2, 1586513140, 1586511752),
(3, 1, '004RWscu2llK38', 2, 1586513140, 1586512053),
(4, 1, '002E5Hg04IUQbb', 1, 1586868736, 1586868736),
(5, 1, '002R4lUQ2a4f2D', 1, 1586869349, 1586869349),
(6, 1, '004YSTKP2o2yyx', 1, 1586869931, 1586869931);

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL COMMENT '用户id',
  `email` varchar(50) NOT NULL COMMENT '邮箱',
  `password` varchar(50) NOT NULL COMMENT '用户密码',
  `status` tinyint(2) NOT NULL DEFAULT '2' COMMENT '状态',
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '登入时间',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `status`, `update_time`, `create_time`) VALUES
(1, '397317382@qq.com', 'e10adc3949ba59abbe56e057f20f883e', 1, 0, 0),
(2, '39731738@qq.com', 'e10adc3949ba59abbe56e057f20f883e', 1, 0, 0),
(3, '3973173@qq.com', 'e10adc3949ba59abbe56e057f20f883e', 1, 0, 0),
(4, '397313@qq.com', 'e10adc3949ba59abbe56e057f20f883e', 1, 0, 0),
(5, '39732@qq.com', 'e10adc3949ba59abbe56e057f20f883e', 1, 0, 0);

--
-- 转储表的索引
--

--
-- 表的索引 `liked`
--
ALTER TABLE `liked`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `liked`
--
ALTER TABLE `liked`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户id', AUTO_INCREMENT=7;

--
-- 使用表AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户id', AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
