<?php
namespace InternManagement\App\Actions;

if ( ! defined( 'ABSPATH' ) ) exit;
class AssignMemberProjectAction extends BaseAction {

    public function assignMembers(int $project_id, array $mentor_ids, array $intern_ids, int $assigned_by){
        $this->service->syncMembers($project_id, $mentor_ids, $intern_ids, $assigned_by);
    }

    public function updateMembers($project_id, array $mentor_ids, array $intern_ids, $assigned_by){
        $this->service->syncMembers($project_id, $mentor_ids, $intern_ids, $assigned_by);
    }


    protected function map_input(): array
    {
        // TODO: Implement map_input() method.
    }
}