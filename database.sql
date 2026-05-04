CREATE DATABASE IF NOT EXISTS mbooks CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE mbooks;

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('user','admin') DEFAULT 'user',
  membership_type ENUM('none','basic','premium') DEFAULT 'none',
  email_verified TINYINT(1) DEFAULT 0,
  verification_token VARCHAR(64) NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS books (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(180) NOT NULL,
  author VARCHAR(140) NOT NULL,
  genre VARCHAR(80) NOT NULL,
  description TEXT,
  price DECIMAL(10,2) NOT NULL DEFAULT 0,
  cover_image VARCHAR(255),
  stock INT DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS cart_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  book_id INT NOT NULL,
  quantity INT NOT NULL DEFAULT 1,
  UNIQUE KEY unique_cart (user_id, book_id)
);

CREATE TABLE IF NOT EXISTS orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  total DECIMAL(10,2) NOT NULL,
  shipping_address TEXT,
  status ENUM('pending','shipped','delivered') DEFAULT 'pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS order_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT NOT NULL,
  book_id INT NOT NULL,
  quantity INT NOT NULL,
  price_at_time DECIMAL(10,2) NOT NULL
);

CREATE TABLE IF NOT EXISTS reviews (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  book_id INT NOT NULL,
  rating INT NOT NULL,
  review_text TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY unique_review (user_id, book_id)
);

CREATE TABLE IF NOT EXISTS clubs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  description TEXT,
  type ENUM('public','private') DEFAULT 'public',
  created_by INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS club_members (
  id INT AUTO_INCREMENT PRIMARY KEY,
  club_id INT NOT NULL,
  user_id INT NOT NULL,
  UNIQUE KEY unique_member (club_id, user_id)
);

CREATE TABLE IF NOT EXISTS votes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  club_id INT NOT NULL,
  book_id INT NOT NULL,
  user_id INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS challenges (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  year INT NOT NULL,
  goal INT NOT NULL DEFAULT 1,
  books_read INT NOT NULL DEFAULT 0,
  completed TINYINT(1) DEFAULT 0,
  UNIQUE KEY unique_challenge (user_id, year)
);

CREATE TABLE IF NOT EXISTS reading_log (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  book_id INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS achievements (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  icon VARCHAR(20) DEFAULT ''
);

CREATE TABLE IF NOT EXISTS user_achievements (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  achievement_id INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY unique_achievement (user_id, achievement_id)
);

INSERT IGNORE INTO users (id, name, email, password, role, membership_type, email_verified) VALUES
(1, 'Admin', 'admin@mbooks.com', '$2y$10$w4iqU0IPf2aC8sPGko3ubOfc3w.i6qWigxl2X92GYHrYp9vaCyeM6', 'admin', 'premium', 1);

INSERT IGNORE INTO achievements (id, name, icon) VALUES
(1, 'First Purchase', '★'),
(2, 'Bookworm', '★'),
(3, 'Club Joiner', '★'),
(4, 'Rated 5', '★'),
(5, 'Challenge Accepted', '★');

INSERT INTO books (title, author, genre, description, price, cover_image, stock)
SELECT 'The Guns of August', 'Barbara W. Tuchman', 'History', 'A narrative history of the opening month of World War I and the decisions that shaped modern conflict.', 18.99, 'images/books/the_guns_of_august.jpg', 12
WHERE NOT EXISTS (SELECT 1 FROM books WHERE title = 'The Guns of August' AND author = 'Barbara W. Tuchman');

INSERT INTO books (title, author, genre, description, price, cover_image, stock)
SELECT 'A People''s History of the United States', 'Howard Zinn', 'History', 'A social history of the United States told from the perspective of workers, activists, and ordinary citizens.', 17.50, 'images/books/peoples_history_us.jpg', 10
WHERE NOT EXISTS (SELECT 1 FROM books WHERE title = 'A People''s History of the United States' AND author = 'Howard Zinn');

INSERT INTO books (title, author, genre, description, price, cover_image, stock)
SELECT 'The Name of the Wind', 'Patrick Rothfuss', 'Fantasy', 'A lyrical fantasy about Kvothe, a gifted musician and magician, recounting the legend of his life.', 15.99, 'images/books/the_name_of_the_wind.jpg', 14
WHERE NOT EXISTS (SELECT 1 FROM books WHERE title = 'The Name of the Wind' AND author = 'Patrick Rothfuss');

INSERT INTO books (title, author, genre, description, price, cover_image, stock)
SELECT 'Mistborn: The Final Empire', 'Brandon Sanderson', 'Fantasy', 'A high-stakes fantasy story about rebellion, power, and a magic system built around metals.', 16.25, 'images/books/mistborn_final_empire.jpg', 14
WHERE NOT EXISTS (SELECT 1 FROM books WHERE title = 'Mistborn: The Final Empire' AND author = 'Brandon Sanderson');
