--
-- Create database
--
CREATE DATABASE IF NOT EXISTS klabhouse;
GRANT SELECT, INSERT, UPDATE, DELETE ON klabhouse.* TO klabhouse_root@localhost IDENTIFIED BY 'klabhouse_root';
FLUSH PRIVILEGES;
--
-- Create tables
--

USE klabhouse;
CREATE TABLE IF NOT EXISTS user (
user_id
INT UNSIGNED NOT NULL AUTO_INCREMENT,
user_fname
VARCHAR(50) NOT NULL,
user_lname
VARCHAR(50) NOT NULL,
user_email
VARCHAR(50) NOT NULL,
user_username
VARCHAR(50) NOT NULL,
user_password
VARCHAR(50) NOT NULL,
user_type
INT(1),
user_created
TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
user_updated
DATETIME,
PRIMARY KEY (user_id)
)ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS thread (
thread_id
INT UNSIGNED NOT NULL AUTO_INCREMENT,
thread_title
VARCHAR(50) NOT NULL,
thread_user_id
INT (11),
thread_created
TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
PRIMARY KEY (thread_id)
)ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS comment (
comment_id
INT UNSIGNED NOT NULL AUTO_INCREMENT,
comment_thread_id
INT UNSIGNED NOT NULL,
comment_user_id
INT (11) NOT NULL,
comment_body
TEXT NOT NULL,
comment_created
TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
PRIMARY KEY (comment_id),
INDEX (comment_thread_id, comment_created)
)ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS klub (
klub_id
INT UNSIGNED NOT NULL AUTO_INCREMENT,
klub_name
VARCHAR(50) NOT NULL,
klub_details
TEXT NOT NULL,
klub_created
TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
klub_updated
DATETIME,
PRIMARY KEY (klub_id)
)ENGINE=InnoDB;