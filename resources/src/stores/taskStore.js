import { defineStore } from 'pinia'
import TaskService from "@/services/TaskService.js";
import ProjectService from "@/services/ProjectService.js";

export const useTaskStore = defineStore('task', {
  state: () => ({
    tasks: [],
    task: null,
    taskDetail: null,
    statistics: [],
    upcoming_tasks: []
  }),
  actions: {
    async fetchTasks(){
      try {
        const response = await TaskService.getAll()
        const resData = response.data.data
        this.tasks = resData.items
        this.statistics = resData.statistics
      } catch (error){
        return error
      }
    },
    async find(id){
      try {
        const response = await TaskService.getById(id)
        const resData = response.data.data
        this.task = {
          ...resData.task,
          taskDetail: resData.task_detail
        }
        return this.task
      } catch (e) {
        console.error("find project error:", e)
        return null
      }
    },
    async removeTask(id) {
      await TaskService.delete(id)
      this.tasks = this.tasks.filter(p => p.id !== id)
    },
    async updateTaskDetailStatus(id, status) {

      const response = await api.put(
        `/task-details/${id}/status`,
        {
          status
        }
      )

      return response.data
    }
  }
})
