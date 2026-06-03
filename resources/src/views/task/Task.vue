<script setup>
import { onMounted } from 'vue'
import {useTaskStore} from "@/stores/taskStore.js";
import Swal from "sweetalert2";

const taskStore = useTaskStore();
onMounted(async () => {
  try {
    await taskStore.fetchTasks()
  } catch (err) {
    console.error("API Error:", err);
  }
})
const remove = async (id) => {
  const result = await Swal.fire({
    title: 'Bạn chắc chắn muốn xoá task này?',
    text: "Dữ liệu sẽ bị xoá!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Xoá',
    cancelButtonText: 'Huỷ'
  })

  if (result.isConfirmed) {
    await taskStore.removeTask(id)
  }
}
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
  <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800">
            <th class="px-6 py-2.5 text-xs font-semibold tracking-widest w-12">No.</th>
            <th class="px-6 py-2.5 text-xs font-semibold tracking-widest">Tên nhiệm vụ</th>
            <th class="px-6 py-2.5 text-xs font-semibold tracking-widest">Ngày bắt đầu</th>
            <th class="px-6 py-2.5 text-xs font-semibold tracking-widest">Ngày kết thúc</th>
            <th class="px-6 py-2.5 text-xs font-semibold tracking-widest">Dự án</th>
            <th class="px-6 py-2.5 text-xs font-semibold tracking-widest text-right">Thao tác</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
          <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors group" v-for="(task, index) in taskStore.tasks" key="task.id">
            <td class="px-6 py-2.5 text-sm text-slate-500">{{ index + 1 }}</td>
            <td class="px-6 py-2.5 font-semibold text-slate-900 dark:text-white text-sm">{{ task.title }}</td>
            <td class="px-6 py-2.5 text-sm font-medium">{{ task.start_date }}</td>
            <td class="px-6 py-2.5 text-sm font-medium">{{ task.end_date }}</td>
            <td class="px-6 py-2.5 text-sm font-medium">{{ task.project_name }}</td>
            <td class="px-6 py-2.5 text-right">
              <div class="flex items-center justify-end gap-1">
                <div class="w-px h-4 bg-slate-200 mx-1"></div>
                <RouterLink :to="{ name: 'task-view', params: { id: task.id }}" class="p-1.5 rounded hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-red-500 transition-all" title="Xem" >
                  <span class="material-symbols-outlined">visibility</span>
                </RouterLink>
                <RouterLink to="" class="p-1.5 rounded hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-red-500 transition-all" title="Sửa" >
                  <span class="material-icons text-lg">edit</span>
                </RouterLink>
                <button @click="remove(task.id)" class="p-1.5 rounded hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-slate-800 dark:hover:text-white transition-all text-slate-500 dark:text-slate-400" title="Xóa">
                  <span class="material-icons text-lg">delete</span>
                </button>
              </div>
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
