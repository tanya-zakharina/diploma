CREATE DATABASE 'zaxaritk_diploma';

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  password VARCHAR(255) NOT NULL,
  points INT DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE results (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  game_name VARCHAR(100),
  score INT,
  played_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE reviews (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT DEFAULT NULL,
  username VARCHAR(100) NOT NULL,
  rating  INT DEFAULT 1,
  text TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Создаем пользователя
CREATE USER 'zaxaritk_diploma'@'localhost' IDENTIFIED BY '4MOE%*uH&v1*';

-- Даем доступ только к одной базе данных (например, 'my_app_db')--
GRANT ALL PRIVILEGES ON `zaxaritk_diploma`.* TO `zaxaritk_diploma`@`localhost`;

-- Применяем изменения
FLUSH PRIVILEGES;
