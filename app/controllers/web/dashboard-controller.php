<?php
namespace InternManagement\App\Controllers\Web;
use InternManagement\App\Services\ProjectService;
use InternManagement\App\Services\TaskService;
use InternManagement\Core\Controller;
use InternManagement\App\Services\UserService;
if ( ! defined( 'ABSPATH' ) ) exit;

class DashboardController extends Controller{
    private UserService $userService;
    private ProjectService $projectService;
    private TaskService $taskService;
    public function __construct($service = null){
        parent::__construct($service);
        $this->userService = new UserService();
        $this->projectService = new ProjectService();
        $this->taskService = new TaskService();
    }

    public function index(){
        $countIntern = $this->userService->countInterns(); // Lấy sl sinh viên
        $countProject = $this->projectService->countProject(); // Lấy sl dự án
        $countTask = $this->taskService->countTask(); // Lấy sl nhiệm vụ
        // Thống kê task hoàn thành
        // Biểu đồ tiến độ nhiệm vụ
        // Nhiệm vụ sắp đến hạn
        //$tasksAreDueSoons = $this->taskService->tasksAreDueSoon(7);

        $this->render('dashboard/index', compact('countIntern', 'countProject', 'countTask'));
    }

    public function create(){

    }

    public function edit(){

    }

    public function delete(){

    }

    public function store(){

    }
}