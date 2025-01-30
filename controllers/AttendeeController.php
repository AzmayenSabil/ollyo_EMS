<?php
require_once 'models/Attendee.php';

class AttendeeController
{
    public function registerAttendee()
    {
        // Check if session is already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Check if user is logged in
        if (!isset($_SESSION["user_id"])) {
            header("Location: /ollyo_EMS/login");
            exit();
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $event_id = $_POST["event_id"];
            $user_id = $_SESSION["user_id"];

            $attendeeModel = new Attendee();
            $result = $attendeeModel->registerForEvent($event_id, $user_id);

            // Check if registration was successful
            if ($result) {
                $successMessage = "You have successfully registered for the event!";
            } else {
                $errorMessage = "Failed to register for the event. Please try again.";
            }
        }

        // Use an absolute path for including the view file
        include __DIR__ . '/../views/attendees/register.php';  // Ensure the path is correct
    }

    public function listAttendees()
    {
        $attendeeModel = new Attendee();
        $attendees = $attendeeModel->getAllAttendees();
        include "views/attendees/list.php";
    }
}
