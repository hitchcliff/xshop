DROP Table IF EXISTS users;

create table users (
    id int AUTO_INCREMENT PRIMARY KEY,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    first_name VARCHAR(255) NULL,
    last_name VARCHAR(255) NULL,
    username VARCHAR(255) NULL,
    password TEXT NULL,
    phone_number VARCHAR(255) NULL,
    email VARCHAR(255) null,
    address VARCHAR(255) NULL,
    user_type VARCHAR(255) null
);

DROP Table IF EXISTS categories;

create table categories (
    id int AUTO_INCREMENT PRIMARY KEY,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    name VARCHAR(255) NULL,
    photo VARCHAR(255) NULL,
    description VARCHAR(255) NULL,
    parentId VARCHAR(255) NULL,
    userId int NOT NULL
);

