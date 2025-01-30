<?php
require_once 'Database.php';

class Attendee
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function registerForEvent($event_id, $user_id)
    {
        $checkStmt = $this->db->conn->prepare("SELECT COUNT(*) FROM registrations WHERE event_id = ? AND user_id = ?");
        $checkStmt->bind_param("ii", $event_id, $user_id);
        $checkStmt->execute();
        $checkStmt->bind_result($count);
        $checkStmt->fetch();
        $checkStmt->close();

        if ($count > 0) {
            return false; // User already registered
        }

        $capacityStmt = $this->db->conn->prepare("SELECT max_capacity FROM events WHERE id = ?");
        $capacityStmt->bind_param("i", $event_id);
        $capacityStmt->execute();
        $capacityStmt->bind_result($max_capacity);
        $capacityStmt->fetch();
        $capacityStmt->close();

        $countStmt = $this->db->conn->prepare("SELECT COUNT(*) FROM registrations WHERE event_id = ?");
        $countStmt->bind_param("i", $event_id);
        $countStmt->execute();
        $countStmt->bind_result($current_attendees);
        $countStmt->fetch();
        $countStmt->close();

        if ($current_attendees >= $max_capacity) {
            return false; // Event is full
        }

        $stmt = $this->db->conn->prepare("INSERT INTO registrations (event_id, user_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $event_id, $user_id);
        return $stmt->execute();
    }

    public function getRegisteredEvents($user_id)
    {
        $sql = "SELECT e.id, e.name, e.date, e.location FROM events e 
                JOIN registrations r ON e.id = r.event_id 
                WHERE r.user_id = ?";

        $stmt = $this->db->conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
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
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC); // Fetch the result as an associative array
    }

    public function getAttendees()
    {
        global $conn;
        $stmt = $conn->prepare("
        SELECT users.id, users.name, users.email 
        FROM attendees 
        JOIN users ON attendees.user_id = users.id 
    ");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC); // Fetch the result as an associative array
    }

}
