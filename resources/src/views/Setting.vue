<script setup>
import {computed, ref, watch} from "vue"
import {useRoute, useRouter} from "vue-router"
import General from "@/component/settings/General.vue"
import Profile from "@/component/settings/Profile.vue"
import Notification from "@/component/settings/Notification.vue"
import Security from "@/component/settings/Security.vue"
import System from "@/component/settings/System.vue"

const route = useRoute()
const router = useRouter()

const activeTab = ref(route.query.tab || 'general')

watch(activeTab, (val) => {
  router.replace({ query: { tab: val } })
})
watch(() => route.query.tab, (tab) => {
  if (tab && tab !== activeTab.value) {
    activeTab.value = tab
  }
})
const tabs = [
  { key: 'general', label: 'Cài đặt chung', icon: 'tune' },
  { key: 'profile', label: 'Thông tin hồ sơ', icon: 'person' },
  { key: 'notification', label: 'Tùy chọn thông báo', icon: 'notifications_active' },
  { key: 'security', label: 'Bảo mật & Mật khẩu', icon: 'shield' },
  { key: 'system', label: 'Cấu hình hệ thống', icon: 'settings_suggest' }
]

const tabComponents = {
  general: General,
  profile: Profile,
  notification: Notification,
  security: Security,
  system: System
}

const currentTab = computed(() => tabComponents[activeTab.value])
</script>

<template>
	<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
      <nav aria-label="Breadcrumb" class="flex text-sm text-slate-500 mb-2">
        <ol class="flex items-center space-x-2">
          <li><a class="hover:text-primary" href="#">Trang chủ</a></li>
          <li class="flex items-center space-x-2">
            <span class="material-icons text-base">chevron_right</span>
            <span class="font-medium text-slate-900">Cài đặt</span>
          </li>
        </ol>
      </nav>
  </div>
  <div class="flex gap-8 max-w-6xl">
	  <!-- Inner Sidebar (Sub-navigation) -->
	  <div class="w-72 flex flex-col gap-1 shrink-0">
	    <button v-for="tab in tabs" :key="tab.key" @click="activeTab = tab.key" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white dark:hover:bg-slate-800 transition-all " :class="activeTab === tab.key ? 'bg-white dark:bg-slate-800 shadow-sm border border-slate-200 dark:border-slate-700 text-primary' : 'text-slate-600 dark:text-slate-400 hover:bg-white hover:shadow-sm'">
	    	<span class="material-symbols-outlined">{{ tab.icon }}</span>
	    	<span class="text-sm font-medium">{{ tab.label }}</span>
	  	</button>
	  </div>
	  <!-- Right Content Panel -->
    <component :is="currentTab" />
	</div>
</template>

<style scoped>

</style>
