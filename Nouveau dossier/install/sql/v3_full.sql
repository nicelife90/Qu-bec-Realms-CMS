CREATE TABLE `acp_styles` (
  `id`      INT(32) NOT NULL AUTO_INCREMENT,
  `path`    VARCHAR(64)      DEFAULT NULL,
  `install` INT(32)          DEFAULT NULL,
  `active`  INT(32)          DEFAULT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  AUTO_INCREMENT = 1
  DEFAULT CHARSET = utf8mb4
  COLLATE = 'utf8mb4_unicode_ci'
  AUTO_INCREMENT = 1;

INSERT INTO `acp_styles` VALUES (1, 'v3-default', 1, 1);

CREATE TABLE `cart` (
  `id`        INT(32) NOT NULL AUTO_INCREMENT,
  `realm`     INT(32)          DEFAULT NULL,
  `account`   VARCHAR(84)      DEFAULT NULL,
  `character` VARCHAR(84)      DEFAULT NULL,
  `item`      INT(32)          DEFAULT NULL,
  `parent`    INT(32)          DEFAULT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  AUTO_INCREMENT = 1
  DEFAULT CHARSET = utf8mb4
  COLLATE = 'utf8mb4_unicode_ci'
  AUTO_INCREMENT = 1;

CREATE TABLE `clog` (
  `id`     INT(32) NOT NULL AUTO_INCREMENT,
  `title`  VARCHAR(64)      DEFAULT NULL,
  `author` VARCHAR(64)      DEFAULT NULL,
  `body`   LONGTEXT,
  `date`   VARCHAR(32)      DEFAULT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  AUTO_INCREMENT = 1
  DEFAULT CHARSET = utf8mb4
  COLLATE = 'utf8mb4_unicode_ci'
  AUTO_INCREMENT = 1;

INSERT INTO `clog` VALUES (1, 'Test', 'Azer', 'Test Post', 'November 30, 2012');

CREATE TABLE `global` (
  `global_title`     VARCHAR(64) NOT NULL DEFAULT '',
  `email_activation` INT(32)              DEFAULT '0',
  `login`            INT(32)              DEFAULT NULL,
  `copyright`        VARCHAR(64)          DEFAULT NULL,
  `realmlist`        VARCHAR(64)          DEFAULT NULL,
  `server_email`     VARCHAR(64)          DEFAULT NULL,
  `domain`           VARCHAR(64)          DEFAULT NULL,
  `server_title`     VARCHAR(64)          DEFAULT NULL,
  `expansion`        INT(32)              DEFAULT NULL,
  PRIMARY KEY (`global_title`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = 'utf8mb4_unicode_ci';

CREATE TABLE `login_log` (
  `id`       INT(32) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(64)      DEFAULT NULL,
  `ip`       VARCHAR(64)      DEFAULT NULL,
  `date`     VARCHAR(64)      DEFAULT NULL,
  `status`   VARCHAR(32)      DEFAULT NULL,
  `lty`      VARCHAR(32)      DEFAULT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  AUTO_INCREMENT = 1
  DEFAULT CHARSET = utf8mb4
  COLLATE = 'utf8mb4_unicode_ci'
  AUTO_INCREMENT = 1;

CREATE TABLE `messages` (
  `id`          INT(32) NOT NULL AUTO_INCREMENT,
  `title`       VARCHAR(84)      DEFAULT NULL,
  `body`        LONGTEXT,
  `sender`      VARCHAR(64)      DEFAULT NULL,
  `user`        VARCHAR(64)      DEFAULT NULL,
  `date`        VARCHAR(64)      DEFAULT NULL,
  `unread`      INT(32)          DEFAULT '1',
  `inbox_copy`  INT(32)          DEFAULT '1',
  `outbox_copy` INT(32)          DEFAULT '1',
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  AUTO_INCREMENT = 1
  DEFAULT CHARSET = utf8mb4
  COLLATE = 'utf8mb4_unicode_ci'
  AUTO_INCREMENT = 1;

CREATE TABLE `news` (
  `id`     INT(32) NOT NULL AUTO_INCREMENT,
  `title`  VARCHAR(64)      DEFAULT NULL,
  `author` VARCHAR(64)      DEFAULT NULL,
  `body`   LONGTEXT,
  `date`   VARCHAR(32)      DEFAULT NULL,
  `avatar` VARCHAR(150)     DEFAULT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  AUTO_INCREMENT = 1
  DEFAULT CHARSET = utf8mb4
  COLLATE = 'utf8mb4_unicode_ci'
  AUTO_INCREMENT = 1;

INSERT INTO `news` VALUES (1, 'Welcome to WoW CMS V3.0', 'Azer', 'First Post.', 'November 30, 2012', 'a3');

CREATE TABLE `realms` (
  `id`        INT(32) NOT NULL AUTO_INCREMENT,
  `rname`     VARCHAR(84)      DEFAULT NULL,
  `type`      VARCHAR(84)      DEFAULT NULL,
  `oid`       INT(32)          DEFAULT NULL,
  `char_db`   VARCHAR(84)      DEFAULT NULL,
  `port`      INT(32)          DEFAULT NULL,
  `soap_port` INT(32)          DEFAULT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  AUTO_INCREMENT = 1
  DEFAULT CHARSET = utf8mb4
  COLLATE = 'utf8mb4_unicode_ci'
  AUTO_INCREMENT = 1;

CREATE TABLE `shouts` (
  `id`     INT(32) NOT NULL AUTO_INCREMENT,
  `author` VARCHAR(64)      DEFAULT NULL,
  `body`   LONGTEXT,
  `date`   VARCHAR(64)      DEFAULT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  AUTO_INCREMENT = 1
  DEFAULT CHARSET = utf8mb4
  COLLATE = 'utf8mb4_unicode_ci'
  AUTO_INCREMENT = 1;

CREATE TABLE `store_categories` (
  `id`    INT(32) NOT NULL AUTO_INCREMENT,
  `cname` VARCHAR(64)      DEFAULT NULL,
  `oid`   INT(32)          DEFAULT NULL,
  `realm` INT(32)          DEFAULT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  AUTO_INCREMENT = 2
  DEFAULT CHARSET = utf8mb4
  COLLATE = 'utf8mb4_unicode_ci'
  AUTO_INCREMENT = 2;

INSERT INTO `store_categories` VALUES (1, 'Vote Items', 1, 1);
INSERT INTO `store_categories` VALUES (2, 'V.I.P Items', 2, 1);

CREATE TABLE `store_items` (
  `sid`             INT(32) NOT NULL AUTO_INCREMENT,
  `name`            VARCHAR(64)      DEFAULT NULL,
  `display`         VARCHAR(64)      DEFAULT NULL,
  `item`            VARCHAR(128)     DEFAULT NULL,
  `ctype`           INT(32)          DEFAULT NULL,
  `cost`            VARCHAR(32)      DEFAULT NULL,
  `amount`          INT(32)          DEFAULT NULL,
  `parent_category` INT(32)          DEFAULT NULL,
  PRIMARY KEY (`sid`)
)
  ENGINE = InnoDB
  AUTO_INCREMENT = 2
  DEFAULT CHARSET = utf8mb4
  COLLATE = 'utf8mb4_unicode_ci'
  AUTO_INCREMENT = 2;

INSERT INTO `store_items` VALUES (1, 'Hearthstone', '6948', '6948', 1, '0', 1, 1);
INSERT INTO `store_items` VALUES (2, 'Hearthstone', '6948', '6948', 2, '0', 1, 2);

CREATE TABLE `store_log` (
  `id`        INT(32) NOT NULL AUTO_INCREMENT,
  `body`      VARCHAR(84)      DEFAULT NULL,
  `eid`       VARCHAR(64)      DEFAULT NULL,
  `acc_id`    INT(32)          DEFAULT NULL,
  `char_id`   INT(32)          DEFAULT NULL,
  `date`      VARCHAR(84)      DEFAULT NULL,
  `trs_id`    VARCHAR(255)     DEFAULT NULL,
  `prc_items` VARCHAR(255)     DEFAULT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  AUTO_INCREMENT = 1
  DEFAULT CHARSET = utf8mb4
  COLLATE = 'utf8mb4_unicode_ci'
  AUTO_INCREMENT = 1;

CREATE TABLE `styles` (
  `id`      INT(32) NOT NULL AUTO_INCREMENT,
  `path`    VARCHAR(64)      DEFAULT NULL,
  `install` INT(32)          DEFAULT NULL,
  `active`  INT(32)          DEFAULT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  AUTO_INCREMENT = 1
  DEFAULT CHARSET = utf8mb4
  COLLATE = 'utf8mb4_unicode_ci'
  AUTO_INCREMENT = 1;

INSERT INTO `styles` VALUES (1, 'v3-default', 1, 1);

CREATE TABLE `vip_log` (
  `id`   INT(32) NOT NULL AUTO_INCREMENT,
  `body` LONGTEXT,
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  AUTO_INCREMENT = 1
  DEFAULT CHARSET = utf8mb4
  COLLATE = 'utf8mb4_unicode_ci'
  AUTO_INCREMENT = 1;

CREATE TABLE `vote_logs` (
  `id`        INT(32) NOT NULL AUTO_INCREMENT,
  `user`      VARCHAR(84)      DEFAULT NULL,
  `site_name` VARCHAR(64)      DEFAULT NULL,
  `site_id`   INT(32)          DEFAULT NULL,
  `site_cost` VARCHAR(32)      DEFAULT NULL,
  `date`      VARCHAR(84)      DEFAULT NULL,
  `timer`     VARCHAR(64)      DEFAULT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  AUTO_INCREMENT = 1
  DEFAULT CHARSET = utf8mb4
  COLLATE = 'utf8mb4_unicode_ci'
  AUTO_INCREMENT = 1;

CREATE TABLE `vote_sites` (
  `id`        INT(32) NOT NULL AUTO_INCREMENT,
  `site_name` VARCHAR(64)      DEFAULT NULL,
  `site_url`  VARCHAR(84)      DEFAULT NULL,
  `site_img`  VARCHAR(255)     DEFAULT NULL,
  `site_cost` VARCHAR(32)      DEFAULT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  AUTO_INCREMENT = 1
  DEFAULT CHARSET = utf8mb4
  COLLATE = 'utf8mb4_unicode_ci'
  AUTO_INCREMENT = 1;