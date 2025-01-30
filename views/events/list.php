<?php
include __DIR__ . '../../layouts/header.php';

if (isset($_SESSION["user_id"])) {
    $user_id = $_SESSION["user_id"];
    $is_admin = $_SESSION["is_admin"] ?? 0; // Check if user is an admin
    $attendeeModel = new Attendee();
    $registeredEvents = $attendeeModel->getRegisteredEvents($user_id); // Get list of registered event IDs
} else {
    $user_id = null;
    $is_admin = 0;
    $registeredEvents = [];
}
?>

<script>
    var registeredEvents = <?php echo json_encode($registeredEvents); ?>;
    console.log("Fetched Events:", registeredEvents); // Log the events to the console
</script>

<h2>Upcoming Events</h2>
<table class="table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Date</th>
            <th>Time</th>
            <th>Location</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($event = $events->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($event["name"]); ?></td>
                <td><?php echo htmlspecialchars($event["date"]); ?></td>
                <td><?php echo htmlspecialchars($event["time"]); ?></td>
                <td><?php echo htmlspecialchars($event["location"]); ?></td>
                <td>
                    <!-- View Button (Always Visible) -->
                    <a href="<?php echo $baseUrl; ?>/event/view?id=<?php echo $event["id"]; ?>" class="btn btn-info">View</a>

                    <?php if ($user_id): ?>
                        <!-- Register Button (If Not Already Registered) -->
                        <button class="btn btn-success register-btn"
                            data-event-id="<?php echo $event["id"]; ?>"
                            <?php echo in_array($event["id"], array_column($registeredEvents, 'id')) ? 'disabled' : ''; ?>>
                            <?php echo in_array($event["id"], array_column($registeredEvents, 'id')) ? 'Registered' : 'Register'; ?>
                        </button>

                        <?php if ($is_admin == 1 || $event["created_by"] == $user_id): ?>
                            <!-- Show Edit & Export Buttons for Admins OR Event Creator -->
                            <a href="<?php echo $baseUrl; ?>/event/edit?id=<?php echo $event["id"]; ?>" class="btn btn-warning">Edit</a>
                            <a href="<?php echo $baseUrl; ?>/event/export?id=<?php echo $event["id"]; ?>" class="btn btn-secondary">Export List</a>
                        <?php endif; ?>
                    <?php else: ?>
                        <!-- If Not Logged In, Show Login Button -->
                        <a href="<?php echo $baseUrl; ?>/login" class="btn btn-primary">Login to Register</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".register-btn").forEach(button => {
            button.addEventListener("click", function() {
                let eventId = this.getAttribute("data-event-id");
                let btn = this;

                fetch("<?php echo $baseUrl; ?>/event/register", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded"
                        },
                        body: "event_id=" + eventId
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update the button text and disable it after successful registration
                            btn.innerText = "Registered";
                            btn.disabled = true;

                            // Optionally, update registered events list dynamically without reload
                            registeredEvents.push({
                                id: eventId
                            });
                            console.log("Updated Registered Events:", registeredEvents);

                            // You can optionally update the button on the frontend dynamically
                            // or even remove the button if you want it to disappear after registration.
                        } else {
                            alert(data.message);
                        }
                    })
                    .catch(error => console.error("Error:", error));
            });
        });
    });
</script>

<?php include __DIR__ . '../../layouts/footer.php'; ?>