export function renderBarraNavegacion(contenedor) {
  if (!contenedor) return;
  contenedor.innerHTML = `
    <nav style="display:flex;gap:12px;align-items:center;">
      <a href="/BIBLIOTECA_UNAMAD/biblioteca-universitaria/interfaz/publico/inicio.html">Inicio</a>
      <a href="/BIBLIOTECA_UNAMAD/biblioteca-universitaria/interfaz/publico/catalogo-publico.html">Catálogo</a>
      <a href="/BIBLIOTECA_UNAMAD/biblioteca-universitaria/interfaz/paginas/acceso/iniciar-sesion.html">Acceso</a>
    </nav>
  `;
}
