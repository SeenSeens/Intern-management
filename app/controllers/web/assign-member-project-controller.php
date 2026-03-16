<?php
namespace InternManagement\App\Controllers\Web;
use InternManagement\App\Actions\AssignMemberProjectAction;
use InternManagement\App\Services\AssignMemberProjectService;
use InternManagement\App\Services\ProjectInternService;
use InternManagement\App\Services\ProjectMentorService;
use InternManagement\Core\Controller;

if ( ! defined( 'ABSPATH' ) ) exit;
class AssignMemberProjectController extends Controller{
    private AssignMemberProjectAction $assignMemberProjectAction;
    private ProjectMentorService $projectMentorService;
    private ProjectInternService $projectInternService;

    public function __construct() {
        parent::__construct(new AssignMemberProjectService());
        $this->assignMemberProjectAction = new AssignMemberProjectAction();
        $this->projectMentorService = new ProjectMentorService();
        $this->projectInternService = new ProjectInternService();
    }

    public function index(){
        $projectId = (int) ($_GET['id'] ?? 0);
        $mentors = $this->projectMentorService->get_mentors($projectId);
        $interns = $this->projectInternService->get_interns($projectId);
        $this->render('project/members', [
            'mentors' => $mentors,
            'interns' => $interns,
            'project_id' => $projectId,
        ]);
    }

    public function create(){
        $project_id = (int)($_GET['id'] ?? 0);
        $mentors = get_users(['role' => 'mentor']);
        $interns = get_users(['role' => 'intern']);
        $this->render( 'assign-member-project/create', compact('project_id', 'mentors', 'interns'));
    }

    public function edit(){
        $project_id = (int) ($_GET['project_id'] ?? 0);
        if (!$project_id) {
            wp_die('Dự án không tồn tại');
        }
        $allMentors = get_users(['role' => 'mentor']);
        $allInterns = get_users(['role' => 'intern']);
        $currentMentors = $this->projectMentorService->get_mentors($project_id);
        $currentInterns = $this->projectInternService->get_interns($project_id);
        $currentMentorIds = array_map(fn($u) => (int)$u->ID, $currentMentors);
        $currentInternIds = array_map(fn($u) => (int)$u->ID, $currentInterns);
        $this->render('assign-member-project/create', compact('project_id', 'allMentors', 'allInterns', 'currentMentorIds', 'currentInternIds'));
    }

    public function delete(){
        $project_id = (int)($_GET['project_id'] ?? 0);
        $mentor_id  = (int)($_GET['mentor_id'] ?? 0);
        $intern_id  = (int)($_GET['intern_id'] ?? 0);
        check_admin_referer('remove_project_member_action');
        if (!current_user_can('edit_intern_projects')) {
            wp_die('Bạn không có quyền');
        }
        $this->service->remove_mentor($project_id, $mentor_id);
        $this->service->remove_intern($project_id, $intern_id);
        wp_redirect(admin_url("admin.php?page=intern-project&action=edit_members&id={$project_id}"));
        exit;
    }

    public function store(){
        check_admin_referer('assign_project_members_action'); // Chỉ nếu dùng nonce
        $project_id = (int)($_POST['project_id'] ?? 0);
        $mentor_ids = $_POST['mentor_ids'] ?? [];
        $intern_ids = $_POST['intern_ids'] ?? [];
        if ($mentor_ids || $intern_ids ) :
            $this->assignMemberProjectAction->update_members($project_id, $mentor_ids, $intern_ids, get_current_user_id());
        endif;
        $this->assignMemberProjectAction->assign_members($project_id, $mentor_ids, $intern_ids, get_current_user_id());
        wp_redirect(admin_url('admin.php?page=intern-project'));
        exit;
    }

}