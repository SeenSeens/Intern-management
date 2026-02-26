<?php
namespace InternManagement\App\Controllers\Web;
use InternManagement\App\Actions\ProjectInternAction;
use InternManagement\App\Services\ProjectInternService;
use InternManagement\Core\Controller;
if ( ! defined( 'ABSPATH' ) ) exit;
class ProjectInternController extends Controller {

    private $projectInternAction;
    public function __construct(){
        parent::__construct(new ProjectInternService());
        $this->projectInternAction = new ProjectInternAction();
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
        check_admin_referer('project_intern_action'); // Chỉ nếu dùng nonce
        $project_id = (int)($_POST['project_id'] ?? 0);
        $intern_ids = $_POST['intern_ids'] ?? [];
        if ($intern_ids  ) :
            $this->projectInternAction->updateIntern($project_id, $intern_ids, get_current_user_id());
        endif;
        $this->projectInternAction->assignIntern($project_id, $intern_ids, get_current_user_id());
        wp_redirect(admin_url('admin.php?page=intern-project&action=view&project_id='.$project_id));
        exit;
    }
}