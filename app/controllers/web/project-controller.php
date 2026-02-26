<?php
namespace InternManagement\App\Controllers\Web;
use InternManagement\App\Actions\ProjectAction;
use InternManagement\App\Services\AssignMemberProjectService;
use InternManagement\App\Services\ProjectInternService;
use InternManagement\App\Services\ProjectMentorService;
use InternManagement\App\Services\ProjectService;
use InternManagement\App\Services\TaskAssigneesService;
use InternManagement\App\Services\TaskService;
use InternManagement\Core\Controller;
use InternManagement\App\Helpers\DateHelper;
if ( ! defined( 'ABSPATH' ) ) exit;
class ProjectController extends Controller {
    private ProjectAction $action;
    private ProjectInternService $projectInternService;
    private ProjectMentorService $projectMentorService;
    private TaskService $taskService;
    private TaskAssigneesService $taskAssigneesService;
    public function __construct() {
        parent::__construct(new ProjectService());
        $this->action = new ProjectAction();
        $this->projectInternService = new ProjectInternService();
        $this->projectMentorService = new ProjectMentorService();
        $this->taskService = new TaskService();
        $this->taskAssigneesService = new TaskAssigneesService();
    }

    public function index(){
        $projects = $this->service->all();
        $this->render( 'project/index', compact('projects'));
    }

    public function create(){
        wp_enqueue_editor();
        $this->render( 'project/form');
    }

    public function edit(){
        $id = (int)($_GET['project_id'] ?? 0);
        $project = $this->service->find($id);
        if (!$project) {
            wp_die('Dự án không tồn tại');
        }
        $this->render( 'project/form', compact('project'));
    }

    public function delete(){
        check_admin_referer('delete_project_action');
        $id = (int)($_GET['project_id'] ?? 0);
        if (!current_user_can('edit_intern_projects')) {
            wp_die('Bạn không có quyền xoá dự án');
        }
        $this->service->delete($id);
        wp_redirect(admin_url('admin.php?page=intern-project'));
        exit;
    }

    public function store(){
        check_admin_referer('save_project_action'); // Chỉ nếu dùng nonce
        $start_date = DateHelper::formatDatetimeLocal($_POST['start_date'] ?? '');
        $end_date = DateHelper::formatDatetimeLocal($_POST['end_date'] ?? '');
        if ($start_date && $end_date && strtotime($start_date) > strtotime($end_date)) {
            wp_die('❌ Ngày bắt đầu không được lớn hơn ngày kết thúc');
        }
        $data = [
            'id' => isset($_POST['id']) ? intval($_POST['id']) : null,
            'name' => sanitize_text_field($_POST['name'] ?? ''),
            'description' => sanitize_textarea_field(wp_kses_post( $_POST['description'] ) ?? ''),
            'status' => sanitize_text_field($_POST['status'] ?? 'waiting'),
            'manager_id' => get_current_user_id(),
            'start_date' => $start_date,
            'end_date' => $end_date,
        ];
        $project_id = $this->action->save($data);
        if (!empty($data['id'])) {
            // Nếu có ID → là cập nhật
            wp_redirect(admin_url('admin.php?page=intern-project&action=view&project_id=' . intval($data['id'])));
        } else {
            // Nếu không có ID → là thêm mới
            wp_redirect(admin_url('admin.php?page=intern-project'));
        }
        exit;
    }

    public function view(){
        $id = (int)($_GET['project_id'] ?? 0);
        if (!$id) {
            wp_die('Dự án không tồn tại');
        }
        $project = $this->service->find($id);
        $mentors = $this->projectMentorService->getMentors($id);
        $interns = $this->projectInternService->getInterns($id);
        $allMentors = get_users(['role' => 'mentor']);
        $allInterns = get_users(['role' => 'intern']);
        $currentMentorIds = array_map(fn($u) => (int)$u->ID, $mentors);
        $currentInternIds = array_map(fn($u) => (int)$u->ID, $interns);

        $tasks = $this->taskService->getTasksByProject($id);
        $internAssignedByTask = [];
        foreach ($tasks as $task) {
            $internAssignedByTask[$task->id] = $this->taskAssigneesService->getInternAssignByTaskId($task->id);
            echo '<pre>';
            var_dump($internAssignedByTask[$task->id]);
            echo '</pre>';
        }
        $this->render( 'project/view', compact('project', 'mentors', 'interns', 'tasks',
            'internAssignedByTask', 'allMentors', 'allInterns', 'currentMentorIds', 'currentInternIds'));
    }

    public function updateMembers(){
        check_admin_referer('update_project_members_action');
        $projectId = (int) ($_POST['project_id'] ?? 0);
        $mentorIds = array_map('intval', $_POST['mentor_ids'] ?? []);
        $internIds = array_map('intval', $_POST['intern_ids'] ?? []);
        $assignedBy = get_current_user_id();
        $this->service->updateMembers($projectId, $mentorIds, $internIds, $assignedBy);
        wp_redirect(admin_url('admin.php?page=intern-project&action=edit&id=' . $projectId));
        exit;
    }

}