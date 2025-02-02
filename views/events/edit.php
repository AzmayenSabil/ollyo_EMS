<?php include __DIR__ . '../../layouts/header.php'; ?>

<div class="container mt-5 min-vh-100">
    <h2 class="text-center mb-4 text-primary">Update Event</h2>
    <form method="POST" class="p-4 shadow rounded bg-light">
        <div class="mb-3">
            <label for="name" class="form-label fw-bold">Event Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($event['name']); ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="date" class="form-label fw-bold">Date:</label>
            <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($event['date']); ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="time" class="form-label fw-bold">Time:</label>
            <input type="time" id="time" name="time" value="<?php echo htmlspecialchars($event['time']); ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="location" class="form-label fw-bold">Location:</label>
            <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($event['location']); ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label fw-bold">Description:</label>
            <textarea id="description" name="description" class="form-control" rows="4"><?php echo htmlspecialchars($event['description']); ?></textarea>
        </div>
        <button type="submit" class="btn btn-success w-100">Update Event</button>
    </form>
</div>

<?php include __DIR__ . '../../layouts/footer.php'; ?>