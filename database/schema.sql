CREATE DATABASE IF NOT EXISTS ksa_discovery CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE ksa_discovery;

CREATE TABLE IF NOT EXISTS regions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    category VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    facts TEXT,
    landmarks TEXT,
    activities TEXT,
    climate TEXT,
    main_image VARCHAR(255),
    gallery_image1 VARCHAR(255),
    gallery_image2 VARCHAR(255),
    gallery_image3 VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Default admin (change password after first login)
INSERT INTO admins (username, password) VALUES ('admin', '$2y$10$defaultHashChangeMe');
