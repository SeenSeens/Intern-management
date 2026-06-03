<?php
namespace InternManagement\Modules\Task\App\Services;

use InternManagement\Includes\BaseService;
use InternManagement\Modules\Task\App\Repositories\TaskDetailRepository;

if ( ! defined( 'ABSPATH' ) ) exit;
class TaskDetailService extends BaseService{
    public function __construct(){
        parent::__construct(new TaskDetailRepository());
    }
    public function get_task_detail_by_task_id(int $task_id ){
        return $this->repository->get_task_detail_by_task_id( $task_id );
    }
    public function delete_task_detail_by_task_id(int $task_id): bool{
        return $this->repository->delete_task_detail_by_task_id($task_id);
    }
}