import axios from "axios"
import { API_URL, NONCE } from "@/utils/config.js"
import { toastSuccess, toastError } from "@/utils/toast.js"
import { useAuthStore } from "@/stores/authStore.js"
const api = axios.create({
  baseURL: API_URL,
  headers: {
    // "X-WP-Nonce": NONCE,
    "Content-Type": "application/json"
  },
  withCredentials: true
});
let isRefreshing = false;
let failedQueue = [];
const processQueue = (error, token = null) => {
  failedQueue.forEach(prom => {
    if (error) {
      prom.reject(error);
    } else {
      prom.resolve(token);
    }
  });
  failedQueue = [];
};
// REQUEST
api.interceptors.request.use(config => {
  const token = localStorage.getItem('access_token')
  // Nếu là API custom → dùng JWT
  if (config.url?.includes('/intern/v1/')) {
    if (token) {
      config.headers.Authorization = `Bearer ${token}`
    }
    delete config.headers['X-WP-Nonce']
  }
  // Nếu là WP API → dùng nonce
  if (config.url.includes('/wp/v2/')) {
    config.headers['X-WP-Nonce'] = NONCE
  }
  return config
})
api.interceptors.response.use(
  res => {
    if (res.data?.message){
      toastSuccess(res.data.message)
    }
    return res
  },
  async err => {
    const originalRequest = err.config
    const url = err.config?.url || ''
    const status = err.response?.status
    const resData = err.response?.data
    // Bắt lỗi 401 và xử lý Refresh Token
    if (status === 401 && !url.includes('/intern/v1/login') && !url.includes('/intern/v1/refresh-token') && !originalRequest._retry) {
      if (isRefreshing) {
        return new Promise(function(resolve, reject) {
          failedQueue.push({ resolve, reject });
        }).then(token => {
          originalRequest.headers.Authorization = 'Bearer ' + token;
          return api(originalRequest);
        }).catch(err => Promise.reject(err));
      }
      originalRequest._retry = true;
      isRefreshing = true;
      const authStore = useAuthStore();
      const refreshToken = authStore.refreshToken;
      if (!refreshToken) {
        authStore.logout();
        return Promise.reject(err);
      }
      try {
        const { data } = await axios.post(`${API_URL}/intern/v1/refresh-token`, {
          refresh_token: refreshToken
        });
        const newAccessToken = data.access_token || data.data?.access_token;
        const newRefreshToken = data.refresh_token || data.data?.refresh_token;
        authStore.setTokens(newAccessToken, newRefreshToken);
        processQueue(null, newAccessToken);
        originalRequest.headers.Authorization = `Bearer ${newAccessToken}`;
        return api(originalRequest);
      } catch (refreshErr) {
        processQueue(refreshErr, null);
        authStore.logout();
        return Promise.reject(refreshErr);
      } finally {
        isRefreshing = false;
      }
    }
    // Lấy message chuẩn từ backend
    const message = resData?.error || resData?.message || 'Có lỗi xảy ra'
    if (status !== 401 || originalRequest._retry === false) {
      toastError(message);
    }
    // Gắn message vào error để dùng lại
    err.message = message
    // Auto logout nếu 401
    if (status === 401 && !url.includes('/intern/v1/login')) {
      localStorage.removeItem('access_token')
      localStorage.removeItem('refresh_token')
      window.location = '#/login'
    }
    return Promise.reject(err)
  }
)
export default api;
