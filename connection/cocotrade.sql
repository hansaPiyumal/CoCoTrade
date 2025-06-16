create database cocotrade;
use cocotrade;

create table users(userid INT primary key auto_increment,fname varchar(255),lname varchar(255),mail varchar(255),pswd varchar(255));

create table items(itemid INT primary key auto_increment,itemname varchar(255),itemprice decimal(9,2),itemcategory varchar(100),itemdetail text,imgname varchar(255),userid INT);


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