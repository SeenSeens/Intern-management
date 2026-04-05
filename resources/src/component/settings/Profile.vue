<script setup>
import {onMounted} from "vue";
import {useProfileStore} from "@/stores/profileStore.js";

const profileStore = useProfileStore()

onMounted(() => {
  profileStore.loadProfile()
})
</script>

<template>
  <div class="flex-1 flex flex-col gap-6 pb-12">
    <!-- Profile Card -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
      <div class="p-6 border border-slate-200 flex items-center justify-between bg-white">
        <h3 class="text-lg font-semibold text-on-surface">Thông tin cá nhân</h3>
        <span class="px-3 py-1 bg-primary/10 text-primary text-xs font-bold uppercase rounded-full tracking-wider">Hồ sơ công khai</span>
      </div>
      <div class="p-8 space-y-10">
        <!-- Avatar Section -->
        <div class="flex flex-col md:flex-row md:items-center gap-8">
          <div class="relative group">
            <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-surface-container shadow-inner bg-slate-100">
              <img class="w-full h-full object-cover" data-alt="Large user profile avatar for settings" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDppOc0bR3nI_wILUyCOnL5lOan8_3rgTPpLQttSmSZ5xyNYsltvsITa0T-4eA5Uamd8rwXPkMKNSiVpn9VFwP32GtcQjvyRrcy7UHX2E4y7MAEjhBLGLK7B-gVarire6XJyJaIzPmg2rZ-EVxjPxvK0zk5XBB_SyJWJdxk_AAztdcvkQsowMR2J4LqmycKHsgLsRSEkArO2l9PxIs07R6M_WGMH27co6FugYZBkfERzSreKX6XZi8ZR56KDuDT11ZR9RdNjt9cd-Q"/>
            </div>
            <button class="absolute bottom-0 right-0 p-2 bg-primary text-white rounded-full shadow-md hover:bg-blue-700 transition-colors active:scale-90">
              <span class="material-symbols-outlined text-sm">photo_camera</span>
            </button>
          </div>
          <div class="space-y-1">
            <h4 class="text-base font-semibold text-on-surface">Ảnh đại diện</h4>
            <p class="text-sm text-on-surface-variant">Định dạng ảnh: JPG, GIF hoặc PNG. Kích thước tối đa: 2MB.</p>
            <div class="flex gap-3 mt-3">
              <button class="px-4 py-2 bg-white border border-slate-200 rounded-lg text-sm font-semibold text-on-surface hover:bg-slate-50 transition-colors">Thay đổi hình ảnh</button>
              <button class="px-4 py-2 text-sm font-semibold text-error hover:bg-error-container/50 rounded-lg transition-colors">Remove</button>
            </div>
          </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <!-- Name Input -->
          <div class="space-y-2">
            <label class="block text-sm font-semibold text-on-surface">Họ và tên</label>
            <div class="relative">
              <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-lg">person</span>
              <input v-model="profileStore.profile.name" class="w-full pl-10 pr-4 py-3 bg-surface-container-low border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all" type="text" value="Alex Mitchell"/>
            </div>
          </div>
          <!-- Email Input -->
          <div class="space-y-2">
            <label class="block text-sm font-semibold text-on-surface">Email cá nhân</label>
            <div class="relative">
              <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-lg">mail</span>
              <input class="w-full pl-10 pr-4 py-3 bg-surface-container-low border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all" type="email" value="alex.mitchell@azurehorizon.com"/>
            </div>
          </div>
          <!-- Phone Input -->
          <div class="space-y-2">
            <label class="block text-sm font-semibold text-on-surface">Số điện thoại</label>
            <div class="relative">
              <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-lg">call</span>
              <input class="w-full pl-10 pr-4 py-3 bg-surface-container-low border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all" type="tel" value="+1 (555) 000-1234"/>
            </div>
          </div>
          <!-- Job Title -->
          <div class="space-y-2">
            <label class="block text-sm font-semibold text-on-surface">Vai trò</label>
            <div class="relative">
              <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-lg">badge</span>
              <input class="w-full pl-10 pr-4 py-3 bg-surface-container-low border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all" type="text" value="Senior Product Designer"/>
            </div>
          </div>
          <!-- Bio Input -->
          <div class="md:col-span-2 space-y-2">
            <label class="block text-sm font-semibold text-on-surface">Tiểu sử ngắn</label>
            <textarea class="w-full px-4 py-3 bg-surface-container-low border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all resize-none" rows="4">Product Designer based in San Francisco. Passionate about building clean, scalable design systems and accessible user interfaces. Currently leading the Horizon UI kit development.</textarea>
            <p class="text-xs text-on-surface-variant italic">Mô tả ngắn gọn về hồ sơ của bạn. Có thể sử dụng URL.</p>
          </div>
        </div>
      </div>
      <!-- Card Footer Action -->
      <div class="p-6 bg-slate-50/50 border-t border-slate-200 flex justify-end gap-3">
        <button class="px-6 py-2.5 bg-white border border-slate-200 rounded-lg text-sm font-semibold text-on-surface hover:bg-slate-50 active:scale-95 transition-all">Hủy bỏ các thay đổi</button>
        <button class="px-6 py-2.5 bg-primary text-white rounded-lg text-sm font-semibold shadow-md shadow-primary/20 hover:bg-blue-700 active:scale-95 transition-all">Lưu thay đổi</button>
      </div>
    </div>
    <!-- Danger Zone Section -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
      <div class="p-6 border border-slate-200 bg-error-container/10">
        <h3 class="text-lg font-semibold text-error">Danger Zone</h3>
      </div>
      <div class="p-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
          <h4 class="text-sm font-bold text-on-surface">Xóa tài khoản</h4>
          <p class="text-sm text-on-surface-variant mt-1">Xóa vĩnh viễn tài khoản của bạn và tất cả dữ liệu liên quan.</p>
        </div>
        <button class="px-6 py-2.5 border border-slate-200 text-error rounded-lg text-sm font-semibold hover:bg-error hover:text-white transition-all">Vô hiệu hóa tài khoản</button>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>
