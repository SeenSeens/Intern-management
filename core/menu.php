<?php
namespace InternManagement\Core;
if ( ! defined( 'ABSPATH' ) ) exit;

class Menu {

    public function __construct(){
        add_action( 'admin_menu', [$this, 'intern_add_menu_page']);
    }

    public function intern_add_menu_page(): void{

        // Menu chính
        add_menu_page(
            __('Intern Management', 'tbay_intern'), // page_title
            __('Intern Management', 'tbay_intern'), // menu_title
            'manage_options',
            'tbay-intern',
            [ $this, 'intern_management_page' ],
            'dashicons-welcome-learn-more',
            45
        );
        // Dashboard (chỉ PM, HR, Admin)
        if ( current_user_can('manage_intern_settings') ) :
            add_submenu_page(
                'tbay-intern',
                __('Dashboard', 'tbay_intern'),
                __('Dashboard', 'tbay_intern'),
                'manage_intern_settings',
                'intern-dashboard',
                [ $this, 'intern_dashboard_routes' ],
            );
        endif;
        /**
         * HR sẽ thấy tất cả sinh viên
         * PM, Mentor sẽ thấy sinh viên thuộc dự án
         */
        if ( current_user_can('view_all_interns') ) :
            add_submenu_page(
                'tbay-intern',
                __('List of students', 'tbay_intern'),
                __('Student', 'tbay_intern'),
                'view_all_interns',
                'intern-student',
                [ $this, 'intern_students_routes' ],
            );
        endif;

        /**
         * PM thấy toàn bộ các dự án
         * Mentor thấy dự án do mình phụ trách
         */
        if ( current_user_can('manage_intern_settings') ) :
            add_submenu_page(
                'tbay-intern',
                __('Project List', 'tbay_intern'),
                __('Project', 'tbay_intern'),
                'manage_intern_settings',
                'intern-project',
                [ $this, 'intern_projects_routes' ],
            );
        endif;

        if ( current_user_can('edit_intern_projects') ) :
            add_submenu_page(
                'tbay-intern',
                __('Thành viên dự án', 'tbay_intern'),
                __('Thành viên dự án', 'tbay_intern'),
                'edit_intern_projects',
                'intern-project-user',
                [ $this, 'intern_assign_member_project_routes' ],
            );
        endif;
        /**
         * Intern sẽ thấy nhiệm vụ của mình
         */
        if ( current_user_can('view_own_progress') ) :
            add_submenu_page(
                'tbay-intern',
                __('Danh sách sinh viên', 'tbay_intern'),
                __('Nhiệm vụ', 'tbay_intern'),
                'view_own_progress',
                'intern-task',
                [ $this, 'intern_tasks_routes' ],
            );
        endif;

    }

    public function intern_management_page(): void{
        require_once plugin_dir_path( INTERN_MANAGEMENT_MAIN_FILE ) . 'app/template-part/about.php';
    }

    public function intern_students_routes(): void{
        require_once plugin_dir_path( INTERN_MANAGEMENT_MAIN_FILE ) . 'app/routes/web/student.php';
    }

    public function intern_projects_routes(): void{
        require_once plugin_dir_path( INTERN_MANAGEMENT_MAIN_FILE ) . '/app/routes/web/project.php';
    }
    public function intern_assign_member_project_routes(): void{
        require_once plugin_dir_path( INTERN_MANAGEMENT_MAIN_FILE ) . '/app/routes/web/assign-member-project.php';
    }
    public function intern_tasks_routes(): void{
        require_once plugin_dir_path( INTERN_MANAGEMENT_MAIN_FILE ) . '/app/routes/web/task.php';
    }
    public function intern_dashboard_routes(): void{
        //require_once plugin_dir_path( INTERN_MANAGEMENT_MAIN_FILE ) . 'app/template-part/dashboard.php';
        require_once plugin_dir_path( INTERN_MANAGEMENT_MAIN_FILE ) . 'app/routes/web/dashboard.php';
    }
}