<?php
require_once __DIR__ . '/../config/database.php';

function tableExists(PDO $pdo, string $table): bool {
    static $cache = [];
    if (isset($cache[$table])) return $cache[$table];
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = DATABASE() AND table_name = ?');
    $stmt->execute([$table]);
    return $cache[$table] = ((int)$stmt->fetchColumn() > 0);
}

function tableColumns(PDO $pdo, string $table): array {
    static $cache = [];
    if (isset($cache[$table])) return $cache[$table];
    if (!tableExists($pdo, $table)) return $cache[$table] = [];
    $stmt = $pdo->prepare('SELECT COLUMN_NAME FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = ?');
    $stmt->execute([$table]);
    return $cache[$table] = array_map('strval', $stmt->fetchAll(PDO::FETCH_COLUMN));
}

function hasColumn(PDO $pdo, string $table, string $column): bool {
    return in_array($column, tableColumns($pdo, $table), true);
}

function firstExistingColumn(PDO $pdo, string $table, array $candidates): ?string {
    $columns = tableColumns($pdo, $table);
    foreach ($candidates as $candidate) {
        if (in_array($candidate, $columns, true)) return $candidate;
    }
    return null;
}

function safeCount(PDO $pdo, string $table, ?string $where = null, array $params = []): int {
    if (!tableExists($pdo, $table)) return 0;
    $sql = "SELECT COUNT(*) FROM `{$table}`";
    if ($where) $sql .= " WHERE {$where}";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return (int)$stmt->fetchColumn();
}

function safeSum(PDO $pdo, string $table, ?string $column, ?string $where = null, array $params = []): float {
    if (!$column || !tableExists($pdo, $table) || !hasColumn($pdo, $table, $column)) return 0.0;
    $sql = "SELECT COALESCE(SUM(`{$column}`), 0) FROM `{$table}`";
    if ($where) $sql .= " WHERE {$where}";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return (float)$stmt->fetchColumn();
}

function safeRows(PDO $pdo, string $table, string $orderBy = '', int $limit = 20): array {
    if (!tableExists($pdo, $table)) return [];
    $columns = tableColumns($pdo, $table);
    $order = in_array($orderBy, $columns, true) ? " ORDER BY `{$orderBy}` DESC" : '';
    $limit = max(1, min($limit, 100));
    return $pdo->query("SELECT * FROM `{$table}`{$order} LIMIT {$limit}")->fetchAll();
}

function redirectTo(string $path): never {
    header('Location: ' . $path);
    exit;
}
