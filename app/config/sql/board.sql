--
-- Create database
--
CREATE DATABASE IF NOT EXISTS board;
GRANT SELECT, INSERT, UPDATE, DELETE ON board.*
    TO board_root@localhost IDENTIFIED BY 'board_root';
FLUSH PRIVILEGES;
--
-- Create tables
--

USE board;

CREATE TABLE IF NOT EXISTS user (
    user_id         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    user_fname      VARCHAR(50) NOT NULL,
    user_lname      VARCHAR(50) NOT NULL,
    user_email      VARCHAR(50) NOT NULL,
    user_username   VARCHAR(50) NOT NULL,
    user_password   VARCHAR(50) NOT NULL,
    user_registered TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
    PRIMARY KEY (user_id)
)ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS thread (
    thread_id       INT UNSIGNED NOT NULL AUTO_INCREMENT,
    thread_title    VARCHAR(50) NOT NULL,
    thread_user_id  INT (11),
    thread_created  TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
    PRIMARY KEY (thread_id)
)ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS comment (
    comment_id          INT UNSIGNED NOT NULL AUTO_INCREMENT,
    comment_thread_id   INT UNSIGNED NOT NULL,
    comment_user_id     INT (11) NOT NULL,
    comment_body        TEXT NOT NULL,
    comment_created     TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
    PRIMARY KEY (comment_id),
    INDEX (comment_thread_id, comment_created)
)ENGINE=InnoDB;