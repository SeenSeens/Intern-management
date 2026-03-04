<?php
namespace InternManagement\App\Actions;

if ( ! defined( 'ABSPATH' ) ) exit;
class ProjectMentorAction extends BaseAction{

    public function assignMentor(int $project_id, array $mentor_ids, int $assigned_by){
        return $this->service->assignMentors($project_id, $mentor_ids, $assigned_by);
    }

    public function updateMentor(int $project_id, array $mentor_ids, int $assigned_by){
        return $this->service->syncMentors($project_id, $mentor_ids, $assigned_by);
    }

    protected function map_input(): array
    {
        // TODO: Implement map_input() method.
    }
}