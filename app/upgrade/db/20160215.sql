ALTER TABLE `[#DB_PREFIX#]users` ADD `users_client` varchar(64) DEFAULT NULL COMMENT '系统';
ALTER TABLE `[#DB_PREFIX#]users` ADD `users_from` varchar(64) DEFAULT NULL COMMENT '来路';
ALTER TABLE `[#DB_PREFIX#]question` ADD `question_client` varchar(64) DEFAULT NULL COMMENT '系统';
ALTER TABLE `[#DB_PREFIX#]question` ADD `question_from` varchar(64) DEFAULT NULL COMMENT '来路';
ALTER TABLE `[#DB_PREFIX#]answer` ADD `answer_client` varchar(64) DEFAULT NULL COMMENT '系统';
ALTER TABLE `[#DB_PREFIX#]answer` ADD `answer_from` varchar(64) DEFAULT NULL COMMENT '来路';
INSERT INTO `[#DB_PREFIX#]system_setting` (`varname`, `value`) VALUES ('integral_system_config_qiandao', 's:2:"15";');
INSERT INTO `[#DB_PREFIX#]system_setting` (`varname`, `value`) VALUES ('integral_system_config_forusers', 's:2:"25";');
ALTER TABLE `[#DB_PREFIX#]users` ADD `extension_count` int(11) DEFAULT '0' COMMENT '推广';
ALTER TABLE `[#DB_PREFIX#]users` ADD `qiandao_count` int(11) DEFAULT '0' COMMENT '签到';
ALTER TABLE `[#DB_PREFIX#]users` ADD `qiandao_countday` int(11) DEFAULT '0' COMMENT '连续签到';

CREATE TABLE `[#DB_PREFIX#]do_work` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT '0',
  `work_time` int(10) DEFAULT NULL,
  `work_type` varchar(16) DEFAULT NULL,
  `work_memo` varchar(255) DEFAULT NULL,
  `work_ip` bigint(12) DEFAULT NULL,
  `touid` int(11) DEFAULT '0',
  `status` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `work_type` (`work_type`),
  KEY `uid` (`uid`)
) ENGINE=[#DB_ENGINE#] DEFAULT CHARSET=utf8 COMMENT='辅助表';

CREATE TABLE `[#DB_PREFIX#]links` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `category_id` int(11) DEFAULT '0' COMMENT '分类',
  `site_name` varchar(100) NOT NULL,
  `site_logo` varchar(255) DEFAULT NULL,
  `site_url` varchar(255)  NOT NULL,
  `times` int(10) DEFAULT NULL,
  `status` tinyint(3) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=[#DB_ENGINE#] DEFAULT CHARSET=utf8 COMMENT='友情链接表';

CREATE TABLE `[#DB_PREFIX#]ads` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `category_id` int(11) DEFAULT '0' COMMENT '分类',
  `ad_name` varchar(100) NOT NULL,
  `ad_logo` varchar(255) DEFAULT NULL,
  `ad_url` varchar(255)  NOT NULL,
  `ad_order` tinyint(5) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=[#DB_ENGINE#] DEFAULT CHARSET=utf8 COMMENT='广告表';

CREATE TABLE `[#DB_PREFIX#]qiandao_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `jifen` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  `position` varchar(255) DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `add_time` (`add_time`),
  KEY `jifen` (`jifen`),
  KEY `position` (`position`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='签到表';