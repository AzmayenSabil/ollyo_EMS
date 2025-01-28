<?php
require_once 'config/database.php';
require_once 'includes/auth.php';
require_once 'includes/event_functions.php';

if (!is_logged_in()) {
    header('Location: login.php');
    exit();
}

// Check if an event ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Event ID is required.");
}

$event_id = (int)$_GET['id'];

// Fetch event attendees from the database
$attendees = get_attendees_by_event($event_id);

if (empty($attendees)) {
    die("No attendees found for this event.");
}

// Create CSV headers
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="attendees_' . $event_id . '.csv"');

// Open a file pointer to PHP output (instead of a file)
$output = fopen('php://output', 'w');

// Write the column headers to the CSV file
fputcsv($output, ['Name', 'Email', 'Phone', 'Registration Date']);

// Write the data for each attendee
foreach ($attendees as $attendee) {
    fputcsv($output, [
        $attendee['name'],
        $attendee['email'],
        $attendee['phone'],
        $attendee['registration_date'],
    ]);
}

// Close the file pointer
fclose($output);
exit();
