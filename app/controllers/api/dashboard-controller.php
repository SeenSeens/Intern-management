<?php
namespace InternManagement\App\Controllers\Api;

use InternManagement\App\Services\ProjectService;
use InternManagement\App\Services\TaskService;
use InternManagement\App\Services\UserService;
use InternManagement\Core\ApiController;
use WP_REST_Request;

if ( ! defined( 'ABSPATH' ) ) exit;

class DashboardController extends ApiController{
    private UserService $userService;
    private ProjectService $projectService;
    private TaskService $taskService;

    public function __construct(){
        parent::__construct();

        $this->userService    = new UserService();
        $this->projectService = new ProjectService();
        $this->taskService    = new TaskService();
    }

    protected function register_routes(): void{
        register_rest_route($this->namespace, '/dashboard', [
            [
                'methods'  => 'GET',
                'callback' => [$this, 'index'],
                //'permission_callback' => [$this, 'permission']
            ]
        ]);
    }

    public function index(WP_REST_Request $request){
        $data = [
            'countIntern'  => $this->userService->countInterns(),
            'countProject' => $this->projectService->countProject(),
            'countTask'    => $this->taskService->countTask(),
        ];

        return $this->success($data);
    }

    public function permission(): bool{
        return $this->require_login();
    }
}

