# Biblioteca Universitaria (UNAMAD) — Estructura base

Este repositorio contiene el esqueleto de una aplicación de biblioteca universitaria.

## Carpetas principales

- `interfaz/`: HTML/CSS/JS (front-end estático).
- `api/`: backend (PHP) para exponer endpoints.
- `base-de-datos/`: scripts/diagramas de BD (por definir).
- `documentacion/`: documentación del proyecto.

## Inicio rápido (XAMPP)

1. Ubica esta carpeta dentro de `htdocs` (por ejemplo: `C:\xampp\htdocs\BIBLIOTECA_UNAMAD`).
2. Abre en el navegador: `http://localhost/BIBLIOTECA_UNAMAD/interfaz/publico/inicio.html`

## Conexión a SQL Server

- Configuración: `api/config/database.php` (puedes usar variables de entorno `DB_SERVER`, `DB_DATABASE`, `DB_USER`, `DB_PASSWORD`).
- Prueba rápida: `http://localhost/BIBLIOTECA_UNAMAD/api/test-conexion.php`
- Requisito: habilitar los drivers de SQL Server para PHP (`sqlsrv` y `pdo_sqlsrv`) y reiniciar Apache.

## Notas

- Los HTML de `interfaz/paginas/` están creados como placeholders para completar.
