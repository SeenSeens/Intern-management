<?php
namespace InternManagement\Core;
if ( ! defined( 'ABSPATH' ) ) exit;
class Role {
    private static ?Role $instance = null;
    private function __construct() {
        add_action('admin_init', [$this, 'create_custom_roles']);
        add_action('admin_init', [$this, 'assign_capabilities_to_roles']);
    }
    // Khởi tạo singleton
    public static function instance(): ?Role{
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    // Tạo role & capability
    public function create_custom_roles(): void{
        add_role(
            'project_manager',
            esc_html__('Project Manager', 'intern' ),
            ['read' => true]
        );
        add_role(
            'mentor',
            esc_html__('Mentor', 'intern' ),
            ['read' => true]
        );
        add_role(
            'intern',
            esc_html__('Intern', 'intern' ),
            ['read' => true]
        );
    }

    public function assign_capabilities_to_roles(): void {
        $roles_caps = [
            'project_manager' => [
                'create_project',
                'edit_project',
                'assign_mentor',
                'assign_intern',
                'view_all_projects',
                'view_all_reports',
                'manage_settings'
            ],
            'mentor' => [
                'view_assigned_projects',
                'assign_intern_to_project',
                'view_intern_tasks',
                'grade_tasks',
                'review_reports'
            ],
            'intern' => [
                'view_own_projects',
                'create_tasks',
                'create_task_details',
                'update_task_status',
                'submit_reports'
            ],
        ];
        foreach ( $roles_caps as $role_slug => $caps ) {
            $role = get_role( $role_slug );
            if ( $role ) {
                foreach ( $caps as $cap ) {
                    $role->add_cap( $cap );
                }
            }
        }
    }
    // Xóa role khi hủy plugin
    public static function remove_custom_roles(): void{
        $roles = [ 'project_manager', 'mentor', 'intern'];
        foreach ($roles as $role_slug) {
            remove_role($role_slug);
        }
    }
}

