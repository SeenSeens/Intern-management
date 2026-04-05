import Toastify from "toastify-js"
import "toastify-js/src/toastify.css"

const baseConfig = {
  duration: 3000,
  close: true,
  gravity: "top",
  position: "right",
  stopOnFocus: true
}

export const toastSuccess = (text) => {
  Toastify({
    ...baseConfig,
    text,
    style: {
      background: "linear-gradient(to right, #00b09b, #96c93d)"
    }
  }).showToast()
}

export const toastError = (text) => {
  Toastify({
    ...baseConfig,
    text,
    style: {
      background: "linear-gradient(to right, #ff5f6d, #ffc371)"
    }
  }).showToast()
}

export const toastWarning = (text) => {
  Toastify({
    ...baseConfig,
    text,
    style: {
      background: "linear-gradient(to right, #f7971e, #ffd200)"
    }
  }).showToast()
}
