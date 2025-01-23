<?php
function create_event($name, $description, $date, $time, $location, $max_capacity, $created_by) {
    global $conn;
    
    $stmt = $conn->prepare("INSERT INTO events (name, description, date, time, location, max_capacity, created_by) 
                           VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssii", $name, $description, $date, $time, $location, $max_capacity, $created_by);
    
    return $stmt->execute();
}

function get_events($page = 1, $limit = 10, $search = '') {
    global $conn;
    
    $offset = ($page - 1) * $limit;
    $search = "%$search%";
    
    $stmt = $conn->prepare("SELECT * FROM events 
                           WHERE name LIKE ? OR description LIKE ?
                           ORDER BY date DESC, time DESC
                           LIMIT ? OFFSET ?");
    $stmt->bind_param("ssii", $search, $search, $limit, $offset);
    $stmt->execute();
    
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

function register_attendee($event_id, $user_id) {
    global $conn;
    
    // Check if event has reached capacity
    $stmt = $conn->prepare("SELECT COUNT(*) as count, events.max_capacity 
                           FROM registrations 
                           JOIN events ON events.id = registrations.event_id 
                           WHERE event_id = ?");
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    
    if ($result['count'] >= $result['max_capacity']) {
        return false;
    }
    
    $stmt = $conn->prepare("INSERT INTO registrations (event_id, user_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $event_id, $user_id);
    
    return $stmt->execute();
}

function get_event_attendees($event_id) {
    global $conn;
    
    $stmt = $conn->prepare("SELECT users.username, users.email, registrations.registration_date 
                           FROM registrations 
                           JOIN users ON users.id = registrations.user_id 
                           WHERE event_id = ?");
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}
?>