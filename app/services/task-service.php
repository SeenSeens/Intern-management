<?php
namespace InternManagement\App\Services;
use DateTime;
use InternManagement\App\Repositories\TaskRepository;
if ( ! defined( 'ABSPATH' ) ) exit;
class TaskService extends BaseService {
    public function __construct(){
        parent::__construct(new TaskRepository());
    }

    public function get_all_tasks(){
        return $this->repository->get_all_tasks();
    }

    public function get_tasks_by_project(int $project_id){
        return $this->repository->get_tasks_by_project($project_id);
    }

    public function get_project_id_by_task_id(int $task_id){
        return $this->repository->get_project_id_by_task_id($task_id);
    }

    public function count_task(){
        return $this->repository->count_task();
    }

    public function statistics(){
        return $this->repository->statistics();
    }
}