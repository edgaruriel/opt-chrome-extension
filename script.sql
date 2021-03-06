-- MySQL Script generated by MySQL Workbench
-- 06/11/15 22:34:26
-- Model: New Model    Version: 1.0
SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema feeds
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `feeds` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `feeds` ;

-- -----------------------------------------------------
-- Table `feeds`.`news_paper`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `feeds`.`news_paper` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `feeds`.`new`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `feeds`.`new` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `description` VARCHAR(255) NOT NULL,
  `author` VARCHAR(255) NOT NULL,
  `date` DATETIME NOT NULL,
  `link` VARCHAR(255) NOT NULL,
  `id_ext` VARCHAR(255) NOT NULL,
  `likes` INT NOT NULL,
  `views` INT NOT NULL,
  `news_paper_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_new_news_paper_idx` (`news_paper_id` ASC),
  CONSTRAINT `fk_new_news_paper`
    FOREIGN KEY (`news_paper_id`)
    REFERENCES `feeds`.`news_paper` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `feeds`.`news_paper`
-- -----------------------------------------------------
START TRANSACTION;
USE `feeds`;
INSERT INTO `feeds`.`news_paper` (`id`, `name`) VALUES (1, 'Diario de Yucatan Ultimas noticias');
INSERT INTO `feeds`.`news_paper` (`id`, `name`) VALUES (2, 'Diario de Yucatan Merida');
INSERT INTO `feeds`.`news_paper` (`id`, `name`) VALUES (3, 'Diario de Yucatan Yucatan');
INSERT INTO `feeds`.`news_paper` (`id`, `name`) VALUES (4, 'Diario de Yucatan Mexico');
INSERT INTO `feeds`.`news_paper` (`id`, `name`) VALUES (5, 'Diario de Yucatan Deportes');
INSERT INTO `feeds`.`news_paper` (`id`, `name`) VALUES (6, 'Diario de Yucatan Quintana roo');

COMMIT;

