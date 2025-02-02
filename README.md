# OLLYO Event Management System

A web-based event management system built with PHP and MySQL.

## Features

- **User Authentication**
  - Login
  - Register
- **Event Management**
  - Create new events
  - View event details
  - Edit own events
  - Export attendee list (CSV) for own events
- **Access Control**
  - Only event creators can edit their events
  - Only event creators can export attendee lists
- **Security Implementation**
  - Password hashing
  - Prepared statements for database queries
  - Session-based authentication
  - Input validation and sanitization
  - XSS prevention through HTML escaping

## Database Structure & Design Rationale

### **Users Table** (`users`)
```sql
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `is_admin` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
);
```
**Design Choices:**
- `username` and `email` are **unique** to prevent duplicate accounts.
- `password` is stored securely with hashing.
- `is_admin` is a **boolean flag** (tinyint) for role-based access control.
- `created_at` stores **registration timestamp**.

### **Events Table** (`events`)
```sql
CREATE TABLE `events` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `location` varchar(200) NOT NULL,
  `max_capacity` int NOT NULL,
  `created_by` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `events_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`)
);
```
**Design Choices:**
- `name`, `date`, `time`, `location` are required fields.
- `max_capacity` ensures **event capacity management**.
- `created_by` is a **foreign key** linking to `users` to track the creator.
- `created_at` helps **log event creation timestamps**.

### **Registrations Table** (`registrations`)
```sql
CREATE TABLE `registrations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `event_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `registration_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_registration` (`event_id`,`user_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `registrations_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`),
  CONSTRAINT `registrations_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
);
```
**Design Choices:**
- `event_id` and `user_id` create a **many-to-many relationship** between `users` and `events`.
- `UNIQUE KEY (event_id, user_id)` ensures **one registration per user per event**.
- Foreign keys maintain **referential integrity**.
- `registration_date` automatically logs the registration timestamp.

## Requirements

- PHP 8.2.12
- MySQL 8.0.32

## Installation

1. Create a MySQL database named `event_management`.
2. Update database configuration in `config/config.php`:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'your_username');
   define('DB_PASS', 'your_password');
   define('DB_NAME', 'event_management');
   ```
3. Upload all files to your web server.
4. Navigate to the project URL in your web browser.
5. Register a new user account to start using the system.

## Project Structure

```
OLLYO_EMS/
├── config/
│   └── config.php
├── controllers/
│   ├── AttendeeController.php
│   ├── AuthController.php
│   └── EventController.php
├── models/
│   ├── Attendee.php
│   ├── Database.php
│   ├── Event.php
│   ├── Registration.php
│   └── User.php
├── views/
│   ├── attendees/
│   │   ├── list.php
│   │   └── register.php
│   ├── auth/
│   │   ├── login.php
│   │   └── register.php
│   └── events/
│       ├── create.php
│       ├── edit.php
│       ├── list.php
│       └── view.php
├── layouts/
├── .htaccess
├── index.php
└── routes.php
```


## Images

Login Page: [Insert Image Placeholder]
Register Page: [Insert Image Placeholder]
Create Event Page: [Insert Image Placeholder]
View Event Page: [Insert Image Placeholder]
Edit Event Page: [Insert Image Placeholder]
Landing Page: [Insert Image Placeholder]

## Credits

Built as a task for OLLYO.