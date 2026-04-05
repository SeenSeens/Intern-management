import { defineStore } from 'pinia'
import AuthService from "@/services/AuthService.js"
import axios from "axios"
export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
    accessToken: localStorage.getItem('access_token') || null,
    refreshToken: localStorage.getItem('refresh_token') || null,
    loading: false,
    checked: false
  }),
  getters: {
    isLoggedIn: (state) => !!state.user
  },
  actions: {
    setTokens(access, refresh) {
      this.accessToken = access
      this.refreshToken = refresh
      localStorage.setItem('access_token', access)
      localStorage.setItem('refresh_token', refresh)
    },
    clearAuth() {
      this.user = null
      this.accessToken = null
      this.refreshToken = null
      localStorage.removeItem('access_token')
      localStorage.removeItem('refresh_token')
    },
    async login(username, password){
      if(this.loading) return
      this.loading = true
      try {
        const { user, access_token, refresh_token } = await AuthService.login(username, password)
        await new Promise(r => setTimeout(r, 100))
        this.user = user
        this.setTokens(access_token, refresh_token)
        this.checked = true
      } catch (e) {
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
      } catch (e){
        try {
          // fallback cookie
          const res = await AuthService.meWP()
          this.user = res.data.data
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
      delete axios.defaults.headers.common['Authorization']
      window.location.href = '#/login'
    }
  }
})
