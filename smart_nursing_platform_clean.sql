-- phpMySQL Dump
-- version 5.2.1
-- https://www.phpmynet/
--
-- Host: 127.0.0.1
-- Generation Time: 01 مايو 2025 الساعة 21:24
-- إصدار الخادم: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smart_nursing_platform`
--

-- --------------------------------------------------------

--
-- بنية الجدول `branches`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2025_04_22_180000_create_branches_table', 1),
(2, '2025_04_22_180001_create_users_table', 1),
(3, '2025_04_22_180002_create_campaigns_table', 1),
(4, '2025_04_22_180002_create_research_fields_table', 1),
(5, '2025_04_22_180002_create_research_stages_table', 1),
(6, '2025_04_22_180003_create_campaign_participants_table', 1),
(7, '2025_04_22_180003_create_events_table', 1),
(8, '2025_04_22_180004_create_research_table', 1),
(9, '2025_04_22_180006_create_research_proposals_table', 1),
(10, '2025_04_22_180007_create_research_comments_table', 1),
(11, '2025_04_22_180008_create_research_proposal_reviewer_table', 1),
(12, '2025_04_22_180009_create_cache_table', 1),
(13, '2025_04_22_180010_create_permission_tables', 1),
(14, '2025_04_22_180011_create_sessions_table', 1),
(15, '2025_04_23_000001_create_research_ratings_table', 1),
(16, '2025_04_23_044535_add_branch_id_to_roles_table', 1),
(17, '2025_04_24_172129_create_jobs_table', 1),
(18, '2025_04_29_100315_add_group_to_permissions_table', 1),
(19, '2025_05_01_160628_add_branch_to_users_table', 1),
(20, '2025_05_01_162359_add_description_to_research_proposals_table', 1),
(21, '2025_05_01_162814_add_fields_to_research_proposals_table', 1),
(22, '2025_05_01_163233_make_research_id_nullable_in_research_proposals', 1),
(23, '2025_05_01_163651_make_abstract_nullable_in_research_proposals', 1),
(24, '2025_05_01_164515_add_branch_id_to_events_table', 1);

-- --------------------------------------------------------

--
-- بنية الجدول `model_has_permissions`
--

CREATE TABLE `branches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `branches`
--

INSERT INTO `branches` (`id`, `name`, `created_at`, `updated_at`) VALUES
(3, 'فرع تمريض البالغين', '2025-05-01 19:22:00', '2025-05-01 19:22:00'),
(4, 'فرع أساسيات التمريض', '2025-05-01 19:22:00', '2025-05-01 19:22:00'),
(5, 'فرع صحة الأم والوليد', '2025-05-01 19:22:00', '2025-05-01 19:22:00'),
(6, 'فرع صحة المجتمع', '2025-05-01 19:22:00', '2025-05-01 19:22:00'),
(7, 'فرع تمريض الأطفال', '2025-05-01 19:22:00', '2025-05-01 19:22:00'),
(8, 'فرع تمريض الصحة النفسية', '2025-05-01 19:22:00', '2025-05-01 19:22:00'),
(9, 'فرع العلوم الأساسية', '2025-05-01 19:22:00', '2025-05-01 19:22:00'),
(10, 'نشاطات طلابية', '2025-05-01 19:22:00', '2025-05-01 19:22:00'),
(11, 'برنامج حكومي', '2025-05-01 19:22:00', '2025-05-01 19:22:00'),
(12, 'التعليم المستمر', '2025-05-01 19:22:00', '2025-05-01 19:22:00'),
(13, 'العلمية', '2025-05-01 19:22:00', '2025-05-01 19:22:00'),
(14, 'الإرشاد النفسي', '2025-05-01 19:22:00', '2025-05-01 19:22:00'),
(15, 'التأهيل والتوظيف', '2025-05-01 19:22:00', '2025-05-01 19:22:00'),
(16, 'شؤون المرأة', '2025-05-01 19:22:00', '2025-05-01 19:22:00'),
(17, 'حقوق الإنسان', '2025-05-01 19:22:00', '2025-05-01 19:22:00'),
(18, 'الدراسات العليا', '2025-05-01 19:22:00', '2025-05-01 19:22:00');

