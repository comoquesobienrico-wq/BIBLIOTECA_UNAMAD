# API — Conexión a SQL Server

Archivos clave:
- `config/database.php`: valores de conexión (servidor, base de datos, usuario/contraseña opcionales).
- `lib/Database.php`: clase que abre la conexión con SQL Server usando la extensión `sqlsrv`.
- `test-conexion.php`: endpoint sencillo para probar la conectividad (`SELECT 1`).

Notas:
- Si `DB_USER` no está definido se usa autenticación integrada de Windows.
- En XAMPP habilita las extensiones `php_sqlsrv` y `php_pdo_sqlsrv` y reinicia Apache antes de probar.
- Ajusta `DB_SERVER`, `DB_DATABASE`, `DB_USER`, `DB_PASSWORD` en variables de entorno o directamente en `config/database.php`.
