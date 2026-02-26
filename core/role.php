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
            'hr',
            esc_html__('Human Resources', 'intern' ),
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
            'intern' => [
                'submit_log',
                'view_own_progress',
                'download_training_docs',
                'view_assigned_projects'
            ],
            'mentor' => [
                'view_assigned_interns',
                'evaluate_interns',
                'comment_on_progress',
                'edit_intern_projects',
                'manage_intern_plugin',
                'view_assigned_projects',
            ],
            'hr' => [
                'read_intern',
                'edit_intern',
                'delete_intern',
                'evaluate_interns',
                'edit_others_interns',
                'view_all_interns',
                'assign_mentor',
                'export_interns',
                'manage_intern_plugin'
            ],
            'project_manager' => [
                'read_intern',
                'edit_intern',
                'delete_intern',
                'publish_interns',
                'read_private_interns',
                'evaluate_interns',
                'view_assigned_interns',
                'manage_intern_settings',
                'edit_others_intern',
                'view_all_interns',
                'edit_intern_projects',
                'assign_mentor',
                'review_progress_reports',
                'comment_on_progress',
                'export_interns',
                'view_assigned_projects'
            ],
            'administrator' => [
                'manage_intern_settings',
                'edit_intern_projects'
            ]
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
        $roles = [ 'project_manager', 'hr', 'mentor', 'intern'];
        foreach ($roles as $role_slug) {
            remove_role($role_slug);
        }
    }
}

