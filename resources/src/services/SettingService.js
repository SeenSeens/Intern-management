import BaseService from "@/services/BaseService";
class SettingService extends BaseService {
  constructor() {
    super('settings')
  }
  /* ===== GENERAL ===== */
  getGeneral() {
    return this.get('/general')
  }
  updateGeneral(data) {
    return this.post('/general', data)
  }
  /* ===== NOTIFICATION ===== */
  getNotifications() {
    return this.get('/notifications')
  }
  updateNotifications(data) {
    return this.post('/notifications', data)
  }
  /* ===== SYSTEM ===== */
  getSystem() {
    return this.get('/system')
  }
  updateSystem(data) {
    return this.post('/system', data)
  }
}
export default new SettingService()
