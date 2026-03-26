<script setup>
import { computed } from "vue";

const props = defineProps({
  currentPage: Number,
  totalPages: Number
});

const emit = defineEmits(["changePage"]);

const pages = computed(() => {
  return Array.from({ length: props.totalPages }, (_, i) => i + 1);
});

const changePage = (page) => {
  if (page < 1 || page > props.totalPages) return;
  emit("changePage", page);
};
</script>

<template>
  <div class="flex items-center gap-2">

    <button
      @click="changePage(currentPage - 1)"
      class="px-3 py-1 border border-slate-200 dark:border-slate-700 rounded-md text-sm hover:bg-white dark:hover:bg-slate-700"
    >
      Trước
    </button>

    <button
      v-for="page in pages"
      :key="page"
      @click="changePage(page)"
      :class="[
        'px-3 py-1 rounded-md text-sm',
        page === currentPage
          ? 'bg-primary text-white'
          : 'border border-slate-200 dark:border-slate-700 hover:bg-white dark:hover:bg-slate-700'
      ]"
    >
      {{ page }}
    </button>

    <button
      @click="changePage(currentPage + 1)"
      class="px-3 py-1 border border-slate-200 dark:border-slate-700 rounded-md text-sm hover:bg-white dark:hover:bg-slate-700"
    >
      Sau
    </button>

  </div>
</template>

<style scoped>

</style>
