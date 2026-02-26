
# Phân tích nghiệp vụ dự án quản lý thực tập sinh

## 1. Mục tiêu hệ thống
Quản lý toàn bộ vòng đời của một thực tập sinh:
**Tuyển chọn → Tiếp nhận → Theo dõi tiến độ → Đánh giá → Kết thúc → Lưu trữ**
Mục tiêu cụ thể:
- Lưu trữ thông tin hồ sơ thực tập sinh
- Quản lý quá trình thực tập: nhiệm vụ, tiến độ, báo cáo
- Hỗ trợ phân công người hướng dẫn
- Ghi nhận đánh giá & kết quả thực tập
- Tìm kiếm, lọc, và xuất báo cáo nhanh chóng

## 2. Đối tượng
| Đối tượng                   | Vai trò                                                     |
|-----------------------------|-------------------------------------------------------------|
| **Thực tập sinh**           | Người thực tập, cung cấp thông tin, nộp báo cáo             |
| **Người hướng dẫn**         | Quản lý trực tiếp thực tập sinh, đánh giá                   |
| **Quản trị viên**           | Quản lý toàn bộ hệ thống, duyệt thực tập sinh, xuất báo cáo |
| **Phòng nhân sự / giáo vụ** | Theo dõi tiến độ, liên hệ với trường học, đánh giá tổng thể |

## 3. Chức năng

### A. Quản lý hồ sơ thực tập sinh
- Tạo mới, cập nhật thông tin cá nhân
- Nhập các trường: trường học, chuyên ngành, số điện thoại, email
- Upload CV, giấy giới thiệu, CMND/CCCD
- Gắn thực tập sinh với người hướng dẫn (mentor)
---

### B. Theo dõi quá trình thực tập
- Lưu trữ ngày bắt đầu – ngày kết thúc
- Ghi nhận vị trí thực tập và nhiệm vụ được giao
- Theo dõi nhật ký công việc theo tuần hoặc tháng
- Ghi lại tiến độ và mức độ hoàn thành
---

### C. Đánh giá kết thúc
- Người hướng dẫn đánh giá năng lực và thái độ
- Phòng nhân sự đánh giá tổng thể toàn khóa thực tập
- Nhập điểm số, xếp loại kết quả (ví dụ: Xuất sắc, Tốt, Trung bình)
- Ghi chú đề xuất (ví dụ: đề xuất tuyển dụng sau thực tập)
---

### D. Tìm kiếm – lọc – phân loại
- Lọc theo trạng thái: `đang thực tập`, `đã hoàn thành`, `đã hủy`
- Tìm kiếm theo tên, email, chuyên ngành, trường học
- Phân loại theo thời gian, mentor, vị trí thực tập
- Xuất dữ liệu thực tập sinh ra file Excel hoặc PDF
---

### E. Thông báo & tương tác
- Gửi email nhắc nộp báo cáo đúng hạn
- Lên lịch hẹn với người hướng dẫn
- Thông báo thay đổi kế hoạch hoặc nhiệm vụ
---
## 4. Phân quyền người dùng (Roles)

### Mục tiêu
Phân chia quyền truy cập theo vai trò để đảm bảo bảo mật, giới hạn chức năng phù hợp từng nhóm người dùng trong hệ thống quản lý thực tập sinh.
---
### Bảng phân quyền
| Role                | Quyền truy cập & hành động chính                                                                                                                                                        |
|---------------------|-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| **Project Manager** | - Xem toàn bộ thực tập sinh (không giới hạn mentor)<br>- Gán/chỉnh sửa dự án thực tập<br>- Theo dõi nhật ký tiến độ<br>- Gửi đánh giá tổng quan về dự án<br>- Góp ý vào báo cáo tiến độ |
| **HR**              | - Xem danh sách thực tập sinh<br>- Phân công mentor<br>- Đánh giá tổng kết<br>- Theo dõi nhật ký                                                                                        |
| **Mentor**          | - Chỉ xem các thực tập sinh được phân công<br>- Ghi nhận xét, đánh giá tiến độ                                                                                                          |
| **Intern**          | - Ghi nhật ký thực tập<br>- Xem tiến độ thực tập<br>- Tải tài liệu, báo cáo liên quan                                                                                                   |

---
### Phân quyền chi tiết với Capabilities
Trong WordPress, mỗi role có một tập hợp các capabilities (năng lực) xác định những gì người dùng có thể làm. Khi xây dựng plugin quản lý thực tập sinh, nên tạo **các capabilities tùy chỉnh** để kiểm soát hành vi theo chức năng.
---

