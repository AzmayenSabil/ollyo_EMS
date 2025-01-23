<?php
require_once 'config/database.php';
require_once 'includes/auth.php';
require_once 'includes/event_functions.php';

if (!is_logged_in() || (!is_admin() && $_GET['created_by'] != $_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$event_id = (int)$_GET['id'];
$attendees = get_event_attendees($event_id);

// Set headers for CSV download
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="event_attendees.csv"');

// Create CSV file
$output = fopen('php://output', 'w');

// Add CSV headers
fputcsv($output, ['Username', 'Email', 'Registration Date']);

// Add attendee data
foreach ($attendees as $attendee) {
    fputcsv($output, [
        $attendee['username'],
        $attendee['email'],
        $attendee['registration_date']
    ]);
}

fclose($output);
?>