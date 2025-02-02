<?php
include __DIR__ . '../../layouts/header.php'; ?>

<div class="container mt-5 min-vh-100">
    <div class="card shadow-lg p-4 rounded">
        <h2 class="mb-4 text-center text-primary">Create Event</h2>
        <form method="POST" action="<?php echo $baseUrl; ?>/event/create">
            <div class="mb-3">
                <label class="form-label">Event Name</label>
                <input type="text" name="name" class="form-control" placeholder="Enter event name" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Event Description</label>
                <textarea name="description" class="form-control" rows="4" placeholder="Enter event details"></textarea>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Date</label>
                    <input type="date" name="date" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Time</label>
                    <input type="time" name="time" class="form-control" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Location</label>
                <input type="text" name="location" class="form-control" placeholder="Enter event location" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Max Capacity</label>
                <input type="number" name="max_capacity" class="form-control" placeholder="Enter max attendees" required>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg">Create Event</button>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '../../layouts/footer.php'; ?>