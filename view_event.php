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
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body {
            background-color: #f8f9fa;
            /* Light gray background */
            color: #212529;
            /* Dark text */
        }

        .event-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .event-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .event-header h2 {
            font-size: 2rem;
            color: #343a40;
        }

        .event-details p {
            font-size: 1.1rem;
            margin: 10px 0;
        }

        .back-button {
            text-align: center;
            margin-top: 20px;
        }

        .back-button a {
            color: #ffffff;
            background-color: #007bff;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
        }

        .back-button a:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <?php require_once 'navbar.php'; ?>

    <div class="container event-container">
        <div class="event-header">
            <h2><?= htmlspecialchars($event['name']) ?></h2>
        </div>
        <div class="event-details">
            <p><strong>Date:</strong> <?= date("F j, Y", strtotime($event['date'])) ?></p>
            <p><strong>Location:</strong> <?= htmlspecialchars($event['location']) ?></p>
            <p><strong>Description:</strong></p>
            <p><?= nl2br(htmlspecialchars($event['description'])) ?></p>
        </div>
        <div class="back-button">
            <a href="dashboard.php">Back to Dashboard</a>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>