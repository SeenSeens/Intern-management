<script setup>
import BaseModal from "@/component/BaseModal.vue";
import {useModalStore} from "@/stores/modalStore.js";
import {ref} from "vue";
const modalStore = useModalStore()
const props = defineProps({
  interns: Array,
  currentInternId: Number
})
const selectedInternId = ref(props.currentInternId ?? null)
const submit = () => {
  if (!selectedInternId.value) {
    alert("Vui lòng chọn thực tập sinh")
    return
  }
  modalStore.close({
    intern_id: selectedInternId.value
  })
}
</script>
<template>
    <BaseModal @close="modalStore.close()">
      <template #header>
        <h3 class="text-lg font-semibold text-center">Phân công lại thành viên</h3>
      </template>
      <template #body>
        <div class="space-y-3">
          <p class="text-sm font-semibold text-center text-slate-600">Vui lòng chọn 1 thực tập sinh mới để thực hiện nhiệm vụ này.</p>
          <label class="text-sm font-semibold text-slate-700 flex items-center gap-2">
            <span class="material-symbols-outlined text-primary text-lg">person</span> Người thực hiện
          </label>
          <select v-model="selectedInternId" class="w-full flex flex-wrap gap-2 p-3 bg-slate-50 rounded-lg border border-dashed border-slate-300">
            <option value="" disabled>Chọn thực tập sinh...</option>
            <option v-for="intern in interns"
                    :key="intern.id"
                    :value="intern.id"
            >
              {{ intern.name }}
            </option>
          </select>
        </div>
      </template>
      <template #footer>
        <button
          @click="modalStore.close()"
          class="rounded-lg border px-4 py-1.5 bg-gray-200 text-sm font-bold text-gray-700 transition-colors hover:bg-gray-300"
        >
          Hủy
        </button>
        <button
          @click="submit"
          class="rounded-lg bg-blue-500 px-4 py-1.5 text-sm font-bold text-white transition-colors hover:bg-blue-600"
        >
          Xác nhận
        </button>
      </template>
    </BaseModal>
</template>
