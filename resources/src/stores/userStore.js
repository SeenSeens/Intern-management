import {defineStore} from "pinia";
import UserService from "@/services/UserService.js";

export const useUserStore = defineStore('user', {
  state: () => ({
    loading: false,
    users: [],
    usersByRole: {},
    countUser: {
      administrator: 0,
      project_manager: 0,
      hr: 0,
      mentor: 0,
      intern: 0
    }
  }),

  getters: {
    // dùng cho select
    userOptions: (state) => (role) => {
      const users = state.usersByRole[role] || []
      return users.map(user => ({
        name: user.name,
        id: user.id
      }))
    }
  },

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
    },
    async getUsersByRole(roles = []){
      this.loading = true
      try {
        const requests = roles.map(role =>
          UserService.getUsersByRole(role)
        )
        const responses = await Promise.all(requests)
        responses.forEach((res, index) => {
          const role = roles[index]
          if (res.data.success) {
            this.usersByRole[role] = res.data.data
          }
        })
      } catch (err) {
        console.error(err)
      } finally {
        this.loading = false
      }
    }
  }
})
