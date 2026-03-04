<?php
namespace InternManagement\Core;

use WP_REST_Request;
use WP_REST_Response;
use WP_Error;

if ( ! defined( 'ABSPATH' ) ) exit;

abstract class ApiController{
    /**
     * Namespace API (versioning)
     */
    protected string $namespace = 'intern';

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
     */
    abstract protected function register_routes(): void;

    /**
     * Response success chuẩn
     */
    protected function success($data = null, int $status = 200): WP_REST_Response{
        return new WP_REST_Response([
            'success' => true,
            'data'    => $data,
        ], $status);
    }

    /**
     * Response error chuẩn
     */
    protected function error($message = 'Error', int $status = 400): WP_REST_Response{
        return new WP_REST_Response([
            'success' => false,
            'error'   => $message,
        ], $status);
    }

    /**
     * Unauthorized helper
     */
    protected function unauthorized(): WP_Error{
        return new WP_Error(
            'rest_forbidden',
            'Unauthorized',
            ['status' => 403]
        );
    }

    /**
     * Validate login mặc định
     */
    protected function require_login(): bool{
        return is_user_logged_in();
    }

    /**
     * Validate role
     */
    protected function require_role(string $role): bool{
        return current_user_can($role);
    }
}