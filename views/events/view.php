<?php include __DIR__ . '../../layouts/header.php'; ?>

<h2>Event Details</h2>
<table class="table">
    <tr>
        <th>Name:</th>
        <td><?php echo htmlspecialchars($event["name"]); ?></td>
    </tr>
    <tr>
        <th>Date:</th>
        <td><?php echo htmlspecialchars($event["date"]); ?></td>
    </tr>
    <tr>
        <th>Time:</th>
        <td><?php echo htmlspecialchars($event["time"]); ?></td>
    </tr>
    <tr>
        <th>Location:</th>
        <td><?php echo htmlspecialchars($event["location"]); ?></td>
    </tr>
    <tr>
        <th>Description:</th>
        <td><?php echo nl2br(htmlspecialchars($event["description"])); ?></td>
    </tr>
</table>

<a href="<?php echo $baseUrl; ?>/events" class="btn btn-primary">Back to Events</a>

<?php include __DIR__ . '../../layouts/footer.php'; ?>