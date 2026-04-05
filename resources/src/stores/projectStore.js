import { defineStore } from 'pinia'
import ProjectService from '@/services/ProjectService.js'
export const useProjectStore = defineStore('project', {
  state: () => ({
    projects: [],
    project: null,
    //mentors: [],
    //interns: [],
    loading: false,
    meta: [],
    statistics: [],
    //overall: []
  }),
  actions: {
    async fetchProjects(page = 1) {
      this.loading = true
      try {
        const response = await ProjectService.getAll()
        const resData = response.data.data
        this.projects = resData.items
        this.meta  = resData.meta
        this.statistics = resData.statistics
      } catch (error) {
        console.error(error)
      }
      this.loading = false
    },

    async find(id){
      try {
        const response = await ProjectService.getById(id)
        const resData = response.data.data
        this.project = {
          ...resData.project,
          mentors: resData.mentor,
          interns: resData.intern,
          overall: resData.overall,
          tasksProject: resData.task_project
        }
        return this.project
      } catch (e) {
        console.error("find project error:", e)
        return null
      }
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
    },
  }
})
