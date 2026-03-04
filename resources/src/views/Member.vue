<script setup>

</script>

<template>
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
      <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Quản lý Thành viên</h1>
      <p class="text-slate-500 dark:text-slate-400 mt-1">Quản lý danh sách thực tập sinh, mentor và quản trị viên hệ thống.</p>
    </div>
    <div class="flex items-center gap-3">
      <button class="flex items-center gap-2 px-4 py-2 border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors text-sm font-medium">
        <span class="material-symbols-outlined text-lg">download</span>
        Xuất danh sách
      </button>
      <button class="flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-lg hover:bg-blue-600 transition-colors text-sm font-medium shadow-sm">
        <span class="material-symbols-outlined text-lg">add</span>
        Thêm thành viên
      </button>
    </div>
  </div>
  <div class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm mb-6">
    <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
      <div class="relative w-full md:w-96">
        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">search</span>
        <input class="w-full pl-10 pr-4 py-2 bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-lg text-sm focus:ring-primary focus:border-primary" placeholder="Tìm kiếm theo tên, email hoặc mã số..." type="text"/>
      </div>
      <div class="flex items-center gap-3 w-full md:w-auto">
        <div class="relative flex-1 md:flex-none">
          <select class="w-full pl-3 pr-8 py-2 bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-lg text-sm focus:ring-primary focus:border-primary appearance-none cursor-pointer">
            <option value="">Tất cả vai trò</option>
            <option value="intern">Intern</option>
            <option value="mentor">Mentor</option>
            <option value="admin">Admin</option>
          </select>
          <span class="material-symbols-outlined absolute right-2 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-lg">expand_more</span>
        </div>
        <div class="relative flex-1 md:flex-none">
          <select class="w-full pl-3 pr-8 py-2 bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-lg text-sm focus:ring-primary focus:border-primary appearance-none cursor-pointer">
            <option value="">Tất cả dự án</option>
            <option value="ui">Redesign Dashboard</option>
            <option value="api">Backend Services</option>
            <option value="sec">Security Audit</option>
          </select>
          <span class="material-symbols-outlined absolute right-2 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-lg">expand_more</span>
        </div>
        <button class="p-2 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900">
          <span class="material-symbols-outlined">filter_list</span>
        </button>
      </div>
    </div>
  </div>
  <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead class="bg-slate-50 dark:bg-slate-800/50">
        <tr>
          <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider w-12">
            <input class="rounded border-slate-300 text-primary focus:ring-primary" type="checkbox"/>
          </th>
          <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Họ và tên</th>
          <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Mã số</th>
          <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Vai trò</th>
          <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Email</th>
          <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Số điện thoại</th>
          <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Dự án đang tham gia</th>
          <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right">Thao tác</th>
        </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors group">
          <td class="px-6 py-4">
            <input class="rounded border-slate-300 text-primary focus:ring-primary" type="checkbox"/>
          </td>
          <td class="px-6 py-4">
            <div class="flex items-center gap-3">
              <img alt="User Avatar" class="w-10 h-10 rounded-full object-cover border border-slate-200 dark:border-slate-700" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBuLRoIYmP61pdkntn0XwGftJOapRZjR-7i9N0406nHYh51G3mVHOODa1E7MJ__hW01n1H2H0K5MvkpeTLlqBNq2Zb8OAUgatVyy5Pcjtkso8LR7kN-RdeAdC2Ow_d_MeK9mz6bjQOV5ROHwSLpHE1oucVNKAV0rwic_br7rY0_L4dgFhoy-mPZReUIeHewYZdyVs9geG95-SxnM8R3CrUlsvghylEDVdKUUtCbsQnHdCdEgqBHXQIillef8UKHvWWLfag0mVWKpdE"/>
              <div>
                <div class="font-medium text-slate-900 dark:text-white text-sm">Nguyễn Văn A</div>
                <div class="text-xs text-slate-500">Frontend Dev</div>
              </div>
            </div>
          </td>
          <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400 font-mono">INT-2023-001</td>
          <td class="px-6 py-4">
