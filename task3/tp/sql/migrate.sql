CREATE database `test`;

USE `test`;

DROP TABLE IF EXISTS `exchange_loneliness`;
CREATE TABLE `exchange_loneliness`(
    `id` INT UNSIGNED AUTO_INCREMENT COMMENT '用户id',
    `img` VARCHAR(100) NOT NULL COMMENT '图片',
    `alt` VARCHAR(100) NOT NULL COMMENT '别名',
    PRIMARY KEY (`id`)
) ENGINE=Innodb DEFAULT CHARSET=utf8;        


DROP TABLE IF EXISTS `regeneration`;
CREATE TABLE `regeneration`(
    `id` INT UNSIGNED AUTO_INCREMENT COMMENT '用户id',
    `img` VARCHAR(100) NOT NULL COMMENT '图片',
    `alt` VARCHAR(100) NOT NULL COMMENT '别名',
    PRIMARY KEY (`id`)
) ENGINE=Innodb DEFAULT CHARSET=utf8;      


DROP TABLE IF EXISTS `petri_dish`;
CREATE TABLE `petri_dish`(
    `id` INT UNSIGNED AUTO_INCREMENT COMMENT '用户id',
    `img` VARCHAR(100) NOT NULL COMMENT '图片',
    `alt` VARCHAR(100) NOT NULL COMMENT '别名',
    PRIMARY KEY (`id`)
) ENGINE=Innodb DEFAULT CHARSET=utf8;      



DROP TABLE IF EXISTS `miscellanea`;
CREATE TABLE `miscellanea`(
    `id` INT UNSIGNED AUTO_INCREMENT COMMENT '用户id',
    `img` VARCHAR(100) NOT NULL COMMENT '图片',
    `alt` VARCHAR(100) NOT NULL COMMENT '别名',
    PRIMARY KEY (`id`)
) ENGINE=Innodb DEFAULT CHARSET=utf8;      




DROP TABLE IF EXISTS `mould`;
CREATE TABLE `mould`(
    `id` INT UNSIGNED AUTO_INCREMENT COMMENT '用户id',
    `img` VARCHAR(100) NOT NULL COMMENT '图片',
    `alt` VARCHAR(100) NOT NULL COMMENT '别名',
    PRIMARY KEY (`id`)
) ENGINE=Innodb DEFAULT CHARSET=utf8;      