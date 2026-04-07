import { permissions } from "../../permissions.js"
import { useAuthStore } from "@/stores/authStore.js"

export function usePermission() {
  const auth = useAuthStore()
  const can = (perm) => {
    return auth.user.capabilities?.includes(perm)
  }
  return { can }
}
