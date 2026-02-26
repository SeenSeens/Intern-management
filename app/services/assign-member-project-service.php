<?php
namespace InternManagement\App\Services;
use InternManagement\App\Repositories\AssignMemberProjectRepository;
if ( ! defined( 'ABSPATH' ) ) exit;
class AssignMemberProjectService extends BaseService {

    public function __construct() {
        parent::__construct(new AssignMemberProjectRepository());
    }
    public function updateMembers(int $project_id, array $mentor_ids, array $intern_ids, int $assigned_by): void{
        $this->repository->syncMentors($project_id, $mentor_ids, $assigned_by);
        $this->repository->syncInterns($project_id, $intern_ids, $assigned_by);
    }
    public function syncMembers(int $project_id, array $mentor_ids, array $intern_ids, int $assigned_by) {
        return $this->repository->syncMembers($project_id, $mentor_ids, $intern_ids, $assigned_by);
    }






}