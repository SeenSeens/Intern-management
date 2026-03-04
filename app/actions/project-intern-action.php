<?php
namespace InternManagement\App\Actions;

if ( ! defined( 'ABSPATH' ) ) exit;
class ProjectInternAction extends BaseAction{

    public function assignIntern( int $project_id, array $intern_ids, int $assigned_by){
        return $this->service->assignInterns($project_id, $intern_ids, $assigned_by);
    }

    public function updateIntern(int  $project_id, array $intern_ids, int $assigned_by){
        return$this->service->syncInterns($project_id, $intern_ids, $assigned_by);
    }

    protected function map_input(): array
    {
        // TODO: Implement map_input() method.
    }
}