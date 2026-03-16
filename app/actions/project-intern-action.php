<?php
namespace InternManagement\App\Actions;

if ( ! defined( 'ABSPATH' ) ) exit;
class ProjectInternAction extends BaseAction{

    public function assign_intern( int $project_id, array $intern_ids, int $assigned_by){
        return $this->service->assign_interns($project_id, $intern_ids, $assigned_by);
    }

    public function update_intern(int  $project_id, array $intern_ids, int $assigned_by){
        return$this->service->sync_interns($project_id, $intern_ids, $assigned_by);
    }

    protected function map_input(): array{
        // TODO: Implement map_input() method.
    }
}