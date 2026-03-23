<script setup>
import {onMounted} from "vue";
import {useUserStore} from "@/stores/userStore.js";

const userStore = useUserStore()
onMounted(async () => {
  try {
    await userStore.fetchUsers()
  } catch (err) {
    console.error("API Error:", err);
  }
});
</script>

<template>
  <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
    <div>
      <nav aria-label="Breadcrumb" class="flex text-sm text-slate-500 mb-2">
        <ol class="flex items-center space-x-2">
          <li><a class="hover:text-primary" href="#">Trang chủ</a></li>
          <li class="flex items-center space-x-2">
            <span class="material-icons text-base">chevron_right</span>
            <span class="font-medium text-slate-900">Quản lý thành viên</span>
          </li>
        </ol>
      </nav>
      <h2 class="text-2xl font-bold tracking-tight">Quản lý thành viên</h2>
      <p class="text-slate-500 mt-1">Quản lý danh sách thực tập sinh, mentor và quản trị viên hệ thống.</p>
    </div>
    <div class="flex items-center gap-3">
      <button class="flex items-center gap-2 px-4 py-2 border border-slate-200 bg-white rounded-lg hover:bg-slate-50 transition-colors text-sm font-medium">
        <span class="material-symbols-outlined text-lg">download</span>
        Xuất danh sách
      </button>
      <RouterLink :to="{ name: 'project-new' }" class="flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-lg hover:bg-blue-600 transition-colors text-sm font-medium shadow-sm">
        <span class="material-icons text-lg">add</span>
        <span class="font-medium">Thêm thành viên</span>
      </RouterLink>
    </div>
  </div>
  <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm mb-6">
    <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
      <div class="relative w-full md:w-96">
        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">search</span>
        <input class="w-full pl-10 pr-4 py-2 bg-slate-50 border-slate-200 rounded-lg text-sm focus:ring-primary focus:border-primary" placeholder="Tìm kiếm theo tên, email hoặc mã số..." type="text"/>
      </div>
      <div class="flex items-center gap-3 w-full md:w-auto">
        <div class="relative flex-1 md:flex-none">
          <select class="w-full pl-3 pr-8 py-2 bg-slate-50 border-slate-200 rounded-lg text-sm focus:ring-primary focus:border-primary appearance-none cursor-pointer">
            <option value="">Tất cả vai trò</option>
            <option value="intern">Intern</option>
            <option value="mentor">Mentor</option>
            <option value="admin">Admin</option>
          </select>
          <span class="material-symbols-outlined absolute right-2 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-lg">expand_more</span>
        </div>
        <div class="relative flex-1 md:flex-none">
          <select class="w-full pl-3 pr-8 py-2 bg-slate-50 border-slate-200 rounded-lg text-sm focus:ring-primary focus:border-primary appearance-none cursor-pointer">
            <option value="">Tất cả dự án</option>
            <option value="ui">Redesign Dashboard</option>
            <option value="api">Backend Services</option>
            <option value="sec">Security Audit</option>
          </select>
          <span class="material-symbols-outlined absolute right-2 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-lg">expand_more</span>
        </div>
        <button class="p-2 text-slate-500 hover:bg-slate-100 rounded-lg transition-colors border border-slate-200 bg-white">
          <span class="material-symbols-outlined">filter_list</span>
        </button>
      </div>
    </div>
  </div>
  <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead class="bg-slate-50">
        <tr>
          <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider w-12">
            <input class="rounded border-slate-300 text-primary focus:ring-primary" type="checkbox"/>
          </th>
          <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Họ và tên</th>
          <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Vai trò</th>
          <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Email</th>
          <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right">Thao tác</th>
        </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
          <tr class="hover:bg-slate-50 transition-colors group" v-for="(user, index) in userStore.users" :key="user.id">
          <td class="px-6 py-4">
            <input class="rounded border-slate-300 text-primary focus:ring-primary" type="checkbox"/>
          </td>
          <td class="px-6 py-4">
            <div class="flex items-center gap-3">
              <img alt="User Avatar" class="w-10 h-10 rounded-full object-cover border border-slate-200" :src="user.avatar"/>
              <div>
                <div class="font-medium text-slate-900 text-sm">{{ user.name }}</div>
              </div>
            </div>
          </td>
          <td class="px-6 py-4">
<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">{{ user.role }}</span>
          </td>
          <td class="px-6 py-4 text-sm text-slate-600">{{ user.email }}</td>
          <td class="px-6 py-4 text-right">
            <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
              <button class="p-1.5 text-slate-400 hover:text-primary hover:bg-blue-50 rounded-md transition-colors" title="Chỉnh sửa">
                <span class="material-symbols-outlined text-lg">edit</span>
              </button>
              <button class="p-1.5 text-slate-400 hover:text-rose-500 hover:bg-rose-50 rounded-md transition-colors" title="Xóa">
                <span class="material-symbols-outlined text-lg">delete</span>
              </button>
            </div>
          </td>
        </tr>
        </tbody>
      </table>
    </div>
    <div class="px-6 py-4 border-t border-slate-200 flex items-center justify-between">
      <div class="text-sm text-slate-500">
        Hiển thị <span class="font-medium text-slate-900">1</span> đến <span class="font-medium text-slate-900">5</span> trong số <span class="font-medium text-slate-900">24</span> thành viên
      </div>
      <div class="flex items-center gap-2">
        <button class="p-2 border border-slate-200 rounded-lg hover:bg-slate-50 disabled:opacity-50 disabled:cursor-not-allowed text-slate-500" disabled="">
          <span class="material-symbols-outlined text-sm">chevron_left</span>
        </button>
        <button class="px-3 py-1 border border-primary bg-primary text-white rounded-lg text-sm font-medium">1</button>
        <button class="px-3 py-1 border border-slate-200 text-slate-600 hover:bg-slate-50 rounded-lg text-sm font-medium transition-colors">2</button>
        <button class="px-3 py-1 border border-slate-200 text-slate-600 hover:bg-slate-50 rounded-lg text-sm font-medium transition-colors">3</button>
        <span class="text-slate-400">...</span>
        <button class="p-2 border border-slate-200 rounded-lg hover:bg-slate-50 text-slate-500 transition-colors">
          <span class="material-symbols-outlined text-sm">chevron_right</span>
        </button>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>
