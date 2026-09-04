<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/db_helpers.php';

function isLoggedIn(): bool { return isset($_SESSION['user_id'], $_SESSION['role']); }

function requireLogin(): void {
    if (!isLoggedIn()) redirectTo('/VANTAGE_FIXED_READY/SystemsByThando/VANTAGE/login.php?error=login');
}

function requireRole(array $roles): void {
    requireLogin();
    if (!in_array($_SESSION['role'], $roles, true)) {
        http_response_code(403);
        exit('Access denied. Your account does not have permission to view this page.');
    }
}

function roleLabel(string $role): string {
    return match ($role) {
        'ADMIN' => 'Administrator',
        'PARTNER' => 'Business Partner',
        'STAFF' => 'Staff Workspace',
        'CUSTOMER' => 'Customer Portal',
        default => 'VANTAGE User',
    };
}
