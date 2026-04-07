<?php
namespace InternManagement\Core;
use WP_REST_Request;
use WP_REST_Response;
use WP_Error;
if ( ! defined( 'ABSPATH' ) ) exit;
abstract class ApiController{
    /**
     * Namespace API (versioning)
     * @var string
     */
    protected string $namespace = 'intern/v1';
    /**
     * Tự động đăng ký route khi khởi tạo
     */
    public function __construct(){
        add_action('rest_api_init', function () {
            $this->register_routes();
        });
    }
    /**
     * Mỗi controller con phải override
     * @return void
     */
    abstract protected function register_routes(): void;
    /**
     * Response success chuẩn
     * @param $data
     * @param int $status
     * @return WP_REST_Response
     */
    protected function success($data = null, int $status = 200): WP_REST_Response{
        return new WP_REST_Response([
            'success' => true,
            'data'    => $data,
        ], $status);
    }
    /**
     * Response error chuẩn
     * @param string $message
     * @param int $status
     * @return WP_REST_Response
     */
    protected function error(string $message = 'Error', int $status = 400): WP_REST_Response{
        return new WP_REST_Response([
            'success' => false,
            'error'   => $message,
        ], $status);
    }
    /**
     * Lỗi 401: Chưa đăng nhập / Token sai
     * @return WP_Error
     */
    protected function unauthenticated(): WP_Error {
        return new WP_Error('rest_unauthenticated', 'Vui lòng đăng nhập', ['status' => 401]);
    }
    /**
     * Lỗi 403: Đã đăng nhập nhưng không đủ quyền
     * @return WP_Error
     */
    protected function forbidden(): WP_Error{
        return new WP_Error('rest_forbidden', 'Không có quyền truy cập', ['status' => 403]);
    }
    /**
     * Validate login - Chuyển sang nhận $request để lấy Header an toàn
     * Hàm này được dùng trong 'permission_callback' của register_rest_route
     * @param WP_REST_Request $request
     * @return bool
     */
    protected function require_login(WP_REST_Request $request): bool{
        // JWT
        $user = $this->get_current_user_from_token($request);
        if ($user) {
            wp_set_current_user($user->ID);
            wp_set_auth_cookie($user->ID);
            return true;
        }
        // Cookie fallback
        return is_user_logged_in();
    }
    /**
     * Check role (dùng cho login / phân loại)
     * @param array $roles
     * @return true|WP_REST_Response
     */
    protected function require_role(array $roles){
        $user = wp_get_current_user();
        if (empty(array_intersect($roles, (array) $user->roles))) {
            return $this->error('Bạn không có quyền truy cập', 403);
        }
        return true;
    }
    /**
     * Check capability
     * @param string $cap
     * @return true|WP_REST_Response
     */
    protected function require_cap(string $cap){
        if (!current_user_can($cap)) {
            return $this->error('Bạn không có quyền thực hiện hành động này', 403);
        }
        return true;
    }
    /**
     * Helper chain middleware
     * @param $checks
     * @return true
     */
    protected function authorize($checks = []){
        foreach ($checks as $check) {
            $result = $check();
            if ($result !== true) {
                return $result;
            }
        }
        return true;
    }
    /** Check token
     * @return false|\WP_User|null
     */
    protected function get_current_user_from_token(WP_REST_Request $request){
        $headers = $request->get_header('authorization');
        if (empty($headers)) return null;
        $token = str_replace('Bearer ', '', $headers);
        try {
            $decoded = Helper::jwt_decode($token);
            return get_user_by('id', $decoded->data->id);
        } catch (\Exception $e){
            return null;
        }
    }

    /**
     * Kiểm tra quyền truy cập dựa trên Capability
     * @param WP_REST_Request $request
     * @param array|string $capabilities Vd: 'edit_tasks' hoặc ['edit_tasks', 'delete_tasks']
     * @param string $relation 'OR' (có 1 quyền là được) hoặc 'AND' (phải có đủ quyền)
     * @return bool|WP_Error True nếu hợp lệ, WP_Error nếu bị chặn
     */
    protected function check_permission(WP_REST_Request $request, array|string $capabilities, string $relation = 'OR') {
        // 1. Kiểm tra xác thực (Authentication)
        if (!$this->require_login($request)) {
            return $this->unauthenticated();
        }
        // Nếu không truyền capability cụ thể, mặc định cho qua (miễn là đã login)
        if (empty($capabilities)) {
            return true;
        }
        $caps = (array) $capabilities;
        $relation = strtoupper($relation);
        // 2. Kiểm tra Capability (Authorization)
        // Lưu ý: Administrator mặc định sẽ luôn pass hàm current_user_can với hầu hết custom capabilities
        if ($relation === 'OR') {
            foreach ($caps as $cap) {
                if (current_user_can($cap)) {
                    return true;
                }
            }
            // Trả về 403 nếu lặp hết mảng mà không có quyền nào
            return $this->forbidden();
        } else { // Kiểm tra kiểu AND
            foreach ($caps as $cap) {
                if (!current_user_can($cap)) {
                    return $this->forbidden(); // Trượt 1 quyền là cấm luôn
                }
            }
            return true;
        }
    }
}