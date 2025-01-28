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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Details - <?= htmlspecialchars($event['name']) ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

    <div class="container">
        <h2><?= htmlspecialchars($event['name']) ?></h2>
        <p><strong>Date:</strong> <?= date("F j, Y", strtotime($event['date'])) ?></p>
        <p><strong>Location:</strong> <?= htmlspecialchars($event['location']) ?></p>
        <p><strong>Description:</strong> <?= nl2br(htmlspecialchars($event['description'])) ?></p>

        <a href="dashboard.php">Back to Dashboard</a>
    </div>

</body>

</html>