-- --------------------------------------------------------

--
-- بنية الجدول `cache`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `type` enum(','professor','student','supervisor') NOT NULL DEFAULT 'student',
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_ tinyint(1) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `branch` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `type`, `branch_id`, `is_, `remember_token`, `created_at`, `updated_at`, `branch`) VALUES
(1, 'مدير النظام', 'jaafar1@jaafar1.com', NULL, '$2y$12$NULYrtu/rt3UIp7Ko3FCwuYKOhIOppgl1lRBtAeGGOXdRHYwqvsja', ', NULL, 1, NULL, '2025-05-01 19:22:00', '2025-05-01 19:22:00', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `branches_name_unique` (`name`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `campaigns`
--
ALTER TABLE `campaigns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `campaign_participants`
--
ALTER TABLE `campaign_participants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `campaign_participants_campaign_id_user_id_unique` (`campaign_id`,`user_id`),
  ADD KEY `campaign_participants_user_id_foreign` (`user_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `researches`
--
ALTER TABLE `researches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `research_researcher_id_foreign` (`researcher_id`),
  ADD KEY `research_supervisor_id_foreign` (`supervisor_id`),
  ADD KEY `research_field_id_foreign` (`field_id`),
  ADD KEY `research_stage_id_foreign` (`stage_id`);

--
-- Indexes for table `research_comments`
--
ALTER TABLE `research_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `research_comments_proposal_id_foreign` (`proposal_id`),
  ADD KEY `research_comments_user_id_foreign` (`user_id`);

--
-- Indexes for table `research_fields`
--
ALTER TABLE `research_fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `research_proposals`
--
ALTER TABLE `research_proposals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `research_proposals_research_id_foreign` (`research_id`);

--
-- Indexes for table `research_proposal_reviewer`
--
ALTER TABLE `research_proposal_reviewer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `research_proposal_reviewer_proposal_id_foreign` (`proposal_id`),
  ADD KEY `research_proposal_reviewer_reviewer_id_foreign` (`reviewer_id`);

--
-- Indexes for table `research_ratings`
--
ALTER TABLE `research_ratings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `research_ratings_research_id_user_id_unique` (`research_id`,`user_id`),
  ADD KEY `research_ratings_user_id_foreign` (`user_id`);

--
-- Indexes for table `research_stages`
--
ALTER TABLE `research_stages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `research_stages_name_unique` (`name`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`),
  ADD KEY `roles_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_branch_id_foreign` (`branch_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `campaigns`
--
ALTER TABLE `campaigns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `campaign_participants`
--
ALTER TABLE `campaign_participants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `researches`
--
ALTER TABLE `researches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `research_comments`
--
ALTER TABLE `research_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `research_fields`
--
ALTER TABLE `research_fields`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `research_proposals`
--
ALTER TABLE `research_proposals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `research_proposal_reviewer`
--
ALTER TABLE `research_proposal_reviewer`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `research_ratings`
--
ALTER TABLE `research_ratings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `research_stages`
--
ALTER TABLE `research_stages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- قيود الجداول المُلقاة.
--

--
-- قيود الجداول `campaign_participants`
--
ALTER TABLE `campaign_participants`
  ADD CONSTRAINT `campaign_participants_campaign_id_foreign` FOREIGN KEY (`campaign_id`) REFERENCES `campaigns` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `campaign_participants_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- قيود الجداول `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- قيود الجداول `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- قيود الجداول `researches`
--
ALTER TABLE `researches`
  ADD CONSTRAINT `research_field_id_foreign` FOREIGN KEY (`field_id`) REFERENCES `research_fields` (`id`),
  ADD CONSTRAINT `research_researcher_id_foreign` FOREIGN KEY (`researcher_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `research_stage_id_foreign` FOREIGN KEY (`stage_id`) REFERENCES `research_stages` (`id`),
  ADD CONSTRAINT `research_supervisor_id_foreign` FOREIGN KEY (`supervisor_id`) REFERENCES `users` (`id`);

--
-- قيود الجداول `research_comments`
--
ALTER TABLE `research_comments`
  ADD CONSTRAINT `research_comments_proposal_id_foreign` FOREIGN KEY (`proposal_id`) REFERENCES `research_proposals` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `research_comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- قيود الجداول `research_proposals`
--
ALTER TABLE `research_proposals`
  ADD CONSTRAINT `research_proposals_research_id_foreign` FOREIGN KEY (`research_id`) REFERENCES `researches` (`id`) ON DELETE CASCADE;

--
-- قيود الجداول `research_proposal_reviewer`
--
ALTER TABLE `research_proposal_reviewer`
  ADD CONSTRAINT `research_proposal_reviewer_proposal_id_foreign` FOREIGN KEY (`proposal_id`) REFERENCES `research_proposals` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `research_proposal_reviewer_reviewer_id_foreign` FOREIGN KEY (`reviewer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- قيود الجداول `research_ratings`
--
ALTER TABLE `research_ratings`
  ADD CONSTRAINT `research_ratings_research_id_foreign` FOREIGN KEY (`research_id`) REFERENCES `researches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `research_ratings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- قيود الجداول `roles`
--
ALTER TABLE `roles`
  ADD CONSTRAINT `roles_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE;

--
-- قيود الجداول `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- قيود الجداول `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`, `branch_id`) VALUES
(26, ', 'web', '2025-05-01 19:21:59', '2025-05-01 19:21:59', NULL),
(27, 'professor', 'web', '2025-05-01 19:21:59', '2025-05-01 19:21:59', NULL),
(28, 'student', 'web', '2025-05-01 19:21:59', '2025-05-01 19:21:59', NULL),
(29, 'supervisor', 'web', '2025-05-01 19:21:59', '2025-05-01 19:21:59', NULL),
(30, 'user', 'web', '2025-05-01 19:21:59', '2025-05-01 19:21:59', NULL);

-- --------------------------------------------------------

--
-- بنية الجدول `role_has_permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `group` varchar(255) DEFAULT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `group`, `guard_name`, `created_at`, `updated_at`) VALUES
(21, 'view_campaigns', NULL, 'web', '2025-05-01 19:21:59', '2025-05-01 19:21:59'),
(22, 'create_campaigns', NULL, 'web', '2025-05-01 19:21:59', '2025-05-01 19:21:59'),
(23, 'edit_campaigns', NULL, 'web', '2025-05-01 19:21:59', '2025-05-01 19:21:59'),
(24, 'delete_campaigns', NULL, 'web', '2025-05-01 19:21:59', '2025-05-01 19:21:59'),
(25, 'export_campaigns', NULL, 'web', '2025-05-01 19:21:59', '2025-05-01 19:21:59'),
(26, 'manage_campaigns', NULL, 'web', '2025-05-01 19:21:59', '2025-05-01 19:21:59'),
(27, 'view_events', NULL, 'web', '2025-05-01 19:21:59', '2025-05-01 19:21:59'),
(28, 'create_events', NULL, 'web', '2025-05-01 19:21:59', '2025-05-01 19:21:59'),
(29, 'edit_events', NULL, 'web', '2025-05-01 19:21:59', '2025-05-01 19:21:59'),
(30, 'delete_events', NULL, 'web', '2025-05-01 19:21:59', '2025-05-01 19:21:59'),
(31, 'export_events', NULL, 'web', '2025-05-01 19:21:59', '2025-05-01 19:21:59'),
(32, 'manage_events', NULL, 'web', '2025-05-01 19:21:59', '2025-05-01 19:21:59'),
(33, 'view_proposals', NULL, 'web', '2025-05-01 19:21:59', '2025-05-01 19:21:59'),
(34, 'create_proposals', NULL, 'web', '2025-05-01 19:21:59', '2025-05-01 19:21:59'),
(35, 'edit_proposals', NULL, 'web', '2025-05-01 19:21:59', '2025-05-01 19:21:59'),
(36, 'delete_proposals', NULL, 'web', '2025-05-01 19:21:59', '2025-05-01 19:21:59'),
(37, 'export_proposals', NULL, 'web', '2025-05-01 19:21:59', '2025-05-01 19:21:59'),
(38, 'review_proposals', NULL, 'web', '2025-05-01 19:21:59', '2025-05-01 19:21:59'),
(39, 'submit_proposals', NULL, 'web', '2025-05-01 19:21:59', '2025-05-01 19:21:59'),
(40, 'view_users', NULL, 'web', '2025-05-01 19:21:59', '2025-05-01 19:21:59'),
(41, 'create_users', NULL, 'web', '2025-05-01 19:21:59', '2025-05-01 19:21:59'),
(42, 'edit_users', NULL, 'web', '2025-05-01 19:21:59', '2025-05-01 19:21:59'),
(43, 'delete_users', NULL, 'web', '2025-05-01 19:21:59', '2025-05-01 19:21:59'),
(44, 'export_users', NULL, 'web', '2025-05-01 19:21:59', '2025-05-01 19:21:59'),
(45, 'manage_users', NULL, 'web', '2025-05-01 19:21:59', '2025-05-01 19:21:59'),
(46, 'view_roles', NULL, 'web', '2025-05-01 19:21:59', '2025-05-01 19:21:59'),
(47, 'create_roles', NULL, 'web', '2025-05-01 19:21:59', '2025-05-01 19:21:59'),
(48, 'edit_roles', NULL, 'web', '2025-05-01 19:21:59', '2025-05-01 19:21:59'),
(49, 'delete_roles', NULL, 'web', '2025-05-01 19:21:59', '2025-05-01 19:21:59'),
(50, 'export_roles', NULL, 'web', '2025-05-01 19:21:59', '2025-05-01 19:21:59'),
(51, 'view_branches', NULL, 'web', '2025-05-01 19:21:59', '2025-05-01 19:21:59'),
(52, 'create_branches', NULL, 'web', '2025-05-01 19:21:59', '2025-05-01 19:21:59'),
(53, 'edit_branches', NULL, 'web', '2025-05-01 19:21:59', '2025-05-01 19:21:59'),
(54, 'delete_branches', NULL, 'web', '2025-05-01 19:21:59', '2025-05-01 19:21:59'),
(55, 'export_branches', NULL, 'web', '2025-05-01 19:21:59', '2025-05-01 19:21:59'),
(56, 'view_permissions', NULL, 'web', '2025-05-01 19:21:59', '2025-05-01 19:21:59'),
(57, 'create_permissions', NULL, 'web', '2025-05-01 19:21:59', '2025-05-01 19:21:59'),
(58, 'edit_permissions', NULL, 'web', '2025-05-01 19:21:59', '2025-05-01 19:21:59'),
(59, 'delete_permissions', NULL, 'web', '2025-05-01 19:21:59', '2025-05-01 19:21:59'),
(60, 'export_permissions', NULL, 'web', '2025-05-01 19:21:59', '2025-05-01 19:21:59'),
(61, 'view_researches', NULL, 'web', '2025-05-01 19:21:59', '2025-05-01 19:21:59'),
(62, 'create_researches', NULL, 'web', '2025-05-01 19:21:59', '2025-05-01 19:21:59'),
(63, 'edit_researches', NULL, 'web', '2025-05-01 19:21:59', '2025-05-01 19:21:59'),
(64, 'delete_researches', NULL, 'web', '2025-05-01 19:21:59', '2025-05-01 19:21:59'),
(65, 'export_researches', NULL, 'web', '2025-05-01 19:21:59', '2025-05-01 19:21:59'),
(66, 'manage_researches', NULL, 'web', '2025-05-01 19:21:59', '2025-05-01 19:21:59'),
(67, 'review_researches', NULL, 'web', '2025-05-01 19:21:59', '2025-05-01 19:21:59'),
(68, 'submit_researches', NULL, 'web', '2025-05-01 19:21:59', '2025-05-01 19:21:59'),
(69, 'view_reports', NULL, 'web', '2025-05-01 19:21:59', '2025-05-01 19:21:59'),
(70, 'create_reports', NULL, 'web', '2025-05-01 19:21:59', '2025-05-01 19:21:59'),
(71, 'edit_reports', NULL, 'web', '2025-05-01 19:21:59', '2025-05-01 19:21:59'),
(72, 'delete_reports', NULL, 'web', '2025-05-01 19:21:59', '2025-05-01 19:21:59'),
(73, 'export_reports', NULL, 'web', '2025-05-01 19:21:59', '2025-05-01 19:21:59'),
(74, 'manage_reports', NULL, 'web', '2025-05-01 19:21:59', '2025-05-01 19:21:59'),
(75, 'view_dashboard', NULL, 'web', '2025-05-01 19:21:59', '2025-05-01 19:21:59'),
(76, 'view_statistics', NULL, 'web', '2025-05-01 19:21:59', '2025-05-01 19:21:59');

-- --------------------------------------------------------

--
-- بنية الجدول `researches`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(21, 26),
(22, 26),
(23, 26),
(24, 26),
(25, 26),
(26, 26),
(27, 26),
(28, 26),
(29, 26),
(30, 26),
(31, 26),
(32, 26),
(33, 26),
(34, 26),
(35, 26),
(36, 26),
(37, 26),
(38, 26),
(39, 26),
(40, 26),
(41, 26),
(42, 26),
(43, 26),
(44, 26),
(45, 26),
(46, 26),
(47, 26),
(48, 26),
(49, 26),
(50, 26),
(51, 26),
(52, 26),
(53, 26),
(54, 26),
(55, 26),
(56, 26),
(57, 26),
(58, 26),
(59, 26),
(60, 26),
(61, 26),
(62, 26),
(63, 26),
(64, 26),
(65, 26),
(66, 26),
(67, 26),
(68, 26),
(69, 26),
(70, 26),
(71, 26),
(72, 26),
(73, 26),
(74, 26),
(75, 26),
(76, 26);

-- --------------------------------------------------------

--
-- بنية الجدول `sessions`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(26, 'App\\Models\\User', 7);

-- --------------------------------------------------------

--
-- بنية الجدول `permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `model_has_roles`
--

CREATE TABLE `events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_type` varchar(255) NOT NULL,
  `event_title` varchar(255) NOT NULL,
  `event_datetime` datetime NOT NULL,
  `location` varchar(255) NOT NULL,
  `lecturers` varchar(255) DEFAULT NULL,
  `attendance` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `duration` int(10) UNSIGNED NOT NULL,
  `description` text NOT NULL,
  `attachments` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`attachments`)),
  `planned` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `jobs`
