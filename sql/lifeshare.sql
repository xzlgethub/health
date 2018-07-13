/*
SQLyog Ultimate v12.09 (64 bit)
MySQL - 5.1.73-log : Database - LifeShare
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`LifeShare` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `LifeShare`;

/*Table structure for table `hl_about_us` */

DROP TABLE IF EXISTS `hl_about_us`;

CREATE TABLE `hl_about_us` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `content` text NOT NULL COMMENT '描述项',
  `copyright` varchar(255) NOT NULL COMMENT '版权',
  `versions` varchar(20) NOT NULL COMMENT '版本',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `save_time` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `versions` (`versions`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `hl_about_us` */

insert  into `hl_about_us`(`id`,`content`,`copyright`,`versions`,`create_time`,`save_time`) values (2,'健康股构建一个去中心化的\"普惠医疗\"健康金融区块链平台\\n\\n基于医疗健康大数据重新连接医疗机构、健康保险、医生团体等健康相关产业\\n\\n形成运动、健康、保障、医疗、康复、正循环，打造普惠医疗健康金融生态系统','版本：1.0.0\\nCopyright © 2018 健康股 | All rights reserved','1.0.0','2018-04-25 10:57:21','2018-04-25 10:57:26');

/*Table structure for table `hl_adminuser` */

DROP TABLE IF EXISTS `hl_adminuser`;

CREATE TABLE `hl_adminuser` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(20) NOT NULL COMMENT '名称',
  `username` varchar(20) NOT NULL COMMENT '账号',
  `password` varchar(32) NOT NULL COMMENT '密码',
  `sex` int(11) DEFAULT NULL COMMENT '性别',
  `email` varchar(30) DEFAULT NULL COMMENT '邮箱',
  `phone` varchar(11) NOT NULL COMMENT '手机号',
  `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '注册时间',
  `type` int(11) DEFAULT NULL COMMENT '管理员身份',
  `status` tinyint(1) DEFAULT NULL COMMENT '1禁用、0允许',
  PRIMARY KEY (`id`),
  KEY `username` (`username`,`password`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `hl_adminuser` */

insert  into `hl_adminuser`(`id`,`name`,`username`,`password`,`sex`,`email`,`phone`,`time`,`type`,`status`) values (1,'超级管理员','admin','e10adc3949ba59abbe56e057f20f883e',NULL,'','0','0000-00-00 00:00:00',NULL,NULL),(2,'杨秀川','757791723','f63f4fbc9f8c85d409f2f59f2b9e12d5',NULL,NULL,'18574141757','2018-05-02 09:57:00',9,NULL);

/*Table structure for table `hl_advertisement` */

DROP TABLE IF EXISTS `hl_advertisement`;

CREATE TABLE `hl_advertisement` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '启动动画表id',
  `pic` varchar(30) NOT NULL,
  `time` int(11) NOT NULL,
  `state` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `hl_advertisement` */

/*Table structure for table `hl_auth_group` */

DROP TABLE IF EXISTS `hl_auth_group`;

CREATE TABLE `hl_auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rules` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

/*Data for the table `hl_auth_group` */

insert  into `hl_auth_group`(`id`,`title`,`status`,`rules`) values (9,'管理员',1,'1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,75,76,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74');

/*Table structure for table `hl_auth_group_access` */

DROP TABLE IF EXISTS `hl_auth_group_access`;

CREATE TABLE `hl_auth_group_access` (
  `uid` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `hl_auth_group_access` */

insert  into `hl_auth_group_access`(`uid`,`group_id`) values (2,9);

/*Table structure for table `hl_auth_rule` */

DROP TABLE IF EXISTS `hl_auth_rule`;

CREATE TABLE `hl_auth_rule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `title` varchar(20) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `condition` varchar(50) DEFAULT '',
  `classify` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8;

/*Data for the table `hl_auth_rule` */

insert  into `hl_auth_rule`(`id`,`name`,`title`,`type`,`status`,`condition`,`classify`) values (1,'Manage/Index/index','首页',1,1,'',1),(2,'Manage/User/index','用户首页',1,1,'',2),(3,'Manage/User/userStep','用户步数页面',1,1,'',2),(4,'Manage/User/userReport','用户健康资料页面',1,1,'',2),(5,'Manage/User/auditAction','用户健康资料页面审核状态操作',1,1,'',2),(6,'Manage/User/audit','报告审核首页',1,1,'',2),(7,'Manage/User/auditStatus','报告审核状态处理操作',1,1,'',2),(8,'Manage/User/auditDel','报告审核删除操作',1,1,'',2),(9,'Manage/User/add','用户添加页面',1,1,'',2),(10,'Manage/User/addAction','用户添加操作',1,1,'',2),(11,'Manage/User/delAction','用户删除操作',1,1,'',2),(12,'Manage/User/vadataajax','验证用户数据操作',1,1,'',2),(13,'Manage/User/edit','用户修改',1,1,'',2),(14,'Manage/User/editAction','用户修改操作',1,1,'',2),(15,'Manage/User/del','用户删除',1,1,'',2),(16,'Manage/User/statusUser','用户限制操作',1,1,'',2),(17,'Manage/Management/administrator','管理员首页',1,1,'',3),(18,'Manage/Management/SelectRuleType','AJAX查询权限组',1,1,'',3),(19,'Manage/Management/add','管理员添加页面',1,1,'',3),(20,'Manage/Management/addUser','管理员添加操作',1,1,'',3),(21,'Manage/Management/vadataajax','验证管理员数据操作',1,1,'',3),(22,'Manage/Management/edit','管理员修改页面',1,1,'',3),(23,'Manage/Management/editAction','管理员修改操作',1,1,'',3),(24,'Manage/Management/del','管理员删除操作',1,1,'',3),(25,'Manage/Rule/index','权限首页',1,1,'',4),(26,'Manage/Rule/edit','权限修改页面',1,1,'',4),(27,'Manage/Rule/editAction','权限修改操作',1,1,'',4),(28,'Manage/Rule/add','权限添加页面',1,1,'',4),(29,'Manage/Rule/addAction','权限添加操作',1,1,'',4),(30,'Manage/Rule/delRule','权限删除操作',1,1,'',4),(31,'Manage/Rule/RuleGroup','权限组首页',1,1,'',4),(32,'Manage/Rule/findRule','查找权限名称操作',1,1,'',4),(33,'Manage/Rule/editRuleGroup','权限组修改页面',1,1,'',4),(34,'Manage/Rule/editAGaction','权限组修改操作',1,1,'',4),(35,'Manage/Rule/addRuleGroup','权限组添加页面',1,1,'',4),(36,'Manage/Rule/addAGaction','权限组添加操作',1,1,'',4),(37,'Manage/Rule/delRuleGroup','权限组删除操作',1,1,'',4),(38,'Manage/Rule/RuleUser','用户分配页面',1,1,'',4),(39,'Manage/Rule/findRuleGroup','查询权限组数据操作',1,1,'',4),(40,'Manage/Rule/changeAGA','修改用户权限组数据操作',1,1,'',4),(41,'Manage/Product/index','产品管理首页',1,1,'',5),(42,'Manage/Product/edit','产品修改页面',1,1,'',5),(43,'Manage/Product/editAction','产品修改操作',1,1,'',5),(44,'Manage/Product/add','产品添加页面',1,1,'',5),(45,'Manage/Product/addAction','产品添加操作',1,1,'',5),(46,'Manage/Product/delAction','产品删除操作',1,1,'',5),(47,'Manage/Product/statusGoods','产品上架下架修改操作',1,1,'',5),(48,'Manage/Logo/index','logo首页',1,1,'',6),(49,'Manage/Logo/stateLogo','状态修改操作',1,1,'',6),(50,'Manage/Logo/add','logo添加页面',1,1,'',6),(51,'Manage/Logo/addAction','logo添加操作',1,1,'',6),(52,'Manage/Logo/delAction','logo删除操作',1,1,'',6),(53,'Manage/Logo/edit','logo修改页面',1,1,'',6),(54,'Manage/Logo/editAction','logo修改操作',1,1,'',6),(55,'Manage/Copyright/index','版权首页',1,1,'',7),(56,'Manage/Copyright/add','版权添加页面',1,1,'',7),(57,'Manage/Copyright/addAction','版权添加操作',1,1,'',7),(58,'Manage/Copyright/delAction','版权删除操作',1,1,'',7),(59,'Manage/Copyright/edit','版权修改页面',1,1,'',7),(60,'Manage/Copyright/editAction','版权修改操作',1,1,'',7),(61,'Manage/Faq/index','常见问题首页',1,1,'',8),(62,'Manage/Faq/add','常见问题添加页面',1,1,'',8),(63,'Manage/Faq/addAction','常见问题添加操作',1,1,'',8),(64,'Manage/Faq/edit','常见问题修改页面',1,1,'',8),(65,'Manage/Faq/editAction','常见问题修改操作',1,1,'',8),(66,'Manage/Faq/delAction','常见问题删除操作',1,1,'',8),(67,'Manage/My/aboutus','关于我们首页',1,1,'',9),(68,'Manage/My/add','关于我们添加页面',1,1,'',9),(69,'Manage/My/addAction','关于我们添加操作',1,1,'',9),(70,'Manage/My/edit','关于我们修改页面',1,1,'',9),(71,'Manage/My/editAction','关于我们修改操作',1,1,'',9),(72,'Manage/My/delaboutus','关于我们删除操作',1,1,'',9),(73,'Manage/Feedback/index','意见反馈首页',1,1,'',10),(74,'Manage/Feedback/del','意见反馈删除',1,1,'',10),(75,'Manage/User/auditShow','报告审核预览',1,1,'',2),(76,'Manage/Index/userAuditShow','用户健康资料页面审核预览',1,1,'',2);

/*Table structure for table `hl_code_verification` */

DROP TABLE IF EXISTS `hl_code_verification`;

CREATE TABLE `hl_code_verification` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `phone` varchar(20) NOT NULL COMMENT '手机号',
  `code` varchar(5) NOT NULL COMMENT '验证码',
  `time` varchar(20) NOT NULL COMMENT '验证码生成时间戳',
  `type` tinyint(1) NOT NULL COMMENT '验证码类型 0:注册 1:登陆 2:修改',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:未使用 1:使用',
  `area_code` varchar(5) DEFAULT NULL COMMENT '区号',
  PRIMARY KEY (`id`),
  KEY `phone` (`phone`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

/*Data for the table `hl_code_verification` */

insert  into `hl_code_verification`(`id`,`phone`,`code`,`time`,`type`,`status`,`area_code`) values (29,'18601258011','2999','1527651133',0,1,'86'),(28,'15120039961','6796','1527472472',1,0,'86'),(27,'13717879033','0100','1526959198',0,1,'86'),(26,'13641096928','0991','1526816945',0,1,'86'),(25,'17501117545','5676','1526816806',0,0,'86');

/*Table structure for table `hl_copyright` */

DROP TABLE IF EXISTS `hl_copyright`;

CREATE TABLE `hl_copyright` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '版权表id',
  `name` varchar(100) NOT NULL COMMENT '版权信息',
  `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `hl_copyright` */

insert  into `hl_copyright`(`id`,`name`,`time`) values (1,'2018 ©健康股','2018-05-02 09:47:50');

/*Table structure for table `hl_faq` */

DROP TABLE IF EXISTS `hl_faq`;

CREATE TABLE `hl_faq` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `title` varchar(50) NOT NULL COMMENT '标题',
  `content` text NOT NULL COMMENT '内容',
  `createtime` datetime NOT NULL COMMENT '创建时间',
  `weight` tinyint(1) NOT NULL DEFAULT '0' COMMENT '权重',
  PRIMARY KEY (`id`),
  KEY `title` (`title`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `hl_faq` */

insert  into `hl_faq`(`id`,`title`,`content`,`createtime`,`weight`) values (1,'我的步数为什么不准确？','健康股App在每天22：00准时结算，您在结算前打开App将获取您最新的步数信息，从而提高您的步数准确度。','2018-04-28 12:33:26',0),(2,'LIFE可以用来干嘛？','LIFE可以在App中兑换相关医疗服务；后续也可以进行提现。','2018-04-28 12:33:26',0),(3,'我的LIFE数值是怎么与步数进行兑换的？','每天累计5000步开始挖矿，可获得50LIFE，每多走1000步多获得30LIFE，每天最多累计500个LIFE。','2018-04-28 12:35:42',0),(4,'为什么别人得到的LIFE比我多？','1.您在结算前没有打开健康股App，所以步数获取不准确。<br/> 2.您所走的步数没有他人多。 <br/> 3.他人通过邀请好友加入健康股App获得额外LIFE奖励','2018-04-28 12:38:22',0),(5,'我上传的健康资料会泄漏吗？','不会的，您的健康资料将会由健康股通过区块链技术进行加密，私密性极高不会泄漏。','2018-04-28 13:16:00',0),(6,'为什么我的健康资料不可更改？','不可篡改是区块链技术特性，以防数据篡改作假。','2018-04-28 13:18:09',0),(8,'为什么我的金币数是0？','每天的基础任务为5000步，超过此步数才可继续获得金币。','2018-05-02 11:26:38',0);

/*Table structure for table `hl_feedback` */

DROP TABLE IF EXISTS `hl_feedback`;

CREATE TABLE `hl_feedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `uid` int(11) DEFAULT NULL COMMENT '用户ID',
  `feedback` varchar(255) NOT NULL DEFAULT '' COMMENT '反馈意见',
  `contact_way` varchar(50) DEFAULT NULL COMMENT '联系方式',
  `createtime` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `hl_feedback` */

insert  into `hl_feedback`(`id`,`uid`,`feedback`,`contact_way`,`createtime`) values (2,100004,'反馈意见是通的吗？我从哪里可以看到啊','1029531497','2018-04-25 22:14:14'),(3,100009,'6666666','757791723',NULL),(4,100009,'发推出停车场','','2018-04-26 16:21:19');

/*Table structure for table `hl_friend_list` */

DROP TABLE IF EXISTS `hl_friend_list`;

CREATE TABLE `hl_friend_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '用户ID',
  `fid` int(11) NOT NULL COMMENT '好友ID',
  `createtime` datetime NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `hl_friend_list` */

/*Table structure for table `hl_goods` */

DROP TABLE IF EXISTS `hl_goods`;

CREATE TABLE `hl_goods` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `goods_name` varchar(20) NOT NULL COMMENT '商品名称',
  `price` decimal(15,2) NOT NULL COMMENT '商品价格',
  `real_price` decimal(15,2) DEFAULT NULL COMMENT '实际价格',
  `up_time` datetime DEFAULT NULL COMMENT '上架时间',
  `down_time` datetime DEFAULT NULL COMMENT '下架时间',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `store_nums` int(11) DEFAULT NULL COMMENT '库存',
  `pic_img` varchar(255) DEFAULT NULL COMMENT '原图路径',
  `thumb_img` varchar(255) DEFAULT NULL COMMENT '缩略图路径',
  `content` text COMMENT '商品描述',
  `goods_no` varchar(20) DEFAULT NULL COMMENT '货号',
  `status` tinyint(1) DEFAULT '1' COMMENT '上架（1）：下架（0）',
  `goods_brand` varchar(255) DEFAULT NULL COMMENT '商品商标',
  `detail_url` varchar(100) DEFAULT NULL COMMENT '商品详情H5',
  PRIMARY KEY (`id`),
  KEY `goods_name` (`goods_name`) USING BTREE,
  KEY `goods_no` (`goods_no`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=78 DEFAULT CHARSET=utf8;

/*Data for the table `hl_goods` */

insert  into `hl_goods`(`id`,`goods_name`,`price`,`real_price`,`up_time`,`down_time`,`create_time`,`store_nums`,`pic_img`,`thumb_img`,`content`,`goods_no`,`status`,`goods_brand`,`detail_url`) values (71,'协医健康无忧计划','1.00','0.01',NULL,NULL,'2018-04-28 17:27:32',100,'file/goodspic/2018-04-28/5ae43e84b9124.png','file/goodspic/2018-04-28/thumb_5ae43e84b9124.png','企业员工健康关怀\\n协和专家 · 34种重大疾病','jkg_001',1,'大病远程资讯,就医绿色通道','http://test.huliantec.com/Lifeshare/health/index.html'),(72,'协医大病宝A计划','1.00','0.01',NULL,NULL,'2018-04-28 17:29:16',100,'file/goodspic/2018-04-28/5ae43eec29388.png','file/goodspic/2018-04-28/thumb_5ae43eec29388.png','保险客户增值计划\\n协和专家 · 34种重大疾病','jkg_002',1,'大病远程资讯,就医绿色通道,手术绿色通道','http://test.huliantec.com/Lifeshare/health/index.html'),(73,'协医抗癌宝','1.00','3.00',NULL,NULL,'2018-04-28 17:30:38',100,'file/goodspic/2018-04-28/5ae43f3ec62bd.png','file/goodspic/2018-04-28/thumb_5ae43f3ec62bd.png','网络互助增值计划\\n协和专家 · 34种重大疾病','jkg_003',1,'癌症远程资讯','http://test.huliantec.com/Lifeshare/health/index.html'),(74,'协医大病宝B计划','1.00','4.00',NULL,NULL,'2018-04-28 17:32:16',100,'file/goodspic/2018-04-28/5ae43fa0044a6.png','file/goodspic/2018-04-28/thumb_5ae43fa0044a6.png','保险客户增值计划\\n协和专家 · 34种重大疾病','jkg_004',1,'大病远程资讯,就医绿色通道','http://test.huliantec.com/Lifeshare/health/index.html'),(75,'协医大病宝C计划','2000.00','2.00',NULL,NULL,'2018-04-28 17:32:56',100,'file/goodspic/2018-04-28/5ae43fc8d640f.png','file/goodspic/2018-04-28/thumb_5ae43fc8d640f.png','保险客户增值计划\\n协和专家 · 34种重大疾病','jkg_005',1,'大病远程资讯','http://test.huliantec.com/Lifeshare/health/index.html');

/*Table structure for table `hl_health_information` */

DROP TABLE IF EXISTS `hl_health_information`;

CREATE TABLE `hl_health_information` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `uid` int(11) NOT NULL COMMENT '用户ID',
  `pic` varchar(255) NOT NULL COMMENT '图片路径',
  `thumbpic` varchar(255) NOT NULL COMMENT '缩略图',
  `info` varchar(255) DEFAULT '' COMMENT '图片描述',
  `reporttype` tinyint(1) NOT NULL COMMENT '报告类型 1:体检报告 2:病历报告',
  `audittype` tinyint(1) NOT NULL DEFAULT '0' COMMENT '审核状态 0:未审核 1:审核',
  `createtime` datetime NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;

/*Data for the table `hl_health_information` */

insert  into `hl_health_information`(`id`,`uid`,`pic`,`thumbpic`,`info`,`reporttype`,`audittype`,`createtime`) values (1,100002,'file/reportpic/2018-04-24/5adf058f8372a.png','file/reportpic/2018-04-24/thumb_5adf058f8372a.png','来来来您共鸣，你在群里说的什么时候有时间可以看看你吗你的，你啦啦啦啦啦啦啦我是卖报歌唱的好啊美女好了吗我也想啊，？，你就知道为什么你总是说我什么情况？你啦啦啦啦啦啦啦德玛西亚杯的事就是这样的人了。，你就不能找你',1,0,'2018-04-24 18:23:11'),(2,100002,'file/reportpic/2018-04-24/5adf0651c25b9.png','file/reportpic/2018-04-24/thumb_5adf0651c25b9.png','啦咯啦咯啦咯图兔兔咯哦搜狗匿名你明明宁宁你民工明明你明明你\n来来来\n考虑考虑\n考虑考虑明明哦！，你啦你是啥情况呢，？',1,0,'2018-04-24 18:26:25'),(5,100002,'file/reportpic/2018-04-24/5adf17d61d151.png','file/reportpic/2018-04-24/thumb_5adf17d61d151.png','',2,0,'2018-04-24 19:41:10'),(6,100001,'file/reportpic/2018-04-25/5ae02ae91cb10.png','file/reportpic/2018-04-25/thumb_5ae02ae91cb10.png','明明民工',1,0,'2018-04-25 15:14:49'),(4,100002,'file/reportpic/2018-04-24/5adf169e98b24.png','file/reportpic/2018-04-24/thumb_5adf169e98b24.png','叽叽叽叽',1,0,'2018-04-24 19:35:58'),(7,100001,'file/reportpic/2018-04-25/5ae02b681089c.png','file/reportpic/2018-04-25/thumb_5ae02b681089c.png','咯噢噢噢',1,0,'2018-04-25 15:16:56'),(8,100001,'file/reportpic/2018-04-25/5ae02b890b605.png','file/reportpic/2018-04-25/thumb_5ae02b890b605.png','',1,0,'2018-04-25 15:17:29'),(9,100001,'file/reportpic/2018-04-25/5ae02b95ac0b3.png','file/reportpic/2018-04-25/thumb_5ae02b95ac0b3.png','急急急您HK李敏',1,0,'2018-04-25 15:17:41'),(10,100001,'file/reportpic/2018-04-25/5ae02bb4afce5.png','file/reportpic/2018-04-25/thumb_5ae02bb4afce5.png','',2,0,'2018-04-25 15:18:12'),(11,100001,'file/reportpic/2018-04-26/5ae14cb725acb.png','file/reportpic/2018-04-26/thumb_5ae14cb725acb.png','',1,0,'2018-04-26 11:51:19'),(12,100001,'file/reportpic/2018-04-26/5ae14e0698437.png','file/reportpic/2018-04-26/thumb_5ae14e0698437.png','',1,0,'2018-04-26 11:56:54'),(14,100008,'file/reportpic/2018-04-27/5ae2805439839.png','file/reportpic/2018-04-27/thumb_5ae2805439839.png','',2,1,'2018-04-27 09:43:48'),(32,100012,'file/reportpic/2018-05-03/5aea6d5dc795e.png','file/reportpic/2018-05-03/thumb_5aea6d5dc795e.png','哈哈哈',1,0,'2018-05-03 10:01:01'),(17,100008,'file/reportpic/2018-04-27/5ae280b902053.png','file/reportpic/2018-04-27/thumb_5ae280b902053.png','',1,1,'2018-04-27 09:45:29'),(18,100008,'file/reportpic/2018-04-27/5ae280bdc8a6f.png','file/reportpic/2018-04-27/thumb_5ae280bdc8a6f.png','',1,1,'2018-04-27 09:45:33'),(20,100004,'file/reportpic/2018-04-28/5ae3df1547690.png','file/reportpic/2018-04-28/thumb_5ae3df1547690.png','',2,0,'2018-04-28 10:40:21'),(21,100011,'file/reportpic/2018-04-28/5ae3e82b72adf.png','file/reportpic/2018-04-28/thumb_5ae3e82b72adf.png','',1,1,'2018-04-28 11:19:07'),(22,100011,'file/reportpic/2018-04-28/5ae3e83f597c7.png','file/reportpic/2018-04-28/thumb_5ae3e83f597c7.png','',2,0,'2018-04-28 11:19:27'),(23,100011,'file/reportpic/2018-04-28/5ae3f4529bb78.png','file/reportpic/2018-04-28/thumb_5ae3f4529bb78.png','',1,1,'2018-04-28 12:10:58'),(24,100011,'file/reportpic/2018-04-28/5ae3f45cb01c3.png','file/reportpic/2018-04-28/thumb_5ae3f45cb01c3.png','',1,2,'2018-04-28 12:11:08'),(25,100011,'file/reportpic/2018-04-28/5ae3f4632edb3.png','file/reportpic/2018-04-28/thumb_5ae3f4632edb3.png','',1,2,'2018-04-28 12:11:15'),(26,100011,'file/reportpic/2018-05-02/5ae97380bc67b.png','file/reportpic/2018-05-02/thumb_5ae97380bc67b.png','',1,0,'2018-05-02 16:14:56'),(27,100011,'file/reportpic/2018-05-02/5ae973abb761f.png','file/reportpic/2018-05-02/thumb_5ae973abb761f.png','',2,0,'2018-05-02 16:15:39'),(36,100013,'file/reportpic/2018-05-16/5afc2d0cba37b.png','file/reportpic/2018-05-16/thumb_5afc2d0cba37b.png','',1,0,'2018-05-16 21:07:24'),(34,100012,'file/reportpic/2018-05-03/5aea6f90d051e.png','file/reportpic/2018-05-03/thumb_5aea6f90d051e.png','',1,0,'2018-05-03 10:10:24'),(30,100012,'file/reportpic/2018-05-03/5aea6d26aa38b.png','file/reportpic/2018-05-03/thumb_5aea6d26aa38b.png','',1,0,'2018-05-03 10:00:06'),(35,100012,'file/reportpic/2018-05-03/5aea7926deb03.png','file/reportpic/2018-05-03/thumb_5aea7926deb03.png','',2,0,'2018-05-03 10:51:18'),(37,100013,'file/reportpic/2018-05-16/5afc2d140ec88.png','file/reportpic/2018-05-16/thumb_5afc2d140ec88.png','',1,0,'2018-05-16 21:07:32'),(38,100013,'file/reportpic/2018-05-16/5afc2d44504ce.png','file/reportpic/2018-05-16/thumb_5afc2d44504ce.png','',2,0,'2018-05-16 21:08:20'),(39,100014,'file/reportpic/2018-05-17/5afd12fd45786.png','file/reportpic/2018-05-17/thumb_5afd12fd45786.png','',1,0,'2018-05-17 13:28:29'),(40,100014,'file/reportpic/2018-05-17/5afd30851cfcd.png','file/reportpic/2018-05-17/thumb_5afd30851cfcd.png','',1,0,'2018-05-17 15:34:29'),(41,100014,'file/reportpic/2018-05-17/5afd30932d2f8.png','file/reportpic/2018-05-17/thumb_5afd30932d2f8.png','',1,0,'2018-05-17 15:34:43');

/*Table structure for table `hl_integral` */

DROP TABLE IF EXISTS `hl_integral`;

CREATE TABLE `hl_integral` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `uid` int(11) NOT NULL COMMENT '用户ID',
  `revenuetype` varchar(10) NOT NULL COMMENT '录入明细',
  `life` decimal(15,2) DEFAULT '0.00' COMMENT 'life积分',
  `createtime` datetime NOT NULL COMMENT '创建时间',
  `lis` decimal(15,3) DEFAULT '0.000' COMMENT 'lis积分',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '录入类型 0：全录入 1：life录入 2：lis录入',
  `inc` tinyint(4) DEFAULT '1' COMMENT '1加积分  2减积分',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=100073 DEFAULT CHARSET=utf8;

/*Data for the table `hl_integral` */

insert  into `hl_integral`(`id`,`uid`,`revenuetype`,`life`,`createtime`,`lis`,`type`,`inc`) values (100001,100001,'走路挖矿','0.00','2018-04-24 00:00:00','0.000',0,1),(100002,100002,'走路挖矿','0.00','2018-04-24 00:00:00','0.000',0,1),(100003,100005,'注册奖励','100.00','2018-04-25 18:58:07','10.000',0,1),(100004,100004,'走路挖矿','120.68','2018-04-25 22:00:01','12.068',0,1),(100005,100006,'注册奖励','100.00','2018-04-26 15:27:29','10.000',0,1),(100006,100007,'注册奖励','100.00','2018-04-26 15:34:13','10.000',0,1),(100007,100008,'注册奖励','100.00','2018-04-26 15:43:59','10.000',0,1),(100008,100009,'注册奖励','100.00','2018-04-26 16:01:37','10.000',0,1),(100009,100004,'走路挖矿','193.43','2018-04-26 22:00:01','19.343',0,1),(100010,100008,'走路挖矿','96.65','2018-04-26 22:00:01','9.665',0,1),(100011,100008,'走路挖矿','165.86','2018-04-27 22:00:01','16.586',0,1),(100012,100010,'注册奖励','100.00','2018-04-28 10:06:59','10.000',0,1),(100013,100011,'注册奖励','100.00','2018-04-28 10:27:19','10.000',0,1),(100014,100012,'注册奖励','100.00','2018-04-28 12:08:08','10.000',0,1),(100015,100004,'走路挖矿','163.25','2018-04-28 22:00:01','16.325',0,1),(100016,100009,'走路挖矿','139.31','2018-04-28 22:00:01','13.931',0,1),(100017,100009,'走路挖矿','500.00','2018-04-30 22:00:01','50.000',0,1),(100018,100010,'走路挖矿','230.27','2018-04-30 22:00:01','23.027',0,1),(100019,100004,'走路挖矿','178.10','2018-04-30 22:00:01','17.810',0,1),(100020,100009,'走路挖矿','330.77','2018-05-01 22:00:01','33.077',0,1),(100021,100010,'走路挖矿','83.42','2018-05-01 22:00:01','8.342',0,1),(100022,100010,'走路挖矿','125.51','2018-05-09 15:22:26','12.551',0,1),(100023,100010,'走路挖矿','125.51','2018-05-09 15:22:47','12.551',0,1),(100024,100013,'注册奖励','100.00','2018-05-16 20:52:07','10.000',0,1),(100025,100014,'注册奖励','100.00','2018-05-16 21:18:40','10.000',0,1),(100026,100014,'购买服务','-1.00','0000-00-00 00:00:00','0.000',0,1),(100027,100014,'购买服务','-1.00','2018-05-17 20:53:28','0.000',0,1),(100028,100014,'走路挖矿','415.17','2018-05-17 22:00:01','31.517',0,1),(100029,100014,'购买服务','-1.00','2018-05-18 10:46:19','0.000',0,1),(100030,100014,'购买服务','-2000.00','2018-05-18 17:19:56','0.000',0,1),(100031,100013,'购买服务','-1.00','2018-05-18 17:26:59','0.000',0,1),(100032,100013,'购买服务','-1.00','2018-05-18 19:19:03','0.000',0,1),(100033,100013,'购买服务','-1.00','2018-05-18 19:20:41','0.000',0,1),(100034,100013,'购买服务','-1.00','2018-05-18 19:33:21','0.000',0,1),(100035,100014,'购买服务','-1.00','2018-05-18 20:42:30','0.000',0,1),(100036,100014,'走路挖矿','195.93','2018-05-18 22:00:01','9.593',0,1),(100037,100015,'分享奖励','50.00','2018-05-20 14:28:27','10.000',0,1),(100038,100016,'分享奖励','50.00','2018-05-20 14:31:13','10.000',0,1),(100039,100017,'分享奖励','50.00','2018-05-20 15:40:51','10.000',0,1),(100040,100018,'分享奖励','50.00','2018-05-20 15:43:33','10.000',0,1),(100041,100019,'分享奖励','50.00','2018-05-20 19:49:27','10.000',0,1),(100042,100014,'分享奖励','50.00','2018-05-20 19:49:27','10.000',0,1),(100043,100014,'购买服务','-1.00','2018-05-21 00:20:04','0.000',0,1),(100044,100014,'购买服务','-1.00','2018-05-21 00:20:27','0.000',0,1),(100045,100004,'购买服务','-1.00','2018-05-21 14:31:04','0.000',0,1),(100046,100014,'购买服务','-1.00','2018-05-21 16:25:14','0.000',0,1),(100047,100014,'走路挖矿','237.36','2018-05-21 22:00:02','13.736',0,1),(100048,100010,'走路挖矿','62.72','2018-05-21 22:00:02','6.272',0,1),(100049,100020,'注册奖励','100.00','2018-05-22 11:20:26','10.000',0,1),(100050,100010,'购买服务','-1.00','2018-05-23 20:25:16','0.000',0,1),(100051,100010,'走路挖矿','245.82','2018-05-23 22:00:01','14.582',0,1),(100052,100014,'走路挖矿','121.13','2018-05-23 22:00:01','12.113',0,1),(100053,100004,'走路挖矿','89.54','2018-05-23 22:00:01','8.954',0,1),(100054,100014,'走路挖矿','239.94','2018-05-24 22:00:01','13.994',0,1),(100055,100004,'走路挖矿','171.72','2018-05-25 22:00:02','7.172',0,1),(100056,100014,'走路挖矿','166.20','2018-05-28 22:00:01','6.620',0,1),(100057,100021,'注册奖励','100.00','2018-05-30 11:32:33','10.000',0,1),(100058,100014,'走路挖矿','247.20','2018-05-30 22:00:02','14.720',0,1),(100059,100010,'走路挖矿','207.15','2018-06-01 22:00:02','10.715',0,1),(100060,100010,'走路挖矿','323.04','2018-06-02 22:00:01','22.304',0,1),(100061,100010,'走路挖矿','267.42','2018-06-03 22:00:01','16.742',0,1),(100062,100004,'走路挖矿','223.14','2018-06-04 22:00:01','12.314',0,1),(100063,100004,'走路挖矿','155.73','2018-06-05 22:00:01','5.573',0,1),(100064,100004,'走路挖矿','183.33','2018-06-06 22:00:01','8.333',0,1),(100065,100004,'走路挖矿','215.61','2018-06-07 22:00:01','11.561',0,1),(100066,100010,'走路挖矿','332.16','2018-06-08 22:00:02','23.216',0,1),(100067,100004,'走路挖矿','147.20','2018-06-08 22:00:02','14.720',0,1),(100068,100010,'走路挖矿','219.78','2018-06-09 22:00:01','11.978',0,1),(100069,100010,'走路挖矿','311.10','2018-06-10 22:00:01','21.110',0,1),(100070,100004,'走路挖矿','223.89','2018-06-27 22:00:02','12.389',0,1),(100071,100010,'走路挖矿','310.20','2018-06-29 22:00:02','21.020',0,1),(100072,100010,'走路挖矿','298.50','2018-06-30 22:00:01','19.850',0,1);

/*Table structure for table `hl_knowledge` */

DROP TABLE IF EXISTS `hl_knowledge`;

CREATE TABLE `hl_knowledge` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '新闻表id',
  `gid` int(11) NOT NULL COMMENT '新闻类别id',
  `aid` int(11) NOT NULL COMMENT '添加人id',
  `title` varchar(100) NOT NULL COMMENT '标题',
  `pic` varchar(100) DEFAULT 'xwmr.png' COMMENT '封面图',
  `curriculum` varchar(100) DEFAULT NULL COMMENT '文件名称',
  `introduce` text COMMENT '介绍',
  `state` tinyint(1) DEFAULT NULL COMMENT '0独立文件形式/1课程形式',
  `num` int(11) DEFAULT '0' COMMENT '阅读量',
  `time` datetime NOT NULL COMMENT '上传时间',
  `path` varchar(250) DEFAULT NULL COMMENT '类别路径',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='知识表';

/*Data for the table `hl_knowledge` */

/*Table structure for table `hl_logo` */

DROP TABLE IF EXISTS `hl_logo`;

CREATE TABLE `hl_logo` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'logo表id',
  `name` varchar(100) NOT NULL COMMENT '图片路径',
  `state` tinyint(1) DEFAULT NULL COMMENT '图片类别（1登录页、2登录后）',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `hl_logo` */

insert  into `hl_logo`(`id`,`name`,`state`,`time`) values (1,'file/logo/5ae92e891b4d8.png',1,'2018-05-02 09:47:24');

/*Table structure for table `hl_logres` */

DROP TABLE IF EXISTS `hl_logres`;

CREATE TABLE `hl_logres` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uname` varchar(50) NOT NULL COMMENT '用户名称',
  `operat` varchar(50) NOT NULL COMMENT '模块名称',
  `status` tinyint(1) NOT NULL COMMENT '操作状态（1为增，2为删，3为改，4为导出，5为导入）',
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

/*Data for the table `hl_logres` */

insert  into `hl_logres`(`id`,`uname`,`operat`,`status`,`time`) values (1,'超级管理员','LOGO&nbsp;&nbsp;&nbsp;ID：1',1,1525225644),(2,'超级管理员','管理员：杨秀川&nbsp;&nbsp;&nbsp;ID：2',1,1525226220),(3,'admin','LOGO：ID：',3,1525230924),(4,'admin','LOGO：ID：',3,1525230961),(5,'admin','LOGO：ID：',3,1525231083),(6,'admin','LOGO：ID：',3,1525231112),(7,'admin','LOGO：ID：',3,1525231241),(8,'admin','LOGO&nbsp;&nbsp;&nbsp;ID：2',1,1525231255),(9,'admin','LOGO：2',2,1525231266);

/*Table structure for table `hl_newstype` */

DROP TABLE IF EXISTS `hl_newstype`;

CREATE TABLE `hl_newstype` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '新闻类别表id',
  `name` varchar(50) NOT NULL COMMENT '类别名称',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '上传时间',
  `state` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1课程、0微客',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `hl_newstype` */

/*Table structure for table `hl_order` */

DROP TABLE IF EXISTS `hl_order`;

CREATE TABLE `hl_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL COMMENT '用户id',
  `order_code` varchar(30) DEFAULT NULL COMMENT '订单编号',
  `name` varchar(20) DEFAULT NULL COMMENT '姓名',
  `phone` varchar(20) DEFAULT NULL COMMENT '电话',
  `id_card` varchar(20) DEFAULT NULL COMMENT '身份证号',
  `create_time` varchar(20) DEFAULT NULL COMMENT '创建时间',
  `pay_time` varchar(20) DEFAULT NULL COMMENT '支付时间',
  `expire_time` varchar(20) DEFAULT NULL COMMENT '到期时间（支付时间加一年）',
  `money` decimal(15,2) DEFAULT NULL COMMENT '价格',
  `state` tinyint(4) DEFAULT '2' COMMENT '订单状态1支付 2待支付',
  `serve_state` tinyint(4) DEFAULT '2' COMMENT '服务状态1已服务 2未服务',
  `serve_time` varchar(20) DEFAULT NULL COMMENT '服务时间',
  `is_effect` tinyint(4) DEFAULT '2' COMMENT '是否生效 1生效 2等待期',
  `rest_time` varchar(20) DEFAULT NULL COMMENT '剩余等待时间戳多90天',
  `insurance_id` int(11) DEFAULT NULL COMMENT '保险id',
  `insurance_name` varchar(100) DEFAULT NULL COMMENT '保险名称',
  `is_del` tinyint(4) DEFAULT '2' COMMENT '订单是否删除1是 2否',
  `life` decimal(15,2) DEFAULT NULL COMMENT 'life值',
  `pay_type` tinyint(4) DEFAULT NULL COMMENT '支付方式  1 life 2微信 3支付宝',
  `handle_serve` tinyint(4) DEFAULT '2' COMMENT '1 已处理服务  2未处理服务',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=115 DEFAULT CHARSET=utf8;

/*Data for the table `hl_order` */

insert  into `hl_order`(`id`,`uid`,`order_code`,`name`,`phone`,`id_card`,`create_time`,`pay_time`,`expire_time`,`money`,`state`,`serve_state`,`serve_time`,`is_effect`,`rest_time`,`insurance_id`,`insurance_name`,`is_del`,`life`,`pay_type`,`handle_serve`) values (114,100014,'H530676636336157','冬眠','13681181726','120222199110046411','1527667663','1527667709','1559145600','0.01',1,2,NULL,2,'55',71,'协医健康无忧计划',2,'1.00',2,2),(108,100010,'H523783030778615','李俊明','18510158016','34213019810823263X','1527078303','1527078316','2019-05-23','4.00',1,2,NULL,2,'48',74,'协医大病宝B计划',2,'1.00',1,2),(93,100004,'H521842597167612','赵翔','15120039961','150105199509177812','1526884259','1526884264','2019-05-21','0.01',1,2,NULL,2,'46',71,'协医健康无忧计划',2,'1.00',1,2),(92,100014,'H521787218259578','机灵','13681181726','120222199110046411','1526878721','1526878755','1558368000','0.01',1,1,'1527166824',1,'0',71,'协医健康无忧计划',2,'1.00',2,2),(91,100014,'H521752226798124','你民工','13681181726','120222199110046411','1526875222','1526877308','1558368000','0.01',1,1,'1526953466',1,'0',71,'协医健康无忧计划',2,'1.00',2,2),(90,100014,'H521738394138784','啊啊啊啊啊啊啊啊啊','13681181726','120222199110046411','1526873839','1526875925','1558368000','0.01',1,2,NULL,2,'46',71,'协医健康无忧计划',2,'1.00',2,2),(89,100014,'H521684147190496','你明明','13681181726','120222199110046411','1526868414','1526868418','1558404418','0.01',1,2,NULL,2,'46',71,'协医健康无忧计划',2,'1.00',2,2),(107,100014,'H521910681495893','Sasw213123','13681181726','120222199110046411','1526891068','1526891114','2019-05-21','0.01',1,2,NULL,2,'46',71,'协医健康无忧计划',2,'1.00',1,2),(86,100014,'H521332569218621','XP嘻嘻您','13681181726','120222199110046411','1526833256','1526833260','1558369260','0.01',1,2,NULL,2,'46',71,'协医健康无忧计划',2,'1.00',2,2),(85,100014,'H521330769471619','明明哦','13681181726','120222199110046411','1526833076','1526833184','1558369184','0.01',1,2,NULL,2,'46',71,'协医健康无忧计划',2,'1.00',2,2),(84,100014,'H520236731985939','啊得得得','13681181726','120222199110046411','1526823673','1526823685','1558359685','0.01',1,2,NULL,2,'45',71,'协医健康无忧计划',2,'1.00',2,2),(83,100014,'H520233468399289','1111','13681181726','120222199110046411','1526823346','1526833204','2019-05-21','0.01',1,2,NULL,2,'46',71,'协医健康无忧计划',2,'1.00',1,2),(82,100014,'H520233209258897','1111','13681181726','120222199110046411','1526823320','1526823326','1558359326','0.01',1,2,NULL,2,'45',71,'协医健康无忧计划',2,'1.00',2,2),(81,100014,'H520189165588642','一世英名','13681181726','120222199110046411','1526818916','1526821742','1558357742','0.01',1,2,NULL,2,'45',71,'协医健康无忧计划',2,'1.00',2,2),(80,100014,'H520183928817302','来来来','13681181726','120222199110046411','1526818392','1526821858','1558357858','0.01',1,2,NULL,2,'45',71,'协医健康无忧计划',2,'1.00',2,2),(112,100014,'H530676550413222','冬眠','13681181726','120222199110046411','1527667655',NULL,NULL,'0.01',2,2,NULL,2,NULL,71,'协医健康无忧计划',2,'1.00',NULL,2),(79,100014,'H520177890610174','公民','13681181726','120222199110046411','1526817789','1526833227','2019-05-21','0.01',1,2,NULL,2,'46',71,'协医健康无忧计划',2,'1.00',1,2),(113,100014,'H530676605112529','冬眠','13681181726','120222199110046411','1527667660',NULL,NULL,'0.01',2,2,NULL,2,NULL,71,'协医健康无忧计划',2,'1.00',NULL,2),(78,100014,'H520176010682173','明明明明','13681181726','120222199110046411','1526817601','1526817604','1558353604','0.01',1,2,NULL,2,'45',71,'协医健康无忧计划',2,'1.00',2,2),(77,100014,'H520175397771803','哦公民','13681181726','120222199110046411','1526817539','1526817543','1558353543','0.01',1,2,NULL,2,'45',71,'协医健康无忧计划',2,'1.00',2,2),(76,100014,'H520173665079950','明年','13681181726','120222199110046411','1526817366','1526817761','1558353761','0.01',1,2,NULL,2,'45',71,'协医健康无忧计划',2,'1.00',2,2);

/*Table structure for table `hl_pics` */

DROP TABLE IF EXISTS `hl_pics`;

CREATE TABLE `hl_pics` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '图库表id',
  `pic_name` varchar(100) DEFAULT NULL COMMENT '图片上传前名',
  `pic_files` varchar(100) DEFAULT NULL COMMENT '图片上传后名子',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `hl_pics` */

/*Table structure for table `hl_picture` */

DROP TABLE IF EXISTS `hl_picture`;

CREATE TABLE `hl_picture` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '图片id',
  `picname` varchar(32) NOT NULL COMMENT '图片名',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `hl_picture` */

/*Table structure for table `hl_prefect_information` */

DROP TABLE IF EXISTS `hl_prefect_information`;

CREATE TABLE `hl_prefect_information` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL COMMENT '所属用户id',
  `name` varchar(50) DEFAULT NULL COMMENT '姓名',
  `phone` varchar(20) DEFAULT NULL COMMENT '手机号',
  `id_card` varchar(30) DEFAULT NULL COMMENT '身份证号',
  `insurance_id` int(11) DEFAULT NULL COMMENT '保险id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `hl_prefect_information` */

insert  into `hl_prefect_information`(`id`,`uid`,`name`,`phone`,`id_card`,`insurance_id`) values (7,100008,'123','13681181726','120222199110046411',71);

/*Table structure for table `hl_role` */

DROP TABLE IF EXISTS `hl_role`;

CREATE TABLE `hl_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '角色id',
  `name` varchar(10) NOT NULL COMMENT '角色名称',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `hl_role` */

/*Table structure for table `hl_slide` */

DROP TABLE IF EXISTS `hl_slide`;

CREATE TABLE `hl_slide` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '轮播图id',
  `name` varchar(100) NOT NULL COMMENT '图片名',
  `pic` varchar(100) NOT NULL COMMENT '上传后文件名',
  `link` text COMMENT '链接',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1禁用、0开启',
  `starttime` datetime NOT NULL COMMENT '起始时间',
  `endtime` datetime NOT NULL COMMENT '结束时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `hl_slide` */

/*Table structure for table `hl_steps` */

DROP TABLE IF EXISTS `hl_steps`;

CREATE TABLE `hl_steps` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `uid` int(11) NOT NULL COMMENT '用户ID',
  `steps` mediumint(7) DEFAULT '0' COMMENT '今日步数',
  `rank` varchar(10) DEFAULT '' COMMENT '今日排行',
  `life` decimal(15,2) DEFAULT '0.00' COMMENT '奖励',
  `createtime` datetime NOT NULL COMMENT '创建时间',
  `firstuid` int(11) DEFAULT '0' COMMENT '每日排行第一的用户ID',
  `endtime` datetime DEFAULT NULL COMMENT '结算时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`) USING BTREE,
  KEY `createtime` (`createtime`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=100132 DEFAULT CHARSET=utf8;

/*Data for the table `hl_steps` */

insert  into `hl_steps`(`id`,`uid`,`steps`,`rank`,`life`,`createtime`,`firstuid`,`endtime`) values (100003,100001,4547,'1','0.00','2018-04-24 00:00:00',100001,'2018-04-25 22:00:00'),(100004,100002,4547,'2','0.00','2018-04-24 00:00:00',100001,'2018-04-25 22:00:00'),(100005,100002,3394,'4','0.00','2018-04-25 00:00:00',100004,'2018-04-25 22:00:00'),(100006,100001,4222,'2','0.00','2018-04-25 00:00:00',100004,'2018-04-25 22:00:00'),(100007,100003,3394,'5','0.00','2018-04-25 00:00:00',100004,'2018-04-25 22:00:00'),(100008,100004,7356,'1','120.68','2018-04-25 00:00:00',100004,'2018-04-25 22:00:00'),(100009,100005,4222,'3','0.00','2018-04-25 00:00:00',100004,'2018-04-25 22:00:00'),(100010,100001,4594,'3','0.00','2018-04-26 00:00:00',100004,'2018-04-26 22:00:00'),(100011,100004,9781,'1','193.43','2018-04-26 00:00:00',100004,'2018-04-26 22:00:00'),(100012,100006,4594,'4','0.00','2018-04-26 00:00:00',100004,'2018-04-26 22:00:00'),(100013,100005,4594,'5','0.00','2018-04-26 00:00:00',100004,'2018-04-26 22:00:00'),(100014,100007,4594,'6','0.00','2018-04-26 00:00:00',100004,'2018-04-26 22:00:00'),(100015,100008,6555,'2','96.65','2018-04-26 00:00:00',100004,'2018-04-26 22:00:00'),(100016,100009,2330,'7','0.00','2018-04-26 00:00:00',100004,'2018-04-26 22:00:00'),(100017,100004,4450,'2','0.00','2018-04-27 00:00:00',100008,'2018-04-27 22:00:01'),(100018,100009,2734,'3','0.00','2018-04-27 00:00:00',100008,'2018-04-27 22:00:01'),(100019,100008,8862,'1','165.86','2018-04-27 00:00:00',100008,'2018-04-27 22:00:01'),(100020,100004,8775,'1','163.25','2018-04-28 00:00:00',100004,'2018-04-28 22:00:01'),(100021,100009,7977,'2','139.31','2018-04-28 00:00:00',100004,'2018-04-28 22:00:01'),(100022,100008,2922,'4','0.00','2018-04-28 00:00:00',100004,'2018-04-28 22:00:01'),(100023,100010,2331,'5','0.00','2018-04-28 00:00:00',100004,'2018-04-28 22:00:01'),(100024,100011,4232,'3','0.00','2018-04-28 00:00:00',100004,'2018-04-28 22:00:01'),(100025,100010,3940,'1','0.00','2018-04-29 00:00:00',100010,'2018-04-29 22:00:01'),(100026,100004,1477,'2','0.00','2018-04-29 00:00:00',100010,'2018-04-29 22:00:01'),(100027,100009,268,'3','0.00','2018-04-29 00:00:00',100010,'2018-04-29 22:00:01'),(100028,100009,21669,'1','500.00','2018-04-30 00:00:00',100009,'2018-04-30 22:00:01'),(100029,100004,9270,'3','178.10','2018-04-30 00:00:00',100009,'2018-04-30 22:00:01'),(100030,100010,11009,'2','230.27','2018-04-30 00:00:00',100009,'2018-04-30 22:00:01'),(100031,100010,6114,'2','83.42','2018-05-01 00:00:00',100009,'2018-05-01 22:00:01'),(100032,100004,706,'3','0.00','2018-05-01 00:00:00',100009,'2018-05-01 22:00:01'),(100033,100009,14359,'1','330.77','2018-05-01 00:00:00',100009,'2018-05-01 22:00:01'),(100034,100009,657,'','0.00','2018-05-02 00:00:00',0,NULL),(100035,100004,4961,'','0.00','2018-05-02 00:00:00',0,NULL),(100036,100010,1907,'','0.00','2018-05-02 00:00:00',0,NULL),(100037,100011,5500,'','65.00','2018-05-02 00:00:00',0,NULL),(100038,100004,6645,'','99.35','2018-05-03 00:00:00',0,NULL),(100039,100010,9160,'','174.80','2018-05-03 00:00:00',0,NULL),(100040,100011,4142,'','0.00','2018-05-03 00:00:00',0,NULL),(100041,100010,3246,'','0.00','2018-05-04 00:00:00',0,NULL),(100042,100004,4688,'','0.00','2018-05-04 00:00:00',0,NULL),(100043,100011,3946,'','0.00','2018-05-04 00:00:00',0,NULL),(100044,100010,10452,'','213.56','2018-05-05 00:00:00',0,NULL),(100045,100004,114,'','0.00','2018-05-06 00:00:00',0,NULL),(100046,100011,737,'','0.00','2018-05-06 00:00:00',0,NULL),(100047,100008,737,'','0.00','2018-05-06 00:00:00',0,NULL),(100048,100010,8917,'','167.51','2018-05-06 00:00:00',0,NULL),(100049,100008,4517,'','0.00','2018-05-07 00:00:00',0,NULL),(100050,100010,3896,'','0.00','2018-05-07 00:00:00',0,NULL),(100051,100004,6312,'','89.36','2018-05-07 00:00:00',0,NULL),(100052,100010,17,'','0.00','2018-05-08 00:00:00',0,NULL),(100053,100004,5659,'','69.77','2018-05-08 00:00:00',0,NULL),(100054,100008,8270,'','148.10','2018-05-08 00:00:00',0,NULL),(100055,100010,7517,'1','125.51','2018-05-09 00:00:00',100010,'2018-05-09 15:22:47'),(100056,100008,3704,'2','0.00','2018-05-09 00:00:00',100010,'2018-05-09 15:22:47'),(100057,100004,5841,'3','75.23','2018-05-09 00:00:00',100010,'2018-05-09 15:22:47'),(100058,100010,3438,'','0.00','2018-05-10 00:00:00',0,NULL),(100059,100008,8559,'','156.77','2018-05-10 00:00:00',0,NULL),(100060,100004,7546,'','126.38','2018-05-10 00:00:00',0,NULL),(100061,100011,3719,'','0.00','2018-05-10 00:00:00',0,NULL),(100062,100008,4230,'','0.00','2018-05-11 00:00:00',0,NULL),(100063,100010,4873,'','0.00','2018-05-11 00:00:00',0,NULL),(100064,100004,4357,'','0.00','2018-05-11 00:00:00',0,NULL),(100065,100008,0,'','0.00','2018-05-12 00:00:00',0,NULL),(100066,100004,4728,'','0.00','2018-05-12 00:00:00',0,NULL),(100067,100008,5645,'','69.35','2018-05-13 00:00:00',0,NULL),(100068,100008,5645,'','69.35','2018-05-13 00:00:00',0,NULL),(100069,100008,5645,'','69.35','2018-05-13 00:00:00',0,NULL),(100070,100008,6598,'','97.94','2018-05-14 00:00:00',0,NULL),(100071,100004,4337,'','0.00','2018-05-15 00:00:00',0,NULL),(100072,100008,3473,'','0.00','2018-05-15 00:00:00',0,NULL),(100073,100008,4684,'','0.00','2018-05-16 00:00:00',0,NULL),(100074,100014,4684,'','0.00','2018-05-16 00:00:00',0,NULL),(100075,100014,13839,'1','315.17','2018-05-17 00:00:00',100014,'2018-05-17 22:00:01'),(100076,100014,6531,'1','95.93','2018-05-18 00:00:00',100014,'2018-05-18 22:00:01'),(100077,100010,507,'','0.00','2018-05-18 00:00:00',0,NULL),(100078,100014,1129,'','0.00','2018-05-20 00:00:00',0,NULL),(100079,100014,7912,'1','137.36','2018-05-21 00:00:00',100014,'2018-05-21 22:00:02'),(100080,100004,3292,'','0.00','2018-05-21 00:00:00',0,NULL),(100081,100010,5424,'2','62.72','2018-05-21 00:00:00',100014,'2018-05-21 22:00:02'),(100082,100014,3352,'','0.00','2018-05-22 00:00:00',0,NULL),(100083,100020,1492,'','0.00','2018-05-22 00:00:00',0,NULL),(100084,100004,2794,'','0.00','2018-05-22 00:00:00',0,NULL),(100085,100014,7371,'2','121.13','2018-05-23 00:00:00',100010,'2018-05-23 22:00:01'),(100086,100004,6318,'3','89.54','2018-05-23 00:00:00',100010,'2018-05-23 22:00:01'),(100087,100010,8194,'1','145.82','2018-05-23 00:00:00',100010,'2018-05-23 22:00:01'),(100088,100014,7998,'1','139.94','2018-05-24 00:00:00',100014,'2018-05-24 22:00:01'),(100089,100010,1638,'','0.00','2018-05-24 00:00:00',0,NULL),(100090,100004,2828,'','0.00','2018-05-24 00:00:00',0,NULL),(100091,100010,2244,'','0.00','2018-05-25 00:00:00',0,NULL),(100092,100014,2866,'','0.00','2018-05-25 00:00:00',0,NULL),(100093,100004,5724,'1','71.72','2018-05-25 00:00:00',100004,'2018-05-25 22:00:02'),(100094,100010,3669,'','0.00','2018-05-27 00:00:00',0,NULL),(100095,100004,4234,'','0.00','2018-05-28 00:00:00',0,NULL),(100096,100014,5540,'1','66.20','2018-05-28 00:00:00',100014,'2018-05-28 22:00:01'),(100097,100004,4932,'','0.00','2018-05-29 00:00:00',0,NULL),(100098,100014,4293,'','0.00','2018-05-29 00:00:00',0,NULL),(100099,100004,4216,'','0.00','2018-05-30 00:00:00',0,NULL),(100100,100014,8240,'1','147.20','2018-05-30 00:00:00',100014,'2018-05-30 22:00:02'),(100101,100021,782,'','0.00','2018-05-30 00:00:00',0,NULL),(100102,100004,2807,'','0.00','2018-05-31 00:00:00',0,NULL),(100103,100014,2604,'','0.00','2018-05-31 00:00:00',0,NULL),(100104,100004,4043,'','0.00','2018-06-01 00:00:00',0,NULL),(100105,100004,4043,'','0.00','2018-06-01 00:00:00',0,NULL),(100106,100010,6905,'1','107.15','2018-06-01 00:00:00',100010,'2018-06-01 22:00:02'),(100107,100010,10768,'1','223.04','2018-06-02 00:00:00',100010,'2018-06-02 22:00:01'),(100108,100014,817,'','0.00','2018-06-02 00:00:00',0,NULL),(100109,100010,8914,'1','167.42','2018-06-03 00:00:00',100010,'2018-06-03 22:00:01'),(100110,100004,7438,'1','123.14','2018-06-04 00:00:00',100004,'2018-06-04 22:00:01'),(100111,100004,5191,'1','55.73','2018-06-05 00:00:00',100004,'2018-06-05 22:00:01'),(100112,100004,6111,'1','83.33','2018-06-06 00:00:00',100004,'2018-06-06 22:00:01'),(100113,100014,2707,'','0.00','2018-06-07 00:00:00',0,NULL),(100114,100004,7187,'1','115.61','2018-06-07 00:00:00',100004,'2018-06-07 22:00:01'),(100115,100010,11072,'1','232.16','2018-06-08 00:00:00',100010,'2018-06-08 22:00:02'),(100116,100004,8240,'2','147.20','2018-06-08 00:00:00',100010,'2018-06-08 22:00:02'),(100117,100010,7326,'1','119.78','2018-06-09 00:00:00',100010,'2018-06-09 22:00:01'),(100118,100010,10370,'1','211.10','2018-06-10 00:00:00',100010,'2018-06-10 22:00:01'),(100119,100010,2321,'','0.00','2018-06-11 00:00:00',0,NULL),(100120,100013,2450,'','0.00','2018-06-14 00:00:00',0,NULL),(100121,100010,0,'','0.00','2018-06-15 00:00:00',0,NULL),(100122,100010,563,'','0.00','2018-06-17 00:00:00',0,NULL),(100123,100010,1786,'','0.00','2018-06-20 00:00:00',0,NULL),(100124,100004,91,'','0.00','2018-06-22 00:00:00',0,NULL),(100125,100013,2305,'','0.00','2018-06-22 00:00:00',0,NULL),(100126,100004,7463,'1','123.89','2018-06-27 00:00:00',100004,'2018-06-27 22:00:02'),(100127,100010,2086,'','0.00','2018-06-27 00:00:00',0,NULL),(100128,100010,10340,'1','210.20','2018-06-29 00:00:00',100010,'2018-06-29 22:00:02'),(100129,100010,9950,'1','198.50','2018-06-30 00:00:00',100010,'2018-06-30 22:00:01'),(100130,100010,323,'','0.00','2018-07-03 00:00:00',0,NULL),(100131,100004,194,'','0.00','2018-07-03 00:00:00',0,NULL);

/*Table structure for table `hl_third_party` */

DROP TABLE IF EXISTS `hl_third_party`;

CREATE TABLE `hl_third_party` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `type` tinyint(1) NOT NULL COMMENT '登陆类型 0:QQ 1:微信 2:微博',
  `uid` int(11) NOT NULL COMMENT '用户ID',
  `openid` varchar(100) NOT NULL COMMENT '用户唯一标识',
  `nickname` varchar(30) DEFAULT NULL COMMENT '用户昵称',
  `province` varchar(10) DEFAULT NULL COMMENT '用户省份',
  `city` varchar(10) DEFAULT NULL COMMENT '用户城市',
  `country` varchar(10) DEFAULT NULL COMMENT '用户国家',
  `createtime` datetime NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `hl_third_party` */

/*Table structure for table `hl_user` */

DROP TABLE IF EXISTS `hl_user`;

CREATE TABLE `hl_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户主键ID',
  `phone` varchar(20) NOT NULL COMMENT '用户手机号',
  `pwd` char(32) DEFAULT '' COMMENT '用户密码',
  `name` varchar(20) NOT NULL COMMENT '用户昵称',
  `age` varchar(5) DEFAULT '0' COMMENT '年龄',
  `sex` tinyint(1) DEFAULT '1' COMMENT '0:女 1:男',
  `headpic` varchar(255) NOT NULL COMMENT '用户头像',
  `thumbpic` varchar(255) NOT NULL COMMENT '头像缩略图',
  `life` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT '积分life',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '用户状态 0为禁用、1正常',
  `createtime` datetime NOT NULL COMMENT '创建时间',
  `lis` decimal(15,3) NOT NULL DEFAULT '0.000' COMMENT '积分lis',
  `area_code` varchar(5) DEFAULT NULL COMMENT '区号',
  `invitation_code` varchar(32) DEFAULT NULL COMMENT '邀请码',
  PRIMARY KEY (`id`),
  UNIQUE KEY `phone` (`phone`) USING BTREE,
  KEY `phone_2` (`phone`,`pwd`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=100022 DEFAULT CHARSET=utf8;

/*Data for the table `hl_user` */

insert  into `hl_user`(`id`,`phone`,`pwd`,`name`,`age`,`sex`,`headpic`,`thumbpic`,`life`,`status`,`createtime`,`lis`,`area_code`,`invitation_code`) values (100010,'18510158065','0194013792b1e54be2aebc74f1b307b7','青竹','0',1,'file/headpic/2018-04-28/5ae3d7adc2ff1.png','file/headpic/2018-04-28/thumb_5ae3d7adc2ff1.png','2341.60',1,'2018-04-28 10:06:59','234.260','86','JuzeIiDq'),(100009,'18574141757','10adaac583eeb865b893ef1519d32306','杨秀川','0',1,'file/headpic/2018-04-26/5ae1879902cf1.png','file/headpic/2018-04-26/thumb_5ae1879902cf1.png','1070.08',1,'2018-04-26 16:01:37','107.008','86','gGb3jizy'),(100004,'15120039961','b294510259a5980763d808f34ef87c2e','Bo ','0',1,'file/headpic/2018-05-21/5b0277213d419.png','file/headpic/2018-05-21/thumb_5b0277213d419.png','1464.62',1,'2018-04-25 15:44:31','146.562','86','Q3cFG9Nf'),(100005,'18020482932','21218cca77804d2ba1922c33e0151105','yhb_5trBJh2vqiRKFXF','0',1,'default.jpg','default.jpg','100.00',1,'2018-04-25 18:58:07','10.000','86','udk2mOih'),(100012,'18801408110','e10adc3949ba59abbe56e057f20f883e','哈哈哈','0',1,'file/headpic/2018-05-03/5aea6fd46bc82.png','file/headpic/2018-05-03/thumb_5aea6fd46bc82.png','100.00',1,'2018-04-28 12:08:08','10.000','86','uZND7c1O'),(100014,'18816207584','21218cca77804d2ba1922c33e0151105','宝宝心里苦把','0',1,'file/headpic/2018-05-30/5b0e22542f839.png','file/headpic/2018-05-30/thumb_5b0e22542f839.png','15945.59',1,'2018-05-16 21:18:40','112.293','86','WmWFHyMs'),(100013,'13681181726','21218cca77804d2ba1922c33e0151105','76767673433','0',1,'file/headpic/2018-05-18/5afeace795eac.png','file/headpic/2018-05-18/thumb_5afeace795eac.png','96.00',1,'2018-05-16 20:52:07','10.000','86','lFkfCTNe'),(100020,'13717879033','25d55ad283aa400af464c76d713c07ad','jkg_6LIbnuZ2','0',1,'default.jpg','default.jpg','100.00',1,'2018-05-22 11:20:26','10.000','86','HbJP7Dly'),(100019,'13641096928','','jkg_pioVRv6AhHGAH0mH','0',1,'default.jpg','default.jpg','50.00',1,'2018-05-20 19:49:27','10.000','86','E1lDmhII'),(100021,'18601258011','e3ea7789c1c3a4df63fb301f76e23a03','jkg_vyKX9yR86HmgxWR','0',1,'default.jpg','default.jpg','100.00',1,'2018-05-30 11:32:33','10.000','86','LZ8eadpM');

/*Table structure for table `hl_version` */

DROP TABLE IF EXISTS `hl_version`;

CREATE TABLE `hl_version` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'APK版本表id',
  `version_code` varchar(20) NOT NULL COMMENT 'APK版本号',
  `version_des` text NOT NULL COMMENT '添加记录',
  `version_route` varchar(150) NOT NULL COMMENT '版本路径',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '版本发布时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='APK版本更新表';

/*Data for the table `hl_version` */

/*Table structure for table `hl_vido` */

DROP TABLE IF EXISTS `hl_vido`;

CREATE TABLE `hl_vido` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '视频id',
  `name` varchar(100) DEFAULT NULL COMMENT '视频名称',
  `vido_name` varchar(100) DEFAULT NULL COMMENT '视频文件名',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '上传时间',
  `introduce` text COMMENT '介绍',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `hl_vido` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
