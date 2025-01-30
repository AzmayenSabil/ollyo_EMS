<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php
    // Start session only if it's not already started
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Define the base URL dynamically
    $baseUrl = 'http://' . $_SERVER['HTTP_HOST'] . '/ollyo_EMS';
    ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="<?php echo $baseUrl; ?>/events">Event Management</a>
            <ul class="navbar-nav">
                <?php if (isset($_SESSION["user_id"])): // Check if user is logged in 
                ?>
                    <li class="nav-item"><a class="nav-link" href="<?php echo $baseUrl; ?>/event/create">Create Event</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo $baseUrl; ?>/logout">Logout</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="<?php echo $baseUrl; ?>/login">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo $baseUrl; ?>/register">Register</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <div class="container mt-4">