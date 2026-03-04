import axios from "axios";
import { API_URL, NONCE } from "./config.js";

const api = axios.create({
  baseURL: API_URL,
  headers: {
    "X-WP-Nonce": NONCE,
    "Content-Type": "application/json"
  },
  withCredentials: true
});

api.interceptors.response.use(
  response => response,
  error => {

    if (error.response) {

      if (error.response.status === 401) {
        console.error("Unauthorized - Nonce expired");
      }

      if (error.response.status === 403) {
        console.error("Forbidden");
      }
    }

    return Promise.reject(error);
  }
);
export default api;
