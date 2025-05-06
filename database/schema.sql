
-- 1. Create the database
CREATE DATABASE  ticket_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;


-- Create users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create events table
CREATE TABLE events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    event_date DATE NOT NULL,
    venue VARCHAR(100) NOT NULL,
    available_seats INT NOT NULL
);

-- Create bookings table
CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    event_id INT NOT NULL,
    booking_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (event_id) REFERENCES events(id)
);

-- Optional: Insert sample events
INSERT INTO events (name, event_date, venue, available_seats) VALUES
('Music Fest 2025', '2025-06-20', 'Arena Hall', 50),
('Tech Conference', '2025-07-10', 'Expo Center', 100),
('Comedy Night', '2025-07-15', 'Downtown Club', 30);
