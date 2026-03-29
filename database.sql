-- Create database (if you haven't created it manually yet)
CREATE DATABASE IF NOT EXISTS nexplay;
USE nexplay;

-- Users Table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    status ENUM('active', 'blocked', 'banned') DEFAULT 'active',
    blocked_until DATETIME NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Settings Table (for storing SMTP configuration dynamically)
CREATE TABLE IF NOT EXISTS settings (
    setting_key VARCHAR(50) PRIMARY KEY,
    setting_value TEXT NOT NULL
);

-- Insert Default Admin (Password: admin123)
-- The password_hash is for 'admin123' using PHP's password_hash with BCRYPT.
INSERT INTO users (username, email, password_hash, role, status) VALUES 
('admin', 'admin@nexplay.local', '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', 'admin', 'active')
ON DUPLICATE KEY UPDATE username=username;

-- Insert Default SMTP Settings
INSERT INTO settings (setting_key, setting_value) VALUES 
('smtp_host', 'smtp.example.com'),
('smtp_port', '587'),
('smtp_username', 'user@example.com'),
('smtp_password', 'password'),
('smtp_encryption', 'tls'),
('smtp_from_email', 'noreply@nexplay.local'),
('smtp_from_name', 'NexPlay Hub')
ON DUPLICATE KEY UPDATE setting_key=setting_key;
