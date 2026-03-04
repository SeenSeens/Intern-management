<script setup>

</script>

<template>
  <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
    <div>
      <nav aria-label="Breadcrumb" class="flex text-sm text-slate-500 mb-2">
        <ol class="flex items-center space-x-2">
          <li><a class="hover:text-primary" href="#">Trang chủ</a></li>
          <li class="flex items-center space-x-2">
            <span class="material-icons text-base">chevron_right</span>
            <span class="font-medium text-slate-900 dark:text-slate-200">Quản lý nhiệm vụ</span>
          </li>
        </ol>
      </nav>
      <h2 class="text-2xl font-bold tracking-tight">Task Tracking and Assignment List</h2>
    </div>
    <button class="bg-primary hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg flex items-center gap-2 shadow-sm transition-all active:scale-95">
      <span class="material-icons text-lg">add</span>
      <span class="font-medium">Thêm task mới</span>
    </button>
  </div>
  <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-200 dark:border-slate-800 flex items-center gap-4">
      <div class="w-12 h-12 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-primary">
        <span class="material-icons">list_alt</span>
      </div>
      <div>
        <p class="text-slate-500 dark:text-slate-400 text-sm">Tổng nhiệm vụ</p>
        <p class="text-2xl font-bold">128</p>
      </div>
    </div>
    <div class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-200 dark:border-slate-800 flex items-center gap-4">
      <div class="w-12 h-12 rounded-lg bg-yellow-100 dark:bg-yellow-900/30 flex items-center justify-center text-yellow-600">
        <span class="material-icons">pending_actions</span>
      </div>
      <div>
        <p class="text-slate-500 dark:text-slate-400 text-sm">Đang thực hiện</p>
        <p class="text-2xl font-bold">42</p>
      </div>
    </div>
    <div class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-200 dark:border-slate-800 flex items-center gap-4">
      <div class="w-12 h-12 rounded-lg bg-green-100 dark:bg-green-900/30 flex items-center justify-center text-green-600">
        <span class="material-icons">check_circle</span>
      </div>
      <div>
        <p class="text-slate-500 dark:text-slate-400 text-sm">Đã hoàn thành</p>
        <p class="text-2xl font-bold">82%</p>
      </div>
    </div>
    <div class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-200 dark:border-slate-800 flex items-center gap-4">
      <div class="w-12 h-12 rounded-lg bg-red-100 dark:bg-red-900/30 flex items-center justify-center text-red-600">
        <span class="material-icons">schedule</span>
      </div>
      <div>
        <p class="text-slate-500 dark:text-slate-400 text-sm">Quá hạn</p>
        <p class="text-2xl font-bold">4</p>
      </div>
    </div>
  </div>
  <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
        <tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800">
          <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 w-16">No.</th>
          <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Task Name</th>
          <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Date of creation</th>
          <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">End date</th>
          <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Project Name</th>
          <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 text-right">Actions</th>
        </tr>
        </thead>
        <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors group">
          <td class="px-6 py-4 text-sm text-slate-500 dark:text-slate-400">1</td>
          <td class="px-6 py-4">
            <div class="flex items-center gap-3">
              <span class="material-icons text-primary text-xl">task</span>
              <span class="font-medium">Thiết kế Mockup UI</span>
            </div>
          </td>
          <td class="px-6 py-4 text-sm font-medium">2026-02-09</td>
          <td class="px-6 py-4 text-sm font-medium text-red-500">2026-02-25</td>
          <td class="px-6 py-4">
            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400">Web Dashboard v2</span>
          </td>
          <td class="px-6 py-4 text-right">
            <a class="text-primary hover:text-blue-700 font-semibold text-sm inline-flex items-center gap-1" href="#">
              Assign work <span class="material-icons text-sm">arrow_forward</span>
            </a>
          </td>
        </tr>
        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors group">
          <td class="px-6 py-4 text-sm text-slate-500 dark:text-slate-400">2</td>
          <td class="px-6 py-4">
            <div class="flex items-center gap-3">
              <span class="material-icons text-primary text-xl">code</span>
              <span class="font-medium">Phát triển API Login</span>
            </div>
          </td>
          <td class="px-6 py-4 text-sm font-medium">2026-02-09</td>
          <td class="px-6 py-4 text-sm font-medium">2026-02-25</td>
          <td class="px-6 py-4">
            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-50 dark:bg-slate-800 text-slate-600 dark:text-slate-400">Backend Core</span>
          </td>
          <td class="px-6 py-4 text-right">
            <a class="text-primary hover:text-blue-700 font-semibold text-sm inline-flex items-center gap-1" href="#">
              Assign work <span class="material-icons text-sm">arrow_forward</span>
            </a>
          </td>
        </tr>
        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors group">
          <td class="px-6 py-4 text-sm text-slate-500 dark:text-slate-400">3</td>
          <td class="px-6 py-4">
            <div class="flex items-center gap-3">
              <span class="material-icons text-primary text-xl">description</span>
              <span class="font-medium">Viết tài liệu Hướng dẫn</span>
            </div>
          </td>
          <td class="px-6 py-4 text-sm font-medium">2026-02-03</td>
          <td class="px-6 py-4 text-sm font-medium">2026-02-17</td>
          <td class="px-6 py-4">
            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400">Internal Wiki</span>
          </td>
          <td class="px-6 py-4 text-right">
            <a class="text-primary hover:text-blue-700 font-semibold text-sm inline-flex items-center gap-1" href="#">
              Assign work <span class="material-icons text-sm">arrow_forward</span>
            </a>
          </td>
        </tr>
        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors group">
          <td class="px-6 py-4 text-sm text-slate-500 dark:text-slate-400">4</td>
          <td class="px-6 py-4">
            <div class="flex items-center gap-3">
              <span class="material-icons text-primary text-xl">bug_report</span>
              <span class="font-medium">Fix bug giao diện Mobile</span>
            </div>
          </td>
          <td class="px-6 py-4 text-sm font-medium">2026-02-03</td>
          <td class="px-6 py-4 text-sm font-medium text-red-500">2026-02-17</td>
          <td class="px-6 py-4">
            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400">App Mobile</span>
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
    <div class="px-6 py-4 bg-slate-50 dark:bg-slate-800/50 border-t border-slate-200 dark:border-slate-800 flex items-center justify-between">
      <p class="text-sm text-slate-500 dark:text-slate-400">
        Hiển thị <span class="font-medium text-slate-900 dark:text-slate-200">1</span> đến <span class="font-medium text-slate-900 dark:text-slate-200">4</span> trong <span class="font-medium text-slate-900 dark:text-slate-200">24</span> kết quả
      </p>
      <div class="flex items-center gap-2">
        <button class="px-3 py-1 border border-slate-200 dark:border-slate-700 rounded-md text-sm hover:bg-white dark:hover:bg-slate-700 transition-colors">Trước</button>
        <button class="px-3 py-1 bg-primary text-white rounded-md text-sm">1</button>
        <button class="px-3 py-1 border border-slate-200 dark:border-slate-700 rounded-md text-sm hover:bg-white dark:hover:bg-slate-700 transition-colors">2</button>
        <button class="px-3 py-1 border border-slate-200 dark:border-slate-700 rounded-md text-sm hover:bg-white dark:hover:bg-slate-700 transition-colors">3</button>
        <button class="px-3 py-1 border border-slate-200 dark:border-slate-700 rounded-md text-sm hover:bg-white dark:hover:bg-slate-700 transition-colors">Sau</button>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>
