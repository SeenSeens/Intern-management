# Intern Management - Coding Conventions

Dự án này tuân thủ các tiêu chuẩn nghiêm ngặt để đảm bảo khả năng mở rộng (Scalability) và dễ bảo trì (Maintainability).

---

## 1. PHP (WordPress Backend)
### 1.1 Quy tắc đặt tên (Naming)
| Thành phần       | Quy tắc                        | Ví dụ                                       |
|------------------|--------------------------------|---------------------------------------------|
| Namespace        | PascalCase                     | `namespace InternManagement\Admin;`         |
| Class Name       | PascalCase                     | `class InternController { ... }`            |
| Method Name      | snake_case                     | `public function get_intern_list() { ... }` |
| Class Property   | snake_case                     | `private $db_connection;`                   |
| Private Property | _snake_case (có dấu gạch dưới) | `private $_is_authenticated;`               |
| Local Variable   | snake_case                     | `$intern_id = 10;`                          |
| Class Constant   | SCREAMING_SNAKE_CASE           | `const STATUS_ACTIVE = 1;`                  |

### 1.2 WordPress Hooks
- Luôn sử dụng mảng để gọi callback từ Class:
`add_action('init', [$this, 'init_function']);`

- Tên Hook (Action/Filter) tự tạo: im_ + snake_case.
`do_action('im_after_intern_saved', $id);`

## 2. Js ( Vue Frontend)
### 2.1 Quy tắc đặt tên (Naming)
| Thành phần          | Quy tắc                | Ví dụ                                                    |
|---------------------|------------------------|----------------------------------------------------------|
| ComponentFile       | `PascalCase`           | `InternList.vue`, `AttendanceChart.vue`                  |
| Variable / Function | `camelCase`            | `const internData = ref([]);`, `function fetchData() {}` |
| Props               | `camelCase`            | `props: { internId: Number }`                            |
| Constants           | `SCREAMING_SNAKE_CASE` | `const API_URL = '...';`                                 |

### 2.2 Quy tắc Vue.js
- **Template**: Sử dụng `kebab-case` cho component trong template: <intern-list />.
- **Emit**: Luôn khai báo rõ ràng: const emit = defineEmits(['update-list']).
- **Styles**: Sử dụng <style scoped> để tránh ảnh hưởng đến giao diện chung của WordPress Admin.

## 3. Database & API
### 3.1 Database (MySQL)
- **Table Name**: wp_intern_ + snake_case (Ví dụ: wp_intern_attendance).
- **Column Name**: snake_case (Ví dụ: first_name, created_at).

### 3.2 REST API (WP REST API)
- **Namespace**: `im/v1`
- **Route**: kebab-case (Ví dụ: wp-json/intern/update-intern-status).
- **Dữ liệu JSON**: PHP gửi snake_case, Vue nhận và có thể sử dụng trực tiếp hoặc map lại.