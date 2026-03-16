import {defineStore} from "pinia";
import UserService from "@/services/UserService.js";

export const useUserStore = defineStore('user', {
  state: () => ({
    users: [],
    countUser: {
      administrator: 0,
      project_manager: 0,
      hr: 0,
      mentor: 0,
      intern: 0
    }
  }),
  actions: {
    async fetchUsers() {
      try {
        const response = await UserService.getAll()
        this.users = response.data.data
      } catch (error) {
        return error
      }
    },
    async countUsersRoles() {
      try {
        const response = await UserService.countUsersByRole()
        this.countUser = response.data.data

      } catch (error) {
        return error
      }
    }
  }
})
