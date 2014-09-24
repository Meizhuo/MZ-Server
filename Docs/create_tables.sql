-- 表前缀 mz_

-- create database `mz`;
DROP DATABASE IF EXISTS `mz`;
create database `mz` CHARACTER SET = utf8;

-- 自主参训补贴项目及补贴标准目录
DROP TABLE IF EXISTS `mz_subsidy_standary`;
create table `mz_subsidy_standary` (
    `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
    `certificate_type` varchar(32) NOT NULL COMMENT '证书类别',
    `kind` varchar(32) DEFAULT '' COMMENT '项目类别',
    `level` varchar(32) DEFAULT '' COMMENT '等级(级别)',
    `money` int(11) NOT NULL DEFAULT '0' COMMENT '补贴金额',
    `series` varchar(32) DEFAULT '' COMMENT '系列',
    `title` varchar(32) NOT NULL COMMENT '资格名称',
    PRIMARY KEY (`id`)
);

-- 用户表
--    `birthday` int(11) DEFAULT '0' COMMENT '生日',
DROP TABLE IF EXISTS `mz_user`;
create table `mz_user`(
    `uid` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户ID',
    `nickname`  varchar(32) NOT NULL COMMENT '用户昵称',
    `sex` varchar(8) NOT NULL DEFAULT '男' COMMENT '性别',
    `work_place` varchar(256) DEFAULT '' COMMENT '工作单位',
    `phone` varchar(32) COMMENT '手机号码',
    `email` varchar(32) COMMENT '电子邮箱',
    `reg_time` int(11) NOT NULL COMMENT '注册时间',
    `psw` varchar(128) NOT NULL COMMENT '密码(8-16位)',
    `level` int(3) NOT NULL COMMENT '权限等级(2个人用户 4用人单位 8培训机构16管理员 32超级管理员 )',
    `status` int(2) NOT NULL  COMMENT '审核状态(-1审核不通过 0 未审核1审核通过)',
    PRIMARY KEY (`uid`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户表' AUTO_INCREMENT=1 ;

-- 文档(新闻、文章)
DROP TABLE IF EXISTS `mz_document`;
create table `mz_document`(
    `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '文档id',
    `uid` int(11) NOT NULL COMMENT '作者ID',
    `title` varchar(64) COMMENT '标题',
    `category_id` int(3) NOT NULL COMMENT '所属分类',
    `display` int(1) NOT NULL  COMMENT '可见性(-1未审核 0 不可见 1可见)',
    `views` int(11) NOT NULL DEFAULT '0' COMMENT '浏览量',
    `commoents` int(11) NOT NULL DEFAULT '0' COMMENT '评论数',
    `create_time`  int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
    `update_time`  int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
    `from` varchar(256) COMMENT '新闻来源',
    `level` int(3) NOT NULL NOT NULL DEFAULT '0' COMMENT '文章等级(0 全部可见 2 只有个人用户可见 4 只有用人单位可见  8只有培训机构可见16 只有管理员可见 32只有超级管理员可见)',
     PRIMARY KEY (`id`) 
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文档' AUTO_INCREMENT=1 ;

-- 新闻详情
DROP TABLE IF EXISTS `mz_document_detail`;
create table `mz_document_detail`(
    `id` int(11) NOT NULL DEFAULT '0' COMMENT '文档ID',
    `content` text NOT NULL DEFAULT '' COMMENT '内容',
    `files` text COMMENT '附件下载地址'
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文档类型' ;

-- 文档类型
DROP TABLE IF EXISTS `mz_document_type`;
create table `mz_document_type` (
    `category_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '分类id',
    `name` varchar(128) NOT NULL DEFAULT '' COMMENT '种类名称' ,
    `description` text  COMMENT '描述',
    PRIMARY KEY (`category_id`) 
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文档类型' AUTO_INCREMENT=1 ;

-- 应用信息 
DROP TABLE IF EXISTS `mz_appinfo`;
create table `mz_appinfo` (
    `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '记录id',
    `version_name` varchar(32) NOT NULL DEFAULT '1.0.0' COMMENT '版本代号',
    `version_code`  int(10) NOT NULL DEFAULT '1'  COMMENT '版本号',
    `description` text  COMMENT '版本描述',
     PRIMARY KEY (`id`) 
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='应用信息' AUTO_INCREMENT=1 ;


-- 表的结构 `mz_institution`

CREATE TABLE IF NOT EXISTS `mz_institution` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '机构id ',
  `name` varchar(128) NOT NULL COMMENT '机构名称',
  `address` varchar(256) NOT NULL COMMENT '机构地址',
  `manager` varchar(32) NOT NULL COMMENT '机构负责人',
  `type` varchar(32) NOT NULL COMMENT '办学类型',
  `approval_number` varchar(256) NOT NULL COMMENT '批准文号',
  `validity_date` int(11) NOT NULL COMMENT '有效期',
  `training_scope` varchar(512) NOT NULL COMMENT '培训范围',
  `description` text NOT NULL COMMENT '描述',
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '审核状态(-1审核失败 0未审核 1已审核)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='培训机构' AUTO_INCREMENT=1 ;