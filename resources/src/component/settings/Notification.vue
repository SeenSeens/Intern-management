<script setup>

</script>

<template>
  <div class="flex-1 flex flex-col gap-6 pb-12">
    <!-- Notification Grid -->
    <div class="bg-white rounded-lg border border-slate-200 shadow-sm overflow-hidden">
      <!-- Table Header (Architectural Style) -->
      <div class="grid grid-cols-12 gap-4 px-6 py-4 bg-surface-container-low border-b border-slate-200">
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
      <div class="grid grid-cols-12 gap-4 px-6 py-6 items-center border-b border-slate-200 hover:bg-slate-50/50 transition-colors">
        <div class="col-span-6 flex items-start gap-4">
          <div class="w-10 h-10 rounded-lg bg-primary-container flex items-center justify-center shrink-0">
            <span class="material-symbols-outlined text-primary" data-icon="assignment">assignment</span>
          </div>
          <div>
            <h3 class="text-sm font-semibold text-on-surface">Giao task mới</h3>
            <p class="text-xs text-on-surface-variant mt-0.5">When a new task is assigned to you or your team.</p>
          </div>
        </div>
        <!-- Email -->
        <div class="col-span-2 flex justify-center">
          <label class="flex items-center cursor-pointer">
            <div class="relative">
              <input checked="" class="sr-only toggle-checkbox" type="checkbox"/>
              <div class="toggle-label w-10 h-5 bg-slate-300 rounded-full shadow-inner transition-colors"></div>
              <div class="toggle-dot absolute left-0.5 top-0.5 bg-white w-4 h-4 rounded-full shadow transition-transform"></div>
            </div>
          </label>
        </div>
        <!-- Push -->
        <div class="col-span-2 flex justify-center">
          <label class="flex items-center cursor-pointer">
            <div class="relative">
              <input checked="" class="sr-only toggle-checkbox" type="checkbox"/>
              <div class="toggle-label w-10 h-5 bg-slate-300 rounded-full shadow-inner transition-colors"></div>
              <div class="toggle-dot absolute left-0.5 top-0.5 bg-white w-4 h-4 rounded-full shadow transition-transform"></div>
            </div>
          </label>
        </div>
        <!-- In-App -->
        <div class="col-span-2 flex justify-center">
          <label class="flex items-center cursor-pointer">
            <div class="relative">
              <input checked="" class="sr-only toggle-checkbox" type="checkbox"/>
              <div class="toggle-label w-10 h-5 bg-slate-300 rounded-full shadow-inner transition-colors"></div>
              <div class="toggle-dot absolute left-0.5 top-0.5 bg-white w-4 h-4 rounded-full shadow transition-transform"></div>
            </div>
          </label>
        </div>
      </div>
      <!-- Row 2: Project Updates -->
      <div class="grid grid-cols-12 gap-4 px-6 py-6 items-center border-b border-slate-200 hover:bg-slate-50/50 transition-colors">
        <div class="col-span-6 flex items-start gap-4">
          <div class="w-10 h-10 rounded-lg bg-primary-container flex items-center justify-center shrink-0">
            <span class="material-symbols-outlined text-primary" data-icon="sync_alt">sync_alt</span>
          </div>
          <div>
            <h3 class="text-sm font-semibold text-on-surface">Cập nhật dự án</h3>
            <p class="text-xs text-on-surface-variant mt-0.5">Changes in project status, timeline, or scope.</p>
          </div>
        </div>
        <!-- Email -->
        <div class="col-span-2 flex justify-center">
          <label class="flex items-center cursor-pointer">
            <div class="relative">
              <input class="sr-only toggle-checkbox" type="checkbox"/>
              <div class="toggle-label w-10 h-5 bg-slate-300 rounded-full shadow-inner transition-colors"></div>
              <div class="toggle-dot absolute left-0.5 top-0.5 bg-white w-4 h-4 rounded-full shadow transition-transform"></div>
            </div>
          </label>
        </div>
        <!-- Push -->
        <div class="col-span-2 flex justify-center">
          <label class="flex items-center cursor-pointer">
            <div class="relative">
              <input checked="" class="sr-only toggle-checkbox" type="checkbox"/>
              <div class="toggle-label w-10 h-5 bg-slate-300 rounded-full shadow-inner transition-colors"></div>
              <div class="toggle-dot absolute left-0.5 top-0.5 bg-white w-4 h-4 rounded-full shadow transition-transform"></div>
            </div>
          </label>
        </div>
        <!-- In-App -->
        <div class="col-span-2 flex justify-center">
          <label class="flex items-center cursor-pointer">
            <div class="relative">
              <input checked="" class="sr-only toggle-checkbox" type="checkbox"/>
              <div class="toggle-label w-10 h-5 bg-slate-300 rounded-full shadow-inner transition-colors"></div>
              <div class="toggle-dot absolute left-0.5 top-0.5 bg-white w-4 h-4 rounded-full shadow transition-transform"></div>
            </div>
          </label>
        </div>
      </div>
      <!-- Row 3: New Messages -->
      <div class="grid grid-cols-12 gap-4 px-6 py-6 items-center hover:bg-slate-50/50 transition-colors">
        <div class="col-span-6 flex items-start gap-4">
          <div class="w-10 h-10 rounded-lg bg-primary-container flex items-center justify-center shrink-0">
            <span class="material-symbols-outlined text-primary" data-icon="forum">forum</span>
          </div>
          <div>
            <h3 class="text-sm font-semibold text-on-surface">Tin nhắn mới</h3>
            <p class="text-xs text-on-surface-variant mt-0.5">Direct messages and mentions from colleagues.</p>
          </div>
        </div>
        <!-- Email -->
        <div class="col-span-2 flex justify-center">
          <label class="flex items-center cursor-pointer">
            <div class="relative">
              <input checked="" class="sr-only toggle-checkbox" type="checkbox"/>
              <div class="toggle-label w-10 h-5 bg-slate-300 rounded-full shadow-inner transition-colors"></div>
              <div class="toggle-dot absolute left-0.5 top-0.5 bg-white w-4 h-4 rounded-full shadow transition-transform"></div>
            </div>
          </label>
        </div>
        <!-- Push -->
        <div class="col-span-2 flex justify-center">
          <label class="flex items-center cursor-pointer">
            <div class="relative">
              <input checked="" class="sr-only toggle-checkbox" type="checkbox"/>
              <div class="toggle-label w-10 h-5 bg-slate-300 rounded-full shadow-inner transition-colors"></div>
              <div class="toggle-dot absolute left-0.5 top-0.5 bg-white w-4 h-4 rounded-full shadow transition-transform"></div>
            </div>
          </label>
        </div>
        <!-- In-App -->
        <div class="col-span-2 flex justify-center">
          <label class="flex items-center cursor-pointer">
            <div class="relative">
              <input checked="" class="sr-only toggle-checkbox" type="checkbox"/>
              <div class="toggle-label w-10 h-5 bg-slate-300 rounded-full shadow-inner transition-colors"></div>
              <div class="toggle-dot absolute left-0.5 top-0.5 bg-white w-4 h-4 rounded-full shadow transition-transform"></div>
            </div>
          </label>
        </div>
      </div>
    </div>
    <!-- Additional Contextual Card: Quiet Hours -->
    <div class="bg-white rounded-lg border border-slate-200 shadow-sm p-6">
      <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-lg bg-surface-container flex items-center justify-center">
            <span class="material-symbols-outlined text-secondary" data-icon="bedtime">bedtime</span>
          </div>
          <div>
            <h3 class="text-sm font-semibold text-on-surface">Quiet Hours</h3>
            <p class="text-xs text-on-surface-variant">Pause all notifications during specific times.</p>
          </div>
        </div>
        <label class="flex items-center cursor-pointer">
          <div class="relative">
            <input class="sr-only toggle-checkbox" type="checkbox"/>
            <div class="toggle-label w-10 h-5 bg-slate-300 rounded-full shadow-inner transition-colors"></div>
            <div class="toggle-dot absolute left-0.5 top-0.5 bg-white w-4 h-4 rounded-full shadow transition-transform"></div>
          </div>
        </label>
      </div>
      <div class="grid grid-cols-2 gap-4 mt-6">
        <div class="space-y-1.5">
          <label class="text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Start Time</label>
          <div class="flex items-center bg-surface-container-low border border-slate-200 rounded px-3 py-2 opacity-50">
            <span class="text-sm text-secondary">22:00</span>
          </div>
        </div>
        <div class="space-y-1.5">
          <label class="text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">End Time</label>
          <div class="flex items-center bg-surface-container-low border border-slate-200 rounded px-3 py-2 opacity-50">
            <span class="text-sm text-secondary">07:00</span>
          </div>
        </div>
      </div>
    </div>
    <!-- Footer Actions -->
    <div class="flex items-center justify-end gap-3 py-4">
      <button class="px-5 py-2 text-sm font-semibold text-secondary hover:bg-slate-100 transition-colors rounded-lg">Reset to defaults</button>
      <button class="px-6 py-2 bg-primary text-white text-sm font-semibold rounded-lg shadow-md active:scale-95 transition-all">Save Changes</button>
    </div>
  </div>
</template>

<style scoped>

</style>
