<script setup>
import ProjectService from "@/services/ProjectService.js";
import { onMounted, ref } from "vue";

const projects = ref([]);
onMounted(async () => {
  try {
    const response = await ProjectService.getAll();
    console.log("Full response:", response);
    console.log("Response data:", response.data);
    projects.value = response.data;
  } catch (err) {
    console.error("API Error:", err);
  }
});
</script>

<template>
  <div class="p-8 pb-0">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
      <div class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
        <div class="text-slate-500 dark:text-slate-400 text-xs font-semibold uppercase tracking-wider mb-1">Tổng dự án</div>
        <div class="text-2xl font-bold">12</div>
      </div>
      <div class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
        <div class="text-blue-500 dark:text-blue-400 text-xs font-semibold uppercase tracking-wider mb-1">Đang triển khai</div>
        <div class="text-2xl font-bold">5</div>
      </div>
      <div class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
        <div class="text-amber-500 dark:text-amber-400 text-xs font-semibold uppercase tracking-wider mb-1">Chờ xử lý</div>
        <div class="text-2xl font-bold">3</div>
      </div>
      <div class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
        <div class="text-emerald-500 dark:text-emerald-400 text-xs font-semibold uppercase tracking-wider mb-1">Đã hoàn thành</div>
        <div class="text-2xl font-bold">4</div>
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
          <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors">
            <td class="px-6 py-2.5 text-xs text-slate-500">1</td>
            <td class="px-6 py-2.5">
              <div class="flex flex-col">
                <span class="font-semibold text-slate-900 dark:text-white text-sm">Xây dựng CRM Intern</span>
                <span class="text-[10px] text-slate-400 uppercase tracking-tighter">CRM-01</span>
              </div>
            </td>
            <td class="px-6 py-2.5 text-xs">admin</td>
            <td class="px-6 py-2.5">
              <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
              Đang triển khai
              </span>
            </td>
            <td class="px-6 py-2.5 text-xs text-slate-600 dark:text-slate-400">2024-02-03</td>
            <td class="px-6 py-2.5 text-xs text-slate-600 dark:text-slate-400">2024-02-17</td>
            <td class="px-6 py-2.5 text-right">
              <div class="flex items-center justify-end gap-1">
                <button class="p-1.5 rounded hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-primary transition-all" title="Thành viên">
                  <span class="material-icons text-lg">group</span>
                </button>
                <button class="p-1.5 rounded hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-primary transition-all" title="Nhiệm vụ">
                  <span class="material-icons text-lg">assignment_turned_in</span>
                </button>
                <div class="w-px h-4 bg-slate-200 dark:bg-slate-700 mx-1"></div>
                <button class="p-1.5 rounded hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-amber-500 transition-all" title="Sửa">
                  <span class="material-icons text-lg">edit</span>
                </button>
                <button class="p-1.5 rounded hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-red-500 transition-all" title="Xóa">
                  <span class="material-icons text-lg">delete</span>
                </button>
              </div>
            </td>
          </tr>
          <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors">
            <td class="px-6 py-2.5 text-xs text-slate-500">2</td>
            <td class="px-6 py-2.5">
              <div class="flex flex-col">
                <span class="font-semibold text-slate-900 dark:text-white text-sm">Website Tuyển dụng 2024</span>
                <span class="text-[10px] text-slate-400 uppercase tracking-tighter">WEB-HR</span>
              </div>
            </td>
            <td class="px-6 py-2.5 text-xs">admin</td>
            <td class="px-6 py-2.5">
              <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300">
              Chờ xử lý
              </span>
            </td>
            <td class="px-6 py-2.5 text-xs text-slate-600 dark:text-slate-400">2024-02-09</td>
            <td class="px-6 py-2.5 text-xs text-slate-600 dark:text-slate-400">2024-02-25</td>
            <td class="px-6 py-2.5 text-right">
              <div class="flex items-center justify-end gap-1">
                <button class="p-1.5 rounded hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-primary transition-all" title="Thành viên">
                  <span class="material-icons text-lg">group</span>
                </button>
                <button class="p-1.5 rounded hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-primary transition-all" title="Nhiệm vụ">
                  <span class="material-icons text-lg">assignment_turned_in</span>
                </button>
                <div class="w-px h-4 bg-slate-200 dark:bg-slate-700 mx-1"></div>
                <button class="p-1.5 rounded hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-amber-500 transition-all" title="Sửa">
                  <span class="material-icons text-lg">edit</span>
                </button>
                <button class="p-1.5 rounded hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-red-500 transition-all" title="Xóa">
                  <span class="material-icons text-lg">delete</span>
                </button>
              </div>
            </td>
          </tr>
          <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors">
            <td class="px-6 py-2.5 text-xs text-slate-500">3</td>
            <td class="px-6 py-2.5">
              <div class="flex flex-col">
                <span class="font-semibold text-slate-900 dark:text-white text-sm">Mobile App Intern Life</span>
                <span class="text-[10px] text-slate-400 uppercase tracking-tighter">APP-09</span>
              </div>
            </td>
            <td class="px-6 py-2.5 text-xs">mentor_john</td>
            <td class="px-6 py-2.5">
              <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300">
              Hoàn thành
              </span>
            </td>
            <td class="px-6 py-2.5 text-xs text-slate-600 dark:text-slate-400">2024-01-15</td>
            <td class="px-6 py-2.5 text-xs text-slate-600 dark:text-slate-400">2024-02-01</td>
            <td class="px-6 py-2.5 text-right">
              <div class="flex items-center justify-end gap-1">
                <button class="p-1.5 rounded hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-primary transition-all" title="Thành viên">
                  <span class="material-icons text-lg">group</span>
                </button>
                <button class="p-1.5 rounded hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-primary transition-all" title="Nhiệm vụ">
                  <span class="material-icons text-lg">assignment_turned_in</span>
                </button>
                <div class="w-px h-4 bg-slate-200 dark:bg-slate-700 mx-1"></div>
                <button class="p-1.5 rounded hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-amber-500 transition-all" title="Sửa">
                  <span class="material-icons text-lg">edit</span>
                </button>
                <button class="p-1.5 rounded hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-red-500 transition-all" title="Xóa">
                  <span class="material-icons text-lg">delete</span>
                </button>
              </div>
            </td>
          </tr>
          </tbody>
        </table>
      </div>
      <div class="px-6 py-3 bg-slate-50 dark:bg-slate-800/50 border-t border-slate-200 dark:border-slate-800 flex items-center justify-between">
        <span class="text-xs text-slate-500 dark:text-slate-400">Hiển thị 1-3 trong số 12 dự án</span>
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
