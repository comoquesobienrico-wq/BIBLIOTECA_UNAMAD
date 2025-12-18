<?php
header('Content-Type: application/json');

require_once __DIR__ . '/lib/Database.php';

try {
    $db = new Database();
    $conn = $db->getConnection();

    // Consulta simple para verificar conectividad.
    $stmt = sqlsrv_query($conn, 'SELECT 1 AS ok');
    if ($stmt === false) {
        throw new RuntimeException(print_r(sqlsrv_errors(), true));
    }

    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    echo json_encode([
        'status' => 'ok',
        'result' => $row['ok'] ?? null,
    ]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage(),
        'sqlsrv_errors' => sqlsrv_errors(),
    ]);
}
