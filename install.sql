CREATE TABLE `nodes` (
	`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`parent_id` INT(11) UNSIGNED NOT NULL DEFAULT '0',
	`deleted` INT(1) UNSIGNED NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`),
	INDEX `parent_id` (`parent_id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
