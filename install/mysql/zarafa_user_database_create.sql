-- to create user and database
CREATE USER 'zarafa'@'localhost' IDENTIFIED BY 'minivisp';
GRANT USAGE ON * . * TO 'zarafa'@'localhost' IDENTIFIED BY 'minivisp' WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0 ;
CREATE DATABASE IF NOT EXISTS `zarafa` ;
GRANT ALL PRIVILEGES ON `zarafa` . * TO 'zarafa'@'localhost';
-- to drop
-- DROP USER 'zarafa'@'localhost';
-- DROP DATABASE IF EXISTS `zarafa` ;
FLUSH PRIVILEGES;