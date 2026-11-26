-- Run this once against the database configured in configs/env.php.
CREATE TABLE IF NOT EXISTS orders (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    order_code VARCHAR(32) NOT NULL UNIQUE,
    customer_name VARCHAR(150) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    email VARCHAR(190) NULL,
    address TEXT NOT NULL,
    note TEXT NULL,
    fulfillment_method ENUM('delivery', 'pickup') NOT NULL DEFAULT 'delivery',
    payment_method VARCHAR(50) NOT NULL DEFAULT 'COD',
    total BIGINT UNSIGNED NOT NULL DEFAULT 0,
    items JSON NOT NULL,
    status VARCHAR(30) NOT NULL DEFAULT 'pending',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
