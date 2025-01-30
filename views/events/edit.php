<?php
include __DIR__ . '../../layouts/header.php';
require_once __DIR__ . '../../models/Event.php';

if (!isset($_SESSION["user_id"])) {
    echo "<p class='alert alert-danger'>You must be logged in to edit an event.</p>";
    exit;
}

$user_id = $_SESSION["user_id"];
$is_admin = $_SESSION["is_admin"] ?? 0;

if (!isset($_GET["id"])) {
    echo "<p class='alert alert-danger'>Invalid event ID.</p>";
    exit;
}

$event_id = $_GET["id"];
$eventModel = new Event();
$event = $eventModel->getEventById($event_id);

if (!$event) {
    echo "<p class='alert alert-danger'>Event not found.</p>";
    exit;
}

if ($event["created_by"] != $user_id && $is_admin != 1) {
    echo "<p class='alert alert-danger'>You do not have permission to edit this event.</p>";
    exit;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"];
    $date = $_POST["date"];
    $time = $_POST["time"];
    $location = $_POST["location"];
    $description = $_POST["description"];

    $updateSuccess = $eventModel->updateEvent($event_id, $name, $date, $time, $location, $description);

    if ($updateSuccess) {
        echo "<p class='alert alert-success'>Event updated successfully.</p>";
        header("refresh:2;url={$baseUrl}/event/view?id=$event_id");
        exit;
    } else {
        echo "<p class='alert alert-danger'>Failed to update event. Please try again.</p>";
    }
}
?>

<h2>Edit Event</h2>
<form method="POST">
    <div class="form-group">
        <label for="name">Event Name</label>
        <input type="text" class="form-control" name="name" id="name" value="<?php echo htmlspecialchars($event["name"]); ?>" required>
    </div>

    <div class="form-group">
        <label for="date">Date</label>
        <input type="date" class="form-control" name="date" id="date" value="<?php echo htmlspecialchars($event["date"]); ?>" required>
    </div>

    <div class="form-group">
        <label for="time">Time</label>
        <input type="time" class="form-control" name="time" id="time" value="<?php echo htmlspecialchars($event["time"]); ?>" required>
    </div>

    <div class="form-group">
        <label for="location">Location</label>
        <input type="text" class="form-control" name="location" id="location" value="<?php echo htmlspecialchars($event["location"]); ?>" required>
    </div>

    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" name="description" id="description" rows="4" required><?php echo htmlspecialchars($event["description"]); ?></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Update Event</button>
    <a href="<?php echo $baseUrl; ?>/event/view?id=<?php echo $event_id; ?>" class="btn btn-secondary">Cancel</a>
</form>

<?php include __DIR__ . '../../layouts/footer.php'; ?>