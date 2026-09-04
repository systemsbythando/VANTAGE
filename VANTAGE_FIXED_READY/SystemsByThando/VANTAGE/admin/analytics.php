<?php
require_once __DIR__.'/../includes/auth.php'; requireRole(['ADMIN','PARTNER','STAFF']);
$metrics=[['Clients',safeCount($pdo,'clients')],['Projects',safeCount($pdo,'projects')],['Invoices',safeCount($pdo,'invoices')],['Payments',safeCount($pdo,'payments')],['Users',safeCount($pdo,'users')]];
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title>Analytics | VANTAGE</title>
        <link rel="stylesheet" href="../assets/css/style.css">
    </head>
    <body>
        <div class="app"><?php include __DIR__.'/../includes/sidebar.php'; ?>
        <main class="main">
            <header class="topbar">
                <div>
                    <div class="eyebrow">BUSINESS INTELLIGENCE</div>
                    <h2>Analytics</h2
                    ><p>Live record counts across your workspace.</p>
                </div>
            </header>
            <section class="dashboard">
                <div class="cards"><?php foreach($metrics as [$n,$v]): ?>
                    <div class="stat-card">
                        <span><?= htmlspecialchars(strtoupper($n)) ?></span>
                        <h1><?= $v ?></h1>
                        <small>Database records</small>
                    </div>
                    <?php endforeach; ?>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
