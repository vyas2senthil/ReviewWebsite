SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `review_website` DEFAULT CHARACTER SET latin1 ;
USE `review_website` ;

-- -----------------------------------------------------
-- Table `review_website`.`organizations`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `review_website`.`organizations` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `organization_name` VARCHAR(75) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `review_website`.`survey_headers`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `review_website`.`survey_headers` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `organization_id` INT NOT NULL ,
  `survey_name` VARCHAR(75) NULL ,
  `instructions` VARCHAR(4096) NULL ,
  `other_header_info` VARCHAR(255) NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_survey_headers_organizations1` (`organization_id` ASC) ,
  CONSTRAINT `fk_survey_headers_organizations1`
    FOREIGN KEY (`organization_id` )
    REFERENCES `review_website`.`organizations` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `review_website`.`survey_sections`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `review_website`.`survey_sections` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `survey_header_id` INT NULL ,
  `section_name` VARCHAR(75) NULL ,
  `section_title` VARCHAR(45) NULL ,
  `section_subheading` VARCHAR(45) NULL ,
  `section_required` TINYINT(1)  NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_survey_sections_survey_headers1` (`survey_header_id` ASC) ,
  CONSTRAINT `fk_survey_sections_survey_headers1`
    FOREIGN KEY (`survey_header_id` )
    REFERENCES `review_website`.`survey_headers` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `review_website`.`input_types`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `review_website`.`input_types` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `input_type_name` VARCHAR(75) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `review_website`.`option_groups`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `review_website`.`option_groups` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `option_group_name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `review_website`.`questions`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `review_website`.`questions` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `survey_section_id` INT NOT NULL ,
  `input_type_id` INT NOT NULL ,
  `question_name` VARCHAR(255) NOT NULL ,
  `question_subtext` VARCHAR(500) NULL ,
  `answer_required` TINYINT(1)  NULL ,
  `option_group_id` INT NULL ,
  `allow_multiple_option_answers` TINYINT(1)  NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_questions_survey_sections1` (`survey_section_id` ASC) ,
  INDEX `fk_questions_input_types1` (`input_type_id` ASC) ,
  INDEX `fk_questions_option_groups1` (`option_group_id` ASC) ,
  CONSTRAINT `fk_questions_survey_sections1`
    FOREIGN KEY (`survey_section_id` )
    REFERENCES `review_website`.`survey_sections` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_questions_input_types1`
    FOREIGN KEY (`input_type_id` )
    REFERENCES `review_website`.`input_types` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_questions_option_groups1`
    FOREIGN KEY (`option_group_id` )
    REFERENCES `review_website`.`option_groups` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `review_website`.`users`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `review_website`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `username` VARCHAR(75) NOT NULL ,
  `password_hashed` VARCHAR(255) NULL ,
  `email` VARCHAR(45) NOT NULL ,
  `admin` TINYINT(1)  NULL ,
  `invite_dt` DATETIME NULL ,
  `last_login_dt` DATETIME NULL ,
  `inviter_user_id` INT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `review_website`.`user_survey_sections`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `review_website`.`user_survey_sections` (
  `id` INT NOT NULL ,
  `user_id` INT NOT NULL ,
  `survey_section_id` INT NOT NULL ,
  `completed_on` DATETIME NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_user_survey_sections_survey_sections1` (`survey_section_id` ASC) ,
  INDEX `fk_user_survey_sections_users1` (`user_id` ASC) ,
  CONSTRAINT `fk_user_survey_sections_survey_sections1`
    FOREIGN KEY (`survey_section_id` )
    REFERENCES `review_website`.`survey_sections` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_survey_sections_users1`
    FOREIGN KEY (`user_id` )
    REFERENCES `review_website`.`users` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `review_website`.`option_choices`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `review_website`.`option_choices` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `option_group_id` INT NOT NULL ,
  `option_choice_name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_option_choices_option_groups1` (`option_group_id` ASC) ,
  CONSTRAINT `fk_option_choices_option_groups1`
    FOREIGN KEY (`option_group_id` )
    REFERENCES `review_website`.`option_groups` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'ijygfo\n';


-- -----------------------------------------------------
-- Table `review_website`.`question_options`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `review_website`.`question_options` (
  `id` INT NOT NULL ,
  `question_id` INT NOT NULL ,
  `option_choice_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_question_options_questions1` (`question_id` ASC) ,
  INDEX `fk_question_options_option_choices1` (`option_choice_id` ASC) ,
  CONSTRAINT `fk_question_options_questions1`
    FOREIGN KEY (`question_id` )
    REFERENCES `review_website`.`questions` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_question_options_option_choices1`
    FOREIGN KEY (`option_choice_id` )
    REFERENCES `review_website`.`option_choices` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `review_website`.`survey_comments`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `review_website`.`survey_comments` (
  `id` INT NOT NULL ,
  `survey_header_id` INT NOT NULL ,
  `user_id` INT NOT NULL ,
  `comments` VARCHAR(4096) NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_survey_comments_survey_headers1` (`survey_header_id` ASC) ,
  INDEX `fk_survey_comments_users1` (`user_id` ASC) ,
  CONSTRAINT `fk_survey_comments_survey_headers1`
    FOREIGN KEY (`survey_header_id` )
    REFERENCES `review_website`.`survey_headers` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_survey_comments_users1`
    FOREIGN KEY (`user_id` )
    REFERENCES `review_website`.`users` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `review_website`.`unit_of_measures`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `review_website`.`unit_of_measures` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `unit_of_measures_name` VARCHAR(75) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `review_website`.`answers`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `review_website`.`answers` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `user_id` INT NOT NULL ,
  `question_option_id` INT NOT NULL ,
  `answer_numeric` INT NULL ,
  `answer_text` VARCHAR(255) NULL ,
  `answer` TINYINT(1)  NULL ,
  `unit_of_measure_id` INT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_answers_question_options1` (`question_option_id` ASC) ,
  INDEX `fk_answers_users1` (`user_id` ASC) ,
  INDEX `fk_answers_unit_of_measures1` (`unit_of_measure_id` ASC) ,
  CONSTRAINT `fk_answers_question_options1`
    FOREIGN KEY (`question_option_id` )
    REFERENCES `review_website`.`question_options` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_answers_users1`
    FOREIGN KEY (`user_id` )
    REFERENCES `review_website`.`users` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_answers_unit_of_measures1`
    FOREIGN KEY (`unit_of_measure_id` )
    REFERENCES `review_website`.`unit_of_measures` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
