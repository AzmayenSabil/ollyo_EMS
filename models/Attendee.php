<?php
require_once 'config.php';

class Attendee
{
    public function registerForEvent($event_id, $user_id)
    {
        global $conn;
        $stmt = $conn->prepare("INSERT INTO registrations (event_id, user_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $event_id, $user_id);
        return $stmt->execute();
    }

    public function getAllAttendees()
    {
        global $conn;
        $sql = "SELECT users.username, events.name AS event_name 
                FROM registrations
                JOIN users ON registrations.user_id = users.id
                JOIN events ON registrations.event_id = events.id";
        return $conn->query($sql);
    }
}
