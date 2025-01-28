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
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .event-container {
            max-width: 800px;
            margin: 0 auto;
            padding-top: 50px;
        }

        .form-control,
        .form-textarea {
            margin-bottom: 15px;
        }

        .btn {
            width: 100%;
            padding: 10px;
        }

        .edit-cancel-btn {
            display: inline-block;
            margin-top: 15px;
            text-decoration: none;
            color: #007bff;
        }
    </style>
</head>

<body>
    <?php require_once 'navbar.php'; ?>

    <div class="event-container">
        <h2>Edit Event</h2>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="name" class="form-label">Event Name:</label>
                <input type="text" id="name" name="name" value="<?= htmlspecialchars($event['name']) ?>" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="date" class="form-label">Date:</label>
                <input type="date" id="date" name="date" value="<?= $event['date'] ?>" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="location" class="form-label">Location:</label>
                <input type="text" id="location" name="location" value="<?= htmlspecialchars($event['location']) ?>" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description:</label>
                <textarea id="description" name="description" class="form-control" rows="4" required><?= htmlspecialchars($event['description']) ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Update Event</button>
        </form>

        <a class="edit-cancel-btn" href="view_event.php?id=<?= $event_id ?>">Cancel</a>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>