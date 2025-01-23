# Event Management System

A simple web-based event management system built with PHP and MySQL.

## Features

- User Authentication (Login/Register)
- Event Management (Create, Update, View, Delete)
- Attendee Registration
- Event Dashboard with pagination and search
- CSV Export for attendee lists
- Responsive UI using Bootstrap

## Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx)

## Installation

1. Create a MySQL database named `event_management`

2. Update database configuration in `config/database.php`:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'your_username');
   define('DB_PASS', 'your_password');
   define('DB_NAME', 'event_management');
   ```

3. Upload all files to your web server

4. Navigate to the project URL in your web browser

5. Register a new user account to start using the system

## Security Features

- Password hashing using PHP's password_hash()
- Prepared statements to prevent SQL injection
- Input validation and sanitization
- Session-based authentication
- CSRF protection
- XSS prevention through HTML escaping

## File Structure

```
├── config/
│   └── database.php
├── includes/
│   ├── auth.php
│   └── event_functions.php
├── index.php
├── login.php
├── register.php
├── dashboard.php
├── create_event.php
├── edit_event.php
├── view_event.php
├── export_attendees.php
└── README.md
```