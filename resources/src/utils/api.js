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
// REQUEST
api.interceptors.request.use(config => {
  const authStore = useAuthStore()
  // Nếu là API custom → dùng JWT
  if (authStore.accessToken) {
    config.headers.Authorization = `Bearer ${authStore.accessToken}`
  }
  //delete config.headers['X-WP-Nonce']
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
    const authStore = useAuthStore()
    const url = err.config?.url || ''
    const status = err.response?.status
    const resData = err.response?.data
    // Bắt lỗi 401 và xử lý Refresh Token
    if (err.response?.status === 401 && !originalRequest._retry) {
      originalRequest._retry = true
      try {
        const { data } = await axios.post(`${API_URL}intern/v1/refresh-token`, {
          refresh_token: authStore.refreshToken
        })
        // Chỉ cần cập nhật Store, plugin sẽ tự lưu xuống Storage cho bạn
        authStore.setTokens(data.access_token, data.refresh_token)
        originalRequest.headers.Authorization = `Bearer ${data.access_token}`
        return api(originalRequest)
      } catch (refreshErr) {
        authStore.logout()
        window.location.hash = '#/login'
        return Promise.reject(refreshErr)
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
      window.location = '#/login'
    }
    return Promise.reject(err)
  }
)
export default api;