<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                        Intern
                                    </span>
          </td>
          <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">nguyenvana@example.com</td>
          <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">0901234567</td>
          <td class="px-6 py-4">
            <span class="text-sm text-slate-700 dark:text-slate-300">Redesign Dashboard</span>
          </td>
          <td class="px-6 py-4 text-right">
            <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
              <button class="p-1.5 text-slate-400 hover:text-primary hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-md transition-colors" title="Chỉnh sửa">
                <span class="material-symbols-outlined text-lg">edit</span>
              </button>
              <button class="p-1.5 text-slate-400 hover:text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-900/20 rounded-md transition-colors" title="Xóa">
                <span class="material-symbols-outlined text-lg">delete</span>
              </button>
            </div>
          </td>
        </tr>
        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors group">
          <td class="px-6 py-4">
            <input class="rounded border-slate-300 text-primary focus:ring-primary" type="checkbox"/>
          </td>
          <td class="px-6 py-4">
            <div class="flex items-center gap-3">
              <img alt="User Avatar" class="w-10 h-10 rounded-full object-cover border border-slate-200 dark:border-slate-700" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDosg9RlhzTwllBULA4ldOE2k0kwHchgkMwH1aIIm-qB1wyAhIszD7sex0u4y8B8c7iMUGM_-6x123Td5yfe4M_OdN1yhUz75mfokjK7PrIgsJ4Z4QT6QS_9hzS-NmJuFzg5u5oCcHhLWrGg9deM8hLzeT3hfuPzJXOwbMdq9QOS0dNaETKY9SB3I_GC3R71Y_KohjJ0ebqpEXfELgwPfXuVhkzo4v4yVlbHEEYOhF9--T8o_c261gUqN-OgbCrpX4iPs-fsO6_DB4"/>
              <div>
                <div class="font-medium text-slate-900 dark:text-white text-sm">Trần Thị B</div>
                <div class="text-xs text-slate-500">Backend Dev</div>
              </div>
            </div>
          </td>
          <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400 font-mono">INT-2023-002</td>
          <td class="px-6 py-4">
<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                        Intern
                                    </span>
          </td>
          <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">tranthib@example.com</td>
          <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">0909876543</td>
          <td class="px-6 py-4">
            <span class="text-sm text-slate-700 dark:text-slate-300">Backend Services</span>
          </td>
          <td class="px-6 py-4 text-right">
            <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
              <button class="p-1.5 text-slate-400 hover:text-primary hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-md transition-colors" title="Chỉnh sửa">
                <span class="material-symbols-outlined text-lg">edit</span>
              </button>
              <button class="p-1.5 text-slate-400 hover:text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-900/20 rounded-md transition-colors" title="Xóa">
                <span class="material-symbols-outlined text-lg">delete</span>
              </button>
            </div>
          </td>
        </tr>
        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors group">
          <td class="px-6 py-4">
            <input class="rounded border-slate-300 text-primary focus:ring-primary" type="checkbox"/>
          </td>
          <td class="px-6 py-4">
            <div class="flex items-center gap-3">
              <img alt="User Avatar" class="w-10 h-10 rounded-full object-cover border border-slate-200 dark:border-slate-700" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCStF-TP6XUvOG7s9GMEa-GkVGR0vnuXlGg4bS3_FiFp2PBoLdxsFmcqsr5BWjwKSonxEMKa55MQCfF0VlZAbzB1kuJNxj2Ao5NUOJrBgBRPpn0_0F7c9oDCYjXMIVZn6llX9bCo9z2xPSPelPq7xRQ8gQbqcIFBWCyHucREL-_s2uEva8-9rDcdor3C4jreEDjnxnBTQ9SuGKd4aSXIYIRmHGFxktaH5GXDCOM54v9_pea4V1S4rj1i05vnc0ZySqE3d_JMTz_NDE"/>
              <div>
                <div class="font-medium text-slate-900 dark:text-white text-sm">Lê Văn C</div>
                <div class="text-xs text-slate-500">Security Analyst</div>
              </div>
            </div>
          </td>
          <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400 font-mono">INT-2023-005</td>
          <td class="px-6 py-4">
