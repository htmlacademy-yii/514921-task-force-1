-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `mydb` ;

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`categories`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`categories` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `ico` VARCHAR(255) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `mydb`.`cities`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`cities` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `coordinates` POINT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `mydb`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(255) NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `city_id` INT NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `date_add` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `role` VARCHAR(45) NULL DEFAULT 'customer',
  PRIMARY KEY (`id`),
  INDEX `cityid_idx` (`city_id` ASC) VISIBLE,
  CONSTRAINT `city_id`
    FOREIGN KEY (`city_id`)
    REFERENCES `mydb`.`cities` (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `mydb`.`messages`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`messages` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `message` TEXT NULL,
  PRIMARY KEY (`id`),
  INDEX `user_id_idx` (`user_id` ASC) VISIBLE,
  CONSTRAINT `fk_messages_users`
    FOREIGN KEY (`user_id`)
    REFERENCES `mydb`.`users` (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `mydb`.`profiles`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`profiles` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `city_id` INT NULL,
  `address` VARCHAR(255) NULL,
  `birthday` DATE NULL,
  `about` TEXT NULL,
  `phone_number` VARCHAR(45) NULL,
  `skype` VARCHAR(45) NULL,
  PRIMARY KEY (`id`, `user_id`),
  INDEX `city_id_idx` (`city_id` ASC) VISIBLE,
  INDEX `fk_profiles_users1_idx` (`user_id` ASC) VISIBLE,
  CONSTRAINT `fk_profiles_cities`
    FOREIGN KEY (`city_id`)
    REFERENCES `mydb`.`cities` (`id`),
  CONSTRAINT `fk_profiles_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `mydb`.`users` (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `mydb`.`tasks`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`tasks` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `description` TEXT NOT NULL,
  `category_id` INT NOT NULL,
  `attachments` LONGBLOB NULL,
  `city_id` INT NULL,
  `budget` DECIMAL(10,0) NULL,
  `date_expire` TIMESTAMP NULL,
  `date_add` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `coordinates` POINT NULL,
  `address` VARCHAR(255) NULL,
  `status` TEXT NULL,
  PRIMARY KEY (`id`),
  INDEX `id_category_idx` (`category_id` ASC) VISIBLE,
  INDEX `FK_task_cities_idx` (`city_id` ASC) VISIBLE,
  CONSTRAINT `category_id`
    FOREIGN KEY (`category_id`)
    REFERENCES `mydb`.`categories` (`id`),
  CONSTRAINT `FK_task_cities`
    FOREIGN KEY (`city_id`)
    REFERENCES `mydb`.`cities` (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `mydb`.`replies`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`replies` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `task_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `description` TEXT NULL,
  `rating` INT NULL,
  `date_add` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `name_id_idx` (`user_id` ASC) VISIBLE,
  INDEX `task_id_idx` (`task_id` ASC) VISIBLE,
  CONSTRAINT `fk_replies_users`
    FOREIGN KEY (`user_id`)
    REFERENCES `mydb`.`users` (`id`),
  CONSTRAINT `task_id`
    FOREIGN KEY (`task_id`)
    REFERENCES `mydb`.`tasks` (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `mydb`.`reviews`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`reviews` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `rating` INT NOT NULL,
  `review` TEXT NULL,
  `date_add` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `name_id_idx` (`user_id` ASC) VISIBLE,
  CONSTRAINT `fk_reviews_user`
    FOREIGN KEY (`user_id`)
    REFERENCES `mydb`.`users` (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
