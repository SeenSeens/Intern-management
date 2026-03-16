<?php
namespace InternManagement\App\Controllers\Web;
use InternManagement\App\Actions\TaskAction;
use InternManagement\App\Actions\TaskAssignessAction;
use InternManagement\App\Helpers\DateHelper;
use InternManagement\App\Services\ProjectInternService;
use InternManagement\App\Services\ProjectService;
use InternManagement\App\Services\TaskAssigneesService;
use InternManagement\App\Services\TaskDetailService;
use InternManagement\App\Services\TaskService;
use InternManagement\Core\Controller;
use InternManagement\Core\Helper;

if ( ! defined( 'ABSPATH' ) ) exit;
class TaskController extends Controller{
    private TaskAction $action;
    private TaskAssignessAction $taskAssigneesAction;
    private ProjectService $projectService;
    private ProjectInternService $projectInternService;
    private TaskAssigneesService $taskAssigneesService;
    private $taskDetailService;

    public function __construct() {
        parent::__construct(new TaskService());
        $this->action = new TaskAction();
        $this->taskAssigneesAction = new TaskAssignessAction();
        $this->projectService = new ProjectService();
        $this->projectInternService = new ProjectInternService();
        $this->taskAssigneesService = new TaskAssigneesService();
        $this->taskDetailService = new TaskDetailService();
    }

    public function index(){
        $tasks = $this->service->all_tasks();
        $this->render('task/index', compact('tasks'));
    }

    public function create(){
        $id = (int)($_GET['project_id'] ?? 0);
        $project = $this->projectService->find($id);
        if (!$project) {
            wp_die('Dự án không tồn tại');
        }
        $this->render('task/create', compact('project'));
    }

    public function edit(){

    }

    public function delete(){

    }

    public function store(){
        check_admin_referer('save_task_action'); // Chỉ nếu dùng nonce
        $data = [
            'id' => isset($_POST['id']) ? intval($_POST['id']) : null,
            'project_id' => (int)($_POST['project_id'] ?? 0),
            'title' => sanitize_text_field($_POST['title'] ?? ''),
            'description' => sanitize_textarea_field($_POST['description'] ?? ''),
            'priority' => sanitize_text_field($_POST['priority'] ?? ''),
            'assigned_by' => get_current_user_id(),
            'status' => sanitize_text_field($_POST['status'] ?? 'pending'),
            'start_date' => Helper::format_date_time_local($_POST['start_date'] ?? ''),
            'end_date' => Helper::format_date_time_local($_POST['end_date'] ?? ''),
        ];
        $this->action->save($data);
        wp_redirect(admin_url('admin.php?page=intern-project'));
        exit();
    }
    public function view(){
        $id = (int)($_GET['task_id'] ?? 0);
        $task = $this->service->find($id); // Lấy thông tin task
        $internsAssignTask = $this->taskAssigneesService->get_intern_assign_by_task_id($id); // Lấy danh intern đã được thêm vào dự án
        $taskDetails = $this->taskDetailService->all(); // Lấy danh sách check list công việc
        $this->render('task/view', compact('task', 'internsAssignTask', 'taskDetails'));
    }
    public function task_assignees(){
        $id = (int)($_POST['task_id'] ?? $_GET['task_id'] ?? 0);
        $project_id = (int)($_POST['project_id'] ?? $_GET['project_id'] ?? 0);
        $task = $this->service->get_project_id_by_task_id($id);
        $interns = $this->projectInternService->get_project_interns($project_id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            check_admin_referer('assign_task_action');
            $internIds = $_POST['intern_ids'] ?? [];
            if (is_array($internIds)) {
                foreach ($internIds as $internId) {
                    $this->taskAssigneesAction->save([
                        'task_id' => $id,
                        'user_id' => (int)$internId,
                    ]);
                }
            }
            wp_redirect(admin_url("admin.php?page=intern-student"));
            exit;
        }
        $this->render('task/assignees', compact('interns', 'id'));
    }

    public function new_subtask() {
        $id = (int)($_GET['task_id'] ?? 0);
        $interns = $this->taskAssigneesService->get_intern_assign_by_task_id($id);
        $this->render('task/new-subtask', compact('interns'));
    }
}