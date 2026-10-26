-- ZENITH COFFEE & ROASTERY Database Dump
-- Database: inventory_sales_db

CREATE DATABASE IF NOT EXISTS `inventory_sales_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `inventory_sales_db`;

-- --------------------------------------------------------
-- Drop tables in reverse FK order
-- --------------------------------------------------------
DROP TABLE IF EXISTS `sale_items`;
DROP TABLE IF EXISTS `sales`;
DROP TABLE IF EXISTS `purchase_items`;
DROP TABLE IF EXISTS `purchases`;
DROP TABLE IF EXISTS `products`;
DROP TABLE IF EXISTS `categories`;
DROP TABLE IF EXISTS `suppliers`;
DROP TABLE IF EXISTS `users`;

-- --------------------------------------------------------
-- Table structure for table `users`
-- --------------------------------------------------------
CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('owner','admin','staff','pelanggan','pembeli') NOT NULL DEFAULT 'pelanggan',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_role_index` (`role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `categories`
-- --------------------------------------------------------
CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `suppliers`
-- --------------------------------------------------------
CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `products`
-- --------------------------------------------------------
CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `sku` varchar(50) NOT NULL,
  `name` varchar(150) NOT NULL,
  `purchase_price` decimal(15,2) NOT NULL DEFAULT 0.00,
  `selling_price` decimal(15,2) NOT NULL DEFAULT 0.00,
  `stock` int(11) NOT NULL DEFAULT 0,
  `minimum_stock` int(11) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_sku_unique` (`sku`),
  KEY `products_category_id_foreign` (`category_id`),
  KEY `products_name_sku_index` (`name`,`sku`),
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `purchases`
-- --------------------------------------------------------
CREATE TABLE `purchases` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `purchase_number` varchar(50) NOT NULL,
  `total` decimal(15,2) NOT NULL DEFAULT 0.00,
  `status` enum('completed','cancelled') NOT NULL DEFAULT 'completed',
  `purchased_at` datetime NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `purchases_purchase_number_unique` (`purchase_number`),
  KEY `purchases_supplier_id_foreign` (`supplier_id`),
  KEY `purchases_user_id_foreign` (`user_id`),
  KEY `purchases_purchased_at_status_index` (`purchased_at`,`status`),
  CONSTRAINT `purchases_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`),
  CONSTRAINT `purchases_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `purchase_items`
-- --------------------------------------------------------
CREATE TABLE `purchase_items` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `purchase_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_cost` decimal(15,2) NOT NULL,
  `subtotal` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `purchase_items_purchase_id_foreign` (`purchase_id`),
  KEY `purchase_items_product_id_foreign` (`product_id`),
  CONSTRAINT `purchase_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  CONSTRAINT `purchase_items_purchase_id_foreign` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `sales`
-- --------------------------------------------------------
CREATE TABLE `sales` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `sale_number` varchar(50) NOT NULL,
  `total` decimal(15,2) NOT NULL DEFAULT 0.00,
  `status` enum('completed','cancelled') NOT NULL DEFAULT 'completed',
  `sold_at` datetime NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sales_sale_number_unique` (`sale_number`),
  KEY `sales_user_id_foreign` (`user_id`),
  KEY `sales_sold_at_status_index` (`sold_at`,`status`),
  CONSTRAINT `sales_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `sale_items`
-- --------------------------------------------------------
CREATE TABLE `sale_items` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `sale_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(15,2) NOT NULL,
  `subtotal` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `sale_items_sale_id_foreign` (`sale_id`),
  KEY `sale_items_product_id_foreign` (`product_id`),
  CONSTRAINT `sale_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  CONSTRAINT `sale_items_sale_id_foreign` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- DATA DUMMY: USERS (Password: password123)
