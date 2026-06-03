<script setup>
const props = defineProps({
  title: String
})
const emit = defineEmits(['close'])
const closeModal = () => {
  emit('close')
}
</script>
<template>
  <Teleport to="body">
    <Transition name="modal"
                enter-active-class="transition duration-300 ease-out"
                enter-from-class="opacity-0 scale-110"
                enter-to-class="opacity-100 scale-100"
                leave-active-class="transition duration-300 ease-in"
                leave-from-class="opacity-100 scale-100"
                leave-to-class="opacity-0 scale-110"
    >
      <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4 bg-opacity-50" @click.self="closeModal">
        <div class="w-full max-w-lg rounded-lg bg-white shadow-xl transition-all">
          <div class="text-lg font-bold text-emerald-500 border-b p-4">
            <slot name="header"/>
          </div>
          <div class="text-gray-600 p-4">
            <slot name="body"/>
          </div>
          <div class="flex justify-end gap-2 border-t p-4">
            <slot name="footer"/>
          </div>
        </div>
      </div>
    </Transition>
  </Teleport>
</template>
