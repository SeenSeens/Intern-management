<script setup>
import { onMounted } from "vue";
import {useProjectStore} from "@/stores/projectStore.js";
import Swal from "sweetalert2";
import StatusBadge from "@/component/StatusBadge.vue";
const projectStore = useProjectStore()

onMounted(async () => {
  try {
    await projectStore.fetchProjects()
  } catch (err) {
    console.error("API Error:", err);
  }
});

const remove = async (id) => {
  const result = await Swal.fire({
    title: 'Bạn chắc chắn muốn xoá dự án?',
    text: "Dữ liệu sẽ bị xoá!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Xoá',
    cancelButtonText: 'Huỷ'
  })

  if (result.isConfirmed) {
    await projectStore.removeProject(id)
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
            <span class="font-medium text-slate-900">Quản lý dự án</span>
          </li>
        </ol>
      </nav>
      <h2 class="text-2xl font-bold tracking-tight">Danh sách theo dõi dự án và phân công</h2>
    </div>
    <RouterLink v-permission="'create_project'" :to="{ name: 'project-new' }" class="px-5 py-2.5 rounded-lg flex items-center gap-2 shadow-sm transition-all active:scale-95">
      <span class="material-icons text-lg">add</span>
      <span class="font-medium">Thêm dự án</span>
    </RouterLink>
  </div>
  <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
      <div class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
        <div class="text-slate-500 dark:text-slate-400 text-xs font-semibold uppercase tracking-wider mb-1">Tổng dự án</div>
        <div class="text-2xl font-bold">{{ projectStore.statistics.total }}</div>
      </div>
      <div class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
        <div class="text-blue-500 dark:text-blue-400 text-xs font-semibold uppercase tracking-wider mb-1">Đang triển khai</div>
        <div class="text-2xl font-bold">{{ projectStore.statistics.in_progress }}</div>
      </div>
      <div class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
        <div class="text-amber-500 dark:text-amber-400 text-xs font-semibold uppercase tracking-wider mb-1">Chờ xử lý</div>
        <div class="text-2xl font-bold">{{ projectStore.statistics.waiting }}</div>
      </div>
      <div class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
        <div class="text-emerald-500 dark:text-emerald-400 text-xs font-semibold uppercase tracking-wider mb-1">Đã hoàn thành</div>
        <div class="text-2xl font-bold">{{ projectStore.statistics.completed }}</div>
      </div>
    </div>
  <div class="pb-8 flex-1">
    <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
          <thead>
            <tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800">
              <th class="px-6 py-2.5 text-xs font-semibold tracking-widest w-12">No</th>
              <th class="px-6 py-2.5 text-xs font-semibold tracking-widest">Dự án</th>
              <th class="px-6 py-2.5 text-xs font-semibold tracking-widest">Trạng thái</th>
              <th class="px-6 py-2.5 text-xs font-semibold tracking-widest">Bắt đầu</th>
              <th class="px-6 py-2.5 text-xs font-semibold tracking-widest">Kết thúc</th>
              <th class="px-6 py-2.5 text-xs font-semibold tracking-widest text-right w-36">Thao tác</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors" v-for="(project, index) in projectStore.projects" :key="project.id">
              <td class="px-6 py-2.5 text-xs text-slate-500">{{ index + 1 }}</td>
              <td class="px-6 py-2.5 font-semibold text-slate-900 dark:text-white text-sm">{{project.name}}</td>
              <td class="px-6 py-2.5">
                <StatusBadge :status="project.status" />
              </td>
              <td class="px-6 py-2.5 text-xs text-slate-600 dark:text-slate-400">{{project.start_date}}</td>
              <td class="px-6 py-2.5 text-xs text-slate-600 dark:text-slate-400">{{project.end_date}}</td>
              <td class="px-6 py-2.5 text-right">
                <div class="flex items-center justify-end gap-1">
                  <div class="w-px h-4 bg-slate-200 mx-1"></div>
                  <RouterLink :to="{ name: 'project-view', params: { id: project.id } }" class="p-1.5 rounded hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-red-500 transition-all" title="Xem">
                    <span class="material-symbols-outlined">visibility</span>
                  </RouterLink>
                  <RouterLink v-permission="'edit_project'" :to="{ name: 'project-edit', params: { id: project.id } }" class="p-1.5 rounded hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-red-500 transition-all" title="Sửa">
                    <span class="material-icons text-lg">edit</span>
                  </RouterLink>
                  <button v-permission="'delete_project'" @click="remove(project.id)" class="p-1.5 rounded hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-slate-800 dark:hover:text-white transition-all text-slate-500 dark:text-slate-400" title="Xóa">
                    <span class="material-icons text-lg">delete</span>
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>
