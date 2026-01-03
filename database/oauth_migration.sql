-- Update schema untuk support Google OAuth 2.0
-- Tambahkan kolom untuk OAuth authentication

USE usahain_db;

-- Alter table user untuk support OAuth
ALTER TABLE `user` 
  ADD COLUMN `google_id` VARCHAR(255) UNIQUE AFTER `id_user`,
  ADD COLUMN `oauth_provider` ENUM('local', 'google') DEFAULT 'local' AFTER `google_id`,
  ADD COLUMN `avatar_url` VARCHAR(500) AFTER `oauth_provider`,
  MODIFY `password` VARCHAR(255) NULL,
  ADD INDEX `idx_google_id` (`google_id`);

-- Update existing users to have oauth_provider = 'local'
UPDATE `user` SET `oauth_provider` = 'local' WHERE `oauth_provider` IS NULL;
