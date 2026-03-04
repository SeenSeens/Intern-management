<script setup>

</script>

<template>
  <aside class="sidebar-expanded bg-white dark:bg-slate-900 border-r border-slate-200 dark:border-slate-800 flex-shrink-0 hidden md:flex flex-col relative" id="sidebar">
    <div class="p-6 logo-container flex items-center gap-3 text-primary font-bold text-xl overflow-hidden">
      <span class="material-symbols-outlined text-3xl flex-shrink-0">school</span>
      <span class="logo-text whitespace-nowrap">InternHub</span>
    </div>
    <nav class="flex-1 px-4 space-y-1 mt-4 overflow-x-hidden">
      <RouterLink to="/" class="nav-item flex items-center gap-3 px-4 py-3 active-nav rounded-md transition-all">
        <span class="material-symbols-outlined flex-shrink-0">dashboard</span>
        <span class="nav-label font-medium whitespace-nowrap">Bảng tin</span>
      </RouterLink>
      <RouterLink to="/member" class="nav-item flex items-center gap-3 px-4 py-3 text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-md transition-all" >
        <span class="material-symbols-outlined flex-shrink-0">group</span>
        <span class="nav-label font-medium whitespace-nowrap">Thành viên</span>
      </RouterLink>
      <RouterLink to="/project" class="nav-item flex items-center gap-3 px-4 py-3 text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-md transition-all">
        <span class="material-symbols-outlined flex-shrink-0">assignment</span>
        <span class="nav-label font-medium whitespace-nowrap">Dự án</span>
      </RouterLink>
      <RouterLink to="/task" class="nav-item flex items-center gap-3 px-4 py-3 text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-md transition-all">
        <span class="material-symbols-outlined flex-shrink-0">checklist</span>
        <span class="nav-label font-medium whitespace-nowrap">Nhiệm vụ</span>
      </RouterLink>
      <div class="section-header pt-4 pb-2 px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider">Account</div>
      <RouterLink to="/setting" class="nav-item flex items-center gap-3 px-4 py-3 text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-md transition-all">
        <span class="material-symbols-outlined flex-shrink-0">settings</span>
        <span class="nav-label font-medium whitespace-nowrap">Cài đặt</span>
      </RouterLink>
    </nav>
    <div class="p-4 border-t border-slate-200 dark:border-slate-800">
      <div class="flex items-center gap-3 px-2">
        <img alt="Admin avatar" class="w-10 h-10 rounded-full border border-slate-200 dark:border-slate-700 flex-shrink-0" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCpg9vPRbqN4F5TYYI2f6oY1zta3swAOayP2wvSuL8oYBIuDBildfJXyVQtEVMR1VA8LEyRxVyq5Rr_ehK6mNtCnyw9bwNFQ1MW59VVUMjdfzAqD-GD3UJzA9JhXUZS_thRv5i5IVwCoQpQ8ph_hid-ezoKUujs8EutnXVN2oQdbs4lXtUMzSwq9pbD0ROkRJllXqxsFqR7-EyXfwHddqDK2Pqjo2wfORBQMfUyfM0VvAdQSQ8HEdCHAHYE25-X_Ja7dq_KxvmLoh0"/>
        <div class="user-info flex-1 min-w-0">
          <p class="text-sm font-semibold truncate">Admin User</p>
          <p class="text-xs text-slate-500 truncate">admin@example.com</p>
        </div>
      </div>
    </div>
  </aside>
</template>

<style scoped>

</style>
