<?php
namespace InternManagement\App\Controllers\Api;
use InternManagement\App\Services\UserService;
use InternManagement\Core\ApiController;
use WP_REST_Request;
use WP_REST_Response;
use WP_REST_Server;

class UserController extends ApiController{

    private UserService $userService;

    public function __construct(){
        parent::__construct();
        $this->userService = new UserService();
    }

    protected function register_routes(): void{
        register_rest_route($this->namespace, '/users', [
            'methods' => 'GET',
            'callback' => [$this, 'index'],
            'permission_callback' => [$this, 'permission']
        ]);
        register_rest_route($this->namespace, '/users/users_by_role', [
            'methods' => 'GET',
            'callback' => [$this, 'get_users_by_role'],
            'permission_callback' => [$this, 'permission']
        ]);
        register_rest_route($this->namespace, '/users/count', [
            'methods' => 'GET',
            'callback' => [$this, 'count_users_by_role'],
            'permission_callback' => [$this, 'permission']
        ]);
    }
    public function permission(): bool{
        return $this->require_login();
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
    public function get_users_by_role(WP_REST_Request $request): \WP_Error|WP_REST_Response|\WP_HTTP_Response{
        $users = $this->userService->get_users_by_roles(['administrator', 'project_manager', 'hr', 'mentor', 'intern']);

        $grouped = [
            'administrator' => [],
            'project_managers' => [],
            'hrs' => [],
            'mentors' => [],
            'interns' => [],
        ];

        foreach ($users as $user) {
            if (in_array('administrator', $user->roles, true)) {
                $grouped['administrator'][] = $user;
            }

            if (in_array('intern', $user->roles, true)) {
                $grouped['interns'][] = $user;
            }

            if (in_array('mentor', $user->roles, true)) {
                $grouped['mentors'][] = $user;
            }

            if (in_array('project_manager', $user->roles, true)) {
                $grouped['project_managers'][] = $user;
            }

            if (in_array('hr', $user->roles, true)) {
                $grouped['hrs'][] = $user;
            }
        }

        return rest_ensure_response([
            'success' => true,
            'data' => $grouped
        ]);
    }
    public function count_users_by_role(): WP_REST_Response{
        $role = ['administrator', 'project_manager', 'hr', 'mentor', 'intern'];
        $count = $this->userService->count_users_by_role($role);
        return $this->success( $count );
    }
}