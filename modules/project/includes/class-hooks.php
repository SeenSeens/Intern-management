<?php
namespace InternManagement\Modules\Project\Includes;
use InternManagement\Modules\Task\App\Services\TaskService;

if (!defined('ABSPATH')) exit;
class Hooks{
    public function __construct(){
        add_action('intern_before_delete_project', [$this, 'handle_project_delete']);
    }
    // Xóa mentor
    // Xóa intern
    // Xóa task theo id project
    public function handle_project_delete(int $project_id): void {
        (new TaskService())->delete_by_project($project_id);
    }
    // Xóa task detail theo task id
    // Xóa task score theo task id
}