<?php
namespace InternManagement\App\Actions;
use InternManagement\App\Services\TaskAssigneesService;
if ( ! defined( 'ABSPATH' ) ) exit;
class TaskAssignessAction extends BaseAction {

    public function __construct($service = null){
        parent::__construct(new TaskAssigneesService());
    }

    protected function map_input(): array
    {
        // TODO: Implement map_input() method.
    }
}
