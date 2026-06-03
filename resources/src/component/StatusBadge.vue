<script setup>
import {computed} from "vue"

const props = defineProps({
  status: String
});

const config = {
  in_progress: { label: 'Đang triển khai', class: 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300' },
  waiting: { label: 'Chờ xử lý', class: 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300' },
  on_hold: { label: 'Tạm hoãn', class: 'bg-blue-100 text-blue-800 dark:bg-purple-100 dark:text-purple-800' },
  completed: { label: 'Hoàn thành', class: 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300' },
  pending: { label: ''},
  

};

const badgeClass = computed(() => {
  const base = 'inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium';
  return `${base} ${config[props.status]?.class || 'bg-gray-100 text-gray-800'}`;
});

const label = computed(() => config[props.status]?.label || props.status);
</script>

<template>
  <span :class="badgeClass">
    <slot>{{ label }}</slot>
  </span>
</template>

<style scoped>

</style>
