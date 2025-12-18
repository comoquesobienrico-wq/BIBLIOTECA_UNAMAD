export function esVacio(valor) {
  return valor == null || String(valor).trim().length === 0;
}

export function esEmail(valor) {
  if (esVacio(valor)) return false;
  return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(String(valor).trim());
}
