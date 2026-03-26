<script setup>
import { onMounted } from 'vue'
import {useTaskStore} from "@/stores/taskStore.js";

const taskStore = useTaskStore();
onMounted(async () => {
  try {
    await taskStore.fetchTasks()
  } catch (err) {
    console.error("API Error:", err);
  }
})
</script>

<template>
  <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
    <div>
      <nav aria-label="Breadcrumb" class="flex text-sm text-slate-500 mb-2">
        <ol class="flex items-center space-x-2">
          <li><a class="hover:text-primary" href="#">Trang chủ</a></li>
          <li class="flex items-center space-x-2">
            <span class="material-icons text-base">chevron_right</span>
            <span class="font-medium text-slate-900">Quản lý nhiệm vụ</span>
          </li>
        </ol>
      </nav>
      <h2 class="text-2xl font-bold tracking-tight">Danh sách theo dõi nhiệm vụ và phân công</h2>
    </div>
    <button class="bg-primary hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg flex items-center gap-2 shadow-sm transition-all active:scale-95">
      <span class="material-icons text-lg">add</span>
      <span class="font-medium">Thêm task mới</span>
    </button>
  </div>
  <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white p-4 rounded-xl border border-slate-200 flex items-center gap-4">
      <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center text-primary">
        <span class="material-icons">list_alt</span>
      </div>
      <div>
        <p class="text-slate-500 text-sm">Tổng nhiệm vụ</p>
        <p class="text-2xl font-bold">{{ taskStore.statistics.total }}</p>
      </div>
    </div>
    <div class="bg-white p-4 rounded-xl border border-slate-200 flex items-center gap-4">
      <div class="w-12 h-12 rounded-lg bg-yellow-100 flex items-center justify-center text-yellow-600">
        <span class="material-icons">pending_actions</span>
      </div>
      <div>
        <p class="text-slate-500 text-sm">Đang thực hiện</p>
        <p class="text-2xl font-bold">{{ taskStore.statistics.in_progress }}</p>
      </div>
    </div>
    <div class="bg-white p-4 rounded-xl border border-slate-200 flex items-center gap-4">
      <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center text-green-600">
        <span class="material-icons">check_circle</span>
      </div>
      <div>
        <p class="text-slate-500 text-sm">Đã hoàn thành</p>
        <p class="text-2xl font-bold">82%</p>
      </div>
    </div>
    <div class="bg-white p-4 rounded-xl border border-slate-200 flex items-center gap-4">
      <div class="w-12 h-12 rounded-lg bg-red-100 flex items-center justify-center text-red-600">
        <span class="material-icons">schedule</span>
      </div>
      <div>
        <p class="text-slate-500 text-sm">Quá hạn</p>
        <p class="text-2xl font-bold">4</p>
      </div>
    </div>
  </div>
  <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="bg-slate-50 border-b border-slate-200">
            <th class="px-6 py-4 text-xs font-semibold uppercase  w-16">No.</th>
            <th class="px-6 py-4 text-xs font-semibold uppercase">Tên nhiệm vụ</th>
            <th class="px-6 py-4 text-xs font-semibold uppercase">Ngày bắt đầu</th>
            <th class="px-6 py-4 text-xs font-semibold uppercase">Ngày kết thúc</th>
            <th class="px-6 py-4 text-xs font-semibold uppercase">Dự án</th>
            <th class="px-6 py-4 text-xs font-semibold uppercase text-right">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-200">
          <tr class="hover:bg-slate-50 transition-colors group" v-for="(task, index) in taskStore.tasks" key="task.id">
            <td class="px-6 py-4 text-sm text-slate-500">{{ index + 1 }}</td>
            <td class="px-6 py-4">
              <div class="flex items-center gap-3">
                <span class="font-medium">{{ task.title }}</span>
              </div>
            </td>
            <td class="px-6 py-4 text-sm font-medium">{{ task.start_date }}</td>
            <td class="px-6 py-4 text-sm font-medium">{{ task.end_date }}</td>
            <td class="px-6 py-4">
              <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-600">{{ task.project_name }}</span>
            </td>
            <td class="px-6 py-4 text-right">
              <a class="text-primary hover:text-blue-700 font-semibold text-sm inline-flex items-center gap-1" href="#">
                Assign work <span class="material-icons text-sm">arrow_forward</span>
              </a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex items-center justify-between">
      <p class="text-sm text-slate-500">
        Hiển thị <span class="font-medium text-slate-900">1</span> đến <span class="font-medium text-slate-900">4</span> trong <span class="font-medium text-slate-900">{{ taskStore.statistics.total }}</span> kết quả
      </p>
      <div class="flex items-center gap-2">
        <button class="px-3 py-1 border border-slate-200 rounded-md text-sm hover:bg-white transition-colors">Trước</button>
        <button class="px-3 py-1 bg-primary text-white rounded-md text-sm">1</button>
        <button class="px-3 py-1 border border-slate-200 rounded-md text-sm hover:bg-white transition-colors">2</button>
        <button class="px-3 py-1 border border-slate-200 rounded-md text-sm hover:bg-white transition-colors">3</button>
        <button class="px-3 py-1 border border-slate-200 rounded-md text-sm hover:bg-white transition-colors">Sau</button>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>
