<?php
use InternManagement\App\Controllers\Web\ProjectController;
use InternManagement\App\Services\ProjectService;

if ( ! defined( 'ABSPATH' ) ) exit;
$service = new ProjectService();
$controller = new ProjectController($service);
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
    case 'view':
        $controller->view();
        break;
    default:
        $controller->index();
        break;
}


