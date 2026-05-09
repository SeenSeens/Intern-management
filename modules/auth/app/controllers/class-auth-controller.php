<?php
namespace InternManagement\Modules\Auth\App\Controllers;
use Exception;
use InternManagement\Includes\ApiController;
use InternManagement\Includes\Helper;

use WP_Error;
use WP_REST_Request;
use WP_REST_Server;

if ( ! defined( 'ABSPATH' ) ) exit;
class AuthController extends ApiController{
    protected function register_routes(): void{
        register_rest_route($this->namespace, '/login', [
            'methods' => WP_REST_Server::CREATABLE,
            'callback' => [$this, 'intern_login'],
            'permission_callback' => '__return_true',
            'args' => []
        ]);
        register_rest_route($this->namespace, '/me', [
            'methods' => WP_REST_Server::READABLE,
            'callback' => function(WP_REST_Request $request){
                $user = wp_get_current_user();
                return [
                    'id' => $user->ID,
                    'name' => $user->display_name,
                    'email' => $user->user_email,
                    'roles' => $user->roles
                ];
            },
            'permission_callback' => function($request){
                return $this->check_permission($request, []);
            }
        ]);
        register_rest_route($this->namespace, '/refresh-token', [
            'methods' => WP_REST_Server::CREATABLE,
            'callback' => [$this, 'refresh_token_api_callback'],
            'permission_callback' => '__return_true',
        ]);
    }
    public function intern_login(WP_REST_Request $request){
        $params = $request->get_params();
        if (empty($params['username']) || empty($params['password'])) {
            return $this->error('Username hoặc password không được để trống');
        }
        $creds = [
            'user_login' => sanitize_text_field($params['username']),
            'user_password' => $params['password'],
            'remember' => true
        ];
        $user = wp_signon($creds, false);
        if (is_wp_error($user)) {
            return $this->error($user->get_error_message(), 401);
        }
        // 🔥 CHECK ROLE
        $allowed_roles = ALLOWED_ROLES;
        $user_roles = (array) $user->roles;
        $has_valid_role = array_intersect($allowed_roles, $user_roles);
        if (empty($has_valid_role)) {
            return $this->error('Bạn không có quyền đăng nhập hệ thống này', 403);
        }
        // JWT
        $tokens = Helper::generate_tokens($user);
        return $this->success([
            'access_token'  => $tokens['access_token'],
            'refresh_token' => $tokens['refresh_token'],
            'user' => [
                'id' => $user->ID,
                'name' => $user->display_name,
                'email' => $user->user_email,
                'avatar' => get_avatar_url($user->ID),
                'roles' => $user->roles,
                'capabilities' => $user->allcaps
            ]
        ]);
    }
    public static function refresh_token_api_callback( WP_REST_Request $request ) {
        $refresh_token = $request->get_param( 'refresh_token' );
        if ( ! $refresh_token ) {
            return new WP_Error( 'no_token', 'Thiếu refresh token.', [ 'status' => 400 ] );
        }
        try {
            // Decode token. Nếu hết hạn, nó sẽ văng thẳng xuống block catch
            $decoded = Helper::jwt_decode($refresh_token);
            // 1. Kiểm tra xem token gửi lên có đúng là 'refresh' không
            if ( $decoded->type !== 'refresh' ) {
                throw new Exception('Token không hợp lệ');
            }
            $user_id = $decoded->data->id;
            // 2. (Tùy chọn) So sánh với token đang lưu trong DB
            $saved_token = get_user_meta( $user_id, 'jwt_refresh_token', true );
            if ( $refresh_token !== $saved_token ) {
                throw new Exception('Token đã bị thu hồi');
            }
            // 3. Hợp lệ -> Lấy user và tạo cặp token mới (Token Rotation)
            $user = get_user_by('id', $user_id);
            $new_tokens = Helper::generate_tokens($user);
            return rest_ensure_response([
                'access_token'  => $new_tokens['access_token'],
                'refresh_token' => $new_tokens['refresh_token']
            ]);

        } catch ( Exception $e ) {
            // Token sai, hoặc đã hết hạn (exp)
            return new WP_Error( 'jwt_invalid', $e->getMessage(), ['status' => 401] );
        }
    }
}