import BaseService from "@/services/BaseService.js";
import api from "../../api.js";

export default new class UserService extends BaseService {
  constructor() {
    super('users');
  }
  getUsersByRole(){
    return api.get(`${this.resource}/users_by_role`);
  }
  countUsersByRole(){
    return api.get(`${this.resource}/count`);
  }
}


