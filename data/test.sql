/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50612
Source Host           : localhost:3306
Source Database       : test

Target Server Type    : MYSQL
Target Server Version : 50612
File Encoding         : 65001

Date: 2017-11-28 13:36:31
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for k_account
-- ----------------------------
DROP TABLE IF EXISTS `k_account`;
CREATE TABLE `k_account` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) CHARACTER SET utf8 DEFAULT NULL,
  `password` varchar(64) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of k_account
-- ----------------------------
INSERT INTO `k_account` VALUES ('1', 'yankuan', '123456');
INSERT INTO `k_account` VALUES ('2', 'yankuan2', '123456');

-- ----------------------------
-- Table structure for k_getdata
-- ----------------------------
DROP TABLE IF EXISTS `k_getdata`;
CREATE TABLE `k_getdata` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `data` text CHARACTER SET utf8,
  `data_url` varchar(255) CHARACTER SET utf8 NOT NULL,
  `response_data` text CHARACTER SET utf8,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of k_getdata
-- ----------------------------
INSERT INTO `k_getdata` VALUES ('1', '{\"m\":\"1\"}', '/kite/api.php?m=1', null);
INSERT INTO `k_getdata` VALUES ('2', '{\"m\":\"1\"}', '/kite/api.php?m=1', null);
INSERT INTO `k_getdata` VALUES ('3', '{\"m\":\"1\"}', '/kite/api.php?m=1', null);
INSERT INTO `k_getdata` VALUES ('4', '{\"m\":\"1\"}', '/kite/api.php?m=1', null);
INSERT INTO `k_getdata` VALUES ('5', '{\"m\":\"1\"}', '/kite/api.php?m=1', null);
INSERT INTO `k_getdata` VALUES ('6', '{\"m\":\"1\"}', '/kite/api.php?m=1', null);
INSERT INTO `k_getdata` VALUES ('7', '{\"m\":\"1\"}', '/kite/api.php?m=1', null);
INSERT INTO `k_getdata` VALUES ('8', '{\"m\":\"1\"}', '/kite/api.php?m=1', null);
