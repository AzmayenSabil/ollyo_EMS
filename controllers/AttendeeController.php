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


    public function listAttendees($event_id)
    {
        $attendeeModel = new Attendee();
        $attendees = $attendeeModel->getAttendeesByEvent($event_id);

        include "views/attendees/list.php";
    }

    public function exportAttendees($event_id)
    {
        $attendeeModel = new Attendee();
        $attendees = $attendeeModel->getAttendeesByEvent($event_id);

        // Implement logic to export the list (for example, CSV)
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="attendees.csv"');

        $output = fopen('php://output', 'w');
        fputcsv($output, ['ID', 'Name', 'Email']);

        foreach ($attendees as $attendee) {
            fputcsv($output, $attendee);
        }

        fclose($output);
        exit();
    }
}
