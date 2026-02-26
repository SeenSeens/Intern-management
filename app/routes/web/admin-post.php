<?php
use InternManagement\App\Controllers\Web\AssignMemberProjectController;
use InternManagement\App\Controllers\Web\ProjectController;
use InternManagement\App\Controllers\Web\ProjectInternController;
use InternManagement\App\Controllers\Web\ProjectMentorController;
use InternManagement\App\Controllers\Web\TaskController;
use InternManagement\App\Services\AssignMemberProjectService;
use InternManagement\App\Services\ProjectInternService;
use InternManagement\App\Services\ProjectMentorService;
use InternManagement\App\Services\ProjectService;
use InternManagement\App\Services\TaskService;

if ( ! defined( 'ABSPATH' ) ) exit;

// Thêm mới & cập nhật dự án
add_action('admin_post_save_project', function () {
    $projectService = new ProjectService();
    $projectController = new ProjectController($projectService);
    $projectController->store();
});

// Xóa dự án
add_action('admin_post_delete_project', function () {
    $projectService = new ProjectService();
    $projectController = new ProjectController($projectService);
    $projectController->delete();
});

// Thêm member vào dự án
add_action('admin_post_assign_project_members', function () {
    $assignMemberProjectService = new AssignMemberProjectService();
    $assignMemberProjectController = new AssignMemberProjectController($assignMemberProjectService);
    $assignMemberProjectController->store();
});

// Cập nhật member trong dự án
add_action('admin_post_update_project_members', function () {
    $assignMemberProjectService = new AssignMemberProjectService();
    $assignMemberProjectController = new AssignMemberProjectController($assignMemberProjectService);
    $assignMemberProjectController->store();
});

// Xóa member trong dự án
add_action('admin_post_delete_project_members', function () {
    $assignMemberProjectService = new AssignMemberProjectService();
    $assignMemberProjectController = new AssignMemberProjectController($assignMemberProjectService);
    $assignMemberProjectController->delete();
});

// Thêm task
add_action('admin_post_save_task', function () {
    $taskService = new TaskService();
    $taskController = new TaskController($taskService);
    $taskController->store();
});

// Thêm intern vào task
add_action('admin_post_assign_task', function () {
    $taskService = new TaskService();
    $taskController = new TaskController($taskService);
    $taskController->taskAssignees();
});

// Thêm mentor vào dự án
add_action('admin_post_project_mentor', function (){
    $projectMentorService = new ProjectMentorService();
    $projectMentorController = new ProjectMentorController($projectMentorService);
    $projectMentorController->store();
});

// Thêm intern vào dự án
add_action('admin_post_project_intern', function (){
    $projectInternService = new ProjectInternService();
    $projectInternController = new ProjectInternController($projectInternService);
    $projectInternController->store();
});