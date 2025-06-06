		CREATE TABLE IF NOT EXISTS `comment` (
			`id` INT PRIMARY KEY AUTO_INCREMENT,
			`blog_id` int NOT NULL,
			`user_id` int NOT NULL,
			`reply_id` int NOT NULL,
			`content` text NOT NULL,`status` tinyint DEFAULT '0',
			`created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `updated_at` DATE DEFAULT NULL,
            FOREIGN KEY (`blog_id`) REFERENCES `motelrooms` (`id`) ON DELETE CASCADE,
            FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
			) ENGINE = InnoDB;