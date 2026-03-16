<script setup>
import { onMounted, ref } from 'vue'
import {useRoute, useRouter} from 'vue-router'
import { useProjectStore } from '@/stores/projectStore.js'

const route = useRoute()
const router = useRouter()
const projectStore = useProjectStore()

const project = ref({})

onMounted(() => {
  const id = route.params.id
  const p = projectStore.projects.find(p => p.id == id)
  if (p) {
    project.value = { ...p }
  }
})

const submit = async () => {
  try {
    await projectStore.updateProject(project.value.id, project.value)
    await router.push('/project')
  } catch (e) {
    console.error(e)
  }
}
</script>

<template>
  <div class="max-w-4xl mx-auto">
    <div class="mb-8">
      <nav class="flex mb-4 text-sm text-slate-500 gap-2 items-center">
        <a class="hover:text-primary" href="#">Dự án</a>
        <span class="material-symbols-outlined text-xs">chevron_right</span>
        <span class="text-slate-900 dark:text-slate-100">Cập nhật án mới</span>
      </nav>
      <h1 class="text-3xl font-extrabold tracking-tight text-slate-900 dark:text-slate-100">Cập nhật án mới</h1>
      <p class="text-slate-500 mt-1">Hãy điền thông tin bên dưới để khởi động dự án mới.</p>
    </div>
    <div class="bg-white dark:bg-slate-900/50 rounded-xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm">
      <form class="p-6 md:p-8 space-y-8" @submit.prevent="submit">
        <!-- Project Basic Info -->
        <section class="grid grid-cols-1 md:grid-cols-1 gap-6">
          <div class="flex flex-col gap-2">
            <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Tên dự án</label>
            <input v-model="project.name" class="rounded-lg border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 focus:ring-primary focus:border-primary px-4 py-2.5" placeholder="e.g. AI-Powered Analytics Dashboard" type="text"/>
          </div>
        </section>
        <!-- Dates and Status -->
        <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <div class="flex flex-col gap-2">
            <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Trạng thái</label>
            <select v-model="project.status" class="rounded-lg border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 focus:ring-primary focus:border-primary px-4 py-2.5">
              <option value="in_progress">In Progress</option>
              <option value="waiting">Waiting</option>
              <option value="on_hold">On Hold</option>
              <option value="completed">Completed</option>
            </select>
          </div>
          <div class="flex flex-col gap-2">
            <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Ngày bắt đầu</label>
            <div class="relative">
              <input v-model="project.start_date" class="w-full rounded-lg border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 focus:ring-primary focus:border-primary px-4 py-2.5" type="date"/>
            </div>
          </div>
          <div class="flex flex-col gap-2">
            <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Ngày kết thúc</label>
            <div class="relative">
              <input v-model="project.end_date" class="w-full rounded-lg border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 focus:ring-primary focus:border-primary px-4 py-2.5" type="date"/>
            </div>
          </div>
        </section>
        <!-- Description -->
        <section class="flex flex-col gap-2">
          <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Mô tả</label>
          <div class="border border-slate-300 dark:border-slate-700 rounded-lg overflow-hidden">
            <textarea v-model="project.description" class="w-full border-none bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 focus:ring-0 p-4 resize-none" placeholder="Enter project scope, goals, and key deliverables..." rows="6"></textarea>
          </div>
        </section>
        <!-- Team Assignment -->
        <section class="space-y-6 pt-4 border-t border-slate-200 dark:border-slate-800">
          <div>
            <h3 class="text-lg font-bold text-slate-900 dark:text-slate-100 mb-4">Team Assignment</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
              <!-- Mentors -->
              <div class="space-y-3">
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-300 flex items-center gap-2">
                  <span class="material-symbols-outlined text-primary text-lg">school</span> Assign Mentors
                </label>
                <div class="flex flex-wrap gap-2 p-3 bg-slate-50 dark:bg-slate-800/30 rounded-lg min-h-[50px] border border-dashed border-slate-300 dark:border-slate-700">
                  <div class="flex items-center gap-1.5 bg-primary/10 text-primary px-2.5 py-1 rounded-full text-xs font-semibold border border-primary/20">
                    Sarah Jenkins <button class="material-symbols-outlined text-sm hover:text-slate-900" type="button">close</button>
                  </div>
                  <div class="flex items-center gap-1.5 bg-primary/10 text-primary px-2.5 py-1 rounded-full text-xs font-semibold border border-primary/20">
                    David Chen <button class="material-symbols-outlined text-sm hover:text-slate-900" type="button">close</button>
                  </div>
                  <button class="text-xs font-medium text-slate-500 hover:text-primary flex items-center gap-1 ml-2" type="button">
                    <span class="material-symbols-outlined text-base">add_circle</span> Add Mentor
                  </button>
                </div>
              </div>
              <!-- Interns -->
              <div class="space-y-3">
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-300 flex items-center gap-2">
                  <span class="material-symbols-outlined text-primary text-lg">group</span> Assign Interns
                </label>
                <div class="flex flex-wrap gap-2 p-3 bg-slate-50 dark:bg-slate-800/30 rounded-lg min-h-[50px] border border-dashed border-slate-300 dark:border-slate-700">
                  <div class="flex items-center gap-1.5 bg-primary/10 text-primary px-2.5 py-1 rounded-full text-xs font-semibold border border-primary/20">
                    Marcus Aurelius <button class="material-symbols-outlined text-sm hover:text-slate-900" type="button">close</button>
                  </div>
                  <button class="text-xs font-medium text-slate-500 hover:text-primary flex items-center gap-1 ml-2" type="button">
                    <span class="material-symbols-outlined text-base">add_circle</span> Add Intern
                  </button>
                </div>
              </div>
            </div>
          </div>
        </section>
        <!-- Form Actions -->
        <div class="flex items-center justify-end gap-4 pt-6">
          <button class="px-6 py-2.5 rounded-lg border border-slate-300 dark:border-slate-700 text-slate-700 dark:text-slate-300 font-semibold hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors" type="button">
            Cancel
          </button>
          <button class="px-8 py-2.5 rounded-lg bg-primary font-bold shadow-lg shadow-primary/30 hover:bg-primary/90 transition-all" type="submit">
            Cập nhật
          </button>
        </div>
      </form>
    </div>
    <!-- Helper Card -->
    <div class="mt-8 p-4 bg-primary/5 rounded-lg border border-primary/10 flex items-start gap-4">
      <span class="material-symbols-outlined text-primary">info</span>
      <div>
        <p class="text-sm font-medium text-slate-900 dark:text-slate-100">Quick Tip</p>
        <p class="text-xs text-slate-500 mt-1">Sau khi được tạo, các thành viên tham gia dự án sẽ nhận được email mời tự động kèm theo vai trò được chỉ định và quyền truy cập vào bảng dự án.</p>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>
