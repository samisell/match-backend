-- Match Backend Database Dump
-- Generated on 2026-02-13 03:18:33

SET FOREIGN_KEY_CHECKS=0;

-- Table structure for table `failed_jobs` --
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `failed_jobs` --

-- Table structure for table `messages` --
DROP TABLE IF EXISTS `messages`;
CREATE TABLE `messages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `sent_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `messages_user_id_foreign` (`user_id`),
  CONSTRAINT `messages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `messages` --

-- Table structure for table `migrations` --
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `migrations` --
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('1', '2014_10_12_000000_create_users_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('2', '2014_10_12_100000_create_password_reset_tokens_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('3', '2019_08_19_000000_create_failed_jobs_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('4', '2019_12_14_000001_create_personal_access_tokens_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('5', '2026_02_10_004139_create_user_photos_table', '2');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('6', '2026_02_10_004221_create_user_preferences_table', '2');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('7', '2026_02_10_004317_create_user_matches_table', '2');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('8', '2026_02_10_004329_create_messages_table', '2');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('9', '2026_02_10_011343_add_is_admin_to_users_table', '3');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('10', '2026_02_10_015933_add_matched_status_to_users_table', '4');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('11', '2026_02_10_020928_create_tags_table', '5');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('12', '2026_02_10_021010_create_taggables_table', '5');

-- Table structure for table `password_reset_tokens` --
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `password_reset_tokens` --

-- Table structure for table `personal_access_tokens` --
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `personal_access_tokens` --

-- Table structure for table `taggables` --
DROP TABLE IF EXISTS `taggables`;
CREATE TABLE `taggables` (
  `tag_id` bigint(20) unsigned NOT NULL,
  `taggable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `taggable_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  UNIQUE KEY `taggables_tag_id_taggable_id_taggable_type_unique` (`tag_id`,`taggable_id`,`taggable_type`),
  KEY `taggables_taggable_type_taggable_id_index` (`taggable_type`,`taggable_id`),
  CONSTRAINT `taggables_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `taggables` --

-- Table structure for table `tags` --
DROP TABLE IF EXISTS `tags`;
CREATE TABLE `tags` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tags_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `tags` --

-- Table structure for table `user_matches` --
DROP TABLE IF EXISTS `user_matches`;
CREATE TABLE `user_matches` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `matched_user_id` bigint(20) unsigned NOT NULL,
  `status` enum('proposed','accepted','declined') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'proposed',
  `matchmaker_note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `matched_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_matches_user_id_foreign` (`user_id`),
  KEY `user_matches_matched_user_id_foreign` (`matched_user_id`),
  CONSTRAINT `user_matches_matched_user_id_foreign` FOREIGN KEY (`matched_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_matches_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `user_matches` --

-- Table structure for table `user_photos` --
DROP TABLE IF EXISTS `user_photos`;
CREATE TABLE `user_photos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `caption` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_primary` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_photos_user_id_foreign` (`user_id`),
  CONSTRAINT `user_photos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `user_photos` --

-- Table structure for table `user_preferences` --
DROP TABLE IF EXISTS `user_preferences`;
CREATE TABLE `user_preferences` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `age_min` int(11) NOT NULL,
  `age_max` int(11) NOT NULL,
  `location_radius_km` int(11) NOT NULL,
  `desired_interests` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`desired_interests`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_preferences_user_id_foreign` (`user_id`),
  CONSTRAINT `user_preferences_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `user_preferences` --

-- Table structure for table `users` --
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `age` int(11) DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `occupation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `education` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quote` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_summary` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `interests` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`interests`)),
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `matched` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `users` --
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `age`, `location`, `occupation`, `education`, `quote`, `profile_summary`, `interests`, `remember_token`, `created_at`, `updated_at`, `is_admin`, `matched`) VALUES ('1', 'Admin', 'info@venihost.com.ng', NULL, '$2y$12$l1RU.nf6XSAXUq6/uQ3WvO7Rxb0XDMS8VVy.Ch4yE8eJkykkJoNNe', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-10 01:25:10', '2026-02-10 01:25:10', '1', '0');

SET FOREIGN_KEY_CHECKS=1;
