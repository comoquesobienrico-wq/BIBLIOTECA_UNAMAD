<?php
header('Content-Type: application/json; charset=utf-8');

$databasePath = __DIR__ . '/lib/Database.php';
if (!file_exists($databasePath)) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'No se encuentra el archivo Database.php.',
    ]);
    exit;
}

require_once $databasePath;

// Nombres reales segun la tabla "usuario".
const USER_TABLE = 'usuario';
const USERNAME_COLUMN = 'login';
const PASSWORD_COLUMN = 'password';
const PASSWORD_HASH_COLUMN = 'password_hash';
const EMAIL_COLUMN = 'email';

try {
    $input = json_decode(file_get_contents('php://input'), true);
    $username = isset($input['username']) ? trim($input['username']) : null;
    $password = isset($input['password']) ? trim($input['password']) : null;

    if (!$username || !$password) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Faltan credenciales']);
        exit;
    }

    $db = new Database();
    $conn = $db->getConnection();

    $sql = sprintf(
        'SELECT * FROM %s WHERE %s = ? OR %s = ? LIMIT 1',
        USER_TABLE,
        USERNAME_COLUMN,
        EMAIL_COLUMN
    );

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new RuntimeException('Error al preparar la consulta: ' . $conn->error);
    }

    $stmt->bind_param('ss', $username, $username);
    if (!$stmt->execute()) {
        throw new RuntimeException('Error al ejecutar la consulta: ' . $stmt->error);
    }

    $result = $stmt->get_result();
    $user = $result ? $result->fetch_assoc() : null;

    if (!$user) {
        http_response_code(401);
        echo json_encode(['status' => 'error', 'message' => 'Credenciales incorrectas']);
        exit;
    }

    $isValid = false;

    if (array_key_exists(PASSWORD_HASH_COLUMN, $user) && $user[PASSWORD_HASH_COLUMN] !== null) {
        $stored = $user[PASSWORD_HASH_COLUMN];

        $hashSha512Bin = hash('sha512', $password, true);
        $hashSha256Bin = hash('sha256', $password, true);
        $hashSha512Hex = hash('sha512', $password);
        $hashSha256Hex = hash('sha256', $password);

        if (
            hash_equals($stored, $hashSha512Bin) ||
            hash_equals($stored, $hashSha256Bin) ||
            hash_equals($stored, $hashSha512Hex) ||
            hash_equals($stored, $hashSha256Hex)
        ) {
            $isValid = true;
        }
    }

    if (!$isValid && array_key_exists(PASSWORD_COLUMN, $user) && $user[PASSWORD_COLUMN] !== null) {
        if ($user[PASSWORD_COLUMN] === $password) {
            $isValid = true;
        }
    }

    if (!$isValid) {
        http_response_code(401);
        echo json_encode(['status' => 'error', 'message' => 'Credenciales incorrectas']);
        exit;
    }

    echo json_encode([
        'status' => 'ok',
        'user' => [
            'id' => $user['idusuario'] ?? null,
            'nombre' => $user['nombre'] ?? $user[USERNAME_COLUMN] ?? null,
            'rol' => $user['tipo_usuario'] ?? null,
            'estado' => $user['estado_usuario'] ?? null,
        ],
    ]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage(),
    ]);
}
