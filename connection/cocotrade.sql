create database cocotrade;
use cocotrade;

create table users(userid INT primary key auto_increment,
       fname varchar(255),lname varchar(255),
       mail varchar(255),pswd varchar(255));

create table items(itemid INT primary key auto_increment,
                   itemname varchar(255),
                   itemprice decimal(9,2),
                   itemcategory varchar(100),
                   itemdetail text,
                   imgname varchar(255),
                   userid INT);


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
-- vehicles table
CREATE TABLE `vehicles` (
  `id` varchar(20) NOT NULL PRIMARY KEY,
  `name` varchar(50) NOT NULL,
  `type` enum('truck','van','car','bike') NOT NULL,
  `driver_id` varchar(20) DEFAULT NULL,
  `status` enum('active','inactive','maintenance') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- vehicle_positions table
CREATE TABLE `vehicle_positions` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `vehicle_id` varchar(20) NOT NULL,
  `latitude` decimal(10,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `speed` decimal(6,2) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`) ON DELETE CASCADE
);

-- Create an index for faster queries
CREATE INDEX `idx_vehicle_positions` ON `vehicle_positions` (`vehicle_id`, `timestamp`);

CREATE TABLE newsletter_subscribers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    subscribed_at DATETIME NOT NULL,
    is_active BOOLEAN DEFAULT TRUE
);
CREATE TABLE drivers (
    driver_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    profile_pic VARCHAR(255) DEFAULT 'default.jpg',
    license_number VARCHAR(50) NOT NULL,
    vehicle_type VARCHAR(50),
    location VARCHAR(100),
    contact_number VARCHAR(20),
    rating DECIMAL(3,2) DEFAULT 0.00,
    is_available BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (user_id) REFERENCES users(userid)
);

CREATE TABLE delivery_requests (
    request_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    driver_id INT,
    pickup_location TEXT NOT NULL,
    delivery_location TEXT NOT NULL,
    distance_km DECIMAL(10,2),
    estimated_time INT COMMENT 'in minutes',
    status ENUM('pending', 'accepted', 'in_progress', 'completed', 'rejected') DEFAULT 'pending',
    request_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    accepted_date DATETIME,
    completed_date DATETIME,
    price DECIMAL(10,2) NOT NULL,
    notes TEXT,
    FOREIGN KEY (driver_id) REFERENCES drivers(driver_id),
    FOREIGN KEY (order_id) REFERENCES orders(order_id)
);

request_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    accepted_date DATETIME,
    completed_date DATETIME,
    price DECIMAL(10,2) NOT NULL,
    notes TEXT,
    FOREIGN KEY (driver_id) REFERENCES drivers(driver_id),
    FOREIGN KEY (order_id) REFERENCES orders(order_id)
);