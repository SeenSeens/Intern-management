import BaseService from "@/services/BaseService";
import api from "../../api.js";

class ProjectService extends BaseService {

  constructor() {
    super("projects");
  }

  // Custom method riêng cho intern
  getByStatus(status) {
    return this.getAll({ status });
  }
}

export default new ProjectService();
