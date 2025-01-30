<?php
include __DIR__ . '../../layouts/header.php';

// Define base URL dynamically
$baseUrl = 'http://' . $_SERVER['HTTP_HOST'] . '/ollyo_EMS';
?>
<h2>Login</h2>
<form method="POST" action="<?php echo $baseUrl; ?>/login">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
</form>

<?php include __DIR__ . '../../layouts/footer.php'; ?>