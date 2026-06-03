import {defineStore} from "pinia";
import {markRaw} from "vue";
export const useModalStore = defineStore('modal', {
  state: () => ({
    isOpen: false,
    component: null,
    props: {},
    resolve: null
  }),
  actions: {
    open(component, props = {}) {
      this.isOpen = true
      this.component = markRaw(component)
      this.props = props
      return new Promise((resolve) => {
        this.resolve = resolve
      })
    },
    close(result = null) {
      this.isOpen = false
      if (this.resolve) {
        this.resolve(result)
      }
      this.component = null
      this.props = {}
      this.resolve = null
    }
  }
})
