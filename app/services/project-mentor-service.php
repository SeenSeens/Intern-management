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

    public function sync_project_mentors(int $project_id, array $mentor_ids, int $assigned_by) {
        return $this->repository->sync_project_mentors($project_id, $mentor_ids, $assigned_by);
    }
}