<?php
include __DIR__ . '../../layouts/header.php';

if (isset($_SESSION["user_id"])) {
    $user_id = $_SESSION["user_id"];
    $is_admin = $_SESSION["is_admin"] ?? 0;
    $attendeeModel = new Attendee();
    $registeredEvents = $attendeeModel->getRegisteredEvents($user_id);
} else {
    $user_id = null;
    $is_admin = 0;
    $registeredEvents = [];
}

// Fetch sorting, filtering, and pagination parameters
$search = $_GET['search'] ?? '';
$sort_by = $_GET['sort_by'] ?? 'date';
$sort_order = $_GET['sort_order'] ?? 'ASC';
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$limit = 5;
$offset = ($page - 1) * $limit;

$eventModel = new Event();
$events = $eventModel->getFilteredEvents($search, $sort_by, $sort_order, $limit, $offset);
$total_events = $eventModel->getTotalEvents($search);
$total_pages = ceil($total_events / $limit);
?>

<script>
    var registeredEvents = <?php echo json_encode($registeredEvents); ?>;
</script>

<div class="d-flex flex-column min-vh-100">
    <div class="container flex-grow-1">
        <h2 class="my-4">Upcoming Events</h2>
        <form method="GET" class="mb-3 d-flex">
            <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Search events..." class="form-control me-2">
            <button type="submit" class="btn btn-primary">Search</button>
            <a href="?page=1" class="btn btn-secondary ms-2">Clear Filters</a>
        </form>


        <table class="table table-striped table-bordered shadow-sm rounded">
            <thead>
                <tr>
                    <th><a href="?sort_by=name&sort_order=<?php echo $sort_order == 'ASC' ? 'DESC' : 'ASC'; ?>">Name</a></th>
                    <th><a href="?sort_by=date&sort_order=<?php echo $sort_order == 'ASC' ? 'DESC' : 'ASC'; ?>">Date</a></th>
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
                            <a href="<?php echo $baseUrl; ?>/event/view?id=<?php echo $event["id"]; ?>" class="btn btn-info btn-sm">View</a>
                            <?php if ($user_id): ?>
                                <button class="btn btn-success btn-sm register-btn" data-event-id="<?php echo $event["id"]; ?>"
                                    <?php echo in_array($event["id"], array_column($registeredEvents, 'id')) ? 'disabled' : ''; ?>>
                                    <?php echo in_array($event["id"], array_column($registeredEvents, 'id')) ? 'Registered' : 'Register'; ?>
                                </button>
                                <?php if ($is_admin == 1 || $event["created_by"] == $user_id): ?>
                                    <a href="<?php echo $baseUrl; ?>/event/edit?id=<?php echo $event["id"]; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="<?php echo $baseUrl; ?>/event/export?event_id=<?php echo $event["id"]; ?>" class="btn btn-secondary btn-sm">Export List</a>
                                <?php endif; ?>
                            <?php else: ?>
                                <a href="<?php echo $baseUrl; ?>/login" class="btn btn-primary btn-sm">Login to Register</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Pagination -->
        <nav>
            <ul class="pagination">
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?php echo $i == $page ? 'active' : ''; ?> me-2">
                        <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>&sort_by=<?php echo $sort_by; ?>&sort_order=<?php echo $sort_order; ?>">
                            <?php echo $i; ?>
                        </a>
                    </li>
                <?php endfor; ?>
            </ul>

        </nav>
    </div>
</div>

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
                            registeredEvents.push({
                                id: eventId
                            });
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