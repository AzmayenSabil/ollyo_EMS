<?php
// Declare global variables for database connection and DB_NAME
global $conn;
global $DB_NAME;

// Check if the environment variable for Cloud SQL is set
if (getenv('CLOUDSQL_DSN')) {
    // Cloud SQL connection using environment variables
    $dsn = getenv('CLOUDSQL_DSN');
    $user = getenv('CLOUDSQL_USER');
    $password = getenv('CLOUDSQL_PASSWORD');
    $DB_NAME = getenv('CLOUDSQL_DB'); // Set DB_NAME from environment variable

    // Create the Cloud SQL connection
    $conn = new mysqli($dsn, $user, $password, $DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Cloud SQL connection failed: " . $conn->connect_error);
    }
} else {
    // Local database configuration
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', 'admin');
    define('DB_NAME', 'event_management'); // Declare DB_NAME globally

    // Set global $DB_NAME
    $DB_NAME = DB_NAME;

    // Establish local database connection
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, $DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Local connection failed: " . $conn->connect_error);
    }
}

// Select the database (DB_NAME)
$conn->select_db($DB_NAME);

// Initialize database and tables
function initializeDatabase($conn)
{
    global $DB_NAME;  // Access global DB_NAME

    $queries = [
        "CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) UNIQUE NOT NULL,
            password VARCHAR(255) NOT NULL,
            email VARCHAR(100) UNIQUE NOT NULL,
            is_admin BOOLEAN DEFAULT FALSE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )",

        "CREATE TABLE IF NOT EXISTS events (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            description TEXT,
            date DATE NOT NULL,
            time TIME NOT NULL,
            location VARCHAR(200) NOT NULL,
            max_capacity INT NOT NULL,
            created_by INT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE CASCADE
        )",

        "CREATE TABLE IF NOT EXISTS registrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            event_id INT,
            user_id INT,
            registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            UNIQUE KEY unique_registration (event_id, user_id)
        )"
    ];

    foreach ($queries as $query) {
        if ($conn->query($query) === FALSE) {
            die("Error initializing table: " . $conn->error);
        }
    }
}

// Run the database initialization
initializeDatabase($conn);

// Ensure UTF-8 encoding
$conn->set_charset("utf8");

// Uncomment this line for debugging purposes
// echo "Database and tables initialized successfully!";
