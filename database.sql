CREATE DATABASE internship_tracker;

USE internship_tracker;

CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100),
    phone VARCHAR(20),
    company VARCHAR(100),
    start_date DATE,
    end_date DATE
);

CREATE TABLE logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    log_date DATE,
    start_time TIME,
    end_time TIME,
    hours DECIMAL(5,1),
    task VARCHAR(255),
    status VARCHAR(50),
    feedback TEXT
);