### Gợi ý capabilities cần có
| Capability                | Ý nghĩa                                                                    |
|---------------------------|----------------------------------------------------------------------------|
| `read_intern`             | - Xem thông tin một thực tập sinh                                          |
| `edit_intern`             | - Sửa thông tin một thực tập sinh                                          |
| `delete_intern`           | - Xóa hồ sơ thực tập sinh                                                  |
| `publish_interns`         | - Xuất bản (kích hoạt) thực tập sinh (nếu dùng CPT)                        |
| `read_private_interns`    | - Xem danh sách thực tập sinh nội bộ (chưa công khai)                      |
| `evaluate_interns`        | - Thực hiện đánh giá cho thực tập sinh (mentor, HR, PM)                    |
| `view_assigned_interns`   | - Mentor chỉ được xem thực tập sinh do mình phụ trách                      |
| `manage_intern_settings`  | - Truy cập phần cấu hình hệ thống plugin quản lý thực tập sinh (chỉ admin) |
| `edit_others_interns`     | - Sửa thực tập sinh do người khác tạo (dành cho HR/PM)                     |
| `view_all_interns`        | - Xem toàn bộ danh sách intern (HR & PM)                                   |
| `edit_intern_projects`    | - Gán hoặc sửa dự án cho thực tập sinh (PM)                                |
| `assign_mentor`           | - Phân công mentor cho intern (HR, PM)                                     |
| `review_progress_reports` | - Xem nhật ký thực tập, báo cáo tiến độ                                    |
| `comment_on_progress`     | - Gửi nhận xét vào báo cáo thực tập sinh (collaborative feedback)          |
| `submit_log`              | - Intern gửi nhật ký thực tập (frontend hoặc dashboard)                    |
| `view_own_progress`       | - Intern xem tiến độ của chính mình                                        |
| `download_training_docs`	 | - Intern tải các tài liệu liên quan                                        |
| `export_interns`	         | - HR xuất báo cáo/danh sách thực tập sinh                                  |
| `access_project_menu`     | - Quyền truy cập menu Dự án                                                |
---

### Bảng phân quyền theo từng vai trò
| `Capability`              | `intern` | `mentor` | `hr` | `project_manager` | `administrator` |
|---------------------------|:--------:|:--------:|:----:|:-----------------:|:---------------:|
| `read_intern`             |          |    ✅     |  ✅   |         ✅         |        ✅        |
| `edit_intern`             |          |          |  ✅   |         ✅         |        ✅        |
| `delete_intern`           |          |          |  ✅   |         ✅         |        ✅        |
| `publish_interns`         |          |          |      |         ✅         |        ✅        |
| `read_private_interns`    |          |          |  ✅   |         ✅         |        ✅        |
| `evaluate_interns`        |          |    ✅     |  ✅   |         ✅         |        ✅        |
| `view_assigned_interns`   |          |    ✅     |  ✅   |         ✅         |        ✅        |
| `manage_intern_settings`  |          |          |  ✅   |         ✅         |        ✅        |
| `edit_others_interns`     |          |          |  ✅   |         ✅         |        ✅        |
| `view_all_interns`        |          |          |  ✅   |         ✅         |        ✅        |
| `edit_intern_projects`    |          |          |      |         ✅         |        ✅        |
| `assign_mentor`           |          |          |  ✅   |         ✅         |        ✅        |
| `review_progress_reports` |          |    ✅     |  ✅   |         ✅         |        ✅        |
| `comment_on_progress`     |          |    ✅     |  ✅   |         ✅         |        ✅        |
| `submit_log`              |    ✅     |          |      |                   |                 |
| `view_own_progress`       |    ✅     |    ✅     |  ✅   |         ✅         |        ✅        |
| `download_training_docs`  |    ✅     |    ✅     |  ✅   |         ✅         |        ✅        |
| `export_interns`          |          |          |  ✅   |         ✅         |        ✅        |
| `access_project_menu`     |          |          |      |                   |                 |

### Bảng capabilities theo từng Role
| Role            | Capabilities                                                                                                                                                               |
|-----------------|----------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| Project Manager | - Full                                                                                                                                                                     |
| HR              | - read_intern<br/> - edit_intern<br/> - delete_intern<br/> - evaluate_interns<br/> - edit_others_interns<br/> - view_all_interns<br/>- assign_mentor<br/> - export_interns |
| Mentor          | - view_assigned_interns<br/> - evaluate_interns<br/> - comment_on_progress                                                                                                 |
| Intern          | - submit_log<br/> - view_own_progress<br/> - download_training_docs                                                                                                        |


## Flow
| Layer          | Vai trò                                             |
|----------------|-----------------------------------------------------|
| **Menu**       | Giao diện, đăng ký menu                             |
| **Routes**     | Phân tích URL, gọi controller tương ứng             |
| **Controller** | Render view + gọi service                           |
| **Actions**    | Xử lý các hành động POST/GET                        |
| **Service**    | Chứa logic nghiệp vụ, xử lý dữ liệu, kiểm tra quyền |
| **Repository** | Làm việc trực tiếp với DB (`$wpdb`)                 |

admin_menu (Menu.php)
↓
routes
↓
controllers
↓
actions
↓
services
↓
repositories
