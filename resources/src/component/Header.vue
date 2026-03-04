<script setup>

</script>

<template>
  <header class="h-16 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between px-4 md:px-8 shrink-0 z-10">
    <div class="flex items-center gap-4">
      <button class="p-2 rounded-lg text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors" id="toggleSidebar">
        <span class="material-symbols-outlined">menu</span>
      </button>
      <div class="hidden sm:flex items-center bg-slate-100 dark:bg-slate-800 rounded-lg px-3 py-1.5 w-64 lg:w-96">
        <span class="material-symbols-outlined text-slate-400 text-lg">search</span>
        <input class="bg-transparent border-none focus:ring-0 text-sm w-full placeholder:text-slate-400 dark:text-slate-200" placeholder="Tìm kiếm nhiệm vụ, dự án..." type="text"/>
      </div>
    </div>
    <div class="flex items-center gap-2 md:gap-4">
      <button class="p-2 text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full transition-colors relative">
        <span class="material-symbols-outlined">notifications</span>
        <span class="absolute top-2 right-2 w-2 h-2 bg-rose-500 rounded-full border-2 border-white dark:border-slate-900"></span>
      </button>
      <button class="p-2 text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full transition-colors" onclick="document.documentElement.classList.toggle('dark')">
        <span class="material-symbols-outlined dark:hidden">dark_mode</span>
        <span class="material-symbols-outlined hidden dark:block">light_mode</span>
      </button>
      <div class="h-8 w-[1px] bg-slate-200 dark:border-slate-700 mx-1"></div>
      <button class="flex items-center gap-2 hover:bg-slate-100 dark:hover:bg-slate-800 p-1 rounded-lg transition-colors">
        <img alt="User profile" class="w-8 h-8 rounded-full border border-slate-200 dark:border-slate-700" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCpg9vPRbqN4F5TYYI2f6oY1zta3swAOayP2wvSuL8oYBIuDBildfJXyVQtEVMR1VA8LEyRxVyq5Rr_ehK6mNtCnyw9bwNFQ1MW59VVUMjdfzAqD-GD3UJzA9JhXUZS_thRv5i5IVwCoQpQ8ph_hid-ezoKUujs8EutnXVN2oQdbs4lXtUMzSwq9pbD0ROkRJllXqxsFqR7-EyXfwHddqDK2Pqjo2wfORBQMfUyfM0VvAdQSQ8HEdCHAHYE25-X_Ja7dq_KxvmLoh0"/>
        <span class="hidden md:block text-sm font-medium text-slate-700 dark:text-slate-300">Admin User</span>
        <span class="material-symbols-outlined text-slate-400 text-sm">expand_more</span>
      </button>
    </div>
  </header>
</template>

<style scoped>

</style>
