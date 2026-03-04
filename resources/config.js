if (!window.InternApp) {
  console.error("InternApp config not found");
}
export const API_URL = window.InternApp?.api_url;
export const NONCE = window.InternApp?.nonce;
