import { CONFIG } from "../configuracion.js";

export async function apiFetch(path, options = {}) {
  const url = new URL(path, window.location.origin);
  if (!path.startsWith("http")) {
    url.pathname = `${CONFIG.apiBaseUrl}${path.startsWith("/") ? "" : "/"}${path}`;
  }

  const response = await fetch(url.toString(), {
    headers: { "Content-Type": "application/json", ...(options.headers || {}) },
    ...options,
  });

  const contentType = response.headers.get("content-type") || "";
  const isJson = contentType.includes("application/json");
  const data = isJson ? await response.json().catch(() => null) : await response.text().catch(() => "");

  if (!response.ok) {
    const message = (data && data.message) ? data.message : `HTTP ${response.status}`;
    throw new Error(message);
  }

  return data;
}
