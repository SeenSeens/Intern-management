<?php
use InternManagement\App\Controllers\Web\TaskController;
use InternManagement\App\Services\TaskService;
if ( ! defined( 'ABSPATH' ) ) exit;
$service = new TaskService();
$controller = new TaskController($service);
$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'new':
        $controller->create();
        break;
    case 'edit':
        $controller->edit();
        break;
    case 'delete':
        $controller->delete();
        break;
    case 'assigned':
        $controller->taskAssignees();
        break;
    case 'view':
        $controller->view();
        break;
    case 'new-subtask':
        $controller->newSubtask();
        break;
    default:
        $controller->index();
        break;
}