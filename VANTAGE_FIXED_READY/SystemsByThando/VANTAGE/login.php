<?php
session_start();
if (isset($_SESSION['user_id'], $_SESSION['role'])) {
    header('Location: ' . ($_SESSION['role'] === 'CUSTOMER' ? 'customer/dashboard.php' : 'admin/dashboard.php'));
    exit;
}
$error = $_GET['error'] ?? '';
$messages = ['invalid'=>'Email or password is incorrect.','inactive'=>'Your account is not active.','email'=>'Enter a valid email address.','role'=>'Your account role is not configured.','login'=>'Please sign in first.'];
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title>Login | VANTAGE</title>
        <link rel="stylesheet" href="assets/css/style.css">
    </head>
    <body class="auth-page">
        <div class="auth-container">
            <div class="auth-card"><a class="logo dark" href="index.php">VANTAGE</a>
            <div class="eyebrow">SECURE ACCESS</div>
            <h2>Welcome back.</h2>
            <p>Sign in to the workspace assigned to your account.</p>
            <?php if(isset($messages[$error])): ?>
                <div class="alert error"><?= htmlspecialchars($messages[$error]) ?></div>
                <?php endif; ?><?php if(isset($_GET['registered'])): ?>
                    <div class="alert success">Account created. You can now sign in.</div>
                    <?php endif; ?>
                    <form action="actions/login_action.php" method="post">
                        <label>Email</label>
                        <input type="email" name="email" autocomplete="email" required>
                        <label>Password</label>
                        <input type="password" name="password" autocomplete="current-password" required>
                        <button class="btn primary full" type="submit">Sign in</button>
                    </form>
                    <p class="auth-link">Need a customer account? 
                        <a href="register.php">Create one</a>
                    </p>
                </div>
            </div>
        </body>
        </html>
