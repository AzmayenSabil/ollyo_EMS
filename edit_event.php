<?php
require_once './config/database.php';

// Check if event ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Event ID is missing.");
}

$event_id = intval($_GET['id']);

// Fetch event details
$sql = "SELECT * FROM events WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();
$event = $result->fetch_assoc();

// If event not found
if (!$event) {
    die("Event not found.");
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $date = trim($_POST["date"]);
    $location = trim($_POST["location"]);
    $description = trim($_POST["description"]);

    // Update event in database
    $update_sql = "UPDATE events SET name=?, date=?, location=?, description=? WHERE id=?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssssi", $name, $date, $location, $description, $event_id);

    if ($update_stmt->execute()) {
        echo "<script>alert('Event updated successfully!'); window.location.href='view_event.php?id={$event_id}';</script>";
        exit();
    } else {
        echo "Error updating event: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event - <?= htmlspecialchars($event['name']) ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

    <div class="container">
        <h2>Edit Event</h2>
        <form method="POST" action="">
            <label for="name">Event Name:</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($event['name']) ?>" required>

            <label for="date">Date:</label>
            <input type="date" id="date" name="date" value="<?= $event['date'] ?>" required>

            <label for="location">Location:</label>
            <input type="text" id="location" name="location" value="<?= htmlspecialchars($event['location']) ?>" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required><?= htmlspecialchars($event['description']) ?></textarea>

            <button type="submit">Update Event</button>
        </form>
        <br>
        <a href="view_event.php?id=<?= $event_id ?>">Cancel</a>
    </div>

</body>

</html>