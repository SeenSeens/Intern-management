<script setup>
import {useAuthStore} from "@/stores/authStore.js"
const emit = defineEmits(["toggleSidebar"])

const auth = useAuthStore()

const logout = () => {
  auth.logout()
}
</script>

<template>
  <header class="h-16 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between px-4 md:px-8 shrink-0 z-10">
    <div class="flex items-center gap-4">
      <button  @click="emit('toggleSidebar')" class="p-2 rounded-lg text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors" id="toggleSidebar">
        <span class="material-symbols-outlined">menu</span>
      </button>
      <div class="hidden sm:flex items-center bg-slate-100 dark:bg-slate-800 rounded-lg px-3 py-1.5 w-64 lg:w-96">
        <span class="material-symbols-outlined text-slate-400 text-lg">search</span>
        <input class="bg-transparent border-none focus:ring-0 text-sm w-full placeholder:text-slate-400 dark:text-slate-200" placeholder="Tìm kiếm nhiệm vụ, dự án..." type="text"/>
      </div>
    </div>
    <div class="flex items-center gap-2 md:gap-4">
      <button class="p-2 text-slate-500 hover:bg-slate-100 rounded-full transition-colors relative">
        <span class="material-symbols-outlined">notifications</span>
        <span class="absolute top-2 right-2 w-2 h-2 bg-rose-500 rounded-full border-2 border-white"></span>
      </button>
      <button @click="toggleDark" class="p-2 text-slate-500 hover:bg-slate-100 rounded-full transition-colors" onclick="document.documentElement.classList.toggle('dark')">
        <span v-if="!darkMode" class="material-symbols-outlined dark:hidden">dark_mode</span>
        <span v-else class="material-symbols-outlined hidden dark:block">light_mode</span>
      </button>
      <div class="h-8 w-[1px] bg-slate-200 mx-1"></div>
      <div class="relative group">
      <button class="flex items-center gap-3 hover:bg-slate-100 dark:hover:bg-slate-800 p-1.5 pr-3 rounded-lg transition-all duration-200 border border-transparent hover:border-slate-200 dark:hover:border-slate-700">
          <img alt="User profile" class="w-8 h-8 rounded-full border border-slate-200" :src="auth.user.avatar"/>
          <span class="text-sm font-semibold text-slate-700 dark:text-slate-200">{{auth.user.name}}</span>
        <span class="material-symbols-outlined text-slate-400 text-sm">expand_more</span>
      </button>
      <!-- Dropdown Menu -->
      <div class="absolute right-0 mt-2 w-56 bg-white dark:bg-slate-900 rounded-xl shadow-xl border border-slate-200 dark:border-slate-800 py-2 invisible group-hover:visible opacity-0 group-hover:opacity-100 translate-y-2 group-hover:translate-y-0 transition-all duration-200 z-50">
        <div class="px-4 py-3 border-b border-slate-100 dark:border-slate-800 md:hidden">
          <p class="text-sm font-semibold text-slate-900 dark:text-white">Admin User</p>
          <p class="text-xs text-slate-500 dark:text-slate-400">Administrator</p>
        </div>
        <a class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors" href="#">
          <span class="material-symbols-outlined text-lg opacity-70">person</span>
          Hồ sơ
        </a>
        <RouterLink to="/setting" class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
          <span class="material-symbols-outlined text-lg opacity-70">settings</span>
          Cài đặt
        </RouterLink>
        <div class="h-px bg-slate-100 dark:bg-slate-800 my-1"></div>
        <a @click="logout" class="flex items-center gap-3 px-4 py-2.5 text-sm text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-900/20 transition-colors">
          <span class="material-symbols-outlined text-lg">logout</span>
          Đăng xuất
        </a>
      </div>
      </div>
    </div>
  </header>
</template>

<style scoped>

</style>
