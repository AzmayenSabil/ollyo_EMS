<?php
require_once 'config/database.php';
require_once 'includes/auth.php';
require_once 'includes/event_functions.php';

// Ensure the user is logged in
if (!is_logged_in()) {
    header("Location: login.php");
    exit();
}

// Get the event ID from the URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid event ID.");
}

$event_id = $_GET['id'];

// Get the user ID (assuming you're storing it in the session after login)
$user_id = $_SESSION['user_id'];  // Assuming session contains the logged-in user's ID

// Attempt to register the user for the event
$registration_success = register_attendee($event_id, $user_id);

// After processing the registration, redirect back to the index page with the status and event_id
header('Location: index.php?registration=success&event_id=' . $event_id);

exit();
