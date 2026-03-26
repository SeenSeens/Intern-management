<?php
namespace InternManagement\App\Actions;

if ( ! defined( 'ABSPATH' ) ) exit;
class AssignMemberProjectAction extends BaseAction {

    public function assign_members(int $project_id, array $mentor_ids, array $intern_ids, int $assigned_by){
        $this->service->sync_members($project_id, $mentor_ids, $intern_ids, $assigned_by);
    }

    public function update_members($project_id, array $mentor_ids, array $intern_ids, $assigned_by){
        $this->service->sync_members($project_id, $mentor_ids, $intern_ids, $assigned_by);
    }


    protected function map_input(): array{
        // TODO: Implement map_input() method.
    }
}