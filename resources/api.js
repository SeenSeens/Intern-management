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
/*api.interceptors.response.use(
  res => res,
  err => {
    const url = err.config?.url || ''
    if (
      err.response?.status === 401 &&
      !url.includes('intern/v1/login')
    ) {
      window.location = '#/login'
    }
    return Promise.reject(err)
  }
)*/
export default api;
