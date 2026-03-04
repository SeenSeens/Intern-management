import {createRouter, createWebHashHistory, createWebHistory} from 'vue-router'
import Dashboard from "@/views/Dashboard.vue";
import Project from "@/views/Project.vue";
import Member from "@/views/Member.vue";
import Setting from "@/views/Setting.vue";
import Task from "@/views/Task.vue";

const router = createRouter({
  history: createWebHashHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'dashboard',
      component: Dashboard
    },
    {
      path: '/member',
      name: 'member',
      component: Member
    },
    {
      path: '/project',
      name: 'project',
      component: Project
    },
    {
      path: '/task',
      name: 'task',
      component: Task
    },
    {
      path: '/setting',
      name: 'setting',
      component: Setting
    },
  ],
})

export default router
