import {createRouter, createWebHashHistory, createWebHistory} from 'vue-router'
import Dashboard from "@/views/Dashboard.vue";
import Project from "@/views/Project.vue";
import Member from "@/views/Member.vue";
import Setting from "@/views/Setting.vue";
import Task from "@/views/Task.vue";
import NewProject from "@/views/NewProject.vue";
import Login from "@/views/Login.vue";
import Auth from "@/layouts/Auth.vue";
import App from "@/layouts/App.vue";
import {useAuthStore} from "@/stores/authStore.js";
import EditProject from "@/views/EditProject.vue";

const router = createRouter({
  history: createWebHashHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/login',
      component: Auth,
      meta: { requiresAuth: false },
      children: [
        {
          path: '',
          component: Login
        }
      ]
    },
    {
      path: '/',
      component: App,
      meta: { requiresAuth: false },
      children: [
        {
          name: 'dashboard',
          path: '',
          component: Dashboard
        },
        {
          path: 'member',
          name: 'member',
          component: Member
        },
        {
          path: 'project',
          name: 'project',
          component: Project,
        },
        {
          path: 'project/new',
          name: 'project-new',
          component: NewProject
        },
        {
          path: 'project/edit/:id',
          name: 'project-edit',
          component: EditProject
        },
        {
          path: 'task',
          name: 'task',
          component: Task
        },
        {
          path: 'setting',
          name: 'setting',
          component: Setting
        },
      ]
    },
  ],
})

/*router.beforeEach(async (to, from, next) => {
  const auth = useAuthStore()
  if (!auth.user) {
    await auth.fetchUser()
  }

  if ( to.meta.requiresAuth && !auth.user ) {
    next('/login')
  }

  else if (to.path === '/login' && auth.user) {
    next('/')
  }

  else {
    next()
  }

})*/

export default router
