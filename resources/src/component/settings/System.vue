<script setup>

</script>

<template>
  <div class="flex-1 flex flex-col gap-6 pb-12">
    <!-- Bento Grid Layout for Sections -->
    <div class="grid grid-cols-12 gap-6">
      <!-- Section 1: Task Approval Workflow (The Lithic Card) -->
      <div class="col-span-12 lg:col-span-8 bg-surface rounded-xl shadow-sm border border-slate-200 p-6 flex flex-col">
        <div class="flex items-center justify-between mb-6">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center text-primary">
              <span class="material-symbols-outlined" data-icon="account_tree">account_tree</span>
            </div>
            <div>
              <h2 class="text-lg font-semibold text-on-surface">Quy trình duyệt task</h2>
              <p class="text-xs text-on-surface-variant">Configure how tasks move through completion cycles</p>
            </div>
          </div>
          <div class="flex items-center gap-2">
            <span class="px-2 py-1 bg-green-50 text-green-600 text-[10px] font-bold rounded uppercase">Active</span>
          </div>
        </div>
        <div class="space-y-6">
          <div class="flex items-start gap-4 p-4 rounded-lg bg-surface-container-low border border-slate-200-variant">
            <input checked="" class="mt-1 text-primary focus:ring-primary border-slate-200" id="linear" name="workflow" type="radio"/>
            <label class="cursor-pointer" for="linear">
              <span class="block text-sm font-semibold text-on-surface">Linear Approval (Standard)</span>
              <span class="block text-xs text-on-surface-variant mt-0.5">Task -&gt; Instructor Review -&gt; Admin Final Approval -&gt; Complete</span>
            </label>
          </div>
          <div class="flex items-start gap-4 p-4 rounded-lg border border-slate-200">
            <input class="mt-1 text-primary focus:ring-primary border-slate-200" id="peer" name="workflow" type="radio"/>
            <label class="cursor-pointer" for="peer">
              <span class="block text-sm font-semibold text-on-surface">Peer-to-Peer Validation</span>
              <span class="block text-xs text-on-surface-variant mt-0.5">Task -&gt; 3 Student Peer Reviews -&gt; Instructor Final Approval</span>
            </label>
          </div>
          <div class="flex items-center justify-between pt-4 border-t border-slate-200">
            <div class="flex items-center gap-2">
              <span class="material-symbols-outlined text-on-surface-variant text-sm" data-icon="info">info</span>
              <span class="text-xs text-on-surface-variant">Auto-archive tasks after 30 days of inactivity</span>
            </div>
            <label class="relative inline-flex items-center cursor-pointer">
              <input checked="" class="sr-only peer" type="checkbox"/>
              <div class="w-9 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary"></div>
            </label>
          </div>
        </div>
      </div>
      <!-- Section 2: Default Student Permissions (Sidebar Card) -->
      <div class="col-span-12 lg:col-span-4 space-y-6">
        <div class="bg-surface rounded-xl shadow-sm border border-slate-200 overflow-hidden">
          <div class="p-6">
            <div class="flex items-center gap-3 mb-4">
              <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center text-primary">
                <span class="material-symbols-outlined" data-icon="person_add">person_add</span>
              </div>
              <h3 class="text-sm font-bold text-on-surface">Phân quyền mặc định</h3>
            </div>
            <p class="text-xs text-on-surface-variant mb-6">Initial access levels for newly enrolled students.</p>
            <div class="space-y-4">
              <div class="flex items-center justify-between">
                <span class="text-sm font-medium">Create Public Tasks</span>
                <input class="rounded border-slate-200 text-primary focus:ring-primary" type="checkbox"/>
              </div>
              <div class="flex items-center justify-between">
                <span class="text-sm font-medium">Internal Messaging</span>
                <input checked="" class="rounded border-slate-200 text-primary focus:ring-primary" type="checkbox"/>
              </div>
              <div class="flex items-center justify-between">
                <span class="text-sm font-medium">Access Global Library</span>
                <input checked="" class="rounded border-slate-200 text-primary focus:ring-primary" type="checkbox"/>
              </div>
              <div class="flex items-center justify-between">
                <span class="text-sm font-medium">Export Personal Logs</span>
                <input class="rounded border-slate-200 text-primary focus:ring-primary" type="checkbox"/>
              </div>
            </div>
            <button class="w-full mt-6 py-2 border border-slate-200 text-on-surface text-sm font-semibold rounded-lg hover:bg-slate-50 transition-colors">
              Edit Permission Groups
            </button>
          </div>
        </div>
      </div>
      <!-- Section 3: Data Backup & Recovery (Wide Bottom Row) -->
      <div class="col-span-12 bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="flex flex-col md:flex-row">
          <div class="md:w-1/3 bg-surface-container-low p-8 border-r border-slate-200">
            <div class="w-12 h-12 rounded-xl bg-primary shadow-md flex items-center justify-center text-white mb-6">
              <span class="material-symbols-outlined text-2xl" data-icon="cloud_sync" data-weight="fill">cloud_sync</span>
            </div>
            <h2 class="text-xl font-bold text-on-surface mb-2">Sao lưu dữ liệu</h2>
            <p class="text-sm text-on-surface-variant mb-6 leading-relaxed">Ensure platform stability by scheduling regular snapshots and automated offsite backups.</p>
            <div class="flex items-center gap-2 text-xs text-on-surface font-semibold bg-white p-3 rounded-lg border border-slate-200">
              <span class="material-symbols-outlined text-primary text-sm" data-icon="history">history</span>
              Last backup: 2 hours ago
            </div>
          </div>
          <div class="md:w-2/3 p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
              <div>
                <label class="block text-[10px] font-bold uppercase tracking-widest text-on-surface-variant mb-2">Backup Frequency</label>
                <select class="w-full bg-surface-container-low border-slate-200 rounded-lg text-sm p-2.5 focus:ring-2 focus:ring-primary focus:border-transparent">
                  <option>Every 6 hours</option>
                  <option selected="">Daily at 02:00 AM</option>
                  <option>Weekly (Sunday)</option>
                  <option>Monthly</option>
                </select>
              </div>
              <div>
                <label class="block text-[10px] font-bold uppercase tracking-widest text-on-surface-variant mb-2">Retention Period</label>
                <select class="w-full bg-surface-container-low border-slate-200 rounded-lg text-sm p-2.5 focus:ring-2 focus:ring-primary focus:border-transparent">
                  <option>Last 7 snapshots</option>
                  <option selected="">Last 30 snapshots</option>
                  <option>Unlimited (Warning: High storage)</option>
                </select>
              </div>
              <div class="col-span-1 md:col-span-2">
                <div class="flex items-center justify-between p-4 bg-primary/5 rounded-lg border border-primary/20">
                  <div class="flex items-center gap-4">
                    <span class="material-symbols-outlined text-primary" data-icon="encrypted">encrypted</span>
                    <div>
                      <p class="text-sm font-semibold text-primary">Encryption is Enabled</p>
                      <p class="text-[10px] text-on-surface-variant">All backups are secured with AES-256 GCM encryption.</p>
                    </div>
                  </div>
                  <button class="text-xs font-bold text-primary hover:underline">Manage Keys</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Global Actions -->
    <div class="mt-8 flex items-center justify-end gap-3 pb-12">
      <button class="px-6 py-2.5 text-sm font-semibold text-on-surface bg-surface border border-slate-200 rounded-lg hover:bg-slate-50 transition-colors">
        Discard Changes
      </button>
      <button class="px-8 py-2.5 text-sm font-semibold text-white bg-primary rounded-lg shadow-md hover:opacity-90 transition-all active:scale-95">
        Save System Config
      </button>
    </div>
  </div>
</template>

<style scoped>

</style>
