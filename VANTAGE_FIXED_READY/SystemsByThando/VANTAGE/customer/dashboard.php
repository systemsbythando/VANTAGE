<?php
require_once __DIR__ . '/../includes/auth.php';
requireRole(['CUSTOMER']);
$userId=$_SESSION['user_id']; $client=null; $projects=[];
if(tableExists($pdo,'clients')){
    if(hasColumn($pdo,'clients','user_id')){ $s=$pdo->prepare('SELECT * FROM clients WHERE user_id=? LIMIT 1');$s->execute([$userId]);$client=$s->fetch(); }
    if(!$client && hasColumn($pdo,'clients','email') && !empty($_SESSION['email'])){ $s=$pdo->prepare('SELECT * FROM clients WHERE email=? LIMIT 1');$s->execute([$_SESSION['email']]);$client=$s->fetch(); }
}
$clientId=$client ? ($client['client_id'] ?? $client['id'] ?? null) : null;
if($clientId && tableExists($pdo,'projects') && hasColumn($pdo,'projects','client_id')){ $s=$pdo->prepare('SELECT * FROM projects WHERE client_id=? ORDER BY '.(firstExistingColumn($pdo,'projects',['created_at','project_id','id']) ?? 'client_id').' DESC');$s->execute([$clientId]);$projects=$s->fetchAll(); }
$active=count($projects); $completed=0; foreach($projects as $p){if(in_array(strtoupper($p['status']??''),['COMPLETED','COMPLETE','DONE'],true))$completed++;}
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title>My Dashboard | VANTAGE</title>
        <link rel="stylesheet" href="../assets/css/style.css">
    </head>
    <body>
        <div class="app"><?php include __DIR__.'/../includes/sidebar.php'; ?>
        <main class="main">
            <header class="topbar">
                <div>
                    <div class="eyebrow">CUSTOMER PORTAL</div>
                    <h2>Welcome, <?= htmlspecialchars($_SESSION['first_name']) ?>.</h2>
                    <p>Your private view of projects, progress and communication.</p>
                </div>
                <div class="user-pill">CUSTOMER</div>
            </header>
            <section class="dashboard">
                <div class="customer-hero">
                    <div>
                        <div class="eyebrow">YOUR WORKSPACE</div>
                        <h1>Everything about your project, in one place.</h1>
                        <p>Track delivery progress, review project status and stay connected with the VANTAGE team.</p>
                    </div>
                    <a class="btn primary" href="projects.php">View my projects</a>
                </div>
                <div class="cards">
                    <div class="stat-card">
                        <span>MY PROJECTS</span>
                        <h1><?= $active ?></h1>
                        <small>Projects assigned to you</small>
                    </div>
                    <div class="stat-card">
                        <span>COMPLETED</span>
                        <h1><?= $completed ?></h1>
                        <small>Delivered projects</small>
                    </div>
                    <div class="stat-card">
                        <span>ACCOUNT</span>
                        <h1>ACTIVE</h1>
                        <small>Customer access enabled</small>
                    </div>
                    <div class="stat-card">
                        <span>MESSAGES</span>
                        <h1>—</h1>
                        <small>Open your inbox</small>
                    </div>
                </div>
                <div class="panel">
                    <div class="panel-head">
                        <div>
                            <div class="eyebrow">DELIVERY</div>
                            <h3>Current projects</h3>
                        </div>
                        <a class="text-link" href="messages.php">Message the team →</a>
                    </div><?php if($projects): ?>
                        <div class="project-grid">
                            <?php foreach($projects as $p): $progress=max(0,min(100,(int)($p['progress']??$p['completion_percent']??0))); ?>
                            <div class="project-card">
                                <div class="project-status"><?= htmlspecialchars($p['status']??'ACTIVE') ?></div>
                                <h3><?= htmlspecialchars($p['project_name']??$p['name']??'Project') ?></h3>
                                <p><?= htmlspecialchars($p['description']??'Project details are being prepared.') ?></p>
                                <div class="progress-container">
                                    <div class="progress-bar" style="width:<?= $progress ?>%"></div>
                                </div>
                                <div class="project-progress"><?= $progress ?>% complete</div>
                                <a class="btn secondary-dark" href="project.php?id=<?= urlencode((string)($p['project_id']??$p['id']??'')) ?>">View details</a>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <?php else: ?>
                            <div class="empty">
                                <h3>No projects are linked to this account yet.</h3>
                                <p>Your VANTAGE team will add a project when work begins.</p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </section>
                </main>
            </div>
        </body>
        </html>
