<script setup>
import { useField } from 'vee-validate';

const props = defineProps({
  name: String,
  type: String,
});

const { value, errorMessage } = useField(() => props.name);
</script>

<template>
  <input v-model="value" :type="type || 'text'" class="rounded-lg border-slate-300 bg-white text-slate-900 focus:ring-primary focus:border-primary px-4 py-2.5"/>
  <span class="text-red-500 text-sm">{{ errorMessage }}</span>
</template>

<style scoped>

</style>
