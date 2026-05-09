<script setup>
import {computed, nextTick, onMounted, ref, watch} from "vue"
import { useUserStore } from "@/stores/userStore"
import Multiselect from "vue-multiselect"
import {useForm} from "vee-validate";
import * as yup from "yup";

const props = defineProps({
  modelValue: Object, // project data
  isEdit: Boolean
})

const emit = defineEmits(["submit"])
const userStore = useUserStore()

const selectedMentors = ref([])
const selectedInterns = ref([])
const selectedStatus = ref(null)

const mentorOptions = computed(() => userStore.userOptions("mentor"))
const internOptions = computed(() => userStore.userOptions("intern"))

onMounted(async () => {
  if (!userStore.usersByRole?.mentor?.length) {
    await userStore.getUsersByRole(["mentor", "intern"])
  }
})

const statusOptions = [
  { label: "Đang xử lý", value: "in_progress" },
  { label: "Đang chờ", value: "waiting" },
  { label: "Tạm giữ", value: "on_hold" },
  { label: "Hoàn thành", value: "completed" }
]

const { handleSubmit, errors, defineField, setValues } = useForm({
  initialValues: {
    name: props.modelValue?.name || "",
    description: props.modelValue?.description || "",
    status: props.modelValue?.status || "waiting",
    start_date: props.modelValue?.start_date || null,
    end_date: props.modelValue?.end_date || null
  },
  validationSchema: yup.object({
    name: yup.string().required('Tên dự án không được để trống!'),
    description: yup.string().required('Vui lòng nhập mô tả'),
    status: yup.string().required('Vui lòng chọn trạng thái'),
    manager_id: yup.number(),
    start_date: yup.date().required('Vui lòng chọn ngày bắt đầu'),
    end_date: yup.date().required('Vui lòng chọn ngày kết thúc').min(yup.ref('start_date'), 'Ngày kết thúc phải sau ngày bắt đầu')
  })
})

const [name] = defineField('name')
const [description] = defineField('description')
const [status] = defineField('status', undefined, { initialValue: 'waiting'} )
const [start_date] = defineField('start_date')
const [end_date] = defineField('end_date')

watch(selectedStatus, (val) => {
  status.value = val?.value || ""
})

watch(status, (val) => {
  selectedStatus.value = statusOptions.find(s => s.value === val)
})

// sync data khi edit
watch(
  () => props.modelValue,(val) => {
    if (!val || !val.id) return
    // set vào vee-validate
    nextTick(() => {
      setValues({
        name: val.name,
        description: val.description,
        status: val.status,
        start_date: val.start_date,
        end_date: val.end_date
      })
    })

    // status
    selectedStatus.value = statusOptions.find(
      s => s.value === val.status
    )

    // set select
    selectedMentors.value = (val.mentors || []).map(u => ({
      name: u.display_name,
      id: u.id
    }))

    selectedInterns.value = (val.interns || []).map(u => ({
      name: u.display_name,
      id: u.id
    }))
  },
  { immediate: true }
)

const submit = handleSubmit( async(values) => {
  emit("submit", {
    ...values,
    mentors: selectedMentors.value.map(i => i.id),
    interns: selectedInterns.value.map(i => i.id)
  })
})
</script>

