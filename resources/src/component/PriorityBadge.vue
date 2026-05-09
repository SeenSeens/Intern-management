<script setup>
import {computed} from "vue"

const props = defineProps({
  priority: String
});

const config = {
  low: {
    label: 'Thấp',
    class: '',
    icon: 'keyboard_arrow_down',
    class_icon: 'text-slate-400'
  },
  medium: {
    label: 'Trung bình',
    class: '',
    icon: 'keyboard_arrow_up',
    class_icon: 'text-orange-500'
  },
  high: {
    label: 'Cao',
    class: '',
    icon: 'keyboard_double_arrow_up',
    class_icon: 'text-error'
  },
  critical: {
    label: 'Khẩn cấp',
    class: '',
    icon: '',
    class_icon: ''
  },
};

const badgeClass = computed(() => {
  const base = 'text-sm font-medium text-on-surface';
  return `${base} ${config[props.priority]?.class}`;
});

const label = computed(() => config[props.priority]?.label || props.priority);

const badgeClassIcon = computed(() => {
  const base = 'material-symbols-outlined text-[18px]';
  return `${base} ${config[props.priority]?.class_icon}`;
});

const icon = computed(() => config[props.priority]?.icon || props.icon);
</script>

<template>
  <span :class="badgeClassIcon" data-icon="{{ icon }}" data-weight="fill" style="font-variation-settings: 'FILL' 1;">{{ icon }}</span>
  <span :class="badgeClass">
    <slot>{{ label }}</slot>
  </span>
</template>

<style scoped>

</style>
