<?php
require_once 'Database.php';

class Attendee
{
    private $db;

    public function __construct()
    {
        $this->db = new Database(); // Initialize the database connection
    }

    public function registerForEvent($event_id, $user_id)
    {
        $stmt = $this->db->conn->prepare("INSERT INTO registrations (event_id, user_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $event_id, $user_id);
        return $stmt->execute();
    }

    public function getEventDetails($event_id)
    {
        $sql = "SELECT e.name AS event_name, e.date, e.time, e.location, e.max_capacity, u.username AS created_by, 
                       a.username AS attendee_name, a.email AS attendee_email
                FROM events e
                JOIN users u ON e.created_by = u.id
                LEFT JOIN registrations r ON e.id = r.event_id
                LEFT JOIN users a ON r.user_id = a.id
                WHERE e.id = ?";

        $stmt = $this->db->conn->prepare($sql);
        $stmt->bind_param("i", $event_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
