
-- ===============================================================
-- Full schema for SmartNursingPlatform (MySQL 8.x compatible)
-- Generated 2025‑05‑02
-- Includes core tables + default seed data (roles & permissions)
-- ===============================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS=0;

-- ----------
-- branches
-- ----------
DROP TABLE IF EXISTS `branches`;
CREATE TABLE `branches` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(191) NOT NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ----------
-- users
-- ----------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(191) NOT NULL,
  `email` VARCHAR(191) NOT NULL UNIQUE,
  `email_verified_at` TIMESTAMP NULL,
  `password` VARCHAR(191) NOT NULL,
  `type` ENUM(','supervisor','user') DEFAULT 'user',
  `branch_id` BIGINT UNSIGNED NULL,
  `is_ TINYINT(1) DEFAULT 0,
  `remember_token` VARCHAR(100) NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  `deleted_at` TIMESTAMP NULL,
  CONSTRAINT `users_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------
-- Spatie laravel-permission tables
-- ---------------------------------------------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(191) NOT NULL,
  `guard_name` VARCHAR(191) NOT NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  UNIQUE KEY `roles_name_guard_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(191) NOT NULL,
  `guard_name` VARCHAR(191) NOT NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  UNIQUE KEY `permissions_name_guard_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE `role_has_permissions` (
  `permission_id` BIGINT UNSIGNED NOT NULL,
  `role_id` BIGINT UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  CONSTRAINT `rh_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions`(`id`) ON DELETE CASCADE,
  CONSTRAINT `rh_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE `model_has_permissions` (
  `permission_id` BIGINT UNSIGNED NOT NULL,
  `model_type` VARCHAR(191) NOT NULL,
  `model_id` BIGINT UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  INDEX `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `mhp_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE `model_has_roles` (
  `role_id` BIGINT UNSIGNED NOT NULL,
  `model_type` VARCHAR(191) NOT NULL,
  `model_id` BIGINT UNSIGNED NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  INDEX `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `mhr_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------
-- events
-- ----------
DROP TABLE IF EXISTS `events`;
CREATE TABLE `events` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `branch_id` BIGINT UNSIGNED NULL,
  `event_type` VARCHAR(120) NOT NULL,
  `event_title` VARCHAR(255) NOT NULL,
  `event_datetime` DATETIME NOT NULL,
  `location` VARCHAR(255) NOT NULL,
  `lecturers` VARCHAR(255) NULL,
  `attendance` INT UNSIGNED NULL,
  `duration` INT UNSIGNED NULL,
  `description` TEXT NULL,
  `planned` TINYINT(1) DEFAULT 0,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  `deleted_at` TIMESTAMP NULL,
  CONSTRAINT `events_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches`(`id`) ON DELETE SET NULL,
  INDEX `events_branch_id_index` (`branch_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------
-- campaigns
-- ----------
DROP TABLE IF EXISTS `campaigns`;
CREATE TABLE `campaigns` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `branch_id` BIGINT UNSIGNED NULL,
  `campaign_type` VARCHAR(120) NOT NULL,
  `campaign_title` VARCHAR(255) NOT NULL,
  `campaign_datetime` DATETIME NOT NULL,
  `location` VARCHAR(255) NOT NULL,
  `audience` INT UNSIGNED NULL,
  `description` TEXT NULL,
  `planned` TINYINT(1) DEFAULT 0,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  `deleted_at` TIMESTAMP NULL,
  CONSTRAINT `campaigns_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches`(`id`) ON DELETE SET NULL,
  INDEX `campaigns_branch_id_index` (`branch_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------
-- researches
-- ----------
DROP TABLE IF EXISTS `researches`;
CREATE TABLE `researches` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `branch_id` BIGINT UNSIGNED NULL,
  `research_title` VARCHAR(255) NOT NULL,
  `research_type` VARCHAR(120) NOT NULL,
  `start_date` DATE NOT NULL,
  `end_date` DATE NULL,
  `status` VARCHAR(60) NOT NULL,
  `description` TEXT NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  `deleted_at` TIMESTAMP NULL,
  CONSTRAINT `researches_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches`(`id`) ON DELETE SET NULL,
  INDEX `researches_branch_id_index` (`branch_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------
-- attachments
-- ----------
DROP TABLE IF EXISTS `attachments`;
CREATE TABLE `attachments` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `path` VARCHAR(255) NOT NULL,
  `attachable_id` BIGINT UNSIGNED NOT NULL,
  `attachable_type` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  INDEX `attachments_attachable_index` (`attachable_id`,`attachable_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------
-- migrations (optional, for artisan migrate tracking)
-- ----------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `migration` VARCHAR(191) NOT NULL,
  `batch` INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------
-- Seed data: branches (sample), roles, permissions, pivot tables
-- ---------------------------------------------------------------
INSERT INTO `branches` (`name`,`created_at`,`updated_at`) VALUES
('فرع تمريض البالغين', NOW(), NOW()),
('فرع تمريض الأطفال', NOW(), NOW());

-- roles
INSERT INTO `roles` (`name`,`guard_name`,`created_at`,`updated_at`) VALUES
(','web',NOW(),NOW()),
('employee','web',NOW(),NOW());

-- permissions
INSERT INTO `permissions` (`name`,`guard_name`,`created_at`,`updated_at`) VALUES
('manage_users','web',NOW(),NOW()),
('manage_events','web',NOW(),NOW()),
('manage_campaigns','web',NOW(),NOW()),
('manage_researches','web',NOW(),NOW());

-- role_has_permissions (gets all)
INSERT INTO `role_has_permissions` (`role_id`,`permission_id`)
SELECT (SELECT id FROM roles WHERE name='),
       id FROM permissions;

-- employee role gets subset
INSERT INTO `role_has_permissions` (`role_id`,`permission_id`)
SELECT (SELECT id FROM roles WHERE name='employee'),
       id FROM permissions WHERE name IN ('manage_events','manage_campaigns');

SET FOREIGN_KEY_CHECKS=1;
