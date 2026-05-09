<?php
namespace InternManagement\Modules\Project\App\Services;
use InternManagement\Includes\BaseService;
use InternManagement\Modules\Project\App\Repositories\ProjectInternRepository;

if ( ! defined( 'ABSPATH' ) ) exit;
class ProjectInternService extends BaseService{
    public function __construct(){
        parent::__construct(new ProjectInternRepository());
    }
    public function get_intern_project(int $project_id){
        return $this->repository->get_intern_project($project_id);
    }

    public function sync_project_interns(int $project_id, array $intern_ids, int $assigned_by) {
        return $this->repository->sync_project_interns($project_id, $intern_ids, $assigned_by);
    }

    public function get_list_projects_intern_assigned(int $user_id){
        return $this->repository->get_list_projects_intern_assigned($user_id);
    }
    public function statistics(int $uer_id){
        return $this->repository->statistics($uer_id);
    }
}