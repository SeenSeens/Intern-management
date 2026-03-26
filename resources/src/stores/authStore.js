import { defineStore } from 'pinia'
import AuthService from "@/services/AuthService.js";

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
    loading: false,
    checked: false
  }),

  getters: {
    isLoggedIn: (state) => !!state.user
  },

  actions: {
    async login(username, password){
      if(this.loading) return
      this.loading = true
      try {
        await AuthService.login(username, password)
        await new Promise(r => setTimeout(r, 100))
        const res = await AuthService.me()
        this.user = res.data
        this.checked = true
        return this.user
      } catch (e) {
        throw e
      } finally {
        this.loading = false
      }
    },
    async fetchUser() {
      if(this.checked) return
      try {
        const res = await AuthService.me()
        this.user = res.data
      } catch (e){
        this.user = null
      }
      this.checked = true
      return this.user
    }
  }
})
