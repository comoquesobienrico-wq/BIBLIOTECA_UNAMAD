# Biblioteca Universitaria (UNAMAD) - Estructura base

Este repositorio contiene el esqueleto de una aplicacion de biblioteca universitaria.

## Carpetas principales

- `interfaz/`: HTML/CSS/JS (front-end estatico).
- `api/`: backend (PHP) para exponer endpoints.
- `base-de-datos/`: scripts/diagramas de BD (por definir).
- `documentacion/`: documentacion del proyecto.

## Inicio rapido (XAMPP)

1. Ubica esta carpeta dentro de `htdocs` (por ejemplo: `C:\xampp\htdocs\BIBLIOTECA_UNAMAD`).
2. Abre en el navegador: `http://localhost/BIBLIOTECA_UNAMAD/interfaz/publico/inicio.html`

## Conexion a MySQL

- Configuracion: `api/config/database.php` (puedes usar variables de entorno `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USER`, `DB_PASSWORD`).
- Prueba rapida: `http://localhost/BIBLIOTECA_UNAMAD/api/test-conexion.php`
- Requisito: habilitar `mysqli` en PHP y reiniciar Apache.

## Notas

- Los HTML de `interfaz/paginas/` estan creados como placeholders para completar.
