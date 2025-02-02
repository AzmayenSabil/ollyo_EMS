<?php include __DIR__ . '../../layouts/header.php'; ?>

<div class="min-vh-100">
    <div class="container d-flex justify-content-center align-items-center">
        <div class="card shadow-lg p-4 rounded" style="max-width: 400px; width: 100%;">
            <h2 class="mb-4 text-center text-primary">Register</h2>
            <form action="<?php echo $baseUrl; ?>/register" method="POST">
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Enter your username" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg">Register</button>
                </div>
            </form>
            <div class="text-center mt-3">
                <a href="<?php echo $baseUrl; ?>/login" class="text-decoration-none">Already have an account? Login</a>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '../../layouts/footer.php'; ?>