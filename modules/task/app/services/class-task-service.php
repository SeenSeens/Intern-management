<?php
namespace InternManagement\Modules\Task\App\Services;
use InternManagement\Includes\BaseService;
use InternManagement\Modules\Task\App\Repositories\TaskRepository;

if ( ! defined( 'ABSPATH' ) ) exit;
class TaskService extends BaseService {
    public function __construct(){
        parent::__construct(new TaskRepository());
    }
    public function get_all_tasks(){
        return $this->repository->get_all_tasks();
    }
    public function get_all_tasks_intern(int $user_id){
        return $this->repository->get_all_tasks_intern($user_id);
    }
    public function statistics(){
        return $this->repository->statistics();
    }
    public function overall_progress($project_id){
        return $this->repository->overall_progress($project_id);
    }
    public function upcoming_tasks($days){
        return $this->repository->upcoming_tasks($days);
    }
    public function get_tasks_from_project($project_id){
        return $this->repository->get_tasks_from_project($project_id);
    }
    // Xóa task theo id project
    public function delete_by_project(int $project_id): bool{
        return $this->repository->delete_by_project($project_id);
    }
    public function get_task(int $id){
        return $this->repository->get_task($id);
    }
}