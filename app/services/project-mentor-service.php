<?php

namespace InternManagement\App\Services;

use InternManagement\App\Repositories\ProjectMentorRepository;
if ( ! defined( 'ABSPATH' ) ) exit;
class ProjectMentorService extends BaseService{
    public function __construct(){
        parent::__construct(new ProjectMentorRepository());
    }

    public function assignMentors(int $project_id, array $mentor_ids, int $assigned_by): void {
        foreach ($mentor_ids as $mentor_id) {
            $this->repository->addMentor($project_id, $mentor_id, $assigned_by);
        }
    }

    public function getMentors(int $project_id) {
        return $this->repository->getMentorsByProject($project_id);
    }

    public function removeMentor(int $project_id, int $mentor_id): bool {
        return $this->repository->removeMentor($project_id, $mentor_id);
    }

    public function syncMentors(int $project_id, array $mentor_ids, int $assigned_by) {
        return $this->repository->syncMentors($project_id, $mentor_ids, $assigned_by);
    }
}