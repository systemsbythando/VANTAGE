<?php
require_once __DIR__ . '/../includes/auth.php';
requireRole(['ADMIN','PARTNER','STAFF']);

$paymentColumn = firstExistingColumn($pdo,'payments',['amount_paid','amount','paid_amount','payment_amount']);
$invoiceColumn = firstExistingColumn($pdo,'invoices',['total_amount','amount','invoice_total']);
$clientCount = safeCount($pdo,'clients', hasColumn($pdo,'clients','status') ? "status = 'ACTIVE'" : null);
$projectCount = safeCount($pdo,'projects', hasColumn($pdo,'projects','status') ? "status IN ('PLANNING','IN_PROGRESS','TESTING','ACTIVE')" : null);
$revenue = safeSum($pdo,'payments',$paymentColumn);
$outstanding = safeSum($pdo,'invoices',$invoiceColumn, hasColumn($pdo,'invoices','status') ? "status IN ('SENT','OVERDUE','PARTIALLY_PAID')" : null);

$activities=[];
if(tableExists($pdo,'activity_logs')){
    $activities=safeRows($pdo,'activity_logs',hasColumn($pdo,'activity_logs','created_at')?'created_at':'',8);
}
$role = $_SESSION['role'];
$roleTitle = roleLabel($role);
?>
<!doctype html><html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title><?= htmlspecialchars($roleTitle) ?> | VANTAGE</title>
        <link rel="stylesheet" href="../assets/css/style.css">
    </head>
<body>
    <div class="app"><?php include __DIR__.'/../includes/sidebar.php'; ?>
    <main class="main">
        <header class="topbar">
            <div>
                <div class="eyebrow"><?= htmlspecialchars($roleTitle) ?></div>
                <h2>Business command centre</h2>
                <p>Welcome back, <?= htmlspecialchars($_SESSION['first_name'] ?? 'User') ?>.</p>
            </div>
            <div class="user-pill"><?= htmlspecialchars($_SESSION['email'] ?? '') ?></div>
        </header>
        <section class="dashboard">
            <div class="cards">
                <div class="stat-card">
                    <span>TOTAL REVENUE</span>
                    <h1>R <?= number_format($revenue,2) ?></h1>
                    <small>Recorded payments</small>
                </div>
                
                <div class="stat-card">
                    <span>ACTIVE CLIENTS</span>
                    <h1><?= $clientCount ?></h1>
                    <small>Current client accounts</small>
                </div>

                <div class="stat-card">
                    <span>ACTIVE PROJECTS</span>
                    <h1><?= $projectCount ?></h1>
                    <small>Projects in delivery</small>
                </div>

                <div class="stat-card">
                    <span>OUTSTANDING</span>
                    <h1>R <?= number_format($outstanding,2) ?></h1>
                    <small>Invoices awaiting payment</small>
                </div>
            </div>

            <div class="dashboard-grid">
                <div class="panel">
                    <div class="panel-head">
                        <div>
                            <div class="eyebrow">OPERATIONS</div>
                            <h3>Revenue overview</h3>
                        </div>
                        <a class="text-link" href="finance.php">Open finance →</a>
                    </div>
                    <div class="metric-hero">
                        <strong>R <?= number_format($revenue,2) ?></strong>
                        <span>Cash received to date</span>
                    </div>
                    <div class="bar-track">
                        <div class="bar-fill" style="width:<?= $revenue > 0 ? '72' : '8' ?>%"></div>
                    </div>
                    <p class="muted">Dashboard figures are calculated from your existing database tables.</p>
                </div>
            <div class="panel">
                <div class="panel-head">
                    <div>
                    <div class="eyebrow">AUDIT TRAIL</div>
                    <h3>Recent activity</h3>
                </div>
                <a class="text-link" href="analytics.php">View analytics →</a>
            </div>

            <?php if($activities): foreach($activities as $a): ?>
                <div class="activity-item">
                    <strong><?= htmlspecialchars($a['action'] ?? $a['activity'] ?? 'Activity') ?></strong>
                    <small><?= htmlspecialchars($a['created_at'] ?? '') ?></small>
                </div>
                <?php endforeach; else: ?>
                    <div class="empty">No activity has been recorded yet.</div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </main>
    </div>
</body>
</html>
