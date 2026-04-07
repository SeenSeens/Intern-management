import { createApp } from 'vue'
import { createPinia } from 'pinia'
import App from './App.vue'
import router from './router'
import '@/assets/style.css'
import {useAuthStore} from "@/stores/authStore.js"
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate'
const app = createApp(App)
const pinia = createPinia()
app.use(pinia)
app.use(router)
pinia.use(piniaPluginPersistedstate)
// Đăng ký Global Custom Directive 'v-permission'
app.directive('permission', {
  mounted(el, binding) {
    const auth = useAuthStore()
    const requiredPermission = binding.value

    if (!requiredPermission) return // Tránh lỗi nếu lỡ gõ v-permission=""

    // 1. Nếu truyền vào 1 MẢNG (vd: v-permission="['edit', 'delete']")
    // -> Sẽ giữ lại element nếu user có ÍT NHẤT 1 trong các quyền đó
    if (Array.isArray(requiredPermission)) {
      const hasAuth = requiredPermission.some(perm => auth.hasPermission(perm))
      if (!hasAuth) {
        el.remove() // Hàm remove() của JS hiện đại, ngắn hơn el.parentNode.removeChild(el)
      }
    }
    // 2. Nếu truyền vào 1 STRING (vd: v-permission="'manage_options'")
    else {
      if (!auth.hasPermission(requiredPermission)) {
        el.remove()
      }
    }
  }
})
app.mount('#app')
