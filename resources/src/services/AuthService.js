import api from "@/utils/api.js"
import axios from "axios"
export default new class AuthService {
  async login(username, password){
    const res = await api.post(`/intern/v1/login`, { username, password })
    // Bắt lỗi nếu API trả về success là false
    if (!res.data.success) {
      throw new Error(res.data.error || res.data.message || 'Login failed')
    }
    const { access_token, refresh_token, user } = res.data.data
    return { user, access_token, refresh_token }
  }
  async meJWT(){
    return await api.get(`/intern/v1/me`)
  }
  async meWP(){
    return await api.get(`/wp/v2/users/me`)
  }
}
