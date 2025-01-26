CREATE DATABASE IF NOT EXISTS category_db;
USE category_db;

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    group_id VARCHAR(255),
    parent_id VARCHAR(255) DEFAULT '0',
    name VARCHAR(255)
);