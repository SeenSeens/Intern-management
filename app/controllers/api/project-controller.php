<?php
namespace InternManagement\App\Controllers\Api;

use Exception;
use InternManagement\App\Actions\ProjectAction;
use InternManagement\App\Services\ProjectInternService;
use InternManagement\App\Services\ProjectMentorService;
use InternManagement\App\Services\ProjectService;
use InternManagement\App\Services\TaskService;
use InternManagement\Core\ApiController;
use InternManagement\Core\Auth;
use InternManagement\Core\Helper;
use WP_REST_Request;
use WP_REST_Response;

if ( ! defined( 'ABSPATH' ) ) exit;

class ProjectController extends ApiController{
    private ProjectService $projectService;
    private ProjectMentorService $projectMentorService;
    private ProjectInternService $projectInternService;
    private TaskService $taskService;
    private ProjectAction $projectAction;
    public function __construct(){
        parent::__construct();
        $this->projectService = new ProjectService();
        $this->projectMentorService = new ProjectMentorService();
        $this->projectInternService = new ProjectInternService();
        $this->taskService = new TaskService();
        $this->projectAction = new ProjectAction();
    }
    protected function register_routes(): void{
        register_rest_route($this->namespace, '/projects', [
            [
                'methods'  => 'GET',
                'callback' => [$this, 'index'],
                'permission_callback' => function(WP_REST_Request $request) {
                    return $this->check_permission($request, []);
                }
            ],
            [
                'methods'  => 'POST',
                'callback' => [$this, 'store'],
                'permission_callback' => function(WP_REST_Request $request) {
                    return $this->check_permission($request, ['create_project']);
                }
            ]
        ]);
        register_rest_route($this->namespace, '/projects/(?P<id>\d+)', [
            [
                'methods'  => 'GET',
                'callback' => [$this, 'show'],
                'permission_callback' => function(WP_REST_Request $request) {
                    return $this->check_permission($request, []);
                }
            ],
            [
                'methods'  => 'PUT',
                'callback' => [$this, 'update'],
                'permission_callback' => function(WP_REST_Request $request) {
                    return $this->check_permission($request, ['edit_project']);
                }
            ],
            [
                'methods'  => 'DELETE',
                'callback' => [$this, 'destroy'],
                'permission_callback' => function(WP_REST_Request $request) {
                    return $this->check_permission($request, ['delete_project']);
                }
            ]
        ]);
        register_rest_route($this->namespace, '/projects/stats', [
            [
                'methods'  => 'GET',
                'callback' => [$this, 'stats'],
                'permission_callback' => function(WP_REST_Request $request) {
                    return $this->check_permission($request, []);
                }
            ]
        ]);
        register_rest_route($this->namespace, '/projects/(?P<project_id>\d+)/interns/(?P<intern_id>\d+)', [
            [
                'methods'  => 'GET',
                'callback' => [$this, 'view_project_scores'],
                'permission_callback' => function(WP_REST_Request $request) {
                    return $this->check_permission($request, []);
                }
            ],
        ]);
        register_rest_route($this->namespace, '/projects/(?P<project_id>\d+)/mentors', [
            [
                'methods'  => 'GET',
                'callback' => [$this, 'view_project_mentor'],
                'permission_callback' => function(WP_REST_Request $request) {
                    return $this->check_permission($request, []);
                }
            ],
            [
                'methods'  => 'POST',
                'callback' => [$this, 'create_project_mentor'],
                'permission_callback' => function(WP_REST_Request $request) {
                    return $this->check_permission($request, []);
                }
            ],
            [
                'methods'  => 'PUT',
                'callback' => [$this, 'update_project_mentor'],
                'permission_callback' => function(WP_REST_Request $request) {
                    return $this->check_permission($request, []);
                }
            ]
        ]);
        register_rest_route($this->namespace, '/projects/(?P<project_id>\d+)/mentors/(?P<mentor_id>\d+)', [
            [
                'methods'  => 'DELETE',
                'callback' => [$this, 'delete_project_mentor'],
                'permission_callback' => function(WP_REST_Request $request) {
                    return $this->check_permission($request, []);
                }
            ]
        ]);
        register_rest_route($this->namespace, '/projects/(?P<project_id>\d+)/interns', [
            [
                'methods'  => 'GET',
                'callback' => [$this, 'view_project_intern'],
                'permission_callback' => function(WP_REST_Request $request) {
                    return $this->check_permission($request, []);
                }
            ],
            [
                'methods'  => 'POST',
                'callback' => [$this, 'create_project_intern'],
                'permission_callback' => function(WP_REST_Request $request) {
                    return $this->check_permission($request, []);
                }
            ],
            [
                'methods'  => 'PUT',
                'callback' => [$this, 'update_project_intern'],
                'permission_callback' => function(WP_REST_Request $request) {
                    return $this->check_permission($request, []);
                }
            ]
        ]);
        register_rest_route($this->namespace, '/projects/(?P<project_id>\d+)/interns/(?P<intern_id>\d+)', [
            [
                'methods'  => 'DELETE',
                'callback' => [$this, 'delete_project_intern'],
                'permission_callback' => function(WP_REST_Request $request) {
                    return $this->check_permission($request, []);
                }
            ]
        ]);
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
        try {
            $id = (int) $request['id'];
            $data['project'] = $this->projectService->find($id);
            $data['mentor'] = $this->projectMentorService->get_mentor_project($id);
            $data['intern'] = $this->projectInternService->get_intern_project($id);
            $data['overall'] = $this->taskService->overall_progress($id);
            $data['task_project'] = $this->taskService->get_tasks_from_project($id);
            return $this->success($data);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    // Store
    public function store(WP_REST_Request $request){
        global $wpdb;
        try {
            $params = $request->get_json_params() ?? $request->get_params();
            $start_date = Helper::format_date_time_local($params['start_date'] ?? '');
            $end_date   = Helper::format_date_time_local($params['end_date'] ?? '');
            if ($start_date && $end_date && strtotime($start_date) > strtotime($end_date)) {
                throw new Exception("Ngày bắt đầu không được lớn hơn ngày kết thúc");
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
            // lấy mentors + interns từ FE
            $mentor_ids = array_map('intval', $params['mentors'] ?? []);
            //error_log(print_r($mentor_ids, true));
            $intern_ids = array_map('intval', $params['interns'] ?? []);
            //error_log(print_r($intern_ids, true));
            $assigned_by = get_current_user_id();
            // START TRANSACTION
            $wpdb->query('START TRANSACTION');
            // tạo project
            $project_id = $this->projectService->create($data);
            //error_log("project_id". $project_id);
            if (!$project_id) {
                throw new Exception("Không thể tạo project");
            }
            // sync mentors
            if (!empty($mentor_ids)) {
                $this->projectMentorService->sync_project_mentors(
                    $project_id,
                    $mentor_ids,
                    $assigned_by
                );
            }
            // sync interns
            if (!empty($intern_ids)) {
                $this->projectInternService->sync_project_interns(
                    $project_id,
                    $intern_ids,
                    $assigned_by
                );
            }
            // COMMIT
            $wpdb->query('COMMIT');
            return $this->success([
                'id' => $project_id
            ], 201);

        } catch (Exception $e) {
            error_log('❌ ERROR: ' . $e->getMessage());
            error_log('❌ SQL: ' . $wpdb->last_query);
            error_log('❌ DB ERROR: ' . $wpdb->last_error);
            // ROLLBACK nếu lỗi
            $wpdb->query('ROLLBACK');
            return $this->error($e->getMessage(), 422);
        }
    }

    // Update
    public function update(WP_REST_Request $request){
        global $wpdb;
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
            // lấy mentors + interns từ FE
            $mentor_ids = array_map('intval', $params['mentors']);
            //error_log(print_r($mentor_ids, true));
            $intern_ids = array_map('intval', $params['interns']);
            //error_log(print_r($intern_ids, true));
            $assigned_by = get_current_user_id();
            // START TRANSACTION
            $wpdb->query('START TRANSACTION');
            $updated = $this->projectService->update(
                $id,
                $data
            );
            error_log("project". $updated);
            if (!$updated) {
                throw new Exception("Không thể cập nhật project");
            }
            // sync mentors
            if (!empty($mentor_ids)) {
                $this->projectMentorService->sync_project_mentors(
                    $id,
                    $mentor_ids,
                    $assigned_by
                );
            }
            // sync interns
            if (!empty($intern_ids)) {
                $this->projectInternService->sync_project_interns(
                    $id,
                    $intern_ids,
                    $assigned_by
                );
            }
            // COMMIT
            $wpdb->query('COMMIT');
            return $this->success([
                'updated' => $updated
            ]);

        } catch (Exception $e) {
            error_log('❌ ERROR: ' . $e->getMessage());
            error_log('❌ SQL: ' . $wpdb->last_query);
            error_log('❌ DB ERROR: ' . $wpdb->last_error);
            // ROLLBACK nếu lỗi
            $wpdb->query('ROLLBACK');
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

    public function view_project_mentor(WP_REST_Request $request){
    }

    public function create_project_mentor(){
        try {

        } catch (Exception $e){

        }
    }

    public function update_project_mentor(){}

    public function delete_project_mentor(){}

    public function view_project_intern(WP_REST_Request $request){
    }

    public function create_project_intern(){}

    public function update_project_intern(){}

    public function delete_project_intern(){}

}

