<?php
namespace InternManagement\App\Actions;

if ( ! defined( 'ABSPATH' ) ) exit;
class ProjectMentorAction extends BaseAction{

    public function assign_mentor(int $project_id, array $mentor_ids, int $assigned_by){
        return $this->service->assign_mentors($project_id, $mentor_ids, $assigned_by);
    }

    public function update_mentor(int $project_id, array $mentor_ids, int $assigned_by){
        return $this->service->sync_mentors($project_id, $mentor_ids, $assigned_by);
    }

    protected function map_input(): array{
        // TODO: Implement map_input() method.
    }
}