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

function register_attendee($event_id, $user_id)
{
    global $conn;

    // Check if event has reached capacity
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM registrations WHERE event_id = ?");
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    // Get the event's max capacity
    $stmt = $conn->prepare("SELECT max_capacity FROM events WHERE id = ?");
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $event = $stmt->get_result()->fetch_assoc();

    // Compare the number of registrations with max_capacity
    if ($result['count'] >= $event['max_capacity']) {
        return false;
    }

    $stmt = $conn->prepare("INSERT INTO registrations (event_id, user_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $event_id, $user_id);

    return $stmt->execute();
}

function is_user_registered($event_id, $user_id)
{
    global $conn;

    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM registrations WHERE event_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $event_id, $user_id);
    $stmt->execute();

    $result = $stmt->get_result()->fetch_assoc();

    return $result['count'] > 0;  // Return true if user is already registered
}

function get_attendees_by_event($event_id) {
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