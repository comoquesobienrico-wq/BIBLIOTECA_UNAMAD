<?php
header('Content-Type: application/json');

require_once __DIR__ . '/lib/Database.php';

try {
    $db = new Database();
    $conn = $db->getConnection();

    $result = $conn->query('SELECT 1 AS ok');
    if (!$result) {
        throw new RuntimeException('Error en la consulta: ' . $conn->error);
    }

    $row = $result->fetch_assoc();
    echo json_encode([
        'status' => 'ok',
        'result' => $row['ok'] ?? null,
    ]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage(),
    ]);
}
