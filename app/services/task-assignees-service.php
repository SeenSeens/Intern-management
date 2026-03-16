<?php
namespace InternManagement\App\Services;
use InternManagement\App\Repositories\TaskAssigneesRepository;
if ( ! defined( 'ABSPATH' ) ) exit;
class TaskAssigneesService extends BaseService {
    public function __construct(){
        parent::__construct(new TaskAssigneesRepository());
    }

    public function get_intern_assign_by_task_id(int $task_id) {
        return $this->repository->get_intern_assign_by_task_id($task_id);
    }
}