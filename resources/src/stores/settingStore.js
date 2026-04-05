import {defineStore} from "pinia";
import SettingService from "@/services/SettingService.js";

export const useSettingStore = defineStore('settings', {
  state: () => ({
    general: {},
    notifications: {},
    system: {},
    loading: false
  }),

  actions: {
    /* ========= GENERAL ========= */
    async loadGeneral() {
      this.loading = true
      try {
        const res = await SettingService.getGeneral()
        this.general = res.data.data
      } finally {
        this.loading = false
      }
    },

    async saveGeneral() {
      this.loading = true
      try {
        const res = await SettingService.updateGeneral(this.general)
        this.general = res.data.data
      } finally {
        this.loading = false
      }
    },

    /* ========= NOTIFICATION ========= */
    async loadNotifications() {
      const res = await SettingService.getNotifications()
      this.notifications = res.data.data
    },

    async saveNotifications() {
      await SettingService.updateNotifications(this.notifications)
    },

    /* ========= SYSTEM ========= */
    async loadSystem() {
      const res = await SettingService.getSystem()
      this.system = res.data.data
    },

    async saveSystem() {
      await SettingService.updateSystem(this.system)
    }
  }
})
