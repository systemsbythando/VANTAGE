<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title>Create Account | VANTAGE</title>
        <link rel="stylesheet" href="assets/css/style.css">
    </head>
    <body class="auth-page">
        <div class="auth-container">
            <div class="auth-card">
                <a class="logo dark" href="index.php">VANTAGE</a>
                <div class="eyebrow">CUSTOMER ONBOARDING</div>
                <h2>Create your account.</h2>
                <p>Public registration creates a customer account. Internal team accounts are managed by administrators.</p>
                <?php if(isset($_GET['error'])): ?>
                    <div class="alert error">Please complete all fields and use a password of at least 8 characters.</div>
                    <?php endif; ?>
                    <form action="actions/register_action.php" method="post">
                        <label>First Name</label>
                        <input name="first_name" required>
                        <label>Last Name</label>
                        <input name="last_name" required>
                        <label>Email</label>
                        <input type="email" name="email" required>
                        <label>Password</label>
                        <input type="password" name="password" minlength="8" required>
                        <button class="btn primary full" type="submit">Create customer account</button>
                    </form>
                    <p class="auth-link">Already registered? 
                        <a href="login.php">Sign in</a>
                    </p>
                </div>
            </div>
        </body>
    </html>
