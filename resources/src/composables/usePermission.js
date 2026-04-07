import { permissions } from "../../permissions.js"
import { useAuthStore } from "@/stores/authStore.js"

export function usePermission() {
  const authStore = useAuthStore();

  const hasRole = (allowedRoles) => {
    return permissions[authStore.user.role]?.includes(allowedRoles)
  };

  return { hasRole };
}
