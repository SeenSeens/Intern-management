<?php
namespace InternManagement\App\Controllers\Api;
use InternManagement\App\Services\UserService;
use InternManagement\Core\ApiController;
use WP_REST_Request;
use WP_REST_Response;
use WP_REST_Server;
if ( ! defined( 'ABSPATH' ) ) exit;
class UserController extends ApiController{
    private UserService $userService;
    public function __construct(){
        parent::__construct();
        $this->userService = new UserService();
    }
    protected function register_routes(): void{
        register_rest_route($this->namespace, '/users', [
            [
                'methods' => 'GET',
                'callback' => [$this, 'index'],
                'permission_callback' => function(WP_REST_Request $request) {
                    return $this->check_permission($request, []);
                }
            ],
        ]);
        register_rest_route($this->namespace, '/users/users_by_role', [
            'methods' => 'GET',
            'callback' => [$this, 'get_users_by_role'],
            'permission_callback' => function(WP_REST_Request $request) {
                return $this->check_permission($request, []);
            }
        ]);
        register_rest_route($this->namespace, '/users/count', [
            'methods' => 'GET',
            'callback' => [$this, 'count_users_by_role'],
            'permission_callback' => function(WP_REST_Request $request) {
                return $this->check_permission($request, []);
            }
        ]);
    }
    public function index(WP_REST_Request $request): WP_REST_Response{
        $users = get_users();
        $data = [];
        foreach ($users as $user) {
            $data[] = [
                'id' => $user->ID,
                'name' => $user->display_name,
                'email' => $user->user_email,
                'avatar' => get_avatar_url($user->ID),
                'role' => $user->roles[0],
            ];
        }
        return $this->success( $data, 200 );
    }
    public function get_users_by_role(WP_REST_Request $request){
        $role = $request->get_json_params('role') ?? $request->get_params('role');
        if (!$role) {
            return [
                'success' => false,
                'message' => 'Role is required'
            ];
        }
        $users = $this->userService->get_users_by_roles($role);
        return $this->success($users, 200 );
    }
    public function count_users_by_role(): WP_REST_Response{
        $role = ['administrator', 'project_manager', 'mentor', 'intern'];
        $count = $this->userService->count_users_by_role($role);
        return $this->success( $count );
    }
}