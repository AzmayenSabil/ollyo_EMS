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
            if (!isset($_POST["event_id"]) || empty($_POST["event_id"])) {
                echo json_encode(["success" => false, "message" => "Invalid event ID."]);
                exit();
            }

            $event_id = intval($_POST["event_id"]);
            $user_id = intval($_SESSION["user_id"]);

            $attendeeModel = new Attendee();
            $result = $attendeeModel->registerForEvent($event_id, $user_id);

            if ($result) {
                echo json_encode(["success" => true, "message" => "Successfully registered!"]);
            } else {
                echo json_encode(["success" => false, "message" => "Registration failed. Event may be full or you are already registered."]);
            }
            exit();
        }
    }

    public function listRegisteredEvents()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION["user_id"])) {
            header("Location: login.php");
            exit();
        }

        $user_id = $_SESSION["user_id"];
        $attendeeModel = new Attendee();
        $registeredEvents = $attendeeModel->getRegisteredEvents($user_id);

        include "views/attendees/list.php"; // View to display registered events
    }

    public function getAttendees()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION["user_id"])) {
            header("Location: login.php");
            exit();
        }

        $user_id = $_SESSION["user_id"];
        $attendeeModel = new Attendee();
        $registeredEvents = $attendeeModel->getAttendees();

        include "views/attendees/list.php"; // View to display registered events
    }
}
