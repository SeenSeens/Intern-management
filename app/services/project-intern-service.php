<?php
namespace InternManagement\App\Services;
use InternManagement\App\Repositories\ProjectInternRepository;
if ( ! defined( 'ABSPATH' ) ) exit;
class ProjectInternService extends BaseService{
    public function __construct(){
        parent::__construct(new ProjectInternRepository());
    }
    public function get_intern_project(int $project_id){
        return $this->repository->get_intern_project($project_id);
    }
    public function get_project_interns(int $project_id){
        return $this->repository->get_project_interns($project_id);
    }

    public function assign_interns(int $project_id, array $intern_ids, int $assigned_by): void {
        foreach ($intern_ids as $intern_id) {
            $this->repository->add_intern($project_id, (int)$intern_id, $assigned_by);
        }
    }

    public function sync_interns(int $project_id, array $intern_ids, int $assigned_by) {
        return $this->repository->syncInterns($project_id, $intern_ids, $assigned_by);
    }

    public function get_interns(int $project_id) {
        return $this->repository->get_interns_by_project($project_id);
    }

    public function remove_intern(int $project_id, int $intern_id): bool {
        return $this->repository->remove_intern($project_id, $intern_id);
    }
}