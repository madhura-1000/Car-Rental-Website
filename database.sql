-- Create database
CREATE DATABASE IF NOT EXISTS carzi_db;
USE carzi_db;

-- Create users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    address TEXT,
    license_number VARCHAR(50),
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create cars table
CREATE TABLE cars (
    id INT AUTO_INCREMENT PRIMARY KEY,
    model VARCHAR(100) NOT NULL,
    brand VARCHAR(100) NOT NULL,
    year INT NOT NULL,
    price_per_day DECIMAL(10, 2) NOT NULL,
    image VARCHAR(255),
    availability BOOLEAN DEFAULT TRUE,
    description TEXT
);

-- Create bookings table
CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    car_id INT NOT NULL,
    pickup_date DATE NOT NULL,
    return_date DATE NOT NULL,
    total_price DECIMAL(10, 2) NOT NULL,
    status ENUM('pending', 'confirmed', 'completed', 'cancelled') DEFAULT 'pending',
    booking_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (car_id) REFERENCES cars(id) ON DELETE CASCADE
);

-- Insert sample car data
INSERT INTO cars (model, brand, year, price_per_day, image, availability, description)
VALUES 
('Swift-Dzire', 'Maruti', 2023, 900, './assets/swift.png', TRUE, 'Compact sedan with excellent fuel efficiency'),
('Creta', 'Hyundai', 2023, 1000, './assets/creta.jpeg', FALSE, 'Popular SUV with comfortable interiors'),
('Amaze', 'Honda', 2022, 800, './assets/honda-amaze-2022.jpg', TRUE, 'Compact sedan with spacious interiors'),
('Venue', 'Hyundai', 2023, 900, './assets/venue.jpeg', TRUE, 'Compact SUV with modern features'),
('Hector', 'MG', 2022, 2000, './assets/20200921114059_Hector-dual-tone-1024x678.jpg', TRUE, 'Premium SUV with advanced tech features'),
('Baleno', 'Maruti', 2023, 1100, './assets/new-maruti-baleno-front-3-quarter-view.jpg', TRUE, 'Premium hatchback with modern styling'),
('Alto', 'Maruti', 2022, 800, './assets/maruti-alto-silky-silver.jpg', TRUE, 'Budget-friendly hatchback with great mileage');