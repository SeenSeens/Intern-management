<?php
namespace InternManagement\App\Controllers\Api;
use InternManagement\App\Services\TaskService;
use InternManagement\Core\ApiController;
use InternManagement\Core\Helper;
use WP_REST_Request;

class TaskController extends ApiController{
    private $taskService;
    public function __construct(){
        parent::__construct();
        $this->taskService = new TaskService();
    }

    protected function register_routes(): void{
        register_rest_route($this->namespace, '/tasks', [
            [
                'methods'  => 'GET',
                'callback' => [$this, 'index'],
                'permission_callback' => [$this, 'permission']
            ],
            [
                'methods'  => 'POST',
                'callback' => [$this, 'store'],
                'permission_callback' => [$this, 'permission']
            ]
        ]);

        register_rest_route($this->namespace, '/tasks/(?P<id>\d+)', [
            [
                'methods'  => 'GET',
                'callback' => [$this, 'show'],
                'permission_callback' => [$this, 'permission']
            ],
            [
                'methods'  => 'PUT',
                'callback' => [$this, 'update'],
                'permission_callback' => [$this, 'permission']
            ],
            [
                'methods'  => 'DELETE',
                'callback' => [$this, 'destroy'],
                'permission_callback' => [$this, 'permission']
            ]
        ]);
    }
    public function permission(): bool{
        return $this->require_login();
    }

    public function index(WP_REST_Request $request){
        $data['items'] = $this->taskService->get_all_tasks();
        $data['statistics'] = $this->taskService->statistics();
        $data['upcoming_tasks'] = $this->taskService->upcoming_tasks(7);
        return $this->success( $data );
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
}