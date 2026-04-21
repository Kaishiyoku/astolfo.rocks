/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `image_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `image_tag` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `image_id` bigint(20) unsigned NOT NULL,
  `tag_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `image_tag_image_external_id_foreign` (`image_id`),
  KEY `image_tag_tag_id_foreign` (`tag_id`),
  CONSTRAINT `image_tag_image_id_foreign` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`),
  CONSTRAINT `image_tag_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `images` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(400) DEFAULT NULL,
  `rating` enum('unknown','safe','questionable','explicit') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `views` int(11) NOT NULL DEFAULT 0,
  `source` varchar(382) DEFAULT NULL,
  `file_extension` varchar(255) NOT NULL,
  `mimetype` varchar(255) DEFAULT NULL,
  `file_size` bigint(20) unsigned NOT NULL,
  `width` bigint(20) unsigned NOT NULL,
  `height` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `images_rating_index` (`rating`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(191) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `possible_duplicates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `possible_duplicates` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `image_id_left` bigint(20) unsigned NOT NULL,
  `image_id_right` bigint(20) unsigned NOT NULL,
  `is_false_positive` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `possible_duplicates_image_id_left_foreign` (`image_id_left`),
  KEY `possible_duplicates_image_id_right_foreign` (`image_id_right`),
  CONSTRAINT `possible_duplicates_image_id_left_foreign` FOREIGN KEY (`image_id_left`) REFERENCES `images` (`id`),
  CONSTRAINT `possible_duplicates_image_id_right_foreign` FOREIGN KEY (`image_id_right`) REFERENCES `images` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tags` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(191) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (1,'2014_10_12_000000_create_users_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (2,'2014_10_12_100000_create_password_resets_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (3,'2018_05_13_165545_create_images_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (4,'2018_05_24_084034_add_additional_info_fields_to_images',2);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (5,'2018_05_24_090021_create_tags_table',2);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (6,'2018_05_24_090343_create_image_tag_table',2);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (7,'2018_05_24_091444_drop_tags_from_images_table',2);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (8,'2018_10_31_103718_create_update_logs_table',3);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (9,'2019_07_03_113247_add_email_verified_at_to_users_table',4);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (10,'2019_08_19_000000_create_failed_jobs_table',4);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (11,'2020_12_27_214343_add_mimetype_to_images_table',5);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (12,'2021_08_15_202748_add_identifier_to_images_table',6);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (13,'2021_08_15_202902_generate_image_identifiers',7);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (14,'2021_08_15_215325_create_possible_duplicates_table',7);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (15,'2021_11_04_195550_rename_external_id_at_images_table',8);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (16,'2021_11_04_195735_drop_external_id_unique_key_from_images_table',8);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (17,'2021_11_04_200003_change_type_of_id_at_images_table',8);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (18,'2021_11_04_201018_change_type_of_id_at_image_tag_table',8);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (19,'2021_11_04_201106_change_type_of_id_at_tags_table',8);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (20,'2021_11_04_201127_change_type_of_id_at_update_logs_table',8);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (21,'2021_11_04_201157_change_type_of_id_at_users_table',8);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (22,'2021_11_04_201228_change_type_of_id_at_migrations_table',8);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (23,'2021_11_04_201320_change_type_of_foreign_keys_at_possible_duplicates_table',8);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (24,'2021_11_04_201524_change_type_of_tag_id_foreign_key_at_image_tag_table',8);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (25,'2021_11_04_202844_adjust_rating_at_images_table',8);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (26,'2021_11_05_225552_add_is_admin_to_users_table',8);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (27,'2021_11_06_173931_add_file_extension_to_images_table',9);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (28,'2021_11_06_174136_fill_image_file_extension_fields',9);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (29,'2021_11_06_174140_remove_url_from_images_table',9);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (30,'2021_11_07_134942_add_image_metadata_to_images_table',10);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (31,'2021_11_07_143530_add_is_false_positive_to_possible_duplicates_table',10);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (32,'2021_11_07_183336_remove_non_images',11);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (33,'2021_11_07_175516_regenerate_image_identifiers',10);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (34,'2021_11_07_183336_remove_non_images',10);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (35,'2021_11_16_220300_add_index_to_rating_at_images_table',12);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (36,'2019_12_14_000001_create_personal_access_tokens_table',13);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (37,'2023_03_22_123135_change_identifier_length_at_images_table',14);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (38,'2023_03_22_132236_drop_identifier_image_column_from_images_table',14);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (39,'2023_08_15_000000_add_expires_at_to_personal_access_tokens_table',15);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (40,'2023_08_15_000000_rename_password_resets_table',15);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (41,'2024_02_07_172049_drop_update_logs_table',16);