<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                        Intern
                                    </span>
          </td>
          <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">levanc@example.com</td>
          <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">0912345678</td>
          <td class="px-6 py-4">
            <span class="text-sm text-slate-700 dark:text-slate-300">Security Audit</span>
          </td>
          <td class="px-6 py-4 text-right">
            <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
              <button class="p-1.5 text-slate-400 hover:text-primary hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-md transition-colors" title="Chỉnh sửa">
                <span class="material-symbols-outlined text-lg">edit</span>
              </button>
              <button class="p-1.5 text-slate-400 hover:text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-900/20 rounded-md transition-colors" title="Xóa">
                <span class="material-symbols-outlined text-lg">delete</span>
              </button>
            </div>
          </td>
        </tr>
        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors group">
          <td class="px-6 py-4">
            <input class="rounded border-slate-300 text-primary focus:ring-primary" type="checkbox"/>
          </td>
          <td class="px-6 py-4">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 dark:bg-indigo-900/30 dark:text-indigo-400 flex items-center justify-center font-bold text-sm">
                PM
              </div>
              <div>
                <div class="font-medium text-slate-900 dark:text-white text-sm">Phạm Minh D</div>
                <div class="text-xs text-slate-500">Project Manager</div>
              </div>
            </div>
          </td>
          <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400 font-mono">MTR-2023-012</td>
          <td class="px-6 py-4">
<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300">
                                        Mentor
                                    </span>
          </td>
          <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">phamminhd@example.com</td>
          <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">0933333333</td>
          <td class="px-6 py-4">
            <span class="text-sm text-slate-700 dark:text-slate-300">Quản lý chung</span>
          </td>
          <td class="px-6 py-4 text-right">
            <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
              <button class="p-1.5 text-slate-400 hover:text-primary hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-md transition-colors" title="Chỉnh sửa">
                <span class="material-symbols-outlined text-lg">edit</span>
              </button>
              <button class="p-1.5 text-slate-400 hover:text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-900/20 rounded-md transition-colors" title="Xóa">
                <span class="material-symbols-outlined text-lg">delete</span>
              </button>
            </div>
          </td>
        </tr>
        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors group">
          <td class="px-6 py-4">
            <input class="rounded border-slate-300 text-primary focus:ring-primary" type="checkbox"/>
          </td>
          <td class="px-6 py-4">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 rounded-full bg-slate-200 text-slate-600 dark:bg-slate-700 dark:text-slate-300 flex items-center justify-center">
                <span class="material-symbols-outlined text-xl">person</span>
              </div>
              <div>
                <div class="font-medium text-slate-900 dark:text-white text-sm">Hoàng Văn E</div>
                <div class="text-xs text-slate-500">System Admin</div>
              </div>
            </div>
          </td>
          <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400 font-mono">ADM-2023-001</td>
          <td class="px-6 py-4">
<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-rose-100 text-rose-800 dark:bg-rose-900/30 dark:text-rose-300">
                                        Admin
                                    </span>
          </td>
          <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">hoangvane@example.com</td>
          <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">0944444444</td>
          <td class="px-6 py-4">
            <span class="text-sm text-slate-400 dark:text-slate-500 italic">--</span>
          </td>
          <td class="px-6 py-4 text-right">
            <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
              <button class="p-1.5 text-slate-400 hover:text-primary hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-md transition-colors" title="Chỉnh sửa">
                <span class="material-symbols-outlined text-lg">edit</span>
              </button>
            </div>
          </td>
        </tr>
        </tbody>
      </table>
    </div>
    <div class="px-6 py-4 border-t border-slate-200 dark:border-slate-800 flex items-center justify-between">
      <div class="text-sm text-slate-500 dark:text-slate-400">
        Hiển thị <span class="font-medium text-slate-900 dark:text-white">1</span> đến <span class="font-medium text-slate-900 dark:text-white">5</span> trong số <span class="font-medium text-slate-900 dark:text-white">24</span> thành viên
      </div>
      <div class="flex items-center gap-2">
        <button class="p-2 border border-slate-200 dark:border-slate-700 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800 disabled:opacity-50 disabled:cursor-not-allowed text-slate-500" disabled="">
          <span class="material-symbols-outlined text-sm">chevron_left</span>
        </button>
        <button class="px-3 py-1 border border-primary bg-primary text-white rounded-lg text-sm font-medium">1</button>
        <button class="px-3 py-1 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-lg text-sm font-medium transition-colors">2</button>
        <button class="px-3 py-1 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-lg text-sm font-medium transition-colors">3</button>
        <span class="text-slate-400">...</span>
        <button class="p-2 border border-slate-200 dark:border-slate-700 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800 text-slate-500 transition-colors">
          <span class="material-symbols-outlined text-sm">chevron_right</span>
        </button>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>
