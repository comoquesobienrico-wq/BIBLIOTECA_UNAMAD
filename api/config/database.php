<?php
return [
    // Host MySQL (InfinityFree).
    'host' => getenv('DB_HOST') ?: 'sql210.infinityfree.com',
    'port' => getenv('DB_PORT') ?: 3306,
    'database' => getenv('DB_DATABASE') ?: 'if0_40720128_dbbiblioteca_unamad',
    'user' => getenv('DB_USER') ?: 'if0_40720128',
    'password' => getenv('DB_PASSWORD') ?: 'BttvjiJlbFIp',
];
