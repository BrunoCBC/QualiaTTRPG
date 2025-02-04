CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    nickname VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    profile_image_path VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE rpgs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    hash VARCHAR(255) NOT NULL UNIQUE,
    rpg_name VARCHAR(255) NOT NULL,
    rpg_description TEXT NULL,
    rpg_image_path VARCHAR(255) NULL,
    visibility ENUM('public', 'private') DEFAULT 'private',
    id_folder_fk INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_folder_fk) REFERENCES folders(id) ON DELETE CASCADE
);

CREATE TABLE attributes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    attributes_name VARCHAR(255) NOT NULL,
    attributes_type VARCHAR(50) NOT NULL,
    attributes_price INT NOT NULL
);

CREATE TABLE levels (
    id INT AUTO_INCREMENT PRIMARY KEY,
    level INT NOT NULL,
    pc INT NOT NULL,
    pl INT NOT NULL,
    pm INT NOT NULL,
    pb INT NOT NULL
);

CREATE TABLE folders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    hash VARCHAR(255) NOT NULL UNIQUE,
    folder_name VARCHAR(255) NOT NULL,
    folder_description TEXT NULL,
    folder_icon_path VARCHAR(255) NULL,
    visibility_role ENUM('viewer', 'player', 'admin', 'owner') DEFAULT 'viewer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE sheets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    hash VARCHAR(255) NOT NULL UNIQUE,
    sheet_name VARCHAR(255) NOT NULL,
    sheet_description TEXT NULL,
    sheet_level INT NOT NULL,
    sheet_image_path VARCHAR(255) NULL,
    id_folder_fk INT NOT NULL,
    id_sheettype_fk INT NOT NULL,
    FOREIGN KEY (id_folder_fk) REFERENCES folders(id) ON DELETE CASCADE,
    FOREIGN KEY (id_sheettype_fk) REFERENCES sheet_types(id) ON DELETE CASCADE
);

CREATE TABLE sheet_types (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sheettype_name VARCHAR(255) NOT NULL,
    sheettype_description TEXT NULL,
    id_rpg_fk BIGINT UNSIGNED,
    FOREIGN KEY (id_rpg_fk) REFERENCES rpgs(id) ON DELETE CASCADE
);

CREATE TABLE files (
    id INT AUTO_INCREMENT PRIMARY KEY,
    hash VARCHAR(255) NOT NULL UNIQUE,
    file_name VARCHAR(255) NOT NULL,
    file_description TEXT NULL,
    file_path VARCHAR(255) NOT NULL,
    file_preview_path VARCHAR(255) NULL,
    id_folder_fk INT NOT NULL,
    FOREIGN KEY (id_folder_fk) REFERENCES folders(id) ON DELETE CASCADE
);

CREATE TABLE user_rpg (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_user_fk INT NOT NULL,
    id_rpg_fk INT NOT NULL,
    id_sheet_fk INT NULL,
    role ENUM('viewer', 'player', 'admin', 'owner') NOT NULL,
    FOREIGN KEY (id_user_fk) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (id_rpg_fk) REFERENCES rpgs(id) ON DELETE CASCADE,
    FOREIGN KEY (id_sheet_fk) REFERENCES sheets(id) ON DELETE CASCADE
);

CREATE TABLE folder_subfolder (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_folder_fk INT NOT NULL,
    id_subfolder_fk INT NOT NULL,
    FOREIGN KEY (id_folder_fk) REFERENCES folders(id) ON DELETE CASCADE,
    FOREIGN KEY (id_subfolder_fk) REFERENCES folders(id) ON DELETE CASCADE
);

CREATE TABLE rpg_attributes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_rpg_fk INT NOT NULL,
    id_attribute_fk INT NOT NULL,
    FOREIGN KEY (id_rpg_fk) REFERENCES rpgs(id) ON DELETE CASCADE,
    FOREIGN KEY (id_attribute_fk) REFERENCES attributes(id) ON DELETE CASCADE
);

CREATE TABLE rpg_level_sheettype (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_rpg_fk INT NOT NULL,
    id_level_fk INT NOT NULL,
    id_sheettype_fk INT NOT NULL,
    FOREIGN KEY (id_rpg_fk) REFERENCES rpgs(id) ON DELETE CASCADE,
    FOREIGN KEY (id_level_fk) REFERENCES levels(id) ON DELETE CASCADE,
    FOREIGN KEY (id_sheettype_fk) REFERENCES sheet_types(id) ON DELETE CASCADE
);

CREATE TABLE sheet_subsheet (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_sheet_fk INT NOT NULL,
    id_subsheet_fk INT NOT NULL,
    FOREIGN KEY (id_sheet_fk) REFERENCES sheets(id) ON DELETE CASCADE,
    FOREIGN KEY (id_subsheet_fk) REFERENCES sheets(id) ON DELETE CASCADE
);

CREATE TABLE sheet_attribute (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_sheet_fk INT NOT NULL,
    id_attribute_fk INT NOT NULL,
    points_spent INT NOT NULL,
    FOREIGN KEY (id_sheet_fk) REFERENCES sheets(id) ON DELETE CASCADE,
    FOREIGN KEY (id_attribute_fk) REFERENCES attributes(id) ON DELETE CASCADE
);
