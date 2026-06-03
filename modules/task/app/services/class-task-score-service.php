<?php
namespace InternManagement\Modules\Task\App\Services;

use InternManagement\Includes\BaseService;
use InternManagement\Modules\Task\App\Repositories\TaskScoreRepository;

if ( ! defined( 'ABSPATH' ) ) exit;
class TaskScoreService extends BaseService{
    public function __construct(){
        parent::__construct(new TaskScoreRepository());
    }
    public function delete_task_score_by_task_id(int $task_id): bool{
        return $this->repository->delete_task_score_by_task_id($task_id);
    }
}