<?php
namespace InternManagement\Modules\Task\App\Actions;
use InternManagement\App\Actions\BaseAction;
use InternManagement\Modules\Task\App\Services\TaskAssigneesService;

if ( ! defined( 'ABSPATH' ) ) exit;
class TaskAssignessAction extends BaseAction {


    protected function map_input(): array{
        return [
            'id' => (int)$this->get('id'),
            'task_id' => (int)$this->get('task_id'),
            'title' => $this->get('title'),
            'description' => $this->get('description'),
            'status' => $this->get('status'),
            'created_by' => $this->get('created_by'),
        ];
    }
}
