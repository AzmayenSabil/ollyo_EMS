<?php
require_once 'models/Event.php';

class EventController
{
    public function listEvents()
    {
        // Initialize the Event model
        $eventModel = new Event();
        $events = $eventModel->getAllEvents();

        // Make the base URL dynamic to handle proper redirects with the 'ollyo_EMS' prefix
        $baseUrl = 'http://' . $_SERVER['HTTP_HOST'] . '/ollyo_EMS';

        // Pass events and base URL to the view
        include "views/events/list.php";
    }

    public function createEvent()
    {
        // Start session only if it's not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Check if user is logged in
        if (!isset($_SESSION["user_id"])) {
            header("Location: /ollyo_EMS/login");
            exit();
        }

        // Handle event creation
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST["name"];
            $description = $_POST["description"];
            $date = $_POST["date"];
            $time = $_POST["time"];
            $location = $_POST["location"];
            $capacity = $_POST["max_capacity"];
            $created_by = $_SESSION["user_id"];

            // Create event in the database
            $eventModel = new Event();
            $result = $eventModel->createEvent($name, $description, $date, $time, $location, $capacity, $created_by);

            // Redirect after successful creation
            if ($result) {
                header("Location: /ollyo_EMS/events");
                exit();
            } else {
                echo "Failed to create event.";
            }
        } else {
            // Show the event creation form
            include "views/events/create.php";
        }
    }
}