<template>
  <form class="p-6 md:p-8 space-y-8" @submit.prevent="submit">
    <!-- Project Basic Info -->
    <section class="grid grid-cols-1 md:grid-cols-1 gap-6">
      <div class="flex flex-col gap-2">
        <label class="text-sm font-semibold text-slate-700">Tên dự án</label>
        <input v-model="name" class="rounded-lg border-slate-300 bg-white text-slate-900 focus:ring-primary focus:border-primary px-4 py-2.5" placeholder="e.g. AI-Powered Analytics Dashboard" type="text"/>
        <span class="text-red-500 text-sm">{{ errors.name }}</span>
      </div>
    </section>
    <!-- Dates and Status -->
    <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div class="flex flex-col gap-2">
        <label class="text-sm font-semibold text-slate-700">Trạng thái</label>
        <Multiselect
          v-model="selectedStatus"
          :options="statusOptions"
          label="label"
          track-by="value"
          placeholder="Chọn trạng thái"
        />
        <span class="text-red-500 text-sm">{{ errors.status }}</span>
      </div>
      <div class="flex flex-col gap-2">
        <label class="text-sm font-semibold text-slate-700">Ngày bắt đầu</label>
        <div class="relative">
          <input v-model="start_date" class="w-full rounded-lg border-slate-300 bg-white text-slate-900 focus:ring-primary focus:border-primary px-4 py-2.5" type="date"/>
          <span class="text-red-500 text-sm">{{ errors.start_date }}</span>
        </div>
      </div>
      <div class="flex flex-col gap-2">
        <label class="text-sm font-semibold text-slate-700">Ngày kết thúc</label>
        <div class="relative">
          <input v-model="end_date" :min="start_date" class="w-full rounded-lg border-slate-300 bg-white text-slate-900 focus:ring-primary focus:border-primary px-4 py-2.5" type="date"/>
          <span class="text-red-500 text-sm">{{ errors.end_date }}</span>
        </div>
      </div>
    </section>
    <!-- Description -->
    <section class="flex flex-col gap-2">
      <label class="text-sm font-semibold text-slate-700">Mô tả</label>
      <div class="border border-slate-300 rounded-lg overflow-hidden">
        <textarea v-model="description" class="w-full border-none bg-white text-slate-900 focus:ring-0 p-4 resize-none" placeholder="Enter project scope, goals, and key deliverables..." rows="6"></textarea>
        <span class="text-red-500 text-sm">{{ errors.description }}</span>
      </div>
    </section>
    <!-- Team Assignment -->
    <section class="space-y-6 pt-4 border-t border-slate-200">
      <div>
        <h3 class="text-lg font-bold text-slate-900 mb-4">Phân công nhóm</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
          <!-- Mentors -->
          <div class="space-y-3">
            <label class="text-sm font-semibold text-slate-700 flex items-center gap-2">
              <span class="material-symbols-outlined text-primary text-lg">school</span> Phân công người hướng dẫn
            </label>
            <Multiselect
              v-model="selectedMentors"
              :options="mentorOptions"
              :multiple="true"
              label="name"
              track-by="id"
              placeholder="Chọn mentor"
              class="flex flex-wrap gap-2 p-3 bg-slate-50 rounded-lg min-h-[50px] border border-dashed border-slate-300"
            />
          </div>
          <!-- Interns -->
          <div class="space-y-3">
            <label class="text-sm font-semibold text-slate-700 flex items-center gap-2">
              <span class="material-symbols-outlined text-primary text-lg">group</span> Phân công thực tập sinh
            </label>
            <Multiselect
              v-model="selectedInterns"
              :options="internOptions"
              :multiple="true"
              label="name"
              track-by="id"
              placeholder="Chọn intern"
              class="flex flex-wrap gap-2 p-3 bg-slate-50 rounded-lg min-h-[50px] border border-dashed border-slate-300"
            />
          </div>
        </div>
      </div>
    </section>
    <!-- Form Actions -->
    <div class="flex items-center justify-end gap-4 pt-6">
      <button class="px-6 py-2.5 rounded-lg border border-slate-300 text-slate-700 font-semibold hover:bg-slate-100 transition-colors" type="button">
        Hủy bỏ
      </button>
      <button class="px-8 py-2.5 rounded-lg border border-slate-300 text-slate-700 font-bold shadow-lg hover:bg-slate-100 transition-all" type="submit">
        {{ isEdit ? "Cập nhật" : "Tạo mới" }}
      </button>
    </div>
  </form>
</template>

<style scoped>

</style>
