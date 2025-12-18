<?php
/**
 * Gestor de conexión a SQL Server usando extensiones sqlsrv.
 */
class Database
{
    /** @var resource|null */
    private $connection = null;

    /** @var array */
    private $config;

    /**
     * @param array|null $config Configuración manual; si es null se cargará desde api/config/database.php.
     */
    public function __construct(?array $config = null)
    {
        $this->config = $config ?: $this->loadConfig();
    }

    /**
     * Devuelve una conexión activa reutilizable.
     *
     * Usa variables de entorno si existen:
     *  - DB_SERVER (ej: DESKTOP-J5EOGTK\SQLEXPRESS)
     *  - DB_DATABASE (ej: Biblioteca)
     *  - DB_USER y DB_PASSWORD para autenticación SQL Server.
     * Si no se define usuario se intenta autenticación integrada de Windows.
     *
     * @throws RuntimeException si no es posible conectar.
     * @return resource
     */
    public function getConnection()
    {
        if ($this->connection !== null) {
            return $this->connection;
        }

        $server = $this->config['server'];
        $database = $this->config['database'];
        $user = $this->config['user'];
        $password = $this->config['password'];

        $connectionOptions = [
            'Database' => $database,
            'ReturnDatesAsStrings' => true,
            'CharacterSet' => 'UTF-8',
            'Encrypt' => $this->config['encrypt'],
            'TrustServerCertificate' => $this->config['trust_server_certificate'],
        ];

        // Si se define usuario usamos autenticación SQL Server, si no Windows.
        if (!empty($user)) {
            $connectionOptions['UID'] = $user;
            $connectionOptions['PWD'] = $password ?: '';
        }

        $conn = sqlsrv_connect($server, $connectionOptions);
        if ($conn === false) {
            $errors = print_r(sqlsrv_errors(), true);
            throw new RuntimeException("No se pudo conectar a SQL Server: {$errors}");
        }

        $this->connection = $conn;
        return $this->connection;
    }

    /**
     * Carga configuración por defecto desde api/config/database.php.
     *
     * @return array
     */
    private function loadConfig()
    {
        $configPath = dirname(__DIR__) . '/config/database.php';
        if (!file_exists($configPath)) {
            throw new RuntimeException('No se encuentra el archivo de configuración de base de datos.');
        }

        $config = require $configPath;

        if (!is_array($config)) {
            throw new RuntimeException('El archivo de configuración de base de datos es inválido.');
        }

        return $config;
    }
}
