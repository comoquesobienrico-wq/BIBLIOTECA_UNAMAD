<?php
header('Content-Type: application/json');

require_once __DIR__ . '/lib/Database.php';

try {
    $db = new Database();
    $conn = $db->getConnection();

    // Consulta de ejemplo: lee todos los registros de la tabla usuario.
    $sql = 'SELECT * FROM usuario';
    $stmt = sqlsrv_query($conn, $sql);
    if ($stmt === false) {
        throw new RuntimeException(print_r(sqlsrv_errors(), true));
    }

    $usuarios = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $usuarios[] = $row;
    }

    echo json_encode([
        'status' => 'ok',
        'count' => count($usuarios),
        'data' => $usuarios,
    ]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage(),
        'sqlsrv_errors' => sqlsrv_errors(),
    ]);
}
