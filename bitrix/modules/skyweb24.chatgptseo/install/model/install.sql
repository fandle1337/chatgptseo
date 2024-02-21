CREATE TABLE `skyweb24_chatgpt_seo_tasks`
(
    `id`             INT(255)  NOT NULL AUTO_INCREMENT,
    `iblock_id`      INT(255)  NULL     DEFAULT NULL,
    `date_create`    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `date_complete`  TIMESTAMP NULL     DEFAULT NULL,
    `status_id`      INT(255)  NULL     DEFAULT NULL,
    `operation_type` TEXT(255) NULL     DEFAULT NULL,
    `element_type`   TEXT(255) NULL     DEFAULT NULL,
    `incorrect_text` LONGTEXT  NULL     DEFAULT NULL,
    `operations`     LONGTEXT  NULL     DEFAULT NULL,
    PRIMARY KEY (`id`),
    INDEX (`iblock_id`),
    INDEX (`date_create`),
    INDEX (`date_complete`),
    INDEX (`status_id`)
)
    ENGINE = InnoDB;


CREATE TABLE `skyweb24_chatgpt_seo_tasks_elements`
(
    `id`         INT(255) NOT NULL AUTO_INCREMENT,
    `task_id`    INT(255) NULL DEFAULT NULL,
    `element_id` INT(255) NULL DEFAULT NULL,
    `status_id`  INT(255) NULL DEFAULT NULL,
    PRIMARY KEY (id),
    INDEX (task_id),
    INDEX (element_id),
    INDEX (status_id)
)
    ENGINE = InnoDB;




