<?php

namespace InternManagement\Modules\Task\Includes;
use InternManagement\Modules\Task\App\Services\TaskAssigneesService;
use InternManagement\Modules\Task\App\Services\TaskDetailService;
use InternManagement\Modules\Task\App\Services\TaskScoreService;

if (!defined('ABSPATH')) exit;

class Hooks{
    public function __construct(){
        add_action('intern_before_delete_task', [$this, 'delete_task_detail']);
        add_action('intern_before_delete_task', [$this, 'delete_task_score']);
        add_action('intern_before_delete_task', [$this, 'delete_task_assignees']);
    }
    public function delete_task_detail(int $task_id): void{
        (new TaskDetailService())->delete_task_detail_by_task_id($task_id);
    }
    public function delete_task_score(int $task_id): void{
        (new TaskScoreService())->delete_task_score_by_task_id($task_id);
    }
    public function delete_task_assignees(int $task_id): void{
        (new TaskAssigneesService())->delete_task_assignees_by_task_id($task_id);
    }
}