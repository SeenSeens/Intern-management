<?php
namespace InternManagement\App\Controllers\Api;

use InternManagement\App\Actions\ProjectAction;
use InternManagement\App\Services\ProjectService;
use InternManagement\Core\ApiController;
use InternManagement\Core\Auth;
use InternManagement\Core\Helper;
use WP_REST_Request;
use WP_REST_Response;

if ( ! defined( 'ABSPATH' ) ) exit;

class ProjectController extends ApiController{
    private ProjectService $projectService;
    private ProjectAction $projectAction;
    public function __construct(){
        parent::__construct();
        $this->projectService = new ProjectService();
        $this->projectAction = new ProjectAction();
    }
    protected function register_routes(): void{
        register_rest_route($this->namespace, '/projects', [
            [
                'methods'  => 'GET',
                'callback' => [$this, 'index'],
                'permission_callback' => [$this, 'permission']
            ]
        ]);
        register_rest_route($this->namespace, '/projects/', [
            [
                'methods'  => 'POST',
                'callback' => [$this, 'store'],
                'permission_callback' => [$this, 'permission']
            ]
        ]);
        register_rest_route($this->namespace, '/projects/(?P<id>\d+)', [
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
        register_rest_route($this->namespace, '/projects/stats', [
            [
                'methods'  => 'GET',
                'callback' => [$this, 'stats'],
                'permission_callback' => [$this, 'permission']
            ]
        ]);
        register_rest_route($this->namespace, '/projects/(?P<id>\d+)/intern/(?P<id>\d+)', [
            [
                'methods'  => 'GET',
                'callback' => [$this, 'view_project_scores'],
                'permission_callback' => [$this, 'permission']
            ],
        ]);
        register_rest_route($this->namespace, '/projects/(?P<id>\d+)/mentor', [
            [
                'methods'  => 'GET',
                'callback' => [$this, 'view_project_mentor'],
                'permission_callback' => [$this, 'permission']
            ],
            [
                'methods'  => 'POST',
                'callback' => [$this, 'create_project_mentor'],
                'permission_callback' => [$this, 'permission']
            ],
            [
                'methods'  => 'PUT',
                'callback' => [$this, 'update_project_mentor'],
                'permission_callback' => [$this, 'permission']
            ]
        ]);
        register_rest_route($this->namespace, '/projects/(?P<id>\d+)/mentor/(?P<id>\d+)', [
            [
                'methods'  => 'DELETE',
                'callback' => [$this, 'delete_project_mentor'],
                'permission_callback' => [$this, 'permission']
            ]
        ]);
        register_rest_route($this->namespace, '/projects/(?P<id>\d+)/intern', [
            [
                'methods'  => 'GET',
                'callback' => [$this, 'view_project_intern'],
                'permission_callback' => [$this, 'permission']
            ],
            [
                'methods'  => 'POST',
                'callback' => [$this, 'create_project_intern'],
                'permission_callback' => [$this, 'permission']
            ],
            [
                'methods'  => 'PUT',
                'callback' => [$this, 'update_project_intern'],
                'permission_callback' => [$this, 'permission']
            ]
        ]);
        register_rest_route($this->namespace, '/projects/(?P<id>\d+)/intern/(?P<id>\d+)', [
            [
                'methods'  => 'DELETE',
                'callback' => [$this, 'delete_project_intern'],
                'permission_callback' => [$this, 'permission']
            ]
        ]);
    }
    public function permission(): bool{
        return $this->require_login();
    }

    // LIST (OFFSET OR CURSOR)
    public function index(WP_REST_Request $request){
        $mode = $request->get_param('mode') ?? 'offset';

        if ($mode === 'cursor') {

            $cursor = $request->get_param('cursor');
            $limit  = $request->get_param('limit') ?? 10;

            $result = $this->projectService->cursor_paginate(
                $cursor ? (int)$cursor : null,
                (int)$limit,
                $this->filters($request)
            );

        } else {

            $page    = $request->get_param('page') ?? 1;
            $perPage = $request->get_param('per_page') ?? 10;

            $result = $this->projectService->offset_paginate(
                (int)$page,
                (int)$perPage,
                $this->filters($request)
            );
        }

        // Lấy thống kê trạng thái
        $stats = $this->projectService->count_project_status();

        // Gộp thống kê vào kết quả trả về
        // Giả sử $result là array, nếu là object hãy dùng $result->stats = $stats;
        $result['statistics'] = $stats;

        return $this->success($result);
    }

    // Show
    public function show(WP_REST_Request $request) {
        $id = (int) $request['id'];

        $project = $this->projectService->find($id);

        if (!$project) {
            return $this->error('Project not found', 404);
        }

        return $this->success($project);
    }

    // Store
    public function store(WP_REST_Request $request){
        try {
            $params = $request->get_json_params() ?? $request->get_params();
            $start_date = Helper::format_date_time_local($params['start_date'] ?? '');
            $end_date   = Helper::format_date_time_local($params['end_date'] ?? '');
            if ($start_date && $end_date && strtotime($start_date) > strtotime($end_date)) {
                throw new \Exception("Ngày bắt đầu không được lớn hơn ngày kết thúc");
            }
            $data = [
                'name' => sanitize_text_field($params['name'] ?? ''),
                'description' => sanitize_textarea_field(
                    wp_kses_post($params['description'] ?? '')
                ),
                'status' => sanitize_text_field($params['status'] ?? 'waiting'),
                'manager_id' => get_current_user_id(),
                'start_date' => $start_date,
                'end_date' => $end_date,
            ];
            $id = $this->projectService->create($data);
            return $this->success([
                'id' => $id
            ], 201);

        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 422);
        }

    }

    // Update
    public function update(WP_REST_Request $request){
        try {
            $id = (int) $request['id'];
            $params = $request->get_json_params() ?? $request->get_params();
            $start_date = Helper::format_date_time_local($params['start_date']);
            $end_date   = Helper::format_date_time_local($params['end_date']);
            if ($start_date && $end_date && strtotime($start_date) > strtotime($end_date)) {
                throw new \Exception("Ngày bắt đầu không được lớn hơn ngày kết thúc");
            }
            $data = [
                'name' => sanitize_text_field($params['name']),
                'description' => sanitize_textarea_field(
                    wp_kses_post($params['description'])
                ),
                'status' => sanitize_text_field($params['status'] ?? 'waiting'),
                'manager_id' => get_current_user_id(),
                'start_date' => $start_date,
                'end_date' => $end_date,
            ];
            $updated = $this->projectService->update(
                $id,
                $data
            );
            return $this->success([
                'updated' => $updated
            ]);

        } catch (\Exception $e) {

            return $this->error($e->getMessage(), 422);
        }
    }

    //delete
    public function destroy(WP_REST_Request $request){
        $params = $request->get_json_params() ?? $request->get_params();
        $id = (int) $params['id'];
        $deleted = $this->projectService->delete($id);
        return $this->success([
            'deleted' => $deleted
        ]);
    }

    //stats
    public function stats(){
        return $this->success(
            $this->projectService->stats()
        );
    }

    protected function filters(WP_REST_Request $request): array{
        return [
            'status'     => $request->get_param('status'),
            'manager_id' => $request->get_param('manager_id'),
        ];
    }

    public function view_project_scores(){}

    public function view_project_mentor(){}

    public function create_project_mentor(){}

    public function update_project_mentor(){}

    public function delete_project_mentor(){}

    public function view_project_intern(){}

    public function create_project_intern(){}

    public function update_project_intern(){}

    public function delete_project_intern(){}

}

