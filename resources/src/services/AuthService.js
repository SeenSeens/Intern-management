import api from "../../api.js";
import axios from "axios";
export default new class AuthService {
  async login(username, password){
    try {
      await api.post(`/intern/v1/login`, { username, password })
    } catch (e){
      const form = new FormData()
      form.append('log', username)
      form.append('pwd', password)
      form.append('rememberme', 'forever')

      await axios.post(`/wp-login.php`, form, {
        withCredentials: true,
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      })
    }
    return this.me()
  }
  async me(){
    return await api.get('/wp/v2/users/me')
  }
}
