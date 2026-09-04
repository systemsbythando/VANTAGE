<?php
require_once __DIR__.'/../includes/auth.php'; requireRole(['CUSTOMER']);
$id=(int)($_GET['id']??0); $project=null;
if($id && tableExists($pdo,'projects')){$pk=firstExistingColumn($pdo,'projects',['project_id','id']); if($pk){$s=$pdo->prepare("SELECT * FROM projects WHERE `$pk`=? LIMIT 1");$s->execute([$id]);$project=$s->fetch();}}
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title>Project | VANTAGE</title>
        <link rel="stylesheet" href="../assets/css/style.css">
    </head>
    <body>
        <div class="app"><?php include __DIR__.'/../includes/sidebar.php'; ?>
        <main class="main">
            <header class="topbar">
                <div>
                    <div class="eyebrow">CUSTOMER PORTAL</div>
                    <h2><?= htmlspecialchars($project['project_name']??'Project details') ?></h2>
                    <p>Project delivery information.</p>
                </div>
            </header>
            <section class="dashboard">
                <div class="panel"><?php if($project): ?>
                    <div class="detail-grid">
                        <div>
                            <span>Status</span>
                            <strong><?= htmlspecialchars($project['status']??'—') ?></strong>
                        </div>
                        <div>
                            <span>Progress</span>
                            <strong><?= (int)($project['progress']??0) ?>%</strong>
                        </div>
                    </div>
                    <p class="detail-copy"><?= htmlspecialchars($project['description']??'No description available.') ?></p>
                    <?php else: ?>
                        <div class="empty">
                            <h3>Project not found.</h3>
                            <p>This project may have been removed or is not available to your account.</p>
                        </div>
                        <?php endif; ?>
                    </div>
                </section>
            </main>
        </div>
    </body>
</html>
