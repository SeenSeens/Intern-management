import { ref } from "vue";

const darkMode = ref(false);

export function useDarkMode() {
  const toggle = () => {
    darkMode.value = !darkMode.value;
    document.documentElement.classList.toggle("dark");
  };

  return { darkMode, toggle };
}
