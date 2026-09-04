<?php
require_once __DIR__ . '/../includes/db_helpers.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') 
    redirectTo('/VANTAGE_FIXED_READY/SystemsByThando/VANTAGE/register.php');
    $first = trim($_POST['first_name'] ?? ''); 
    $last = trim($_POST['last_name'] ?? ''); 
    $email = trim($_POST['email'] ?? ''); 
    $password = $_POST['password'] ?? '';
if ($first === '' || $last === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 8) 
    redirectTo('/VANTAGE_FIXED_READY/SystemsByThando/VANTAGE/register.php?error=validation');
if (!tableExists($pdo, 'users')) 
    exit('The users table is missing. Import the VANTAGE database schema first.');
if (hasColumn($pdo,'users','email')) { 
    $c=$pdo->prepare('SELECT user_id FROM users WHERE email=? LIMIT 1'); 
    $c->execute([$email]); if($c->fetch()) 
    redirectTo('/VANTAGE_FIXED_READY/SystemsByThando/VANTAGE/login.php?error=exists'); 
}
$cols = tableColumns($pdo,'users'); $insert=[]; $values=[];
foreach ([['first_name',$first],['last_name',$last],['email',$email],['password',password_hash($password,PASSWORD_DEFAULT)],['role','CUSTOMER'],['account_status','ACTIVE']] as [$col,$val]) if(in_array($col,$cols,true)){ $insert[]=$col; $values[]=$val; }
if(in_array('username',$cols,true)){ 
    $base=preg_replace('/[^a-z0-9]/','',strtolower($first.$last)); 
    $username=$base ?: 'customer'; $n=0; 
    $candidate=$username; while(true){
        $q=$pdo->prepare('SELECT COUNT(*) FROM users WHERE username=?');
        $q->execute([$candidate]);if(!$q->fetchColumn())break;
$candidate=$username.(++$n);} $insert[]='username';$values[]=$candidate; }
if(count($insert)<4) exit('The users table does not match the VANTAGE account structure.');
$sql='INSERT INTO users (`'.implode('`,`',$insert).'`) VALUES ('.implode(',',array_fill(0,count($values),'?')).')'; 
$stmt=$pdo->prepare($sql);$stmt->execute($values);
redirectTo('/VANTAGE_FIXED_READY/SystemsByThando/VANTAGE/login.php?registered=1');
