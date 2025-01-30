<?php include __DIR__ . '../../layouts/header.php'; ?>

<form method="POST">
    <div>
        <label for="name">Event Name:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($event['name']); ?>" required>
    </div>
    <div>
        <label for="date">Date:</label>
        <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($event['date']); ?>" required>
    </div>
    <div>
        <label for="time">Time:</label>
        <input type="time" id="time" name="time" value="<?php echo htmlspecialchars($event['time']); ?>" required>
    </div>
    <div>
        <label for="location">Location:</label>
        <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($event['location']); ?>" required>
    </div>
    <div>
        <label for="description">Description:</label>
        <textarea id="description" name="description"><?php echo htmlspecialchars($event['description']); ?></textarea>
    </div>
    <button type="submit">Update Event</button>
</form>

<?php include __DIR__ . '../../layouts/footer.php'; ?>