/*
 Navicat Premium Data Transfer

 Source Server         : Local
 Source Server Type    : MySQL
 Source Server Version : 100605
 Source Host           : localhost:3306
 Source Schema         : doan1

 Target Server Type    : MySQL
 Target Server Version : 100605
 File Encoding         : 65001

 Date: 07/01/2022 13:31:05
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for phongban
-- ----------------------------
DROP TABLE IF EXISTS `phongban`;
CREATE TABLE `phongban`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `ten` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `mo_ta` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `so_phong` int NULL DEFAULT NULL,
  `manager_id` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of phongban
-- ----------------------------
INSERT INTO `phongban` VALUES (1, 'Covid19', 'Phòng ban covid 19', 7, 5);
INSERT INTO `phongban` VALUES (2, 'Giám đốc', 'Phòng giám đốc', 1, 0);

-- ----------------------------
-- Table structure for tasks
-- ----------------------------
DROP TABLE IF EXISTS `tasks`;
CREATE TABLE `tasks`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `ten` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `mo_ta` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `status` int NULL DEFAULT 0,
  `attachment` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `time` datetime NULL DEFAULT NULL,
  `owner_id` int NULL DEFAULT NULL,
  `assign_id` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tasks
-- ----------------------------
INSERT INTO `tasks` VALUES (1, 'Vinh', 'VInh2\r\nLe Vinh Lvjxn\r\nabcxyz', 3, '[\"uploads\\/-1641531227-Tan-Chau-A-2010-De-3.docx\",\"uploads\\/-1641532558-248346377_1003926860167202_3530818374511318594_n.png\",\"uploads\\/-1641533149-pngtree-character-element-striped-prison-background-image_384788.jpg\",\"uploads\\/-1641535406-Tai_lieu_khong_co_tieu_e.docx\"]', '2022-01-28 10:36:00', 1, 2);
INSERT INTO `tasks` VALUES (2, 'Fix chức năng task', 'tính năng này khá quan trọng                		', 2, '[\"uploads\\/-1641533675-Tan-Chau-A-2010-De-3.docx\"]', '2022-01-08 12:33:00', 1, 4);
INSERT INTO `tasks` VALUES (3, 'Fix chức năng task', 'tính năng này khá quan trọng                		', 0, '[]', '2022-01-08 12:33:00', 1, 3);
INSERT INTO `tasks` VALUES (4, 'Test task', 'chức năng                 		', 0, '[\"uploads\\/-1641533774-248346377_1003926860167202_3530818374511318594_n.png\"]', '2022-01-07 12:40:00', 1, 2);
INSERT INTO `tasks` VALUES (5, 'Task giao việc và nhận việc', '=Task giao việc và nhận việcá', 0, '[\"uploads\\/-1641533847-DE_4-7_COM107_V3.docx\"]', '2022-01-07 12:39:00', 1, 4);

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `role` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `imageurl` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `isFirst` bit(1) NULL DEFAULT b'1',
  `old_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `active` bit(1) NOT NULL DEFAULT b'1',
  `phongban_id` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'vinh8c059', '71b1abb01462f7c3df4e06ff9e49f119', 'Le vinh8c059', 'god', 'uploads/vinh8c059-1641533592-248346377_1003926860167202_3530818374511318594_n.png', b'0', NULL, b'1', NULL);
INSERT INTO `users` VALUES (2, 'vinh8c0592', '71b1abb01462f7c3df4e06ff9e49f119', 'Le vinh8c0592', 'user', '', b'0', NULL, b'1', NULL);
INSERT INTO `users` VALUES (3, 'vinhdeptraj45', '71b1abb01462f7c3df4e06ff9e49f119', 'VinhCB vinhdeptraj45', 'user', '', b'0', NULL, b'1', 0);
INSERT INTO `users` VALUES (4, 'vinhkosd', '71b1abb01462f7c3df4e06ff9e49f119', 'Le vinhkosd', 'user', 'http://pngimg.com/uploads/croissant/small/croissant_PNG2.png', b'0', NULL, b'1', 0);
INSERT INTO `users` VALUES (5, 'vinhdeptrai', '71b1abb01462f7c3df4e06ff9e49f119', 'vinhdeptraitest3', 'admin', '', b'0', NULL, b'0', 1);
INSERT INTO `users` VALUES (6, 'vinh5122', '71b1abb01462f7c3df4e06ff9e49f119', 'Test TK moi', 'user', 'https://vnn-imgs-f.vgcloud.vn/2019/04/02/16/kha-banh-kiem-duoc-bao-nhieu-tien-tu-mang-xa-hoi.jpg', b'0', NULL, b'0', NULL);

SET FOREIGN_KEY_CHECKS = 1;
