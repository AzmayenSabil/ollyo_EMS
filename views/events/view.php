<?php
include __DIR__ . '../../layouts/header.php';
require_once __DIR__ . '../../models/Event.php';
require_once __DIR__ . '../../models/Attendee.php';

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

$attendeeModel = new Attendee();
$attendees = $attendeeModel->getAttendeesByEventId($event_id);

?>

<h2><?php echo htmlspecialchars($event["name"]); ?></h2>
<p><strong>Date:</strong> <?php echo htmlspecialchars($event["date"]); ?></p>
<p><strong>Time:</strong> <?php echo htmlspecialchars($event["time"]); ?></p>
<p><strong>Location:</strong> <?php echo htmlspecialchars($event["location"]); ?></p>
<p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($event["description"])); ?></p>

<h3>Registered Attendees</h3>
<ul>
    <?php if (count($attendees) > 0): ?>
        <?php foreach ($attendees as $attendee): ?>
            <li><?php echo htmlspecialchars($attendee["name"]); ?> (<?php echo htmlspecialchars($attendee["email"]); ?>)</li>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No attendees registered yet.</p>
    <?php endif; ?>
</ul>

<a href="<?php echo $baseUrl; ?>/events.php" class="btn btn-secondary">Back to Events</a>

<?php include __DIR__ . '../../layouts/footer.php'; ?>