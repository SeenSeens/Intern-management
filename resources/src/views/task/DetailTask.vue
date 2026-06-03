<script setup>
import {useTaskStore} from "@/stores/taskStore.js";
import {computed, onMounted, ref} from "vue";
import {useRoute} from "vue-router";
import StatusBadge from "@/component/StatusBadge.vue";
import PriorityBadge from "@/component/PriorityBadge.vue";
import {useModalStore} from "@/stores/modalStore.js";
import AssignMemberModal from "@/modals/AssignMemberModal.vue";
import {useUserStore} from "@/stores/userStore.js";
const taskStore = useTaskStore()
const route = useRoute()
const task = ref(null)
const isLoading = ref(true)
const modalStore = useModalStore()
const userStore = useUserStore()
const loadData = async (id) => {
  try {
    isLoading.value = true
    const taskId = Number(id)
    task.value = await taskStore.find(taskId)
  } catch (err) {
    console.error("API Error:", err)
  } finally {
    isLoading.value = false
  }
}
// Tính toán phần trăm tiến độ tự động
const progressPercentage = computed(() => {
  if (!task.value?.taskDetail?.length) return 0;
  const completed = task.value.taskDetail.filter(st => st.status === 'completed').length;
  return Math.round((completed / task.value.taskDetail.length) * 100);
});
// số subtask completed
const completedSubTasksCount = computed(() => {
  return task.value?.taskDetail?.filter(st => st.status === 'completed').length || 0;
});
onMounted(async () => {
  await Promise.all([
    userStore.getUsersByRole(["intern"]),
    loadData(route.params.id)
  ])
});
const toggleSubtask = async (subtask) => {
  try {
    const oldStatus = subtask.status
    subtask.status = subtask.status === 'completed' ? 'pending' : 'completed'
    await taskStore.updateTaskDetailStatus(subtask.id, subtask.status)
  } catch (err) {
    console.error(err)
    subtask.status = oldStatus
  }
}
const internOptions = computed(() =>
  userStore.userOptions("intern")
)
const openAssignModal = async () => {
  const result = await modalStore.open(
    AssignMemberModal,
    {
      interns: internOptions.value,
      currentInternId: task.value.assignee?.id
    }
  )
  if (!result) {
    return
  }
  await taskStore.reassignTask({
    task_id: task.value.id,
    intern_id: result.intern_id
  })
  await loadData(task.value.id)
}
</script>

