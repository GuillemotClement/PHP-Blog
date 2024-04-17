CREATE TABLE `blog`.`article` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `category` VARCHAR(45) NOT NULL,
  `content` LONGTEXT NOT NULL,
  `picture` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE);


ALTER TABLE `blog`.`article`
ADD COLUMN `author` INT NULL AFTER `category`;

