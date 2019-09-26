/*
 Navicat Premium Data Transfer

 Source Server         : 172.30.167.134
 Source Server Type    : MariaDB
 Source Server Version : 100408
 Source Host           : localhost:3308
 Source Schema         : faces

 Target Server Type    : MariaDB
 Target Server Version : 100408
 File Encoding         : 65001

 Date: 26/09/2019 14:06:38
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

CREATE DATABASE IF NOT EXISTS `faces` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `faces`;

-- ----------------------------
-- Table structure for faces
-- ----------------------------
DROP TABLE IF EXISTS `faces`;
CREATE TABLE `faces`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `regid` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `category` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `gender` enum('male','female') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `picurl` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `picbase64` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `descriptor` varchar(5000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `import_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT current_timestamp,
  `updated_at` datetime(0) NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of faces
-- ----------------------------
INSERT INTO `faces` VALUES (1, 'aaaaa', NULL, 'aaaa', 'male', NULL, NULL, '{\r\n        \"0\": -0.07690539211034775,\r\n        \"1\": 0.07936838269233704,\r\n        \"2\": 0.06676022708415985,\r\n        \"3\": -0.08384646475315094,\r\n        \"4\": -0.18108946084976196,\r\n        \"5\": -0.0225407462567091,\r\n        \"6\": -0.09291422367095947,\r\n        \"7\": -0.022189438343048096,\r\n        \"8\": 0.14969560503959656,\r\n        \"9\": -0.1688993126153946,\r\n        \"10\": 0.22831393778324127,\r\n        \"11\": -0.06144299358129501,\r\n        \"12\": -0.23177950084209442,\r\n        \"13\": 0.0025929841212928295,\r\n        \"14\": -0.14572730660438538,\r\n        \"15\": 0.27991437911987305,\r\n        \"16\": -0.2005247175693512,\r\n        \"17\": -0.16260960698127747,\r\n        \"18\": -0.052495457231998444,\r\n        \"19\": 0.010604050010442734,\r\n        \"20\": 0.09144909679889679,\r\n        \"21\": 0.08277018368244171,\r\n        \"22\": 0.024155069142580032,\r\n        \"23\": 0.07814665138721466,\r\n        \"24\": -0.08192729204893112,\r\n        \"25\": -0.3842282295227051,\r\n        \"26\": -0.01885719783604145,\r\n        \"27\": -0.08257786184549332,\r\n        \"28\": -0.06636829674243927,\r\n        \"29\": -0.11315444111824036,\r\n        \"30\": -0.0121853556483984,\r\n        \"31\": 0.02313724160194397,\r\n        \"32\": -0.18840648233890533,\r\n        \"33\": 0.007952218875288963,\r\n        \"34\": -0.006732631474733353,\r\n        \"35\": 0.09341821074485779,\r\n        \"36\": 0.007352788001298904,\r\n        \"37\": -0.12013441324234009,\r\n        \"38\": 0.15680629014968872,\r\n        \"39\": 0.02530224248766899,\r\n        \"40\": -0.35531309247016907,\r\n        \"41\": 0.08396252989768982,\r\n        \"42\": 0.05806601792573929,\r\n        \"43\": 0.2478409707546234,\r\n        \"44\": 0.15781928598880768,\r\n        \"45\": -0.032885193824768066,\r\n        \"46\": 0.0158994123339653,\r\n        \"47\": -0.14817655086517334,\r\n        \"48\": 0.08448517322540283,\r\n        \"49\": -0.2362804263830185,\r\n        \"50\": 0.02463415451347828,\r\n        \"51\": 0.09684785455465317,\r\n        \"52\": 0.05782246217131615,\r\n        \"53\": 0.015325937420129776,\r\n        \"54\": 0.013237789273262024,\r\n        \"55\": -0.15227481722831726,\r\n        \"56\": 0.05015923082828522,\r\n        \"57\": 0.12583157420158386,\r\n        \"58\": -0.17601469159126282,\r\n        \"59\": -0.021050846204161644,\r\n        \"60\": 0.0712328627705574,\r\n        \"61\": -0.03438586741685867,\r\n        \"62\": 0.05204995721578598,\r\n        \"63\": -0.07364888489246368,\r\n        \"64\": 0.21666839718818665,\r\n        \"65\": 0.061107661575078964,\r\n        \"66\": -0.11703689396381378,\r\n        \"67\": -0.1695479154586792,\r\n        \"68\": 0.11242392659187317,\r\n        \"69\": -0.17377954721450806,\r\n        \"70\": -0.05366223305463791,\r\n        \"71\": 0.1020047664642334,\r\n        \"72\": -0.1228242963552475,\r\n        \"73\": -0.22650685906410217,\r\n        \"74\": -0.31307080388069153,\r\n        \"75\": 0.0409214049577713,\r\n        \"76\": 0.3669692575931549,\r\n        \"77\": 0.12543985247612,\r\n        \"78\": -0.17419742047786713,\r\n        \"79\": 0.07269252836704254,\r\n        \"80\": 0.03846456855535507,\r\n        \"81\": 0.017614945769309998,\r\n        \"82\": 0.09185569733381271,\r\n        \"83\": 0.21042947471141815,\r\n        \"84\": 0.003586404025554657,\r\n        \"85\": 0.07480912655591965,\r\n        \"86\": -0.11396418511867523,\r\n        \"87\": 0.04489276185631752,\r\n        \"88\": 0.20801471173763275,\r\n        \"89\": -0.06778737902641296,\r\n        \"90\": -0.04023304581642151,\r\n        \"91\": 0.2596449851989746,\r\n        \"92\": 0.005083482712507248,\r\n        \"93\": -0.00022554956376552582,\r\n        \"94\": 0.0658441036939621,\r\n        \"95\": 0.07783744484186172,\r\n        \"96\": -0.09268196672201157,\r\n        \"97\": 0.04021037742495537,\r\n        \"98\": -0.15843182802200317,\r\n        \"99\": 0.03370294347405434,\r\n        \"100\": 0.0014978935942053795,\r\n        \"101\": -0.03441543132066727,\r\n        \"102\": -0.06916464120149612,\r\n        \"103\": 0.06578803062438965,\r\n        \"104\": -0.11849353462457657,\r\n        \"105\": 0.05187857896089554,\r\n        \"106\": -0.0881941020488739,\r\n        \"107\": -0.06526165455579758,\r\n        \"108\": -0.052552517503499985,\r\n        \"109\": 0.01863913983106613,\r\n        \"110\": -0.07840922474861145,\r\n        \"111\": -0.07855693995952606,\r\n        \"112\": 0.13909853994846344,\r\n        \"113\": -0.16714328527450562,\r\n        \"114\": 0.19302146136760712,\r\n        \"115\": 0.181906059384346,\r\n        \"116\": 0.09558098018169403,\r\n        \"117\": 0.16523024439811707,\r\n        \"118\": 0.15371397137641907,\r\n        \"119\": 0.0611397922039032,\r\n        \"120\": -0.007856459356844425,\r\n        \"121\": -0.05733422935009003,\r\n        \"122\": -0.18326058983802795,\r\n        \"123\": -0.013289526104927063,\r\n        \"124\": 0.1131211519241333,\r\n        \"125\": -0.06655343621969223,\r\n        \"126\": 0.12981131672859192,\r\n        \"127\": 0.0049875155091285706\r\n    }', NULL, '2019-09-19 10:19:56', '2019-09-19 10:19:56');

-- ----------------------------
-- Table structure for imports
-- ----------------------------
DROP TABLE IF EXISTS `imports`;
CREATE TABLE `imports`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `desc` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `successed` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `unsuccess` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT current_timestamp,
  `updated_at` datetime(0) NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
