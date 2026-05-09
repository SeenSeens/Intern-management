import api from "@/utils/api.js"

class ProfileService {
  constructor() {
    this.resource = `/intern/v1`
  }
  getMe() {
    return api.get(`${this.resource}/me`)
  }

  updateMe(data) {
    return api.put(`${this.resource}/me`, data)
  }
}

export default new ProfileService()
