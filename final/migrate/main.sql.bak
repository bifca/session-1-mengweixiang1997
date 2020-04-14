create DATABASE music;

use music;

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `email` varchar(50) NOT NULL COMMENT '邮箱',
  `password` varchar(50) NOT NULL COMMENT '用户密码',
  `status` tinyint(2) NOT NULL DEFAULT '2' COMMENT '状态',
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '登入时间',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',   
  PRIMARY KEY (`id`)
) ENGINE=Innodb DEFAULT CHARSET=utf8;
-- test
insert into user(`email`,`password`,`status`) value('397317382@qq.com','e10adc3949ba59abbe56e057f20f883e', 1);



DROP TABLE IF EXISTS `liked`;
CREATE TABLE `liked` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `uid` int(11) NOT NULL COMMENT '用户的ID',
  `mid` varchar(50) NOT NULL COMMENT '音乐的MID',
  `status` tinyint(2) NOT NULL DEFAULT '2' COMMENT '状态',
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '登入时间',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',   
  PRIMARY KEY (`id`)
) ENGINE=Innodb DEFAULT CHARSET=utf8;
-- test
insert into liked(`uid`,`mid`,`status`) value(1,'000I9Epx0vKv7k', 1);
