export function alerta(mensaje, tipo = "info") {
  const prefijo = tipo.toUpperCase();
  window.alert(`${prefijo}: ${mensaje}`);
}
