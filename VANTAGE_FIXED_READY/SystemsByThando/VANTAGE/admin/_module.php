<?php
require_once __DIR__ . '/../includes/auth.php'; requireRole(['ADMIN','PARTNER','STAFF']);
$table=$table??null;
$title=$title??'Module'; 
$description=$description??''; 
$columns=$table&&tableExists($pdo,$table)?tableColumns($pdo,$table):[]; 
if($table==='users'){ 
    $columns=array_values(array_diff($columns,['password'])); 
    } 
    $rows=$table?safeRows($pdo,$table,hasColumn($pdo,$table,'created_at')?'created_at':'',50):[];
function moduleValue(array $row,string $col): 
string { 
    $v=$row[$col]??''; if(is_array($v))return '';
 return htmlspecialchars((string)$v); 
}
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title><?= htmlspecialchars($title) ?> | VANTAGE</title>
        <link rel="stylesheet" href="../assets/css/style.css">
    </head>
    <body>
        <div class="app"><?php include __DIR__.'/../includes/sidebar.php'; ?>
        <main class="main">
            <header class="topbar">
                <div>
                    <div class="eyebrow"><?= htmlspecialchars(roleLabel($_SESSION['role'])) ?></div>
                    <h2><?= htmlspecialchars($title) ?></h2>
                    <p><?= htmlspecialchars($description) ?></p>
                </div>
            </header>
            <section class="dashboard">
                <div class="panel">
                    <div class="panel-head">
                        <div>
                            <h3><?= htmlspecialchars($title) ?> records</h3>
                        </div>
                        <span class="badge"><?= count($rows) ?> records</span>
                    </div><?php if(!$table): ?>
                    <div class="empty">This module is ready for configuration.</div>
                    <?php elseif(!$columns): ?>
                        <div class="empty">
                            <h3>No <?= htmlspecialchars($table) ?> table found.</h3>
                            <p>The page is protected from crashing. Add the corresponding table when this module is activated.</p>
                        </div><?php elseif(!$rows): ?>
                        <div class="empty">
                            <h3>No records yet.</h3>
                            <p>New records will appear here when they are created.</p>
                        </div><?php else: ?>
                        <div class="table-wrap">
                            <table>
                                <thead>
                                    <tr><?php foreach(array_slice($columns,0,7) as $c): ?>
                                        <th><?= htmlspecialchars(ucwords(str_replace('_',' ',$c))) ?></th>
                                        <?php endforeach; ?>
                                    </tr>
                                </thead>
                                <tbody><?php foreach($rows as $r): ?>
                                    <tr><?php foreach(array_slice($columns,0,7) as $c): ?>
                                        <td><?= moduleValue($r,$c) ?></td><?php endforeach; ?>
                                    </tr>
                                        <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php endif; ?>
                    </div>
                </section>
            </main>
        </div>
    </body>
    </html>
