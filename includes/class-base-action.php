<?php
namespace InternManagement\Includes;
use BadMethodCallException;
use Exception;
use RuntimeException;
use WP_REST_Response;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class Action
 * - Tự động khởi tạo Service tương ứng nếu có.
 * - Cung cấp quy trình: authorize() → validate() → handle() → respond()
 * - Cung cấp hàm tiện ích save(), delete(), success(), error()
 *
 * Cập nhật:
 * - sanitize() bỏ qua các field trong $allow_html và dùng wp_kses_post() để giữ HTML an toàn.
 * - sanitize() hỗ trợ đệ quy cho mảng.
 * - get() trả lại giá trị đã được sanitize; nếu là mảng sẽ nối thành chuỗi.
 */

abstract class Action {
    protected mixed $service;
    protected array $input = [];

    /**
     * Danh sách các field được phép chứa HTML
     * Các field này sẽ không bị sanitize_text_field() mà được xử lý bằng wp_kses_post()
     */
    protected array $allow_html = [];

    public function __construct($service = null) {
        if ($service) {
            $this->service = $service;
        } else {
            $serviceClass = str_replace(array('Action', 'Actions'), array('Service', 'Services'), get_class($this));
            if (class_exists($serviceClass)) {
                $this->service = new $serviceClass();
            } else {
                throw new RuntimeException("Service class {$serviceClass} not found");
            }
        }
    }

    /**
     * Thực thi action với dữ liệu đầu vào
     */
    final public function execute(array $input = [], bool $return = false): ?array{
        $this->input = $this->sanitize($input);
        try {
            if (!$this->authorize()) {
                return $this->respond([
                    'error' => 'Unauthorized',
                    'success' => false,
                    $this->error('Bạn không có quyền thực hiện hành động này.')
                ], 403, $return);
            }
            $errors = $this->validate();
            if (!empty($errors)) {
                return $this->respond([
                    'error' => 'Invalid data',
                    'success' => false,
                    'details' => $errors,
                    $this->error('Dữ liệu không hợp lệ.')
                ], 422, $return);
            }
            $result = $this->handle();
            if ($return) {
                return $this->respond( [
                    'success' => true,
                    'message' => is_string($result) ? $result : 'Thực hiện thành công.',
                    'data' => $result
                ], 200, $return);
            }
            return $this->success($result);

        } catch (Exception $e) {
            return $return
                ? ['error' => $e->getMessage()]
                : $this->error($e->getMessage(), 500);
        }
    }

    /**
     * Kiểm tra quyền - override nếu cần
     */
    protected function authorize(): bool {
        return current_user_can('manage_options');
    }

    /**
     * Kiểm tra dữ liệu đầu vào - override nếu cần
     * @return array Mảng lỗi dạng ['field' => 'message']
     */
    protected function validate(): array {
        return [];
    }

    /**
     * Logic chính của action - override bắt buộc
     */
    abstract protected function handle();

    /**
     * Lưu dữ liệu (tạo mới hoặc cập nhật nếu có id)
     */
    public function save(array $data): int|string{
        if (!isset($this->service)) {
            throw new RuntimeException("Service chưa được gán trong " . static::class);
        }
        if (!empty($data['id'])) {
            if (!method_exists($this->service, 'update')) {
                throw new BadMethodCallException('Service không có method update');
            }
            $result = $this->service->update($data['id'], $data);
            return $data['id'];
        }
        if (!method_exists($this->service, 'create')) {
            throw new BadMethodCallException('Service không có method create');
        }
        return $this->service->create($data);
    }

    /**
     * Delete record theo ID
     */
    protected function delete(int $id): bool {
        if (!$this->service) {
            throw new RuntimeException("Service chưa được gán trong " . static::class);
        }
        if (!method_exists($this->service, 'delete')) {
            throw new BadMethodCallException('Service không có method delete');
        }
        return (bool) $this->service->delete($id);
    }

    /**
     * Chuẩn hóa input
     * - Các field nằm trong $allow_html được xử lý bằng wp_kses_post() (giữ HTML an toàn).
     * - Các field khác dùng sanitize_text_field().
     * - Hỗ trợ giá trị là mảng (đệ quy).
     */
    protected function sanitize(array $data): array {
        $clean = [];
        foreach ($data as $key => $value) {
            $clean[$key] = $this->sanitize_value($key, $value);
        }
        return $clean;
    }

    /**
     * Sanitize một giá trị theo key (hỗ trợ đệ quy nếu là mảng)
     */
    protected function sanitize_value(string $key, $value) {
        if (is_string($value)) {
            $value = wp_unslash($value);
        }
        if (is_array($value)) {
            $out = [];
            foreach ($value as $k => $v) {
                $out[$k] = $this->sanitize_value($key, $v);
            }
            return $out;
        }
        if (in_array($key, $this->allow_html, true) && is_string($value)) {
            return wp_kses_post($value);
        }
        if (is_string($value)) {
            return sanitize_text_field($value);
        }
        return $value;
    }

    /**
     * Lấy giá trị input an toàn (hỗ trợ cả chuỗi và mảng)
     * Nếu là mảng → nối thành chuỗi bằng dấu phẩy
     * @param string $key Tên trường cần lấy
     * @param mixed $default Giá trị mặc định nếu không có
     * @return mixed Chuỗi đã sanitize, hoặc mảng sanitize, hoặc giá trị mặc định
     */
    protected function get(string $key, mixed $default = null): mixed{
        if (!array_key_exists($key, $this->input)) {
            return $default;
        }
        $value = $this->input[$key];
        if (is_array($value)) {
            $all_scalar = true;
            foreach ($value as $v) {
                if (is_array($v)) {
                    $all_scalar = false;
                    break;
                }
            }
            if ($all_scalar) {
                return implode(', ', array_filter($value, function($v){ return $v !== ''; }));
            }
            return $value;
        }
        return $value;
    }

    /**
     * Trả JSON thành công
     */
    protected function success($data = [], int $status = 200): WP_REST_Response|array|null{
        return $this->respond([
            'success' => true,
            'data'    => $data
        ], $status);
    }

    /**
     * Trả JSON lỗi
     */
    protected function error(string $message, int $status = 400, array $errors = []): WP_REST_Response|array|null{
        return $this->respond([
            'success' => false,
            'message' => $message,
            'errors'  => $errors
        ], $status);
    }

    protected function request_type(): string{
        if (defined('REST_REQUEST') && REST_REQUEST) {
            return 'rest';
        }
        if (wp_doing_ajax()) {
            return 'ajax';
        }
        return 'http';
    }

    protected function respond(array $data, int $status = 200, bool $return = false){
        if ($return) {
            return $data;
        }
        switch ($this->request_type()) {
            case 'rest':
                return new WP_REST_Response($data, $status);
                break;
            case 'ajax':
                wp_send_json($data, $status);
                break;
            case 'http':
                break;
            default:
                return $data;
        }
    }
}