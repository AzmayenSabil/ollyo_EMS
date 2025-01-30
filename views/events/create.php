<?php
include __DIR__ . '../../layouts/header.php'; ?>

<h2>Create Event</h2>
<form method="POST" action="<?php echo $baseUrl; ?>/event/create">
    <input type="text" name="name" placeholder="Event Name" required>
    <textarea name="description" placeholder="Event Description"></textarea>
    <input type="date" name="date" required>
    <input type="time" name="time" required>
    <input type="text" name="location" placeholder="Location" required>
    <input type="number" name="max_capacity" placeholder="Max Capacity" required>
    <button type="submit">Create Event</button>
</form>

<?php include __DIR__ . '../../layouts/footer.php'; ?>