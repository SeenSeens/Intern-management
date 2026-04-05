import api from '@/utils/api.js'
class BaseService {
  constructor(resource) {
    this.resource = `/intern/v1/${resource}`
  }
  getAll(params = {}) {
    return api.get(this.resource, { params })
  }
  getById(id) {
    return api.get(`${this.resource}/${id}`)
  }
  create(data) {
    return api.post(this.resource, data)
  }
  update(id, data) {
    return api.put(`${this.resource}/${id}`, data)
  }
  delete(id) {
    return api.delete(`${this.resource}/${id}`)
  }
  get(path = '') {
    return api.get(`${this.resource}${path}`)
  }
  post(path = '', data = {}) {
    return api.post(`${this.resource}${path}`, data)
  }
}
export default BaseService
