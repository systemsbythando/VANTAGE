<?php require_once __DIR__.'/../includes/auth.php'; 
requireRole(['ADMIN','PARTNER','STAFF']); ?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title>Settings | VANTAGE</title>
        <link rel="stylesheet" href="../assets/css/style.css">
    </head>
    <body>
        <div class="app"><?php include __DIR__.'/../includes/sidebar.php'; ?>
        <main class="main">
            <header class="topbar">
                <div>
                    <div class="eyebrow">SYSTEM CONTROL</div>
                    <h2>Settings</h2>
                    <p>Workspace configuration will live here.</p>
                </div>
            </header>
            <section class="dashboard">
                <div class="panel empty">
                    <h3>VANTAGE is ready.</h3>
                    <p>Production settings such as SMTP, company details, notifications and deployment secrets should be configured outside the public web root.</p>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
