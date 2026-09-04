<?php
require_once __DIR__.'/../includes/auth.php'; requireRole(['ADMIN','PARTNER','STAFF']);
$paymentCol=firstExistingColumn($pdo,'payments',['amount_paid','amount','paid_amount']); $invoiceCol=firstExistingColumn($pdo,'invoices',['total_amount','amount','invoice_total']); $paid=safeSum($pdo,'payments',$paymentCol); $billed=safeSum($pdo,'invoices',$invoiceCol); $outstanding=safeSum($pdo,'invoices',$invoiceCol,hasColumn($pdo,'invoices','status')?"status IN ('SENT','OVERDUE','PARTIALLY_PAID')":null);
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title>Finance | VANTAGE</title>
        <link rel="stylesheet" href="../assets/css/style.css">
    </head>
    <body>
        <div class="app"><?php include __DIR__.'/../includes/sidebar.php'; ?>
        <main class="main">
            <header class="topbar">
                <div>
                    <div class="eyebrow">FINANCIAL CONTROL</div>
                    <h2>Finance</h2>
                    <p>Revenue, billing and outstanding balances.</p>
                </div>
            </header>
            <section class="dashboard">
                <div class="cards">
                    <div class="stat-card">
                        <span>RECEIVED</span>
                        <h1>R <?= number_format($paid,2) ?></h1>
                        <small>Payments recorded</small>
                    </div>
                    <div class="stat-card">
                        <span>BILLED</span>
                        <h1>R <?= number_format($billed,2) ?></h1>
                        <small>Invoice value</small>
                    </div>
                    <div class="stat-card">
                        <span>OUTSTANDING</span>
                        <h1>R <?= number_format($outstanding,2) ?></h1>
                        <small>Open invoices</small>
                    </div>
                </div>
                <div class="panel">
                    <h3>Finance control</h3>
                    <p class="muted">Use this area to review invoices and payments. The totals above are read from your current VANTAGE database without assuming a column named 
                        <code>amount</code>.
                    </p>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
