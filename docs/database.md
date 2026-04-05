[//]: # (Đặc tả)
## Đặc tả
| Thành phần                       | Mô tả nghiệp vụ                                                                |
|----------------------------------|--------------------------------------------------------------------------------|
| **Dự án (`wp_intern_projects`)** | Mỗi dự án do 1 Project Manager tạo                                             |
| **Thực tập sinh (`interns`)**    | Được gán vào các dự án thông qua bảng liên kết                                 |
| **Thực tập sinh (`mentors`)**    | Được gán vào các dự án thông qua bảng liên kết                                 |
| **Nhiệm vụ (`wp_intern_task`)**  | Là các task nhỏ trong 1 dự án, giao cho intern thực hiện, có mô tả và deadline |

[//]: # (Bảng Project)
## wp_intern_projects
| Cột           | Kiểu dữ liệu                                        | Mô tả                                                                    |
|---------------|-----------------------------------------------------|--------------------------------------------------------------------------|
| `id`          | BIGINT (PK)                                         | ID dự án                                                                 |
| `name`        | VARCHAR(255)                                        | Tên dự án                                                                |
| `description` | TEXT                                                | Mô tả dự án                                                              |
| `status`      | ENUM(`in_progress`,`waiting`,`on_hold`,`completed`) | Trạng thái (`đang triển khai`, `đang chờ`, `tạm dừng`, `hoàn thành`,...) |
| `manager_id`  | BIGINT                                              | user_id của Project Manager                                              |
| `start_date`  | DATE                                                | Ngày bắt đầu dự án                                                       |
| `end_date`    | DATE                                                | Ngày kết thúc dự án                                                      |
| `created_at`  | DATETIME                                            | Ngày tạo                                                                 |
| `updated_at`  | DATETIME                                            | Cập nhật cuối cùng                                                       |
| `deleted_at`  | DATETIME                                            | Ngày xóa                                                                 |

[//]: # (Bảng liên kết N-N: Project – Intern)
## wp_intern_project_interns - liên kết Intern với dự án
| Cột           | Kiểu dữ liệu | Mô tả                               |
|---------------|--------------|-------------------------------------|
| `id`          | BIGINT (PK)  |                                     |
| `project_id`  | BIGINT       | FK → `wp_intern_projects.id`        |
| `intern_id`   | BIGINT       | FK → `wp_users.ID` (vai trò intern) |
| `assigned_by` | BIGINT       | FK → `wp_users.ID`                  |
| `created_at`  | DATETIME     | Ngày tạo                            |
| `updated_at`  | DATETIME     | Cập nhật cuối cùng                  |
| `deleted_at`  | DATETIME     | Ngày xóa                            |

[//]: # (Bảng liên kết N-N: Project – Mentor)
## wp_intern_project_mentors - liên kết Mentor với dự án
| Cột           | Kiểu dữ liệu | Mô tả                               |
|---------------|--------------|-------------------------------------|
| `id`          | BIGINT (PK)  |                                     |
| `project_id`  | BIGINT       | FK → `wp_intern_projects.id`        |
| `mentor_id`   | BIGINT       | FK → `wp_users.ID` (vai trò mentor) |
| `assigned_by` | BIGINT       | FK → `wp_users.ID`                  |
| `created_at`  | DATETIME     | Ngày tạo                            |
| `updated_at`  | DATETIME     | Cập nhật cuối cùng                  |
| `deleted_at`  | DATETIME     | Ngày xóa                            |

[//]: # (Bảng Task)
## wp_intern_task
| Cột           | Kiểu dữ liệu                                | Mô tả                                                                        |
|---------------|---------------------------------------------|------------------------------------------------------------------------------|
| `id`          | BIGINT (PK)                                 | ID của nhiệm vụ                                                              |
| `project_id`  | BIGINT                                      | FK → `wp_intern_projects.id`                                                 |
| `title`       | VARCHAR(255)                                | Tên nhiệm vụ                                                                 |
| `description` | TEXT                                        | Mô tả chi tiết nhiệm vụ                                                      |
| `priority`    | ENUM(`low`, `medium`, `high`, `critical`)   | Phân loại mức độ ưu tiên để sắp lịch `Thấp`, `Trung bình`, `Cao`, `Khẩn cấp` |
| `max_score`   | INT                                         | Điểm tối đa                                                                  |
| `assigned_by` | BIGINT                                      |                                                                              |
| `status`      | ENUM(`pending`, `in_progress`, `completed`) | Trạng thái `Đã giao`, `Đang thực hiện`, `Hoàn thành`                         |
| `start_date`  | DATETIME                                    | Thời điểm chính thức bắt đầu                                                 |
| `end_date`    | DATE                                        | Thời điểm kết thúc                                                           |
| `created_at`  | DATETIME                                    | Ngày tạo                                                                     |
| `updated_at`  | DATETIME                                    | Ngày cập nhật                                                                |
| `deleted_at`  | DATETIME                                    | Ngày xóa                                                                     |

[//]: # (Bảng liên kết: Task - Intern)
## wp_intern_task_assignees
| Cột          | Kiểu dữ liệu | Mô tả                               |
|--------------|--------------|-------------------------------------|
| `id`         | BIGINT       |                                     |
| `task_id`    | BIGINT       |                                     |
| `user_id`    | BIGINT       | FK → `wp_users.ID` (vai trò intern) |
| `created_at` | DATETIME     | Ngày tạo                            |
| `updated_at` | DATETIME     | Ngày cập nhật                       |
| `deleted_at` | DATETIME     | Ngày xóa                            |

[//]: # (Bảng task details: Chi tiết task - Đây là bảng subtask - Intern tự thêm subtask)
## wp_intern_task_details
| Cột           | Kiểu dữ liệu                               | Mô tả                                                     |
|---------------|--------------------------------------------|-----------------------------------------------------------|
| `id`          | BIGINT                                     |                                                           |
| `task_id`     | BIGINT                                     | FK → `wp_intern_task.id`                                  |
| `title`       | VARCHAR(255)                               | Tiêu đề                                                   |
| `description` | TEXT                                       | Mô tả                                                     |
| `created_at`  | DATETIME                                   | Ngày tạo                                                  |
| `status`      | ENUM(`pending`, `in_progress`, `completed` | Trạng thái (`Chờ xử lý`, `Đang triển khai`, `Hoàn thành`) |
| `created_by`  | BIGINT                                     | FK → `wp_users.ID` (vai trò intern) - Intern đã assignees |
| `created_at`  | DATETIME                                   | Ngày tạo                                                  |
| `updated_at`  | DATETIME                                   | Ngày cập nhật                                             |
| `deleted_at`  | DATETIME                                   | Ngày xóa                                                  |

[//]: # (Bảng reports: Bảng báo cáo - Intern tiến hành nộp báo cáo khi hoàn thành tất cả các subtask)
## wp_intern_reports
| Cột           | Kiểu dữ liệu                                          | Mô tả                                                     |
|---------------|-------------------------------------------------------|-----------------------------------------------------------|
| `id`          | BIGINT                                                |                                                           |
| `project_id`  | BIGINT                                                | FK → `wp_intern_projects.id`                              |
| `task_id`     | BIGINT                                                | FK → `wp_intern_task.id`                                  |
| `intern_id`   | BIGINT                                                | FK → `wp_users.ID` (vai trò intern)                       |
| `report_type` | ENUM(`daily`, `weekly`, `monthly`, `task`, `project`  | Loại báo cáo (`Ngày`, `Tuần`, `Tháng`, `Task`, `Project`) |
| `title`       | VARCHAR(255)                                          | Tiêu đề                                                   |
| `content`     | TEXT                                                  | Nội dung                                                  |
| `progress`    | INT                                                   | Tiến độ                                                   |
| `report_date` | DATE                                                  | Ngày báo cáo                                              |
| `week_number` | INT                                                   | Tuần số                                                   |
| `month`       | INT                                                   |                                                           |
| `year`        | INT                                                   |                                                           |
| `status`      | ENUM(`submitted`, `reviewed`, `approved`, `rejected`) | Trạng thái (`Đã gửi`, `Xem xét`, `Tán thành`, `Từ chối`)  |
| `reviewed_by` | BIGING                                                | FK → `wp_users.ID` (Người đánh giá)                       |
| `created_at`  | DATETIME                                              | Ngày tạo                                                  |
| `updated_at`  | DATETIME                                              | Ngày cập nhật                                             |
| `deleted_at`  | DATETIME                                              | Ngày xóa                                                  |

[//]: # (Bảng scores: Bảng điểm - Bảng điểm này tính dựa trên mức độ hoàn thành subtask - Intern phải nộp báo cáo task thì mới tiến hành chấm điểm)
## wp_intern_task_scores
| Cột            | Kiểu dữ liệu | Mô tả                                 |
|----------------|--------------|---------------------------------------|
| `id`           | BIGINT       |                                       |
| `intern_id`    | BIGINT       | FK → `wp_users.ID` (vai trò intern)   |
| `task_id`      | BIGINT       | FK → `wp_intern_task.id`              |
| `score`        | INT          | Điểm                                  |
| `evaluated_by` | BIGINT       | FK → `wp_users.ID` (Mentor chấm điểm) |
| `comment`      | TEXT         | Bình luận                             |
| `created_at`   | DATETIME     | Ngày tạo                              |