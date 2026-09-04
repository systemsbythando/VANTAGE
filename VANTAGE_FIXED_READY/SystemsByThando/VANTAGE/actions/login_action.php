<?php
session_start();
require_once __DIR__ . '/../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirectLogin('login');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') redirectLogin('invalid');

$stmt = $pdo->prepare('SELECT user_id, first_name, last_name, username, email, password, role, account_status FROM users WHERE email = ? LIMIT 1');
$stmt->execute([$email]);
$user = $stmt->fetch();
if (!$user) redirectLogin('invalid');
if (($user['account_status'] ?? 'ACTIVE') !== 'ACTIVE') redirectLogin('inactive');
if (!password_verify($password, $user['password'])) redirectLogin('invalid');

session_regenerate_id(true);
$_SESSION['user_id'] = $user['user_id'];
$_SESSION['first_name'] = $user['first_name'];
$_SESSION['last_name'] = $user['last_name'];
$_SESSION['username'] = $user['username'] ?? '';
$_SESSION['email'] = $user['email'];
$_SESSION['role'] = strtoupper($user['role']);

if (in_array('last_login', array_column($pdo->query("SHOW COLUMNS FROM users")->fetchAll(), 'Field'), true)) {
    $u = $pdo->prepare('UPDATE users SET last_login = NOW() WHERE user_id = ?');
    $u->execute([$user['user_id']]);
}

switch ($_SESSION['role']) {
    case 'CUSTOMER': redirectTo('/VANTAGE_FIXED_READY/SystemsByThando/VANTAGE/customer/dashboard.php');
    case 'ADMIN':
    case 'PARTNER':
    case 'STAFF': redirectTo('/VANTAGE_FIXED_READY/SystemsByThando/VANTAGE/admin/dashboard.php');
    default: session_destroy(); redirectLogin('role');
}

function redirectLogin(string $error): never { header('Location: /VANTAGE_FIXED_READY/SystemsByThando/VANTAGE/login.php?error=' . urlencode($error)); exit; }
function redirectTo(string $path): never { header('Location: ' . $path); exit; }
