<script setup>
import {computed, onMounted, ref} from "vue";
import {useProjectStore} from "@/stores/projectStore.js";
import Swal from "sweetalert2";
import { useRouter } from 'vue-router'
const projectStore = useProjectStore()
const router = useRouter()

onMounted(async () => {
  try {
    await projectStore.fetchProjects()
  } catch (err) {
    console.error("API Error:", err);
  }
});
const start = computed(() => (projectStore.meta.current_page - 1) * projectStore.meta.per_page + 1);
const end = computed(() =>
  Math.min(projectStore.meta.current_page * projectStore.meta.per_page, projectStore.meta.total)
);

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
            <span class="font-medium text-slate-900 dark:text-slate-200">Quản lý dự án</span>
          </li>
        </ol>
      </nav>
      <h2 class="text-2xl font-bold tracking-tight">Danh sách theo dõi dự án và phân công</h2>
    </div>
    <RouterLink :to="{ name: 'project-new' }" class="bg-primary hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg flex items-center gap-2 shadow-sm transition-all active:scale-95">
      <span class="material-icons text-lg">add</span>
      <span class="font-medium">Thêm dự án</span>
    </RouterLink>
  </div>
  <div class="p-8 pb-0">
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
  </div>
  <div class="px-8 pb-8 flex-1">
    <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
          <thead>
          <tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800">
            <th class="px-6 py-2.5 text-[10px] font-semibold text-slate-500 uppercase tracking-widest w-12">No</th>
            <th class="px-6 py-2.5 text-[10px] font-semibold text-slate-500 uppercase tracking-widest">Dự án &amp; Mã</th>
            <th class="px-6 py-2.5 text-[10px] font-semibold text-slate-500 uppercase tracking-widest">Người tạo</th>
            <th class="px-6 py-2.5 text-[10px] font-semibold text-slate-500 uppercase tracking-widest">Trạng thái</th>
            <th class="px-6 py-2.5 text-[10px] font-semibold text-slate-500 uppercase tracking-widest">Bắt đầu</th>
            <th class="px-6 py-2.5 text-[10px] font-semibold text-slate-500 uppercase tracking-widest">Kết thúc</th>
            <th class="px-6 py-2.5 text-[10px] font-semibold text-slate-500 uppercase tracking-widest text-right w-36">Thao tác</th>
          </tr>
          </thead>
          <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
          <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors" v-for="(project, index) in projectStore.projects" :key="project.id">
            <td class="px-6 py-2.5 text-xs text-slate-500">{{ start + index }}</td>
            <td class="px-6 py-2.5">
              <div class="flex flex-col">
                <span class="font-semibold text-slate-900 dark:text-white text-sm">{{project.name}}</span>
                <span class="text-[10px] text-slate-400 uppercase tracking-tighter">{{project.id}}</span>
              </div>
            </td>
            <td class="px-6 py-2.5 text-xs">admin</td>
            <td class="px-6 py-2.5">
              <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">{{ project.status }}</span>
            </td>
            <td class="px-6 py-2.5 text-xs text-slate-600 dark:text-slate-400">{{project.start_date}}</td>
            <td class="px-6 py-2.5 text-xs text-slate-600 dark:text-slate-400">{{project.end_date}}</td>
            <td class="px-6 py-2.5 text-right">
              <div class="flex items-center justify-end gap-1">
                <button class="p-1.5 rounded hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-primary transition-all" title="Thành viên">
                  <span class="material-icons text-lg">group</span>
                </button>
                <button class="p-1.5 rounded hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-primary transition-all" title="Nhiệm vụ">
                  <span class="material-icons text-lg">assignment_turned_in</span>
                </button>
                <div class="w-px h-4 bg-slate-200 dark:bg-slate-700 mx-1"></div>
                <RouterLink :to="{ name: 'project-edit', params: { id: project.id } }" class="p-1.5 rounded hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-amber-500 transition-all" title="Sửa">
                  <span class="material-icons text-lg">edit</span>
                </RouterLink>
                <button @click="remove(project.id)" class="p-1.5 rounded hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-red-500 transition-all" title="Xóa">
                  <span class="material-icons text-lg">delete</span>
                </button>
              </div>
            </td>
          </tr>
          </tbody>
        </table>
      </div>
      <div class="px-6 py-3 bg-slate-50 dark:bg-slate-800/50 border-t border-slate-200 dark:border-slate-800 flex items-center justify-between">
        <span class="text-xs text-slate-500 dark:text-slate-400">Hiển thị {{ start }}-{{ end }} trong số {{ projectStore.statistics.total }} dự án</span>
        <div class="flex items-center gap-2">
          <button class="p-1.5 border border-slate-300 dark:border-slate-600 rounded-lg hover:bg-white dark:hover:bg-slate-700 disabled:opacity-50" disabled="">
            <span class="material-icons text-sm">chevron_left</span>
          </button>
          <button class="px-2.5 py-1 bg-primary text-white rounded-lg text-xs font-medium">1</button>
          <button class="px-2.5 py-1 border border-slate-300 dark:border-slate-600 rounded-lg text-xs font-medium hover:bg-white dark:hover:bg-slate-700">2</button>
          <button class="px-2.5 py-1 border border-slate-300 dark:border-slate-600 rounded-lg text-xs font-medium hover:bg-white dark:hover:bg-slate-700">3</button>
          <button class="p-1.5 border border-slate-300 dark:border-slate-600 rounded-lg hover:bg-white dark:hover:bg-slate-700">
            <span class="material-icons text-sm">chevron_right</span>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>
