CREATE TABLE `hire_me`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(45) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `type` VARCHAR(20) NOT NULL,
  `about_me` TEXT NULL,
  `web` VARCHAR(100) NULL,
  `created_timestamp` INT(11) NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_timestamp` INT(11) NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) VISIBLE);


CREATE TABLE `hire_me`.`jobs` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `slug` VARCHAR(255) NOT NULL,
  `employer_id` INT(11) NULL,
  `title` VARCHAR(100) NOT NULL,
  `description` TEXT(1000) NULL,
  `required_knowledge` TEXT(10000) NOT NULL,
  `education_experience` TEXT(10000) NOT NULL,
  `location` VARCHAR(45) NOT NULL,
  `salary_from` INT(11) NULL,
  `salary_to` INT(11) NULL,
  `job_nature` VARCHAR(20) NULL,
  `vacancy_number` INT(3) NULL,
  `created_timestamp` INT(11) NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_timestamp` INT(11) NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `slug_UNIQUE` (`slug` ASC) VISIBLE);