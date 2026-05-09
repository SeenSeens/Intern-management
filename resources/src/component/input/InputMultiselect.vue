<script setup>

import Multiselect from "vue-multiselect";
</script>

<template>
  <Multiselect
    v-model="selectedMentors"
    :options="mentorOptions"
    :multiple="true"
    label="name"
    track-by="id"
    placeholder="Chọn mentor"
    class="flex flex-wrap gap-2 p-3 bg-slate-50 rounded-lg min-h-[50px] border border-dashed border-slate-300"
  />
</template>

<style scoped>

</style>
