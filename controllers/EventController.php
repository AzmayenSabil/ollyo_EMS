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

    public function viewEvent()
    {
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            echo "Invalid event ID.";
            return;
        }

        $event_id = intval($_GET['id']);
        $eventModel = new Event();
        $event = $eventModel->getEventById($event_id);

        if (!$event) {
            echo "Event not found.";
            return;
        }

        include 'views/events/view.php';
    }

    public function editEvent()
    {
        $baseFolder = '/ollyo_EMS'; // Base folder for your application

        // Check if the event ID is set and valid
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            echo "Invalid event ID.";
            return;
        }

        $event_id = intval($_GET['id']); // Sanitize the event ID

        // Create the Event model instance
        $eventModel = new Event();

        // Fetch the event details from the database
        $event = $eventModel->getEventById($event_id);

        // Check if the event exists
        if (!$event) {
            echo "Event not found.";
            return;
        }

        // If the form is submitted, handle the update process
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sanitize and validate form inputs
            $name = trim($_POST['name'] ?? '');
            $date = trim($_POST['date'] ?? '');
            $time = trim($_POST['time'] ?? '');
            $location = trim($_POST['location'] ?? '');
            $description = trim($_POST['description'] ?? '');

            // Perform basic validation
            if (empty($name) || empty($date) || empty($time) || empty($location)) {
                echo "All fields are required.";
                return;
            }

            // Update the event details
            $updateResult = $eventModel->updateEvent($event_id, $name, $date, $time, $location, $description);

            if ($updateResult) {
                // Redirect to the event view page on success
                header('Location: ' . $baseFolder . '/events/view?id=' . $event_id);
                exit();
            } else {
                echo "Failed to update event.";
            }
        }

        // Include the edit view with event details to pre-populate the form
        include 'views/events/edit.php';
    }

}
