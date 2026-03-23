<?php

namespace InternManagement\App\Services;

use InternManagement\App\Repositories\ProjectMentorRepository;
if ( ! defined( 'ABSPATH' ) ) exit;
class ProjectMentorService extends BaseService{
    public function __construct(){
        parent::__construct(new ProjectMentorRepository());
    }
    public function get_mentor_project(int $project_id){
        return $this->repository->get_mentor_project($project_id);
    }
    public function assign_mentors(int $project_id, array $mentor_ids, int $assigned_by): void {
        foreach ($mentor_ids as $mentor_id) {
            $this->repository->add_mentor($project_id, $mentor_id, $assigned_by);
        }
    }

    public function remove_mentor(int $project_id, int $mentor_id): bool {
        return $this->repository->remove_mentor($project_id, $mentor_id);
    }

    public function sync_mentors(int $project_id, array $mentor_ids, int $assigned_by) {
        return $this->repository->sync_mentors($project_id, $mentor_ids, $assigned_by);
    }
}