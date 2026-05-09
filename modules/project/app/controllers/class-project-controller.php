<?php
namespace InternManagement\Modules\Project\App\Controllers;

use Exception;
use InternManagement\Includes\ApiController;
use InternManagement\Includes\Helper;
use InternManagement\Modules\Project\App\Actions\ProjectAction;
use InternManagement\Modules\Project\App\Services\ProjectInternService;
use InternManagement\Modules\Project\App\Services\ProjectMentorService;
use InternManagement\Modules\Project\App\Services\ProjectService;
use InternManagement\Modules\Task\App\Services\TaskService;
use WP_REST_Request;
use WP_REST_Server;

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
                    return $this->check_permission($request, ['create_project']);
                }
            ]
        ]);
        register_rest_route($this->namespace, '/projects/(?P<id>\d+)', [
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
                    return $this->check_permission($request, ['edit_project']);
                }
            ],
            [
                'methods'  => WP_REST_Server::DELETABLE,
                'callback' => [$this, 'destroy'],
                'permission_callback' => function(WP_REST_Request $request) {
                    return $this->check_permission($request, ['delete_project']);
                }
            ]
        ]);
        register_rest_route($this->namespace, '/projects/stats', [
            [
                'methods'  => WP_REST_Server::READABLE,
                'callback' => [$this, 'stats'],
                'permission_callback' => function(WP_REST_Request $request) {
                    return $this->check_permission($request, []);
                }
            ]
        ]);
        register_rest_route($this->namespace, '/projects/(?P<project_id>\d+)/interns/(?P<intern_id>\d+)', [
            [
                'methods'  => WP_REST_Server::READABLE,
                'callback' => [$this, 'view_project_scores'],
                'permission_callback' => function(WP_REST_Request $request) {
                    return $this->check_permission($request, []);
                }
            ],
        ]);
        register_rest_route($this->namespace, '/projects/(?P<project_id>\d+)/mentors', [
            [
                'methods'  => WP_REST_Server::READABLE,
                'callback' => [$this, 'view_project_mentor'],
                'permission_callback' => function(WP_REST_Request $request) {
                    return $this->check_permission($request, []);
                }
            ],
            [
                'methods'  => WP_REST_Server::CREATABLE,
                'callback' => [$this, 'create_project_mentor'],
                'permission_callback' => function(WP_REST_Request $request) {
                    return $this->check_permission($request, []);
                }
            ],
            [
                'methods'  => WP_REST_Server::EDITABLE,
                'callback' => [$this, 'update_project_mentor'],
                'permission_callback' => function(WP_REST_Request $request) {
                    return $this->check_permission($request, []);
                }
            ]
        ]);
        register_rest_route($this->namespace, '/projects/(?P<project_id>\d+)/mentors/(?P<mentor_id>\d+)', [
            [
                'methods'  => WP_REST_Server::DELETABLE,
                'callback' => [$this, 'delete_project_mentor'],
                'permission_callback' => function(WP_REST_Request $request) {
                    return $this->check_permission($request, []);
                }
            ]
        ]);
        register_rest_route($this->namespace, '/projects/(?P<project_id>\d+)/interns', [
            [
                'methods'  => WP_REST_Server::READABLE,
                'callback' => [$this, 'view_project_intern'],
                'permission_callback' => function(WP_REST_Request $request) {
                    return $this->check_permission($request, []);
                }
            ],
            [
                'methods'  => WP_REST_Server::CREATABLE,
                'callback' => [$this, 'create_project_intern'],
                'permission_callback' => function(WP_REST_Request $request) {
                    return $this->check_permission($request, []);
                }
            ],
            [
                'methods'  => WP_REST_Server::EDITABLE,
                'callback' => [$this, 'update_project_intern'],
                'permission_callback' => function(WP_REST_Request $request) {
                    return $this->check_permission($request, []);
                }
            ]
        ]);
        register_rest_route($this->namespace, '/projects/(?P<project_id>\d+)/interns/(?P<intern_id>\d+)', [
            [
                'methods'  => WP_REST_Server::DELETABLE,
                'callback' => [$this, 'delete_project_intern'],
                'permission_callback' => function(WP_REST_Request $request) {
                    return $this->check_permission($request, []);
                }
            ]
        ]);
    }

    // LIST (OFFSET OR CURSOR)
    public function index(WP_REST_Request $request){
        try {
            $user_id = get_current_user_id();
            if (empty($user_id)) {
                return $this->error('Vui lòng đăng nhập để tiếp tục', 401);
            }
            $user = get_userdata($user_id);
            $projects = [];
            $stats = [];
            if ( $user->has_cap('manage_options') ) {
                $projects = $this->projectService->all();
                $stats = $this->projectService->statistics();
            }
            if ( in_array('mentor', (array) $user->roles) ) {
                $projects = $this->projectMentorService->get_list_projects_mentor_assigned($user_id);
                $stats = $this->projectMentorService->statistics($user_id);
            }
            if ( in_array('intern', (array) $user->roles) ) {
                $projects = $this->projectInternService->get_list_projects_intern_assigned($user_id);
                $stats = $this->projectInternService->statistics($user_id);
            }

            $result = [
                'items'      => $projects,
                'statistics' => $stats
            ];
            return $this->success($result);
        } catch (\Exception $e) {
            $this->error($e->getMessage(),500);
        }
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

    public function store(WP_REST_Request $request){
        $params = $request->get_json_params() ?? $request->get_params();
        $params['action_type'] = 'create';
        return $this->projectAction->execute($params, true);
    }

    public function update(WP_REST_Request $request){
        $params = $request->get_json_params() ?? $request->get_params();
        $params['action_type'] = 'update';
        $params['id'] = (int) $request['id'];
        return $this->projectAction->execute($params, true);
    }

    public function destroy(WP_REST_Request $request){
        $params = $request->get_json_params() ?? $request->get_params();
        $id = $request->get_param('id') ?? $params['id'] ?? 0;
        $action_params = [
            'id'          => (int) $id,
            'action_type' => 'delete'
        ];
        return $this->projectAction->execute($action_params, true);
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

    public function view_project_mentor(WP_REST_Request $request){}

    public function create_project_mentor(){}

    public function update_project_mentor(){}

    public function delete_project_mentor(){}

    public function view_project_intern(WP_REST_Request $request){
    }

    public function create_project_intern(){}

    public function update_project_intern(){}

    public function delete_project_intern(){}

}

