<?php
namespace InternManagement\App\Services;
use InternManagement\App\Repositories\ProjectInternRepository;
if ( ! defined( 'ABSPATH' ) ) exit;
class ProjectInternService extends BaseService{
    public function __construct(){
        parent::__construct(new ProjectInternRepository());
    }

    public function getProjectInterns(int $project_id){
        return $this->repository->getProjectInterns($project_id);
    }

    public function assignInterns(int $project_id, array $intern_ids, int $assigned_by): void {
        foreach ($intern_ids as $intern_id) {
            $this->repository->addIntern($project_id, (int)$intern_id, $assigned_by);
        }
    }

    public function syncInterns(int $project_id, array $intern_ids, int $assigned_by) {
        return $this->repository->syncInterns($project_id, $intern_ids, $assigned_by);
    }

    public function getInterns(int $project_id) {
        return $this->repository->getInternsByProject($project_id);
    }

    public function removeIntern(int $project_id, int $intern_id): bool {
        return $this->repository->removeIntern($project_id, $intern_id);
    }
}