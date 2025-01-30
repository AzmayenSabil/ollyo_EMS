<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Registration</title>
</head>

<body>
    <h1>Register for Event</h1>

    <?php if (isset($successMessage)): ?>
        <div style="color: green;">
            <p><?php echo $successMessage; ?></p>
        </div>
    <?php elseif (isset($errorMessage)): ?>
        <div style="color: red;">
            <p><?php echo $errorMessage; ?></p>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="event_id">Event ID:</label>
        <input type="text" id="event_id" name="event_id" required>
        <br>
        <button type="submit">Register</button>
    </form>
</body>

</html>