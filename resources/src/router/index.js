import {createRouter, createWebHashHistory, createWebHistory} from 'vue-router'
import Dashboard from "@/views/Dashboard.vue";
import Project from "@/views/project/Project.vue";
import Member from "@/views/user/Member.vue";
import Setting from "@/views/Setting.vue";
import Task from "@/views/task/Task.vue";
import NewProject from "@/views/project/NewProject.vue";
import Login from "@/views/auth/Login.vue";
import Auth from "@/layouts/Auth.vue";
import App from "@/layouts/App.vue";
import {useAuthStore} from "@/stores/authStore.js";
import EditProject from "@/views/project/EditProject.vue";
import DetailProject from "@/views/project/DetailProject.vue";
import DetailTask from "@/views/task/DetailTask.vue";

const router = createRouter({
  history: createWebHashHistory(import.meta.env.BASE_URL),
  //linkActiveClass: 'active-nav',
  linkExactActiveClass: 'active-nav',
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
      meta: { requiresAuth: true },
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
          component: NewProject,
          meta: {
            requiresPermission: 'create_project'
          }
        },
        {
          path: 'project/edit/:id',
          name: 'project-edit',
          component: EditProject,
          meta: {
            requiresPermission: 'edit_project'
          }
        },
        {
          path: 'project/view/:id',
          name: 'project-view',
          component: DetailProject
        },
        {
          path: 'task',
          name: 'task',
          component: Task
        },
        {
          path: 'task/view/:id',
          name: 'task-view',
          component: DetailTask
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

router.beforeEach(async (to, from, next) => {
  const auth = useAuthStore()
  if (!auth.checked) {
    await new Promise(resolve => setTimeout(resolve, 50))
    await auth.fetchUser()
  }
  // Chặn người dùng chưa đăng nhập
  if (to.meta.requiresAuth && !auth.user) {
    return next({path: '/login', query: { redirect: to.fullPath }})
  }
  // Chặn người dùng đã đăng nhập nhưng cố quay lại login
  if(to.path === '/login' && auth.user){
    return next('/')
  }
  // Kiểm tra phân quyền (Capabilities)
  // Nếu route có quy định quyền cụ thể (vd: requiresPermission: 'create_project')
  if (to.meta.requiresPermission) {
    // Gọi hàm hasPermission từ store 'auth'
    if (!auth.hasPermission(to.meta.requiresPermission)) {
      // Nếu KHÔNG có quyền, đẩy về trang chủ hoặc trang báo lỗi 403 tuỳ bạn
      return next('/')
    }
  }
  next()
})

export default router
