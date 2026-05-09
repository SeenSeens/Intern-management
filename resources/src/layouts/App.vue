  <script setup>
import { ref } from 'vue';
import Sidebar from "@/component/Sidebar.vue";
import Header from "@/component/Header.vue";
import Footer from "@/component/Footer.vue";

const collapsed = ref(false);

const toggleSidebar = () => {
  collapsed.value = !collapsed.value;
};
</script>

<template>
  <div class="flex h-screen">
    <Sidebar :collapsed="collapsed"/>
    <div class="flex-1 flex flex-col min-w-0">
      <Header @toggleSidebar="toggleSidebar" />
      <main class="flex-1 overflow-y-auto p-4 md:p-8 bg-background-light dark:bg-background-dark">
        <RouterView />
        <Footer/>
      </main>
    </div>
  </div>
</template>

<style scoped></style>