--

CREATE TABLE `campaigns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('pending','active','completed') NOT NULL DEFAULT 'pending',
  `branch` varchar(255) NOT NULL,
  `organizers` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`organizers`)),
  `participants_count` int(11) NOT NULL DEFAULT 0,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `attachments` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`attachments`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `campaign_participants`
--

CREATE TABLE `campaign_participants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campaign_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `events`
--

CREATE TABLE `research_fields` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `research_proposals`
--

CREATE TABLE `researches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `researcher_id` bigint(20) UNSIGNED NOT NULL,
  `supervisor_id` bigint(20) UNSIGNED NOT NULL,
  `field_id` bigint(20) UNSIGNED NOT NULL,
  `stage_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('pending','in_progress','completed','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `research_comments`
--

CREATE TABLE `research_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `proposal_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `research_fields`
--

CREATE TABLE `research_stages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `roles`
--

CREATE TABLE `research_proposals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `research_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `abstract` text DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `description` text DEFAULT NULL,
  `field_id` bigint(20) UNSIGNED DEFAULT NULL,
  `researcher_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `research_proposal_reviewer`
--

CREATE TABLE `research_proposal_reviewer` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `proposal_id` bigint(20) UNSIGNED NOT NULL,
  `reviewer_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `research_ratings`
--

CREATE TABLE `research_ratings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `research_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` text DEFAULT NULL,
  `criteria_ratings` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`criteria_ratings`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `research_stages`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `migrations`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `campaigns`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `users`
--

COMMIT;
