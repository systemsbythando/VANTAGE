<?php
require_once __DIR__ . '/../includes/auth.php'; requireRole(['CUSTOMER']);
$messages=[];
if(tableExists($pdo,'messages')){
  $cols=tableColumns($pdo,'messages');
  $senderCol=firstExistingColumn($pdo,'messages',['sender_id','user_id']); $receiverCol=firstExistingColumn($pdo,'messages',['receiver_id','recipient_id']);
  if($senderCol && $receiverCol){
    $s=$pdo->prepare("SELECT * FROM messages WHERE `$senderCol`=? OR `$receiverCol`=? ORDER BY ".(hasColumn($pdo,'messages','created_at')?'created_at':'message_id')." DESC LIMIT 30");$s->execute([$userId,$userId]);$messages=$s->fetchAll();}
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Messages | VANTAGE</title>
    <link rel="stylesheet" href="../assets/css/style.css">
  </head>
  <body>
    <div class="app"><?php include __DIR__.'/../includes/sidebar.php'; ?>
    <main class="main">
      <header class="topbar">
        <div>
          <div class="eyebrow">CUSTOMER PORTAL</div>
          <h2>Messages</h2>
          <p>Keep project communication in one place.</p>
        </div>
      </header>
      <section class="dashboard">
        <div class="panel">
          <div class="panel-head">
            <div>
              <h3>Your conversations</h3>
            </div>
          </div>
          <?php if($messages): foreach($messages as $m): ?>
            <div class="message-item">
              <strong><?= htmlspecialchars($m['subject']??'VANTAGE message') ?></strong>
              <p><?= htmlspecialchars($m['message']??$m['body']??'') ?></p>
              <small><?= htmlspecialchars($m['created_at']??'') ?></small>
            </div>
            <?php endforeach; else: ?>
            <div class="empty">
              <h3>No messages yet.</h3>
              <p>Your VANTAGE team will use this area for project updates and communication.</p>
            </div>
            <?php endif; ?>
          </div>
        </section>
      </main>
    </div>
  </body>
</html>
