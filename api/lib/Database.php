<?php
/**
 * MySQL connection manager using mysqli.
 */
class Database
{
    /** @var mysqli|null */
    private $connection = null;

    /** @var array */
    private $config;

    /**
     * @param array|null $config Manual config; if null it loads api/config/database.php.
     */
    public function __construct(?array $config = null)
    {
        $this->config = $config ?: $this->loadConfig();
    }

    /**
     * Returns a reusable active connection.
     *
     * Env vars:
     *  - DB_HOST (e.g. sql210.infinityfree.com)
     *  - DB_PORT (e.g. 3306)
     *  - DB_DATABASE
     *  - DB_USER and DB_PASSWORD
     *
     * @throws RuntimeException when connection fails.
     * @return mysqli
     */
    public function getConnection()
    {
        if ($this->connection !== null) {
            return $this->connection;
        }

        $host = $this->config['host'];
        $port = (int) ($this->config['port'] ?? 3306);
        $database = $this->config['database'];
        $user = $this->config['user'];
        $password = $this->config['password'];

        $conn = new mysqli($host, $user, $password, $database, $port);
        if ($conn->connect_errno) {
            throw new RuntimeException('No se pudo conectar a MySQL: ' . $conn->connect_error);
        }

        if (!$conn->set_charset('utf8mb4')) {
            throw new RuntimeException('No se pudo configurar el charset: ' . $conn->error);
        }

        $this->connection = $conn;
        return $this->connection;
    }

    /**
     * Loads default config from api/config/database.php.
     *
     * @return array
     */
    private function loadConfig()
    {
        $configPath = dirname(__DIR__) . '/config/database.php';
        if (!file_exists($configPath)) {
            throw new RuntimeException('No se encuentra el archivo de configuracion de base de datos.');
        }

        $config = require $configPath;

        if (!is_array($config)) {
            throw new RuntimeException('El archivo de configuracion de base de datos es invalido.');
        }

        return $config;
    }
}
