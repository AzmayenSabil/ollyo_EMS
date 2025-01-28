<?php
require_once 'config/database.php';
require_once 'includes/auth.php';
require_once 'includes/event_functions.php';

$events = get_events(1, 5);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Ensure the footer sticks to the bottom */
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }

        main {
            flex: 1;
        }

        footer {
            text-align: center;
        }
    </style>
</head>

<body>
    <?php require_once 'navbar.php'; ?>

    <div class="container mt-4">
        <h1>Upcoming Events</h1>
        <div class="row">
            <?php foreach ($events as $event): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($event['name']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($event['description']); ?></p>
                            <p class="card-text">
                                <small class="text-muted">
                                    Date: <?php echo $event['date']; ?><br>
                                    Time: <?php echo $event['time']; ?><br>
                                    Location: <?php echo htmlspecialchars($event['location']); ?>
                                </small>
                            </p>
                            <?php if (is_logged_in()): ?>
                                <a href="register_event.php?id=<?php echo $event['id']; ?>" class="btn btn-primary">Register</a>
                            <?php else: ?>
                                <a href="login.php" class="btn btn-secondary">Login to Register</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>