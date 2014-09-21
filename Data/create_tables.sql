-- 表前缀 mz_

-- create database `mz`;
DROP DATABASE IF EXISTS `mz`;
create database `mz` CHARACTER SET = utf8;

-- 自主参训补贴项目及补贴标准目录
DROP TABLE IF EXISTS `mz_subsidy_standary`;
create table `mz_subsidy_standary` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `certificate_type` varchar(32) NOT NULL,
    `kind` varchar(32) DEFAULT '',
    `level` varchar(32) DEFAULT '',
    `money` int(11) NOT NULL DEFAULT '0',
    `series` varchar(32) DEFAULT '',
    `title` varchar(32) NOT NULL,
    PRIMARY KEY (`id`)
);