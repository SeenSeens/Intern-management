<?php
namespace InternManagement\App\Services;
use InternManagement\App\Repositories\TaskAssigneesRepository;
if ( ! defined( 'ABSPATH' ) ) exit;
class TaskAssigneesService extends BaseService {
    public function __construct(){
        parent::__construct(new TaskAssigneesRepository());
    }

    public function getInternAssignByTaskId(int $task_id) {
        return $this->repository->getInternAssignByTaskId($task_id);
    }
}