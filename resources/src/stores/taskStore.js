import { defineStore } from 'pinia'
import TaskService from "@/services/TaskService.js";

export const useTaskStore = defineStore('task', {
  state: () => ({
    tasks: [],
    statistics: {
      pending: 0,
      in_progress: 0,
      completed: 0,
      total: 0
    }
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
    }
  }
})
