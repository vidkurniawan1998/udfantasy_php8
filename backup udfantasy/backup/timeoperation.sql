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

 Date: 18/03/2021 16:57:10
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for timeoperation
-- ----------------------------
DROP TABLE IF EXISTS `timeoperation`;
CREATE TABLE `timeoperation`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hari` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `jam_buka` time NULL DEFAULT NULL,
  `jam_tutup` time NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of timeoperation
-- ----------------------------
INSERT INTO `timeoperation` VALUES (1, 'Monday', '08:00:00', '10:00:00');
INSERT INTO `timeoperation` VALUES (2, 'Tuesday', '08:00:00', '10:00:00');
INSERT INTO `timeoperation` VALUES (3, 'Wednesday', '08:00:00', '18:00:00');
INSERT INTO `timeoperation` VALUES (4, 'Thursday', '08:00:00', '18:00:00');
INSERT INTO `timeoperation` VALUES (5, 'Friday', '08:00:00', '18:00:00');
INSERT INTO `timeoperation` VALUES (6, 'Saturday', '08:00:00', '15:00:00');

SET FOREIGN_KEY_CHECKS = 1;
