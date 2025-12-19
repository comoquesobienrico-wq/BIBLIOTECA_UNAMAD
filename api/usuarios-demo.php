<?php
header('Content-Type: application/json');

require_once __DIR__ . '/lib/Database.php';

try {
    $db = new Database();
    $conn = $db->getConnection();

    $sql = 'SELECT * FROM usuario';
    $result = $conn->query($sql);
    if (!$result) {
        throw new RuntimeException('Error en la consulta: ' . $conn->error);
    }

    $usuarios = [];
    while ($row = $result->fetch_assoc()) {
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
    ]);
}
