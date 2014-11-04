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
DROP TABLE IF EXISTS `mz_user`;
CREATE TABLE `mz_user` (
  `uid` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户id (主键)',
  `nickname` varchar(128) NOT NULL COMMENT ' 用户昵称',
  `phone` varchar(32) DEFAULT NULL COMMENT '手机号码(11位)',
  `email` varchar(32) DEFAULT NULL COMMENT '邮箱',
  `psw` varchar(64) NOT NULL COMMENT 'md5,8-16位数字or字母',
  `reg_time` int(11) NOT NULL COMMENT '注册时间',
  `level` int(1) NOT NULL DEFAULT '1' COMMENT '权限等级(1个人用户 2 用人单位 4 培训机构8管理员16超级管理员 )',
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '审核状态(-2冻结状态 -1审核不通过 0 未审核1审核通过 )',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `phone` (`phone`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户表' AUTO_INCREMENT=1 ;


-- 个人用户表
DROP TABLE IF EXISTS `mz_user_person`;
CREATE TABLE `mz_user_person` (
  `uid` int(11) NOT NULL COMMENT 'uid用户id',
  `sex` varchar(2) DEFAULT '男' COMMENT '性别(男或女)',
  `work_place` varchar(128) DEFAULT NULL COMMENT '工作地点',
   PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='个人用户表';


-- 用人单位
DROP TABLE IF EXISTS `mz_user_employer`;
CREATE TABLE  `mz_user_employer` (
  `uid` int(11) NOT NULL COMMENT '用户id',
  `contact_phone` varchar(32) DEFAULT NULL COMMENT '联系电话',
  `address` varchar(128) DEFAULT NULL COMMENT '用人单位地址',
   PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用人单位';


-- 管理员表
DROP TABLE IF EXISTS `mz_user_admin`;
CREATE TABLE `mz_user_admin` (
  `uid` int(11) NOT NULL COMMENT '用户id',
  `per_categorys_post` text COMMENT '有权限起草/编辑的栏目 (json)',
  `per_categorys_check` text COMMENT '有权限管理的群组(json)',
  `per_institution_check` text COMMENT '有权限审核培训机构(0无权限1有权限)',
  `per_person_man` int(1) DEFAULT '1' COMMENT '是否有权限管理普通用户(0无权限1有权限,默认1)',
  `per_employer_man` int(1) DEFAULT '1' COMMENT '是否有权限管理企业用户(0无权限1有权限,默认1)',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理员表';

-- alter table mz_user_admin add COLUMN per_person_man int(1) DEFAULT 1 COMMENT '是否有权限管理普通用户';
-- alter table mz_user_admin add COLUMN per_employer_man int(1) DEFAULT 1 COMMENT '是否有权限管理企业用户';


-- 培训机构用户表
DROP TABLE IF EXISTS `mz_user_institution`;
CREATE TABLE `mz_user_institution` (
  `uid` int(11) NOT NULL COMMENT '机构用户id',
  `name` varchar(128) DEFAULT NULL COMMENT '机构名称',
  `address` varchar(256) DEFAULT NULL COMMENT '机构地址',
  `manager` varchar(128) DEFAULT NULL COMMENT '机构负责人 ',
  `type` varchar(128) DEFAULT NULL COMMENT '办学类型',
  `approval_number` varchar(256) DEFAULT NULL COMMENT '批准文号',
  `validity_date` int(11) DEFAULT NULL COMMENT '有效期 ',
  `training_scope` text COMMENT '培训范围',
  `description` text COMMENT '描述',
  `teacher_resource` text COMMENT '师资力量',
  `contact_member` varchar(64) DEFAULT NULL COMMENT '联系人',
  `contact_phone` varchar(64) DEFAULT NULL COMMENT '联系电话',
  `contact_email` varchar(64) DEFAULT NULL COMMENT '联系邮箱',
  `vertify_uid` int(11) DEFAULT NULL COMMENT '审核人id',
  `vertify_time` int(11) DEFAULT NULL COMMENT '审核时间',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='培训机构用户表';


-- 培训课程表
DROP TABLE IF EXISTS `mz_course`;
CREATE TABLE `mz_course` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '课程id',
  `institution_id` int(11) NOT NULL COMMENT '所属的培训机构',
  `subsidy_id` int(11) DEFAULT NULL COMMENT '对应的补贴项目',
  `name` varchar(64) DEFAULT NULL COMMENT '课程名称',
  `start_time` varchar(32) DEFAULT NULL COMMENT '开课时间(格式为Y-m-d)',
  `address` varchar(256) DEFAULT NULL COMMENT '开课地址',
  `teacher` varchar(32) DEFAULT NULL COMMENT '授课老师',
  `introduction` text COMMENT '课程介绍',
  `cost` int(11) DEFAULT NULL COMMENT '课程费用',
  `display` int(1) DEFAULT '-1' COMMENT '是否显示课程(-1不显示,1显示)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='培训课程' AUTO_INCREMENT=1 ;




-- 文档(新闻、文章)
DROP TABLE IF EXISTS `mz_document`;
CREATE TABLE  `mz_document` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '文档id ',
  `uid` int(11) NOT NULL COMMENT '作者id',
  `title` varchar(256) NOT NULL COMMENT '标题 ',
  `category_id` int(11) NOT NULL COMMENT '所属分类(栏目)',
  `display` int(2) NOT NULL DEFAULT '1' COMMENT '可见性( 0 不可见1可见,默认1可见)',
  `status` int(2) NOT NULL DEFAULT '0' COMMENT '审核状态(-1审核不通过 0未审核 1审核通过)',
  `views` int(11) NOT NULL DEFAULT '0' COMMENT '浏览量(默认为0)',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `update_time` int(11) NOT NULL COMMENT '最后更新时间',
  `from` varchar(256) DEFAULT NULL COMMENT '新闻来源(可空',
  `level` int(2) NOT NULL COMMENT '文章等级(1 只有个人用户可见 2 只有用人单位可见  4只有培训机构可见8 只有管理员可见 16只有超级管理员可见 31全部可见,默认31',
  `description` text COMMENT '描述(可空',
  `order_num` int(1) NOT NULL DEFAULT '1' COMMENT '序号(优先级别,默认为1',
  `content` text NOT NULL COMMENT '新闻内容',
  `vertify_uid` int(11) DEFAULT NULL COMMENT '审核人id',
  `vertify_time` int(11) DEFAULT NULL COMMENT '审核时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='文档' AUTO_INCREMENT=1 ;

-- doc_id 默认为0
-- 文档附件
DROP TABLE IF EXISTS `mz_document_file`;
CREATE TABLE `mz_document_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '附件id',
  `doc_id` int(11) NOT NULL DEFAULT '0' COMMENT '对应的文档id',
  `ins_id` int(11) NOT NULL DEFAULT '0' COMMENT '对应的机构用户id',
  `raw_name` varchar(256) NOT NULL COMMENT '原始文件名',
  `save_name` varchar(256) NOT NULL COMMENT '保存的文件名',
  `save_path` varchar(512) NOT NULL COMMENT '文件保存路径',
  `ext` varchar(32) NOT NULL COMMENT '文件后缀',
  `mime` varchar(32) DEFAULT NULL COMMENT '文件mime类型',
  `size` int(11) DEFAULT NULL COMMENT '文件大小',
  `md5` varchar(64) DEFAULT NULL COMMENT '文件md5',
  `create_time` int(11) NOT NULL COMMENT '上传时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='文档附件' AUTO_INCREMENT=1 ;


-- 文档种类/栏目
DROP TABLE IF EXISTS `mz_document_category`;
CREATE TABLE `mz_document_category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '分类id',
  `category` varchar(32) NOT NULL DEFAULT '' COMMENT '种类名称',
  `name` varchar(32) NOT NULL COMMENT '子种类名称',
  `description` text COMMENT '描述',
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='文档种类/栏目' AUTO_INCREMENT=1 ;

-- 消息
DROP TABLE IF EXISTS `mz_message`;
CREATE TABLE `mz_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '消息id',
  `uid` int(11) NOT NULL COMMENT '发送人id',
  `title` varchar(64) NOT NULL COMMENT '标题',
  `content` text NOT NULL COMMENT '内容',
  `create_time` int(11) NOT NULL COMMENT '创建日期',
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '发送状态(-1发送失败 0等待发送 1发送成功) ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='消息' AUTO_INCREMENT=1 ;

--
-- 应用信息
-- 表的结构 `mz_appinfo`
--
DROP TABLE IF EXISTS  `mz_appinfo`;
CREATE TABLE `mz_appinfo` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '记录id',
  `version_name` varchar(32) NOT NULL DEFAULT '1.0.0' COMMENT '版本代号',
  `version_code` int(10) NOT NULL DEFAULT '1' COMMENT '版本号',
  `description` text COMMENT '版本描述',
  `url` varchar(4096) COMMENT '链接',
  `need_update` int(1) COMMENT '是否强制更新(0否 1是)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- 广告
-- 
DROP TABLE IF EXISTS  `mz_advertisement`;
CREATE TABLE `mz_advertisement` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '广告id',
  `description` varchar(256) NOT NULL COMMENT '描述',
  `url` varchar(512) NOT NULL COMMENT '广告链接',
  `pic_url` varchar(512) NOT NULL COMMENT '图片链接',
  `display` int(1) NOT NULL DEFAULT '0' COMMENT '是否显示(0 否1是)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='广告' AUTO_INCREMENT=1 ;


--
-- 用户修改密码
--
DROP TABLE IF EXISTS  `mz_user_forget`;
CREATE TABLE `mz_user_forget` (
  `email` varchar(32) DEFAULT NULL COMMENT '邮箱',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `rand_str` varchar(32) NOT NULL COMMENT '8位随机字符串',
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户忘记密码信息';


--
-- 转存表中的数据 `mz_appinfo`
--

INSERT INTO `mz_appinfo` (`id`, `version_name`, `version_code`, `description`,`url`,`need_update`) VALUES
(1, '1.0.0', 1, 'first version','http://61.29.161.61:88/mz/apk/MZ-Android.apk',0);

-- ---------
-- 预定义数据
-- ---------

--
-- 转存表中的数据 `mz_document_category`
-- 基本栏目
--

INSERT INTO `mz_document_category` (`category_id`, `name`, `description`, `category`) VALUES
(1, '基本职能', '职业培训-基本职能', '职业培训'),
(2, '法律法规及政策', '职业培训-法律法规及政策', '职业培训'),
(3, '相关新闻', '职业培训-相关新闻', '职业培训'),
(4, '通知信息', '职业培训-通知信息', '职业培训'),
(5, '政策法规', '职业技能鉴定-政策法规', '职业技能鉴定'),
(6, '办事指南', '职业技能鉴定-办事指南', '职业技能鉴定'),
(7, '全国统考', '职业技能鉴定-全国统考', '职业技能鉴定');


--
-- 转存表中的数据 `mz_user`
-- 超级管理员 nickname:superadmin email:superadmin@mz.com psw:superadmin lv:16
--

INSERT INTO `mz_user` (`uid`, `nickname`, `phone`, `email`, `psw`, `reg_time`, `level`, `status`) VALUES
(1, 'superadmin', NULL, 'superadmin@mz.com', '17c4520f6cfd1ab53d8745e84681eb49', 1411877304, 16, 1);

--
-- 转存表中的数据 `mz_user_admin`
-- 超级管理员的资料/权限
--

INSERT INTO `mz_user_admin` (`uid`, `per_categorys_post`, `per_categorys_check`, `per_institution_check`) VALUES
(1, '[1,2,3,4,5,6,7]', '[1,2,3,4,5,6,7]', '1');


