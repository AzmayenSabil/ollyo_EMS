<?php
require_once 'models/Attendee.php';

class AttendeeController
{
    public function registerAttendee()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION["user_id"])) {
            echo json_encode(["success" => false, "message" => "You need to login first."]);
            exit();
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $event_id = $_POST["event_id"];
            $user_id = $_SESSION["user_id"];

            $attendeeModel = new Attendee();
            $result = $attendeeModel->registerForEvent($event_id, $user_id);

            if ($result) {
                echo json_encode(["success" => true, "message" => "Successfully registered!"]);
            } else {
                echo json_encode(["success" => false, "message" => "Failed to register, try again."]);
            }
            exit();
        }
    }

    public function listEventDetails($event_id)
    {
        $attendeeModel = new Attendee();
        $eventDetails = $attendeeModel->getEventDetails($event_id); // Fetch everything related to the event

        include "views/events/details.php"; // Updated to a more relevant view
    }

    public function exportEventDetails($event_id)
    {
        $attendeeModel = new Attendee();
        $eventDetails = $attendeeModel->getEventDetails($event_id); // Fetch all related data

        // Implement logic to export the list (for example, CSV)
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="event_details.csv"');

        $output = fopen('php://output', 'w');
        fputcsv($output, ['Event Name', 'Date', 'Time', 'Location', 'Capacity', 'Created By', 'Attendee Name', 'Attendee Email']);

        foreach ($eventDetails as $detail) {
            fputcsv($output, $detail);
        }

        fclose($output);
        exit();
    }
}
