DROP TABLE IF EXISTS `user_business_unit`;
CREATE TABLE `user_business_unit`
(
	`user_id` INTEGER  NOT NULL,
	`business_unit_id` INTEGER  NOT NULL,
	PRIMARY KEY (`user_id`,`business_unit_id`),
	CONSTRAINT `user_business_unit_FK_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `sf_guard_user` (`id`)
		ON DELETE CASCADE,
	INDEX `user_business_unit_FI_2` (`business_unit_id`),
	CONSTRAINT `user_business_unit_FK_2`
		FOREIGN KEY (`business_unit_id`)
		REFERENCES `business_unit` (`id`)
		ON DELETE CASCADE
)Engine=InnoDB;
ALTER TABLE `sf_guard_user_profile` DROP FOREIGN KEY `sf_guard_user_profile_FK_2` ;
ALTER TABLE `sf_guard_user_profile` DROP COLUMN `business_unit_id` , DROP INDEX `sf_guard_user_profile_FI_2` ;
ALTER TABLE `job` DROP FOREIGN KEY `job_FK_2`;
ALTER TABLE `job` ADD CONSTRAINT `job_FK_2`	FOREIGN KEY (`job_type_id`)	REFERENCES `job_type` (`id`) ON DELETE CASCADE;