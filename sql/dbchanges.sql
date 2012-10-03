/*
Navicat MySQL Data Transfer

Source Server         : Localhost
Source Server Version : 50525
Source Host           : 127.0.0.1:3306
Source Database       : ownhp

Target Server Type    : MYSQL
Target Server Version : 50525
File Encoding         : 65001

Date: 2012-09-19 20:03:08
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `bookmark`
-- ----------------------------
DROP TABLE IF EXISTS `bookmark`;
CREATE TABLE `bookmark` (
  `bookmark_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('ACTIVE','INACTIVE') COLLATE utf8_unicode_ci DEFAULT 'ACTIVE',
  `is_default` enum('YES','NO') COLLATE utf8_unicode_ci DEFAULT 'NO',
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `last_updated_at` datetime DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`bookmark_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of bookmark
-- ----------------------------
INSERT INTO `bookmark` VALUES ('1', 'Google', 'http://www.google.com', 'ACTIVE', 'YES', '2012-09-15 19:09:01', '1', '2012-09-15 19:09:04', '1');
INSERT INTO `bookmark` VALUES ('2', 'Yahoo', 'http://www.yahoo.com', 'ACTIVE', 'YES', '2012-09-15 19:09:19', '1', '2012-09-15 19:09:22', '1');
INSERT INTO `bookmark` VALUES ('3', 'Twitter', 'http://www.twitter.com', 'ACTIVE', 'YES', '2012-09-15 19:09:39', '1', '2012-09-15 19:09:48', '1');
INSERT INTO `bookmark` VALUES ('4', 'Facebook', 'http://www.facebook.com', 'ACTIVE', 'YES', '2012-09-15 21:47:37', '1', '2012-09-15 21:47:39', '1');
INSERT INTO `bookmark` VALUES ('5', 'Picasa', 'http://www.picasa.com', 'ACTIVE', 'YES', '2012-09-15 21:48:18', '1', '2012-09-15 21:48:22', '1');

-- ----------------------------
-- Table structure for `icon`
-- ----------------------------
DROP TABLE IF EXISTS `icon`;
CREATE TABLE `icon` (
  `icon_id` int(11) NOT NULL AUTO_INCREMENT,
  `bookmark_id` int(11) NOT NULL,
  `path` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') COLLATE utf8_unicode_ci DEFAULT 'ACTIVE',
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `last_updated_at` datetime DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`icon_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of icon
-- ----------------------------
INSERT INTO `icon` VALUES ('1', '1', 'resources/icons/default_google.com.png', 'ACTIVE', '2012-09-16 22:57:18', '1', '2012-09-16 22:57:22', '1');
INSERT INTO `icon` VALUES ('2', '2', 'resources/icons/default_yahoo.com.png', 'ACTIVE', '2012-09-16 23:01:31', '1', '2012-09-16 23:01:35', '1');
INSERT INTO `icon` VALUES ('3', '3', 'resources/icons/default_twitter.com.png', 'ACTIVE', '2012-09-16 23:02:09', '1', '2012-09-16 23:02:13', '1');
INSERT INTO `icon` VALUES ('4', '4', 'resources/icons/default_facebook.com.png', 'ACTIVE', '2012-09-16 23:02:53', '1', '2012-09-16 23:02:56', '1');
INSERT INTO `icon` VALUES ('5', '5', 'resources/icons/default_picasa.com.png', 'ACTIVE', '2012-09-16 23:03:50', '1', '2012-09-16 23:03:54', '1');

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `twitter_id` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `facebook_id` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `role` enum('ADMINISTRATOR','USER') COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') COLLATE utf8_unicode_ci DEFAULT 'ACTIVE',
  `created_at` datetime DEFAULT NULL,
  `last_updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'tirthbodawala', 'aks@123', null, null, 'ADMINISTRATOR', 'ACTIVE', '2012-09-18 17:26:17', '2012-09-18 17:26:19');
INSERT INTO `user` VALUES ('2', 'dharmesh', 'aks@123', null, null, 'USER', 'ACTIVE', '2012-09-18 17:26:43', '2012-09-18 17:26:46');
INSERT INTO `user` VALUES ('3', 'ajaypatel', 'aks@123', null, null, 'USER', 'ACTIVE', '2012-09-18 17:27:05', '2012-09-18 17:27:07');

-- ----------------------------
-- Table structure for `user_details`
-- ----------------------------
DROP TABLE IF EXISTS `user_details`;
CREATE TABLE `user_details` (
  `user_details_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `twitter_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `facebook_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `profile_picture` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` enum('MALE','FEMALE') COLLATE utf8_unicode_ci DEFAULT 'MALE',
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `last_updated_at` datetime DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`user_details_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of user_details
-- ----------------------------
INSERT INTO `user_details` VALUES ('1', 'Tirth Bodawala', 'tirthbodawala@yahoo.co.in', null, null, 'resources/profile_picture/default.png', 'MALE', '2012-09-18 17:45:08', '1', '2012-09-18 17:45:10', '1');
INSERT INTO `user_details` VALUES ('2', 'Dharmesh Patel', 'dharmesh@aksystems-inc.com', null, null, 'resources/profile_picture/default.png', 'MALE', '2012-09-18 17:45:43', '2', '2012-09-18 17:45:46', '1');
INSERT INTO `user_details` VALUES ('3', 'Ajay Patel', 'ajay.patel@aksystems-inc.com', null, null, 'resources/profile_picture/default.png', 'MALE', '2012-09-18 17:46:30', '3', '2012-09-18 17:46:37', '3');
