<?php include __DIR__ . '../../layouts/header.php'; ?>

<style>


    h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #333;
    }

    label {
        font-weight: bold;
        margin-bottom: 8px;
        color: #555;
    }

    input,
    textarea {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 14px;
    }

    input[type="date"],
    input[type="time"] {
        font-size: 14px;
    }

    textarea {
        min-height: 120px;
        resize: vertical;
    }

    button {
        width: 100%;
        padding: 12px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    button:hover {
        background-color: #45a049;
    }

    .form-group {
        margin-bottom: 20px;
    }

    @media (max-width: 768px) {
        .container {
            padding: 15px;
        }

        input,
        textarea,
        button {
            font-size: 16px;
        }
    }
</style>

<div class="container">
    <h2>Update Event</h2>
    <form method="POST">
        <div class="form-group">
            <label for="name">Event Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($event['name']); ?>" required>
        </div>
        <div class="form-group">
            <label for="date">Date:</label>
            <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($event['date']); ?>" required>
        </div>
        <div class="form-group">
            <label for="time">Time:</label>
            <input type="time" id="time" name="time" value="<?php echo htmlspecialchars($event['time']); ?>" required>
        </div>
        <div class="form-group">
            <label for="location">Location:</label>
            <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($event['location']); ?>" required>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea id="description" name="description"><?php echo htmlspecialchars($event['description']); ?></textarea>
        </div>
        <button type="submit">Update Event</button>
    </form>
</div>

<?php include __DIR__ . '../../layouts/footer.php'; ?>