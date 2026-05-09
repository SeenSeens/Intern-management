<script setup>
import {onMounted} from "vue";
import {useSettingStore} from "@/stores/settingStore.js";
import { Label } from '@/components/ui/label'
import { Switch } from '@/components/ui/switch'

const settingStore = useSettingStore()

onMounted(() => {
  settingStore.loadNotifications()
})
</script>

<template>
  <div class="flex-1 flex flex-col gap-6 pb-12">
    <!-- Notification Grid -->
    <div class="bg-surface rounded-lg border border-outline shadow-sm overflow-hidden">
      <!-- Table Header (Architectural Style) -->
      <div class="grid grid-cols-12 gap-4 px-6 py-4 bg-surface-container-low border-b border-outline">
        <div class="col-span-6">
          <span class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Notification Type</span>
        </div>
        <div class="col-span-2 text-center">
          <span class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Email</span>
        </div>
        <div class="col-span-2 text-center">
          <span class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Push</span>
        </div>
        <div class="col-span-2 text-center">
          <span class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">In-App</span>
        </div>
      </div>
      <!-- Row 1: New Tasks -->
      <div class="grid grid-cols-12 gap-4 px-6 py-6 items-center border-b border-outline hover:bg-slate-800/50 transition-colors">
        <div class="col-span-6 flex items-start gap-4">
          <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center shrink-0">
            <span class="material-symbols-outlined text-primary" data-icon="assignment">assignment</span>
          </div>
          <div>
            <h3 class="text-sm font-semibold text-on-surface">Giao task mới</h3>
            <p class="text-xs text-on-surface-variant mt-0.5">Khi một nhiệm vụ mới được giao cho bạn hoặc nhóm của bạn.</p>
          </div>
        </div>
        <!-- Email -->
        <div class="col-span-2 flex justify-center">
          <label class="flex items-center cursor-pointer">
            <div class="relative">
              <Switch />
            </div>
          </label>
        </div>
        <!-- Push -->
        <div class="col-span-2 flex justify-center">
          <label class="flex items-center cursor-pointer">
            <div class="relative">
              <Switch />
            </div>
          </label>
        </div>
        <!-- In-App -->
        <div class="col-span-2 flex justify-center">
          <label class="flex items-center cursor-pointer">
            <div class="relative">
              <Switch />
            </div>
          </label>
        </div>
      </div>
      <!-- Row 2: Project Updates -->
      <div class="grid grid-cols-12 gap-4 px-6 py-6 items-center border-b border-outline hover:bg-slate-800/50 transition-colors">
        <div class="col-span-6 flex items-start gap-4">
          <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center shrink-0">
            <span class="material-symbols-outlined text-primary" data-icon="sync_alt">sync_alt</span>
          </div>
          <div>
            <h3 class="text-sm font-semibold text-on-surface">Cập nhật dự án</h3>
            <p class="text-xs text-on-surface-variant mt-0.5">Những thay đổi về trạng thái, tiến độ hoặc phạm vi dự án.</p>
          </div>
        </div>
        <!-- Email -->
        <div class="col-span-2 flex justify-center">
          <label class="flex items-center cursor-pointer">
            <div class="relative">
              <Switch />
            </div>
          </label>
        </div>
        <!-- Push -->
        <div class="col-span-2 flex justify-center">
          <label class="flex items-center cursor-pointer">
            <div class="relative">
              <Switch />
            </div>
          </label>
        </div>
        <!-- In-App -->
        <div class="col-span-2 flex justify-center">
          <label class="flex items-center cursor-pointer">
            <div class="relative">
              <Switch />
            </div>
          </label>
        </div>
      </div>
      <!-- Row 3: New Messages -->
      <div class="grid grid-cols-12 gap-4 px-6 py-6 items-center hover:bg-slate-800/50 transition-colors">
        <div class="col-span-6 flex items-start gap-4">
          <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center shrink-0">
            <span class="material-symbols-outlined text-primary" data-icon="forum">forum</span>
          </div>
          <div>
            <h3 class="text-sm font-semibold text-on-surface">Tin nhắn mới</h3>
            <p class="text-xs text-on-surface-variant mt-0.5">Tin nhắn trực tiếp và lời nhắc từ đồng nghiệp.</p>
          </div>
        </div>
        <!-- Email -->
        <div class="col-span-2 flex justify-center">
          <label class="flex items-center cursor-pointer">
            <div class="relative">
              <Switch />
            </div>
          </label>
        </div>
        <!-- Push -->
        <div class="col-span-2 flex justify-center">
          <label class="flex items-center cursor-pointer">
            <div class="relative">
              <Switch />
            </div>
          </label>
        </div>
        <!-- In-App -->
        <div class="col-span-2 flex justify-center">
          <label class="flex items-center cursor-pointer">
            <div class="relative">
              <Switch />
            </div>
          </label>
        </div>
      </div>
    </div>
    <!-- Additional Contextual Card: Quiet Hours -->
    <div class="bg-surface rounded-lg border border-outline shadow-sm p-6">
      <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-lg bg-surface-container-hight flex items-center justify-center">
            <span class="material-symbols-outlined text-secondary" data-icon="bedtime">bedtime</span>
          </div>
          <div>
            <h3 class="text-sm font-semibold text-on-surface">Giờ yên tĩnh</h3>
            <p class="text-xs text-on-surface-variant">Tạm dừng tất cả thông báo trong những khoảng thời gian cụ thể.</p>
          </div>
        </div>
        <label class="flex items-center cursor-pointer">
          <div class="relative">
            <Switch />
          </div>
        </label>
      </div>
      <div class="grid grid-cols-2 gap-4 mt-6">
        <div class="space-y-1.5">
          <label class="text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Thời gian bắt đầu</label>
          <div class="flex items-center bg-surface-container-low border border-outline rounded px-3 py-2 opacity-50">
            <span class="text-sm text-secondary">22:00</span>
          </div>
        </div>
        <div class="space-y-1.5">
          <label class="text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Thời gian kết thúc</label>
          <div class="flex items-center bg-surface-container-low border border-outline rounded px-3 py-2 opacity-50">
            <span class="text-sm text-secondary">07:00</span>
          </div>
        </div>
      </div>
    </div>
    <!-- Footer Actions -->
    <div class="flex items-center justify-end gap-3 py-4">
      <button class="px-5 py-2 text-sm font-semibold text-secondary hover:bg-slate-800 transition-colors rounded-lg">Khôi phục về cài đặt mặc định</button>
      <button class="px-6 py-2 bg-primary text-white text-sm font-semibold rounded-lg shadow-md active:scale-95 transition-all">Lưu thay đổi</button>
    </div>
  </div>
</template>

<style scoped>

</style>
