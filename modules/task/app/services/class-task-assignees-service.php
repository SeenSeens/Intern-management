<?php
namespace InternManagement\Modules\Task\App\Services;
use InternManagement\Includes\BaseService;
use InternManagement\Modules\Task\App\Repositories\TaskAssigneesRepository;

if ( ! defined( 'ABSPATH' ) ) exit;
class TaskAssigneesService extends BaseService {
    public function __construct(){
        parent::__construct(new TaskAssigneesRepository());
    }

    public function get_intern_assign_by_task_id(int $task_id) {
        return $this->repository->get_intern_assign_by_task_id($task_id);
    }

    public function delete_task_assignees_by_task_id(int $task_id) {
        return $this->repository->delete_task_assignees_by_task_id($task_id);
    }
}