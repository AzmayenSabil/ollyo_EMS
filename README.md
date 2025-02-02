# OLLYO Event Management System

A comprehensive web-based event management system built with PHP and MySQL, designed to streamline event organization and attendee management.

## ✨ Features

### User Authentication
- Secure login system
- User registration with email verification
- Password recovery functionality

### Event Management
- Create and publish new events
- View comprehensive event details
- Edit existing events
- Real-time capacity tracking
- Export attendee lists in CSV format

### Access Control
- Role-based permissions system
- Event creator privileges
- Admin dashboard for system oversight

### Security Implementation
- Password hashing using modern algorithms
- Prepared statements for SQL injection prevention
- Session-based authentication
- Comprehensive input validation
- XSS prevention through HTML escaping

## 🛠 Technical Requirements

- PHP 8.2.12 or higher
- MySQL 8.0.32 or higher
- Apache/Nginx web server
- mod_rewrite enabled

## 📦 Installation

1. **Database Setup**
   ```sql
   CREATE DATABASE event_management;
   ```

2. **Configuration**
   - Navigate to `config/config.php`
   - Update database credentials:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'your_username');
   define('DB_PASS', 'your_password');
   define('DB_NAME', 'event_management');
   ```

3. **File Deployment**
   - Upload all files to your web server
   - Ensure proper permissions are set
   - Configure web server for PHP execution

4. **Initial Setup**
   - Navigate to the project URL
   - Register an admin account
   - Begin creating and managing events

## 📁 Project Structure

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

## 🛡️ Security Features

### Database Security
- Prepared statements for all queries
- Input validation and sanitization
- Parameterized queries

### User Authentication
- Secure password hashing
- Session management
- CSRF protection
- Rate limiting on login attempts

### Access Control
- Role-based permissions
- Event ownership verification
- Secure file handling

## 💾 Database Structure

### Users Table
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

### Events Table
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

### Registrations Table
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

## 📸 Screenshots

### Landing Page
![1](https://github.com/user-attachments/assets/0949bcc0-de87-4eb3-a638-45fe308ef001)

### User Authentication
![5](https://github.com/user-attachments/assets/5bf9ea33-66f3-4940-a256-78965fc8ca00)
![6](https://github.com/user-attachments/assets/7b6d4e76-b2c7-4f70-9376-af731074065c)

### Event Management
![2](https://github.com/user-attachments/assets/3e18de91-90d8-4de3-b1e7-ac714af6e53e)
![3](https://github.com/user-attachments/assets/3932dc68-df66-4689-89a2-529c60246926)
![4](https://github.com/user-attachments/assets/3e23a066-86cb-41ee-9c4e-a209d93cbfb6)


## 👥 Credits

Built as a technical assessment task for OLLYO.

## 📧 Support

For support and queries, please contact the development team at [contact information].
