<?php
require_once "Database.php";

class Registration
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function registerUserForEvent($user_id, $event_id)
    {
        $sql = "INSERT INTO registrations (user_id, event_id) VALUES ('$user_id', '$event_id')";
        return $this->db->query($sql);
    }

    public function getEventAttendees($event_id)
    {
        $sql = "SELECT users.username, users.email FROM registrations 
                JOIN users ON registrations.user_id = users.id 
                WHERE registrations.event_id = '$event_id'";
        return $this->db->query($sql);
    }
}
