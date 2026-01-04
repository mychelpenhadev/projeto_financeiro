CREATE DATABASE IF NOT EXISTS iafinancecrm;
USE iafinancecrm;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL UNIQUE,
  `senha_hash` varchar(255) NOT NULL,
  `role` enum('admin','normal') DEFAULT 'normal',
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


INSERT INTO `users` (`nome`, `email`, `senha_hash`, `role`) VALUES
('Administrador', 'admin@iafinance.com', '$2y$10$yixs5ci4m8XBF7vb0.MNEcDjcxQiqwW2UMtUFclaFX.ExampleHash', 'admin');


CREATE TABLE `receitas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `categoria` varchar(50) NOT NULL,
  `data` date NOT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `despesas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `categoria` varchar(50) NOT NULL,
  `data` date NOT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE INDEX idx_receitas_user_date ON receitas(user_id, data);
CREATE INDEX idx_despesas_user_date ON despesas(user_id, data);

COMMIT;
