<?php
include __DIR__ . '../../layouts/header.php';

// Define base URL dynamically
$baseUrl = 'http://' . $_SERVER['HTTP_HOST'] . '/ollyo_EMS';
?>

<div class="min-vh-100">
    <div class="container d-flex justify-content-center align-items-center">
        <div class="card shadow-lg p-4 rounded" style="max-width: 400px; width: 100%;">
            <h2 class="mb-4 text-center text-primary">Login</h2>
            <form method="POST" action="<?php echo $baseUrl; ?>/login">
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg">Login</button>
                </div>
            </form>
            <div class="text-center mt-3">
                <a href="<?php echo $baseUrl; ?>/forgot-password" class="text-decoration-none">Forgot password?</a>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '../../layouts/footer.php'; ?>