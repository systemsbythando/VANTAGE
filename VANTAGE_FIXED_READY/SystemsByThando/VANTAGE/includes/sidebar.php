<?php
$role = $_SESSION['role'] ?? '';
$isCustomer = $role === 'CUSTOMER';
$base = '/VANTAGE_FIXED_READY/SystemsByThando/VANTAGE/';
?>
<aside class="sidebar">
    <div class="brand">VANTAGE <span><?= $isCustomer ? 'CUSTOMER PORTAL' : 'BUSINESS CONTROL' ?></span></div>
    <nav>
        <?php if ($isCustomer): ?>
            <a href="<?= $base ?>customer/dashboard.php">Dashboard</a>
            <a href="<?= $base ?>customer/projects.php">My Projects</a>
            <a href="<?= $base ?>customer/messages.php">Messages</a>
        <?php else: ?>
            <a href="<?= $base ?>admin/dashboard.php">Dashboard</a>
            <a href="<?= $base ?>admin/clients.php">Clients</a>
            <a href="<?= $base ?>admin/projects.php">Projects</a>
            <a href="<?= $base ?>admin/sales.php">Sales</a>
            <a href="<?= $base ?>admin/finance.php">Finance</a>
            <a href="<?= $base ?>admin/users.php">Team</a>
            <a href="<?= $base ?>admin/messages.php">Messages</a>
            <a href="<?= $base ?>admin/analytics.php">Analytics</a>
            <a href="<?= $base ?>admin/settings.php">Settings</a>
        <?php endif; ?>
    </nav>
    <div class="sidebar-bottom">
        <a href="<?= $base ?>logout.php">Logout</a>
    </div>
</aside>
