<?php

use InternManagement\App\Controllers\Web\DashboardController;


if ( ! defined( 'ABSPATH' ) ) exit;

$controller = new DashboardController();
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


