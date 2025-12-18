import { CONFIG } from "./configuracion.js";

export function initApp() {
  window.__APP_CONFIG__ = CONFIG;
}

initApp();
