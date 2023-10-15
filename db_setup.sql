CREATE TABLE `hire_me`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(45) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `type` VARCHAR(20) NOT NULL,
  `about_me` TEXT NULL,
  `web` VARCHAR(100) NULL,
  `avatar` VARCHAR(255) NULL,
  `resume` VARCHAR(255) NULL,
  `created_timestamp` INT(11) NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_timestamp` INT(11) NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) VISIBLE);


CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL AUTO_INCREMENT,
  `slug` varchar(100) NOT NULL,
  `created_timestamp` int(11) NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_timestamp` int(11) NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `name_unique` (`name` ASC) VISIBLE);


CREATE TABLE `hire_me`.`jobs` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `slug` VARCHAR(255) NOT NULL,
  `employer_id` INT(11) NULL,
  `category_id` INT(11) NULL,
  `title` VARCHAR(100) NOT NULL,
  `description` TEXT(1000) NULL,
  `required_knowledge` TEXT(10000) NOT NULL,
  `education_experience` TEXT(10000) NOT NULL,
  `location` VARCHAR(45) NOT NULL,
  `salary_from` INT(11) NULL,
  `salary_to` INT(11) NULL,
  `job_nature` VARCHAR(20) NULL,
  `vacancy_number` INT(3) NULL,
  `years_of_experience` VARCHAR(10) NOT NULL,
  `created_timestamp` INT(11) NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_timestamp` INT(11) NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `slug_UNIQUE` (`slug` ASC) VISIBLE);

CREATE TABLE `job_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `job_id` int(11) NOT NULL,
  `usrt_id` int(11) NOT NULL,
  `status` varchar(20) NOT NULL,
  `created_timestamp` INT(11) NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_timestamp` INT(11) NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`));


ALTER TABLE `hire_me`.`job_user` ADD UNIQUE (`job_id`, `user_id`);