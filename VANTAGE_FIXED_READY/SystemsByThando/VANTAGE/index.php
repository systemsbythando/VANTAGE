<?php
session_start();
if (isset($_SESSION['user_id'], $_SESSION['role'])) {
    if ($_SESSION['role'] === 'CUSTOMER') {
        header('Location: customer/dashboard.php');
    } else {
        header('Location: admin/dashboard.php');
    }
    exit;
}
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title>SystemsByThando | Business Management</title>
        <link rel="stylesheet" href="assets/css/style.css">
    </head>
    <body>
        <div class="landing">
            <div class="landing-content">
                <div class="logo">VANTAGE</div>
                <div class="eyebrow">BUSINESS OPERATIONS PLATFORM</div>
                <h1>Run the business.<br>
                <span>See the whole picture.</span>
                </h1>
                <p>Clients, projects, sales, finance, team activity and customer communication in one controlled workspace.</p>
                <div class="landing-buttons">
                    <a href="login.php" class="btn primary">Sign in to VANTAGE</a>
                    <a href="register.php" class="btn secondary">Customer registration</a>
                </div>
            </div>
        </div>
    </body>
</html>
