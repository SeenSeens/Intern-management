<script setup>
import {onMounted, onUnmounted, ref, watch} from "vue"
import {useRoute} from "vue-router"
import {useProjectStore} from "@/stores/projectStore.js"
import Swal from "sweetalert2";
import StatusBadge from "@/component/StatusBadge.vue";
import PriorityBadge from "@/component/PriorityBadge.vue";
import BaseModal from "@/component/BaseModal.vue";

const viewMode = ref('board') // 'board' | 'list'

const route = useRoute()
const projectStore = useProjectStore()
const loadData = async (id) => {
  try {
    const projectId = Number(id)
    await Promise.all([
      projectStore.find(projectId)
    ])
  } catch (err) {
    console.error("API Error:", err)
  }
}

onMounted( () => {
  loadData(route.params.id)
});

watch(
  () => route.params.id,
  (newId) => {
    if (newId) loadData(newId)
  }
)

const showModal = ref(false)
const handleEsc = (e) => {
  if (e.key === 'Escape') showModal.value = false
}

onMounted(() => window.addEventListener('keydown', handleEsc))
onUnmounted(() => window.removeEventListener('keydown', handleEsc))
watch(showModal, (val) => {
  document.body.style.overflow = val ? 'hidden' : ''
})
</script>

<template>
  <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
    <div>
      <nav aria-label="Breadcrumb" class="flex text-sm text-slate-500 mb-2">
        <ol class="flex items-center space-x-2">
          <li><a class="hover:text-primary" href="#">Trang chủ</a></li>
          <li class="flex items-center space-x-2">
            <span class="material-icons text-base">chevron_right</span>
            <span class="font-medium text-slate-900">Quản lý dự án</span>
          </li>
        </ol>
      </nav>
      <h2 class="text-2xl font-bold tracking-tight">Danh sách theo dõi dự án và phân công</h2>
    </div>
  </div>
  <div class="flex-1 overflow-auto">
    <div class="grid grid-cols-12 gap-6 max-w-7xl mx-auto">
      <!-- Left Column (Main) -->
      <div class="col-span-12 lg:col-span-8 flex flex-col gap-6">
        <!-- Project Overview Card -->
        <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
          <div class="h-32 bg-gradient-to-r from-blue-600 to-indigo-600 relative">
            <div class="absolute inset-0 bg-slate-900/10"></div>
          </div>
          <div class="px-6 py-5 -mt-12 relative z-10">
            <div class="bg-white dark:bg-slate-800 p-1 rounded-lg inline-block shadow-sm mb-4">
              <div class="h-16 w-16 bg-blue-50 dark:bg-blue-900/30 rounded flex items-center justify-center text-primary">
                <span class="material-symbols-outlined text-4xl">rocket_launch</span>
              </div>
            </div>
            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">{{ projectStore.project?.name }}</h3>
            <p class="text-slate-600 dark:text-slate-300 leading-relaxed text-sm">{{ projectStore.project?.description }}</p>
          </div>
        </div>
        <!-- Task Progress Section -->
        <div class="flex flex-col gap-4">
          <div class="flex items-center justify-between">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white">Tiến độ công việc</h3>
            <div class="flex gap-2 bg-slate-100 dark:bg-slate-800 p-1 rounded-lg">
              <button
                @click="viewMode = 'board'"
                :class="[
                  'px-3 py-1 text-xs font-medium rounded',
                  viewMode === 'board'
                    ? 'bg-white shadow text-slate-900 dark:bg-slate-700 dark:text-white'
                    : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white'
                ]"
              >
                Board
              </button>
              <button
                @click="viewMode = 'list'"
                :class="[
                  'px-3 py-1 text-xs font-medium rounded',
                  viewMode === 'list'
                    ? 'bg-white shadow text-slate-900 dark:bg-slate-700 dark:text-white'
                    : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white'
                ]"
              >
                List
              </button>
            </div>
          </div>
          <!-- Kanban Board -->
          <div v-if="viewMode === 'board'" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Column: To Do -->
            <div class="flex flex-col gap-3">
              <div class="flex items-center justify-between mb-1">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Việc cần làm</span>
                <span class="bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 text-xs px-2 py-0.5 rounded-full">3</span>
              </div>
              <!-- Task Card 1 -->
              <div class="bg-white dark:bg-slate-900 p-4 rounded-lg border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-md transition-shadow cursor-pointer group">
                <div class="flex justify-between items-start mb-2">
                  <span class="bg-orange-50 text-orange-700 text-[10px] px-2 py-0.5 rounded font-medium border border-orange-100">Design</span>
                  <span class="material-symbols-outlined text-slate-400 text-[18px] opacity-0 group-hover:opacity-100 transition-opacity">more_horiz</span>
                </div>
                <h4 class="text-sm font-medium text-slate-900 dark:text-white mb-3">Create high-fidelity mockups</h4>
                <div class="flex items-center justify-between mt-2">
                  <div class="flex -space-x-2">
                    <img alt="Avatar" class="inline-block h-6 w-6 rounded-full ring-2 ring-white dark:ring-slate-900" data-alt="Female intern avatar" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDxrG9StTsp-hPi9YdnWknBS60zJGF1gTiWP1ySSk7jZAmQ2HV-76xAMlhhWPTdHs6bcsqd8sDoo8nTyFTbLMOUhaKm8gWUdFJYOIrxk1-y3DnZ1sCRTcMlKrni9jJWalo9GumuSfFVD1kSP-Q6o4daohEHjO3pEjGSZXVd5iTKDydVUOaM3HTcsbYsIAPnlMJE9GQ8rNv8Y_KoYpm51BjScWRocbQG0ygEaPOK_DgD6XUO_41Gv8lclLF83iuaSoIWHCTSD6UtuIE"/>
                  </div>
                  <div class="flex items-center text-slate-400 gap-1 text-xs">
                    <span class="material-symbols-outlined text-[14px]">attachment</span>
                    <span>2</span>
                  </div>
                </div>
              </div>
              <!-- Task Card 2 -->
              <div class="bg-white dark:bg-slate-900 p-4 rounded-lg border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-md transition-shadow cursor-pointer group">
                <div class="flex justify-between items-start mb-2">
                  <span class="bg-purple-50 text-purple-700 text-[10px] px-2 py-0.5 rounded font-medium border border-purple-100">Backend</span>
                  <span class="material-symbols-outlined text-slate-400 text-[18px] opacity-0 group-hover:opacity-100 transition-opacity">more_horiz</span>
                </div>
                <h4 class="text-sm font-medium text-slate-900 dark:text-white mb-3">Database schema design</h4>
                <div class="flex items-center justify-between mt-2">
                  <div class="flex -space-x-2">
                    <div class="h-6 w-6 rounded-full ring-2 ring-white dark:ring-slate-900 bg-slate-200 flex items-center justify-center text-[10px] font-bold text-slate-500">?</div>
                  </div>
                  <div class="flex items-center text-slate-400 gap-1 text-xs">
                    <span class="material-symbols-outlined text-[14px]">calendar_today</span>
                    <span>Oct 24</span>
                  </div>
                </div>
              </div>
            </div>
            <!-- Column: In Progress -->
            <div class="flex flex-col gap-3">
              <div class="flex items-center justify-between mb-1">
                <span class="text-xs font-semibold text-primary uppercase tracking-wider">Đang làm</span>
                <span class="bg-blue-50 dark:bg-blue-900/30 text-primary text-xs px-2 py-0.5 rounded-full">2</span>
              </div>
              <!-- Task Card 3 -->
              <div class="bg-white dark:bg-slate-900 p-4 rounded-lg border-l-4 border-l-primary border-y border-r border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-md transition-shadow cursor-pointer group">
                <div class="flex justify-between items-start mb-2">
                  <span class="bg-green-50 text-green-700 text-[10px] px-2 py-0.5 rounded font-medium border border-green-100">Frontend</span>
                  <span class="material-symbols-outlined text-slate-400 text-[18px] opacity-0 group-hover:opacity-100 transition-opacity">more_horiz</span>
                </div>
                <h4 class="text-sm font-medium text-slate-900 dark:text-white mb-3">Implement login component</h4>
                <div class="w-full bg-slate-100 rounded-full h-1.5 mb-3">
                  <div class="bg-primary h-1.5 rounded-full" style="width: 60%"></div>
                </div>
                <div class="flex items-center justify-between mt-2">
                  <div class="flex -space-x-2">
                    <img alt="Avatar" class="inline-block h-6 w-6 rounded-full ring-2 ring-white dark:ring-slate-900" data-alt="Male intern avatar" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAT8zp6AHS13wgsHr5kv54fTGMm-pPfoHNmff9wug718-5nPhnGJPDEyxx0QXiMjgaCCF8RjvOUEoEphXYtoeIa7iOQRpb61osZM-Cr8H2I0AKgGQMET6h0CgYTC93O-RDe3jVatxUHwta10JwA3XDwadzZt2Kxw8OZa4YauhC3QK3fsx3UYdJdeNfJxbE6qdnGYbiM9B31ZcOnoilpuAstZLJK-VN8nsKEfjdHhNuKizmQDRyK2VcoJlV2cdUEU4eJhM2MxIaXgbc"/>
                  </div>
                  <div class="flex items-center text-orange-500 gap-1 text-xs font-medium">
                    <span class="material-symbols-outlined text-[14px]">schedule</span>
                    <span>2 days left</span>
                  </div>
                </div>
              </div>
            </div>
            <!-- Column: Done -->
            <div class="flex flex-col gap-3">
              <div class="flex items-center justify-between mb-1">
                <span class="text-xs font-semibold text-green-600 uppercase tracking-wider">Xong</span>
                <span class="bg-green-50 dark:bg-green-900/30 text-green-600 text-xs px-2 py-0.5 rounded-full">5</span>
              </div>
              <!-- Task Card 4 -->
              <div class="bg-slate-50 dark:bg-slate-800/50 p-4 rounded-lg border border-slate-200 dark:border-slate-800 shadow-sm opacity-80 cursor-pointer">
                <div class="flex justify-between items-start mb-2">
                  <span class="bg-slate-200 text-slate-600 text-[10px] px-2 py-0.5 rounded font-medium">Research</span>
                  <div class="bg-green-100 text-green-600 rounded-full p-0.5">
                    <span class="material-symbols-outlined text-[14px] block">check</span>
                  </div>
                </div>
                <h4 class="text-sm font-medium text-slate-500 dark:text-slate-400 mb-3 line-through">Competitor Analysis</h4>
                <div class="flex items-center justify-between mt-2">
                  <div class="flex -space-x-2">
                    <img alt="Avatar" class="inline-block h-6 w-6 rounded-full ring-2 ring-white dark:ring-slate-900 grayscale" data-alt="Male intern avatar" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDnMJKF-_RWmqbPEwLjGU2qByV6ZPnZNdm-cVjTiFiopczBB8196B9JRv7I7MVOG2sChCUF8F9orWr65uXji0XWB-Zlv_39_Jw69WYNqa1BaY5VRbMNo855XRu2chYjocoAUAsjBfLSAcKoC_dJMglOYRFeYqV48k5UnmpH4aIRUMDDSWRc6FydTed4v4aM7szqejVU6wwqAN0PE0Q1s-8ku5aCWE87cJHyzmjg_bpoQKZZY8xT6BJm8oLRB2v9AZISDlYzQv_ZG6s"/>
                  </div>
                  <div class="text-xs text-slate-400">Oct 15</div>
                </div>
              </div>
            </div>
          </div>
          <!-- Task Table -->
          <div v-else class="rounded-xl border border-outline shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
              <table class="w-full text-left border-collapse">
                <thead>
                  <tr class="border-b border-outline bg-surface-container-low/50">
                    <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Tên nhiệm vụ</th>
                    <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-on-surface-variant text-center">Trạng thái</th>
                    <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Độ ưu tiên</th>
                    <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Hạn chót</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-outline">
                  <tr class="transition-colors group" v-for="(task, index) in projectStore.project?.tasksProject">
                    <td class="px-6 py-4">
                      <div class="flex items-center">
                          <span class="text-sm font-semibold text-on-surface group-hover:text-primary transition-colors cursor-pointer">{{ task.title }}</span>
                      </div>
                    </td>
                    <td class="px-6 py-4 text-center">
                      <StatusBadge :status="task.status" />
                    </td>
                    <td class="px-6 py-4">
                      <div class="flex items-center gap-1.5">
                        <PriorityBadge :priority="task.priority" />
                      </div>
                    </td>
                    <td class="px-6 py-4">
                      <div class="flex flex-col">
                        <span class="text-sm font-medium text-on-surface">{{ task.end_date }}</span>
                        <span class="text-[11px] text-error font-semibold">2 days left</span>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <!-- Pagination -->
          </div>
        </div>
      </div>
      <!-- Right Sidebar -->
      <div class="col-span-12 lg:col-span-4 flex flex-col gap-6">
        <!-- Progress Circle Card -->
        <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm p-6">
          <h3 class="text-base font-bold text-slate-900 dark:text-white mb-4">Tổng thể tiến độ</h3>
          <div class="flex flex-col items-center">
            <div class="relative size-40">
              <svg class="size-full rotate-[-90deg]" viewbox="0 0 36 36" xmlns="http://www.w3.org/2000/svg">
                <circle class="stroke-slate-100 dark:stroke-slate-800" cx="18" cy="18" fill="none" r="16" stroke-width="3"></circle>
                <circle class="stroke-primary" cx="18" cy="18" fill="none" r="16" stroke-dasharray="100" stroke-dashoffset="35" stroke-linecap="round" stroke-width="3"></circle>
              </svg>
              <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-center">
                <span class="text-3xl font-bold text-slate-900 dark:text-white">{{ projectStore.project?.overall?.progress }}%</span>
                <span class="block text-xs text-slate-500 font-medium uppercase tracking-wide">Hoàn thành</span>
              </div>
            </div>
            <div class="flex w-full justify-between mt-6 px-2 text-center">
              <div>
                <p class="text-2xl font-bold text-slate-900 dark:text-white">{{ projectStore.project?.overall?.total }}</p>
                <p class="text-xs text-slate-500">Tổng số nhiệm vụ</p>
              </div>
              <div>
                <p class="text-2xl font-bold text-slate-900 dark:text-white">{{ projectStore.project?.overall?.in_progress }}</p>
                <p class="text-xs text-slate-500">Đang tiến hành</p>
              </div>
              <div>
                <p class="text-2xl font-bold text-green-600">{{ projectStore.project?.overall?.completed }}</p>
                <p class="text-xs text-slate-500">Hoàn thành</p>
              </div>
              <div>
                <p class="text-2xl font-bold text-orange-500">{{ projectStore.project?.overall?.pending }}</p>
                <p class="text-xs text-slate-500">Chưa giải quyết</p>
              </div>
            </div>
          </div>
        </div>
        <!-- Project Info Card -->
        <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm p-6">
          <div class="flex items-center justify-between mb-4">
            <h3 class="text-base font-bold text-slate-900 dark:text-white">Thông tin dự án</h3>
            <RouterLink v-permission="'edit_project'" :to="{ name: 'project-edit', params: { id: projectId } }" class="text-primary hover:text-blue-700 text-sm font-medium">Edit</RouterLink>
          </div>
          <div class="space-y-4">
            <div class="flex items-start gap-3">
              <div class="bg-slate-100 dark:bg-slate-800 p-2 rounded-lg text-slate-500">
                <span class="material-symbols-outlined text-[20px]">calendar_month</span>
              </div>
              <div>
                <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">Timeline</p>
                <p class="text-sm font-semibold text-slate-900 dark:text-white">Oct 1, 2023 - Dec 15, 2023</p>
              </div>
            </div>
            <div class="flex items-start gap-3">
              <div class="bg-slate-100 dark:bg-slate-800 p-2 rounded-lg text-slate-500">
                <span class="material-symbols-outlined text-[20px]">badge</span>
              </div>
              <div>
                <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">Project Manager</p>
                <p class="text-sm font-semibold text-slate-900 dark:text-white">Sarah Jenkins</p>
              </div>
            </div>
            <div class="flex items-start gap-3">
              <div class="bg-slate-100 dark:bg-slate-800 p-2 rounded-lg text-slate-500">
                <span class="material-symbols-outlined text-[20px]">domain</span>
              </div>
              <div>
                <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">Department</p>
                <p class="text-sm font-semibold text-slate-900 dark:text-white">Product Engineering</p>
              </div>
            </div>
          </div>
        </div>
        <!-- Team Members Card -->
        <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm p-6">
          <h3 class="text-base font-bold text-slate-900 dark:text-white mb-4">Thành viên nhóm</h3>
          <!-- Mentors -->
          <div class="mb-5">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">Người cố vấn</p>
            <div class="flex items-center gap-3 mb-3" v-for="(mentor, index) in projectStore.project?.mentors" :key="mentor.id">
              <img alt="Mentor avatar" class="h-8 w-8 rounded-full object-cover ring-2 ring-white dark:ring-slate-800" data-alt="Male mentor face" :src="mentor.avatar"/>
              <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-slate-900 dark:text-white truncate">{{ mentor.display_name }}</p>
              </div>
              <button class="text-slate-400 hover:text-primary"><span class="material-symbols-outlined text-[20px]">mail</span></button>
            </div>
          </div>
          <!-- Interns -->
          <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">Thực tập sinh</p>
            <div class="space-y-3">
              <div class="flex items-center gap-3" v-for="(intern, index) in projectStore.project?.interns" :key="intern.id">
                <img alt="Intern avatar" class="h-8 w-8 rounded-full object-cover ring-2 ring-white dark:ring-slate-800" data-alt="Female intern face" :src="intern.avatar"/>
                <div class="flex-1 min-w-0">
                  <p class="text-sm font-medium text-slate-900 dark:text-white truncate">{{ intern.display_name }}</p>
                </div>
              </div>
            </div>
            <button @click="showModal = true" v-permission="['assign_mentor', 'assign_intern', 'assign_intern_to_project']" class="mt-4 w-full py-2 text-sm text-primary font-medium hover:bg-blue-50 rounded-lg transition-colors border border-dashed border-primary/30">
              + Thêm thành viên
            </button>
          </div>
          <Teleport to="body">
            <!-- use the modal component, pass in the prop -->
            <BaseModal :show="showModal" @close="showModal = false">
              <template #header>
                <h3 class="text-lg font-semibold text-center">Phân công lại thành viên</h3>
              </template>
              <template #body>
                <div class="space-y-3">
                  <p class="text-sm font-semibold text-center text-slate-600">Vui lòng chọn 1 thực tập sinh mới để thực hiện nhiệm vụ này.</p>
                  <label class="text-sm font-semibold text-slate-700 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-lg">person</span> Người thực hiện
                  </label>
                </div>
              </template>
              <template #footer>
                <button @click="showModal = false"
                  class="rounded-lg border px-4 py-1.5 bg-gray-200 text-sm font-bold text-gray-700 transition-colors hover:bg-gray-300"
                >
                  Hủy
                </button>
                <button
                  @click="showModal = false"
                  class="rounded-lg bg-blue-500 px-4 py-1.5 text-sm font-bold text-white transition-colors hover:bg-blue-600"
                >
                  Xác nhận
                </button>
              </template>
            </BaseModal>
          </Teleport>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>
