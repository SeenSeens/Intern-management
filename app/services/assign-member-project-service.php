<?php
namespace InternManagement\App\Services;
use InternManagement\App\Repositories\AssignMemberProjectRepository;
if ( ! defined( 'ABSPATH' ) ) exit;
class AssignMemberProjectService extends BaseService {

    public function __construct() {
        parent::__construct(new AssignMemberProjectRepository());
    }
    public function update_members(int $project_id, array $mentor_ids, array $intern_ids, int $assigned_by): void{
        $this->repository->sync_mentors($project_id, $mentor_ids, $assigned_by);
        $this->repository->sync_interns($project_id, $intern_ids, $assigned_by);
    }
    public function sync_members(int $project_id, array $mentor_ids, array $intern_ids, int $assigned_by) {
        return $this->repository->sync_members($project_id, $mentor_ids, $intern_ids, $assigned_by);
    }






}