<template>
  <!-- Loading state -->
  <div v-if="isLoading" class="flex items-center justify-center h-screen">
    <p>Loading task details...</p>
  </div>
  <!-- Main Content Canvas -->
  <div v-else-if="task" class="flex-1 flex bg-surface-container-low">
    <!-- Center Content: Task Details -->
    <div class="flex-1 p-8 overflow-y-auto">
      <div class="max-w-4xl mx-auto space-y-8">
        <!-- Task Title & Meta -->
        <section class="space-y-4">
          <div class="flex items-start justify-between">
            <div class="flex-1">
              <h1 class="text-3xl font-bold tracking-tight text-on-surface outline-none focus:ring-2 focus:ring-primary/20 rounded-lg px-1 -ml-1 transition-all" contenteditable="true">{{ task.title }}</h1>
            </div>
            <div class="flex items-center gap-3 shrink-0">
            <span class="px-3 py-1 bg-primary/10 text-primary rounded-full text-xs font-bold uppercase tracking-wider flex items-center gap-1.5">
              <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
              <StatusBadge :status="task.status" />
            </span>
            <span class="px-3 py-1 bg-error-container text-on-error-container rounded-full text-xs font-bold uppercase tracking-wider flex items-center gap-1.5">
              <span class="material-symbols-outlined text-sm">priority_high</span>
              <PriorityBadge :priority="task.priority" />
            </span>
            </div>
          </div>
        </section>
        <!-- Tabs/Navigation for Task Info -->
        <div class="flex gap-8 border-b border-outline">
          <button class="pb-3 border-b-2 border-primary text-sm font-semibold text-primary">Description</button>
          <button class="pb-3 border-b-2 border-transparent text-sm font-medium text-on-surface-variant hover:text-on-surface transition-colors">Chi tiết nhiệm vụ ({{ task.taskDetail?.length || 0 }})</button>
          <button class="pb-3 border-b-2 border-transparent text-sm font-medium text-on-surface-variant hover:text-on-surface transition-colors">Tệp đính kèm</button>
        </div>
        <!-- Description Area -->
        <div class="bg-surface p-6 rounded-xl border border-outline shadow-sm space-y-4">
          <div class="prose prose-slate max-w-none text-on-surface leading-relaxed" v-html="task.description">
          </div>
        </div>
        <!-- Sub-tasks Checklist -->
        <section class="space-y-4">
          <div class="flex items-center justify-between">
            <h3 class="text-lg font-bold text-on-surface">Chi tiết nhiệm vụ</h3>
            <button class="text-xs font-bold text-primary flex items-center gap-1 hover:underline">
              <span class="material-symbols-outlined text-sm">add</span> Thêm chi tiết nhiệm vụ
            </button>
          </div>
          <div class="space-y-2">
            <!-- V-for loop qua các taskDetail -->
            <div class="group flex items-center gap-4 p-4 bg-white rounded-xl border border-outline hover:shadow-sm transition-all" v-for="subtask in task.taskDetail" :key="subtask.id">
              <input :checked="subtask.status === 'completed'" @change="toggleSubtask(subtask)" class="w-5 h-5 rounded border-slate-300 text-primary focus:ring-primary" type="checkbox"/>
              <span class="flex-1 text-sm transition-all" :class="{ 'line-through text-on-surface-variant': subtask.status === 'completed', 'text-on-surface': subtask.status !== 'completed' }">{{ subtask.title }}</span>
              <span class="material-symbols-outlined text-slate-300 group-hover:text-slate-600 cursor-pointer">drag_indicator</span>
            </div>
          </div>
        </section>
      </div>
    </div>
    <!-- Right Sidebar: Contextual Meta -->
    <aside class="w-80 bg-white border-l border-outline p-6 space-y-8 sticky top-16 overflow-y-auto">
      <!-- Quick Actions -->
      <div class="space-y-3">
        <button class="w-full flex items-center justify-center gap-2 py-2.5 bg-primary text-white rounded-lg text-sm font-bold shadow-md hover:shadow-lg transition-all active:scale-95">
          <span class="material-symbols-outlined text-lg" style="font-variation-settings: 'FILL' 1;">check_circle</span>
          Hoàn thành nhiệm vụ
        </button>
        <div class="grid grid-cols-2 gap-2">
          <button class="flex items-center justify-center gap-1.5 py-2 border border-outline rounded-lg text-xs font-bold text-on-surface hover:bg-slate-50 transition-colors" id="show-modal" @click="openAssignModal">
            <span class="material-symbols-outlined text-sm">person_add</span>
            Phân công lại
          </button>
          <button class="flex items-center justify-center gap-1.5 py-2 border border-outline rounded-lg text-xs font-bold text-on-surface hover:bg-slate-50 transition-colors">
            <span class="material-symbols-outlined text-sm">event</span>
            Lịch
          </button>
        </div>
      </div>
      <!-- Detail List -->
      <div class="space-y-6">
        <div v-if="task.assignee">
          <span class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant block mb-3">Assignee</span>
          <div class="flex items-center gap-3 p-3 bg-surface-container-low rounded-xl border border-outline/50">
            <img alt="Jared Erickson" class="h-10 w-10 rounded-full" data-alt="professional portrait of a young intern with short dark hair in a clean minimalist environment" src="https://lh3.googleusercontent.com/aida-public/AB6AXuC1bH-0q3Y3_TtDGQ8G1sNkoubKHR7rj7MI_Uxy2ReHw4kmPTZITTXCZRdMEDVcdL1_S-aq1eCTflX_CMdfDx3iZR-Sjj6D2_M0iGdb3I07aCiZVZOwTkVqNFBMZbR-u-P3PPuiqjEjJZPJxquAvDlF8KLRGfpBbpK8UoR_gWXR5FdKo4bYu2n4Ptz6y39qYjHV7Ws6KC2LA4BA0L-JTVXU8H7JQuCHFKOAQEmVx3O67G5IIPXe7ENL-s39kQXiPsNcYF2xXWOAbz8"/>
            <div>
              <p class="text-sm font-bold text-on-surface leading-tight">Jared Erickson</p>
              <p class="text-xs text-on-surface-variant">Backend Intern</p>
            </div>
          </div>
        </div>
        <div class="grid grid-cols-1 gap-4">
          <div class="space-y-1">
            <span class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Ngày đến hạn</span>
            <div class="flex items-center gap-2 text-sm font-semibold text-on-surface">
              <span class="material-symbols-outlined text-primary text-lg">calendar_today</span>
              {{ task.end_date }}
            </div>
          </div>
          <div class="space-y-1">
            <span class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Dự án</span>
            <div class="flex items-center gap-2 text-sm font-semibold text-on-surface">
              <span class="material-symbols-outlined text-primary text-lg" style="font-variation-settings: 'FILL' 1;">folder</span>
              {{ task.project_name }}
            </div>
          </div>
        </div>
        <div>
          <span class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant block mb-3">Tags</span>
          <div class="flex flex-wrap gap-2">
            <span class="px-2 py-1 bg-slate-100 text-slate-600 rounded text-[11px] font-bold">#authentication</span>
            <span class="px-2 py-1 bg-slate-100 text-slate-600 rounded text-[11px] font-bold">#api</span>
            <span class="px-2 py-1 bg-error-container text-on-error-container rounded text-[11px] font-bold">#urgent</span>
          </div>
        </div>
      </div>
      <!-- Task Progress Card -->
      <div class="p-5 bg-primary/5 rounded-2xl border border-primary/10 space-y-4">
        <div class="flex items-center justify-between">
          <span class="text-xs font-bold text-primary">Progress</span>
          <span class="text-xs font-bold text-primary">{{progressPercentage}}%</span>
        </div>
        <div class="w-full bg-primary/10 h-1.5 rounded-full overflow-hidden">
          <div class="bg-primary h-full rounded-full" :style="{ width: `${progressPercentage}%` }"></div>
        </div>
        <p class="text-[11px] text-on-surface-variant italic text-center">Đã hoàn thành {{ completedSubTasksCount }} of {{ task.taskDetail?.length || 0 }} trong số 3 nhiệm vụ phụ.</p>
      </div>
      <!-- History Timeline (Additional Contextual Component) -->
      <div class="bg-surface rounded-xl shadow-sm border border-outline p-6">
        <h3 class="text-[10px] font-bold uppercase tracking-[0.2em] text-on-surface-variant mb-4">Task Activity</h3>
        <div class="space-y-4">
          <div class="flex gap-3 relative">
            <div class="absolute left-1.5 top-5 bottom-0 w-px bg-outline-variant"></div>
            <div class="w-3 h-3 rounded-full bg-primary mt-1 z-10"></div>
            <div>
              <p class="text-xs font-bold text-on-surface">Status changed to In Progress</p>
              <p class="text-[10px] text-on-surface-variant">Today, 9:24 AM by Marcus Chen</p>
            </div>
          </div>
          <div class="flex gap-3 relative">
            <div class="absolute left-1.5 top-5 bottom-0 w-px bg-outline-variant"></div>
            <div class="w-3 h-3 rounded-full bg-outline-variant mt-1 z-10"></div>
            <div>
              <p class="text-xs font-bold text-on-surface">Sub-task completed</p>
              <p class="text-[10px] text-on-surface-variant">Yesterday, 4:12 PM by Jared Erickson</p>
            </div>
          </div>
          <div class="flex gap-3">
            <div class="w-3 h-3 rounded-full bg-outline-variant mt-1 z-10"></div>
            <div>
              <p class="text-xs font-bold text-on-surface">Task created</p>
              <p class="text-[10px] text-on-surface-variant">Oct 21, 2024 by Sarah Jenkins</p>
            </div>
          </div>
        </div>
      </div>
      <!-- Sidebar Footer -->
      <div class="pt-6 border-t border-slate-100">
        <div class="flex items-center justify-between text-[11px] text-on-surface-variant">
          <span>Created Sep 12, 2024</span>
          <button class="hover:text-primary transition-colors">History</button>
        </div>
      </div>
    </aside>
  </div>
</template>
