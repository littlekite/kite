/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50719
Source Host           : localhost:3306
Source Database       : test

Target Server Type    : MYSQL
Target Server Version : 50719
File Encoding         : 65001

Date: 2018-01-19 10:30:39
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for k_account
-- ----------------------------
DROP TABLE IF EXISTS `k_account`;
CREATE TABLE `k_account` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of k_account
-- ----------------------------
INSERT INTO `k_account` VALUES ('1', 'yankuan', '123456');

-- ----------------------------
-- Table structure for k_getdata
-- ----------------------------
DROP TABLE IF EXISTS `k_getdata`;
CREATE TABLE `k_getdata` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `data` varchar(255) NOT NULL,
  `data_url` varchar(255) NOT NULL,
  `response_data` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of k_getdata
-- ----------------------------
INSERT INTO `k_getdata` VALUES ('14', '{\"m\":\"1\"}', '/kite/api.php?m=1', null);
