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
}