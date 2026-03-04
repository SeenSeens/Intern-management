<script setup>

</script>

<template>
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
      <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Dashboard Quản lý Thực tập sinh</h1>
      <p class="text-slate-500 dark:text-slate-400">Chào mừng trở lại! Dưới đây là tóm tắt tiến độ công việc hôm nay.</p>
    </div>
    <div class="flex items-center gap-3">
      <button class="flex items-center gap-2 px-4 py-2 border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors text-sm font-medium">
        <span class="material-symbols-outlined text-lg">download</span>
        Xuất báo cáo
      </button>
      <button class="flex items-center gap-2 px-4 py-2 bg-primary dark:text-white rounded-lg hover:bg-blue-600 transition-colors text-sm font-medium shadow-sm">
        <span class="material-symbols-outlined text-lg">add</span>
        Dự án mới
      </button>
    </div>
  </div>
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-blue-500 rounded-xl p-6 text-white shadow-lg shadow-blue-500/20 relative overflow-hidden group">
      <div class="relative z-10">
        <p class="text-blue-100 text-sm font-medium mb-1">Sinh viên</p>
        <h3 class="text-3xl font-bold">3</h3>
      </div>
      <span class="material-symbols-outlined absolute -right-4 -bottom-4 text-8xl text-white/10 group-hover:scale-110 transition-transform">groups</span>
    </div>
    <div class="bg-emerald-500 rounded-xl p-6 text-white shadow-lg shadow-emerald-500/20 relative overflow-hidden group">
      <div class="relative z-10">
        <p class="text-emerald-100 text-sm font-medium mb-1">Dự án</p>
        <h3 class="text-3xl font-bold">2</h3>
      </div>
      <span class="material-symbols-outlined absolute -right-4 -bottom-4 text-8xl text-white/10 group-hover:scale-110 transition-transform">folder_open</span>
    </div>
    <div class="bg-amber-500 rounded-xl p-6 text-white shadow-lg shadow-amber-500/20 relative overflow-hidden group">
      <div class="relative z-10">
        <p class="text-amber-100 text-sm font-medium mb-1">Nhiệm vụ</p>
        <h3 class="text-3xl font-bold">4</h3>
      </div>
      <span class="material-symbols-outlined absolute -right-4 -bottom-4 text-8xl text-white/10 group-hover:scale-110 transition-transform">task</span>
    </div>
    <div class="bg-rose-500 rounded-xl p-6 text-white shadow-lg shadow-rose-500/20 relative overflow-hidden group">
      <div class="relative z-10">
        <p class="text-rose-100 text-sm font-medium mb-1">Hoàn thành (%)</p>
        <h3 class="text-3xl font-bold">68%</h3>
      </div>
      <span class="material-symbols-outlined absolute -right-4 -bottom-4 text-8xl text-white/10 group-hover:scale-110 transition-transform">trending_up</span>
    </div>
  </div>
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2 bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 p-6 shadow-sm">
      <div class="flex items-center justify-between mb-8">
        <div class="flex items-center gap-2">
          <span class="material-symbols-outlined text-rose-500">bar_chart</span>
          <h2 class="text-lg font-semibold">Biểu đồ tiến độ nhiệm vụ</h2>
        </div>
        <select class="bg-slate-50 dark:bg-slate-800 border-none rounded-md text-xs py-1.5 pl-3 pr-8 focus:ring-0">
          <option>Tháng này</option>
          <option>Tháng trước</option>
        </select>
      </div>
      <div class="relative h-64 w-full">
        <div class="absolute inset-0 flex items-end justify-around px-4">
          <div class="w-full flex flex-col items-center group">
            <div class="bg-emerald-500 w-16 rounded-t-md transition-all duration-500 group-hover:brightness-110" style="height: 27%;"></div>
            <span class="text-xs text-slate-500 mt-4">Tuần 1</span>
          </div>
          <div class="w-full flex flex-col items-center group">
            <div class="bg-emerald-500 w-16 rounded-t-md transition-all duration-500 group-hover:brightness-110" style="height: 66%;"></div>
            <span class="text-xs text-slate-500 mt-4">Tuần 2</span>
          </div>
          <div class="w-full flex flex-col items-center group">
            <div class="bg-emerald-500 w-16 rounded-t-md transition-all duration-500 group-hover:brightness-110" style="height: 50%;"></div>
            <span class="text-xs text-slate-500 mt-4">Tuần 3</span>
          </div>
          <div class="w-full flex flex-col items-center group">
            <div class="bg-emerald-500 w-16 rounded-t-md transition-all duration-500 group-hover:brightness-110" style="height: 100%;"></div>
            <span class="text-xs text-slate-500 mt-4">Tuần 4</span>
          </div>
        </div>
        <div class="absolute inset-0 flex flex-col justify-between pointer-events-none opacity-10 dark:opacity-5">
          <div class="border-t border-slate-900 w-full flex items-center"><span class="text-[10px] -ml-6">18</span></div>
          <div class="border-t border-slate-900 w-full flex items-center"><span class="text-[10px] -ml-6">12</span></div>
          <div class="border-t border-slate-900 w-full flex items-center"><span class="text-[10px] -ml-6">6</span></div>
          <div class="border-t border-slate-900 w-full flex items-center"><span class="text-[10px] -ml-6">0</span></div>
        </div>
      </div>
      <p class="text-center text-xs font-medium text-slate-400 mt-8 italic">Tiến độ theo tuần</p>
    </div>
    <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 p-6 shadow-sm">
      <div class="flex items-center gap-2 mb-6">
        <span class="material-symbols-outlined text-orange-500">rocket_launch</span>
        <h2 class="text-lg font-semibold">Bắt đầu nhanh</h2>
      </div>
      <ul class="space-y-4">
        <li class="flex gap-4">
          <span class="flex-shrink-0 w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 flex items-center justify-center font-bold text-sm">1</span>
          <div>
            <p class="text-sm font-medium">Truy cập menu Intern Management</p>
            <p class="text-xs text-slate-500">Để tạo dự án mới cho nhóm thực tập.</p>
          </div>
        </li>
        <li class="flex gap-4">
          <span class="flex-shrink-0 w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 flex items-center justify-center font-bold text-sm">2</span>
          <div>
            <p class="text-sm font-medium">Thêm Mentor và Thực tập sinh</p>
            <p class="text-xs text-slate-500">Gán quyền quản lý và người tham gia.</p>
          </div>
        </li>
        <li class="flex gap-4">
          <span class="flex-shrink-0 w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 flex items-center justify-center font-bold text-sm">3</span>
          <div>
            <p class="text-sm font-medium">Phân chia công việc</p>
            <p class="text-xs text-slate-500">Tạo task và theo dõi tiến độ chi tiết.</p>
          </div>
        </li>
      </ul>
      <div class="mt-8 pt-6 border-t border-slate-100 dark:border-slate-800">
        <button class="w-full py-2 px-4 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-lg hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors text-sm font-medium flex items-center justify-center gap-2">
          <span class="material-symbols-outlined text-lg">description</span>
          Tài liệu hướng dẫn
        </button>
      </div>
    </div>
  </div>
  <div class="mt-8 bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between">
      <div class="flex items-center gap-2">
        <span class="material-symbols-outlined text-primary">schedule</span>
        <h2 class="text-lg font-semibold">Nhiệm vụ sắp đến hạn</h2>
      </div>
      <a class="text-primary hover:underline text-sm font-medium" href="#">Xem tất cả</a>
    </div>
    <div class="overflow-x-auto">
      <table class="w-full text-left">
        <thead class="bg-slate-50 dark:bg-slate-800/50">
        <tr>
          <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase">Tên nhiệm vụ</th>
          <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase">Dự án</th>
          <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase">Sinh viên</th>
          <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase">Hạn chót</th>
          <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase">Trạng thái</th>
        </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors">
          <td class="px-6 py-4">
            <div class="font-medium text-slate-900 dark:text-white text-sm">Thiết kế Mockup UI</div>
          </td>
          <td class="px-6 py-4 text-slate-600 dark:text-slate-400 text-sm">Redesign Dashboard</td>
          <td class="px-6 py-4">
            <div class="flex items-center gap-2">
              <img alt="Student" class="w-6 h-6 rounded-full" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBuLRoIYmP61pdkntn0XwGftJOapRZjR-7i9N0406nHYh51G3mVHOODa1E7MJ__hW01n1H2H0K5MvkpeTLlqBNq2Zb8OAUgatVyy5Pcjtkso8LR7kN-RdeAdC2Ow_d_MeK9mz6bjQOV5ROHwSLpHE1oucVNKAV0rwic_br7rY0_L4dgFhoy-mPZReUIeHewYZdyVs9geG95-SxnM8R3CrUlsvghylEDVdKUUtCbsQnHdCdEgqBHXQIillef8UKHvWWLfag0mVWKpdE"/>
              <span class="text-sm">Nguyễn Văn A</span>
            </div>
          </td>
          <td class="px-6 py-4 text-sm font-medium text-rose-600 dark:text-rose-400">20/10/2023</td>
          <td class="px-6 py-4">
            <span class="px-2 py-1 text-[10px] font-bold uppercase rounded-full bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400">Đang thực hiện</span>
          </td>
        </tr>
        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors">
          <td class="px-6 py-4">
            <div class="font-medium text-slate-900 dark:text-white text-sm">Viết API Authentication</div>
          </td>
          <td class="px-6 py-4 text-slate-600 dark:text-slate-400 text-sm">Backend Services</td>
          <td class="px-6 py-4">
            <div class="flex items-center gap-2">
              <img alt="Student" class="w-6 h-6 rounded-full" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDosg9RlhzTwllBULA4ldOE2k0kwHchgkMwH1aIIm-qB1wyAhIszD7sex0u4y8B8c7iMUGM_-6x123Td5yfe4M_OdN1yhUz75mfokjK7PrIgsJ4Z4QT6QS_9hzS-NmJuFzg5u5oCcHhLWrGg9deM8hLzeT3hfuPzJXOwbMdq9QOS0dNaETKY9SB3I_GC3R71Y_KohjJ0ebqpEXfELgwPfXuVhkzo4v4yVlbHEEYOhF9--T8o_c261gUqN-OgbCrpX4iPs-fsO6_DB4"/>
              <span class="text-sm">Trần Thị B</span>
            </div>
          </td>
          <td class="px-6 py-4 text-sm font-medium text-rose-600 dark:text-rose-400">22/10/2023</td>
          <td class="px-6 py-4">
            <span class="px-2 py-1 text-[10px] font-bold uppercase rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400">Mới</span>
          </td>
        </tr>
        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors">
          <td class="px-6 py-4">
            <div class="font-medium text-slate-900 dark:text-white text-sm">Kiểm thử bảo mật</div>
          </td>
          <td class="px-6 py-4 text-slate-600 dark:text-slate-400 text-sm">Security Audit</td>
          <td class="px-6 py-4">
            <div class="flex items-center gap-2">
              <img alt="Student" class="w-6 h-6 rounded-full" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCStF-TP6XUvOG7s9GMEa-GkVGR0vnuXlGg4bS3_FiFp2PBoLdxsFmcqsr5BWjwKSonxEMKa55MQCfF0VlZAbzB1kuJNxj2Ao5NUOJrBgBRPpn0_0F7c9oDCYjXMIVZn6llX9bCo9z2xPSPelPq7xRQ8gQbqcIFBWCyHucREL-_s2uEva8-9rDcdor3C4jreEDjnxnBTQ9SuGKd4aSXIYIRmHGFxktaH5GXDCOM54v9_pea4V1S4rj1i05vnc0ZySqE3d_JMTz_NDE"/>
              <span class="text-sm">Lê Văn C</span>
            </div>
          </td>
          <td class="px-6 py-4 text-sm font-medium text-slate-600 dark:text-slate-400">25/10/2023</td>
          <td class="px-6 py-4">
            <span class="px-2 py-1 text-[10px] font-bold uppercase rounded-full bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-400">Chờ duyệt</span>
          </td>
        </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<style scoped>

</style>
