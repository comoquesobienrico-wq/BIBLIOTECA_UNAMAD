<?php
return [
    // Nombre o IP del servidor SQL Server (puedes usar el valor de la captura).
    'server' => getenv('DB_SERVER') ?: 'DESKTOP-J5EOGTK\SQLEXPRESS',
    // Base de datos a usar; con autenticación integrada puedes dejar 'master' y cambiar luego.
    'database' => getenv('DB_DATABASE') ?: 'dbbiblioteca_unamad',
    // Para autenticación integrada deja null en usuario/contraseña.
    'user' => getenv('DB_USER') ?: null,
    'password' => getenv('DB_PASSWORD') ?: null,
    // Seguridad: cifra y acepta el certificado del servidor en entornos locales.
    'encrypt' => true,
    'trust_server_certificate' => true,
];
