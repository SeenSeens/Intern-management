<?php
namespace InternManagement\App\Controllers\Web;
use InternManagement\App\Actions\ProjectMentorAction;
use InternManagement\App\Services\ProjectMentorService;
use InternManagement\Core\Controller;
if ( ! defined( 'ABSPATH' ) ) exit;
class ProjectMentorController extends Controller{

    private ProjectMentorAction $projectMentorAction;
    public function __construct(){
        parent::__construct(new ProjectMentorService());
        $this->projectMentorAction = new ProjectMentorAction();
    }

    public function index(){

    }

    public function create(){

    }

    public function edit(){

    }

    public function delete(){

    }

    public function store(){
        check_admin_referer('project_mentor_action'); // Chỉ nếu dùng nonce
        $project_id = (int)($_POST['project_id'] ?? 0);
        $mentor_ids = $_POST['mentor_ids'] ?? [];
        if ($mentor_ids  ) :
            $this->projectMentorAction->updateMentor($project_id, $mentor_ids, get_current_user_id());
        endif;
        $this->projectMentorAction->assignMentor($project_id, $mentor_ids, get_current_user_id());
        wp_redirect(admin_url('admin.php?page=intern-project&action=view&project_id='.$project_id));
        exit;
    }
}