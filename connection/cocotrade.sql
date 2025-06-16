create database cocotrade;
use cocotrade;

-- Users Table (for farmers, buyers, wholesalers, etc.)
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone_number VARCHAR(20),
    user_type ENUM('farmer', 'buyer', 'wholesaler', 'admin') NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    address TEXT,
    city VARCHAR(50),
    district VARCHAR(50),
    profile_image VARCHAR(255),
    registration_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    account_status ENUM('active', 'suspended', 'pending') DEFAULT 'pending',
    last_login DATETIME,
    verification_status BOOLEAN DEFAULT FALSE
);

-- User Verification Documents (for farmer/wholesaler verification)
CREATE TABLE user_verification (
    verification_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    id_proof VARCHAR(255),
    address_proof VARCHAR(255),
    farm_ownership_proof VARCHAR(255),
    business_license VARCHAR(255),
    verification_status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    verification_notes TEXT,
    verified_by INT,
    verification_date DATETIME,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (verified_by) REFERENCES users(user_id)
);

-- Products Table
CREATE TABLE products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    seller_id INT NOT NULL,
    product_name VARCHAR(100) NOT NULL,
    product_type ENUM('fresh_coconut', 'dry_coconut', 'coconut_oil', 'coconut_shell', 'other') NOT NULL,
    description TEXT,
    price_per_unit DECIMAL(10,2) NOT NULL,
    unit_type ENUM('piece', 'kilogram', 'liter', 'ton') NOT NULL,
    available_quantity DECIMAL(10,2) NOT NULL,
    quality_grade ENUM('A', 'B', 'C', 'premium') NOT NULL,
    harvest_date DATE,
    expiry_date DATE,
    organic_certified BOOLEAN DEFAULT FALSE,
    product_image1 VARCHAR(255),
    product_image2 VARCHAR(255),
    product_image3 VARCHAR(255),
    listing_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    is_active BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (seller_id) REFERENCES users(user_id)
);

-- Product Categories (for coconut-based products)
CREATE TABLE product_categories (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(50) NOT NULL,
    description TEXT,
    parent_category_id INT,
    FOREIGN KEY (parent_category_id) REFERENCES product_categories(category_id)
);

-- Orders Table
CREATE TABLE orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    buyer_id INT NOT NULL,
    order_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    total_amount DECIMAL(10,2) NOT NULL,
    payment_status ENUM('pending', 'paid', 'failed', 'refunded') DEFAULT 'pending',
    order_status ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
    delivery_address TEXT NOT NULL,
    contact_phone VARCHAR(20) NOT NULL,
    notes TEXT,
    FOREIGN KEY (buyer_id) REFERENCES users(user_id)
);

-- Order Items Table
CREATE TABLE order_items (
    order_item_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity DECIMAL(10,2) NOT NULL,
    unit_price DECIMAL(10,2) NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(order_id),
    FOREIGN KEY (product_id) REFERENCES products(product_id)
);

-- Transportation Services (for bulk orders)
CREATE TABLE transportation_services (
    service_id INT AUTO_INCREMENT PRIMARY KEY,
    provider_id INT NOT NULL,
    vehicle_type ENUM('small_truck', 'medium_truck', 'large_truck', 'lorry') NOT NULL,
    capacity DECIMAL(10,2) NOT NULL COMMENT 'in kilograms',
    price_per_km DECIMAL(10,2) NOT NULL,
    availability_schedule TEXT,
    service_description TEXT,
    is_available BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (provider_id) REFERENCES users(user_id)
);

-- Transportation Bookings
CREATE TABLE transportation_bookings (
    booking_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    service_id INT NOT NULL,
    pickup_location TEXT NOT NULL,
    delivery_location TEXT NOT NULL,
    distance_km DECIMAL(10,2) NOT NULL,
    booking_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    transport_date DATE NOT NULL,
    transport_status ENUM('pending', 'assigned', 'in_transit', 'delivered', 'cancelled') DEFAULT 'pending',
    total_cost DECIMAL(10,2) NOT NULL,
    driver_contact VARCHAR(20),
    notes TEXT,
    FOREIGN KEY (order_id) REFERENCES orders(order_id),
    FOREIGN KEY (service_id) REFERENCES transportation_services(service_id)
);

-- Coconut Disease Information
CREATE TABLE coconut_diseases (
    disease_id INT AUTO_INCREMENT PRIMARY KEY,
    disease_name VARCHAR(100) NOT NULL,
    scientific_name VARCHAR(100),
    symptoms TEXT NOT NULL,
    causes TEXT,
    prevention_methods TEXT NOT NULL,
    treatment_methods TEXT,
    images VARCHAR(255)
);

-- Service Providers (dealers, pickers, etc.)
CREATE TABLE service_providers (
    provider_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    service_type ENUM('coconut_picker', 'disease_specialist', 'equipment_supplier', 'other') NOT NULL,
    service_description TEXT NOT NULL,
    service_area VARCHAR(100),
    experience_years INT,
    hourly_rate DECIMAL(10,2),
    daily_rate DECIMAL(10,2),
    contact_method ENUM('phone', 'email', 'both') DEFAULT 'phone',
    is_verified BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

-- Reviews and Ratings
CREATE TABLE reviews (
    review_id INT AUTO_INCREMENT PRIMARY KEY,
    reviewer_id INT NOT NULL,
    target_id INT NOT NULL COMMENT 'Can be product_id or user_id',
    target_type ENUM('product', 'user', 'service') NOT NULL,
    rating TINYINT NOT NULL CHECK (rating BETWEEN 1 AND 5),
    review_text TEXT,
    review_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (reviewer_id) REFERENCES users(user_id)
);

-- Messages (for direct communication)
CREATE TABLE messages (
    message_id INT AUTO_INCREMENT PRIMARY KEY,
    sender_id INT NOT NULL,
    receiver_id INT NOT NULL,
    subject VARCHAR(100),
    message_text TEXT NOT NULL,
    sent_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    is_read BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (sender_id) REFERENCES users(user_id),
    FOREIGN KEY (receiver_id) REFERENCES users(user_id)
);

-- Notifications
CREATE TABLE notifications (
    notification_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    notification_type VARCHAR(50) NOT NULL,
    message TEXT NOT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    reference_id INT COMMENT 'ID of related entity (order, product, etc.)',
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);