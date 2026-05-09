<script setup>
import {onMounted} from "vue";
import {useUserStore} from "@/stores/userStore.js";

const userStore = useUserStore()
onMounted(async () => {
  try {
    await userStore.getUsersByRole(['administrator', 'project_manager', 'mentor', 'intern'])
  } catch (err) {
    console.error("API Error:", err);
  }
});
</script>

<template>
  <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
    <div>
      <nav aria-label="Breadcrumb" class="flex text-sm text-slate-500 mb-2">
        <ol class="flex items-center space-x-2">
          <li><a class="hover:text-primary" href="#">Trang chủ</a></li>
          <li class="flex items-center space-x-2">
            <span class="material-icons text-base">chevron_right</span>
            <span class="font-medium text-slate-900">Quản lý thành viên</span>
          </li>
        </ol>
      </nav>
      <h2 class="text-2xl font-bold tracking-tight">Quản lý thành viên</h2>
      <p class="text-slate-500 mt-1">Quản lý danh sách thực tập sinh, mentor và quản trị viên hệ thống.</p>
    </div>
  </div>
  <section class="mb-12">
    <div class="flex items-center gap-2 mb-4">
      <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200">Danh sách Admins</h3>
    </div>
    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl overflow-hidden shadow-sm">
      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
          <thead>
            <tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800">
              <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider w-16">No</th>
              <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Avatar</th>
              <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Username</th>
              <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Email</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors" v-for="(user, index) in userStore.usersByRole.administrator" :key="index">
              <td class="px-6 py-4 text-sm text-slate-500 dark:text-slate-400 font-medium">{{ index+1 }}</td>
              <td class="px-6 py-4">
                <img alt="Jared Erickson" class="w-10 h-10 rounded-full border border-slate-200 dark:border-slate-700 shadow-sm" :src="user.avatar"/>
              </td>
              <td class="px-6 py-4 text-sm font-medium text-slate-700 dark:text-slate-300">{{user.name}}</td>
              <td class="px-6 py-4 text-sm text-slate-500 dark:text-slate-400">{{user.email}}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </section>
  <section class="mb-12">
    <div class="flex items-center gap-2 mb-4">
      <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200">Danh sách Project Manager</h3>
    </div>
    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl overflow-hidden shadow-sm">
      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
          <thead>
          <tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800">
            <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider w-16">No</th>
            <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Avatar</th>
            <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Username</th>
            <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Email</th>
          </tr>
          </thead>
          <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
          <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors" v-for="(user, index) in userStore.usersByRole.project_manager" :key="index">
            <td class="px-6 py-4 text-sm text-slate-500 dark:text-slate-400 font-medium">{{ index+1 }}</td>
            <td class="px-6 py-4">
              <img alt="Jared Erickson" class="w-10 h-10 rounded-full border border-slate-200 dark:border-slate-700 shadow-sm" :src="user.avatar"/>
            </td>
            <td class="px-6 py-4 text-sm font-medium text-slate-700 dark:text-slate-300">{{user.name}}</td>
            <td class="px-6 py-4 text-sm text-slate-500 dark:text-slate-400">{{user.email}}</td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>
  </section>
  <section class="mb-12">
    <div class="flex items-center gap-2 mb-4">
      <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200">Danh sách Mentors</h3>
    </div>
    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl overflow-hidden shadow-sm">
      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
          <thead>
          <tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800">
            <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider w-16">No</th>
            <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Avatar</th>
            <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Username</th>
            <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Email</th>
          </tr>
          </thead>
          <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
          <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors" v-for="(user, index) in userStore.usersByRole.mentor" :key="index">
            <td class="px-6 py-4 text-sm text-slate-500 dark:text-slate-400 font-medium">{{ index+1 }}</td>
            <td class="px-6 py-4">
              <img alt="Jared Erickson" class="w-10 h-10 rounded-full border border-slate-200 dark:border-slate-700 shadow-sm" :src="user.avatar"/>
            </td>
            <td class="px-6 py-4 text-sm font-medium text-slate-700 dark:text-slate-300">{{user.name}}</td>
            <td class="px-6 py-4 text-sm text-slate-500 dark:text-slate-400">{{user.email}}</td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>
  </section>
  <section class="mb-12">
    <div class="flex items-center gap-2 mb-4">
      <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200">Danh sách Interns</h3>
    </div>
    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl overflow-hidden shadow-sm">
      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
          <thead>
          <tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800">
            <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider w-16">No</th>
            <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Avatar</th>
            <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Username</th>
            <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Email</th>
          </tr>
          </thead>
          <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
          <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors" v-for="(user, index) in userStore.usersByRole.intern" :key="user.index">
            <td class="px-6 py-4 text-sm text-slate-500 dark:text-slate-400 font-medium">{{ index+1 }}</td>
            <td class="px-6 py-4">
              <img alt="Jared Erickson" class="w-10 h-10 rounded-full border border-slate-200 dark:border-slate-700 shadow-sm" :src="user.avatar"/>
            </td>
            <td class="px-6 py-4 text-sm font-medium text-slate-700 dark:text-slate-300">{{user.name}}</td>
            <td class="px-6 py-4 text-sm text-slate-500 dark:text-slate-400">{{user.email}}</td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>
  </section>
</template>

<style scoped>

</style>
