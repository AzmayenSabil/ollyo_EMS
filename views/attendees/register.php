<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Confirmation</title>
</head>

<body>
    <h1>Registration Status</h1>

    <?php if (!empty($successMessage)): ?>
        <div style="color: green;">
            <p><?php echo $successMessage; ?></p>
        </div>
        <script>
            setTimeout(function() {
                window.location.href = "/ollyo_EMS/events";
            }, 3000); // Redirect to event list after 3 seconds
        </script>
    <?php elseif (!empty($errorMessage)): ?>
        <div style="color: red;">
            <p><?php echo $errorMessage; ?></p>
        </div>
    <?php endif; ?>

</body>

</html>