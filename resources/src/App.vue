<script setup>
import { ref } from 'vue';
import Sidebar from "@/component/Sidebar.vue";
import Header from "@/component/Header.vue";
import Footer from "@/component/Footer.vue";

const isExpanded = ref(true)

const toggleSidebar = () => {
  isExpanded.value = !isExpanded.value
}
</script>

<template>
  <Sidebar isExpanded="isExpanded" />
  <div class="flex-1 flex flex-col min-w-0">
    <Header @toggle="toggleSidebar" />
    <main class="flex-1 overflow-y-auto p-4 md:p-8 bg-background-light dark:bg-background-dark">
      <RouterView />
      <Footer/>
    </main>
  </div>
</template>

<style scoped></style>
