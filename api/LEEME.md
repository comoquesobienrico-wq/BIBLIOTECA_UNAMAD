# API - Conexion a MySQL

Archivos clave:
- `config/database.php`: valores de conexion (host, base de datos, usuario, password, puerto).
- `lib/Database.php`: clase que abre la conexion con MySQL usando `mysqli`.
- `test-conexion.php`: endpoint sencillo para probar la conectividad (`SELECT 1`).

Notas:
- Ajusta `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USER`, `DB_PASSWORD` en variables de entorno o directamente en `config/database.php`.
- En InfinityFree asegurate de usar el hostname del panel (por ejemplo `sql210.infinityfree.com`).
