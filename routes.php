<?php
require_once 'config/config.php'; // Include the config file
require_once 'controllers/AuthController.php';
require_once 'controllers/EventController.php';
require_once 'controllers/AttendeeController.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Define the base folder dynamically
$baseFolder = '/ollyo_EMS';
$request = str_replace($baseFolder, '', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Remove trailing slashes for consistency
$request = rtrim($request, '/');

// Debugging: Print request path (remove this after fixing)
error_log("Request Path: " . $request);

switch ($request) {
    case '':
    case '/':
    case '/events':
        $controller = new EventController();
        $controller->listEvents();
        break;
    case '/event/create':
        $controller = new EventController();
        $controller->createEvent();
        break;
    case '/event/view':
        $controller = new EventController();
        $controller->viewEvent();
        break;
    case '/event/edit':
        $controller = new EventController();
        $controller->editEvent();
        break;
    case '/event/register':
        $controller = new AttendeeController();
        $controller->registerAttendee();
        break;
    case '/attendees':
        $controller = new AttendeeController();
        $controller->getAttendees();
        break;
    case '/login':
        $controller = new AuthController();
        $controller->login();
        break;
    case '/register':
        $controller = new AuthController();
        $controller->register();
        break;
    case '/logout':
        session_destroy();
        header('Location: ' . $baseFolder . '/login');
        exit();
    default:
        http_response_code(404);
        echo "Page not found: " . htmlspecialchars($request);
        break;
}
