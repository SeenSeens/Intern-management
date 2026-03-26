<script setup>
import { useRouter } from "vue-router"
import { useProjectStore } from "@/stores/projectStore"
import ProjectForm from "@/views/project/ProjectForm.vue";

const router = useRouter()
const projectStore = useProjectStore()

const submit = ( async(data) => {
  try {
    await projectStore.createProject(data)
    router.push("/project")
  } catch (e) {
    console.error(e)
  }
})
</script>

<template>
  <div class="max-w-4xl mx-auto">
    <div class="mb-8">
      <nav class="flex mb-4 text-sm text-slate-500 gap-2 items-center">
        <a class="hover:text-primary" href="#">Dự án</a>
        <span class="material-symbols-outlined text-xs">chevron_right</span>
        <span class="text-slate-900"></span>
      </nav>
      <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">Tạo dự án mới</h1>
      <p class="text-slate-500 mt-1">Hãy điền thông tin bên dưới để khởi động dự án mới.</p>
    </div>
    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
      <ProjectForm :isEdit="false" @submit="submit" />
    </div>
    <!-- Helper Card -->
    <div class="mt-8 p-4 rounded-lg border border-slate-200 flex items-start gap-4">
      <span class="material-symbols-outlined text-primary">info</span>
      <div>
        <p class="text-sm font-medium text-slate-900">Mẹo nhanh</p>
        <p class="text-xs text-slate-500 mt-1">Sau khi được tạo, các thành viên tham gia dự án sẽ nhận được email mời tự động kèm theo vai trò được chỉ định và quyền truy cập vào bảng dự án.</p>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>
