CREATE TABLE IF NOT EXISTS `civicrm_mailing_permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `user_group` int(10) unsigned NOT NULL COMMENT 'Logged in user group. FK to civicrm_group',
  `from_address` varchar(1024) COMMENT 'Permitted from addresses',
  `to_groups` varchar(2048) COMMENT 'Permitted mailing recipients groups',
  PRIMARY KEY ( `id` ),
  CONSTRAINT `FK_civicrm_mailing_permissions_group_id` FOREIGN KEY (`user_group`) REFERENCES `civicrm_group` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
