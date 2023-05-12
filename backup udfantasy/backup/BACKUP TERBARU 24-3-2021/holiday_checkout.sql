/*
 Navicat Premium Data Transfer

 Source Server         : redsystemdevelopment
 Source Server Type    : MySQL
 Source Server Version : 50564
 Source Host           : 159.65.132.116:3306
 Source Schema         : ud_fantasy

 Target Server Type    : MySQL
 Target Server Version : 50564
 File Encoding         : 65001

 Date: 24/03/2021 13:53:30
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for holiday_checkout
-- ----------------------------
DROP TABLE IF EXISTS `holiday_checkout`;
CREATE TABLE `holiday_checkout`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_start` date NULL DEFAULT NULL,
  `date_finish` date NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of holiday_checkout
-- ----------------------------
INSERT INTO `holiday_checkout` VALUES (2, '2021-03-24', '2021-03-25');
INSERT INTO `holiday_checkout` VALUES (3, '2021-03-24', '2021-03-26');
INSERT INTO `holiday_checkout` VALUES (4, '2021-03-21', '2021-03-25');
INSERT INTO `holiday_checkout` VALUES (10, '2021-04-01', '2021-04-05');
INSERT INTO `holiday_checkout` VALUES (11, '2021-03-28', '2021-03-30');

SET FOREIGN_KEY_CHECKS = 1;
