<?php
header('Content-Type: application/json');

require_once __DIR__ . '/lib/Database.php';

// Ajusta estos nombres a las columnas reales de tu tabla "usuario".
const USER_TABLE = 'usuario';
const USERNAME_COLUMN = 'login';          // columna de usuario en la tabla
const PASSWORD_COLUMN = 'password';       // contraseña en texto plano (si la usas)
const PASSWORD_HASH_COLUMN = 'password_hash'; // varbinary con hash (SHA-256/512) si existe

try {
    $input = json_decode(file_get_contents('php://input'), true);
    $username = $input['username'] ?? null;
    $password = $input['password'] ?? null;

    if (!$username || !$password) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Faltan credenciales']);
        exit;
    }

    $db = new Database();
    $conn = $db->getConnection();

    // Traemos el usuario por login y validamos el password en PHP para poder usar hash.
    $sql = sprintf(
        'SELECT TOP 1 * FROM %s WHERE %s = ?',
        USER_TABLE,
        USERNAME_COLUMN
    );

    $stmt = sqlsrv_query($conn, $sql, [$username]);
    if ($stmt === false) {
        throw new RuntimeException(print_r(sqlsrv_errors(), true));
    }

    $user = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    if (!$user) {
        http_response_code(401);
        echo json_encode(['status' => 'error', 'message' => 'Credenciales incorrectas']);
        exit;
    }

    // Verificación de contraseña:
    $isValid = false;

    // 1) Si hay hash en varbinary, compara contra SHA-512 y SHA-256 del password ingresado.
    if (array_key_exists(PASSWORD_HASH_COLUMN, $user) && $user[PASSWORD_HASH_COLUMN] !== null) {
        $hashSha512 = hash('sha512', $password, true); // binario (64 bytes)
        $hashSha256 = hash('sha256', $password, true); // binario (32 bytes)

        $stored = $user[PASSWORD_HASH_COLUMN];
        // sqlsrv puede devolver varbinary como stream; normalizamos a string binaria.
        if (is_resource($stored)) {
            $stored = stream_get_contents($stored);
        }

        if ($stored === $hashSha512 || $stored === $hashSha256) {
            $isValid = true;
        }
    }

    // 2) Fallback: compara texto plano si existe la columna password.
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

    // Devuelve datos mínimos; ajusta las columnas según tu tabla.
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
        'sqlsrv_errors' => sqlsrv_errors(),
    ]);
}
