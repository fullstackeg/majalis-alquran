CREATE TABLE `tadabbur_likes` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` BIGINT UNSIGNED NOT NULL,
  `tadabbur_id` BIGINT UNSIGNED NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tadabbur_likes_user_id_tadabbur_id_unique` (`user_id`, `tadabbur_id`),
  CONSTRAINT `tadabbur_likes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tadabbur_likes_tadabbur_id_foreign` FOREIGN KEY (`tadabbur_id`) REFERENCES `tadabburat` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- 1. إضافة عمود الـ slug إلى جدول المجالس
ALTER TABLE `majalis` ADD `slug` VARCHAR(255) NULL AFTER `title`;

-- 2. جعل حقل الـ slug فريداً لضمان عدم التكرار والأمان
ALTER TABLE `majalis` ADD UNIQUE (`slug`);

-- 3. تحديث السجلات القديمة الموجودة مسبقاً بقيم عشوائية آمنة لكي لا تظهر فارغة
-- (يمكنك تنفيذ هذا السطر إذا كان لديك بيانات قديمة في الجدول)
UPDATE `majalis` SET `slug` = SUBSTRING(MD5(RAND()) FROM 1 FOR 10) WHERE `slug` IS NULL;


-- 1. إضافة عمود user_id لربط المجلس بالمستخدم الذي أنشأه
-- 1. إضافة العمود وجعله يقبل القيمة الفارغة (NULL) مؤقتاً لتجنب خطأ السجلات القديمة
ALTER TABLE `majalis` 
ADD COLUMN `user_id` BIGINT UNSIGNED NULL AFTER `id`;

-- 2. (اختياري) إذا كنت تريد تعيين مشرف افتراضي (مثل المستخدم صاحب ID رقم 1) لجميع المجالس القديمة
UPDATE `majalis` SET `user_id` = 1 WHERE `user_id` IS NULL;

-- 3. الآن بعد أن أصبحت كل الصفوف تحتوي على user_id صالح، يمكنك جعله إجبارياً (NOT NULL)
ALTER TABLE `majalis` 
MODIFY COLUMN `user_id` BIGINT UNSIGNED NOT NULL;

-- 4. إضافة قيد المفتاح الأجنبي (Foreign Key) بنجاح تام بدون أخطاء
ALTER TABLE `majalis` 
ADD CONSTRAINT `majalis_user_id_foreign` 
FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;


CREATE TABLE `majlis_histories` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `majlis_id` BIGINT UNSIGNED NOT NULL,
  `user_id` BIGINT UNSIGNED NOT NULL, -- الشخص الذي أجرى التعديل
  `action` VARCHAR(50) NOT NULL, -- نوع الإجراء مثل: created, updated, description_changed
  `old_content` TEXT NULL, -- المحتوى القديم أو ملخص التغيير
  `new_content` TEXT NULL, -- المحتوى الجديد
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT `majlis_histories_majlis_id_foreign` FOREIGN KEY (`majlis_id`) REFERENCES `majalis` (`id`) ON DELETE CASCADE,
  CONSTRAINT `majlis_histories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;