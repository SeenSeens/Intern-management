import { defineStore } from 'pinia'
import ProjectService from '@/services/ProjectService.js'
export const useProjectStore = defineStore('project', {
  state: () => ({
    projects: [],
    loading: false,
    meta: {
      current_page: 1,
      per_page: 10,
      total: 0,
      last_page: 1,

    },
    statistics: {
      in_progress: 0,
      waiting: 0,
      on_hold: 0,
      completed: 0,
      total: 0
    }
  }),
  actions: {
    async fetchProjects(page = 1) {
      this.loading = true
      try {
        const response = await ProjectService.getAll()
        const resData = response.data.data
        this.projects = resData.items
        this.pagination = resData.meta
        this.currentPage = resData.current_page
        this.statistics = resData.statistics;
      } catch (error) {
        console.error(error)
      }
      this.loading = false
    },

    async createProject(data) {
      try {
        const res = await ProjectService.create(data)
        this.projects.unshift(res.data)
        return res.data
      }
      catch (error) {
        console.error(error)
      }
    },

    async updateProject(id, data) {
      const res = await ProjectService.update(id, data)
      const index = this.projects.findIndex(p => p.id === id)
      if (index !== -1) {
        this.projects[index] = res.data
      }
    },

    async removeProject(id) {
      await ProjectService.delete(id)
      this.projects = this.projects.filter(p => p.id !== id)
    }
  }
})
