import { defineStore } from 'pinia'
import AuthService from "@/services/AuthService.js"
export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
    accessToken: null,
    refreshToken: null,
    loading: false,
    checked: false,
    permissions: [],
  }),
  getters: {
    // Kiểm tra đã đăng nhập chưa (phải có cả user và token)
    isLoggedIn: (state) => !!state.user && !state.accessToken,
    // Hàm dùng chung để check xem user có 1 quyền cụ thể hay không
    hasPermission: (state) => {
      return (permissionName) => state.permissions.includes(permissionName)
    }
  },
  actions: {
    setTokens(access, refresh) {
      this.accessToken = access
      this.refreshToken = refresh
    },
    setPermissions(perms) {
      this.permissions = perms
    },
    clearAuth() {
      this.user = null
      this.accessToken = null
      this.refreshToken = null
      this.permissions = []
    },
    async login(username, password){
      if(this.loading) return
      this.loading = true
      try {
        const { user, access_token, refresh_token } = await AuthService.login(username, password)
        await new Promise(r => setTimeout(r, 100))
        this.user = user
        this.setTokens(access_token, refresh_token)
        // Trích xuất capabilities từ WP User Object thành mảng permissions
        if (user?.capabilities) {
          this.permissions = Object.keys(user.capabilities)
        }
        // Gọi API /me để lấy thông tin User dựa trên Token vừa nhận
        await this.fetchUser()
        this.checked = true
      } catch (e) {
        this.clearAuth()
        throw new Error(e.response?.data?.error || e.message)
      } finally {
        this.loading = false
      }
    },
    async fetchUser() {
      if(this.checked) return
      try {
        // ưu tiên JWT
        const res = await AuthService.meJWT()
        this.user = res.data.data
        if (this.user?.capabilities) {
          this.permissions = Object.keys(this.user.capabilities)
        }
      } catch (e){
        try {
          // fallback cookie
          const res = await AuthService.meWP()
          this.user = res.data
          if (this.user?.capabilities) {
            this.permissions = Object.keys(this.user.capabilities)
          }
        } catch (e2) {
          this.logout()
        }
      }
      this.checked = true
      return this.user
    },
    logout() {
      this.clearAuth()
      this.checked = true
      //delete axios.defaults.headers.common['Authorization']
      window.location.href = '#/login'
    }
  },
  // Cấu hình lưu trữ
  persist: {
    key: 'intern-auth-storage', // Tên key dưới Storage
    storage: sessionStorage, // Thay bằng localStorage nếu muốn đóng trình duyệt vẫn còn login
  },
})
