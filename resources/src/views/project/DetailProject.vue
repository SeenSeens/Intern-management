<script setup>
import {useProjectStore} from "@/stores/projectStore.js";
import {onMounted, ref, watch} from "vue";
import {useRoute} from "vue-router";

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
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
          <div class="h-32 bg-gradient-to-r from-blue-600 to-indigo-600 relative">
            <div class="absolute inset-0 bg-slate-900/10"></div>
          </div>
          <div class="px-6 py-5 -mt-12 relative z-10">
            <div class="bg-white p-1 rounded-lg inline-block shadow-sm mb-4">
              <div class="h-16 w-16 bg-blue-50 rounded flex items-center justify-center text-primary">
                <span class="material-symbols-outlined text-4xl">rocket_launch</span>
              </div>
            </div>
            <h3 class="text-lg font-bold text-slate-900 mb-2">{{ projectStore.project.name }}</h3>
            <p class="text-slate-600 leading-relaxed text-sm">{{ projectStore.project.description }}</p>
          </div>
        </div>
        <!-- Task Progress Section -->
        <div class="flex flex-col gap-4">
          <div class="flex items-center justify-between">
            <h3 class="text-lg font-bold text-slate-900">Tiến độ công việc</h3>
            <div class="flex gap-2 bg-slate-100 p-1 rounded-lg">
              <button class="px-3 py-1 bg-white shadow text-xs font-medium rounded text-slate-900">Board</button>
              <button class="px-3 py-1 text-xs font-medium rounded text-slate-500 hover:text-slate-900">List</button>
            </div>
          </div>
          <!-- Kanban Board -->
          <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Column: To Do -->
            <div class="flex flex-col gap-3">
              <div class="flex items-center justify-between mb-1">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Việc cần làm</span>
                <span class="bg-slate-100 text-slate-600 text-xs px-2 py-0.5 rounded-full">3</span>
              </div>
              <!-- Task Card 1 -->
              <div class="bg-white p-4 rounded-lg border border-slate-200 shadow-sm hover:shadow-md transition-shadow cursor-pointer group">
                <div class="flex justify-between items-start mb-2">
                  <span class="bg-orange-50 text-orange-700 text-[10px] px-2 py-0.5 rounded font-medium border border-orange-100">Design</span>
                  <span class="material-symbols-outlined text-slate-400 text-[18px] opacity-0 group-hover:opacity-100 transition-opacity">more_horiz</span>
                </div>
                <h4 class="text-sm font-medium text-slate-900 mb-3">Create high-fidelity mockups</h4>
                <div class="flex items-center justify-between mt-2">
                  <div class="flex -space-x-2">
                    <img alt="Avatar" class="inline-block h-6 w-6 rounded-full ring-2 ring-white" data-alt="Female intern avatar" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDxrG9StTsp-hPi9YdnWknBS60zJGF1gTiWP1ySSk7jZAmQ2HV-76xAMlhhWPTdHs6bcsqd8sDoo8nTyFTbLMOUhaKm8gWUdFJYOIrxk1-y3DnZ1sCRTcMlKrni9jJWalo9GumuSfFVD1kSP-Q6o4daohEHjO3pEjGSZXVd5iTKDydVUOaM3HTcsbYsIAPnlMJE9GQ8rNv8Y_KoYpm51BjScWRocbQG0ygEaPOK_DgD6XUO_41Gv8lclLF83iuaSoIWHCTSD6UtuIE"/>
                  </div>
                  <div class="flex items-center text-slate-400 gap-1 text-xs">
                    <span class="material-symbols-outlined text-[14px]">attachment</span>
                    <span>2</span>
                  </div>
                </div>
              </div>
              <!-- Task Card 2 -->
              <div class="bg-white p-4 rounded-lg border border-slate-200 shadow-sm hover:shadow-md transition-shadow cursor-pointer group">
                <div class="flex justify-between items-start mb-2">
                  <span class="bg-purple-50 text-purple-700 text-[10px] px-2 py-0.5 rounded font-medium border border-purple-100">Backend</span>
                  <span class="material-symbols-outlined text-slate-400 text-[18px] opacity-0 group-hover:opacity-100 transition-opacity">more_horiz</span>
                </div>
                <h4 class="text-sm font-medium text-slate-900 mb-3">Database schema design</h4>
                <div class="flex items-center justify-between mt-2">
                  <div class="flex -space-x-2">
                    <div class="h-6 w-6 rounded-full ring-2 ring-white bg-slate-200 flex items-center justify-center text-[10px] font-bold text-slate-500">?</div>
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
                <span class="bg-blue-50 text-primary text-xs px-2 py-0.5 rounded-full">2</span>
              </div>
              <!-- Task Card 3 -->
              <div class="bg-white p-4 rounded-lg border-l-4 border-l-primary border-y border-r border-slate-200 shadow-sm hover:shadow-md transition-shadow cursor-pointer group">
                <div class="flex justify-between items-start mb-2">
                  <span class="bg-green-50 text-green-700 text-[10px] px-2 py-0.5 rounded font-medium border border-green-100">Frontend</span>
                  <span class="material-symbols-outlined text-slate-400 text-[18px] opacity-0 group-hover:opacity-100 transition-opacity">more_horiz</span>
                </div>
                <h4 class="text-sm font-medium text-slate-900 mb-3">Implement login component</h4>
                <div class="w-full bg-slate-100 rounded-full h-1.5 mb-3">
                  <div class="bg-primary h-1.5 rounded-full" style="width: 60%"></div>
                </div>
                <div class="flex items-center justify-between mt-2">
                  <div class="flex -space-x-2">
                    <img alt="Avatar" class="inline-block h-6 w-6 rounded-full ring-2 ring-white" data-alt="Male intern avatar" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAT8zp6AHS13wgsHr5kv54fTGMm-pPfoHNmff9wug718-5nPhnGJPDEyxx0QXiMjgaCCF8RjvOUEoEphXYtoeIa7iOQRpb61osZM-Cr8H2I0AKgGQMET6h0CgYTC93O-RDe3jVatxUHwta10JwA3XDwadzZt2Kxw8OZa4YauhC3QK3fsx3UYdJdeNfJxbE6qdnGYbiM9B31ZcOnoilpuAstZLJK-VN8nsKEfjdHhNuKizmQDRyK2VcoJlV2cdUEU4eJhM2MxIaXgbc"/>
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
                <span class="bg-green-50 text-green-600 text-xs px-2 py-0.5 rounded-full">5</span>
              </div>
              <!-- Task Card 4 -->
              <div class="bg-slate-50 p-4 rounded-lg border border-slate-200 shadow-sm opacity-80 cursor-pointer">
                <div class="flex justify-between items-start mb-2">
                  <span class="bg-slate-200 text-slate-600 text-[10px] px-2 py-0.5 rounded font-medium">Research</span>
                  <div class="bg-green-100 text-green-600 rounded-full p-0.5">
                    <span class="material-symbols-outlined text-[14px] block">check</span>
                  </div>
                </div>
                <h4 class="text-sm font-medium text-slate-500 mb-3 line-through">Competitor Analysis</h4>
                <div class="flex items-center justify-between mt-2">
                  <div class="flex -space-x-2">
                    <img alt="Avatar" class="inline-block h-6 w-6 rounded-full ring-2 ring-white grayscale" data-alt="Male intern avatar" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDnMJKF-_RWmqbPEwLjGU2qByV6ZPnZNdm-cVjTiFiopczBB8196B9JRv7I7MVOG2sChCUF8F9orWr65uXji0XWB-Zlv_39_Jw69WYNqa1BaY5VRbMNo855XRu2chYjocoAUAsjBfLSAcKoC_dJMglOYRFeYqV48k5UnmpH4aIRUMDDSWRc6FydTed4v4aM7szqejVU6wwqAN0PE0Q1s-8ku5aCWE87cJHyzmjg_bpoQKZZY8xT6BJm8oLRB2v9AZISDlYzQv_ZG6s"/>
                  </div>
                  <div class="text-xs text-slate-400">Oct 15</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Right Sidebar -->
      <div class="col-span-12 lg:col-span-4 flex flex-col gap-6">
        <!-- Progress Circle Card -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
          <h3 class="text-base font-bold text-slate-900 mb-4">Tổng thể tiến độ</h3>
          <div class="flex flex-col items-center">
            <div class="relative size-40">
              <svg class="size-full rotate-[-90deg]" viewbox="0 0 36 36" xmlns="http://www.w3.org/2000/svg">
                <circle class="stroke-slate-100" cx="18" cy="18" fill="none" r="16" stroke-width="3"></circle>
                <circle class="stroke-primary" cx="18" cy="18" fill="none" r="16" stroke-dasharray="100" stroke-dashoffset="35" stroke-linecap="round" stroke-width="3"></circle>
              </svg>
              <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-center">
                <span class="text-3xl font-bold text-slate-900">{{ projectStore.overall.progress }}%</span>
                <span class="block text-xs text-slate-500 font-medium uppercase tracking-wide">Hoàn thành</span>
              </div>
            </div>
            <div class="flex w-full justify-between mt-6 px-2 text-center">
              <div>
                <p class="text-2xl font-bold text-slate-900">{{ projectStore.overall.total }}</p>
                <p class="text-xs text-slate-500">Tổng số nhiệm vụ</p>
              </div>
              <div>
                <p class="text-2xl font-bold text-slate-900">{{ projectStore.overall.in_progress }}</p>
                <p class="text-xs text-slate-500">Đang tiến hành</p>
              </div>
              <div>
                <p class="text-2xl font-bold text-green-600">{{ projectStore.overall.completed }}</p>
                <p class="text-xs text-slate-500">Hoàn thành</p>
              </div>
              <div>
                <p class="text-2xl font-bold text-orange-500">{{ projectStore.overall.pending }}</p>
                <p class="text-xs text-slate-500">Chưa giải quyết</p>
              </div>
            </div>
          </div>
        </div>
        <!-- Project Info Card -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
          <div class="flex items-center justify-between mb-4">
            <h3 class="text-base font-bold text-slate-900">Thông tin dự án</h3>
            <RouterLink :to="{ name: 'project-edit', params: { id: projectId } }" class="text-primary hover:text-blue-700 text-sm font-medium">Edit</RouterLink>
          </div>
          <div class="space-y-4">
            <div class="flex items-start gap-3">
              <div class="bg-slate-100 p-2 rounded-lg text-slate-500">
                <span class="material-symbols-outlined text-[20px]">calendar_month</span>
              </div>
              <div>
                <p class="text-xs text-slate-500 font-medium">Timeline</p>
                <p class="text-sm font-semibold text-slate-900">Oct 1, 2023 - Dec 15, 2023</p>
              </div>
            </div>
            <div class="flex items-start gap-3">
              <div class="bg-slate-100 p-2 rounded-lg text-slate-500">
                <span class="material-symbols-outlined text-[20px]">badge</span>
              </div>
              <div>
                <p class="text-xs text-slate-500 font-medium">Project Manager</p>
                <p class="text-sm font-semibold text-slate-900">Sarah Jenkins</p>
              </div>
            </div>
            <div class="flex items-start gap-3">
              <div class="bg-slate-100 p-2 rounded-lg text-slate-500">
                <span class="material-symbols-outlined text-[20px]">domain</span>
              </div>
              <div>
                <p class="text-xs text-slate-500 font-medium">Department</p>
                <p class="text-sm font-semibold text-slate-900">Product Engineering</p>
              </div>
            </div>
          </div>
        </div>
        <!-- Team Members Card -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
          <h3 class="text-base font-bold text-slate-900 mb-4">Team Members</h3>
          <!-- Mentors -->
          <div class="mb-5">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">Mentors</p>
            <div class="flex items-center gap-3 mb-3" v-for="(mentor, index) in projectStore.mentors" :key="index">
              <img alt="Mentor avatar" class="h-8 w-8 rounded-full object-cover ring-2 ring-white" data-alt="Male mentor face" :src="mentor.avatar"/>
              <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-slate-900 truncate">{{ mentor.display_name }}</p>
                <p class="text-xs text-slate-500 truncate">Senior Developer</p>
              </div>
              <button class="text-slate-400 hover:text-primary"><span class="material-symbols-outlined text-[20px]">mail</span></button>
            </div>
          </div>
          <!-- Interns -->
          <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">Interns</p>
            <div class="space-y-3">
              <div class="flex items-center gap-3" v-for="(intern, index) in projectStore.interns" :key="index">
                <img alt="Intern avatar" class="h-8 w-8 rounded-full object-cover ring-2 ring-white" data-alt="Female intern face" :src="intern.avatar"/>
                <div class="flex-1 min-w-0">
                  <p class="text-sm font-medium text-slate-900 truncate">{{ intern.display_name }}</p>
                  <p class="text-xs text-slate-500 truncate">Frontend Intern</p>
                </div>
              </div>
            </div>
            <button class="mt-4 w-full py-2 text-sm text-primary font-medium hover:bg-blue-50 rounded-lg transition-colors border border-dashed border-primary/30">24
              + Add Member
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>
