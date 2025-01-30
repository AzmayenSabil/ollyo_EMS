<?php
include __DIR__ . '../../layouts/header.php';

// Ensure $registeredEvents is an array
$registeredEvents = $registeredEvents ?? [];
?>

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
                    <?php if (isset($_SESSION["user_id"])): ?>
                        <button
                            class="btn btn-success register-btn"
                            data-event-id="<?php echo $event["id"]; ?>"
                            <?php echo in_array($event["id"], $registeredEvents) ? 'disabled' : ''; ?>>
                            <?php echo in_array($event["id"], $registeredEvents) ? 'Registered' : 'Register'; ?>
                        </button>
                    <?php else: ?>
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
                            btn.innerText = "Registered";
                            btn.disabled = true;
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