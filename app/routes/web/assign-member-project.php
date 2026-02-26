<?php
use InternManagement\App\Controllers\Web\AssignMemberProjectController;
use InternManagement\App\Services\ProjectService;

if ( ! defined( 'ABSPATH' ) ) exit;
$service = new ProjectService();
$controller = new AssignMemberProjectController($service);
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
    default:
        $controller->index();
        break;
}