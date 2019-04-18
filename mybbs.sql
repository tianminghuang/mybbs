/*
Navicat MySQL Data Transfer

Source Server         : xxoo
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : mybbs

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2019-04-17 15:54:07
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for bbs_cate
-- ----------------------------
DROP TABLE IF EXISTS `bbs_cate`;
CREATE TABLE `bbs_cate` (
  `cid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '板块ID',
  `pid` int(10) unsigned NOT NULL COMMENT '所属分区ID',
  `cname` varchar(255) NOT NULL COMMENT '板块的名称',
  `uid` int(10) unsigned NOT NULL COMMENT '版主的用户ID',
  PRIMARY KEY (`cid`),
  UNIQUE KEY `cname` (`cname`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bbs_cate
-- ----------------------------
INSERT INTO `bbs_cate` VALUES ('1', '3', '我的英雄学院', '1');
INSERT INTO `bbs_cate` VALUES ('2', '1', '武侠', '2');
INSERT INTO `bbs_cate` VALUES ('3', '2', '乒乓球', '2');
INSERT INTO `bbs_cate` VALUES ('4', '4', '流浪地球', '4');
INSERT INTO `bbs_cate` VALUES ('9', '4', '翻滚吧!阿信!', '6');
INSERT INTO `bbs_cate` VALUES ('13', '4', '复仇者联盟4', '5');
INSERT INTO `bbs_cate` VALUES ('14', '3', '一拳超人', '7');
INSERT INTO `bbs_cate` VALUES ('15', '1', '沙赞', '1');
INSERT INTO `bbs_cate` VALUES ('18', '4', '阿丽塔天使', '17');

-- ----------------------------
-- Table structure for bbs_part
-- ----------------------------
DROP TABLE IF EXISTS `bbs_part`;
CREATE TABLE `bbs_part` (
  `pid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '分区ID',
  `pname` varchar(255) NOT NULL COMMENT '分区名称',
  PRIMARY KEY (`pid`),
  UNIQUE KEY `pname` (`pname`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bbs_part
-- ----------------------------
INSERT INTO `bbs_part` VALUES ('2', '体育与健康');
INSERT INTO `bbs_part` VALUES ('3', '动漫');
INSERT INTO `bbs_part` VALUES ('4', '热门电影');
INSERT INTO `bbs_part` VALUES ('1', '科幻电影');

-- ----------------------------
-- Table structure for bbs_post
-- ----------------------------
DROP TABLE IF EXISTS `bbs_post`;
CREATE TABLE `bbs_post` (
  `pid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text,
  `uid` int(10) unsigned NOT NULL,
  `cid` int(10) unsigned NOT NULL,
  `rep_cnt` int(10) unsigned NOT NULL DEFAULT '0',
  `view_cnt` int(10) unsigned NOT NULL DEFAULT '0',
  `is_jing` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `is_top` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `is_display` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `created_at` int(10) unsigned DEFAULT '0',
  `updated_at` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bbs_post
-- ----------------------------
INSERT INTO `bbs_post` VALUES ('4', '彭于晏主演', '中国唯一的几个威胁到我颜值的男人', '4', '9', '0', '2', '0', '0', '1', '1555300748', '1555402104');
INSERT INTO `bbs_post` VALUES ('6', '超牛B的国产科幻大片', '在今年春节上映', '5', '4', '0', '3', '0', '0', '1', '1555402030', '1555402054');
INSERT INTO `bbs_post` VALUES ('7', '2018年霍金逝世', '江湖已不再', '6', '2', '0', '2', '0', '0', '1', '1555402169', '1555402223');
INSERT INTO `bbs_post` VALUES ('8', '他是', '', '9', '10', '0', '2', '1', '0', '1', '1555421200', '1555421215');
INSERT INTO `bbs_post` VALUES ('12', '世界乒乓球大赛', '中国第一', '9', '3', '0', '1', '1', '1', '0', '1555466677', '1555466677');
INSERT INTO `bbs_post` VALUES ('13', '乒乓球王子惊现广州~~', '黄某人在此', '9', '3', '0', '7', '0', '0', '1', '1555466855', '1555486954');
INSERT INTO `bbs_post` VALUES ('14', '出色演技,口碑炸裂', '一部电影,一项技能', '9', '9', '0', '11', '0', '0', '1', '1555467005', '1555467081');
INSERT INTO `bbs_post` VALUES ('15', 'DC英雄', '实力与超人并肩', '9', '15', '0', '2', '0', '0', '1', '1555467454', '1555467454');
INSERT INTO `bbs_post` VALUES ('16', '啥的', '爱是飞洒', '9', '15', '0', '0', '0', '0', '1', '1555467485', '1555467485');
INSERT INTO `bbs_post` VALUES ('17', '一击必杀', '担心反派', '9', '14', '0', '2', '0', '0', '1', '1555467653', '1555467670');

-- ----------------------------
-- Table structure for bbs_reply
-- ----------------------------
DROP TABLE IF EXISTS `bbs_reply`;
CREATE TABLE `bbs_reply` (
  `rid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rcontent` text,
  `uid` int(10) unsigned NOT NULL,
  `pid` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`rid`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bbs_reply
-- ----------------------------
INSERT INTO `bbs_reply` VALUES ('11', '111老爷子最后一部电影啦,一定去看!', '9', '3', '1555401843');
INSERT INTO `bbs_reply` VALUES ('13', '是本帖的创始人', '9', '5', '1555401947');
INSERT INTO `bbs_reply` VALUES ('14', '好看好看!!', '9', '6', '1555402054');
INSERT INTO `bbs_reply` VALUES ('15', '哈哈哈,帖主的脸呢??', '9', '4', '1555402104');
INSERT INTO `bbs_reply` VALUES ('16', '关霍金什么事??', '9', '7', '1555402223');
INSERT INTO `bbs_reply` VALUES ('17', 'dasdasda', '9', '8', '1555421215');
INSERT INTO `bbs_reply` VALUES ('21', '明明可以靠脸,却偏要努力', '9', '14', '1555467066');
INSERT INTO `bbs_reply` VALUES ('22', '牛逼', '9', '14', '1555467081');
INSERT INTO `bbs_reply` VALUES ('23', '哈哈哈哈.心疼', '9', '17', '1555467670');
INSERT INTO `bbs_reply` VALUES ('25', 'aaaaa', '19', '20', '1555486602');
INSERT INTO `bbs_reply` VALUES ('26', '1', '9', '13', '1555486954');

-- ----------------------------
-- Table structure for bbs_user
-- ----------------------------
DROP TABLE IF EXISTS `bbs_user`;
CREATE TABLE `bbs_user` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `uname` varchar(255) NOT NULL COMMENT '用户名称',
  `upwd` char(80) NOT NULL,
  `auth` int(10) unsigned NOT NULL DEFAULT '3' COMMENT '用户权限 1 超级管理员 2 管理员 3\r\n普通会员',
  `uface` varchar(255) DEFAULT NULL,
  `tel` varchar(20) DEFAULT '' COMMENT '手机号码',
  `sex` enum('x','m','w') DEFAULT 'w',
  `created_at` int(10) unsigned DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bbs_user
-- ----------------------------
INSERT INTO `bbs_user` VALUES ('1', '演员s', '$2y$10$6qXACvNEVKA0Dd1hUTfdWO72IH1bX52Vwoxv2PL6iIsvKL9G/AQ4G', '1', 'Public/Uploads/20190417/5cb6d6f38c037.jpg', '', 'm', '1554795374');
INSERT INTO `bbs_user` VALUES ('2', 'htm', '$2y$10$/zcZjN3MNPWcxag6ZHXXZurAd.0f8Ye5jMc.wOsysh1wZZM4WpQgS', '1', 'Public/Uploads/20190416/5cb551bb7d95e.jpg', '', 'm', '1554813372');
INSERT INTO `bbs_user` VALUES ('4', '酒吞童子', '$2y$10$oz9v3pb5i754gLR6bgps5.aQUKnsn1h7y392WRNP0AWgf5FUxSYIu', '3', 'Public/Uploads/20190409/5caca56a0e88a.jpg', '', 'x', '1554818409');
INSERT INTO `bbs_user` VALUES ('5', '许愿鬼切', '$2y$10$ckV5mlvBg0jPP1IhfZUe/OLPvzxMy2lGEB.fVr9pB5Bw5vP4fq4zG', '1', 'Public/Uploads/20190409/5caca5d91c1a7.jpg', '', 'm', '1554818521');
INSERT INTO `bbs_user` VALUES ('6', '彼岸花', '$2y$10$c7NNfNq5aTXw59PtE2HuoOcRxDB/u.k3HI87T9smAvKNLjGA/46Qy', '1', 'Public/Uploads/20190409/5caca6336e484.jpg', '', 'w', '1554818611');
INSERT INTO `bbs_user` VALUES ('7', '茨木', '$2y$10$0D1xBXYIyUi5XYxue4fZ4OtPT8Em2gIEr//63i4vKgunzobOtZGp.', '2', 'Public/Uploads/20190409/5caca74f5d99b.jpg', '', 'm', '1554818895');
INSERT INTO `bbs_user` VALUES ('8', '青行灯', '$2y$10$gk9Y5w4cnwp5Tpnws1sMj.2f57wCue5QW0ARaB8JRX.Ea0OTsU3IC', '3', 'Public/Uploads/20190409/5caca7a403509.jpg', '', 'w', '1554818979');
INSERT INTO `bbs_user` VALUES ('9', 'admin', '$2y$10$BGsdY2BDFKBZyWbJXzFESOow9G4uzItG8bMxuDonRJoKPzuem4c.S', '1', 'Public/Uploads/20190417/5cb6d971ed2a9.jpg', '1123456', 'm', '1555421145');
INSERT INTO `bbs_user` VALUES ('17', 'xxoos', '$2y$10$SGR0rc4Q258xOAnzBRlrkeBJym3VoCKHZbCMdeniGy1MdnAY4r0fW', '1', 'Public/Uploads/20190416/5cb551e42df74.jpg', 'adsasddsadas', 'm', '1555338211');
