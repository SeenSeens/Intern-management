<?php
namespace InternManagement\Modules\Task\App\Controllers;
use InternManagement\Includes\ApiController;
use InternManagement\Includes\Helper;
use InternManagement\Modules\Task\App\Actions\TaskAction;
use InternManagement\Modules\Task\App\Services\TaskService;
use WP_REST_Request;
use WP_REST_Server;

class TaskController extends ApiController{
    private TaskService $taskService;
    private TaskAction $taskAction;
    public function __construct(){
        parent::__construct();
        $this->taskService = new TaskService();
        $this->taskAction = new TaskAction();
    }

    protected function register_routes(): void{
        register_rest_route($this->namespace, 'projects/(?P<project_id>\d+)/tasks', [
            [
                'methods' => WP_REST_Server::READABLE,
                'callback' => [$this, ''],
                'permission_callback' => function(WP_REST_Request $request) {
                    return $this->check_permission($request, []);
                }
            ]
        ]);
        register_rest_route($this->namespace, '/tasks', [
            [
                'methods'  => WP_REST_Server::READABLE,
                'callback' => [$this, 'index'],
                'permission_callback' => function(WP_REST_Request $request) {
                    return $this->check_permission($request, []);
                }
            ],
            [
                'methods'  => WP_REST_Server::CREATABLE,
                'callback' => [$this, 'store'],
                'permission_callback' => function(WP_REST_Request $request) {
                    return $this->check_permission($request, []);
                }
            ]
        ]);

        register_rest_route($this->namespace, '/tasks/(?P<id>\d+)', [
            [
                'methods'  => WP_REST_Server::READABLE,
                'callback' => [$this, 'show'],
                'permission_callback' => function(WP_REST_Request $request) {
                    return $this->check_permission($request, []);
                }
            ],
            [
                'methods'  => WP_REST_Server::EDITABLE,
                'callback' => [$this, 'update'],
                'permission_callback' => function(WP_REST_Request $request) {
                    return $this->check_permission($request, []);
                }
            ],
            [
                'methods'  => WP_REST_Server::DELETABLE,
                'callback' => [$this, 'destroy'],
                'permission_callback' => function(WP_REST_Request $request) {
                    return $this->check_permission($request, []);
                }
            ]
        ]);
    }
    public function index(WP_REST_Request $request){
        try {
            $user_id = get_current_user_id();
            if (empty($user_id)) {
                return $this->error('Vui lòng đăng nhập để tiếp tục', 401);
            }
            $user = get_userdata($user_id);
            if ( $user->has_cap('manage_options') ) {
                $data['items'] = $this->taskService->get_all_tasks();
            }
            if ( in_array('intern', (array) $user->roles) ) {
                $data['items'] = $this->taskService->get_all_tasks_intern($user_id);
            }
            $data['statistics'] = $this->taskService->statistics();
            $data['upcoming_tasks'] = $this->taskService->upcoming_tasks(7);
            return $this->success( $data );
        } catch (\Exception $e) {
            $this->error($e->getMessage(),500);
        }
    }
    public function store(WP_REST_Request $request){
        try {
            $params = $request->get_json_params() ?? $request->get_params();
            $start_date = Helper::format_date_time_local($params['start_date'] ?? '');
            $end_date   = Helper::format_date_time_local($params['end_date'] ?? '');
            if ($start_date && $end_date && strtotime($start_date) > strtotime($end_date)) {
                throw new \Exception("Ngày bắt đầu không được lớn hơn ngày kết thúc");
            }
            $data = [
                'project_id' => (int)($params['project_id'] ?? 0),
                'title' => sanitize_text_field($params['title'] ?? ''),
                'description' => sanitize_textarea_field( wp_kses_post($params['description'] ?? '') ),
                'priority' => sanitize_text_field($params['priority'] ?? 'medium'),
                'assigned_by' => get_current_user_id(),
                'status' => sanitize_text_field($params['status'] ?? 'pending'),
                'start_date' => $start_date,
                'end_date' => $end_date,
            ];
            $id = $this->taskService->create($data);
            return $this->success([
                'id' => $id
            ], 201);

        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 422);
        }

    }
    public function destroy(WP_REST_Request $request){
        $params = $request->get_json_params() ?? $request->get_params();
        $id = $request->get_param('id') ?? $params['id'] ?? 0;
        $action_params = [
            'id'          => (int) $id,
            'action_type' => 'delete'
        ];
        return $this->taskAction->execute($action_params, true);
    }
}