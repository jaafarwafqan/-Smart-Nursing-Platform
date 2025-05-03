-- =====================================================
-- Patch SQL for Smart Nursing Platform
-- Adjusts schema to match refactored Laravel project
-- Run after backing up your current database.
-- =====================================================

SET FOREIGN_KEY_CHECKS=0;

-- 1. Rename 'researches' table to 'researches'
DROP TABLE IF EXISTS `researches`;
RENAME TABLE `researches` TO `researches`;

-- 2. Standardize columns in 'researches'
ALTER TABLE `researches`
  CHANGE `title` `research_title` VARCHAR(255) NOT NULL,
  CHANGE `type` `research_type` VARCHAR(120) NOT NULL,
  CHANGE `start_date` `start_date` DATE NOT NULL,
  CHANGE `end_date` `end_date` DATE NULL,
  CHANGE `status` `status` VARCHAR(60) NOT NULL,
  ADD COLUMN `description` TEXT NULL AFTER `status`,
  ADD COLUMN `branch_id` BIGINT UNSIGNED NULL AFTER `id`,
  ADD COLUMN `deleted_at` TIMESTAMP NULL AFTER `updated_at`;

-- 3. Tidy up 'campaigns' table
ALTER TABLE `campaigns`
  CHANGE `title` `campaign_title` VARCHAR(255) NOT NULL,
  CHANGE `status` `campaign_type` VARCHAR(120) NOT NULL,
  CHANGE `start_date` `campaign_datetime` DATETIME NOT NULL,
  DROP COLUMN `branch`,
  ADD COLUMN `branch_id` BIGINT UNSIGNED NULL AFTER `id`,
  ADD COLUMN `planned` TINYINT(1) NOT NULL DEFAULT 0 AFTER `description`,
  ADD COLUMN `deleted_at` TIMESTAMP NULL AFTER `updated_at`;

-- 4. Remove JSON 'attachments' columns (now handled via separate table)
ALTER TABLE `events`   DROP COLUMN `attachments`;
ALTER TABLE `campaigns` DROP COLUMN `attachments`;
ALTER TABLE `researches` DROP COLUMN `attachments`;

-- 5. Create new 'attachments' table
CREATE TABLE IF NOT EXISTS `attachments` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `path` VARCHAR(255) NOT NULL,
  `attachable_id` BIGINT UNSIGNED NOT NULL,
  `attachable_type` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. Drop obsolete tables
DROP TABLE IF EXISTS `campaign_participants`,
                     `research_comments`,
                     `research_fields`,
                     `research_stages`,
                     `research_proposals`,
                     `research_proposal_reviewer`,
                     `research_ratings`;

SET FOREIGN_KEY_CHECKS=1;
