<?php
use InternManagement\App\Controllers\Web\UserController;
use InternManagement\App\Services\UserService;
if ( ! defined( 'ABSPATH' ) ) exit;
$service = new UserService();
$controller = new UserController($service);
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