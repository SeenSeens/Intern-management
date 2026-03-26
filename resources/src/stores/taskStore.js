import { defineStore } from 'pinia'
import TaskService from "@/services/TaskService.js";

export const useTaskStore = defineStore('task', {
  state: () => ({
    tasks: [],
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
    }
  }
})
