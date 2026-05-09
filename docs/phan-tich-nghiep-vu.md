
# Phân tích nghiệp vụ dự án quản lý thực tập sinh

## 1. Mục tiêu hệ thống
Hệ thống tập trung vào việc **quản lý tiến độ, đánh giá năng lực và lưu trữ kết quả của thực tập sinh thông qua các dự án thực tế**.
Hệ thống **không** bao gồm quy trình tuyển chọn và tiếp nhận ban đầu.

### Scope:
**Project → Task → Progress → Evaluation → Report → Completion → Archive**

### Mục tiêu cụ thể:
- Quản lý danh sách dự án và nhân sự tham gia (Mentor, Intern)
- Theo dõi tiến độ công việc qua cấu trúc: Project -> Task -> Task Detail (Subtask)
- Quản lý hệ thống báo cáo đa dạng: Daily, Weekly, Monthly, Task, Project
- Tự động hóa quá trình tính điểm và tổng kết dự án
- Tối ưu hóa hiệu suất truy xuất dữ liệu bằng Custom Tables thay vì Custom Post Types

## 2. Đối tượng
| Đối tượng                 | Vai trò                                                                                                 |
|---------------------------|---------------------------------------------------------------------------------------------------------|
| **Admin/Project manager** | Tạo dự án tổng, phân công Mentor và Intern vào dự án, theo dõi tổng quan dự án.                         |
| **Mentor**                | Quản lý dự án được giao, theo dõi tiến độ Intern, đánh giá báo cáo và chấm điểm Task.                   |
| **Intern**                | Chủ động lên kế hoạch (tạo Task, Subtask), cập nhật tiến độ, nộp báo cáo định kỳ và báo cáo hoàn thành. |

## 3. Luồng nghiệp vụ cốt lõi (Workflow)

### A. Khởi tạo & Phân bổ
- Admin tạo mới một Dự án (Project) trên hệ thống.
- Admin chỉ định (assign) Mentor phụ trách và các Intern tham gia vào Dự án.
- Mentor đăng nhập, xem danh sách Dự án của mình và có quyền chỉ định thêm Intern vào Dự án (nếu được cấp quyền điều phối).

### B. Lập kế hoạch công việc
- Intern truy cập vào Dự án được phân công.
- Intern chủ động phân rã công việc bằng cách tạo các Task.
- Trong mỗi Task, Intern tiếp tục tạo chi tiết các Task Detail (Subtask) để định hình các bước thực hiện.

### C. Thực thi & Báo cáo
- Intern thực hiện công việc và đánh dấu hoàn thành (check) các Task Detail.
- Intern nộp các báo cáo định kỳ theo quy định: Daily Report, Weekly Report, Monthly Report.
- Khi toàn bộ Task Detail trong một Task được đánh dấu hoàn thành, Intern nộp Task Report.

### D. Đánh giá & Chấm điểm
- Mentor nhận được thông báo về Task Report của Intern.
- Mentor xem xét nội dung báo cáo, đối chiếu với mức độ hoàn thành các Task Detail.
- Mentor tiến hành chấm điểm cho Task đó.

### E. Tổng kết tự động
- Hệ thống tự động tính toán Điểm Dự Án (Project Score) của Intern dựa trên điểm số của các Task đã được Mentor chấm.
- Hệ thống xuất Báo cáo Dự án (Project Report) khi dự án kết thúc.
- Lưu trữ toàn bộ dữ liệu (Archived) phục vụ việc tra cứu sau này.
---
## 4. Phân quyền người dùng (Capabilities)
Hệ thống sử dụng Custom Capabilities để kiểm soát quyền hạn chính xác tới từng hành động.

| Role                      | Capabilities                                                                                                                                                                          |
|---------------------------|---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| **Admin/Project manager** | `create_project`, `edit_project`, `delete_project`, `assign_mentor`, `assign_intern`, `view_all_projects`, `view_all_reports`, `manage_settings`, `general_setting`, `system_setting` |
| **Mentor**                | `view_assigned_projects`, `assign_intern_to_project`, `view_intern_tasks`, `grade_tasks`, `review_reports`                                                                            |
| **Intern**                | `view_own_projects`, `create_tasks`, `create_task_details`, `update_task_status`, `submit_reports`                                                                                    |

## 5. Cấu trúc Backend (Layered Architecture)
Hệ thống tuân thủ mô hình phân lớp rành mạch để dễ dàng nâng cấp, bảo trì và cung cấp dữ liệu sạch cho Frontend.

| Tầng (Layer)     | Trách nhiệm                                                                              |
|:-----------------|:-----------------------------------------------------------------------------------------|