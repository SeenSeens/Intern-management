<?php
namespace InternManagement\App\Services;
use DateTime;
use InternManagement\App\Repositories\TaskRepository;
if ( ! defined( 'ABSPATH' ) ) exit;
class TaskService extends BaseService {
    public function __construct(){
        parent::__construct(new TaskRepository());
    }

    public function allTasks(){
        return $this->repository->allTasks();
    }

    public function getTasksByProject(int $project_id){
        return $this->repository->getTasksByProject($project_id);
    }

    public function getProjectIdByTaskId(int $task_id){
        return $this->repository->getProjectIdByTaskId($task_id);
    }

    public function countTask(){
        return $this->repository->countTask();
    }

    /*public function tasksAreDueSoon( DateTime $days_ahead ){
        return $this->repository->tasksAreDueSoon( $days_ahead );
    }*/
}