<?php include __DIR__ . '../../layouts/header.php'; ?>

<div class="container mt-5 min-vh-100">
    <h2 class="text-center mb-4 text-primary">Event Details</h2>

    <div class="card shadow-lg p-4">
        <table class="table table-bordered">
            <tr>
                <th class="bg-light text-dark">Name:</th>
                <td><?php echo htmlspecialchars($event["name"]); ?></td>
            </tr>
            <tr>
                <th class="bg-light text-dark">Date:</th>
                <td><?php echo htmlspecialchars($event["date"]); ?></td>
            </tr>
            <tr>
                <th class="bg-light text-dark">Time:</th>
                <td><?php echo htmlspecialchars($event["time"]); ?></td>
            </tr>
            <tr>
                <th class="bg-light text-dark">Location:</th>
                <td><?php echo htmlspecialchars($event["location"]); ?></td>
            </tr>
            <tr>
                <th class="bg-light text-dark">Description:</th>
                <td><?php echo nl2br(htmlspecialchars($event["description"])); ?></td>
            </tr>
        </table>

        <div class="text-center mt-3">
            <a href="<?php echo $baseUrl; ?>/events" class="btn btn-primary px-4">Back to Events</a>
        </div>
    </div>
</div>

<?php include __DIR__ . '../../layouts/footer.php'; ?>