-- --------------------------------------------------------
INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`) VALUES
(1, 'Budi Hartono (Owner Kafe)', 'owner@example.com', '$2y$12$NlmxQYm1D5oR61v0wG7oO.6t1Q2vR3wN4s5.8J3j5s5iK0wL1vM2y', 'owner'),
(2, 'Siti Rahma (Head Barista & Kasir)', 'staff@example.com', '$2y$12$NlmxQYm1D5oR61v0wG7oO.6t1Q2vR3wN4s5.8J3j5s5iK0wL1vM2y', 'staff'),
(3, 'Ahmad Fauzi (Barista & Restock)', 'staff2@example.com', '$2y$12$NlmxQYm1D5oR61v0wG7oO.6t1Q2vR3wN4s5.8J3j5s5iK0wL1vM2y', 'staff'),
(4, 'Rizky Pratama (Member Pelanggan)', 'pelanggan@example.com', '$2y$12$NlmxQYm1D5oR61v0wG7oO.6t1Q2vR3wN4s5.8J3j5s5iK0wL1vM2y', 'pelanggan');

-- --------------------------------------------------------
-- DATA DUMMY: KATEGORI KAFE
-- --------------------------------------------------------
INSERT INTO `categories` (`id`, `name`, `description`) VALUES
(1, 'Signature Kopi Susu', 'Menu kopi susu kekinian dengan gula aren dan perisa spesial'),
(2, 'Espresso & Coffee Bar', 'Minuman klasik berbasis espresso: Americano, Latte, Cappuccino'),
(3, 'Non-Coffee & Mocktails', 'Minuman segar non-kopi: Matcha Latte, Cokelat Belgia, Red Velvet'),
(4, 'Artisan Pastry & Bakery', 'Roti dan kue panggang segar: Butter Croissant, Cinnamon Roll'),
(5, 'Biji Kopi & Kemasan', 'Biji kopi sangrai asli Nusantara dalam kemasan 250g');

-- --------------------------------------------------------
-- DATA DUMMY: PEMASOK BAHAN BAKU & ROASTERY
-- --------------------------------------------------------
INSERT INTO `suppliers` (`id`, `name`, `phone`, `email`, `address`) VALUES
(1, 'PT Roastery Kopi Nusantara', '021-5558989', 'roastery@kopinusantara.id', 'Sentra Roastery Kopi No. 12, Jakarta Selatan'),
(2, 'CV Sumber Dairy & Susu Segar', '022-7774321', 'order@sumberdairy.com', 'Kawasan Agrowisata Susu Lembang Kav. 8, Bandung'),
(3, 'Artisan Syrup & Bakery Supply', '031-8886543', 'supply@artisansyrup.co.id', 'Pergudangan Industri Makanan No. 5, Surabaya');

-- --------------------------------------------------------
-- DATA DUMMY: MENU & PRODUK KAFE
-- --------------------------------------------------------
INSERT INTO `products` (`id`, `category_id`, `sku`, `name`, `purchase_price`, `selling_price`, `stock`, `minimum_stock`) VALUES
(1, 1, 'KOP-AREN-ICE', 'Es Kopi Susu Gula Aren Signature', 8000.00, 22000.00, 85, 15),
(2, 1, 'KOP-CARAMEL', 'Iced Salted Caramel Macchiato', 11000.00, 28000.00, 40, 10),
(3, 2, 'KOP-AMR-HOT', 'Hot Americano Arabica Single Origin', 6000.00, 20000.00, 60, 10),
(4, 2, 'KOP-CAPPUC', 'Hot Cappuccino Velvety Milk Foam', 9000.00, 25000.00, 45, 10),
(5, 3, 'NCF-MTC-ICE', 'Iced Kyoto Matcha Latte', 12000.00, 26000.00, 5, 10),
(6, 3, 'NCF-CHO-ICE', 'Iced Belgian Dark Chocolate', 10000.00, 24000.00, 35, 10),
(7, 4, 'BAK-CRST-BTR', 'French Butter Croissant Fresh Baked', 12000.00, 25000.00, 20, 8),
(8, 4, 'BAK-CIN-ROL', 'Cinnamon Roll Cream Cheese Glaze', 14000.00, 27000.00, 0, 5),
(9, 5, 'BNS-GYO-250G', 'Biji Kopi Arabika Aceh Gayo Medium Roast 250g', 45000.00, 75000.00, 25, 5);

-- --------------------------------------------------------
-- DATA DUMMY: PASOKAN STOK MASUK (PURCHASES)
-- --------------------------------------------------------
INSERT INTO `purchases` (`id`, `supplier_id`, `user_id`, `purchase_number`, `total`, `status`, `purchased_at`, `notes`) VALUES
(1, 1, 1, 'PO-20261015-001', 1260000.00, 'completed', NOW() - INTERVAL 3 DAY, 'Pasokan biji kopi Arabika Gayo dan pasokan mentah pastry harian');

INSERT INTO `purchase_items` (`id`, `purchase_id`, `product_id`, `quantity`, `unit_cost`, `subtotal`) VALUES
(1, 1, 9, 20, 45000.00, 900000.00),
(2, 1, 7, 30, 12000.00, 360000.00);

-- --------------------------------------------------------
-- DATA DUMMY: PESANAN & TRANSAKSI KASIR (SALES)
-- --------------------------------------------------------
INSERT INTO `sales` (`id`, `user_id`, `sale_number`, `total`, `status`, `sold_at`, `notes`) VALUES
(1, 2, 'SO-20261019-001', 69000.00, 'completed', NOW() - INTERVAL 4 HOUR, 'Pesanan Dine-In Meja 04 (Kasir Barista)'),
(2, 2, 'SO-20261019-002', 54000.00, 'completed', NOW() - INTERVAL 2 HOUR, 'Pesanan Takeaway Drive-thru (Kasir Barista)'),
(3, 4, 'SO-20261019-003', 97000.00, 'completed', NOW() - INTERVAL 45 MINUTE, 'Pesanan Mandiri Aplikasi Pelanggan (Self Pick-up)');

INSERT INTO `sale_items` (`id`, `sale_id`, `product_id`, `quantity`, `unit_price`, `subtotal`) VALUES
(1, 1, 1, 2, 22000.00, 44000.00),
(2, 1, 7, 1, 25000.00, 25000.00),
(3, 2, 2, 1, 28000.00, 28000.00),
(4, 2, 5, 1, 26000.00, 26000.00),
(5, 3, 1, 1, 22000.00, 22000.00),
(6, 3, 9, 1, 75000.00, 75000.00);
