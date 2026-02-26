[//]: # (Đặc tả)
## Đặc tả
| Thành phần                       | Mô tả nghiệp vụ                                                                |
|----------------------------------|--------------------------------------------------------------------------------|
| **Dự án (`wp_intern_projects`)** | Mỗi dự án do 1 Project Manager tạo, có thể giao thêm 1 Mentor phụ trách        |
| **Thực tập sinh (`interns`)**    | Được gán vào các dự án thông qua bảng liên kết                                 |
| **Nhiệm vụ (`wp_intern_task`)**  | Là các task nhỏ trong 1 dự án, giao cho intern thực hiện, có mô tả và deadline |

[//]: # (Danh sách dự án)
## wp_intern_projects
| Cột           | Kiểu dữ liệu                                        | Mô tả                                                                    |
|---------------|-----------------------------------------------------|--------------------------------------------------------------------------|
| `id`          | BIGINT (PK)                                         | ID dự án                                                                 |
| `name`        | VARCHAR(255)                                        | Tên dự án                                                                |
| `description` | TEXT                                                | Mô tả dự án                                                              |
| `status`      | ENUM(`in_progress`,`waiting`,`on_hold`,`completed`) | Trạng thái (`đang triển khai`, `đang chờ`, `tạm dừng`, `hoàn thành`,...) |
| `manager_id`  | BIGINT                                              | user\_id của Project Manager                                             |
| `mentor_id`   | BIGINT NULL                                         | user\_id của Mentor phụ trách                                            |
| `created_at`  | DATETIME                                            | Ngày tạo                                                                 |
| `updated_at`  | DATETIME                                            | Cập nhật cuối cùng                                                       |

[//]: # (Bảng liên kết N-N: Dự án – Intern)
## wp_intern_project_interns - liên kết Intern với dự án
| Cột           | Kiểu dữ liệu | Mô tả                               |
|---------------|--------------|-------------------------------------|
| `id`          | BIGINT (PK)  |                                     |
| `project_id`  | BIGINT       | FK → `wp_intern_projects.id`        |
| `intern_id`   | BIGINT       | FK → `wp_users.ID` (vai trò intern) |
| `assigned_at` | DATETIME     | Ngày được gán vào dự án             |

[//]: # (Bảng nhiệm vụ thuộc dự án)
## wp_intern_task
| Cột                   | Kiểu dữ liệu         | Mô tả                                                  |
|-----------------------|----------------------|--------------------------------------------------------|
| `id`                  | BIGINT (PK)          | ID của nhiệm vụ                                        |
| `project_id`          | BIGINT               | FK → `wp_intern_projects.id`                           |
| `intern_id`           | BIGINT               | FK → `wp_users.ID`                                     |
| `title`               | VARCHAR(255)         | Tên nhiệm vụ                                           |
| `description`         | TEXT                 | Mô tả chi tiết nhiệm vụ                                |
| `status`              | ENUM(...)            | `Đã giao`, `Đang thực hiện`, `Hoàn thành`              |
| `deadline`            | DATETIME             | Hạn chót                                               |
| `priority`            |                      | Phân loại mức độ ưu tiên để sắp lịch                   |
| `start_date`	         | DATETIME	            | Thời điểm chính thức bắt đầu                           |
| `completed_at`	       | DATETIME NULL        | Ngày hoàn thành (hữu ích để đo KPI)                    |
| `progress_percent`	   | TINYINT(3) DEFAULT 0 | % hoàn thành (tùy chọn cập nhật tay hoặc tự động tính) |
| `created_by`          |                      | Người tạo task                                         |
| `created_at`          | DATETIME             | Ngày tạo                                               |
| `updated_at`          | DATETIME             | Ngày cập nhật                                          |


## wp_intern_task_details 

## wp_intern_task_assignees
