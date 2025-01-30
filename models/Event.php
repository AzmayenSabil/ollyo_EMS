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

    public function createEvent($name, $description, $date, $time, $location, $capacity, $created_by)
    {
        global $conn;
        $stmt = $conn->prepare("INSERT INTO events (name, description, date, time, location, max_capacity, created_by) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssis", $name, $description, $date, $time, $location, $capacity, $created_by);
        return $stmt->execute();
    }
}
