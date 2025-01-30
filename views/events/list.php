<?php include __DIR__ . '../../layouts/header.php'; ?>
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
                    <a href="<?php echo $baseUrl; ?>/event/register?id=<?php echo $event["id"]; ?>" class="btn btn-success">Register</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<?php include __DIR__ . '../../layouts/footer.php'; ?>