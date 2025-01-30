<?php
require_once 'config.php';

class Event
{
    public function getAllEvents()
    {
        global $conn;
        $sql = "SELECT * FROM events ORDER BY date, time";
        return $conn->query($sql);
    }

    public function getEventById($event_id)
    {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM events WHERE id = ?");
        $stmt->bind_param("i", $event_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc(); // Fetch the event as an associative array
    }

    public function createEvent($name, $description, $date, $time, $location, $capacity, $created_by)
    {
        global $conn;
        $stmt = $conn->prepare("INSERT INTO events (name, description, date, time, location, max_capacity, created_by) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssis", $name, $description, $date, $time, $location, $capacity, $created_by);
        return $stmt->execute();
    }

    public function updateEvent($event_id, $name, $date, $time, $location, $description)
    {
        // Use prepared statement to update event details
        try {
            global $conn;

            // Prepare the SQL query
            $query = "UPDATE events SET name = ?, date = ?, time = ?, location = ?, description = ? WHERE id = ?";
            $stmt = $conn->prepare($query);

            // Check if the statement is prepared successfully
            if (!$stmt) {
                throw new Exception("Failed to prepare the SQL statement: " . $conn->error);
            }

            // Bind parameters to the query
            $stmt->bind_param("sssssi", $name, $date, $time, $location, $description, $event_id);

            // Execute the statement
            $result = $stmt->execute();

            // Check if the update was successful
            if ($result) {
                return true; // Return true if the update was successful
            } else {
                throw new Exception("Error executing query: " . $stmt->error);
            }
        } catch (Exception $e) {
            // Log the error for debugging purposes
            error_log("Error updating event: " . $e->getMessage());
            return false; // Return false if an error occurred
        }
    }


    public function getAttendeesByEventId($event_id)
    {
        global $conn;
        $stmt = $conn->prepare("
            SELECT users.id, users.name, users.email 
            FROM attendees 
            JOIN users ON attendees.user_id = users.id 
            WHERE attendees.event_id = ?
        ");
        $stmt->bind_param("i", $event_id);
        $stmt->execute();
        return $stmt->get_result();
    }
}
