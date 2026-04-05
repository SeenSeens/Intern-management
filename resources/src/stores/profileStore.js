import {defineStore} from "pinia";
import ProfileService from "@/services/ProfileService.js";

export const useProfileStore = defineStore('profile', {
  state: () => ({
    profile: {},
    loading: false
  }),

  actions: {
    async loadProfile() {
      this.loading = true
      try {
        const res = await ProfileService.getMe()
        this.profile = res.data
      } finally {
        this.loading = false
      }
    },

    async saveProfile() {
      this.loading = true
      try {
        await ProfileService.updateMe(this.profile)
      } finally {
        this.loading = false
      }
    }
  }
})
