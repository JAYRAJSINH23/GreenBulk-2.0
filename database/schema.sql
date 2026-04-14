-- GreenBulk Database Schema

CREATE DATABASE IF NOT EXISTS greenbulk;
USE greenbulk;

-- Users Table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Products Table
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    category VARCHAR(100),
    image_url VARCHAR(255),
    stock INT DEFAULT 0,
    nutrition_facts TEXT, -- JSON string or simple text describing macros
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Orders Table
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    razorpay_order_id VARCHAR(255),
    razorpay_payment_id VARCHAR(255),
    status ENUM('Pending', 'Paid', 'Failed', 'Shipped') DEFAULT 'Pending',
    total_amount DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Order Items Table
CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- Reviews Table
CREATE TABLE IF NOT EXISTS reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    user_id INT NOT NULL,
    rating INT NOT NULL CHECK (rating >= 1 AND rating <= 5),
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Seed Initial Products
INSERT INTO products (name, description, price, category, image_url, stock, nutrition_facts) VALUES
('100% Whey Protein Isolate - Chocolate', 'Clean, fast-absorbing whey isolate for maximum muscle recovery.', 3499.00, 'Protein', 'images/whey-isolate.jpg', 100, 'Protein: 28g, Carbs: 1g, Fat: 0.5g'),
('Natural Mass Gainer', 'Premium mass gainer with complex carbs and zero added sugar.', 2999.00, 'Mass Gainer', 'images/mass-gainer.jpg', 50, 'Protein: 50g, Carbs: 100g, Calories: 650kcal'),
('Pre-Workout Beast Mode', 'Explosive energy and focus without the crash. Natural caffeine extract.', 1499.00, 'Pre-Workout', 'images/pre-workout.jpg', 200, 'Caffeine: 200mg, Citrulline: 6g, Beta-Alanine: 3g'),
('Vegan Plant Protein - Vanilla', 'Pea and brown rice protein blend to fuel your muscle gains naturally.', 2499.00, 'Vegan', 'images/vegan-protein.jpg', 75, 'Protein: 25g, Carbs: 3g, Fat: 2g'),
('BCAA Recovery 2:1:1', 'Essential amino acids to support intra-workout endurance and recovery.', 1299.00, 'Aminos', 'images/bcaa.jpg', 150, 'Leucine: 3g, Isoleucine: 1.5g, Valine: 1.5g'),
('Creatine Monohydrate', 'Pure, micronized creatine for explosive power and strength.', 999.00, 'Strength', 'images/creatine.jpg', 300, 'Creatine: 3g per serving');
